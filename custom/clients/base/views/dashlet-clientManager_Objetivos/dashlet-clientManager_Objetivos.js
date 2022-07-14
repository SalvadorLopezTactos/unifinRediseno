({
    plugins: ['Dashlet'],
    dataMensual:[],
    dataAnual:[],
    
    initialize: function (options) {
        this._super('initialize', [options]);

        obj = this;
        obj.data();
        //this.model.on('sync', this.setChart, this);
        //this.model.on('sync', this.setChart1, this);
    },

    data: function () {
        
        var puesto_usuario = App.user.attributes.puestousuario_c;
        var idUsuarioLogeado = App.user.attributes.id;
        var posiciones = App.user.attributes.posicion_operativa_c;
        var equipo = App.user.attributes.equipo_c;
        var region = App.user.attributes.region_c;

        const d = new Date();
        var mes = d.getMonth();
        var anio = d.getFullYear();

        var Params = JSON.stringify({
            'id_user': idUsuarioLogeado,
            'posicion': posiciones,
            'puesto': puesto_usuario,
            'equipo': equipo,
            'region': region,
            'mes': mes,
            'anio': anio
        });

        console.log(Params);
        app.api.call('GET', app.api.buildURL('getObjetivos/'+ Params), null, {
            success: function (data) {
				console.log(data);
                obj.setChart(data['Mensual'].montocubierto, data['Mensual'].presupuesto, data['Mensual'].avance,data['Mensual'].avance_gr);
                obj.setChart1(data['Anual'].montocubierto, data['Anual'].presupuesto, data['Anual'].avance, data['Anual'].avance_gr);
                //obj.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    /**
     * {@inheritDoc}
     */
    bindDataChange: function() {
        this.settings.on('change', function(model) {
            // reload the chart
            if (this.$el && this.$el.is(':visible')) {
                this.loadData({});
            }
        }, this);
    },


    /**
     * @inheritDoc
     */
    unbind: function() {
        this.settings.off('change');
        this._super('unbind');
    },

    _render: function () {
        this._super("_render");
    },

    setChart:function( valor1, valor2, porcentaje, gr){

        const mensual = document.getElementById('chartMensual').getContext('2d');
        
        const chartMensual = new Chart(mensual, {
            type: 'doughnut',
            data: {
                labels: ['0 - 50','50 - 100','100 - 200'],
                datasets: [{
                    data: [33, 34, 33],
                    backgroundColor: [
                        'rgba(255, 206, 86)',
                        'rgba(63, 191, 63)',
                        'rgb(54, 162, 235)',
                    ]
                },
                {
                    data: [gr,1, (100-gr)],
                    backgroundColor: [
                        "rgba(0, 0, 0, 0)",
                        "rgba(0, 0, 0, 0.6)",
                        "rgba(0, 0, 0, 0)"
                    ],
                    borderColor : [
                        "rgba(0, 0, 0, 0.4)",
                        "rgba(0, 0, 0, 0.4)",
                        "rgba(0, 0, 0, 0.4)"
                    ],
                    borderWidth: 1,
                    hoverBackgroundColor: [
                        "rgba(0, 0, 0, 0)",
                        "rgba(0, 0, 0, 0.6)",
                        "rgba(0, 0, 0, 0)"
                    ],
                    hoverBorderWidth: 0
                }
                ],
            },
            options: {
                responsive:true,
                rotation: -90.0,
                circumference: -180,
                cutoutPercentage: 0,
                legend: {
                    position: 'top',
                    display: true
                },
                animation: {
                    animateRotate: false,
                    animateScale: true
                },
                tooltips: {
                    enabled: true
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Objetivo Mensual: "+ valor2 ,
                        position: "top"
                    },
                    subtitle: {
                        display: true,
                        text: "Monto Cubierto: "+valor1+ "  -    "+ porcentaje+" %",
                    },
                    tooltip: {
                        enabled : false,
                    },
                },
            }

        });
    },
    
    setChart1:function(valor1, valor2, porcentaje, gr){
        var ctx1 = document.getElementById("chartAnual");
        var chartAnual = new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['0 - 50','50 - 100','100 - 200'],
                datasets: [{
                    label: 'rangos',
                    data: [ 33, 34, 33],
                    needleValue: 27,
                    hoverOffset: 4,
                    backgroundColor: [
                        'rgba(255, 206, 86)',
                        'rgba(63, 191, 63)',
                        'rgb(54, 162, 235)',
                    ]
                },
                {
                    data: [gr,1, (100-gr)],
                    labels: ['1','2','3'],
                    backgroundColor: [
                        "rgba(0, 0, 0, 0)",
                        "rgba(0, 0, 0, 0.6)",
                        "rgba(0, 0, 0, 0)"
                    ],
                    borderColor : [
                        "rgba(0, 0, 0, 0.4)",
                        "rgba(0, 0, 0, 0.4)",
                        "rgba(0, 0, 0, 0.4)"
                    ],
                    borderWidth: 1,
                    hoverBackgroundColor: [
                        "rgba(0, 0, 0, 0)",
                        "rgba(0, 0, 0, 0.6)",
                        "rgba(0, 0, 0, 0)"
                    ],
                    hoverBorderWidth: 0
                }
                ],
            },
            options: {
                responsive:true,
                rotation: -90.0,
                circumference: -180,
                cutoutPercentage: 0,
                legend: {
                    position: 'top',
                    display: false
                },
                animation: {
                    animateRotate: false,
                    animateScale: true
                },
                tooltips: {
                    enabled: true
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Objetivo Anual : "+ valor2 ,
                        position: "top"
                    },
                    subtitle: {
                        display: true,
                        text: "Monto Cubierto: "+valor1+ "  -    "+ porcentaje+" %",
                    },
                    tooltip: {
                        enabled : false,
                    },
                },
            }
        });
    }
})
