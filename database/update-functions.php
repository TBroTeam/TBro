#!/usr/bin/php
<?php
define('INC', __DIR__ . '/../includes/');
echo INC;
require_once INC . '/db.php';
require_once INC . '/constants.php';
global $db, $_CONST;

$stored_functions = array(
    array('func_header' => 'get_or_insert_analysis (character varying(255), character varying(255), character varying(255), timestamp)',
        'func_returns' => 'integer',
        'func_body' => <<<EOF
DECLARE
    _name ALIAS FOR $1;
    _program ALIAS FOR $2;
    _version ALIAS FOR $3;
    _timeexecuted ALIAS FOR $4;

    _analysis_id integer;
BEGIN
    SELECT INTO _analysis_id analysis_id FROM analysis WHERE name=_name AND program=_program AND programversion=_version AND timeexecuted=_timeexecuted;

    IF _analysis_id IS NULL THEN
        INSERT INTO analysis (name, program, programversion, timeexecuted) VALUES (_name, _program, _version, _timeexecuted);
        _analysis_id := currval(''analysis_analysis_id_seq'');
    END IF;
    
    RETURN _analysis_id;

END;
EOF
    ),
    array('func_header' => 'get_or_insert_dbxref (character varying(255), character varying(255))',
        'func_returns' => 'integer',
        'func_body' => <<<EOF
DECLARE
    _dbname ALIAS FOR $1;
    _accession ALIAS FOR $2;

    _db_id integer;
    _dbxref_id integer;
BEGIN
    SELECT INTO _db_id db_id FROM db WHERE name = _dbname;
    SELECT INTO _dbxref_id dbxref_id FROM dbxref WHERE db_id = _db_id AND accession = _accession;

    IF _dbxref_id IS NULL THEN
        INSERT INTO dbxref (db_id, accession) VALUES (_db_id, _accession);
        _dbxref_id := currval(''dbxref_dbxref_id_seq'');
    END IF;
    
    RETURN _dbxref_id;

END;
EOF
    ),
    array('func_header' => 'set_expressionresult_quantificationresult_relationships (bigint, integer, character varying(255), character varying(255))',
        'func_returns' => 'integer',
        'func_body' => <<<EOF
DECLARE
    _expressionresult_id ALIAS FOR $1;
    _parent_id ALIAS FOR $2;
    _feature_uniq ALIAS FOR $3;
    _samplegroup ALIAS FOR $4;

    _line RECORD;
    _count integer;
BEGIN
_count := 0;

FOR _line IN (
    SELECT quantificationresult.quantificationresult_id AS qr_id FROM feature, quantificationresult, biomaterial, biomaterial_relationship WHERE
    quantificationresult.feature_id = feature.feature_id AND
    quantificationresult.biomaterial_id = biomaterial.biomaterial_id AND 
    biomaterial.biomaterial_id = biomaterial_relationship.subject_id AND 
    biomaterial_relationship.object_id = _parent_id AND
    biomaterial_relationship.type_id = {$_CONST('CV_BIOMATERIAL_ISA')} AND
    feature.uniquename = _feature_uniq
) LOOP
        _count:=_count+1;

        INSERT INTO expressionresult_quantificationresult(
            expressionresult_id, quantificationresult_id, samplegroup)
            VALUES (_expressionresult_id, _line.qr_id, _samplegroup);


    END LOOP;
    RETURN _count;
END;
EOF
    ),
        /*
          array('func_header' => '',
          'func_returns' => null,
          'func_body' => <<<EOF
          EOF
          ),
         */
);

$query = <<<EOF
   CREATE OR REPLACE FUNCTION %s %s AS '
%s
' LANGUAGE 'plpgsql';
EOF;
echo"\n";
foreach ($stored_functions as $fun) {

    echo 'updating ' . $fun['func_header'] . "\n";
    $db->query(sprintf($query
                    , $fun['func_header']
                    , $fun['func_returns'] == null ? '' : 'RETURNS ' . $fun['func_returns']
                    , $fun['func_body']
    ));
}
?>
