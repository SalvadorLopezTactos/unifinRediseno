({
    extendsFrom: 'CreateView',
    previas: null,
    initialize: function (options)
	{
		relContext = this;
        /*
         If you are on 7.2.0, there is a dependency bug that can cause the screen to render an empty form.
         To correct this, uncomment the code below:
         if (!_.has(options.meta, "template"))
         {
            *options.meta.template = 'record';
         }
         */
        this._super('initialize', [options]);


         /* 
        	AF. 13/02/2018
        	Set account_id: Establece id para campo 
        		from: 	rel_relaciones_accounts_1accounts_ida
        		to: 	rel_relaciones_accountsaccounts_ida 
        */
        this.model.addValidationTask('set_Account_Related', _.bind(this._setAccount, this));

        //CVV INICIO
		//this.events['blur input[name=relaciones_activas]'] = 'doRelationFields';
		this.model.addValidationTask('check_Campos_Contacto', _.bind(this._doValidateContactFields, this));
		this.model.addValidationTask('check_custom_validations', _.bind(this.checarValidacionesonSave, this));
		this.model.addValidationTask('check_custom_relacion_c', _.bind(this.checarRelacion, this));
		this.model.addValidationTask('check_Relaciones_Permitidas', _.bind(this.RelacionesPermitidas, this));
		this.model.addValidationTask('check_Relaciones_Duplicadas', _.bind(this.relacionesDuplicadas, this));
        this.model.addValidationTask('crearrelacionaccionista', _.bind(this.Relacionaccionista, this));


		this.model.on('change:relacion_c', this.checarValidaciones, this);
		this.model.on('change:relaciones_activas', this.checarValidaciones, this);
		this.model.on('change:relaciones_activas', this.doRelationFields, this);
		//Perform check of parent data once parent record finishes loading
		/*this.model.once('data:sync:complete', this.doRecordCheck, this);*/

		/** BEGIN CUSTOMIZATION: jgarcia@levementum.com 8/27/2015 Description: When a new relationship is created, the same person is pre-selected in the “Relacion” field.
		 * Modify the out of the box behavior to start with a blank “Relacion”*/
		this.model.set("relacion_c", "   ");
		/* END CUSTOMIZATION */


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

	_render: function() {
		this._super("_render");
		this.doRelationFields();
        this.$('div[data-name=relacion_c]').hide();
        this.model.on("change:relaciones_activas", _.bind(function(){
            if(new String(this.model.get('relaciones_activas'))==""){
                this.$('div[data-name=relacion_c]').hide();
            }else{
                this.$('div[data-name=relacion_c]').show();
            }
        },this));
	},

	_setAccount: function (fields, errors, callback) {
		this.model.set('rel_relaciones_accountsaccounts_ida',this.model.get('rel_relaciones_accounts_1accounts_ida'));
		//console.log('idPersona: ' + this.model.get('rel_relaciones_accountsaccounts_ida'));

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
	
	_doValidateContactFields: function (fields, errors, callback) {
    	var sRelaciones = new String(this.model.get('relaciones_activas'));
        if (sRelaciones.search("Contacto") >= 0) {
            if (_.isEmpty(this.model.get('tipodecontacto'))) {
                errors['tipodecontacto'] = errors['tipodecontacto'] || {};
                errors['tipodecontacto'].required = true;
            }
        }
        callback(null, fields, errors);
    },

	/*** ALI INICIO ***/
	doRelationFields: function()
	{
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

	/** BEGIN CUSTOMIZATION: jgarcia@levementum.com 8/31/2015 Description: During the creation of a “Relacion” if you select an existing “Persona”
	 * validate that all the mandatory fields for the type of relationships selected are captured*/
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
                                           // console.log("sin repetir  "+ self.RequeridosFaltantes.unique());
                                            self.RequeridosFaltantes=$.unique(self.RequeridosFaltantes);

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

    /*Configuracion*/
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
	/* END CUSTOMIZATION */

	checarRelacion: function (fields, errors, callback){
		if(this.model.get("relacion_c") === "   "){
			errors['relacion_c'] = errors['relacion_c'] || {};
			errors['relacion_c'].required = true;
		}
		callback(null, fields, errors);
	},
	relacionesDuplicadas: function (fields, errors, callback){
		console.log("relacionesDuplicadas");

		var verificaDuplicidadURL = app.api.buildURL("obtieneRelacionesDuplicadas",'',{},{});
		app.api.call("create",verificaDuplicidadURL, {'guid_cliente':  this.model.get("rel_relaciones_accountsaccounts_ida"),
			'guid_relacion':  this.model.get("account_id1_c"),
			'relacion': String(this.model.get('relaciones_activas')),
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
    	if (this.model.get('relaciones_activas').includes('Accionista')) 
    	{
            if (this.model.get('porcentaje_participacion_c')=="" || this.model.get('porcentaje_participacion_c')==null || this.model.get('porcentaje_participacion_c')== "0.00") {
                app.alert.show("% requerido", {
                    level: "error",
                    title: "El Porcentaje de Participaci\u00F3n valor debe ser mayor a cero.",
                    autoClose: false
                });
                errors['porcentaje_participacion_c'] = errors['porcentaje_participacion_c'] || {};
                errors['porcentaje_participacion_c'].required = true;
            }
        }

        callback(null, fields, errors);
    },


})