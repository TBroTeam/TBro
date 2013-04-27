<?php
namespace cli_db\propel;

if (!@include_once 'propel/Propel.php')
    die(<<<EOF
Failure including propel/Propel.php
please install propel_runtime via PEAR or check your include_path
        
    pear channel-discover pear.propelorm.org
    pear install -a propel/propel_runtime
EOF
);

// Initialize Propel with the runtime configuration
\Propel::init(ROOT.'propel-conf/cli_db-conf.php');

// Add the generated 'classes' directory to the include path
set_include_path(ROOT.'propel-classes/' . PATH_SEPARATOR . get_include_path());
?>
