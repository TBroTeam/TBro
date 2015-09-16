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

     --for all these search hits:
     FOR t_ IN (SELECT * FROM hits) LOOP
	-- if we are a unigene: store id into _unigene_id
        IF t_.type_id = {PHPCONST('CV_UNIGENE')} THEN
		_unigene_id:=t_.feature_id;
        ELSIF t_.type_id = {PHPCONST('CV_ISOFORM')} THEN
        -- if we are a isoform: store corresponding unigene into hits (if it is not already in hits), set _unigene_id
		SELECT object_id INTO _unigene_id FROM feature_relationship WHERE subject_id=t_.feature_id;
		INSERT INTO hits (SELECT f.name, f.feature_id, f.type_id, '' AS synonym_name FROM feature f WHERE f.feature_id = _unigene_id 
			AND NOT EXISTS (SELECT 1 FROM hits WHERE hits.feature_id = f.feature_id));
	END IF;
	-- insert all isoforms for _unigene_id into hits, if they are not already in hits (e.g. have been found in the first place).
	-- this way, found aliases will be preserved
	INSERT INTO hits (
		SELECT details.*, fp.value AS description FROM (SELECT f.name, f.feature_id, f.type_id, '' AS synonym_name 
		FROM feature_relationship fr JOIN feature f ON (fr.subject_id = f.feature_id) 
		WHERE fr.object_id=_unigene_id AND NOT EXISTS (SELECT 1 FROM hits WHERE hits.feature_id = f.feature_id)
		) AS details LEFT JOIN (SELECT featureprop.feature_id, value FROM featureprop WHERE featureprop.type_id={PHPCONST('CV_ANNOTATION_DESC')}) AS fp
                ON details.feature_id=fp.feature_id);
     END LOOP;     
     RETURN QUERY SELECT * FROM hits ORDER BY feature_id;
 END
$$;
