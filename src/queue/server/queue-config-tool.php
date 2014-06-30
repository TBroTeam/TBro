<?php

//include requirements
if (stream_resolve_include_path('Console/CommandLine.php'))
    require_once 'Console/CommandLine.php';
else
    die("Failure including Console/CommandLine.php\nplease install PEAR::Console_CommandLine or check your include_path\n");

if (stream_resolve_include_path('Console/Table.php'))
    require_once 'Console/Table.php';
else
    die("Failure including Console/Table.php\nplease install PEAR::Console_Table or check your include_path\n");


$xmldata = <<<EOF
<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<command>
    <option name="configfile">
        <short_name>-c</short_name>
        <long_name>--config</long_name>
        <description>path to configuration file</description>
    </option>    

    <command>
        <name>list_databases</name>
        <description>list_databases</description>
    </command>

    <command>
        <name>add_database</name>
        <description>add_database</description>
        
        <option name="dbname">
            <short_name>-d</short_name>
            <long_name>--dbname</long_name>
            <description>name of database file within zip archive</description>
        </option>

        <option name="md5">
            <short_name>-m</short_name>
            <long_name>--md5</long_name>
            <description>md5 sum of zip archive</description>
        </option>    

        <option name="uri">
            <short_name>-u</short_name>
            <long_name>--uri</long_name>
            <description>download uri for zip archive (should be accessible for workers)</description>
        </option>    
    </command>

    <command>
        <name>remove_database</name>
        <description>remove_database</description>
        
        <option name="dbname">
            <short_name>-d</short_name>
            <long_name>--dbname</long_name>
            <description>name of database file within zip archive</description>
        </option>
    </command>
    
    <command>
        <name>list_programs</name>
        <description>list programs</description>
    </command>

    <command>
        <name>list_relationships</name>
        <description>list programs with associated databases</description>
    </command>
    
    <command>
        <name>link_database_program</name>
        <description>link program(s) to database</description>
        
        <option name="dbname">
            <short_name>-d</short_name>
            <long_name>--dbname</long_name>
            <description>name of database file within zip archive</description>
        </option>
        
       <argument name="programs">
           <multiple>TRUE</multiple>
           <description>programs to link</description>
       </argument>
    </command>
    
    <command>
        <name>unlink_database_program</name>
        <description>unlink program(s) from database</description>
        
        <option name="dbname">
            <short_name>-d</short_name>
            <long_name>--dbname</long_name>
            <description>name of database file within zip archive</description>
        </option>
        
       <argument name="programs">
           <multiple>TRUE</multiple>
           <description>programs to link</description>
       </argument>
    </command>
</command>
EOF;

$parser = Console_CommandLine::fromXmlString($xmldata);
$parser->subcommand_required = true;


try {
    $result = $parser->parse();

    //include config files
    require_command_option($result, 'configfile');
    if (file_exists($result->options['configfile']))
        include_once $result->options['configfile'];
    else
        die("Missing config file " . $result->options['configfile'] . "\n");

    //have we been called with a command?
    if (is_object($result->command)) {
        $pdo = connect_queue_db();

        switch ($result->command_name) {
            case 'list_databases':
                $stm_list = $pdo->prepare('SELECT name, md5, download_uri FROM database_files');
                $stm_list->execute();

                $tbl = new Console_Table();
                $tbl->setHeaders(array('name', 'md5', 'download_uri'));

                while ($row = $stm_list->fetch(\PDO::FETCH_NUM))
                    $tbl->addRow($row);

                echo $tbl->getTable();

                break;

            case 'add_database':
                require_command_option($result->command, 'dbname');
                require_command_option($result->command, 'md5');
                require_command_option($result->command, 'uri');

                $stm_ins = $pdo->prepare('INSERT INTO database_files (name, md5, download_uri) VALUES (?,?,?);');
                $stm_ins->execute(array($result->command->options['dbname'], $result->command->options['md5'], $result->command->options['uri']));
                if ($stm_ins->rowCount() > 0)
                    echo "successfully inserted\n";

                break;

            case 'remove_database':
                require_command_option($result->command, 'dbname');


                $stm_del = $pdo->prepare('DELETE FROM database_files WHERE name=?');
                $stm_del->execute(array($result->command->options['dbname']));

                if ($stm_del->rowCount() > 0)
                    echo "successfully removed\n";

                break;

            case 'list_programs':
                $stm_list = $pdo->prepare('SELECT name FROM programs');
                $stm_list->execute();

                $tbl = new Console_Table();
                $tbl->setHeaders(array('name'));

                while ($row = $stm_list->fetch(\PDO::FETCH_NUM))
                    $tbl->addRow($row);

                echo $tbl->getTable();

                break;

            case 'list_relationships':
                $stm_list = $pdo->prepare('SELECT programname, database_name FROM program_database_relationships');
                $stm_list->execute();

                $tbl = new Console_Table();
                $tbl->setHeaders(array('programname', 'database_name'));

                while ($row = $stm_list->fetch(\PDO::FETCH_NUM))
                    $tbl->addRow($row);

                echo $tbl->getTable();

                break;

            case 'link_database_program':
                require_command_option($result->command, 'dbname');
                $dbname = $result->command->options['dbname'];
                foreach ($result->command->args['programs'] as $program) {
                    $stm_ins = $pdo->prepare('INSERT INTO program_database_relationships (programname, database_name) VALUES (?,?);');
                    $stm_ins->execute(array($program, $dbname));
                    if ($stm_ins->rowCount() > 0)
                        echo "successfully inserted $dbname <-> $program \n";
                }

                break;

            case 'unlink_database_program':
                require_command_option($result->command, 'dbname');
                $dbname = $result->command->options['dbname'];
                foreach ($result->command->args['programs'] as $program) {
                    $stm_ins = $pdo->prepare('DELETE FROM program_database_relationships  WHERE (programname, database_name) = (?,?);');
                    $stm_ins->execute(array($program, $dbname));
                    if ($stm_ins->rowCount() > 0)
                        echo "successfully removed $dbname <-> $program \n";
                }

                break;
        }
    } else {
        $parser->displayUsage();
        exit(0);
    }
} catch (\Exception $exc) {
    if (defined('DEBUG') && DEBUG) {
        throw $exc;
    }
    $parser->displayError("\n" . $exc->getMessage() . "\n\n");
}

function require_command_option($command, $optionname) {
    if (!isset($command->options[$optionname])) {
        die("Please specify command line option $optionname !\n");
    }
}

?>
