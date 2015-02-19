DROP FUNCTION IF EXISTS function_get_diffexp_filters() CASCADE;
--NEWCMD--
CREATE OR REPLACE FUNCTION function_get_diffexp_filters() RETURNS 
    TABLE (ba_id int, bb_id int, analysis_id int, quantification_id int, organism_id int, dbxref_id int)
 LANGUAGE plpgsql AS $BODY$
 DECLARE
 BEGIN
    RETURN QUERY 
        SELECT DISTINCT
            d.biomateriala_id ba_id, d.biomaterialb_id bb_id, d.analysis_id, d.quantification_id, f.organism_id, f.dbxref_id
        FROM 
            diffexpresult d, feature f
        WHERE 
            d.feature_id=f.feature_id;
 END
 $BODY$;
--NEWCMD--
DROP TABLE IF EXISTS materialized_view_diffexp_filter;
--NEWCMD--
CREATE TABLE materialized_view_diffexp_filter AS SELECT * FROM function_get_diffexp_filters();
--NEWCMD--
DROP FUNCTION IF EXISTS update_materialized_view_diffexp_filter();
--NEWCMD--
CREATE FUNCTION update_materialized_view_diffexp_filter() RETURNS VOID
 LANGUAGE plpgsql AS $$
 BEGIN
    EXECUTE 'DELETE FROM materialized_view_diffexp_filter';
    EXECUTE 'INSERT INTO materialized_view_diffexp_filter SELECT * FROM function_get_diffexp_filters()';
    RETURN;
 END
 $$;