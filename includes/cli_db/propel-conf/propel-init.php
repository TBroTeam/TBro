<?php
namespace cli_db\propel;

//needs PEAR package propel-runtime: pear install -a propel/propel_runtime
require_once 'propel/Propel.php';

// Initialize Propel with the runtime configuration
\Propel::init(__DIR__.'/../propel-conf/cli_db-conf.php');

// Add the generated 'classes' directory to the include path
set_include_path(__DIR__.'/../propel-classes/' . PATH_SEPARATOR . get_include_path());
?>
