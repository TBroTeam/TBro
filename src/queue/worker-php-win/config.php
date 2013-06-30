<?php

define('JOB_DB_CONNSTR', 'pgsql:host=132.187.22.155;dbname=dionaea_transcript_db_dev');
define('JOB_DB_USERNAME', 's202139');
define('JOB_DB_PASSWORD', 's202139');

define('MAX_FORKS', 2);
define('HOSTNAME', gethostname());
define('SUPPORTED_PROGRAMS', serialize(array(
            'blastn' => 'ncbi-blast-2.2.28+\\bin\\blastn.exe',
            'blastp' => 'ncbi-blast-2.2.28+\\bin\\blastp',
            'blastx' => 'ncbi-blast-2.2.28+\\bin\\bin\\blastx',
            'tblastn' => 'ncbi-blast-2.2.28+\\bin\\bin\\tblastn',
            'tblastx' => 'ncbi-blast-2.2.28+\\bin\\bin\\tblastx'
        )));

#make sure you have write rights in this directory, as databases will be downloaded there
define('DATABASE_BASEDIR', 'downloaded_databases')
?>
