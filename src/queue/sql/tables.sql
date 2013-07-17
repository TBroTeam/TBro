CREATE TYPE job_status AS ENUM('NOT_PROCESSED', 'STARTING', 'PROCESSING', 'PROCESSED','ERROR', 'PROCESSED_WITH_ERRORS');
CREATE TYPE blast_type AS ENUM('blastn', 'blastp', 'blastx', 'tblastn', 'tblastx');

CREATE TABLE programs
(
	program_id serial NOT NULL PRIMARY KEY,
	name varchar NOT NULL UNIQUE
);
CREATE TABLE database_files
(
    database_file_id serial NOT NULL PRIMARY KEY,
    name varchar NOT NULL UNIQUE,
    md5 varchar NOT NULL,
    download_uri varchar NOT NULL
);

CREATE TABLE program_database_relationships
(
    program_database_relationship_id serial NOT NULL PRIMARY KEY,
    programname varchar NOT NULL REFERENCES programs(name),
    database_name varchar NOT NULL REFERENCES database_files(name),
    availability_filter varchar,
    UNIQUE (programname,database_name,availability_filter)
);

CREATE TABLE jobs
(
	job_id serial NOT NULL PRIMARY KEY,
	uid varchar NOT NULL UNIQUE,
	additional_data text,
	queueing_time timestamp without time zone NOT NULL DEFAULT now(),
	status job_status NOT NULL DEFAULT 'NOT_PROCESSED'
);

CREATE TABLE parameter_sets 
(
	parameter_set_id serial NOT NULL PRIMARY KEY,
	parameters_assembled varchar NOT NULL UNIQUE
);

CREATE TABLE queries
(
	query_id serial NOT NULL PRIMARY KEY,
	programname varchar NOT NULL REFERENCES programs(name),
	parameter_set_id integer NOT NULL REFERENCES parameter_sets(parameter_set_id),
	target_db varchar NOT NULL REFERENCES database_files(name),
	query text NOT NULL,
	status job_status NOT NULL DEFAULT 'NOT_PROCESSED',
	processing_start_time timestamp without time zone,
	processing_end_time timestamp without time zone,
	return_value integer,
	stdout text,
	stderr text
);
CREATE INDEX ON queries (programname, parameter_set_id, target_db, query);

CREATE TABLE job_queries
(
    job_query_id serial NOT NULL PRIMARY KEY,
    job_id integer NOT NULL REFERENCES jobs(job_id),
    query_id integer NOT NULL REFERENCES queries(query_id),
    UNIQUE (job_id, query_id)
);

CREATE TABLE running_queries
(
	running_query_id serial NOT NULL PRIMARY KEY,
	query_id integer NOT NULL REFERENCES queries(query_id) UNIQUE,
	processing_host_identifier varchar NOT NULL,
        last_keepalive timestamp without time zone NOT NULL DEFAULT now(),
	pid int
);


CREATE TABLE allowed_parameters
(
    allowed_parameter_id serial NOT NULL PRIMARY KEY,
    programname varchar NOT NULL REFERENCES programs(name),
    param_name varchar NOT NULL,
    default_value varchar,
    constraint_function varchar NOT NULL,
    constraint_function_parameters varchar[],
    UNIQUE (programname, param_name)
);
COMMENT ON COLUMN allowed_parameters.constraint_function IS 'name of a function with the signature "constraint_function(val varchar, arr varchar[]) RETURNS boolean"';

CREATE TABLE options
(
    option_id serial NOT NULL PRIMARY KEY,
    key varchar NOT NULL,
    value varchar,
    description text,
    UNIQUE (key)
);
COMMENT ON TABLE options IS 
'contains configuration options, such as MAXIMUM_EXECUTION_TIME';
INSERT INTO options
(key, value, description) VALUES
('MAXIMUM_EXECUTION_TIME', '120', 
'time in seconds until a query job will be set from "PROCESSING" to "NOT_PROCESSED". 
make sure this value is big enough or some jobs will stay in the queue forever.'),
('MAXIMUM_KEEPALIVE_TIMEOUT', '15', 
'time in seconds a worker has to send another keepalive_ping until a query job will be set from "PROCESSING" to "NOT_PROCESSED".');
