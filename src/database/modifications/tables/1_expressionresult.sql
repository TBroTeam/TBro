CREATE TABLE IF NOT EXISTS expressionresult
(
   expressionresult_id serial, 
   analysis_id integer NOT NULL,
   feature_id integer NOT NULL, 
   biomaterial_id integer NOT NULL, 
   quantification_id integer NOT NULL, 
   value double precision NOT NULL, 
   CONSTRAINT expressionresult_pkey PRIMARY KEY (expressionresult_id), 
   CONSTRAINT expressionresult_feature_fkey FOREIGN KEY (feature_id) REFERENCES feature (feature_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT expressionresult_biomaterial_fkey FOREIGN KEY (biomaterial_id) REFERENCES biomaterial (biomaterial_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT expressionresult_quantification_fkey FOREIGN KEY (quantification_id) REFERENCES quantification (quantification_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT expressionresult_analysis_fkey FOREIGN KEY (analysis_id) REFERENCES analysis (analysis_id) ON UPDATE CASCADE ON DELETE NO ACTION,
    UNIQUE (feature_id, biomaterial_id, quantification_id, analysis_id)
) 
WITH (
  OIDS = FALSE
);