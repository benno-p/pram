<?php
session_start();

function generateRandomString($length = 6) {
    $characters = 'ABCDEFGHIJKLNOPQRSTUVXYZ';//abcdefghijklmnopqrstuvwxyz
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}





$_SESSION['n_n'] = generateRandomString();
//mt_rand(100,9999);
$img = imagecreate(240,80);
$font = getcwd().'/../fonts/Multistrokes.ttf';
$bg = imagecolorallocate($img,255,255,255);
$textcolor = imagecolorallocate($img,110,193,77);

$pixel_color = imagecolorallocate($img, 110,193,77);
for($i=0;$i<8000;$i++) {
    imagesetpixel($img,rand()%240,rand()%80,$pixel_color);
}  

imagettftext($img, 40,0,12,52, $textcolor, $font,$_SESSION['n_n']);

header('Content-type:image/jpeg');
imagejpeg($img);
imagedestroy($img);

?>