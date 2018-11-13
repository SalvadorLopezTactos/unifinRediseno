({
extendsFrom: 'RecordView',
	previas: null,
	initialize: function (options) {
	    this._super('initialize', [options]);
		this.events['blur input[name=relaciones_activas]'] = 'doRelationFields';
		this.model.on('change:relaciones_activas', this.doRelationFields, this);
		this.model.addValidationTask('check_Campos_Contacto', _.bind(this._doValidateContactFields, this));
		this.model.addValidationTask('check_Relaciones_Permitidas', _.bind(this.RelacionesPermitidas, this));
		this.model.addValidationTask('check_Relaciones_Duplicadas', _.bind(this.relacionesDuplicadas, this));

		this.model.on('sync', this._render, this);
        this.model.addValidationTask('crearrelacionaccionista', _.bind(this.Relacionaccionista, this));

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
		this.previas = new String(this.model.get('relaciones_activas'));
		console.log(this.previas);
		this.doRelationFields();
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
        if (this.model.get('relaciones_activas').includes('Accionista'))
        {
            if (this.model.get('porcentaje_participacion_c')=="" || this.model.get('porcentaje_participacion_c')==null || this.model.get('porcentaje_participacion_c')== "0.00") {
                app.alert.show("% requerido", {
                    level: "error",
                    title: "El valor de Porcentaje de Participaci\u00F3n debe ser mayor a cero.",
                    autoClose: false
                });
                errors['porcentaje_participacion_c'] = errors['porcentaje_participacion_c'] || {};
                errors['porcentaje_participacion_c'].required = true;
            }
        }

        callback(null, fields, errors);
    },


})