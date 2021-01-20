------------------------------------------------
--NEW DB
------------------------------------------------

------------------------------------------------
--Nouvelle table users
------------------------------------------------
CREATE TABLE saisie_observation.users
(
  u_id serial NOT NULL,
  u_nom text,
  u_prenom text,
  u_courriel text,
  u_id_session text,
  u_id_structure text,
  u_id_nom_structure text,
  u_pwd text,
  u_telephone text,
  u_logo text,
  u_geom geometry,
  u_uuid uuid DEFAULT uuid_generate_v1(),
  u_old_id text,
  u_old_mdp text,
  CONSTRAINT users_pkey PRIMARY KEY (u_id)
);
--Update depuis l'ancienne table
INSERT INTO saisie_observation.users (
u_nom, u_prenom, u_courriel, u_id_session, u_id_structure, 
       u_id_nom_structure, u_pwd,  u_logo, u_geom, u_old_id, u_old_mdp)
SELECT 
o."OBS_NOM", o."OBS_PRENOM", s."S_EMAIL", s."S_ID_SESSION", s."S_ID", s."STRUCTURE", md5(s."S_MDP"), s."LOGO_STRUCTURE", s.geom, o."ID", s."S_MDP"
FROM saisie_observation.structure s, saisie_observation.observateur o
where s."STRUCTURE"::text = o."OBS_STRUCTURE";

------------------------------------------------
--LOCALISATION
------------------------------------------------
CREATE TABLE mares.localisations
(
  loc_id serial NOT NULL,
  loc_id_plus text,
  loc_uuid uuid DEFAULT uuid_generate_v1(),
  loc_nom text,
  loc_type_propriete text,
  loc_statut text,
  loc_date date,
  loc_obsv text,
  loc_comt text,
  loc_anonymiser boolean,
  loc_geom geometry,
  car_ids text,
  CONSTRAINT localisations_pkey PRIMARY KEY (loc_id)
)
;
CREATE TRIGGER set_code_plus
  AFTER INSERT OR UPDATE OR DELETE
  ON mares.localisations
  FOR EACH ROW
  EXECUTE PROCEDURE loc_codeplus();

-- INSERT FROM OLD FORMAT WITH DATEs CORRECTION
insert into mares.localisations(
             loc_nom, loc_type_propriete, loc_statut, 
            loc_date, loc_obsv, loc_comt, loc_geom, car_ids)

SELECT "L_NOM", "L_PROP", "L_STATUT", 
    CASE WHEN "L_DATE" < 0 THEN  a_get_date_fromint(0::int)::date
        WHEN "L_DATE" > 2147483647 THEN Now()::date 
        ELSE a_get_date_fromint("L_DATE"::int)::date
    END as date_,
    "L_OBSV", "C_COMT", geom, null
  FROM saisie_observation.localisation
  --where "L_DATE">-31948506021 and 31948506021>"L_DATE"
;

--Convertion des valeurs vers le texte correspondant
--STATUT
UPDATE mares.localisations set loc_statut = 
CASE WHEN loc_statut = '2' THEN 'Potentielle'
WHEN loc_statut = '3' THEN 'Vue'
WHEN loc_statut = '4' THEN 'Caractérisée'
WHEN loc_statut = '5' THEN 'Disparue'
ELSE 'A saisir'
END;
--PROPRIETAIRE
UPDATE mares.localisations set loc_type_propriete = 
CASE WHEN loc_type_propriete = '2' THEN 'Public'
WHEN loc_type_propriete = '3' THEN 'Privé'
WHEN loc_type_propriete = '4' THEN 'Mixte'
WHEN loc_type_propriete = '5' THEN 'Inconnu'
ELSE 'A saisir'
END;


------------------------------------------------
--CARACTERISATION
------------------------------------------------
CREATE TABLE mares.caracterisations
(
  car_id serial NOT NULL,
  car_id_plus text, -- loc_id_plus + serial
  loc_id_plus text,
  loc_idstrp text,
  car_date date,
  car_obsv text,
  car_strp text,
  car_type text,
  car_veget text,
  car_evolution text,
  car_abreuv text,
  car_topo text,
  car_topo_autre text,
  car_cloture text,
  car_haie text,
  car_form text,
  car_long double precision,
  car_larg double precision,
  car_prof integer,
  car_natfond text,
  car_natfond_autre text,
  car_berges text,
  car_bourrelet text,
  car_bourrelet_pourcentage text,
  car_pietinement text,
  car_hydrologie text,
  car_turbidite text,
  car_couleur text,
  car_tampon text,
  car_exutoire text,
  car_recou_total double precision,
  car_recou_helophyte double precision,
  car_recou_hydrophyte_e double precision,
  car_recou_hydrophyte_ne double precision,
  car_recou_algue double precision,
  car_recou_eau_libre double precision,
  car_embrous text,
  car_ombrage text,
  car_comt text,
  car_recou_non_veget double precision,
  car_patrimoine text,
  car_patrimoine_autre text,
  car_couleur_precision text,
  car_objec_trav text,
  CONSTRAINT caracterisation_pkey PRIMARY KEY (car_id)
);
COMMENT ON COLUMN mares.caracterisations.car_id_plus IS 'loc_id_plus + serial';
--INSERT INTO
INSERT INTO mares.caracterisations(
--car_id, 
--car_id_plus, 
loc_id_plus, 
loc_idstrp, 
car_date, 
car_obsv, 
car_strp, 
car_type, 
car_veget, 
car_evolution, 
car_abreuv, 
car_topo, 
car_topo_autre, 
car_cloture, 
car_haie, 
car_form, 
car_long, 
car_larg, 
car_prof, 
car_natfond, 
car_natfond_autre, 
car_berges, 
car_bourrelet, 
car_bourrelet_pourcentage, 
car_pietinement, 
car_hydrologie, 
car_turbidite, 
car_couleur, 
car_tampon, 
car_exutoire, 
car_recou_total, 
car_recou_helophyte, 
car_recou_hydrophyte_e, 
car_recou_hydrophyte_ne, 
car_recou_algue, 
car_recou_eau_libre, 
car_embrous, 
car_ombrage, 
car_comt, 
car_recou_non_veget, 
car_patrimoine, 
car_patrimoine_autre, 
car_couleur_precision, 
car_objec_trav)
SELECT 
--"ID_CARAC", 
"L_ID", 
"L_IDSTRP", 
CASE WHEN "C_DATE" is null then to_date('01-01-2001', 'DD-MM-YYYY')
ELSE to_date(a_get_date_frombigint("C_DATE"), 'DD-MM-YYYY')
END as date_, 
"C_OBSV", 
"C_STRP", 
"C_TYPE", 
"C_VEGET", 
"C_EVOLUTION", 
"C_ABREUV", 
"C_TOPO", 
"C_TOPO_AUTRE", 
"C_CLOTURE", 
"C_HAIE", 
"C_FORM", 
"C_LONG", 
"C_LARG", 
"C_PROF", 
"C_NATFOND", 
"C_NATFOND_AUTRE", 
"C_BERGES", 
"C_BOURRELET", 
"C_BOURRELET_POURCENTAGE", 
"C_PIETINEMENT", 
"C_HYDROLOGIE", 
"C_TURBIDITE", 
"C_COULEUR", 
"C_TAMPON", 
"C_EXUTOIRE", 
"C_RECOU_TOTAL", 
"C_RECOU_HELOPHYTE", 
"C_RECOU_HYDROPHYTE_E", 
"C_RECOU_HYDROPHYTE_NE", 
"C_RECOU_ALGUE", 
"C_RECOU_EAU_LIBRE", 
"C_EMBROUS", 
"C_OMBRAGE", 
"C_COMT", 
"C_RECOU_NON_VEGET", 
--"TEST_CARAC", 
"C_PATRIMOINE", 
"C_PATRIMOINE_AUTRE", 
"C_COULEUR_PRECISION", 
--"ID_CARAC_IMPORT", 
"C_OBJEC_TRAV"
  FROM saisie_observation.caracterisation;

--update loc_id_plus
with loc as 
(select lo."L_ID",l.loc_id_plus
from mares.localisations l left join saisie_observation.localisation lo on (pluscode(st_y(lo.geom), st_x(lo.geom),10) = left(l.loc_id_plus,11))
)
UPDATE mares.caracterisations c
   SET loc_id_plus = loc.loc_id_plus 
   from loc
   where loc."L_ID" = c.loc_id_plus;

--update car_id_plus
update mares.caracterisations set 
car_id_plus = left(loc_id_plus,11)||'_'||car_id::text;

--delete false data obsv is null strp null etc
--delete from mares.caracterisations where car_obsv is null and car_type is null;


--convert values CARACTERISATION




------------------------------------------------
--PHOTOS
------------------------------------------------
--Les photos sont désormais rattachées aux caractérisations
create table mares.photos (
photo_id serial primary key,
car_id_plus text,
car_photo_link text,
photo bytea
);
comment on column mares.photos.car_photo_link is 'car_id_plus + _serial';


















