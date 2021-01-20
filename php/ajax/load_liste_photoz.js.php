<?php
include '../../php/properties.php';

//cnx BDD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$img='';
$link='-_-';
$link_to_write='';
//Recupere les données binaires du champ "VALUE"de la table BLOB générée automatiquement par ODK --> _BLB
//encode(photo, 'base64')
$sql = 
"SELECT ".
" '_' as img, photo_id, left(date_photo::text,10) as date_, car, loc, photo_link , id_user ".
"FROM $photos where id_plus = '".$_POST["id_mare"]."' and photo is not null order by 3 desc ";

//execute la requete dans le moteur de base de donnees  
$query_result = pg_query($dbconn,$sql) or die ( pg_last_error());
while($row = pg_fetch_row($query_result))
{
    $image = pg_unescape_bytea($row[0]);
    //Affiche les images sur la page web (taille max 200px)
    $link_to_write = $photos_directory .$row[5].'.jpeg';
    $link = $row[5].'.jpeg';
    if (file_exists($link_to_write)) {
        //do nothing
    } else {
        file_put_contents($link_to_write, base64_decode($image) );
    }
    $img = $img.$link.'|'.$row[2].'|'.$row[3].'|'.$row[4].'#';
}
//Ferme cnx BDD
pg_close($dbconn);
echo $img;



?>