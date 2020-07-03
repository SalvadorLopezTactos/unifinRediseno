({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.model.on("change:referenciador",this.addRegion, this);
        this.model.addValidationTask('fecha_req', _.bind(this.validaFecha, this));
    },

    _render: function() {
        this._super("_render");
        //Oculta etiqueta del campo custom pipeline
        $("div.record-label[data-name='seguro_pipeline']").attr('style', 'display:none;');
        //Oculta campo seguro_pipeline
        this.$('div[data-name=seguro_pipeline]').hide();
    },

    addRegion: function() {
      var usrid = this.model.get('user_id1_c');
      app.api.call("read", app.api.buildURL("Users/" + usrid, null, null, {}), null, {
        success: _.bind(function (data) {
          this.model.set('region',data.region_c);
        }, this)
      });
    },

    validaFecha: function(fields, errors, callback) {
      var hoy = new Date();
      var fecha = new Date(this.model.get('fecha_req'));
      hoy.setDate(hoy.getDate()-10);
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