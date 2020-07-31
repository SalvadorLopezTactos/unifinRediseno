({
    extendsFrom: 'CreateView',   

    initialize: function (options) {
        self = this;
        contexto_cuenta = this;
        
		this._super("initialize", [options]);

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

})