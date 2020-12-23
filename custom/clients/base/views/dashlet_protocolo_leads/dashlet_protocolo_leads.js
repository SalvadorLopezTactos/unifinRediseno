({
    plugins: ['Dashlet'],

    events: {
        'click #assign_cp': 'asignarCP',
        'click #assign_asesor': 'asignarPorAsesor',
        'click #assign_bd': 'asignarPorBD',
        'click #assign_cancel': 'asignarPorCancelados',
        'click .modalRecordsCancel': 'closeModal',
        'click .btnLeadSelect': 'activarLead',

    },

    registros:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        self=this;
        this.getLeadsAplazadosCancelados();
    },

    asignarCP: function (evt) {

    	app.alert.show('navigateToNotificationCP', {
    		level: 'confirmation',
    		messages: 'Se le enviará una notificación al Centro de Prospección.<br>¿Está seguro?',
    		autoClose: false,
    		onConfirm: function(){
    			alert("Enviando notificación...");
    		},
    		onCancel: function(){
    			alert("Cancelando operación!..");
    		}
    	});
    },

    asignarPorAsesor:function(evt){

    	var objLead = {
            action: 'edit',
            copy: true,
            create: true,
            layout: 'create',
            module: 'Leads',
            dataFromProtocolo:'1'
        };

    	app.controller.loadView(objLead);

    	// update the browser URL with the proper
    	app.router.navigate('#Leads/create', {trigger: false});

    },

    asignarPorBD:function(){

    	//Obtener registros para asignar automáticamente
    	alert("Asignación por base de datos");

    },

    asignarPorCancelados:function(){

    	if(this.registros.length==0){
    		app.alert.show('sinCancelados', {
    			level: 'warning',
    			messages: 'No existen registros de Leads Cancelados / Aplazados',
    			autoClose: true
			});

    	}
    	else{
    		var modal = $('#modalRecordsCancel');
            if (modal) {
                modal.show();
            }
    	}
    	
    },

    closeModal:function(){
    	
    	var modal = $('#modalRecordsCancel');
    	if (modal) {
    		modal.hide();
      	}
    },

    activarLead:function(evt){

    	var nombre=$(evt.currentTarget).parent().parent().children().eq(0).children().html();
    	var id=$(evt.currentTarget).attr('data-id');

    	app.alert.show('confirmActivation', {
    		level: 'confirmation',
    		messages: 'Se procederá a activar el siguiente registro:<br>'+nombre+'<br>¿Estás seguro?',
    		autoClose: false,
    		onConfirm: function(){
    			var url = app.api.buildURL('Leads/' + id, null, null);

    			App.alert.show('activaLead', {
    				level: 'process',
    				title: 'Activando Lead, por favor espere',
    			});

    			var api_params = {};
    			api_params['lead_cancelado_c']=0;
    			api_params['motivo_cancelacion_c']="";
    			api_params['status_management_c']="1";//Activo
    			api_params['subtipo_registro_c']="1";//Sin Contactar

    			app.api.call('update', url, api_params, {
    				success: _.bind(function (data) {
    					app.alert.dismiss('activaLead');

    					var mensaje='Se ha actualizado el Lead: '+'<a href="#Leads/'+data.id+'">'+data.name+'</a>';

    					app.alert.show('activaLeadSuccess', {
    						level: 'success',
    						messages: mensaje,
                    	});

                    	var indice=self.searchIndex(self.registros,id);
                    	self.registros.splice(indice, 1);
                    	self.render();
                })
            });
    		},
    		onCancel: function(){
    			
    		}
    	});

    },

    searchIndex:function(arreglo,id){

    	var index=-1;

    	if(arreglo.length>0){

    		for (var i =0;i <arreglo.length; i ++) {
    			if(arreglo[i].id==id){
    				index=i;
    			}
    		}
    	}

    	return index;
    	
    },

    getLeadsAplazadosCancelados:function(){

        App.alert.show('getLeadsCancelados', {
            level: 'process'
        });

        app.api.call("read", app.api.buildURL("Leads/", null, null, {
                    "filter": [
                        {
                        	"status_management_c": {
                        		"$in":['2','3']
                            }
                        }
                    ]
                }), null, {
                    success: _.bind(function (data) {

                    	App.alert.dismiss('getLeadsCancelados');
                    	self.registros=data.records;
                        
                        self.render();
                    }, this)
                });

    },




})