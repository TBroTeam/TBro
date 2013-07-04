CREATE INDEX feature_tbro_idx_1
  ON feature
  USING btree
  (name varchar_pattern_ops);
--NEWCMD--
ALTER TABLE feature
  ADD CONSTRAINT feature_dbxref_id_organism_id_name_key UNIQUE (dbxref_id, organism_id, name);