/**
 * Created by Salvador Lopez <salvador.lopez@tactos.com.mx>
 */
({
    events: {
        'focusout #newPostalInputTemp': 'getInfoAboutCP',

        'change .newPais': 'populateEdoByPais',

        //Dependencia entre Municipio y Colonia
        'change .newMunicipio': 'populateColoniasByMunicipio',

        //Dependencia entre Estado y Colonia, además llena municipio por Estado
        'change .newEstado': 'populateCiudadesByEstado',

        'click  .addDireccion': 'addNewDireccion',
    },

    initialize: function(options) {
        this._super('initialize', [options]);

        
        this.paises_list={};
        this.estados_list=[];
        this.municipios_list=[];
        this.ciudades_list={};
        this.colonias_list={};

        self=this;

        this.tipo_direccion_list = App.lang.getAppListStrings('dir_tipo_unique_list');
        this.indicador_list = App.lang.getAppListStrings('dir_indicador_unique_list');

    },

    _render: function() {
        this._super("_render");

        
        //Estableciendo formato select2 a campo "Tipo"
        this.$('.multi_tipo').select2({
            width:'100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        //Estableciendo formato select2 a campo "Tipo de dirección"
        this.$('.multi1_n').select2({
            width:'100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });
        

    },

    getInfoAboutCP: function(evt){
        
        var cp=evt.currentTarget.value;
        var str_length=cp.length;
        var self = this;

        var pattern = /^\d+$/;
        var isNumber= pattern.test(cp);
        if(str_length==5 && isNumber){

            //Limpiado campos select
            this.$('select.newPais').empty();
            this.$('select.newEstado').empty();
            this.$('select.newMunicipio').empty();
            this.$('select.newCiudad').empty();
            this.$('select.newColonia').empty();

            this.estados_list=[];

            //LLamada a api custom
            var strUrl='DireccionesCP/'+cp;
            this.$(".loadingIcon").show();
            this.$(".loadingIconEstado").show();
            this.$(".loadingIconMunicipio").show();
            this.$(".loadingIconCiudad").show();
            this.$(".loadingIconColonia").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {

                    if (data.paises.length == 0) {
                        app.alert.show('invalid_cp_exist', {
                            level: 'error',
                            autoClose: true,
                            messages: 'El C\u00F3digo Postal no existe'
                        });
                        self.$(".loadingIcon").hide();
                        self.$(".loadingIconEstado").hide();
                        self.$(".loadingIconMunicipio").hide();
                        self.$(".loadingIconCiudad").hide();
                        self.$(".loadingIconColonia").hide();

                        self.$('#newPostalInputTemp').css('border-color', 'red');

                    }else{

                        //Añadiendo id de cp
                        $('#newPostalHidden').val(data.idCP);

                        var list_paises = data.paises;
                        var list_municipios = data.municipios;
                        var list_estados = data.estados;
                        var list_colonias = data.colonias;

                        var paises_options = '';
                        for (var i = 0; i < list_paises.length; i++) {
                            self.$('select.newPais').append($("<option>").val(list_paises[i].idPais).html(list_paises[i].namePais));
                        }

                        for (var i = 0; i < list_estados.length; i++) {
                            self.$('select.newEstado').append($("<option>").val(list_estados[i].idEstado).html(list_estados[i].nameEstado));
                            self.estados_list.push({'id':list_estados[i].idEstado,"name":list_estados[i].nameEstado});
                        }

                        for (var i = 0; i < list_municipios.length; i++) {
                            self.$('select.newMunicipio').append($("<option>").val(list_municipios[i].idMunicipio).html(list_municipios[i].nameMunicipio));
                            self.municipios_list.push({'id':list_municipios[i].idMunicipio,"name":list_municipios[i].nameMunicipio})
                        }

                        //Ejecutar la carga de estados por país solo si para el CP ingresado existe más de un país
                        if(list_paises.length>1){
                            self.$('.newPais').trigger("change");
                        }

                        self.$('.newMunicipio').trigger("change");
                    
                        self.$(".loadingIcon").hide();
                        self.$(".loadingIconEstado").hide();
                        self.$(".loadingIconMunicipio").hide();
                        //self.$(".loadingIconColonia").hide();

                        self.$('.newEstado').trigger('change');

                        //self.$(".loadingIconCiudad").hide();
                    }
                },this)
            });

        }else{
            app.alert.show('invalid_cp', {
                level: 'error',
                autoClose: true,
                messages: 'C\u00F3digo Postal inv\u00E1lido'
            });
        }

    },

    populateEdoByPais:function(evt){

        //Establecer estado por pais
        var id_pais=$(evt.currentTarget).val();
        var returnArray=this.arraySearch(this.estados_list,id_pais,'estado');

        if(returnArray.length>0){
            this.$('select.newEstado').empty();
            for (var i = 0; i < returnArray.length; i++) {

                this.$('select.newEstado').append($("<option>").val(returnArray[i].id).html(returnArray[i].name));     
            }

            this.$('.newEstado').trigger('change');

        }
    },


    arraySearch:function(arr,val,tipo) {
        var returnArray=[];
        if(tipo=='estado'){
            for (var i=0; i<arr.length; i++){
                if (arr[i].id.startsWith("00"+val)){
                    returnArray.push(arr[i]);
                }  
            }    
        }
        if(tipo=='municipio'){
            for (var i=0; i<arr.length; i++){
                if (arr[i].id.startsWith(val)){
                    returnArray.push(arr[i]);
                }  
            }
        }
                      
        return returnArray;
    },

    populateColoniasByMunicipio:function(evt){

        this.$('select.newColonia').empty();

        var id_municipio=$(evt.currentTarget).val();
        var cp=this.$('#newPostalInputTemp').val();

        if(id_municipio != null && id_municipio != "" ){

            //LLamada a api custom
            var strUrl='dire_Colonia?filter[0][codigo_postal]='+cp+'&filter[0][id][$starts]='+id_municipio+'&max_num=-1';

            this.$(".loadingIconColonia").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {
                    if(data.records.length>0){

                        this.$('select.newColonia').append($("<option>").val("1").html("Seleccionar Colonia"));
                        for (var i = 0; i < data.records.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            this.$('select.newColonia').append($("<option>").val(data.records[i].id).html(data.records[i].name));
                        }
                        $(".loadingIconColonia").hide();
                    }
                },this)
            });

        }
    },

    populateCiudadesByEstado:function(evt){

        this.$('select.newCiudad').empty();
        this.$('select.newMunicipio').empty();

        var id_estado=$(evt.currentTarget).val();

        if(id_estado != null && id_estado != "" ){
            var returnArray=this.arraySearch(this.municipios_list,id_estado,'municipio');

            if(returnArray.length>0){
                for (var i = 0; i < returnArray.length; i++) {

                    this.$('select.newMunicipio').append($("<option>").val(returnArray[i].id).html(returnArray[i].name));     
                }

              this.$('.newMunicipio').trigger('change');  

            }

            //Llamando a api para filtrar ciudades
            var strUrl='dire_Ciudad?filter[0][id][$starts]='+id_estado+'&max_num=-1';

            this.$(".loadingIconCiudad").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {
                    if(data.records.length>0){

                        this.$('select.newCiudad').append($("<option>").val("1").html("Seleccionar Ciudad"));
                        for (var i = 0; i < data.records.length; i++) {
                            this.$('select.newCiudad').append($("<option>").val(data.records[i].id).html(data.records[i].name));
                        }

                        $(".loadingIconCiudad").hide();

                    }
                },this)
            });

        }
    },

    /**
     * Event handler to add a new direccion field.
     * @param {Event} evt
     */
    addNewDireccion: function (evt) {
        if (!evt) return;

        var calle = this.$(evt.currentTarget).val() || this.$('.newCalle').val(),
        currentValue,
        direccionFieldHtml,
        $newDireccionField;

        //Validaciones dentro del control de direcciones
        //TODO: Convertir los mensajes de error a etiquetas dentro del modulo para poder habilitar cambios via studio.
        var errorMsg = '';
        var dirErrorCounter = 0;
        var dirError = false;


        //Valida tipo de direccion Multiselect
        if (this.$('#tipo_multiselect_id').val() == null || this.$('#tipo_multiselect_id').val() == "") {
            errorMsg = 'Tipo de direccion requerido';
            dirError = true; dirErrorCounter++;
            this.$('#s2id_tipo_multiselect_id ul').css('border-color', 'red');
        } else {
            this.$('#s2id_tipo_multiselect_id ul').css('border-color', '');
        }

        //Valida indicador
        if (this.$('#indicador_multiselect_id').val() == null || this.$('#indicador_multiselect_id').val() == "") {
            errorMsg = 'Indicador de direcci\u00F3n requerido';

            dirError = true; dirErrorCounter++;

            this.$('#s2id_indicador_multiselect_id ul').css('border-color', 'red');  //Validación para pintar el campo Indicador.
        } else {
            this.$('#s2id_indicador_multiselect_id ul').css('border-color', '');
            //$('#multi1').css('border-color', '');

        }

        //Valida código postal
        if (this.$('#newPostalInputTemp').val() == '') {
            errorMsg = 'C\u00F3digo postal requerido';
            dirError = true; dirErrorCounter++;
            this.$('#newPostalInputTemp').css('border-color', 'red');
        } else {
            this.$('#newPostalInputTemp').css('border-color', '');

        }

        //Valida extensión de código postal y valida únicamente números
        var pattern = /^\d+$/;

        if (this.$('#newPostalInputTemp').val().length !=5 || !pattern.test(this.$('#newPostalInputTemp').val())) {
            this.$('#newPostalInputTemp').css('border-color', 'red');
        } else {
            this.$('#newPostalInputTemp').css('border-color', '');

        }

        //Valida Ciudad
        if (this.$('select.newCiudad').val() == '1') {
            errorMsg = 'Favor de seleccionar una ciudad';
            dirError = true; dirErrorCounter++;
            this.$('select.newCiudad').css('border-color', 'red');
        } else {
            this.$('select.newCiudad').css('border-color', '');

        }

        //Valida colonia
        if (this.$('select.newColonia').val() == '1') {
            errorMsg = 'Favor de seleccionar una colonia';
            dirError = true; dirErrorCounter++;
            this.$('select.newColonia').css('border-color', 'red');
        } else {
            this.$('select.newColonia').css('border-color', '');

        }

        //Valida Calle
        if (this.$('.newCalle').val() == '' || this.$('.newCalle').val() == null) {
            errorMsg = 'Calle es requerida';
            dirError = true; dirErrorCounter++;
            this.$('.newCalle').css('border-color', 'red');
        } else {
            this.$('.newCalle').css('border-color', '');

        }

        //Valida Num Ext
        if (this.$('.newNumExt').val() == '' || this.$('.newNumExt').val() == null) {
            errorMsg = 'Numero Exterior es requerido';
            dirError = true; dirErrorCounter++;
            this.$('.newNumExt').css('border-color', 'red');
        } else {
            this.$('.newNumExt').css('border-color', '');

        }

        if (dirError) {
            if(dirErrorCounter > 1) errorMsg = 'Hay campos vac\u00EDos en la direcci\u00F3n.'
                app.alert.show('list_delete_direccion_info', {
                    level: 'error',
                    autoClose: true,
                    messages: errorMsg
                });
            return;
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