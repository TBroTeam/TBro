#!env php
<?

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
    annotation
        requires full import of: sequence
        requires option --subtype

options:
    --subtype
        required for --type annotation
        one of
            blast2go
            interpro
    --verbose
        will give verbose output
    --debug
        will give even more ouptut, try to continue on error

EOF;
}

$arguments_with_parameter = array('--type', '--subtype');
$arguments_with_multi_params = array('--file');
$valid_types = array('map', 'sequence', 'quantification', 'annotation');
$valid_annotation_types = array('blast2go', 'interpro');
$parms = array();

for ($i = 1; $i < $argc; $i++) {
    if (in_array($argv[$i], $arguments_with_parameter)) {
        $parms[$argv[$i]] = $argv[++$i];
    } else if (in_array($argv[$i], $arguments_with_multi_params)) {
        $parmlist = array();
        $_i = $i;

        while (isset($argv[$i + 1]) && strpos($argv[$i + 1], '--') !== 0) {
            $parmlist[] = $argv[++$i];
        }

        $parms[$argv[$_i]] = $parmlist;
    } else {
        $parms[$argv[$i]] = true;
    }
}

if (isset($parms['--help'])) {
    display_help();
    die();
}

if (!isset($parms['--type']) || !in_array($parms['--type'], $valid_types) || !isset($parms['--file'])) {
    die("wrong parameter usage, call with --help for more information\n");
}

foreach ($parms['--file'] as $file) {
    if (!file_exists($file)) {
        die ("file $file does not exist!\n");
    }
}





define('ASSEMBLY_PREFIX', '1.01_');
define('DB_ORGANISM_ID', '13');
global $dbrefx_versions;
$dbrefx_versions = array('HMMPIR' => '1.0');


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

try {
    global $db;
    if (VERBOSE || DEBUG) {
        include './loggedPDO.php';
        $db = new LoggedPDO('pgsql:host=wbbi155;dbname=dionaea_transcript_db_dev;user=s202139;password=s202139');
        DEBUG && $db->logLevel = LoggedPDO::LOGLEVEL_LONG;
        VERBOSE && $db->logLevel = LoggedPDO::LOGLEVEL_SHORT;
    } else {
        $db = new PDO('pgsql:host=wbbi155;dbname=dionaea_transcript_db_dev;user=s202139;password=s202139');
    }
    #usually stop execution on DB error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #in debug mode, try to continue and output warning
    DEBUG && $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

foreach ($parms['--file'] as $file) {
    switch ($parms['--type']) {
        case 'map':
            require_once __DIR__.'/includes/import_map.php';
            import_map($file);
            break;
        case 'sequence':
            require_once __DIR__.'/includes/import_sequences.php';
            import_sequences($file);
            break;
        case 'quantification':
            require_once __DIR__.'/includes/import_counts.php';
            import_quantification_results($file, 1);
            break;
        case 'annotation':
            if (!in_array($parms['--subtype'], $valid_annotation_types)) {
                display_help();
                die();
            }
            require_once __DIR__.'/includes/import_annotations.php';
            switch ($parms['--subtype']) {
                case 'blast2go':
                    import_annot_blast2go($file);
                    break;
                case 'interpro':
                    import_annot_interpro($file);
                    break;
            }
            break;
    }
}

die();







?>