<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Analysis extends AbstractTable {

    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'AnalysisId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'analysis id'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'name'
            ),
            'description' => array(
                'colname' => 'Description',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'description'
            ),
            'program' => array(
                'colname' => 'Program',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => "Program name, e.g. blastx, blastp, sim4, genscan. \nNote: The combination of program, programversion and sourcename has to be unique."
            ),
            'programversion' => array(
                'colname' => 'Programversion',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'Version description, e.g. TBLASTX 2.0MP-WashU [09-Nov-2000].'
            ),
            'algorithm' => array(
                'colname' => 'Algorithm',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'Algorithm name, e.g. blast.'
            ),
            'sourcename' => array(
                'colname' => 'Sourcename',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'Source name, e.g. cDNA, SwissProt.'
            ),
            'sourceversion' => array(
                'colname' => 'Sourceversion',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'Source version.'
            ),
            'sourceuri' => array(
                'colname' => 'Sourceuri',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'This is an optional, permanent URL or URI for the source of the  analysis. The idea is that someone could recreate the analysis directly by going to this URI and fetching the source data (e.g. the blast database, or the training model).'
            ),
            'timeexecuted' => array(
                'colname' => 'Timeexecuted',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'time of execution'
            ),
        );
    }

    public static function CLI_commandDescription() {
        return 'Manipulate analyses.';
    }

    public static function CLI_commandName() {
        return 'analysis';
    }

    public static function CLI_longHelp() {

    }

    public static function getSubCommands() {
        return array('insert', 'update', 'delete', 'details', 'list');
    }

    public static function getPropelClass() {
        return '\\cli_db\\propel\\Analysis';
    }
    
}

?>
