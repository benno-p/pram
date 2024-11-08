    $(document).ready(function() {
        /* initialize the external events
        -----------------------------------------------------------------*/
        count_events_from_bdd = 0;
        count_new_events      = 0;
        id_ola                    = '';

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


        /* Load events from Bdd
        -----------------------------------------------------------------*/

        /* initialize the calendar
        -----------------------------------------------------------------*/
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            locale: 'fr',
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            eventReceive: function (event) {
                //suppression des events l'identifiant n'est pas bon
                //for (gevents of $('#calendar').fullCalendar( 'clientEvents')) { // WAS ACTIVE 18-01-2018
                //    $('#calendar').fullCalendar('removeEvents',gevents.id); // WAS ACTIVE 18-01-2018
                //}; // WAS ACTIVE 18-01-2018
                //Demande a qui est attribue l'equipement
                var person = prompt("Qui emprunte l'équipement ?", "");
                if (person != null) {
                    event.title += " "+person;
                }
                if (event.nb_ > 1) {
                    var nb_ = prompt("Combien ? ("+event.nb_+")", "");
                } else { var nb_ = "" };
                    event.title += " "+nb_;
                //console.log(event);
                event.id = event.title+moment(event.start, 'DD MM YYYY HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');;
                //Mise à jour de l'event
                $('#calendar').fullCalendar('updateEvent',event);
                //$('#calendar').fullCalendar('renderEvent',event, true);
                
                
                //$('#calendar').fullCalendar( 'refetchEvents' ); // WAS ACTIVE 18-01-2018
                save_e(event);
                //$('#calendar').fullCalendar( 'refetchEvents' ); // WAS ACTIVE 18-01-2018
                
            },
            eventMouseover: function (event) {
                $('#rendu').text(event.title);
            },
            eventMouseout: function (event) {
                $('#rendu').text('...');
            },
            eventRender: function(event, element) {
                element.append( "<span class='closeon glyphicon glyphicon-remove'></span>" );
                element.find(".closeon").click(function() {
                    //console.log('close done');
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
                    url: "php/ajax/calendar/load_events_calendar.js.php",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        //custom_param1: 'something',
                        //custom_param2: 'somethingelse'
                    },
                    error: function() {
                        alert('erreur sur le chargement du calendrier !');
                    },
                    succes: function() {
                        console.log('Loaded');
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
            
            //console.log(__title);
            //console.log(__start);
            //console.log(__end);
            //console.log(__end  );
            
            $.ajax({
                method   : "POST",
                //url: "php/ajax/search_autocomplete_site.js.php",
                url: "php/ajax/calendar/save_event_calendar.js.php",
                dataType : "text",
                data: {
                    id     : __id    ,
                    title  : __title ,
                    start  : __start ,
                    end    : __end   ,
                    url    : __url   ,
                    allday : __allday,
                    active : __active,
                    color  : __color
                },
                success: function( data ) {
                    //response( data );
                    //console.log(data);
                }
            });
        }
        /* Update event in BDD */
        function update_e (event) {
        //console.log(event.id);
            var __id = event.id;
            var __start = moment(event.start, 'DD MM YYYY HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');
            var __end   = moment(event.end, 'DD MM YYYY HH:mm:ss').format('DD-MM-YYYY HH:mm:ss');
            $.ajax({
                method   : "POST",
                //url: "php/ajax/search_autocomplete_site.js.php",
                url: "php/ajax/calendar/update_event_calendar.js.php",
                dataType : "text",
                data: {
                    id     : __id,
                    start  : __start ,
                    end    : __end   ,
                },
                success: function( data ) {
                    //response( data );
                    //console.log(data);
                }
            });
        }
        /* Delete event in BDD */
        function delete_e (event) {
        //console.log(event.id);
            var __id = event.id;
            $.ajax({
                method   : "POST",
                //url: "php/ajax/search_autocomplete_site.js.php",
                url: "php/ajax/calendar/delete_event_calendar.js.php",
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
    });

