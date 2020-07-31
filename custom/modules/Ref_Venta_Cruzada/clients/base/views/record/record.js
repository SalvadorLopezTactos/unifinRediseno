({
    extendsFrom: 'RecordView',   

    initialize: function (options) {
        self = this;
        contexto_cuenta = this;
        
		this._super("initialize", [options]);

    },
	
	_renderHtml: function(){      
		var self = this;  
		self.noEditFields.push('estatus');
		self.noEditFields.push('producto_referenciado');
		self.noEditFields.push('producto_origen');
		self.noEditFields.push('numero_anexos');
		self.noEditFields.push('primer_fecha_anexo');
		self.noEditFields.push('ultima_fecha_anexo');
		
		this._super('_renderHtml'); 
      
	},
    
	_dispose: function(){  
		this._super('_dispose');  
	},

	_render: function (options) {
        this._super("_render");
    },	

})