({
    extendsFrom: 'RecordView',

    fechaInicioTemp: "",

    estadoOriginal: "",
    parentIdOriginal: "",



    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.events['click a[name=parent_name]'] = 'handleEdit';
        //this.model.addValidationTask('ValidaObjetivos',_.bind(this.ValidaObjetivos,this));

        /**
          AF: 2018-12-04
          Validación para identificar si una reunión es marcada como realizada y se agrega cuenta
        **/
        this.model.addValidationTask('ValidaRealizadaSinCuenta',_.bind(this.validaRealizada,this));

        this.on('render', this.disableparentsfields, this);
        this.on('render', this.noEditStatus,this);
        this.model.on('sync', this.cambioFecha, this);
        this.model.on('sync', this.disablestatus, this);
        this.model.on('sync', this.disableFieldsTime,this);
        this.model.on('sync', this.validaprospeccion,this);
        this.model.addValidationTask('VaildaFechaMayoraInicial', _.bind(this.validaFechaInicial2, this));
        this.model.on("change:status",_.bind(this.muestracampoResultado, this));
        this.model.on("change:status",_.bind(this.hidecheck, this));
        this.model.on("change:parent_name",_.bind(this.showCheckin, this));
        //this.model.on('render',this.hidecheck,this);
        //this.model.on("change:ca_importe_enganche_c", _.bind(this.calcularPorcientoRI, this));
        //this.model.addValidationTask('ValidaCuentaNoVacia',_.bind(this.ValidaCuentaNoVacia, this));
        //Al dar click mandara a la vista de creacion correspondiente a la minuta
        this.context.on('button:new_minuta_b:click', this.CreaMinuta,this);

        this.context.on('button:getlocation:click', this.GetLocation, this);

        this.model.on('sync', this.ValidaCuentNoVacia,this); //Validacion para creación de la minuta
        this.model.on('sync', this.showCheckin, this);
        /*@Jesus Carrillo
            Funcion que pinta de color los paneles relacionados
        */
        this.model.on('sync', this.fulminantcolor, this);
        /*
          * Victor Martinez Lopez 24-08-2018
        */
        this.model.addValidationTask('resultadoCitaRequerido',_.bind(this.resultadoCitaRequerido, this));
        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));
        this.model.addValidationTask('valida_usuarios_inactivos',_.bind(this.valida_usuarios_inactivos, this));
        this.model.addValidationTask('valida_usuarios_vetados',_.bind(this.valida_usuarios_vetados, this));
        this.model.on('sync',this.enableparentname,this);
    },

    _render: function (options) {
        this._super("_render");
        reunion = this;
        $('[data-name=reunion_objetivos]').find('.record-label').addClass('hide');

        //Ocultar panel con campos de control de check in
        $('[data-panelname="LBL_RECORDVIEW_PANEL2"]').addClass('hide');

        if (this.model.get('status') == 'Planned') {
            this.$('div[data-name=resultado_c]').hide();
        }
        //Deshabilita campo "asignado a"
        $('div[data-name=assigned_user_name]').css("pointer-events", "none");
        this.enableparentname();

        //Evento para validar acciones
        $('a.btn.dropdown-toggle.btn-primary').on('click', function(e){
            reunion.hidecheck();
        });
    },

    /**
     * @author Salvador Lopez
     * Se habilita handleEdit, editClicked y cancelClicked para dejar habilitado el campo parent_name y solo se bloquea al
     * dar click en el campo e intentar editar
     * */
    handleEdit: function(e, cell) {
        var target,
            cellData,
            field;

        if (e) { // If result of click event, extract target and cell.
            target = this.$(e.target);
            cell = target.parents('.record-cell');
        }

        if(e.currentTarget.dataset['name']=='parent_name'){

            this.inlineEditMode = false;

        }else{

            cellData = cell.data();
            field = this.getField(cellData.name);

            // Set Editing mode to on.
            this.inlineEditMode = true;

            this.setButtonStates(this.STATE.EDIT);

            this.toggleField(field);

            if (cell.closest('.headerpane').length > 0) {
                this.toggleViewButtons(true);
                this.adjustHeaderpaneFields();
            }

        }


    },

    hasUnsavedChanges: function(){
        this._super('hasUnsavedChanges');

        if (this.action==='detail'){
            return false;
        }
        else{
            return true;
            }
    },
    CreaMinuta:function(){

        /*if($('.objetivoSelect').length<=0){
            app.alert.show("Objetivo vacio",{
                    level: "error",
                    title: "Es necesario tener por lo menos un <b>Objetivo espec\u00EDfico</b> para generar la minuta",
                    autoClose: false
                });
        }else{*/

        var model=App.data.createBean('minut_Minutas');
        // FECHA ACTUAL
        var startDate = new Date(this.model.get('date_end'));
        var startMonth = startDate.getMonth() + 1;
        var startDay = startDate.getDate();
        var startYear = startDate.getFullYear();
        var startDateText = startDay + "/" + startMonth + "/" + startYear;
        var objetivo=App.lang.getAppListStrings('objetivo_list');
        model.set('account_id_c', this.model.get('parent_id'));
        model.set('tct_relacionado_con_c', this.model.get('parent_name'));
        model.set('objetivo_c', this.model.get('objetivo_c'));
        model.set('minut_minutas_meetingsmeetings_idb',this.model.get('id'));
        model.set('minut_minutas_meetings_name',this.model.get('name'));
        model.set('name',"Minuta"+" "+startDateText+" "+objetivo[this.model.get('objetivo_c')]);
        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'minut_Minutas',
                    model: model
                },
            },
            function(){
            //alert('Drawer Cerrado');
                location.reload();

            }
        );
        //}
    },

  _dispose: function() {
     this._super('_dispose');
   },

    editClicked: function() {
        this._super("editClicked");

        if(this.model.get('status')=='Held' || this.model.get('status')=='Not Held'){
            this.setButtonStates(this.STATE.VIEW);
            this.action = 'detail';
            this.toggleEdit(false);
            this.setRoute('');
        }
    },

    cancelClicked: function() {

        this._super("cancelClicked");

        this.$('[data-name="parent_name"]').attr('style', '');

        this.setButtonStates(this.STATE.VIEW);
        this.action = 'detail';
        this.handleCancel();
        this.clearValidationErrors(this.editableFields);
        this.setRoute();
        this.unsetContextAction();

        //LLamando función para limpiar los objetivos específicos que no hayan sido guardados
        this.clearUnsavedObjectives();
    },

    cambioFecha: function () {
        this.fechaInicioTemp = Date.parse(this.model.get("date_start"));
        //console.log("Fechas: " + this.fechaInicioTemp);
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
    /*Victor Martinez Lopez
    *25-09-2018
    *El campo parent_name se habilita cuando esta vacio
    */
    enableparentname:function(){
        var self = this;
        if (this.model.get('parent_name') !=='' && this.model.get('parent_name')!==undefined){
          self.noEditFields.push('parent_name');
        }
        else {
        this.$('[data-name="parent_name"]').attr('style', '');
        this.action = 'detail';
        this.toggleEdit(false);
        }

        //Valida fechas
        if (this.model.get('status')=='Held' || this.model.get('status')=='Not Held') {
          self.noEditFields.push('date_start');
          self.noEditFields.push('date_end');
          self.noEditFields.push('duration');
        } else {
          this.$('[data-name="date_start"]').attr('style', '');
          this.$('[data-name="date_end"]').attr('style', '');
          this.$('[data-name="duration"]').attr('style', '');
          this.action = 'detail';
          this.toggleEdit(false);
        }

        //Valida estado
        if (this.model.get('status')=='Held'|| this.model.get('status')=='Not Held' ) {
          self.noEditFields.push('status');
        } else {
          this.$('[data-name="status"]').attr('style', '');
          this.action = 'detail';
          this.toggleEdit(false);
        }
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
                    //console.log("Guarda por opcion 1");
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
                    //console.log("Guarda por opcion 2")
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

        //this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;');

        //Elimina ícono de lápiz para editar parent_name*
        $('[data-name="parent_name"]').find('.fa-pencil').remove();
        },

        /*Victor Martinez Lopez
        *El estado no es editable de manera directa al dar click, solo cuando se presiona el boton editar
        */
    noEditStatus:function (){
        $('[data-name="status"]').find('.fa-pencil').remove();
        $('.record-edit-link-wrapper[data-name=status]').remove();
    },

    /*Victor Martinez López
    * Duración y recordatorios no son editables cuando la reunión esta como realizada
    * */
    disableFieldsTime: function(){
        $('.record-edit-link-wrapper[data-name=duration]').remove();
        $('.record-edit-link-wrapper[data-name=reminders]').remove();
        if (this.model.get('objetivo_c')=='' ){
            this.$("[data-name='objetivo_c']").prop("enable", true);
        }else {
            $('.record-edit-link-wrapper[data-name=objetivo_c]').remove();
        }
        if(this.model.get('resultado_c')==''){
            this.$("[data-name='resultado_c']").prop("enable", true);
        }else{
            $('.record-edit-link-wrapper[data-name=resultado_c]').remove();
        }
    },


    /*@Jesus Carrillo
    Deshabilita campo status dependiendo de diferentes criterios
     */
    disablestatus:function () {
        //Recupera valores originales antes de edición
        this.estadoOriginal = this.model.get('status');
        this.parentIdOriginal = this.model.get('parent_id');

        if(Date.parse(this.model.get('date_end'))>Date.now() || app.user.attributes.id!=this.model.get('assigned_user_id')){

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

    /*Victor Martinez Lopez 23-10-2018
    *Función para obtener la latitud y longitud(coordenadas) y transformar a una dirección
    */
    GetLocation: function (){
        self=this;
        var today= new Date();
        self.model.set('check_in_time_c', today);
        self.model.set('check_in_platform_c', self.GetPlatform());
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(this.showPosition,this.showError);
        }else {
            alert("No se pudo encontrar tu ubicacion");
        }

        if(this.model.get('minut_minutas_meetings_name')==null || this.model.get('minut_minutas_meetings_name')==""){
            this.model.set('status', 'Planned');
        }
        //self.model.save();
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

    showPosition:function(position) {
        self.model.set('check_in_longitude_c', position.coords.longitude);
        self.model.set('check_in_latitude_c',position.coords.latitude);
        self.model.save();
        self.render();
        app.alert.show('alert_check-in_success', {
                level: 'success',
                messages: 'Check-in Existoso',
            });
        //SUGAR.App.controller.context.reloadData({});
        },
    showError:function(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("Permiso de geolocalizaci\u00F3n no autorizado")
            break;
                case error.POSITION_UNAVAILABLE:
                alert("La informaci\u00F3n de la geolocalizaci\u00F3n no está disponible");
                break;
            case error.TIMEOUT:
                alert("El tiempo de espera a terminado");
                break;
            case error.UNKNOWN_ERROR:
                alert("A ocurrido un error desconocido");
                break;
        }
        self.model.save();
        self.render();
        SUGAR.App.controller.context.reloadData({});
    },
    /*Victor Martinez Lopez 22-10-2018
    El boton de Check-in solo será visible una ocasion para guardar datos
    y cuando el usuario asignado sea igual la ususario loggeado Pendiente de terminar
    */
    hidecheck:function(){
        var fechaActual = new Date(); //obtiene fecha actual
        var fechainicio = new Date(this.model.get("date_start"));
        var d = fechainicio.getDate();
        var m = fechainicio.getMonth() + 1;
        var y = fechainicio.getFullYear();
        var fechafin= new Date(y,m-1,d+1, 2,0); //Fecha final
        //Fecha inicio, anterior al dia anterior
        //var fechainicio= new Date(y,m-1,d, 0,0);

        if (this.model.get('assigned_user_id')==app.user.attributes.id && (this.model.get('check_in_time_c')=='' || this.model.get('check_in_time_c')==null)
            && fechaActual>fechainicio && fechaActual<fechafin && (this.model.get('parent_name')!='' && this.model.get('parent_name')!=null) && this.model.get('status')=='Planned'){
                $('[name="check_in1"]').show();
            }   else   {
                $('[name="check_in1"]').hide();
            }
            if(this.model.get('parent_name')!='' && app.user.attributes.id==this.model.get('assigned_user_id')
            && fechaActual>fechainicio && fechaActual<fechafin && this.model.get('status')=='Planned'){
                $('[name="new_minuta"]').show();
        }   else{
                $('[name="new_minuta"]').hide();
        }
    },

    showCheckin:function(){
        var myField=this.getField("check_in1");
        var dateActual = new Date();
        var d1 = dateActual.getDate();
        var m1 = dateActual.getMonth() + 1;
        var y1 = dateActual.getFullYear();
        var dateActualFormat = [m1, d1, y1].join('/');
        var fechaActual = Date.parse(dateActualFormat);

        var dateend = new Date(this.model.get("date_start"));
        var d = dateend.getDate();
        var m = dateend.getMonth() + 1;
        var y = dateend.getFullYear();
        var fechaCompleta = [m, d, y].join('/');
        var fechaendnew = Date.parse(fechaCompleta);

        if (this.model.get('assigned_user_id')==app.user.attributes.id && (this.model.get('check_in_time_c')=='' || this.model.get('check_in_time_c')==null)
            && fechaActual==fechaendnew && (this.model.get('parent_name')!='' && this.model.get('parent_name')!=null) && this.model.get('status')=='Planned'){
                myField.listenTo(myField, "render", function () {
                        myField.show();
                        //console.log("field being rendered as: " + myField.tplName);
                    });

            }   else   {
                myField.listenTo(myField, "render", function () {
                        myField.hide();
                        //console.log("field being rendered as: " + myField.tplName);
                    });
            }
    },
    //Heredar el objetivo y el resultado a la minuta y cambiar y una etiqueta de la minuta a la cuenta
    /*El boton de creación de la minuta solo será visible cuando la reunión tenga una cuenta
    *La fecha de termino sea igual a la fecha actual y el usuario asignado sea el usuario loggeado
     */
    ValidaCuentNoVacia: function () {
        var fechaActual = new Date(); //obtiene fecha actual
        var fechainicio = new Date(this.model.get("date_start"));
        var d = fechainicio.getDate();
        var m = fechainicio.getMonth() + 1;
        var y = fechainicio.getFullYear();
        var fechafin= new Date(y,m-1,d+1, 2,0); //Fecha final
        var myField = this.getField("new_minuta");
        if (this.model.get('parent_name')!='' && app.user.attributes.id==this.model.get('assigned_user_id')
            && fechaActual>fechainicio && fechaActual<fechafin && this.model.get('status')=='Planned'){
            myField.listenTo(myField, "render", function () {
                myField.show();
                //console.log("field being rendered as: " + myField.tplName);
            });
        }else{
            myField.listenTo(myField, "render", function () {
                myField.hide();
                //console.log("field being rendered as: " + myField.tplName);
            });
        }
    },

    /*
    @Salvador Lopez
    * Se agrega función para controlar registros NO guardados en el modelo que se enuentran en el campo de reunion_objetivos
    * y eliminar del array a que se muestra en el hbs, los objetivos NO GUARDADOS
    * */
    clearUnsavedObjectives: function () {

        //if(!_.isEmpty(this.context.get('model').changed) && this.context.get('model').changed.reunion_objetivos != undefined) {

            var lengthArr = self.myobject.records.length;

            if (lengthArr > 0) {

                for (var i = 0; i < lengthArr; i++) {

                    if (self.myobject.records[i].id == undefined) {

                        self.myobject.records.splice(i, 1);
                        //Cambia la longitud del ciclo al eliminar elemento del array
                        lengthArr=self.myobject.records.length;
                        i=i-1;

                    }
                }
            }
        //}


        var lengthDelete= self.myDeletedObj.records.length;

        if(lengthDelete>0){

            for(var i=0;i<self.myIndexDeleted.length;i++){
                //Establecer deleted como 0, ya que myDeletedObj.records[i] trae 1
                self.myDeletedObj.records[i].deleted=0;
                self.myobject.records.splice(self.myIndexDeleted[i],0,self.myDeletedObj.records[i]);

            }

            self.render();
        }

        //Reiniciar arreglos
        self.myDeletedObj.records=[];
        self.myIndexDeleted=[];

    },

    /*Valida que por lo menos exita un objetivo específico a su vez expande el panel*/
    ValidaObjetivos:function(fields, errors, callback){
        if (this.$('.objetivoSelect').length<=0 && this.model.get('parent_type') == "Accounts" && this.model.get('parent_id')!="" && this.model.get('status')!="Not Held" ){
            errors[$(".objetivoSelect")] = errors['objetivos_especificos'] || {};
            errors[$("objetivos_especificos")].required = true;
            //Agrega borde
            this.$('.newCampo1').css('border-color', 'red');
            //Expande panel
            this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(0).removeClass('panel-inactive');
            this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(0).addClass('panel-active');
            this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(1).attr("style","display:block");
            app.alert.show("Objetivo vacio",{
                level: "error",
                title: "Es necesario tener por lo menos un <b>Objetivo espec\u00EDfico</b>",
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    /**
      Valida que no permita pasara a realizada y agregar cuetna en la misma edición de la reunión
    */
    validaRealizada:function(fields, errors, callback){
      //Recupera valores
      if (this.estadoOriginal != "Held" && this.parentIdOriginal == "" && this.model.get('status')=='Held' && this.model.get('parent_type') == 'Accounts' && this.model.get('parent_id') != "" ) {
        errors['status_cuenta'] = 'No es posible actualizar el estado y la cuenta en la misma edición';
        errors['status_cuenta'].required = true;
        app.alert.show("Estado_sin_cuenta",{
            level: "error",
            title: "No es posible actualizar el estado y la cuenta en la misma edici\u00F3n",
            autoClose: false
        });
      }
      callback(null, fields, errors);
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

    valida_usuarios_inactivos:function (fields, errors, callback) {

        var inivitados=this.model.attributes.invitees.models;

        var ids_usuarios='';

        for(var i=0;i<this.model.attributes.invitees.models.length;i++){

            ids_usuarios+=this.model.attributes.invitees.models[i].id + ',';

        }

        //Generar petición para validación
        app.api.call('GET', app.api.buildURL('GetStatusOfUser/' + ids_usuarios+'/inactivo'), null, {
            success: _.bind(function(data) {
                if(data.length>0){

                    var nombres='';
                    //Armando lista de usuarios
                    for(var i=0;i<data.length;i++){

                        nombres+='<b>'+data[i].nombre_usuario+'</b><br>';
                    }

                    app.alert.show("Usuarios", {
                        level: "error",
                        messages: "No es posible generar una reunión con los siguientes usuarios inactivos:<br>"+nombres,
                        autoClose: false
                    });
                    errors['usuariostatus'] = errors['usuariostatus'] || {};
                    errors['usuariostatus'].required = true;
                }
                callback(null, fields, errors);
            }, this)
        });

    },

    //Valida centro prospeccion, si esta vacio deja editar,de lo contrario, no.
    validaprospeccion:function (){
        var self = this;
     if (this.model.get('centro_prospecccion_c') !== "" && this.model.get('centro_prospecccion_c')!==undefined) {
        self.noEditFields.push('centro_prospecccion_c');
         $('div[data-name=centro_prospecccion_c]').css("pointer-events", "none");
     }else {
        this.$('div[data-name=centro_prospecccion_c]').css("pointer-events", "");
      }
    },

    valida_usuarios_vetados:function (fields, errors, callback) {
        if (App.user.attributes.puestousuario_c == '27' || App.user.attributes.puestousuario_c == '31') {
            var inivitados=this.model.attributes.invitees.models;
            var ids_usuarios='';

            for(var i=0;i<this.model.attributes.invitees.models.length;i++){
                ids_usuarios+=this.model.attributes.invitees.models[i].id + ',';
            }

            //Generar petición para validación
            app.api.call('GET', app.api.buildURL('GetStatusOfUser/' + ids_usuarios +'/vetado'), null, {
                success: _.bind(function(data) {
                    if(data.length>0){
                        var nombres='';
                        //Armando lista de usuarios
                        for(var i=0;i<data.length;i++){
                            nombres+='<b>'+data[i].nombre_usuario+'</b><br>';
                        }
                        app.alert.show("Usuarios", {
                            level: "error",
                            messages: "No es posible generar una reunión con los siguientes usuarios vetados:<br>"+nombres,
                            autoClose: false
                        });
                        errors['usuariostatus_vetado'] = errors['usuariostatus_vetado'] || {};
                        errors['usuariostatus_vetado'].required = true;
                    }
                    callback(null, fields, errors);
                }, this)
            });
        }else {
            callback(null, fields, errors);
        }
    },

})
