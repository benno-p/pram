<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
session_start();
include 'properties.php';

$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

//$sql="select * from mares.caracterisations where id_carac = '".$_POST['id_carac']."' ";
$sql="
SELECT 
wc.wc_id, 
wc.wc_loc_id_plus, 
wc.wc_date, 
wc.wc_str, 
wc.wc_obj, 
wc.wc_cmt, 
wc.l_id,
l.loc_id, 
l.loc_id_plus, 
l.loc_uuid, 
l.loc_nom, 
l.loc_type_propriete, 
l.loc_statut, 
l.loc_date, 
l.loc_obsv, 
l.loc_comt, 
l.loc_anonymiser, 
l.loc_geom, 
l.car_ids, 
l.obs_ids, 
l.tra_ids, 
l.loc_id_user,
(select l_nom from $communes2018 where st_intersects(l_geom, l.loc_geom) ) as nom_commune,
(select l_nom from $epci2018 where st_intersects(l_geom, l.loc_geom) ) as epci,
st_x(l.loc_geom) as x_,
st_y(l.loc_geom) as y_,
st_x(st_transform(l.loc_geom,2154)) as x_l93,
st_y(st_transform(l.loc_geom,2154)) as y_l93
  FROM $creations wc left join 
   $localisations l on wc.wc_loc_id_plus = l.loc_id_plus
where wc.wc_id = '".$_POST['id_']."' and l.tra_ids like '%".$_POST['type_w']."_%_".$_POST['id_']."%' ";
//select * from mares.caracterisations where car_id = ".$_POST['id_carac']." ";
//$sql="select * from mares.caracterisations limit 105 ";


$query_result = pg_exec($dbconn,$sql) or die (pg_last_error());
$arr = pg_fetch_array($query_result);
pg_close($dbconn);


//<td style='width:20%;text-align:right;font-size:14px;'><img src='../img/pram_normandie_small.PNG' style='width:50%'>
//</td>

    
    //Permet la gestion des informations par rapport ࠬa fiche
    $document = "
            <page>
            <page_header>
                <table style='width:100%;'> 
                    <tr>                
                        <td style='width:20%;text-align:left;font-size:14px;'>
                            <img src='../img/pram_normandie_small.PNG' style='width:50%'>
                        </td>
                        <td style='width:60%;text-align:center;font-size:14px;'>
                        </td>
                        <td style='width:20%;text-align:right;font-size:14px;'>".$arr["loc_st????"]."</td>
                    </tr>
                </table>
            </page_header>
            <br>
            <br>
            <br>
            <br>
            <table style='width:100%;'> 
                <tr>                

                    <td style='width:100%;font-size:17px;'>
                        <fieldset style='height:8%;text-align:center;vertical-align:middle;background-color:#aab5cc;color:#ffffff;border:0px;font-size:22px;'>
                            <b>FICHE TRAVAUX DE CREATION DE LA MARE ".$arr["loc_id_plus"]."</b><br>
                            <b>COMMUNE DE : ".$arr["nom_commune"]."</b>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <br>
        
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;DONNEES GENERALES DE LOCALISATION</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Date de localiation : </b> ".$arr["loc_date"]."
                            
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Nom de la mare : </b> ".$arr["loc_nom"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Commune : </b> ".$arr["nom_commune"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Structure localisante : </b> ".$arr["loc_st???"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Observateur : </b> ".$arr["loc_obsv"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Mode de localisation : </b>
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <br>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;TRAVAUX DE CREATION DE LA MARE</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>
                <table border='0' style='width:100%;'>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Date de création : </b> ".$arr["wc_date"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Structure de création : </b> ".$arr["STRUCTURE"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
                            <b>Objectif de création : </b> ";
                                    foreach( array_pop(explode("|",$arr["wc_obj"])) as $objcreation){
                                        $document.= $objcreation." ";
                                    }
                        $document.="
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
                            <b>Commentaire : </b> ".$arr["wc_cmt"]."
                        </td>
                    </tr>
                </table>
            </fieldset>.
            </page>
            <page_footer>
                <p style='text-align:right;font-size:10px'>PRAM Normandie</p>
            </page_footer>";
    

//


require $root_dir_.'/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
//$html2pdf = new Html2Pdf();
$marges = array(6, 6, 6, 6);
$html2pdf = new HTML2PDF('P','A4','da', true, 'UTF-8', $marges);
$html2pdf->writeHTML($document);
ob_end_clean();

//echo $html2pdf;

if (file_exists ($root_dir_."/pdf/fiche_mare_cr.pdf")) {
    //delete last file
    unlink($root_dir_."/pdf/fiche_mare_cr.pdf");
};


//write file on serveur
$html2pdf->output($root_dir_."/pdf/fiche_mare_cr.pdf","F");
echo "fiche_mare_cr.pdf";


?>