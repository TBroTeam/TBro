<?php

function help_quantification_actions() {
    echo <<<EOF
biomaterial
    requires
        --name 
            unique identifier
        --action 
            can be one of:
            create
                same parameters as 'edit'
            edit
                --description <string>
                    sets biomaterial description
                --dbxref <string:dbxref>
                    DB ref in the form DBNAME:ACCESSION
            show
            delete
        
analysis
   requires
        --action 
            can be one of:
            create
                requires
                    --program <string>
                    --programversion <string>
            edit
                requires
                    --id <int>
                optional
                    --program <string>
                    --programversion <string>
                    --name <string>
                    --timeexecuted <timestamp>
            list
                optional
                    --program <string>
            show
            delete

EOF;
}

function biomaterial_create($name, $options) {
    global $db;

    $statement_create_biomaterial = $db->prepare(
            sprintf('INSERT INTO biomaterial (name) VALUES (:name)')
    );
    $statement_create_biomaterial->bindValue('name', $name, PDO::PARAM_STR);
    $statement_create_biomaterial->execute();

    biomaterial_edit($name, $options);
}

function biomaterial_show() {
    
}

function biomaterial_edit($name, $options) {
    global $db;
    $keys = array('description');

    foreach ($keys as $key) {
        if (!isset($options["--$key"]))
            continue;
        $statement_update_biomaterial = $db->prepare("UPDATE biomaterial SET $key=:$key WHERE name=:name");
        $statement_update_biomaterial->bindValue('name', $name, PDO::PARAM_STR);
        $statement_update_biomaterial->bindValue($key, $options["--$key"], PDO::PARAM_STR);
        $statement_update_biomaterial->execute();
    }
    if (isset($options["--dbxref"])) {
        list($dbname, $accession) = explode(':', $options["--dbxref"]);
        $statement_update_biomaterial = $db->prepare("UPDATE biomaterial SET dbxref=get_or_insert_dbxref(:dbname, :accession) WHERE name=:name");
        $statement_update_biomaterial->bindValue('name', $name, PDO::PARAM_STR);
        $statement_update_biomaterial->bindValue('dbname', $dbname, PDO::PARAM_STR);
        $statement_update_biomaterial->bindValue('accession', $accession, PDO::PARAM_STR);
        $statement_update_biomaterial->execute();
    }
}

function biomaterial_delete() {
    
}

function analysis_create($options) {
    global $db;

    $statement_create_analysis = $db->prepare(
            sprintf('INSERT INTO analysis (program, programversion) VALUES (:program, :programversion) RETURNING analysis_id')
    );
    $statement_create_analysis->bindValue('program', $options['--program'], PDO::PARAM_STR);
    $statement_create_analysis->bindValue('programversion', $options['--programversion'], PDO::PARAM_STR);
    $statement_create_analysis->execute();
    unset($options['--program']);
    unset($options['--programversion']);

    $id = $statement_create_analysis->fetchColumn();
    
    echo "\n###\nnew analysis inserted as $id\n###\n";
    
    analysis_edit($id, $options);
}

function analysis_edit($id, $options) {
    global $db;
    $keys = array('name', 'program', 'programversion', 'timeexecuted');

    foreach ($keys as $key) {
        if (!isset($options["--$key"]))
            continue;
        $statement_update_analysis = $db->prepare("UPDATE analysis SET $key=:$key WHERE analysis_id=:id");
        $statement_update_analysis->bindValue('id', $id, PDO::PARAM_INT);
        $statement_update_analysis->bindValue($key, $options["--$key"], PDO::PARAM_STR);
        $statement_update_analysis->execute();
    }
}

/*
  analysis Structure
  FK	 Name	 Type	 Description
  analysis_id	 serial	 PRIMARY KEY
  name	 character varying(255)		A way of grouping analyses. This should be a handy short identifier that can help people find an analysis they want. For instance "tRNAscan", "cDNA", "FlyPep", "SwissProt", and it should not be assumed to be unique. For instance, there may be lots of separate analyses done against a cDNA database.
  description	 text
  program	 character varying(255)	 UNIQUE#1 NOT NULL 	Program name, e.g. blastx, blastp, sim4, genscan.
  programversion	 character varying(255)	 UNIQUE#1 NOT NULL 	Version description, e.g. TBLASTX 2.0MP-WashU [09-Nov-2000].
  algorithm	 character varying(255)		Algorithm name, e.g. blast.
  sourcename	 character varying(255)	 UNIQUE#1 	Source name, e.g. cDNA, SwissProt.
  sourceversion	 character varying(255)
  sourceuri	 text		This is an optional, permanent URL or URI for the source of the analysis. The idea is that someone could recreate the analysis directly by going to this URI and fetching the source data (e.g. the blast database, or the training model).
  timeexecuted	 timestamp without time zone	 NOT NULL DEFAULT ('now'::text)::timestamp(6) with time zone
 */

/**
 * internally edits tables
 * quantification, acquisition, assay, assay_biomaterial
 */
function quantification_create() {
    "INSERT INTO quantification (name, )";
}

function quantification_edit() {
    
}

/*
 * necessary
 * name (shared with quantification, acquisition, assay.)
 * date  (shared with quantification, acquisition, assay.)
 * contact  (shared with quantification, assay.)
 * biomaterial
 * analysis
 * 
  quantification Structure
  FK	 Name	 Type	 Description
  quantification_id	 serial	 PRIMARY KEY
  quantificationdate	 timestamp without time zone	 DEFAULT ('now'::text)::timestamp(6) with time zone
  name	 text	 UNIQUE#1
  uri	 text
  acquisition	acquisition_id	 integer	 NOT NULL
  analysis	analysis_id	 integer	 UNIQUE#1 NOT NULL
  contact	operator_id	 integer
  protocol	protocol_id	 integer


  acquisition Structure
  FK	 Name	 Type	 Description
  acquisition_id	 serial	 PRIMARY KEY
  acquisitiondate	 timestamp without time zone	 DEFAULT ('now'::text)::timestamp(6) with time zone
  name	 text	 UNIQUE
  uri	 text
  assay	assay_id	 integer	 NOT NULL
  channel	channel_id	 integer
  protocol	protocol_id	 integer

  assay Structure
  FK	 Name	 Type	 Description
  assay_id	 serial	 PRIMARY KEY
  assaydate	 timestamp without time zone	 DEFAULT ('now'::text)::timestamp(6) with time zone
  arrayidentifier	 text
  arraybatchidentifier	 text
  name	 text	 UNIQUE
  description	 text
  arraydesign	arraydesign_id	 integer	 NOT NULL
  contact	operator_id	 integer	 NOT NULL
  dbxref	dbxref_id	 integer
  protocol	protocol_id	 integer

  assay_biomaterial Structure
  FK	 Name	 Type	 Description
  assay_biomaterial_id	 serial	 PRIMARY KEY
  rank	 integer	 UNIQUE#1 NOT NULL
  assay	assay_id	 integer	 UNIQUE#1 NOT NULL
  biomaterial	biomaterial_id	 integer	 UNIQUE#1 NOT NULL
  channel	channel_id	 integer	 UNIQUE#1
 */
?>