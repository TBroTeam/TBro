DROP TABLE IF EXISTS expressionresult_quantificationresult;
DROP TABLE IF EXISTS expressionresult;
DROP TABLE IF EXISTS quantificationresult;

DROP SEQUENCE IF EXISTS expressionresult_quantificationresult;
DROP SEQUENCE IF EXISTS expressionresult_expressionresult_id_seq;
DROP SEQUENCE IF EXISTS quantificationresult_quantificationresult_id_seq;

CREATE SEQUENCE quantificationresult_quantificationresult_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE quantificationresult_quantificationresult_id_seq
  OWNER TO s202139;

CREATE SEQUENCE expressionresult_expressionresult_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE expressionresult_expressionresult_id_seq
  OWNER TO s202139;


CREATE TABLE quantificationresult
(
   quantificationresult_id integer DEFAULT nextval('quantificationresult_quantificationresult_id_seq'::regclass) NOT NULL, 
   feature_id integer NOT NULL, 
   biomaterial_id integer NOT NULL, 
   quantification_id integer NOT NULL, 
   type_id integer NOT NULL, 
   value double precision NOT NULL, 
   CONSTRAINT quantificationresult_pkey PRIMARY KEY (quantificationresult_id), 
   CONSTRAINT quantificationresult_feature_fkey FOREIGN KEY (feature_id) REFERENCES feature (feature_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT quantificationresult_biomaterial_fkey FOREIGN KEY (biomaterial_id) REFERENCES biomaterial (biomaterial_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT quantificationresult_quantification_fkey FOREIGN KEY (quantification_id) REFERENCES quantification (quantification_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT quantificationresult_cvterm_fkey FOREIGN KEY (type_id) REFERENCES cvterm (cvterm_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
    UNIQUE (feature_id, biomaterial_id, quantification_id, type_id)
) 
WITH (
  OIDS = FALSE
)
;

CREATE TABLE expressionresult
(
   expressionresult_id integer DEFAULT nextval('expressionresult_expressionresult_id_seq'::regclass), 
   analysis_id integer,
   "baseMean" double precision, 
   "baseMeanA" double precision, 
   "baseMeanB" double precision, 
   "foldChange" double precision, 
   "log2foldChange" double precision, 
   pval double precision, 
   pvaladj double precision, 
   CONSTRAINT expressionresult_analysis_fkey FOREIGN KEY (analysis_id) REFERENCES analysis (analysis_id) ON UPDATE CASCADE ON DELETE NO ACTION,
   CONSTRAINT expressionresult_pkey PRIMARY KEY (expressionresult_id)
) 
WITH (
  OIDS = FALSE
)
;

CREATE TABLE expressionresult_quantificationresult
(
   id serial, 
   expressionresult_id integer, 
   quantificationresult_id integer, 
   samplegroup varchar(1), 
   CONSTRAINT expressionresult_quantificationresult_id PRIMARY KEY (id), 
   CONSTRAINT expressionresult_quantificationresult_expressionresult_fkey FOREIGN KEY (expressionresult_id) REFERENCES expressionresult (expressionresult_id)ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT expressionresult_quantificationresult_quantificationresult_fkey FOREIGN KEY (quantificationresult_id) REFERENCES quantificationresult (quantificationresult_id)ON UPDATE CASCADE ON DELETE NO ACTION,
   CHECK (samplegroup IN ('A', 'B'))
) 
WITH (
  OIDS = FALSE
)
;
