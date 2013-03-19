#!/usr/bin/php
<?php
define('DEBUG', false);
define('INC', __DIR__ . '/../includes/');
echo INC;
require_once INC . '/db.php';
require_once INC . '/constants.php';
global $db, $_CONST;

$stored_functions = array(
    array('func_header' => 'get_or_insert_analysis (_name character varying(255), _program character varying(255), _version character varying(255), _timeexecuted timestamp)',
        'func_returns' => 'integer',
        'func_body' => <<<EOF
DECLARE
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
    array('func_header' => 'get_or_insert_dbxref (_dbname character varying(255), _accession character varying(255))',
        'func_returns' => 'integer',
        'func_body' => <<<EOF
DECLARE
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
    array('func_header' => 'set_expressionresult_quantificationresult_relationships (_expressionresult_id bigint, _parent_id integer, _feature_uniq character varying(255), _samplegroup character varying(255))',
        'func_returns' => 'integer',
        'func_body' => <<<EOF
DECLARE
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
    array('func_header' => 'get_isoform_annotations_repeatmasker(_isoform_ids integer[])',
        'func_returns' => 'TABLE (isoform_id int, uniquename text, fmin integer, fmax integer, strand smallint, repeat_name text, repeat_family text, repeat_class text)',
        'func_body' => <<<EOF
   BEGIN
        RETURN QUERY
        SELECT
            featureloc.srcfeature_id AS isoform_id, repeatmasker.uniquename, featureloc.fmin, featureloc.fmax, featureloc.strand, repeat_name.value AS repeat_name, repeat_family.value AS repeat_family, repeat_class.value AS repeat_class
        FROM
            feature AS repeatmasker
            INNER JOIN featureloc ON (repeatmasker.feature_id = featureloc.feature_id)
            LEFT OUTER JOIN featureprop AS repeat_name ON (repeat_name.feature_id = repeatmasker.feature_id AND repeat_name.type_id = {$_CONST('CV_REPEAT_NAME')})
            LEFT OUTER JOIN featureprop AS repeat_family ON (repeat_family.feature_id = repeatmasker.feature_id AND repeat_family.type_id = {$_CONST('CV_REPEAT_FAMILY')})
            LEFT OUTER JOIN featureprop AS repeat_class ON (repeat_class.feature_id = repeatmasker.feature_id AND repeat_class.type_id = {$_CONST('CV_REPEAT_CLASS')})
        WHERE
            featureloc.srcfeature_id = any(_isoform_ids) AND
            repeatmasker.type_id = {$_CONST('CV_ANNOTATION_REPEATMASKER')};
END;
EOF
    ),
    array('func_header' => 'get_predpep_annotations_interpro(_predpep_ids integer[])',
        'func_returns' => 'TABLE (predpep_id int, feature_id int, uniquename text, fmin int, fmax int, strand smallint, interpro_ID text, evalue double precision, analysis_name character varying(255), program  character varying(255), programversion  character varying(255), timeexecuted timestamp)',
        'func_body' => <<<EOF
BEGIN
    RETURN QUERY
    SELECT 
        featureloc.srcfeature_id AS predpep_id, interpro.feature_id, interpro.uniquename, featureloc.fmin, featureloc.fmax, featureloc.strand, interpro_ID.value AS interpro_ID, analysisfeature.significance AS evalue, analysis.name AS analysis_name, analysis.program, analysis.programversion, analysis.timeexecuted
    FROM 
        feature interpro
        INNER JOIN featureloc ON (interpro.feature_id = featureloc.feature_id)
        LEFT OUTER JOIN featureprop AS interpro_ID ON (interpro_ID.feature_id   = interpro.feature_id AND interpro_ID.type_id = {$_CONST('CV_INTERPRO_ID')}) 
        LEFT OUTER JOIN analysisfeature ON (interpro.feature_id = analysisfeature.feature_id)
        LEFT OUTER JOIN analysis ON (analysisfeature.analysis_id = analysis.analysis_id)
    WHERE 
        featureloc.srcfeature_id = any(_predpep_ids) AND
        interpro.type_id = {$_CONST('CV_ANNOTATION_INTERPRO')};
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




$fquery = <<<EOF
   CREATE FUNCTION %1\$s %2\$s AS '
%3\$s
' LANGUAGE 'plpgsql';
EOF;
echo"\n";
foreach ($stored_functions as $fun) {
    if ($fun['func_header'] == '')
        continue;

    echo 'updating ' . $fun['func_header'] . "\n";
    $query = sprintf($fquery
            , $fun['func_header']
            , $fun['func_returns'] == null ? '' : 'RETURNS ' . $fun['func_returns']
            , $fun['func_body']
    );
    echo $query . "\n";
    $db->query(sprintf('DROP FUNCTION IF EXISTS %1$s;', $fun['func_header']));
    $db->query($query);
}
?>
