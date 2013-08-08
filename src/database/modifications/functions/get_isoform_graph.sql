DROP FUNCTION IF EXISTS get_isoform_graph(int);
--NEWCMD--
DROP TYPE IF EXISTS isoform_graph_row;
--NEWCMD--
CREATE TYPE isoform_graph_row AS (feature_id int, name varchar, type_id int, residues text, seqlen int, fmin int, fmax int, strand smallint);
--NEWCMD--
CREATE OR REPLACE FUNCTION get_isoform_graph(int) RETURNS 
    SETOF isoform_graph_row
 LANGUAGE plpgsql AS $BODY$
 DECLARE
     isoform_id ALIAS FOR $1;
     predpep isoform_graph_row;
 BEGIN
        --get isoform, first line
	RETURN QUERY SELECT f.feature_id, f.name, f.type_id, f.residues, f.seqlen, 0,0,0::smallint FROM feature f WHERE f.feature_id=isoform_id;

        --get repeatmasker annotations
	RETURN QUERY 
            SELECT f.feature_id, 
                CASE WHEN repeat_family.value IS NULL 
                    THEN (repeat_name.value||'#'||repeat_class.value)::varchar
                    ELSE (repeat_name.value||'#'||repeat_class.value||'('||repeat_family.value||')')::varchar 
                    END AS name, 
                f.type_id, f.residues, f.seqlen, fl.fmin,fl.fmax,fl.strand 
            FROM featureloc fl 
                JOIN feature f ON (f.feature_id = fl.feature_id AND f.type_id = {PHPCONST('CV_ANNOTATION_REPEATMASKER')}) 
                JOIN      featureprop repeat_name   ON (repeat_name.feature_id = fl.feature_id   AND repeat_name.type_id   = {PHPCONST('CV_REPEAT_NAME')})
                JOIN      featureprop repeat_class  ON (repeat_class.feature_id = fl.feature_id  AND repeat_class.type_id  = {PHPCONST('CV_REPEAT_CLASS')})
                LEFT JOIN featureprop repeat_family ON (repeat_family.feature_id = fl.feature_id AND repeat_family.type_id = {PHPCONST('CV_REPEAT_FAMILY')})
            WHERE fl.srcfeature_id=isoform_id;

        --predicted peptides
	FOR predpep IN SELECT f.feature_id, f.name, f.type_id, f.residues, f.seqlen, fl.fmin,fl.fmax,fl.strand FROM feature f, featureloc fl WHERE f.type_id = {PHPCONST('CV_PREDPEP')} AND f.feature_id = fl.feature_id AND fl.srcfeature_id=isoform_id
	LOOP
		RETURN NEXT predpep;
                --for each predpep, get interpro annotations
		RETURN QUERY 
                    SELECT f.feature_id, 
                        CASE WHEN description.value IS NOT NULL AND description.value != 'no description' THEN description.value::varchar 
                             WHEN interpro_id.value IS NOT NULL THEN interpro_id.value::varchar
                             ELSE (analysis.sourcename || ':' || analysis_match_id.value)::varchar
                        END AS name,
                        f.type_id, f.residues, f.seqlen, fl.fmin,fl.fmax,fl.strand 
                    FROM  featureloc fl 
                        JOIN feature f ON (f.feature_id = fl.feature_id AND f.type_id = {PHPCONST('CV_ANNOTATION_INTERPRO')}) 
                        LEFT JOIN featureprop interpro_id ON (interpro_id.feature_id = fl.feature_id AND interpro_id.type_id = {PHPCONST('CV_INTERPRO_ID')})
                        LEFT JOIN featureprop description ON (description.feature_id = fl.feature_id AND description.type_id = {PHPCONST('CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION')})
                        LEFT JOIN analysisfeature ON (fl.feature_id = analysisfeature.feature_id)
                        LEFT JOIN analysis ON (analysisfeature.analysis_id = analysis.analysis_id)                        
                        LEFT JOIN featureprop AS analysis_match_id ON (analysis_match_id.feature_id = fl.feature_id AND analysis_match_id.type_id = {PHPCONST('CV_INTERPRO_ANALYSIS_MATCH_ID')})
                    WHERE fl.srcfeature_id=predpep.feature_id;
	END LOOP;

	RETURN;
  END
 $BODY$;