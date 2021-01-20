<?php
session_start();
include '../../properties.php';


//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$idx = 0;
$size = $_POST['file_size'];
$image_src = base64_decode($_POST['base64_img']);


//reduce img if size > 5 Mb
if ($size > 5000000) {
    $name = "out".date("h_i_s").".jpeg";
    $final_name = "out".date("h_i_s").".jpeg";
    file_put_contents($photos_directory.$name, $image_src );
    $image = imagecreatefromjpeg($photos_directory.$name);
    $out = imagejpeg($image, $photos_directory.$final_name , 5);
    $resized_image = base64_encode(file_get_contents($photos_directory.$final_name));
    
    if (file_exists($photos_directory.$name)) {
        unlink($photos_directory.$name);
    }
    if (file_exists($photos_directory.$final_name)) {
        unlink($photos_directory.$final_name);
    }
}
else {
    //reduce img if size > 2 Mb
    if ($size > 2000000) {
        while ($size > 2000000) {
            $name = "out".date("h_i_s").".jpeg";
            $final_name = "out".date("h_i_s").".jpeg";
            
            file_put_contents($photos_directory.$name, $image_src );
            $image = imagecreatefromjpeg($photos_directory.$name);
            $out = imagejpeg($image, $photos_directory.$final_name , 15);
            
            $image_src = $image;
            $size = filesize($photos_directory.$final_name);
            $resized_image = base64_encode(file_get_contents($photos_directory.$final_name));
            if (file_exists($photos_directory.$name)) {
                unlink($photos_directory.$name);
            }
            if (file_exists($photos_directory.$final_name)) {
                unlink($photos_directory.$final_name);
            }
        }
    } else {
        $resized_image = $_POST['base64_img'];
    }
}
foreach (glob($photos_directory."out*.*") as $filename) {
    unlink($filename);
}


$sql = 
"
INSERT INTO $photos(
            id_plus , photo, id_user, date_photo,schema_)
 (
SELECT
  '".str_replace("'","''",$_POST['id_plus'])."' ,
  '".str_replace("'","''",$resized_image)."',
  '".str_replace("'","''",$_SESSION['email'])."',
  current_date,
  ".$_POST['id_plus']."
);
";

//echo $sql;
if ( pg_exec($dbconn,$sql) ) {
    echo "true";
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


//$_POST['base64_img'];
//$image = $_POST['base64_img'];

//ecrit la photo sur le serveur si elle n'existe pas
$link_to_write = $photos_directory.$link_id.'.jpeg';
if (file_exists($link_to_write)) {
    //do nothing
} else {
    file_put_contents($link_to_write, base64_decode($resized_image) );
};

//echo $link_to_write;


////ferme la connexion a la BD
pg_close($dbconn);


?>