CREATE SEQUENCE quantificationresult_quantificationresult_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE quantificationresult_quantificationresult_id_seq
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