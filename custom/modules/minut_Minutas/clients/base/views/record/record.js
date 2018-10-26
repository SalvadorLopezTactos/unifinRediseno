({
    extendsFrom: 'RecordView',

    initialize: function (options)
    {
        this._super("initialize", [options]);
        this.context.on('button:view_document:click', this.view_document, this);
    },

    view_document: function()
    {
    		window.open('https://www.natura.com.mx/repositorio/descargas/consultorias/CONSULTORIA_C15-18.pdf','_blank');
    		var cDate = new Date();
        this.model.set('fecha_y_hora_c',cDate);
        navigator.geolocation.getCurrentPosition(function(position) {
          var latitud = position.coords.latitude;
          var longitud = position.coords.longitude;
          alert(latitud);
        });
    		this.model.set('description',cDate);
    },
})