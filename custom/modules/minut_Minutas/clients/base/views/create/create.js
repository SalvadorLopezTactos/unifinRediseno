({
    extendsFrom: 'CreateView',

    latitude :0,
    longitude:0,

    initialize: function (options) {
        //this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);
        this.model.addValidationTask('save_meetings_status_and_location', _.bind(this.savestatusandlocation, this));
        this.model.addValidationTask('checkcompromisos', _.bind(this.checkcompromisos, this));
        this.context.on('button:view_document:click', this.view_document, this);
    },

    render: function(){
        this._super("render");
        //Quita etiquetas de campos custom
        $('[data-name=minuta_participantes]').find('.record-label').addClass('hide');
        $('[data-name=minuta_objetivos]').find('.record-label').addClass('hide');
        $('[data-name=minuta_compromisos]').find('.record-label').addClass('hide');
        $('[data-name=minuta_division]').find('.record-label').addClass('hide');

        //Bloquea campo de ReuniÃ³n relacionada
        if(this.model.get('minut_minutas_meetingsmeetings_idb')!=undefined){

            $('[data-name="minut_minutas_meetings_name"]').attr('style','pointer-events:none');

        }
    },

    /*Actualiza el estado de la reunion además de guardar fecha y lugar de Check-Out
    *Victor Martínez 23-10-2018
    */
        savestatusandlocation:function(fields, errors, callback){

        try {
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
                  modelo.save([],{
                      dataType:"text",
                      complete:function() {
                          //app.router.navigate(module_name , {trigger: true});
                          location.reload();
                      }
                  });
              }, this)
          });
        } catch (e) {
            console.log("Error: al recuperar ubicación para unifin proceso")
        }
        callback(null,fields,errors);
    },

    checkcompromisos:function(fields, errors, callback){
        $('.existingcompromiso').each(function(index,item){
            if($(item).val().trim()!=''){
                $('.existingcompromiso').eq(index).css('border-color', '');
            }else{
                $('.existingcompromiso').eq(index).css('border-color', 'red');
                app.alert.show("empty_compromiso", {
                    level: "error",
                    title: "Existen compromisos <b>sin nombre</b>, favor de verificar",
                    autoClose: false
                });
                errors['comp_comp'] = errors['comp_comp'] || {};
                errors['comp_comp'].required = true;
            }
        });
        $('.existingdate').each(function(index,item){
            if($(item).val().trim()!=''){
                $('.existingdate').eq(index).css('border-color', '');
            }else{
                $('.existingdate').eq(index).css('border-color', 'red');
                app.alert.show("empty_date", {
                    level: "error",
                    title: "Existen compromisos <b>sin fecha</b>, favor de verificar",
                    autoClose: false
                });
                errors['comp_date'] = errors['comp_date'] || {};
                errors['comp_date'].required = true;
            }
        });
        $('.existingresponsable').each(function(index,item){
            if($(item).text().trim()!=''){
                $('.existingresponsable').eq(index).css('border-color', '');
            }else{
                $('.existingresponsable').eq(index).css('border-color', 'red');
                app.alert.show("empty_resp", {
                    level: "error",
                    title: "Existen compromisos <b>sin responsable</b>, favor de verificar",
                    autoClose: false
                });
                errors['comp_resp'] = errors['comp_resp'] || {};
                errors['comp_resp'].required = true;
            }
        });
        callback(null,fields,errors);
    },

    showPosition:function(position) {
        self.longitude=position.coords.longitude;
        self.latitude=position.coords.latitude;
    },

    view_document: function(){
		  var pdf = window.location.origin+window.location.pathname+"/custom/pdf/Ladas.pdf";
    	window.open(pdf,'_blank');
      self.model.set('tct_proceso_unifin_time_c',this.model.get('tct_today_c'));
      navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var lng = position.coords.longitude;
		      var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=AIzaSyDdJzHxd4GtxcrAhc9C_2Qg-mqra1-IjtQ";
          $.getJSON(url, function(data) {
          	var address = data.results[0]['formatted_address'];
			      self.model.set('tct_proceso_unifin_address_c',address);
          });
      });
    },
})
