({
    extendsFrom : 'PreviewView',
    
    initialize : function(options)
    {
        this._super("initialize",[options]);
		this.model.on('sync', this.ocultaFunc, this);
		app.events.on("preview:render", this.ocultaFunc, this);
    },   
    
    ocultaFunc : function()
    {
        var str = this.model.get("description");
        expreg = str.search(/ALERTA:/i);
        if(expreg >= 0)
	    {
			$('div[name="is_read"]').parent().hide();
	    }
    }
})