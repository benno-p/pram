<?php
session_start();
include '../../properties.php';


$pwd = str_replace("'","''",$_POST['pwd_']);
$n_ = str_replace("'","''",$_POST['n_']);
$p_ = str_replace("'","''",$_POST['p_']);
$str_ = str_replace("'","''",$_POST['str_']);

$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$sql = "
UPDATE $users set 
u_nom = '".$n_."',
u_prenom = '".$p_."',
u_id_nom_structure = '".$str_."',
u_pwd = md5('".$pwd."')
where u_courriel = '".$_SESSION['email']."'
";
echo $sql;
pg_exec($dbconn,$sql);
pg_close($dbconn);


?>
