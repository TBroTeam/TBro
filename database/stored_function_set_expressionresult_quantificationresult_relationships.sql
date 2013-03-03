DROP FUNCTION IF EXISTS set_expressionresult_quantificationresult_relationships (bigint, integer, integer, character varying(255), character varying(255));
CREATE FUNCTION set_expressionresult_quantificationresult_relationships (bigint, integer, integer, character varying(255), character varying(255))
RETURNS integer AS '
DECLARE
    _expressionresult_id ALIAS FOR $1;
    _parent_id ALIAS FOR $2;
    _cvterm_isa ALIAS FOR $3;
    _feature_uniq ALIAS FOR $4;
    _samplegroup ALIAS FOR $5;

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
    biomaterial_relationship.type_id = _cvterm_isa AND
    feature.uniquename = _feature_uniq
) LOOP
        _count:=_count+1;

        INSERT INTO expressionresult_quantificationresult(
            expressionresult_id, quantificationresult_id, samplegroup)
            VALUES (_expressionresult_id, _line.qr_id, _samplegroup);


    END LOOP;
    RETURN _count;
END;
' LANGUAGE 'plpgsql';

--        INSERT INTO expressionresult_quantificationresult(
--            expressionresult_id, quantificationresult_id, samplegroup)
--            VALUES (_expressionresult_id, _line.qr_id, _samplegroup);
