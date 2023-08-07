({
    extendsFrom: 'EnumField',

    initialize: function (options){

        this._super('initialize',[options]);
    },

    render : function(){
    	if(this.name === 'status'){
            /**
            * Si el caso se encuentra "Atrasado" (Fecha de seguimiento), el status solo puede cambiarse a Escalado o Completado, es decir, no se puede establecer status anteriores
            */
            var fecha_vencimiento = this.model.get('follow_up_datetime');
            var status_actual = this.model.get('status');
            
            if( fecha_vencimiento != "" && fecha_vencimiento != undefined ){

                //var date = new Date();
                //var fecha_actual = date.getFullYear().toString() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-'+ String(date.getDate()).padStart(2, '0');

                //Si la fecha de seguimiento es menor a la fecha actual, es un caso atradado
                var time_fecha_actual = new Date().getTime();
                var time_fecha_vencimiento = new Date(fecha_vencimiento).getTime();

                if( time_fecha_vencimiento < time_fecha_actual ){
                    var lista_status= app.lang.getAppListStrings('case_status_dom');

                    //Solo mostrar "Completada" o "Escalada"
                    Object.keys(lista_status).forEach(function (key) {
                        if(key !="3" && key != "5" && key != status_actual){
                            delete lista_status[key];
                        }
                    });

                    this.items = lista_status;

                    //Status se establece vacío para que no permita guardar ya que el registro se encuentra vencido en caso de que aún no se haya establecido como Completada o Escalada
                    if( status_actual != '3' && status_actual !='5'){
                        this.model.set('status','');
                    }
                    
                }
            }
        }
        this._super('render');
    }
})