({
    extendsFrom: 'CreateView',

    latitude :0,
    longitude:0,

    initialize: function (options) {
        //this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        
        self = this;
        this._super("initialize", [options]);
        this.model.addValidationTask('save_meetings_status_and_location', _.bind(this.savestatusandlocation, this));
    		this.context.on('button:view_document:click', this.view_document, this);

},
    /*Actualiza el estado de la reunion además de guardar fecha y lugar de Check-Out
    *Victor Martínez 23-10-2018
    */    
    savestatusandlocation:function(fields, errors, callback){
        self=this;
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(this.showPosition);
        }else {
            alert("No se pudo encontrar tu ubicacion");
        }
          
        var today= new Date();
        //self.model.set('check_in_time_c', today);
        var moduleid = app.data.createBean('Meetings',{id:this.model.get('minut_minutas_meetingsmeetings_idb')});
        moduleid.fetch({
        success:_.bind(function(modelo){
            this.estado = modelo.get('status');
            this.checkoutad=modelo.get('check_out_address_c');
            this.checkoutime=modelo.get('check_out_time_c');
            this.checkoutlat=modelo.get('check_out_latitude_c');
            this.checkoutlong=modelo.get('check_out_longitude_c');
            this.resultado=modelo.get('resultado_c');
            modelo.set('status', 'Held');
            modelo.set('check_out_address_c');
            modelo.set('check_out_time_c', today);
            modelo.set('check_out_latitude_c',self.latitude);
            modelo.set('check_out_longitude_c',self.longitude);
            modelo.set('resultado_c', self.model.get('resultado_c'));
            modelo.save();
            }, this)
        });
        callback(null,fields,errors);
    },

    showPosition:function(position) {
        self.longitude=position.coords.longitude;
        self.latitude=position.coords.latitude;
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
