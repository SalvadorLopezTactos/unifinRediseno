/*
 @author: Salvador Lopez Balleza salvador.lopez@tactos.com.mx
 @date: 21/06/2019
 */

({
    nuevoRegistro:{},
    reunLlam:null,
    events:{
        'change .newItem': 'addNewReuLam',
        'click  .addObjetivoE': 'addObjetivoEFunction',
        'change #tp11': 'setOptionsDateEnd'
    },
    initialize: function (options) {

        this._super('initialize', [options]);

        this.loadData(); //Carga de Datos
        this.model.addValidationTask('validaRequiredFields', _.bind(this.validaRequiredFields, this));
        this.model.addValidationTask('validaFechaInicialCall', _.bind(this.validaFechaInicialCall, this));
        
        this.model.addValidationTask('Guardarobjetivos', _.bind(this.almacenaobjetivosE, this));
        this.model.addValidationTask('validaobjetivosave', _.bind(this.validaobjetivosE, this));
        this.model.addValidationTask('GuardaReunionLlamada', _.bind(this.SaveMeetCall, this));
        //this.model.addValidationTask('RequeMeetCall',_.bind(this.RequeMeetCall,this));
        //this.model.addValidationTask('Fechas',_.bind(this.InicioNoMenorActual,this));
        this.model.on('sync', this.loadData, this);
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

        //this.model.on('change:tct_resultado_llamada_ddw_c', this.showHideMeetingCall, this);
        this.model.on('change', this.showHideMeetingCall, this);

    },

    loadData: function (options) {

        selfRella=this;
        modulo='';

        if(this.model.get('tct_resultado_llamada_ddw_c') == "Cita"){
            modulo='Meetings';
        }
        if(this.model.get('tct_resultado_llamada_ddw_c') == "Nueva_llamada"){
            modulo='Calls';
        }

        //Para la vista de detalle
        if(this.model.get('id') !=undefined && this.model.get('id') !="" && (this.model.get('tct_resultado_llamada_ddw_c') =="Cita" || this.model.get('tct_resultado_llamada_ddw_c')=="Nueva_llamada")){
            var idCall=this.model.get('id');
            app.api.call('GET', app.api.buildURL(modulo+'?filter[0][tct_parent_call_id_txf_c][$equals]=' + idCall), null, {
                success: function(data){
                    if(data.records.length){
                        selfRella.reunLlam=data;
                        var d = new Date(selfRella.reunLlam.records[0].date_start);
                        selfRella.reunLlam.records[0].date_start=d.toLocaleString();
                        var d1=new Date(selfRella.reunLlam.records[0].date_end);
                        selfRella.reunLlam.records[0].date_end=d1.toLocaleString();

                        selfRella.reunLlam.records[0].str_link=modulo+'/'+selfRella.reunLlam.records[0].id;
                        _.extend(selfRella, selfRella.reunLlam);
                        if(modulo=='Calls'){
                            selfRella.render();
                        }

                        //Obtener objetivos relacionados
                        if(modulo=='Meetings'){
                            app.api.call('GET', app.api.buildURL('Meetings/' + data.records[0].id + '/link/meetings_minut_objetivos_1?order_by=date_entered:asc'), null, {
                                success: function (data) {
                                    //Reiniciando arreglos de registros eliminados
                                    selfRella.myDeletedObj={};
                                    selfRella.myDeletedObj.records=[];
                                    selfRella.myIndexDeleted=[];

                                    selfRella.myobject = data;
                                    selfRella.myOriginal = data;
                                    _.extend(this, selfRella.myobject);
                                    _.extend(this, selfRella.myOriginal);
                                    selfRella.render();
                                },
                                error: function (e) {
                                    throw e;
                                }
                            });
                        }
                    }

                },
                error: function (e) {
                    //console.log(e);
                }
            });
        }

        //Vista de creacion
        else if(this.context.get('create')){
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
                    "account_id_c":this.model.get('parent_id'),
                    "account_name":this.model.get('parent_name'),
                    "assigned_user_id":this.model.get('assigned_user_id'),
                    "assigned_user_name":this.model.get('assigned_user_name')
                };
        }
        else{ //Entra cuando es vista de detalle y aún no se establece el resultado

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
                    "account_id_c":this.model.get('parent_id'),
                    "account_name":this.model.get('parent_name'),
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

    _render: function () {

        this._super("_render");

        this.showHideMeetingCall();
        var d=new Date();
        var horas=d.getHours();
        var minutos=d.getMinutes();
        var hora_actual=horas+":"+minutos;
        //Redondear minutos
        var current_hour_round=this.roundMinutes(hora_actual);
        hora_actual=this.tConvert(current_hour_round);

        $('#tp11').timepicker({
                'minTime': hora_actual,
                'maxTime': '11:30pm',
            });
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

        //Condición para que valores de vista de detalle persistan en vista de edición
        if (this.tplName === 'edit') {
            if(this.reunLlam != null){

                //Name
                $('.newCampo1A').val(this.reunLlam.records[0].name);
                //Fecha inicio
                var fecha_formatear=this.reunLlam.records[0].date_start.split(" ")[0].split("/");
                var mes_formatear=fecha_formatear[1];
                if(mes_formatear<10){
                    mes_formatear="0"+mes_formatear;
                }

                $(".newDate").val(fecha_formatear[2]+"-"+mes_formatear+"-"+fecha_formatear[0]);
                //Hora inicio
                var hora_formatear=this.reunLlam.records[0].date_start.split(" ")[1];
                $(".newTime1").val(this.tConvert(hora_formatear));

                //Fecha fin
                var fecha_formatear_fin=this.reunLlam.records[0].date_end.split(" ")[0].split("/");
                var mes_formatear_fin=fecha_formatear_fin[1];
                if(mes_formatear_fin<10){
                    mes_formatear_fin="0"+mes_formatear_fin;
                }

                $(".newDate2").val(fecha_formatear_fin[2]+"-"+mes_formatear_fin+"-"+fecha_formatear_fin[0]);
                //Hora fin
                var hora_formatear_fin=this.reunLlam.records[0].date_end.split(" ")[1];
                $(".newTime2").val(this.tConvert(hora_formatear_fin));

                //Objetivo General
                $('select.objetivoG').select2('val',this.reunLlam.records[0].objetivo_c);

            }
        }


    },

    tConvert:function (time) {
        // Check correct time format and split into components
        time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

        if (time.length > 1) { // If time format correct
            time = time.slice (1);  // Remove full string match value
            time[5] = +time[0] < 12 ? 'am' : 'pm'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join (''); // return adjusted time or original string
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

    SaveMeetCall:function(fields, errors, callback){

        /*Todo*/
        //Establecerlo de nuevo solo si es modo edición y ya se tiene un id
        selfRella.nuevoRegistro.nombre=$('.newCampo1A').val();
        selfRella.nuevoRegistro.date_start=$('.newDate').val();
        selfRella.nuevoRegistro.time_start=this.validaTiempo($('.newTime1').val());
        selfRella.nuevoRegistro.date_end=$('.newDate2').val();
        selfRella.nuevoRegistro.time_end=this.validaTiempo($('.newTime2').val());
        selfRella.nuevoRegistro.objetivoG=$('.objetivoG').select2('val');

        diferencia = Math.abs(new Date(selfRella.nuevoRegistro.date_start +' '+selfRella.nuevoRegistro.time_start) - new Date(selfRella.nuevoRegistro.date_end+' '+selfRella.nuevoRegistro.time_end));
        minutosTotales = Math.floor((diferencia/1000)/60);
        horas = (minutosTotales/60>>0);
        minutos = minutosTotales%60;
        selfRella.nuevoRegistro.duracion_hora=horas;
        selfRella.nuevoRegistro.duracion_minuto=minutos;

        this.model.set('calls_meeting_call', selfRella.nuevoRegistro);
        callback(null, fields, errors);
    },

    validaRequiredFields:function(fields, errors, callback){
        var bandera=0;
        var msjError="Favor de completar la siguiente informaci\u00F3n:<br>";
        //Aplicar validaciones solo si el campo custom es visible
        if($(".record-cell[data-type='calls_meeting_call']").is(':visible')){

            $('.newCampo1A').css('border-color','');
            $('.select2-container.objetivoG').css('border', '');
            $('.newDate').css('border-color','');
            $('.newTime1').css('border-color','');
            $('.newDate2').css('border-color','');
            $('.newTime2').css('border-color','');
            $('.newObjetivoE1').css('border-color', '');

            if($('.newCampo1A').val()==""){
                $('.newCampo1A').css('border-color','red');
                msjError+="<b>Asunto</b><br>";
                bandera+=1;

            }

            if($('#Objetivos').is(':visible')){

                    if($('select.objetivoG').val()==""){
                    $('.select2-container.objetivoG').css('border', '1px solid red');
                    msjError+="<b>Objetivo General</b><br>";
                    bandera+=1;
                }

            }
            
            if($('.newDate').val()==""){
                $('.newDate').css('border-color','red');
                msjError+="<b>Fecha inicio</b><br>";
                bandera+=1;

            }

            if($('.newTime1').val()==""){
                $('.newTime1').css('border-color','red');
                msjError+="<b>Hora inicio</b><br>";
                bandera+=1;
                
            }

            if($('.newDate2').val()==""){
                $('.newDate2').css('border-color','red');
                msjError+="<b>Fecha fin</b><br>";
                bandera+=1;

            }

            if($('.newTime2').val()==""){
                $('.newTime2').css('border-color','red');
                msjError+="<b>Hora fin</b><br>"
                bandera+=1;
                
            }

            if(this.myobject.records.length==0 && this.model.get('tct_resultado_llamada_ddw_c')=="Cita"){
                $('.newObjetivoE1').css('border-color', 'red');
                msjError+="<b>Objetivo espec\u00EDfico</b><br>"
                bandera+=1;
            }

            if(bandera>0){

                var alertOptions = {title: msjError, level: "error"};
                app.alert.show('validation', alertOptions);

                errors['calls_meeting_call_'] = errors['calls_meeting_call_'] || {};
                errors['calls_meeting_call_'].required = true;
            }

        }
        
        callback(null, fields, errors);

    },

    validaFechaInicialCall: function (fields, errors, callback) {

        var module='';
        if(this.model.get('tct_resultado_llamada_ddw_c')=="Cita"){
            module="Reuni\u00F3n";
        }
        if(this.model.get('tct_resultado_llamada_ddw_c')=="Nueva_llamada"){
            module="Llamada";
        }


        if($('.newDate').val()!="" && $('.newDate2').val()!=""){

            // FECHA INICIO
            var dateSplit=$('.newDate').val().split('-');
            var d = dateSplit[2];
            var m = dateSplit[1];
            var y = dateSplit[0];
            var fechaCompleta = [m, d, y].join('/');
            // var dateFormat = dateInicio.toLocaleDateString();
            var fechaInicio = Date.parse(fechaCompleta);

            // FECHA FIN
            var dateFinSplit=$('.newDate2').val().split('-');
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


            if (fechaInicio < fechaActual) {
                app.alert.show("Fecha no valida", {
                    level: "error",
                    title: "No puedes crear una "+ module +" relacionada con fecha menor al d\u00EDa de hoy",
                    autoClose: false
                });

                $('.newDate').css('border-color','red');
                $('.newTime1').css('border-color','red');

                errors['calls_meeting_call_'] = errors['calls_meeting_call_'] || {};
                errors['calls_meeting_call_'].custom_message1 = true;
            }

        }

        //Comparar fecha inicio vs fecha fin
        if($(".newTime1").val()!="" && $(".newTime2").val()){
            //Fecha inicio
            var fechaInicioCompletaConHora=fechaCompleta+" "+this.convertTo24Format($(".newTime1").val());
            var fechaInicioCompare=Date.parse(new Date(fechaInicioCompletaConHora));
            //Fecha fin
            var fechaFinCompletaConHora=fechaFinCompleta+" "+this.convertTo24Format($(".newTime2").val());
            var fechaFinCompare=Date.parse(new Date(fechaFinCompletaConHora));

            if(fechaFinCompare < fechaInicioCompare){

                app.alert.show("Fecha no valida", {
                    level: "error",
                    title: "La fecha fin no puede ser antes de la fecha inicio",
                    autoClose: false
                });

                $('.newDate2').css('border-color','red');
                $('.newTime2').css('border-color','red');

                errors['calls_meeting_call_'] = errors['calls_meeting_call_'] || {};
                errors['calls_meeting_call_'].custom_message1 = true;

            }

        }


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

    showHideMeetingCall:function(){

        if(this.collection != undefined){
            //Si cambian el resultado de la llamada, hay que limpiar los campos
            if(this.collection.models[0]._previousAttributes["tct_resultado_llamada_ddw_c"] != this.model.get('tct_resultado_llamada_ddw_c')){

                //Asunto
                $('.newCampo1A').val("");
                //Fecha inicio
                $('.newDate').val("");
                //Hora inicio
                $('.newTime1').val("");
                //Fecha fin
                $('.newDate2').val("");
                //Hora fina
                $('.newTime2').val("");
                //Objetivo General
                $('select.objetivoG').select2('val','');
            }
        }

        if(this.model.get('tct_resultado_llamada_ddw_c')=="Cita") {

            $('.record-cell[data-type="calls_meeting_call"]').show();
            //oculta etiqueta de campo
            $('.record-label[data-name="calls_meeting_call"]').addClass('hide');
            $("#Objetivos").show();
            selfRella.nuevoRegistro.tipo_registro = "reunion";

            //Condición para establecer campos relacionados al intentar editar campo custom
            if(this.reunLlam !=null){
                if(this.reunLlam.records.length>0){
                    selfRella.nuevoRegistro.id = this.reunLlam.records[0].id;
                    selfRella.nuevoRegistro.account_id_c = this.reunLlam.records[0].parent_id;
                    selfRella.nuevoRegistro.account_name = this.reunLlam.records[0].parent_name;

                    selfRella.nuevoRegistro.assigned_user_id = this.reunLlam.records[0].assigned_user_id;
                    selfRella.nuevoRegistro.assigned_user_name = this.reunLlam.records[0].assigned_user_name;

                    //selfRella.myobject.records=[{"name":"HOLA"},{"name":"adios"}];
                }

            }

        }

        else if(this.model.get('tct_resultado_llamada_ddw_c')=="Nueva_llamada"){

            $('.record-cell[data-type="calls_meeting_call"]').show();
            //oculta etiqueta de campo
            $('.record-label[data-name="calls_meeting_call"]').addClass('hide');
            $("#Objetivos").hide();
            selfRella.nuevoRegistro.tipo_registro="llamada";

            //Condición para establecer campos relacionados al intentar editar campo custom
            if(this.reunLlam !=null){
                if(this.reunLlam.records.length>0){
                    selfRella.nuevoRegistro.id = this.reunLlam.records[0].id;

                    selfRella.nuevoRegistro.account_id_c = this.reunLlam.records[0].parent_id;
                    selfRella.nuevoRegistro.account_name = this.reunLlam.records[0].parent_name;

                    selfRella.nuevoRegistro.assigned_user_id = this.reunLlam.records[0].assigned_user_id;
                    selfRella.nuevoRegistro.assigned_user_name = this.reunLlam.records[0].assigned_user_name;

                    //selfRella.myobject.records=[{"name":"HOLA"},{"name":"adios"}];
                }

            }

        }else{
            $('.record-cell[data-type="calls_meeting_call"]').hide();
            selfRella.nuevoRegistro.tipo_registro="";

        }

    },

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

    setOptionsDateEnd:function(evt){

        var hora_select=$(evt.currentTarget).val();
        //Establece opciones de hora fin dependiendo de la hora de inicio seleccionada
        $('#tp12').timepicker({
                'minTime': hora_select,
                'maxTime': '11:30pm',
            });

    },

    /*
    * Función para redondear los minutos de la hora actual y poder establecer la hora por default
    * en el campo de hora inicio
    */
    roundMinutes:function(t) {
        function format(v) { return v < 10 ? '0' + v: v; }

        var m = t.split(':').reduce(function (h, m) { return h * 60 + +m; });
    
        m = Math.ceil(m / 15) * 15;
        return [Math.floor(m / 60), m % 60].map(format).join(':');
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