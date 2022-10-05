({
    plugins: ['Dashlet'],

    initialize: function (options) {
        this._super("initialize", [options]);
        self=this;
        this.model.on('sync', this.setChart, this);
    },

    _render: function () {
        this._super("_render");
    },

    setChart:function(){
        contextoChart=this;
        var equipos=App.user.attributes.equipos_c;

        App.alert.show('getProspectosEstatus', {
            level: 'process',
            title: 'Cargando',
        });
       app.api.call('GET', app.api.buildURL('GetProspectosEstatus/'+equipos), null, {
        success: function (data) {
            App.alert.dismiss('getProspectosEstatus');
            contextoDetalleGrafica.registrosUsuarios=[];
            
            //Estableciendo variables para los totales
            contextoDetalleGrafica.GranTotal=data['Total'];
            contextoDetalleGrafica.TotalSinContactar=data['TotalSinContactar'];
            contextoDetalleGrafica.TotalContactado=data['TotalContactado'];
            contextoDetalleGrafica.TotalInteresado=data['TotalInteresado'];
            contextoDetalleGrafica.TotalIntExp=data['TotalIntExp'];
            contextoDetalleGrafica.TotalCredito=data['TotalCredito'];
            contextoDetalleGrafica.TotalSinOperar=data['TotalSinOperar'];
            contextoDetalleGrafica.TotalActivo=data['TotalActivo'];
            contextoDetalleGrafica.TotalPerdido=data['TotalPerdido'];
            
            //Generando dataset
            var dataset=[];
            if(Object.keys(data).length>0){
                for (let index = 0; index < Object.keys(data).length-9; index++) {//El object se recorre hasta 9 posiciones antes para no tomar en cuenta los atributos con Totales

                    //Seteo de arreglo para evitar tomar los últimos 9 atributos (Que son los totales), los cuales no cuentan para mostrarlos en la tabla
                    contextoDetalleGrafica.registrosUsuarios.push(data[index]);
                    var registro={
                        label: data[index].Usuario,
                        backgroundColor: "#"+contextoChart.randomColor(),
                        data: data[index].Registros,
                    }
                    dataset[index]=registro;
                }

                //contextoChart.render();
                contextoDetalleGrafica.render();
            }
            
            var textChart="";
            if(App.user.attributes.posicion_operativa_c.includes('^2^')){
                textChart="Para filtrar información, dar click sobre el nombre del equipo";
            }else{
                textChart="Para filtrar información, dar click sobre el nombre del asesor"
            }
            const ctx = document.getElementById('myChart').getContext('2d');

            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Lead Sin Contactar",
                    "Prospecto Contactado",
                    "Prospecto Interesado",
                    "Prospecto Integración de Expediente",
                    "Prospecto en Crédito",
                    "Cliente con Línea sin Operar",
                    "Cliente Activo",
                    "Cliente Perdido"],
                    datasets: dataset,  
                },
                options: {
                    tooltips: {
                      displayColors: true,
                      callbacks:{
                        title: function(tooltipItem, data) {
                            console.log("TITLE");
                            console.log(tooltipItem);
                            console.log(data);
                            return data['labels'][tooltipItem[0]['index']];
                          },
                          label: function(tooltipItem, data) {
                            console.log("LABEL");
                            console.log(tooltipItem);
                            console.log(data);
                            return 'Nombre: '+data['datasets'][0]['data'][tooltipItem['index']];
                          },
                      },
                    },
                    scales: {
                        x: {
                            stacked: true,
                            gridLines: {
                                display: false,
                            }
                         },
                        y: {
                            stacked: true,
                            ticks: {
                            beginAtZero: true,
                            },
                            type: 'linear'
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { position: 'bottom' },
                    plugins: {
                        title: {
                            display: true,
                            text: ['El total es '+data['Total'],textChart],
                            font:{
                                size:14
                            },
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        }
                    }
                }
            });
            
        },
        error: function (e) {
            throw e;
        }
    });

    },

    /**
     * Función para generar colores hexadecimales y se puedan mostrar colores variados en las barras de la gráfica
     */
    randomColor:function(){
        return Math.floor(Math.random()*16777215).toString(16);
    }

})