
({

    extendsFrom: 'CreateView',

    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);
        this.on('render', this.disableparentsfields, this);
        this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicial, this));
        this.model.addValidationTask('ValidaObjetivos',_.bind(this.ValidaObjetivos,this));
        this.model.addValidationTask('Campos_necesarios', _.bind(this.Campos_necesarios, this));
        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));
        this.model.addValidationTask('valida_usuarios',_.bind(this.valida_usuarios, this));
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

    /*Valida que por lo menos exita un objetivo específico a su vez expande el panel*/
    ValidaObjetivos:function(fields, errors, callback){
        if (this.$('.objetivoSelect').length<=0){
            errors[$(".objetivoSelect")] = errors['objetivos_especificos'] || {};
            errors[$("objetivos_especificos")].required = true;
            //Agrega borde
            this.$('.newCampo1').css('border-color', 'red');
            //Expande panel
            this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(0).removeClass('panel-inactive');
            this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(0).addClass('panel-active');
            this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(1).attr("style","display:block");
        }
        callback(null, fields, errors);
    },

    Campos_necesarios:function(fields, errors, callback){
        var necesario="";
        if(this.model.get('name')=="" || this.model.get('name')==null){
            necesario= necesario + '<b>Asunto</b><br>';
            errors['name'] = errors['name'] || {};
            errors['name'].custom_message1 = true;
        }
        if(this.model.get('objetivo_c')=="" || this.model.get('objetivo_c')==null){
            necesario=necesario + '<b>Objetivo General</b><br>';
            errors['objetivo_c'] = errors['objetivo_c'] || {};
            errors['objetivo_c'].custom_message1 = true;
        }
        if(this.$('.objetivoSelect').length<=0){
            necesario=necesario + '<b>Objetivos Espec\u00EDficos</b><br>';
            app.alert.show("Guardar Reunion", {
                level: "error",
                title: '<p style="font-weight: normal;">Por lo menos debe agregar un <b>Objetivo Específico</b> para la <b>Reuni\u00F3n</b></p>',
                autoClose: false
            });
        }
        if (necesario != ""){
            /*console.log("Confirma necesarios");
            app.alert.show("Guardar Reunion", {
                level: "error",
                title: '<p style="font-weight: normal;">Faltan los siguientes datos para poder guardar la Reuni\u00F3n:</p>' + necesario,
                autoClose: false
            });*/
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

    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "Meetings") + '</b><br>';
                    }
          		  }
       	    }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Reunión:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    valida_usuarios: function(fields, errors, callback) {
        //Recuperar variables
        var invitadosObject = this.model.get('invitees')._byId;
        var invitados = [];
        var count = 0;
        Object.keys(invitadosObject).forEach(function(key) {
           invitados[count] = invitadosObject[key].id;
           count++;
        });
        //Generar petición para valdiación
        app.api.call('GET', app.api.buildURL('validaUsuarios/' + invitados), null, {
            success: _.bind(function(data) {
               if(data==true){
                  app.alert.show("Usuarios", {
                    level: "error",
                    messages: "No se puede guardar la Reunión ya que los invitados tienen algún puesto de:<br>" + campos,
                    autoClose: false
                  });
                  errors['usuariocp'] = errors['usuariocp'] || {};
                  errors['usuariocp'].required = true;
               }
               callback(null, fields, errors);
            }, this)
        });
    },
})
