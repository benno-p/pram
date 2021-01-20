CREATE MATERIALIZED VIEW layers.layers_admin AS
(
SELECT l_id, l_nom, l_geom, l_table_name
  FROM layers.communes_2018
UNION
SELECT l_id, l_nom, l_geom, l_table_name
  FROM layers.epci_2018
);

CREATE INDEX layers_admin_idx_nom
  ON layers.layers_admin
  USING btree
  (l_nom COLLATE pg_catalog."default");
CREATE INDEX layers_admin_idx_id
  ON layers.layers_admin
  USING btree
  (l_id COLLATE pg_catalog."default");
CREATE INDEX admin_geom_idx
  ON layers.layers_admin
  USING gist
  (l_geom);