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
                aux = data.Datos.records;
                aux1 = data.Totales.records[0];
                dato =new Object();
                dato1 =new Object();
                dato2 =new Object();
                index = 0;

                _.each(aux, function (value, key) {
                    if(value['filtro'] == "En proceso"){
                        if(value['etapa'] == '3'){ dato.prospecto =  value['suma'] ;}
                        if(value['etapa'] == '4'){ dato.credito =  value['suma'];   }
                        if(value['etapa'] == '2'){ dato.rechazada =  value['suma']; }
                    }
                    if(value['filtro'] == "Autorizado"){
                        if(value['solicitud'] == '2'){ dato1.sinsc = value['suma']; }
                        if(value['solicitud'] == '1'){ dato1.consc =  value['suma'] ; }
                    }
                }),
                dato1.total = parseFloat(dato1.sinsc) + parseFloat(dato1.consc); 
                backlog.dataEnproceso.push(dato);
                backlog.dataAutorizado.push(dato1);
                //total['total'] = sinsc['sinsc'] + consc['consc'] ; 
                //backlog.dataEnproceso = new Array(prospecto,credito,rechazada);
                //backlog.dataAutorizado = new Array(sinsc,consc,total);
                
                _.each(aux1, function (value, key) {
                    if (key == "montoTotal") { dato2.montoTotal =  parseFloat(value) ; }
                    if (key == "conteoTotal") {dato2.conteoTotal =  parseFloat(value) ; } 
                }),
                backlog.dataTotal.push(dato2);
                backlog.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },
    
})
