<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PRAM Normandie</title>
    <script>L_PREFER_CANVAS = true;</script>
    
    
    
    <!--LEAFLET-->
    <link href="css/leaflet.css" rel="stylesheet" type="text/css">
    <link href="js/leaflet/plugins/Leaflet.draw-master/dist/leaflet.draw.css" rel="stylesheet" type="text/css">
    <link href="js/leaflet/plugins/leaflet_label/css/leafleat_label.css" rel="stylesheet" type="text/css">
    <link href="css/custom_leaflet.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datatables.bootstrap4.5.min.css" rel="stylesheet">
    <!--Autocomplete UI -->
    <link href="css/plugins/jquery-ui.css" rel="stylesheet">
    <link href="css/plugins/ui_autocomplete.css" rel="stylesheet">
    <!--FONT AWESOME-->
    <link href="font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Datetime picker -->
    <link href="js/plugins/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" >
    <!--<link href="js/plugins/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker-standalone.css" rel="stylesheet" type="text/css" >-->
    
    
    <!-- Custom CSS -->
    <!--<link href="css/sb-admin.css" rel="stylesheet">-->
    <link href="css/c_home.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
</head>

<?php
session_start();
include 'php/properties.php';


if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
};
if (!isset($_SESSION['password'])) {
    header('Location: index.php');
    exit();
};
$menu_on = stripos($_SERVER['REQUEST_URI'], 'infos.php') ? "men_li_d" : "men_li";
?>

<body class="">
<div id="wrapper">
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion d-flex flex-column justify-content-center" id="accordionSidebar" style="z-index:10;">
        <div class="d-flex justify-content-center">
            <img class="img_bottom" src="img/pram.png" alt="PRAM Normandie"/>
        </div>
        <li class="nav-item mx-2 mt-4 mb-2">
            <a href="home.php" class="nav-link text-light">
                <i class="mx-2 fas fa-home"></i>Accueil
            </a>
        </li>
        <!--<li class="nav-item">
        <!--    <a class="nav-link collapsed text-light" href="#" data-toggle="collapse" data-target="#collapseSaisie" aria-expanded="false" aria-controls="collapseSaisie">
        <!--        <i class="mx-2 fas fa-edit"></i>Saisie
        <!--    </a>
        <!--    <div id="collapseSaisie" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
        <!--    <div class=" py-2 collapse-inner d-flex flex-column"  style="color:#004ea1;">
        <!--        <div class="d-flex"><div id="mare_loc_menu"     class="<?php //echo $menu_on; ?> btn btn-primary btn-sm m-2 justify-content-start" ><i class="fa fa-plus-circle"></i> Localisation</div></div>
        <!--        <div class="d-flex"><div id="mare_car_menu"     class="<?php //echo $menu_on; ?> btn btn-success btn-sm m-2" ><i class="fa fa-plus-circle"></i> Caractérisation</div></div>
        <!--        <div class="d-flex"><div id="mare_photo_menu"   class="<?php //echo $menu_on; ?> btn btn-yellowed btn-sm m-2" ><i class="fa fa-plus-circle"></i> Photo</div></div>
        <!--        <div class="d-flex"><div id="mare_delete_menu"  class="<?php //echo $menu_on; ?> btn btn-danger btn-sm m-2" ><i class="fa fa-minus-circle"></i> Mare</div></div>
        <!--        <div class="d-flex"><div id="mare_espece_menu"  class="<?php //echo $menu_on; ?> btn btn-purple btn-sm m-2" data-toggle="modal" data-target="#modalSpecies"><i class="fa fa-plus-circle"></i> Espèces</div></div>
        <!--        <div class="d-flex"><div id="mare_travaux_menu" class="<?php //echo $menu_on; ?> btn btn-pink btn-sm m-2" data-toggle="modal" data-target="#modalTravaux"><i class="fa fa-plus-circle"></i> Travaux</div></div>
        <!--    </div>
        <!--    </div>
        <!--</li>-->
        <li class="nav-item mx-2 my-2">
            <a class="nav-link collapsed text-light" href="#" data-toggle="collapse" data-target="#collapseExport" aria-expanded="false" aria-controls="collapseExport">
                <i class="mx-2 fas fa-file-export"></i>Export
            </a>
            <div id="collapseExport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                <div class="collapse-inner d-flex flex-column border border-secondary border-right-0 border-left-0 pl-2" style="">
                    <a id="export_mares_shapefile" class="m-2 small text-light <?php echo $menu_on; ?>"><i class="far fa-file-archive"></i> Shapefile</a>
                    <a id="export_mares_excel" class="m-2 small text-light <?php echo $menu_on; ?>"><i class="far fa-file-excel"></i> Excel</a>
                </div>
            </div>
        </li>
        <li class="nav-item mx-2 my-2">
            <a class="nav-link collapsed text-light" href="#" data-toggle="collapse" data-target="#collapseAnalyse" aria-expanded="false" aria-controls="collapseAnalyse">
                <i class="mx-2 fas fa-chart-bar"></i>Analyse
            </a>
            <div id="collapseAnalyse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                <div class="collapse-inner d-flex flex-column border border-secondary border-right-0 border-left-0 pl-2 "  style="">
                    <a id="define_semi" class="m-2 small text-light <?php echo $menu_on; ?>" >
                        <span><i class="fas fa-edit"></i>
                        Definir un semi</span>
                    </a>
                    <a id="analyse_semi" class="m-2 small text-light <?php echo $menu_on; ?>" >
                        <i class="fas fa-chart-bar"></i>
                        Analyse du semi
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item mx-2 my-2">
            <a class="nav-link collapsed text-light" href="#" data-toggle="collapse" data-target="#collapseMobile" aria-expanded="false" aria-controls="collapseMobile">
                <i class="mx-2 fas fa-mobile-alt"></i>Mes données terrain
            </a>
            <div id="collapseMobile" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
            <div class="collapse-inner d-flex flex-column border border-secondary border-right-0 border-left-0 pl-2"  style="">
                <a id="valid_android" class="m-2 small text-light <?php echo $menu_on; ?>" ><i class="fab fa-android"></i> Saisies avec ODK</a>
                <!--<a id="valid_android" class="m-2 small text-light <?php //echo $menu_on; ?>" ><i class="fab fa-android"></i> Saisies avec Géomare</a>-->
            </div>
            </div>
        </li>
        <li class="nav-item mx-2 my-2">
            <a href="infos.php" class="nav-link text-light">
                <i class="mx-2 fas fa-user"></i>Mes Informations
            </a>
        </li>
        <div class="d-flex mt-auto justify-content-center">
            <div class="d-flex w-100 justify-content-between mt-1 mb-2 ml-2 mr-2 " >
                    <img class="" style="max-width:40px;max-height:50px;opacity:0.8" src="img/logos/AESN.jpg" alt="AESN" data-toggle="tooltip" data-placement="top" title="AESN"/>
                    <img class="" style="max-width:40px;max-height:50px;opacity:0.8" src="img/logos/Region.jpg" alt="Région Normandie" data-toggle="tooltip" data-placement="top" title="Région Normandie"/>
                    <img class="" style="max-width:40px;max-height:50px;opacity:0.8" src="img/logos/FEADER.jpg" alt="FEADER" data-toggle="tooltip" data-placement="top" title="FEADER"/>
                    <img class="" style="max-width:40px;max-height:50px;opacity:0.8" src="img/logos/AELB.jpg" alt="AELB" data-toggle="tooltip" data-placement="top" title="AELB"/>
            </div>
        </div>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column w-100 bg-light" style="overflow-x: hidden;min-height:100vh;">
        <div class="d-flex static-top bg-dark  pt-2 pb-2 mb-0 pb-0 justify-content-end align-items-center font-weight-bold" >
            <div><span href="#" class=" mx-2 font-weight-bold" id="mail_user" style="color:#fff;opacity:0.8;"> <?php echo $_SESSION['email']; ?></span></div>
            <div style="color:#fff;opacity:0.8;"><a class="small mx-2 logout font-weight-bold" href="php/logout.php"  style="color:#fff;"><i class="fa fa-fw fa-power-off"></i> Déconnexion</a></div>
        </div>
        <div class="content d-flex h-100 flex-column" style="">
            <div class="d-flex w-100">
                <div class="d-flex flex-column flex-grow-1" ><!-- data-spy="affix" data-offset-top="60" -->
                    <div id="map" style="min-width:70%;height:600px;" ></div><!-- data-spy="affix" data-offset-top="60" -->
                    <div id="images_out" class="d-none" ></div>
                    <div class="d-flex flex-row flex-wrap align-content-end">
                        <div class="mx-2"><img style="max-width:16px;max-height:16px;padding-right:2px;" src="img\mare\vue.png" /><small>Vue</small></div>
                        <div class="mx-2"><img style="max-width:16px;max-height:16px;padding-right:2px;" src="img\mare\caracterisee.png" /><small>Caractérisée</small></div>
                        <div class="mx-2"><img style="max-width:16px;max-height:16px;padding-right:2px;" src="img\mare\potentielle.png" /><small>Potentielle</small></div>
                        <div class="mx-2"><img style="max-width:16px;max-height:16px;padding-right:2px;" src="img\mare\disparue.png" /><small>Disparue</small></div>
                        <!--<div class="mx-2"><input class="mr-1" type="checkbox" id="filter_myloc" checked></div>-->
                        <!--<div class="mx-2"><input class="mr-1" type="checkbox" id="filter_loc_tierce" checked><small>Localisations tierces</small><img style="max-width:16px;max-height:16px;" class="ml-1" src="img\mare\other.png" /></input></div>-->
                        <div class="mx-2 custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="filter_myloc" checked>
                            <label class="custom-control-label" for="filter_myloc"><small>Mes localisations</small><img style="max-width:16px;max-height:16px;" class="ml-1 mr-3" src="img\mare\mine.png" /></input></label>
                        </div>
                        <div class="mx-2 custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="filter_loc_tierce" checked>
                            <label class="custom-control-label" for="filter_loc_tierce"><small>Localisations tierces</small><img style="max-width:16px;max-height:16px;" class="ml-1 mr-3" src="img\mare\other.png" /></input></label>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column pl-2 pr-2" style="min-width:30%;">
                    <div id="loader" class="loader visible_s">
                        <img style="width:20px;height:20px;" src ="./img/spin.png" class="m-1 rotate_"/>Loading
                    </div>
                    <div class="form-group mt-2">
                        <label for="layers_autocomplete">Rechercher un découpage administratif :</label>
                        <input id="layers_autocomplete" class="form-control" placeholder="" onblur="" aria-describedby="layersHelp" >
                        <small id="layersHelp" class="form-text text-muted">Commune, EPCI ...</small>
                    </div>
                    <div class="form-group">
                        <label for="mares_autocomplete">Rechercher une mare :</label>
                        <input id="mares_autocomplete" class="form-control" placeholder="" onblur="" aria-describedby="maresHelp">
                        <small id="maresHelp" class="form-text text-muted">5 caractères minimum (ex: 8FW2X) </small>
                    </div>
                    <div class="d-flex  justify-content-start flex-column">
                        <div class="d-flex">
                            <div id="add_loc" class=" btn btn-primary mt-2" ><i class="fa fa-plus-circle"></i> Localisation de mare</div><!--data-toggle="modal" data-target="#modalLoc"> -->
                        </div>
                        <div class="d-flex">
                            <div id="add_car" class="btn btn-success mt-2" ><i class="fa fa-plus-circle"></i> Caractérisation de mare</div>
                        </div>
                        <div class="d-flex">
                            <div id="add_photo" class="btn btn-yellowed mt-2" ><i class="fa fa-plus-circle"></i> Photo</div>
                        </div>
                        <div class="d-flex">
                            <div id="delete_mare" class="btn btn-danger mt-2" ><i class="fa fa-minus-circle"></i> Mare</div>
                        </div>
                        <div class="d-flex">
                            <div id="add_spec" class="btn btn-purple mt-2" data-toggle="modal" data-target="#modalSpecies"><i class="fa fa-plus-circle"></i> Observation d'espèce</div>
                        </div>
                        <div class="d-flex">
                            <div id="add_w" class="btn btn-pink mt-2" data-toggle="modal" data-target="#modalTravaux"><i class="fa fa-plus-circle"></i> Travaux</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div><!-- content -->
        <div class="d-flex mt-auto justify-content-end align-items-center text-muted" >
            <kbd class="small">CEN Normandie © <?php echo date("Y"); ?></kbd>
        </div>
    </div><!-- /#content-wrapper -->



<!-- MODAL SPECIES -->
<div class="modal fade " id="ModalSpecies" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-full-height float-right modal-xl h-100 my-0" role="document">
    <div class="modal-content h-100 my-0 ">
      <div class="modal-header flex-column">
        <div class="d-flex w-100">
        <p class="modal-title text-muted" id="species_mare" style=""></p>
        <div class="ml-auto">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        </div>
      </div>
      <div class="modal-body w-100">
            <h4 class="font-weight-bold bg-secondary text-light ml-2 pl-2" style="">Nouvelles Observations :</h4><!--background-color:#773AC7;color:#fff;-->
            <div class="eventInsForm d-flex">
                <div class="d-flex flex-column w-25 mx-2 my-2">
                    <form id="formSpecies" class="">
                    <div class="d-flex flex-column">
                            <label class="sm">Espèce :
                                <input class="form-control form-control-sm" id="taxon_autocomplete" size="" placeholder="ex: Buffo | Rouge-gorge">
                                    <div id="loader_modal_esp" class="loader visible_s">
                                        <img style="width:20px;height:20px;" src ="./img/spin.png" class="m-1 rotate_"/>Recherche d'un taxon...
                                    </div>
                                </input>
                            </label>
                            <label>Date:
                            <input id="esp_date" class="form-control form-control-sm" placeholder="JJ-MM-AAAA" type="text"></input>
                            </label>
                            <label>Effectif :
                            <input class="form-control form-control-sm" type="number" min="0" id="esp_effectif" size="10" placeholder="Ex:2">
                            </label>
                            <label>Commentaires :
                            <input class="form-control form-control-sm" id="esp_comt" size="10" placeholder="Ex: blablabla">
                            </label>
                    </div>
                    </form>
                    <div class="d-flex justify-content-between mx-1 my-1">
                        <a id="add_row_esp" class="btn btn-purple "><strong>+</strong> esp</a>
                        <a id="delete_row_esp" class=" btn btn-purple " ><strong>-</strong> esp</a>
                    </div>
                </div>
                <div class="d-flex flex-column w-75 mx-2 my-2">
                    <div class="table-responsive" >
                        <table id="ola_dt" class="table table-bordered table-hover"><!-- dt-responsive-->
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        Espèce :
                                    </th>
                                    <th class="text-center">
                                        Date :
                                    </th>
                                    <th class="text-center">
                                        Effectif :
                                    </th>
                                    <th class="text-center">
                                        Obs :
                                    </th>
                                    <th class="text-center">
                                        Commentaire :
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex w-100 justify-content-end mb-2">
                <a href="" id="save_spec" class="btn btn-purple">Sauvegarder les observations</a>
            </div>
            <h4 class="font-weight-bold bg-secondary text-light ml-2 pl-2" style="">Observations Précédentes:</h4><!--background-color:#773AC7;color:#fff;-->
            <div class="d-flex justify-content-center">
                <div class="table-responsive" >
                    <table id="ola_dt__" class="table table-bordered table-hover"><!-- dt-responsive-->
                        <thead>
                            <tr>
                                <th class="text-center">
                                    Espèce :
                                </th>
                                <th class="text-center">
                                    Date :
                                </th>
                                <th class="text-center">
                                    Effectif :
                                </th>
                                <th class="text-center">
                                    Obs :
                                </th>
                                <th class="text-center">
                                    Commentaire :
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer ">
      </div>
    </div>
  </div>
</div>




<!-- MODAL -->
<div id="ModalTravaux" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
<!-- <form id="formTravaux d-flex"> -->
    <div class="modal-dialog modal-full-height float-right modal-xl h-100 my-0">
        <div class="modal-content h-100 my-0">
            <div class="modal-header d-flex">
                <h4 class="modal-title" id="Travaux_mare">Travaux</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body d-flex flex-column" >
                <h4 class="wc">Création d'une mare</h4>
                <div class="d-flex small justify-content-around">
                    <div class="wc_creation d-flex flex-column w-50 mx-2 my-2" >
                        <div class="form-group">
                            <label>Date de création:
                                <input id="wc_date" class="form-control form-control-sm" placeholder="JJ-MM-AAAA" type="text"></input>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Structure :
                                <input class="form-control form-control-sm" type="text" id="wc_str" placeholder="Ex:CEN">
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Commentaires :
                                <input class="form-control form-control-sm" id="wc_comt" size="10" placeholder="Ex: blablabla">
                            </label>
                        </div>
                    </div>
                    <div id="wc_obj" class="wc_creation d-flex flex-column w-50 mx-2 my-2" >
                        <label class="" >Objectif :
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Abreuvement"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Abreuvement">Abreuvement
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Collecte Ruisselement"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Collecte Ruisselement">Collecte Ruisselement
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Pêche"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Pêche">Pêche
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Chasse"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Chasse">Chasse
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Réserve incendie"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Réserve incendie">Réserve incendie
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Ornementale"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Ornementale">Ornementale
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Protection de la Biodiversité"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Protection de la Biodiversité">Protection de la Biodiversité
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Patrimoine culturel / Paysager"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Patrimoine culturel / Paysager">Patrimoine culturel / Paysager
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Pédagogique"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Pédagogique">Pédagogique
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Abandonné"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Abandonné">Abandonné
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Lagunage"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Lagunage">Lagunage
                                    </label>
                                </div>
                                <div class="form-group form-check mt-1 mb-0">
                                    <label class="form-check-label" >
                                        <input value="Inconnu"  type="checkbox" grp="wc_obj" class="form-check-input" descr="Inconnu">Inconnu
                                    </label>
                                </div>
                        </label>
                    </div>
                </div>
                <div class="d-flex w-100 justify-content-end mb-2">
                    <button type="button" id="wc_save" class="btn btn-blue_wc" data-dismiss="modal" aria-hidden="true">Enregistrer</button>
                </div>
                <h4 class="wa">Aménagement d'une mare</h4>
                <div class="d-flex small justify-content-around">
                    <div class="d-flex flex-column mr-1">
                        <div class="form-group">
                            <label class="form-label w-100" >Date d'aménagement:
                                <input id="wa_date" class="form-control form-control-sm" placeholder="JJ-MM-AAAA" type="text"></input>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100" >Structure :
                                <input class="form-control form-control-sm" type="text" id="wa_str" placeholder="Ex:CEN">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100" >Aménag. Hydraulique :
                                <select class="form-control form-control-sm" id="wa_hydrau" name="wa_hydrau" onchange="" tabindex="3">
                                    <option value="----">----</option>
                                    <option value="Surverse">Surverse</option>
                                    <option value="Débit de fuite">Débit de fuite</option>
                                    <option value="Débordement">Débordement</option>
                                    <option value="Indéterminé">Indéterminé</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex flex-column mr-1">
                        <div class="form-group">
                            <label class="form-label w-100" >Autre Aménag. hydraulique :
                            <input class="form-control form-control-sm" type="text" id="wa_hydrau_autre" placeholder="Ex:...">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Aménag. communication :
                                <select class="form-control form-control-sm" id="wa_com" name="wa_com" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Aménag. bande enherbée :
                                <select class="form-control form-control-sm" id="wa_enherb" name="wa_enherb" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex flex-column mr-1">
                        <div class="form-group">
                            <label class="form-label w-100">Aménag. de plantation :
                                <select class="form-control form-control-sm" id="wa_plant" name="wa_plant" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Aménag. de haie :
                                <select class="form-control form-control-sm" id="wa_haie" name="wa_haie" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Aménag. de clôture :
                                <select class="form-control form-control-sm" id="wa_clot" name="wa_clot" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex flex-column ">
                        <div class="form-group">
                            <label class="form-label w-100">Aménag. d'abreuvoir :
                                <select class="form-control form-control-sm" id="wa_abreuv" name="wa_abreuv" onchange="" tabindex="3">
                                    <option value="Exclos">Exclos</option>
                                    <option value="Pompe à museau">Pompe à museau</option>
                                    <option value="Non">Non</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Aménag. d'un patrimoine bâti :
                                <select class="form-control form-control-sm" id="wa_bati" name="wa_bati" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Commentaires :
                                <input class="form-control form-control-sm" id="wa_comt" size="10" placeholder="Ex: blablabla">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" id="wa_save" class="btn btn-green_wa mb-2" data-dismiss="modal" aria-hidden="true">Enregistrer</button>
                </div>
                <h4 class="wr">Restauration d'une mare</h4>
                <div class="d-flex small justify-content-around">
                    <div class="d-flex flex-column mr-1">
                        <div class="form-group">
                            <label class="form-label w-100">Date de restauration :
                                <input id="wr_date" class="form-control form-control-sm" placeholder="JJ-MM-AAAA" type="text"></input>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Structure :
                                <input class="form-control form-control-sm" type="text" id="wr_str" placeholder="Ex:CEN">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Curage :
                                <select class="form-control form-control-sm" id="wr_cur" name="wr_cur" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui, 1/3">Oui, 1/3</option>
                                    <option value="Oui, 1/2">Oui, 1/2</option>
                                    <option value="Oui, 2/3">Oui, 2/3</option>
                                    <option value="Oui, total">Oui, total</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Reprofilage :
                                <select class="form-control form-control-sm" id="wr_repro" name="wr_repro" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui, 1/3">Oui, 1/3</option>
                                    <option value="Oui, 1/2">Oui, 1/2</option>
                                    <option value="Oui, 2/3">Oui, 2/3</option>
                                    <option value="Oui, total">Oui, total</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex flex-column mr-1">
                        <div class="form-group">
                            <label class="form-label w-100">Étanchéification :
                                <select class="form-control form-control-sm" id="wr_etanc" name="wr_etanc" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Nature d'étanchéification:
                                <input class="form-control form-control-sm" type="text" id="wr_etanc_nature" placeholder="Ex:Argile, Bâche, Bentonite, Autre">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Abattage :
                                <select class="form-control form-control-sm" id="wr_abat" name="wr_abat" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui, 1/3">Oui, 1/3</option>
                                    <option value="Oui, 1/2">Oui, 1/2</option>
                                    <option value="Oui, 2/3">Oui, 2/3</option>
                                    <option value="Oui, total">Oui, total (sur tout le pourtour)</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Nb de dessouchage :
                                <input class="form-control form-control-sm" type="number" min="0" id="wr_dessouch_nb" size="10" placeholder="Ex:2">
                            </label>
                        </div>
                    </div>
                    <div class="d-flex flex-column mr-1">
                        <div class="form-group">
                            <label class="form-label w-100">Nb d'élaguage :
                                <input class="form-control form-control-sm" type="number" min="0" id="wr_elag_nb" size="10" placeholder="Ex:2">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Surface débroussaillée :
                                <input class="form-control form-control-sm" type="number" min="0" id="wr_debrou_surf" size="10" placeholder="Ex:2">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Évacuation des déchets :
                                <select class="form-control form-control-sm" id="wr_depol" name="wr_depol" onchange="" tabindex="3">
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label w-100">Commentaires :
                                <input class="form-control form-control-sm" id="wr_comt" size="10" placeholder="Ex: blablabla">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 eventInsMod">
                        <form class="" action="#" method="post">
                        <div class="d-flex w-100 flex-column bg-light">
                            <div class="d-flex flex-column justify-content-center">
                                <label class="form-label font-weight-bold small">Introduction d'Espèce :
                                    <input class="form-control form-control-sm" id="wr_taxon_autocomplete" size="" placeholder="ex: Buffo | Rouge-gorge">
                                        <div id="loader_modal_travaux" class="loader visible_s">
                                            <img style="width:20px;height:20px;" src ="./img/spin.png" class="m-1 rotate_"/>Recherche d'un taxon...
                                        </div>
                                    </input>
                                </label>
                                <div class="d-flex justify-content-around">
                                    <a id="add_row_eisp" class="btn btn-default spacer "><strong>+</strong> esp</a>
                                    <a id="delete_row_eisp" class=" btn btn-default pull-right spacer " ><strong>-</strong> esp</a>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <div class="table-responsive" >
                                    <table id="wr_esp_dt" class="table table-bordered table-hover"><!-- dt-responsive-->
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th class="text-center">
                                                    Espèce :
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" id="wr_save" class="btn btn-yellow_wr" data-dismiss="modal" aria-hidden="true">Enregistrer</button>
                </div>
            </div>
            <!-- END MODAL BODY -->
            <div class="modal-footer ">
            </div>
        </div>
    </div>
<!-- </form> -->
</div>
<!-- MODAL DELETE -->
<!-- MODAL DELETE -->
<div class="modal fade " id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog float-right modal-md h-100 my-0" role="document">
    <form id="formDelete" class="d-flex h-100">
    <div class="modal-content h-100 my-0">
      <div class="modal-header flex-column">
        <div class="d-flex w-100">
        <h5 class="modal-title" id="exampleModalLabel">Suppression de la mare</h5>
        <div class="ml-auto">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        </div>
        <div class="d-flex">
            <p id="delete_mare_id" class="text-danger"></p>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex mt-4">
            <div class="form-group">
            </div>
        </div>
      </div>
      <div class="modal-footer ">
        <div class="d-flex justify-content-around">
            <button id="delete_mare_ended" type="submit" class="btn btn-danger">Supprimer la mare</button>
        </div>
      </div>
    </div>
    </form>
  </div>
</div>


<!-- MODAL PHOTO -->
<!-- MODAL PHOTO -->
<div class="modal fade " id="modalPhoto" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog float-right modal-md h-100 my-0" role="document">
    <div class="modal-content h-100 my-0">
      <div class="modal-header flex-column">
        <div class="d-flex w-100">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter une photo</h5>
        <div class="ml-auto">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        </div>
        <div class="d-flex">
            <p class="text-muted small" id="add_photo_id_form" ></p>
        </div>
      </div>
      <div class="modal-body">
      <form id="formPhoto">
        <div class="custom-file mt-4 w-100">
            <input type="file" class="custom-file-input" id="photo">
            <label class="custom-file-label" for="photo" data-browse="Parcourir">Photo</label>
        </div>
        <div class="custom-file mt-4 w-100">
            <input type="file" class="custom-file-input" id="schema">
            <label class="custom-file-label" for="schema" data-browse="Parcourir">Schéma</label>
        </div>
      </form>
      </div>
      <div class="modal-footer ">
        <div class="d-flex w-100 justify-content-around">
        <div class=""><button id="save_photo" type="submit" class="btn btn-warning text-white">Enregistrer la photo</button></div>
        <div class="mb-2"><button id="save_schema" type="submit" class="btn btn-warning text-white">Enregistrer le schema</button></div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- MODAL PHOTO CONTENT-->
<!-- MODAL PHOTO CONTENT-->
<div class="modal fade " id="modalPhotoContent" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-md mw-100 w-50" role="document">
    <div class="modal-content h-100 my-0">
      <div class="modal-header flex-column">
        <div class="d-flex w-100">
        <h5 class="modal-title" id="">Photo de la mare :</h5>
        <div class="ml-auto">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        </div>
      </div>
      <div class="modal-body px-0 py-0">
        <div class="d-flex flex-wrap w-100" id="photoz">
        </div>
      </div>
      <div class="modal-footer ">
      </div>
    </div>
  </div>
</div>

<!-- MODAL ODK-->
<!-- MODAL ODK-->
<div class="modal fade " id="modalOdk" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg float-right h-100 my-0" role="document">
    <div class="modal-content h-100 my-0">
      <div class="modal-header flex-column w-100">
            <div class="d-flex w-100">
                <h5 class="modal-title" id="">Formulaires ODK en attente :</h5>
                <div class="ml-auto"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="d-flex">
                <small class="text-muted">Importer vos mares caracterisée sur ODK</small>
            </div>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column w-100" id="odkz">
        </div>
      </div>
      <div class="modal-footer ">
        <div class="d-flex flex-column">
        </div>
      </div>
    </div>
  </div>
</div>


<!-- MODAL LOCALISATION -->
<!-- MODAL LOCALISATION -->
<div class="modal fade " id="modalLoc" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-md float-right h-100 my-0" role="document">
    <div class="modal-content h-100 my-0">
      <div class="modal-header flex-column w-100">
            <div class="d-flex w-100">
                <h5 class="modal-title" id="">Localisation</h5>
                <div class="ml-auto"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="d-flex">
                <small class="text-muted">Cliquez sur la carte pour localiser la mare</small>
            </div>
        
      </div>
      <div class="modal-body">
        <form id="formLoc" >
        <div class="d-flex">
            <div class="form-group mx-2">
            <label for="loc_x" >X :</label>
            <input id="loc_x" class="form-control" type="text">
            </div>
            <div class="form-group mx-2">
            <label for="loc_y" >Y :</label>
            <input id="loc_y" class="form-control" type="text">
            </div>
        </div>
        <div class="d-flex">
            <div class="form-group mx-2">
            <label for="loc_date">Date :</label>
            <input id="loc_date" class="form-control" placeholder="JJ-MM-AAAA" type="text">
            </div>
            <div class="form-group mx-2">
            <label for="loc_nom">Nom de la mare :</label>
            <input id="loc_nom" class="form-control" placeholder="Mare Anguerny" type="text">
            </div>
        </div>
        <div class="d-flex">
            <div class="form-group mx-2">
            <label for="loc_statut">Statut </label>
            <select id="loc_statut" class="form-control" required>
                <option>Vue</option>
                <option>Potentielle</option>
                <option>Disparue</option>
                <option>Caractérisée</option>
            </select>
            </div>
            <div class="form-group mx-2">
            <label for="loc_type_propriete">Type de propriété :</label>
            <select id="loc_type_propriete" class="form-control" required>
                <option>Public</option>
                <option>Privé</option>
                <option>Mixte</option>
                <option>Inconnu</option>
            </select>
            </div>
        </div>
        <div class="d-flex">
            <div class="form-group mx-2">
            <label for="loc_comment" >Commentaires</label>
            <textarea id="loc_comment" class="form-control" rows="2" ></textarea>
            </div>
        </div>
      </div>
      </form>
      
      <div class="modal-footer ">
        <div class="d-flex flex-column">
        <div class="mb-2 small"><span id="text_update" class="text-success"> --> nouvelle localisation</span></div>
        <div class=""><button id="save_loc" class="btn btn-primary">+ Enregistrer la nouvelle localisation</button></div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- MODAL DEFINE ANALYSE -->
<!-- MODAL DEFINE ANALYSE -->
<!-- FORM DEFINIR SEMI -->
<div class="modal fade " id="modalDefineSemi" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-md float-right h-100 my-0" role="document">
    <div class="modal-content h-100 my-0">
      <div class="modal-header flex-column w-100">
            <div class="d-flex w-100">
                <h5 class="modal-title" id="">Definir un semi :</h5>
                <div class="ml-auto"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="d-flex">
                <small class="text-muted">Afin de définir géographiquement le semi de mares vous pouvez sélectionnez des entités administratives en cliquant dessus, dessinez vos propres zones ou bien combinez les 2. Une fois que le tableau récapitulatif contient au moins une entité vous pouvez lancer une analyse.</small>
            </div>
        
      </div>
      <form id="formDefineAnalyse" >
      <div class="modal-body h-100">
        <div class="d-flex flex-column">
            <div class="form-group mx-2 my-2">
                <label for="liste_layer_reference">Choisir un contour de référence :</label>
                <select class="form-control form-control-sm" id="liste_layer_reference">
                    <option id="f_0" table_name=" null " >----</option>
                    <option id="f_1" table_name="<?php echo $communes; ?>" >Commune</option>
                    <option id="f_2" table_name="<?php echo $epci; ?>" >EPCI</option>
                </select>
                <div id="loader_layers" class="loader visible_s">
                    <img style="width:20px;height:20px;" src ="./img/spin.png" class="m-1 rotate_"/>Chargement du fond cartographique...
                </div>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="form-group mx-2 justify-content-around">
                <label>Ou dessiner une zone spécifique</label>
                <div id="drawundraw" type="submit" class="btn btn-orange"> + Dessiner une zone</div>
            </div>
            <div id="send_drawn_items" class=" d-none">
                <div class="form-group mx-2 justify-content-around">
                    <label for="specific_name small" style="color: #E489C4;font-weigth:600;">Nommez votre Zone Spécifique :
                        <input id="specific_name" class="form-control form-control-sm" placeholder="" onblur="" >
                    </label>
                    <div  id="savedrawnitems" class="btn btn-pink" ><i class="fas fa-save mr-1"></i> Enregistrer la zone</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column">
            <p class="small">Tableau récapitulatif :</p>
            <table id="composition_dt" class="table table-striped table-hover"><!-- dt-responsive-->
                <thead>
                    <tr>
                        <th>Nom de l'entité</th>
                        <th>ID</th>
                        <th>X</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer ">
        <div class="d-flex w-100 justify-content-around">
            <div><input id="name_save_semi" class="form-control" ></div>
            <div><button id="save_semi" type="submit" class="btn btn-primary">Enregistrer le semi</button></div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- FORM DEFINIR SEMI -->


<!-- MODAL ANALYSE ANALYSE -->
<!-- MODAL ANALYSE ANALYSE -->
<!-- FORM ANALYSE SEMI -->
<div class="modal fade " id="modalAnalyse" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-md float-right h-100 my-0" role="document">
    <div class="modal-content h-100 my-0">
      <div class="modal-header flex-column w-100">
            <div class="d-flex w-100">
                <h5 class="modal-title" id="">Analyser un semi :</h5>
                <div class="ml-auto"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="d-flex">
                <small class="text-muted">Si aucun élément n'est présent dans la liste, il faut préalablement définir un semi</small>
            </div>
      </div>
      <form id="formDefineAnalyse" >
      <div class="modal-body h-100">
        <div class="d-flex flex-column">
            <div class="form-group mx-2 my-2">
                <p>Choisir un semi :</p>
                <select class="form-control" id="liste_semi_analyses">
                </select>
                <div id="loader_layers" class="loader visible_s">
                    <img style="width:20px;height:20px;" src ="./img/spin.png" class="m-1 rotate_"/>Chargement du fond cartographique...
                </div>
            </div>
            <div class="d-flex flex-column mx-2 my-2">
                <div class="form-group">
                    <p>Nommez votre Analyse :</p>
                    <input id="nom_analyse" class="form-control" placeholder="" onblur="" >
                </div>
                <div class="d-flex justify-content-end">
                    <button id="run_analyse" type="submit" class="btn btn-primary">Lancer l'analyse</button>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column mt-4">
            <div class="form-group mx-2 my-2">
                <p class="">Ou recharger une ancienne analyse :</p>
                <select class="form-control" id="liste_old_analyses">
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer ">
        <div class="d-flex w-100 justify-content-around">
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- FORM ANALYSE SEMI -->

<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- MODAL CARACTERISATION -->
<!-- MODAL CARACTERISATION -->
<!-- MODAL CARACTERISATION -->

<div id="modalCar" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog float-right modal-xl h-100 my-0">
        <div class="modal-content h-100 my-0">
            <div class="modal-header d-flex flex-column">
                <div class="d-flex w-100">
                    <div><h5 class="" id="">Caractérisation / Description</h5></div>
                    <div class="ml-auto"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
                <div class="d-flex w-100 justify-content-between">
                    <!--<div></div>-->
                    <form>
                    <div><span id="add_car_id_form" class="text-primary small ml-2"></span></div>
                    <div><span id="car_id_update" class="text-success small ml-2"></span></div>
                    </form>
                </div>
            </div>
            <div class="modal-body d-flex" >
            <form id="formCar" class="d-flex">
                <div class=" d-flex position-sticky sticky-top" data-spy="affix">
                    <ul class="list-group ml-0 mr-0 pl-1 pr-1 ">
                        <li class="list-group-item"><a href="#A">A</a></li>
                        <li class="list-group-item"><a href="#B">B</a></li>
                        <li class="list-group-item"><a href="#C">C</a></li>
                        <li class="list-group-item"><a href="#D">D</a></li>
                        <li class="list-group-item"><a href="#E">E</a></li>
                        <li class="list-group-item"><a href="#F">F</a></li>
                        <li class="list-group-item"><a href="#G">G</a></li>
                        <li class="list-group-item"><a href="#H">H</a></li>
                    </ul>
                </div>
                <div class="d-flex ml-2 w-100"><!-- BEGIN FLEX COLUMN MAIN-->
                    <div class="d-flex flex-column w-100" >
                        <h4 id="A" class="font-weight-bold bg-secondary text-light ml-2 pl-2">A. Données générales :</h4><span class="text-muted ml-2 mb-2 small font-italic">Ces champs sont obligatoires pour enregistrer votre description</span>
                        <div class="d-flex justify-content-start flex-wrap small">
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="car_date" class="font-weight-bold">Date de caractérisation* :</label>
                                    <input id="car_date" class="form-control form-control-sm" placeholder="JJ-MM-AAAA" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="car_type" class="font-weight-bold">Type de mare* :</label>
                                    <select id="car_type" class="custom-select custom-select-sm" placeholder="----"required>
                                        <option>----</option>
                                        <option>Prairie</option>
                                        <option>Culture</option>
                                        <option>Forêt</option>
                                        <option>Friche</option>
                                        <option>Marais</option>
                                        <option>Carrière</option>
                                        <option>Bassin routier / decantation</option>
                                        <option>Village, jardin, ferme</option>
                                        <option>Indeterminé</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="car_veget" class="font-weight-bold">Végétation aquatique* :</label>
                                    <select id="car_veget" class="custom-select custom-select-sm" placeholder="----" required>
                                        <option>Oui</option>
                                        <option>Non</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <label class="font-weight-bold">Groupes Faunistiques observés* :</label>
                                <form required>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="Amphibiens (grenouilles, crapauds, tritons, salamandres)"  name="grp_faune" descr="Amphibiens (grenouilles, crapauds, tritons, salamandres)" type="checkbox" class="form-check-input" >Amphibiens (grenouilles, crapauds, tritons, salamandres)
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Reptiles (serpents, tortues, lézards)"  name="grp_faune" descr="Reptiles (serpents, tortues, lézards)" type="checkbox" class="form-check-input" >Reptiles (serpents, tortues, lézards)
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Libellules (larves, adultes ou exuvies)"  name="grp_faune" descr="Libellules (larves, adultes ou exuvies)" type="checkbox" class="form-check-input" >Libellules (larves, adultes ou exuvies)
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Invertébrés aquatiques"  name="grp_faune" descr="Invertébrés aquatiques" type="checkbox" class="form-check-input" >Invertébrés aquatiques
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Poissons"  name="grp_faune" descr="Poissons" type="checkbox" class="form-check-input" >Poissons
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Canards, oies, cygnes"  name="grp_faune" descr="Canards, oies, cygnes" type="checkbox" class="form-check-input" >Canards, oies, cygnes
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input  id="grp_faune_cx" value="Autre" name="grp_faune" descr="Autre" type="checkbox" class="form-check-input" >Autre
                                        </label>
                                        <input id="grp_faune_autre" class="form-control form-control-sm d-none" placeholder="Méduses..." type="text" >
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input  value="Aucun" name="grp_faune" descr="Aucun" type="checkbox" class="form-check-input" >Aucun
                                        </label>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group  ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <label class="font-weight-bold" >Stade d'évolution* :</label>
                                <form class="mt-1 mb-1" required>
                                    <div class="form-group form-radio mt-1 mb-0">
                                        <input id="Stade1" value="Stade 1" name="stade" type="radio" class="form-radio-input" unchecked><img class="ml-1" src="img/evolution/stade1_.png" style="height:40px;">
                                        <label for="Stade1" class="form-radio-label">Stade 1</label>
                                    </div>
                                    <div class="form-group form-radio mt-1 mb-0">
                                        <input id="Stade2" value="Stade 2" name="stade" type="radio" class="form-radio-input" unchecked><img class="ml-1" src="img/evolution/stade2_.png" style="height:40px;">
                                        <label for="Stade2" class="form-radio-label">Stade 2</label>
                                    </div>
                                    <div class="form-group form-radio mt-1 mb-0">
                                        <input id="Stade3" value="Stade 3" name="stade" type="radio" class="form-radio-input" unchecked><img class="ml-1" src="img/evolution/stade3_.png" style="height:40px;">
                                        <label for="Stade3" class="form-radio-label">Stade 3</label>
                                    </div>
                                    <div class="form-group form-radio mt-1 mb-0">
                                        <input id="Stade4" value="Stade 4" name="stade" type="radio" class="form-radio-input" unchecked><img class="ml-1" src="img/evolution/stade4_.png" style="height:40px;">
                                        <label for="Stade4" class="form-radio-label">Stade 4</label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--END A ####################################### -->
                        <!--END A ####################################### -->
                        
                        <h4 id="B" class="font-weight-bold bg-secondary text-light ml-2 pl-2">B. Usages :</h4>
                        <div class="d-flex justify-content-start flex-wrap small">
                            <div class="form-group ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <label class="font-weight-bold">Usage principal :</label>
                                <form class=" mt-1 mb-1" >
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="Abreuvoir aménagé" name="car_usages" type="checkbox" class="form-check-input" >Abreuvoir aménagé
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Abreuvoir non-aménagé" name="car_usages" type="checkbox" class="form-check-input" >Abreuvoir non-aménagé
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Collecte ruissellement" name="car_usages" type="checkbox" class="form-check-input" >Collecte ruissellement
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Pêche" name="car_usages" type="checkbox" class="form-check-input" >Pêche
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Chasse" name="car_usages" type="checkbox" class="form-check-input" >Chasse
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Réserve incendie" name="car_usages" type="checkbox" class="form-check-input" >Réserve incendie
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="Ornemental" name="car_usages" type="checkbox" class="form-check-input" >Ornemental
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Protection de la Biodiversité" name="car_usages" type="checkbox" class="form-check-input" >Protection de la Biodiversité
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Patrimoine culturel / Paysager" name="car_usages" type="checkbox" class="form-check-input" >Patrimoine culturel / Paysager
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Pédagogique" name="car_usages" type="checkbox" class="form-check-input" >Pédagogique
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Abandonné" name="car_usages" type="checkbox" class="form-check-input" >Abandonné
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Lagunage" name="car_usages" type="checkbox" class="form-check-input" >Lagunage
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Inconnu" name="car_usages" name="" type="checkbox" class="form-check-input" >Inconnu
                                        </label>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group">
                                <label for="car_pompe" class="font-weight-bold">Présence de pompe à nez :</label>
                                <select id="car_pompe" class="custom-select custom-select-sm" placeholder="----" >
                                    <option>Non</option>
                                    <option>Oui</option>
                                </select>
                            </div>
                            <div class="form-group ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <label class="font-weight-bold">Usage principal :</label>
                                <form id="car_dechets mt-1 mb-1" >
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="Aucun" name="car_dechets" type="checkbox" class="form-check-input" >Aucun
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Déchets verts" name="car_dechets" type="checkbox" class="form-check-input" >Déchets verts
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Ordures ménagères" name="car_dechets" type="checkbox" class="form-check-input" >Ordures ménagères
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Déchets recyclables" name="car_dechets" type="checkbox" class="form-check-input" >Déchets recyclables
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Déchets dangereux" name="car_dechets" type="checkbox" class="form-check-input" >Déchets dangereux
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Déchets inertes" name="car_dechets" type="checkbox" class="form-check-input" >Déchets inertes
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="Meubles" name="car_dechets" type="checkbox" class="form-check-input" >Meubles
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Electroménager" name="car_dechets" type="checkbox" class="form-check-input" >Electroménager
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--END B ####################################### -->
                        <!--END B ####################################### -->
                        
                        <h4 id="C" class="font-weight-bold bg-secondary text-light ml-2 pl-2">C. Situation de la mare :</h4>
                        <div class="d-flex justify-content-start flex-wrap small">
                        
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="car_topo" class="font-weight-bold">Topographie :</label>
                                    <select id="car_topo" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Plateau</option>
                                        <option>Versant</option>
                                        <option>Fond de vallée</option>
                                        <option>Autre</option>
                                    </select>
                                    <input id="car_topo_autre" class="form-control form-control-sm d-none" placeholder="..." type="text" >
                                </div>
                                <div class="form-group">
                                    <label for="car_cloture" class="font-weight-bold">Mare clôturée :</label>
                                    <select id="car_cloture" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Non</option>
                                        <option>En partie</option>
                                        <option>Totalement</option>
                                    </select>
                                </div>
                                <div class="form-group"> 
                                    <label for="car_haie" class="font-weight-bold">Présence d'une haie :</label>
                                    <select id="car_haie" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>Non</option>
                                        <option>Oui</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <label class="font-weight-bold">Contexte de la mare :</label>
                                <form id="car_contextes" >
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="marais continental salé ou saumâtre" name="car_contextes" type="checkbox" class="form-check-input" >Marais continental salé ou saumâtre
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="pelouse sècheDéchets verts" name="car_contextes" type="checkbox" class="form-check-input" >Pelouse sècheDéchets verts
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="prairie mésophile" name="car_contextes" type="checkbox" class="form-check-input" >Prairie mésophile
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="prairie humide" name="car_contextes" type="checkbox" class="form-check-input" >Prairie humide
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="fourrés, bosquets" name="car_contextes" type="checkbox" class="form-check-input" >Fourrés, bosquets
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="lande humide" name="car_contextes" type="checkbox" class="form-check-input" >Lande humide
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="lande sèche" name="car_contextes" type="checkbox" class="form-check-input" >Lande sèche
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="bois de feuillus" name="car_contextes" type="checkbox" class="form-check-input" >Bois de feuillus
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="bois de résineux" name="car_contextes" type="checkbox" class="form-check-input" >Bois de résineux
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="culture" name="car_contextes" type="checkbox" class="form-check-input" >Culture
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="jardin, parc, cour (de ferme)" name="car_contextes" type="checkbox" class="form-check-input" >Jardin, parc, cour (de ferme)
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="carrière" name="car_contextes" type="checkbox" class="form-check-input" >Carrière
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="annexe routière / ferrovière" name="car_contextes" type="checkbox" class="form-check-input" >Annexe routière / ferrovière
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="indéterminé" name="car_contextes" type="checkbox" class="form-check-input" >Indéterminé
                                        </label>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <label class="font-weight-bold">Petit patrimoine associé :</label>
                                <form  >
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="Aucun" name="car_patrimoine" type="checkbox" class="form-check-input" >Aucun
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Fond empierré"  name="car_patrimoine" type="checkbox" class="form-check-input" >Fond empierré
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Muret" name="car_patrimoine" type="checkbox" class="form-check-input" >Muret
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Ponton" name="car_patrimoine" type="checkbox" class="form-check-input" >Ponton
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Enrochement" name="car_patrimoine" type="checkbox" class="form-check-input" >Enrochement
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="Autre"  id="car_patrimoine" name="car_patrimoine" type="checkbox" class="form-check-input" >Autre
                                        </label>
                                    </div>
                                    <input id="car_patrimoine_autre" class="form-control form-control-sm d-none" placeholder="..." type="text" >
                                </form>
                            </div>
                        </div>
                        <!--END C ####################################### -->
                        <!--END C ####################################### -->
                        
                        <h4 id="D" class="font-weight-bold bg-secondary text-light ml-2 pl-2">D. Caractéristique abiotique de la mare :</h4>
                        <div class="d-flex justify-content-start flex-wrap small">
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="car_forme" class="font-weight-bold">Forme de la mare :</label>
                                    <select id="car_forme" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Ronde / ovale</option>
                                        <option>Triangle</option>
                                        <option>Carré / rectangle</option>
                                        <option>Patatoïde</option>
                                        <option>Complexe (en u )</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Longueur (m) :</label>
                                    <input id="car_long" class="form-control form-control-sm" placeholder="0" onblur="" value="0" type="number">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Largeur (m) :</label>
                                    <input id="car_larg" class="form-control form-control-sm" placeholder="0" onblur="" value="0" type="number">
                                </div>
                            </div>
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="car_hauteur" class="font-weight-bold">Hauteur Max observée :</label>
                                    <select id="car_hauteur" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>0</option>
                                        <option>30-60 cm</option>
                                        <option>60-100 cm</option>
                                        <option>> 100 cm</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="car_fond" class="font-weight-bold">Nature du fond :</label>
                                    <select id="car_fond" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Matériau naturel</option>
                                        <option>Béton</option>
                                        <option>Bâche</option>
                                        <option>Autre</option>
                                        <option>Indéterminé</option>
                                    </select>
                                    <input id="car_fond_autre" class="form-control form-control-sm d-none" placeholder="..." onblur="" value="" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="car_berges" class="font-weight-bold">Berges en pente douces :</label>
                                    <select id="car_berges" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>0-25%</option>
                                        <option>25-50%</option>
                                        <option>50-75%</option>
                                        <option>75-100%</option>
                                        <option>100%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="car_bourrelet_cx" class="font-weight-bold">Bourrelet de curage :</label>
                                    <select id="car_bourrelet_cx" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>Non</option>
                                        <option>Oui</option>
                                    </select>
                                    <input id="car_bourrelet_prct" class="form-control form-control-sm d-none" placeholder="..." type="text" >
                                </div>
                                <div class="form-group">
                                    <label for="car_surpietinement" class="font-weight-bold">Surpiétinement des abords :</label>
                                    <select id="car_surpietinement" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Intense et total</option>
                                        <option>Localisé</option>
                                        <option>Faible à nul</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--END D ####################################### -->
                        <!--END D ####################################### -->
                        
                        <h4 id="E" class="font-weight-bold bg-secondary text-light ml-2 pl-2">E. Hydrologie :</h4>
                        <div class="d-flex justify-content-start flex-wrap small">
                        
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="car_hydrologie" class="font-weight-bold">Régime hydrologique :</label>
                                    <select id="car_hydrologie" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Mare permanente</option>
                                        <option>Mare temporaire</option>
                                        <option>Indéterminé</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <label class="font-weight-bold">Liaison(s) réseau hydro. superficiel :</label>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="aucune" name="car_liaisons" type="checkbox" class="form-check-input" >Aucune
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="fossés, noues" name="car_liaisons" type="checkbox" class="form-check-input" >Fossés, noues
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="drainage/pompage" name="car_liaisons" type="checkbox" class="form-check-input" >Drainage/pompage
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="cours d'eau" name="car_liaisons" type="checkbox" class="form-check-input" >Cours d'eau
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="axe de ruisselement" name="car_liaisons" type="checkbox" class="form-check-input" >Axe de ruisselement
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="autre" name="car_liaisons" id="car_liaisons_cx" type="checkbox" class="form-check-input" >Autre
                                        </label>
                                        <input id="car_liaisons_autre" class="form-control form-control-sm d-none" placeholder="..." type="text" >
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="indéterminé" name="car_liaisons" type="checkbox" class="form-check-input" >Indéterminé
                                        </label>
                                    </div>
                            </div>
                            <div class="form-group ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <label class="font-weight-bold">Alimentation(s) spécifique(s) :</label>
                                <form >
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label" >
                                            <input value="aucune" name="car_alimentations" type="checkbox" class="form-check-input" >Aucune
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="ruisselement voirie" name="car_alimentations" type="checkbox" class="form-check-input" >Ruisselement voirie
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="ruisselement culture" name="car_alimentations" type="checkbox" class="form-check-input" >Ruisselement culture
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="source" name="car_alimentations" type="checkbox" class="form-check-input" >Source
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="nappe" name="car_alimentations" type="checkbox" class="form-check-input" >Nappe
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="pluvial bâti" name="car_alimentations" type="checkbox" class="form-check-input" >Pluvial bâti
                                        </label>
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="autre" name="car_alimentations" id="car_alimentations_cx" type="checkbox" class="form-check-input" >Autre
                                        </label>
                                        <input id="car_alimentations_autre" class="form-control form-control-sm d-none" placeholder="..." type="text" >
                                    </div>
                                    <div class="form-group form-check mt-1 mb-0">
                                        <label class="form-check-label">
                                            <input value="indéterminé" name="car_alimentations" type="checkbox" class="form-check-input" >Indéterminé
                                        </label>
                                    </div>
                                    
                                </form>
                            </div>
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="car_turbidite" class="font-weight-bold">Turbidité de l'eau :</label>
                                    <select id="car_turbidite" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Limpide</option>
                                        <option>Trouble</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="car_couleur" class="font-weight-bold">Couleur spécifique de l'eau :</label>
                                    <select id="car_couleur" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Oui</option>
                                        <option>Non</option>
                                    </select>
                                    <input id="car_couleur_autre" class="form-control form-control-sm d-none" placeholder="..." type="text" >
                                </div>
                                <div class="form-group">
                                    <label for="car_tampon" class="font-weight-bold">Zone tampon :</label>
                                    <select id="car_tampon" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Oui</option>
                                        <option>Non</option>
                                        <option>Indeterminé</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="car_exutoire" class="font-weight-bold">Présence d'éxutoire :</label>
                                    <select id="car_exutoire" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>Surverse</option>
                                        <option>Débit de fuite</option>
                                        <option>Débordement</option>
                                        <option>Indéterminé</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--END E ####################################### -->
                        <!--END E ####################################### -->
                        
                        
                        <h4 id="F" class="font-weight-bold bg-secondary text-light ml-2 pl-2">E. Ecologie :</h4>
                        <div class="d-flex justify-content-start flex-wrap small">
                            <div class="d-flex flex-column ml-2 bg-light">
                                <div class="form-group">
                                    <label class="font-weight-bold">Recouvrement :</label>
                                    <p class="small">en pourcentage de recouvrement :</p>
                                    <div class="col-sm-12">
                                        <p id="rec_total">0%</p>
                                        <table class="table">
                                        <thead>
                                        </thead>
                                        <tbody class="small">
                                            <tr>
                                            <td style="width:15%"><input style="width:30px" class="form-control form-control-sm" id="c_recou_helophyte" value="0" onchange="" type="text"></td>
                                            <td style="width:2%">+</td>
                                            <td style="width:39%"><input style="width:30px" class="form-control form-control-sm" id="c_recou_hydrophyte_e" value="0" onchange="maj_total_recouvrement()" type="text"></td>
                                            <td style="width:2%">+</td>
                                            <td style="width:8%"><input style="width:30px" class="form-control form-control-sm" id="c_recou_hydrophyte_ne" value="0" onchange="maj_total_recouvrement()" type="text"></td>
                                            <td style="width:2%">+</td>
                                            <td style="width:8%"><input style="width:30px" class="form-control form-control-sm" id="c_recou_algue" value="0" onchange="maj_total_recouvrement()" type="text"></td>
                                            <td style="width:2%">+</td>
                                            <td style="width:8%"><input style="width:30px" class="form-control form-control-sm" id="c_recou_eau_libre" value="0" onchange="maj_total_recouvrement()" type="text"></td>
                                            <td style="width:2%">+</td>
                                            <td style="width:11%"><input style="width:30px" class="form-control form-control-sm" id="c_recou_non_veget" value="0" onchange="maj_total_recouvrement()" type="text"></td>
                                            </tr>
                                            <tr align="center">
                                                <td colspan="11"><img src="img/recouvrement.png"></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="car_embroussaillement" class="font-weight-bold">Embroussaillement :</label>
                                    <select id="car_embroussaillement" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>0%</option>
                                        <option>0-25%</option>
                                        <option>25-50%</option>
                                        <option>50-75%</option>
                                        <option>75-100%</option>
                                        <option>100%</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="car_ombrage" class="font-weight-bold">Ombrage :</label>
                                    <select id="car_ombrage" class="custom-select custom-select-sm" placeholder="----" >
                                        <option>----</option>
                                        <option>0%</option>
                                        <option>0-25%</option>
                                        <option>25-50%</option>
                                        <option>50-75%</option>
                                        <option>75-100%</option>
                                        <option>100%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group w-100 justify-content-center " style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                <div class="d-flex mt-2 mb-2">
                                    <div class="w-50 mx-2">
                                        <label class="font-weight-bold">Présence d'EAEE:</label>
                                        <div class="table-sm">
                                                <table class="table table-bordered table-hover" id="tab_logic_eaee">
                                                    <thead  class="thead-light">
                                                        <tr>
                                                            <th class="text-center">
                                                                #
                                                            </th>
                                                            <th class="text-center">
                                                                EAEE :
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!--<tr id="eaee0"></tr>-->
                                                    </tbody>
                                                </table>
                                        </div>
                                        <div class="d-flex" >
                                            <button id="add_row_eaee" type="button" class="btn btn-outline-secondary mr-auto"><strong>+</strong> eaee</button>
                                            <button id="delete_row_eaee" type="button" class=" btn btn-outline-secondary"><strong>-</strong> eaee</button>
                                        </div>
                                    </div>
                                    <div class="w-50 mx-2">
                                        <label class="font-weight-bold">Présence d'EVEE:</label>
                                        <div class="table-sm">
                                            <!--<div class="clearfix">-->
                                                <table class="table table-bordered table-hover" id="tab_logic_evee">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="text-center">
                                                                #
                                                            </th>
                                                            <th class="text-center">
                                                                EVEE :
                                                            </th>
                                                            <th class="text-center">
                                                                % :
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!--<tr id="evee0"></tr>-->
                                                    </tbody>
                                                </table>
                                        </div>
                                        <div class="d-flex" >
                                            <button id="add_row_evee" type="button" class="btn btn-outline-secondary mr-auto"><strong>+</strong> evee</button>
                                            <button id="delete_row_evee" type="button" class=" btn btn-outline-secondary"><strong>-</strong> evee</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--END F ####################################### -->
                        <!--END F ####################################### -->
                        
                
                <h4 id="G" class="font-weight-bold bg-secondary text-light ml-2 pl-2">G. Travaux :</h4>
                        <div class="d-flex justify-content-start flex-wrap small">
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group ml-2 flex-column" style="overflow:hidden;text-overflow: ellipsis;white-space:nowrap;" >
                                    <label class="font-weight-bold">Travaux envisagés :</label>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label" >
                                                <input value="Aucun" name="car_travaux" type="checkbox" class="form-check-input" >Aucun
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Curage" name="car_travaux" type="checkbox" class="form-check-input" >Curage
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Reprofilage berge" name="car_travaux" type="checkbox" class="form-check-input" >Reprofilage berge
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Bûcheronnage" name="car_travaux" type="checkbox" class="form-check-input" >Bûcheronnage
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Débroussaillage" name="car_travaux" type="checkbox" class="form-check-input" >Débroussaillage
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Pose de clôture" name="car_travaux" type="checkbox" class="form-check-input" >Pose de clôture
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Aménagement d'abreuvoir" name="car_travaux" type="checkbox" class="form-check-input" >Aménagement d'abreuvoir
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Lutte contre espèces exotiques envahissantes" name="car_travaux" type="checkbox" class="form-check-input" >Lutte contre espèces exotiques envahissantes
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Nettoyage déchets" name="car_travaux" type="checkbox" class="form-check-input" >Nettoyage déchets
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Arrachage de végétation" name="car_travaux" type="checkbox" class="form-check-input" >Arrachage de végétation
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Intervention sur fonctionnement hydraulique" name="car_travaux" type="checkbox" class="form-check-input" >Intervention sur fonctionnement hydraulique
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Fauchage tardif de la périphérie" name="car_travaux" type="checkbox" class="form-check-input" >Fauchage tardif de la périphérie
                                            </label>
                                        </div>
                                        <div class="form-group form-check mt-1 mb-0">
                                            <label class="form-check-label">
                                                <input value="Autre" name="car_travaux" id="car_travaux_cx" type="checkbox" class="form-check-input" >Autre
                                            </label>
                                            <input id="car_travaux_autre" class="form-control form-control-sm d-none" placeholder="..." type="text" >
                                        </div>
                                        
                                </div>
                            </div>
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label>Objectif des travaux :</label>
                                    <input id="car_objec_trav" class="form-control form-control-sm" placeholder="..." type="text" >
                                </div>
                            </div>
                        </div>
                        <!--END G ####################################### -->
                        <!--END G ####################################### -->
                        
                        <h4 id="H" class="font-weight-bold bg-secondary text-light ml-2 pl-2">H. Commentaires :</h4>
                        <div class="d-flex justify-content-start flex-wrap small">
                            <div class="d-flex flex-column ml-2">
                                <div class="form-group">
                                    <label for="comment">Commentaire:</label>
                                    <textarea class="form-control" rows="3" id="car_comt"></textarea>
                                </div>
                            </div>
                        </div>
                        <!--END H ####################################### -->
                        <!--END H ####################################### -->
                    </div>
                </div><!-- END FLEX COLUMN MAIN -->
            </form>
            </div><!-- END MODAL BODY -->
            <div class="modal-footer ">
                <div class="d-flex">
                    <div class=""><span id="text_update_car" class="text-success small mr-4"> --> nouvelle caractérisation</span><button id="save_car" class="btn btn-success">+ Enregistrer la nouvelle caractérisation</button></div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->





<div class="d-none" id="absolute_path" ><?php echo $root_dir_; ?></div>
<div class="d-none" id="cur_dir" ><?php echo $dir_; ?></div>
</div><!-- /#wrapper -->








<!-- JQUERY-->
<script src="js/jq3.5.js" ></script>

<!--POPPER-->
<script src="js/popper.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.bundle.js"></script>
<!-- JQUERY AUTOCOMPLETE -->
<script src="js/plugins/jquery-ui-1.12.1.custom/jquery-ui.js" ></script>




<!-- BS Datetimepicker -->
<script src="js/plugins/moments.js" ></script>
<script src="js/plugins/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js" charset="UTF-8" ></script>
<script src="js/plugins/bootstrap-datetimepicker-master/build/js/locale_fr.js" ></script>

<!--HighCharts-->
<script src="js/plugins/highcharts/code/highcharts.js" ></script>
<script src="js/plugins/highcharts/code/modules/exporting.js" ></script>


<!-- DATATABLES -->
<!--<script type="text/javascript" src="js/plugins/datatables_all.min.js"></script> -->
<script type="text/javascript" src="js/plugins/datatable_bs4.5/datatables.min.js"></script>

<!--Leaflet-->
<script src="js/leaflet/leaflet.js" ></script>
<script src="js/leaflet/leaflet_add_function.js" ></script>
<script src="js/leaflet/plugins/Leaflet.draw-master/dist/leaflet.draw.js" ></script>
<script src="js/leaflet/plugins/leaflet_label/js/leaflet_label.js" ></script>
<script src="js/leaflet/plugins/Leaflet.markercluster-master/src/MarkerCluster.js" ></script>
<script src="js/leaflet/plugins/Leaflet.markercluster-master/src/MarkerClusterGroup.js" ></script>
<script src="js/leaflet/plugins/leaflet-image-gh-pages/leaflet-image.js"></script>
<script src="js/init_leaflet.js" ></script>

<!--Custom-->
<script src="js/home.js" ></script>
<script src="js/home_analyse.js" ></script>
<script src="js/plugins/d3/d3.js" ></script>
<script src="js/export_pdf_analyse.js" ></script>

<script >



//GET PATH
const absolute_path = $('#absolute_path').html();
const cur_dir = $('#cur_dir').html();
//const 

//popover
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

// LOAD HTML 
// CARACTERISATION MODAL
function includeHTML() {
  var z, i, elmnt, file, xhttp;
  /* Loop through a collection of all HTML elements: */
  z = document.getElementsByTagName("*");
  for (i = 0; i < z.length; i++) {
    elmnt = z[i];
    /*search for elements with a certain atrribute:*/
    file = elmnt.getAttribute("z-include-html");
    if (file) {
      /* Make an HTTP request using the attribute value as the file name: */
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
          if (this.status == 200) {elmnt.innerHTML = this.responseText;}
          if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
          /* Remove the attribute, and call this function once more: */
          elmnt.removeAttribute("z-include-html");
          //$("#modalCar").modal();
        }
      }
      xhttp.open("GET", file, true);
      xhttp.send();
      /* Exit the function: */
      return;
    }
  }
}
includeHTML();

////////////////////////////
//Reset forms
function resetModals () {
    $('#formLoc').trigger("reset");
    $('#formCar').trigger("reset");
    $('#formSpecies').trigger("reset");
    $('#formTravaux').trigger("reset");
    $('#formDelete').trigger("reset");
    $('#formPhoto').trigger("reset");
    i_i = 0;
    j_j = 0;
    id_car = "";
    update = false;
    $('input:checkbox').removeAttr('checked');
    $('input:radio').removeAttr('checked');
    $('#tab_logic_eaee tbody').html("<tr id='eaee0'></tr>");
    $('#tab_logic_evee tbody').html("<tr id='evee0'></tr>");
    $('#odkz').html("");
    $("#car_id_update").text("");
    $("#save_car").text("+ Enregistrer la nouvelle caractérisation");
    $("#text_update_car").text(" -> nouvelle caractérisation");
    $("#save_loc").text("+ Enregistrer la nouvelle localisation");
    $("#text_update").text(" -> nouvelle localisation");
    console.log("reset");
};

//$("#modalLoc").appendTo("#body");
//$('#modalLoc').modal("show");

////////////////////////////
//Clear FORMS on close modal
$('#modalCar').on('hidden.bs.modal', function () { resetModals();});
$('#modalLoc').on('hidden.bs.modal', function () { map_up(false); resetModals();});
$('#modalLoc').on('show.bs.modal', function (e) { map_up(true,"localisation"); });
$('#modalDefineSemi').on('hidden.bs.modal', function (e) { 
    map_up(false); 
    resetModals();
    map.removeControl(drawControl);
    drawing = false;
    $('#drawundraw').text(" + Dessiner une zone");
    ////Cache le bouton de sauvegarde du dessin
    $('#send_drawn_items').addClass("d-none");
    drawnItems.clearLayers();
});
$('#modalDefineSemi').on('show.bs.modal', function (e) { map_up(true,"analyse"); });
$('#modalSpecies').on('show.bs.modal', function (e) { resetModals();});
$('#modalTravaux').on('show.bs.modal', function (e) { resetModals();});
$('#modalDelete').on('show.bs.modal', function (e) { resetModals();});
$('#modalPhoto').on('show.bs.modal', function (e) { resetModals();});
$('#modalOdk').on('hidden.bs.modal', function (e) { map_up(false); resetModals();});
$('#modalOdk').on('show.bs.modal', function (e) { map_up(true,"odk"); resetModals();});
//$('#modalPhotoContent').on('show.bs.modal', function (e) { resetModals();});
$('#modalAnalyse').on('show.bs.modal', function (e) { resetModals();});

function load_esp_edit() {
    $("#add_spec").trigger('click');
}

////////////////////////////
//Display modals and Clear FORMS before
//Affiche le formulaire pour la caractérisation
$("#add_loc").click( function () {
    resetModals();
    emptied_selected_mare();
    map.closePopup();
    $('#modalLoc').modal();
});
$("#add_car").click( function () {
    remove_layers_for_other();
    if (mare_selected_str == '') {
        alert('Selectionnez/cliquez sur une mare pour ajouter une caractérisation');
    } else {
        $("#add_car_id_form").text('Ajouter une caractérisation pour la mare : '+$('#mares_autocomplete').val());
        resetModals();
        $("#modalCar").modal();
    }
});
//Affiche le formulaire pour la caractérisation
$("#add_photo").click( function () {
    remove_layers_for_other();
    if (mare_selected_str == '') {
        alert('Selectionnez/cliquez sur une mare pour ajouter une caractérisation');
    } else {
        $("#add_photo_id_form").text('De la mare : '+$('#mares_autocomplete').val());
        resetModals();
        $("#modalPhoto").modal();
    }
});
//Affiche le formulaire pour supprimer une mare
$("#delete_mare").click( function () {
    remove_layers_for_other();
    if (mare_selected_str == '') {
        alert('Selectionnez/cliquez sur une mare pour la supprimer');
    } else {
        $("#delete_mare_id").text('Identifiant de la mare à supprimer : '+$('#mares_autocomplete').val());
        resetModals();
        $("#modalDelete").modal();
    }
});
//Affiche le formulaire pour ajouter des especes
$("#add_spec").click( function (){
    if (mare_selected_str == '') {
        alert('Selectionnez/cliquez sur une mare pour y ajouter des espèces');
    } else {
        $("#species_mare").text("Mare : "+mare_selected_str);
        resetModals();
        dt4.clear().draw();
        e_e=0;
        $("#ModalSpecies").modal();
        load_species(mare_selected_str)
    }
});
//Affiche le formulaire pour ajouter des travaux
$("#add_w").click( function (){
    if (mare_selected_str == '') {
        alert('Selectionnez/cliquez sur une mare pour y ajouter des travaux');
    } else {
        $("#w_mare").text("Mare : "+mare_selected_str);
        resetModals();
        dt5.clear().draw();
        ei_e=0;
        $("#ModalTravaux").modal();
    }
});

//display file name for custom file input
$("#photo").on('change',function(e){
  var fileName = document.getElementById("photo").files[0].name;
  var nextSibling = e.target.nextElementSibling
  nextSibling.innerText = fileName
});
$("#schema").on('change',function(e){
  var fileName = document.getElementById("schema").files[0].name;
  var nextSibling = e.target.nextElementSibling
  nextSibling.innerText = fileName
});


initmap();
liste_evee_eaee_full();
e_events();
e_e=0;
ei_events();
ei_e=0;
reload();

function emptied_selected_mare () {
    update = false;
    $("#mares_autocomplete").val('');
    mare_selected_str='';
}

function emptied_form_car () {
    update = false;
    $("#mares_autocomplete").val('');
}

$("#add_row_eisp").css("border","1px solid #dddddd");
$("#delete_row_eisp").css("border","1px solid #dddddd");


var dt2 = $('#ola_dt__').DataTable({
    "language": {
    "paginate": {
    "previous": "Préc.",
    "next": "Suiv."
    },
    "search": "Filtrer :",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
    "sInfoPostFix":    "",
    "sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau"
},
dom: 'tB',
buttons: [
    { 
    "extend": 'excel', 
    "text":'Excel',
    "className": 'btn btn-secondary' },
    { 
    "extend": 'pdf', 
    "text":'PDF',
    "className": 'btn btn-secondary' }
    ]
});

var dt4 = $('#ola_dt').DataTable({
    "language": {
    "paginate": {
    "previous": "Préc.",
    "next": "Suiv."
    },
    "search": "Filtrer :",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
    "sInfoPostFix":    "",
    "sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau"
},
dom: 'pt',
buttons: [
    { 
    "extend": 'excel', 
    "text":'Excel',
    "className": 'btn btn-default' },
    { 
    "extend": 'pdf', 
    "text":'PDF',
    "className": 'btn btn-default' }
    ]
});
var dt5 = $('#wr_esp_dt').DataTable({
    "language": {
    "paginate": {
    "previous": "Préc.",
    "next": "Suiv."
    },
    "search": "Filtrer :",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
    "sInfoPostFix":    "",
    "sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau"
},
dom: 'tB',
buttons: [
    { 
    "extend": 'excel', 
    "text":'Excel',
    "className": 'btn btn-default' },
    { 
    "extend": 'pdf', 
    "text":'PDF',
    "className": 'btn btn-default' }
    ]
});

$('#filter_myloc').change(function () {
    (this.checked) ? map.addLayer(my_mares) : map.removeLayer(my_mares);
  }).change();
$('#filter_loc_tierce').change(function () {
     (this.checked) ? map.addLayer(mares) : map.removeLayer(mares);
  }).change();

<!--SAVE MODAL LOC -->
$("#save_loc").on('click', function() {
    var x = $("#loc_x").val();
    var y = $("#loc_y").val();
    var loc_date = $("#loc_date").val();
    if (( x != '') && (y != '') && ( loc_date != '')) {
        if (update) {
            console.log("loc update");
            var loc_nom             = $("#loc_nom").val();
            var loc_type_propriete  = $("#loc_type_propriete option:selected").text();
            var loc_statut          = $("#loc_statut option:selected").text();
            var loc_comment         = $("#loc_comment").val();
            var loc_anonymiser      = true;
            
            var id = mare_p_active.properties.loc_id_plus;
            $.ajax({
                method   : "POST",
                url: "php/ajax/save_form/localisation_update.js.php",
                dataType : "text",
                async : true,
                data: {
                    id:id,
                    x: x,
                    y: y, 
                    loc_nom: loc_nom, 
                    loc_type_propriete: loc_type_propriete, 
                    loc_statut: loc_statut, 
                    loc_date: loc_date, 
                    loc_comt: loc_comment, 
                    loc_anonymiser: loc_anonymiser
                },
                success: function( data ) {
                    // console.log(data);
                    if (data) {
                        loc_end("update");
                        console.log("loc update success");
                    }
                },
                error: function () {loc_end("error");}
            });
        }else {
            console.log("loc");
            $("#save_loc").val("Enregistrer la localisation");
            var loc_nom             = $("#loc_nom").val();
            var loc_type_propriete  = $("#loc_type_propriete option:selected").text();
            var loc_statut          = $("#loc_statut option:selected").text();
            var loc_comment         = $("#loc_comment").val();
            var loc_anonymiser      = true;
            $.ajax({
                method   : "POST",
                url: "php/ajax/save_form/localisation.js.php",
                dataType : "json",
                async : true,
                data: {
                    x: x,
                    y: y, 
                    loc_nom: loc_nom, 
                    loc_type_propriete: loc_type_propriete, 
                    loc_statut: loc_statut, 
                    loc_date: loc_date, 
                    loc_comt: loc_comment, 
                    loc_anonymiser: loc_anonymiser
                },
                success: function( data ) {
                    if (data) {
                        loc_end("");
                        console.log("loc success");
                    }
                },
                error: function () {loc_end("error");}
            });
        }
    }else {
        alert("Attention champ lat, lng ou date non renseigné");
    }
    });

function loc_end(result) {
    update=false;
    remove_layers_for_other();
    if (result == "update") {
        alert("Modification de localisation enregistrée !");
    } else if (result == "error") {
        alert("Une erreur s'est produite impossible d'enregistrer les informations !");
    } else {
        alert("Localisation enregistrée !");
        console.log("click");
    }
    display_mares_in_area(sessionStorage.getItem('id_search'), sessionStorage.getItem('table_name_search'));
    emptied_selected_mare();
    resetModals();
    $('#modalLoc').modal('hide');
}

<!--SAVE MODAL CAR -->
$("#save_car").on('click', function() {
    var eaee_str = '';
    var evee_str = '';
    //var evee_rec_str = '';
    var grp_faune_ar = '';
    var usages_ar = '';
    var dechets_ar = '';
    var contextes_ar = '';
    var patrimoines_ar = '';
    var liaisons_ar = '';
    var alimentations_ar = '';
    var travaux_ar = '';
    
    //$("#grp_faune input:checked").each(function() {grp_faune_ar+=$(this).attr('name')+'|';});
    $.each($("input[name='grp_faune']:checked"), function(){ grp_faune_ar+=$(this).val()+'|'; });
    $.each($("input[name='car_usages']:checked"), function(){ usages_ar+=$(this).val()+'|'; });
    $.each($("input[name='car_dechets']:checked"), function(){ dechets_ar+=$(this).val()+'|'; });
    $.each($("input[name='car_contextes']:checked"), function(){ contextes_ar+=$(this).val()+'|'; });
    $.each($("input[name='car_patrimoine']:checked"), function(){ patrimoines_ar+=$(this).val()+'|'; });
    $.each($("input[name='car_liaisons']:checked"), function(){ liaisons_ar+=$(this).val()+'|'; });
    $.each($("input[name='car_alimentations']:checked"), function(){ alimentations_ar+=$(this).val()+'|'; });
    $.each($("input[name='car_travaux']:checked"), function(){ travaux_ar+=$(this).val()+'|'; });
    
    $('[id^="template_eaee"]').each(function() {eaee_str+=$(this).val()+'|';});
    $('[id^="template_evee_"]').each(function() {var id_ = $(this).attr('id').replace("template_evee_",""); evee_str+=$(this).val()+'__'+$("#template_eveeprt_"+id_).val()+'|';});
    //$('[id^="template_eveeprt_"]').each(function() {evee_rec_str+=$(this).val()+'|';});
    
    var car_date = $("#car_date").val();
    var car_type = $("#car_type option:selected").text();//SELECT
    var grp_faune = delete_last_car(grp_faune_ar);//CHECKBOXES
    var grp_faune_autre = $("#grp_faune_autre").val();
    var car_veget = $("#car_veget option:selected").text();
    var car_stade = $('input[name=stade]:checked').val();// RADIO BUTTON
    var car_usages = delete_last_car(usages_ar);
    var car_pompe = $("#car_pompe option:selected").val();
    var car_dechets = delete_last_car(dechets_ar);
    var car_topo = $("#car_topo option:selected").text();
    var car_topo_autre = $("#car_topo_autre").val();
    var car_contextes = delete_last_car(contextes_ar);
    var car_patrimoine = delete_last_car(patrimoines_ar);
    var car_patrimoine_autre = $("#car_patrimoine_autre").val();
    var car_cloture = $("#car_cloture option:selected").text();
    var car_haie = $("#car_haie option:selected").text();
    var car_forme = $("#car_forme option:selected").text();
    var car_long = $("#car_long").val();
    var car_larg = $("#car_larg").val();
    var car_hauteur = $("#car_hauteur option:selected").text();
    var car_fond = $("#car_fond option:selected").text();
    var car_fond_autre = $("#car_fond_autre").val();
    var car_berges = $("#car_berges option:selected").text();
    var car_bourrelet = $("#car_bourrelet option:selected").text();
    var car_bourrelet_prct = $("#car_bourrelet_prct").val();
    var car_surpietinement = $("#car_surpietinement option:selected").text();
    var car_hydrologie = $("#car_hydrologie option:selected").text();
    var car_liaisons = delete_last_car(liaisons_ar);
    var car_liaisons_autre = $("#car_liaisons_autre").val();
    var car_alimentations = delete_last_car(alimentations_ar);
    var car_alimentations_autre = $("#car_alimentations_autre").val();
    var car_turbidite = $("#car_turbidite option:selected").text();
    var car_couleur = $("#car_couleur option:selected").text();
    var car_couleur_autre = $("#car_couleur_autre").val();
    var car_tampon = $("#car_tampon option:selected").text();
    var car_exutoire = $("#car_exutoire option:selected").text();
    var rec_total = $("#rec_total").text().split("%")[0].trim();
    var c_recou_helophyte = $("#c_recou_helophyte").val();
    var c_recou_hydrophyte_e = $("#c_recou_hydrophyte_e").val();
    var c_recou_hydrophyte_ne = $("#c_recou_hydrophyte_ne").val();
    var c_recou_algue = $("#c_recou_algue").val();
    var c_recou_eau_libre = $("#c_recou_eau_libre").val();
    var c_recou_non_veget = $("#c_recou_non_veget").val();
    var car_embroussaillement = $("#car_embroussaillement option:selected").text();
    var car_ombrage = $("#car_ombrage option:selected").text();
    var car_eaee = eaee_str;
    var car_evee = evee_str;
    var car_objec_trav = $("#car_objec_trav").val();
    var car_travaux =  delete_last_car(travaux_ar);
    var car_travaux_autre = $("#car_travaux_autre").val();
    var car_comt = $("#car_comt").val();
    
    if (( car_date != '') && ( car_type != '') && ( grp_faune != '') && ( car_veget != '')  && ( car_stade != '') && ( car_date != null) && ( car_type != null) && ( grp_faune != null) && ( car_veget != null)  && ( car_stade != null) ) {
        if (update) 
        {$.ajax({
            method   : "POST",
            url: "php/ajax/save_form/caracterisation_update.js.php",
            dataType : "json",
            data: {
                //car_id : $("#car_id_update").text().split(" : ")[1],
                car_id : id_car,
                car_date : car_date ,
                car_type : car_type ,
                grp_faune : grp_faune ,
                grp_faune_autre : grp_faune_autre ,
                car_veget : car_veget ,
                car_stade : car_stade ,
                car_usages : car_usages ,
                car_pompe : car_pompe ,
                car_dechets : car_dechets ,
                car_topo : car_topo ,
                car_topo_autre : car_topo_autre ,
                car_contextes : car_contextes ,
                car_patrimoine : car_patrimoine ,
                car_patrimoine_autre : car_patrimoine_autre ,
                car_cloture : car_cloture ,
                car_haie : car_haie ,
                car_forme : car_forme ,
                car_long : car_long ,
                car_larg : car_larg ,
                car_hauteur : car_hauteur ,
                car_fond : car_fond ,
                car_fond_autre : car_fond_autre ,
                car_berges : car_berges ,
                car_bourrelet : car_bourrelet ,
                car_bourrelet_prct : car_bourrelet_prct,
                car_surpietinement : car_surpietinement ,
                car_hydrologie : car_hydrologie ,
                car_liaisons : car_liaisons ,
                car_liaisons_autre : car_liaisons_autre ,
                car_alimentations : car_alimentations ,
                car_alimentations_autre : car_alimentations_autre ,
                car_turbidite : car_turbidite ,
                car_couleur : car_couleur ,
                car_couleur_autre : car_couleur_autre ,
                car_tampon : car_tampon ,
                car_exutoire : car_exutoire ,
                rec_total : rec_total ,
                c_recou_helophyte : c_recou_helophyte ,
                c_recou_hydrophyte_e : c_recou_hydrophyte_e ,
                c_recou_hydrophyte_ne : c_recou_hydrophyte_ne ,
                c_recou_algue : c_recou_algue ,
                c_recou_eau_libre : c_recou_eau_libre ,
                c_recou_non_veget : c_recou_non_veget ,
                car_embroussaillement : car_embroussaillement ,
                car_ombrage : car_ombrage ,
                car_eaee : car_eaee ,
                car_evee : car_evee ,
                car_objec_trav : car_objec_trav ,
                car_travaux : car_travaux ,
                car_travaux_autre : car_travaux_autre ,
                car_comt : car_comt
            },
            success: function( data ) {
                if(data) {alert("Modification de la caractérisation enregistrée !");update = false;$('#modalCar').modal('hide');}
            }
        });
        } else {
            $.ajax({
            method   : "POST",
            url: "php/ajax/save_form/caracterisation.js.php",
            dataType : "json",
            data: {
                loc_id_plus : $("#mares_autocomplete").val(),
                car_date : car_date ,
                car_type : car_type ,
                grp_faune : grp_faune ,
                grp_faune_autre : grp_faune_autre ,
                car_veget : car_veget ,
                car_stade : car_stade ,
                car_usages : car_usages ,
                car_pompe : car_pompe ,
                car_dechets : car_dechets ,
                car_topo : car_topo ,
                car_topo_autre : car_topo_autre ,
                car_contextes : car_contextes ,
                car_patrimoine : car_patrimoine ,
                car_patrimoine_autre : car_patrimoine_autre ,
                car_cloture : car_cloture ,
                car_haie : car_haie ,
                car_forme : car_forme ,
                car_long : car_long ,
                car_larg : car_larg ,
                car_hauteur : car_hauteur ,
                car_fond : car_fond ,
                car_fond_autre : car_fond_autre ,
                car_berges : car_berges ,
                car_bourrelet : car_bourrelet ,
                car_bourrelet_prct : car_bourrelet_prct,
                car_surpietinement : car_surpietinement ,
                car_hydrologie : car_hydrologie ,
                car_liaisons : car_liaisons ,
                car_liaisons_autre : car_liaisons_autre ,
                car_alimentations : car_alimentations ,
                car_alimentations_autre : car_alimentations_autre ,
                car_turbidite : car_turbidite ,
                car_couleur : car_couleur ,
                car_couleur_autre : car_couleur_autre ,
                car_tampon : car_tampon ,
                car_exutoire : car_exutoire ,
                rec_total : rec_total ,
                c_recou_helophyte : c_recou_helophyte ,
                c_recou_hydrophyte_e : c_recou_hydrophyte_e ,
                c_recou_hydrophyte_ne : c_recou_hydrophyte_ne ,
                c_recou_algue : c_recou_algue ,
                c_recou_eau_libre : c_recou_eau_libre ,
                c_recou_non_veget : c_recou_non_veget ,
                car_embroussaillement : car_embroussaillement ,
                car_ombrage : car_ombrage ,
                car_eaee : car_eaee ,
                car_evee : car_evee ,
                car_objec_trav : car_objec_trav ,
                car_travaux : car_travaux ,
                car_travaux_autre : car_travaux_autre ,
                car_comt : car_comt
            },
            success: function( data ) {
                if(data) {alert("caractérisation enregistrée !");  };update = false;// $('#modalCar').modal('hide');
                $('#modalCar').modal('hide');
                display_mares_in_area(sessionStorage.getItem('id_search'), sessionStorage.getItem('table_name_search'));
            }
            });
        }
    } else {
        alert('Attention les 5 premiers champs sont obligatoires');
    }
});

//PHOTO
var file_photo = false;
var file_schema = false;
var validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
$("#photo").change(function() {
    file_photo = true;
    file = this.files[0];
    fileType = file['type'];
});
$("#schema").change(function() {
    file_schema = true;
    file = this.files[0];
    fileType = file['type'];
});

$("#save_photo").on('click', function() {
    var id_plus = $('#mares_autocomplete').val();
    if ( file_photo && (typeof fileType !== 'undefined')) {
        if (validImageTypes.includes(fileType)) {
            //Le fichier est de type image
            reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                $.ajax({
                    method   : "POST",
                    url: "php/ajax/save_form/save_photo.php",
                    dataType : "text",
                    data: {
                        base64_img : reader.result.split(',')[1],
                        id_plus : id_plus,
                        file_size : file.size,
                        schema : false
                    },
                    success: function( data ) {
                            alert("photo enregistrée !");
                    }
                });
            };
        }else {
            alert("selectionnez une image (jpeg,png,gif)");
        }
    } else {
        alert("pas de fichier selectionné");
    }
    
});
$("#save_schema").on('click', function() {
    var id_plus = $('#mares_autocomplete').val();
    if ( file_schema && (typeof fileType !== 'undefined')) {
        if (validImageTypes.includes(fileType)) {
            //Le fichier est de type image
            reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                $.ajax({
                    method   : "POST",
                    url: "php/ajax/save_form/save_schema.php",
                    dataType : "text",
                    data: {
                        base64_img : reader.result.split(',')[1],
                        id_plus : id_plus,
                        file_size : file.size,
                        schema : false
                    },
                    success: function( data ) {
                            alert("schema enregistré !");
                    }
                });
            };
        }else {
            alert("selectionnez une image (jpeg,png,gif)");
        }
    } else {
        alert("pas de fichier selectionné");
    }
    
});
//DELETE MARE
$("#delete_mare_ended").click( function () {
    var id_plus = $("#mares_autocomplete").val();
    if ((id_plus !== '')&&(id_plus !== 'undefined')) {
            if ( confirm( "Supprimer toutes les informations \n liées à la mare "+ id_plus+" ? \n (localisation, caractérisation(s),photo(s))" ) ) {
                $.ajax({
                    method   : "POST",
                    url: "php/ajax/delete/delete_mare.js.php",
                    dataType : "text",
                    data: {
                        id_plus : id_plus
                    },
                    success: function( data ) {
                        display_mares_in_area(sessionStorage.getItem('id_search'), sessionStorage.getItem('table_name_search'));
                        $('#modalDelete').modal('toggle');
                    }
                });
            }
    }
});
</script>
</body>
</html>