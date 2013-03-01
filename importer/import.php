#!/usr/bin/php
<?
require __DIR__ . '/includes/constants.php';

//TODO count of lines imported
## don't touch anything below!

function display_help() {
    echo <<<EOF
### transcript data importer ###
usage: 
    import.php --type <type> --file <file> [<file>*] [opts]
    import.php --help

types:
    map
    sequence
        requires import of: map
    quantification
        requires full import of: sequences
        requires
            --quantification_id <int>
            --biomaterial_name <string>
            --type_name <string>
            --column <int>
    annotation
        requires full import of: sequences
        requires
            --subtype (blast2go|interpro|repeatmasker)
    expressions
        requires full import of: sequences, quantifications
        requires 
            --analysis_id <int>
            --biomaterial_A_name <string, name of parent biomaterial>
            --biomaterial_B_name <string, name of parent biomaterial>
            

options:
    --verbose
        will give verbose output
    --debug
        will give even more ouptut, try to continue on error

EOF;
}

include __DIR__ . '/includes/init_cli.php';
global $parms;
init_cli();

if (isset($parms['--help'])) {
    display_help();
    die();
}

if (!isset($parms['--type'])|| !isset($parms['--file']) || $parms['--file'] === true) {
    die("wrong parameter usage, call with --help for more information\n");
}

if (is_string($parms['--file'])) {
    $parms['--file'] = array($parms['--file']);
}

foreach ($parms['--file'] as $file) {
    if (!file_exists($file)) {
        die("file $file does not exist!\n");
    }
}

if (isset($parms['--debug']))
    define('DEBUG', true);
else
    define('DEBUG', false);

if (isset($parms['--verbose']))
    define('VERBOSE', true);
else
    define('VERBOSE', false);

foreach ($parms['--file'] as $file) {
    $file_result = null;
    try {
        switch ($parms['--type']) {
            case 'map':
                require_once __DIR__ . '/includes/importers/Importer_Map.php';
                $file_result = Importer_Map::import($file);
                break;
            case 'sequence':
                require_once __DIR__ . '/includes/importers/Importer_Sequences.php';
                $file_result = Importer_Sequences::import($file);
                break;
            case 'quantification':
                require_parameter(array('--quantification_id', '--biomaterial_name', '--type_name', '--column'));
                require_once __DIR__ . '/includes/importers/Importer_Quantifications.php';
                $file_result = Importer_Quantifications::import($file, $parms['--quantification_id'], $parms['--biomaterial_name'], $parms['--type_name'], $parms['--column']);
                break;
            case 'annotation':
                require_parameter(array('----subtype'));
                switch ($parms['--subtype']) {
                    case 'blast2go':
                        require_once __DIR__ . '/includes/importers/Importer_Annotations_Blast2Go.php';
                        $file_result = Importer_Annotations_Blast2Go::import($file);
                        break;
                    case 'interpro':
                        require_once __DIR__ . '/includes/importers/Importer_Annotations_Interpro.php';
                        $file_result = Importer_Annotations_Interpro::import($file);
                        break;
                    case 'repeatmasker':
                        require_once __DIR__ . '/includes/importers/Importer_Annotations_Repeatmasker.php';
                        $file_result = Importer_Annotations_Repeatmasker::import($file);
                        break;
                    default:
                        display_help();
                        die();
                        break;
                }
                break;
            case 'expressions':
                require_once __DIR__ . '/includes/importers/Importer_Expressions.php';
                require_parameter(array('--analysis_id', '--biomaterial_A_name', '--biomaterial_B_name'));
                $file_result = Importer_Expressions::import($file, $parms['--analysis_id'], $parms['--biomaterial_A_name'], $parms['--biomaterial_B_name']);
                break;
            default:
                display_help();
                die();
                break;
        }
    } catch (PDOException $e) {
        print "Error processing file $file: " . $e->getMessage() . "<br/>";
    }

    var_dump(array("File $file successfully processed.", $file_result));
}

die();
?>