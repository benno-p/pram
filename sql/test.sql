SELECT 
c.car_id, c.car_id_plus, l.loc_id_plus, loc_id_strp, c.car_date, c.car_obsv, c.car_strp, c.car_type, c.car_veget, c.car_evolution, c.car_abreuv, c.car_topo, 
c.car_topo_autre, c.car_cloture, c.car_haie, c.car_form, c.car_long, c.car_larg, 
c.car_prof, c.car_natfond, c.car_natfond_autre, c.car_berges, c.car_bourrelet, 
c.car_bourrelet_pourcentage, c.car_pietinement, c.car_hydrologie, c.car_turbidite, 
c.car_couleur, c.car_tampon, c.car_exutoire, c.car_recou_total, c.car_recou_helophyte, 
c.car_recou_hydrophyte_e, c.car_recou_hydrophyte_ne, c.car_recou_algue, 
c.car_recou_eau_libre, c.car_embrous, c.car_ombrage, c.car_comt, c.car_recou_non_veget, 
c.car_patrimoine, c.car_patrimoine_autre, c.car_couleur_precision, 
c.car_objec_trav, c.car_travaux, c.car_liaison, c.car_dechet, c.car_alimentation, 
c.car_contexte, c.car_faune, c.car_usage, c.car_bati, c.car_eaee, c.car_evee,
p.photo_link--,
--com.l_id,
--com.l_nom
  FROM 
  mares.caracterisations c 
    LEFT JOIN mares.localisations l ON (c.loc_id_plus = l.loc_id_plus)
    LEFT JOIN mares.photos p ON (c.loc_id_plus = p.id_plus)
    --LEFT JOIN layers.communes_2018 com ON st_intersects(l.loc_geom, com.l_geom)
  --where p.car is true
