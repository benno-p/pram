<?php
session_start();
include "../../properties.php";



//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = 
"
INSERT INTO $semis_tmp ( id_user, id_zone, nom_zone, table_name, nom_semis, geom ) (
WITH data AS (SELECT '".str_replace("\r", "\n",str_replace("'","''",$_POST["geom"]))."'::json AS fc)
SELECT
  '".$_SESSION['email']."' ,
  '".str_replace("'","''",$_POST['id'])."',
  '".str_replace("'","''",$_POST['name'])."',
  '".str_replace("'","''",$_POST['table_name'])."',
  '".str_replace("'","''",$_POST['semis'])."',
  ST_GeomFromGeoJSON(fc->>'geometry') AS geom
FROM  data
);
";

//echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo "true";
} else {
    echo "false";
}

////ferme la connexion a la BD
pg_close($dbconn);

?>