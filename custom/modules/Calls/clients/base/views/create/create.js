({
    extendsFrom: 'CreateView',
    personasRelData_list: null,
    initialize: function (options) {
      	var createViewEvents = {};
        createViewEvents['focus [data-name=campana_rel_c]'] = 'abre';
	      this.events = _.extend({}, this.events, createViewEvents);
        this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);
        this.on('render', this.disableparentsfields, this);
        // this.on('render',this.disabledates,this);
        this.on('render', this.noestatusedit, this);
		this.model.on('change:padres_c', this.llenaLlamada, this);
        // this.model.on("change:date_start_date", _.bind(this.validaFecha, this));
        this.model.addValidationTask('valida_cuenta_no_contactar', _.bind(this.valida_cuenta_no_contactar, this));
        //this.model.on("change:tct_conferencia_chk_c", _.bind(this.ocultaConferencia, this));
        this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicialCall, this));
        //this.model.addValidationTask('rqueridoPErsona', _.bind(this.reqPersona, this));
        this.model.addValidationTask('valida_requeridos', _.bind(this.valida_requeridos, this));
        this.on('render', this.hidePErsonaEdit, this);
        this.model.addValidationTask('validaRelLeadCall', _.bind(this.validaRelLeadCall, this));
        this.model.addValidationTask('valida_usuarios_inactivos',_.bind(this.valida_usuarios_inactivos, this));
		this.model.addValidationTask('avisa_persona',_.bind(this.avisa_persona, this));
		this.on('render', this.hideLlamadas, this);
        this.omiteLlamadaPreventiva();
         // @author Erick de jesus	//Se manda a llamar función para omitir opción de puesto de investigacion de mercados
         this.llamadaInvMercados();
        
    },

    abre: function () {
      window.abre = 1;
    },

    /* @F. Javier G. Solar
     * Valida que la Fecha Inicial no sea menor que la actual
     * 14/08/2018
     */
    validaFechaInicialCall: function (fields, errors, callback) {

        // FECHA INICIO
        var dateInicio = new Date(this.model.get("date_start"));
        var d = dateInicio.getDate();
        var m = dateInicio.getMonth() + 1;
        var y = dateInicio.getFullYear();
        var fechaCompleta = [m, d, y].join('/');
        // var dateFormat = dateInicio.toLocaleDateString();
        var fechaInicio = Date.parse(fechaCompleta);


        // FECHA ACTUAL
        var dateActual = new Date();
        var d1 = dateActual.getDate();
        var m1 = dateActual.getMonth() + 1;
        var y1 = dateActual.getFullYear();
        var dateActualFormat = [m1, d1, y1].join('/');
        var fechaActual = Date.parse(dateActualFormat);


        if (fechaInicio < fechaActual) {
            app.alert.show("Fecha no valida", {
                level: "error",
                title: "No puedes crear una Llamada con fecha menor al d&iacutea de hoy",
                autoClose: false
            });

            app.error.errorName2Keys['custom_message1'] = 'La fecha no puede ser menor a la actual';
            errors['date_start'] = errors['date_start'] || {};
            errors['date_start'].custom_message1 = true;
        }
        callback(null, fields, errors);
    },

    _render: function () {
        this._super("_render");
        this.hide_subpanel();
        this.disabledates();
        this.getPersonas();
        this.hidePErsonaEdit();
        this.omiteLlamadaPreventiva();
    },

    /* @Jesus Carrillo
       Oculta el subpanel del boton dropdown y campos de fechas
     */
    hide_subpanel: function () {
        var subpanel = this.getField("save_invite_button");
        if (subpanel) {
            subpanel.listenTo(subpanel, "render", function () {
                subpanel.hide();
            });
        }
    },

    disabledates: function () {
        console.log(App.user.attributes.puestousuario_c);
        if (App.user.attributes.puestousuario_c != '27' && App.user.attributes.puestousuario_c != '31') {
            this.$('div[data-name="evento_campana_c"]').hide();
            this.$('div[data-name="tct_fecha_cita_dat_c"]').hide();
            $('div[data-name="tct_usuario_cita_rel_c"]').hide();
            console.log('SE ocultaron');
        } else {
            this.$('div[data-name="tct_fecha_cita_dat_c"]').show();
            $('div[data-name="tct_usuario_cita_rel_c"]').show();
            console.log('SE mostraron');
        }
    },

    /* @Alvador Lopez Y Adrian Arauz
       Oculta los campos relacionados
     */
    disableparentsfields: function () {
        if (this.createMode) {//Evalua si es la vista  de creacion
            if (this.model.get('parent_id') != undefined) {
                this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;')
            }
        }
    },

    valida_cuenta_no_contactar: function (fields, errors, callback) {
		if(!app.user.attributes.tct_no_contactar_chk_c && !app.user.attributes.bloqueo_credito_c && !app.user.attributes.bloqueo_cumple_c) {
			if (this.model.get('parent_id') && this.model.get('parent_type') == "Accounts") {
				var account = app.data.createBean('Accounts', {id: this.model.get('parent_id')});
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
										var alertas = app.alert.getAll();
										for (var property in alertas) {
											if (property != 'cuentas_no_contactar') {
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
			} else {
				callback(null, fields, errors);
			}
		} else {
			callback(null, fields, errors);
		}
    },

    ocultaConferencia: function () {
        if (this.model.get('tct_conferencia_chk_c')) {
            this.model.set('tct_resultado_llamada_ddw_c', "Conferencia");
            this.$('div[data-name="tct_calificacion_conferencia_c"]').hide();
        }
    },

    //No permite editar el campo Estado al crear una nueva llamada.
    //Adrian Arauz 6/09/2018
    noestatusedit: function () {
        $('span[data-name=status]').css("pointer-events", "none");
    },

    valida_requeridos: function (fields, errors, callback) {
        var campos = "";
        _.each(errors, function (value, key) {
            _.each(this.model.fields, function (field) {
                if (_.isEqual(field.name, key)) {
                    if (field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "Calls") + '</b><br>';
                    }
                }
            }, this);
        }, this);
        if (campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Llamada:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    reqPersona: function (fields, errors, callback) {
        var idCuenta = person.model.get('parent_id');
        var parentModule = person.model.get('parent_type');
        if(idCuenta!=undefined && idCuenta!="" && parentModule !=undefined && parentModule == 'Accounts'){
            var idUsrFirmado = App.user.attributes.id;
            var tipoCuenta = person.model.attributes.parent!=undefined?person.model.attributes.parent.tipodepersona_c:"";
            var idUsrAsignado = person.model.get('assigned_user_id');
            var puestosDispo = app.lang.getAppListStrings('puestos_llamadas_list');
            var arrayPuestos = [];
            Object.keys(puestosDispo).forEach(function (key) {
                arrayPuestos.push(Number(key));
            });
            var puesto_usr = Number(app.user.attributes.puestousuario_c);

            if (arrayPuestos.includes(puesto_usr) && idUsrFirmado == idUsrAsignado && tipoCuenta == 'Persona Moral' && (this.model.get('persona_relacion_c') == "" || this.model.get('persona_relacion_c') == undefined)) {
                app.alert.show("Falta Persona", {
                    level: "error",
                    title: "Hace falta completar la siguiente información: <br> Persona con quien se atiende la llamada. <br> Nota: Si no cuenta con algún registro, favor de agregar uno en el módulo de RELACIÓN.",
                    autoClose: false
                });
                $('[data-name="calls_persona_relacion"]').find('.select2-choice').css('border-color', 'red');
                errors['calls_persona_relaccion'] = "Persona con quien se atiende la llamada";
                errors['calls_persona_relaccion'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    getPersonas: function () {
        var idCuenta = selfPerson.model.get('parent_id');
        var parentModule = selfPerson.model.get('parent_type');
        if(idCuenta!=undefined && idCuenta!="" && parentModule !=undefined && parentModule == 'Accounts'){
            var tipoCuenta = selfPerson.model.attributes.parent!=undefined?selfPerson.model.attributes.parent.tipodepersona_c:"";
            if (tipoCuenta == 'Persona Moral') {
                app.api.call('GET', app.api.buildURL('GetRelRelaciones/' + idCuenta), null, {
                    success: function (data) {
                        var idpersonas = selfPerson.model.get('persona_relacion_c');
                        var arrayPersonas = [];
                        var isSelect = false;
                        for (var i = 0; i < data.length; i++) {

                            if (idpersonas != "" && idpersonas == data[i]['id']) {
                                isSelect = true;
                            }
                            arrayPersonas.push({
                                "id": data[i]['id'],
                                "name": data[i]['name'],
                                "select": isSelect
                            });
                        }
                        //console.log(arrayPersonas);
                        selfPerson.personasRelData_list = arrayPersonas;
                        selfPerson.render();
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
        }
    },

    hidePErsonaEdit: function () {
        person = this;
        var parentModule = person.model.get('parent_type');
        if (parentModule !=undefined && parentModule == 'Accounts') {
            var puestosDispo = app.lang.getAppListStrings('puestos_llamadas_list');
            var arrayPuestos = [];
            Object.keys(puestosDispo).forEach(function (key) {
                arrayPuestos.push(Number(key));
            });
            var puesto_usr = Number(app.user.attributes.puestousuario_c);
            var tipoCuenta = person.model.attributes.parent!=undefined?person.model.attributes.parent.tipodepersona_c:"";

            if (arrayPuestos.includes(puesto_usr) && tipoCuenta == 'Persona Moral' && parentModule == 'Accounts') {
                // $('.divPersonasRel').show();
                person.$('[data-name="persona_relacion_c"]').hide()
                // Valida si el usuario firmado pertenece a la cuenta o a la llamada
               /* var idUsrFirmado = App.user.attributes.id;
                var idUsrLeading = person.model.attributes.parent.user_id_c;
                var idUsrAsignado = person.model.get('assigned_user_id');
                if (idUsrFirmado != idUsrAsignado || idUsrFirmado != idUsrLeading) {
                    $('[data-name="calls_persona_relacion"]').attr('style', 'pointer-events:none')
                }*/
            }
            else {
                person.$('[data-name="calls_persona_relacion"]').hide();
                person.$('[data-name="persona_relacion_c"]').hide();
                //$('[data-name="calls_persona_relacion"]').addClass('hide');
            }
        }else {
            person.$('[data-name="calls_persona_relacion"]').hide();
            person.$('[data-name="persona_relacion_c"]').hide();
        }
		if (tipoCuenta == 'Persona Moral' && parentModule == 'Accounts') {
			person.$('[data-name="calls_persona_relacion"]').show();
			this.$('[data-name="calls_persona_relacion"]').attr('style', '');
		}
		//person.$('[data-name="regimen_fiscal_c"]').hide();
    },

    omiteLlamadaPreventiva:function(){

        var nueva_lista_resultado = app.lang.getAppListStrings('tct_resultado_llamada_ddw_list');
        var producto=App.user.attributes.tipodeproducto_c;

        //Valor 8 - Uniclick,Solo se muestra el valor de Llamada preventiva cuando el usuario tenga en su perfil el producto Uniclick
        if (producto!='8') {
            Object.keys(nueva_lista_resultado).forEach(function (key) {
                if (key == "Llamada_preventiva") {
                    delete nueva_lista_resultado[key];
                }
            });
        }

        this.model.fields['tct_resultado_llamada_ddw_c'].options = nueva_lista_resultado;

    },

    validaRelLeadCall: function (fields, errors, callback) {
        
        if (this.model.get('parent_id') && this.model.get('parent_type') == "Leads") {
            
            var lead = app.data.createBean('Leads', {id: this.model.get('parent_id')});
            lead.fetch({
                success: _.bind(function (model) {

                   if (model.get('subtipo_registro_c') == '3') {

                        app.alert.show("lead-cancelado-call", {
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
                                if (property != 'lead-cancelado-call') {
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

    hideLlamadas: function()
    {
        this.$('div[data-name="accounts_calls_1_name"]').hide();
        this.$('div[data-name="leads_calls_1_name"]').hide();
		this.$('div[data-name="tct_call_issabel_c"]').hide();
		this.$('div[data-name="tct_call_from_issabel_c"]').hide();
		this.$('div[data-name="detalle_c"]').hide();
    },

    valida_usuarios_inactivos:function (fields, errors, callback) {
        var ids_usuarios='';
        for(var i=0;i<this.model.attributes.invitees.models.length;i++){
            if(this.model.attributes.invitees.models[i].id) {
              ids_usuarios+=this.model.attributes.invitees.models[i].id + ',';
            }
        }
        if(ids_usuarios) {
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
                          messages: "No es posible generar una llamada con lo(s) siguiente(s) usuario(s) inactivo(s):<br>"+nombres,
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

	llenaLlamada:function(){
		if(this.model.get('parent_type') == "Accounts") this.model.set('accounts_calls_1accounts_ida', this.model.get('padres_c'));
    },

    avisa_persona:function (fields, errors, callback) {
		if (this.model.get('parent_id') && this.model.get('parent_type') == "Accounts") {
			var account = app.api.buildURL('Accounts/' + this.model.get('parent_id'), null, null);
			app.api.call('read', account, {}, {
				success: _.bind(function (data) {
					this.model.set('detalle_c','');
					if(this.model.get('persona_relacion_c') == undefined && data.tipodepersona_c == 'Persona Moral') {
						app.alert.show('persona', {
							level: 'warning',
							messages: 'No se ha seleccionado la persona relacionada con quién se atendió la llamada. Por favor, ayúdanos completando esta información.',
							autoClose: false
						});
						this.model.set('detalle_c',2);
					}
					if(this.model.get('padres_c') == null && window.padres > 0) {
						app.alert.show('cuenta', {
							level: 'warning',
							messages: 'No se ha seleccionado una Cuenta Principal para vincular la llamada. Por favor, ayúdanos completando esta información.',
							autoClose: false
						});
						this.model.set('detalle_c',1);
					}
					callback(null, fields, errors);
				}, this)
			});
		} else {
			callback(null, fields, errors);
		}
    },

    /*
     @author Erick de jesus
     Se omite la opción de "encuesta exitosa" y "encuesta no exitosa" dentro del campo resultado de llamada
     * */
     llamadaInvMercados: function () {
        var puesto = App.user.attributes.puestousuario_c;
        
        var new_options = app.lang.getAppListStrings('tct_resultado_llamada_ddw_list');
       
        Object.keys(new_options).forEach(function (key) {
            if (key.indexOf("Encuesta") !== -1 && puesto != "63"){
                delete new_options[key];
            }
        });
        
        this.model.fields['tct_resultado_llamada_ddw_c'].options = new_options;

    },
})