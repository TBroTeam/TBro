DROP TABLE IF EXISTS programs CASCADE;
DROP TYPE IF EXISTS job_status CASCADE;
DROP TABLE IF EXISTS jobs CASCADE;
DROP TABLE IF EXISTS job_parameters CASCADE;
DROP TABLE IF EXISTS job_queries CASCADE;
DROP TABLE IF EXISTS running_queries CASCADE;
DROP TABLE IF EXISTS allowed_parameters CASCADE;
DROP TYPE blast_type;
CREATE TYPE job_status AS ENUM('NOT_PROCESSED', 'STARTING', 'PROCESSING', 'PROCESSED','ERROR', 'PROCESSED_WITH_ERRORS');
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
	uid varchar NOT NULL UNIQUE,
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
	param_value varchar NOT NULL,
	UNIQUE (job_id, param_name)
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

INSERT INTO allowed_parameters
(programname, param_name, default_value, constraint_function, constraint_function_parameters) VALUES
('blastn',  'task',             'megablast', 'cfunc_in_array',      ARRAY['blastn', 'dc-megablast', 'megablast']),
('blastn',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastn',  'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastn',  'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastn',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastn',  'db',               '$DBFILE',  'cfunc_default_only',  NULL),
('blastp',  'task',             'blastp',    'cfunc_default_only',  NULL),
('blastp',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastp',  'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastp',  'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastp',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastp',  'db',               '$DBFILE',  'cfunc_default_only',  NULL),
('blastx',  'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('blastx',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastx',  'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastx',  'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastx',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastx',  'db',               '$DBFILE',  'cfunc_default_only',  NULL),
('tblastn', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('tblastn', 'outfmt',           '5',         'cfunc_default_only',  NULL),
('tblastn', 'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastn', 'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastn', 'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('tblastn',  'db',              '$DBFILE',  'cfunc_default_only',  NULL),
('tblastx', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('tblastx', 'outfmt',           '5',         'cfunc_default_only',  NULL),
('tblastx', 'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastx', 'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastx', 'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('tblastx',  'db',              '$DBFILE',  'cfunc_default_only',  NULL);



--SELECT create_job('blastn', 'human', '', ARRAY[ARRAY['task','dc-megablast'], ARRAY['evalue','3']], ARRAY['TGC','TGAC','TGAC','TGAC']);

--SELECT request_job(0,NULL, ARRAY['blastp']);

--SELECT check_parameters('blastn', ARRAY[ARRAY['task','dc-megablast'], ARRAY['evalue','3']]);

--SELECT * FROM request_job('2', 'wbbi170', ARRAY['blastn','blastp','blastx','tblastn','tblastx']);
