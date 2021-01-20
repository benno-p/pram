<?php
session_start();
include "../../properties.php";


//CHECK IF PHOTOS ARE WRITTEN ON SERVER IF NOT WRITE
//$dbconn = pg_connect("hostaddr=$ODK_DBHOST port=$ODK_PORT dbname=$ODK_DBNAME user=$ODK_LOGIN password=$ODK_PASS")
//or die ('Connexion impossible :'. pg_last_error());
//$result = pg_prepare($dbconn, "sql", "
//with data_ as (
//    SELECT 
//    odk.uuid_core, 
//    odk.id_user, 
//    odk.date_import, 
//    odk.date_form, 
//    odk.status
//    FROM $odk_import_odk_pram odk
//    WHERE 
//    odk.status = $1 AND
//    odk.id_user = $2
//)
//SELECT 
//    obs.\"_URI\",
//    data_.uuid_core,
//    encode(photo.\"VALUE\", 'base64') as img, 
//    replace(trim(photo.\"_URI\", 'uuid:'), '-','')||'.jpg' as id_
//    FROM 
//    data_ LEFT JOIN 
//    $odk_pram_obs obs ON (((obs.\"_URI\")::text = (data_.uuid_core)::text))
//    LEFT JOIN $odk_pram_obs_ajout_photo ap ON (((ap.\"_PARENT_AURI\")::text = (obs.\"_URI\")::text))
//    LEFT JOIN $odk_pram_obs_photo_mare_bn blb_bn ON (((ap.\"_URI\")::text = (blb_bn.\"_PARENT_AURI\")::text))
//    LEFT JOIN $odk_pram_obs_photo_mare_ref blb_ref ON (((blb_bn.\"_URI\")::text = (blb_ref.\"_DOM_AURI\")::text))
//    LEFT JOIN $odk_pram_obs_photo_mare_blb photo ON (((blb_ref.\"_SUB_AURI\")::text = (photo.\"_URI\")::text))
//WHERE photo.\"VALUE\" IS NOT NULL;
//");
//// --photo.\"_URI\",
//// --photo.\"VALUE\"
//
//$result = pg_execute($dbconn, "sql",array(
//'pending', $_SESSION['email']
//));
//
//while($row = pg_fetch_row($result))
//{
//    $image = pg_unescape_bytea($row[2]);
//    $link_to_write = $odk_photos_directory.$row[3];
//    if (file_exists($link_to_write)) {
//        //do nothing
//    } else {
//        file_put_contents($link_to_write, base64_decode($image) );
//    }
//};
//pg_close($dbconn);




// LOAD LIST PHOTO
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());


$result = pg_prepare($dbconn, "sql", "
with data_ as (
    SELECT 
    odk.id, 
    odk.uuid_core, 
    odk.formulaire, 
    odk.id_user, 
    odk.date_import, 
    odk.date_form, 
    odk.status, 
    COALESCE(odk.lng, st_x(l.loc_geom)) as lng,
    COALESCE(odk.lat, st_y(l.loc_geom)) as lat,
    odk.loc_id, 
    odk.loc_id_plus,
    COALESCE(odk.photo_id, 'nothing.png') as photo_id
    FROM $suivi_odk odk
    LEFT JOIN $localisations l ON l.loc_id_plus = odk.loc_id_plus 
    WHERE 
    odk.status = $1 AND
    odk.id_user = $2
)
SELECT row_to_json(fc)
FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
FROM (SELECT 'Feature' As type
   , ST_AsGeoJSON( st_setsrid(st_makepoint(lg.lng,lg.lat),4326) )::json As geometry
   , row_to_json(lp) As properties
  FROM  data_ As lg 
        INNER JOIN (
select * from data_
) As lp 
ON lg.uuid_core = lp.uuid_core ) As f )  As fc
");
$result = pg_execute($dbconn, "sql",array(
'pending', $_SESSION['email']
));

while($row = pg_fetch_row($result))
{
  echo trim($row[0]);
}
pg_close($dbconn);

?>