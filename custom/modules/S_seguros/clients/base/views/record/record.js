({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super("initialize", [options]);
        this.model.on("change:referenciador",this.addRegion, this);
        this.model.on("change:empleados_c",this.adDepartment, this);
        this.model.addValidationTask('fecha_req', _.bind(this.validaFecha, this));        
    },

    _render: function() {
        this._super("_render");
        //Desabilita accion sobre pipeline
        $('[data-name="seguro_pipeline"]').attr('style', 'pointer-events:none');
        //Oculta etiqueta del campo custom pipeline_opp
        $("div.record-label[data-name='seguro_pipeline']").attr('style', 'display:none;');
        //Desabilita edicion campo pipeline
        this.noEditFields.push('seguro_pipeline');
    },

    addRegion: function() {
      var usrid = this.model.get('user_id1_c');
      app.api.call("read", app.api.buildURL("Users/" + usrid, null, null, {}), null, {
        success: _.bind(function (data) {
          this.model.set('region',data.region_c);
        }, this)
      });
    },

    adDepartment: function() {
      var empid = this.model.get('user_id2_c');
      app.api.call("read", app.api.buildURL("Employees/" + empid, null, null, {}), null, {
        success: _.bind(function (data) {
          this.model.set('departamento_c',data.no_empleado_c);
        }, this)
      });
    },

    validaFecha: function(fields, errors, callback) {
      var hoy = new Date();
      var fecha = new Date(this.model.get('fecha_req'));
      for(dias = 1; dias < 10;) {
        hoy.setDate(hoy.getDate()+1);
        if(hoy.getDay() != 6 && hoy.getDay() != 0) dias++;
      }
      if(fecha < hoy){
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
})