({
extendsFrom: 'RecordView',
	previas: null,
	initialize: function (options) {
        relContext = this;
	    this._super('initialize', [options]);
		this.events['blur input[name=relaciones_activas]'] = 'doRelationFields';
		this.model.on('change:relaciones_activas', this.doRelationFields, this);
		this.model.addValidationTask('check_Campos_Contacto', _.bind(this._doValidateContactFields, this));
        this.model.addValidationTask('check_custom_validations', _.bind(this.checarValidacionesonSave, this));
        this.model.addValidationTask('check_custom_relacion_c', _.bind(this.checarRelacion, this));
		this.model.addValidationTask('check_Relaciones_Permitidas', _.bind(this.RelacionesPermitidas, this));
		this.model.addValidationTask('check_Relaciones_Duplicadas', _.bind(this.relacionesDuplicadas, this));
        this.model.addValidationTask('validarequeridosPropReal',_.bind(this.validaPropietarioReal, this));
        this.model.addValidationTask('validarequeridosProvRec',_.bind(this.validaProveedorRecursos, this));
        this.model.addValidationTask('validarequeridosRelActivas',_.bind(this.validaRelacionesValidation, this));



        this.model.on('sync', this._render, this);
        this.model.on('sync', this.validajuridico, this);
        this.model.addValidationTask('crearrelacionaccionista', _.bind(this.Relacionaccionista, this));

        this.model.on('change:relacion_c', this.checarValidaciones, this);
        this.model.on('change:relaciones_activas', this.checarValidaciones, this);
        this.model.on('change:relaciones_activas', this.doRelationFields, this);
        this.model.on('change:relaciones_activas',this.chkjuridico, this);
        this.model.on('change:relaciones_activas',this.validaPropietarioRealchange, this);
        this.model.on('change:relaciones_activas',this.changejuridico, this);
        this.model.on('change:relaciones_activas',this.validaProveedorRecursoschange, this);
        this.model.on('change:relaciones_activas',this.validaRelacionesChange, this);
				this.model.on('change:relacion_c',this.validaRelacionesChange, this);

        var valParams = {
            'modulo': 'Accounts',
        };
        var valUrl = app.api.buildURL("customValidations", '', {}, {});
        app.api.call("create", valUrl, {data: valParams}, { //Call and Collect the Dependencies
            success: _.bind(function (data) {
                if (data != null) {
                    self.validaciones = data;
                    console.log(self.validaciones);
                }
            }, this)
        });
        this.previas = new String(this.model.get('relaciones_activas'));


    },

	_renderHtml : function()
    {
		var id = app.lang.getAppListStrings('tct_persona_generica_list');
		//console.log(this.model.get('account_id1_c') + ' - ' +id['accid'] + ' - ' + app.user.get('type') );
		//console.log(this.model.get('relacion_c') );
		if(this.model.get('account_id1_c') == id['accid'] && app.user.get('type') != 'admin')
		{
		  	var self = this;
               		_.each(this.model.fields, function(field)
                	{
                			self.noEditFields.push(field.name);
                	});
		}
		this._super('_renderHtml');
	},

	_render: function() {
		this._super("_render");
		this.blockRecordNoContactar();
		this.previas = new String(this.model.get('relaciones_activas'));
		console.log(this.previas);
		this.doRelationFields();

	},

    blockRecordNoContactar:function () {

        var id_cuenta=this.model.get('rel_relaciones_accounts_1accounts_ida');

        if(id_cuenta!='' && id_cuenta != undefined ){

            var account = app.data.createBean('Accounts', {id:this.model.get('rel_relaciones_accounts_1accounts_ida')});
            account.fetch({
                success: _.bind(function (model) {

                    if(model.get('tct_no_contactar_chk_c')==true){

                        app.alert.show("cuentas_no_contactar", {
                            level: "error",
                            title: "Cuenta No Contactable<br>",
                            messages: "Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
                            autoClose: false
                        });

                        //Bloquear el registro completo y mostrar alerta
                        $('.record').attr('style','pointer-events:none')
                    }
                }, this)
            });

        }

    },

    validajuridico: function (){
        if(!this.model.get('relaciones_activas').includes('Propietario Real')){
            $('[data-name=tct_validado_juridico_chk_c]').hide();
        }
    },

	_doValidateContactFields: function (fields, errors, callback) {
		var sRelaciones = new String(this.model.get('relaciones_activas'));
		if (sRelaciones.search("Contacto") >= 0) {
			if (_.isEmpty(this.model.get('tipodecontacto'))) {
				errors['rel_relaciones'] = errors['tipodecontacto'] || {};
				errors['rel_relaciones'].required = true;
			}
		}
		callback(null, fields, errors);
	},

	RelacionesPermitidas: function(fields, errors, callback){
		//Valida los tipos de relación permitidos para el regimen de la persona relacionada
		var account = app.data.createBean('Accounts', {id:this.model.get('account_id1_c')});
        account.fetch({
            success: _.bind(function (model) {
            	console.log("El regimen fiscal de la persona relacionada es " + model.get('tipodepersona_c'));
                if (model.get('tipodepersona_c') == 'Persona Moral') {
                	var sRelaciones = new String(this.model.get('relaciones_activas'));
                	var arrRelaciones = sRelaciones.split(",");
                	console.log("Cadena sRelaciones:" + sRelaciones);
                	console.log(arrRelaciones);
                	for (rel in arrRelaciones){
                		console.log("Item:" + arrRelaciones[rel]);
						if (arrRelaciones[rel] == 'Contacto' || arrRelaciones[rel] == 'Conyuge' || arrRelaciones[rel] == 'Depositario'
						|| arrRelaciones[rel] == 'Directivo' || arrRelaciones[rel] == 'Referencia Personal'){
							app.alert.show("Tipo de relación no permitida", {
								level: "error",
								title: "Una persona moral no puede ser " + arrRelaciones[rel],
								autoClose: false
							});
		        			errors['relacion_c'] = errors['relacion_c'] || {};
							errors['relacion_c'].required = true;

							errors['relaciones_activas'] = errors['relaciones_activas'] || {};
							errors['relaciones_activas'].required = true;
						}
					}
                }
                callback(null, fields, errors);
            }, this)
        });
	},

	doRelationFields: function(){
		var sRelaciones = new String(this.model.get('relaciones_activas'));
		var arrRelaciones = sRelaciones.split(",");
		this.$("div[data-name='montodeparticipacion']").hide();
		this.$("div[data-name='miembrodecomite']").hide();
		this.$("div[data-name='porcentaje_participacion_c']").hide();
		this.$("div[data-name='tipodecontacto']").hide();
		this.$("div[data-name='limitedecredito']").hide();
		this.$("div[data-name='plazoendias']").hide();
		this.$("div[data-name='parentesco']").hide();
		this.$("div[data-name='tiempodeconocerloano']").hide();
		this.$("div[data-name='tiempodeconocerlomeses']").hide();
		this.$("div[data-name='probabilidadincremento']").hide();
		this.$("div[data-name='facturacionmensual']").hide();
		this.$("div[data-name='opinion']").hide();
		this.$("div[data-name='consumomensual']").hide();
		this.$("div[data-name='linea']").hide();
		this.$("div[data-name='saldo']").hide();
		this.$("div[data-name='producto']").hide();
		this.$("div[data-name='puesto']").hide();
		this.$("div[data-name='puestodescription']").hide();


		for(var x = 0; x < arrRelaciones.length; x++){
			switch (arrRelaciones[x]){
				case "Accionista":
					this.$("div[data-name='montodeparticipacion']").show();
					this.$("div[data-name='miembrodecomite']").show();
					this.$("div[data-name='porcentaje_participacion_c']").show();
					break;
				case "Contacto":
					this.$("div[data-name='tipodecontacto']").show();
					break;
				case "Referencia Personal":
					this.$("div[data-name='parentesco']").show();
					this.$("div[data-name='tiempodeconocerloano']").show();
					this.$("div[data-name='tiempodeconocerlomeses']").show();

					break;
				case "Referencia Proveedor":
					this.$("div[data-name='limitedecredito']").show();
					this.$("div[data-name='plazoendias']").show();
					this.$("div[data-name='opinion']").show();
					this.$("div[data-name='tiempodeconocerloano']").show();
					this.$("div[data-name='tiempodeconocerlomeses']").show();
					this.$("div[data-name='consumomensual']").show();
					this.$("div[data-name='linea']").show();
					this.$("div[data-name='saldo']").show();
					this.$("div[data-name='producto']").show();

					break;
				case "Referencia Cliente":
					this.$("div[data-name='limitedecredito']").show();
					this.$("div[data-name='plazoendias']").show();
					this.$("div[data-name='tiempodeconocerloano']").show();
					this.$("div[data-name='tiempodeconocerlomeses']").show();
					this.$("div[data-name='probabilidadincremento']").show();
					this.$("div[data-name='facturacionmensual']").show();
					this.$("div[data-name='opinion']").show();
					break;
				case "Representante":
					this.$("div[data-name='puesto']").show();
					this.$("div[data-name='puestodescription']").show();
					break;
			}
		}
	},
	relacionesDuplicadas: function (fields, errors, callback){
		console.log("relacionesDuplicadas");

		var OppParams = {
			'guid_cliente':  this.model.get("rel_relaciones_accountsaccounts_ida"),
			'guid_relacion':  this.model.get("account_id1_c"),
			'relacion': String(this.model.get('relaciones_activas')),
			'idRel': String(this.model.get('id')),
			'previas' : this.previas,

		};
		console.log("previas");
		console.log(String(this.model.get('relaciones_activas')).replace(this.previas,''));
		console.log(OppParams);
		var verificaDuplicidadURL = app.api.buildURL("obtieneRelacionesDuplicadas",'',{},{});
		app.api.call("create",verificaDuplicidadURL, {'guid_cliente':  this.model.get("rel_relaciones_accountsaccounts_ida"),
			'guid_relacion':  this.model.get("account_id1_c"),
			'relacion': String(this.model.get('relaciones_activas')).replace(this.previas,''),
			'idRel': String(this.model.get('id')),
			'previas' : this.previas},{
			success: _.bind(function(data){
                console.log(data);
				if(data!=null){
					if(data.length>=1){
						mensaje = data.length==1?'La relaci\u00F3n '+data.toString()+
                        ' ya existe, favor de verificar':'Las relaciones '+ data.join(", ") + ' ya existen, por favor verificar';

						errors['relaciones_activas'] = mensaje; //errors['relaciones_activas'] || {};
						errors['relaciones_activas'].required = true;

						app.alert.show("RelacionesRepetidas", {
							level: "error",
							title: mensaje,
							autoClose: false
						});
					}

				}
			},this)
		});
        callback(null, fields, errors);
	},
    Relacionaccionista: function (fields, errors, callback) {
        if (this.model.get('relaciones_activas').includes('Accionista')) {
            if (parseFloat(this.model.get('porcentaje_participacion_c')) <= 0.0000){
                errors['porcentaje_participacion_c'] = errors['porcentaje_participacion_c'] || {};
                errors['porcentaje_participacion_c'].required = true;

                app.alert.show("Participacion_mayor_a_cero", {
                    level: "error",
                    messages: "El valor de <b>Porcentaje de Participaci\u00F3n</b> debe ser mayor a cero.",
                    autoClose: false
                });
            }
            // Valida valor mayor a 100
            if (parseFloat(this.model.get('porcentaje_participacion_c')) > 100.00) {

                errors['porcentaje_participacion_c'] = errors['porcentaje_participacion_c'] || {};
                errors['porcentaje_participacion_c'].required = true;

                app.alert.show("Participacion_menor_a_cero", {
                    level: "error",
                    messages: "El valor de <b>Porcentaje de Participaci\u00F3n</b> debe ser menor o igual a cien.",
                    autoClose: false
                });
            }
            if (this.model.get('porcentaje_participacion_c')=="" || this.model.get('porcentaje_participacion_c')== undefined){
                errors['porcentaje_participacion_c'] = errors['porcentaje_participacion_c'] || {};
                errors['porcentaje_participacion_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },
    checarValidaciones: function(){

        if(this.model.get('relaciones_activas') != "") {
            self.RequeridosFaltantes = [];
            app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                "filter": [
                    {
                        "id": this.model.get("account_id1_c")
                    }
                ]
            }), null, {
                success: _.bind(function (data) {
                    if(data.records.length > 0) {
                        _.each(self.validaciones, function (val_values, val_parent_field) {
                            _.each(val_values, function (rule, rule_name) {
                                if (_.contains(relContext.model.get('relaciones_activas'), rule_name) || relContext.model.get('relaciones_activas') == rule_name) { //is it contained in an array?
                                    _.each(rule, function (rule_body, rule_index) {
                                        if (_.isNull(rule_body.estatus) || rule_body.estatus == 'Inactivo') {
                                            return;
                                        }
                                        //Check for visible, on this version this is the only dependency
                                        if (rule_body.requerido == '1') { //REQUIRED RULE
                                            var campo = rule_body.campo_dependiente;
                                            _.each(data.records[0], function (data_value, data_index) {
                                                if(campo == data_index) {
                                                    if(data_value == "" || data_value == null){


                                                        var pr=app.metadata.getField({module:'Accounts',name:data_index});
                                                        //pr.labelValue;
                                                        //console.log("Valores campos Ja  " + data_index + " su etiqueta  " + pr.labelValue);

                                                        self.RequeridosFaltantes.push(pr.labelValue);

                                                    }
                                                }
                                            });

                                            // console.log("Repetidos  "+ self.RequeridosFaltantes);
                                            // console.log("sin repetir  "+ self.RequeridosFaltantes.filter((item, i, ar) => ar.indexOf(item) == i););
                                            if (self.RequeridosFaltantes.length>0){
                                                self.RequeridosFaltantes=self.RequeridosFaltantes.filter((item, i, ar) => ar.indexOf(item) == i);;
                                            }

                                            console.log("lista "+self.RequeridosFaltantes);
                                        }
                                        //jescamilla Process SubValidaciones (AND)
                                        if (rule_index == 'SubValidaciones') {
                                            _.each(rule_body, function (subvalidacion, subvalidacion_index) {
                                                if(data.records[0][subvalidacion.campo_padre] == subvalidacion.criterio_validacion && subvalidacion.requerido != 1){ //if its not required, do not enforce it
                                                    var pr2=app.metadata.getField({module:'Accounts',name:subvalidacion.campo_dependiente});
                                                    if (pr2!==undefined){
                                                        subvalidacion.campo_dependiente=pr2.labelValue;
                                                    }
                                                    //self.RequeridosFaltantes = _.without(self.RequeridosFaltantes, _.findWhere(self.RequeridosFaltantes, subvalidacion.campo_dependiente));
                                                    //Salvador Lopez <salvador.lopez@tactos.com.mx>, replace findWhere by find
                                                    self.RequeridosFaltantes = _.without(self.RequeridosFaltantes, _.find(self.RequeridosFaltantes, function (x) { return x == subvalidacion.campo_dependiente }));
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        });

                        if(self.RequeridosFaltantes != "" && self.RequeridosFaltantes != null){
                            relContext.RequeridosFaltantes = self.RequeridosFaltantes;
                            app.drawer.open({
                                layout:'custom-RequiredFields',
                                context:{
                                    RequeridosFaltantes:self.RequeridosFaltantes,
                                    relatedAcct:relContext.model.get("account_id1_c"),
                                    relaciones_activas:relContext.model.get('relaciones_activas'),
                                    relatedAcctName:relContext.model.get('relacion_c'),
                                }
                            });
                        }
                    }

                }, this)
            });
        }
    },

    checarValidacionesonSave: function(fields, errors, callback){
        /* Ejecuta de nuevo la función checharValidaciones para no mandar el mensaje de campos restantes
        * Victor Martinez Lopez 2018-08-14
        * */
        if(this.model.get('relaciones_activas') != "") {
            self.RequeridosFaltantes = [];
            app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                "filter": [
                    {
                        "id": this.model.get("account_id1_c")
                    }
                ]
            }), null, {
                success: _.bind(function (data) {
                    /*Código original*/


                    /*Fin*/

                    if(data.records.length > 0) {
                        _.each(self.validaciones, function (val_values, val_parent_field) {
                            _.each(val_values, function (rule, rule_name) {
                                if (_.contains(relContext.model.get('relaciones_activas'), rule_name) || relContext.model.get('relaciones_activas') == rule_name) { //is it contained in an array?
                                    _.each(rule, function (rule_body, rule_index) {
                                        if (_.isNull(rule_body.estatus) || rule_body.estatus == 'Inactivo') {
                                            return;
                                        }
                                        //Check for visible, on this version this is the only dependency
                                        if (rule_body.requerido == '1') { //REQUIRED RULE
                                            var campo = rule_body.campo_dependiente;
                                            _.each(data.records[0], function (data_value, data_index) {
                                                if(campo == data_index) {
                                                    if(data_value == "" || data_value == null){
                                                        var pr=app.metadata.getField({module:'Accounts',name:data_index});

                                                        self.RequeridosFaltantes.push(pr.labelValue);
                                                    }
                                                }
                                            });
                                            self.RequeridosFaltantes=$.unique(self.RequeridosFaltantes);
                                        }
                                        //jescamilla Process SubValidaciones (AND)
                                        if (rule_index == 'SubValidaciones') {
                                            _.each(rule_body, function (subvalidacion, subvalidacion_index) {
                                                if(data.records[0][subvalidacion.campo_padre] == subvalidacion.criterio_validacion && subvalidacion.requerido != 1){ //if its not required, do not enforce it
                                                    /*cambio*/
                                                    var pr2=app.metadata.getField({module:'Accounts',name:subvalidacion.campo_dependiente});
                                                    if (pr2!==undefined){
                                                        subvalidacion.campo_dependiente=pr2.labelValue;
                                                    }

                                                    //self.RequeridosFaltantes = _.without(self.RequeridosFaltantes, _.findWhere(self.RequeridosFaltantes, subvalidacion.campo_dependiente));
                                                    //Salvador Lopez <salvador.lopez@tactos.com.mx>, replace findWhere by find
                                                    self.RequeridosFaltantes = _.without(self.RequeridosFaltantes, _.find(self.RequeridosFaltantes, function (x) { return x == subvalidacion.campo_dependiente }));
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        });

                        //Removiendo elementos 'undefined' del arreglo
                        if(self.RequeridosFaltantes.includes(undefined)){

                            for(var i=0;i<self.RequeridosFaltantes.length;i++){

                                var pos=self.RequeridosFaltantes.indexOf(undefined);
                                if(pos !=-1){
                                    self.RequeridosFaltantes.splice(pos,1);
                                }

                            }

                        }

                        if(self.RequeridosFaltantes != "" && self.RequeridosFaltantes != null){
                            relContext.RequeridosFaltantes = self.RequeridosFaltantes;
                            app.drawer.open({
                                layout:'custom-RequiredFields',
                                context:{
                                    RequeridosFaltantes:self.RequeridosFaltantes,
                                    relatedAcct:relContext.model.get("account_id1_c"),
                                    relaciones_activas:relContext.model.get('relaciones_activas'),
                                    relatedAcctName:relContext.model.get('relacion_c'),
                                }
                            });
                            console.log(relContext.RequeridosFaltantes);
                            errors['relacion_c'] = errors['relacion_c'] || {};
                            errors['relacion_c'].required = true;

                            errors['relaciones_activas'] = errors['relaciones_activas'] || {};
                            errors['relaciones_activas'].required = true;

                            app.alert.show("CamposRequeridosFaltantes", {
                                level: "error",
                                title: "La persona relacionada no cumple con los datos requeridos para las relaciones activas seleccionadas.",
                                autoClose: false
                            });
                        }
                    }
                    callback(null, fields, errors);

                }, this)
            });
        }
        else {
            callback(null, fields, errors);
        }
    },

    checarRelacion: function (fields, errors, callback){
        if(this.model.get("relacion_c") === "   "){
            errors['relacion_c'] = errors['relacion_c'] || {};
            errors['relacion_c'].required = true;
        }
        callback(null, fields, errors);
    },


    chkjuridico: function (){
        if (this.model.get('relaciones_activas').includes('Propietario Real')){
            $("div[data-name='tct_validado_juridico_chk_c']").show();

        }else{
            $("div[data-name='tct_validado_juridico_chk_c']").hide();
        }
        if (App.user.attributes.tct_propietario_real_chk_c== "1"){
            $('[data-fieldname=tct_validado_juridico_chk_c]').attr('style', 'pointer-events:block;');
        }else{
            $('[data-fieldname=tct_validado_juridico_chk_c]').attr('style', 'pointer-events:none;');
        }
    },

    changejuridico : function (){
        if (!this.model.get('relaciones_activas').includes('Propietario Real') && this.model.get("tct_validado_juridico_chk_c")== true){
            this.model.set("tct_validado_juridico_chk_c", 'false');
        }

    },

    validaPropietarioReal: function (fields, errors, callback){
        var RequeridosPR = "";
        var productospld = App.user.attributes.productos_c;
        if (this.model.get('relaciones_activas').includes('Propietario Real') && this.model.get("relacion_c").trim()!= "") {

            app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("rel_relaciones_accounts_1accounts_ida")), null, {
                success: _.bind(function (data) {
                    if (data.tipodepersona_c == "Persona Moral") {

                        app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c")), null, {
                            success: _.bind(function (data) {
                                if (data.tipodepersona_c != "Persona Moral") {

                                    if (data.primernombre_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Nombre<br></b>';
                                    }
                                    if (data.apellidopaterno_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Apellido Paterno<br></b>';
                                    }
                                    if (data.apellidomaterno_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Apellido Materno<br></b>';
                                    }
                                    if (data.genero_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Género<br></b>';
                                    }
                                    if (data.fechadenacimiento_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Fecha de Nacimiento<br></b>';
                                    }
                                    if (data.paisdenacimiento == "") {
                                        RequeridosPR = RequeridosPR + '<b>País de Nacimiento<br></b>';
                                    }
                                    if (data.estado_nacimiento_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Estado de Nacimiento<br></b>';
                                    }
                                    if (data.nacionalidad_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Nacionalidad<br></b>';
                                    }
                                    if (data.tct_macro_sector_ddw_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Macro Sector<br></b>';
                                    }
                                    if (data.sectoreconomico_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Sector Económico<br></b>';
                                    }
                                    if (data.subsectoreconomico_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Subsector Económico<br></b>';
                                    }
                                    if (data.actividadeconomica_c == "") {
                                        RequeridosPR = RequeridosPR + '<b>Actividad Económica<br></b>';
                                    }
                                    if (data.phone_office == "") {
                                        RequeridosPR = RequeridosPR + '<b>Teléfono<br></b>';
                                    }
                                    app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c") + "/link/accounts_dire_direccion_1"), null, {
                                        success: _.bind(function (data) {
                                            if (data.records <= 0) {
                                                RequeridosPR = RequeridosPR + '<b>Dirección<br></b>';
                                            }
                                            app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c") + "/link/accounts_tct_pld_1"), null, {
                                                success: _.bind(function (data) {
                                                    if (data.records.length > 0) {
                                                        for (var indice in data.records) {
                                                            console.log(data.records[indice].description);

                                                            if (data.records[indice].description == "AP" && productospld.includes("1")) {

                                                                if (data.records[indice].tct_pld_campo2_ddw == "") {
                                                                    RequeridosPR = RequeridosPR + '<b>Pregunta 1 Arrendamiento Puro<br></b>';
                                                                }
                                                                if (data.records[indice].tct_pld_campo4_ddw == "") {
                                                                    RequeridosPR = RequeridosPR + '<b>Pregunta 2 Arrendamiento Puro<br></b>';
                                                                }
                                                            }
                                                            if (data.records[indice].description == "CA" && productospld.includes("3")) {

                                                                if (data.records[indice].tct_pld_campo2_ddw == "") {
                                                                    RequeridosPR = RequeridosPR + '<b>Pregunta 1 Crédito Automotriz<br></b>';
                                                                }
                                                                if (data.records[indice].tct_pld_campo4_ddw == "") {
                                                                    RequeridosPR = RequeridosPR + '<b>Pregunta 2 Crédito Automotriz<br></b>';
                                                                }
                                                            }
                                                            if (data.records[indice].description == "FF" && productospld.includes("4")) {

                                                                if (data.records[indice].tct_pld_campo2_ddw == "") {
                                                                    RequeridosPR = RequeridosPR + '<b>Pregunta 1 Factoraje Financiero<br></b>';
                                                                }
                                                                if (data.records[indice].tct_pld_campo4_ddw == "") {
                                                                    RequeridosPR = RequeridosPR + '<b>Pregunta 2 Factoraje Financiero<br></b>';
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        RequeridosPR = RequeridosPR + '<b>Hace Falta completar información de la pestaña cuestionario PLD<br></b>';
                                                    }
                                                    if (RequeridosPR != "") {
                                                        app.alert.show("Campos faltantes en cuenta", {
                                                            level: "error",
                                                            messages: 'Hace falta completar la siguiente información en la cuenta ' + '<a href="#Accounts/' + this.model.get("account_id1_c") + '" target= "_blank"> ' + this.model.get('relacion_c') + '  </a>' + 'para una relación tipo Propietario Real:<br> ' + RequeridosPR,
                                                            autoClose: false
                                                        });
                                                        errors['errorpersonamoral'] = errors['errorpersonamoral'] || {};
                                                        errors['errorpersonamoral'].required = true;

                                                    }
                                                    callback(null, fields, errors);
                                                }, this)
                                            });

                                        }, this)
                                    });
                                } else {
                                    app.alert.show("Es persona Moral", {
                                        level: "error",
                                        title: "Una persona moral no puede ser Propietario Real",
                                        autoClose: false
                                    });
                                    errors['errorpersonamoral'] = errors['errorpersonamoral'] || {};
                                    errors['errorpersonamoral'].required = true;

                                    callback(null, fields, errors);
                                }
                            }, this)
                        });

                    } else {
                        app.alert.show("Error cuenta no es candidata a PR", {
                            level: "error",
                            messages: 'La cuenta principal es persona física y no puede generar una relación de tipo Propietario Real.',
                            autoClose: false
                        });
                        errors['errorcuenta'] = errors['errorcuenta'] || {};
                        errors['errorcuenta'].required = true;

                        callback(null, fields, errors);
                    }
                }, this)
            });
        }else {
            callback(null, fields, errors);
        }
    },

    validaPropietarioRealchange: function (){
        var Requeridoschange = "";
        var productospld = App.user.attributes.productos_c;

        if (this.model.get('relaciones_activas').includes('Propietario Real') && this.model.get("relacion_c").trim()!= "" ){

            app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c")), null, {
                success: _.bind(function (data) {
                    if (data.tipodepersona_c!="Persona Moral") {

                        if (data.primernombre_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Nombre<br></b>';
                        }
                        if (data.apellidopaterno_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Apellido Paterno<br></b>';
                        }
                        if (data.apellidomaterno_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Apellido Materno<br></b>';
                        }
                        if (data.genero_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Género<br></b>';
                        }
                        if (data.fechadenacimiento_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Fecha de Nacimiento<br></b>';
                        }
                        if (data.paisdenacimiento == "") {
                            Requeridoschange = Requeridoschange + '<b>País de Nacimiento<br></b>';
                        }
                        if (data.estado_nacimiento_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Estado de Nacimiento<br></b>';
                        }
                        if (data.nacionalidad_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Nacionalidad<br></b>';
                        }
                        if (data.tct_macro_sector_ddw_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Macro Sector<br></b>';
                        }
                        if (data.subsectoreconomico_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Subsector Económico<br></b>';
                        }
                        if (data.actividadeconomica_c == "") {
                            Requeridoschange = Requeridoschange + '<b>Actividad Económica<br></b>';
                        }
                        if (data.phone_office == "") {
                            Requeridoschange = Requeridoschange + '<b>Teléfono<br></b>';
                        }
                        app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c") + "/link/accounts_dire_direccion_1"), null , {
                            success: _.bind(function (data) {
                                if (data.records <= 0) {
                                    Requeridoschange = Requeridoschange + '<b>Dirección<br></b>';
                                }
                                app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c") + "/link/accounts_tct_pld_1"), null, {
                                    success: _.bind(function (data) {
                                        if (data.records.length>0) {
                                            for (var indice in data.records) {
                                                console.log(data.records[indice].description);

                                                if (data.records[indice].description == "AP" && productospld.includes("1")) {

                                                    if (data.records[indice].tct_pld_campo2_ddw == "") {
                                                        Requeridoschange = Requeridoschange + '<b>Pregunta 1 Arrendamiento Puro<br></b>';
                                                    }
                                                    if (data.records[indice].tct_pld_campo4_ddw == "") {
                                                        Requeridoschange = Requeridoschange + '<b>Pregunta 2 Arrendamiento Puro<br></b>';
                                                    }
                                                }
                                                if (data.records[indice].description == "CA" && productospld.includes("3")) {

                                                    if (data.records[indice].tct_pld_campo2_ddw == "") {
                                                        Requeridoschange = Requeridoschange + '<b>Pregunta 1 Crédito Automotriz<br></b>';
                                                    }
                                                    if (data.records[indice].tct_pld_campo4_ddw == "") {
                                                        Requeridoschange = Requeridoschange + '<b>Pregunta 2 Crédito Automotriz<br></b>';
                                                    }
                                                }
                                                if (data.records[indice].description == "FF" && productospld.includes("4")) {

                                                    if (data.records[indice].tct_pld_campo2_ddw == "") {
                                                        Requeridoschange = Requeridoschange + '<b>Pregunta 1 Factoraje Financiero<br></b>';
                                                    }
                                                    if (data.records[indice].tct_pld_campo4_ddw == "") {
                                                        Requeridoschange = Requeridoschange + '<b>Pregunta 2 Factoraje Financiero<br></b>';
                                                    }
                                                }
                                            }
                                        }else{
                                            Requeridoschange = Requeridoschange + '<b>Hace Falta completar información de la pestaña cuestionario PLD<br></b>';
                                        }
                                        if (Requeridoschange!= "") {
                                            app.alert.show("Campos faltantes en cuenta", {
                                                level: "error",
                                                messages: 'Hace falta completar la siguiente información en la cuenta '+'<a href="#Accounts/' + this.model.get("account_id1_c") + '" target= "_blank"> ' + this.model.get('relacion_c')+'  </a>' + 'para una relación tipo Propietario Real:<br> ' + Requeridoschange ,
                                                autoClose: false
                                            });
                                        }

                                    }, this)
                                });

                            }, this)
                        });
                    }else{
                        app.alert.show("Es persona Moral", {
                            level: "error",
                            title: "Una persona moral no puede ser Propietario Real",
                            autoClose: false
                        });

                    }
                }, this)
            });
        }
    },

    validaProveedorRecursos: function (fields, errors, callback){
        var RequeridosProvRec = "";
        if (this.model.get('relaciones_activas').includes('Proveedor de Recursos L') || this.model.get('relaciones_activas').includes('Proveedor de Recursos F') || this.model.get('relaciones_activas').includes('Proveedor de Recursos CA') && this.model.get("relacion_c").trim()!= "") {

            app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("rel_relaciones_accounts_1accounts_ida")), null, {
                success: _.bind(function (data) {
                    if (data.tipodepersona_c != "") {

                        app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c")), null, {
                            success: _.bind(function (data) {
                                if (data.tipodepersona_c == "Persona Fisica" || data.tipodepersona_c == "Persona Fisica con Actividad Empresarial") {

                                    if (data.primernombre_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Nombre<br></b>';
                                    }
                                    if (data.apellidopaterno_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Apellido Paterno<br></b>';
                                    }
                                    if (data.apellidomaterno_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Apellido Materno<br></b>';
                                    }
                                    if (data.fechadenacimiento_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Fecha de Nacimiento<br></b>';
                                    }
                                    if (data.nacionalidad_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Nacionalidad<br></b>';
                                    }
                                    if (data.tct_macro_sector_ddw_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Macro Sector<br></b>';
                                    }
                                    if (data.sectoreconomico_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Sector Económico<br></b>';
                                    }
                                    if (data.subsectoreconomico_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Subsector Económico<br></b>';
                                    }
                                    if (data.actividadeconomica_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Actividad Económica<br></b>';
                                    }
                                    if(data.rfc_c == "" && data.curp_c == "" && data.ctpldnoseriefiel_c == "" ){
                                        RequeridosProvRec = RequeridosProvRec + '<b><br>Almenos la captura de alguno de estos campos:<br><br>-RFC<br>-CURP<br>-Firma Electrónica Avanzada<br><br></b>';
                                    }
                                    app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c") + "/link/accounts_dire_direccion_1"), null, {
                                        success: _.bind(function (data) {
                                            if (data.records <= 0) {
                                                RequeridosProvRec = RequeridosProvRec + '<b>-Dirección<br></b>';
                                            }
                                            if (RequeridosProvRec != "") {
                                                app.alert.show("Campos faltantes en cuenta", {
                                                    level: "error",
                                                    messages: 'Hace falta completar la siguiente información en la cuenta ' + '<a href="#Accounts/' + this.model.get("account_id1_c") + '" target= "_blank"> ' + this.model.get('relacion_c') + '  </a>' + 'para una relación tipo Proveedor de Recursos:<br> ' + RequeridosProvRec,
                                                    autoClose: false
                                                });
                                                errors['faltantescuenta'] = errors['faltantescuenta'] || {};
                                                errors['faltantescuenta'].required = true;

                                            }
                                            callback(null, fields, errors);
                                        }, this)
                                    });
                                }else {
                                    if (data.razonsocial_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Denominación o Razón Social<br></b>';
                                    }
                                    if (data.nacionalidad_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Nacionalidad<br></b>';
                                    }
                                    if (data.rfc_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-RFC<br></b>';
                                    }
                                    app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c") + "/link/accounts_dire_direccion_1"), null, {
                                        success: _.bind(function (data) {
                                            if (data.records <= 0) {
                                                RequeridosProvRec = RequeridosProvRec + '<b>-Domicilio<br></b>';
                                            }
                                            if (RequeridosProvRec != "") {
                                                app.alert.show("Campos faltantes en cuenta", {
                                                    level: "error",
                                                    messages: 'Hace falta completar la siguiente información en la cuenta ' + '<a href="#Accounts/' + this.model.get("account_id1_c") + '" target= "_blank"> ' + this.model.get('relacion_c') + '  </a>' + 'para una relación tipo Proveedor de Recursos:<br> ' + RequeridosProvRec,
                                                    autoClose: false
                                                });
                                                errors['errorpersonamoral'] = errors['errorpersonamoral'] || {};
                                                errors['errorpersonamoral'].required = true;

                                            }
                                            callback(null, fields, errors);
                                        }, this)
                                    });
                                }
                            }, this)
                        });

                    }
                }, this)
            });
        }else {
            callback(null, fields, errors);
        }
    },

    validaProveedorRecursoschange: function (){
        var RequeridosProvRec = "";
        if ((this.model.get('relaciones_activas').includes('Proveedor de Recursos L') || this.model.get('relaciones_activas').includes('Proveedor de Recursos F') || this.model.get('relaciones_activas').includes('Proveedor de Recursos CA')) && this.model.get("relacion_c").trim()!= "") {

            app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("rel_relaciones_accounts_1accounts_ida")), null, {
                success: _.bind(function (data) {
                    if (data.tipodepersona_c != "") {

                        app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c")), null, {
                            success: _.bind(function (data) {
                                if (data.tipodepersona_c == "Persona Fisica" || data.tipodepersona_c == "Persona Fisica con Actividad Empresarial") {

                                    if (data.primernombre_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Nombre<br></b>';
                                    }
                                    if (data.apellidopaterno_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Apellido Paterno<br></b>';
                                    }
                                    if (data.apellidomaterno_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Apellido Materno<br></b>';
                                    }
                                    if (data.fechadenacimiento_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Fecha de Nacimiento<br></b>';
                                    }
                                    if (data.nacionalidad_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Nacionalidad<br></b>';
                                    }
                                    if (data.tct_macro_sector_ddw_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Macro Sector<br></b>';
                                    }
                                    if (data.sectoreconomico_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Sector Económico<br></b>';
                                    }
                                    if (data.subsectoreconomico_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Subsector Económico<br></b>';
                                    }
                                    if (data.actividadeconomica_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Actividad Económica<br></b>';
                                    }
                                    if(data.rfc_c == "" && data.curp_c == "" && data.ctpldnoseriefiel_c == "" ){
                                        RequeridosProvRec = RequeridosProvRec + '<b><br>Al menos la captura de alguno de estos campos:<br><br>-RFC<br>-CURP<br>-Firma Electrónica Avanzada<br><br></b>';
                                    }
                                    app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c") + "/link/accounts_dire_direccion_1"), null, {
                                        success: _.bind(function (data) {
                                            if (data.records <= 0) {
                                                RequeridosProvRec = RequeridosProvRec + '<b>-Dirección Particular<br></b>';
                                            }
                                            if (RequeridosProvRec != "") {
                                                app.alert.show("Campos faltantes en cuenta", {
                                                    level: "error",
                                                    messages: 'Hace falta completar la siguiente información en la cuenta ' + '<a href="#Accounts/' + this.model.get("account_id1_c") + '" target= "_blank"> ' + this.model.get('relacion_c') + '  </a>' + 'para una relación tipo <b>Proveedor de Recursos</b>:<br> ' + RequeridosProvRec,
                                                    autoClose: false
                                                });
                                            }
                                        }, this)
                                    });
                                }else {
                                    if (data.razonsocial_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Denominación o Razón Social<br></b>';
                                    }
                                    if (data.nacionalidad_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-Nacionalidad<br></b>';
                                    }
                                    if (data.rfc_c == "") {
                                        RequeridosProvRec = RequeridosProvRec + '<b>-RFC<br></b>';
                                    }
                                    app.api.call("read", app.api.buildURL("Accounts/" + this.model.get("account_id1_c") + "/link/accounts_dire_direccion_1"), null, {
                                        success: _.bind(function (data) {
                                            if (data.records <= 0) {
                                                RequeridosProvRec = RequeridosProvRec + '<b>-Domicilio<br></b>';
                                            }
                                            if (RequeridosProvRec != "") {
                                                app.alert.show("Campos faltantes en cuenta", {
                                                    level: "error",
                                                    messages: 'Hace falta completar la siguiente información en la cuenta ' + '<a href="#Accounts/' + this.model.get("account_id1_c") + '" target= "_blank"> ' + this.model.get('relacion_c') + '  </a>' + 'para una relación tipo <b>Proveedor de Recursos</b>:<br> ' + RequeridosProvRec,
                                                    autoClose: false
                                                });

                                            }

                                        }, this)
                                    });
                                }
                            }, this)
                        });
                    }
                }, this)
            });
        }
    },
    //Funcion para validar campos requeridos de relacion tipo Aval, Accionista y Representante
    validaRelacionesChange: function (){
        var requests=[];
        var request={};
        var Cuenta= this.model.get('account_id1_c');
        request.url="";
        request.method="GET";

        if ((this.model.get('relaciones_activas').includes('Aval') || this.model.get('relaciones_activas').includes('Accionista') || this.model.get('relaciones_activas').includes('Representante')) && this.model.get("relacion_c").trim()!= "" && Cuenta != "") {
            var requestA = app.utils.deepCopy(request);
            var url = app.api.buildURL("Accounts/" + Cuenta);
            requestA.url = url.substring(4);
            requests.push(requestA);
            var requestB = app.utils.deepCopy(request);
            var url = app.api.buildURL("Accounts/" + Cuenta + "/link/accounts_dire_direccion_1");
            requestB.url = url.substring(4);
            requests.push(requestB);
            var requestC = app.utils.deepCopy(request);
            var url = app.api.buildURL("Accounts/" + Cuenta + "/link/accounts_tel_telefonos_1")
            requestC.url = url.substring(4);
            requests.push(requestC);
            var faltantes=[];
            var relacionesActivas=[];
						var self = this;

            app.api.call("create", app.api.buildURL("bulk", '', {}, {}), {requests: requests}, {
                success: _.bind(function (data) {
                    //Variables para controlar las direcciones y telefonos
                    var direP=0;
                    var direF=0;
                    var telCyC=0;
                    var telO=0;

                    //Itera direcciones
                    for (var d = 0; d < data[1].contents.records.length; d++) {
                        //Itera direccion Particular
                        if (App.lang.getAppListStrings('tipo_dir_map_list')[data[1].contents.records[d].tipodedireccion[0]].includes('1')) {
                            direP++;
                        }
                        //Valida direccion Fiscal
                        if (App.lang.getAppListStrings('dir_indicador_map_list')[data[1].contents.records[d].indicador[0]].includes('2')) {
                            direF++;
                        }
                    }
                    //Itera telefonos
                    for (var t = 0; t < data[2].contents.records.length; t++) {
                        //Itera telefono casa y celular
                        if (data[2].contents.records[t].tipotelefono.includes('1') || data[2].contents.records[t].tipotelefono.includes('3')) {
                            telCyC++;
                        }
                        //Itera para telefono de trabajo y celular trabajo
                        if (data[2].contents.records[t].tipotelefono.includes('2') || data[2].contents.records[t].tipotelefono.includes('4')) {
                            telO++;
                        }
                    }
                    if (data) {
                        if (this.model.get('relaciones_activas').includes('Aval')){
                            relacionesActivas.push("Aval");
                            if (data[0].contents.tipodepersona_c != "Persona Moral") {
                                if (data[0].contents.primernombre_c == "") {
                                    faltantes.push('Nombre');
                                }
                                if (data[0].contents.apellidopaterno_c == "") {
                                    faltantes.push('Apellido Paterno');
                                }
                                if (data[0].contents.apellidomaterno_c == "") {
                                    faltantes.push('Apellido Materno');
                                }
                                if (data[0].contents.fechadenacimiento_c == "") {
                                    faltantes.push('Fecha de Nacimiento');
                                }
                                if (data[0].contents.paisdenacimiento_c == "") {
                                    faltantes.push('País de Nacimiento');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.profesion_c == "") {
                                    faltantes.push('Profesión');
                                }
                                if (data[0].contents.curp_c == "") {
                                    faltantes.push('CURP');
                                }
                            } else {
                                if (data[0].contents.razonsocial_c == "") {
                                    faltantes.push('Razón Social');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.fechaconstitutiva_c == "") {
                                    faltantes.push('Fecha Constitutiva');
                                }
                                if (data[0].contents.sectoreconomico_c == "") {
                                    faltantes.push('Sector Económico');
                                }
                                if (data[0].contents.actividadeconomica_c == "") {
                                    faltantes.push('Actividad Económica');
                                }
                                if (data[0].contents.subsectoreconomico_c == "") {
                                    faltantes.push('Sub Sector Económico');
                                }
                                if (data[0].contents.subsectoreconomico_c == "") {
                                    faltantes.push('Sub Sector Económico');
                                }
                                if (data[0].contents.pais_nacimiento_c == "") {
                                    faltantes.push('País de Constitución');
                                }
                            }
                            //Pregunta por la direccion
                            if (direP == 0) {
                                faltantes.push('Dirección Particular');
                            }
                            //Pregunta por el telefono
                            if (telCyC== 0) {
                                faltantes.push('Teléfono Casa o Celular');
                            }
                        }
                        if (this.model.get('relaciones_activas').includes('Accionista')) {
                            relacionesActivas.push("Accionista");
                            if (data[0].contents.tipodepersona_c != "Persona Moral") {
                                if (data[0].contents.primernombre_c == "") {
                                    faltantes.push('Nombre');
                                }
                                if (data[0].contents.apellidopaterno_c == "") {
                                    faltantes.push('Apellido Paterno');
                                }
                                if (data[0].contents.fechadenacimiento_c == "") {
                                    faltantes.push('Fecha de Nacimiento');
                                }
                                if (data[0].contents.paisdenacimiento_c == "") {
                                    faltantes.push('País de Nacimiento');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.curp_c == "") {
                                    faltantes.push('CURP');
                                }

                            }else{
                                if (data[0].contents.razonsocial_c == "") {
                                    faltantes.push('Razón Social');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.fechaconstitutiva_c == "") {
                                    faltantes.push('Fecha Constitutiva');
                                }
                                if (data[0].contents.pais_nacimiento_c == "") {
                                    faltantes.push('País de Constitución');
                                }
                            }
                            //Pregunta por el telefono
                            if (telO== 0) {
                                faltantes.push('Teléfono de Oficina o Celular Oficina');
                            }
                            //Pregunta por la direccion fiscal
                            if (direF == 0) {
                                faltantes.push('Dirección Fiscal');
                            }
                            if (self.model.get('porcentaje_participacion_c')=="" || self.model.get('porcentaje_participacion_c')==undefined){
                                faltantes.push('Porcentaje de Participación');
                            }

                        }
                        if (this.model.get('relaciones_activas').includes('Representante')) {
                            relacionesActivas.push("Representante");
                            if (data[0].contents.tipodepersona_c != "Persona Moral") {
                                if (data[0].contents.primernombre_c == "") {
                                    faltantes.push('Nombre');
                                }
                                if (data[0].contents.apellidopaterno_c == "") {
                                    faltantes.push('Apellido Paterno');
                                }
                                if (data[0].contents.fechadenacimiento_c == "") {
                                    faltantes.push('Fecha de Nacimiento');
                                }
                                if (data[0].contents.paisdenacimiento_c == "") {
                                    faltantes.push('País de Nacimiento');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.profesion_c == "") {
                                    faltantes.push('Profesión');
                                }
                                if (data[0].contents.curp_c == "") {
                                    faltantes.push('CURP');
                                }
                            }else{
                                if (data[0].contents.razonsocial_c == "") {
                                    faltantes.push('Razón Social');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.pais_nacimiento_c == "") {
                                    faltantes.push('País de Constitución');
                                }
                            }
                            //Pregunta por el telefono
                            if (telO== 0) {
                                faltantes.push('Teléfono de Oficina o Celular Oficina');
                            }
                            //Pregunta por la direccion fiscal
                            if (direF == 0) {
                                faltantes.push('Dirección Fiscal');
                            }
                        }
                    }
										if (faltantes.length >  0) {
                        faltantes=faltantes.filter((item, i, ar) => ar.indexOf(item) == i);
                        var lista="";
                        faltantes.forEach(element => lista=lista+'<br><b> '+element + '</b>');
                        app.alert.show("Campos_faltantes_en_cuenta", {
                            level: "error",
                            messages: 'Hace falta completar la siguiente información en la cuenta ' + '<a href="#Accounts/' + this.model.get("account_id1_c") + '" target= "_blank"> ' + this.model.get('relacion_c') + '  </a>' + 'para una relación  tipo '+ relacionesActivas+':' + lista,
                            autoClose: false
                        });

                    }

                }, this)
            });
        }
    },

    validaRelacionesValidation: function (fields, errors, callback){
        var requests=[];
        var request={};
        var Cuenta= this.model.get('account_id1_c');
        request.url="";
        request.method="GET";

        if ((this.model.get('relaciones_activas').includes('Aval') || this.model.get('relaciones_activas').includes('Accionista') || this.model.get('relaciones_activas').includes('Representante')) && this.model.get("relacion_c").trim()!= "" && Cuenta != "") {
            var requestA = app.utils.deepCopy(request);
            var url = app.api.buildURL("Accounts/" + Cuenta);
            requestA.url = url.substring(4);
            requests.push(requestA);
            var requestB = app.utils.deepCopy(request);
            var url = app.api.buildURL("Accounts/" + Cuenta + "/link/accounts_dire_direccion_1");
            requestB.url = url.substring(4);
            requests.push(requestB);
            var requestC = app.utils.deepCopy(request);
            var url = app.api.buildURL("Accounts/" + Cuenta + "/link/accounts_tel_telefonos_1")
            requestC.url = url.substring(4);
            requests.push(requestC);
            var faltantes=[];
            var relacionesActivas=[];
						var self = this;

            app.api.call("create", app.api.buildURL("bulk", '', {}, {}), {requests: requests}, {
                success: _.bind(function (data) {
                    //Variables para controlar las direcciones y telefonos
                    var direP=0;
                    var direF=0;
                    var telCyC=0;
                    var telO=0;

                    //Itera direcciones
                    for (var d = 0; d < data[1].contents.records.length; d++) {
                        //Itera direccion Particular
                        if (App.lang.getAppListStrings('tipo_dir_map_list')[data[1].contents.records[d].tipodedireccion[0]].includes('1')) {
                            direP++;
                        }
                        //Valida direccion Fiscal
                        if (App.lang.getAppListStrings('dir_indicador_map_list')[data[1].contents.records[d].indicador[0]].includes('2')) {
                            direF++;
                        }
                    }
                    //Itera telefonos
                    for (var t = 0; t < data[2].contents.records.length; t++) {
                        //Itera telefono casa y celular
                        if (data[2].contents.records[t].tipotelefono.includes('1') || data[2].contents.records[t].tipotelefono.includes('3')) {
                            telCyC++;
                        }
                        //Itera para telefono de trabajo y celular trabajo
                        if (data[2].contents.records[t].tipotelefono.includes('2') || data[2].contents.records[t].tipotelefono.includes('4')) {
                            telO++;
                        }
                    }
                    if (data) {
                        if (this.model.get('relaciones_activas').includes('Aval')){
                            relacionesActivas.push("Aval");
                            if (data[0].contents.tipodepersona_c != "Persona Moral") {
                                if (data[0].contents.primernombre_c == "") {
                                    faltantes.push('Nombre');
                                }
                                if (data[0].contents.apellidopaterno_c == "") {
                                    faltantes.push('Apellido Paterno');
                                }
                                if (data[0].contents.apellidomaterno_c == "") {
                                    faltantes.push('Apellido Materno');
                                }
                                if (data[0].contents.fechadenacimiento_c == "") {
                                    faltantes.push('Fecha de Nacimiento');
                                }
                                if (data[0].contents.paisdenacimiento_c == "") {
                                    faltantes.push('País de Nacimiento');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.profesion_c == "") {
                                    faltantes.push('Profesión');
                                }
                                if (data[0].contents.curp_c == "") {
                                    faltantes.push('CURP');
                                }
                            } else {
                                if (data[0].contents.razonsocial_c == "") {
                                    faltantes.push('Razón Social');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.fechaconstitutiva_c == "") {
                                    faltantes.push('Fecha Constitutiva');
                                }
                                if (data[0].contents.sectoreconomico_c == "") {
                                    faltantes.push('Sector Económico');
                                }
                                if (data[0].contents.actividadeconomica_c == "") {
                                    faltantes.push('Actividad Económica');
                                }
                                if (data[0].contents.subsectoreconomico_c == "") {
                                    faltantes.push('Sub Sector Económico');
                                }
                                if (data[0].contents.subsectoreconomico_c == "") {
                                    faltantes.push('Sub Sector Económico');
                                }
                                if (data[0].contents.pais_nacimiento_c == "") {
                                    faltantes.push('País de Constitución');
                                }
                            }
                            //Pregunta por la direccion
                            if (direP == 0) {
                                faltantes.push('Dirección Particular');
                            }
                            //Pregunta por el telefono
                            if (telCyC== 0) {
                                faltantes.push('Teléfono Casa o Celular');
                            }
                        }
                        if (this.model.get('relaciones_activas').includes('Accionista')) {
                            relacionesActivas.push("Accionista");
                            if (data[0].contents.tipodepersona_c != "Persona Moral") {
                                if (data[0].contents.primernombre_c == "") {
                                    faltantes.push('Nombre');
                                }
                                if (data[0].contents.apellidopaterno_c == "") {
                                    faltantes.push('Apellido Paterno');
                                }
                                if (data[0].contents.fechadenacimiento_c == "") {
                                    faltantes.push('Fecha de Nacimiento');
                                }
                                if (data[0].contents.paisdenacimiento_c == "") {
                                    faltantes.push('País de Nacimiento');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.curp_c == "") {
                                    faltantes.push('CURP');
                                }

                            }else{
                                if (data[0].contents.razonsocial_c == "") {
                                    faltantes.push('Razón Social');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.fechaconstitutiva_c == "") {
                                    faltantes.push('Fecha Constitutiva');
                                }
                                if (data[0].contents.pais_nacimiento_c == "") {
                                    faltantes.push('País de Constitución');
                                }
                            }
                            //Pregunta por el telefono
                            if (telO== 0) {
                                faltantes.push('Teléfono de Oficina o Celular Oficina');
                            }
                            //Pregunta por la direccion fiscal
                            if (direF == 0) {
                                faltantes.push('Dirección Fiscal');
                            }
                            if (self.model.get('porcentaje_participacion_c')=="" || self.model.get('porcentaje_participacion_c')==undefined){
                                faltantes.push('Porcentaje de Participación');
                            }

                        }
                        if (this.model.get('relaciones_activas').includes('Representante')) {
                            relacionesActivas.push("Representante");
                            if (data[0].contents.tipodepersona_c != "Persona Moral") {
                                if (data[0].contents.primernombre_c == "") {
                                    faltantes.push('Nombre');
                                }
                                if (data[0].contents.apellidopaterno_c == "") {
                                    faltantes.push('Apellido Paterno');
                                }
                                if (data[0].contents.fechadenacimiento_c == "") {
                                    faltantes.push('Fecha de Nacimiento');
                                }
                                if (data[0].contents.paisdenacimiento_c == "") {
                                    faltantes.push('País de Nacimiento');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.profesion_c == "") {
                                    faltantes.push('Profesión');
                                }
                                if (data[0].contents.curp_c == "") {
                                    faltantes.push('CURP');
                                }
                            }else{
                                if (data[0].contents.razonsocial_c == "") {
                                    faltantes.push('Razón Social');
                                }
                                if (data[0].contents.rfc_c == "") {
                                    faltantes.push('RFC');
                                }
                                if (data[0].contents.pais_nacimiento_c == "") {
                                    faltantes.push('País de Constitución');
                                }
                            }
                            //Pregunta por el telefono
                            if (telO== 0) {
                                faltantes.push('Teléfono de Oficina o Celular Oficina');
                            }
                            //Pregunta por la direccion fiscal
                            if (direF == 0) {
                                faltantes.push('Dirección Fiscal');
                            }
                        }
                    }
										if (faltantes.length >  0) {
                        faltantes=faltantes.filter((item, i, ar) => ar.indexOf(item) == i);
                        var lista="";
                        faltantes.forEach(element => lista=lista+'<br><b> '+element + '</b>');
                        app.alert.show("Campos_faltantes_en_cuenta", {
                            level: "error",
                            messages: 'Hace falta completar la siguiente información en la cuenta ' + '<a href="#Accounts/' + this.model.get("account_id1_c") + '" target= "_blank"> ' + this.model.get('relacion_c') + '  </a>' + 'para una relación  tipo '+ relacionesActivas+':' + lista,
                            autoClose: false
                        });
                        errors['validacionRelacionesActivas'] = errors['validacionRelacionesActivas'] || {};
                        errors['validacionRelacionesActivas'].required = true;
                    }
                    callback(null, fields, errors);
                }, this)
            });
        }else{
            callback(null, fields, errors);
        }

    },



})
