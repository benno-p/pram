<?php
include '../properties.php';


$table_name_search = $_POST["table_name_search"];
$id_search = $_POST["id_search"];

$sql = "select l.loc_id, l.loc_id_plus,  l.loc_uuid, l.loc_nom, l.loc_type_propriete, l.loc_statut,  l.loc_date,  l.loc_obsv,  l.loc_comt,  l.loc_anonymiser,  l.car_ids,  l.loc_id_user, c.id, c.id_plus, c.date, c.obsv, c.strp, c.type, c.veget, c.evolution, c.abreuv, c.topo, c.topo_autre, c.cloture, c.haie, c.form, c.long, c.larg, c.natfond, c.natfond_autre, c.berges, c.bourrelet, c.bourrelet_pourcentage, c.pietinement, c.hydrologie, c.turbidite, c.couleur, c.tampon, c.exutoire, c.recou_total, c.recou_helophyte, c.recou_hydrophyte_e, c.recou_hydrophyte_ne, c.recou_algue, c.recou_eau_libre, c.prof, c.embrous, c.ombrage, c.comt, c.recou_non_veget, c.patrimoine, c.patrimoine_autre, c.couleur_precision, c.objec_trav, c.travaux, c.liaison, c.dechet, c.alimentation, c.contexte, c.faune, c.usage, c.bati, c.eaee, c.evee, c.id_user, c.faune_autre, c.liaison_autre, c.alimentation_autre, c.travaux_autre, l.loc_geom from  
    (   select  loc_id,  loc_id_plus,  loc_uuid,  loc_nom,  loc_type_propriete,  loc_statut,  loc_date,  loc_obsv,  loc_comt,  loc_anonymiser,  loc_geom,  car_ids,  loc_id_user from mares.localisations 
        join 
        (select l_geom from layers.".pg_escape_string($table_name_search)." where l_id = '".pg_escape_string($id_search)."') t  
        on st_intersects(localisations.loc_geom, t.l_geom) 
    ) as l left join 
    ( select distinct on (loc_id_plus)  car_id as id, car_id_plus as id_plus, loc_id_plus, loc_id_strp, car_date as date, car_obsv as obsv, car_strp as strp, car_type as type, car_veget as veget, car_evolution as evolution, car_abreuv as abreuv, car_topo as topo, car_topo_autre as topo_autre, car_cloture as cloture, car_haie as haie, car_form as form, car_long as long, car_larg as larg, car_natfond as natfond, car_natfond_autre as natfond_autre, car_berges as berges, car_bourrelet as bourrelet, car_bourrelet_pourcentage as bourrelet_pourcentage, car_pietinement as pietinement, car_hydrologie as hydrologie, car_turbidite as turbidite, car_couleur as couleur, car_tampon as tampon, car_exutoire as exutoire, car_recou_total as recou_total, car_recou_helophyte as recou_helophyte, car_recou_hydrophyte_e as recou_hydrophyte_e, car_recou_hydrophyte_ne as recou_hydrophyte_ne, car_recou_algue as recou_algue, car_recou_eau_libre as recou_eau_libre, car_embrous as embrous, car_ombrage as ombrage, car_comt as comt, car_recou_non_veget as recou_non_veget, car_patrimoine as patrimoine, car_patrimoine_autre as patrimoine_autre, car_couleur_precision as couleur_precision, car_objec_trav as objec_trav, car_travaux as travaux, car_liaison as liaison, car_dechet as dechet, car_alimentation as alimentation, car_contexte as contexte, car_faune as faune, car_usage as usage, car_bati as bati, car_eaee as eaee, car_evee as evee, car_id_user as id_user, car_faune_autre as faune_autre, car_liaison_autre as liaison_autre, car_alimentation_autre as alimentation_autre, car_travaux_autre as travaux_autre, car_prof as prof from mares.caracterisations order by loc_id_plus, car_date desc ) as c on  (l.loc_id_plus = c.loc_id_plus);";

//echo $sql;

$ogr2ogr_query = "ogr2ogr -f \"ESRI Shapefile\" \"$path_shapefile_serveur"."yop.shp\" PG:\"host=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS\" -sql \"".$sql."\" -lco ENCODING=UTF-8 " ;
exec( $ogr2ogr_query);

$rootPath = realpath($path_shapefile_serveur);

// Initialize archive object
$zip = new ZipArchive();
$file_name_ = "shapefile_.zip" ;
$zip->open("$path_shapefile_serveur_out".$file_name_ , ZipArchive::CREATE | ZipArchive::OVERWRITE);

$filesToDelete = array();

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        $zip->addFile($filePath, $relativePath);
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
$file__ = "$path_shapefile_serveur_out".$file_name_;
echo $file_name_;




?>