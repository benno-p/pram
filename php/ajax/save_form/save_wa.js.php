<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = 
"
INSERT INTO $amenagements (
wa_loc_id_plus, 
wa_date, 
wa_str, 
wa_hydrau, 
wa_hydrau_autre, 
wa_com, 
wa_enherb, 
wa_plant, 
wa_haie, 
wa_clot, 
wa_abreuv, 
wa_bati, 
wa_comt,
id_user) (
SELECT
  '".str_replace("'","''",$_POST['wa_loc_id_plus'])."' ,
  to_date('".str_replace("'","''",$_POST['wa_date'])."','DD-MM-YYYY'),
  '".str_replace("'","''",$_POST['wa_str'])."',
  '".str_replace("'","''",$_POST['wa_hydrau'])."',
  '".str_replace("'","''",$_POST['wa_hydrau_autre'])."',
  '".str_replace("'","''",$_POST['wa_com'])."',
  '".str_replace("'","''",$_POST['wa_enherb'])."',
  '".str_replace("'","''",$_POST['wa_plant'])."',
  '".str_replace("'","''",$_POST['wa_haie'])."',
  '".str_replace("'","''",$_POST['wa_clot'])."',
  '".str_replace("'","''",$_POST['wa_abreuv'])."',
  '".str_replace("'","''",$_POST['wa_bati'])."',
  '".str_replace("'","''",$_POST['wa_comt'])."',
  '".str_replace("'","''",$_SESSION['email'])."'
);
";
pg_exec($dbconn,$sql) or die ( pg_last_error());
////ferme la connexion a la BD
pg_close($dbconn);

?>