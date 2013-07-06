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
('blastp',  'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('blastp',  'db',               '$DBFILE',  'cfunc_default_only',  NULL),
('blastx',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastx',  'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastx',  'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastx',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastx', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('blastx',  'db',               '$DBFILE',  'cfunc_default_only',  NULL),
('tblastn', 'outfmt',           '5',         'cfunc_default_only',  NULL),
('tblastn', 'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastn', 'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastn', 'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('tblastn', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('tblastn',  'db',              '$DBFILE',  'cfunc_default_only',  NULL),
('tblastx', 'outfmt',           '5',         'cfunc_default_only',  NULL),
('tblastx', 'num_descriptions', '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastx', 'num_alignments',   '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastx', 'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('tblastx', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('tblastx',  'db',              '$DBFILE',  'cfunc_default_only',  NULL);

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


INSERT INTO database_files
(name, md5, download_uri) VALUES
('13_test.fasta', '81b096cd80be252fd7633d39b08d53d2', 'http://wbbi170/httpdocs/server/downloads/13_test.fasta.zip'),
('13_test_predpep.fasta', 'de360c35e8719b36c19de387d8f77f18', 'http://wbbi170/httpdocs/server/downloads/13_test_predpep.fasta.zip');

INSERT INTO program_database_relationships
(programname, database_name) VALUES
('blastn','13_test.fasta'),
('blastp','13_test_predpep.fasta'),
('blastx','13_test_predpep.fasta'),
('tblastn','13_test.fasta'),
('tblastx','13_test.fasta');
