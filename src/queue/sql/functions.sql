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
    LOCK TABLE allowed_parameters;
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


CREATE OR REPLACE FUNCTION get_param_set_id(parameters varchar[][], _programname varchar)  RETURNS integer
AS
$BODY$
DECLARE
    _ret varchar;
    _parameter_names varchar [];
    _row RECORD;
    _param_set_id integer;
BEGIN
    SELECT INTO _parameter_names ARRAY(SELECT UNNEST(p[array_lower(p, 1):array_upper(p, 1)][1:1]) FROM (SELECT parameters p) x);

    _ret := '';
    FOR _row IN
        SELECT param_name, default_value AS value FROM allowed_parameters WHERE programname=_programname AND default_value IS NOT NULL AND NOT param_name=ANY(_parameter_names)
        UNION
        SELECT UNNEST(p[array_lower(p, 1):array_upper(p, 1)][1:1]) AS param_name, UNNEST(p[array_lower(p, 1):array_upper(p, 1)][2:2]) AS value FROM (SELECT parameters p) x
    LOOP
        _ret := _ret || ' -' || _row.param_name || ' "' || _row.value || '"';
    END LOOP;

    SELECT INTO _param_set_id parameter_set_id FROM parameter_sets WHERE parameters_assembled = _ret;
    IF NOT FOUND THEN
        INSERT INTO parameter_sets (parameters_assembled) VALUES (_ret) RETURNING parameter_set_id INTO _param_set_id ;
    END IF;
    RETURN _param_set_id;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION get_param_set_id(varchar[][], varchar) IS 
'assemble command line parameters & add default values where none given to form a command line call, e.g. ''-a "valuea" -b "valueb"''';


CREATE OR REPLACE FUNCTION request_job(_max_jobs_running int,  _worker_identifier varchar, _handled_programs varchar[]) 
RETURNS TABLE(running_query_id int, programname varchar, parameters varchar, query text, max_lifetime int, target_db varchar, target_db_md5 varchar, target_db_download_uri varchar)
AS
$BODY$
DECLARE 
    _jobs_available integer;
    _jobs_running integer;
    _query_id int;
    _programname varchar;
    _parameters varchar;
    _query text;
    _running_query_id integer;
    _target_db varchar;
    _target_db_md5 varchar;
    _target_db_download_uri varchar;    
BEGIN
    LOCK TABLE queries;
    LOCK TABLE running_queries;

    EXECUTE reset_timed_out_queries();
    
    --check for job availability
    SELECT COUNT(*) INTO _jobs_available FROM queries WHERE queries.status='NOT_PROCESSED' AND queries.programname = any(_handled_programs);
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
    SELECT q.query_id,  q.programname, q.query, q.target_db, p.parameters_assembled
    INTO _query_id, _programname, _query, _target_db, _parameters
    FROM queries q JOIN parameter_sets p ON (q.parameter_set_id=p.parameter_set_id) 
    WHERE q.status='NOT_PROCESSED' AND q.programname = any(_handled_programs)
    ORDER BY q.query_id ASC
    LIMIT 1;

    SELECT md5, download_uri FROM database_files WHERE name=_target_db INTO _target_db_md5, _target_db_download_uri;

    UPDATE queries SET status='STARTING', processing_start_time=NOW() WHERE queries.query_id=_query_id;
    INSERT INTO running_queries (query_id, processing_host_identifier) VALUES (_query_id, _worker_identifier)  RETURNING running_queries.running_query_id INTO _running_query_id;
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
    _query_id integer;
BEGIN
    LOCK TABLE jobs;
    LOCK TABLE queries;
    LOCK TABLE running_queries;

    SELECT INTO _query_id query_id FROM running_queries WHERE running_query_id=_running_query_id;
    IF FOUND THEN
        UPDATE queries         SET status='PROCESSING' WHERE  query_id=_query_id;
        UPDATE running_queries SET pid=_pid            WHERE  query_id=_query_id;
        UPDATE jobs            SET status='PROCESSING' WHERE status='NOT_PROCESSED' and job_id IN (SELECT job_id FROM job_queries WHERE query_id=_query_id);
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
    _query_id integer;
BEGIN
    LOCK TABLE queries;
    LOCK TABLE running_queries;

    SELECT INTO _query_id query_id FROM running_queries WHERE running_query_id=_running_query_id;
    IF NOT FOUND THEN
        RAISE NOTICE 'this job does not belong to you(any more?)!';
        RETURN;
    END IF;

    UPDATE queries SET 
        status = CASE WHEN _return_code = 0 THEN 'PROCESSED'::job_status ELSE 'ERROR'::job_status END,
        return_value = _return_code, 
        stdout = _stdout, 
        stderr = _stderr,
        processing_end_time = NOW()
    WHERE query_id=_query_id;
    DELETE FROM running_queries WHERE query_id=_query_id;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION report_job_result(int, int, text, text) IS
'sets query final status "PROCESSED" or "ERROR", depending on return code. saves stdout and stderr and removes job from the running_queries table';

CREATE OR REPLACE FUNCTION keepalive_ping(_query_id int) RETURNS integer
AS 
$BODY$
BEGIN
    PERFORM * FROM queries WHERE query_id=_query_id FOR UPDATE;
    UPDATE queries SET last_keepalive=now() WHERE query_id=_query_id;
    IF FOUND THEN
        RETURN get_option('MAXIMUM_KEEPALIVE_TIMEOUT')::integer;
    ELSE
        RETURN -1;
    END IF;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION keepalive_ping(_query_id int) IS
'updates last_keepalive. returns max_keepalive_timeout or -1 if this job has already timed out.out';

CREATE OR REPLACE FUNCTION set_job_final_status(_job_id int) RETURNS VOID
AS 
$BODY$
BEGIN
    LOCK TABLE jobs;
        IF NOT EXISTS (SELECT 1 FROM job_queries jq JOIN queries q ON (jq.query_id=q.query_id) WHERE jq.job_id=_job_id AND NOT status='PROCESSED') THEN
            UPDATE jobs SET status='PROCESSED' WHERE job_id = _job_id;
        ELSEIF NOT EXISTS (SELECT 1 FROM job_queries jq JOIN queries q ON (jq.query_id=q.query_id) WHERE jq.job_id=_job_id AND NOT (status='PROCESSED' OR status='ERROR')) THEN
            UPDATE jobs SET status='PROCESSED_WITH_ERRORS' WHERE job_id = _job_id;
        END IF;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION set_job_final_status(_job_id int) IS
'sets job final status "PROCESSED" or "PROCESSED_WITH_ERRORS", depending on the associated queries'' return codes';

CREATE OR REPLACE FUNCTION updated_query_status() RETURNS TRIGGER
AS 
$BODY$
DECLARE
    _job_id int;
BEGIN
    FOR _job_id IN SELECT job_id FROM job_queries WHERE job_queries.query_id=NEW.query_id LOOP
        EXECUTE set_job_final_status(_job_id);
    END LOOP;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION updated_query_status() IS
'sets job final status "PROCESSED" or "PROCESSED_WITH_ERRORS", depending on the associated queries'' return codes';

DROP TRIGGER IF EXISTS trigger_update_query_status ON queries;
CREATE TRIGGER trigger_update_query_status
    AFTER UPDATE ON queries
    FOR EACH ROW
    WHEN (OLD.status IS DISTINCT FROM NEW.status AND (NEW.status='PROCESSED' OR NEW.status='ERROR'))
    EXECUTE PROCEDURE updated_query_status();


CREATE OR REPLACE FUNCTION create_job(_programname varchar,  _target_db varchar, _additional_data text, _parameters varchar[][], _queries text[]) 
RETURNS varchar
AS 
$BODY$
DECLARE 
    _uid varchar;
    _job_id integer;
    _parameter_set_id integer;
    _query_id integer;
    _query text;
    _inserted_queries integer;
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

    --assemble command line parameters & add default values where none given
    _parameter_set_id := get_param_set_id(_parameters, _programname);

    LOCK TABLE jobs;
    LOCK TABLE queries;
    LOCK TABLE job_queries;
        

    LOOP --generate a random 32-bit-uid until it is unique
        _uid = to_hex((random()*power(2,32))::bigint);
        EXIT WHEN NOT EXISTS (SELECT 1 FROM jobs WHERE uid=_uid);
    END LOOP;

    --insert job
    INSERT INTO jobs (additional_data, uid) 
        VALUES   (_additional_data, _uid)
    RETURNING job_id INTO _job_id;
    RAISE NOTICE 'inserted job id %', _job_id;

    --insert queries
    _inserted_queries := 0;
    FOREACH _query IN ARRAY _queries LOOP
        SELECT INTO _query_id query_id FROM queries WHERE (programname, parameter_set_id, target_db, query) = (_programname, _parameter_set_id, _target_db, _query);
        IF NOT FOUND THEN
            INSERT INTO queries (programname, parameter_set_id, target_db, query) VALUES (_programname, _parameter_set_id, _target_db, _query) RETURNING query_id INTO _query_id;
            RAISE NOTICE 'inserted query id %', _query_id;
            _inserted_queries := _inserted_queries + 1;
        END IF;

        INSERT INTO job_queries ( job_id,  query_id) VALUES (_job_id, _query_id);
        RAISE NOTICE 'inserted job_queries(%,%)',_job_id, _query_id;
    END LOOP;
    RAISE NOTICE 'queries: %', _inserted_queries;
    if _inserted_queries = 0 THEN
        -- will set job to processed when all queries have been processed earlier
        RAISE NOTICE 'did not insert any queries for this job, computing final job status';
        EXECUTE set_job_final_status(_job_id);
    END IF;

    --done
    RETURN _uid;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION create_job(varchar,  varchar, text, varchar[][], text[]) IS
'create a new job.';

CREATE OR REPLACE FUNCTION get_job_results(_job_uid varchar)
RETURNS TABLE(status job_status, additional_data text, query text, query_status job_status, query_stdout text, query_stderr text)
AS 
$BODY$
BEGIN
    LOCK TABLE jobs;
    LOCK TABLE job_queries;
    RETURN QUERY SELECT jobs.status, jobs.additional_data, q.query, q.status, q.stdout, q.stderr
        FROM jobs LEFT JOIN job_queries jq ON (jobs.job_id = jq.job_id) JOIN queries q ON (jq.query_id=q.query_id) WHERE jobs.uid = _job_uid;
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
BEGIN
      PERFORM * from queries WHERE 
      (
      (status='PROCESSING' OR status='STARTING') 
      AND 
      (
         (processing_start_time + get_option('MAXIMUM_EXECUTION_TIME')::integer * interval '1 second'<NOW())
	 OR
	 (last_keepalive + get_option('MAXIMUM_KEEPALIVE_TIMEOUT')::integer * interval '1 second'<NOW())
      )) FOR UPDATE;

      UPDATE queries SET status='NOT_PROCESSED', processing_start_time=NULL WHERE 
      (
      (status='PROCESSING' OR status='STARTING') 
      AND 
      (
         (processing_start_time + get_option('MAXIMUM_EXECUTION_TIME')::integer * interval '1 second'<NOW())
	 OR
	 (last_keepalive + get_option('MAXIMUM_KEEPALIVE_TIMEOUT')::integer * interval '1 second'<NOW())
      ));
 END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION reset_timed_out_queries() IS 
'resets all queries that have ran for more than MAXIMUM_EXECUTION_TIME or did not send a keepalive pint seconds ago to NOT_PROCESSED';

CREATE OR REPLACE FUNCTION get_programname_database(_availability_filter varchar)
RETURNS TABLE(programname varchar, database_name varchar)
AS 
$BODY$
DECLARE
BEGIN
    RETURN QUERY SELECT pgr.programname, pgr.database_name FROM program_database_relationships pgr WHERE pgr.availability_filter=_availability_filter OR pgr.availability_filter IS NULL OR _availability_filter IS NULL; 
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION  get_option(varchar) IS 
'gets possible programname database combinations';