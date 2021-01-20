<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql =
"
UPDATE $localisations 
set 
loc_nom = '".str_replace("'","''",$_POST['loc_nom'])."', 
loc_type_propriete = '".str_replace("'","''",$_POST['loc_type_propriete'])."', 
loc_statut = '".str_replace("'","''",$_POST['loc_statut'])."', 
loc_date = '".str_replace("'","''",$_POST['loc_date'])."', 
loc_obsv = '".str_replace("'","''",$_SESSION['nom_prenom'])."', 
loc_comt = '".str_replace("'","''",$_POST['loc_comt'])."', 
loc_anonymiser = '".str_replace("'","''",$_POST['loc_anonymiser'])."', 
loc_geom = st_setsrid(st_makepoint(".str_replace("'","''",$_POST['x']).", ".str_replace("'","''",$_POST['y'])."),4326), 
loc_id_user = '".str_replace("'","''",$_SESSION['email'])."'
WHERE loc_id_plus = '".str_replace("'","''",$_POST['id'])."';
";

echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo "true";
} else {
    echo "false";
}

////ferme la connexion a la BD
pg_close($dbconn);

?>