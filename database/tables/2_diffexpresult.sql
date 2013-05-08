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
);