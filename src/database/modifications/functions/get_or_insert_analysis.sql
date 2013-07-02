DROP FUNCTION IF EXISTS
    get_or_insert_analysis (_name character varying(255), _program character varying(255), _programversion character varying(255), _sourcename character varying(255))
--NEWCMD--
CREATE FUNCTION
    get_or_insert_analysis (_name character varying(255), _program character varying(255), _programversion character varying(255), _sourcename character varying(255))
RETURNS integer
AS $$
DECLARE
    _analysis_id integer;
BEGIN
    SELECT INTO _analysis_id analysis_id FROM analysis WHERE name=_name AND program=_program AND sourcename = _sourcename AND programversion=_programversion;

    IF _analysis_id IS NULL THEN
        INSERT INTO analysis (name, program, programversion, sourcename) VALUES (_name, _program, _programversion, _sourcename);
        _analysis_id := currval('analysis_analysis_id_seq');
    END IF;
    
    RETURN _analysis_id;
END;
$$ LANGUAGE 'plpgsql';