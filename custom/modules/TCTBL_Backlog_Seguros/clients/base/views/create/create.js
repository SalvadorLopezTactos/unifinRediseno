({
    extendsFrom: 'CreateView',
	val : null,

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        this.model.addValidationTask('validaMontosPrimas', _.bind(this.validaMontosPrimas, this));
		this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));

    },

    _render: function() {
        this._super("_render");
    },

    validaMontosPrimas: function (fields, errors, callback){

        if (parseFloat(this.model.get('estimado_prima_neta_objetivo')) <= 0 || this.model.get('estimado_prima_neta_objetivo') == "")
        {
            errors['estimado_prima_neta_objetivo'] = errors['estimado_prima_neta_objetivo'] || {};
            errors['estimado_prima_neta_objetivo'].required = true;
        }

        if (parseFloat(this.model.get('estimado_prima_total_objetivo')) <= 0 || this.model.get('estimado_prima_total_objetivo') == "" )
        {
            errors['estimado_prima_total_objetivo'] = errors['estimado_prima_total_objetivo'] || {};
            errors['estimado_prima_total_objetivo'].required = true;
        }
        callback(null, fields, errors);
    },

    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "TCTBL_Backlog_Seguros") + '</b><br>';
                    }
                    }
            }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en el registro:<br>" + campos,
                autoClose: false
            });
        }
    callback(null, fields, errors);
    },

})
