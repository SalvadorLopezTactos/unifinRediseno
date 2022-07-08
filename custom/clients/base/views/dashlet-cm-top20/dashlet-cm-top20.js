({
    plugins: ['Dashlet'],

    dataResult:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        self = this;
        this.top20();
    },

    top20: function () {
        app.api.call('GET', app.api.buildURL('Top20Backlog'), null, {
            success: function (data) {
				console.log(data);
				self.dataResult = data.records;
				self.render();
				const ctx = document.getElementById('top20').getContext('2d');
				var labels = data.labels;
				var datas = {
					labels: labels,
					datasets: [{
						label: 'Top 20 Backlog',
						data: data.datas,
						backgroundColor: data.colors,
						borderColor: data.colors,
						borderWidth: 1
					}]
				};
				var myChart= new Chart(ctx,{
					type: 'bar',
					data: datas,
					options: {
					  scales: {
						y: {
						  beginAtZero: false
						}
					  }
					},
				});
            },
            error: function (e) {
                throw e;
            }
        });
    },
})
