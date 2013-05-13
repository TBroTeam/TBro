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
	RETURN QUERY SELECT f.feature_id, f.name, f.type_id, f.residues, f.seqlen, 0,0,0::smallint FROM feature f WHERE f.feature_id=isoform_id;

	RETURN QUERY SELECT f.feature_id, f.name, f.type_id, f.residues, f.seqlen, fl.fmin,fl.fmax,fl.strand FROM feature f, featureloc fl WHERE f.type_id = {PHPCONST('CV_ANNOTATION_REPEATMASKER')} AND f.feature_id = fl.feature_id AND fl.srcfeature_id=isoform_id;

	FOR predpep IN SELECT f.feature_id, f.name, f.type_id, f.residues, f.seqlen, fl.fmin,fl.fmax,fl.strand FROM feature f, featureloc fl WHERE f.type_id = {PHPCONST('CV_PREDPEP')} AND f.feature_id = fl.feature_id AND fl.srcfeature_id=isoform_id
	LOOP
		RETURN NEXT predpep;
		RETURN QUERY SELECT f.feature_id, f.name, f.type_id, f.residues, f.seqlen, fl.fmin,fl.fmax,fl.strand FROM feature f, featureloc fl WHERE f.type_id = {PHPCONST('CV_ANNOTATION_INTERPRO')} AND f.feature_id = fl.feature_id AND fl.srcfeature_id=predpep.feature_id;
	END LOOP;

	RETURN;
  END
 $BODY$;