<?php
session_start();
include "../../properties.php";

// LOAD LIST PHOTO
$dbconn = pg_connect("hostaddr=$ODK_DBHOST port=$ODK_PORT dbname=$ODK_DBNAME user=$ODK_LOGIN password=$ODK_PASS")
or die ('Connexion impossible :'. pg_last_error());

$result = pg_prepare($dbconn, "sql", "INSERT INTO fdw.localisations(
loc_uuid, 
loc_nom, 
loc_type_propriete, 
loc_statut,
loc_date, 
loc_obsv, 
loc_comt, 
loc_anonymiser, 
loc_geom, 
loc_id_user)
 SELECT 
        replace($1::text, 'uuid:',''),
        $2::text,
        $3::text,
        'caractérisée'::text,
        $4::timestamp::date, 
        $5,
        $6,
        $7,
        st_makepoint($8, $9),
        $10
    FROM $odk_pram_obs
    WHERE $1 = $11;
    "
$result = pg_execute($dbconn, "sql",array(
'"_URI"', 
'"DATA_GLOBAL_ID_MARE"', 
'"DATA_GLOBAL_TYPE_PROPR"', 
'"DATA_GLOBAL_DATE_MARE"', 
$_SESSION['nom_prenom'], 
'"SCHEMA_MARE_CMT_MARE"', 
true, 
'"MARE_GEOPOINT_LNG"',
'"MARE_GEOPOINT_LAT"', 
'"EMAIL"',
"_URI",
$_SESSION['email'],
$_POST['uuid']
));

while($row = pg_fetch_row($result))
{
  echo trim($row[0]);
}
pg_close($dbconn);

?>