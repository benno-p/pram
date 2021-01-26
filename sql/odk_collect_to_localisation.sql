INSERT INTO mares.localisations(
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
        replace("_URI"::text, 'uuid:',''),
        "DATA_GLOBAL_ID_MARE"::text,
		"DATA_GLOBAL_TYPE_PROPR"::text,
		"DATA_GLOBAL_TYPE_MARE"::text,
        "EMAIL",
        "DATA_GLOBAL_DATE_MARE"::timestamp::date, 
        now()::date,
        'pending'::text,
        "MARE_GEOPOINT_LNG", 
        "MARE_GEOPOINT_LAT",
		(SELECT replace(TRIM(photo."_URI", 'uuid:'), '-','')||'.jpg' 
		 FROM odk_prod_rio."PRAM_OBS_AJOUT_PHOTO" ap
    		LEFT JOIN odk_prod_rio."PRAM_OBS_PHOTO_MARE_PHOTO_OBS_BN" blb_bn ON (((ap."_URI")::text = (blb_bn."_PARENT_AURI")::text))
    		LEFT JOIN odk_prod_rio."PRAM_OBS_PHOTO_MARE_PHOTO_OBS_REF" blb_ref ON (((blb_bn."_URI")::text = (blb_ref."_DOM_AURI")::text))
    		LEFT JOIN odk_prod_rio."PRAM_OBS_PHOTO_MARE_PHOTO_OBS_BLB" photo ON (((blb_ref."_SUB_AURI")::text = (photo."_URI")::text))
		WHERE (((ap."_PARENT_AURI")::text = ("PRAM_OBS_CORE"."_URI")::text))
		 LIMIT 1
		) as photo_mare_id
    FROM odk_prod_rio."PRAM_OBS_CORE"
    WHERE "_URI" = NEW."_URI";
