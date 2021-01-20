<?php
session_start();
include "../../properties.php";

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = 
"
DELETE FROM $localisations where loc_id_plus = '".$_POST["id_plus"]."'
";
//echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo " true loc ";
} else {
    echo " false loc ";
}

$sql = 
"
DELETE FROM $caracterisations where loc_id_plus = '".$_POST["id_plus"]."'
";
//echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo " true car ";
} else {
    echo " false car ";
}


$sql = 
"
DELETE FROM $photos where id_plus = '".$_POST["id_plus"]."'
";
//echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo " true photo ";
} else {
    echo " false photo ";
}



////ferme la connexion a la BD
pg_close($dbconn);

?>