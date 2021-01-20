<?php
session_start();
include 'php/properties.php';


$mail = str_replace("'","''",$_POST['courriel']); // Déclaration de l'adresse de destination.

$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$sql = "INSERT INTO $users (
            u_courriel, u_id_session, u_pwd)
VALUES ('".$mail ."', '".$mail ."', md5('".str_replace("'","''",$_POST["dwp"])."') )";
pg_exec($dbconn,$sql);
pg_close($dbconn);


//$mail = 'b.perceval@cen-bn.fr';
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
	$passage_ligne = "\r\n";
}
else
{
	$passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
//$message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
$message_html = "<html>";
$message_html .= "<head>";
$message_html .= "<meta charset='utf-8' />"; 
$message_html .= "<head></head>";
$message_html .= "<body>";
$message_html .= "<table style=\"width: 100%;\">";
$message_html .= "<tr style=\"\">";
$message_html .= "<td style=\"text-align: center;background-color:#004fa2;\">";
$message_html .= "<img src=\"http://cen-normandie.com/intranet/img/pram_normandie_small.PNG\" alt=\"logo_pram\"  style=\"display: inline-block; width: 120px;height: 44px;\" />";
$message_html .= "</td>";
$message_html .= "</tr>";
$message_html .= "<tr>";
$message_html .= "<td style=\"\">";
$message_html .= "<div style=\"\" ><p style=\"color:#004fa2;font-size:20px;font-weight:600;font-family: Calibri, Helvetica, Arial, sans-serif;\">Bonjour</p>";
$message_html .= "<p style=\"color:#004fa2;font-size:18px;font-weight:600;font-family: Calibri, Helvetica, Arial, sans-serif;\">Vous recevez ce courriel suite à votre inscription sur le site pramnormandie.fr pour le Programme Régional d'Actions en faveur des Mares</p>";
$message_html .= "<p><span style=\"color:#004fa2;font-size:16px;font-weight:600;font-family: Calibri, Helvetica, Arial, sans-serif;\">L'inscription a été réalisée avec l'adresse :&nbsp;</span></p>";
$message_html .= "<p><span style=\"font-family: Calibri, Helvetica, Arial, sans-serif;\">".$mail."</span></p>";
$message_html .= "<p><span style=\"color:#004fa2;font-size:16px;font-weight:600;font-family: Calibri, Helvetica, Arial, sans-serif;\">L'équipe du PRAM Normandie vous remercie pour votre contribution au projet !</span></p>";
//$message_html .= "<p><span style=\"color:#004fa2;font-size:16px;font-weight:600;font-family: Calibri, Helvetica, Arial, sans-serif;\">Vous pouvez dès à présent vous connecter et découvrir l'application.</span>";
//$message_html .= "</p>";
//$message_html .= "<p style=\"color:#004fa2;font-size:16px;font-weight:600;font-family: Calibri, Helvetica, Arial, sans-serif;\">L'équipe du PRAM Normandie vous remercie pour votre contribution au projet !</p></div>";
$message_html .= "</div></td>";
$message_html .= "</tr>";
$message_html .= "<tr>";
$message_html .= "<td style=\"\">&nbsp;</td>";
$message_html .= "</tr>";
$message_html .= "<tr>";
$message_html .= "<td style=\"\">";
$message_html .= "<div style=\"background-color:#004fa2;\" ><p style=\"color:#fff;font-size:18px;font-weight:600;\">&nbsp;</p></div>";
$message_html .= "</td>";
$message_html .= "</tr>";
$message_html .= "</table>";
$message_html .= "</br></br><div style=\"font-size:12px;\" ><p>Si vous n'êtes pas à l'origine de la création de ce compte veuillez ignorer cet e-mail.</p>";
$message_html .= "</br><p>Pour tout problème veuillez envoyer un mail à l'adresse suivante contact@pramnormandie.com</p></div>";
$message_html .= "</body>";
$message_html .= "</html>";



//==========
 
//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========
 
//=====Définition du sujet.
$sujet = "Validation de votre inscription PRAM Normandie";
//=========
 
//=====Création du header de l'e-mail.
$header = "From: \"pram normandie\"<contact@pramnormandie.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
 
//=====Création du message.
//$message = $passage_ligne."--".$boundary.$passage_ligne;
////=====Ajout du message au format texte.
//$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
//$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
//$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
 
//=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);
//==========

echo "send";
?>
