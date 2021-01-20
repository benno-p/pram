<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
session_start();
include 'php/properties.php';



$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$_POST['id_carac'] = 15;

//$sql="select * from mares.caracterisations where id_carac = '".$_POST['id_carac']."' ";
$sql="
SELECT 
c.car_id, c.car_id_plus, l.loc_id_plus, loc_id_strp, c.car_date, c.car_obsv, c.car_strp, c.car_type, c.car_veget, c.car_evolution, c.car_abreuv, c.car_topo, 
c.car_topo_autre, c.car_cloture, c.car_haie, c.car_form, c.car_long, c.car_larg, 
c.car_prof, c.car_natfond, c.car_natfond_autre, c.car_berges, c.car_bourrelet, 
c.car_bourrelet_pourcentage, c.car_pietinement, c.car_hydrologie, c.car_turbidite, 
c.car_couleur, c.car_tampon, c.car_exutoire, c.car_recou_total, c.car_recou_helophyte, 
c.car_recou_hydrophyte_e, c.car_recou_hydrophyte_ne, c.car_recou_algue, 
c.car_recou_eau_libre, c.car_embrous, c.car_ombrage, c.car_comt, c.car_recou_non_veget, 
c.car_patrimoine, c.car_patrimoine_autre, c.car_couleur_precision, 
c.car_objec_trav, c.car_travaux, c.car_liaison, c.car_dechet, c.car_alimentation, 
c.car_contexte, c.car_faune, c.car_usage, c.car_bati, c.car_eaee, c.car_evee,
p.photo_link
,com.l_id
,com.l_nom
,epci.l_id as l_id_epci
,epci.l_nom as l_nom_epci
  FROM 
  mares.caracterisations c 
    LEFT JOIN mares.localisations l ON (c.loc_id_plus = l.loc_id_plus)
    LEFT JOIN (select * from mares.photos where car is true) as  p ON (c.loc_id_plus = p.id_plus)
    LEFT JOIN layers.communes_2018 com ON st_intersects(l.loc_geom, com.l_geom)
    LEFT JOIN layers.epci_2018 epci ON st_intersects(l.loc_geom, epci.l_geom)
  where car_id = '".$_POST['id_carac']."' ";
//select * from mares.caracterisations where car_id = ".$_POST['id_carac']." ";
//$sql="select * from mares.caracterisations limit 105 ";


$query_result = pg_exec($dbconn,$sql) or die (pg_last_error());
$arr = pg_fetch_array($query_result);
pg_close($dbconn);

//<img src='".$arr["photo_link"]."' style='width:50%'>
$document = "
            <page>
            <page_header>
                <table style='width:100%;'> 
                    <tr>                
                        <td style='width:20%;text-align:left;font-size:14px;'>
                            
                        </td>
                        <td style='width:60%;text-align:center;font-size:14px;'>
                        </td>
                        <td style='width:20%;text-align:right;font-size:14px;'>
            ".$arr["loc_id_plus"]."</td>
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
                            <b>FICHE DE CARACTERISATION DE LA MARE ".$arr["loc_id_plus"]."</b><br>
                            <b>COMMUNE DE : ".$arr["l_nom"]."</b>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <br>
        
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;DONNEES GENERALES</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Date de caractérisation : </b> ".$arr["car_date"]."
                            
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Nom de la mare : </b> ".$arr["car_comt"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Commune : </b> ".$arr["l_nom"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Numéro INSEE : </b> ".$arr["l_id"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>EPCI : </b> ".$arr["l_nom_epci"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Numéro EPCI : </b> ".$arr["l_id_epci"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Observateur : </b> ".$arr["car_obsv"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Type de mare : </b> ".$arr["car_type"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Végétation aquatique : </b> ".$arr["car_veget"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td colspan='2' style='width:50%;text-align:left;font-size:14px;'>
                            <b>Groupe faunistique observés : </b> ".$arr["car_faune"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td colspan='2' style='width:50%;text-align:left;font-size:14px;'>
                            <b>Stade d'évolution : </b> ".$arr["car_evolution"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td colspan='2' style='width:100%;text-align:center;font-size:14px;'>
                        <img src='img/pram_normandie.PNG' style='width:20%'>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <br>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;USAGE</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>
                <table border='0' style='width:100%;'>
                    <tr>
                        <td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
                            <b>Usage principal de la mare : </b> ".$arr["car_usage"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Mare équipée d'une pompe à nez : </b> ".$arr["car_pompe"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Présence de déchets : </b> ".$arr["car_dechet"]."
                        </td>
                    </tr>
                </table>
            </fieldset>.
            </page>
            <page_footer>
                <p style='text-align:right;font-size:10px'>Fiche générée à partir de l'application cartographique du Programme Régional d'Actions en faveur des mares de Normandie (www.pramnormandie.com/API) - Page 1</p>
            </page_footer>
            <page>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;SITUATION DE LA MARE</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>        
                <br>
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Topographie : </b>".$arr["car_topo"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Contexte : </b>".$arr["car_contexte"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Petit patrimoine associé : </b> ".$arr["car_patrimoine"]."
                        </td>
                        
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Mare clôturée : </b> ".$arr["car_cloture"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Présence d'une haie : </b> ".$arr["car_haie"]."
                        </td>
                    </tr>
                </table>    
            </fieldset>
            <br>
            <br>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;CARACTERISTIQUES ABIOTIQUES DE LA MARE</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>        
                <br>        
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Forme : </b> ".$arr["car_forme"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Taille moyenne (m) : </b> ".$arr["car_long"]." de longueur et ".$arr["car_larg"]." de largeur
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Profondeur : </b> ".$arr["car_prof"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Nature du fond : </b> ".$arr["car_natfond"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>    
                    <tr>    
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Berges en pente douce : </b> ".$arr["car_berges"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Bourrelet de curage : </b> ".$arr["car_bourrelet"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>    
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Surpiétinement des abords : </b> ".$arr["car_surpietinement"]."
                        </td>
                    </tr>
                </table>    
            </fieldset>
            <br>
            <br>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;HYDROLOGIE</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>        
                <br>        
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Régime hydrographique : </b> ".$arr["car_hydro"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Laison avec le réseau hydro : </b> ".$arr["car_liaison"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
                            <b>Alimentation dpécifique : </b> ".$arr["car_alim"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Turbidité de l'eau : </b> ".$arr["car_turbidite"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Couleur spécifique de l'eau : </b> ".$arr["car_couleur"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Tampon : </b> ".$arr["car_tampon"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Exutoire : </b> ".$arr["car_exutoire"]."
                        </td>
                    </tr>
                </table>
                <br>
            </fieldset>
            <br>
            <br>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;ECOLOGIE</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>        
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td colspan='2' style='width:50%;text-align:left;font-size:14px;'>
                            <b>Recouv. total : </b> ".$arr["car_recou_total"]."%<br><br>
                            <b>Recouv. hélophytes : </b> ".$arr["car_recou_helophyte"]."%<br><br>
                            <b>Recouv. hydrophytes enracinées : </b> ".$arr["car_recou_hydrophyte_e"]."%<br><br>
                            <b>Recouv. hydrophytes non enracinés : </b> ".$arr["car_recou_hydrophyte_ne"]."%<br><br>
                            <b>Recouv. algues : </b> ".$arr["car_recou_algue"]."%<br><br>
                            <b>Recouv. eau libre : </b> ".$arr["car_recou_eau_libre"]."%<br><br>
                            <b>Recouv. non végétalisé : </b> ".$arr["car_recou_non_veget"]."%<br>
                        </td>    
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Boisement / Embroussaillement : </b> ".$arr["car_embrous"]."
                        </td>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Ombrage surface par ligneux : </b> ".$arr["car_ombrage"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
                            <b>Espèce animale exotique envahissante : </b> ".$arr["car_eaee"]."
                        </td>
                    </tr>
                    <tr><td style='height:1%;'></td></tr>
                    <tr>
                        <td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
                            <b>Espèce végétale exotique envahissante : </b> ".$arr["car_evee"]."
                        </td>
                    </tr>
                </table>
            </fieldset>
            </page>
            <page_footer>
                <p style='text-align:right;font-size:10px'>Fiche générée à partir de l'application cartographique du Programme Régional d'Actions en faveur des mares de Normandie (www.pramnormandie.com/API) - Page 2</p>
            </page_footer>
            <page>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;INTERVENTION EN FAVEUR DE CETTE MARE...</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
                            <b>Travaux à envisager : </b> ".$arr["car_travaux"]."
                        </td>
                    </tr>
                </table>
                <br>
            </fieldset>
            <br>
            <br>
            <fieldset style='color:#ffffff;font-size:15px;border:0px;border-color:#aabcd6;background-color:#aab5cc'><b>&nbsp;&nbsp;COMMENTAIRES ET PHOTO DE CARACTERISATION</b></fieldset>
            <fieldset style='text-align:left;vertical-align:middle;border:1px;border-color:#aabcd6'>
                <br>
                <table border='0' style='width:100%;'> 
                    <tr>
                        <td style='width:50%;text-align:left;font-size:14px;'>
                            <b>Commentaires : </b> ".$arr["car_comt"]."
                        </td>
                        <td style='width:50%;text-align:center;font-size:14px;'><img src='img/pram_normandie.PNG' style='width:50%'>
                        </td>
                    </tr>
                </table>
                <br>
            </fieldset>
            <br>
            <br>
        <page_footer>
            <p style='text-align:right;font-size:10px'>Fiche générée à partir de l'application cartographique du Programme Régional d'Actions en faveur des mares de Normandie (www.pramnormandie.com/API) - Page 3</p>
        </page_footer>
        </page>";

//OLD VERSION
//ATTENTION A OU SE TROUVE LA LIBRAIRIE PAR RAPPORT A TON FICHIER :)
//require_once('html2pdf/html2pdf.class.php');
//require_once('html2pdf-master/src/Html2Pdf.php');
//$marges = array(10, 10, 10, 10);
//$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', $marges);
//$html2pdf->WriteHTML($document);
//ob_end_clean();
//$html2pdf->Output('monFichier.pdf');


require __DIR__.'/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
//$html2pdf = new Html2Pdf();
$html2pdf = new HTML2PDF('P','A4','da', true, 'UTF-8');
$html2pdf->writeHTML($document);
ob_end_clean();
$html2pdf->output();



?>