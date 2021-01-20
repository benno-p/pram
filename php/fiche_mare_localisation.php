<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
session_start();
include 'properties.php';

$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());


//$_POST['id__'] = '8CXX5FVR+86_43484';
//$_POST['image_src'] = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+gAAAJYCAYAAADxHswlAAAgAElEQVR4nOzdd5hTVf7H8RmGLgLKIjYUdbGLlaKIgIgLVlBWXAuW1Z9txYKd3hEQpEiVJoIFQQSliQpIUToDCkoXESmTTDJpk0ny/f3hMksyczM5aSfJfb+eJ89jhuTmeybJ8X7m3vs9WQIAigoKCmTIkCFSp04dycrKSvjthhtukAULFkggENA9dCTAzp07ZerUqUrPycrKiuk1Q5/fpUuXEp+7OnXqxPQaQCL8+uuvUq5cOeV5dOPGjbpLBwBEILY9HACm5nK5ZNSoUXL22WcnJahfe+218vnnn4vf79c9dMTRtGnT5Ndff4348fEO5yIigwcPLvUzd/jw4ZheC0iE+++/X3n+7NChg+6yAQARIKADiJnH45EJEybIeeedl5SgfsUVV8jHH38sPp9P99ARB927d4/47IhEhHMRkU8++aTUz9rSpUtje…AMAcoI9yAl0AJl26qmnKgX6I488onsygAyw306tqr+DEOgAgJxAoAOobX379lUK9NNPP133ZAAOO9jt1MrKytLuh74/Ah0AkBMIdAC1bf78+cpvc9+7d6/u2QAcZL+dmv1+6HYEOgAgJ9iDvLy8nEAHkFF79uxRDvQ33nhD92wADrLfTs1+P3Q7Ah0AkBPs/4Cs7P6jAOCkLl26KAX6/fffr3syAAfZb6dmvx+6HYEOAMgJBDoAHR5++GGlQO/UqZPuyQAccrDbqdnvh25HoAMAcgKBDkCHBQsWKL/NfdeuXbpnA3CA/XZq9vuhHwyBDgDICQQ6AB28Xq8UFBQoBfprr72mezYAB9ivfxMKhSQcDlf53yHQAQA5IRQKpQV5KBSSSCSicRGAXHHWWWcpBfq9996rezIAB9hvp+bz+SSRSFT53yHQAQA5wR7kBDqA2tK/f3+lQG/fvr3uyQBqyH47tYPdD/1g/h9JZbvfU31nBwAAAABJRU5ErkJggg==";

//$sql="select * from mares.caracterisations where id_carac = '".$_POST['id_carac']."' ";
$sql="
SELECT 
loc_id, 
loc_id_plus, 
loc_uuid, 
loc_nom, 
loc_type_propriete, 
loc_statut, 
loc_date, 
loc_obsv, 
loc_comt, 
loc_anonymiser, 
loc_geom, 
car_ids, 
obs_ids, 
tra_ids, 
loc_id_user,
(select l_nom from $communes2018 where st_intersects(l_geom, loc_geom) ) as nom_commune,
(select l_nom from $epci2018 where st_intersects(l_geom, loc_geom) ) as epci,
st_x(loc_geom) as x_,
st_y(loc_geom) as y_,
st_x(st_transform(loc_geom,2154)) as x_l93,
st_y(st_transform(loc_geom,2154)) as y_l93
  FROM $localisations 
  where loc_id_plus = '".$_POST['id__']."' ";
//select * from mares.caracterisations where car_id = ".$_POST['id_carac']." ";
//$sql="select * from mares.caracterisations limit 105 ";


$query_result = pg_exec($dbconn,$sql) or die (pg_last_error());
$arr = pg_fetch_array($query_result);
pg_close($dbconn);

$image_data_src = $_POST['image_src'];

$data = $_POST['image_src'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

file_put_contents($root_dir_."/pdf/img.png", $data);
//file_put_contents('/tmp/image.png', $data);
echo "fiche_mare.pdf";




//<td style='width:20%;text-align:right;font-size:14px;'><img src='../img/pram_normandie_small.PNG' style='width:50%'>
//</td>

    
    //Permet la gestion des informations par rapport � la fiche
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
                        <fieldset style='height:8%;text-align:center;vertical-align:middle;background-color:#d79c5f;color:#ffffff;border:0px;font-size:22px;'>
                            <b>FICHE DE LOCALISATION DE LA MARE ".$arr["loc_id_plus"]."</b><br>
                            <b>COMMUNE DE : ".$arr["nom_commune"]."</b>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <br>
        
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#d79c5f'><b>&nbsp;&nbsp;DONNEES GENERALES</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Date de la localisation : </b> ".$arr["loc_date"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Nom de la mare : </b> ".$arr["loc_nom"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Structure : </b> ".$arr["loc_st????"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Observateur : </b> ".$arr["loc_obsv"]."
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
                            <b>Nom usuel de la mare : </b> ".$arr["loc_nom"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Type de propriété : </b> ".$arr["loc_type_propriete"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Longitude (WGS84) : </b> ".$arr["x_"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Latitude (WGS84) : </b> ".$arr["y_"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>X (Lambert 93) : </b> ".$arr["x_l93"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Y (Lambert 93) : </b> ".$arr["y_l93"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Commentaire : </b> ".$arr["loc_comt"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                </table>
            </fieldset>
            <br>
            <br>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#d79c5f'><b>&nbsp;&nbsp;CARTE DE LOCALISATION</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td style='width:100%;text-align:center;font-size:14px;'>
                            <img src='http://cen-normandie.com/".$dir_."/pdf/img.png'  style='width:80%'>
                        </td>
                    </tr>
                    
                </table>
            </fieldset>
        <page_footer>
            <p style='text-align:right;font-size:10px'>PRAM Normandie</p>
        </page_footer>
        </page>";
    
//
//echo $document;

//echo $_SERVER["DOCUMENT_ROOT"].'pram_v4444_/vendor/autoload.php';

require $root_dir_.'/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
// $html2pdf = new Html2Pdf();
$marges = array(6, 6, 6, 6);
$html2pdf = new HTML2PDF('P','A4','da', true, 'UTF-8', $marges);
$html2pdf->writeHTML($document);
ob_end_clean();

// echo $html2pdf;

if (file_exists ($root_dir_.'/pdf/fiche_mare_loc.pdf')) {
    // delete last file
    unlink($root_dir_.'/pdf/fiche_mare_loc.pdf');
};

// write file on serveur
$html2pdf->output($root_dir_.'/pdf/fiche_mare_loc.pdf',"F");
//echo $root_dir_.'/pdf/fiche_mare_loc.pdf'; 

echo "fiche_mare_loc.pdf"; 

?>