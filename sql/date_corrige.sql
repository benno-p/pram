/* SCRIPT SQL de mise à jour des localisations dans une nouvelle table mares.localisations */

------------------------------------------------------------------------
--CREATE TABLE
CREATE TABLE mares.localisations
(
  loc_id serial NOT NULL,
  loc_id_plus text,
  loc_uuid uuid DEFAULT uuid_generate_v1(),
  loc_nom text,
  loc_proprietaire text,
  loc_statut text,
  loc_date date,
  loc_obsv text,
  loc_comt text,
  loc_geom geometry,
  car_ids text,
  CONSTRAINT localisations_pkey PRIMARY KEY (loc_id)
);
CREATE TRIGGER set_code_plus
  AFTER INSERT OR UPDATE OR DELETE
  ON mares.localisations
  FOR EACH ROW
  EXECUTE PROCEDURE loc_codeplus();
------------------------------------------------------------------------



------------------------------------------------------------------------
-- INSERT FROM OLD FORMAT WITH DATEs CORRECTION
insert into mares.localisations(
             loc_nom, loc_proprietaire, loc_statut, 
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
------------------------------------------------------------------------



------------------------------------------------------------------------
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
UPDATE mares.localisations set loc_proprietaire = 
CASE WHEN loc_proprietaire = '2' THEN 'Public'
WHEN loc_proprietaire = '3' THEN 'Privé'
WHEN loc_proprietaire = '4' THEN 'Mixte'
WHEN loc_proprietaire = '5' THEN 'Inconnu'
ELSE 'A saisir'
END;
------------------------------------------------------------------------



























