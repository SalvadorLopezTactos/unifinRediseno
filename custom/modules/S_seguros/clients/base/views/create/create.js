({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
		this.creditaria = 0;
        this._super("initialize", [options]);
		this.model.on("change:tipo_sf_c",this.perIncentivo, this);
		this.model.on("change:tipo_venta_c",this.perIncentivo, this);
        this.model.on("change:referenciador",this.addRegion, this);
        this.model.on("change:empleados_c",this.adDepartment, this);
        this.model.on("change:tipo_cuenta_c",this.setTipo, this);
		this.model.on("change:oficina_c",this.setASVC, this);
        this.model.addValidationTask('fecha_req', _.bind(this.validaFecha, this));
        this.model.addValidationTask('fecha_cierre_c', _.bind(this.fechaCierre, this));
        this.model.addValidationTask('referenciador', _.bind(this.validauser, this));
        this.model.addValidationTask('Requeridos_c', _.bind(this.valida_Req, this));
        this.model.addValidationTask('Notifica', _.bind(this.notifica, this));
		this.model.addValidationTask('puesto', _.bind(this.validaPuesto, this));
		var roles = app.user.attributes.roles;
		for(var i=0;i<roles.length;i++)
		{
			if(roles[i] === "Seguros - Creditaria")
			{
				this.model.set("creditaria_c","Creditaria");
				this.model.set("user_id1_c",app.user.id);
				this.model.set("referenciador",app.user.attributes.full_name);
				this.model.set("requiere_ayuda_c",1);
				this.addRegion();
				this.model.set("asesor_vta_cruzada_c",2);
				this.model.set("ejecutivo_c","6");
				this.model.set("tipo_venta_c",9);
				this.creditaria = 1;
			}
		}
    },

    _render: function() {
        this._super("_render");
        //Oculta etiqueta del campo custom pipeline
        $("div.record-label[data-name='seguro_pipeline']").attr('style', 'display:none;');
        //Oculta campo seguro_pipeline
        this.$('div[data-name=seguro_pipeline]').hide();
        //Oculta campo Notificar KAM
        this.$('[data-name=notifica_kam_c]').hide();
        //Oculta campos UNI2
        this.$('[data-name=seguro_uni2_c]').hide();
		//Oculta campos para Creditaria
		if(this.creditaria) {
			this.$('[data-name=comision_tec_c]').hide();
			this.$('[data-name="tipo_venta_c"]').attr('style', 'pointer-events:none');
		}
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

    fechaCierre: function(fields, errors, callback) {
      var hoy = new Date();
      var fecha_cierre = new Date(this.model.get('fecha_cierre_c'));
      if(fecha_cierre <= hoy){
        errors['fecha_cierre_c'] = errors['fecha_cierre_c'] || {};
        errors['fecha_cierre_c'].required = true;
        app.alert.show("Fecha Cierre", {
          level: "error",
          title: "La Fecha Cierre debe ser mayor al día de hoy",
          autoClose: false
        });
      }
      callback(null, fields, errors);
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

    notifica: function (fields, errors, callback) {
        if (this.model.get('etapa') == 1 || this.model.get('etapa') == 2) {
            app.alert.show("Notifica", {
                level: "info",
                messages: "Favor de Integrar la documentación/Información mínima requerida para determinar las condiciones del seguro a cotizar, tales como: Carátula de póliza actual, términos y condiciones, reporte de siniestralidad, listados de asegurados o bienes por asegurar, ubicaciones del bien, otros",
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    validaPuesto: function (fields, errors, callback) {
        if (app.user.get('puestousuario_c') == 59) {
		    errors['puesto'] = errors['puesto'] || {};
            errors['puesto'].required = true;
            app.alert.show("ErrorPuesto", {
                level: "error",
                messages: "Usted no tiene privilegios para crear Oportunidades de Seguro",
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    setASVC: function() {
		if(this.creditaria) {
			if(this.model.get('oficina_c') == 5 || this.model.get('oficina_c') == 9) this.model.set('asesor_vta_cruzada_c', 5);
			else this.model.set('asesor_vta_cruzada_c', 2);
		}
    },
})
