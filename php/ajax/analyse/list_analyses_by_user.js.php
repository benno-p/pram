<?php
session_start();
include '../../properties.php';

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = "
SELECT nom_analyse, id_analyse_semis
  FROM $analyses where id_user = '".$_SESSION['email']."'
";
$x= 1;

$query_result = pg_exec($dbconn,$sql) or die (pg_last_error());
while($row = pg_fetch_row($query_result))
{
    echo "<option id='aold_".$x."' id_semis='".$row[1]."' id_analyses='".$row[0]."' >".$row[0]."</option>";
    $x = $x+1;
}
//ferme la connexion a la BD
pg_close($dbconn);

?>