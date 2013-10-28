CREATE TABLE diffexpresult
(
   diffexpresult_id serial, 
   analysis_id integer,
   feature_id integer NOT NULL, 
   biomaterialA_id integer NOT NULL, 
   biomaterialB_id integer NOT NULL, 
   quantification_id integer NOT NULL,
   baseMean double precision, 
   baseMeanA double precision, 
   baseMeanB double precision, 
   foldChange double precision, 
   log2foldChange double precision, 
   pval double precision, 
   pvaladj double precision, 
   CONSTRAINT diffexpresult_analysis_fkey FOREIGN KEY (analysis_id) REFERENCES analysis (analysis_id) ON UPDATE CASCADE ON DELETE NO ACTION,
   CONSTRAINT diffexpresult_feature_fkey FOREIGN KEY (feature_id) REFERENCES feature (feature_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT diffexpresult_biomaterialA_fkey FOREIGN KEY (biomaterialA_id) REFERENCES biomaterial (biomaterial_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT diffexpresult_biomaterialB_fkey FOREIGN KEY (biomaterialB_id) REFERENCES biomaterial (biomaterial_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT diffexpresult_analysis_id_feature_id_biomateriala_id_bioma_key1 UNIQUE (analysis_id , feature_id , biomateriala_id , biomaterialb_id , quantification_id ),
   CONSTRAINT diffexpresult_quantification_fkey FOREIGN KEY (quantification_id) REFERENCES quantification (quantification_id) ON UPDATE CASCADE ON DELETE NO ACTION,
   CONSTRAINT diffexpresult_pkey PRIMARY KEY (diffexpresult_id)
) 
WITH (
  OIDS = FALSE
);
--NEWCMD--
CREATE INDEX ON diffexpresult (analysis_id);
--NEWCMD--
CREATE INDEX ON diffexpresult (biomaterialA_id);
--NEWCMD--
CREATE INDEX ON diffexpresult (biomaterialB_id);
--NEWCMD--
CREATE INDEX ON diffexpresult (quantification_id);
--NEWCMD--
CREATE INDEX ON diffexpresult (feature_id);