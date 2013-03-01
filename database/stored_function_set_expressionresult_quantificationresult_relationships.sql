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

FOR _line IN (SELECT 
  quantificationresult.quantificationresult_id AS qr_id
FROM 
  public.quantificationresult, 
  public.feature, 
  public.biomaterial, 
  public.biomaterial_relationship
WHERE 
  biomaterial_relationship.subject_id = _parent_id AND
  biomaterial_relationship.biomaterial_relationship_id = _cvterm_isa AND
  feature.uniquename = _feature_uniq AND
  quantificationresult.feature_id = feature.feature_id AND
  biomaterial.biomaterial_id = quantificationresult.quantificationresult_id AND
  biomaterial_relationship.subject_id = biomaterial.biomaterial_id) LOOP
        _count:=_count+1;

        INSERT INTO expressionresult_quantificationresult(
            expressionresult_id, quantificationresult_id, samplegroup)
            VALUES (_expressionresult_id, _line.qr_id, _samplegroup);


    END LOOP;
    RETURN _count;
END;
' LANGUAGE 'plpgsql';