var map;
var loc_plus=false;
var car_plus=false;
var mare_selected_str='';
var semi_array = {};
//mare avec la popup open
var mare_p_active;

// Style Neutre
var contour_jaune={
    color:'#f9eb07',
    fillOpacity:0,
    weight:2,
    opacity:1
    };
// Style Rose
var contour_semi_selected={
    color:'#ff09e0',
    fillOpacity:0.4,
    weight:2,
    opacity:0.8
    };
// Style Vert semi fond
var contour_semi={
    color:'#3b9a2d',
    fillOpacity:0,
    weight:2,
    opacity:1,
    className: "hidde_A"
    };
// Style Rouge analyse
var contour_analyse={
    color:'#d43434',
    fillOpacity:0.2,
    weight:2,
    opacity:0.7
    };
// create custom icon
car = L.icon({
                iconUrl: 'img/mare/caracterisee.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});
vue = L.icon({
                iconUrl: 'img/mare/vue.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});
pot = L.icon({
                iconUrl: 'img/mare/potentielle.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});
dis = L.icon({
                iconUrl: 'img/mare/disparue.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});
a_car = L.icon({
                iconUrl: 'img/mare/a_caracterisee.png',
                iconSize: [16, 14], 
                popupAnchor: [0,-12]
});
a_vue = L.icon({
                iconUrl: 'img/mare/a_vue.png',
                iconSize: [16, 14], 
                popupAnchor: [0,-12]
});
a_pot = L.icon({
                iconUrl: 'img/mare/a_potentielle.png',
                iconSize: [16, 14], 
                popupAnchor: [0,-12]
});
a_dis = L.icon({
                iconUrl: 'img/mare/a_disparue.png',
                iconSize: [16, 14], 
                popupAnchor: [0,-12]
});
selected_mare = L.icon({
                iconUrl: 'img/mare/mare_selected.png',
                iconSize: [20,20], 
                popupAnchor: [0,-12]
});
added_mare_loc = L.icon({
                iconUrl: 'img/mare/added_mare.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});
stade1 = L.icon({
                iconUrl: 'img/mare/stade1.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});
stade = L.icon({
                iconUrl: 'img/mare/stade2.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});
stade3 = L.icon({
                iconUrl: 'img/mare/stade3.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});
stade4 = L.icon({
                iconUrl: 'img/mare/stade4.png',
                iconSize: [16, 16], 
                popupAnchor: [0,-12]
});


function semi_selected_load () {
    semi_geojson_selected.clearLayers();
    for (var k in semi_array){
        id=k;
        table_name=semi_array[k][1];
            $.ajax({
            url      : "php/ajax/analyse/load_semi_geojson_selected.js.php",
            data     : {table_name: table_name, id:id},
            method   : "POST",
            dataType : "json",
            async    : false,
            start    : function () {},
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            success  : function(data) {
                    //if (data.features != null) {
                    //    $(data.features).each(function(key, value) {
                    //        semi_geojson_selected.addData(data.features[key]);
                    //    });
                    //}
                semi_geojson_selected.addData(data);
                }
            });
    }
    if (semi_array.length > 0) {
        map.fitBounds(semi_geojson_selected.getBounds());
    }
};


function initmap() {
    // set up the map
    map = new L.Map('map'//,{drawControl: true}
    );
    

    //TileLayer
    var osmUrlbg='http://{s}.tile.stamen.com/toner/{z}/{x}/{y}.png';
    var osmwatercolorUrl='http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png';
    var ignOrtho='http://wxs.ign.fr/apgyusriiwvbm0osuwsff2dg/geoportail/wmts?service=WMTS&request=GetTile&version=1.0.0&tilematrixset=PM&tilematrix={z}&tilecol={x}&tilerow={y}&layer=ORTHOIMAGERY.ORTHOPHOTOS&format=image/jpeg&style=normal';
    var ignSCAN25='http://wxs.ign.fr/apgyusriiwvbm0osuwsff2dg/geoportail/wmts?service=WMTS&request=GetTile&version=1.0.0&tilematrixset=PM&tilematrix={z}&tilecol={x}&tilerow={y}&layer=GEOGRAPHICALGRIDSYSTEMS.MAPS&format=image/jpeg&style=normal';
    
    
    var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
    var ignAttrib='<a href="http://www.ign.fr/">IGN © </a> IGN© WM(T)S BD ORTHO, BD PARCELLES, BD SCAN';
    
    var ign_cadastre =new L.tileLayer.wms('http://wxs.ign.fr/apgyusriiwvbm0osuwsff2dg/geoportail/r/wms?', {layers: 'CADASTRALPARCELS.PARCELS',attribution:ignAttrib,opacity:0.4});
    var ignO = new L.TileLayer(ignOrtho,{minZoom:1,maxZoom:24,attribution:ignAttrib,opacity:0.4});
    var ignS = new L.TileLayer(ignSCAN25,{minZoom:1,maxZoom:24,attribution:ignAttrib,opacity:0.4});
    var osmbg=new L.TileLayer(osmUrlbg,{minZoom:1,maxZoom:24,attribution:osmAttrib,opacity:0.4});
    var osmWatercolor=new L.TileLayer(osmwatercolorUrl,{minZoom:1,maxZoom:24,attribution:osmAttrib,opacity:0.5});
    
    
    //Marker
    var markers = L.markerClusterGroup({showCoverageOnHover: false,disableClusteringAtZoom: 9});

    map.setView(new L.LatLng(46.85,2.3518),6);
    map.addLayer(osmbg);
    
    
    // Créer une couche geojson vide pour les Contours Admin
    admin_geojson_feature = L.geoJson(false, {
        style:contour_jaune,
        onEachFeature: function(feature,layer)
            {
                layer.on("click",function(e){
                    if (!loc_plus) {
                        map.fitBounds(layer.getBounds(), {animate: false});
                    }else {
                        add_Marker(e);
                    }
                });

                //layer.on("mouseover",function(e){
                //    layer.setStyle(highlightStyle_Yellow);
                //});
                //layer.on("mouseout",function(e){
                //    admin_geojson_feature.resetStyle(e.target);
                //});
            }
    }).addTo(map);
    
    mare_selected_point = L.geoJson(false, {
        onEachFeature: function (feature, layer) //functionality on click on feature
            {
                var content = '\
                    <div class="col-lg-12 leaf_title" >\
                        <div class="col-sm-12">\
                            <div class="form-group">\
                            <span>Identifiant : '+feature.properties.loc_id_plus+'</span>\
                            </div>\
                        </div>\
                        <div class="col-sm-12">\
                            <div class="form-group">\
                            <span>Statut : '+feature.properties.loc_statut+' </span>\
                            </div>\
                        </div>\
                        <div class="col-sm-12">\
                            <span>Localisation : <a id="loc_fiche"><i class="fa fa-fw fa-table"></i> Fiche  </a><a id="loc_edit"><i class="fa fa-fw fa-edit"></i> Edition  </a><a id="loc_export"><i class="fa fa-fw fa-file"></i> PDF  </a></span>\
                        </div>\
                        <div class="col-sm-12">\
                            <span>Caractérisation : <a id="car_fiche" ><i class="fa fa-fw fa-table"></i> Fiche  </a><a id="car_edit"><i class="fa fa-fw fa-edit"></i> Edition  </a><a id="car_export"><i class="fa fa-fw fa-file"></i> PDF  </a></span>\
                        </div>\
                        <div class="col-sm-12">\
                            <span>Espèces : <a id="sp_fiche"><i class="fa fa-fw fa-table"></i> Fiche  </a><a id="sp_edit"><i class="fa fa-fw fa-edit"></i> Edition  </a><a id="sp_export"><i class="fa fa-fw fa-file"></i> Excel  </a></span>\
                        </div>\
                        <div class="col-sm-12">\
                            <div class="form-group">\
                            <span>Travaux : <a id="w_fiche"><i class="fa fa-fw fa-table"></i> Fiche  </a><a id="w_edit"><i class="fa fa-fw fa-edit"></i> Edition  </a><a id="w_export"><i class="fa fa-fw fa-file"></i> Excel  </a></span>\
                            </div>\
                        </div>\
                        <div class="col-sm-12">\
                            <div class="form-group">\
                            <span> <a id="photoz_link"><i class="fa fa-fw fa-picture-o"></i> Photos de la mare </a></span>\
                            </div>\
                        </div>\
                    </div>';
                layer.on("click",function(e){
                    $('#mares_autocomplete').val(feature.properties.loc_id_plus);
                });
                layer.bindPopup(content, {maxWidth : 500});
                layer.setIcon(selected_mare);
            }
    }).addTo(map);
    
    
    // Créer une couche geojson vide pour la definition du semi
    semi_geojson_selected = L.geoJson(false, {
        style:contour_semi_selected,
        onEachFeature: function(feature,layer)
            {
                layer.on("click",function(e){
                    semi_geojson_selected.removeLayer(feature);
                });
            }
    }).addTo(map);
    
    // Créer une couche geojson vide pour afficher l'analyse
    analyse_fond = L.geoJson(false, {
        style:contour_analyse,
        onEachFeature: function(feature,layer)
            {
            }
    }).addTo(map);
    
    semi_geojson = L.geoJson(false, {
        style:contour_semi,
        onEachFeature: function(feature,layer)
            {
                layer.on("click",function(e){
                    semi_geojson_selected.addData(feature);
                    semi_array[feature.properties.l_id] = [feature,feature.properties.table_name];
                    console.log(feature.properties.l_nom);
                    console.log(feature.properties.l_id);
                    dt_composition.row.add(
                        [
                        feature.properties.l_nom, 
                        feature.properties.l_id,
                        "<div id='del__"+feature.properties.l_id+"' class='link_delete' >X</div>"
                        ]
                    ).node().id= feature.properties.l_id;
                    dt_composition.draw( false );
                    $("#"+feature.properties.l_id).click( function (){
                        var id = $(this).attr("id").replace("del__","");
                        dt_composition.row("#"+id).remove().draw();
                        delete semi_array[id];
                        semi_selected_load();
                        map.removeLayer(semi_geojson);
                        map.addLayer(semi_geojson);
                        });
                });
                //layer.on("mouseover",function(e){layer.setStyle(contour_jaune)});
                //layer.on("mouseout",function(e){semi_geojson.resetStyle(e.target)});
                layer.bindLabel(feature.properties.l_nom);
            }
            
    }).addTo(map);
    
    mares = L.geoJson(false, {
        onEachFeature: function (feature, layer) //functionality on click on feature
            {
                var car_content = "";
                var w_content = "";
                var obs_content = "";
                if (feature.properties.car_ids !== '') {
                    car_content+="<div class='col-sm-12'><div class='d-flex justify-content-start' ><div class='flex-wrap align-content-center' >Caractérisation : <select id='select_car' class='custom-select custom-select-sm' >";
                    for (var k in feature.properties.car_ids.split("|") ) {
                        
                        if (k>0) {
                            feature.properties.car_ids.split("|")[k];
                            //console.log(feature.properties.car_ids.split("|")[k]);
                            var val= feature.properties.car_ids.split("|")[k].split("_");
                            var date_id = val[1];
                            var id_car = val[0];
                            car_content +="<option id='"+id_car+"'>"+date_id+"</option>";
                        }
                    }
                    car_content+="</select><a onclick='load_car_edit();'><i class='fa fa-fw fa-edit'></i> Edition  </a><a id='car_export' onclick='load_fiche_mare();'><i class='fa fa-fw fa-file'></i> PDF  </a></div></div></div>";
                }
                if (feature.properties.obs_ids !== '') {
                    obs_content+="<div class='col-sm-12'><div>Espèces : <a onclick='load_esp_edit();'><i class='fa fa-fw fa-edit'></i> Ajout / Consultation </a></div></div>";
                }
                if (feature.properties.tra_ids !== '') {
                    //travaux_content+="<div class='col-sm-12'><div>Travaux : <a onclick='load_tra_edit();'><i class='fa fa-fw fa-edit'></i> Consultation/Edition </a></div></div>";
                    w_content+="<div class='col-sm-12'><div>Travaux : <select id='select_tra'  class='custom-select custom-select-sm' >";
                    for (var k in feature.properties.tra_ids.split("|") ) {
                        if (k>0) {
                            feature.properties.tra_ids.split("|")[k];
                            //console.log(feature.properties.car_ids.split("|")[k]);
                            var val= feature.properties.tra_ids.split("|")[k].split("_");
                            var date_id = val[1];
                            var id_w = val[2];
                            var type_w = val[0];
                            var value_ ='';
                            switch (val[0]) {
                                case "wa":
                                    value_ = "Aménagement";
                                    break;
                                case "wr":
                                    value_ = "Restauration";
                                    break;
                                case "wc":
                                    value_ = "Création";
                                    break;
                                default:
                                    break;
                            };
                            w_content +="<option id='"+type_w+"_"+id_w+"'>"+date_id+" - "+value_+"</option>";
                            
                        }
                    }
                    w_content+="</select><a id='tra_export' onclick='load_w_pdf();'><i class='fa fa-fw fa-file'></i> PDF  </a></div></div>"; 
                    //Non editable
                    //<a onclick='load_w_edit();'><i class='fa fa-fw fa-edit'></i> Edition  </a>
                }
                var content = '\
<row class="no-gutters">\
<div class="col-lg-12 leaf_title" >\
    <row class="no-gutters">\
    <div class="d-flex flex-column">\
        <div class="mb-2">Identifiant : <span style="color:#6fbd43;font-weight:600;">'+feature.properties.loc_id_plus+'</span></div>\
        <div class="mb-2">Statut : <span style="color:#6fbd43;font-weight:600;">'+feature.properties.loc_statut+'</span></div>\
    </div>\
    <div class="d-flex mb-1">\
        <div>Localisation : <a onclick="load_loc_edit(\''+feature.properties.loc_id_plus+'\');"><i class="fa fa-fw fa-edit"></i> Edition  </a><a id="loc_export" onclick="load_fiche_mare_localisation();"><i class="fa fa-fw fa-file"></i> PDF  </a></div>\
    </div>\
    '+car_content+'\
    '+obs_content+'\
    '+w_content+'\
    <div class="d-flex mt-2">\
        <div> <a id="photoz_link"><i class="fas fa-file-image"></i> Photos de la mare </a></div>\
    </div>\
    </row>\
</div>\
</row>';
                switch (feature.properties.loc_statut) {
                    case 'Vue':
                        layer.setIcon(a_vue);
                        break;
                    case 'Potentielle':
                        layer.setIcon(a_pot);
                        break;
                    case 'Caractérisée':
                        layer.setIcon(a_car);
                        break;
                    default:
                        layer.setIcon(a_dis);
                };
                layer.bindPopup(content, {maxWidth : 500})
                .on('popupopen', function (popup) {
                    mare_p_active = 'null' ;
                    mare_p_active = feature;
                })
                .on('popupclose', function (popup) {
                    
                    //mare_p_active = 'null' ;
                });
                layer.on("click",function(e){
                    $('#mares_autocomplete').val(feature.properties.loc_id_plus);
                    mare_selected_str=feature.properties.loc_id_plus;
                    //Clear photos content
                    $("#photoz").html('');
                    if (feature.properties.blb_ids !== '') {
                        for (var k in feature.properties.blb_ids.split("|") ) {
                            if (k>0) {
                                //|id_plus_photo#id_user#date_photo
                                var blb_id = feature.properties.blb_ids.split("|")[k].split("#");
                                $('#photoz').append('<div class="card mx-2 my-2" style="max-width:300px;max-height:300px;">'+
                                '<img class="card-img-top" style="max-width:300px;max-height:300px;" src="img/photos/'+blb_id[0]+'" alt="Mare">'+
                                '<div class="card-img-overlay"><h5 class="card-text text-white"><span class="px-2 t_over_photo">'+blb_id[2]+'</span></h5>'+
                                '<p class="card-title text-white font-weight-bold"><span class="px-2 t_over_photo">'+blb_id[1]+'</span></p>'+
                                '<a href="img/photos/'+blb_id[0]+'" class="stretched-link" target="blank_"></a>'+
                                '</div></div>');
                            }
                        }
                    }
                });
            },
            filter: function(feature, layer) {
                    return !feature.properties.mine_loc;
                }
    }).addTo(map);
    
    my_mares = L.geoJson(false, {
        onEachFeature: function (feature, layer) //functionality on click on feature
            {
                var car_content = "";
                var w_content = "";
                var obs_content = "";
                if (feature.properties.car_ids !== '') {
                    car_content+="<div class='col-sm-12'><div class='d-flex justify-content-start' ><div class='flex-wrap align-content-center' >Caractérisation : <select id='select_car'  class='custom-select custom-select-sm' >";
                    for (var k in feature.properties.car_ids.split("|") ) {
                        
                        if (k>0) {
                            feature.properties.car_ids.split("|")[k];
                            //console.log(feature.properties.car_ids.split("|")[k]);
                            var val= feature.properties.car_ids.split("|")[k].split("_");
                            var date_id = val[1];
                            var id_car = val[0];
                            car_content +="<option id='"+id_car+"'>"+date_id+"</option>";
                        }
                    }
                    car_content+="</select><a onclick='load_car_edit();'><i class='fa fa-fw fa-edit'></i> Edition  </a><a id='car_export' onclick='load_fiche_mare();'><i class='fa fa-fw fa-file'></i> PDF  </a></div></div></div>";
                }
                if (feature.properties.obs_ids !== '') {
                    obs_content+="<div class='col-sm-12'><div>Espèces : <a onclick='load_esp_edit();'><i class='fa fa-fw fa-edit'></i> Consultation/Edition </a></div></div>";
                }
                if (feature.properties.tra_ids !== '') {
                    //travaux_content+="<div class='col-sm-12'><div>Travaux : <a onclick='load_tra_edit();'><i class='fa fa-fw fa-edit'></i> Consultation/Edition </a></div></div>";
                    w_content+="<div class='col-sm-12'><div>Travaux : <select id='select_tra'  class='custom-select custom-select-sm' >";
                    for (var k in feature.properties.tra_ids.split("|") ) {
                        if (k>0) {
                            feature.properties.tra_ids.split("|")[k];
                            //console.log(feature.properties.car_ids.split("|")[k]);
                            var val= feature.properties.tra_ids.split("|")[k].split("_");
                            var date_id = val[1];
                            var id_w = val[2];
                            var type_w = val[0];
                            var value_ ='';
                            switch (val[0]) {
                                case "wa":
                                    value_ = "Aménagement";
                                    break;
                                case "wr":
                                    value_ = "Restauration";
                                    break;
                                case "wc":
                                    value_ = "Création";
                                    break;
                                default:
                                    break;
                            };
                            w_content +="<option id='"+type_w+"_"+id_w+"'>"+date_id+" - "+value_+"</option>";
                            
                        }
                    }
                    w_content+="</select><a onclick='load_w_edit();'><i class='fa fa-fw fa-edit'></i> Edition  </a><a id='tra_export' onclick='load_w_pdf();'><i class='fa fa-fw fa-file'></i> PDF  </a></div></div>";
                }
                var content = '\
<row class="no-gutters">\
<div class="col-lg-12 leaf_title" >\
    <row class="no-gutters">\
    <div class="d-flex flex-column">\
        <div class="mb-2">Identifiant : <span style="color:#6fbd43;font-weight:600;">'+feature.properties.loc_id_plus+'</span></div>\
        <div class="mb-2">Statut : <span style="color:#6fbd43;font-weight:600;">'+feature.properties.loc_statut+'</span></div>\
    </div>\
    <div class="d-flex mb-1">\
        <div>Localisation : <a onclick="load_loc_edit(\''+feature.properties.loc_id_plus+'\');"><i class="fa fa-fw fa-edit"></i> Edition  </a><a id="loc_export" onclick="load_fiche_mare_localisation();"><i class="fa fa-fw fa-file"></i> PDF  </a></div>\
    </div>\
    '+car_content+'\
    '+obs_content+'\
    '+w_content+'\
    <div class="d-flex mt-2">\
        <div> <a id="photoz_link"><i class="fas fa-file-image"></i> Photos de la mare </a></div>\
    </div>\
    </row>\
</div>\
</row>';
                switch (feature.properties.loc_statut) {
                    case 'Vue':
                        layer.setIcon(vue);
                        break;
                    case 'Potentielle':
                        layer.setIcon(pot);
                        break;
                    case 'Caractérisée':
                        layer.setIcon(car);
                        break;
                    default:
                        layer.setIcon(dis);
                };
                layer.bindPopup(content, {maxWidth : 500})
                .on('popupopen', function (popup) {
                    mare_p_active = 'null' ;
                    mare_p_active = feature;
                })
                .on('popupclose', function (popup) {
                    //mare_p_active = 'null' ;
                });
                layer.on("click",function(e){
                    $('#mares_autocomplete').val(feature.properties.loc_id_plus);
                    mare_selected_str=feature.properties.loc_id_plus;
                    //Clear photos content
                    $("#photoz").html('');
                    if (feature.properties.blb_ids !== '') {
                        for (var k in feature.properties.blb_ids.split("|") ) {
                            if (k>0) {
                                //|id_plus_photo#id_user#date_photo
                                var blb_id = feature.properties.blb_ids.split("|")[k].split("#");
                                $('#photoz').append('<div class="card mx-2 my-2" style="max-width:300px;max-height:300px;">'+
                                '<img class="card-img-top" style="" src="img/photos/'+blb_id[0]+'" alt="Mare">'+
                                '<div class="card-img-overlay"><h5 class="card-text text-white"><span class="px-2 t_over_photo">'+blb_id[2]+'</span></h5>'+
                                '<p class="card-title text-white font-weight-bold"><span class="px-2 t_over_photo">'+blb_id[1]+'</span></p>'+
                                '<a href="img/photos/'+blb_id[0]+'" class="stretched-link" target="blank_"></a>'+
                                '</div></div>');
                            }
                        }
                    }
                });
            },
            filter: function(feature, layer) {
                    return feature.properties.mine_loc;
                }
    }).addTo(map);
    
    
    mare_added = L.geoJson(false, {
        onEachFeature: function (feature, layer) //functionality on click on feature
            {
                layer.on("click",function(e){
                });
                layer.setIcon(added_mare_loc);
            }
    }
    ).addTo(map);
    mare_analyse = L.geoJson(false, {
        onEachFeature: function (feature, layer) //functionality on click on feature
            {
                switch (feature.properties.loc_statut) {
                    case 'Vue':
                        layer.setIcon(vue);
                        break;
                    case 'Potentielle':
                        layer.setIcon(pot);
                        break;
                    case 'Caractérisée':
                        layer.setIcon(car);
                        break;
                    default:
                        layer.setIcon(dis);
                };
                layer.on("click",function(e){
                });
            }
    }
    ).addTo(map);
    
    
    osmbg.setOpacity(0.8);
    osmWatercolor.setOpacity(0.8);
    ign_cadastre.setOpacity(0.8);
    ignO.setOpacity(0.8);
    
    
    overlaysMaps={"Contours Administratifs":admin_geojson_feature,"Mare Cible":mare_selected_point,"Mares de l'analyse":mare_analyse,"Entités cartographiques":semi_geojson};//"Mes Mares":my_mares,"Mares Tierces":mares,"Mare Localisation":mare_added, "Entités cartographiques":semi_geojson, "Semi selectionné":semi_geojson_selected,"Zone d'analyse":analyse_fond,
    baseMaps={"OSM N&B":osmbg,"OSM Watercolor":osmWatercolor,"IGN Parcellaire":ign_cadastre, "IGN Ortho":ignO,"IGN SCAN25":ignS };
    //baseMaps={"OSM N&B":osmbg,"OSM Watercolor":osmWatercolor};
    ControlLayer=L.control.layers(baseMaps,overlaysMaps).addTo(map); 
    //ControlLayer=L.control.layers(overlaysMaps).addTo(map); 
    admin_geojson_feature.bringToBack();
    mare_added.bringToFront();
    

    
    
    
    
    
    function add_Marker(e) {
        if (loc_plus) {
            mare_added.clearLayers();
            var point_loc = JSON.parse('{ "type": "FeatureCollection","features": [{ "type": "Feature","geometry": {"type": "Point", "coordinates":['+e.latlng.lng+','+e.latlng.lat+']},"properties": {"id": "new"}}]}');
            //Add marker to map at click location
            mare_added.addData(point_loc);
            $('#loc_x').val(e.latlng.lng);
            $('#loc_y').val(e.latlng.lat);
        }else {
            mare_added.bringToBack();
        }
    }
    
    
    map.on('click', function (e) {
        add_Marker(e);
        });
    
    // DRAW START
    // Initialize the FeatureGroup to store editable layers
    drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);
    // Initialize the draw control and pass it the FeatureGroup of editable layers
    drawControl = new L.Control.Draw({
        draw : {
        position : 'topleft',
        polygon : true,
        polyline : false,
        rectangle : false,
        circle : false,
        marker : false
        },
        edit: {
            featureGroup: drawnItems
        }
     });
    
    //LISTEN EVENTS ON DRAWING
    map.on('draw:created', function (e) {
    var type = e.layerType,
        layer = e.layer;
        if (type === 'marker') {
            // Do marker specific actions
        }
        // Do whatever else you need to. (save to db, add to map etc)
        drawnItems.addLayer(layer);
        //call function to store drawnItems layer in geojson string
    });
    
    map.on('draw:edited', function () {
        // Update db to save latest changes.
    });
    map.on('draw:deleted', function () {
        // Update db to save latest changes.
        drawnItems.clearLayers();
    });
    // DRAW END
    
    
    
};



function clear_all_layer() {
    //geojson_layer
    admin_geojson_feature.clearLayers();
    semi_geojson_selected.clearLayers();
    semi_geojson.clearLayers();
    //geojson_marker_layer
    mares.clearLayers();
    my_mares.clearLayers();
    mare_added.clearLayers();
    mare_selected_point.clearLayers();
    mare_analyse.clearLayers();
    
    console.log("cleared");
    
    //cache_geojson_layer
    //cache_geojson_marker_layer
    sessionStorage.clear();
}

function reload() {
    console.log("reload");
    //RELOAD older search if exists
    if (JSON.parse(sessionStorage.getItem('admin_')) != null) {
        console.log("worked");
        if (JSON.parse(sessionStorage.getItem('mares')) != null) {
            mares.addData(JSON.parse(sessionStorage.getItem('mares')));
        }
        if (JSON.parse(sessionStorage.getItem('my_mares')) != null) {
            my_mares.addData(JSON.parse(sessionStorage.getItem('my_mares')));
        }
        if (JSON.parse(sessionStorage.getItem('mare_selected_point')) != null) {
            //mare_selected_point.addData(JSON.parse(sessionStorage.getItem('mare_selected_point')));
        }
        if (JSON.parse(sessionStorage.getItem('mare_added')) != null) {
            mare_added.addData(JSON.parse(sessionStorage.getItem('mare_added')));
        }
        admin_geojson_feature.addData(JSON.parse(sessionStorage.getItem('admin_')));
        map.fitBounds(admin_geojson_feature.getBounds());
        $("#layers_autocomplete").val(sessionStorage.getItem('id_search')+' - '+sessionStorage.getItem('entity_name'));
    }
};


//-----------------------------------------------------------------
// RECUPERE LE DESSIN POUR ENVOI EN BDD
//-----------------------------------------------------------------
function save_specific_area() {
    if ($('#specific_name').attr("value") != "") {
        if (drawnItems.getBounds().isValid() ) {
            //console.log(JSON.stringify(drawnItems.toGeoJSON() ));
            drawnedItems_to_pg( JSON.stringify(drawnItems.toGeoJSON() ) , $("#specific_name").val() );
            //vide la couche de dessin
            drawnItems.clearLayers();
            //remove and add drawnitems
            map.removeLayer(drawnItems);
            //rajoute la couche vide
            map.addLayer(drawnItems);
        } else //la couche de dessin est vide pas de polygon dessine....
        {
            alert('Veuillez dessiner un polygone avant d\'enregistrer une zone');
        }
    } else //Aucun nom n'est donne a la zone specifique
    {
        alert('Veuillez donner un nom à votre zone specifique');
    }
}
//-----------------------------------------------------------------
// ENREGISTRE LE DESSIN EN BDD
//-----------------------------------------------------------------
function drawnedItems_to_pg (drawned_obj, str_name ) {
    var name_ = str_name+date_();
    $.ajax({
        type: "POST",
        url: "php/ajax/analyse/save_drawned_items.js.php",
        async: false,
        datatype: "text",
        data: {temp_geoson: drawned_obj , temp_name: name_ },
        success : function(data) {
            if (data == "true") {
                console.log("saved");
                $("#define_semi").trigger('click');
                drawnItems.clearLayers();
            } else {
                console.log("not saved");
            }
        }
    });
};







































