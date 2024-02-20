({ 
    extendsFrom: 'SubpanelListView',

     initialize: function(options) {   
        self = this; 
        this._super("initialize", [options]);

        this.events = _.extend({}, this.events, {
            'click [name="btn-start-meeting"]' : 'iniciarReunionFromSubpanel',
        });

    },

    iniciarReunionFromSubpanel: function(event){

        var index = $(event.currentTarget).closest('tr').index();
        var currentModel = this.collection.models[index];

        var status = currentModel.get('status');

        if( status != "Planned" ){

            app.alert.show("not_planned_alert",{
                level: "error",
                title: "Error",
                messages: "La Reunión no se encuentra Planificada",
                autoClose: false
            });

            return;

        }else{

            var fechaActual = new Date(); //obtiene fecha actual
            var fechainicio = new Date(currentModel.get("date_start"));
            var d = fechainicio.getDate();
            var m = fechainicio.getMonth() + 1;
            var y = fechainicio.getFullYear();
            var fechafin= new Date(y,m-1,d+1, 2,0); //Fecha final

            if (currentModel.get('assigned_user_id')==app.user.attributes.id /* && (currentModel.get('check_in_time_c')=='' || currentModel.get('check_in_time_c')==null) */
                && fechaActual>fechainicio && fechaActual<fechafin && currentModel.get('status')=='Planned'){

                    //Se obtienen coordenadas
                    this.getLocation(currentModel);
            }else if( App.user.get('lenia_c') == 1 ){

                app.alert.show("alert_error_meeting",{
                    level: "error",
                    title: "Error",
                    messages: "No cuentas con el privilegio para iniciar reunión de este tipo",
                    autoClose: false
                });

                return;

            }else{

                app.alert.show("alert_error_meeting",{
                    level: "error",
                    title: "Error",
                    messages: "No se cumplen las condiciones para <b>Iniciar Reunión</b>, favor de verificar ",
                    autoClose: false
                });

                return;
            }
        }
    },

    getLocation: function ( model ){
        self=this;
        self.model = model;
        var today= new Date();
        self.model.set('check_in_time_c', today);
        self.model.set('check_in_platform_c', self.getPlatform());
        self.model.set('minuta_reunion_status_c', 'Iniciada');
        self.model.set('date_start', today);
        if(navigator.geolocation){
            app.alert.show('checkin_alert', {
                level: 'process',
                title: 'Realizando Check-in, favor de esperar'
            });
            navigator.geolocation.getCurrentPosition(this.showPosition,this.showError);
        }else {
            alert("No se pudo encontrar tu ubicacion");
        }

        //self.model.save();
    },

    //Obtiene la plataforma del usuario en la cual haya hecho check-in
    getPlatform: function(){
        var plataforma=navigator.platform;
        if(plataforma!='iPad'){
            return 'Pc';
        }else{
            return 'iPad';
        }
    },

    showPosition:function(position) {
        self.model.set('check_in_longitude_c', position.coords.longitude);
        self.model.set('check_in_latitude_c',position.coords.latitude);
        self.model.save();
        self.render();

        app.alert.dismiss('checkin_alert');
        app.alert.show('alert_check-in_success', {
                level: 'success',
                messages: 'Check-in Existoso',
            });
        
        self.createMinuta();
        
        //SUGAR.App.controller.context.reloadData({});
    },

    showError:function(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("Permiso de geolocalizaci\u00F3n no autorizado")
            break;
                case error.POSITION_UNAVAILABLE:
                alert("La informaci\u00F3n de la geolocalizaci\u00F3n no está disponible");
                break;
            case error.TIMEOUT:
                alert("El tiempo de espera a terminado");
                break;
            case error.UNKNOWN_ERROR:
                alert("A ocurrido un error desconocido");
                break;
        }
        self.model.save();
        self.render();
        SUGAR.App.controller.context.reloadData({});
    },

    createMinuta:function(){
        var parentModel = this.context.attributes.parentModel;
        var modelMinuta=App.data.createBean('minut_Minutas');
        // FECHA ACTUAL
        var startDate = new Date(self.model.get('date_end'));
        var startMonth = startDate.getMonth() + 1;
        var startDay = startDate.getDate();
        var startYear = startDate.getFullYear();
        var startDateText = startDay + "/" + startMonth + "/" + startYear;
        var objetivo=App.lang.getAppListStrings('objetivo_list');
        modelMinuta.set('account_id_c', parentModel.get('id') );
        modelMinuta.set('tct_relacionado_con_c', parentModel.get('name'));
        modelMinuta.set('objetivo_c', self.model.get('objetivo_c'));
        modelMinuta.set('minut_minutas_meetingsmeetings_idb',self.model.get('id'));
        modelMinuta.set('minut_minutas_meetings_name',self.model.get('name'));
        modelMinuta.set('name',"Minuta de Reunión: " +self.model.get('name') );

        var parent_meet = this.model.get('parent_type');
        var parent_id_acc = this.model.get('parent_id');

        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'minut_Minutas',
                    model: modelMinuta,
                    modelMeeting : self.model
                },
            },
          function(variable){
              //alert('Drawer Cerrado');
              location.reload();
              //self.MotivoCanc_flag = 1;
              //self.render();
          }
        );
        //}
    },


})