CREATE OR REPLACE FUNCTION cfunc_in_array(val varchar, arr varchar[]) RETURNS boolean AS
$BODY$
DECLARE 
    ret boolean;
BEGIN
    RETURN val = any(arr);
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION cfunc_in_array(varchar, varchar[]) IS 'checks if val in arr';

CREATE OR REPLACE FUNCTION cfunc_within_bounds(val varchar, arr varchar[]) RETURNS boolean AS
$BODY$
BEGIN
    RETURN arr[1]::numeric <= val::numeric AND val::numeric <= arr[2]::numeric;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION cfunc_within_bounds(varchar, varchar[]) IS 'checks if arr[1] < val < arr[2]';

CREATE OR REPLACE FUNCTION cfunc_default_only(val varchar, arr varchar[]) RETURNS boolean AS
$BODY$
BEGIN
    RETURN false;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION cfunc_default_only(varchar, varchar[]) IS 'always returns false, so default value cannot be changed';

CREATE OR REPLACE FUNCTION check_parameters(_programname varchar, _parameters varchar[][]) RETURNS boolean
AS 
$BODY$
DECLARE 
    _param varchar[];
    _param_constraints allowed_parameters%ROWTYPE;
    _retval boolean;
BEGIN
    IF _parameters IS NULL THEN
        RETURN TRUE;
    END IF;
    FOREACH _param SLICE 1 IN ARRAY _parameters
    LOOP
        SELECT * INTO _param_constraints FROM allowed_parameters WHERE programname=_programname AND param_name=_param[1];
        IF _param_constraints IS NULL THEN
            RAISE EXCEPTION 'Parameter % is not defined for Programname %', _param[1], _programname;
            RETURN FALSE;
        END IF;
        EXECUTE 'SELECT ' || _param_constraints.constraint_function || '($1, $2)' 
            INTO _retval USING _param[2], _param_constraints.constraint_function_parameters;
        IF _retval = FALSE THEN
            RAISE EXCEPTION 'Invalid argument for Parameter %: %', _param[1], _param[2];
            RETURN FALSE;
        END IF;
    END LOOP;
    RETURN TRUE;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION check_parameters(varchar, varchar[][]) IS 
'checks if all given parameters match the rules in the allowed_parameters table';

CREATE OR REPLACE FUNCTION get_job_parameters(_job_id int)  RETURNS varchar
AS
$BODY$
DECLARE
    _ret varchar;
    _row RECORD;
BEGIN
    _ret := '';
    FOR _row IN SELECT param_name, param_value FROM job_parameters WHERE job_id=_job_id LOOP
        _ret := _ret || ' -' || _row.param_name || ' ' || _row.param_value;
    END LOOP;
    RETURN _ret;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION get_job_parameters(int) IS 
'assembles the jobs parameters to those resembling a command line call, e.g. "-a valuea -b valueb"';


CREATE OR REPLACE FUNCTION request_job(_max_jobs_running int,  _worker_identifier varchar, _handled_programs varchar[]) 
RETURNS TABLE(running_query_id int, programname varchar, parameters varchar, query text, max_lifetime int, target_db varchar, target_db_md5 varchar, target_db_download_uri varchar)
AS
$BODY$
DECLARE 
    _jobs_available integer;
    _jobs_running integer;
    _job_query_id int;
    _job_id int;
    _programname varchar;
    _parameters varchar;
    _query text;
    _running_query_id integer;
    _target_db varchar;
    _target_db_md5 varchar;
    _target_db_download_uri varchar;    
BEGIN
    LOCK TABLE jobs;
    LOCK TABLE job_queries;
    LOCK TABLE running_queries;

    EXECUTE reset_timed_out_queries();
    
    --check for job availability
    SELECT COUNT(*) INTO _jobs_available FROM job_queries JOIN jobs ON (job_queries.job_id=jobs.job_id) WHERE job_queries.status='NOT_PROCESSED' AND jobs.programname = any(_handled_programs);
    IF _jobs_available = 0 THEN
        RAISE NOTICE 'no jobs available';
        RETURN;
    END IF;
    IF _max_jobs_running <> -1 THEN --check if this worker can start another job
        IF _worker_identifier IS NULL THEN
            RAISE NOTICE 'no worker identifier given, using ip address';
            _worker_identifier = inet_client_addr()::varchar;
        END IF;
        SELECT COUNT(*) INTO _jobs_running FROM running_queries WHERE processing_host_identifier = _worker_identifier;
        RAISE NOTICE '% jobs are currently running for %', _jobs_running, _worker_identifier;
        IF _jobs_running >= _max_jobs_running THEN
            RAISE NOTICE 'already at full capacity, exiting';
            RETURN;
        END IF;
    END IF;
    --assign a job
    SELECT jq.job_query_id, j.job_id,  j.programname, jq.query, j.target_db
    INTO _job_query_id, _job_id, _programname, _query, _target_db
    FROM job_queries jq JOIN jobs j ON (jq.job_id=j.job_id) 
    WHERE jq.status='NOT_PROCESSED' AND j.programname = any(_handled_programs)
    ORDER BY jq.job_query_id ASC
    LIMIT 1;

    SELECT INTO _parameters get_job_parameters(_job_id);
    SELECT md5, download_uri FROM database_files WHERE name=_target_db INTO _target_db_md5, _target_db_download_uri;

    UPDATE job_queries SET status='STARTING', processing_start_time=NOW() WHERE job_queries.job_query_id=_job_query_id;
    INSERT INTO running_queries (job_query_id, processing_host_identifier) VALUES (_job_query_id, _worker_identifier)  RETURNING running_queries.running_query_id INTO _running_query_id;
    RETURN QUERY SELECT _running_query_id, _programname, _parameters, _query, get_option('MAXIMUM_EXECUTION_TIME')::integer, _target_db, _target_db_md5, _target_db_download_uri ;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION request_job(int,  varchar, varchar[])  IS 
'if the number of running jobs for the given hostname (or IP of the connection, if null given) 
and there is a job waiting in the queue for one of the given handled programs,
assign this job to the given hostname and return a row describing the job.
otherwise, returns zero rows.
';

CREATE OR REPLACE FUNCTION report_job_pid(_running_query_id int,  _pid int) RETURNS VOID
AS 
$BODY$
DECLARE
    _job_query_id integer;
BEGIN
    LOCK TABLE jobs;
    LOCK TABLE job_queries;
    LOCK TABLE running_queries;


    SELECT INTO _job_query_id job_query_id FROM running_queries WHERE running_query_id=_running_query_id;
    IF FOUND THEN
        UPDATE job_queries     SET status='PROCESSING' WHERE  job_query_id=_job_query_id;
        UPDATE running_queries SET pid=_pid            WHERE  job_query_id=_job_query_id;
        UPDATE jobs            SET status='PROCESSING' WHERE status='NOT_PROCESSED' and job_id=(SELECT job_id FROM job_queries WHERE job_query_id=_job_query_id);
    END IF;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION report_job_pid(int, int) IS
'set\s the job status to "PROCESSING" (is "STARTED" when request_job is called, but report_job_pid has not been called yet) and saves the pid to the DB';

CREATE OR REPLACE FUNCTION report_job_result(_running_query_id int,  _return_code integer, _stdout text, _stderr text) RETURNS VOID
AS 
$BODY$
DECLARE
    _job_id int;
    _job_query_id integer;
BEGIN
    SELECT INTO _job_query_id job_query_id FROM running_queries WHERE running_query_id=_running_query_id;
    IF NOT FOUND THEN
        RETURN;
    END IF;

    UPDATE job_queries SET 
        status = CASE WHEN _return_code = 0 THEN 'PROCESSED'::job_status ELSE 'ERROR'::job_status END,
        return_value = _return_code, 
        stdout = _stdout, 
        stderr = _stderr 
    WHERE job_query_id=_job_query_id RETURNING job_id INTO _job_id;
    DELETE FROM running_queries WHERE job_query_id=_job_query_id;
    -- set job to finished
    UPDATE jobs SET status='PROCESSED' WHERE job_id=_job_id 
        AND NOT EXISTS (SELECT 1 FROM job_queries WHERE job_id=_job_id AND NOT status='PROCESSED');
    IF NOT FOUND THEN
        UPDATE jobs SET status='PROCESSED_WITH_ERRORS' WHERE job_id=_job_id 
            AND NOT EXISTS (SELECT 1 FROM job_queries WHERE job_id=_job_id AND NOT (status='PROCESSED' OR status='ERROR'));
    END IF;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION report_job_result(int, int, text, text) IS
'sets job final status "PROCESSED" or "ERROR", depending on return code. saves stdout and stderr and removes job from the running_queries table';

CREATE OR REPLACE FUNCTION create_job(_programname varchar,  _target_db varchar, _additional_data text, _parameters varchar[][], _queries text[]) 
RETURNS varchar
AS 
$BODY$
DECLARE 
    _md5 varchar;
    _uid varchar;
    _job_id integer;
    _param varchar[];
    _query text;
    _default_parameter allowed_parameters%ROWTYPE;
BEGIN
    IF NOT EXISTS (SELECT 1 FROM programs WHERE name=_programname) THEN
        RAISE EXCEPTION 'program unknown: %', _programname;
        RETURN NULL;
    END IF;

    IF NOT check_parameters(_programname, _parameters) THEN
        RETURN NULL;
    END IF;

    IF _queries IS NULL THEN
        RAISE EXCEPTION 'query is NULL';
        RETURN NULL;
    END IF;    


    -- sort and remove duplicates
    SELECT ARRAY(SELECT DISTINCT UNNEST(_queries) a ORDER BY a) INTO _queries;
    
    _md5 := md5((_programname, _target_db, _additional_data, _parameters::text, _queries::text)::text);

    LOCK TABLE jobs;
    LOCK TABLE job_queries;
    
    SELECT uid FROM jobs WHERE md5 = _md5 INTO _uid;
    IF _uid IS NOT NULL THEN
        --TODO complete check
        RETURN _uid;
    END IF;
    
    LOOP --generate a random 32-bit-uid until it is unique
        _uid = to_hex((random()*power(2,32))::bigint);
        EXIT WHEN NOT EXISTS (SELECT 1 FROM jobs WHERE uid=_uid);
    END LOOP;

    --insert job
    INSERT INTO jobs ( programname,  target_db,  additional_data,  md5,  uid) 
        VALUES   (_programname, _target_db, _additional_data, _md5, _uid)
    RETURNING job_id INTO _job_id;
    RAISE NOTICE 'inserted job id %', _job_id;

    --insert default parameters
    FOR _default_parameter IN SELECT * FROM allowed_parameters WHERE programname=_programname AND default_value IS NOT NULL LOOP
        INSERT INTO job_parameters ( job_id,  param_name,  param_value) 
        VALUES   (_job_id, _default_parameter.param_name, _default_parameter.default_value);
    END LOOP;
    
    --override custom parameters
    IF _parameters IS NOT NULL THEN
        FOREACH _param SLICE 1 IN ARRAY _parameters LOOP
            IF EXISTS (SELECT 1 FROM job_parameters WHERE job_id = _job_id AND param_name = _param[1]) THEN
                UPDATE job_parameters SET param_value = _param[2]
                WHERE job_id = _job_id AND param_name = _param[1];
            ELSE
                INSERT INTO job_parameters ( job_id,  param_name,  param_value) 
                VALUES   (_job_id, _param[1], _param[2]);
            END IF;
        END LOOP;
    END IF;

    --insert queries
    FOREACH _query IN ARRAY _queries LOOP
        INSERT INTO job_queries ( job_id,  query) 
        VALUES   (_job_id, _query);
    END LOOP;

    --done
    RETURN _uid;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION create_job(varchar,  varchar, text, varchar[][], text[]) IS
'if an identical query has already been issued, returns that queries uid. if this is a new query, it will be added to the respective tables.';

CREATE OR REPLACE FUNCTION get_job_results(_job_uid varchar)
RETURNS TABLE(status job_status, additional_data text, query text, query_status job_status, query_stdout text, query_stderr text)
AS 
$BODY$
BEGIN
    RETURN QUERY SELECT jobs.status, jobs.additional_data, jq.query, jq.status, jq.stdout, jq.stderr
        FROM jobs LEFT JOIN job_queries jq ON (jobs.job_id = jq.job_id) WHERE jobs.uid = _job_uid;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION  get_job_results(varchar) IS 
'returns job details for the given job';

CREATE OR REPLACE FUNCTION get_queue_position(_job_uid varchar)
RETURNS TABLE(queue_position bigint, queue_length bigint)
AS 
$BODY$
BEGIN
    RETURN QUERY SELECT stats.queue_position, cnt.queue_length
        FROM jobs 
        LEFT JOIN (
            SELECT job_id, row_number() OVER (PARTITION BY status ORDER BY queueing_time ASC) AS queue_position
            FROM jobs WHERE status='NOT_PROCESSED'
        ) AS stats ON (jobs.job_id = stats.job_id),
        (SELECT COUNT(*) AS queue_length FROM jobs WHERE status='NOT_PROCESSED') cnt
        WHERE jobs.uid=_job_uid;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION  get_queue_position(varchar) IS 
'returns job queue position';

CREATE OR REPLACE FUNCTION get_option(_optionname varchar)
RETURNS varchar
AS 
$BODY$
DECLARE
    _value varchar;
BEGIN
        SELECT value FROM options WHERE key=_optionname INTO _value;
    RETURN _value; 
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION  get_option(varchar) IS 
'gets configuration value';

CREATE OR REPLACE FUNCTION reset_timed_out_queries()
RETURNS void
AS 
$BODY$
DECLARE
    _job_query_id integer;
BEGIN
    FOR _job_query_id IN SELECT job_query_id FROM job_queries WHERE (status='PROCESSING' OR STATUS='STARTING') AND (processing_start_time + get_option('MAXIMUM_EXECUTION_TIME')::integer * interval '1 second')<NOW()  LOOP
        UPDATE job_queries SET status='NOT_PROCESSED', processing_start_time=NULL WHERE job_query_id=_job_query_id;
                DELETE FROM running_queries WHERE job_query_id=_job_query_id;
    END LOOP;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION  get_option(varchar) IS 
'resets all queries that have started more than MAXIMUM_EXECUTION_TIME seconds ago to NOT_PROCESSED';

CREATE OR REPLACE FUNCTION get_programname_database()
RETURNS TABLE(program_name varchar, database_name varchar)
AS 
$BODY$
DECLARE
BEGIN
    RETURN QUERY SELECT pgr.program_name, pgr.database_name FROM program_database_relationships pgr; 
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION  get_option(varchar) IS 
'gets possible programname database combinations';