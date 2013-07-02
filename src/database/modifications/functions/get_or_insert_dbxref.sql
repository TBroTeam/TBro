DROP FUNCTION IF EXISTS
    get_or_insert_dbxref (_dbname character varying(255), _accession character varying(255))
--NEWCMD--
CREATE FUNCTION
    get_or_insert_dbxref (_dbname character varying(255), _accession character varying(255))
RETURNS integer
AS $$
DECLARE
    _db_id integer;
    _dbxref_id integer;
BEGIN
    SELECT INTO _db_id db_id FROM db WHERE name = _dbname;
    SELECT INTO _dbxref_id dbxref_id FROM dbxref WHERE db_id = _db_id AND accession = _accession;

    IF _dbxref_id IS NULL THEN
        INSERT INTO dbxref (db_id, accession, version) VALUES (_db_id, _accession, 'by import');
        _dbxref_id := currval('dbxref_dbxref_id_seq');
    END IF;
    
    RETURN _dbxref_id;

END;
$$ LANGUAGE 'plpgsql';