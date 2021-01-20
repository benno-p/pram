<?php
include '../properties.php';
$arr = array();

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = "
select row_to_json(t) from 
(SELECT o_id_unique, loc_id_plus, o_date, o_cd_nom, o_reference, o_nom_complet, 
       o_nom_vernaculaire, o_nombre, o_comt, o_observateur, o_structure, 
       o_technique_acquisition
  FROM $observations where loc_id_plus = '".$_POST["mare"]."' ) t
";
//echo $sql;


$query_result = pg_exec($dbconn,$sql) or die (pg_last_error());
if (!(empty($query_result))){
    while($row = pg_fetch_row($query_result))
    {
    $arr[]=trim($row[0]);
    }
} else {
    
}
echo json_encode($arr);
//ferme la connexion a la BD
pg_close($dbconn);

?>