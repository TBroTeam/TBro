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
);