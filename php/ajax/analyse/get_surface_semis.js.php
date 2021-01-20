<?php
session_start();
include '../../properties.php';


//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = "
    SELECT round((st_area(st_transform(geom,2154))/1000000)::numeric,0) as surface_km FROM $semis WHERE id_semis = '".$_POST["id_semis"]."' and id_user = '".$_SESSION['email']."' 
    ";
        
$query_result = pg_exec($dbconn,$sql) or die (pg_last_error());
while($row = pg_fetch_row($query_result))
{
echo trim($row[0]);
}

//ferme la connexion a la BD
pg_close($dbconn);

?>





