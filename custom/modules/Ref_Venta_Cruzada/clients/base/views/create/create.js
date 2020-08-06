({
    extendsFrom: 'CreateView',   

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
		this.model.addValidationTask('producto_repetido', _.bind(this.producto_repetido, this));
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
        $('[data-name="cancelado"]').hide();
    },	
	
	producto_repetido: function (fields, errors, callback) {
        app.alert.dismiss('Error_validacion_Campos');
        var sameproductref = 0;
        
		app.api.call("read", app.api.buildURL("Accounts/" + this.model.get('accounts_ref_venta_cruzada_1accounts_ida') + "/link/accounts_ref_venta_cruzada_1", null, null,
			null), null, {
            success: _.bind(function (data) {
				if (data.records.length > 0) {
                    for(var i=0;i<data.records.length;i++){
                        //Validar si es activa
                        if(data.records[i].estatus=='1' && data.records[i].producto_referenciado == this.model.get('producto_referenciado')){
                            errors['account_ref_valida'] = errors['account_ref_valida'] || {};
							sameproductref = sameproductref+1;
							
                        }
					}
					if(sameproductref > 0){
						app.alert.show("Error_validacion_Referencias", {
							   level: "error",
							   messages: 'El producto seleccionado, tiene una referencia activa',
							   autoClose: false
							});
						errors['account_ref_valida'] = errors['account_ref_valida'] || {};
						errors['producto_referenciado'] = errors['producto_referenciado'] || {};
						errors['producto_referenciado'].required = true;
					}
                }
				callback(null,fields,errors);
			}, this)
        });
		
		//callback(null, fields, errors);
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