#!env php
<?

function display_help_db() {
    echo <<<EOF
### transcript data importer ###
usage: 
    import.php --table <table> --action <action> [opts}
    
##
 tables:
##

biomaterial
    requires
        --action 
            can be one of:
            create
                same parameters as 'edit'
                requires
                     --name <string>
            edit
                requires
                     --name <string>
                optional
                    --description <string>
                        sets biomaterial description
                    --dbxref <string:'DBNAME:ACCESSION'>
            list
            show
                requires
                     --name <string>
            delete
                requires
                     --name <string>
analysis
    --action 
        can be one of:
        create
            requires
                --program <string>
                --programversion <string>
                --sourcename <string>      
        edit
            requires
                --id <int>
            optional
                --program <string>
                --programversion <string>
                --algorithm <string>
                --sourcename <string>
                --name <string>
                --timeexecuted <timestamp>
        list
            optional
                --program <string>
        show
        delete

assay
    --action 
        can be one of:
        create
            same parameters as 'edit'
            requires
                --operator_id <int:contact_id>
                --name <string>
        edit
            requires
                --name <string>
            optional
                --operator_id <int:contact_id>
                --description <string>
                --assaydate <timestamp>
                --dbxref <string:'DBNAME:ACCESSION'>
                --add-biomaterial <string:biomaterial_name>
                --delete-biomaterial <string:biomaterial_name>
        list
        show
            requires
                --name <string>
        delete
            requires
                --name <string>
                
acquisition
    --action 
        can be one of:
        create
            same parameters as 'edit'
            requires 
                --assay_id <int:assay_id>
                --name <string>
        edit
            requires
                --name <string>
            optional
                --assay_id <int:assay_id>
                --acquisitiondate <timestamp>
                --uri <string>
        list
        show
            requires
                 --name <string>
        delete
            requires
                 --name <string>
                     
quantification
    --action
        can be one of
        create
            same parameters as 'edit'
            requires
                --name <string>
                --acquisition_id <int:acquisition_id>
                --analsysis_id <int:analysis_id>
        edit
            requires
                --name <string>
            optional
                --acquisition_id <int:acquisition_id>
                --analsysis_id <int:analysis_id>
                --quantificationdate <timestamp>
                --uri <string>
        list
        show
            requires
                 --name <string>
        delete
            requires
                 --name <string>
                 
contact
    --action
        can be one of
        create
            same parameters as 'edit'
            requires
                --name <string>
        edit
            requires
                --name <string>
            optional
                --description <string>
        list
        show
            requires
                 --name <string>
        delete
            requires
                 --name <string>

EOF;
}

include __DIR__ . '/includes/init_cli.php';
global $parms;
init_cli();

if (isset($parms['--debug']))
    define('DEBUG', true);
else
    define('DEBUG', false);

if (isset($parms['--verbose']))
    define('VERBOSE', true);
else
    define('VERBOSE', false);

include __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/db_actions.php';

$tables = array('biomaterial', 'analysis', 'assay', 'acquisition', 'quantification', 'contact');
$actions = array('create', 'edit', 'list', 'show', 'delete');
if (!isset($parms['--table']) || !isset($parms['--action']) || !in_array($parms['--table'], $tables) || !in_array($parms['--action'], $actions)) {
    display_help_db();
    die();
}

define('ERR_MISSING_PARAMTER', 'missing parameter: %s');
define('ERR_NOT_YET_IMPLEMENTED', 'not yet implemented, try again later' . "\n");

function require_parameter($param_names) {
    global $parms;
    foreach ($param_names as $param_name)
        if (!isset($parms[$param_name])) {
            die(sprintf(ERR_MISSING_PARAMTER, $param_name));
        }
}

function confirm() {
    echo "are you sure you want to delete this row? all referencing rows in other tables will be deleted too, so be careful! (yes/no)\n> ";
    while (!in_array($line = trim(fgets(STDIN)), array('yes', 'no'))) {

        echo "enter one of (yes/no):\n> ";
    }
    return $line == 'yes';
}

switch ($parms['--table']) {
    case 'biomaterial':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name'));
                biomaterial_create($parms['--name'], $parms);
                biomaterial_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                biomaterial_edit($parms['--name'], $parms);
                biomaterial_show($parms['--name']);
                break;
            case 'list':
                biomaterial_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                biomaterial_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                biomaterial_show($parms['--name']);
                if (confirm())
                    biomaterial_delete($parms['--name']);
                break;
        }
        break;
    case 'analysis':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--program', '--programversion', '--sourcename'));
                $id = analysis_create($parms);
                analysis_show($id);
                break;
            case 'edit':
                require_parameter(array('--id'));
                analysis_edit($parms['--id'], $parms);
                break;
            case 'list':
                analysis_list();
                break;
            case 'show':
                require_parameter(array('--id'));
                analysis_show($parms['--id']);
                break;
            case 'delete':
                require_parameter(array('--id'));
                analysis_show($parms['--id']);
                if (confirm())
                    analysis_delete($parms['--id']);
                break;
        }
        break;
    case 'assay':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name', '--operator_id'));
                assay_create($parms['--name'], $parms);
                assay_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                assay_edit($parms['--name'], $parms);
                assay_show($parms['--name']);
                break;
            case 'list':
                assay_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                assay_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                assay_show($parms['--name']);
                if (confirm())
                    assay_delete($parms['--name']);
                break;
        }
        break;
    case 'acquisition':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name', '--assay_id'));
                acquisition_create($parms['--name'], $parms);
                acquisition_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                acquisition_edit($parms['--name'], $parms);
                acquisition_show($parms['--name']);
                break;
            case 'list':
                acquisition_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                acquisition_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                acquisition_show($parms['--name']);
                if (confirm())
                    acquisition_delete($parms['--name']);
                break;
        }
        break;
    case 'quantification':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name', '--acquisition_id', '--analysis_id'));
                quantification_create($parms['--name'], $parms);
                quantification_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                quantification_edit($parms['--name'], $parms);
                quantification_show($parms['--name']);
                break;
            case 'list':
                quantification_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                quantification_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                quantification_show($parms['--name']);
                if (confirm())
                    quantification_delete($parms['--name']);
                break;
        }
        break;
    case 'contact':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name'));
                contact_create($parms['--name'], $parms);
                contact_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                contact_edit($parms['--name'], $parms);
                contact_show($parms['--name']);
                break;
            case 'list':
                contact_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                contact_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                contact_show($parms['--name']);
                if (confirm())
                    contact_delete($parms['--name']);
                break;
        }
        break;
}
?>