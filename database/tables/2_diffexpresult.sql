CREATE TABLE diffexpresult
(
   diffexpresult_id serial, 
   analysis_id integer,
   feature_id integer NOT NULL, 
   biomaterialA_id integer NOT NULL, 
   biomaterialB_id integer NOT NULL, 
   "baseMean" double precision, 
   "baseMeanA" double precision, 
   "baseMeanB" double precision, 
   "foldChange" double precision, 
   "log2foldChange" double precision, 
   pval double precision, 
   pvaladj double precision, 
   CONSTRAINT diffexpresult_analysis_fkey FOREIGN KEY (analysis_id) REFERENCES analysis (analysis_id) ON UPDATE CASCADE ON DELETE NO ACTION,
   CONSTRAINT diffexpresult_feature_fkey FOREIGN KEY (feature_id) REFERENCES feature (feature_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT diffexpresult_biomaterialA_fkey FOREIGN KEY (biomaterialA_id) REFERENCES biomaterial (biomaterial_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT diffexpresult_biomaterialB_fkey FOREIGN KEY (biomaterialB_id) REFERENCES biomaterial (biomaterial_id) ON UPDATE CASCADE ON DELETE NO ACTION, 
   CONSTRAINT diffexpresult_pkey PRIMARY KEY (diffexpresult_id)
) 
WITH (
  OIDS = FALSE
);