<?php

define('JOB_DB_CONNSTR', 'pgsql:host=${queue_db_host};dbname=${queue_db_name};port=${queue_db_port}');
define('JOB_DB_USERNAME', '${queue_db_username}');
define('JOB_DB_PASSWORD', '${queue_db_password}');

define('MAX_FORKS', 2);
define('HOSTNAME', gethostname());
define('SUPPORTED_PROGRAMS', serialize(array(
            'blastn' => '/usr/bin/blastn',
            'blastp' => '/usr/bin/blastp',
            'blastx' => '/usr/bin/blastx',
            'tblastn' => '/usr/bin/tblastn',
            'tblastx' => '/usr/bin/tblastx'
        )));

#make sure you have write rights in this directory, as databases will be downloaded there
define('DATABASE_BASEDIR', '/tmp/queue-worker/')
?>
