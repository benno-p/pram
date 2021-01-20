<?php
session_start();
include '../properties.php';

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$sql = "
SELECT row_to_json(fc)
FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
FROM (SELECT 'Feature' As type
   , ST_AsGeoJSON( st_transform(lg.loc_geom,4326) )::json As geometry
   , row_to_json(lp) As properties
  FROM mares.localisations As lg 
        INNER JOIN (SELECT loc_id_plus, loc_nom, loc_statut, loc_geom, st_y(loc_geom) as loc_y, st_x(loc_geom) as loc_x, loc_date, loc_type_propriete, loc_obsv, loc_comt, car_ids, obs_ids, tra_ids , blb_ids , 
        CASE WHEN loc_id_user = '".$_SESSION['email']."' THEN 'true'::boolean ELSE 'false'::boolean END as mine_loc 
        FROM $localisations WHERE loc_id_plus ~* replace('".$_POST["term"]."', '+','\+') or loc_nom ~* '".$_POST["term"]."' ) As lp 
      ON lg.loc_id_plus = lp.loc_id_plus  ) As f )  As fc
";
//execute la requete dans le moteur de base de donnees  
$query_result = pg_query($dbconn,$sql) or die ( pg_last_error());
while($row = pg_fetch_row($query_result))
{
  echo trim($row[0]);
}
//ferme la connexion a la BD
pg_close($dbconn);

?>