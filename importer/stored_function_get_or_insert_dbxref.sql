CREATE FUNCTION get_or_insert_dbxref (character varying(255), character varying(255)) RETURNS integer AS '
DECLARE
    _dbname ALIAS FOR $1;
    _accession ALIAS FOR $2;

    _db_id integer;
    _dbxref_id integer;
BEGIN
    SELECT INTO _db_id db_id FROM db WHERE name = _dbname;
    SELECT INTO _dbxref_id dbxref_id FROM dbxref WHERE db_id = _db_id AND accession = _accession;

    IF _dbxref_id IS NULL THEN
        INSERT INTO dbxref (db_id, accession) VALUES (_db_id, _accession);
        _dbxref_id := currval(''dbxref_dbxref_id_seq'');
    END IF;
    
    RETURN _dbxref_id;

END;
' LANGUAGE 'plpgsql';