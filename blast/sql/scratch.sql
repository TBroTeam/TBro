SELECT * FROM jobs 
	JOIN job_queries ON (jobs.job_id=job_queries.job_id) 
	JOIN queries ON (job_queries.query_id=queries.query_id)
	JOIN parameter_sets ON (queries.parameter_set_id=parameter_sets.parameter_set_id);