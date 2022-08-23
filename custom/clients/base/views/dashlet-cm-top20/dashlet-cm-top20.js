({
    plugins: ['Dashlet'],

    dataResult:[],
	regional:false,

    initialize: function (options) {
        this._super("initialize", [options]);
        self_top = this;
        self_top.top20();
    },

    top20: function () {
		var posicion_operativa = App.user.attributes.posicion_operativa_c;
		self_top.regional = posicion_operativa.indexOf("2")>=0 ? true:false;

        app.api.call('GET', app.api.buildURL('Top20Backlog'), null, {
            success: function (data) {
				console.log(data);
				self_top.dataResult = data.records;
				var labels = data.labels;
				self_top.render();
				var dataset=[];
				if(Object.keys(data.datas).length>0){
					for (let index = 0; index < Object.keys(data.datas).length; index++) {//El object se recorre hasta una posición antes para no tomar en cuenta el atributo "Total"
						var registro={
							label: data.datas[index].etapa,
							backgroundColor: "#"+self_top.randomColor(),
							data: data.datas[index].monto,
						}
						dataset[index]=registro;
					}
				}
				const ctx = document.getElementById('top20').getContext('2d');
				const myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: labels,
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
									// Include a dollar sign in the ticks
									callback: function(value, index, ticks) {
										return Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(value);
									}
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
								//text: ['El total es '+data['Total'],'Para filtrar información, dar click sobre el nombre del asesor'],
								font:{
									size:14
								},
								padding: {
									top: 10,
									bottom: 30
								}
							},
							tooltip: {
								callbacks: {
									label: function(context) {
										let label = context.dataset.label || '';
										if (label) {
											label += ': ';
										}
										if (context.parsed.y !== null) {
											label += new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MEX' }).format(context.parsed.y);
										}
										return label;
									}
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
