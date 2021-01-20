<?php
session_start();
include '../properties.php';

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

if ($_POST['spec'] != 'nope') {
    $sql = "
SELECT row_to_json(fc)
FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
FROM (SELECT 'Feature' As type
   , ST_AsGeoJSON( st_transform(lg.geom,4326) )::json As geometry
   , row_to_json(lp) As properties
  FROM $zones_specifiques As lg 
        INNER JOIN (SELECT id_zs as l_id, nom_zs as l_nom, ' layers.zones_specifiques ' as table_name FROM $zones_specifiques where nom_zs = '".$_POST["spec"]."' AND id_user = '".$_SESSION['email']."' ) As lp 
      ON lg.id_zs = lp.l_id ) As f )  As fc";
} else  {
        $sql = "
SELECT row_to_json(fc)
FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
FROM (SELECT 'Feature' As type
   , ST_AsGeoJSON( st_transform(ST_SnapToGrid(lg.l_geom, 0.0007),4326) )::json As geometry
   , row_to_json(lp) As properties
  FROM ".$_POST["table_name"]." As lg 
        INNER JOIN (SELECT l_id, l_nom, '".$_POST["table_name"]."' as table_name FROM ".$_POST["table_name"]." ) As lp 
      ON lg.l_id = lp.l_id ) As f )  As fc";
}
//echo $sql;
$query_result = pg_exec($dbconn,$sql) or die (pg_last_error());
while($row = pg_fetch_row($query_result))
{
  echo trim($row[0]);
}
//ferme la connexion a la BD
pg_close($dbconn);

?>