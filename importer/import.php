#!env php
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
        requires full import of: sequence
        requires
            --quantification_id <int>
            --biomaterial_name <string>
    annotation
        requires full import of: sequence
        requires
            --subtype <string>
            one of
                blast2go
                interpro

options:
    --verbose
        will give verbose output
    --debug
        will give even more ouptut, try to continue on error

EOF;
}

$valid_types = array('map', 'sequence', 'quantification', 'annotation');
$valid_annotation_types = array('blast2go', 'interpro');

include __DIR__ . '/includes/init_cli.php';
global $parms;
init_cli();

if (isset($parms['--help'])) {
    display_help();
    die();
}

if (!isset($parms['--type']) || !in_array($parms['--type'], $valid_types) || !isset($parms['--file']) || $parms['--file'] === true) {
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

define('ERRCODE_ILLEGAL_FILE_FORMAT', -1);
define('ERRCODE_TRANSACTION_NOT_COMPLETED', -1);

if (isset($parms['--debug']))
    define('DEBUG', true);
else
    define('DEBUG', false);

if (isset($parms['--verbose']))
    define('VERBOSE', true);
else
    define('VERBOSE', false);

foreach ($parms['--file'] as $file) {
    try {
        switch ($parms['--type']) {
            case 'map':
                require_once __DIR__ . '/includes/importers/Importer_Map.php';
                Importer_Map::import($file);
                break;
            case 'sequence':
                require_once __DIR__ . '/includes/importers/Importer_Sequences.php';
                Importer_Sequences::import($file);
                break;
            case 'quantification':
                require_parameter(array('--quantification_id', '--biomaterial_name'));
                require_once __DIR__ . '/includes/importers/Importer_Quantifications.php';
                Importer_Quantifications::import($file, $parms['--quantification_id'], $parms['--biomaterial_name']);
                break;
            case 'annotation':
                if (!in_array($parms['--subtype'], $valid_annotation_types)) {
                    display_help();
                    die();
                }
                switch ($parms['--subtype']) {
                    case 'blast2go':
                        require_once __DIR__ . '/includes/importers/Importer_Annotations_Blast2Go.php';
                        Importer_Annotations_Blast2Go::import($file);
                        break;
                    case 'interpro':
                        require_once __DIR__ . '/includes/importers/Importer_Annotations_Interpro.php';
                        Importer_Annotations_Interpro::import($file);
                        break;
                    case 'repeatmasker':
                        require_once __DIR__ . '/includes/importers/Importer_Annotations_Repeatmasker.php';
                        Importer_Annotations_Repeatmasker::import($file);
                        break;
                }
                break;
        }
    } catch (PDOException $e) {
        print "Error processing file $file: " . $e->getMessage() . "<br/>";
    }
}

die();
?>