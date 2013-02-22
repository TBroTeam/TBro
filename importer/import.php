#!env php
<?
## config
define('ASSEMBLY_PREFIX', '1.01_');
define('DB_ORGANISM_ID', '13');
global $dbrefx_versions;
#versions of databases for interpro import
$dbrefx_versions = array('HMMPIR' => '1.0');


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

include __DIR__.'/includes/init_cli.php';
global $parms;
init_cli();

if (isset($parms['--help'])) {
    display_help();
    die();
}

if (!isset($parms['--type']) || !in_array($parms['--type'], $valid_types) || !isset($parms['--file']) || $parms['--file']===true) {
    die("wrong parameter usage, call with --help for more information\n");
}

if (is_string($parms['--file'])){
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

include __DIR__.'/includes/db.php';

foreach ($parms['--file'] as $file) {
    try {
        switch ($parms['--type']) {
            case 'map':
                require_once __DIR__ . '/includes/import_map.php';
                import_map($file);
                break;
            case 'sequence':
                require_once __DIR__ . '/includes/import_sequences.php';
                import_sequences($file);
                break;
            case 'quantification':
                require_parameter(array('--quantification_id', '--biomaterial_name'));
                require_once __DIR__ . '/includes/import_counts.php';
                import_quantification_results($file, $parms['--quantification_id'], $parms['--biomaterial_name']);
                break;
            case 'annotation':
                if (!in_array($parms['--subtype'], $valid_annotation_types)) {
                    display_help();
                    die();
                }
                require_once __DIR__ . '/includes/import_annotations.php';
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
    } catch (PDOException $e) {
        print "Error processing file $file: " . $e->getMessage() . "<br/>";
    }
}

die();
?>