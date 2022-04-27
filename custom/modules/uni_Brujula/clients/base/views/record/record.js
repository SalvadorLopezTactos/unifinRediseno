({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        /*@Jesus Carrillo
            Funcion que pinta de color los paneles relacionados
        */
        this.model.on('sync', this.fulminantcolor, this);

        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));
    },

    /*@Jesus Carrillo
        Funcion que pinta de color los paneles relacionados
    */
    fulminantcolor: function () {
        $( '#space' ).remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "uni_Brujula") + '</b><br>';
                    }
          		  }
       	    }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Brujula:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },
})
