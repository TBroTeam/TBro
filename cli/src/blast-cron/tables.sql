CREATE TABLE blast_cron_jobs
(
  job_id serial NOT NULL,
  job_uuid character varying NOT NULL,
  blast_type character varying NOT NULL,
  organism_common_name character varying NOT NULL,
  release_name character varying NOT NULL,
  query text COLLATE pg_catalog."C.UTF-8" NOT NULL,
  job_status character varying NOT NULL DEFAULT 'NOT PROCESSED'::character varying,
  job_creation_time timestamp without time zone NOT NULL DEFAULT ('now'::text)::timestamp without time zone,
  job_processing_start_time timestamp without time zone,
  job_processing_finish_time timestamp without time zone,
  job_md5 character varying,
  CONSTRAINT blast_cron_jobs_pkey PRIMARY KEY (job_id ),
  CONSTRAINT blast_cron_jobs_job_uuid_key UNIQUE (job_uuid),
  CONSTRAINT blast_cron_jobs_job_status_check CHECK (job_status::text = ANY (ARRAY['NOT PROCESSED'::character varying, 'PROCESSING'::character varying, 'PROCESSED'::character varying, 'ERROR'::character varying]::text[]))
)
WITH (
  OIDS=FALSE
);

CREATE TABLE blast_cron_jobs_properties
(
  job_property_id serial NOT NULL,
  job_id integer NOT NULL,
  property_name character varying NOT NULL,
  property_value character varying NOT NULL,
  CONSTRAINT blast_cron_jobs_properties_pkey PRIMARY KEY (job_property_id ),
  CONSTRAINT blast_cron_jobs_properties_job_id_fkey FOREIGN KEY (job_id)
      REFERENCES blast_cron_jobs (job_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

CREATE TABLE blast_cron_jobs_results
(
  job_results_id serial NOT NULL,
  job_id integer NOT NULL,
  results_xml text NOT NULL,
  CONSTRAINT blast_cron_jobs_results_pkey PRIMARY KEY (job_results_id ),
  CONSTRAINT blast_cron_jobs_results_job_id_fkey FOREIGN KEY (job_id)
      REFERENCES blast_cron_jobs (job_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

CREATE TABLE blast_cron_jobs_running_pids
(
  running_job_id serial NOT NULL,
  pid integer NOT NULL,
  job_id integer,
  hostname character varying NOT NULL,
  CONSTRAINT blast_cron_jobs_running_pids_pkey PRIMARY KEY (running_job_id ),
  CONSTRAINT blast_cron_jobs_running_pids_job_id_fkey FOREIGN KEY (job_id)
      REFERENCES blast_cron_jobs (job_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);