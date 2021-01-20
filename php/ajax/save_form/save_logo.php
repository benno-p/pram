<?php
session_start();
include '../../properties.php';

$base64 = base64_encode($binary);
echo $base64;

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());


$sql = 
"
UPDATE $users
set 
u_logo='".$_POST["filename"]."'
WHERE 
u_courriel = '".$_SESSION['email']."' 
";

echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo "true";
} else {
    echo "false";
}






$image = $_POST['base64_img'];

//ecrit la photo sur le serveur si elle n'existe pas
$link_to_write = $logos_directory.$_POST["filename"];

file_put_contents($link_to_write, base64_decode($image) );


echo $link_to_write;



////ferme la connexion a la BD
pg_close($dbconn);


?>