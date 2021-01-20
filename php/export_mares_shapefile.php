<?php 
ini_set("display_errors",1);

// On se connecte ࡬a base de donn꦳
include '../../bdd.php';

//on recupere les varaible
$Identifiant_Session = $_POST['j_id_session'];
//echo $Identifiant_Session.'</br>';

$req_structure_id = pg_query($bdd, 'SELECT * FROM saisie_observation.structure WHERE "S_ID_SESSION"='."'".$Identifiant_Session."'".'');
$donnees_structure_id = pg_fetch_array($req_structure_id);
$id_structure_connectee = $donnees_structure_id['S_ID'];
//echo $id_structure_connectee.'</br>';

//On indique ensuite un emplacement sur le serveur, le fichier
$fname = "pram_exportation.shp";

//ON VA FAIRE UNE REQUETE POUR VOIT SI LA STRUCUTRE POSSEDE UN CONTOUR GEOGRAPHIQUE DANS LA TABLE CONTOUR_STRUCTURE
$req_contour_structure = pg_query($bdd, 'SELECT * FROM saisie_observation.structure WHERE "S_ID_SESSION"='."'".$Identifiant_Session."'".' AND geom is Not Null');
$count_contour = pg_num_rows($req_contour_structure);

//ON VA FAIRE UNE REQUETE POUR DETERMINER LE ROLE DE LA STRUCTURE
$req_role_structure = pg_query($bdd, 'SELECT "ROLE" FROM saisie_observation.structure WHERE "S_ID_SESSION"='."'".$Identifiant_Session."'".'');
$role_structure = pg_fetch_array($req_role_structure);

//echo "id_session : ".$Identifiant_Session;
//echo "ola".$role_structure['ROLE']."<br/>";
//$role_structure['ROLE'] == "observateur";

if($role_structure['ROLE'] == "administrateur"){
    //echo ' role : admin : '.$role_structure['ROLE'].'</br>';
    $where_filtre_contour = 
    //" where  c.\"L_ID\" = l.\"L_ID\" ";
    " where  1=1 ";
}
elseif($role_structure['ROLE'] == "observateur"){
    //SI count_contour = 1 alors on filtre les mares comprise dans le perimetre de la strucuture sinon on prend les mares qui posède l'identifiant en plus des filtres
    if($count_contour == 1){
    $where_filtre_contour = 
    " , saisie_observation.structure where  ".
    " ((st_intersects(structure.geom, st_transform(l.geom,2154)) ".
    "AND \"S_ID_SESSION\"='$Identifiant_Session') OR (l.\"L_STRP\"::text = structure.\"S_ID\"::text AND structure.\"S_ID\"::text = '$id_structure_connectee')) ";
    }else{
    $where_filtre_contour = 
    " , saisie_observation.structure s where   ".
    " l.\"L_STRP\"::text = s.\"S_ID\"::text  ".
    "AND s.\"S_ID_SESSION\" = '$Identifiant_Session' ";
    }
}
elseif($role_structure['ROLE'] == "utilisateur"){
    $where_filtre_contour = 
    " , saisie_observation.structure s where  ".
    " l.\"L_STRP\"::text = s.\"S_ID\"::text ".
    "AND s.\"S_ID_SESSION\" = '$Identifiant_Session' ";
}
else {
    $where_filtre_contour = "ERROR";
}


    $sql_query = str_replace( "\"", "\\\"" ," ".
    "select ". 
    " l.\"L_ID\" as loc_id, ". 
    " CASE ".
    " WHEN l.\"L_STATUT\" = '2' THEN 'Potentielle' ".
    " WHEN l.\"L_STATUT\" = '3' THEN 'Vue' ".
    " WHEN l.\"L_STATUT\" = '4' THEN 'Caractérisée' ".
    " WHEN l.\"L_STATUT\" = '5' THEN 'Disparue' ".
    " ELSE 'null' ".
    " END as statut, ".
    " c.date_, ". 
    " (select \"OBS_NOM_PRENOM\" from saisie_observation.observateur where \"ID\" = c.\"C_OBSV\" ) as obs, ". 
    " c.type_m as type_mare, ". 
    " c.vegetation, ". 
    " c.evolution, ". 
    " c.abreuvoir, ". 
    " c.topo, ". 
    " \"C_TOPO_AUTRE\" as topo_autre, ". 
    " c.cloture, ". 
    " c.haie, ". 
    " c.forme, ". 
    " c.\"C_LONG\" as longueur, ". 
    " c.\"C_LARG\"as largeur, ". 
    " c.\"C_PROF\" as profondeur, ". 
    " c.natfond, ". 
    " c.\"C_NATFOND_AUTRE\" as natfond_a, ". 
    " c.berges, ". 
    " c.bourrelet, ". 
    " c.\"C_BOURRELET_POURCENTAGE\" as bour_pct,". 
    " c.pietinement, ". 
    " c.hydro, ". 
    " c.turbidite, ". 
    " c.couleur, ". 
    " c.tampon, ". 
    " c.exutoire, ". 
    " c.\"C_RECOU_TOTAL\" as rcvt_tot, ". 
    " c.\"C_RECOU_HELOPHYTE\" as rcvt_he, ". 
    " c.\"C_RECOU_HYDROPHYTE_E\" as rc_hy_enr, ". 
    " c.\"C_RECOU_HYDROPHYTE_NE\" as rc_hynenr, ". 
    " c.\"C_RECOU_ALGUE\" as rc_algue, ". 
    " c.\"C_RECOU_EAU_LIBRE\" as eau_libre, ". 
    " c.\"C_RECOU_NON_VEGET\" as rc_nveg, ". 
    " c.embrous, ". 
    " c.ombrage, ". 
    " c.\"C_COMT\" as coment, ". 
    " c.liaison, ". 
    " c.dechet, ". 
    " c.bati, ". 
    " c.alimentation, ". 
    " c.contexte, ". 
    " c.faune, ". 
    " c.travaux, ". 
    " c.usages, ". 
    " l.geom as geom, ". 
    " COALESCE( (select m.\"NOM_VERNACULAIRE\" from menu_deroulant.c_eaee m, saisie_observation.caracterisation_eaee se where se.\"EAEE\" = m.\"ID\" AND c.\"ID_CARAC\" = se.\"ID_CARAC\" LIMIT 1) ,'') as eaee, ". 
    " COALESCE( (select m.\"NOM_VERNACULAIRE\" from menu_deroulant.c_evee m, saisie_observation.caracterisation_evee se where se.\"EVEE\" = m.\"ID\" AND c.\"ID_CARAC\" = se.\"ID_CARAC\" LIMIT 1) ,'') as evee,". 
    " COALESCE( c.surface_m2, 0) as surf_m2 ". 
    " from ". 
    " (select loc.\"L_ID\", loc.\"L_STATUT\", loc.geom, loc.\"L_STRP\" ". 
    " from saisie_observation.localisation loc ". 
    " where loc.\"L_ID\" is not null AND loc.\"L_ID\" <> '' AND loc.geom is not null AND st_isvalid(loc.geom) is true ". 
    " group by 1,2,3,4 ". 
    " order by 1 ". 
    " ) as l left join ". 
    " (". 
    " SELECT DISTINCT ON (\"L_ID\") ". 
    " \"ID_CARAC\", ". 
    " \"L_ID\",". 
    " \"L_IDSTRP\", ". 
    //" a_get_date_fromint(CAST(\"C_DATE\" as integer)) as date_, ". 
    " \"C_DATE\" as date_, ". 
    " \"C_OBSV\",". 
    " \"C_STRP\", ". 
    " (select typ.\"TYPE\"::text from menu_deroulant.c_type typ where typ.\"ID\" = caracterisation.\"C_TYPE\" )  as type_m,". 
    " (select veg.\"VEGET\"::text from menu_deroulant.c_veget veg where veg.\"ID\" = caracterisation.\"C_VEGET\" )  as vegetation,". 
    " (select evol.\"EVOLUTION\"::text from menu_deroulant.c_evolution evol where evol.\"ID\" = caracterisation.\"C_EVOLUTION\" )  as evolution,". 
    " (select abre.\"ABREUV\"::text from menu_deroulant.c_abreuv abre where abre.\"ID\" = caracterisation.\"C_ABREUV\" )  as abreuvoir,". 
    " (select topo.\"TOPO\"::text from menu_deroulant.c_topo topo where topo.\"ID\" = caracterisation.\"C_TOPO\" )  as topo,". 
    " \"C_TOPO_AUTRE\",". 
    " (select clot.\"CLOTURE\"::text from menu_deroulant.c_cloture clot where clot.\"ID\" = caracterisation.\"C_CLOTURE\" )  as cloture,". 
    " (select haie.\"HAIE\"::text from menu_deroulant.c_haie haie where haie.\"ID\" = caracterisation.\"C_HAIE\" )  as haie,". 
    " (select form.\"FORM\"::text from menu_deroulant.c_form form where form.\"ID\" = caracterisation.\"C_FORM\" )  as forme,". 
    " \"C_LONG\", ". 
    " \"C_LARG\", ". 
    " \"C_PROF\",". 
    " (select natf.\"NATFOND\"::text from menu_deroulant.c_natfond natf where natf.\"ID\" = caracterisation.\"C_NATFOND\" )  as natfond,". 
    " \"C_NATFOND_AUTRE\", ". 
    " (select cb.\"BERGES\"::text from menu_deroulant.c_berges cb where cb.\"ID\" = caracterisation.\"C_BERGES\" )  as berges, ". 
    " (select bour.\"BOURRELET\"::text from menu_deroulant.c_bourrelet bour where bour.\"ID\" = caracterisation.\"C_BOURRELET\" )  as bourrelet,". 
    " \"C_BOURRELET_POURCENTAGE\",". 
    " (select cp.\"PIETINEMENT\"::text from menu_deroulant.c_pietinement cp where cp.\"ID\" = caracterisation.\"C_PIETINEMENT\" )  as pietinement,". 
    " (select hyd.\"HYDROLOGIE\"::text from menu_deroulant.c_hydrologie hyd where hyd.\"ID\" = caracterisation.\"C_HYDROLOGIE\" )  as hydro, ". 
    " (select ct.\"TURBIDITE\"::text from menu_deroulant.c_turbidite ct where ct.\"ID\" = caracterisation.\"C_TURBIDITE\" )  as turbidite, ". 
    " (select coul.\"COULEUR\"::text from menu_deroulant.c_couleur coul where coul.\"ID\" = caracterisation.\"C_COULEUR\" )  as couleur, ". 
    " (select tamp.\"TAMPON\"::text from menu_deroulant.c_tampon tamp where tamp.\"ID\" = caracterisation.\"C_COULEUR\" )  as tampon, ". 
    " (select exu.\"EXUTOIRE\"::text from menu_deroulant.c_exutoire exu where exu.\"ID\" = caracterisation.\"C_EXUTOIRE\" )  as exutoire, ". 
    " \"C_RECOU_TOTAL\", ". 
    " \"C_RECOU_HELOPHYTE\", ". 
    " \"C_RECOU_HYDROPHYTE_E\", ". 
    " \"C_RECOU_HYDROPHYTE_NE\", ". 
    " \"C_RECOU_ALGUE\", ". 
    " \"C_RECOU_EAU_LIBRE\", ". 
    " \"C_RECOU_NON_VEGET\", ". 
    " (select embr.\"EMBROUS\"::text from menu_deroulant.c_embrous embr where embr.\"ID\" = caracterisation.\"C_EMBROUS\" )  as embrous, ". 
    " (select ombr.\"OMBRAGE\"::text from menu_deroulant.c_ombrage ombr where ombr.\"ID\" = caracterisation.\"C_OMBRAGE\" )  as ombrage, ". 
    " \"C_COMT\", ". 
    " ( \"C_LONG\" * \"C_LARG\" ) as surface_m2,". 
    " (select string_agg(cl.\"LIAISON\"::text, '|') as agg from saisie_observation.caracterisation_liaison liaison, menu_deroulant.c_liaison cl where caracterisation.\"ID_CARAC\" = liaison.\"ID_CARAC\" and cl.\"ID\" = liaison.\"LIAISON\"  order by 1 )  as liaison,". 
    " (select string_agg(cd.\"DECHETS\"::text, '|') as agg from saisie_observation.caracterisation_dechets dechets, menu_deroulant.c_dechets cd where caracterisation.\"ID_CARAC\" = dechets.\"ID_CARAC\" and cd.\"ID\" = dechets.\"DECHETS\"  order by 1 )  as dechet,". 
    " (select string_agg(cbat.\"PATRIMOINE\"::text, '|') as agg from saisie_observation.caracterisation_patrimoine bati, menu_deroulant.c_patrimoine cbat where caracterisation.\"ID_CARAC\" = bati.\"ID_CARAC\" and cbat.\"ID\" = bati.\"PATRIMOINE\"  order by 1 )  as bati,". 
    " (select string_agg(ca.\"ALIMENTATION\"::text, '|') as agg from saisie_observation.caracterisation_alimentation alim, menu_deroulant.c_alimentation ca where caracterisation.\"ID_CARAC\" = alim.\"ID_CARAC\" and ca.\"ID\" = alim.\"ALIMENTATION\"  order by 1 )  as alimentation,". 
    " (select string_agg(ctx.\"CONTEXT\"::text, '|') as agg from saisie_observation.caracterisation_context context, menu_deroulant.c_context ctx where caracterisation.\"ID_CARAC\" = context.\"ID_CARAC\" and ctx.\"ID\" = context.\"CONTEXT\"  order by 1 )  as contexte,". 
    " (select string_agg(cf.\"FAUNE\"::text, '|') as agg from saisie_observation.caracterisation_faune faune, menu_deroulant.c_faune cf where caracterisation.\"ID_CARAC\" = faune.\"ID_CARAC\" and cf.\"ID\" = faune.\"FAUNE\"  order by 1 )  as faune,". 
    " (select string_agg(ctr.\"TRAVAUX\"::text, '|') as agg from saisie_observation.caracterisation_travaux travaux, menu_deroulant.c_travaux ctr where caracterisation.\"ID_CARAC\" = travaux.\"ID_CARAC\" and ctr.\"ID\" = travaux.\"TRAVAUX\"  order by 1 )  as travaux,". 
    " (select string_agg(cus.\"USAGE\"::text, '|') as agg from saisie_observation.caracterisation_usage usages, menu_deroulant.c_usage cus where caracterisation.\"ID_CARAC\" = usages.\"ID_CARAC\" and cus.\"ID\" = usages.\"C_USAGE\"  order by 1 )  as usages, ". 
    " \"C_DATE\" ". 
    " FROM saisie_observation.caracterisation ". 
    " WHERE  \"L_ID\" is not null and \"L_ID\" <> '' ". 
    " ORDER BY \"L_ID\", \"C_DATE\" DESC ". 
    " ) as c   on  (l.\"L_ID\" = c.\"L_ID\")  ".$where_filtre_contour. 
    " order by 1 ");

//echo $sql_query ;

$ogr2ogr_query = $ogr2ogrPath." -f \"ESRI Shapefile\" \"".$shapefile_dir.$fname."\" PG:\""."host=$host port=$port dbname=$dbname user=$user password=$password"."\" "." -sql \"".$sql_query."\" -s_srs EPSG:4326 -t_srs EPSG:2154 -lco ENCODING=UTF-8 " ;
 
//echo $ogr2ogr_query;
 
//exec( $ogr2ogr_query, $output, $return_var);
exec( $ogr2ogr_query);
//foreach ($output as $value){
//    echo($value.'</br>');
//}
$return_var = 0;

if ($return_var == 0) {

// Get real path for our folder
$rootPath = realpath($shapefile_dir);

// Initialize archive object
$zip = new ZipArchive();
$file_name_ = "shapefile_.zip" ;
$zip->open("$shapefile_out_dir".$file_name_ , ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Initialize empty "delete list"
$filesToDelete = array();

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        //echo $filePath.' || '.$relativePath.'</br>';
        

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);

        // Add current file to "delete list"
        // delete it later cause ZipArchive create archive only after calling close function and ZipArchive lock files until archive created)
        if ($file->getFilename() != 'important.txt')
        {
            $filesToDelete[] = $filePath;
        }
    }
}

// Zip archive will be created only after closing object
$zip->close();

// Delete all files from "delete list"
foreach ($filesToDelete as $file)
{
    unlink($file);
}


$file__ = $shapefile_out_dir.$file_name_;
echo $file_name_;

//if (headers_sent()) {
//    echo 'HTTP header already sent';
//} else {
//    if (!is_file($file__)) {
//        header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
//        echo 'File not found';
//    } else if (!is_readable($file__)) {
//        header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
//        echo 'File not readable';
//    } else {
//        header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
//                header('Content-Description: File Transfer');
//                header('Content-Type: application/octet-stream');
//                header("Content-Disposition: attachment; filename=\""."pram_export_shp.zip"."\"");
//                header('Content-Transfer-Encoding: binary');
//                header('Expires: 0');
//                header('Cache-Control: must-revalidate');
//                header('Pragma: public');
//                ob_clean();
//                flush();
//                readfile($file__);
//                //unlink($file__);
//        exit;
//    }
//}



};


?>