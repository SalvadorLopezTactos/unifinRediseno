({
    extendsFrom: 'EnumField',

    initialize: function (options){
        this._super('initialize',[options]);
    },

    render : function(){
    	if(this.name === 'status'){
    		var lista = app.lang.getAppListStrings('meeting_status_dom');
        
        if( this.model.get('status') === 'Planned' && this.model.get('parent_type') == 'Accounts'){
          lista = app.lang.getAppListStrings('meeting_status_list');
        }
		    this.items = lista;
      }
      this._super('render');
    }
})