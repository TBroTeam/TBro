<?php

function help_quantification_actions() {
    echo <<<EOF
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
   requires
        --action 
            can be one of:
            create
                requires
                    --program <string>
                    --programversion <string>
                returns
                    id
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
   requires
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
aqcuisition
    requires
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
    requires
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
                     
EOF;
}

/**
 * 
 * @global PDO $db
 * @param string $query_sprintf like 'UPDATE biomaterial SET %1$s=:%1$s WHERE name=:unique'
 * @param array $keys like array('description', 'timeedited')
 * @param string $unique_value value for ':unique' PDO parameter in query
 * @param array $options like array('--description'=>'my description', '--timeedited'=>'2013-12-31 00:05'[, ...])
 */
function quickedit_query($query_sprintf, $keys, $unique_value, $options) {
    global $db;

    foreach ($keys as $key) {
        if (!isset($options["--$key"]))
            continue;
        $statement_update_key = $db->prepare(sprintf($query_sprintf, $key));
        $statement_update_key->bindValue('unique', $unique_value, PDO::PARAM_STR);
        $statement_update_key->bindValue($key, $options["--$key"], PDO::PARAM_STR);
        $statement_update_key->execute();
    }
}

/**
 * 
 * @global PDO $db
 * @param string $query_sprintf like UPDATE biomaterial SET %s WHERE name=:unique'
 * @param string $unique_value value for ':unique' PDO parameter in query
 * @param array $options like array('--dbxref'=>'GO:123'[, ...])
 */
function quickedit_dbxref($query_sprintf, $unique_value, $options) {
    global $db;

    if (isset($options["--dbxref"])) {
        list($dbname, $accession) = explode(':', $options["--dbxref"]);
        $statement_update_dbxref = $db->prepare(sprintf($query_sprintf, 'dbxref_id=get_or_insert_dbxref(:dbname, :accession)'));
        $statement_update_dbxref->bindValue('unique', $unique_value, PDO::PARAM_STR);
        $statement_update_dbxref->bindValue('dbname', $dbname, PDO::PARAM_STR);
        $statement_update_dbxref->bindValue('accession', $accession, PDO::PARAM_STR);
        $statement_update_dbxref->execute();
    }
}

/*
  CREATE TABLE biomaterial
  (
  biomaterial_id serial NOT NULL,
  taxon_id integer,
  biosourceprovider_id integer,
 * dbxref_id integer,
 * name text,
 * description text,
  CONSTRAINT biomaterial_pkey PRIMARY KEY (biomaterial_id ),
  CONSTRAINT biomaterial_dbxref_id_fkey FOREIGN KEY (dbxref_id)
  REFERENCES dbxref (dbxref_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT biomaterial_taxon_id_fkey FOREIGN KEY (taxon_id)
  REFERENCES organism (organism_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT biomaterial_c1 UNIQUE (name )
  )
 */

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
    quickedit_query('UPDATE biomaterial SET %1$s=:%1$s WHERE name=:unique', array('description'), $name, $options);
    quickedit_dbxref('UPDATE biomaterial SET %s WHERE name=:unique', $name, $options);
}

function biomaterial_delete() {
    
}

/*
  CREATE TABLE analysis
  (
 * analysis_id serial NOT NULL,
 * name character varying(255), -- A way of grouping analyses. This...
 * description text,
 * program character varying(255) NOT NULL, -- Program name, e.g. blastx, blastp, sim4, genscan.
 * programversion character varying(255) NOT NULL, -- Version description, e.g. TBLASTX 2.0MP-WashU [09-Nov-2000].
 * algorithm character varying(255), -- Algorithm name, e.g. blast.
 * sourcename character varying(255), -- Source name, e.g. cDNA, SwissProt.
  sourceversion character varying(255),
  sourceuri text, -- This is an optional, permanent URL or URI for the source of the  analysis. The idea is that someone could recreate the analysis directly by going to this URI and fetching the source data (e.g. the blast database, or the training model).
  timeexecuted timestamp without time zone NOT NULL DEFAULT now(),
  CONSTRAINT analysis_pkey PRIMARY KEY (analysis_id ),
  CONSTRAINT analysis_c1 UNIQUE (program , programversion , sourcename )
  )
 */

function analysis_create($options) {
    global $db;

    $statement_create_analysis = $db->prepare(
            sprintf('INSERT INTO analysis (program, programversion) VALUES (:program, :programversion) RETURNING analysis_id')
    );
    $statement_create_analysis->bindValue('program', $options['--program'], PDO::PARAM_STR);
    $statement_create_analysis->bindValue('programversion', $options['--programversion'], PDO::PARAM_STR);
    $statement_create_analysis->execute();


    $id = $statement_create_analysis->fetchColumn();

    echo "\n###\nnew analysis inserted as $id\n###\n";

    #won't need to set these two again
    unset($options['--program']);
    unset($options['--programversion']);
    #set the rest of the variables
    analysis_edit($id, $options);
}

function analysis_edit($id, $options) {
    quickedit_query(
            'UPDATE analysis SET %1$s=:%1$s WHERE analysis_id=:unique'
            , array('name', 'program', 'programversion', 'algorithm', 'sourcename', 'timeexecuted')
            , $id
            , $options
    );
}

/*
  CREATE TABLE assay
  (
  assay_id serial NOT NULL,
 * ! arraydesign_id integer NOT NULL,
  protocol_id integer,
 * assaydate timestamp without time zone DEFAULT now(),
  arrayidentifier text,
  arraybatchidentifier text,
 * operator_id integer NOT NULL,
 * dbxref_id integer,
 * name text,
 * description text,
  CONSTRAINT assay_pkey PRIMARY KEY (assay_id ),
  CONSTRAINT assay_arraydesign_id_fkey FOREIGN KEY (arraydesign_id)
  REFERENCES arraydesign (arraydesign_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT assay_dbxref_id_fkey FOREIGN KEY (dbxref_id)
  REFERENCES dbxref (dbxref_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT assay_protocol_id_fkey FOREIGN KEY (protocol_id)
  REFERENCES protocol (protocol_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT assay_c1 UNIQUE (name )
  )

  CREATE TABLE assay_biomaterial
  (
  assay_biomaterial_id serial NOT NULL,
 * assay_id integer NOT NULL,
 * biomaterial_id integer NOT NULL,
  channel_id integer,
  rank integer NOT NULL DEFAULT 0,
  CONSTRAINT assay_biomaterial_pkey PRIMARY KEY (assay_biomaterial_id ),
  CONSTRAINT assay_biomaterial_assay_id_fkey FOREIGN KEY (assay_id)
  REFERENCES assay (assay_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT assay_biomaterial_biomaterial_id_fkey FOREIGN KEY (biomaterial_id)
  REFERENCES biomaterial (biomaterial_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT assay_biomaterial_channel_id_fkey FOREIGN KEY (channel_id)
  REFERENCES channel (channel_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT assay_biomaterial_c1 UNIQUE (assay_id , biomaterial_id , channel_id , rank )
  )
 */

function assay_create($name, $options) {
    global $db;

    $statement_create_assay = $db->prepare(
            sprintf('INSERT INTO assay (name, arraydesign_id, operator_id) VALUES (:name, :arraydesign, :operator_id)')
    );
    $statement_create_assay->bindValue('name', $name, PDO::PARAM_STR);
    $statement_create_assay->bindValue('arraydesign', 1, PDO::PARAM_INT); # 'unknown'
    $statement_create_assay->bindValue('operator_id', $options['--operator_id'], PDO::PARAM_INT); # 'unknown'
    $statement_create_assay->execute();

    unset($options['--operator_id']);
    assay_edit($name, $options);
}

function assay_edit($name, $options) {
    quickedit_query('UPDATE assay SET %1$s=:%1$s WHERE name=:unique', array('operator_id', 'description', 'assaydate'), $name, $options);
    quickedit_dbxref('UPDATE assay SET %s WHERE name=:unique', $name, $options);
    assay_edit_biomaterial($name, $options);
}

function assay_edit_biomaterial($name, $options) {
    global $db;
    foreach ($options as $key => $value) {
        if ($key != '--add-biomaterial' && $key != '--delete-biomaterial')
            continue;
        if ($key == '--add-biomaterial') {
            $statement = $db->prepare(
                    sprintf('INSERT INTO assay_biomaterial (assay_id, biomaterial_id) VALUES ((%s),(%s))', 'SELECT assay_id FROM assay WHERE name=:assay_name LIMIT 1', 'SELECT biomaterial_id FROM biomaterial WHERE name=:biomaterial_name LIMIT 1')
            );
        } {
            $statement = $db->prepare(
                    sprintf('DELETE FROM assay_biomaterial WHERE assay_id=(%s) AND biomaterial_id=(%s) LIMIT 1', 'SELECT assay_id FROM assay WHERE name=:assay_name LIMIT 1', 'SELECT biomaterial_id FROM biomaterial WHERE name=:biomaterial_name LIMIT 1')
            );
        }
        $statement->bindValue('assay_name', $name, PDO::PARAM_STR);
        $statement->bindValue('biomaterial_name', $value, PDO::PARAM_STR);
        $statement->execute();
    }
}

/*
  CREATE TABLE acquisition
  (
  acquisition_id serial NOT NULL,
 * assay_id integer NOT NULL,
  protocol_id integer,
  channel_id integer,
 * acquisitiondate timestamp without time zone DEFAULT now(),
 * name text,
 * uri text,
  CONSTRAINT acquisition_pkey PRIMARY KEY (acquisition_id ),
  CONSTRAINT acquisition_assay_id_fkey FOREIGN KEY (assay_id)
  REFERENCES assay (assay_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT acquisition_channel_id_fkey FOREIGN KEY (channel_id)
  REFERENCES channel (channel_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT acquisition_protocol_id_fkey FOREIGN KEY (protocol_id)
  REFERENCES protocol (protocol_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT acquisition_c1 UNIQUE (name )
  )
 */

function acquisition_create($name, $options) {
    global $db;

    $statement_create_acquisition = $db->prepare(
            sprintf('INSERT INTO acquisition (name, assay_id) VALUES (:name, :assay_id)')
    );
    $statement_create_acquisition->bindValue('name', $name, PDO::PARAM_STR);
    $statement_create_acquisition->bindValue('assay_id', $options['--assay_id'], PDO::PARAM_STR);
    $statement_create_acquisition->execute();

    unset($options['--assay_id']);
    acquisition_edit($name, $options);
}

function acquisition_edit($name, $options) {
    quickedit_query('UPDATE acquisition SET %1$s=:%1$s WHERE name=:unique', array('assay_id', 'acquisitiondate', 'uri'), $name, $options);
}

/*
  CREATE TABLE quantification
  (
  quantification_id integer NOT NULL,
 * acquisition_id integer NOT NULL,
  operator_id integer,
  protocol_id integer,
 * analysis_id integer NOT NULL,
 * quantificationdate timestamp without time zone DEFAULT now(),
 * name text,
 * uri text,
  CONSTRAINT quantification_pkey PRIMARY KEY (quantification_id ),
  CONSTRAINT quantification_acquisition_id_fkey FOREIGN KEY (acquisition_id)
  REFERENCES acquisition (acquisition_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT quantification_analysis_id_fkey FOREIGN KEY (analysis_id)
  REFERENCES analysis (analysis_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT quantification_protocol_id_fkey FOREIGN KEY (protocol_id)
  REFERENCES protocol (protocol_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE SET NULL DEFERRABLE INITIALLY DEFERRED,
  CONSTRAINT quantification_c1 UNIQUE (name , analysis_id )
  )

 */

function quantification_create($name, $options) {
    global $db;

    $statement_create_acquisition = $db->prepare(
            sprintf('INSERT INTO quantification (name, acquisition_id, analysis_id) VALUES (:name, :acquisition_id, :analysis_id)')
    );
    $statement_create_acquisition->bindValue('name', $name, PDO::PARAM_STR);
    $statement_create_acquisition->bindValue('acquisition_id', $options['--acquisition_id'], PDO::PARAM_STR);
    $statement_create_acquisition->bindValue('analysis_id', $options['--analysis_id'], PDO::PARAM_STR);
    $statement_create_acquisition->execute();

    unset($options['--acquisition_id']);
    unset($options['--analysis_id']);
    quantification_edit($name, $options);
}

function quantification_edit($name, $options) {
    quickedit_query('UPDATE acquisition SET %1$s=:%1$s WHERE name=:unique', array('acquisition_id', 'analysis_id', 'quantificationdate', 'uri'), $name, $options);
}

?>