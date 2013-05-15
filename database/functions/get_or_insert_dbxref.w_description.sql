DROP FUNCTION IF EXISTS
    get_or_insert_dbxref (_dbname character varying(255), _accession character varying(255), _description character varying(255))
--NEWCMD--
CREATE FUNCTION
    get_or_insert_dbxref (_dbname character varying(255), _accession character varying(255), _description character varying(255))
RETURNS integer
AS $$
DECLARE
    _db_id integer;
    _dbxref_id integer;
    _db_description  character varying(255);
BEGIN
    SELECT INTO _db_id db_id FROM db WHERE name = _dbname;
    SELECT INTO _dbxref_id, _db_description dbxref_id, description FROM dbxref WHERE db_id = _db_id AND accession = _accession;

    IF _dbxref_id IS NULL THEN
        INSERT INTO dbxref (db_id, accession, description, version) VALUES (_db_id, _accession, _description, 'by import');
        _dbxref_id := currval('dbxref_dbxref_id_seq');
    ELSIF _db_description IS NULL OR _db_description != _description THEN
	UPDATE dbxref SET description=_description WHERE dbxref_id = _dbxref_id;	
    END IF;

    
    RETURN _dbxref_id;

END;   
$$ LANGUAGE 'plpgsql';