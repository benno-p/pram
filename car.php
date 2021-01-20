<!DOCTYPE html>
<html lang="en">
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
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="css/datatables.bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/c_home.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <!-- DATATABLES -->
    <!--<link href="js/plugins/datatables_all.min.css" rel="stylesheet">-->
    <!--Autocomplete UI -->
    <link href="css/plugins/jquery-ui.css" rel="stylesheet">
    <link href="css/plugins/ui_autocomplete.css" rel="stylesheet">
    <!--FONT AWESOME-->
    <link href="font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Datetime picker -->
    <link href="js/plugins/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" >
    <link href="js/plugins/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker-standalone.css" rel="stylesheet" type="text/css" >
    
</head>

<?php
session_start();
include 'php/properties.php';


if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = "b.perceval@cenbn.fr"; /* A desactiver pour mise en ligne */
    //header('Location: index.php');
    //exit();
};
if (!isset($_SESSION['password'])) {
    $_SESSION['password'] = "cenno"; /* A desactiver pour mise en ligne */
};
if (!isset($_SESSION['id_sicen'])) {
    $_SESSION['id_sicen'] = 21; /* A desactiver pour mise en ligne */
};
//if (!isset($_SESSION['search_done'])) {
//    $_SESSION['id_sicen'] = 21; /* A desactiver pour mise en ligne */
//};

?>



<body class="">
<div id="screen_grey" class="screen_grey d-none"></div>
<div id="form_to_display" class="form_over"></div>

<div id="wrapper">

<?php include('menu.inc.php'); ?>

    
        
        
    <div id="content-wrapper">
        
        
        
        <div class="d-flex w-100 static-top text-white bg-dark  pt-2 mb-2 pb-2 justify-content-end align-items-center">
            <div><span href="#" class=" mx-2 strong" id="mail_user"> <?php echo $_SESSION['email']; ?></span></div>
            <div><a class="small mx-2 logout" href="php/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a></div>
        </div>
        
        
        <div class="content">
            <div class="container-fluid">
            
            

            
            
            
            

                <!-- /.Page Heading -->
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-8" ><!-- data-spy="affix" data-offset-top="60" -->
                        <div id="map" style="width:1000px;height:600px;" ></div><!-- data-spy="affix" data-offset-top="60" -->
                        <div id="images_out" class="d-none" ></div>
                        <div class="d-flex flex-wrap align-content-center bg-light">
                            <div class="mx-2"><img style="max-width:12px;max-height:12px;" src="img\mare\vue.png" /><small>Vue</small></div>
                            <div class="mx-2"><img style="max-width:12px;max-height:12px;" src="img\mare\caracterisee.png" /><small>Caractérisée</small></div>
                            <div class="mx-2"><img style="max-width:12px;max-height:12px;" src="img\mare\potentielle.png" /><small>Potentielle</small></div>
                            <div class="mx-2"><img style="max-width:12px;max-height:12px;" src="img\mare\disparue.png" /><small>Disparue</small></div>
                            <div class="mx-2"><input class="" type="checkbox" id="filter_myloc" checked><small>Mes localisations</small></input></div>
                            <div class="mx-2"><input class="" type="checkbox" id="filter_loc_tierce" checked><small>Localisations tierces</small></input></div>
                            
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div id="loader" class="loader visible_s">
                                    <i class="fa fa-refresh fa-spin"></i>Loading
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="layers_autocomplete">Rechercher un découpage administratif :</label>
                                <input id="layers_autocomplete" class="form-control" placeholder="" onblur="" aria-describedby="layersHelp" >
                                <small id="layersHelp" class="form-text text-muted">Commune, EPCI ...</small>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="mares_autocomplete">Rechercher une mare :</label>
                                <input id="mares_autocomplete" class="form-control" placeholder="" onblur="" aria-describedby="maresHelp">
                                <small id="maresHelp" class="form-text text-muted">5 caractères minimum (ex: 8FW2X) </small>
                            </div>
                        </div>
                        
                        <p id="close_on" class="d-none close_on_form_over" ><span class="glyphicon glyphicon-remove"></span></p>
                        
                        <div class="col-lg-12">
                        
                        <button id="add_loc" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLoc"><i class="fa fa-plus-circle"></i> Localisation de mare</button>
                        <button id="add_car" type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCar"><i class="fa fa-plus-circle"></i> Caractérisation de mare</button>
                        
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <button id="add_photo" type="submit" class="btn btn-yellowed"><i class="fa fa-plus-circle"></i> Photo</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <button id="add_car" type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Caractérisation de mare</button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <button id="delete_mare" type="submit" class="btn btn-danger"><i class="fa fa-minus-circle"></i> Mare</button>
                                </div>
                            </div>
                            
                            
                            
                            
                            <!--<div class="col-lg-12">
                            <!--    <div class="form-group">
                            <!--        <button id="test" type="submit" class="btn btn-danger">GET GRAPH</button>
                            <!--    </div>
                            <!--</div>-->
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div id="add_spec" class="btn btn-purple" data-toggle="modal" ><i class="fa fa-plus-circle"></i> Observation d'espèce</div><!--data-target="#ModalSpecies" -->
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div id="add_w" class="btn btn-pink" data-toggle="modal" ><i class="fa fa-plus-circle"></i> Travaux</div><!--data-target="#ModalSpecies" -->
                                </div>
                            </div>
                        </div>
                        
                        
                        <img id="image_export" style="" class=""/>
                        
                        
                        <div class="col-lg-12">
                            <div id="olaa" class="form-group">
                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                
                            </div>
                        </div>
                    </div>
                <div class="row">

<!-- MODAL LOCALISATION-->
<!-- MODAL LOCALISATION-->
<!-- MODAL LOCALISATION-->
<div class="modal fade" id="modalLoc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-slideout modal-md" role="document">
    <div class="modal-content loc_blue">
      <div class="modal-header">
        <div class="d-flex">
        <h5 class="modal-title" id="exampleModalLabel">Localisation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="d-flex">
            <small class="text-muted">Cliquez sur la carte pour localiser la mare</small>
        </div>
      </div>
      <div class="modal-body">
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
            <select id="loc_statut" class="form-control">
                <option>Vue</option>
                <option>Potentielle</option>
                <option>Disparue</option>
                <option>Caractérisée</option>
            </select>
            </div>
            <div class="form-group mx-2">
            <label for="loc_type_propriete">Type de propriété :</label>
            <select id="loc_type_propriete" class="form-control">
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
      <div class="modal-footer ">
        <div class="d-flex flex-column">
        <div class="mb-2 small"><span id="text_update" class="text-success"> --> nouvelle localisation</span></div>
        <div class=""><button id="save_loc" type="submit" class="btn btn-primary">+ Enregistrer la nouvelle localisation</button></div>
        </div>
      </div>
    </div>
  </div>
</div>








                </div>
                <!-- /.row -->
                </div>
            <!-- /.row -->
            </div><!-- /container-fluid -->
        </div><!-- content -->
        <?php include('footer.inc.php'); ?>
    </div><!-- /#content-wrapper -->


</div><!-- /#wrapper -->

<!-- JQUERY-->
<script src="js/jq3.5.js" ></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js"></script>
<script src="js/popper.js"></script>
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
<script type="text/javascript" src="js/plugins/datatable/datatables.js"></script>


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
//bootstrap 3.x and datatable work but disable dropdown menu
$('body .dropdown-toggle').dropdown();
// Pour test graph
//graph_typologie("typologie", [10,50,25,30]);
//$("#analyse_result").removeClass("hidden");
initmap();
liste_evee_eaee_full();
e_events();
e_e=0;
ei_events();
ei_e=0;

$("#add_row_eisp").css("border","1px solid #dddddd");
$("#delete_row_eisp").css("border","1px solid #dddddd");

//$('#layers_autocomplete_d').attr("zIndex",1020);
$("#drawundraw").click(function () {
    display_drawing_items();
});

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
    "className": 'btn btn-outline-secondary' },
    { 
    "extend": 'pdf', 
    "text":'PDF',
    "className": 'btn btn-outline-secondary' }
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

reload();

/*TEST MODAL*/
//$("#ModalSpecies").modal();
//load_species('8CXX6JVQ+JR_43497');
//$("#ModalTravaux").modal();
//mare_selected_str = '8CXX6JVQ+JR_43497';

<!--TEST MODAL LOC -->
$("#save_loc").on('click', function() {
    if (update) {
        var id = mare_p_active.properties.loc_id_plus;
        var x = $("#loc_x").val();
        var y = $("#loc_y").val();
        var loc_date = $("#loc_date").val();
        if (( x != '') && (y != '') && ( loc_date != '')) {
            var loc_nom             = $("#loc_nom").val();
            var loc_type_propriete  = $("#loc_type_propriete option:selected").text();
            var loc_statut          = $("#loc_statut option:selected").text();
            var loc_comment         = $("#loc_comment").val();
            var loc_anonymiser      = true;
            $.ajax({
                method   : "POST",
                url: "php/ajax/save_form/localisation_update.js.php",
                dataType : "text",
                async : false,
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
                    //console.log(data);
                    if (data) {
                        alert("Modification de localisation enregistrée !"); update=false;
                        $('#modalLoc').modal('toggle');
                        remove_layers_for_other();
                    }
                }
            });
        };
    }else {
        $("#save_loc").val("Enregistrer la localisation");
        var x = $("#loc_x").val();
        var y = $("#loc_y").val();
        var loc_date = $("#loc_date").val();
        if (( x != '') && (y != '') && ( loc_date != '')) {
            var loc_nom             = $("#loc_nom").val();
            var loc_type_propriete  = $("#loc_type_propriete option:selected").text();
            var loc_statut          = $("#loc_statut option:selected").text();
            var loc_comment         = $("#loc_comment").val();
            var loc_anonymiser      = true;
            $.ajax({
                method   : "POST",
                url: "php/ajax/save_form/localisation.js.php",
                dataType : "json",
                async : false,
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
                        alert("Localisation enregistrée !"); update=false;
                        $('#modalLoc').modal('toggle');
                        remove_layers_for_other();
                    }
                }
            });
        };
    }
    change_load ('Re-Chargement des mares...');
    display_mares_in_area(sessionStorage.getItem('id_search'), sessionStorage.getItem('table_name_search'));
    });
    

// LOAD HTML 
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

</script>




</body>
</html>
                        <!-- NEW FORM checkbox to buttons -->
                        <!--<div class="form-group" required>
                        <!--    <label>Groupes Faunistiques observés* :</label>
                        <!--    <div class="btn-group btn-group-vertical btn-group-toggle btn-sm" data-toggle="buttons">
                        <!--        <label class="btn btn-outline-secondary btn-sm">
                        <!--            <input value="" grp="grp_faune"   name="Amphibiens (grenouilles, crapauds, tritons, salamandres)" descr="Amphibiens (grenouilles, crapauds, tritons, salamandres)" type="checkbox">Amphibiens (grenouilles, crapauds, tritons, salamandres)
                        <!--        </label>
                        <!--        <label class="btn btn-outline-secondary btn-sm">
                        <!--            <input value="" grp="grp_faune"   name="Reptiles (serpents, tortues, lézards)" descr="Reptiles (serpents, tortues, lézards)" type="checkbox">Reptiles (serpents, tortues, lézards)
                        <!--        </label>
                        <!--        <label class="btn btn-outline-secondary btn-sm">
                        <!--            <input value="" grp="grp_faune"   name="Libellules (larves, adultes ou exuvies)" descr="Libellules (larves, adultes ou exuvies)" type="checkbox">Libellules (larves, adultes ou exuvies)
                        <!--        </label>
                        <!--        <label class="btn btn-outline-secondary btn-sm active">
                        <!--            <input value="" grp="grp_faune" checked name="Invertébrés aquatiques" descr="Invertébrés aquatiques" type="checkbox">Invertébrés aquatiques
                        <!--        </label>
                        <!--        <label class="btn btn-outline-secondary btn-sm">
                        <!--            <input value="" grp="grp_faune"   name="Poissons" descr="Poissons" type="checkbox">Poissons
                        <!--        </label>
                        <!--        <label class="btn btn-outline-secondary btn-sm active">
                        <!--            <input value="" grp="grp_faune"   name="Canards, oies, cygnes" descr="Canards, oies, cygnes" type="checkbox">Canards, oies, cygnes
                        <!--        </label>
                        <!--        <label class="btn btn-outline-secondary btn-sm">
                        <!--            <input grp="grp_faune"  checked id="grp_faune_cx" value="" name="Autre" descr="Autre" type="checkbox">Autre
                        <!--        </label>
                        <!--                <!--<input id="grp_faune_autre" class="form-control d-none" placeholder="Elephant" type="text" >-->
                        <!--        <label class="btn btn-outline-secondary btn-sm">
                        <!--            <input grp="grp_faune"  checked="true" autocomplete="on" value="" name="Aucun" descr="Aucun" type="checkbox">Aucun
                        <!--        </label>
                        <!--    </div>
                        <!--</div>-->
                        
                        
                        
                        
                        
                        
                        
                        
                        



