<?php
	date_default_timezone_set('Europe/Paris');
	// ini_set("display_errors",1);
	// On se connecte ?a base de donn?
	include '../../bdd.php';
	
	//REQUETE POUR VOIR SI IL EXISTE UNE PHOTO OU PAS
	$event_exist = pg_query($bdd, 'SELECT * FROM saisie_observation.localisation_photo WHERE saisie_observation.localisation_photo."L_ID"='."'".$_GET['L_ID']."'".'');
	$count = pg_num_rows($event_exist);
	
	//REQUETE POUR VOIR SI IL EXISTE UNE PHOTO OU PAS
	$event_exist_carac = pg_query($bdd, 'SELECT * FROM saisie_observation.caracterisation_photo 
											WHERE saisie_observation.caracterisation_photo."L_ID"='."'".$_GET['L_ID']."'".'
											AND saisie_observation.caracterisation_photo."ID_CARAC"='."'".$_GET['ID_CARAC']."'".'');
	$count_carac = pg_num_rows($event_exist_carac);
	
	function dataProjet($L_ID,$ID_CARAC,$bdd){
		$data = array();
		
		//LISTE LES INFOS LOCALISATION MARE
		$req_localisation = pg_query($bdd, 'SELECT * FROM saisie_observation.localisation, ign_bd_topo.commune, saisie_observation.structure, saisie_observation.observateur, saisie_observation.caracterisation
								  WHERE saisie_observation.localisation."L_ADMIN" = commune."Num_INSEE"
								  AND saisie_observation.localisation."L_ID" = saisie_observation.caracterisation."L_ID"
								  AND saisie_observation.caracterisation."C_STRP"::text = saisie_observation.structure."S_ID"::text
								  AND saisie_observation.localisation."L_OBSV" = saisie_observation.observateur."ID"::text
								  AND caracterisation."L_ID"='."'".$L_ID."'".'');
		$donnees_localisation = pg_fetch_array($req_localisation);
		$data["INFO_LOCALISATION"] = $donnees_localisation;
		
		//LISTE LES INFOS POUR PHOTO DE MARE
		$listephoto = array();
		$req_photo = pg_query($bdd, 'SELECT * FROM saisie_observation.localisation_photo
								  WHERE saisie_observation.localisation_photo."L_ID"='."'".$L_ID."'".'');
		while ($donnees_photo = pg_fetch_array($req_photo)){
			array_push($listephoto, $donnees_photo); 
		}
		$data["INFO_PHOTO"] = $listephoto;
		
		//LISTE LES INFOS POUR PHOTO DE CARACTERISATION
		$req_photo_carac = pg_query($bdd, 'SELECT * FROM saisie_observation.caracterisation_photo
								  WHERE saisie_observation.caracterisation_photo."L_ID"='."'".$L_ID."'".'
								  AND saisie_observation.caracterisation_photo."ID_CARAC"='."'".$ID_CARAC."'".'');
		$donnees_photo_carac = pg_fetch_array($req_photo_carac);
		$data["INFO_PHOTO_CARAC"] = $donnees_photo_carac;
		
		//LISTE LES INFOS CARACTERISATION MARE
		$req_caracterisation = pg_query($bdd, 'SELECT * 
												FROM saisie_observation.caracterisation, menu_deroulant.c_type, menu_deroulant.c_veget, menu_deroulant.c_evolution,
												menu_deroulant.c_abreuv, menu_deroulant.c_form, menu_deroulant.c_prof, menu_deroulant.c_haie,
												menu_deroulant.c_ombrage, menu_deroulant.c_berges, menu_deroulant.c_embrous, menu_deroulant.c_pietinement,
												menu_deroulant.c_natfond, menu_deroulant.c_topo, menu_deroulant.c_hydrologie,
												menu_deroulant.c_patrimoine, menu_deroulant.c_cloture, menu_deroulant.c_turbidite,
												menu_deroulant.c_tampon, menu_deroulant.c_exutoire, menu_deroulant.c_couleur
												WHERE saisie_observation.caracterisation."C_TYPE" = menu_deroulant.c_type."ID"
												AND saisie_observation.caracterisation."C_VEGET" = menu_deroulant.c_veget."ID"
												AND saisie_observation.caracterisation."C_EVOLUTION" = menu_deroulant.c_evolution."ID"
												AND saisie_observation.caracterisation."C_ABREUV" = menu_deroulant.c_abreuv."ID"
												AND saisie_observation.caracterisation."C_FORM" = menu_deroulant.c_form."ID"
												AND saisie_observation.caracterisation."C_HAIE" = menu_deroulant.c_haie."ID"
												AND saisie_observation.caracterisation."C_PROF" = menu_deroulant.c_prof."ID"
												AND saisie_observation.caracterisation."C_OMBRAGE" = menu_deroulant.c_ombrage."ID"
												AND saisie_observation.caracterisation."C_BERGES" = menu_deroulant.c_berges."ID"
												AND saisie_observation.caracterisation."C_EMBROUS" = menu_deroulant.c_embrous."ID"
												AND saisie_observation.caracterisation."C_PIETINEMENT" = menu_deroulant.c_pietinement."ID"
												AND saisie_observation.caracterisation."C_NATFOND" = menu_deroulant.c_natfond."ID"
												AND saisie_observation.caracterisation."C_TOPO" = menu_deroulant.c_topo."ID"
												AND saisie_observation.caracterisation."C_HYDROLOGIE" = menu_deroulant.c_hydrologie."ID"
												AND saisie_observation.caracterisation."C_TURBIDITE" = menu_deroulant.c_turbidite."ID"
												AND saisie_observation.caracterisation."C_CLOTURE" = menu_deroulant.c_cloture."ID"
												AND saisie_observation.caracterisation."C_TAMPON" = menu_deroulant.c_tampon."ID"
												AND saisie_observation.caracterisation."C_EXUTOIRE" = menu_deroulant.c_exutoire."ID"
												AND saisie_observation.caracterisation."C_COULEUR" = menu_deroulant.c_couleur."ID"
												AND saisie_observation.caracterisation."ID_CARAC"='."'".$ID_CARAC."'".'');
		$donnees_caracterisation = pg_fetch_array($req_caracterisation);
		$data["INFO_CARACTERISATION"] = $donnees_caracterisation;
		
		//LISTE LES INFOS FAUNE
		$listefaune = array();
		$req_faune = pg_query($bdd, 'SELECT menu_deroulant.c_faune."FAUNE", saisie_observation.caracterisation_faune."FAUNE_AUTRE"
										FROM saisie_observation.caracterisation_faune, menu_deroulant.c_faune
										WHERE saisie_observation.caracterisation_faune."FAUNE" = menu_deroulant.c_faune."ID"
										AND saisie_observation.caracterisation_faune."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_faune = pg_fetch_array($req_faune)){
			array_push($listefaune, $donnees_faune); 
		}
		$data["GROUPE_FAUNE"] = $listefaune;
		
		//LISTE LES INFOS CONTEXTE DE LA MARE
		$listecontexte = array();
		$req_context = pg_query($bdd, 'SELECT menu_deroulant.c_context."CONTEXT"
										FROM saisie_observation.caracterisation_context, menu_deroulant.c_context
										WHERE saisie_observation.caracterisation_context."CONTEXT" = menu_deroulant.c_context."ID"
										AND saisie_observation.caracterisation_context."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_context = pg_fetch_array($req_context)){
			array_push($listecontexte, $donnees_context); 
		}
		$data["INFO_CONTEXTE"] = $listecontexte;
		
		
		
		//LISTE LES INFOS SUR LA LIAISON
		$listeliaison = array();
		$req_liaison = pg_query($bdd, 'SELECT menu_deroulant.c_liaison."LIAISON", saisie_observation.caracterisation_liaison."LIAISON_AUTRE"
										FROM saisie_observation.caracterisation_liaison, menu_deroulant.c_liaison
										WHERE saisie_observation.caracterisation_liaison."LIAISON" = menu_deroulant.c_liaison."ID"
										AND saisie_observation.caracterisation_liaison."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_liaison = pg_fetch_array($req_liaison)){
			array_push($listeliaison, $donnees_liaison); 
		}
		$data["INFO_LIAISON"] = $listeliaison;
		
		//LISTE LES INFOS SUR LALIMENATATION
		$listealim = array();
		$req_alim = pg_query($bdd, 'SELECT menu_deroulant.c_alimentation."ALIMENTATION", saisie_observation.caracterisation_alimentation."ALIMENTATION_AUTRE"
									FROM saisie_observation.caracterisation_alimentation, menu_deroulant.c_alimentation
									WHERE saisie_observation.caracterisation_alimentation."ALIMENTATION" = menu_deroulant.c_alimentation."ID"
									AND saisie_observation.caracterisation_alimentation."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_alim = pg_fetch_array($req_alim)){
			array_push($listealim, $donnees_alim); 
		}
		$data["INFO_ALIMENTATION"] = $listealim;
		
		//LISTE LES INFOS GROUPE FAUNISTIQUE OBSERVES
		$listefaune = array();
		$req_faune = pg_query($bdd, 'SELECT menu_deroulant.c_faune."FAUNE"
									FROM saisie_observation.caracterisation_faune, menu_deroulant.c_faune
									WHERE saisie_observation.caracterisation_faune."FAUNE" = menu_deroulant.c_faune."ID"
									AND saisie_observation.caracterisation_faune."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_faune = pg_fetch_array($req_faune)){
			array_push($listefaune, $donnees_faune); 
		}
		$data["INFO_FAUNE"] = $listefaune;
		
		
		
		//LISTE LES INFOS DECHETS ANTHROPIQUE
		$listedechet = array();
		$req_dechet = pg_query($bdd, 'SELECT menu_deroulant.c_dechets."DECHETS"
									FROM saisie_observation.caracterisation_dechets, menu_deroulant.c_dechets
									WHERE saisie_observation.caracterisation_dechets."DECHETS" = menu_deroulant.c_dechets."ID"
									AND saisie_observation.caracterisation_dechets."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_dechet = pg_fetch_array($req_dechet)){
			array_push($listedechet, $donnees_dechet); 
		}
		$data["INFO_DECHETS"] = $listedechet;
		
		//LISTE LES INFOS DUSAGE DE LA MARE
		$listeusage = array();
		$req_usage = pg_query($bdd, 'SELECT menu_deroulant.c_usage."USAGE"
									FROM saisie_observation.caracterisation_usage, menu_deroulant.c_usage
									WHERE saisie_observation.caracterisation_usage."C_USAGE" = menu_deroulant.c_usage."ID"
									AND saisie_observation.caracterisation_usage."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_usage = pg_fetch_array($req_usage)){
			array_push($listeusage, $donnees_usage); 
		}
		$data["INFO_USAGE"] = $listeusage;
		
		//LISTE LES INFOS EAEE
		$listeeaee = array();
		$req_eaee = pg_query($bdd, 'SELECT menu_deroulant.c_eaee."TAXON"
									FROM saisie_observation.caracterisation_eaee, menu_deroulant.c_eaee
									WHERE saisie_observation.caracterisation_eaee."EAEE" = menu_deroulant.c_eaee."ID"
									AND saisie_observation.caracterisation_eaee."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_eaee = pg_fetch_array($req_eaee)){
			array_push($listeeaee, $donnees_eaee); 
		}
		$data["INFO_EAEE"] = $listeeaee;
		
		//LISTE LES INFOS EVEE
		$listeevee = array();
		$req_evee = pg_query($bdd, 'SELECT menu_deroulant.c_evee."TAXON", menu_deroulant.c_evee_pourcent."POURCENTAGE"
									FROM saisie_observation.caracterisation_evee, menu_deroulant.c_evee, menu_deroulant.c_evee_pourcent
									WHERE saisie_observation.caracterisation_evee."EVEE" = menu_deroulant.c_evee."ID"
									AND saisie_observation.caracterisation_evee."EVEE_POURCENT" = menu_deroulant.c_evee_pourcent."ID"
									AND saisie_observation.caracterisation_evee."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_evee = pg_fetch_array($req_evee)){
			array_push($listeevee, $donnees_evee); 
		}
		$data["INFO_EVEE"] = $listeevee;
		
		//LISTE LES INFOS TRAVAUX ENVISAGER
		$listetrav = array();
		$req_trav = pg_query($bdd, 'SELECT menu_deroulant.c_travaux."TRAVAUX", saisie_observation.caracterisation_travaux."TRAVAUX_AUTRE"
									FROM saisie_observation.caracterisation_travaux, menu_deroulant.c_travaux
									WHERE saisie_observation.caracterisation_travaux."TRAVAUX" = menu_deroulant.c_travaux."ID"
									AND saisie_observation.caracterisation_travaux."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_trav = pg_fetch_array($req_trav)){
			array_push($listetrav, $donnees_trav); 
		}
		$data["INFO_TRAVAUX"] = $listetrav;
		
		//LISTE LES INFOS PATRIMOINE
		$listepatrimoine = array();
		$req_patrimoine = pg_query($bdd, 'SELECT menu_deroulant.c_patrimoine."PATRIMOINE", saisie_observation.caracterisation_patrimoine."PATRIMOINE_AUTRE"
									FROM saisie_observation.caracterisation_patrimoine, menu_deroulant.c_patrimoine
									WHERE saisie_observation.caracterisation_patrimoine."PATRIMOINE" = menu_deroulant.c_patrimoine."ID"
									AND saisie_observation.caracterisation_patrimoine."ID_CARAC"='."'".$ID_CARAC."'".'');
		while ($donnees_patrimoine = pg_fetch_array($req_patrimoine)){
			array_push($listepatrimoine, $donnees_patrimoine); 
		}
		$data["INFO_PATRIMOINE"] = $listepatrimoine;
		
		
		return $data;	
	}
	
	
	
	
	
	
	//Permet de r?perer la valeur de ID_Projet et de $bdd
	$infos = dataProjet($_GET['L_ID'],$_GET['ID_CARAC'],$bdd);	

	//Permet la gestion des informations par rapport ?a fiche
	$document = "
			<page>
			<page_header>
				<table style='width:100%;'> 
					<tr>				
						<td style='width:20%;text-align:left;font-size:14px;'>
							<img src='../../img/pram.jpg' style='width:50%'>
						</td>
						<td style='width:60%;text-align:center;font-size:14px;'>
						</td>
						<td style='width:20%;text-align:right;font-size:14px;'>";
							if($infos["INFO_LOCALISATION"]["LOGO_STRUCTURE"] <> ""){
								$document .= "<img src='".substr($infos["INFO_LOCALISATION"]["LOGO_STRUCTURE"], 3)."' style='width:15%'/>";
							}else{
									$document .= "<img src='../../img/logo_cenhn.png' style='width:100%'>";
							};
						$document .= "</td>
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
							<b>FICHE DE CARACTERISATION DE LA MARE ".$infos["INFO_LOCALISATION"]["L_ID"]."</b><br>
							<b>COMMUNE DE : ".$infos["INFO_LOCALISATION"]["Nom_Commune"]."</b>
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
							<b>Date de caractérisation : </b> ".date('d/m/Y', $infos["INFO_CARACTERISATION"]["C_DATE"])."
							
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Nom de la mare : </b> ".$infos["INFO_LOCALISATION"]["L_NOM"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Commune : </b> ".$infos["INFO_LOCALISATION"]["Nom_Commune"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Numéro INSEE : </b> ".$infos["INFO_LOCALISATION"]["L_ADMIN"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Structure : </b> ".$infos["INFO_LOCALISATION"]["STRUCTURE"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Observateur : </b> ".$infos["INFO_LOCALISATION"]["OBS_NOM_PRENOM"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Mode de localisation : </b>";
								if($infos["INFO_LOCALISATION"]["L_PREC"] == "1.5"){
									$document.="Photo aérienne";
								}else if($infos["INFO_LOCALISATION"]["L_PREC"] == "7.5"){
									$document.="Carte IGN SCAN 25";
								}else if($infos["INFO_LOCALISATION"]["L_PREC"] == "mesuré"){
									$document.="GPS";
								};
						$document.="
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Type de mare : </b> ".$infos["INFO_CARACTERISATION"]["TYPE"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Végétation aquatique : </b> ".$infos["INFO_CARACTERISATION"]["VEGET"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td colspan='2' style='width:50%;text-align:left;font-size:14px;'>
							<b>Groupe faunistique observés : </b> ";
								foreach($infos["GROUPE_FAUNE"] as $groupefaune){
									if($groupefaune["FAUNE"] == "Autre"){
										$document.= $groupefaune["FAUNE"]." (".$groupefaune["FAUNE_AUTRE"].") ; ";
									}else{
										$document.= $groupefaune["FAUNE"]." ; ";
									}
								};
						$document.="
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td colspan='2' style='width:50%;text-align:left;font-size:14px;'>
							<b>Stade d'évolution : </b> ".$infos["INFO_CARACTERISATION"]["EVOLUTION"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td colspan='2' style='width:100%;text-align:center;font-size:14px;'>";
							foreach($infos["INFO_PHOTO"] as $photo){
									$document.="<img src='".$photo["LIEN"]."' style='width:20%'>";
							}
							$document.="
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
							<b>Usage principal de la mare : </b> ";
									foreach($infos["INFO_USAGE"] as $usage){
										$document.= $usage["USAGE"]." ; ";
									}
						$document.="
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Mare équipée d'une pompe à nez : </b> ".$infos["INFO_CARACTERISATION"]["ABREUV"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Présence de déchets : </b> ";
									foreach($infos["INFO_DECHETS"] as $dechets){
										$document.= $dechets["DECHETS"]." ; ";
									}
						$document.="
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
							<b>Topographie : </b> ".$infos["INFO_CARACTERISATION"]["TOPO"];
								if($infos["INFO_CARACTERISATION"]["C_TOPO"] == "5"){
										$document.= " : ".$infos["INFO_CARACTERISATION"]["C_TOPO_AUTRE"];
									}
						$document.="
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Contexte : </b> ";
								foreach($infos["INFO_CONTEXTE"] as $context){
									$document.= $context["CONTEXT"]." ; ";
								}
						$document.="
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Petit patrimoine associé : </b> ";
								foreach($infos["INFO_PATRIMOINE"] as $patrimoine){
										if($patrimoine["PATRIMOINE"] == "autres"){
											$document.= $patrimoine["PATRIMOINE"]." (".$patrimoine["PATRIMOINE_AUTRE"].") ; ";
										}else{
											$document.= $patrimoine["PATRIMOINE"]." ; <br>";
										}
									}
						$document.="
						</td>
						
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Mare clôturée : </b> ".$infos["INFO_CARACTERISATION"]["CLOTURE"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Présence d'une haie : </b> ".$infos["INFO_CARACTERISATION"]["HAIE"]."
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
							<b>Forme : </b> ".$infos["INFO_CARACTERISATION"]["FORM"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Taille moyenne (m) : </b> ".$infos["INFO_CARACTERISATION"]["C_LONG"]." de longueur et ".$infos["INFO_CARACTERISATION"]["C_LARG"]." de largeur
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Profondeur : </b> ".$infos["INFO_CARACTERISATION"]["PROF"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Nature du fond : </b> ".$infos["INFO_CARACTERISATION"]["NATFOND"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>	
					<tr>	
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Berges en pente douce : </b> ".$infos["INFO_CARACTERISATION"]["BERGES"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Bourrelet de curage : </b> ".$infos["INFO_CARACTERISATION"]["C_BOURRELET"];
									if($infos["INFO_CARACTERISATION"]["C_BOURRELET"] == "Oui"){
										$document.= " : ".$infos["INFO_CARACTERISATION"]["C_BOURRELET_POURCENTAGE"]."%";
									}
						$document.="						
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>	
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Surpiétinement des abords : </b> ".$infos["INFO_CARACTERISATION"]["PIETINEMENT"]."
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
							<b>Régime hydrographique : </b> ".$infos["INFO_CARACTERISATION"]["HYDROLOGIE"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Laison avec le réseau hydro : </b> ";
								foreach($infos["INFO_LIAISON"] as $context){
									if($context["LIAISON"] == "autre"){
										$document.= $context["LIAISON"]." (".$context["LIAISON_AUTRE"].") ;";
									}else{
										$document.= $context["LIAISON"]." ; ";
									}
							}
					$document.="
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
							<b>Alimentation dpécifique : </b> ";
								foreach($infos["INFO_ALIMENTATION"] as $alim){
									if($alim["ALIMENTATION"] == "autre"){
										$document.= $alim["ALIMENTATION"]." (".$alim["ALIMENTATION_AUTRE"].") ;";
									}else{
										$document.= $alim["ALIMENTATION"]." ; ";
									}
							}
					$document.="
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Turbidité de l'eau : </b> ".$infos["INFO_CARACTERISATION"]["TURBIDITE"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Couleur spécifique de l'eau : </b> ".$infos["INFO_CARACTERISATION"]["COULEUR"];
							if($infos["INFO_CARACTERISATION"]["C_COULEUR"] == "3"){
										$document.= " : ".$infos["INFO_CARACTERISATION"]["C_COULEUR_PRECISION"];
									}
						$document.="	
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Tampon : </b> ".$infos["INFO_CARACTERISATION"]["TAMPON"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Exutoire : </b> ".$infos["INFO_CARACTERISATION"]["EXUTOIRE"]."
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
							<b>Recouv. total : </b> ".$infos["INFO_CARACTERISATION"]["C_RECOU_TOTAL"]."%<br><br>
							<b>Recouv. hélophytes : </b> ".$infos["INFO_CARACTERISATION"]["C_RECOU_HELOPHYTE"]."%<br><br>
							<b>Recouv. hydrophytes enracinées : </b> ".$infos["INFO_CARACTERISATION"]["C_RECOU_HYDROPHYTE_E"]."%<br><br>
							<b>Recouv. hydrophytes non enracinés : </b> ".$infos["INFO_CARACTERISATION"]["C_RECOU_HYDROPHYTE_NE"]."%<br><br>
							<b>Recouv. algues : </b> ".$infos["INFO_CARACTERISATION"]["C_RECOU_ALGUE"]."%<br><br>
							<b>Recouv. eau libre : </b> ".$infos["INFO_CARACTERISATION"]["C_RECOU_EAU_LIBRE"]."%<br><br>
							<b>Recouv. non végétalisé : </b> ".$infos["INFO_CARACTERISATION"]["C_RECOU_NON_VEGET"]."%<br>
						</td>	
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Boisement / Embroussaillement : </b> ".$infos["INFO_CARACTERISATION"]["EMBROUS"]."
						</td>
						<td style='width:50%;text-align:left;font-size:14px;'>
							<b>Ombrage surface par ligneux : </b> ".$infos["INFO_CARACTERISATION"]["OMBRAGE"]."
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
							<b>Espèce animale exotique envahissante : </b> ";
								foreach($infos["INFO_EAEE"] as $eaee){
									$document.= $eaee["TAXON"]." ; ";
								}
						$document.="
						</td>
					</tr>
					<tr><td style='height:1%;'></td></tr>
					<tr>
						<td colspan='2' style='width:100%;text-align:left;font-size:14px;'>
							<b>Espèce végétale exotique envahissante : </b> ";
								foreach($infos["INFO_EVEE"] as $evee){
									$document.= $evee["TAXON"]." (".$evee["POURCENTAGE"].") ; ";
								}
						$document.="
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
							<b>Travaux à envisager : </b> ";
									foreach($infos["INFO_TRAVAUX"] as $trav){
										if($trav["TRAVAUX"] == "autres"){
											$document.= $trav["TRAVAUX"]." (".$trav["TRAVAUX_AUTRE"].") ; ";
										}else{
											$document.= $trav["TRAVAUX"]." ; <br>";
										}
									}
						$document.="
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
							<b>Commentaires : </b> ".$infos["INFO_CARACTERISATION"]["C_COMT"]."
						</td>
						<td style='width:50%;text-align:center;font-size:14px;'>";
							if($count_carac >= 1){
									$document.="<img src='".$infos["INFO_PHOTO_CARAC"]["LIEN"]."' style='width:50%'>";
							}else{
									$document.="<img src='../../img/photo/no_picture.jpg' style='width:50%'>";
							}
							$document.="
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
	

	// $accent = array("ö", "? "?","?"?"?"?"?"?"??û","°","?"¢,"ù","+");
	// $accentTrans = array("&ouml;", "&ccedil;", "&#128;","&agrave;", "&euml;", "&eacute;","&egrave;","&ecirc;","&icirc;","&ocirc;","&ucirc;","&deg;","&acirc;","&Acirc;","&uuml;","&#134;");
		
	// $document = 	str_replace($accent,$accentTrans,$document);
	
	
	// echo $document;
	
	//ATTENTION A OU SE TROUVE LA LIBRAIRIE PAR RAPPORT A TON FICHIER :)
	
	require_once('../../html2pdf/html2pdf.class.php');
	$marges = array(10, 10, 10, 10);
    $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', $marges);
    $html2pdf->WriteHTML($document);
	ob_end_clean();
	$html2pdf->Output('monFichier.pdf');	
	

?>