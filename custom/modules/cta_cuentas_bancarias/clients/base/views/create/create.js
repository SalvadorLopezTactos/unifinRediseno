({
    extendsFrom: 'CreateView',

    initialize: function (options) {

        this._super("initialize", [options]);
        
		this.model.addValidationTask('validaClabe', _.bind(this.validaClabe, this));
    },

    validaClabe: function (fields, errors, callback) {

        var clabe = this.model.get('clabe');

        var regex = /^\d{18}$/;

        if( !regex.test(clabe) && clabe != "" ){
            app.alert.show("errorClabe", {
              level: "error",
              title: "Clabe interbancaria no válida",
              messages:"Formato incorrecto, favor de ingresar los 18 dígitos de la Clabe Interbancaria",
              autoClose: false,
            });

            errors["clabe"] = errors["tipo_producto_c"] || {};
            errors["clabe"].required = true;
        }

        callback(null, fields, errors);
    }
})
