﻿DROP TABLE IF EXISTS programs CASCADE;
DROP TYPE IF EXISTS job_status CASCADE;
DROP TABLE IF EXISTS jobs CASCADE;
DROP TABLE IF EXISTS job_parameters CASCADE;
DROP TABLE IF EXISTS job_queries CASCADE;
DROP TABLE IF EXISTS running_queries CASCADE;
DROP TABLE IF EXISTS allowed_parameters CASCADE;
DROP TYPE blast_type;
CREATE TYPE job_status AS ENUM('NOT_PROCESSED', 'STARTING', 'PROCESSING', 'PROCESSED', 'PROCESSED_WITH_ERRORS', 'ERROR');
CREATE TYPE blast_type AS ENUM('blastn', 'blastp', 'blastx', 'tblastn', 'tblastx');

CREATE TABLE programs
(
	program_id serial NOT NULL PRIMARY KEY,
	name varchar NOT NULL UNIQUE
);
INSERT INTO programs (name) VALUES
('blastn'),
('blastp'),
('blastx'),
('tblastn'),
('tblastx');

CREATE TABLE jobs
(
	job_id serial NOT NULL PRIMARY KEY,
	uuid varchar NOT NULL UNIQUE,
	programname varchar NOT NULL REFERENCES programs(name),
	target_db varchar NOT NULL,
	additional_data text,
	md5 varchar,
	queueing_time timestamp without time zone NOT NULL DEFAULT now(),
	status job_status NOT NULL DEFAULT 'NOT_PROCESSED'
);

CREATE TABLE job_parameters 
(
	job_parameter_id serial NOT NULL PRIMARY KEY,
	job_id integer NOT NULL REFERENCES jobs(job_id),
	param_name varchar NOT NULL,
	param_value varchar NOT NULL
);

CREATE TABLE job_queries
(
	job_query_id serial NOT NULL PRIMARY KEY,
	job_id integer NOT NULL REFERENCES jobs(job_id),
	query text NOT NULL,
	status job_status NOT NULL DEFAULT 'NOT_PROCESSED',
	processing_start_time timestamp without time zone,
	processing_end_time timestamp without time zone,
	return_value integer,
	stdout text,
	stderr text
);

CREATE TABLE running_queries
(
	running_query_id serial NOT NULL PRIMARY KEY,
	job_query_id integer NOT NULL REFERENCES job_queries(job_query_id) UNIQUE,
	processing_host_identifier varchar NOT NULL,
	job_uid int
);


CREATE TABLE allowed_parameters
(
    allowed_parameter_id serial NOT NULL PRIMARY KEY,
    programname varchar NOT NULL REFERENCES programs(name),
    param_name varchar NOT NULL,
    default_value varchar,
    constraint_function varchar NOT NULL,
    constraint_function_parameters varchar[]
);
COMMENT ON COLUMN allowed_parameters.constraint_function IS 'name of a function with the signature "constraint_function(val varchar, arr varchar[]) RETURNS boolean"';

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

INSERT INTO allowed_parameters
(programname, param_name, default_value, constraint_function, constraint_function_parameters) VALUES
('blastn',  'task',             'megablast', 'cfunc_in_array',      ARRAY['blastn', 'dc-megablast', 'megablast']),
('blastn',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastn',  'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastn',  'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastn',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastp',  'task',             'blastp',    'cfunc_default_only',  NULL),
('blastp',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastp',  'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastp',  'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastp',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastx',  'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('blastx',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastx',  'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastx',  'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastx',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('tblastn', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('tblastn', 'outfmt',           '5',         'cfunc_default_only',  NULL),
('tblastn', 'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastn', 'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastn', 'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('tblastx', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('tblastx', 'outfmt',           '5',         'cfunc_default_only',  NULL),
('tblastx', 'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastx', 'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastx', 'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']);

CREATE OR REPLACE FUNCTION check_parameters(_programname varchar, _parameters varchar[][]) RETURNS boolean
AS 
$BODY$
DECLARE 
	_param varchar[];
	_param_constraints allowed_parameters%ROWTYPE;
	_retval boolean;
BEGIN
	FOREACH _param SLICE 1 IN ARRAY _parameters
	LOOP
		SELECT * INTO _param_constraints FROM allowed_parameters WHERE programname=_programname AND param_name=_param[1];
		IF _param_constraints IS NULL THEN
			RAISE NOTICE 'Parameter % is not defined for Programname %', _param[1], _programname;
			RETURN FALSE;
		END IF;
		EXECUTE 'SELECT ' || _param_constraints.constraint_function || '($1, $2)' 
			INTO _retval USING _param[2], _param_constraints.constraint_function_parameters;
		IF _retval = FALSE THEN
			RAISE NOTICE 'Invalid argument for Parameter %: %', _param[1], _param[2];
			RETURN FALSE;
		END IF;
	END LOOP;
	RETURN TRUE;
END;
$BODY$
LANGUAGE plpgsql;

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

CREATE OR REPLACE FUNCTION request_job(_max_jobs_running int,  _worker_identifier varchar, _handled_programs varchar[]) 
RETURNS TABLE(job_query_id int, programname varchar, parameters varchar, fasta_header varchar, query text, max_lifetime int)
AS
$BODY$
DECLARE 
	_jobs_available integer;
	_jobs_running integer;
	_job_query_id int;
	_job_id int;
	_programname varchar;
	_parameters varchar;
	_fasta_header varchar;
	_query text;
	_max_lifetime int;
	
BEGIN
	--check for job availability
	SELECT COUNT(*) INTO _jobs_available FROM job_queries WHERE status='NOT_PROCESSED' AND programname=any(_handled_programs);
	IF _jobs_available = 0 THEN
		RAISE NOTICE 'no jobs available';
		RETURN;
	END IF;
	START TRANSACTION;
	IF _max_jobs_running <> -1 THEN --check if this worker can start another job
		LOCK TABLE running_queries; --locked until we are finished, either because we are already at max jobs for this worker or we have assigned a new task
		IF _worker_identifier IS NULL THEN
			RAISE NOTICE 'no worker identifier given, using ip address';
			_worker_identifier = inet_client_addr()::varchar;
		END IF;
		SELECT COUNT(*) INTO _jobs_running FROM running_queries WHERE processing_host_identifier = _worker_identifier;
		RAISE NOTICE '% jobs are currently running for %', _jobs_running, _worker_identifier;
		IF _jobs_running >= _max_jobs_running THEN
			RAISE NOTICE 'already at full capacity, exiting';
			ROLLBACK;
			RETURN;
		END IF;
	END IF;
	--assign a job
	--while we do this, we don't want anyone else grab our job.
	LOCK TABLE job_queries;
		SELECT job_query_id, job_id,  programname,  query 
		INTO _job_query_id, _job_id, _programname, _query
		FROM job_queries
		WHERE status='NOT_PROCESSED' AND programname=any(_handled_programs)
		ORDER BY job_query_id ASC
		LIMIT 1;

		SELECT INTO _parameters get_job_parameters(_job_id);
		SELECT INTO _max_lifetime NOW() + '120 seconds'::interval; --TODO separate table for configuration options

		UPDATE job_queries SET status='STARTING', max_lifetime=_max_lifetime WHERE job_query_id=_job_query_id;
		INSERT INTO running_queries (job_query_id, processing_host_identifier) VALUES (_job_query_id, _worker_identifier);
	COMMIT;
	RETURN QUERY SELECT _job_query_id, _programname, _parameters, _fasta_header, _query, _max_lifetime;
END;
$BODY$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION report_job_pid(_job_query_id int,  _pid int) RETURNS VOID
AS 
$BODY$
BEGIN
	UPDATE job_queries SET     status='PROCESSING' WHERE  job_query_id=_job_query_id;
	UPDATE running_queries SET pid=_pid            WHERE  job_query_id=_job_query_id;
END;
$BODY$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION report_job_result(_job_query_id int,  _return_code integer, _stdout text, _stderr text) RETURNS VOID
AS 
$BODY$
BEGIN
	UPDATE job_queries SET 
		status = CASE WHEN _return_code = 0 THEN 'PROCESSED' ELSE 'PROCESSED_WITH_ERRORS' END,
		return_code = _return_code, 
		stdout = _stdout, 
		stderr = _stderr 
	WHERE job_query_id=_job_query_id;
	DELETE FROM running_queries WHERE  job_query_id=_job_query_id;
END;
$BODY$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION create_job(_programname varchar,  _target_db varchar, _additional_data text, _parameters varchar[][], _queries text[]) RETURNS varchar
AS 
$BODY$
BEGIN
END;
$BODY$
LANGUAGE plpgsql;


SELECT request_job(0,NULL, ARRAY['blastp']);

SELECT check_parameters('blastn', ARRAY[ARRAY['task','dc-megablast'], ARRAY['evalue','3']]);