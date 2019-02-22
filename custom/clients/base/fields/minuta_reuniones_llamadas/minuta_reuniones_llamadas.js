/*
Victor Martinez
12-02-2019
Controlador de reuniones-llamadas
*/

({
  nuevoRegistro:null,
  reunLlam:null,
  events:{
    'change .newItem': 'addNewReuLam',
    /*'change .newTime1':'addNewReuLam',
    'change .newTime2':'addNewReuLam',*/
    'click  .addObjetivoE': 'addObjetivoEFunction',
  },
  initialize: function (options) {
    //Inicializa campo custom
    //selfMeetCall=this;

    this._super('initialize', [options]);
    this.loadData(); //Carga de Datos
    this.model.addValidationTask('Guardarobjetivos', _.bind(this.almacenaobjetivosE, this));
    this.model.addValidationTask('validaobjetivosave', _.bind(this.validaobjetivosE, this));
    this.model.addValidationTask('GuardaReunionLlamada', _.bind(this.SaveMeetCall, this));
    this.model.addValidationTask('RequeMeetCall',_.bind(this.RequeMeetCall,this));
    //this.model.addValidationTask('Fechas',_.bind(this.InicioNoMenorActual,this));
    this.model.on('sync', this.loadData, this);
    this.model.on('change', this.reunion_llamada, this);

    //Definicion de variables para objetivos especificos
    this.myobject={};
    this.myobject.records=[];
    //Data eliminada
    this.myDeletedObj={};
    this.myDeletedObj.records=[];
    //Data original
    this.myOriginal={};
    this.myOriginal.records=[];
    this.myIndexDeleted=[];
  },
  //Muestra o oculta el campo dependiendo del resultado
  reunion_llamada:function(){
    if(this.model.get('resultado_c') == 5){
      console.log("se crea reunion");
      $("[data-panelname='LBL_RECORDVIEW_PANEL5']").show();
      $("#Objetivos").show();
      selfRella.nuevoRegistro.tipo_registro="reunion";
    }

    if(this.model.get('resultado_c') == 19){
      console.log("se crea llamada");
      $("[data-panelname='LBL_RECORDVIEW_PANEL5']").show();
      $("#Objetivos").hide();
      selfRella.nuevoRegistro.tipo_registro="llamada";
    }

    if(this.model.get('resultado_c') !=5 && this.model.get('resultado_c')!=19){
      $("[data-panelname='LBL_RECORDVIEW_PANEL5']").hide();
      selfRella.nuevoRegistro.tipo_registro="";
    }
  },

  //Funcion para cambiar el formato de la hora
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

  loadData: function(options){
    
    selfRella=this;
    var link='';
    /*
    if(this.model.get('resultado_c') == 5){
      link='minut_minutas_meetings_2';
    }
    if(this.model.get('resultado_c') == 19){
      link='minut_minutas_calls_1';
    }*/

    //Para la vista de detalle
    if(this.model.get('id') !=undefined && this.model.get('id') !=""){
      var idMinuta=this.model.get('id');
      app.api.call('GET', app.api.buildURL('Meetings?filter[0][minut_minutas_meetings_2minut_minutas_ida][$equals]=' + idMinuta), null, {
        success: function(data){
          selfRella.reunLlam=data;          
          var d = new Date(selfRella.reunLlam.records[0].date_start);
          selfRella.reunLlam.records[0].date_start=d.toLocaleString();
          var d1=new Date(selfRella.reunLlam.records[0].date_end);
          selfRella.reunLlam.records[0].date_end=d1.toLocaleString();
          _.extend(selfRella, selfRella.reunLlam);
          selfRella.render();
        },
        error: function (e) {
          console.log(e);
        }      
      });
    }

    //Vista de creacion
    else if(this.context.parent){
      selfRella.nuevoRegistro=
      {
        "id":"",
        "tipo_registro":"",
        "nombre":"",
        "date_start":"",
        "time_start":"",
        "date_end":"",
        "time_end":"",
        "duracion_hora":"",
        "duracion_minuto":"",
        "cuenta":"",
        "asignado":"",
        "objetivoG":"",
        "objetivoE":"",
        "account_id_c":this.model.get('account_id_c'),
        "tct_relacionado_con_c":this.model.get('tct_relacionado_con_c'),
        "assigned_user_id":this.model.get('assigned_user_id'),
        "assigned_user_name":this.model.get('assigned_user_name')
      };
    }

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
        min_date = {"min_date": yyyy + '-' + mm + '-' + dd};
        _.extend(this, min_date);
  },

  addNewReuLam:function(evt){
    selfRella.nuevoRegistro.nombre=$('.newCampo1A').val();
    selfRella.nuevoRegistro.date_start=$('.newDate').val();
    selfRella.nuevoRegistro.time_start=this.validaTiempo($('.newTime1').val()); 
    selfRella.nuevoRegistro.date_end=$('.newDate2').val();
    selfRella.nuevoRegistro.time_end=this.validaTiempo($('.newTime2').val());   
    //selfRella.nuevoRegistro.objetivoE='';
    selfRella.nuevoRegistro.objetivoG=$('.objetivoG').select2('val');
    diferencia = Math.abs(new Date(selfRella.nuevoRegistro.date_start +' '+selfRella.nuevoRegistro.time_start) - new Date(selfRella.nuevoRegistro.date_end+' '+selfRella.nuevoRegistro.time_end));
    minutosTotales = Math.floor((diferencia/1000)/60);
    horas = (minutosTotales/60>>0);
    minutos = minutosTotales%60;
    selfRella.nuevoRegistro.duracion_hora=horas;
    selfRella.nuevoRegistro.duracion_minuto=minutos;
  },

  SaveMeetCall:function(fields, errors, callback){
    this.model.set('minuta_reuniones_llamadas', selfRella.nuevoRegistro);
    callback(null, fields, errors);
  },

  almacenaobjetivosE:function(fields, errors, callback) {
       myObjetivos={};
       myObjetivos.records=[];

       //Itera myobject
       Object.keys(selfRella.myobject.records).forEach(function(key) {
           myObjetivos.records.push(selfRella.myobject.records[key]);
       });

       //Itera myDeletedObj
       Object.keys(selfRella.myDeletedObj.records).forEach(function(key) {
           myObjetivos.records.push(selfRella.myDeletedObj.records[key]);
       });

       selfRella.nuevoRegistro.objetivoE=myObjetivos;
       // if (this.model.get('reunion_objetivos') == "" || this.model.get('reunion_objetivos') == null || this.model.get('reunion_objetivos').records.length==0) {
       //     errors['reunion_objetivos'] = "Al menos un objetivo es requerido.";
       //     errors['reunion_objetivos'].required = true;
       // }
       callback(null, fields, errors);
   },

   RequeMeetCall:function(fields,errors,callback){
    //Campos necesarios para Reunion
    if(this.model.get('resultado_c')==5){
      var necesarios="";
      if($('.newCampo1A').val()=='' || $('.newCampo1A').val()==null){
        necesarios=necesarios  + '<br><b>Asunto</b><br>'
        $('.newCampo1A').css('border-color', 'red');
        errors[$(".newCampo1A")] = errors['Asunto'] || {};
        errors[$(".newCampo1A")].custom_message1 = true;
      }
    
      if($('.objetivoG').val()=='' || $('.objetivoG').val()==null || $('.objetivoG').val()==undefined){
        necesarios=necesarios  + '<b>Objetivo General</b><br>'
        $('.objetivoG').find('.select2-choice').css('border-color','red');
        errors[$(".objetivoG")] = errors['Objetivo'] || {};
        errors[$(".objetivoG")].custom_message1 = true;
        }

      if($('.newDate').val()=='' || $('.newDate').val()==null || $('.newDate').val()==undefined ){
        necesarios=necesarios + '<b>Fecha inicial</b><br>'
        $('.newDate').css('border-color', 'red');
        errors[$(".newDate")] = errors['Fecha_inicial'] || {};
        errors[$(".newDate")].custom_message2 = true;
      }

      if($('.newTime1').val()=='' || $().val('.newTime1')==null || $().val('.newTime1')==undefined){
        //necesariosC=necesariosC + '<b>Tiempo inicial</b><b>'
        $('.newTime1').css('border-color', 'red');
        errors[$(".newTime1")] = errors['Tiempo_inicial'] || {};
        errors[$(".newTime1")].custom_message2 = true;
      }

      if($('.newDate2').val()=='' || $('.newDate2').val()==null || $('.newDate2').val()==undefined){
        necesarios=necesarios + '<b>Fecha Final</b><br>'
        $('.newDate2').css('border-color', 'red');
        errors[$(".newDate2")] = errors['Fecha_fin'] || {};
        errors[$(".newDate2")].custom_message2 = true;
      }

      if($('.newTime2').val()=='' || $('newTime2').val()==null || $$('newTime2').val()==null){
        //necesariosC=necesariosC + '<b>Tiempo Final</b><b>'
        $('.newTime2').css('border-color', 'red');
        errors[$(".newDate2")] = errors['Fecha_fin'] || {};
        errors[$(".newDate2")].custom_message2 = true;
      }
      
      if($('.newObjetivoE1').val()=='' || $('.newObjetivoE1').val()==null || $('.newObjetivoE1').val()==undefined){
        necesarios=necesarios  + '<b>Objetivos Especificos</b><br>'
        $('.newObjetivoE1').css('border-color', 'red');
          //errors[$(".newObjetivoE1")] = errors['Objetivo'] || {};
          app.alert.show("Objetivo especificos",{
            level: "error",
            title: "Favor de completar la siguiente informacion para Reunion:"+ necesarios,
            autoClose: false
        });        
      }

      if(necesarios!=""){
        $('.newCampo1A').css('border-color', '');
        $('.newDate').css('border-color', '');
        $('.newTime1').css('border-color', '');
        $('.newDate2').css('border-color', '');
        $('.newTime2').css('border-color', '');
        $('.newObjetivoE1').css('border-color', '');
        $('.objetivoG').css('border-color', '');
      }
    }
    //Campos Requeridos para llamada
    if(this.model.get('resultado_c')==19){
      var necesariosC="";
      if($('.newCampo1A').val()=='' || $('.newCampo1A').val()==null ||$('.newCampo1A').val()==undefined){
        necesariosC=necesariosC + '<br><b>Asunto</b><br>'
        $('.newCampo1A').css('border-color', 'red');
        errors[$(".newCampo1A")] = errors['Asunto'] || {};
        errors[$(".newCampo1A")].custom_message2 = true;
      }
      if($('.newDate').val()=='' || $('.newDate').val()==null || $('.newDate').val()==undefined ){
        necesariosC=necesariosC + '<b>Fecha inicial</b><br>'
        $('.newDate').css('border-color', 'red');
        errors[$(".newDate")] = errors['Fecha_inicial'] || {};
        errors[$(".newDate")].custom_message2 = true;
      }
      if($('.newTime1').val()=='' || $().val('.newTime1')==null || $().val('.newTime1')==undefined){
        //necesariosC=necesariosC + '<b>Tiempo inicial</b><b>'
        $('.newTime1').css('border-color', 'red');
        errors[$(".newTime1")] = errors['Tiempo_inicial'] || {};
        errors[$(".newTime1")].custom_message2 = true;
      }
      if($('.newDate2').val()=='' || $('.newDate2').val()==null || $('.newDate2').val()==undefined){
        necesariosC=necesariosC + '<b>Fecha Final</b><br>'
        $('.newDate2').css('border-color', 'red');
        errors[$(".newDate2")] = errors['Fecha_fin'] || {};
        errors[$(".newDate2")].custom_message2 = true;
      }
      if($('.newTime2').val()=='' || $('newTime2').val()==null){
        //necesariosC=necesariosC + '<b>Tiempo Final</b><b>'
        $('.newTime2').css('border-color', 'red');
        app.alert.show("Requeridos llamada",{
            level: "error",
            title: "Favor de completar la siguiente informacion para Llamada:"+ necesariosC,
            autoClose: false
        }); 
      }
      if(necesariosC!=""){
        $('.newCampo1A').css('border-color', '');
        $('.newDate').css('border-color', '');
        $('.newTime1').css('border-color', '');
        $('.newDate2').css('border-color', '');
        $('.newTime2').css('border-color', '');
      }
    }
  callback(null,fields,errors);
  },

   //Adrian Arauz
   //Validacion para que los objetivos añadidos no estén vacíos a la hora de crear la reunion.
   validaobjetivosE: function (fields, errors, callback) {
       var cont=0;
       $('.objetivoEselect').find('.span10').each(function () {

           if ($(this).val()=="") {

               $(this).css('border-color', 'red');
               errors[$(this)] = errors['<b>Favor de no añadir Objetivo(s) vac\u00EDos</b>'] || {};
               errors[$(this)].required = true;
           }

       });
       callback(null, fields, errors);
   },

  _render: function () {
    $("div.record-label[data-name='minuta_reuniones_llamadas']").attr('style', 'display:none;');
    $("[data-panelname='LBL_RECORDVIEW_PANEL5']").hide();
    this._super("_render");
    this.reunion_llamada();
    $('#tp11').timepicker();
    $('#tp12').timepicker();
    //Función para eliminar objetivos especificos
    $('.deleteObjetivoE').click(function(evt) {
      var row = $(this).closest("tr");    // Find the row
      //self.myData.records[row.index()].deleted = 1;
      if (selfRella.myobject.records[row.index()].id) {
        //Agrega a myDeletedObj
        selfRella.myobject.records[row.index()].deleted = 1;
        selfRella.myDeletedObj.records.push(selfRella.myobject.records[row.index()]);
      }
      selfRella.myIndexDeleted.push(row.index());
      selfRella.myobject.records.splice(row.index(),1);
      selfRella.render();
      });
    //Función para actualizar objetivos Especificos
    $('.objetivoEselect').change(function(evt) {
      var row = $(this).closest("tr");    // Find the row
      var text = row.find(".objetivoEselect").context.value;
      selfRella.myobject.records[row.index()].name = text;
      selfRella.render();
     });

    selfRella.objetivoG_list = app.lang.getAppListStrings('objetivo_list');
    $('select.objetivoG').select2();
  },

  /*
       Función para agregar nuevos elementos al objeto
   */
   addObjetivoEFunction: function (evt) {
       if (!evt) return;

       var errorMsg = '';
       var dirErrorCounter = 0;
       var dirError = false;

       if($('.newObjetivoE1').val() == '' || $('.newObjetivoE1').val() == null || $('.newObjetivoE1').val().trim()==''){
           $('.newObjetivoE1').css('border-color', 'red');
           errorMsg = 'Favor de agregar un objetivo.';
           dirError = true; dirErrorCounter++;

           if (dirError) {
               if (dirErrorCounter > 1) errorMsg = ''
               app.alert.show('Error al agregar objetivo', {
                   level: 'error',
                   autoClose: true,
                   messages: errorMsg

               });
               return;
           }
       }else{
     var valor1 = $('.newObjetivoE1')[0].value;
     var item = {
     "name":valor1,"cumplimiento":"", "description":1
     };

     selfRella.myobject.records.push(item);
     selfRella.render();
       }       
   },

  /**
  * When data changes, re-render the field only if it is not on edit (see MAR-1617).
  * @inheritdoc
  */
  bindDataChange: function () {
    this.model.on('change:' + this.name, function () {
      if (this.action !== 'edit') {
        this.render();
      }
    }, this);
  },

})