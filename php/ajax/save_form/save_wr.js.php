<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = 
"
INSERT INTO $restaurations (
wr_loc_id_plus, 
wr_date, 
wr_str, 
wr_cur, 
wr_repro, 
wr_etanc, 
wr_etanc_nature, 
wr_abat, 
wr_dessouch_nb, 
wr_elag_nb, 
wr_debrou_surf, 
wr_depol, 
wr_intro, 
wr_comt,
id_user)
 (
SELECT
  '".str_replace("'","''",$_POST['wr_loc_id_plus'])."' ,
  to_date('".str_replace("'","''",$_POST['wr_date'])."','DD-MM-YYYY'),
  '".str_replace("'","''",$_POST['wr_str'])."',
  '".str_replace("'","''",$_POST['wr_cur'])."',
  '".str_replace("'","''",$_POST['wr_repro'])."',
  '".str_replace("'","''",$_POST['wr_etanc'])."',
  '".str_replace("'","''",$_POST['wr_etanc_nature'])."',
  '".str_replace("'","''",$_POST['wr_abat'])."',
  '".str_replace("'","''",$_POST['wr_dessouch_nb'])."',
  '".str_replace("'","''",$_POST['wr_elag_nb'])."',
  '".str_replace("'","''",$_POST['wr_debrou_surf'])."',
  '".str_replace("'","''",$_POST['wr_depol'])."',
  '".str_replace("'","''",$_POST['wr_intro'])."',
  '".str_replace("'","''",$_POST['wa_comt'])."',
  '".str_replace("'","''",$_SESSION['email'])."'
);
";
pg_exec($dbconn,$sql) or die ( pg_last_error());
////ferme la connexion a la BD
pg_close($dbconn);

?>