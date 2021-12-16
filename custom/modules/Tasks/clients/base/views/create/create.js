({
    extendsFrom: 'CreateView',

    events: {
        'change [name=tipo_tarea_c]': 'actualizaAsunto',
    },

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.on('render',this.disableparentsfields,this);
		this.on('render',this.ocultaTipoTarea,this);
        this.model.addValidationTask('valida_cuenta_no_contactar', _.bind(this.valida_cuenta_no_contactar, this));
        this.model.addValidationTask('checkdate', _.bind(this.checkdate, this));
		this.model.addValidationTask('valida_asignado', _.bind(this.valida_asignado, this));
		this.model.on('change:ayuda_asesor_cp_cfz', this._ValoresPredetAsesor, this);
		this.model.on('change:parent_name', this._ValoresPredetAsesor, this);
        this.model.addValidationTask('validaRelLeadTask', _.bind(this.validaRelLeadTask, this));		
        this.model.addValidationTask('valida_requeridos', _.bind(this.valida_requeridos, this));
        this.model.addValidationTask('valida_atrasada', _.bind(this.valida_atrasada, this));
        this.model.addValidationTask('valida_usuarios_inactivos',_.bind(this.valida_usuarios_inactivos, this));
        
        this.deleteOportunidadRecuperacion();

        this.events['change input[name=name]'] = 'actualizaAsunto';

    },

    _render: function () {
        this._super("_render");
    },

    /* @Alvador Lopez Y Adrian Arauz
    Oculta los campos relacionados
    */
    disableparentsfields:function () {
        // if(this.createMode){//Evalua si es la vista de creacion
        //     if(this.model.get('parent_id')!=undefined){
        //         this.$('[data-name="parent_name"]').attr('style','pointer-events:none;')
        //     }
        // }
		if(this.model.get('parent_name')) {
			this.noEditFields.push('parent_type');
			this.noEditFields.push('parent_name');
			this.$('[data-name="parent_type"]').attr('style', 'pointer-events:none');
			this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none');
		}
		if(this.model.get('parent_type') == "Accounts" && this.model.get('parent_id') != "" && this.model.get('parent_id') != null && this.model.get('parent_id') != 'undefined') {
			var params = {
				'account_id': this.model.get('parent_id'),
			};
			var urlGetSolicitudes = app.api.buildURL("getSolicitudes", '', {}, {});
			app.api.call("create", urlGetSolicitudes, params, {
                success: _.bind(function (data) {
					this.model.set('solicitud_alta_c',0);
                    if(data == 0) this.model.set('solicitud_alta_c',1);
                }, this)
            });
		}
		this.noEditFields.push('solicitud_alta_c');
		this.$('[data-name="solicitud_alta_c"]').attr('style', 'pointer-events:none');
		if (App.user.attributes.puestousuario_c=='27'||App.user.attributes.puestousuario_c=='31') {
			//Oculta Check ayuda
			this.$('[data-name=ayuda_asesor_cp_c]').hide(); 
        }
        this.isAyudaVisible();
		this.$('[data-name=puesto_c]').hide();
		this.$('[data-name=tasks_opportunities_1_name]').hide();
		this.$('[data-name=solicitud_alta_c]').hide();
		this.$('[data-name=potencial_negocio_c]').hide();
		this.$('[data-name=fecha_calificacion_c]').hide();
		this.$('[data-name=motivo_potencial_c]').hide();
		this.$('[data-name=detalle_motivo_potencial_c]').hide();
    },

    isAyudaVisible:function(){
        if(this.model.get('parent_type')=="Leads"){
            this.$('[data-name=ayuda_asesor_cp_c]').hide(); 
        }
    },
	
    ocultaTipoTarea:function(){
        if(app.user.attributes.puestousuario_c != 27 && app.user.attributes.puestousuario_c != 31 && app.user.attributes.puestousuario_c != 61 ){
            this.$('[data-name=tipo_tarea_c]').hide();
        }
    },	

    valida_cuenta_no_contactar:function (fields, errors, callback) {
		if(!app.user.attributes.tct_no_contactar_chk_c && !app.user.attributes.bloqueo_credito_c && !app.user.attributes.bloqueo_cumple_c) {
			if (this.model.get('parent_id') && this.model.get('parent_type') == "Accounts") {
				var account = app.data.createBean('Accounts', {id:this.model.get('parent_id')});
				account.fetch({
					success: _.bind(function (model) {
						var url = app.api.buildURL('tct02_Resumen/' + this.model.get('parent_id'), null, null);
						app.api.call('read', url, {}, {
							success: _.bind(function (data) {
								if (data.bloqueo_cartera_c || data.bloqueo2_c || data.bloqueo3_c) {
									app.alert.show("cuentas_no_contactar", {
										level: "error",
										title: "Cuenta No Contactable<br>",
										messages: "Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
										autoClose: false
									});
									app.error.errorName2Keys['custom_message1'] = '';
									errors['cliente'] = errors['cliente'] || {};
									errors['cliente'].custom_message1 = true;
									//Cerrar vista de creación de solicitud
									if (app.drawer.count()) {
										app.drawer.close(this.context);
										//Ocultar alertas excepto la que indica que no se pueden crear relacionados a Cuentas No Contactar
										var alertas=app.alert.getAll();
										for (var property in alertas) {
											if(property != 'cuentas_no_contactar'){
												app.alert.dismiss(property);
											}
										}
									} else {
										app.router.navigate(this.module, {trigger: true});
									}
								}
								callback(null, fields, errors);
							}, this)
						});
					}, this)
				});
			}else {
				callback(null, fields, errors);
			}
		} else {
			callback(null, fields, errors);
		}
    },

    checkdate: function (fields, errors, callback) {
        var temp1=this.model.get('date_start');
        var temp3=this.model.get('date_due');
        if(temp1!=null && temp1!=undefined && temp3!=null && temp3!=undefined) {
            var temp2 = temp1.split('T');
            var start_date = temp2[0];
            var temp4 = temp3.split('T');
            var due_date = temp4[0];
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            today = yyyy + '-' + mm + '-' + dd;

            if (start_date < today) {
                app.alert.show("start_invalid", {
                    level: "error",
                    title: "La fecha de inicio no puede ser menor al d\u00EDa de hoy",
                    autoClose: false
                });
                errors['date_start'] = errors['date_start'] || {};
                errors['date_start'].datetime = true;
            }
            if (due_date < today) {
                app.alert.show("due_invalid", {
                    level: "error",
                    title: "La fecha de vencimiento no puede ser menor al d\u00EDa de hoy",
                    autoClose: false
                });
                errors['date_due'] = errors['date_due'] || {};
                errors['date_due'].datetime = true;
            }
        }
        callback(null,fields,errors);
    },
	
	/*
	Erick de Jesus check ayuda CP 
	*/
	_ValoresPredetAsesor: function () {
		var parent_nombre="";
		var fechaini = "";
		var tomorrow = new Date();
		var puesto = App.user.attributes.puestousuario_c; //27=> Agente Tel, 31=> Coordinador CP,
		
        if(this.model.get('ayuda_asesor_cp_c') == '1') {
			
			var module = this.model.get('parent_type');
			var parent_id = this.model.get('parent_id');
				
			if((module == "Accounts" || module == "Leads") && (parent_id != "" && parent_id != null && parent_id != 'undefined')){
			
				this.model.set('name', "AYUDA CP");
				var reg_parent = app.data.createBean(module, {id:this.model.get('parent_id')});
				reg_parent.fetch({
					success: _.bind(function (model) {
						//parent_nombre = model.get('name');
						this.model.set('name', "AYUDA CP - "+model.get('name'));
					}, this)
				});
				
			}else{
				this.model.set('name', "AYUDA CP");
			}
        }
        // else{
        //     this.model.set('name', '');
		// 	this.model.set('date_due', '');
        // }
		
		if(this.model.get('parent_type') == "Accounts" && this.model.get('parent_id') != "" && this.model.get('parent_id') != null && this.model.get('parent_id') != 'undefined') {
			var params = {
				'account_id': this.model.get('parent_id'),
			};
			var urlGetSolicitudes = app.api.buildURL("getSolicitudes", '', {}, {});
			app.api.call("create", urlGetSolicitudes, params, {
                success: _.bind(function (data) {
					this.model.set('solicitud_alta_c',0);
                    if(data == 0) this.model.set('solicitud_alta_c',1);
                }, this)
            });
		}
    },
	
	/*
	Erick de Jesus valida usuario asesor telefonico asignado cuando el check de ayuda esta activo 
	*/
	valida_asignado:function (fields, errors, callback) {        
		if (this.model.get('ayuda_asesor_cp_c') == '1'){
			
			var user = app.data.createBean('Users', {id:this.model.get('assigned_user_id')});
            user.fetch({
                success: _.bind(function (model) {
                    if(model.get('puestousuario_c')!= '27'){

                        app.alert.show("El usuario asignado debe ser Agente Telefónico", {
                            level: "error",
                            title: "Usuario asignado",
                            messages: "El usuario asignado debe ser Agente Telefónico",
                            autoClose: false
                        });

                        errors['assigned_user_id'] = errors['assigned_user_id'] || {};
						errors['assigned_user_id'].required = true;

                    }
					callback(null, fields, errors);
                }, this)
            });
        }else{
			callback(null, fields, errors);
		}        
    },

    validaRelLeadTask: function (fields, errors, callback) {
        
        if (this.model.get('parent_id') && this.model.get('parent_type') == "Leads") {
            
            var lead = app.data.createBean('Leads', {id: this.model.get('parent_id')});
            lead.fetch({
                success: _.bind(function (model) {

                   if (model.get('subtipo_registro_c') == '3') {

                        app.alert.show("lead-cancelado-task", {
                            level: "error",
                            title: "Lead Cancelado<br>",
                            messages: "No se puede agregar una relación con Lead Cancelado",
                            autoClose: false
                        });

                        app.error.errorName2Keys['custom_message2'] = '';
                        errors['cliente'] = errors['cliente'] || {};
                        errors['cliente'].custom_message2 = true;

                        //Cerrar vista de creación
                        if (app.drawer.count()) {
                            app.drawer.close(this.context);
                            //Ocultar alertas excepto la que indica que no se pueden crear relacionados a Lead Cancelado
                            var alertas = app.alert.getAll();
                            for (var property in alertas) {
                                if (property != 'lead-cancelado-task') {
                                    app.alert.dismiss(property);
                                }
                            }
                        } else {
                            app.router.navigate(this.module, {trigger: true});
                        }

                    }
                    callback(null, fields, errors);
                }, this)
            });
        
        } else {
            callback(null, fields, errors);
        }
    },

    valida_requeridos: function (fields, errors, callback) {
        var campos = "";
        _.each(errors, function (value, key) {
            _.each(this.model.fields, function (field) {
                if (_.isEqual(field.name, key)) {
                    if (field.vname) {
                        if (field.vname == 'LBL_DUE_DATE') {
                            campos = campos + '<b>Fecha de vencimiento</b><br>';
                        }
                        if (field.vname == 'LBL_START_DATE') {
                            campos = campos + '<b>Fecha Inicio</b><br>';
                        }
                        else {
                            if (field.vname == 'LBL_DETALLE_MOTIVO_POTENCIAL') {
                                campos = campos + '<b>Detalle</b><br>';
                            }
                            else {
								if (field.vname == 'LBL_POTENCIAL_NEGOCIO') {
									campos = campos + '<b>Potencial de Negocio</b><br>';
								}
								else {
									campos = campos + '<b>' + app.lang.get(field.vname, "Calls") + '</b><br>';
								}
                            }
                        }
                    }
                }
            }, this);
        }, this);
        if (campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Tarea:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },
    valida_atrasada: function (fields, errors, callback) {
        
        if(this.model.get('status')=='Atrasada'){
            app.alert.show("atrasada_invalid", {
                level: "error",
                title: "No se puede guardar una tarea con estado <b>Atrasada</b>. Seleccione otra opci\u00F3n para continuar",
                autoClose: false
            });
            errors['status'] = errors['status'] || {};
            errors['status'].required = true;

        }
        
        callback(null, fields, errors);
    },

    deleteOportunidadRecuperacion(){
        if (this.model.get('parent_type') == 'Accounts' && this.model.get('parent')!=null && this.model.get('parent')!=undefined) {
            //la opción de CAC Oportunidad Recuperación solo se muestra para Cliente Perdido, 
            //tipo_registro_cuenta_c:Cliente: 3, 
            //subtipo_registro_cuenta_c:Perdido: 17
            var opciones_default = app.lang.getAppListStrings('tipo_tarea_list');
                Object.keys(opciones_default).forEach(function (key) {
                    if (key == "CAC Oportunidad Recuperacion") {
                        delete opciones_default[key];
                    }
                });
            this.model.fields['tipo_tarea_c'].options = opciones_default;

            if (this.model.get('parent').tipo_registro_cuenta_c == '3' && this.model.get('parent').subtipo_registro_cuenta_c=='17') {
                var opciones_full=app.lang.getAppListStrings('tipo_tarea_list');
                //Cuando es Cliente Perdido, solo se muestra la Opción de Oportunidad Recuperación
                Object.keys(opciones_full).forEach(function (key) {
                    if (key != "CAC Oportunidad Recuperacion" && key != "CAC Informativa") {
                        delete opciones_full[key];
                    }
                });
                this.model.fields['tipo_tarea_c'].options = opciones_full;
            }

        }
    },

    actualizaAsunto:function(e){
        var asunto="";
        if(this.model.get('tipo_tarea_c')!="" && this.model.get('tipo_tarea_c')!=null){
            var asunto="";
            if(this.model.get('tipo_tarea_c')!=""){
                var tipo_tarea=this.model.get('tipo_tarea_c');
    
                //Antes de concatenar, se resetea valor de nombre, para que solo tome el propio asunto y no concatene sobre lo que ya se ha escrito
                var asunto=this.model.get('name');
                if(asunto !="" && asunto !=undefined){
                    var asunto_split=asunto.split(':');
                    var asunto_inicial=asunto_split[asunto_split.length-1];
                    asunto=App.lang.getAppListStrings("tipo_tarea_list")[tipo_tarea]+": "+asunto_inicial.trim();
                    this.model.set("name",asunto);
                    $('[data-fieldname="name"]').find('input[name="name"]').val(asunto);
    
                }
            }
        }else{
            var asunto=this.model.get('name');
            if(asunto !="" && asunto !=undefined){
                var asunto_split=asunto.split(':');
                var asunto_inicial=asunto_split[asunto_split.length-1];
                asunto=asunto_inicial;

                this.model.set("name",asunto);

            }
        }
    },
    valida_usuarios_inactivos:function (fields, errors, callback) {
        var ids_usuarios='';
            if(this.model.attributes.assigned_user_id) {
              ids_usuarios+=this.model.attributes.assigned_user_id;
            }
            console.log("Valor del ID del asignado: ".ids_usuarios);
            ids_usuarios += ',';
        if(ids_usuarios!="") {
          //Generar petición para validación
          app.api.call('GET', app.api.buildURL('GetStatusOfUser/' + ids_usuarios+'/inactivo'), null, {
              success: _.bind(function(data) {
                  if(data.length>0){
                      var nombres='';
                      //Armando lista de usuarios
                      for(var i=0;i<data.length;i++){
                          nombres+='<b>'+data[i].nombre_usuario+'</b><br>';
                      }
                      app.alert.show("Usuarios", {
                          level: "error",
                          messages: "No es posible generar una tarea con el siguiente usuario inactivo:<br>"+nombres,
                          autoClose: false
                      });
                      errors['usuariostatus'] = errors['usuariostatus'] || {};
                      errors['usuariostatus'].required = true;
                  }
                  callback(null, fields, errors);
              }, this)
          });
        }
        else {
          callback(null, fields, errors);
        }
    },
})