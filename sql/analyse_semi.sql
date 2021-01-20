WITH mares as (
SELECT 
l.loc_id_plus,l.loc_statut,car_date,car_obsv,car_type,car_veget,car_evolution,car_abreuv,
car_topo,car_topo_autre,car_cloture,car_haie,car_form,car_long,car_larg,car_prof,
car_natfond,car_natfond_autre,car_berges,car_bourrelet,car_bourrelet_pourcentage,
car_pietinement,car_hydrologie,car_turbidite,car_couleur,car_tampon,car_exutoire,
car_recou_total,car_recou_helophyte,car_recou_hydrophyte_e,car_recou_hydrophyte_ne,car_recou_algue,car_recou_eau_libre,
car_recou_non_veget,car_embrous,car_ombrage,car_comt,car_liaison,car_dechet,car_bati,car_alimentation,car_contexte,
car_faune,car_travaux,car_usage,loc_geom,car_eaee,car_evee
FROM 
(
    SELECT loc.loc_id_plus, loc.loc_statut, loc.loc_geom
    FROM mares.localisations loc 
    ORDER BY 1 
) AS l LEFT JOIN 
( 
SELECT DISTINCT ON (loc_id_plus) 
car_id_plus,loc_id_plus,loc_id_strp,car_date,car_obsv,car_strp,car_type,car_veget,car_evolution,
car_abreuv,car_topo,car_topo_autre,car_cloture,car_haie,car_form,car_long,car_larg,car_prof,car_natfond,
car_natfond_autre,car_berges,car_bourrelet,car_bourrelet_pourcentage,car_pietinement,car_hydrologie,car_turbidite,
car_couleur,car_tampon,car_exutoire,car_recou_total,car_recou_helophyte,car_recou_hydrophyte_e,car_recou_hydrophyte_ne,
car_recou_algue,car_recou_eau_libre,car_recou_non_veget,car_embrous,car_ombrage,car_comt,car_long*car_larg as surface_m2,
car_travaux,car_liaison,car_dechet,car_alimentation,car_contexte,car_faune,car_usage,car_bati,car_eaee,
car_evee
FROM mares.caracterisations 
ORDER BY loc_id_plus, car_date DESC 
) AS c 
ON (l.loc_id_plus = c.loc_id_plus) 
WHERE st_intersects(loc_geom, (SELECT geom FROM layers.analyses limit 1))
AND loc_statut = 'Caractérisée'
order by 1)


SELECT row_to_json(fc)
FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
FROM (SELECT 'Feature' As type
   , ST_AsGeoJSON(lg.loc_geom)::json As geometry
   , row_to_json(lp) As properties
  FROM mares As lg 
        INNER JOIN (SELECT * FROM mares ) As lp 
      ON lg.loc_id_plus = lp.loc_id_plus ) As f )  As fc

