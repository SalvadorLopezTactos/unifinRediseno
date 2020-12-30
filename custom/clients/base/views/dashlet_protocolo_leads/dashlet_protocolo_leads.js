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
        this.viewEnable=false;
        this.getRegistrosAsignados();

        //this.getLeadsAplazadosCancelados();
    },

    /*
    Función ejecutada para saber si la información se debe de mostrar
    */
    getRegistrosAsignados:function(){

    	var id_user=App.user.attributes.id;
    	App.alert.show('obtieneAsignados', {
    				level: 'process',
    				title: 'Cargando',
    			});

    	app.api.call('GET', app.api.buildURL('GetRegistrosAsignadosForProtocolo/' + id_user), null, {
            success: function (data) {
            	App.alert.dismiss('obtieneAsignados');
            	if(data.total_asignados<20){ //Las opciones de protocolo solo serán visibles cuando el usuario tiene menos de 20 registros asignados
            		self.viewEnable='1';
            		self.getLeadsAplazadosCancelados();
            	}else{
            		self.viewEnable=false;
            		self.render();
            	}
            },
            error: function (e) {
                throw e;
            }
        });

    },

    asignarCP: function (evt) {

    	app.alert.show('navigateToNotificationCP', {
    		level: 'confirmation',
    		messages: 'Se notificará a Asesor Telefónico para que se le asigne un nuevo Lead',
    		autoClose: false,
    		onConfirm: function(){
    			App.alert.show('asignaLeadCP', {
    				level: 'process',
    				title: 'Procesando',
    			});

    			//Obtener los agentes telefónicos disponibles para generarle el registro de tarea
    			app.api.call("read", app.api.buildURL("GetSiguienteAgenteTel", null, null, {}), null, {
                    success: _.bind(function (data) {
                        if(data!=""){
                        	var idAsesor=data;
                        	var usuario=App.user.get('full_name');
                        	var date= new Date();
                        	var fechaString=date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate()+" 05:00:00";

                        	var jsonDate = (new Date()).toJSON();

                        	var bodyTask={
                        		"name":"Asignar Lead a "+usuario,
                        		"priority":"High",
                        		"assigned_user_id":idAsesor,
                        		"date_start": jsonDate
                        	};

                        	app.api.call("create", app.api.buildURL("Tasks", null, null, bodyTask), null, {
                        		success: _.bind(function (data) {
                        			console.log("TAREA CREADA CORRECTAMENTE AL ASESOR");
                        			App.alert.dismiss('asignaLeadCP');
                        			app.alert.show('taskCreteSuccess', {
                        				level: 'success',
                        				messages: 'Proceso completo<br>El agente encargado de gestionar la asignación es: '+data.assigned_user_name,
                        				autoClose: false
                        			});

                        		},this)});

                        }
                    }, this)
                });


    		
    		},
    		onCancel: function(){
    			
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

    	//Obtiene registros cargados a través de carga de layout
    	app.alert.show('assignLeadFromDB', {
    		level: 'confirmation',
    		messages: 'Se asignará un Lead obtenido de una base de datos especial<br>¿Está seguro?',
    		autoClose: false,
    		onConfirm: function(){
    			//Obtiene registros provenientes de la bd especial
    			App.alert.show('asignaFromDB', {
    				level: 'process',
    				title: 'Procesando',
    			});

    			//Se obtiene valor de una lista, para que el nombre del archivo de carga sea dinámico
    			var nombre_archivo=App.lang.getAppListStrings('nombre_archivo_protocolo_leads_list')[1];

    			app.api.call("read", app.api.buildURL("Leads/", null, null, {
                    "filter": [
                        {
                        	"nombre_de_cargar_c": {
                        		"$equals":nombre_archivo
                            }
                        }
                    ]
                }), null, {
                    success: _.bind(function (data) {

                    	if(data.records.length>0){
	                    	var url = app.api.buildURL('Leads/' + data.records[0].id, null, null);
                    		var api_params = {};
		    				api_params['assigned_user_id']=App.user.get('id');
		    				api_params['assigned_user_name']=App.user.get('full_name');
		    				//Se modifica nombre de carga para evitar obtener nuevamente el registro ya asignado
		    				api_params['nombre_de_cargar_c']="";

	    					app.api.call('update', url, api_params, {
	    						success: _.bind(function (data) {
	    							app.alert.dismiss('asignaFromDB');
	    							var mensaje='Se ha asignado el registro: '+'<a href="#Leads/'+data.id+'">'+data.name+'</a>';

	    							app.alert.show('assignFromDB', {
		    							level: 'success',
		    							messages: mensaje,
		                    		});
	                			})
	            			});
            			}else{

            				app.alert.show('sinRegistrosDB', {
            					level: 'warning',
            					messages: 'No existen registros disponibles para asignar',
            					autoClose: true
            				});

            				app.alert.dismiss('asignaFromDB');
            			}
                    	
                    }, this)
                });//Fin api call obtener registros de la bd

    		},//OnConfirm
    		onCancel: function(){
    			
    		}//onCancel
    	});
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
        //subtipo_registro_c=3, LEAD CANCELADO
        var filtro={
        	"filter":[
        		{
        			"$or":[
        				{
        					"status_management_c": {
                        		"$in":['2','3']
                            }
        				},
        				{
        					"subtipo_registro_c": {
        						"$in":['3']
                            }
        				},
        			]
        		}
        	]

        };

        app.api.call("read", app.api.buildURL("Leads/", null, null, filtro), null, {
                    success: _.bind(function (data) {

                    	App.alert.dismiss('getLeadsCancelados');
                    	self.registros=data.records;
                        
                        self.render();
                    }, this)
                });

    },

    _render: function () {
        this._super("_render");

    },

})