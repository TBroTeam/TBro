#!/usr/bin/php
<?php
define('INC', __DIR__ . '/../includes/');

echo implode(' ', $argv) . "\n";
$help = <<<EOF
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
                    --link-parent <string:biomaterial_name>
                    --unlink-parent <string:biomaterial_name>
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
                --link-biomaterial <string:biomaterial_name>
                --unlink-biomaterial <string:biomaterial_name>
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

require_once INC . '/init_cli.php';
global $parms;
init_cli();

if (!defined("DEBUG")) {
    if (isset($parms['--debug']))
        define('DEBUG', true);
    else
        define('DEBUG', false);
}
if (!defined("VERBOSE")) {
    if (isset($parms['--verbose']))
        define('VERBOSE', true);
    else
        define('VERBOSE', false);
}
require_once INC . '/DB_Actions.php';

$tables = array('biomaterial', 'analysis', 'assay', 'acquisition', 'quantification', 'contact');
$actions = array('create', 'edit', 'list', 'show', 'delete');
if (!isset($parms['--table']) || !isset($parms['--action']) || !in_array($parms['--table'],
                $tables) || !in_array($parms['--action'], $actions)) {
    die($help);
}


if (!defined('ERR_NOT_YET_IMPLEMENTED')) {
    define('ERR_NOT_YET_IMPLEMENTED',
            'not yet implemented, try again later' . "\n");
}




switch ($parms['--table']) {
    case 'biomaterial':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name'));
                DB_Actions::biomaterial_create($parms['--name'], $parms);
                DB_Actions::biomaterial_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                DB_Actions::biomaterial_edit($parms['--name'], $parms);
                DB_Actions::biomaterial_show($parms['--name']);
                break;
            case 'list':
                DB_Actions::biomaterial_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                DB_Actions::biomaterial_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                DB_Actions::biomaterial_show($parms['--name']);
                if (confirm())
                    DB_Actions::biomaterial_delete($parms['--name']);
                break;
        }
        break;
    case 'analysis':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--program', '--programversion', '--sourcename'));
                $id = DB_Actions::analysis_create($parms);
                DB_Actions::analysis_show($id);
                break;
            case 'edit':
                require_parameter(array('--id'));
                DB_Actions::analysis_edit($parms['--id'], $parms);
                break;
            case 'list':
                DB_Actions::analysis_list();
                break;
            case 'show':
                require_parameter(array('--id'));
                DB_Actions::analysis_show($parms['--id']);
                break;
            case 'delete':
                require_parameter(array('--id'));
                DB_Actions::analysis_show($parms['--id']);
                if (confirm())
                    DB_Actions::analysis_delete($parms['--id']);
                break;
        }
        break;
    case 'assay':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name', '--operator_id'));
                DB_Actions::assay_create($parms['--name'], $parms);
                DB_Actions::assay_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                DB_Actions::assay_edit($parms['--name'], $parms);
                DB_Actions::assay_show($parms['--name']);
                break;
            case 'list':
                DB_Actions::assay_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                DB_Actions::assay_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                DB_Actions::assay_show($parms['--name']);
                if (confirm())
                    DB_Actions::assay_delete($parms['--name']);
                break;
        }
        break;
    case 'acquisition':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name', '--assay_id'));
                DB_Actions::acquisition_create($parms['--name'], $parms);
                DB_Actions::acquisition_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                DB_Actions::acquisition_edit($parms['--name'], $parms);
                DB_Actions::acquisition_show($parms['--name']);
                break;
            case 'list':
                DB_Actions::acquisition_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                DB_Actions::acquisition_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                DB_Actions::acquisition_show($parms['--name']);
                if (confirm())
                    DB_Actions::acquisition_delete($parms['--name']);
                break;
        }
        break;
    case 'quantification':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name', '--acquisition_id', '--analysis_id'));
                DB_Actions::quantification_create($parms['--name'], $parms);
                DB_Actions::quantification_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                DB_Actions::quantification_edit($parms['--name'], $parms);
                DB_Actions::quantification_show($parms['--name']);
                break;
            case 'list':
                DB_Actions::quantification_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                DB_Actions::quantification_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                DB_Actions::quantification_show($parms['--name']);
                if (confirm())
                    DB_Actions::quantification_delete($parms['--name']);
                break;
        }
        break;
    case 'contact':
        switch ($parms['--action']) {
            case 'create':
                require_parameter(array('--name'));
                DB_Actions::contact_create($parms['--name'], $parms);
                DB_Actions::contact_show($parms['--name']);
                break;
            case 'edit':
                require_parameter(array('--name'));
                DB_Actions::contact_edit($parms['--name'], $parms);
                DB_Actions::contact_show($parms['--name']);
                break;
            case 'list':
                DB_Actions::contact_list();
                break;
            case 'show':
                require_parameter(array('--name'));
                DB_Actions::contact_show($parms['--name']);
                break;
            case 'delete':
                require_parameter(array('--name'));
                DB_Actions::contact_show($parms['--name']);
                if (confirm())
                    DB_Actions::contact_delete($parms['--name']);
                break;
        }
        break;
}
?>