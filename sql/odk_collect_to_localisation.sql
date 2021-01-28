INSERT INTO fdw.localisations(
loc_id,
loc_uuid, 
loc_nom, 
loc_type_propriete, 
loc_statut,
loc_date, 
loc_obsv, 
loc_comt, 
loc_anonymiser, 
loc_geom, 
loc_id_user)
 SELECT
 		(SELECT max(loc_id)+1 FROM fdw.localisations ),
        replace("_URI"::text, 'uuid:','')::uuid,
        "DATA_GLOBAL_ID_MARE"::text,
		"DATA_GLOBAL_TYPE_PROPR"::text,
		'caractérisée'::text,
		"DATA_GLOBAL_DATE_MARE"::timestamp::date, 
		'$_SESSION[''nom_prenom'']',
		"SCHEMA_MARE_CMT_MARE",
		true,
		st_setsrid(st_makepoint("MARE_GEOPOINT_LNG","MARE_GEOPOINT_LAT"),4326),
    "EMAIL"
    FROM odk_prod_rio."PRAM_OBS_CORE"
    WHERE "_URI" = 'uuid:d88a7080-a8b8-48af-aea0-10a2972c735f';
