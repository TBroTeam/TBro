CREATE TABLE webuser_data
(
  identity character varying,
  type_id integer,
  value jsonb,
  webuser_data_id serial NOT NULL,
  CONSTRAINT webuser_data_pkey PRIMARY KEY (webuser_data_id),
  CONSTRAINT webuser_data_cvterm_fkey FOREIGN KEY (type_id)
      REFERENCES cvterm (cvterm_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT webuser_data_identity_type_id_key UNIQUE (identity, type_id)
)
WITH (
  OIDS=FALSE
);