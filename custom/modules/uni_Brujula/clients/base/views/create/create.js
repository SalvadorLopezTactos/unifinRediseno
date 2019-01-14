({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        this._super("initialize", [options]);
        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));
    },
    
    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "uni_Brujula") + '<br></b>';
                    }
          		  }
       	    }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                title: "<b>ERROR</b> Hace falta completar la siguiente información en la <b>Brujula:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },
})