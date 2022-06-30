({
    plugins: ['Dashlet'],
    dataEnproceso:[],
    dataAutorizado:[],
    dataTotal:[],
    montoTotal:0,

    initialize: function (options) {
        this._super("initialize", [options]);
        backlog = this;
        this.totalBacklog();
    },


    totalBacklog: function () {
        //DASHLET: Asesor
        
        app.api.call('GET', app.api.buildURL('GetClientManager_BacklogTabla/'+ app.user.get('id')), null, {
            success: function (data) {
				console.log(data);
                aux = data.Datos;
                aux1 = data.Totales;
                index = 0;

                //backlog.dataEnproceso.push(dato);
                //backlog.dataAutorizado.push(dato1);
                //backlog.dataEnproceso = new Array(prospecto,credito,rechazada);
                //backlog.dataAutorizado = new Array(sinsc,consc,total);
                
                /*_.each(aux1, function (value, key) {
                    if (key == "montoTotal") { dato2.montoTotal =  parseFloat(value) ; }
                    if (key == "conteoTotal") {dato2.conteoTotal =  parseFloat(value) ; } 
                }),*/
                backlog.dataTotal=data;
                backlog.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },
    
})
