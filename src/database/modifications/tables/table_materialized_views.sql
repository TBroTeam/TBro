
CREATE TABLE matviews (
  mv_name NAME NOT NULL PRIMARY KEY
  , v_name NAME NOT NULL
  , last_refresh TIMESTAMP WITH TIME ZONE
);