<?php
namespace cli_db\propel;

// Initialize Propel with the runtime configuration
\Propel::init(ROOT.'propel-conf/cli_db-conf.php');

// Add the generated 'classes' directory to the include path
set_include_path(ROOT.'propel-classes/' . PATH_SEPARATOR . get_include_path());
?>
