<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/constants.php';

class DB_Actions {

    static $mappings = array(
        'biomaterial' => array(
            'list' => array('name' => 'string'),
            'show' => array('name' => 'string', 'description' => 'string', 'dbxref_id' => 'dbxref')
        ),
        'analysis' => array(
            'list' => array('analysis_id' => 'string', 'program' => 'string', 'programversion' => 'string', 'sourcename' => 'string'),
            'show' => array('analysis_id' => 'string', 'program' => 'string', 'programversion' => 'string', 'sourcename' => 'string', 'algorithm' => 'string', 'name' => 'string', 'timeexecuted' => 'string')
        ),
        'assay' => array(
            'list' => array('assay_id' => 'string', 'name' => 'string'),
            'show' => array('assay_id' => 'string', 'name' => 'string', 'operator_id' => 'string', 'description' => 'string', 'assaydate' => 'string', 'dbxref_id' => 'dbxref')
        ),
        'acquisition' => array(
            'list' => array('acquisition_id' => 'string', 'name' => 'string'),
            'show' => array('acquisition_id' => 'string', 'name' => 'string', 'assay_id' => 'string', 'acquisitiondate' => 'string', 'uri' => 'string')
        ),
        'quantification' => array(
            'list' => array('quantification_id' => 'string', 'name' => 'string'),
            'show' => array('quantification_id' => 'string', 'name' => 'string', 'acquisition_id' => 'string', 'analysis_id' => 'string', 'quantificationdate' => 'string', 'uri' => 'string')
        ),
        'contact' => array(
            'list' => array('contact_id' => 'string', 'name' => 'string'),
            'show' => array('contact_id' => 'string', 'name' => 'string', 'description' => 'string')
        ),
    );

    static function quickList($table, &$header_shown = false, $silent = false) {
        global $db;
        $select = '';
        foreach (self::$mappings[$table]['list'] as $key => $key_type) {
            switch ($key_type) {
                case 'string':
                    $select .= (empty($select) ? '' : ', ') . $key;
                    break;
            }
        }
        $statement_select = $db->prepare(
                sprintf('SELECT %s FROM %s', $select, $table), array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL)
        );


        $statement_select->execute();
        $ret = array();
        while ($row = $statement_select->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            if (!$header_shown && !$silent) {
                echo implode("\t", array_keys($row)) . "\n";
                $header_shown = true;
            }
            if (!$silent)
                echo implode("\t", $row) . "\n";
            $ret[] = $row;
        }
        return $ret;
    }

    static function quickShow($table, $uniquekey, $uniquevalue, &$header_shown = false, $silent = false) {
        global $db;
        $select = '';
        foreach (self::$mappings[$table]['show'] as $key => $key_type) {
            switch ($key_type) {
                case 'string':
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
        $row = $statement_select->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
        if ($row) {
            if (!$header_shown && !$silent) {
                echo implode("\t", array_keys($row)) . "\n";
                $header_shown = true;
            }
            if (!$silent)
                echo implode("\t", $row) . "\n";
        }
        return $row;
    }

    /**
     * @global PDO $db
     * @param string $query_sprintf like 'UPDATE biomaterial SET %1$s=:%1$s WHERE name=:unique'
     * @param array $keys like array('description', 'timeedited')
     * @param string $unique_value value for ':unique' PDO parameter in query
     * @param array $options like array('--description'=>'my description', '--timeedited'=>'2013-12-31 00:05'[, ...])
     */
    static function quickEdit($query_sprintf, $keys, $unique_value, $options) {
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
    static function quickEditDbxref($query_sprintf, $unique_value, $options) {
        global $db;

        if (isset($options["--dbxref"])) {
            list($dbname, $accession) = explode(':', $options["--dbxref"]);
            var_dump($dbname, $accession);
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
    static function quick_delete($table, $unique_key, $unique_value) {
        global $db;
        $statement_delete_key = $db->prepare(sprintf('DELETE FROM %s WHERE %s=:unique', $table, $unique_key));
        $statement_delete_key->bindValue('unique', $unique_value, PDO::PARAM_STR);
        if ($statement_delete_key->execute()) {
            printf("%d line(s) affected\n", $statement_delete_key->rowCount());
        } else {
            printf("something went wrong:\n %s", print_r($statement_delete_key->errorInfo(), true));
        }
        return $statement_delete_key->rowCount();
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

    static function biomaterial_create($name, $options) {
        global $db;

        $statement_create_biomaterial = $db->prepare('INSERT INTO biomaterial (name) VALUES (:name)'
        );
        $statement_create_biomaterial->bindValue('name', $name, PDO::PARAM_STR);
        $statement_create_biomaterial->execute();

        self::biomaterial_edit($name, $options);
    }

    static function biomaterial_setParent($name, $options) {
        global $db;

        foreach ($options as $key => $value) {
            if ($key != '--link-parent' && $key != '--unlink-parent')
                continue;
            if ($key == '--link-parent') {
                $statement_mod_parent = $db->prepare(
                        sprintf('INSERT INTO biomaterial_relationship (subject_id, type_id, object_id) VALUES ((%s), :type, (%s))'
                                , 'SELECT biomaterial_id FROM biomaterial WHERE name=:subject LIMIT 1'
                                , 'SELECT biomaterial_id FROM biomaterial WHERE name=:object LIMIT 1'
                        )
                );
            } else if ($key == '--unlink-parent') {
                $statement_mod_parent = $db->prepare(
                        sprintf('DELETE FROM  biomaterial_relationship WHERE subject_id=(%s) AND type_id=:type AND object_id=(%s)'
                                , 'SELECT biomaterial_id FROM biomaterial WHERE name=:subject LIMIT 1'
                                , 'SELECT biomaterial_id FROM biomaterial WHERE name=:object LIMIT 1'
                        )
                );
            }

            $statement_mod_parent->bindValue('subject', $name, PDO::PARAM_STR);
            $statement_mod_parent->bindValue('type', CV_BIOMATERIAL_ISA, PDO::PARAM_STR);
            $statement_mod_parent->bindValue('object', $value, PDO::PARAM_STR);
            $statement_mod_parent->execute();
        }
    }

    static function biomaterial_edit($name, $options) {
        self::quickEdit('UPDATE biomaterial SET %1$s=:%1$s WHERE name=:unique', array('description'), $name, $options);
        self::quickEditDbxref('UPDATE biomaterial SET %s WHERE name=:unique', $name, $options);
        self::biomaterial_setParent($name, $options);
    }

    static function biomaterial_show($name) {
        global $db;
        $result = self::quickShow('biomaterial', 'name', $name);
        $result['parents'] = array();


        $statement = $db->prepare(
                sprintf('SELECT (%s) AS subject, (%s) AS relationship, (%s)  AS object FROM biomaterial_relationship WHERE subject_id = (%s)'
                        , 'SELECT name FROM biomaterial WHERE biomaterial_id=subject_id'
                        , 'SELECT name FROM cvterm WHERE cvterm.cvterm_id=type_id'
                        , 'SELECT name FROM biomaterial WHERE biomaterial_id=object_id'
                        , 'SELECT biomaterial_id FROM biomaterial WHERE name=:subject_name')
        );
        $statement->bindValue('subject_name', $name, PDO::PARAM_STR);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
            $result['parents'][] = $row;
        if (count($result['parents']) > 0) {
            $header = false;
            echo "\nassociated biomaterials:\n";
            foreach ($result['parents'] as $row) {
                if (!$header) {
                    echo implode("\t", array_keys($row)) . "\n";
                }
                echo implode("\t", $row) . "\n";
            }
        }
        return $result;
    }

    static function biomaterial_list() {
        return self::quickList('biomaterial');
    }

    static function biomaterial_delete($name) {
        return self::quick_delete('biomaterial', 'name', $name, true);
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

    static function analysis_create($options) {
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
        self::analysis_edit($id, $options);

        return $id;
    }

    static function analysis_edit($id, $options) {
        self::quickEdit(
                'UPDATE analysis SET %1$s=:%1$s WHERE analysis_id=:unique'
                , array('name', 'program', 'programversion', 'algorithm', 'sourcename', 'timeexecuted')
                , $id
                , $options
        );
    }

    static function analysis_show($id) {
        return self::quickShow('analysis', 'analysis_id', $id);
    }

    static function analysis_list() {
        return self::quickList('analysis');
    }

    static function analysis_delete($id) {
        return self::quick_delete('analysis', 'analysis_id', $id);
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

    static

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
        self::assay_edit($name, $options);
    }

    static function assay_edit($name, $options) {
        self::quickEdit('UPDATE assay SET %1$s=:%1$s WHERE name=:unique', array('operator_id', 'description', 'assaydate'), $name, $options);
        self::quickEditDbxref('UPDATE assay SET %s WHERE name=:unique', $name, $options);
        self::assay_edit_biomaterial($name, $options);
    }

    static function assay_edit_biomaterial($name, $options) {
        global $db;
        foreach ($options as $key => $value) {
            if ($key != '--link-biomaterial' && $key != '--unlink-biomaterial')
                continue;
            if ($key == '--link-biomaterial') {
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

    static

    function assay_show($name) {
        global $db;

        $ret = array('biomaterial' => array());

        $ret['assay'] = self::quickShow('assay', 'name', $name);



        echo "\nassociated biomaterials:\n";
        $statement = $db->prepare(
                sprintf('SELECT (%s) FROM assay_biomaterial WHERE assay_id=(%s)', 'SELECT name FROM biomaterial WHERE biomaterial.biomaterial_id = assay_biomaterial.biomaterial_id', 'SELECT assay_id FROM assay WHERE name=:assay_name LIMIT 1')
        );
        $statement->bindValue('assay_name', $name, PDO::PARAM_STR);
        $statement->execute();
        $header_shown = false;
        while (($bioname = $statement->fetchColumn()) != false) {
            $ret['biomaterial'][] = self::quickShow('biomaterial', 'name', $bioname, $header_shown);
        }
        return $ret;
    }

    static function assay_list() {
        return self::quickList('assay');
    }

    static function assay_delete($name) {
        return self::quick_delete('assay', 'name', $name);
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

    static function acquisition_create($name, $options) {
        global $db;

        $statement_create_acquisition = $db->prepare(
                sprintf('INSERT INTO acquisition (name, assay_id) VALUES (:name, :assay_id)')
        );
        $statement_create_acquisition->bindValue('name', $name, PDO::PARAM_STR);
        $statement_create_acquisition->bindValue('assay_id', $options['--assay_id'], PDO::PARAM_STR);
        $statement_create_acquisition->execute();

        unset($options['--assay_id']);
        self::acquisition_edit($name, $options);
    }

    static function acquisition_edit($name, $options) {
        self::quickEdit('UPDATE acquisition SET %1$s=:%1$s WHERE name=:unique', array('assay_id', 'acquisitiondate', 'uri'), $name, $options);
    }

    static function acquisition_show($name) {
        return self::quickShow('acquisition', 'name', $name);
    }

    static function acquisition_list() {
        return self::quickList('acquisition');
    }

    static function acquisition_delete($name) {
        return self::quick_delete('acquisition', 'name', $name);
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

    static function quantification_create($name, $options) {
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
        self::quantification_edit($name, $options);
    }

    static function quantification_edit($name, $options) {
        self::quickEdit('UPDATE quantification SET %1$s=:%1$s WHERE name=:unique', array('acquisition_id', 'analysis_id', 'quantificationdate', 'uri'), $name, $options);
    }

    static function quantification_show($name) {
        return self::quickShow('quantification', 'name', $name);
    }

    static function quantification_list() {
        return self::quickList('quantification');
    }

    static function quantification_delete($name) {
        return self::quick_delete('quantification', 'name', $name);
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

    static function contact_create($name, $options) {
        global $db;

        $statement_create_biomaterial = $db->prepare(
                sprintf('INSERT INTO contact (name, type_id) VALUES (:name, :type_id)')
        );
        $statement_create_biomaterial->bindValue('name', $name, PDO::PARAM_STR);
        $statement_create_biomaterial->bindValue('type_id', 1, PDO::PARAM_INT);
        $statement_create_biomaterial->execute();

        self::contact_edit($name, $options);
    }

    static function contact_edit($name, $options) {
        self::quickEdit('UPDATE contact SET %1$s=:%1$s WHERE name=:unique', array('description'), $name, $options);
    }

    static function contact_show($name) {
        return self::quickShow('contact', 'name', $name);
    }

    static function contact_list() {
        return self::quickList('contact');
    }

    static function contact_delete($name) {
        return self::quick_delete('contact', 'name', $name);
    }

}

?>