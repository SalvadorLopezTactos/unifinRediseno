/**
 * Created by Levementum on 9/21/2016.
 * User: jgarcia@levementum.com
 */

({

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.model.on('change:contactos_duracion', this.calculaTiempo, this);
        this.model.on('change:citas_brujula', this.calculaTiempo, this);
        App.events.on('data:sync:success',this.checkRole, this);
        this.model.addValidationTask('validar_fecha', _.bind(this.validarFecha, this));
        this.model.addValidationTask('sync_citas_alert', _.bind(this.citasSyncAlert, this));
        this.model.addValidationTask('citas_campos_requeridos', _.bind(this.citasCamposRequeridos, this));
        this.model.addValidationTask('campos_numero', _.bind(this.camposNumericos, this));
    },

    _render: function() {
        this._super("_render");
        $('.rowaction[name="save_button"]').html("Enviar");
        $('.porcentaje input[type="text"]').attr("readonly", true);
        $('input[name="tiempo_prospeccion"]').attr("readonly", true);
        this.checkRole();
    },

    checkRole: function (){

        app.api.call("read", app.api.buildURL("UserRoles", null, null, {
        }), null, {
            success: _.bind(function (data) {
                var roleBrujula = false;
                _.each(data, function (key, value) {
                    if (key == "Admin Brujula") {
                        roleBrujula = true;
                    }
                });

                if(roleBrujula == false){
                    $('[data-name="assigned_user_name"]').find("*").prop("disabled", true);
                }

            }, this)
        });
    },

    calculaTiempo: function(){

        var total = 0;
        var citas_brujula = this.model.get("citas_brujula");
        var contactos_duracion = this.model.get("contactos_duracion");

        if(contactos_duracion > 0){
            total = +contactos_duracion;
        }

        _.each(citas_brujula, function(key, value) {

            if(key["nuevo_estatus"] == "1") {
                var minutos = +key["duration_minutes"] + +key["nuevo_traslado"];
                if (minutos > 0) {
                    total += minutos;
                }
            }
        });

        total = total / 60;
        this.model.set("tiempo_prospeccion", total);
    },

    validarFecha: function (fields, errors, callback) {

        app.api.call("read", app.api.buildURL("UserRoles", null, null, {
        }), null, {
            success: _.bind(function (data) {
                var roleBrujula = false;
                _.each(data, function (key, value) {
                    if (key == "Admin Brujula") {
                        roleBrujula = true;
                    }
                });

                this.model.set("extemporaneo",false);
                var currentYear = (new Date).getFullYear();
                var currentMonth = (new Date).getMonth() + 1;
                var currentDay = (new Date).getDate();
                var currentHour = (new Date).getHours();

                var year_report = (new Date(this.model.get("fecha_reporte"))).getFullYear();
                var month_report = (new Date(this.model.get("fecha_reporte"))).getMonth() + 1;
                var day_report = new Date(this.model.get("fecha_reporte")).getUTCDate()

                var weekDay = (new Date).getDay();
                var weekDayReport = (new Date(this.model.get("fecha_reporte"))).getUTCDay();
                var diferencia_dias = this.daysBetween(new Date() , new Date(this.model.get("fecha_reporte")+'T10:20:30Z'));

                //CVV se marca el reporte como extemporaneo
                /*
                    AF: 08/12/17
                    Ajuste límite para determinar extemporaneo, de 10 a 2 am
                */
                if(diferencia_dias == 1){
                    if(currentHour > 2){
                        this.model.set("extemporaneo",true);
                    }
                }else {  //diferencia_dias > 1
                    if (weekDay == 1 && weekDayReport == 5) {
                        if (currentHour > 2) {
                            this.model.set("extemporaneo", true);
                        }
                    }else{
                        this.model.set("extemporaneo", true);
                    }
                }

                /*
                    AF: 02/01/18
                    Ajuste RN extemporaneo
                */
                //Validaciones 2.0 Exptemporaneo
                var slectedDate = new Date(this.model.get("fecha_reporte") + " 02:01:00");      //Día seleccionado
                var limitIDate = new Date(this.model.get("fecha_reporte") + " 00:00:00");       //Límite inferior día : 00:00
                var limitSDate = new Date();    
                limitSDate.setDate(slectedDate.getDate()+1);                                    //Límite superior día +1 : 02:00

                var currentDate = new Date();
                var vacaciones = this.model.get("vacaciones_c");

                //1.- Fecha > Hoy & Vacaciones = false
                if (limitSDate > currentDate && vacaciones == false) {
                    this.model.set("extemporaneo", true);
                }

                //2.- Fecha < Hoy & Vacaciones = true;"
                if (limitIDate < currentDate && vacaciones == true) {
                    this.model.set("extemporaneo", true);
                }

                //3.- Fecha > Hoy & Vacaciones = false
                if (limitSDate > currentDate && vacaciones == true) {
                    this.model.set("extemporaneo", false);
                }

                //4.- Fecha > limitInferior & Fecha < limitSuperior
                if (currentDate >= limitIDate && currentDate < limitSDate) {
                    this.model.set("extemporaneo", false);
                }



                if(roleBrujula == false){
                    /*if(currentYear > year_report){
                        app.alert.show('fecha_brujula', {
                            level: 'error',
                            messages: 'No se permiten años anteriores',
                            autoClose: true
                        });

                        errors['fecha_reporte'] = errors['fecha_reporte'] || {};
                        errors['fecha_reporte'].required = true;
                    }*/
                    //if(currentMonth > month_report){
                        /*if(diferencia_dias > 1) {
                            if (weekDay == 1 && weekDayReport == 5) {
                                if (currentHour > 10) {
                                    this.model.set("extemporaneo", true);
                                }

                                // CVV Se comenta ya que se permite enviar la brujula hasta 15 días despues
                                if (currentHour > 23) {
                                    app.alert.show('fecha_brujula', {
                                        level: 'error',
                                        messages: 'El reporte debio completarse antes de las 11 de la noche',
                                        autoClose: true
                                    });

                                    errors['fecha_reporte'] = errors['fecha_reporte'] || {};
                                    errors['fecha_reporte'].required = true;
                                }

                                callback(null, fields, errors);
                                return;
                            }else{
                                this.model.set("extemporaneo", true);
                            }
                        }

                        if(diferencia_dias == 1){
                            if(currentHour > 10){
                                this.model.set("extemporaneo",true);
                            }

                             // CVV Se comenta ya que se permite enviar la brujula hasta 15 días despues
                            if(currentHour > 23){
                                app.alert.show('fecha_brujula', {
                                    level: 'error',
                                    messages: 'El reporte debio completarse antes de las 11 de la noche',
                                    autoClose: true
                                });

                                errors['fecha_reporte'] = errors['fecha_reporte'] || {};
                                errors['fecha_reporte'].required = true;
                            }
                        }


                        app.alert.show('fecha_brujula', {
                            level: 'error',
                            messages: 'No se permiten meses anteriores',
                            autoClose: true
                        });

                        errors['fecha_reporte'] = errors['fecha_reporte'] || {};
                        errors['fecha_reporte'].required = true;
                        */
                    //}

                    if(year_report >= currentYear){
                        if(month_report >= currentMonth){
                            if(currentDay > day_report){
                                console.log('Dias de diferencia:' + diferencia_dias);
                                if(diferencia_dias > 15){
                                    /*
                                    if(weekDay == 1 && weekDayReport == 5){

                                        if(currentHour > 10){
                                            this.model.set("extemporaneo",true);
                                        }

                                        if(currentHour > 23){
                                            app.alert.show('fecha_brujula', {
                                                level: 'error',
                                                messages: 'El reporte debio completarse antes de las 11 de la noche',
                                                autoClose: true
                                            });

                                            errors['fecha_reporte'] = errors['fecha_reporte'] || {};
                                            errors['fecha_reporte'].required = true;
                                        }

                                        callback(null, fields, errors);
                                        return;
                                    }*/

                                    app.alert.show('fecha_brujula', {
                                        level: 'error',
                                        messages: 'No se pueden registrar brujulas de hace mas de 15 dias',
                                        autoClose: true
                                    });

                                    errors['fecha_reporte'] = errors['fecha_reporte'] || {};
                                    errors['fecha_reporte'].required = true;
                                }
                                /*
                                if(diferencia_dias == 1){
                                    if(currentHour > 10){
                                        this.model.set("extemporaneo",true);
                                    }

                                    if(currentHour > 23){
                                        app.alert.show('fecha_brujula', {
                                            level: 'error',
                                            messages: 'El reporte debio completarse antes de las 11 de la noche',
                                            autoClose: true
                                        });

                                        errors['fecha_reporte'] = errors['fecha_reporte'] || {};
                                        errors['fecha_reporte'].required = true;
                                    }
                                }*/
                            }
                        }
                    }
                }/*else{

                    if(year_report >= currentYear){
                        if(month_report >= currentMonth){
                            if(currentDay > day_report){

                                if(diferencia_dias > 1) {

                                    if (weekDay == 1 && weekDayReport == 5) {

                                        if (currentHour > 10) {
                                            this.model.set("extemporaneo", true);
                                        }else{
                                            this.model.set("extemporaneo", false);
                                        }
                                    }else{
                                        this.model.set("extemporaneo", true);
                                    }
                                }

                                if(diferencia_dias == 1){
                                    if(currentHour > 10){
                                        this.model.set("extemporaneo",true);
                                    }
                                }
                            }
                        }
                    }

                    if(currentMonth > month_report){
                        if(diferencia_dias > 1) {
                            if (weekDay == 1 && weekDayReport == 5) {

                                if (currentHour > 10) {
                                    this.model.set("extemporaneo", true);
                                }else{
                                    this.model.set("extemporaneo", false);
                                }
                            }else{
                                this.model.set("extemporaneo", true);
                            }
                        }

                        if(diferencia_dias == 1){
                            if(currentHour > 10){
                                this.model.set("extemporaneo",true);
                            }
                        }
                    }
                }*/

                callback(null, fields, errors);
            }, this)
        });
    },

    citasSyncAlert: function (fields, errors, callback){

        var citas_originales = self.model.get("citas_originales");
        var citas = self.citas.length;
        if(citas > citas_originales){
            app.alert.show('citas_sync_alert', {
                level: 'warning',
                messages: 'Has indicado más citas de las que están en tu agenda. Por favor ten siempre la agenda actualizada',
            });
        }
        callback(null, fields, errors);
    },

    citasCamposRequeridos: function (fields, errors, callback){

        var citas_brujula = this.model.get("citas_brujula");
        _.each(citas_brujula, function(key, value) {
            _.each(key, function(valor, campo) {

                if(campo != "nuevo_referenciada" && campo != "nuevo_acompanante" && campo != "nuevo_acompanante_id" && campo != "duration_minutes" && campo != "nuevo_traslado" && campo != "hora_cita" && campo != "id" ) {
                    //&& campo != "nuevo_objetivo" && campo != "nuevo_resultado"
                    if(_.isEmpty(valor) || valor ==''){
                        console.log("Campo " + campo + key['id'] + " Valor del campo: " + valor + ".");
                        errors[$("#" + campo + key['id'])] = errors[$("#" + campo + key['id'])] || {};
                        errors[$("#" + campo + key['id'])].required = true;

                        $("#" + campo + key['id']).css('border-color', 'red');
                    }else{
                        console.log("ELSE Campo " + campo + key['id'] + " Valor del campo: " + valor + ".");
                    }
                }

                if(campo == "duration_minutes" || campo == "nuevo_traslado"){

                    if(campo == "nuevo_traslado") {
                        if (+valor < 0 ) {
                            //if (+valor < 0 || !valor) {
                            errors[$("#" + campo + key['id'])] = errors[$("#" + campo + key['id'])] || {};
                            errors[$("#" + campo + key['id'])].required = true;

                            $("#" + campo + key['id']).css('border-color', 'red');
                        }
                    }

                    if(campo == "duration_minutes") {
                        if (+valor <= 0) {
                            errors[$("#" + campo + key['id'])] = errors[$("#" + campo + key['id'])] || {};
                            errors[$("#" + campo + key['id'])].required = true;

                            $("#" + campo + key['id']).css('border-color', 'red');
                        }
                    }
                }

            });
        });

        callback(null, fields, errors);
    },

    camposNumericos: function(fields, errors, callback){
        _.each(self.model.fields, function(key, value) {
            if(key['type'] == 'int'){
                var campo_value = $('input[name=' + value +']').val();
                if(!_.isEmpty(campo_value)) {
                    var esNumero = $.isNumeric(campo_value);

                    if(!esNumero) {
                        errors[value] = errors[value] || {};
                        errors[value].number = true;
                    }
                }
            }
        });

        callback(null, fields, errors);
    },

    daysBetween: function( date1, date2 ) {
        //Get 1 day in milliseconds
        var one_day=1000*60*60*24;

        // Convert both dates to milliseconds
        var date1_ms = date1.getTime();
        var date2_ms = date2.getTime();

        // Calculate the difference in milliseconds
        var difference_ms = date2_ms - date1_ms;

        // Convert back to days and return
        var difference = Math.round(difference_ms/one_day);
        difference = Math.abs(difference);
        return difference;
    },

    _dispose: function() {
        this._super('_dispose', []);
    }
})




