-- taken from the excellent tutorial at http://tech.jonathangardner.net/wiki/PostgreSQL/Materialized_Views

CREATE OR REPLACE FUNCTION create_matview(NAME, NAME)
 RETURNS VOID
 SECURITY DEFINER
 LANGUAGE plpgsql AS $$
 DECLARE
     matview ALIAS FOR $1;
     view_name ALIAS FOR $2;
     entry matviews%ROWTYPE;
 BEGIN
     SELECT * INTO entry FROM matviews WHERE mv_name = matview;
 
     IF FOUND THEN
         RAISE EXCEPTION 'Materialized view ''%'' already exists.',
           matview;
     END IF;
 
     EXECUTE 'REVOKE ALL ON ' || view_name || ' FROM PUBLIC'; 
 
     EXECUTE 'GRANT SELECT ON ' || view_name || ' TO PUBLIC';
 
     EXECUTE 'CREATE TABLE ' || matview || ' AS SELECT * FROM ' || view_name;
 
     EXECUTE 'REVOKE ALL ON ' || matview || ' FROM PUBLIC';
 
     EXECUTE 'GRANT SELECT ON ' || matview || ' TO PUBLIC';
 
     INSERT INTO matviews (mv_name, v_name, last_refresh)
       VALUES (matview, view_name, CURRENT_TIMESTAMP); 
     
     RETURN;
 END
 $$;
--NEWCMD--
CREATE OR REPLACE FUNCTION drop_matview_if_exists(NAME) RETURNS VOID
 SECURITY DEFINER
 LANGUAGE plpgsql AS $$
 DECLARE
     matview ALIAS FOR $1;
     entry matviews%ROWTYPE;
 BEGIN
 
     SELECT * INTO entry FROM matviews WHERE mv_name = matview;
 
     IF NOT FOUND THEN
        RETURN;
         --RAISE EXCEPTION 'Materialized view % does not exist.', matview;
     END IF;
 
     EXECUTE 'DROP TABLE IF EXISTS ' || matview;
     DELETE FROM matviews WHERE mv_name=matview;
 
     RETURN;
 END
 $$;
--NEWCMD--
CREATE OR REPLACE FUNCTION refresh_matview(name) RETURNS VOID
 SECURITY DEFINER
 LANGUAGE plpgsql AS $$
 DECLARE 
     matview ALIAS FOR $1;
     entry matviews%ROWTYPE;
 BEGIN
 
     SELECT * INTO entry FROM matviews WHERE mv_name = matview;
 
     IF NOT FOUND THEN
         RAISE EXCEPTION 'Materialized view % does not exist.', matview;
    END IF;

    EXECUTE 'DELETE FROM ' || matview;
    EXECUTE 'INSERT INTO ' || matview
        || ' SELECT * FROM ' || entry.v_name;

    UPDATE matviews
        SET last_refresh=CURRENT_TIMESTAMP
        WHERE mv_name=matview;

    RETURN;
END
$$;
--NEWCMD--
DROP FUNCTION IF EXISTS update_materialized_views();
--NEWCMD--
--this method will try for all materialized views a function named update_<tablename>.
--this function is called after imports
CREATE FUNCTION update_materialized_views() RETURNS VOID
 LANGUAGE plpgsql AS $$
 DECLARE 
      row matviews%ROWTYPE;
      entry pg_proc%ROWTYPE;
      my_query varchar;
 BEGIN
    FOR row IN SELECT * FROM matviews
    LOOP
        SELECT INTO entry * FROM pg_proc where proname = 'update_' || row.mv_name;
        IF FOUND THEN
		my_query = 'SELECT update_' || row.mv_name || '()';
		EXECUTE my_query;
        END IF;
    END LOOP;
    RETURN;
 END
 $$;