<?php
include '../properties.php';
$arr = array();

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$sql = "select txrf.nom_complet, coalesce(txrf.nom_vern,'...'), txrf.cd_nom FROM $taxref txrf where ( txrf.nom_complet ~* '".$_POST["term"]."' or txrf.nom_vern ~* '".$_POST["term"]."' ) order by 1";
//$sql = "select nom_complet, nom_vern, cd_nom, cd_ref, recherche_rapide from inpn.taxref_9 where nom_complet ~* '".$_POST["term"]."' or recherche_rapide = '".$_POST["term"]."' order by 1";
//execute la requete dans le moteur de base de donnees  
$query_result = pg_query($dbconn,$sql) or die ( pg_last_error());
while($row = pg_fetch_row($query_result))
{
  $arr[]=trim($row[0])."\t".trim($row[1])."\t".trim($row[2]);
}
//ferme la connexion a la BD
pg_close($dbconn);
echo json_encode($arr);

?>