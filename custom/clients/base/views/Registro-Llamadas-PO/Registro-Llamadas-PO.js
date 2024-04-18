/**
 * Created by salvadorlopez salvador.lopez@tactos.com.mx
 */
({

  events: {
    
    'click #btn_STodo': 'seleccionarTodo',
    'click #btnRegistrar': 'registrarLlamada',
    
  },
  initialize: function (options) {
    this._super("initialize", [options]);
    this.getRecordsPO();

    selfRegistroLlamadas = this;
  },

  _render: function () {
    this._super("_render");

    this.$('#resultadoLlamada').select2();

    $('#horaInicio').timepicker();
    $('#horaFin').timepicker();

    selfRegistroLlamadas.min_date = this.setMinDate();
    
  },

  setMinDate: function(){

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

    return yyyy + '-' + mm + '-' + dd;
    
  },

  getRecordsPO: function(){
    contextoRegistroLlamadas = this;
    var idUsuario = App.user.id;
    var filter = "filter[0][estatus_po_c][$equals]=1&filter[1][assigned_user_id][$equals]="+idUsuario+"&order_by=name:ASC&max_num=-1";

     //Recupera líneas existentes
    App.alert.show('loadingPO', {
        level: 'process',
        title: 'Cargando...',
    });

    App.api.call("read", app.api.buildURL("Prospects?"+filter, null, null, {}), null, {
      success: _.bind(function (data) {
          app.alert.dismiss('loadingPO');
          contextoRegistroLlamadas.recordsPO = data.records;
          contextoRegistroLlamadas.resultado_list = app.lang.getAppListStrings('resultado_llamada_masivo_list');
          contextoRegistroLlamadas.userName = App.user.get('full_name');
          contextoRegistroLlamadas.render();
      }, this)
    });

  },

  seleccionarTodo: function(e){
    
    var btnState = $(e.target).attr("btnState");
    if(btnState == "Off"){
        $(e.target).attr("btnState", "On");
        btnState='On';
    }else{
        $(e.target).attr("btnState", "Off");
        btnState='Off';
    }

    $('.selected').each(function (index, value) {
        if(btnState == "On"){
            //$(value).attr("checked", true);
            $(value).prop('checked', true);
        }else{
            //$(value).attr("checked", false);
            $(value).prop('checked', false);
        }
    });

    var seleccionarTodo = [];
    var crossSeleccionados = $("#crossSeleccionados").val();
    if(!_.isEmpty(crossSeleccionados)) {
        seleccionarTodo = JSON.parse(crossSeleccionados);
    }

    if($('.selected').prop("checked")) {
        $(this.cuentas).each(function (index, value) {
            seleccionarTodo.push(value.id);
        });
    }else{
        seleccionarTodo = [];
    }

    this.seleccionados = seleccionarTodo;
    $("#crossSeleccionados").val(JSON.stringify(this.seleccionados));
  },

  registrarLlamada: function(){
    var asunto = $('#asuntoLlamada').val();
    var resultado = $('#resultadoLlamada').select2('val'); 
    var horaInicio = $('#horaInicio').val(); 
    var horaFin = $('#horaFin').val(); 
  
    this.validRequeridos( asunto, resultado, horaInicio, horaFin );

    this.validaFechas( horaInicio, horaFin  );

    this.validaSeleccionados();

    this.procesaCreacionLlamadas();

  },

  validRequeridos: function ( asunto, resultado, horaInicio, horaFin ){

    if( asunto.trim() == "" ){
      App.alert.show('errorRequired', {
        level: 'error',
        title: 'Error',
        messages: "Favor de ingresar Asunto de llamada"
      });

      return;
    }

    if( resultado == "" ){
      App.alert.show('errorRequired', {
        level: 'error',
        title: 'Error',
        messages: "Favor de ingresar Resultado de llamada"
      });

      return;
    }

    if( horaInicio == "" ){
      App.alert.show('errorRequired', {
        level: 'error',
        title: 'Error',
        messages: "Favor de establecer Hora de inicio"
      });

      return;
    }

    if( horaFin == "" ){
      App.alert.show('errorRequired', {
        level: 'error',
        title: 'Error',
        messages: "Favor de establecer Hora de fin"
      });

      return;
    }

  },

  validaFechas: function ( horaInicio, horaFin ){

    this.cleanFields();

    if($('.dateInicio').val() !="" && $('.dateFin').val() != "" && $('.dateInicio').val() != undefined && $('.dateFin').val() != undefined ){
      // FECHA INICIO 
      var dateSplit=$('.dateInicio').val().split('-');
      var d = dateSplit[2];
      var m = dateSplit[1];
      var y = dateSplit[0];
      var fechaCompleta = [m, d, y].join('/');
      // var dateFormat = dateInicio.toLocaleDateString();
      var fechaInicio = Date.parse(fechaCompleta);

      // FECHA FIN
      var dateFinSplit=$('.dateFin').val().split('-');
      var df = dateFinSplit[2];
      var mf = dateFinSplit[1];
      var yf = dateFinSplit[0];
      var fechaFinCompleta = [mf, df, yf].join('/');
      // var dateFormat = dateInicio.toLocaleDateString();
      var fechaFin = Date.parse(fechaFinCompleta);


      // FECHA ACTUAL
      var dateActual = new Date();
      var d1 = dateActual.getDate();
      var m1 = dateActual.getMonth() + 1;
      var y1 = dateActual.getFullYear();
      var dateActualFormat = [m1, d1, y1].join('/');
      var fechaActual = Date.parse(dateActualFormat);


      // // if (fechaInicio < fechaActual) {
      // //     app.alert.show("error_fecha", {
      // //         level: "error",
      // //         title: "Error",
      // //         messages: "No se puede establecer valor con fecha menor al d\u00EDa de hoy",
      // //         autoClose: false
      // //     });

      // //     $('.dateInicio').css('border-color','red');
      // //     $('.dateFin').css('border-color','red');

      // //     return;
      // // }

      //Validar que la fecha inicio se encuentre entre el día de hoy y máximo 5 días atrás
      const currentDate = new Date();
      currentDate.setHours(0, 0, 0, 0);

      const fechaMaxima = new Date();
      fechaMaxima.setDate(fechaMaxima.getDate() - 5);
      fechaMaxima.setHours(0, 0, 0, 0); 

      // Crear un objeto Date para la fecha que deseas comparar
      const dateInicio = new Date($('.dateInicio').val());
      //Se obtiene timeZone para evitar restar 6 horas debido a la zona horariao
      const zonaHorariaOffset = dateInicio.getTimezoneOffset();
      // Sumar la diferencia de tiempo a la fecha para ajustarla a la zona horaria local
      dateInicio.setMinutes(dateInicio.getMinutes() + zonaHorariaOffset);

      // Comprobar si la fecha a comparar está dentro del rango
      if (dateInicio.getTime() >= fechaMaxima.getTime() && dateInicio.getTime() <= currentDate.getTime()) {
          console.log('La fecha está dentro del rango de hoy y hasta 5 días anteriores.');
      } else {
          console.log('La fecha está fuera del rango de hoy y hasta 5 días anteriores.');
          app.alert.show("error_fecha_inicio", {
              level: "error",
              title: "Error",
              messages: "La fecha de inicio debe de cumplir lo siguiente:<br>Máximo puede ser una fecha de 5 días atrás<br>No puede ser una fecha futura",
              autoClose: false
          });

          $('.dateInicio').css('border-color','red');

          return;
      }

    }

    if(horaInicio !="" && horaFin != ""){
        //Fecha inicio
        var fechaInicioCompletaConHora = fechaCompleta + " " + this.convertTo24Format(horaInicio);
        var fechaInicioCompare = Date.parse(new Date(fechaInicioCompletaConHora));
        //Fecha fin
        var fechaFinCompletaConHora=fechaFinCompleta+" "+this.convertTo24Format(horaFin);
        var fechaFinCompare=Date.parse(new Date(fechaFinCompletaConHora));

        if(fechaFinCompare < fechaInicioCompare){

            app.alert.show("error_hora", {
                level: "error",
                title: "Error",
                messages: "La fecha fin no se puede establecer con valor anterior de la fecha inicio",
                autoClose: false
            });

            $('#horaInicio').css('border-color','red');
            $('#horaFin').css('border-color','red');

            return;
        }

        //Validando que fecha y hora fin no sea superior a la fecha y hora actual
        const fechaHoraActual = new Date();

        // Obtener la fecha y hora de finalización
        const dateFin = $('.dateFin').val();

        // Verificar si la hora incluye "am" o "pm"
        if (horaFin.includes('pm')) {
          const [hora, minutos] = horaFin.replace('pm', '').split(':');
          horaFin = `${parseInt(hora, 10) + 12}:${minutos}`;
        } else if (horaFin.includes('am')) {
          horaFin = horaFin.replace('am', '');
        }
        const [hora, minutos] = horaFin.split(':');
        const fechaHoraFin = new Date(dateFin);
        const zonaHorariaFin = fechaHoraFin.getTimezoneOffset();
        // Sumar la diferencia de tiempo a la fecha para ajustarla a la zona horaria local
        fechaHoraFin.setMinutes(fechaHoraFin.getMinutes() + zonaHorariaFin);
        fechaHoraFin.setHours(parseInt(hora, 10));
        fechaHoraFin.setMinutes(parseInt(minutos, 10));

        // Validar si la fecha y hora de finalización es posterior a la fecha y hora actual
        if (fechaHoraFin > fechaHoraActual) {
          app.alert.show("error_fecha_fin", {
                level: "error",
                title: "Error",
                messages: "La fecha fin no puede ser superior a la hora y fecha actual",
                autoClose: false
            });

            $('.dateFin').css('border-color','red');

            return;
        }
    }
  },

  validaSeleccionados: function(){
    
    if( $("input.selected:checked").length == 0 ){

      app.alert.show("Sin_seleccion", {
        level: "error",
        title: "Error",
        messages: "Favor de seleccionar al menos un registro",
        autoClose: false
      });

      return;
        
    }
  },

  procesaCreacionLlamadas: function (){

    this.seleccionados = [];

    var checks = document.querySelectorAll('input[type="checkbox"].selected');

    checks.forEach((checkbox) => {
      // Verificar si el checkbox está marcado (seleccionado)
      if (checkbox.checked) {
          // Obtener el valor del checkbox y agregarlo al arreglo
          selfRegistroLlamadas.seleccionados.push(checkbox.value);
      }
    });
    
    if( this.seleccionados.length > 0 ){

      var asunto=$('#asuntoLlamada').val();
      var date_start=$('.dateInicio').val();
      var time_start=this.validaTiempo($('#horaInicio').val());
      var date_end=$('.dateFin').val();
      var time_end=this.validaTiempo($('#horaFin').val());
      var resultado=$('#resultadoLlamada').select2('val');
      diferencia = Math.abs(new Date(date_start + ' ' + time_start) - new Date( date_end + ' '+ time_end));
      minutosTotales = Math.floor((diferencia/1000)/60);
      horas = (minutosTotales/60>>0);
      minutos = minutosTotales%60;
      var duracion_horas = horas;
      var duracion_minutos = minutos;

      var request = {
        "records": this.seleccionados,
        "asunto": asunto,
        "fecha_inicio": date_start,
        "hora_inicio": time_start,
        "fecha_fin": date_end,
        "hora_fin": time_end,
        "duracion_horas": duracion_horas ,
        "duracion_minutos": duracion_minutos ,
        "resultado": resultado,
      };

      console.log(request);

      app.alert.show('create_calls', {
          level: 'process',
          title: 'Creando registros...'
      });

      $('#processing').show();
      $('#btnRegistrar').attr('disabled',true);
      app.api.call("create", app.api.buildURL("AltaLlamadasMasivas", null, null, request), null, {
        
        success: _.bind(function (data) {
            //console.log(data);
            app.alert.dismiss('create_calls');
            $('#processing').hide();
            $('#btnRegistrar').removeAttr( 'disabled' );

            app.alert.show('success_calls', {
                level: 'success',
                messages: 'Las llamadas se generaron correctamente',
                autoClose: true
            });

            selfRegistroLlamadas.render();
            selfRegistroLlamadas.getRecordsPO();

        }, this),
        error: _.bind(function (error) {
          $('#processing').hide();
          $('#btnRegistrar').removeAttr( 'disabled' );
          app.alert.dismiss('create_calls');

            console.log(error);

            App.alert.show('errorRequired', {
              level: 'error',
              title: 'Error',
              messages: JSON.stringify(error,null,1)
            });
            
        }, this)
      });

    }

  },

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

  cleanFields: function (){
    
    $('.dateInicio').css('border-color','');
    $('.dateFin').css('border-color','');
    
    $('#horaInicio').css('border-color','');
    $('#horaFin').css('border-color','');
  },

  convertTo24Format:function(time){

    var time = time;
    var hours = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM = "";
    if(time.search('pm')!= -1){
        AMPM="pm";
    }
    if(time.search('am')!= -1){
        AMPM="am";
    }
    if(AMPM == "pm" && hours<12) hours = hours+12;
    if(AMPM == "am" && hours==12) hours = hours-12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if(hours<10) sHours = "0" + sHours;
    if(minutes<10) sMinutes = "0" + sMinutes;
    return sHours + ":" + sMinutes;

  },
});
