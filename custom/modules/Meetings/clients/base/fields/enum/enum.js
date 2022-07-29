({
    extendsFrom: 'EnumField',

    initialize: function (options)
    {
        this._super('initialize',[options]);
    },

    render : function()
    {
    	if(this.name === 'status')
	    {
    		var lista = app.lang.getAppListStrings('meeting_status_dom');
        if(this.model.get('parent_name') !== '' && this.model.get('status') === 'Planned')
        {
          lista = app.lang.getAppListStrings('meeting_status_list');
        }
		    this.items = lista;
      }
      this._super('render');
    }
})