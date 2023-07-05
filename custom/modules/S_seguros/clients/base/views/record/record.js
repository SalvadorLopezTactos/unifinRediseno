({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super("initialize", [options]);
        this.model.on('sync', this.roFunction, this);
		this.model.on("change:tipo_sf_c",this.perIncentivo, this);
		this.model.on("change:tipo_venta_c",this.perIncentivo, this);
        this.model.on('change:etapa', this.refrescaPipeLine, this);
        this.model.on("change:referenciador",this.addRegion, this);
        this.model.on("change:empleados_c",this.adDepartment, this);
        this.model.on("change:tipo_cuenta_c",this.setTipo, this);
		this.context.on('button:unifin:click', this.unifin, this);
		this.context.on('button:creditaria:click', this.creditaria, this);
        this.model.addValidationTask('fecha_req', _.bind(this.validaFecha, this));
        this.model.addValidationTask('referenciado', _.bind(this.validauser, this));
        this.model.addValidationTask('Requeridos_c', _.bind(this.valida_Req, this));
        this.model.addValidationTask('prima_neta_ganada_c', _.bind(this.valida_PN, this));
        this.model.addValidationTask('comision_c', _.bind(this.comision, this));
        this.model.addValidationTask('validaDoc', _.bind(this.validaDoc, this));
        this.model.addValidationTask('Notifica', _.bind(this.notifica, this));
        this.model.addValidationTask('fecha_aplicacion_c', _.bind(this.validAplica, this));
        this.model.on('sync', this._disableActionsSubpanel, this);
		this.model.on('sync', this.seguimiento, this);
        this._disableActionsSubpanel();
    },

    _render: function() {
        this._super("_render");
        //Oculta campo UNI2
        this.$('[data-name=seguro_uni2_c]').hide();
        //Oculta espacio en blanco
        this.$(".record-cell[data-name='blank_space']").hide();
        this._disableActionsSubpanel();
        //Desabilita accion sobre pipeline
        this.$('[data-name="seguro_pipeline"]').attr('style', 'pointer-events:none');
        //Oculta etiqueta del campo custom pipeline_opp
        this.$("div.record-label[data-name='seguro_pipeline']").attr('style', 'display:none;');
        //Desabilita edicion campo pipeline
        this.noEditFields.push('seguro_pipeline');
    },

    setTipo: function() {
        //Pone el tipo de cliente
        this.model.set('tipo_cliente_c', 1);
        if(this.model.get('tipo_cuenta_c') == 3) this.model.set('tipo_cliente_c', 2);
    },

    perIncentivo: function() {
      if(this.model.get('user_id1_c')) var usrid = this.model.get('user_id1_c');
	  if(this.model.get('user_id2_c')) var usrid = this.model.get('user_id2_c');
	  if(usrid) {
		app.api.call("read", app.api.buildURL("Users/" + usrid, null, null, {}), null, {
		  success: _.bind(function (data) {
		    if(data.puestousuario_c == 58) this.model.set('incentivo',15);
		    if(this.model.get('tipo_venta_c') == 4) this.model.set('incentivo',0);
		    if(this.model.get('tipo_sf_c') == 2 && data.puestousuario_c != 58) this.model.set('incentivo',10);
		    if(this.model.get('tipo_sf_c') == 1 && data.productos_c.includes("8")) this.model.set('incentivo',15);
          }, this)
        });
	  }
    },

    roFunction: function() {
		var creditaria = 0;
		var roles = app.user.attributes.roles;
		for(var i=0;i<roles.length;i++)
		{
			if(roles[i] === "Seguros - Creditaria")
			{
				creditaria = 1;
			}
		}
		if(creditaria) {
			$('[name="edit_button"]').hide();
			_.each(this.model.fields, function(field){
				this.noEditFields.push(field.name);
				this.$('.record-edit-link-wrapper[data-name='+field.name+']').remove();
				this.$("[data-name='"+field.name+"']").attr('style', 'pointer-events:none;');
			},this);
			this.noEditFields.push('prima_objetivo');
			this.$("[data-name='prima_objetivo']").attr('style', 'pointer-events:none;');
			this.$('[data-name=comision_tec_c]').hide();
			this.$('[data-name=comision_c]').hide();
			this.$('[data-name=prima_neta]').hide();
			this.$('[data-name=incentivo]').hide();
			this.$('[data-name=ingreso_ref]').hide();
		}
		else {
			if(app.user.get('puestousuario_c') == 59 || app.user.get('puestousuario_c') == 60 || this.model.get('etapa') == 2 || this.model.get('etapa') == 5 || this.model.get('etapa') == 9 || this.model.get('etapa') == 10 || this.model.get('registro_no_valido_c') || (app.user.get('puestousuario_c') != 56 && app.user.get('puestousuario_c') != 58 && this.model.get('etapa') != 1)) {
				if(app.user.get('puestousuario_c') != 56 || app.user.get('puestousuario_c') != 58 && this.model.get('etapa') != 9 ) $('[name="edit_button"]').hide();
				_.each(this.model.fields, function(field){
					if(app.user.get('puestousuario_c') != 56 || app.user.get('puestousuario_c') != 58 && field.name != 'no_poliza_emitida_c' && field.name != 'inicio_vigencia_emitida_c' && field.name != 'fin_vigencia_emitida_c' && field.name != 'prima_neta_emitida_c' && field.name != 'cambio_pn_emitida_c' && field.name != 'prima_total_emitida_c' && field.name != 'cambio_pt_emitida_c' && field.name != 'forma_pago_emitida_c' && field.name != 'aseguradora_emitida_c' && field.name != 'fecha_pago_c' && field.name != 'fecha_aplicacion_c' && field.name != 'razon_cancel_ganada_c' && field.name != 'comentarios_ganada_c' && field.name != 'subetapa_c') {
						this.noEditFields.push(field.name);
						$('.record-edit-link-wrapper[data-name='+field.name+']').remove();
					}
				},this);
				this.noEditFields.push('prima_objetivo');
				this.$("[data-name='prima_objetivo']").attr('style', 'pointer-events:none;');
			}
		}
		this.setFieldsEditAdminSeguros();
    },

    setFieldsEditAdminSeguros: function(){

      if( this.model.get('etapa') == 9 && app.user.get('admin_seguros_c') ){

        var array_fields_admin_seguros = ['tipo_sf_c','tipo_referenciador','empleados_c','comision_c'];

        for (let index = 0; index < array_fields_admin_seguros.length; index++) {
          var field = array_fields_admin_seguros[index];
          if( this.noEditFields.includes( field ) ){
            var pos_field = this.noEditFields.indexOf( field );
            this.noEditFields.splice(pos_field, 1);
          }
        }

        if( !$('[name="edit_button"]').is(":visible") ){
          $('[name="edit_button"]').show();
        }

      }
    },

    addRegion: function() {
      var usrid = this.model.get('user_id1_c');
	  if(usrid) {
        app.api.call("read", app.api.buildURL("Users/" + usrid, null, null, {}), null, {
          success: _.bind(function (data) {
            this.model.set('region',data.region_c);
		    if(data.puestousuario_c == 58) this.model.set('incentivo',15);
		    if(this.model.get('tipo_venta_c') == 4) this.model.set('incentivo',0);
		    if(this.model.get('tipo_sf_c') == 2 && data.puestousuario_c != 58) this.model.set('incentivo',10);
		    if(this.model.get('tipo_sf_c') == 1 && data.productos_c.includes("8")) this.model.set('incentivo',15);
          }, this)
        });
	  }
    },

    adDepartment: function() {
      var empid = this.model.get('user_id2_c');
	  if(empid) {
        app.api.call("read", app.api.buildURL("Infouser/" + empid, null, null, {}), null, {
          success: _.bind(function (data) {
            this.model.set('departamento_c',data.no_empleado_c);
		    if(data.puestousuario_c == 58) this.model.set('incentivo',15);
		    if(this.model.get('tipo_venta_c') == 4) this.model.set('incentivo',0);
		    if(this.model.get('tipo_sf_c') == 2 && data.puestousuario_c != 58) this.model.set('incentivo',10);
		    if(this.model.get('tipo_sf_c') == 1 && data.productos_c.includes("8")) this.model.set('incentivo',15);
          }, this)
        });
	  }
    },

    validaFecha: function(fields, errors, callback) {
      if(this.model.get('date_entered')) {
        var hoy = new Date(this.model.get('date_entered'));
      }
      else {
       var hoy = new Date();
      }
      var fecha_req = new Date(this.model.get('fecha_req'));
      var festivos = app.lang.getAppListStrings('festivos_list');
      for(dias = 1; dias < 10;) {
        hoy.setDate(hoy.getDate()+1);
        var pasa = true;
        var cuenta = 0;
        var total = 0;
        if(hoy.getDay() != 6 && hoy.getDay() != 0) {
          for(var key in festivos) {
            var dia = hoy.getDate();
            var mes = hoy.getMonth()+1;
            var fecha = dia+"/"+mes;
            total = total + 1;
            if(fecha != festivos[key]) cuenta++;
          }
          if(total != cuenta) pasa = false;
        } else pasa = false;
        if(pasa) dias++;
      }
      if(fecha_req < hoy){
        errors['fecha_req'] = errors['fecha_req'] || {};
        errors['fecha_req'].required = true;
        app.alert.show("Fecha", {
          level: "error",
          title: "La fecha en la que se requiere la Oportunidad no debe ser menor a 10 días",
          autoClose: false
        });
        this.model.set('fecha_req','');
      }
      callback(null, fields, errors);
    },

    valida_Req: function (fields, errors, callback) {
        var campos = "";
        _.each(errors, function (value, key) {
            _.each(this.model.fields, function (field) {
                if (_.isEqual(field.name, key)) {
                    if (field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "S_seguros") + '</b><br>';
                    }
                }
            }, this);
        }, this);

        if (campos) {
            app.alert.show("Campos_Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la oportunidad de <b>Seguro:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    refrescaPipeLine: function () {
        //Limpia pipeline
        pipe_s.render();
        //Ejecuta funcion para actualizar pipeline
        pipe_s.pipelineseguro();

    },

    validauser: function(fields, errors, callback) {
        if(this.model.get('tipo_referenciador') == '1'){ //Valida sólo si tipo referenciador es usuario
          //Validación para el referenciador asignado no sea un usuario inactivo
          usrid = this.model.get('user_id1_c');
          app.api.call("read", app.api.buildURL("Recuperauser/" + usrid, null, null, {}), null, {
              success: _.bind(function (data) {
                  if(data=="Inactive" || data == null){
                    if(this.model.get('user_id1_c')) {
                      errors['referenciador'] = errors['referenciador'] || {};
                      errors['referenciador'].required = true;
                    }
                    app.alert.show("Error Referenciador", {
                      level: "error",
                      title: "El referenciador seleccionado no se encuentra activo, favor de elegir otro.",
                      autoClose: false
                    });
                  }
                  callback(null, fields, errors);
              }, this),
              error: function (e) {
                throw e;
              }
          });
      }else{
        callback(null, fields, errors);
      }
    },

    valida_PN: function(fields, errors, callback) {
      //Validación de Prima Neta Ganada mayor a 0
      if(this.model.get('prima_neta_ganada_c') <= 0 && this.model.get('etapa') == 9) {
        errors['prima_neta_ganada_c'] = errors['prima_neta_ganada_c'] || {};
        errors['prima_neta_ganada_c'].required = true;
        app.alert.show("Error Prima Neta", {
          level: "error",
          title: "La Prima Neta Ganada debe ser mayor a cero.",
          autoClose: false
        });
      }
      callback(null, fields, errors);
    },

    comision: function(fields, errors, callback) {
      //Validación de Comisión Ganada mayor a 0
      if(this.model.get('comision_c') <= 0 && this.model.get('etapa') == 9) {
        errors['comision_c'] = errors['comision_c'] || {};
        errors['comision_c'].required = true;
        app.alert.show("Error Comision", {
          level: "error",
          title: "La Comisión debe ser mayor a cero.",
          autoClose: false
        });
      }
      callback(null, fields, errors);
    },

    validaDoc: function (fields, errors, callback) {
        var id = this.model.get('id');
        var notikam = this.model.get('notifica_kam_c');
        var etapa = this.model.get('etapa');
        if(notikam == 1 && etapa == 1) {
            app.api.call('GET', app.api.buildURL("S_seguros/" + id + "/link/s_seguros_documents_1"), null, {
                success: function (data) {
                    if(data.records.length == 0) {
                      errors['doc_cliente_c'] = errors['doc_cliente_c'] || {};
                      errors['doc_cliente_c'].required = true;
                      app.alert.show("Error_documento", {
                        level: "error",
                        messages: "Se debe adjuntar al menos un documento para poder notificar al KAM.",
                        autoClose: false
                      });
                    }
                    callback(null, fields, errors);
                },
                error: function (e) {
                    throw e;
                }
            });
        }
        else
        {
          callback(null, fields, errors);
        }
    },

    notifica: function (fields, errors, callback) {
        if (this.model.get('etapa') == 1 || this.model.get('etapa') == 2 || this.model.get('etapa') == 11) {
            app.alert.show("Notifica", {
                level: "info",
                messages: "Favor de Integrar la documentación/Información mínima requerida para determinar las condiciones del seguro a cotizar, tales como: Carátula de póliza actual, términos y condiciones, reporte de siniestralidad, listados de asegurados o bienes por asegurar, ubicaciones del bien, otros",
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    validAplica: function (fields, errors, callback) {
        if (this.model.get('subetapa_c') == 2 && this.model.get('fecha_aplicacion_c') < this.model.get('fecha_pago_c')) {
			errors['fecha_aplicacion_c'] = errors['fecha_aplicacion_c'] || {};
			errors['fecha_aplicacion_c'].required = true;
			app.alert.show("Error_fechas", {
				level: "error",
				messages: "La Fecha de Aplicación debe ser mayor o igual a la Fecha de Pago",
				autoClose: false
			});
        }
        callback(null, fields, errors);
    },

    _disableActionsSubpanel: function () {
	  this.$("div.record-label[data-name='seguro_pipeline']").attr('style', 'display:none;');
      if (this.model.get('tipo_registro_sf_c')=='2' &&  (this.model.get('requiere_ayuda_c')=='1' || this.model.get('requiere_ayuda_c')=='')){
        $('[data-subpanel-link="cot_cotizaciones_s_seguros"]').find(".subpanel-controls").hide();
      }
    },

    unifin: function () {
		app.alert.show("unifin", {
			level: "info",
			messages: "Éxito se ha mandado la oportunidad al seguimiento: UNIFIN",
			autoClose: false
		});
		this.model.set("revision_c",0);
		this.model.set("seguimiento_c",1);
        this.model.save();
		this.render();
    },

    creditaria: function () {
		app.alert.show("creditaria", {
			level: "info",
			messages: "Éxito se ha mandado la oportunidad al seguimiento: CREDITARIA",
			autoClose: false
		});
		this.model.set("revision_c",0);
        this.model.set("seguimiento_c",2);
        this.model.save();
		this.render();
    },

    seguimiento: function () {
        var unifin = this.getField("unifin");
		var creditaria = this.getField("creditaria");
		this.$('[data-name="revision_c"]').hide();
        if(app.user.get('seguimiento_seguros_c') && this.model.get('revision_c')) {
            unifin.listenTo(unifin, "render", function () {
                unifin.show();
            });
			creditaria.listenTo(creditaria, "render", function () {
                creditaria.show();
            });
        }else{
            unifin.listenTo(unifin, "render", function () {
                unifin.hide();
            });
            creditaria.listenTo(creditaria, "render", function () {
                creditaria.hide();
            });
        }
    }
})
