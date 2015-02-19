DROP FUNCTION IF EXISTS update_materialized_views();
--NEWCMD--
CREATE FUNCTION update_materialized_views() RETURNS VOID
 LANGUAGE plpgsql AS $$
 BEGIN
    EXECUTE 'SELECT update_materialized_view_statistical_information();';
    EXECUTE 'SELECT update_materialized_view_diffexp_filter();';
    EXECUTE 'SELECT update_materialized_view_expression_filter();';
    RETURN;
 END
 $$;
