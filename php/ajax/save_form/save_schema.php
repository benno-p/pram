<?php
session_start();
include '../../properties.php';

//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());


$sql = 
"
INSERT INTO $photos(
            id_plus , photo, id_user, date_photo, schema_)
 (
SELECT
  '".str_replace("'","''",$_POST['id_plus'])."' ,
  '".str_replace("'","''",$_POST['base64_img'])."',
  '".str_replace("'","''",$_SESSION['email'])."',
  current_date,
  ".$_POST['id_plus']."
);
";

echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo "true".strval($_POST['file_size']);
} else {
    echo "false";
}



//recupère l'id final
$sql = "select link from $photo_last_id";
$query_result = pg_query($dbconn,$sql) or die ( pg_last_error());
while($row = pg_fetch_row($query_result))
{
    $link_id=$row[0];
};

$image = $_POST['base64_img'];

//ecrit la photo sur le serveur si elle n'existe pas
$link_to_write = $photos_directory.$link_id.'.jpeg';
if (file_exists($link_to_write)) {
    //do nothing
} else {
    file_put_contents($link_to_write, base64_decode($image) );
};





////ferme la connexion a la BD
pg_close($dbconn);


?>