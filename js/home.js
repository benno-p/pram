photos_directory = "img/photos/";
var i_i = 0;
var j_j = 0;
var drawing = false;
var dt=false;
var update=false;
var id_car="";
$("#mare_loc_menu").click( function (){
    $("#add_loc").trigger('click');
});
$("#mare_car_menu").click( function (){
    $("#add_car").trigger('click');
});
$("#mare_photo_menu").click( function (){
    $("#add_photo").trigger('click');
});
$("#mare_delete_menu").click( function (){
    $("#delete_mare").trigger('click');
});
$("#mare_espece_menu").click( function (){
    $("#add_spec").trigger('click');
});
$("#mare_travaux_menu").click( function (){
    $("#add_w").trigger('click');
});
$("#wc_save").click( function (){
    save_wc();
});
$("#wa_save").click( function (){
    save_wa();
});
$("#wr_save").click( function (){
    save_wr();
});






$("#save_spec").click( function (){
    save_species(mare_selected_str);
});

function save_species (si_str) {
    dt4.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
    var data = this.data();
        $.ajax({
            type : 'POST',
            url: "php/ajax/save_form/save_species.js.php",
            data: {
                loc_id_plus : si_str, 
                nom_complet : data[1],
                date : data[2],
                effectif : data[3],
                obs : data[4],
                comt : data[5]
                },
            async    : true,
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            dataType : "text",
            success: function(data) {
                console.log(data);
            }
        });
    
    });
}
function load_species (mare_selected_) {
    $.ajax({
    type: 'POST',
    url: "php/ajax/load_species.js.php",
    async: true,
    dataType: 'json',
    data: {mare : mare_selected_},
    success: function(obs_s) {
            Object.keys(obs_s).forEach(function(k){
                //console.log(obs_s[k]);
                var o = JSON.parse(obs_s[k]);
                var taxon = o.o_nom_complet;
                var date_o = o.o_date;
                var effe = o.o_nombre;
                var comt = o.o_comt;
                var obsv = o.o_observateur;
                
                var rowNode = dt2.row.add( [
                    taxon,
                    date_o,
                    effe,
                    //obsv,
                    ((obsv == $("#mail_user").text()|| "") ? obsv : 'autre observateur'),
                    comt
                ] ).draw( true ).node();
            });
    }
   });
}



function save_wr() {
    var wr_ar='';
    dt5.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
    var data = this.data();
        wr_ar+=data[1]+'|';
    });
        $.ajax({
            type : 'POST',
            url: "php/ajax/save_form/save_wr.js.php",
            data: {
                wr_loc_id_plus : mare_selected_str,
                wr_date : $("#wr_date").val(), 
                wr_str : $("#wr_str").val(),
                wr_cur : $("#wr_cur").val(),
                wr_repro : $("#wr_repro").val(),
                wr_etanc : $("#wr_etanc").val(),
                wr_etanc_nature : $("#wr_etanc_nature").val(),
                wr_abat : $("#wr_abat").val(),
                wr_dessouch_nb : $("#wr_dessouch_nb").val(),
                wr_elag_nb : $("#wr_elag_nb").val(),
                wr_debrou_surf : $("#wr_debrou_surf").val(),
                wr_depol : $("#wr_depol").val(),
                wr_intro : wr_ar,
                wr_comt : $("#wr_comt").val()
                },
            async    : true,
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            dataType : "text",
            success: function(data) {
            }
        });
}
function save_wa() {
        $.ajax({
            type : 'POST',
            url: "php/ajax/save_form/save_wa.js.php",
            data: {
                wa_loc_id_plus : mare_selected_str,
                wa_date : $("#wa_date").val(), 
                wa_str : $("#wa_str").val(),
                wa_hydrau : $("#wa_hydrau").val(),
                wa_hydrau_autre : $("#wa_hydrau_autre").val(),
                wa_com : $("#wa_com").val(),
                wa_enherb : $("#wa_enherb").val(),
                wa_plant : $("#wa_plant").val(),
                wa_haie : $("#wa_haie").val(),
                wa_clot : $("#wa_clot").val(),
                wa_abreuv : $("#wa_abreuv").val(),
                wa_bati : $("#wa_bati").val(),
                wa_comt : $("#wa_comt").val()
                },
            async    : true,
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            dataType : "text",
            success: function(data) {
            }
        });
}
function save_wc() {
    var wc_ar = '';
    $.each($("input[grp='wc_obj']:checked"), function(){
        wc_ar+=$(this).attr('descr')+'|';
        console.log("c");
    });
    
        $.ajax({
            type : 'POST',
            url: "php/ajax/save_form/save_wc.js.php",
            data: {
                wc_loc_id_plus : mare_selected_str,
                wc_date : $("#wc_date").val(), 
                wc_str : $("#wc_str").val(),
                wc_comt : $("#wc_comt").val(),
                wc_obj : wc_ar
                },
            async    : true,
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            dataType : "text",
            success: function(data) {
            }
        });
}


$(document).on('focus',"#loc_date", function(){
    $(this).datetimepicker({
    format : "DD-MM-YYYY",
    locale: 'fr'
    });
});
$(document).on('focus',"#car_date", function(){
    $(this).datetimepicker({
    format : "DD-MM-YYYY",
    locale: 'fr'
    });
});
$(document).on('focus',"#esp_date", function(){
    $(this).datetimepicker({
    format : "DD-MM-YYYY",
    locale: 'fr'
    });
});
$(document).on('focus',"#wr_date", function(){
    $(this).datetimepicker({
    format : "DD-MM-YYYY",
    locale: 'fr'
    });
});
$(document).on('focus',"#wa_date", function(){
    $(this).datetimepicker({
    format : "DD-MM-YYYY",
    locale: 'fr'
    });
});
$(document).on('focus',"#wc_date", function(){
    $(this).datetimepicker({
    format : "DD-MM-YYYY",
    locale: 'fr'
    });
});



    $( "#taxon_autocomplete" ).autocomplete({
      //source: availableTags,
      source: function( request, response ) {
        $.ajax( {
          method   : "POST",
          url: "php/ajax/search_autocomplete_taxref.js.php",
          dataType : "json",
          data: {
            term: request.term
          },
          beforeSend: function(){
            $("#loader_modal_esp").toggleClass("visible_s");
          },
          success: function( data ) 
          {
            var JSON_values_completed_taxref = [];
            $.each(data, function (index, value) {
                value_t                     = value.split("\t");
                var nom_complet             = value_t[0];
                var nom_vern                = value_t[1];
                var cd_nom                  = value_t[2];
                 JSON_values_completed_taxref.push({
                    label: cd_nom + ' - ' + nom_complet+ ' - ' + nom_vern,
                    value: cd_nom + ' - ' + nom_complet+ ' - ' + nom_vern
                });
            })
            response(JSON_values_completed_taxref);
            $("#loader_modal_esp").toggleClass("visible_s");
          }
        } );
      },
      minLength : 5,
      select: function AutoCompleteSelectHandler(event, ui)
        {
            var sObj = ui.item;
        },
        appendTo : ".eventInsForm"
    });

        $( "#wr_taxon_autocomplete" ).autocomplete({
      source: function( request, response ) {
        $.ajax( {
          method   : "POST",
          url: "php/ajax/search_autocomplete_taxref.js.php",
          dataType : "json",
          data: {
            term: request.term
          },
          beforeSend: function(){
            $("#loader_modal_travaux").toggleClass("visible_s");
          },
          success: function( data ) 
          {
            var JSON_values_completed_wr_taxref = [];
            $.each(data, function (index, value) {
                value_t                     = value.split("\t");
                var nom_complet             = value_t[0];
                var nom_vern                = value_t[1];
                var cd_nom                  = value_t[2];
                 JSON_values_completed_wr_taxref.push({
                    label: cd_nom + ' - ' + nom_complet+ ' - ' + nom_vern,
                    value: cd_nom + ' - ' + nom_complet+ ' - ' + nom_vern
                });
            })
            response(JSON_values_completed_wr_taxref);
            $("#loader_modal_travaux").toggleClass("visible_s");
          }
        } );
      },
      minLength : 5,
      select: function AutoCompleteSelectHandler(event, ui)
        { 
            var sObj = ui.item;
        },
        appendTo : ".eventInsMod"
    });



function display_mares_in_area(id, table_name) {
    var array_mares=[];
    $.ajax({
        url      : "php/ajax/load_mares_in_area.js.php",
        data     : {id: id, table_name: table_name},
        method   : "POST",
        dataType : "json",
        async    : true,
        error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
        success  : function(data) {
            mares.clearLayers();
            my_mares.clearLayers();
            var count_loc = 0;
            //$(data.features).each(function(key, value) {
                if (data.features != null) {
                    $(data.features).each(function(key, value) {
                        mares.addData(data.features[key]);
                        my_mares.addData(data.features[key]);
                        var id2= data.features[key].properties.loc_id_plus.replace('+','');
                        $('#a_'+id2).click(function () {
                        });
                        count_loc += 1;
                        //add_mare_in_datatable(data.features[key].properties.loc_id_plus, data.features[key].properties.loc_statut)
                            var id_ = data.features[key].properties.loc_id_plus;
                            var statut_ = data.features[key].properties.loc_statut;
                        //add_mare_in_datatable(id_,statut_);
                    });
                }
            //mares.addData(data);
            //});
            
            
            
            
            
            //session storage
            sessionStorage.setItem('mares', JSON.stringify(data.features));
            sessionStorage.setItem('my_mares', JSON.stringify(data.features));
            sessionStorage.setItem('id_search', id);
            sessionStorage.setItem('table_name_search', table_name);
            sessionStorage.setItem('entity_name', $("#layers_autocomplete").val().split(' - ')[1]);
            //USELESS
            //$('#nb_mares_loc').text(count_loc+' mares localisées');
            
            // TO HEAVY TO LOAD
            //cl_();
        }
    });// End ajax
}

$("#close_on").click( function (){
    $("#screen_grey").trigger('click');
});


function delete_last_car(str) {
    return str.substring(0, str.length-1);
}
//function add_layers_in_list (layer_name,table_name_,text_display) {
//    //console.log(layer_name+table_name_+text_display);
//    //var elem = $("#liste_layer_reference option").length;
//    //$("#liste_layer_reference").append($('<option>', {id:"f_"+elem, value:text_display, table_name:table_name_}));
//    //$("#f_"+elem).text(text_display);
//    $("#define_semi").trigger('click');
//    map.addControl(drawControl);
//}





function load_loc_edit(loc_id_plus) {
    update = true;
    $("#text_update").text(' --> Modification de la mare '+loc_id_plus);
    $("#save_loc").text('Enregistrer les modifications');
    remove_layers_for_other();
    //Charge les données enregistrée :
    //console.log(mare_p_active.properties);
    $('#loc_y').val(mare_p_active.properties.loc_y);
    $('#loc_x').val(mare_p_active.properties.loc_x);
    $('#loc_date').val(mare_p_active.properties.loc_date);
    $('#loc_statut').val(mare_p_active.properties.loc_statut);
    $('#loc_nom').val(mare_p_active.properties.loc_nom);
    $('#loc_type_propriete').val(mare_p_active.properties.loc_type_propriete);
    $('#loc_comt').text(mare_p_active.properties.loc_comt);
    update=true;
    if (($('#modalLoc').hasClass('show')) === false ) {$('#modalLoc').modal('show');};
    //$("#save_loc").val('Enregistrer les modifications');
    
    map.closePopup();
}






function fill_checkboxes (string_pipe,field_form) {
    if ((string_pipe !== '')&&(typeof string_pipe !== "undefined")) {
        if (string_pipe.indexOf("|") >= 0) {
            string_pipe.split('|').forEach(function(element) {
                $('input[type=checkbox][value="'+element+'"][name="'+field_form+'"]').attr('checked',true);
            });
        }
    }
}

function load_fiche_mare() {
    id_car = $("#select_car").children("option:selected").attr("id");
    $.ajax({
        url      : "php/fiche_mare.php",
        data     : {id_car_: id_car},
        method   : "POST",
        dataType : "text",
        async    : false,
        error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
        success  : function(data) {
                window.open('pdf/'+data, '_blank');
        }
    });
};
function load_w_pdf() {
    var mare_ = $("#select_tra").children("option:selected").attr("id");
    var type_= mare_.split("_")[0];
    var id_= mare_.split("_")[1];
    console.log(type_);
    switch(type_) {
        case "wa":
            $.ajax({
                url      : "php/fiche_mare_wa.php",
                data     : {type_w: type_, id_:id_},
                method   : "POST",
                dataType : "text",
                async    : false,
                error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
                success  : function(data) {
                        window.open('pdf/'+data, '_blank');
                        //console.log(data);
                }
            });
            break;
        case "wc":
            $.ajax({
                url      : "php/fiche_mare_wc.php",
                data     : {type_w: type_, id_:id_},
                method   : "POST",
                dataType : "text",
                async    : false,
                error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
                success  : function(data) {
                        window.open('pdf/'+data, '_blank');
                        //console.log(data);
                }
            });
            break;
        case "wr":
            $.ajax({
                url      : "php/fiche_mare_wr.php",
                data     : {type_w: type_, id_:id_},
                method   : "POST",
                dataType : "text",
                async    : false,
                error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
                success  : function(data) {
                        window.open('pdf/'+data, '_blank');
                        //console.log(data);
                }
            });
            break;
        default :
            console.log("nope");
            break;
    }
    
    
};

function load_fiche_mare_localisation() {
    var id_mare__ = $("#mares_autocomplete").val();
    var marker = L.marker([mare_p_active.geometry.coordinates[1],mare_p_active.geometry.coordinates[0]]).addTo(map);
    map.setView(new L.LatLng(mare_p_active.geometry.coordinates[1],mare_p_active.geometry.coordinates[0]),17);
    map.closePopup();
    //Clic on the basemap
    //$('.leaflet-control-layers-selector')[3].click();
    leafletImage(map, function(err, canvas) {
    // now you have canvas
    // example thing to do with that canvas:
    var img = document.createElement('img');
    img.setAttribute("id","image2send");
    var dimensions = map.getSize();
    img.width = dimensions.x;
    img.height = dimensions.y;
    img.src = canvas.toDataURL('image/png', 0.5);
    document.getElementById('images_out').innerHTML = '';
    document.getElementById('images_out').appendChild(img);
    //setTimeout(function() {
        $.ajax({
            url      : "php/fiche_mare_localisation.php",
            data     : {id__: id_mare__, image_src: $("#image2send").attr("src")},
            method   : "POST",
            dataType : "text",
            async    : false,
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            success  : function(data) {
                    //console.log(data);
                    window.open('pdf/'+data, '_blank');
                    map.removeLayer(marker);
            }
        });
    });
};

function load_car_edit() {
    console.log("load_car_edit()");
    update = true;
    $("#modalCar").modal();
    id_car = $("#select_car").children("option:selected").attr("id");
    //form_display(form_car_content,false);
    $("#add_car_id_form").text('ID mare : '+$('#mares_autocomplete').val());
    //caracterisation_events();
    $("#car_id_update").text("ID caracterisation : "+id_car);
    //Charge les données enregistrée :
    $.ajax({
                url      : "php/ajax/load_car_mare.js.php",
                data     : {id_mare_car:id_car},
                method   : "POST",
                async    : true,
                datatype : "JSON",
                error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
                success  : function(data) {
                    e = JSON.parse(data);
                    var loc_id_plus             = e.loc_id_plus            ; //console.log(loc_id_plus            );
                    var car_date                = e.car_date               ; //console.log(car_date               );
                    var car_type                = e.car_type               ; //console.log(car_type               );
                    var grp_faune               = e.car_faune              ; //console.log(grp_faune              );//
                    var grp_faune_autre         = e.grp_faune_autre        ; //console.log(grp_faune_autre        );//
                    var car_veget               = e.car_veget              ; //console.log(car_veget              );
                    var car_stade               = e.car_evolution          ; //console.log(car_stade              );//
                    var car_usages              = e.car_usage              ; //console.log(car_usages             );//
                    var car_pompe               = e.car_abreuv             ; //console.log(car_pompe              );//
                    var car_dechets             = e.car_dechet             ; //console.log(car_dechets            );//
                    var car_topo                = e.car_topo               ; //console.log(car_topo               );
                    var car_topo_autre          = e.car_topo_autre         ; //console.log(car_topo_autre         );
                    var car_contextes           = e.car_contexte           ; //console.log(car_contextes          );//
                    var car_patrimoine          = e.car_patrimoine         ; //console.log(car_patrimoine         );
                    var car_patrimoine_autre    = e.car_patrimoine_autre   ; //console.log(car_patrimoine_autre   );
                    var car_cloture             = e.car_cloture            ; //console.log(car_cloture            );
                    var car_haie                = e.car_haie               ; //console.log(car_haie               );
                    var car_forme               = e.car_form               ; //console.log(car_forme              );//
                    var car_long                = e.car_long               ; //console.log(car_long               );
                    var car_larg                = e.car_larg               ; //console.log(car_larg               );
                    var car_hauteur             = e.car_prof               ; //console.log(car_hauteur            );//
                    var car_fond                = e.car_natfond            ; //console.log(car_fond               );//
                    var car_fond_autre          = e.car_natfond_autre      ; //console.log(car_fond_autre         );//
                    var car_berges              = e.car_berges             ; //console.log(car_berges             );
                    var car_bourrelet           = e.car_bourrelet          ; //console.log(car_bourrelet          );
                    var car_bourrelet_prct      = e.car_bourrelet_prct     ; //console.log(car_bourrelet_prct     );//
                    var car_surpietinement      = e.car_pietinement        ; //console.log(car_surpietinement     );//
                    var car_hydrologie          = e.car_hydrologie         ; //console.log(car_hydrologie         );
                    var car_liaisons            = e.car_liaison            ; //console.log(car_liaisons           );//
                    var car_liaisons_autre      = e.car_liaisons_autre     ; //console.log(car_liaisons_autre     );//
                    var car_alimentations       = e.car_alimentation       ; //console.log(car_alimentations      );//
                    var car_alimentations_autre = e.car_alimentations_autre; //console.log(car_alimentations_autre);//
                    var car_turbidite           = e.car_turbidite          ; //console.log(car_turbidite          );
                    var car_couleur             = e.car_couleur            ; //console.log(car_couleur            );
                    var car_couleur_autre       = e.car_couleur_autre      ; //console.log(car_couleur_autre      );
                    var car_tampon              = e.car_tampon             ; //console.log(car_tampon             );
                    var car_exutoire            = e.car_exutoire           ; //console.log(car_exutoire           );
                    var rec_total               = e.rec_total              ; //console.log(rec_total              );
                    var c_recou_helophyte       = e.car_recou_helophyte    ; //console.log(c_recou_helophyte      );
                    var c_recou_hydrophyte_e    = e.car_recou_hydrophyte_e ; //console.log(c_recou_hydrophyte_e   );
                    var c_recou_hydrophyte_ne   = e.car_recou_hydrophyte_ne; //console.log(c_recou_hydrophyte_ne  );
                    var c_recou_algue           = e.car_recou_algue        ; //console.log(c_recou_algue          );
                    var c_recou_eau_libre       = e.car_recou_eau_libre    ; //console.log(c_recou_eau_libre      );
                    var c_recou_non_veget       = e.car_recou_non_veget    ; //console.log(c_recou_non_veget      );
                    var car_embroussaillement   = e.car_embrous            ; //console.log(car_embroussaillement  );
                    var car_ombrage             = e.car_ombrage            ; //console.log(car_ombrage            );
                    var car_eaee                = e.car_eaee               ; //console.log(car_eaee               );
                    var car_evee                = e.car_evee               ; //console.log(car_evee               );
                    var car_objec_trav          = e.car_objec_trav         ; //console.log(car_objec_trav         );
                    var car_travaux             = e.car_travaux            ; //console.log(car_travaux            );
                    var car_travaux_autre       = e.car_travaux_autre      ; //console.log(car_travaux_autre      );
                    var car_comt                = e.car_comt               ; //console.log(car_comt               );
                    $("#loc_id_plus").val(                      loc_id_plus               );
                    $("#car_date").val(                         car_date               );
                    $("#car_type").val(                         car_type               );
                    fill_checkboxes(grp_faune, "grp_faune");
                    $("#grp_faune_autre").val(                  grp_faune_autre               );
                    $("#car_veget").val(                        car_veget               );
                    //$("#car_stade").val(                        car_stade               );
                    //$("#car_stade").val(                        car_stade               );
                    //car_stade1
                    $('input[type=radio][value="'+car_stade+'"]').attr('checked',true);
                    
                    //$("#car_usages").val(                       car_usages               );
                    fill_checkboxes(car_usages, "car_usages");
                    $("#car_pompe").val(                        car_pompe               );
                    //$("#car_dechets").val(                      car_dechets               );
                    fill_checkboxes(car_dechets, "car_dechets");
                    $("#car_topo").val(                         car_topo               );
                    $("#car_topo_autre").val(                   car_topo_autre               );
                    //$("#car_contextes").val(                    car_contextes               );
                    fill_checkboxes(car_contextes, "car_contextes");
                    //$("#car_patrimoine").val(                   car_patrimoine               );
                    fill_checkboxes(car_patrimoine, "car_patrimoine");
                    $("#car_patrimoine_autre").val(             car_patrimoine_autre               );
                    $("#car_cloture").val(                      car_cloture               );
                    $("#car_haie").val(                         car_haie               );
                    $("#car_forme").val(                        car_forme               );
                    $("#car_long").val(                         car_long               );
                    $("#car_larg").val(                         car_larg               );
                    $("#car_hauteur").val(                      car_hauteur               );
                    $("#car_fond").val(                         car_fond               );
                    $("#car_fond_autre").val(                   car_fond_autre               );
                    $("#car_berges").val(                       car_berges               );
                    $("#car_bourrelet_cx").val(                    car_bourrelet               );
                    $("#car_bourrelet_prct").val(               car_bourrelet_prct               );
                    $("#car_surpietinement").val(               car_surpietinement               );
                    $("#car_hydrologie").val(                   car_hydrologie               );
                    //$("#car_liaisons").val(                     car_liaisons               );
                    fill_checkboxes(car_liaisons, "car_liaisons");
                    $("#car_liaisons_autre").val(               car_liaisons_autre               );
                    //$("#car_alimentations").val(                car_alimentations               );
                    fill_checkboxes(car_alimentations, "car_alimentations");
                    $("#car_alimentations_autre").val(          car_alimentations_autre);
                    $("#car_turbidite").val(                    car_turbidite                );
                    $("#car_couleur").val(                      car_couleur                );
                    $("#car_couleur_autre").val(                car_couleur_autre                );
                    $("#car_tampon").val(                       car_tampon                );
                    $("#car_exutoire").val(                     car_exutoire                );
                    $("#rec_total").val(                        rec_total                );
                    $("#c_recou_helophyte").val(                c_recou_helophyte                );
                    $("#c_recou_hydrophyte_e").val(             c_recou_hydrophyte_e                );
                    $("#c_recou_hydrophyte_ne").val(            c_recou_hydrophyte_ne                );
                    $("#c_recou_algue").val(                    c_recou_algue                );
                    $("#c_recou_eau_libre").val(                c_recou_eau_libre                );
                    $("#c_recou_non_veget").val(                c_recou_non_veget                );
                    $("#car_embroussaillement").val(            car_embroussaillement                );
                    $("#car_ombrage").val(                      car_ombrage                );
                    $("#car_eaee").val(                         car_eaee                );
                    if ((car_eaee !=='')&&(car_eaee!=='undefined')) {
                        i_i=0;
                        var hh = car_eaee.split('|');
                        hh.pop();
                        hh.forEach(function(element) {
                            $('#eaee'+i_i).html("<td>"+ (i_i+1) +"</td><td><select id='template_eaee_"+(i_i)+"' class='form-control input-sm' >"+select_eaee_all+"</select></td>");
                            $('#tab_logic_eaee').append('<tr id="eaee'+(i_i+1)+'"></tr>');
                            $('#template_eaee_'+i_i).val(element);
                            console.log(i_i);
                            i_i++;
                        });
                    }
                    $("#car_evee").val(                         car_evee                );
                    if ((car_evee !=='')&&(car_evee!=='undefined')) {
                        j_j=0;
                        var hh = car_evee.split('|');
                        hh.pop();
                        hh.forEach(function(element) {
                            $('#evee'+j_j).html("<td>"+ (j_j+1) +"</td><td><select id='template_evee_"+(j_j)+"' class='form-control input-sm' >"+select_evee_all+"</select></td><td><select id='template_eveeprt_"+(j_j)+"' class='form-control input-sm'><option id='r0'>x<1%</option><option id='r1_"+(j_j)+"'>1-5%</option><option id='r2_"+(j_j)+"'>5-25%</option><option id='r3_"+(j_j)+"'>25-50%</option><option id='r4_"+(j_j)+"'>50-75%</option><option id='r5_"+(j_j)+"'>75-100%</option></select></td>");
                            $('#tab_logic_evee').append('<tr id="evee'+(j_j+1)+'"></tr>');
                            $('#template_evee_'+i_i).val(element.split("__")[0]);
                            $('#template_eveeprt_'+i_i).val(element.split("__")[1]);
                            console.log(j_j);
                            j_j++;
                        });
                    }
                            
                    
                    $("#car_objec_trav").val(                   car_objec_trav                );
                    //$("#car_travaux").val(                      car_travaux                );
                    fill_checkboxes(car_travaux, "car_travaux");
                    $("#car_travaux_autre").val(                car_travaux_autre                );
                    $("#car_comt").val(                         car_comt                );
                    }
    });
    $("#save_car").text('Enregistrer les modifications');
    $("#text_update_car").text('-> modification');
    map.closePopup();
    
    
    
    
    if ($("#grp_faune_cx").is(':checked')){$("#grp_faune_autre").removeClass("d-none")};
    if ($("#car_patrimoine").is(':checked')){$("#car_patrimoine_autre").removeClass("d-none")};
    if ($("#car_liaisons_cx").is(':checked')){$("#car_liaisons_autre").removeClass("d-none")};
    if ($("#car_alimentations_cx").is(':checked')){$("#car_alimentations_autre").removeClass("d-none")};
    if ($("#car_travaux_cx").is(':checked')){$("#car_travaux_autre").removeClass("d-none")};
    if ($("#car_topo").val() == 'autre'){$("#car_topo_autre").removeClass("d-none")};
    if ($("#car_bourrelet_cx").val() == 'Oui'){$("#car_bourrelet_prct").removeClass("d-none")};
    if ($("#car_couleur").val() =='Oui'){$("#car_couleur_autre").removeClass("d-none")};
    
};
//////////END LOAD CAR EDIT

function load_w_edit() {
    var id_w = $("#select_tra").children("option:selected").attr("id").split("_")[1];
    var type_w = $("#select_tra").children("option:selected").attr("id").split("_")[0];
    $("#ModalTravaux").modal();
    switch (type_w) {
        case "wa" :
        case "wr" :
        case "wc" :
            var x = "1";
            fill_checkboxes(wc_obj, "wc_obj");
        
    }
}

//Affiche le formulaire pour charger une photo
//$("#add_photo").click( function () {
//    console.log(mare_selected_str);
//    remove_layers_for_other();
//    if (mare_selected_str == '') {
//        alert('Selectionnez/cliquez sur une mare pour ajouter une photo');
//    } else {
//        form_display(form_photo,false);
//        
//        photo_events();
//    }
//});



//Affiche le formulaire pour definir un semi
$("#define_semi").click( function () {
    //remove_layers_for_analyse();

    $('#modalDefineSemi').modal();
    //clear_all_layer();
    //remove_layers_for_semi();
    //
    ////if (($('#modalAnalyse').hasClass('show')) === false ) {$('#modalAnalyse').modal('show');};
    //
    //map.closePopup();
    //
    ////-----------------------------------------------------------------
    //// Chargement des zones specifiques defini par l'utilisateur
    ////-----------------------------------------------------------------
    $.ajax({
        url      : "php/ajax/analyse/list_zones_specifique_by_user.js.php",
        data     : {},
        method   : "POST",
        dataType : "html",
        async    : true,
        error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
        success  : function(data) {
            $("#liste_layer_reference").append(data);
            }
    });
    
});

//Affiche le formulaire pour definir un semi
$("#valid_android").click( function () {
    $('#modalOdk').modal();
    var odkI =0;
    ////-----------------------------------------------------------------
    //// Chargement des formulaires ODK de l'utilisateur
    ////-----------------------------------------------------------------
    $.ajax({
        url      : "php/ajax/odk/odk_forms.js.php",
        data     : {},
        method   : "POST",
        dataType : "json",
        async    : true,
        error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
        success  : function(data) {
                console.log(data);
                if (data.features != null) {
                    $(data.features).each(function(key, value) {
                        $('#odkz').append(
                        `
                        <div class="d-flex">
                            <div id="odkform_`+odkI.toString()+`" class=" border odk_img_overlay_bg d-flex w-100 my-2" lat="`+data.features[key].properties.lat+`" lng="`+data.features[key].properties.lng+`" id_form=`+data.features[key].properties.uuid_core+` >
                                <div class="d-flex justify-content-center w-50" >
                                    <img class="m-auto" src="img/photos/odk_photos/`+data.features[key].properties.photo_id+`" style="max-width:150px;max-height:150px;" alt="Mare à importer">
                                </div>
                                <div class="d-flex w-50">
                                    <div class="d-flex flex-column ml-1">
                                        <div class="mb-4">
                                            <h6 class="mt-2 text-muted">`+data.features[key].properties.formulaire+`</h6>
                                            <div class="text-warning small">`+data.features[key].properties.date_form+`</div>
                                            <div class="text-danger small">`+data.features[key].properties.id_user+`</div>
                                        </div>
                                        <div id="import_odk|`+data.features[key].properties.uuid_core+`" class="btn btn-secondary btn-sm mt-auto mx-2">Importer</div>
                                        <div id="cancel_import_odk|`+data.features[key].properties.uuid_core+`" class="btn btn-danger btn-sm mt-2 mb-1 mx-4">Supprimer</div>
                                    </div>
                                </div>
                            </div>
                        </div>`);
                        odkI++;
                    });
                    add_hover_odkform_event();
                } else {
                    $('#odkz').append(`<div class="alert alert-info">
                    <strong>Désolé!</strong> Il n'y a pas de formulaire en attente de validation.
                    </div>`);
                }
        }
    });// End ajax
    
    
});
function add_hover_odkform_event() {
    $('[id^=odkform_]').mouseenter(function() {
        marker = L.marker([$(this).attr( 'lat' ),$(this).attr( 'lng' )]).addTo(map);
        map.setView(new L.LatLng($(this).attr( 'lat' ),$(this).attr( 'lng' )),12);
    }).mouseleave(function() {
        map.removeLayer(marker);
    });
    $('[id^=import_odk]').click(function() {
        ///////////////////////////////////////////////////
        ///////////////////////////////////////////////////
        //VALIDER LE FORMULAIRE ODK
        ///////////////////////////////////////////////////
        ///////////////////////////////////////////////////
        console.log('IMPORT'+ $(this).attr('id').split('|')[1]);
    });
    $('[id^=cancel_import_odk]').click(function() {
        ///////////////////////////////////////////////////
        ///////////////////////////////////////////////////
        //Supprimer LE FORMULAIRE ODK
        ///////////////////////////////////////////////////
        ///////////////////////////////////////////////////
        console.log('CANCEL'+ $(this).attr('id').split('|')[1]);
    });
}


//Affiche le formulaire pour lancer une analyse
$("#analyse_semi").click( function () {
    //form_display(form_analyse_semi,true);
    $('#modalAnalyse').modal();
    $("#liste_semi_analyses").html('');
    analyse_semi_events();
    
});


//Affiche le formulaire de liste des photos
$(document).on('click','#photoz_link', function(){
    //form_display(form_list_photos,false);
    $('#modalPhotoContent').modal();
});

$("#export_mares_shapefile").click( function () { 
    if (!!sessionStorage.getItem('id_search')) {
        if ((Object.keys(my_mares._layers).length > 0) || (Object.keys(mares._layers).length > 0)) {
            var admin_id = sessionStorage.getItem('id_search');
            var admin_table_name = sessionStorage.getItem('table_name_search');
            $.ajax({
                type : 'POST',
                url: "php/ajax/export_mares_shapefile.js.php",
                data: {table_name_search : sessionStorage.getItem('table_name_search'), id_search : sessionStorage.getItem('id_search')},
                async    : false,
                error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
                dataType : "text",
                success: function( file_name_ ) {
                                console.log(file_name_);
                                window.location = '/'+cur_dir+'/php/shapefile_out/'+file_name_;
                                delete_file(absolute_path+cur_dir+'/php/shapefile_out/'+file_name_);
                            }
            });
            
        } else {
            alert("Aucune mare n'est présente dans la zone...\nSélectionnez un autre découpage administratif...")
        }
    } else {
        alert("Sélectionnez un découpage administratif");
    }
});

$("#export_mares_excel").click( function () { 
    if (!!sessionStorage.getItem('id_search')) {
        if(Object.keys(mares._layers).length > 0) {
            var admin_id = sessionStorage.getItem('id_search');
            var admin_table_name = sessionStorage.getItem('table_name_search');
            $.ajax({
            method   : "POST",
            //url: "php/ajax/export_data_"+layer+".js.php",
            url: "php/ajax/export_mares_excel.js.php",
            async    : false,
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            dataType : "text",
            data: {table_name_search : sessionStorage.getItem('table_name_search'), id_search : sessionStorage.getItem('id_search')},
            success: function( file_name_ ) {
                            console.log(file_name_);
                            window.location = '/'+cur_dir+'/php/excel/'+file_name_;
                            delete_file(absolute_path+cur_dir+'/php/excel/'+file_name_);
                        }
           });
            
        } else {
            alert("Aucune mare n'est présente dans la zone...\nSélectionnez un autre découpage administratif...")
        }
    } else {
        alert("Sélectionnez un découpage administratif");
    }
});






function display_photo_blob(id) {
    // on local desktop
            var id_ = id;
            var photo_link='';
            $.ajax({
                url      : "php/ajax/load_liste_photoz.js.php",
                data     : {id_mare:id_},
                method   : "POST",
                async    : false,
                error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
                success  : function(data) {
                    photo_link = data;
                    }
            });
            return photo_link;
        }

function map_up (bool,state) {
    if (bool) {
        $('#map').css('z-index',1051);
        switch(state) {
            case "localisation":
                loc_plus = true;
                L.DomUtil.addClass(map._container,'crosshair-cursor-enabled');
                break;
            case "analyse":
                break;
            case "odk":
                break;
        }
    } else {
        $('#map').css('z-index',100);
        L.DomUtil.removeClass(map._container,'crosshair-cursor-enabled');
        loc_plus = false;
        mare_added.clearLayers();
    }
}






function delete_file(filepath_name) {
    // Default AJAX request type is GET so no need to define  
    $.ajax({
        url: 'php/delete_file.php',
        method   : "POST",
        data: {'file' : filepath_name },
        dataType: 'json', 
        success: function (response) {
            if( response.status === true ) {
                console.log('File Deleted!');
            }
            else console.log('Something Went Wrong!');
        }
        });
}



//-----------------------------------------------------------------
//LIMIT CONTEXTE TO 2 VALUES
//-----------------------------------------------------------------
var limit = 3;
$("input.contexte:checkbox").on('change', function(e) {
    console.log('change'+$("input.contexte:checkbox:checked").length);
   if($("input.contexte:checkbox:checked").length >= limit) {
       this.checked = false;
   }
});


//-----------------------------------------------------------------
// GET EAEE AND EVEE LISTS TO POPULATE SELECT
//-----------------------------------------------------------------
function liste_evee_eaee_full () {
select_eaee_all = '';
select_evee_all = '';
$('#template_eaee_0').find('option').remove().end();
$('#template_evee_0').find('option').remove().end();
$.ajax({
    url      : "php/ajax/load_liste_eee_full.js.php",
    data     : {},
    method   : "POST",
    dataType : "text",
    async    : true,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
            var values = data.split('|');
            values.pop();
            values.forEach(function(item)  {
                var id_     = item.split("__")[0];
                var name_   = item.split("__")[1];
                var type_   = item.split("__")[2];
                if (type_ == "eaee") {
                    select_eaee_all += '<option id="list_eaee_'+id_+'">'+name_+'</option>';
                    //$('#template_eaee_0').append('<option id="list_eaee_'+id_+'">'+name_+'</option>');
                } else {
                    select_evee_all += '<option id="list_evee_'+id_+'">'+name_+'</option>';
                    //$('#template_evee_0').append('<option id="list_evee_'+id_+'">'+name_+'</option>');
                }
            });
    }
});
}



//-----------------------------------------------------------------
// MODAL ESPECES
//-----------------------------------------------------------------
function e_events() {
    $('[id^="temp_esp"]').each(function() {esp_str+=$(this).val()+'|';});
    $("#add_row_esp").css("border","1px solid grey");
    $("#delete_row_esp").css("border","1px solid grey");
    $("#add_row_esp").click(function(){
        //$('#esp'+e_e).html("<td>"+ (e_e+1) +"</td><td><span id='temp_esp"+(e_e)+"' class='small' >"+$("#taxon_autocomplete").val().split(" - ")[1]+"</span></td>"+"<td >"+$("#esp_date").val()+"</td>"+"<td >"+$("#esp_effectif").val()+"</td>");
        //$('#ola_dt').append('<tr id="esp'+(e_e+1)+'"></tr>');
        //e_e++;
        //DATATABLES
        var id = e_e;
        var taxon = $("#taxon_autocomplete").val().split(" - ")[1]|| "";
        var date_o = $("#esp_date").val()|| "";
        var effe = $("#esp_effectif").val()|| "";
        var obsv = $("#mail_user").text()|| "";
        var comt = $("#esp_comt").val()|| "";
        
        var rowNode = dt4.row.add( [
            id,
            taxon,
            date_o,
            effe,
            obsv,
            comt
        ] ).draw( true ).node();
        $(rowNode).attr("id", e_e);
        e_e++;
    });
    $("#delete_row_esp").click(function(){
        if(e_e>=1){
        //$("#esp"+(e_e-1)).html('');
        dt4.row(e_e-1).remove().draw();
        e_e--;
        }
    });
}
//-----------------------------------------------------------------
// MODAL ESPECES INTRODUITE
//-----------------------------------------------------------------
function ei_events() {
    $('[id^="temp_eisp"]').each(function() {eisp_str+=$(this).val()+'|';});
    $("#add_row_eisp").click(function(){
        //DATATABLES
        var id = ei_e;
        var taxon = $("#wr_taxon_autocomplete").val().split(" - ")[1]|| "";
        var rowNode = dt5.row.add( [
            id,
            taxon
        ] ).draw( true ).node();
        $(rowNode).attr("id", ei_e);
        ei_e++;
    });
    $("#delete_row_eisp").click(function(){
        if(ei_e>=1){
        //$("#esp"+(e_e-1)).html('');
        dt5.row(ei_e-1).remove().draw();
        ei_e--;
        }
    });
}

//-----------------------------------------------------------------
// ADD / EVENT ON CARACTERISATION CLICK
//-----------------------------------------------------------------
    //EAEE / EVEE
    //var i=0+i_i;
    //var j=0+j_j;
    $("#add_row_eaee").css("border","1px solid grey");
    $("#delete_row_eaee").css("border","1px solid grey");
    $("#add_row_evee").css("border","1px solid grey");
    $("#delete_row_evee").css("border","1px solid grey");
    //<select id="template_eaee_" 1="" class="form-control input-sm" '=""></select>
    $("#add_row_eaee").click(function(){
        $('#eaee'+i_i).html("<td>"+ (i_i+1) +"</td><td><select id='template_eaee_"+(i_i)+"' class='custom-select custom-select' >"+select_eaee_all+"</select></td>");
        $('#tab_logic_eaee').append('<tr id="eaee'+(i_i+1)+'"></tr>');
        i_i++;
    });
    $("#delete_row_eaee").click(function(){
        if(i_i>=1){
        $("#eaee"+(i_i-1)).html('');
        i_i--;
        }
    });
    $("#add_row_evee").click(function(){
        console.log("add");
        $('#evee'+j_j).html("<td>"+ (j_j+1) +"</td><td><select id='template_evee_"+(j_j)+"' class='custom-select custom-select' >"+select_evee_all+"</select></td><td><select id='template_eveeprt_"+(j_j)+"' class='custom-select custom-select'><option id='r0'>x<1%</option><option id='r1_"+(j_j)+"'>1-5%</option><option id='r2_"+(j_j)+"'>5-25%</option><option id='r3_"+(j_j)+"'>25-50%</option><option id='r4_"+(j_j)+"'>50-75%</option><option id='r5_"+(j_j)+"'>75-100%</option></select></td>");
        $('#tab_logic_evee').append('<tr id="evee'+(j_j+1)+'"></tr>');
        console.log(j_j);
        j_j++;
    });
    $("#delete_row_evee").click(function(){
        if(j_j>=1){
        $("#evee"+(j_j-1)).html('');
        j_j--;
        }
    });
    
    //calcul in form
    $('#c_recou_helophyte').change(function() {maj_total_recouvrement();});
    $('#c_recou_hydrophyte_e').change(function() {maj_total_recouvrement();});
    $('#c_recou_hydrophyte_ne').change(function() {maj_total_recouvrement();});
    $('#c_recou_algue').change(function() {maj_total_recouvrement();});
    $('#c_recou_eau_libre').change(function() {maj_total_recouvrement();});
    $('#c_recou_non_veget').change(function() {maj_total_recouvrement();});
    
    var limit = 3;
    $('.contexte').on('change', function() {
        if($('.contexte:checked').length >= limit) {
            this.checked = false;
        }
    });
    //CHECKBOXES
    $("#grp_faune_cx").change(function() {
        $("#grp_faune_autre").toggleClass("d-none");
    });
    $("#car_patrimoine").change(function() {
        $("#car_patrimoine_autre").toggleClass("d-none");
        $("#car_patrimoine_autre").val('');
    });
    $("#car_liaisons_cx").change(function() {
        $("#car_liaisons_autre").toggleClass("d-none");
        $("#car_liaisons_autre").val('');
    });
    $("#car_alimentations_cx").change(function() {
        $("#car_alimentations_autre").toggleClass("d-none");
        $("#car_alimentations_autre").val('');
    });
    $("#car_travaux_cx").change(function() {
        $("#car_travaux_autre").toggleClass("d-none");
        $("#car_travaux_autre").val('');
    });
    $("#car_topo").change(function() {
        if($("#car_topo").val() == "autre") {
            $("#car_topo_autre").removeClass("d-none");
        } else {
            $("#car_topo_autre").addClass("d-none");
            $("#car_topo_autre").val('');
        }
    });
    $("#car_bourrelet_cx").change(function() {
        if($("#car_bourrelet_cx").val() == "Oui") {
            $("#car_bourrelet_prct").removeClass("d-none");
        } else {
            $("#car_bourrelet_prct").addClass("d-none");
            $("#car_bourrelet_prct").val('');
        }
    });
    $("#car_couleur").change(function() {
        if($("#car_couleur").val() == "Oui") {
            $("#car_couleur_autre").removeClass("d-none");
        } else {
            $("#car_couleur_autre").addClass("d-none");
            $("#car_couleur_autre").val('');
        }
    });
    //SELECT
    $("#car_fond").change(function() {
        if($("#car_fond").val() == "Autre") {
            $("#car_fond_autre").removeClass("d-none");
        } else {
            $("#car_fond_autre").addClass("d-none");
            $("#car_fond_autre").val('');
        }
    })
    
    



//-----------------------------------------------------------------
// ADD / EVENT ON LOCALISATION CLICK
//-----------------------------------------------------------------
//function localisation_events() {
//    console.log('localisation_events_loaded');
//    $("#save_loc").on('click', function() {
//    if (update) {
//        var id = mare_p_active.properties.loc_id_plus;
//        var x = $("#loc_x").val();
//        var y = $("#loc_y").val();
//        var loc_date = $("#loc_date").val();
//        if (( x != '') && (y != '') && ( loc_date != '')) {
//            var loc_nom             = $("#loc_nom").val();
//            var loc_type_propriete  = $("#loc_type_propriete option:selected").text();
//            var loc_statut          = $("#loc_statut option:selected").text();
//            var loc_comment         = $("#loc_comment").val();
//            var loc_anonymiser      = true;
//            $.ajax({
//                method   : "POST",
//                url: "php/ajax/save_form/localisation_update.js.php",
//                dataType : "text",
//                async : false,
//                data: {
//                    id:id,
//                    x: x,
//                    y: y, 
//                    loc_nom: loc_nom, 
//                    loc_type_propriete: loc_type_propriete, 
//                    loc_statut: loc_statut, 
//                    loc_date: loc_date, 
//                    loc_comt: loc_comment, 
//                    loc_anonymiser: loc_anonymiser
//                },
//                success: function( data ) {
//                    //console.log(data);
//                    if (data) {
//                        alert("Modification de localisation enregistrée !"); $("#screen_grey").trigger('click'); update=false;
//                    }
//                }
//            });
//        };
//    }else {
//        var x = $("#loc_x").val();
//        var y = $("#loc_y").val();
//        var loc_date = $("#loc_date").val();
//        if (( x != '') && (y != '') && ( loc_date != '')) {
//            var loc_nom             = $("#loc_nom").val();
//            var loc_type_propriete  = $("#loc_type_propriete option:selected").text();
//            var loc_statut          = $("#loc_statut option:selected").text();
//            var loc_comment         = $("#loc_comment").val();
//            var loc_anonymiser      = true;
//            $.ajax({
//                method   : "POST",
//                url: "php/ajax/save_form/localisation.js.php",
//                dataType : "json",
//                async : false,
//                data: {
//                    x: x,
//                    y: y, 
//                    loc_nom: loc_nom, 
//                    loc_type_propriete: loc_type_propriete, 
//                    loc_statut: loc_statut, 
//                    loc_date: loc_date, 
//                    loc_comt: loc_comment, 
//                    loc_anonymiser: loc_anonymiser
//                },
//                success: function( data ) {
//                    if (data) {
//                        alert("localisation enregistrée !"); $("#screen_grey").trigger('click'); update=false;
//                    }
//                }
//            });
//        };
//    }
//    change_load ('Re-Chargement des mares...');
//    display_mares_in_area(sessionStorage.getItem('id_search'), sessionStorage.getItem('table_name_search'));
//    });
//};
//-----------------------------------------------------------------
// ADD / EVENT ON CARACTERISATION CLICK
//-----------------------------------------------------------------

//-----------------------------------------------------------------
// ADD PHOTO
//-----------------------------------------------------------------





function remove_layers_for_semi() {
    //remove other layers
    admin_geojson_feature.clearLayers();
    map.removeLayer(admin_geojson_feature);
    semi_geojson_selected.clearLayers();
    map.addLayer(semi_geojson_selected);
    semi_geojson.clearLayers();
    map.addLayer(semi_geojson);
    mares.clearLayers();
    map.removeLayer(mares);
    my_mares.clearLayers();
    map.removeLayer(my_mares);
    mare_added.clearLayers();
    map.removeLayer(mare_added);
    mare_selected_point.clearLayers();
    map.removeLayer(mare_selected_point);
    mare_analyse.clearLayers();
    map.removeLayer(mare_analyse);
    analyse_fond.clearLayers();
    map.removeLayer(analyse_fond);
}
function remove_layers_for_analyse() {
    //remove other layers
    admin_geojson_feature.clearLayers();
    map.removeLayer(admin_geojson_feature);
    semi_geojson_selected.clearLayers();
    map.removeLayer(semi_geojson_selected);
    semi_geojson.clearLayers();
    map.removeLayer(semi_geojson);
    mares.clearLayers();
    map.removeLayer(mares);
    my_mares.clearLayers();
    map.removeLayer(my_mares);
    mare_added.clearLayers();
    map.removeLayer(mare_added);
    mare_selected_point.clearLayers();
    map.removeLayer(mare_selected_point);
    mare_analyse.clearLayers();
    map.addLayer(mare_analyse);
    analyse_fond.clearLayers();
    map.addLayer(analyse_fond);
}
function remove_layers_for_other() {
    //remove other layers
    //admin_geojson_feature.clearLayers();
    map.addLayer(admin_geojson_feature);
    //semi_geojson_selected.clearLayers();
    map.removeLayer(semi_geojson_selected);
    //semi_geojson.clearLayers();
    map.removeLayer(semi_geojson);
    //mares.clearLayers();
    map.addLayer(mares);
    //my_mares.clearLayers();
    map.addLayer(my_mares);
    //mare_added.clearLayers();
    map.addLayer(mare_added);
    //mare_selected_point.clearLayers();
    map.addLayer(mare_selected_point);
    mare_analyse.clearLayers();
    map.removeLayer(mare_analyse);
    analyse_fond.clearLayers();
    map.removeLayer(analyse_fond);
}


// DEFINE SEMI EVENTS
$("#savedrawnitems").click( function () {
    save_specific_area();
    $("#drawundraw").trigger('click');
    $("#specific_name").val('');
});

dt_composition = $('#composition_dt').DataTable({
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
dom: 'rt',
buttons: [
    'excel', 'pdf'
]
});
$("#drawundraw").click(function () {
    //Drawing items are not visible
    if (drawing == false) {
        map.addControl(drawControl);
        drawing = true;
        $('#drawundraw').text(" - Désactiver le dessin");
        ////Affiche le bouton de sauvegarde du dessin
        $('#send_drawn_items').toggleClass("d-none");
    }
    //Drawing items are visible
    else {
        map.removeControl(drawControl);
        drawing = false;
        $('#drawundraw').text(" + Dessiner une zone");
        ////Cache le bouton de sauvegarde du dessin
        $('#send_drawn_items').toggleClass("d-none");
        drawnItems.clearLayers();
    }
});
//-----------------------------------------------------------------
//selection du fond pour le semi
//-----------------------------------------------------------------
$("#liste_layer_reference").on('change', function() {
    var id = $(this).children(":selected").attr("id");
    var table_name = $(this).children(":selected").attr("table_name");
    var specifik = $(this).children(":selected").attr("value");
    semi_geojson.clearLayers();
    if (table_name != ' null ') {
        switch(table_name) {
        case ' layers.communes ':
            specifik = 'nope';
            break;
        case ' layers.epci ':
            specifik = 'nope';
            // code block
            break;
        default:
            specifik = $(this).children(":selected").attr("id_entity");
            break;
            // code block
        }
        
        ////////////////////////////////////////////////////////////////////////////////////////////////////
        //FROM BDD
        $.ajax({
        url      : "php/ajax/load_semi_geojson_comepci.js.php",
        data     : {table_name: table_name, spec:specifik},
        beforeSend: function(){$("#loader_layers").toggleClass("visible_s");},
        method   : "POST",
        dataType : "json",
        async    : true,
        start    : function () {},
        error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
        success  : function(data) {
            semi_geojson.clearLayers();
            semi_geojson.addData(data);
            map.fitBounds(semi_geojson.getBounds());
            $("#loader_layers").toggleClass("visible_s");
            }
        });
    }
});
//-----------------------------------------------------------------
// Event permettant d'enregistrer le semi en BDD
//-----------------------------------------------------------------
$("#save_semi").click(function () {
    if ($("#name_save_semi").val() != '') {
        var val = $("#name_save_semi").val();
        
        semi_geojson_selected.eachLayer(function(layer) {
            var id=layer.feature.properties.l_id;
            var name=layer.feature.properties.l_nom;
            var table_name=layer.feature.properties.table_name;
            var geom=JSON.stringify(layer.toGeoJSON());
            //console.log(layer.feature.toGeoJSON());
            $.ajax({
                url      : "php/ajax/analyse/save_semi.js.php",
                data     : {id:id,semis:val,name:name,table_name:table_name,geom:geom},
                method   : "POST",
                dataType : "html",
                async    : false,
                error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
                success  : function(data) {
                        //console.log(data);
                    }
            });
        });
        $.ajax({
                url      : "php/ajax/analyse/group_semis.js.php",
                data     : {},
                method   : "POST",
                dataType : "html",
                async    : false,
                error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
                success  : function(data) {
                        //console.log(data);
                        $("#name_save_semi").text();
                        alert("Selection enregistrée");
                        
                    }
        });
        
        
    } else {alert("Le semi doit être nommé!");}
});




//-----------------------------------------------------------------
// ADD / EVENT ON ANALYSE SEMI
//-----------------------------------------------------------------
function analyse_semi_events() {
    console.log('analyse_events_loaded');
    //-----------------------------------------------------------------
    // Chargement des semis defini par l'utilisateur
    //-----------------------------------------------------------------
    $.ajax({
        url      : "php/ajax/analyse/list_semis_by_user.js.php",
        data     : {},
        method   : "POST",
        dataType : "html",
        async    : true,
        error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
        success  : function(data) {
            $("#liste_semi_analyses").append(data);
            }
    });
    //-----------------------------------------------------------------
    // Chargement des analyses defini par l'utilisateur
    //-----------------------------------------------------------------
    $.ajax({
        url      : "php/ajax/analyse/list_analyses_by_user.js.php",
        data     : {},
        method   : "POST",
        dataType : "html",
        async    : true,
        error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
        success  : function(data) {
            $("#liste_old_analyses").append(data);
            }
    });
    //-----------------------------------------------------------------
    //selection du fond pour le semi
    //-----------------------------------------------------------------
    $("#liste_semi_analyses").on('change', function() {
        var id_semis = $(this).children(":selected").attr("id_semis");
        analyse_fond.clearLayers();
        if (id_semis != ' null ') {
            
            $.ajax({
            url      : "php/ajax/analyse/load_semis.js.php",
            data     : {id_semis: id_semis},
            method   : "POST",
            dataType : "json",
            async    : false,
            start    : function () {},
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            success  : function(data) {
                //$(data.features).each(function(key, value) {
                    if (data.features != null) {
                        $(data.features).each(function(key, value) {
                            analyse_fond.addData(data.features[key]);
                        });
                    }
                map.fitBounds(analyse_fond.getBounds());
                }
            });
        }
    });
    //-----------------------------------------------------------------
    //selection du fond pour une ancienne analyse
    //-----------------------------------------------------------------
    $("#liste_old_analyses").on('change', function() {
        var id_analyses = $(this).children(":selected").attr("id_analyses");
        analyse_fond.clearLayers();
        if (id_analyses != ' null ') {
            $.ajax({
            url      : "php/ajax/analyse/load_analyses.js.php",
            data     : {nom_analyse: id_analyses},
            method   : "POST",
            dataType : "json",
            async    : false,
            start    : function () {},
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            success  : function(data) {
                //$(data.features).each(function(key, value) {
                    if (data.features != null) {
                        $(data.features).each(function(key, value) {
                            analyse_fond.addData(data.features[key]);
                        });
                    }
                }
            });
        }
        map.fitBounds(analyse_fond.getBounds());
        $("#analyse_result").removeClass("d-none");
        get_mares($(this).children(":selected").attr("id_semis"),false);
    });
    $("#run_analyse").click(function () {
        //analyse_fond.clearLayers();
        console.log("analyse");
        $("#analyse_result").removeClass("d-none");
        //$(document).scrollTop( $("#analyse_result").offset().top );
        var analyse = $("#nom_analyse").val();
        if (analyse != ('')) {
            get_mares(analyse,true);
        } else {alert("Nommez votre analyse !");}
    });
};





function sansAccent(ost){
    var accent = [
        /[\300-\306]/g, /[\340-\346]/g, // A, a
        /[\310-\313]/g, /[\350-\353]/g, // E, e
        /[\314-\317]/g, /[\354-\357]/g, // I, i
        /[\322-\330]/g, /[\362-\370]/g, // O, o
        /[\331-\334]/g, /[\371-\374]/g, // U, u
        /[\321]/g, /[\361]/g, // N, n
        /[\307]/g, /[\347]/g, // C, c
        
    ];
    var noaccent = ['A','a','E','e','I','i','O','o','U','u','N','n','C','c'];
     
    var str = ost;
    for(var i = 0; i < accent.length; i++){
        str = str.replace(accent[i], noaccent[i]);
    }
    return str;
}



//-----------------------------------------------------------------
// Calcul du recouvrement total
//-----------------------------------------------------------------
function maj_total_recouvrement () {
    var a_1 = parseInt($('#c_recou_helophyte').val());
    var a_2 = parseInt($('#c_recou_hydrophyte_e').val());
    var a_3 = parseInt($('#c_recou_hydrophyte_ne').val());
    var a_4 = parseInt($('#c_recou_algue').val());
    var a_5 = parseInt($('#c_recou_eau_libre').val());
    var a_6 = parseInt($('#c_recou_non_veget').val());
    $('#rec_total').text((a_1+a_2+a_3+a_4+a_5+a_6) + ' %');
}


//-----------------------------------------------------------------
//AUTOCOMPLETE ADMIN
//-----------------------------------------------------------------
$( "#layers_autocomplete" ).autocomplete({
  //source: availableTags,
  source: function( request, response ) {
    $.ajax( {
      method   : "POST",
      url: "php/ajax/load_layers_admin.js.php",
      dataType : "json",
      data: {
        term: request.term
      },
      success: function( data ) {
        var JSON_values_completed = [];
        $.each(data.features, function (index, value) {
            
            //console.log(data.features[0].properties.l_id );
            var id = data.features[index].properties.l_id;
            var nom = data.features[index].properties.l_nom;
            var table_name_ = data.features[index].properties.l_table_name;
             JSON_values_completed.push({
                label: id+ ' - '+nom,
                value: id+ ' - '+nom,
                feature: data.features[index],
                table_name: table_name_
            });
        })
        response(JSON_values_completed);
      }
    } );
  },
  minLength : 3,
  select: function AutoCompleteSelectHandler(event, ui)
    {
        var id_selected = ui.item.value.split(' - ')[0];
        admin_geojson_feature.clearLayers();
        //session storage
        sessionStorage.setItem('admin_', JSON.stringify(ui.item.feature));
        //sessionStorage.setItem('id_search', id_selected);
        //sessionStorage.setItem('table_name_search', ui.item.table_name);
        //sessionStorage.setItem('entity_name', name_selected);
        
        admin_geojson_feature.addData(ui.item.feature);
        map.fitBounds(admin_geojson_feature.getBounds());
        display_mares_in_area(id_selected, ui.item.table_name );
        //
    }
    
});
//-----------------------------------------------------------------
//AUTOCOMPLETE MARE
//-----------------------------------------------------------------
$( "#mares_autocomplete" ).autocomplete({
  source: function( request, response ) {
    $.ajax( {
      method   : "POST",
      url: "php/ajax/load_mare.js.php",
      dataType : "json",
      data: {
        term: request.term
      },
      success: function( data ) {
        var JSON_values_completed = [];
        $.each(data.features, function (index, value) {
            
            //console.log(data.features[0].properties.l_id );
            var loc_id_plus     = data.features[index].properties.loc_id_plus;
            var loc_nom         = data.features[index].properties.loc_nom;
             JSON_values_completed.push({
                label: loc_id_plus,
                value: loc_id_plus,
                feature: data.features[index]
            });
        })
        response(JSON_values_completed);
      }
    } );
  },
  minLength : 5,
  select: function AutoCompleteSelectHandler(event, ui)
    {
        var id_selected = ui.item.value;
        mare_selected_point.clearLayers();
        //session storage
        //sessionStorage.setItem('mare_selected_point', JSON.stringify(ui.item.feature));
        console.log(ui.item.feature);
        mare_selected_point.addData(ui.item.feature);
        mare_selected_str=id_selected;
        map.setView(new L.LatLng(ui.item.feature.geometry.coordinates[1], ui.item.feature.geometry.coordinates[0]),14);
    }
});


//-----------------------------------------------------------------
//GET DATE
//-----------------------------------------------------------------
function date_ () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10) {
        dd = '0'+dd
    }
    if(mm<10) {
        mm = '0'+mm
    }
    today = dd+'-'+mm+'-'+yyyy;
    return today
}







// TOO HEAVY TO LOAD
//var dt = $('#liste_loc_mares').DataTable({
//  "scrollY":        "200px",
//  "scrollCollapse": true,
//  "paging":         false,
//  "language": {
//    "paginate": {
//      "previous": "Préc.",
//      "next": "Suiv."
//    },
//    "search": "Filtrer :",
//    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
//    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
//    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
//    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
//    "sInfoPostFix":    "",
//    "sLoadingRecords": "Chargement en cours...",
//    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
//    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau"
//  },
//  dom: 'frtip',// B --> button
//  buttons: [
//            'excel'
//        ]
//});



// TOO HEAVY TO LOAD
//function cl_() {
//    for (var prop in mares._layers) {
//        //console.log(mares._layers[prop].feature.properties.loc_id_plus);
//        dt.row.add([
//            mares._layers[prop].feature.properties.loc_id_plus,
//            mares._layers[prop].feature.properties.loc_statut
//        ]).draw();
//    }
//}








form_define_semi = '\
<div class="col-lg-12" >\
    <div class="form-group">\
    </div>\
    <div class="col-lg-12">\
        <div class="form-group">\
            <div id="loader_f" class="loader visible_s_f z_indexed">\
                <i class="fa fa-refresh fa-spin"></i>Loading\
            </div>\
        </div>\
    </div>\
    <div class="page-header">\
        <h2>Definir un semi :</h2>\
        <p>Afin de définir géographiquement le semi de mares vous pouvez sélectionnez des entités administratives en cliquant dessus, dessinez vos propres zones ou bien combinez les 2. Une fois que le tableau récapitulatif contient au moins une entité vous pouvez lancer une analyse.</p>\
    </div>\
    <div class="col-lg-5">\
        <div class="form-group">\
            <p>Choisir un contour de référence :</p>\
            <select class="form-control" id="liste_layer_reference">\
                <option id="f_0" table_name=" null " >----</option>\
                <option id="f_1" table_name=" layers.communes_2018 " >Commune</option>\
                <option id="f_2" table_name=" layers.epci_2018 " >EPCI</option>\
        </select>\
        </div>\
    </div>\
    <div class="col-lg-7">\
        <div class="col-lg-12">\
            <div class="form-group">\
                <p>Ou dessiner une zone spécifique</p>\
            </div>\
        </div>\
        <div class="col-lg-12">\
                <div class="form-group">\
                    <div id="drawundraw" type="submit" class="btn_ orange"> + Dessiner une zone</div>\
                </div>\
        </div>\
        <div id="send_drawn_items" class="col-lg-12 d-none">\
            <div class="form-group">\
                <p>Nommez votre Zone Spécifique :</p>\
                <input id="specific_name" class="form-control" placeholder="" onblur="" >\
                <a  id="savedrawnitems" href="javascript:;"><i class="fa fa-fw fa-save"></i> Enregistrer la zone</a>\
            </div>\
        </div>\
    </div>\
    <div class="col-lg-12 form_left_grey form-group">\
    <p>Tableau récapitulatif :</p>\
    <table id="composition_dt" class="table table-striped table-hover"><!-- dt-responsive-->\
        <thead>\
            <tr>\
                <th>Nom de l\'entité</th>\
                <th>ID</th>\
                <th>X</th>\
            </tr>\
        </thead>\
        <tbody>\
        </tbody>\
    </table>\
    </div>\
    <div class="col-lg-12">\
        <div class="col-lg-5">\
        <button id="save_semi" type="submit" class="btn btn-primary">Enregistrer le semi</button>\
        </div>\
        <div class="col-lg-6">\
        <input id="name_save_semi" class="form-control" >\
        </div>\
    </div>\
    <div class="col-lg-12 page-header">\
    </div>\
</div>';
    
form_analyse_semi = '\
<div class="col-lg-12" >\
    <div class="form-group">\
    </div>\
    <div class="col-lg-12">\
        <div class="form-group">\
            <div id="loader_f" class="loader visible_s_f z_indexed">\
                <i class="fa fa-refresh fa-spin"></i>Loading\
            </div>\
        </div>\
    </div>\
    <div class="page-header">\
        <h2>Analyser un semi :</h2>\
        <p>Si aucun élément n\'est présent dans la liste, il faut préalablement définir un semi</p>\
    </div>\
    <div class="col-lg-5">\
        <div class="form-group">\
            <p>Choisir un semi :</p>\
            <select class="form-control" id="liste_semi_analyses">\
                <option id="a_0" id_semis=" null " >----</option>\
        </select>\
        </div>\
    </div>\
    <div class="col-lg-12">\
        <div class="form-group">\
            <p>Nommez votre Analyse :</p>\
            <input id="nom_analyse" class="form-control" placeholder="" onblur="" >\
        </div>\
    </div>\
    <div class="col-lg-10">\
        <button id="run_analyse" type="submit" class="btn btn-primary">Lancer l\'analyse</button>\
    </div>\
    <div class="col-lg-12 page-header">\
    </div>\
    <div class="col-lg-7">\
        <div class="form-group">\
            <p>Ou recharger une ancienne analyse :</p>\
            <select class="form-control" id="liste_old_analyses">\
                <option id="aold_0" id_analyses=" null " >----</option>\
        </select>\
        </div>\
    </div>\
</div>';


