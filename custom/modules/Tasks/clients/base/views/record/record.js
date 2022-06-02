({
    extendsFrom: 'RecordView',

    events: {
        'change [name=tipo_tarea_c]': 'actualizaAsunto',
    },

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
		this.on('render',this.ocultaTipoTarea,this);
        this.on('render',this.disableparentsfields,this);
		this.model.on('change:ayuda_asesor_cp_c', this._ValoresPredetAsesor, this);
		this.model.on('change:parent_name', this._ValoresPredetAsesor, this);

        this.model.addValidationTask('valida_cuenta_no_contactar', _.bind(this.valida_cuenta_no_contactar, this));
        this.model.addValidationTask('checkdate', _.bind(this.checkdate, this));
		this.model.addValidationTask('valida_asignado', _.bind(this.valida_asignado, this));
        this.model.addValidationTask('metodo_asignacion_lm', _.bind(this.metodoAsignacionLM, this));
		this.model.addValidationTask('validaSolicitud', _.bind(this.validaSolicitud, this));
		this.model.addValidationTask('validaRequeridos', _.bind(this.validaRequeridos, this));

		this.model.addValidationTask('valida_requeridos', _.bind(this.valida_requeridos, this));
        this.model.addValidationTask('valida_atrasada', _.bind(this.valida_atrasada, this));
        this.model.addValidationTask('valida_usuarios_inactivos',_.bind(this.valida_usuarios_inactivos, this));
        /*@Jesus Carrillo
            Funcion que pinta de color los paneles relacionados
        */
        this.model.on('sync', this.fulminantcolor, this);
        this.model.on('sync', this.loadprevdate, this);
        this.model.on('sync', this.validaRelLeadTask, this);
        this.model.on('sync', this.roFunction, this);

        this.model.on('sync', this.deleteOportunidadRecuperacion, this);

        this.model.on('change:name', this.actualizaAsunto, this);

        //Genesys
        this.context.on('button:add_iws:click', this._openIWSInteractionModal, this);
        this.on('render', this._checkIWSToolbar, this);
    },

    /**
     * @author Salvador Lopez
     * Se habilita handleEdit, editClicked y cancelClicked para dejar habilitado el campo parent_name y solo se bloquea al
     * dar click en el campo e intentar editar
     * */
    // handleEdit: function(e, cell) {
    //     var target,
    //         cellData,
    //         field;
    //     if (e) { // If result of click event, extract target and cell.
    //         target = this.$(e.target);
    //         cell = target.parents('.record-cell');
    //     }

    //     if(e.currentTarget.dataset['name']=='parent_name'){

    //         this.inlineEditMode = false;

    //     }else{

    //         cellData = cell.data();
    //         field = this.getField(cellData.name);

    //         // Set Editing mode to on.
    //         this.inlineEditMode = true;

    //         this.setButtonStates(this.STATE.EDIT);

    //         this.toggleField(field);

    //         if (cell.closest('.headerpane').length > 0) {
    //             this.toggleViewButtons(true);
    //             this.adjustHeaderpaneFields();
    //         }

    //     }


    // },

    editClicked: function() {

        this._super("editClicked");

        var RO = 1;
        var puesto = app.user.attributes.puestousuario_c;
        RO = ((puesto == 5 || puesto == 11 || puesto == 16 || puesto == 53 || puesto == 54) &&  this.model.get('status')=='Completed' && this.model.get('potencial_negocio_c')!='' ) ? 1 : 0;
        var ROCAC = (puesto == 61) ? 1 : 0;
        //if((puesto == 5 || puesto == 11 || puesto == 16 || puesto == 53 || puesto == 54) &&  this.model.get('status')!='Completed' && this.model.get('potencial_negocio_c')!='' ) RO = 0;
        if(RO) {
            //this.noEditFields.push('tasks_opportunities_1_name');
            this.$("[data-name='potencial_negocio_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='solicitud_alta_c']").attr('style', 'pointer-events:none;');
      			this.$("[data-name='fecha_calificacion_c']").attr('style', 'pointer-events:none;');
      			this.$("[data-name='motivo_potencial_c']").attr('style', 'pointer-events:none;');
      			this.$("[data-name='detalle_motivo_potencial_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='parent_type']").attr('style', 'pointer-events:none;');
            this.$("[data-name='tipo_tarea_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='date_start']").attr('style', 'pointer-events:none;');
            this.$("[data-name='date_due']").attr('style', 'pointer-events:none;');
            this.$("[data-name='priority']").attr('style', 'pointer-events:none;');
            this.$("[data-name='status']").attr('style', 'pointer-events:none;');
            this.$("[data-name='assigned_user_name']").attr('style', 'pointer-events:none;');
            this.$("[data-name='parent_name']").attr('style', 'pointer-events:none;');
            this.$("[data-name='parent_type']").attr('style', 'pointer-events:none;');
            this.$("[data-name='description']").attr('style', 'pointer-events:none;');
            this.$("[data-name='subject']").attr('style', 'pointer-events:none;');

            //$("[data-name='tasks_opportunities_1_name']").attr('style', 'pointer-events:none;');
        }
        if(ROCAC) {
            //this.noEditFields.push('tasks_opportunities_1_name');
            this.$("[data-name='potencial_negocio_c']").attr('style', 'pointer-events:none;');
            this.$("[data-name='solicitud_alta_c']").attr('style', 'pointer-events:none;');
      			this.$("[data-name='fecha_calificacion_c']").attr('style', 'pointer-events:none;');
      			this.$("[data-name='motivo_potencial_c']").attr('style', 'pointer-events:none;');
      			this.$("[data-name='detalle_motivo_potencial_c']").attr('style', 'pointer-events:none;');
        }
    },

    // cancelClicked: function() {

    //     this._super("cancelClicked");
    //     this.$('[data-name="parent_name"]').attr('style', '');
    //     this.setButtonStates(this.STATE.VIEW);
    //     this.action = 'detail';
    //     this.handleCancel();
    //     this.clearValidationErrors(this.editableFields);
    //     this.setRoute();
    //     this.unsetContextAction();
    // },

    roFunction: function() {
		if(this.model.get('parent_name')) {
			this.noEditFields.push('parent_type');
			this.noEditFields.push('parent_name');
			this.$('.record-edit-link-wrapper[data-name=parent_type]').remove();
			this.$('.record-edit-link-wrapper[data-name=parent_name]').remove();
		}
		if(this.model.get('tasks_opportunities_1_name')) {
			this.noEditFields.push('solicitud_alta_c');
			this.$('.record-edit-link-wrapper[data-name=solicitud_alta_c]').remove();
		}
		if(this.model.get('status') == "Completed") {
			_.each(this.model.fields, function(field) {
				if (!_.isEqual(field.name,'tasks_opportunities_1_name')) {
					this.noEditFields.push(field.name);
					this.$('.record-edit-link-wrapper[data-name='+field.name+']').remove();
					this.$("[data-name='description']").attr('style', 'pointer-events:none;');
					//Oculta campos CAC
					if(this.model.get('puesto_c') != '61' || this.model.get('parent_type') != "Accounts")
					{
						this.$('[data-name=tasks_opportunities_1_name]').hide();
						this.$('[data-name=solicitud_alta_c]').hide();
						this.$('[data-name=potencial_negocio_c]').hide();
						this.$('[data-name=fecha_calificacion_c]').hide();
						this.$('[data-name=motivo_potencial_c]').hide();
						this.$('[data-name=detalle_motivo_potencial_c]').hide();
					}
				}
			},this);
		}
		var RO = 1;
		var puesto = app.user.attributes.puestousuario_c;
        if(puesto == 5 || puesto == 11 || puesto == 16 || puesto == 53 || puesto == 54) RO = 0;
		if(RO) {
			this.noEditFields.push('tasks_opportunities_1_name');
			this.noEditFields.push('solicitud_alta_c');
			this.noEditFields.push('potencial_negocio_c');
			this.noEditFields.push('fecha_calificacion_c');
			this.noEditFields.push('motivo_potencial_c');
			this.noEditFields.push('detalle_motivo_potencial_c');
			this.$('.record-edit-link-wrapper[data-name=tasks_opportunities_1_name]').remove();
			this.$('.record-edit-link-wrapper[data-name=solicitud_alta_c]').remove();
			this.$('.record-edit-link-wrapper[data-name=potencial_negocio_c]').remove();
			this.$('.record-edit-link-wrapper[data-name=fecha_calificacion_c]').remove();
			this.$('.record-edit-link-wrapper[data-name=motivo_potencial_c]').remove();
			this.$('.record-edit-link-wrapper[data-name=detalle_motivo_potencial_c]').remove();
			this.$("[data-name='solicitud_alta_c']").attr('style', 'pointer-events:none;');
			this.$("[data-name='potencial_negocio_c']").attr('style', 'pointer-events:none;');
			this.$("[data-name='fecha_calificacion_c']").attr('style', 'pointer-events:none;');
			this.$("[data-name='motivo_potencial_c']").attr('style', 'pointer-events:none;');
			this.$("[data-name='detalle_motivo_potencial_c']").attr('style', 'pointer-events:none;');
		}
		if(this.model.get('puesto_c') != '61' || this.model.get('parent_type') != "Accounts") {
			this.$('[data-name=tasks_opportunities_1_name]').hide();
			this.$('[data-name=solicitud_alta_c]').hide();
			this.$('[data-name=potencial_negocio_c]').hide();
			this.$('[data-name=fecha_calificacion_c]').hide();
			this.$('[data-name=motivo_potencial_c]').hide();
			this.$('[data-name=detalle_motivo_potencial_c]').hide();
		}
		this.$('[data-name=puesto_c]').hide();
    },

    _render: function () {
        this._super("_render");
    },

    /*@Jesus Carrillo
        Funcion que pinta de color los paneles relacionados
    */
    fulminantcolor: function () {
        this.blockRecordNoContactar();
        $( '#space' ).remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

    blockRecordNoContactar:function () {
		if (!app.user.attributes.tct_no_contactar_chk_c && !app.user.attributes.bloqueo_credito_c && !app.user.attributes.bloqueo_cumple_c) {
			var id_cuenta=this.model.get('parent_id');
			if(id_cuenta!='' && id_cuenta != undefined && this.model.get('parent_type') == "Accounts" ){
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
									//Bloquear el registro completo y mostrar alerta
									$('.record').attr('style','pointer-events:none');
									$('.subpanel').attr('style', 'pointer-events:none');
								}
							}, this)
						});
					}, this)
				});
			}
		}
    },

    loadprevdate: function(){
        var temp1=this.model.get('date_start');
        var temp2=temp1.split('T');
        this.temp_startdate = temp2[0];
        _.extend(this,this.temp_startdate);
        var temp3=this.model.get('date_due');
        var temp4=temp3.split('T');
        this.temp_duedate = temp4[0];
        _.extend(this,this.temp_duedate);

        this.isAyudaVisible();
    },

    valida_cuenta_no_contactar:function (fields, errors, callback) {
		if (!app.user.attributes.tct_no_contactar_chk_c && !app.user.attributes.bloqueo_credito_c && !app.user.attributes.bloqueo_cumple_c) {
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
										messages: "Unifin ha decidido NO trabajar con la cuenta relacionada a esta tarea.<br>Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
										autoClose: false
									});
									errors['parent_name'] = errors['parent_name'] || {};
									errors['parent_name'].required = true;
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
        var temp2=temp1.split('T');
        var start_date = temp2[0];
        var temp3=this.model.get('date_due');
        var temp4=temp3.split('T');
        var due_date = temp4[0];
        if(start_date<this.temp_startdate ){
            app.alert.show("start_invalid", {
                level: "error",
                title: "La fecha de inicio actual no puede ser menor a la que estaba guardada",
                autoClose: false
            });
            errors['date_start'] = errors['date_start'] || {};
            errors['date_start'].datetime = true;
        }
        if(due_date<this.temp_duedate ){
            app.alert.show("due_invalid", {
                level: "error",
                title: "La fecha de vencimiento actual no puede ser menor a la que estaba guardada",
                autoClose: false
            });
            errors['date_due'] = errors['date_due'] || {};
            errors['date_due'].datetime = true;
        }
        callback(null,fields,errors);
    },

    /* @Salvador Lopez Y Adrian Arauz
    Oculta los campos relacionados
    */

    disableparentsfields:function () {
        //this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;');
        //$('.record-cell[data-type="relate"]').removeAttr("style");
		if (App.user.attributes.puestousuario_c=='27'||App.user.attributes.puestousuario_c=='31') {
			//Oculta Check ayuda
			this.$('[data-name=ayuda_asesor_cp_c]').hide();
        }
		this.noEditFields.push('solicitud_alta_c');
		this.$('[data-name="solicitud_alta_c"]').attr('style', 'pointer-events:none');
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

    validaRelLeadTask: function () {

        if (this.model.get('parent_id') && this.model.get('parent_type') == "Leads") {

            var lead = app.data.createBean('Leads', {id: this.model.get('parent_id')});
            lead.fetch({
                success: _.bind(function (model) {

                   if (model.get('subtipo_registro_c') == '3') {

                        app.alert.show("lead-cancelado-task-record", {
                            level: "error",
                            title: "Lead Cancelado<br>",
                            messages: "No se puede agregar / editar una relación con Lead Cancelado",
                            autoClose: false
                        });

                        //Bloquear el registro completo y mostrar alerta
                        $('.record').attr('style', 'pointer-events:none');
                        $('.dropdown-toggle').attr('style', 'pointer-events:none');
                        $('.record-edit-link-wrapper').remove();
                        $('.fa-pencil').remove();

                        var editButton = self.getField('edit_button');
                        editButton.setDisabled(true);
                    }

                }, this)
            });
        }
    },

    metodoAsignacionLM: function (fields, errors, callback) {

        if (this.model.get('name') == "Solicitud de asignación de Lead/Cuenta - (Lead Management)") {

            if (this.model.get('status') == 'Completed') {

                if((this.model.get('parent_type') == "Accounts" || this.model.get('parent_type') == "Leads" || this.model.get('parent_type') == "") &&
                this.model.get('parent_id') == ""){

                    app.alert.show('message-metodo-lm', {
                        level: 'error',
                        messages: 'Seleccionar un Lead/Cuenta relacionada con la Tarea!',
                        autoClose: false
                    });

                    errors['parent_name'] = errors['parent_name'] || {};
                    errors['parent_name'].required = true;

                } else {

                    if(this.model.get('parent_type') == "Leads" && this.model.get('parent_id') != ""){

                        var lead_ = app.data.createBean('Leads', {id: this.model.get('parent_id')});
                        lead_.fetch({
                            success: _.bind(function (model) {
                                //Método de Asignación LM - Centro de Prospección
                                model.set('metodo_asignacion_lm_c','1');
                                model.save();

                            }, this)
                        });
                    }
                    if(this.model.get('parent_type') == "Accounts" && this.model.get('parent_id') != ""){

                        var userTipoProducto = App.user.attributes.tipodeproducto_c;
                        var idProducto = '';

                        app.api.call('GET', app.api.buildURL('GetProductosCuentas/' + this.model.get('parent_id')), null, {
                            success: function (data) {
                                Productos = data;

                                _.each(Productos, function (value, key) {
                                    var tipoProducto = Productos[key].tipo_producto;

                                    if (tipoProducto == userTipoProducto) { //Tipo de Producto Leasing "1"

                                        idProducto = Productos[key].id; //Id cuenta de uni productos "Leasing"

                                        var producto = app.data.createBean('uni_Productos', { id: idProducto });
                                        producto.fetch({
                                            success: _.bind(function (model) {
                                                //Método de Asignación LM - Centro de Prospección
                                                model.set('metodo_asignacion_lm_c','1');
                                                model.save();

                                            }, this)
                                        });
                                    }
                                });
                            },
                            error: function (e) {
                                throw e;
                            }
                        });
                    }
                }
            }
        }
        callback(null, fields, errors);
    },

    validaSolicitud: function (fields, errors, callback) {
        if (this.model.get('tasks_opportunities_1opportunities_idb')) {
            var opp = app.data.createBean('Opportunities', {id: this.model.get('tasks_opportunities_1opportunities_idb')});
            opp.fetch({
                success: _.bind(function (model) {
                    if(model.get('tct_etapa_ddw_c') == 'R' || model.get('estatus_c') == 'R' || model.get('estatus_c') == 'K' || model.get('estatus_c') == 'CM') {
                        app.alert.show("opp-task", {
                            level: "error",
                            title: "Solicitud Cancelada/Rechazada<br>",
                            messages: "No se puede agregar una relación con una Solicitud Cancelada o Rechazada",
                            autoClose: false
                        });
                        app.error.errorName2Keys['custom_message2'] = '';
                        errors['tasks_opportunities_1_name'] = errors['tasks_opportunities_1_name'] || {};
                        errors['tasks_opportunities_1_name'].custom_message2 = true;
                    }
                    callback(null, fields, errors);
                }, this)
            });
        } else {
            callback(null, fields, errors);
        }
    },

    validaRequeridos: function (fields, errors, callback) {
		    var puesto = App.user.attributes.puestousuario_c; //this.model.get('puesto_asignado_c');
        if(this.model.get('puesto_c') == '61' && this.model.get('parent_type') == "Accounts" && !this.model.get('potencial_negocio_c') && this.model.get('status') == 'Completed' && (puesto == 5 || puesto == 11 || puesto == 16 || puesto == 53 || puesto == 54)) {
            app.error.errorName2Keys['custom_message2'] = '';
            errors['potencial_negocio_c'] = errors['potencial_negocio_c'] || {};
            errors['potencial_negocio_c'].custom_message2 = true;
        }
        callback(null, fields, errors);
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
			this.render();
            if(this.model.get('parent').tipo_registro_cuenta_c==undefined){
                app.api.call('GET', app.api.buildURL('Accounts/' + this.model.get('parent_id')), null, {
                    success: _.bind(function (data) {
                        if(data.tipo_registro_cuenta_c=="3" && data.subtipo_registro_cuenta_c=="17"){
                            var opciones_full=app.lang.getAppListStrings('tipo_tarea_list');
                            //Cuando es Cliente Perdido, solo se muestra la Opción de Oportunidad Recuperación
                            Object.keys(opciones_full).forEach(function (key) {
                                if (key != "CAC Oportunidad Recuperacion" && key != "CAC Informativa") {
                                    delete opciones_full[key];
                                }
                            });
                            this.model.fields['tipo_tarea_c'].options = opciones_full;
                            this.render();
                        }
                    }, this),
                });
            }else{
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
                this.render();
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
                          messages: "No es posible guardar la tarea con el siguiente usuario inactivo:<br>"+nombres,
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
    _checkIWSToolbar: function() {
        console.log("_checkIWSToolbar called");
        if (!window.isToolBarLoaded) {
            $("a[name|='add_iws']").hide();
            console.warn("cti-connector-sugar-core package not loaded !!!");
        }

        var userAcl = SUGAR.App.user.getAcls()["Soft_WDEScript"];
        if (!userAcl || (userAcl["access"] && userAcl["access"] == "no") || (userAcl["view"] && userAcl["view"] == "no")) {
            console.warn("User doesnt'have the WDE Script persmissions to load WDE Personalization.");
            $("a[name|='add_iws']").hide();
        }
    },

    /**Function to open the note create pop-up*/
    _openIWSInteractionModal: function() {

        console.log("called _openIWSInteractionModal");
        /**add class content-overflow-visible if client has touch feature*/
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }

        if (this.co)
            var quickCreateView = this.layout.getComponent('viewinteraction');
        if (!quickCreateView) {
            console.log("called _openIWSInteractionModal quickCreateView");
            var context = null;
            if (!this.context) {
                console.log("_openIWSInteractionModal context undefined");
                var context = this.context.getChildContext({
                    forceNew: true,
                    create: true
                });
                context.prepare();
            } else {
                console.log("_openIWSInteractionModal context found");
                context = this.context;
            }

            quickCreateView = app.view.createView({
                context: context,
                name: 'viewinteraction',
                layout: this.layout,
                module: context.module
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);
        }
        this.layout.trigger("app:view:viewinteraction");
    },

})
