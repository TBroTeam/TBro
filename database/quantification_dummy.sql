
INSERT INTO contact (name) VALUES ('dummymanufacturer');
INSERT INTO arraydesign (manufacturer_id, platformtype_id, name) VALUES (currval('contact_contact_id_seq'),1,'dummy');
INSERT INTO contact (name) VALUES ('dummy');
INSERT INTO assay (name, arraydesign_id, operator_id) VALUES ('dummy', currval('arraydesign_arraydesign_id_seq'), currval('contact_contact_id_seq'));
INSERT INTO acquisition (assay_id) VALUES ( currval('assay_assay_id_seq')   );
INSERT INTO analysis (program, programversion) VALUES ('dummy', 'dummyver');
INSERT INTO quantification (quantification_id, acquisition_id, analysis_id) VALUES (1, currval('acquisition_acquisition_id_seq'),  currval('analysis_analysis_id_seq') );
