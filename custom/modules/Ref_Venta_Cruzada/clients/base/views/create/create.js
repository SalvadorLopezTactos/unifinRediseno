({
    extendsFrom: 'CreateView',   

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
		this.model.addValidationTask('producto_repetido', _.bind(this.producto_repetido, this));
    },
	
	_renderHtml: function(){      
		
        var userprod = (app.user.attributes.tipodeproducto_c).replace(/\^/g, "");
		
		if(this.model.get('producto_origen') != null || this.model.get('producto_origen') != ""){
			this.model.set('producto_origen', userprod);
		}
		this._super('_renderHtml');  
      
	},
    
	_dispose: function(){  
		this._super('_dispose');  
	},

	_render: function (options) {
        this._super("_render");
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

})