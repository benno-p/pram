<?php
include 'properties.php';

$mail_bd_result = '';
$password_bd_result = '';
$id_user_bd_result = '';
$id_ids_obs_bd_result = '';
$nom_ids_obs_bd_result = '';

$pwd = $_POST['password'];
$courriel = $_POST['password'];

if (isset($_POST['email']) && isset($_POST['password'])) {
    if( ($_POST['email'] != '') && ($_POST['password'] != '') ) {
        
        
        $dbconn = pg_connect("host=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
        or die ('Connexion impossible :'. pg_last_error());
        
        $q_=  pg_prepare($dbconn, "q_","select i.u_courriel,i.u_pwd, i.u_id_session , i.u_nom , i.u_prenom , i.u_id from $users i where (i.u_pwd = md5( $1 ) and i.u_courriel = $2 ) ");
        $res = pg_execute($dbconn, "q_", array($_POST['password'], $_POST['email'] ));
        
        //INSERT INTO OBSERVATEUR
        while($data = pg_fetch_array($res)){
            session_start ();
            $_SESSION['email']              = $_POST['email'];
            $_SESSION['password']           = $_POST['password'];
            $_SESSION['session']            = trim($data['u_id_session']);
            $_SESSION['search_done']        = false;
            $_SESSION['nom_prenom']         = $data['u_nom'] .' '.$data['u_prenom'];
            $_SESSION['u_id']               = $data['u_id'];
            echo "Success";
        }
        //ferme la connexion a la BD
        pg_close($dbconn);
    }
    else {
        echo "Failed";
    }
}
else {
    /*header ('location: index.php');*/
    echo "Failed and failed";
}

?>