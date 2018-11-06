({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);
        this.on('render', this.disableparentsfields, this);
        this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicial, this));
        this.model.addValidationTask('ValidaObjetivos',_.bind(this.ValidaObjetivos,this));
        this.on('render', this.disablestatus, this);
    },

    _render: function () {
        this._super("_render");
        $('[data-name=reunion_objetivos]').find('.record-label').addClass('hide');

        //Ocultar panel con campos de control de check in
        $('[data-panelname="LBL_RECORDVIEW_PANEL2"]').addClass('hide');

        /*Oculta el campo de resultado de la llamada cuando la está se encuentra en planificada
         *Victor Martinez López 23-08-2018
         * */
        if(this.model.get('status')=='Planned'){
            this.$('div[data-name=resultado_c]').hide();
        }
        //Deshabilita campo "asignado a"
        $('div[data-name=assigned_user_name]').css("pointer-events", "none");
    },

    /*Valida que por lo menos exita un objetivo específico*/
    ValidaObjetivos:function(fields, errors, callback){
        if ($('.objetivoSelect').length<=0){
            errors[$(".objetivoSelect")] = errors['objetivos_especificos'] || {};
            errors[$("objetivos_especificos")].required = true;
            $('.newCampo1').css('border-color', 'red');
            app.alert.show("Objetivo vacio",{
                    level: "error",
                    title: "Es necesario tener por lo menos un objetivo espec\u00EDfico",
                    autoClose: false
                });
        }
        callback(null, fields, errors);
    },

    /* @F. Javier G. Solar
     * Valida que la Fecha Inicial no sea menor que la actual
     * 14/08/2018
     */
    validaFechaInicial: function (fields, errors, callback) {

        // FECHA INICIO
        var dateInicio = new Date(this.model.get("date_start"));
        var d = dateInicio.getDate();
        var m = dateInicio.getMonth() + 1;
        var y = dateInicio.getFullYear();
        var fechaCompleta = [m, d, y].join('/');
        // var dateFormat = dateInicio.toLocaleDateString();
        var fechaInicio = Date.parse(fechaCompleta);


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
                title: "No puedes crear una Reuni&oacuten con fecha menor al d&Iacutea de hoy",
                autoClose: false
            });

            app.error.errorName2Keys['custom_message1'] = 'La fecha no puede ser menor a la actual';
            errors['date_start'] = errors['date_start'] || {};
            errors['date_start'].custom_message1 = true;
        }
        callback(null, fields, errors);
    },


    /* @Alvador Lopez Y Adrian Arauz
    Oculta los campos relacionados
    */
    disableparentsfields: function () {
        if (this.createMode) {//Evalua si es la vista de creacion
            if (this.model.get('parent_id') != undefined) {
                this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;')
            }
        }
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
})