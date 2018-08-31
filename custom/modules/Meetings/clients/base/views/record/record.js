({
    extendsFrom: 'RecordView',
    fechaInicioTemp: "",

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        this.on('render', this.disableparentsfields, this);
        this.model.on('sync', this.cambioFecha, this);
        this.model.on('sync', this.disablestatus, this);
        this.model.addValidationTask('VaildaFechaMayoraInicial', _.bind(this.validaFechaInicial2, this));
        this.model.addValidationTask('resultadoCitaRequerido',_.bind(this.resultadoCitaRequerido, this));
        this.model.on("change:status",_.bind(this.muestracampoResultado, this));
        //this.model.on("change:ca_importe_enganche_c", _.bind(this.calcularPorcientoRI, this));

        /*@Jesus Carrillo
            Funcion que pinta de color los paneles relacionados
        */
        this.model.on('sync', this.fulminantcolor, this);

        /*
          * Victor Martinez Lopez 24-08-2018
        */
        this.model.addValidationTask('resultadoCitaRequerido',_.bind(this.resultadoCitaRequerido, this));

    },

    _render: function () {
        this._super("_render");
        if (this.model.get('status') == 'Planned') {
            this.$('div[data-name=resultado_c]').hide();
        }
    },

    cambioFecha: function () {
        this.fechaInicioTemp = Date.parse(this.model.get("date_start"));
        console.log("Fechas: " + this.fechaInicioTemp);
    },

    /*Solo será visible el resultado cuando el estado se Realizada o No Realizada
    * Victor Martinez Lopez 23-8-2018
    * */
    muestracampoResultado:function () {
        if(this.model.get('status')=='Held'|| this.model.get('status')=='Not Held'){
            this.$('div[data-name=resultado_c]').show();
        } if (this.model.get('status') == 'Planned') {
            this.$('div[data-name=resultado_c]').hide();
        }
    },
    /*El resultado es requerido solo cuando se resultado es realizada o no realizada
    * Victor Martinez Lopez 24-08-2018
    * */
    resultadoCitaRequerido:function (fields, errors, callback) {
        if(this.model.get('status')=='Held' || this.model.get('status')=='Not Held'){
            app.error.errorName2Keys['requerido_obj'] = 'El resultado de la cita es requerido';
            errors['resultado_c'] = errors['resultado_c'] || {};
            errors['resultado_c'].requerido_obj = true;
            errors['resultado_c'].required = true;
        }
        callback(null, fields, errors);
    },
    /* @F. Javier G. Solar
     * Valida que la Fecha Inicial no sea menor que la actual
     * 14/08/2018
     */

    validaFechaInicial2: function (fields, errors, callback) {

        // FECHA ACTUAL
        var dateActual = new Date();
        var d1 = dateActual.getDate();
        var m1 = dateActual.getMonth() + 1;
        var y1 = dateActual.getFullYear();
        var dateActualFormat = [m1, d1, y1].join('/');
        var fechaActual = Date.parse(dateActualFormat);

        // FECHA INICIO ANTES DE CAMBIAR
        var dateInicioTmp = new Date(this.fechaInicioTemp);
        var d = dateInicioTmp.getDate();
        var m = dateInicioTmp.getMonth() + 1;
        var y = dateInicioTmp.getFullYear();
        var fechaCompletaTmp = [m, d, y].join('/');
        var fechaInicioTmp = Date.parse(fechaCompletaTmp);

        // FECHA INICIO EN CAMPO
        var dateInicio = new Date(this.model.get("date_start"));
        var d = dateInicio.getDate();
        var m = dateInicio.getMonth() + 1;
        var y = dateInicio.getFullYear();
        var fechaCompleta = [m, d, y].join('/');
        var fechaInicioNueva = Date.parse(fechaCompleta);

        if (fechaInicioTmp != fechaInicioNueva) {
            if (fechaInicioTmp < fechaActual) {
                if (fechaInicioNueva >= fechaInicioTmp) {
                    console.log("Guarda por opcion 1");
                }
                else {
                    app.alert.show("Fecha no valida", {
                        level: "error",
                        title: "No puedes guardar una reunion con fecha menor a la que se habia establecido",
                        autoClose: false
                    });

                    app.error.errorName2Keys['custom_message_date_init0'] = 'No puedes guardar una reunion con fecha menor a la que se habia establecido';
                    errors['date_start'] = errors['date_start'] || {};
                    errors['date_start'].custom_message_date_init0 = true;
                }

            //    callback(null, fields, errors);
            }
            if (fechaInicioTmp >= fechaActual) {
                if (fechaInicioNueva >= fechaActual) {
                    console.log("Guarda por opcion 2")
                }
                else {
                    app.alert.show("Fecha no valida", {
                        level: "error",
                        title: "No puedes agendar reuniones con fecha menor al d&Iacutea de hoy",
                        autoClose: false
                    });

                    app.error.errorName2Keys['custom_message_date_init1'] = 'No puedes agendar reuniones con fecha menor al d&Iacutea de hoy';
                    errors['date_start'] = errors['date_start'] || {};
                    errors['date_start'].custom_message_date_init1 = true;
                }

               // callback(null, fields, errors);
            }
        }
        callback(null, fields, errors);

    },
    /* @Salvador Lopez Y Adrian Arauz
    Oculta los campos relacionados
    */
    disableparentsfields: function () {
        this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;')
    },
    /*@Jesus Carrillo
    Deshabilita campo status dependiendo de diferentes criterios
     */
    disablestatus:function () {
        if(this.model.get('id')=='' || Date.parse(this.model.get('date_end'))>Date.now()){
            $('span[data-name=status]').css("pointer-events", "none");
        }else{
            $('span[data-name=status]').css("pointer-events", "auto");
        }
    },

    /*@Jesus Carrillo
        Funcion que pinta de color los paneles relacionados
    */
    fulminantcolor: function () {
        $( '#space' ).remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

    /*El resultado es requerido solo cuando se resultado es realizada o no realizada
    * Victor Martinez Lopez 24-08-2018
    * */
    resultadoCitaRequerido:function (fields, errors, callback) {
      if(this.model.get('status')=='Held' || this.model.get('status')=='Not Held'){
        if (this.model.get('resultado_c')=='') {
          app.error.errorName2Keys['requerido_obj'] = 'El resultado de la cita es requerido';
          errors['resultado_c'] = errors['resultado_c'] || {};
          errors['resultado_c'].requerido_obj = true;
          errors['resultado_c'].required = true;
        }
      }
      callback(null, fields, errors);
    },
})
