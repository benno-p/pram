<?php
session_start();
include '../properties.php';
//connexion a la BD
$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());

$sql = "
select array_to_json(array_agg(row_to_json(t)))
    from (
SELECT 
i,
month_,
year_,
coalesce(sum(l.nb_loc),0) AS s_l,
coalesce(count(c.nb_car),0) AS s_c,
coalesce(count(p.nb_photo),0) AS s_p
FROM    ( 
        select  to_char( (now()::date + ((i)::text||' month')::interval)::date, 'TMMonth') as month_,
        to_char( (now()::date + ((i)::text||' month')::interval)::date, 'YYYY') as year_,
        i
        FROM generate_series (-12, 0) i
        ) i
LEFT JOIN (
    select to_char(loc_date,'TMMonth') as mon, to_char(loc_date,'YYYY') as year , count(l.*) as nb_loc
    from mares.localisations l 
    where loc_date is not null group by 1,2
) l ON (l.mon = i.month_ AND l.year = i.year_)
LEFT JOIN (
    select to_char(car_date,'TMMonth') as mon, to_char(car_date,'YYYY') as year , count(l.*) as nb_car
    from mares.caracterisations l 
    where car_date is not null group by 1,2
) c ON (c.mon = i.month_ AND c.year = i.year_)
LEFT JOIN (
    select to_char(date_photo,'TMMonth') as mon, to_char(date_photo,'YYYY') as year ,count(l.*) as nb_photo
    from mares.photos l 
    where date_photo is not null group by 1,2
) p ON (c.mon = i.month_ AND c.year = i.year_)
GROUP  BY 1,2,3
ORDER  BY 1
    ) t";

//execute la requete dans le moteur de base de donnees  
$query_result = pg_exec($dbconn,$sql) or die (pgErrorMessage());
while($row = pg_fetch_row($query_result))
{
  echo trim($row[0]);
}
//ferme la connexion a la BD
pg_close($dbconn);
?>
