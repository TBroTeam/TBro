DROP TABLE IF EXISTS diffexpresult_expressionresult;
DROP TABLE IF EXISTS diffexpresult;
DROP TABLE IF EXISTS expressionresult;
DROP TABLE IF EXISTS webuser_data;


CREATE TABLE expressionresult
(
   expressionresult_id serial, 
   feature_id integer NOT NULL, 
   biomaterial_id integer NOT NULL, 
   quantification_id integer NOT NULL, 
   type_id integer NOT NULL, 
   value double precision NOT NULL, 
   CONSTRAINT expressionresult_pkey PRIMARY KEY (expressionresult_id), 
   CONSTRAINT expressionresult_feature_fkey FOREIGN KEY (feature_id) REFERENCES feature (feature_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT expressionresult_biomaterial_fkey FOREIGN KEY (biomaterial_id) REFERENCES biomaterial (biomaterial_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT expressionresult_quantification_fkey FOREIGN KEY (quantification_id) REFERENCES quantification (quantification_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT expressionresult_cvterm_fkey FOREIGN KEY (type_id) REFERENCES cvterm (cvterm_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
    UNIQUE (feature_id, biomaterial_id, quantification_id, type_id)
) 
WITH (
  OIDS = FALSE
)
;

CREATE TABLE diffexpresult
(
   diffexpresult_id serial, 
   analysis_id integer,
   "baseMean" double precision, 
   "baseMeanA" double precision, 
   "baseMeanB" double precision, 
   "foldChange" double precision, 
   "log2foldChange" double precision, 
   pval double precision, 
   pvaladj double precision, 
   CONSTRAINT diffexpresult_analysis_fkey FOREIGN KEY (analysis_id) REFERENCES analysis (analysis_id) ON UPDATE CASCADE ON DELETE NO ACTION,
   CONSTRAINT diffexpresult_pkey PRIMARY KEY (diffexpresult_id)
) 
WITH (
  OIDS = FALSE
)
;

CREATE TABLE diffexpresult_expressionresult
(
   id serial, 
   diffexpresult_id integer, 
   expressionresult_id integer, 
   samplegroup varchar(1), 
   CONSTRAINT diffexpresult_expressionresult_id PRIMARY KEY (id), 
   CONSTRAINT diffexpresult_expressionresult_diffexpresult_fkey FOREIGN KEY (diffexpresult_id) REFERENCES diffexpresult (diffexpresult_id)ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT diffexpresult_expressionresult_expressionresult_fkey FOREIGN KEY (expressionresult_id) REFERENCES expressionresult (expressionresult_id)ON UPDATE CASCADE ON DELETE NO ACTION,
   CHECK (samplegroup IN ('A', 'B'))
) 
WITH (
  OIDS = FALSE
)
;

CREATE TABLE webuser_data
(
  identity character varying,
  type_id integer,
  value text,
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