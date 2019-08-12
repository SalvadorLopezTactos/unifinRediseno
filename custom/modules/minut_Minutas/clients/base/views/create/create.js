({
    extendsFrom: 'CreateView',

    latitude :0,
    longitude:0,
    urlEncuesta: null,


    initialize: function (options) {
        //this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);
        this.model.addValidationTask('checkcompromisos', _.bind(this.checkcompromisos, this));
        this.model.addValidationTask('validaFecha', _.bind(this.validaFechaReunion, this));
        this.model.addValidationTask('save_Asistencia_Parti', _.bind(this.saveAsistencia, this));
        this.model.addValidationTask('save_Referencias', _.bind(this.saveReferencias, this));
        //this.model.addValidationTask('validaObjetivosmarcados', _.bind(this.validaObjetivosmarcados,this));
        this.model.addValidationTask('save_Reuunion_Llamada',_.bind(this.saveReuionLlamada, this));
        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));
        //Mantener como último VT a savestatusandlocation
        this.model.addValidationTask('save_meetings_status_and_location', _.bind(this.savestatusandlocation, this));
        this.context.on('button:view_document:click', this.view_document, this);
        //Evento para contestar encuesta
        this.context.on('button:survey_minuta:click', this.open_survey_minuta, this);

    },

    render: function(){
        this._super("render");
        //Quita etiquetas de campos custom
        $('[data-name=minuta_participantes]').find('.record-label').addClass('hide');
        $('[data-name=minuta_objetivos]').find('.record-label').addClass('hide');
        $('[data-name=minuta_compromisos]').find('.record-label').addClass('hide');
        $('[data-name=minuta_division]').find('.record-label').addClass('hide');

        //Oculta panel con campos de checkin en minuta
        $('[data-panelname="LBL_RECORDVIEW_PANEL4"]').addClass('hide');

        //Bloquea campo de ReuniÃ³n relacionada
        if(this.model.get('minut_minutas_meetingsmeetings_idb')!=undefined){

            $('[data-name="minut_minutas_meetings_name"]').attr('style','pointer-events:none');

        }
        this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(0).removeClass('panel-inactive');
        this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(0).addClass('panel-active');
        this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(1).attr("style","display:block");
    },

    /* F. Javier G. Solar 9-10-2018
     * Valida asistencia de almenos un participante tipo Cuenta
     */
    saveAsistencia: function (fields, errors, callback) {
        var objParticipantes = selfData.mParticipantes["participantes"];
        banderaAsistencia = 0;
        banderaCorreo = 0;
        for (var i = 0; i < objParticipantes.length; i++) {
            if (objParticipantes[i].asistencia == 1 && objParticipantes[i].unifin != 1) {
                banderaAsistencia++;
            }
            if (!objParticipantes[i].correo && objParticipantes[i].asistencia ==1 && objParticipantes[i].unifin != 1) {
                banderaCorreo++;
            }
        }
        // Valida Asistencias
        if (this.model.get('resultado_c') != '1') {
            if (banderaAsistencia < 1) {
                app.alert.show("Asistencia", {
                    level: "error",
                    messages: "Debes marcar <b>asistencia</b> por lo menos a un <b>Participante</b> tipo Cuenta.",
                    autoClose: false,
                    return: false,
                });
                errors['xd'] = errors['xd'] || {};
                errors['xd'].required = true;
            }
        }
        // Valida Correos
        if (banderaCorreo > 0 && banderaAsistencia >= 1) {
            app.alert.show("Correo", {
                level: "error",
                messages: "Todos los <b>Participantes</b> tipo Cuenta marcados con asistencia deben contar con <b>correo</b>.",
                autoClose: false,
                return: false,
            });
            errors['correo'] = errors['correo'] || {};
            errors['correo'].required = true;
        }
        callback(null, fields, errors);
    },

    validaObjetivosmarcados:function(fields,errors,callback){
        var objetivoesp=self.myobjmin;
        var check=false;
        for( i=0 ; i<objetivoesp.records.length; i++){
            if(objetivoesp.records[i].cumplimiento==1 && objetivoesp.records[i].description=="1"){
                check=true;
            }
        }
        if(check==false){
            app.alert.show("Objetivo especifico requerido", {
                level: "error",
                title: "Al menos un un objetivo espec\u00EDfico debe estar marcado",
                autoClose: false
            });
            errors['objetivoespecificos'] = "Al menos un un objetivo espec\u00EDfico debe estar marcado";
        }
        callback(null, fields, errors);
    },
    /*Actualiza el estado de la reunion además de guardar fecha y lugar de Check-Out
    *Victor Martínez 23-10-2018
    */
    savestatusandlocation:function(fields, errors, callback){

      if (Object.keys(errors).length == 0) {
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
                    this.checkoutplat=modelo.get('check_out_platform_c');
                    this.resultado=modelo.get('resultado_c');
                    modelo.set('status', 'Held');
                    modelo.set('check_out_address_c');
                    modelo.set('check_out_time_c', today);
                    modelo.set('check_out_latitude_c',self.latitude);
                    modelo.set('check_out_longitude_c',self.longitude);
                    modelo.set('check_out_platform_c', self.GetPlatform());
                    modelo.set('resultado_c', self.model.get('resultado_c'));
                    modelo.save([],{
                        dataType:"text",
                        complete:function() {
                            //app.router.navigate(module_name , {trigger: true});
                            $('a[name=new_minuta]').hide()
                            SUGAR.App.controller.context.reloadData({});
                            $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                            $('[data-name="assigned_user_name"]').removeAttr("style");
                        }
                    });
                }, this)
            });
          } catch (e) {
              console.log("Error: al recuperar ubicación para unifin proceso")
          }
      }
      callback(null,fields,errors);
    },

    showPosition:function(position) {
        self.longitude=position.coords.longitude;
        self.latitude=position.coords.latitude;
    },

    //Obienete la plataforma del usuario en la cual haya hecho check-in
    GetPlatform: function(){
        var plataforma=navigator.platform;
        if(plataforma!='iPad'){
            return 'Pc';
        }else{
            return 'iPad';
        }
    },

    checkcompromisos:function(fields, errors, callback){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {
            dd = '0'+dd
        }
        if(mm<10) {
            mm = '0'+mm
        }
        today = yyyy+'-'+mm+'-'+dd;

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
                if($(item).val().trim()<today){
                    $('.existingdate').eq(index).css('border-color', 'red');
                    app.alert.show("datecomp_invalid", {
                        level: "error",
                        title: "La fechas de los compromisos deben ser mayor al d\u00EDa de hoy",
                        autoClose: false
                    });
                    errors['comp_date'] = errors['comp_date'] || {};
                    errors['comp_date'].required = true;
                }else {
                    $('.existingdate').eq(index).css('border-color', '');
                }
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

    validaFechaReunion: function(fields, errors, callback){

        //Validar fecha de reunión únicamente cuando el campo sea visible
        if (!$('[data-fieldname="fecha_y_hora_c"]').children().eq(0).hasClass("vis_action_hidden")) {

            var startDate = new Date(this.model.get('fecha_y_hora_c'));
            var startMonth = startDate.getMonth() + 1;
            var startDay = startDate.getDate();
            var startYear = startDate.getFullYear();
            var startDateText = startMonth + "/" + startDay + "/" + startYear;
            // FECHA ACTUAL
            var dateActual = new Date();
            var d1 = dateActual.getDate();
            var m1 = dateActual.getMonth() + 1;
            var y1 = dateActual.getFullYear();
            var dateActualFormat = [m1, d1, y1].join('/');

            var fechaActual = Date.parse(dateActualFormat);
            var startToDate = Date.parse(startDateText);
            if(startToDate < fechaActual)
            {
                app.alert.show("invalid_date_reunion", {
                    level: "error",
                    title: "No se puede agendar reuni\u00F3n para una fecha anterior a la actual",
                    autoClose: false
                });
                errors['fecha_y_hora_c'] = "No se puede agendar reuni\u00F3n para una fecha anterior a la actual";
                errors['fecha_y_hora_c'].required = true;
            }

        }

        callback(null, fields, errors);
    },

    view_document: function(){
		var pdf = window.location.origin+window.location.pathname+"/custom/pdf/proceso_unifin.pdf";
		window.open(pdf,'_blank');
		self.model.set('tct_proceso_unifin_time_c',this.model.get('tct_today_c'));
		self.model.set('tct_proceso_unifin_platfom_c', this.GetPlatform());
        navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var lng = position.coords.longitude;
		  var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=1234";
          /*$.getJSON(url, function(data) {
          	var address = data.results[0]['formatted_address'];
			      self.model.set('tct_proceso_unifin_address_c',address);
          });*/
		  self.model.set('tct_proceso_unifin_address_c',lat+lng);
		});
    },

    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "minut_Minutas") + '</b><br>';
                    }
          		  }
       	    }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Minuta:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    saveReferencias: function (fields, errors, callback) {
        var objReferencias = selfRef.mReferencias["referencias"];
        banderaRef = 0;
        var escritos =[];
        Array.prototype.unique=function(a){
            return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
        });

        for (var i = 0; i < objReferencias.length; i++) {
            var iteradas='';
            if(objReferencias[i].regimen_fiscal=='Persona Moral'){
                iteradas=objReferencias[i].razon_social.trim();
            }else{
                iteradas= objReferencias[i].nombres.trim() + objReferencias[i].apaterno.trim() + objReferencias[i].amaterno.trim();
            }

            iteradas = iteradas.replace(/\s+/gi,'');
            iteradas = iteradas.toUpperCase();
            if (iteradas=="" || (objReferencias[i].telefono == "" && objReferencias[i].correo == "")) {
                banderaRef++;
            }
            escritos.push(iteradas);
        }
        $('td.filareferencia').attr('style','');
        var escritosunicos=escritos.unique();
        if (escritosunicos.length != escritos.length) {
           var escritos_copia=escritos;

            escritos_copia.forEach(function(element, key){
                escritos.forEach(function (elementA,keyA) {
                    if (element==elementA && key!=keyA){
                        $('td.filareferencia').eq(key).attr('style','border: 2px solid red;');
                    }
                });

            });
            app.alert.show("Referenciaduplicada", {
                level: "error",
                title: "Alguna referencia est\u00E1 duplicada. <br> Favor de validar.",
                autoClose: false,
            });
            errors['referncias_duplicadas'] = errors['referncias_duplciadas'] || {};
            errors['referncias_duplicadas'].required = true;
        }
        if (banderaRef >= 1) {
            app.alert.show("ReferenciaVacia", {
                level: "error",
                title: "Alguna referencia est\u00E1 incompleta. <br> Favor de completar los campos.",
                autoClose: false,
            });
            errors['referncias_vacias'] = errors['referncias_vacias'] || {};
            errors['referncias_vacias'].required = true;
        }

        if (objReferencias.length > 0) {
            //Valida si la referencia añadida existe en la db de accounts
            var contadorR = 0;
            for (var i = 0; i < objReferencias.length; i++) {
                //Valida si la referencia añadida existe en la db de accounts
                var nombrecompleto='';
                if(objReferencias[i].regimen_fiscal=='Persona Moral'){

                    nombrecompleto= objReferencias[i].razon_social.trim();

                }else{
                    nombrecompleto = objReferencias[i].nombres.trim() + objReferencias[i].apaterno.trim() + objReferencias[i].amaterno.trim();
                }
                nombrecompleto = nombrecompleto.replace(/\s+/gi,'');


                if (nombrecompleto != "") {


                    var campos = ["primernombre_c", "apellidopaterno_c", "apellidomaterno_c"];
                    app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                        campos: campos.join(','),
                        max_num: 4,
                        "filter": [
                            {
                                "clean_name": nombrecompleto,
                            }
                        ]
                    }), null, {
                        success: _.bind(function (cuenta) {
                            if (cuenta.records.length > 0) {
                                $('td.filareferencia').eq(contadorR).attr('style', 'border: 2px solid red;');
                                app.alert.show("ReferenciaDuplicada", {
                                    level: "error",
                                    title: "Ya existe una cuenta registrada. <br> Favor de verificar.",
                                    autoClose: false
                                });
                                errors['Referenciabuscada'] = errors['Referenciabuscada'] || {};
                                errors['Referenciabuscada'].required = true;
                            }
                            contadorR++;
                            if (contadorR == objReferencias.length) {
                                callback(null, fields, errors);
                            }
                        }, this)
                    });
                }else{
                    errors['Referenciaañadidavacia'] = errors['Referenciaañadidavacia'] || {};
                    errors['Referenciaañadidavacia'].required = true;

                    callback(null, fields, errors);
                }
            }
        }else{
            callback(null, fields, errors);
        }
    },

    saveReuionLlamada: function (fields, errors, callback) {
      //Limpia campos
      var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {
            dd = '0'+dd
        }
        if(mm<10) {
            mm = '0'+mm
        }
        today = yyyy+'-'+mm+'-'+dd;

      var necesarios="";
      $('.newCampo1A').css('border-color', '');
      $('.newDate').css('border-color', '');
      $('.newTime1').css('border-color', '');
      $('.newDate2').css('border-color', '');
      $('.newTime2').css('border-color', '');
      $('.objetivoG').find('.select2-choice').css('border-color','');
      $('.newObjetivoE1').css('border-color', '');

      //Campos necesarios para Reunion y llamada
      if(this.model.get('resultado_c')==5 || this.model.get('resultado_c')==19){
        var necesarios="";
        if($('.newCampo1A').val()=='' || $('.newCampo1A').val()==null){
          necesarios=necesarios  + '<br><b>Asunto</b>'
          $('.newCampo1A').css('border-color', 'red');
        }

        if($('.newDate').val()=='' || $('.newDate').val()==null || $('.newDate').val()==undefined || $('.newTime1').val()=='' || $().val('.newTime1')==null || $().val('.newTime1')==undefined){
          necesarios=necesarios + '<br><b>Fecha inicial</b>'
          $('.newDate').css('border-color', 'red');
          $('.newTime1').css('border-color', 'red');
        }

        var registro="";
        if(this.model.get('resultado_c')==5){
            registro="Reunión";
        }
        if(this.model.get('resultado_c')==19){
            registro="Llamada";
        }

        if($('.newDate').val()<today){
            $('.newDate').css('border-color', 'red');
            app.alert.show("requeridos_reunion_llamada", {
            level: "error",
            messages: "No se pueden agendar la "+registro+" con fecha de inicio menor a la actual",
            autoClose: false
        });
        errors['.newDate'] = errors['.newDate'] || {};
        errors['.newDate'].required = true;
        }

        var fechain=$('.newDate').val();
        var hora_ini=this.validaTiempo($('.newTime1').val());
        var fechafin=$('.newDate2').val();
        var hora_fin=this.validaTiempo($('.newTime2').val());

        var fecha_ini_formateada=new Date(fechain + ' '+hora_ini);
        var fecha_fin_formateada= new Date(fechafin + ' '+hora_fin);

        if(fecha_fin_formateada<fecha_ini_formateada){
            $('.newDate2').css('border-color', 'red');
            $('.newTime2').css('border-color', 'red');
            app.alert.show("Fecha", {
            level: "error",
            messages: "La fecha de fin en la "+registro+" no puede ser menor a la fecha de inicio",
            autoClose: false
        });
        errors['.newDate2'] = errors['.newDate2'] || {};
        errors['.newDate2'].required = true;
        }

        if($('.newDate2').val()=='' || $('.newDate2').val()==null || $('.newDate2').val()==undefined || $('.newTime2').val()=='' || $('.newTime2').val()==null){
          necesarios=necesarios + '<br><b>Fecha Final</b>'
          $('.newDate2').css('border-color', 'red');
          $('.newTime2').css('border-color', 'red');
        }
      }
      //Campos Requeridos para reunión
      if(this.model.get('resultado_c')==5){
        if($('.objetivoG').select2('val')=='' || $('.objetivoG').select2('val')==null || $('.objetivoG').select2('val')==undefined){
          necesarios=necesarios  + '<br><b>Objetivo General</b>'
          $('.objetivoG').find('.select2-choice').css('border-color','red');
        }
        /*if($('.objetivoEselect').eq(0).find('input').val()=='' || $('.objetivoEselect').eq(0).find('input').val()==null || $('.objetivoEselect').eq(0).find('input').val()==undefined){
          necesarios=necesarios  + '<br><b>Objetivos Especificos</b>'
          $('.newObjetivoE1').css('border-color', 'red');
        }*/
      }
      if (necesarios != "") {
        app.alert.show("requeridos_reunion_llamada", {
            level: "error",
            messages: "Hace falta completar la siguiente información para la <b>Reunión/Llamada:</b>" + necesarios,
            autoClose: false
        });
        errors['reunion_llamada'] = errors['reunion_llamada'] || {};
        errors['reunion_llamada'].required = true;
      }
      callback(null,fields,errors);
    },

    ////Función para cambiar el formato de la hora y poder cambiar
    validaTiempo:function(time){
        if(time!="" && time!=null && time!=undefined){
            time = time.replace("pm", " PM");
            time = time.replace("am", " AM");
            var hours = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);
            var AMPM = time.match(/\s(.*)$/)[1];
            if(AMPM == "PM" && hours<12) hours = hours+12;
            if(AMPM == "AM" && hours==12) hours = hours-12;
            var sHours = hours.toString();
            var sMinutes = minutes.toString();
            if(hours<10) sHours = "0" + sHours;
            if(minutes<10) sMinutes = "0" + sMinutes;
            return sHours + ":" + sMinutes;
        }
    },
    open_survey_minuta: function(){

        //Valida que reunión haya sido generada por usuario Agente Teléfonico o Coordinador
        var idUser = this.context.parent.attributes.model.attributes.created_by;
        var url = app.api.buildURL("Users/"+idUser, '', {}, {});

        //Valida resultado vacío
        if (this.model.get('resultado_c') == "") {
            App.alert.show("survey_no_result", {
                level: "info",
                messages: "Favor de indicar resultado de la cita previo a contestar encuesta",
                autoClose: true,
            });
            return;
        }

        //Valida resultado diferente a El cliente no estuvo presente, cita cancelada
        if (this.model.get('resultado_c') == "1") {
            App.alert.show("survey_no_result", {
                level: "info",
                messages: "No se puede contestar encuesta para resutado <b>El cliente no estuvo presente,Cita cancelada</b>",
                autoClose: true,
            });
            return;
        }

        app.api.call("read", url, null, {
            success: _.bind(function (data) {
              /*
              Condiciones
                puesto
                  27- Agente teléfonico
                  31 - Coordinador CP
                o Usuario OmarVenegas: eeae5860-bb05-4ae5-3579-56ddd8a85c31
              */
              if (data.puestousuario_c == '27' || data.puestousuario_c == '31' || data.id == 'eeae5860-bb05-4ae5-3579-56ddd8a85c31') {
                  //Genera apertura de encuesta
                  var sugarHost = window.location.origin+window.location.pathname + "survey_submission.php?q=";
                  var url = "";
                  if (self.urlEncuesta == undefined || self.urlEncuesta == null) {
                      //Genera petición para obtener url de encuesta
                      var args = {
                          'idMeeting': self.model.attributes.minut_minutas_meetingsmeetings_idb,
                          'idUser': App.user.id,
                          'nameUser': App.user.attributes.full_name
                      };
                      var encuestaURL = app.api.buildURL("createSubmission", '', {}, {});
                      app.api.call("create", encuestaURL, {data:args}, {
                          success: _.bind(function (data) {
                              if (data) {
                                  self.urlEncuesta = data;
                                  url = sugarHost + self.urlEncuesta;
                                  window.open(url, 'Noticias', 'width=450, height=500, top=85, left=50', true);
                              }
                          }, this)
                      });

                  }else{
                      url = sugarHost + self.urlEncuesta;
                      window.open(url, 'Noticias', 'width=450, height=500, top=85, left=50', true);
                  }
              }else {
                  App.alert.show("survey_no_access", {
                      level: "info",
                      messages: "No cuenta con permiso para contestar encuesta",
                      autoClose: true,
                  });
                  return;
              }
            }, this)
        });
    },

})
