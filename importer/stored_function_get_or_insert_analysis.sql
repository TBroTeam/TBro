CREATE FUNCTION get_or_insert_analysis (character varying(255), character varying(255), character varying(255), timestamp) RETURNS integer AS '
DECLARE
    _name ALIAS FOR $1;
    _program ALIAS FOR $2;
    _version ALIAS FOR $3;
    _timeexecuted ALIAS FOR $4;

    _analysis_id integer;
BEGIN
    SELECT INTO _analysis_id analysis_id FROM analysis WHERE name=_name AND program=_program AND programversion=_version AND timeexecuted=_timeexecuted;

    IF _analysis_id IS NULL THEN
        INSERT INTO analysis (name, program, programversion, timeexecuted) VALUES (_name, _program, _version, _timeexecuted);
        _analysis_id := currval(''analysis_analysis_id_seq'');
    END IF;
    
    RETURN _analysis_id;

END;
' LANGUAGE 'plpgsql';