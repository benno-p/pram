<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = "
INSERT INTO $semis (
            id_semis, nom_semis, geom, id_user, date_semis, composition)
SELECT nom_semis, nom_semis, st_union(geom) as geom, id_user, current_date, string_agg( id_zone||'|'||nom_zone||'|'||table_name, '||') 
  FROM $semis_tmp
  group by 1,2,4,5;
";
//echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo "true";
} else {
    echo "false";
}

$sql ="
 delete from $semis_tmp ;
";
pg_exec($dbconn,$sql);
$sql ="
 update $semis set geom = st_setsrid(geom,4326);
";
pg_exec($dbconn,$sql);


////ferme la connexion a la BD
pg_close($dbconn);

?>