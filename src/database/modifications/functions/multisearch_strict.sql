DROP FUNCTION IF EXISTS multisearch(_organism_id int, _release_name varchar, _feature_names varchar[]);
--NEWCMD--
CREATE OR REPLACE FUNCTION multisearch(_organism_id int, _release_name varchar, _feature_names varchar[])
 RETURNS TABLE(feature_name varchar, feature_id int, type_id int, synonym_name varchar, description text)
 LANGUAGE plpgsql AS $$
 DECLARE
     _release_id int;
     _unigene_id int;
     t_ record;
 BEGIN
     SELECT dbxref_id INTO _release_id FROM dbxref WHERE db_id={PHPCONST('DB_ID_IMPORTS')} AND accession=_release_name;

     --create temp table with 'direct' search hits
     CREATE TEMP TABLE hits ON COMMIT DROP AS 
	SELECT details.*, fp.value AS description FROM ((SELECT f.name, f.feature_id, f.type_id, '' AS synonym_name FROM feature f WHERE f.dbxref_id = _release_id AND f.organism_id = _organism_id AND name=ANY(_feature_names) LIMIT 500)
		UNION
	(SELECT f.name, f.feature_id, f.type_id, s.name AS synonym_name 
		FROM synonym s JOIN feature_synonym fs ON (fs.synonym_id = s.synonym_id) JOIN feature f ON (fs.feature_id = f.feature_id)
		WHERE s.name=ANY(_feature_names) AND f.organism_id = _organism_id AND f.dbxref_id = _release_id
	LIMIT 500)) AS details LEFT JOIN (SELECT featureprop.feature_id, value FROM featureprop WHERE featureprop.type_id={PHPCONST('CV_ANNOTATION_DESC')}) AS fp
    ON details.feature_id=fp.feature_id;

     RETURN QUERY SELECT * FROM hits ORDER BY feature_id;
 END
$$;
