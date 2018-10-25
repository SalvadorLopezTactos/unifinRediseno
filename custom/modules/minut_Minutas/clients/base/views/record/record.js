({
    extendsFrom: 'RecordView',

    initialize: function (options)
    {
        this._super("initialize", [options]);
        this.context.on('button:view_document:click', this.view_document, this);
    },

    view_document: function()
    {
        var pdf = window.location.origin+window.location.pathname+"/custom/pdf/ladas.pdf";
    	window.open(pdf,'_blank');
    	var cDate = new Date();
        this.model.set('fecha_y_hora_c',cDate);
        navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var lng = position.coords.longitude;
          var geocoder = new google.maps.Geocoder();
          var latlng = {lat: lat, lng: lng};
          geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
              if (results[0]) {
                var direccion = results[0].formatted_address;
                alert(direccion);
              } else {
                window.alert('No se encontro la dirección');
              }
            } else {
              window.alert('Error de Google: ' + status);
            }
          });
        });
	this.model.set('description',cDate);
	this.model.save();
    },
})