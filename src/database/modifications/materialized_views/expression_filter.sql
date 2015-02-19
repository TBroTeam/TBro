DROP FUNCTION IF EXISTS function_get_expression_filters() CASCADE;
--NEWCMD--
CREATE OR REPLACE FUNCTION function_get_expression_filters() RETURNS 
    TABLE (biomaterial_id int, parent_biomaterial_id int, analysis_id int, quantification_id int, organism_id int, dbxref_id int)
 LANGUAGE plpgsql AS $BODY$
 DECLARE
 BEGIN
    RETURN QUERY 
        SELECT DISTINCT
            d.biomaterial_id, r.object_id parent_biomaterial_id, d.analysis_id, d.quantification_id, f.organism_id, f.dbxref_id
        FROM 
            expressionresult d, feature f, biomaterial_relationship r
        WHERE 
            d.feature_id=f.feature_id 
            AND r.subject_id=d.biomaterial_id 
            AND r.type_id={PHPCONST('CV_BIOMATERIAL_ISA')};
 END
 $BODY$;
--NEWCMD--
DROP TABLE IF EXISTS materialized_view_expression_filter;
--NEWCMD--
CREATE TABLE materialized_view_expression_filter AS SELECT * FROM function_get_expression_filters();
--NEWCMD--
DROP FUNCTION IF EXISTS update_materialized_view_expression_filter();
--NEWCMD--
CREATE FUNCTION update_materialized_view_expression_filter() RETURNS VOID
 LANGUAGE plpgsql AS $$
 BEGIN
    EXECUTE 'DELETE FROM materialized_view_expression_filter';
    EXECUTE 'INSERT INTO materialized_view_expression_filter SELECT * FROM function_get_expression_filters()';
    RETURN;
 END
 $$;