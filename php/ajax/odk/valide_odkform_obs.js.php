<?php
session_start();
include "../../properties.php";

$id_locplus_generated = '';
id_car_generated = '';
$uuid_core = $_POST['uuid'];

// LOAD LIST PHOTO
$dbconn = pg_connect("hostaddr=$ODK_DBHOST port=$ODK_PORT dbname=$ODK_DBNAME user=$ODK_LOGIN password=$ODK_PASS")
or die ('Connexion impossible :'. pg_last_error());

//PG_PREPARE ne gere pas les champs en majuscules
$__uri = '"_URI"';
$__id = '"DATA_GLOBAL_ID_MARE"';
$__typeprop = '"DATA_GLOBAL_TYPE_PROPR"';
$__date = '"DATA_GLOBAL_DATE_MARE"';
$__cmt = '"SCHEMA_MARE_CMT_MARE"';
$__lng = '"MARE_GEOPOINT_LNG"';
$__lat = '"MARE_GEOPOINT_LAT"';


$result = pg_prepare($dbconn, "sql", "INSERT INTO $odk_pram_obs_fdw_localisation(
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
        (SELECT max(loc_id)+1 FROM $odk_pram_obs_fdw_localisation ),
        replace($__uri::text, 'uuid:','')::uuid,
        $__id,
        $__typeprop,
        'Caractérisée'::text,
        $__date::timestamp::date, 
        $1,
        $__cmt,
        $2,
        st_setsrid(st_makepoint($__lng, $__lat),4326),
        $3
    FROM $odk_pram_obs
    WHERE $__uri = $4;
    ");
$result = pg_execute($dbconn, "sql",array(
$_SESSION['nom_prenom'], 
true, 
$_SESSION['email'],
$_POST['uuid']
));
pg_close($dbconn);
/////////////////////////////////////////////
/////////////////////////////////////////////
/////////////////////////////////////////////
/////////////////////////////////////////////
/////////////////////////////////////////////
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS") or die ('Connexion impossible :'. pg_last_error());
$result = pg_prepare($dbconn, "sql", "SELECT * FROM $localisations WHERE loc_uuid::text = replace( $1::text, 'uuid:','') LIMIT 1");
$result = pg_execute($dbconn, "sql",array( $uuid_core ));
while($row = pg_fetch_array($result))
{
  //echo trim($row["loc_id"])." uuid ".$row["loc_uuid"];
  echo json_encode($row["loc_id_plus"]);
  $id_locplus_generated = $row["loc_id_plus"];
}
pg_close($dbconn);


$dbconn = pg_connect("hostaddr=$ODK_DBHOST port=$ODK_PORT dbname=$ODK_DBNAME user=$ODK_LOGIN password=$ODK_PASS") or die ('Connexion impossible :'. pg_last_error());
/////////////////////////////////////////////
/////////////////////////////////////////////
//insert mares.caracterisations
$___uri = '"_URI"';
$___parent_auri = '"_PARENT_AURI"';
$__value = '"VALUE"';
$__evee = '"EVEE"';
$__evee_rec = '"EVEE_REC"';
$__pram_obs_data_intervention_travaux = '"PRAM_OBS_DATA_INTERVENTION_TRAVAUX"';
$__pram_obs_data_situation_patrimoine = '"PRAM_OBS_DATA_SITUATION_PATRIMOINE"';
$__pram_obs_data_hydrologie_liaison = '"PRAM_OBS_DATA_HYDROLOGIE_LIAISON"';
$__pram_obs_data_usage_dechets = '"PRAM_OBS_DATA_USAGE_DECHETS"';
$__pram_obs_data_hydrologie_alimentation = '"PRAM_OBS_DATA_HYDROLOGIE_ALIMENTATION"';
$__pram_obs_data_situation_contexte = '"PRAM_OBS_DATA_SITUATION_CONTEXTE"';
$__pram_obs_data_global_grp_faune = '"PRAM_OBS_DATA_GLOBAL_GRP_FAUNE"';
$__pram_obs_data_usage_usage_mare = '"PRAM_OBS_DATA_USAGE_USAGE_MARE"';
$__pram_obs_data_ecologie_eaee_eaee = '"PRAM_OBS_DATA_ECOLOGIE_EAEE_EAEE"';
$__pram_obs_data_ecologie_evee = '"PRAM_OBS_DATA_ECOLOGIE_EVEE"';
$__data_global_date_mare = '"DATA_GLOBAL_DATE_MARE"';
$__data_global_type_mare = '"DATA_GLOBAL_TYPE_MARE"';
$__data_global_veg_aqua = '"DATA_GLOBAL_VEG_AQUA"';
$__stade_evol_stade_evo = '"STADE_EVOL_STADE_EVO"';
$__data_usage_pompe_nez = '"DATA_USAGE_POMPE_NEZ"';
$__data_situation_topo = '"DATA_SITUATION_TOPO"';
$__topo_spe = '"TOPO_SPE"';
$__data_situation_cloture = '"DATA_SITUATION_CLOTURE"';
$__data_situation_haie = '"DATA_SITUATION_HAIE"';
$__data_abiotique_forme = '"DATA_ABIOTIQUE_FORME"';
$__data_abiotique_longueur = '"DATA_ABIOTIQUE_LONGUEUR"';
$__data_abiotique_largeur = '"DATA_ABIOTIQUE_LARGEUR"';
$__data_abiotique_nature_fond = '"DATA_ABIOTIQUE_NATURE_FOND"';
$__nature_fond_spe = '"NATURE_FOND_SPE"';
$__data_abiotique_berges = '"DATA_ABIOTIQUE_BERGES"';
$__data_abiotique_bourrelet = '"DATA_ABIOTIQUE_BOURRELET"';
$__bourrelet_prct = '"BOURRELET_PRCT"';
$__data_abiotique_surpietinement = '"DATA_ABIOTIQUE_SURPIETINEMENT"';
$__data_hydrologie_regime_hydro = '"DATA_HYDROLOGIE_REGIME_HYDRO"';
$__data_hydrologie_turbidite = '"DATA_HYDROLOGIE_TURBIDITE"';
$__data_hydrologie_couleur = '"DATA_HYDROLOGIE_COULEUR"';
$__data_hydrologie_zone_tampon = '"DATA_HYDROLOGIE_ZONE_TAMPON"';
$__data_hydrologie_exutoire = '"DATA_HYDROLOGIE_EXUTOIRE"';
$__data_ecologie_suite_rec_tot = '"DATA_ECOLOGIE_SUITE_REC_TOT"';
$__data_ecologie_data_ecologie_helo_rec1 = '"DATA_ECOLOGIE_DATA_ECOLOGIE_HELO_REC1"';
$__data_ecologie_data_ecologie_hydro_rec2 = '"DATA_ECOLOGIE_DATA_ECOLOGIE_HYDRO_REC2"';
$__data_ecologie_data_ecologie_hyne_rec3 = '"DATA_ECOLOGIE_DATA_ECOLOGIE_HYNE_REC3"';
$__data_ecologie_data_ecologie_alg_rec4 = '"DATA_ECOLOGIE_DATA_ECOLOGIE_ALG_REC4"';
$__data_ecologie_data_ecologie_eau_rec5 = '"DATA_ECOLOGIE_DATA_ECOLOGIE_EAU_REC5"';
$__data_ecologie_suite_embroussaillement = '"DATA_ECOLOGIE_SUITE_EMBROUSSAILLEMENT"';
$__data_ecologie_suite_ombrage = '"DATA_ECOLOGIE_SUITE_OMBRAGE"';
$__schema_mare_cmt_mare = '"SCHEMA_MARE_CMT_MARE"';
$__data_ecologie_data_ecologie_fon_rec6 = '"DATA_ECOLOGIE_DATA_ECOLOGIE_FON_REC6"';
$__patrimoine_spe = '"PATRIMOINE_SPE"';
$__couleur_spe = '"COULEUR_SPE"';
$__data_intervention_objectifs = '"DATA_INTERVENTION_OBJECTIFS"';
$__grp_faune_spe = '"GRP_FAUNE_SPE"';
$__liaison_spe = '"LIAISON_SPE"';
$__alimentation_spe = '"ALIMENTATION_SPE"';
$__data_abiotique_hauteur_eau = '"DATA_ABIOTIQUE_HAUTEUR_EAU"';

$result = pg_prepare($dbconn, "sql", "
with 
travaux as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS travaux FROM $odk_prod_schema.$__pram_obs_data_intervention_travaux group by 1
    ),
patrimoine as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS patrimoine FROM $odk_prod_schema.$__pram_obs_data_situation_patrimoine group by 1
    ),
liaison as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS liaison FROM $odk_prod_schema.$__pram_obs_data_hydrologie_liaison group by 1
    ),
dechet as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS dechet FROM $odk_prod_schema.$__pram_obs_data_usage_dechets group by 1
    ),
alimentation as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS alimentation FROM $odk_prod_schema.$__pram_obs_data_hydrologie_alimentation group by 1
    ),
contexte as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS contexte FROM $odk_prod_schema.$__pram_obs_data_situation_contexte group by 1
    ),
faune as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS faune FROM $odk_prod_schema.$__pram_obs_data_global_grp_faune group by 1
    ),
usage as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS usage FROM $odk_prod_schema.$__pram_obs_data_usage_usage_mare group by 1
    ),
eaee as (
    select $___parent_auri, string_agg(replace($__value,'_',' '),'|') AS eaee FROM $odk_prod_schema.$__pram_obs_data_ecologie_eaee_eaee group by 1
    ),
evee as (
    select $___parent_auri, string_agg(replace($__evee,'_',' ')||'__'||replace($__evee_rec,'_',' '),'|') AS evee FROM $odk_prod_schema.$__pram_obs_data_ecologie_evee group by 1
    )
INSERT INTO
fdw.caracterisations ( 
loc_id_plus, 
loc_id_strp, 
car_date, 
car_obsv,  car_strp,  car_type,  car_veget,  car_evolution,  car_abreuv,  car_topo,  car_topo_autre,  car_cloture,  car_haie,  car_form,  car_long,  car_larg,  car_natfond,  car_natfond_autre,  car_berges,  car_bourrelet,  car_bourrelet_pourcentage,  car_pietinement,  car_hydrologie,  car_turbidite,  car_couleur,  car_tampon,  car_exutoire,  car_recou_total,  car_recou_helophyte,  car_recou_hydrophyte_e,  car_recou_hydrophyte_ne,  car_recou_algue,  car_recou_eau_libre,  car_embrous,  car_ombrage,  car_comt,  car_recou_non_veget,  car_patrimoine,  car_patrimoine_autre,  car_couleur_precision,  car_objec_trav,  car_travaux,  car_liaison,  car_dechet,  car_alimentation,  car_contexte,  car_faune,  car_usage,  car_bati,  car_eaee,  car_evee,  car_id_user,  car_faune_autre,  car_liaison_autre,  car_alimentation_autre,  car_prof
)
select 
$1, 
$2 as loc_id_strp, 
$__data_global_date_mare as date_, 
$3, $2 as car_strp, $__data_global_type_mare, $__data_global_veg_aqua, $__stade_evol_stade_evo, $__data_usage_pompe_nez, $__data_situation_topo, $__topo_spe, $__data_situation_cloture, $__data_situation_haie, $__data_abiotique_forme, $__data_abiotique_longueur, $__data_abiotique_largeur, $__data_abiotique_nature_fond, $__nature_fond_spe, $__data_abiotique_berges, $__data_abiotique_bourrelet, $__bourrelet_prct, $__data_abiotique_surpietinement, $__data_hydrologie_regime_hydro, $__data_hydrologie_turbidite, $__data_hydrologie_couleur, $__data_hydrologie_zone_tampon, $__data_hydrologie_exutoire, $__data_ecologie_suite_rec_tot::integer, $__data_ecologie_data_ecologie_helo_rec1, $__data_ecologie_data_ecologie_hydro_rec2, $__data_ecologie_data_ecologie_hyne_rec3, $__data_ecologie_data_ecologie_alg_rec4, $__data_ecologie_data_ecologie_eau_rec5, $__data_ecologie_suite_embroussaillement, $__data_ecologie_suite_ombrage, $__schema_mare_cmt_mare, $__data_ecologie_data_ecologie_fon_rec6, patrimoine.patrimoine, $__patrimoine_spe, $__couleur_spe, $__data_intervention_objectifs, travaux.travaux, liaison.liaison, dechet.dechet, alimentation.alimentation, contexte.contexte, faune.faune, usage.usage, $2 as car_bati, eaee.eaee, evee.evee, $4 , $__grp_faune_spe, $__liaison_spe, $__alimentation_spe, $__data_abiotique_hauteur_eau 
FROM $odk_pram_obs o
    LEFT JOIN patrimoine on (o.$___uri = patrimoine.$___parent_auri)
    LEFT JOIN travaux on (o.$___uri = travaux.$___parent_auri)
    LEFT JOIN liaison on (o.$___uri = liaison.$___parent_auri)
    LEFT JOIN dechet on (o.$___uri = dechet.$___parent_auri)
    LEFT JOIN alimentation on (o.$___uri = alimentation.$___parent_auri )
    LEFT JOIN contexte on (o.$___uri = contexte.$___parent_auri)
    LEFT JOIN faune on (o.$___uri = faune.$___parent_auri )
    LEFT JOIN usage on (o.$___uri = usage.$___parent_auri )
    LEFT JOIN eaee on (o.$___uri = eaee.$___parent_auri)
    LEFT JOIN evee on (o.$___uri = evee.$___parent_auri )
");
$result = pg_execute($dbconn, "sql",array($id_locplus_generated, '', $_SESSION['nom_prenom'], $_SESSION['email'] ));


//update mares.localisations.car_ids
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS") or die ('Connexion impossible :'. pg_last_error());
$result = pg_prepare($dbconn, "sql", "SELECT MAX(car_id) FROM $caracterisations WHERE loc_id_plus::text = replace( $1::text, 'uuid:','') LIMIT 1");
$result = pg_execute($dbconn, "sql",array( $uuid_core ));
while($row = pg_fetch_array($result))
{
  $id_car_generated = $row["car_id"];
}
pg_close($dbconn);



//$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS") or die ('Connexion impossible :'. pg_last_error());
//$result = pg_prepare($dbconn, "sql", "UPDATE $suivi_odk set status = 'imported' WHERE uuid_core = $1 ");
//$result = pg_execute($dbconn, "sql",array( $uuid_core ));
//pg_close($dbconn);



?>