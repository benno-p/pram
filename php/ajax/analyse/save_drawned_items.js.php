<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = "
INSERT INTO $zones_specifiques (id_user, id_zs, nom_zs,geom,date ) (
WITH data AS (SELECT '".str_replace("\r", "\n",str_replace("'","''",$_POST["temp_geoson"]))."'::json AS fc)
SELECT
  '".$_SESSION['email']."' as id_user,
  '".str_replace("'","''",$_POST['temp_name'])."',
  '".str_replace("'","''",$_POST['temp_name'])."',
  ST_GeomFromGeoJSON(feat->>'geometry') AS geom,
  current_date
FROM (
  SELECT json_array_elements(fc->'features') AS feat
  FROM data
) AS f
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