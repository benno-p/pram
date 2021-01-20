<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

//pg_exec($dbconn,"DELETE FROM $observations WHERE loc_id_plus = '".$_POST['loc_id_plus']."'") or die ( pg_last_error());

$sql = 
"
INSERT INTO $observations (
loc_id_plus, o_date, o_nom_complet,o_nombre,o_comt,o_observateur, id_user
) (
SELECT
  '".str_replace("'","''",$_POST['loc_id_plus'])."' ,
  to_date('".str_replace("'","''",$_POST['date'])."','DD-MM-YYYY'),
  '".str_replace("'","''",$_POST['nom_complet'])."',
  '".str_replace("'","''",$_POST['effectif'])."',
  '".str_replace("'","''",$_POST['comt'])."',
  '".str_replace("'","''",$_POST['obs'])."',
  '".str_replace("'","''",$_SESSION['email'])."'
);
";
$result = pg_exec($dbconn,$sql) or die ( pg_last_error());
echo $result;
////ferme la connexion a la BD
pg_close($dbconn);

?>