<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = 
"
INSERT INTO $creations (
 wc_loc_id_plus, wc_date, wc_str, wc_obj, wc_cmt, id_user) (
SELECT
  '".str_replace("'","''",$_POST['wc_loc_id_plus'])."' ,
  to_date('".str_replace("'","''",$_POST['wc_date'])."','DD-MM-YYYY'),
  '".str_replace("'","''",$_POST['wc_str'])."',
  '".str_replace("'","''",$_POST['wc_obj'])."',
  '".str_replace("'","''",$_POST['wc_comt'])."',
  '".str_replace("'","''",$_SESSION['email'])."'
);
";
pg_exec($dbconn,$sql) or die ( pg_last_error());
////ferme la connexion a la BD
pg_close($dbconn);

?>