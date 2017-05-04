BEGIN TRANSACTION;

-- programs that the user is allowed to execute
INSERT INTO programs (name) VALUES
('blastn'),
('blastp'),
('blastx'),
('tblastn'),
('tblastx');

-- database files available. name is the name it will be referenced by, md5 is the zip file's sum, download_uri specifies where the file can be retreived
INSERT INTO database_files
(name, md5, download_uri) VALUES
('13_test.fasta', '81b096cd80be252fd7633d39b08d53d2', 'http://wbbi170/httpdocs/server/downloads/13_test.fasta.zip'),
('13_test_predpep.fasta', 'de360c35e8719b36c19de387d8f77f18', 'http://wbbi170/httpdocs/server/downloads/13_test_predpep.fasta.zip');


-- contains information which program is available for which program.
-- additionally, 'availability_filter' can be used to e.g. restrict use for a organism-release combination
-- the availability filter has the format {organism_id}_{release}
-- you need a separate line for each organism/release combination
INSERT INTO program_database_relationships
(programname, database_name, availability_filter) VALUES
('blastn','13_test.fasta', '13_test'),
('blastp','13_test_predpep.fasta', '13_test'),
('blastx','13_test_predpep.fasta', '13_test'),
('tblastn','13_test.fasta', '13_test'),
('tblastx','13_test.fasta', '13_test');


--time in seconds until a query job will be set from "PROCESSING" to "NOT_PROCESSED". make sure this value is big enough or some jobs will stay in the queue forever.
UPDATE options SET value=120 WHERE key='MAXIMUM_EXECUTION_TIME';
--time in seconds a worker has to send another keepalive_ping until a query job will be set from "PROCESSING" to "NOT_PROCESSED".
UPDATE options SET value=15 WHERE key='MAXIMUM_KEEPALIVE_TIMEOUT';


-- allowed parameters to be passed for each of these programs
-- if a parameter is omited by create_job, the default_value will be used. can contain the variable $DBFILE
-- the constraint_function will be executed on the parameter value, together with constraint_function_parameters
-- available constraints function are (but can be extended):
--   cfunc_in_array - takes an array of values as constraint_function_parameters
--   cfunc_within_bounds - takes an array of {min,max} as constraint_function_parameters
--   cfunc_default_only - user can not change it, always use default parameter
INSERT INTO allowed_parameters
(programname, param_name, default_value, constraint_function, constraint_function_parameters) VALUES
('blastn',  'task',             'megablast', 'cfunc_in_array',      ARRAY['blastn', 'dc-megablast', 'megablast']),
('blastn',  'word_size',        '11',        'cfunc_in_array',      ARRAY['7', '11', '15']),
('blastn',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastn',  'max_target_seqs',  '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastn',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastn',  'db',               '$DBFILE',   'cfunc_default_only',  NULL),
('blastp',  'task',             'blastp',    'cfunc_default_only',  NULL),
('blastp',  'word_size',        '3',         'cfunc_in_array',      ARRAY['2', '3']),
('blastp',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastp',  'max_target_seqs',  '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastp',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastp',  'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('blastp',  'db',               '$DBFILE',   'cfunc_default_only',  NULL),
('blastx',  'outfmt',           '5',         'cfunc_default_only',  NULL),
('blastx',  'word_size',        '3',         'cfunc_in_array',      ARRAY['2', '3']),
('blastx',  'max_target_seqs',  '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('blastx',  'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('blastx',  'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('blastx',  'db',               '$DBFILE',   'cfunc_default_only',  NULL),
('tblastn', 'outfmt',           '5',         'cfunc_default_only',  NULL),
('tblastn', 'word_size',        '3',         'cfunc_in_array',      ARRAY['2', '3']),
('tblastn', 'max_target_seqs',  '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastn', 'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('tblastn', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('tblastn', 'db',               '$DBFILE',   'cfunc_default_only',  NULL),
('tblastx', 'outfmt',           '5',         'cfunc_default_only',  NULL),
('tblastx', 'word_size',        '3',         'cfunc_in_array',      ARRAY['2', '3']),
('tblastx', 'max_target_seqs',  '10',        'cfunc_within_bounds', ARRAY['1','1000']),
('tblastx', 'evalue',           '0.1',       'cfunc_within_bounds', ARRAY['0','100']),
('tblastx', 'matrix',           'BLOSUM62',  'cfunc_in_array',      ARRAY['BLOSUM45', 'BLOSUM50', 'BLOSUM62', 'BLOSUM80', 'BLOSUM90', 'PAM30', 'PAM70', 'PAM250']),
('tblastx', 'db',               '$DBFILE',   'cfunc_default_only',  NULL);

COMMIT;
