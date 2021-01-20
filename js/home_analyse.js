//8CXX2GRX+WM_20101
//8CXX2HQ5+RR_20770
var flag_eee                = false;

/////////////////////////////////////////////////////////////////
// DECLARATION DE L'ELEMENT DATATABLE POUR AFFICHER LES MARES
dt = $('#mares_dt').DataTable({
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
  dom: 'Bfrtip',
  buttons: [
                {extend:'excelHtml5',
                title: 'Data export'
                },
                {extend:'pdfHtml5',
                title: 'Data export'
                }
        ]
  
  
});

function get_mares(nom_analyse, new_analyse) {
    clear_all_layer();
    $("#clef_atterrissement").val('');
    $("#clef_deghydro").val('');
    $("#clef_eee").val('');
    $("#clef_dechet").val('');
    $("#clef_usage").val('');
    
    
    if (new_analyse) {
        var id_semis = $("#liste_semi_analyses").val();
        //console.log(id_semis);
    } else {
        var id_semis = nom_analyse;
        //console.log(id_semis);
    }
    var nb_total_mares = 0;
    var surf_moyenne_mares = 0;
    var surf_cumulee_mares = 0;
    var surf_array =[];
    var eaee = true;
    var evee = true;
    $("#title_analyse").text(nom_analyse);
    $.ajax({
            url      : "php/ajax/analyse/get_mares.js.php",
            data     : {nom_analyse: nom_analyse, id_semis:id_semis, new_analyse:new_analyse},
            method   : "POST",
            dataType : "json",
            async    : false,
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            success  : function(data) {
                    if (data.features !== null) {
                        $(data.features).each(function(key, value) {
                            mare_analyse.addData(data.features[key]);
                            nb_total_mares += 1;
                            var evol = '';
                            if ((data.features[key].properties.car_larg !== null) && (data.features[key].properties.car_long !== null)) {
                                surf_array.push(data.features[key].properties.car_larg*data.features[key].properties.car_long);
                                surf_cumulee_mares+=(data.features[key].properties.car_larg*data.features[key].properties.car_long);
                            }
                            if ((data.features[key].properties.car_eaee !== null) && (eaee)) {
                                eaee = false;
                                $("#presence_eaee").text("Oui");
                            }
                            if ((data.features[key].properties.car_evee !== null) && (evee)) {
                                evee = false;
                                $("#presence_evee").text("Oui");
                            }
                            if (data.features[key].properties.car_evolution !== null) {
                                evol = data.features[key].properties.car_evolution.substring(0, 7);
                                
                            }
                            dt.row.add([
                                data.features[key].properties.loc_id_plus,
                                data.features[key].properties.car_type,
                                data.features[key].properties.car_date,
                                evol,
                                //data.features[key].properties.car_evolution,
                                data.features[key].properties.car_usage,
                                data.features[key].properties.car_eaee,
                                data.features[key].properties.car_evee
                            ]).draw();
                        });
                    map.fitBounds(mare_analyse.getBounds());
                    } else {
                        alert("Aucune mare n'est présente dans la zone...");
                    }
                
                atterrissement();
                typologie();
                alimentation();
                contexte();
                usage();
                degrad_hydro();
                degrad_eee();
                degrad_0dechet();
                $("#nb_total_mares").text(nb_total_mares);
                $("#surf_moyenne_mares").text(moyenne(surf_array));
                $("#surf_cumulee_mares").text(surf_cumulee_mares);
                $("#completude").text("0 %");
                clef();
                }// END SUCCESS
            });
    $.ajax({
            url      : "php/ajax/analyse/get_surface_semis.js.php",
            data     : {nom_analyse: nom_analyse, id_semis:id_semis, new_analyse:new_analyse},
            method   : "POST",
            dataType : "text",
            async    : false,
            start    : function () {},
            error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
            success  : function(data) {
                    $("#surface_semis").text(data+" km²");
                    $("#densite_mares").text((nb_total_mares/data).toFixed(2)+" /km²");
                }
            });
}

function moyenne(arguments) {
  var somme=0.0;
  var nombre=arguments.length;
  for (var i=0; i<nombre; i++) somme+=arguments[i];
  return somme/nombre;
}



function clef() {
    $("#clef_eee").empty();
    $("#clef_atterrissement").empty();
    $("#clef_deghydro").empty();
    $("#clef_dechet").empty();
    $("#clef_usage").empty();
    if(flag_eee) {
        $("#clef_eee").append("<img src='img/badthing_2.png' />"+" Des espèces exotiques envahissantes sont présentes dans le réseau de mares");
    } else {$("#clef_eee").append("<img src='img/goodthing_2.png' />");};
    if(parseInt($("#val_atterrissement").text().split(' %')[0]) > 33) {
        $("#clef_atterrissement").append("<img src='img/badthing_2.png' />"+" L'atterrissement du réseau est plutôt élevé ");
    } else {$("#clef_atterrissement").append("<img src='img/goodthing_2.png' />");};
    if(parseInt($("#prct_mares_deg_hydro").text().split(' %')[0]) > 5) {
        $("#clef_deghydro").append("<img src='img/badthing_2.png' />"+" La dégradation hydrosystémique du réseau est plutôt élevée (x>5%)");
    } else {$("#clef_deghydro").append("<img src='img/goodthing_2.png' />");};
    if(parseInt($("#prct_mares_deg_dechet").text().split(' %')[0]) < 95) {
        $("#clef_dechet").append("<img src='img/badthing_2.png' />"+"  Moins de 95% des mares sont renseignées comme n'ayant aucun déchet");
    } else {$("#clef_dechet").append("<img src='img/goodthing_2.png' />");};
    if(parseInt($("#nb_usage_val_prct").text().split(' %')[0]) < 50) {
        $("#clef_usage").append("<img src='img/badthing_2.png' />"+" Moins de 50% des mares du semis ont un usage valorisant");
    } else {$("#clef_usage").append("<img src='img/goodthing_2.png' />");};
}
function degrad_hydro() {
    var nb_mares_degra                  = 0;
    var nb_mares_valeurs_renseignees    = 0;
    mare_analyse.eachLayer(function(layer) {
        if (layer.feature.properties.loc_statut == 'Caractérisée') {
            if (layer.feature.properties.car_liaison !== null) {
                if (layer.feature.properties.car_alimentation !== null) {
                     if ((layer.feature.properties.car_liaison == "cours d'eau") || (layer.feature.properties.car_alimentation == "source")) {
                        nb_mares_degra+=1;
                     } else { nb_mares_valeurs_renseignees +=1;}
                }
            }
        }
    });
    var prct_deg_hydro = 0;
    if( ((nb_mares_valeurs_renseignees)>0) || ((nb_mares_degra)>0) ) {
        prct_deg_hydro = (nb_mares_degra/(nb_mares_degra +nb_mares_valeurs_renseignees))*100;
    } else {
        prct_deg_hydro = 0;
    };
    $("#prct_mares_deg_hydro").text(prct_deg_hydro.toFixed(2)+" %");
    $("#nb_mares_deg_hydro").text(nb_mares_degra);
};
function degrad_eee() {
    var nb_mares_eee            = 0;
    var liste_eee               = '';
    mare_analyse.eachLayer(function(layer) {
        if (layer.feature.properties.loc_statut == 'Caractérisée') {
            flag_eee = true;
            if (layer.feature.properties.car_evee !== null) {
                nb_mares_eee+=1;
                var it = layer.feature.properties.car_evee.split('|').length;
                for (i = 0; i < it; i++) {liste_eee += layer.feature.properties.car_evee.split('|')[i]+'</br>'}
            };
            if (layer.feature.properties.car_eaee !== null) {
                nb_mares_eee+=1;
                var it = layer.feature.properties.car_eaee.split('|').length;
                for (i = 0; i < it; i++) {liste_eee += layer.feature.properties.car_eaee.split('|')[i]+'</br>'}
            };
            
        }
    });
    $("#nb_eee").text(nb_mares_eee);
    $("#liste_eee").append('<span>'+liste_eee+'</span>');
};
function degrad_0dechet() {
    var nb_mares_0dechet            = 0;
    var nb_mares_dechets            = 0;
    mare_analyse.eachLayer(function(layer) {
        if (layer.feature.properties.loc_statut == 'Caractérisée') {
            if (layer.feature.properties.car_dechet !== null) {
                if (layer.feature.properties.car_dechet == "Aucun") {
                    nb_mares_0dechet+=1;
                } else {
                    nb_mares_dechets+=1;
                }
            }
        }
    });
    var prct_0dechet = 0;
    if( ((nb_mares_0dechet)>0) || ((nb_mares_dechets)>0) ) {
        prct_0dechet = (nb_mares_0dechet/(nb_mares_0dechet +nb_mares_dechets))*100;
    } else {
        prct_0dechet = 0;
    };
    $("#prct_mares_deg_dechet").text(prct_0dechet.toFixed(2)+" %");
    $("#nb_mares_deg_dechet").text(nb_mares_0dechet);
};
function atterrissement() {
    var stade1 = 0;
    var stade2 = 0;
    var stade3 = 0;
    var stade4 = 0;
    var nb_not_null  = 0;
    var ratio        = [];
    mare_analyse.eachLayer(function(layer) {
        if (layer.feature.properties.loc_statut == 'Caractérisée') {
            if (layer.feature.properties.car_evolution !== null) {
                switch (layer.feature.properties.car_evolution.substring(0, 7)) {
                    case 'Stade 1':
                        stade1+=1;ratio.push(0);break;
                    case 'Stade 2':
                        stade2+=1;ratio.push(0);break;
                    case 'Stade 3':
                        stade3+=1;ratio.push(0.5);break;
                    case 'Stade 4':
                        stade4+=1;ratio.push(1);break;
                    default :
                        autre=0;
                };
                console.log(layer.feature.properties.loc_statut);
                console.log(layer.feature.properties.car_evolution.substring(0, 7));
            }
        }
    });
    var somme=0;
    var args=0;
    for (var i=0; i<ratio.length; i++) somme+=ratio[i];
    $("#val_atterrissement").text(((somme/ratio.length).toFixed(2))*100 +" %");
    graph_atterrissement("atterrissement", [stade1,stade2,stade3,stade4]);
};
function typologie() {
    var potentielle     = 0;
    var caracterisee    = 0;
    var vue             = 0;
    var disparue        = 0;
    var autre           = 0;
    mare_analyse.eachLayer(function(layer) {
        if (layer.feature.properties.loc_statut !== null) {
            switch (layer.feature.properties.loc_statut) {
                case 'Potentielle':
                    potentielle+=1;break;
                case 'Caractérisée':
                    caracterisee+=1;break;
                case 'Vue':
                    vue+=1;break;
                case 'Disparue':
                    disparue+=1;break;
                default :
                    autre=0;
            };
        }
        
    });
    graph_typologie("typologie", [potentielle,caracterisee,vue,disparue]);
};
function alimentation() {
    var aucune              = 0;
    var rui_voirie          = 0;
    var rui_culture         = 0;
    var source              = 0;
    var nappe               = 0;
    var pluv_bati           = 0;
    var autre               = 0;
    var indetermine         = 0;
    mare_analyse.eachLayer(function(layer) {
        if (layer.feature.properties.loc_statut == 'Caractérisée') {
            if (layer.feature.properties.car_alimentation !== null) {
                var it = layer.feature.properties.car_alimentation.split('|').length;
                for (i = 0; i < it; i++) {
                    switch (layer.feature.properties.car_alimentation.split('|')[i]) {
                        case 'aucune':
                            aucune+=1;break;
                        case 'ruissellement voirie':
                            rui_voirie+=1;break;
                        case 'ruissellement culture':
                            rui_culture+=1;break;
                        case 'source':
                            source+=1;break;
                        case 'nappe':
                            nappe+=1;break;
                        case 'pluvial bâti':
                            pluv_bati+=1;break;
                        case 'autre':
                            autre+=1;break;
                        case 'indéterminée':
                            indetermine+=1;break;
                        default :
                            autre+=0;
                    };
                };
            }
        }
    });
    graph_alimentation("alimentation", [aucune,rui_voirie,rui_culture,source,nappe,pluv_bati,autre,indetermine]);
};
function usage() {
    var inconnu             = 0;
    var abandonne           = 0;
    var autre_valeur_usage  = 0;
    var null_               = 0;
    var prct_usage          = 0;
    mare_analyse.eachLayer(function(layer) {
        if (layer.feature.properties.loc_statut == 'Caractérisée') {
            if (layer.feature.properties.car_usage !== null) {
                //console.log(layer.feature.properties.car_usage);
                var it = layer.feature.properties.car_usage.split('|').length;
                for (i = 0; i < it; i++) {
                    switch (layer.feature.properties.car_usage.split('|')[i]) {
                        case 'Inconnu':
                            inconnu+=1;break;
                        case 'Abandonné':
                            abandonne+=1;break;
                        default :
                            autre_valeur_usage+=1;
                            i=it;
                    };
                };
            } else { null_ +=1;}
        }
    });
    if((autre_valeur_usage)>0) {
        prct_usage = ((autre_valeur_usage)/(inconnu+abandonne+autre_valeur_usage+null_))*100;
    } else {
        prct_usage = 0;
    };
    graph_usage("usage", [inconnu,abandonne,autre_valeur_usage]);
    $("#nb_usage_val_prct").text(prct_usage.toFixed(2)+" %");
    $("#nb_usage_val").text(autre_valeur_usage);
    $("#nb_usage_aba").text(abandonne);
    $("#nb_usage_inc").text(inconnu);
    $("#nb_usage_nul").text(null_);
    
};
function contexte() {
    var dune_cotiere                        =0;
    var falaise_et_rochers_cotiers          =0;
    var tourbiere_acide                     =0;
    var bas_marais_tourbiere_alcaline       =0;
    var marais_continental_sale_ou_saumatre =0;
    var pelouse_seche                       =0;
    var prairie_mesophile                   =0;
    var prairie_humide                      =0;
    var fourres_bosquets                    =0;
    var lande_humide                        =0;
    var lande_seche                         =0;
    var bois_de_feuillus                    =0;
    var bois_de_resineux                    =0;
    var culture                             =0;
    var jardin_parc_cour_de_ferme           =0;
    var carriere                            =0;
    var annexe_routiere_ferroviaire         =0;
    var indetermine                         =0;
    var count                               =0;
    var count_split                         =0;
    mare_analyse.eachLayer(function(layer) {
        if (layer.feature.properties.loc_statut == 'Caractérisée') {
            if (layer.feature.properties.car_contexte !== null) {
                //if (layer.feature.properties.car_contexte.split('|').length > 1) {
                var it = layer.feature.properties.car_contexte.split('|').length;
                for (i = 0; i < it; i++) {
                    switch (layer.feature.properties.car_contexte.split('|')[i]) {
                        case "dûne cotière":
                            dune_cotiere += 1;
                            break;
                        case "falaise et rochers côtiers":
                            falaise_et_rochers_cotiers += 1;
                            break;
                        case "tourbière acide":
                            tourbiere_acide += 1;
                            break;
                        case "bas marais / tourbière alcaline":
                            bas_marais_tourbiere_alcaline += 1;
                            break;
                        case "marais continental salé ou saumâtre":
                            marais_continental_sale_ou_saumatre += 1;
                            break;
                        case "pelouse sèche":
                            pelouse_seche += 1;
                            break;
                        case "prairie mésophile":
                            prairie_mesophile += 1;
                            break;
                        case "prairie humide":
                            prairie_humide += 1;
                            break;
                        case "fourrés, bosquets":
                            fourres_bosquets += 1;
                            break;
                        case "lande humide":
                            lande_humide += 1;
                            break;
                        case "lande sèche":
                            lande_seche += 1;
                            break;
                        case "bois de feuillus":
                            bois_de_feuillus += 1;
                            break;
                        case "bois de résineux":
                            bois_de_resineux += 1;
                            break;
                        case "culture":
                            culture += 1;
                            break;
                        case "jardin, parc, cour (de ferme)":
                            jardin_parc_cour_de_ferme += 1;
                            break;
                        case "carrière":
                            carriere += 1;
                            break;
                        case "annexe routière / ferroviaire":
                            annexe_routiere_ferroviaire += 1;
                            break;
                        case "indéterminé":
                            indetermine += 1;
                    }
                }
            }
        }
    });
    graph_contexte("contexte", [dune_cotiere,falaise_et_rochers_cotiers,tourbiere_acide,bas_marais_tourbiere_alcaline,marais_continental_sale_ou_saumatre,pelouse_seche,prairie_mesophile,prairie_humide,fourres_bosquets,lande_humide,lande_seche,bois_de_feuillus,bois_de_resineux,culture,jardin_parc_cour_de_ferme,carriere,annexe_routiere_ferroviaire,indetermine]);
};




function graph_atterrissement( graph_id, data_) {
    Highcharts.chart(graph_id, {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Atterrissement'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                'Stade 1',
                'Stade 2',
                'Stade 3',
                'Stade 4'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Nb Mares'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:12px">{point.key}: </span>',
            pointFormat: '<b>{point.y}</b>',
            footerFormat: '',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        credits: {
                enabled: false
            },
        series: [{
            name: 'Stades',
            data: data_,
            color:'rgba(217,95,2,.8)'
        }]
    });
}

function graph_typologie( graph_id, data_) {
    bim_ = new Highcharts.chart(graph_id, {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Typologie des mares'
        },
        xAxis: {categories: ['Typologie']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Nb Mares'
            }
        },
        credits: {
                enabled: false
            },
        series: [{
            name: 'Potentielle',
            data: [data_[0]],
            color:'rgba(250,29,37,.8)'
        },{
            name: 'Caractérisée',
            data: [data_[1]],
            color:'rgba(20,120,190,.8)'
        },{
            name: 'Vue',
            data: [data_[2]],
            color:'rgba(61,182,78,.8)'
        },{
            name: 'Disparue',
            data: [data_[3]],
            color:'rgba(0,0,0,.8)'
        }]
    });
};
function graph_alimentation(graph_id, data_) {
    Highcharts.chart(graph_id, {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    legend: {
            layout: 'vertical',
            floating: false,
            backgroundColor: '#FFFFFF',
            align: 'right',
            verticalAlign: 'top',
            y:30
        },
    title: {
        text: 'Alimentation des mares'
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    credits: {
                enabled: false
            },
    series: [{
        name: '',
        colorByPoint: true,
        data: [{
            name: 'Aucune',
            y: data_[0]
            //,sliced: true,
            //selected: true
        }, {
            name: 'Ruisselement Voirie',
            y: data_[1]
        }, {
            name: 'Ruisselement Culture',
            y: data_[2]
        }, {
            name: 'Source',
            y: data_[3]
        }, {
            name: 'Nappe',
            y: data_[4]
        }, {
            name: 'Pluvial bâti',
            y: data_[5]
        }, {
            name: 'Autre',
            y: data_[6]
        }, {
            name: 'Indéterminée',
            y: data_[7]
        }]
    }]
});
};

function graph_usage(graph_id, data_) {
    Highcharts.chart(graph_id, {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    legend: {
            layout: 'vertical',
            floating: false,
            backgroundColor: '#FFFFFF',
            align: 'right',
            verticalAlign: 'top',
            y:30
        },
    title: {
        text: 'Usage des mares'
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    credits: {
                enabled: false
            },
    series: [{
        name: '',
        colorByPoint: true,
        data: [{
            name: 'Inconnu',
            y: data_[0]
            //,sliced: true,
            //selected: true
        }, {
            name: 'Abandonné',
            y: data_[1]
        }, {
            name: 'Avec valeur d\'usage',
            y: data_[2]
        }]
    }]
});
};
function graph_contexte(graph_id, data_) {
    Highcharts.chart(graph_id, {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    legend: {
            layout: 'vertical',
            floating: false,
            backgroundColor: '#FFFFFF',
            align: 'right',
            verticalAlign: 'top',
            y:30
        },
    title: {
        text: 'Contexte des mares'
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    credits: {
                enabled: false
            },
    series: [{
        name: '',
        colorByPoint: true,
        data: [{
            name: 'Dûne cotière',
            y: data_[0]
            //,sliced: true,
            //selected: true
        }, {
            name: 'Falaise Côtière',
            y: data_[1]
        }, {
            name: 'Tourbière Acide',
            y: data_[2]
        }, {
            name: 'Tourbière Alcaline',
            y: data_[3]
        }, {
            name: 'Marais Continental',
            y: data_[4]
        }, {
            name: 'Pelouse Sèche',
            y: data_[5]
        }, {
            name: 'Prairie Mésophile',
            y: data_[6]
        }, {
            name: 'Prairie Humide',
            y: data_[7]
        }, {
            name: 'Fourrés, Bosquet',
            y: data_[8]
        }, {
            name: 'Lande Humide',
            y: data_[9]
        }, {
            name: 'Lande Sèche',
            y: data_[10]
        }, {
            name: 'Bois Feuillus',
            y: data_[11]
        }, {
            name: 'Bois Résineux',
            y: data_[12]
        }, {
            name: 'Culture',
            y: data_[13]
        }, {
            name: 'Jardin, Cour de ferme',
            y: data_[14]
        }, {
            name: 'Carrière',
            y: data_[15]
        }, {
            name: 'Annexe routière',
            y: data_[16]
        }, {
            name: 'Indeterminé',
            y: data_[17]
        }]
    }]
});
}