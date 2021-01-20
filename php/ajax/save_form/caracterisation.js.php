<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$result = pg_prepare($dbconn, "sql", "
INSERT INTO $caracterisations (
loc_id_plus, car_date, car_obsv, 
car_type, car_faune, car_faune_autre, car_veget, car_evolution, 
car_abreuv, car_topo, car_topo_autre, car_cloture, car_haie, car_form, car_long, car_larg, 
car_prof, car_natfond, car_natfond_autre, car_berges, car_bourrelet, 
car_bourrelet_pourcentage, car_pietinement, 
car_hydrologie, car_turbidite, car_couleur, car_tampon, car_exutoire, car_recou_total, car_recou_helophyte, 
car_recou_hydrophyte_e, car_recou_hydrophyte_ne, car_recou_algue, 
car_recou_eau_libre, car_embrous, car_ombrage, car_comt, car_recou_non_veget, 
car_patrimoine, car_patrimoine_autre, car_couleur_precision, 
car_objec_trav, car_travaux, car_liaison, car_dechet, car_alimentation, 
car_contexte, car_usage, car_bati, car_eaee, car_evee, 
car_liaison_autre, car_alimentation_autre, car_travaux_autre,
car_id_user
) 
(
SELECT
$1,$2,$3,$4,$5,$6,$7,$8,$9,$10,
$11,$12,$13,$14,
coalesce($15, 0),
coalesce($16, 0),
$17,$18,$19,$20,
$21,$22,$23,$24,$25,$26,$27,$28,
coalesce($29, 0),
coalesce($30, 0),
coalesce($31, 0),
coalesce($32, 0),
coalesce($33, 0),
coalesce($34, 0),
$35,$36,$37,
coalesce($38, 0),
$39,$40,
$41,$42,$43,$44,$45,$46,$47,$48,$49,$50,
$51,$52,$53,$54,$55)
");
$result = pg_execute($dbconn, "sql",array(
$_POST['loc_id_plus'],
 $_POST['car_date'],
 $_SESSION['nom_prenom'],
 $_POST['car_type'],
 $_POST['grp_faune'],
 $_POST['grp_faune_autre'],
 $_POST['car_veget'],
 $_POST['car_stade'],
 $_POST['car_pompe'],
 $_POST['car_topo'],
 $_POST['car_topo_autre'],
 $_POST['car_cloture'],
 $_POST['car_haie'],
 $_POST['car_forme'],
 $_POST['car_long'],
 $_POST['car_larg'],
 $_POST['car_hauteur'],
 $_POST['car_fond'],
 $_POST['car_fond_autre'],
 $_POST['car_berges'],
 $_POST['car_bourrelet'],
 $_POST['car_bourrelet_prct'],
 $_POST['car_surpietinement'],
 $_POST['car_hydrologie'],
 $_POST['car_turbidite'],
 $_POST['car_couleur'],
 $_POST['car_tampon'],
 $_POST['car_exutoire'],
 $_POST['rec_total'],
 $_POST['c_recou_helophyte'],
 $_POST['c_recou_hydrophyte_e'],
 $_POST['c_recou_hydrophyte_ne'],
 $_POST['c_recou_algue'],
 $_POST['c_recou_eau_libre'],
 $_POST['car_embroussaillement'],
 $_POST['car_ombrage'],
 $_POST['car_comt'],
 $_POST['c_recou_non_veget'],
 $_POST['car_patrimoine'],
 $_POST['car_patrimoine_autre'],
 $_POST['car_couleur_autre'],
 $_POST['car_objec_trav'],
 $_POST['car_travaux'],
 $_POST['car_liaisons'],
 $_POST['car_dechets'],
 $_POST['car_alimentations'],
 $_POST['car_contextes'],
 $_POST['car_usages'],
 $_POST['car_patrimoine'],
 $_POST['car_eaee'],
 $_POST['car_evee'],
 $_POST['car_liaisons_autre'],
 $_POST['car_alimentations_autre'],
 $_POST['car_travaux_autre'],
 $_SESSION['email']));


//echo $sql;
if ( $result ) {
    echo "true";
} else {
    echo "false";
}

////ferme la connexion a la BD
pg_close($dbconn);

?>