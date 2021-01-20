<?php
include '../properties.php';
//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$sql = "SELECT cd_nom , nom_complet, eee_type from $eee order by 2;";
//execute la requete dans le moteur de base de donnees  
$query_result = pg_exec($dbconn,$sql) or die (pgErrorMessage());
while($row = pg_fetch_row($query_result))
{
  echo trim($row[0]).'__'.trim($row[1]).'__'.trim($row[2]).'|';
}
//ferme la connexion a la BD
pg_close($dbconn);

?>