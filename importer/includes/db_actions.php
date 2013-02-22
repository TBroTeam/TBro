<?php

define('S', 'string');
global $mappings;
$mappings = array(
    'biomaterial' => array(
        'list' => array('name' => S),
        'show' => array('name' => S, 'description' => S, 'dbxref_id' => 'dbxref')
    ),
    'analysis' => array(
        'list' => array('analysis_id' => S, 'program' => S, 'programversion' => S, 'sourcename' => S),
        'show' => array('analysis_id' => S, 'program' => S, 'programversion' => S, 'sourcename' => S, 'algorithm' => S, 'name' => S, 'timeexecuted' => S)
    ),
    'assay' => array(
        'list' => array('assay_id' => S, 'name' => S),
        'show' => array('assay_id' => S, 'name' => S, 'operator_id' => S, 'description' => S, 'assaydate' => S, 'dbxref_id' => 'dbxref')
    ),
    'acquisition' => array(
        'list' => array('acquisition_id' => S, 'name' => S),
        'show' => array('acquisition_id' => S, 'name' => S, 'assay_id' => S, 'acquisitiondate' => S, 'uri' => S)
    ),
    'quantification' => array(
        'list' => array('quantification_id' => S, 'name' => S),
        'show' => array('quantification_id' => S, 'name' => S, 'acquisition_id' => S, 'analysis_id' => S, 'quantificationdate' => S, 'uri' => S)
    ),
    'contact' => array(
        'list' => array('contact_id' => S, 'name' => S),
        'show' => array('contact_id' => S, 'name' => S, 'description' => S)
    ),
);

function quick_list($table, $filters = array()) {
    global $mappings;
    global $db;
    $select = '';
    foreach ($mappings[$table]['list'] as $key => $key_type) {
        switch ($key_type) {
            case S:
                $select .= (empty($select) ? '' : ', ') . $key;
                break;
        }
    }
    $filter = '';
    foreach ($filters as $key => $value) {
        $filter .= "AND $key LIKE :$key ";
    }
    $statement_select = $db->prepare(
            sprintf('SELECT %s FROM %s WHERE TRUE %s', $select, $table, $filter), array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL)
    );
    foreach ($filters as $key => $value) {
        $statement_select->bindValue($key, $value, PDO::PARAM_STR);
    }

    $statement_select->execute();
    $header_shown = false;
    while ($row = $statement_select->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        if (!$header_shown) {
            echo implode("\t", array_keys($row)) . "\n";
            $header_shown = true;
        }
        echo implode("\t", $row) . "\n";
    }
}

function quick_show($table, $uniquekey, $uniquevalue, &$header_shown = false) {
    global $mappings;
    global $db;
    $select = '';
    foreach ($mappings[$table]['show'] as $key => $key_type) {
        switch ($key_type) {
            case S:
                $select .= (empty($select) ? '' : ', ') . $key;
                break;
            case 'dbxref':
                $select .= (empty($select) ? '' : ', ') . "(SELECT concat((SELECT db.name FROM db WHERE db.db_id = dbxref.db_id),':',dbxref.accession,'(',dbxref.description,')') FROM dbxref WHERE dbxref.dbxref_id=$table.$key ) AS $key ";
                break;
        }
    }
    $statement_select = $db->prepare(
            sprintf('SELECT %s FROM %s WHERE %s=:unique', $select, $table, $uniquekey), array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL)
    );
    $statement_select->bindValue('unique', $uniquevalue, PDO::PARAM_STR);

    $statement_select->execute();
    while ($row = $statement_select->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        if (!$header_shown) {
            echo implode("\t", array_keys($row)) . "\n";
            $header_shown = true;
        }
        echo implode("\t", $row) . "\n";
    }
}

/**
 * 
 * @global PDO $db
 * @param string $query_sprintf like 'UPDATE biomaterial SET %1$s=:%1$s WHERE name=:unique'
 * @param array $keys like array('description', 'timeedited')
 * @param string $unique_value value for ':unique' PDO parameter in query
 * @param array $options like array('--description'=>'my description', '--timeedited'=>'2013-12-31 00:05'[, ...])
 */
function quick_edit_query($query_sprintf, $keys, $unique_value, $options) {
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
function quick_edit_dbxref($query_sprintf, $unique_value, $options) {
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

/**
 * 
 * @global PDO $db DB
 * @param string $table table to delete from
 * @param string $unique_key name of unique column
 * @param string $unique_value value of unique column
 */
function quick_delete($table, $unique_key, $unique_value) {
    global $db;
    $statement_delete_key = $db->prepare(sprintf('DELETE FROM %s WHERE %s=:unique', $table, $unique_key));
    $statement_delete_key->bindValue('unique', $unique_value, PDO::PARAM_STR);
    if ($statement_delete_key->execute()) {
        printf("%d line(s) affected\n", $statement_delete_key->rowCount());
    } else {
        printf("something went wrong:\n %s", print_r($statement_delete_key->errorInfo(), true));
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

function biomaterial_edit($name, $options) {
    quick_edit_query('UPDATE biomaterial SET %1$s=:%1$s WHERE name=:unique', array('description'), $name, $options);
    quick_edit_dbxref('UPDATE biomaterial SET %s WHERE name=:unique', $name, $options);
}

function biomaterial_show($name) {
    quick_show('biomaterial', 'name', $name);
}

function biomaterial_list() {
    quick_list('biomaterial');
}

function biomaterial_delete($name) {
    quick_delete('biomaterial', 'name', $name);
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
            sprintf('INSERT INTO analysis (program, programversion, sourcename) VALUES (:program, :programversion, :sourcename) RETURNING analysis_id')
    );
    $statement_create_analysis->bindValue('program', $options['--program'], PDO::PARAM_STR);
    $statement_create_analysis->bindValue('programversion', $options['--programversion'], PDO::PARAM_STR);
    $statement_create_analysis->bindValue('sourcename', $options['--sourcename'], PDO::PARAM_STR);
    $statement_create_analysis->execute();


    $id = $statement_create_analysis->fetchColumn();

    echo "\n###\nnew analysis inserted as $id\n###\n";

    #won't need to set these two again
    unset($options['--program']);
    unset($options['--programversion']);
    #set the rest of the variables
    analysis_edit($id, $options);

    return $id;
}

function analysis_edit($id, $options) {
    quick_edit_query(
            'UPDATE analysis SET %1$s=:%1$s WHERE analysis_id=:unique'
            , array('name', 'program', 'programversion', 'algorithm', 'sourcename', 'timeexecuted')
            , $id
            , $options
    );
}

function analysis_show($id) {
    quick_show('analysis', 'analysis_id', $id);
}

function analysis_list() {
    quick_list('analysis');
}

function analysis_delete($id) {
    quick_delete('analysis', 'analysis_id', $id);
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
    quick_edit_query('UPDATE assay SET %1$s=:%1$s WHERE name=:unique', array('operator_id', 'description', 'assaydate'), $name, $options);
    quick_edit_dbxref('UPDATE assay SET %s WHERE name=:unique', $name, $options);
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
        } else {
            $statement = $db->prepare(
                    sprintf('DELETE FROM assay_biomaterial WHERE assay_id=(%s) AND biomaterial_id=(%s)', 'SELECT assay_id FROM assay WHERE name=:assay_name LIMIT 1', 'SELECT biomaterial_id FROM biomaterial WHERE name=:biomaterial_name LIMIT 1')
            );
        }
        $statement->bindValue('assay_name', $name, PDO::PARAM_STR);
        $statement->bindValue('biomaterial_name', $value, PDO::PARAM_STR);
        $statement->execute();
    }
}

function assay_show($name) {
    global $db;

    quick_show('assay', 'name', $name);



    echo "\nassociated biomaterials:\n";
    $statement = $db->prepare(
            sprintf('SELECT (%s) FROM assay_biomaterial WHERE assay_id=(%s)', 'SELECT name FROM biomaterial WHERE biomaterial.biomaterial_id = assay_biomaterial.biomaterial_id', 'SELECT assay_id FROM assay WHERE name=:assay_name LIMIT 1')
    );
    $statement->bindValue('assay_name', $name, PDO::PARAM_STR);
    $statement->execute();
    $header_shown = false;
    while (($bioname = $statement->fetchColumn()) != false) {
        quick_show('biomaterial', 'name', $bioname, &$header_shown);
    }
}

function assay_list() {
    quick_list('assay');
}


function assay_delete($name) {
    quick_delete('assay', 'name', $name);
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
    quick_edit_query('UPDATE acquisition SET %1$s=:%1$s WHERE name=:unique', array('assay_id', 'acquisitiondate', 'uri'), $name, $options);
}

function acquisition_show($name) {
    quick_show('acquisition', 'name', $name);
}

function acquisition_list() {
    quick_list('acquisition');
}


function acquisition_delete($name) {
    quick_delete('acquisition', 'name', $name);
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
    quick_edit_query('UPDATE quantification SET %1$s=:%1$s WHERE name=:unique', array('acquisition_id', 'analysis_id', 'quantificationdate', 'uri'), $name, $options);
}

function quantification_show($name) {
    quick_show('quantification', 'name', $name);
}

function quantification_list() {
    quick_list('quantification');
}

function quantification_delete($name) {
    quick_delete('quantification', 'name', $name);
}

/*
  CREATE TABLE contact
  (
  contact_id serial NOT NULL,
  type_id integer, -- What type of contact is this?  E.g. "person", "lab".
 * name character varying(255) NOT NULL,
 * description character varying(255),
  CONSTRAINT contact_pkey PRIMARY KEY (contact_id ),
  CONSTRAINT contact_type_id_fkey FOREIGN KEY (type_id)
  REFERENCES cvterm (cvterm_id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT contact_c1 UNIQUE (name )
  )
 * 
 * flybase has only contact_id, description, name: no type_id o_O
 * => using CVTERM 1 (equals "null") as type_id here
 */

function contact_create($name, $options) {
    global $db;

    $statement_create_biomaterial = $db->prepare(
            sprintf('INSERT INTO contact (name, type_id) VALUES (:name, :type_id)')
    );
    $statement_create_biomaterial->bindValue('name', $name, PDO::PARAM_STR);
    $statement_create_biomaterial->bindValue('type_id', 1, PDO::PARAM_INT);
    $statement_create_biomaterial->execute();

    biomaterial_edit($name, $options);
}

function contact_edit($name, $options) {
    quick_edit_query('UPDATE contact SET %1$s=:%1$s WHERE name=:unique', array('description'), $name, $options);
}

function contact_show($name) {
    quick_show('contact', 'name', $name);
}

function contact_list() {
    quick_list('contact');
}

function contact_delete($name) {
    quick_delete('contact', 'name', $name);
}


?>