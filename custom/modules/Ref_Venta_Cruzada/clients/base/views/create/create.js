({
    extendsFrom: 'CreateView',   

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
		this.model.addValidationTask('check_Requeridos', _.bind(this.valida_requeridos, this));

		//this.model.addValidationTask('mismo_producto', _.bind(this.mismo_producto, this));
    },
	
	_renderHtml: function(){      
		
        var userprod = (app.user.attributes.tipodeproducto_c).replace(/\^/g, "");
		
		if(this.model.get('producto_origen') != null || this.model.get('producto_origen') != ""){
			this.model.set('producto_origen', userprod);
		}
		
		//if(this.model.get('usuario_rechazo') == null || this.model.get('producto_origen') == ""){
		//	this.model.set('usuario_rechazo', App.user.attributes.id);
		//}
		this._super('_renderHtml');  
      
	},
    
	_dispose: function(){  
		this._super('_dispose');  
	},

	_render: function (options) {
        this._super("_render");
    },	
	
	valida_requeridos: function (fields, errors, callback) {
        var campos = "";   
      
        if ( this.model.get('description') == '' ) {
            campos = campos + '<b>' + 'Necesidad del cliente' + '</b><br>';
            errors['description'] = errors['description'] || {};
            errors['description'].required = true;
        }
        
		if (this.model.get('producto_referenciado') == '') {
			campos = campos + '<b>' + 'Producto referenciado'+ '</b><br>';
            errors['producto_referenciado'] = errors['producto_referenciado'] || {};
            errors['producto_referenciado'].required = true;
        }
        if (campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información para guardar una <b>Referencia Venta Cruzada: </b><br>" + campos,
                autoClose: false
            });
        }

        callback(null, fields, errors);
    },

})