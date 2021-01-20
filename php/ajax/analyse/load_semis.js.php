<?php
session_start();
include '../../properties.php';

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());


$sql = "
SELECT row_to_json(fc)
FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
FROM (SELECT 'Feature' As type
   , ST_AsGeoJSON( st_transform(ST_SnapToGrid(lg.geom, 0.0000001),4326) )::json As geometry
   , row_to_json(lp) As properties
  FROM $semis As lg 
        INNER JOIN (SELECT id_semis, nom_semis, id_user, date_semis, composition FROM $semis where id_semis = '".$_POST["id_semis"]."' AND id_user = '".$_SESSION['email']."' ) As lp 
      ON lg.id_semis = lp.id_semis ) As f )  As fc";

//echo $sql;
$query_result = pg_exec($dbconn,$sql) or die (pg_last_error());
while($row = pg_fetch_row($query_result))
{
  echo trim($row[0]);
}
//ferme la connexion a la BD
pg_close($dbconn);

?>