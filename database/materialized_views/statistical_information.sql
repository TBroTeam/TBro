DROP FUNCTION IF EXISTS function_view_statistical_information() CASCADE;
--NEWCMD--
CREATE OR REPLACE FUNCTION function_view_statistical_information() RETURNS 
    TABLE (total_sequences int, total_unigenes int, total_isoforms int, releases bigint, organisms bigint, count_unigenes numeric, count_isoforms numeric, organism varchar, release varchar)
 LANGUAGE plpgsql AS $BODY$
 DECLARE
     total_sequences bigint;
     total_unigenes bigint;
     total_isoforms bigint;
     
 BEGIN
 
	DROP TABLE IF EXISTS  tmp_feature_counts ;
	CREATE TEMP TABLE tmp_feature_counts ON COMMIT DROP  AS SELECT COUNT(*) AS count, dbxref_id, organism_id, type_id FROM feature GROUP BY dbxref_id, organism_id, type_id;

	SELECT INTO total_unigenes SUM(count) FROM tmp_feature_counts WHERE type_id = {PHPCONST('CV_UNIGENE')};
	SELECT INTO total_isoforms SUM(count) FROM tmp_feature_counts WHERE type_id = {PHPCONST('CV_ISOFORM')};

	IF total_unigenes IS NULL THEN 
		total_unigenes:=0; 
	END IF;
	IF total_isoforms IS NULL THEN 
		total_isoforms:=0; 
	END IF;

	total_sequences := total_unigenes + total_isoforms;

	RETURN QUERY EXECUTE '
		SELECT 
			'||total_sequences||' AS total_sequences,
			'||total_unigenes||' AS total_unigenes,
			'||total_isoforms||' AS total_isoforms,
			(SELECT COUNT(*) FROM  (SELECT 1 FROM tmp_feature_counts i GROUP BY (dbxref_id,organism_id)) x ) AS releases,
			(SELECT COUNT(*) FROM  (SELECT 1 FROM tmp_feature_counts i GROUP BY (organism_id)) x ) AS organisms,
			(SELECT SUM(count) FROM tmp_feature_counts i WHERE i.type_id = {PHPCONST('CV_UNIGENE')} AND i.dbxref_id=c.dbxref_id AND i.organism_id = c.organism_id) AS count_unigenes,
			(SELECT SUM(count) FROM tmp_feature_counts i WHERE i.type_id = {PHPCONST('CV_ISOFORM')} AND i.dbxref_id=c.dbxref_id AND i.organism_id = c.organism_id) AS count_isoforms,
			(SELECT common_name FROM organism WHERE organism_id = c.organism_id) AS organism,
			(SELECT accession FROM dbxref WHERE dbxref_id = c.dbxref_id) AS release
		FROM tmp_feature_counts c
		GROUP BY dbxref_id, organism_id;
        ';
 END
 $BODY$;
--NEWCMD--
DROP TABLE IF EXISTS materialized_view_statistical_information;
--NEWCMD--
CREATE TABLE materialized_view_statistical_information AS SELECT * FROM function_view_statistical_information();
--NEWCMD--
CREATE INDEX materialized_view_statistical_information_idx_1 ON materialized_view_statistical_information(organism, release);
--NEWCMD--
DROP FUNCTION IF EXISTS update_materialized_view_statistical_information();
--NEWCMD--
CREATE FUNCTION update_materialized_view_statistical_information() RETURNS VOID
 LANGUAGE plpgsql AS $$
 BEGIN
    DROP INDEX IF EXISTS materialized_view_statistical_information_idx_1;
    EXECUTE 'DELETE FROM materialized_view_statistical_information';
    EXECUTE 'INSERT INTO materialized_view_statistical_information SELECT * FROM function_view_statistical_information()';
    CREATE INDEX materialized_view_statistical_information_idx_1 ON materialized_view_statistical_information(organism, release);
    RETURN;
 END
 $$;
--NEWCMD--
DROP FUNCTION IF EXISTS update_materialized_views();
--NEWCMD--
CREATE FUNCTION update_materialized_views() RETURNS VOID
 LANGUAGE plpgsql AS $$
 BEGIN
    EXECUTE 'SELECT update_materialized_view_statistical_information();';
    RETURN;
 END
 $$;
