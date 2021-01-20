
--cloture
update mares.caracterisations set 
car_cloture = (select clot."CLOTURE"::text from menu_deroulant.c_cloture clot where clot."ID" = caracterisations."car_cloture"::bigint)
--type
update mares.caracterisations set 
car_veget = (select clot."VEGET"::text from menu_deroulant.c_veget clot where clot."ID" = caracterisations."car_veget"::bigint)
--veget
update mares.caracterisations set 
car_veget = (select clot."VEGET"::text from menu_deroulant.c_veget clot where clot."ID" = caracterisations."car_veget"::bigint)
--evolution
update mares.caracterisations set 
car_evolution = (select clot."EVOLUTION"::text from menu_deroulant.c_evolution clot where clot."ID" = caracterisations."car_evolution"::bigint)
--abreuv
update mares.caracterisations set 
car_abreuv = (select clot."ABREUV"::text from menu_deroulant.c_abreuv clot where clot."ID" = caracterisations."car_abreuv"::bigint)
--topo
update mares.caracterisations set 
car_topo = (select clot."TOPO"::text from menu_deroulant.c_topo clot where clot."ID" = caracterisations."car_topo"::bigint)
--haie
update mares.caracterisations set 
car_haie = (select clot."HAIE"::text from menu_deroulant.c_haie clot where clot."ID" = caracterisations."car_haie"::bigint)
--form
update mares.caracterisations set 
car_form = (select clot."FORM"::text from menu_deroulant.c_form clot where clot."ID" = caracterisations."car_form"::bigint)
--natfond
update mares.caracterisations set 
car_natfond = (select clot."NATFOND"::text from menu_deroulant.c_natfond clot where clot."ID" = caracterisations."car_natfond"::bigint)
--berges
update mares.caracterisations set 
car_berges = (select clot."BERGES"::text from menu_deroulant.c_berges clot where clot."ID" = caracterisations."car_berges"::bigint)
--bourrelet
update mares.caracterisations set 
car_bourrelet = (select clot."BOURRELET"::text from menu_deroulant.c_bourrelet clot where clot."ID" = caracterisations."car_bourrelet"::bigint)
--pietinement
update mares.caracterisations set 
car_pietinement = (select clot."PIETINEMENT"::text from menu_deroulant.c_pietinement clot where clot."ID" = caracterisations."car_pietinement"::bigint)
--hydro
update mares.caracterisations set 
car_hydrologie = (select clot."HYDROLOGIE"::text from menu_deroulant.c_hydrologie clot where clot."ID" = caracterisations."car_hydrologie"::bigint)
--turbidite
update mares.caracterisations set 
car_turbidite = (select clot."TURBIDITE"::text from menu_deroulant.c_turbidite clot where clot."ID" = caracterisations."car_turbidite"::bigint)
--couleur
update mares.caracterisations set 
car_couleur = (select clot."COULEUR"::text from menu_deroulant.c_couleur clot where clot."ID" = caracterisations."car_couleur"::bigint)
--tampon
update mares.caracterisations set 
car_tampon = (select clot."TAMPON"::text from menu_deroulant.c_tampon clot where clot."ID" = caracterisations."car_tampon"::bigint)
--exutoire
update mares.caracterisations set 
car_exutoire = (select clot."EXUTOIRE"::text from menu_deroulant.c_exutoire clot where clot."ID" = caracterisations."car_exutoire"::bigint)
--embrouss
update mares.caracterisations set 
car_embrous = (select clot."EMBROUS"::text from menu_deroulant.c_embrous clot where clot."ID" = caracterisations."car_embrous"::bigint)
--ombrage
update mares.caracterisations set 
car_ombrage = (select clot."OMBRAGE"::text from menu_deroulant.c_ombrage clot where clot."ID" = caracterisations."car_ombrage"::bigint)
--liaison
--update mares.caracterisations set 
--car_liaison = (select string_agg(cl."LIAISON"::text, '|') as agg from saisie_observation.caracterisation_liaison liaison, menu_deroulant.c_liaison cl where caracterisation."ID_CARAC" = liaison."ID_CARAC" and cl."ID" = liaison."LIAISON"  order by 1 )  as liaison,
--dechets
--patrimpoine
--alimenation
--contexte
--faune
--travaux
--usage










select distinct(car_natfond) from mares.caracterisations;















