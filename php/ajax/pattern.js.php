<?php
include '../properties.php';


$table_name_search = 'communes_2018';
$id_search = '14118';


//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$m_result = pg_query_params( $dbconn, "
select
l.loc_id, 
l.loc_id_plus, 
l.loc_uuid, 
c.id,
c.id_plus
from 
(
select 
loc_id, 
loc_id_plus, 
loc_uuid 
from mares.localisations
left join (select l_geom from layers.".pg_escape_string($table_name_search)." where l_id = $1) t 
on st_intersects(localisations.loc_geom, t.l_geom)
) as l
left join
(
select distinct on (loc_id_plus) 
car_id as id,
car_id_plus as id_plus,
loc_id_plus
from mares.caracterisations
order by loc_id_plus, car_date desc
) as c on  (l.loc_id_plus = c.loc_id_plus) 
", array($id_search) ) or die ( pg_last_error());

while($row = pg_fetch_row($m_result))
{
  echo trim($row[2]);
}
//ferme la connexion a la BD
pg_close($dbconn);

?>