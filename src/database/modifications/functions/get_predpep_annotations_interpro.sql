DROP FUNCTION IF EXISTS
    get_predpep_annotations_interpro(_predpep_ids integer[])
--NEWCMD--
CREATE FUNCTION
    get_predpep_annotations_interpro(_predpep_ids integer[])
RETURNS
    TABLE (predpep_id int, feature_id int, uniquename text, fmin int, fmax int, strand smallint, interpro_ID text, evalue double precision, analysis_name character varying(255), program  character varying(255), programversion  character varying(255), sourcename  character varying(255), analysis_match_id text, analysis_match_description text)
AS $$
BEGIN
    RETURN QUERY
    SELECT 
        featureloc.srcfeature_id AS predpep_id, interpro.feature_id, interpro.uniquename, featureloc.fmin, featureloc.fmax, featureloc.strand, interpro_ID.value AS interpro_ID, analysisfeature.significance AS evalue, analysis.name AS analysis_name, analysis.program, analysis.programversion, analysis.sourcename, analysis_match_id.value, analysis_match_description.value
    FROM 
        feature interpro
        INNER JOIN featureloc ON (interpro.feature_id = featureloc.feature_id)
        LEFT OUTER JOIN featureprop AS interpro_ID ON (interpro_ID.feature_id = interpro.feature_id AND interpro_ID.type_id = {PHPCONST('CV_INTERPRO_ID')}) 
        LEFT OUTER JOIN analysisfeature ON (interpro.feature_id = analysisfeature.feature_id)
        LEFT OUTER JOIN analysis ON (analysisfeature.analysis_id = analysis.analysis_id)
        LEFT OUTER JOIN featureprop AS analysis_match_id ON (analysis_match_id.feature_id = interpro.feature_id AND analysis_match_id.type_id = {PHPCONST('CV_INTERPRO_ANALYSIS_MATCH_ID')})
        LEFT OUTER JOIN featureprop AS analysis_match_description ON (analysis_match_description.feature_id = interpro.feature_id AND analysis_match_description.type_id = {PHPCONST('CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION')})
    WHERE 
        featureloc.srcfeature_id = any(_predpep_ids) AND
        interpro.type_id = {PHPCONST('CV_ANNOTATION_INTERPRO')};
END;
$$ LANGUAGE 'plpgsql';