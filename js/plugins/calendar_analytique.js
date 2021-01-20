// event.id = xxxxxx didsn't work --> BUG FIXED 
// event.id = xxxxxx then $('#calendar').fullCalendar('updateEvent',event); --> NOW THIS WORKS
//var prefix_id = '';
//function check_id_underscore (id_current) {
//    if (id_current.indexOf('_') > -1) {
//        return true
//    } else { return false}
//}

        /* Load events from Bdd
        -----------------------------------------------------------------*/
  $(document).ready(function() {
        /* initialize the calendar
        -----------------------------------------------------------------*/
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            locale: 'fr',
            slotDuration: '00:15:00',
            slotLabelInterval: 15,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            eventReceive: function (event) {
                event.id = event.title+moment(event.start, 'DD MM YYYY HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');
                //console.log(event.start);
                //console.log(event.end);
                save_e(event);
                $('#calendar').fullCalendar('updateEvent',event);
                console.log(event.id);
            },
            eventMouseover: function (event) {
                $('#rendu').text(event.title);
            },
            eventMouseout: function (event) {
                $('#rendu').text('...');
            },
            eventRender: function(event, element) {
                //element.html(event.title + "<span class='closeon glyphicon glyphicon-remove'></span>");
                element.append( "<span class='closeon glyphicon glyphicon-remove'></span>" );
                element.find(".closeon").click(function() {
                    delete_e(event);
                    $('#calendar').fullCalendar('removeEvents',event.id);
                });
                //update_e(event);
            },
            eventDrop: function (event) {
                update_e(event);
            },
            eventResize: function (event) {
                update_e(event);
            },
            //Laisse le choix de supprimer les éléments draggable
            //drop: function() {
            //    // is the "remove after drop" checkbox checked?
            //    if ($('#drop-remove').is(':checked')) {
            //        // if so, remove the element from the "Draggable Events" list
            //        $(this).remove();
            //    }
            //}
            eventSources: [
                // your event source
                {
                    url: "php/ajax/calendar/analytique/load_events_calendar.js.php",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        //custom_param1: 'something',
                        //custom_param2: 'somethingelse'
                        id_user:$('#id_sicen_obs').text()
                    },
                    error: function() {
                        alert('erreur sur le chargement du calendrier !');
                    },
                    succes: function(data) {
                        //Doesn't work no success callback function
                    }
                    //,
                    //color: 'yellow',   // a non-ajax option
                }
            ]
        });
        
        /* Save event in BDD */
        function save_e (event) {
            var __title = event.title;
            var __start = moment(event.start, 'DD MM YYYY HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');
            var __id    = __title+__start;
            var __end   = moment(event.start, 'DD MM YYYY HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');
            var __url   = '';
            var __allday= '';
            var __active= 'true';
            var __color= event.color;
            var __user              = $('#id_sicen_obs').text() ;
            var __projet            = $('#an_projet').val() ;
            var __site              = $('#an_site').val() ;
            var __vehicule          = $('#an_vehicule').val() ;
            var __bv                = $('#an_bv').val() ;
            var __terrain_bureau    = $('#an_terrain_bureau').val() ;
            var __domact            = $('#an_domact').val() ;
            var __comment           = $('#an_comment').val() ;
            
            $.ajax({
                method   : "POST",
                async: false,
                //url: "php/ajax/search_autocomplete_site.js.php",
                url: "php/ajax/calendar/analytique/save_event_calendar.js.php",
                dataType : "text",
                data: {
                    id     : __id    ,
                    title  : __title ,
                    start  : __start ,
                    end    : __end   ,
                    url    : __url   ,
                    allday : __allday,
                    active : __active,
                    color  : __color,
                    user           : __user          ,
                    projet         : __projet        ,
                    site           : __site          ,
                    vehicule       : __vehicule      ,
                    bv             : __bv            ,
                    terrain_bureau : __terrain_bureau,
                    domact         : __domact        ,
                    comment        : __comment       
                    
                },
                success: function( data ) {
                    //response( data );
                    //console.log(data);
                    event.id = data; //IS GOOOOOD
                    //prefix_id = data.split("_")[0]+"_";
                }
            });
        }
        /* Update event in BDD */
        function update_e (event) {
            //if (check_id_underscore(event.id)) {
            //    
            //} else {
            //    event.id = prefix_id+event.id
            //}
            console.log(event.id);
        
            var __id = event.id;
            var __start = moment(event.start, 'DD MM YYYY HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');
            var __end   = moment(event.end, 'DD MM YYYY HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');
            var __title = event.title;
            
            $.ajax({
                method   : "POST",
                async:false,
                //url: "php/ajax/search_autocomplete_site.js.php",
                url: "php/ajax/calendar/analytique/update_event_calendar.js.php",
                dataType : "text",
                data: {
                    id     : __id,
                    start  : __start ,
                    end    : __end   ,
                    title  : __title
                },
                success: function( data ) {
                    //response( data );
                    //console.log(data);
                }
            });
        }
        /* Delete event in BDD */
        function delete_e (event) {
            //if (check_id_underscore(event.id)) {
            //    
            //} else {
            //    event.id = prefix_id+event.id
            //}
            console.log(event.id);
            var __id = event.id;
            $.ajax({
                method   : "POST",
                //url: "php/ajax/search_autocomplete_site.js.php",
                url: "php/ajax/calendar/analytique/delete_event_calendar.js.php",
                dataType : "text",
                data: {
                    id     : __id
                },
                success: function( data ) {
                    //response( data );
                    //console.log(data);
                }
            });
        }
        //Load data (events) in datatable
        load_events_in_datatable();
        liste_projet_analytique();
        display_graph();
        
  });

function create_external_event () {
        $('#external-events .fc-event').each(function() {
            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true, // maintain when user navigates (see docs on the renderEvent method)
                color: $(this).css("background-color"),
                nb_: $(this).attr("nb")
            });
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
        };

function loadEventsFromBDD () {
    $.ajax({
                    url: "php/ajax/calendar/analytique/load_events_calendar.js.php",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        //custom_param1: 'something',
                        //custom_param2: 'somethingelse'
                    },
                    error: function() {
                        alert('erreur sur le chargement du calendrier !');
                    },
                    succes: function(data) {
                        console.log('chargé');
                        console.log('Loaded');
                        console.log(data);
                    }
    });
}























