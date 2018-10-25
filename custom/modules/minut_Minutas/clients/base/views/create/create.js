({
    extendsFrom: 'CreateView',
    
	initialize: function (options) {
        this._super('initialize', [options]);
		this.context.on('button:view_document:click', this.view_document, this);
    },
    
    view_document: function()
    {
		var pdf = window.location.origin+window.location.pathname+"/custom/pdf/Ladas.pdf";
    	window.open(pdf,'_blank');
    	var cDate = new Date();
        this.model.set('tct_proceso_unifin_time_c',cDate);
        navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var lng = position.coords.longitude;
		  var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=AIzaSyDdJzHxd4GtxcrAhc9C_2Qg-mqra1-IjtQ";
          $.getJSON(url, function(data) {
          	var address = data.results[0]['formatted_address'];
			this.model.set('tct_proceso_unifin_address_c',address);
          });
        });
    },
})
