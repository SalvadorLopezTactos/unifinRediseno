({
    extendsFrom: 'EnumField',

    initialize: function (options){
        this._super('initialize',[options]);
    },

    render : function(){
    	if(this.name === 'status'){
    		var lista = {};

        var fechaActual = new Date(); //obtiene fecha actual
        var fechainicio = new Date(this.model.get("date_start"));
        var d = fechainicio.getDate();
        var m = fechainicio.getMonth() + 1;
        var y = fechainicio.getFullYear();
        var fechafin= new Date(y,m-1,d+1, 2,0); //Fecha final

        if( fechaActual>fechainicio && this.model.get('status') === 'Planned' && this.model.get('parent_type') != 'Accounts' ){
          lista = app.lang.getAppListStrings('meeting_status_dom');

        }else {
          //( this.model.get('status') === 'Planned' && this.model.get('parent_type') == 'Accounts')
          lista = app.lang.getAppListStrings('meeting_status_list');
        }
        
		    this.items = lista;
      }
      this._super('render');
    }
})