<?php
include '../properties.php';
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$sql = "select i.u_nom,i.u_prenom, i.u_id_nom_structure, i.u_logo from saisie_observation.users i where i.u_courriel = '".$_POST['email']."' AND i.u_old_mdp = '".$_POST['password']."' ";
echo $sql;
//execute la requete dans le moteur de base de donnees  
$query_result1 = pg_exec($dbconn,$sql_init) or die (pg_last_error());
while($row = pg_fetch_row($query_result1))
{
    echo trim($row[0]).'|'.trim($row[1]).'|'.trim($row[2]).'|'.trim($row[3]);
}
//ferme la connexion a la BD
pg_close($dbconn);


?>