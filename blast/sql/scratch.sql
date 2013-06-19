CREATE OR REPLACE FUNCTION reset_timed_out_queries()
RETURNS void
AS 
$BODY$
DECLARE
    _job_query_id integer;
BEGIN
    FOR _job_query_id IN SELECT job_query_id FROM job_queries WHERE (status='PROCESSING' OR STATUS='STARTING') AND (processing_start_time + get_option('MAXIMUM_EXECUTION_TIME')::integer * interval '1 second')<NOW()  LOOP
        UPDATE job_queries SET status='NOT_PROCESSED', processing_start_time=NULL WHERE job_query_id=_job_query_id;
                DELETE FROM running_queries WHERE job_query_id=_job_query_id;
    END LOOP;
END;
$BODY$
LANGUAGE plpgsql;
COMMENT ON FUNCTION  get_option(varchar) IS 
'resets all queries that have started more than MAXIMUM_EXECUTION_TIME seconds ago to NOT_PROCESSED';
