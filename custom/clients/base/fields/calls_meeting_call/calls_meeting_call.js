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
    },
    initialize: function (options) {

        this._super('initialize', [options]);

        this.loadData(); //Carga de Datos
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
            app.api.call('GET', app.api.buildURL(modulo+'?filter[0][description][$equals]=' + idCall), null, {
                success: function(data){
                    if(data.records.length){
                        selfRella.reunLlam=data;
                        var d = new Date(selfRella.reunLlam.records[0].date_start);
                        selfRella.reunLlam.records[0].date_start=d.toLocaleString();
                        var d1=new Date(selfRella.reunLlam.records[0].date_end);
                        selfRella.reunLlam.records[0].date_end=d1.toLocaleString();
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
        this.model.set('calls_meeting_call', selfRella.nuevoRegistro);
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

        if(this.model.get('tct_resultado_llamada_ddw_c')=="Cita") {

            $('.record-cell[data-type="calls_meeting_call"]').show();
            $("#Objetivos").show();
            selfRella.nuevoRegistro.tipo_registro = "reunion";

            //Condición para establecer campos relacionados al intentar editar campo custom
            if(this.reunLlam !=null){
                if(this.reunLlam.records.length>0){

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
            $("#Objetivos").hide();
            selfRella.nuevoRegistro.tipo_registro="llamada";

            //Condición para establecer campos relacionados al intentar editar campo custom
            if(this.reunLlam !=null){
                if(this.reunLlam.records.length>0){

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