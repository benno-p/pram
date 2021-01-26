with 
	travaux as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS travaux FROM odk_prod_rio."PRAM_OBS_DATA_INTERVENTION_TRAVAUX" group by 1
		),
	patrimoine as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS patrimoine FROM odk_prod_rio."PRAM_OBS_DATA_SITUATION_PATRIMOINE" group by 1
		),
	liaison as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS liaison FROM odk_prod_rio."PRAM_OBS_DATA_HYDROLOGIE_LIAISON" group by 1
		),
	dechet as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS dechet FROM odk_prod_rio."PRAM_OBS_DATA_USAGE_DECHETS" group by 1
		),
	alimentation as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS alimentation FROM odk_prod_rio."PRAM_OBS_DATA_HYDROLOGIE_ALIMENTATION" group by 1
		),
	contexte as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS contexte FROM odk_prod_rio."PRAM_OBS_DATA_SITUATION_CONTEXTE" group by 1
		),
	faune as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS faune FROM odk_prod_rio."PRAM_OBS_DATA_GLOBAL_GRP_FAUNE" group by 1
		),
	usage as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS usage FROM odk_prod_rio."PRAM_OBS_DATA_USAGE_USAGE_MARE" group by 1
		),
	eaee as (
		select "_PARENT_AURI", string_agg(replace("VALUE",'_',' '),'|') AS eaee FROM odk_prod_rio."PRAM_OBS_DATA_ECOLOGIE_EAEE_EAEE" group by 1
		),
	evee as (
		select "_PARENT_AURI", string_agg(replace("EVEE",'_',' ')||'__'||replace("EVEE_REC",'_',' '),'|') AS evee FROM odk_prod_rio."PRAM_OBS_DATA_ECOLOGIE_EVEE" group by 1
		)
select
o."_URI" as id_,
--car_id_plus,
--loc_id_plus,
--loc_id_strp,
"DATA_GLOBAL_DATE_MARE" as date_,
"EMAIL",
--car_strp,
"DATA_GLOBAL_TYPE_MARE",
"DATA_GLOBAL_VEG_AQUA",
"STADE_EVOL_STADE_EVO",
"DATA_USAGE_POMPE_NEZ",
"DATA_SITUATION_TOPO",
"TOPO_SPE",
"DATA_SITUATION_CLOTURE",
"DATA_SITUATION_HAIE",
"DATA_ABIOTIQUE_FORME",
"DATA_ABIOTIQUE_LONGUEUR",
"DATA_ABIOTIQUE_LARGEUR",
"DATA_ABIOTIQUE_NATURE_FOND",
"NATURE_FOND_SPE",
"DATA_ABIOTIQUE_BERGES",
"DATA_ABIOTIQUE_BOURRELET",
"BOURRELET_PRCT",
"DATA_ABIOTIQUE_SURPIETINEMENT",
"DATA_HYDROLOGIE_REGIME_HYDRO",
"DATA_HYDROLOGIE_TURBIDITE",
"DATA_HYDROLOGIE_COULEUR",
"DATA_HYDROLOGIE_ZONE_TAMPON",
"DATA_HYDROLOGIE_EXUTOIRE",
"DATA_ECOLOGIE_SUITE_REC_TOT",
"DATA_ECOLOGIE_DATA_ECOLOGIE_HELO_REC1",
"DATA_ECOLOGIE_DATA_ECOLOGIE_HYDRO_REC2",
"DATA_ECOLOGIE_DATA_ECOLOGIE_HYNE_REC3",
"DATA_ECOLOGIE_DATA_ECOLOGIE_ALG_REC4",
"DATA_ECOLOGIE_DATA_ECOLOGIE_EAU_REC5",
"DATA_ECOLOGIE_SUITE_EMBROUSSAILLEMENT",
"DATA_ECOLOGIE_SUITE_OMBRAGE",
"SCHEMA_MARE_CMT_MARE",
"DATA_ECOLOGIE_DATA_ECOLOGIE_FON_REC6",
patrimoine."VALUE",
"PATRIMOINE_SPE",
"COULEUR_SPE",
"DATA_INTERVENTION_OBJECTIFS",
travaux.travaux,
liaison.liaison,
dechet.dechet,
alimentation.alimentation,
contexte.contexte,
faune.faune,
usage.usage,
--"DATA_SITUATION_PATRIMOINE.VALUE",
eaee.eaee,
evee.evee,
"EMAIL",
"GRP_FAUNE_SPE",
"LIAISON_SPE",
"ALIMENTATION_SPE"
FROM odk_prod_rio."PRAM_OBS_CORE" o
	LEFT JOIN odk_prod_rio."PRAM_OBS_DATA_SITUATION_PATRIMOINE" patrimoine on (o."_URI" = patrimoine."_PARENT_AURI")
	LEFT JOIN travaux on (o."_URI" = travaux."_PARENT_AURI")
	LEFT JOIN liaison on (o."_URI" = liaison."_PARENT_AURI")
	LEFT JOIN dechet on (o."_URI" = dechet."_PARENT_AURI")
	LEFT JOIN alimentation on (o."_URI" = alimentation."_PARENT_AURI" )
	LEFT JOIN contexte on (o."_URI" = contexte."_PARENT_AURI")
	LEFT JOIN faune on (o."_URI" = faune."_PARENT_AURI" )
	LEFT JOIN usage on (o."_URI" = usage."_PARENT_AURI" )
	LEFT JOIN eaee on (o."_URI" = eaee."_PARENT_AURI")
	LEFT JOIN evee on (o."_URI" =evee."_PARENT_AURI" )

	
