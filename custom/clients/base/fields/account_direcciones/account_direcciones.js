/**
 * Created by Salvador Lopez <salvador.lopez@tactos.com.mx>
 */
({
    events: {

        
        'keydown .calleExisting': 'checkcallenum',
        'keydown .numIntExisting': 'checknumint',
        'keydown .numExtExisting': 'checkcallenum',

        'blur .calleExisting': 'checkcallenum',
        'blur .numIntExisting': 'checknumint',
        'blur .numExtExisting': 'checkcallenum',
         
        'keydown .newCalle': 'limitto100',
        'keydown .newNumInt': 'limitto50',
        'keydown .newNumExt': 'limitto100',

        'focusout #newPostalInputTemp': 'getInfoAboutCP',
        'change .postalInputTempExisting': 'getInfoAboutCPExisting',

        'change .newPais': 'populateEdoByPais',
        'change .paisExisting': 'populateEdoByPaisExisting',

        'change .ciudadExisting':'updateExistingCiudad',
        'change .coloniaExisting':'updateExistingColonia',

        //Dependencia entre Municipio y Colonia
        'change .newMunicipio': 'populateColoniasByMunicipio',
        'change .municipioExisting': 'populateColoniasByMunicipioExisting',

        //Dependencia entre Estado y Colonia, además llena municipio por Estado
        'change .newEstado': 'populateCiudadesByEstado',
        'change .estadoExisting': 'populateCiudadesByEstadoExisting',
        'click  .addDireccion': 'addNewDireccion',

        //Nuevo evento para actualizar valores de select "Tipo" dependiendo el valor del multiselect
        'change .multi_tipo': 'updateValueTipoMultiselect',
        'change .multi_tipo_existing': 'updateValueTipoMultiselect',

        //Nuevo evento para actualizar valores de select "Tipo de Direccion" dependiendo el valor del multiselect
        //Indicador con formato select2
        'change .multi1_n': 'updateValueIndicadorMultiselect',
        //Indicador existente con formato select2
        'change .multi1_n_existing': 'updateValueIndicadorMultiselect',

        'change .existingIndicador': 'updateIndicadores',
        'change .newIndicador': 'updateIndicadores',

        //Actualizaciones de calle, num exterior y num interior 
        'change .inputExisting': 'updateExistingInputs',

    },

    initialize: function (options) {
        this._super('initialize', [options]);


        this.paises_list = {};
        this.estados_list = [];
        this.municipios_list = [];
        this.ciudades_list = {};
        this.colonias_list = {};
        this.flagDirecciones = 0;


        this.direcciones = [];
        this.dataDireccionesApi = [];

        this.fiscalCounter = 0;
        this.counterTipoVacio = 0;

        this.tipo_direccion_list = App.lang.getAppListStrings('dir_tipo_unique_list');
        this.indicador_list = App.lang.getAppListStrings('dir_indicador_unique_list');

        //Tipos de dirección hidden para guardar valores en dire_direccion
        this.def.dir_tipo_list_html = App.lang.getAppListStrings('tipodedirecion_list');
        this.def.indicador_html = App.lang.getAppListStrings('dir_Indicador_list');

        this.model.addValidationTask('check_empty_tipo', _.bind(this._doValidateEmptyTipo, this));
        this.model.addValidationTask('check_multiple_fiscal', _.bind(this._doValidateDireccionFiscal, this));
        this.model.addValidationTask('check_multiple_fiscalCorrespondencia', _.bind(this._doValidateDireccionFiscalCorrespondencia, this));

        this.model.addValidationTask('GuardarDirecciones', _.bind(this.almacenaDirecciones, this));


        var api_params = {
            //'fields': fields.join(','),
            'max_num': 42,
            'order_by': 'date_entered:desc',
            'filter': [{'accounts_dire_direccion_1accounts_ida': this.model.id}]
        };
        var pull_direccion_url = app.api.buildURL('dire_Direccion',
            null, null, api_params);

        self = this;

        //Ejecuta consulta para recuperar infomación
        try {
            app.api.call('READ', pull_direccion_url, {}, {
                success: function (data) {
                    //get mapping arrays and keys
                    //self.direcciones = [];
                    if (self.flagDirecciones == 0) {
                        self.flagDirecciones++;
                        var dir_tipo_list_html = App.lang.getAppListStrings('tipodedirecion_list');
                        var country_list = app.metadata.getCountries();
                        var estado_list = app.metadata.getStates();
                        var municipio_list = app.metadata.getMunicipalities();
                        var city_list = app.metadata.getCities();
                        var postal_list = app.metadata.getPostalCodes();
                        this.arrObjDirecciones = [];
                        for (var i = 0; i < data.records.length; i++) {

                            //Tipo seleccionado
                            var tipo_seleccionado_hide = '';
                            var tipo_seleccionado_hide_label = '';

                            this.objDireccion = {
                                "id": data.records[i].id,
                                "tipo_direccion_list_hide": App.lang.getAppListStrings('tipodedirecion_list'),
                                "tipo_seleccionado_hide": data.records[i].tipodedireccion[0],
                                "tipo_seleccionado_hide_label": dir_tipo_list_html[data.records[i].tipodedireccion[0]],
                                "tipo_direccion_list": self.tipo_direccion_list,
                                //"tipos_seleccionados":$('select.multi_tipo').select2('val').join(),
                                "indicador_list_hide": self.def.indicador_html,
                                "indicador_seleccionado_hide": data.records[i].indicador,
                                "indicador_seleccionado_hide_label": self.def.indicador_html[data.records[i].indicador],
                                "indicador_list": self.indicador_list,
                                //"indicadores_seleccionados":$('select.multi1_n').select2('val').join(),
                                //"lista_paises_existing":lista_paises_existing,
                                "pais_seleccionado": data.records[i].dire_direccion_dire_paisdire_pais_ida,
                                //"lista_estados_existing":lista_estados_existing,
                                "estado_seleccionado": data.records[i].dire_direccion_dire_estadodire_estado_ida,
                                //"lista_municipios_existing":lista_municipios_existing,
                                "municipio_seleccionado": data.records[i].dire_direccion_dire_municipiodire_municipio_ida,
                                //"lista_ciudades_existing":lista_ciudades_existing,
                                "ciudad_seleccionada": data.records[i].dire_direccion_dire_ciudaddire_ciudad_ida,
                                //"lista_colonias_existing":lista_colonias_existing,
                                "colonia_seleccionada": data.records[i].dire_direccion_dire_coloniadire_colonia_ida,
                                "codigo_postal": data.records[i].dire_direccion_dire_codigopostal_name,
                                "postal_hidden": data.records[i].dire_direccion_dire_codigopostaldire_codigopostal_ida,
                                "calle": data.records[i].calle,
                                "numext": data.records[i].numext,
                                "numint": data.records[i].numint,
                                "principal": data.records[i].principal,
                                "inactivo": false
                            };
                            this.arrObjDirecciones.push(this.objDireccion);
                            self.dataDireccionesApi.push(this.objDireccion.postal_hidden);
                            
                            var contextoApi = this;
                            //LLamada a api custom
                            var strUrl = 'DireccionesCP/' + this.objDireccion.codigo_postal;
                            app.api.call('GET', app.api.buildURL(strUrl), null, {
                                success: _.bind(function (data) {
                                    //self.direcciones=[];
                                    var list_paises = data.paises;
                                    var list_municipios = data.municipios;
                                    var city_list = App.metadata.getCities();
                                    var list_estados = data.estados;
                                    var list_colonias = data.colonias;

                                    var indice=self.getIndexOfAddress(contextoApi.arrObjDirecciones,data.idCP);

                                    contextoApi.arrObjDirecciones[indice].lista_paises_existing = {};
                                    contextoApi.arrObjDirecciones[indice].lista_estados_existing = {};
                                    contextoApi.arrObjDirecciones[indice].lista_municipios_existing = {};
                                    contextoApi.arrObjDirecciones[indice].lista_ciudades_existing = {};
                                    contextoApi.arrObjDirecciones[indice].lista_colonias_existing = {};


                                    var paises_options = '';
                                    for (var i = 0; i < list_paises.length; i++) {
                                        //contextoApi.objDireccion.lista_paises_existing.push({'id':list_paises[i].idPais,"name":list_paises[i].namePais});
                                        contextoApi.arrObjDirecciones[indice].lista_paises_existing[list_paises[i].idPais] = list_paises[i].namePais;
                                    }

                                    for (var i = 0; i < list_estados.length; i++) {
                                        //contextoApi.objDireccion.lista_estados_existing.push({'id':list_estados[i].idEstado,"name":list_estados[i].nameEstado});
                                        contextoApi.arrObjDirecciones[indice].lista_estados_existing[list_estados[i].idEstado] = list_estados[i].nameEstado;
                                    }

                                    for (var i = 0; i < list_municipios.length; i++) {
                                        //contextoApi.objDireccion.lista_estados_existing.push({'id':list_estados[i].idEstado,"name":list_estados[i].nameEstado});
                                        contextoApi.arrObjDirecciones[indice].lista_municipios_existing[list_municipios[i].idMunicipio] = list_municipios[i].nameMunicipio;
                                    }

                                    var ciudades = Object.values(city_list);
                                    for (var i = 0; i < ciudades.length; i++) {
                                        if (ciudades[i].estado_id == contextoApi.arrObjDirecciones[indice].estado_seleccionado) {
                                            contextoApi.arrObjDirecciones[indice].lista_ciudades_existing[ciudades[i].id] = ciudades[i].name;
                                        }
                                    }

                                    for (var i = 0; i < list_colonias.length; i++) {
                                        //contextoApi.objDireccion.lista_estados_existing.push({'id':list_estados[i].idEstado,"name":list_estados[i].nameEstado});
                                        contextoApi.arrObjDirecciones[indice].lista_colonias_existing[list_colonias[i].idColonia] = list_colonias[i].nameColonia;
                                    }

                                    self.direcciones.push(contextoApi.arrObjDirecciones[indice]);
                                    //set model so tpl detail tpl can read data
                                    try {
                                        self.model.set('account_direcciones', self.direcciones);
                                        self.model._previousAttributes.account_direcciones = self.direcciones;
                                        self.model._syncedAttributes.account_direcciones = self.direcciones;
                                        //self.format();
                                        self._render();

                                    }catch (e) {
                                        console.log(e.message);
                                    }

                                }, self)
                            });


                        }

                    }


                }
            });
        } catch (e) {
            console.log(e.message);
        }


    },

    _render: function () {

        /*Condición para saber si los valores de direcciones existentes han cambiado
        y evitar que al dar click en 'Guardar', el campo se pase inmediatamente a su vista de detalle
        */
        /*
        if(this.direcciones.length > 0 && this.dataDireccionesApi.length >0 && 
            this.direcciones.length == this.dataDireccionesApi.length){
            for (var i =0;i<this.direcciones.length;i++) {
                if(this.direcciones[i].postal_hidden!=this.dataDireccionesApi[i]){
                    this.options.viewName='edit';
                    this.action='edit';
                }
            }

        }
        */
        this._super("_render");


        //Estableciendo formato select2 a campo "Tipo"
        this.$('.multi_tipo').select2({
            width: '100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        //Estableciendo formato select2 a campo "Tipo de dirección"
        this.$('.multi1_n').select2({
            width: '100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        
         $('select.newPais').select2({width:'100%'});
         $('select.newEstado').select2({width:'100%'});
         $('select.newMunicipio').select2({width:'100%'});
         $('select.newCiudad').select2({width:'100%'});
         $('select.newColonia').select2({width:'100%'});
         

        /* Estableciendo formato select2 a campos de direccionaes existententes */
        $('.multi_tipo_existing').select2({
            width: '100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        $('.multi1_n_existing').select2({
            width: '100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        $('select.paisExisting').select2({width: '100%'});
        $('select.estadoExisting').select2({width: '100%'});
        $('select.municipioExisting').select2({width: '100%'});
        $('select.ciudadExisting').select2({width: '100%'});
        $('select.coloniaExisting').select2({width: '100%'});

        /*Fin existentes*/
        if (this.tplName === 'edit') {
            var self = this;
            //Se establece valor de multiselect dependiendo el valor de select que se encuentra en la misma fila
            $("select.existingTipodedireccion").each(function (i, obj) {
                var valuesI = self._getTipoDireccion($(this).val(), null)
                $('select.multi_tipo_existing').eq(i).select2('val', valuesI);

            });

            //Se establece valor de multiselect dependiendo el valor de select que se encuentra en la misma fila
            $("select.existingIndicador").each(function (i, obj) {
                var valuesI = self._getIndicador($(this).val(), null)
                $('select.multi1_n_existing').eq(i).select2('val', valuesI);

            });

        }


    },

    getInfoAboutCP: function (evt) {

        var cp = evt.currentTarget.value;
        var str_length = cp.length;
        var self = this;

        var pattern = /^\d+$/;
        var isNumber = pattern.test(cp);
        if (str_length == 5 && isNumber) {

            //Limpiado campos select
            this.$('select.newPais').select2('val','');
            this.$('select.newPais').empty();
            this.$('select.newEstado').select2('val','');
            this.$('select.newEstado').empty();
            this.$('select.newMunicipio').select2('val','');
            this.$('select.newMunicipio').empty();
            this.$('select.newCiudad').select2('val','');
            this.$('select.newCiudad').empty();
            this.$('select.newColonia').select2('val','');
            this.$('select.newColonia').empty();

            this.estados_list = [];

            //LLamada a api custom
            var strUrl = 'DireccionesCP/' + cp;
            this.$(".loadingIcon").show();
            this.$(".loadingIconEstado").show();
            this.$(".loadingIconMunicipio").show();
            this.$(".loadingIconCiudad").show();
            this.$(".loadingIconColonia").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {

                    if (data.paises.length == 0) {
                        self.$('select.newPais').select2('val','');
                        self.$('select.newPais').empty();
                        self.$('select.newEstado').select2('val','');
                        self.$('select.newEstado').empty();
                        self.$('select.newMunicipio').select2('val','');
                        self.$('select.newMunicipio').empty();
                        self.$('select.newCiudad').select2('val','');
                        self.$('select.newCiudad').empty();
                        self.$('select.newColonia').select2('val','');
                        self.$('select.newColonia').empty();

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

                    } else {

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

                        //Se lanza evento change de país para observar el valor "seteado" del dropdown
                        self.$('select.newPais').trigger('change');

                        for (var i = 0; i < list_estados.length; i++) {
                            self.$('select.newEstado').append($("<option>").val(list_estados[i].idEstado).html(list_estados[i].nameEstado));
                            self.estados_list.push({
                                'id': list_estados[i].idEstado,
                                "name": list_estados[i].nameEstado
                            });
                        }

                        for (var i = 0; i < list_municipios.length; i++) {
                            self.$('select.newMunicipio').append($("<option>").val(list_municipios[i].idMunicipio).html(list_municipios[i].nameMunicipio));
                            self.municipios_list.push({
                                'id': list_municipios[i].idMunicipio,
                                "name": list_municipios[i].nameMunicipio
                            })
                        }

                        //Ejecutar la carga de estados por país solo si para el CP ingresado existe más de un país
                        if (list_paises.length > 1) {
                            self.$('.newPais').trigger("change");
                        }

                        self.$('.newMunicipio').trigger("change");

                        self.$(".loadingIcon").hide();
                        self.$(".loadingIconEstado").hide();
                        self.$(".loadingIconMunicipio").hide();
                        //self.$(".loadingIconColonia").hide();

                        //Evento change de estado para llenar ciudades
                        //Se dispara función populateCiudadesByEstadoExisting
                        self.$('.newEstado').trigger('change');

                        //self.$(".loadingIconCiudad").hide();
                    }
                }, this)
            });

        } else {
            app.alert.show('invalid_cp', {
                level: 'error',
                autoClose: true,
                messages: 'C\u00F3digo Postal inv\u00E1lido'
            });
        }

    },

    /*
    * Función que llena los campos de una direccíon ya existente, consumiendo el api DireccionesCP
    */
    getInfoAboutCPExisting: function (evt) {
    
        this.cpEvt = evt;
        var cp = evt.currentTarget.value;
        var str_length = cp.length;
        var self = this;

        if (str_length == 0) {
            this.counterEmptyFields++;
        }

        var pattern = /^\d+$/;
        var isNumber = pattern.test(cp);
        if (str_length == 5 && isNumber) {

            this.$(evt.target).css('border-color', '');

            this.$(evt.target).parent().parent().find('select.paisExisting').select2('val','');
            this.$(evt.target).parent().parent().find('select.paisExisting').empty();
            this.$(evt.target).parent().parent().find('select.estadoExisting').select2('val','');
            this.$(evt.target).parent().parent().find('select.estadoExisting').empty();
            this.$(evt.target).parent().parent().next('tr').children().eq(0).find('select.municipioExisting').select2('val','');
            this.$(evt.target).parent().parent().next('tr').children().eq(0).find('select.municipioExisting').empty();
            this.$(evt.target).parent().parent().next('tr').children().eq(1).find('select.ciudadExisting').select2('val','');
            this.$(evt.target).parent().parent().next('tr').children().eq(1).find('select.ciudadExisting').empty();
            this.$(evt.target).parent().parent().next('tr').children().eq(2).find('select.coloniaExisting').select2('val','');
            this.$(evt.target).parent().parent().next('tr').children().eq(2).find('select.coloniaExisting').empty();

            //Arreglo global para llenar campo estadoExisting con base a un idPais
            this.estados_list = [];
            this.municipios_list=[];

            //LLamada a api custom
            var strUrl = 'DireccionesCP/' + cp;

            this.$(evt.target).parent().parent().find('.loadingIconPaisExisting').show();
            this.$(evt.target).parent().parent().find('.loadingIconEstadoExisting').show();
            this.$(evt.target).parent().parent().next('tr').children().eq(0).find('.loadingIconMunicipioExisting').show();
            this.$(evt.target).parent().parent().next('tr').children().eq(1).find('.loadingIconCiudadExisting').show();
            this.$(evt.target).parent().parent().next('tr').children().eq(2).find('.loadingIconColoniaExisting').show();


            app.api.call('GET', app.api.buildURL(strUrl), evt, {
                success: _.bind(function (data) {
                    //self.cpEvt

                    if (data.paises.length == 0) {
                        app.alert.show('invalid_cp_exist', {
                            level: 'error',
                            autoClose: true,
                            messages: 'El C\u00F3digo Postal no existe'
                        });
                        $(self.cpEvt.target).parent().parent().find('.loadingIconPaisExisting').hide();
                        $(self.cpEvt.target).parent().parent().find('.loadingIconEstadoExisting').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(0).find('.loadingIconMunicipioExisting').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(1).find('.loadingIconCiudadExisting').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(2).find('.loadingIconColoniaExisting').hide();

                        $(self.cpEvt.target).css('border-color', 'red');

                    } else {

                        //Añadiendo id de cp
                        //$('#existingPostalHidden').val(data.idCP);
                        $(self.cpEvt.target).parent().parent().find('input.postalHiddenExisting').val(data.idCP);

                        var list_paises = data.paises;
                        var list_municipios = data.municipios;
                        var list_estados = data.estados;
                        var list_colonias = data.colonias;

                        var paises_options = '';
                        for (var i = 0; i < list_paises.length; i++) {
                            $(self.cpEvt.target).parent().parent().find('select.paisExisting').append($("<option>").val(list_paises[i].idPais).html(list_paises[i].namePais));

                        }

                        //Se lanza evento change para poder observar el valor concatenado en el select con formato select2
                        $(self.cpEvt.target).parent().parent().find('select.paisExisting').trigger('change');

                        for (var i = 0; i < list_estados.length; i++) {
                            
                            $(self.cpEvt.target).parent().parent().find('select.estadoExisting').append($("<option>").val(list_estados[i].idEstado).html(list_estados[i].nameEstado));
                            self.estados_list.push({
                                'id': list_estados[i].idEstado,
                                "name": list_estados[i].nameEstado
                            });
                        }


                        for (var i = 0; i < list_municipios.length; i++) {
                            
                            $(self.cpEvt.target).parent().parent().next('tr').children().eq(0).find('select.municipioExisting').append($("<option>").val(list_municipios[i].idMunicipio).html(list_municipios[i].nameMunicipio));
                            self.municipios_list.push({
                                'id': list_municipios[i].idMunicipio,
                                "name": list_municipios[i].nameMunicipio
                            })
                        }

                        //Ejecutar la carga de estados por país solo si para el CP ingresado existe más de un país
                        if (list_paises.length > 1) {
                            //Con este evento change se dispara la función populateEdoByPais
                            self.$(self.cpEvt.target).parent().parent().find('select.paisExisting').trigger("change");
                        }

                        //Evento change de municipioExisting para llenar colonias
                        //Se dispara función populateColoniasByMunicipioExisting
                        self.$(self.cpEvt.target).parent().parent().next('tr').children().eq(0).find('select.municipioExisting').trigger("change");

                        self.$(self.cpEvt.target).parent().parent().find('.loadingIconPaisExisting').hide();
                        self.$(self.cpEvt.target).parent().parent().find('.loadingIconEstadoExisting').hide();
                        self.$(self.cpEvt.target).parent().parent().next('tr').children().eq(0).find('.loadingIconMunicipioExisting').hide();

                        //Actualizando el código postal en el arreglo this.direcciones
                        var $input = self.$(self.cpEvt.currentTarget);
                        var class_name = $input[0].className;
                        var $inputs = self.$('.' + class_name),
                        $index = $inputs.index($input),
                        nuevo_valor = $input.siblings('input').val();

                        //Actualizando el valor hidden del codigo postal
                        self.updateExistingDireccion($index, nuevo_valor, 'codigopostalhidden');

                        //Evento change de estado para llenas ciudades
                        //Se dispara función populateCiudadesByEstadoExisting
                        self.$(self.cpEvt.target).parent().parent().find('select.estadoExisting').trigger('change');

                    }
                }, this)
            });

            //Obteniendo información para actulizar el valor del cp en el arreglo de this.direcciones
            var $input = this.$(evt.currentTarget);
            var class_name = $input[0].className;
            var $inputs = this.$('.' + class_name),
            $index = $inputs.index($input),
            nuevo_valor = $input.val();

            //Actualizando el valor de codigo postal
            this.updateExistingDireccion($index, nuevo_valor, 'codigopostal');

            

        } else {

            app.alert.show('invalid_cp', {
                level: 'error',
                autoClose: true,
                messages: 'C\u00F3digo Postal inv\u00E1lido'
            });

            this.$(evt.target).css('border-color', 'red');
        }

    },

    populateEdoByPais: function (evt) {

        //Establecer estado por pais
        var id_pais = $(evt.currentTarget).val();
        var returnArray = this.arraySearch(this.estados_list, id_pais, 'estado');

        if (returnArray.length > 0) {
            this.$('select.newEstado').empty();
            for (var i = 0; i < returnArray.length; i++) {

                this.$('select.newEstado').append($("<option>").val(returnArray[i].id).html(returnArray[i].name));
            }

            this.$('.newEstado').trigger('change');

        }
    },

    populateEdoByPaisExisting:function(evt){

        //Establecer estado por pais
        var id_pais = $(evt.currentTarget).val();

        //Actualizando el código postal en el arreglo this.direcciones
        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className;
        var $inputs = this.$('select.' + class_name),
        $index = $inputs.index($input);

        var returnArray = this.arraySearch(this.estados_list, id_pais, 'estado');

        if (returnArray.length > 0) {
            this.$(evt.currentTarget).parent().parent().find('select.estadoExisting').select2('val','');
            this.$(evt.currentTarget).parent().parent().find('select.estadoExisting').empty();
            for (var i = 0; i < returnArray.length; i++) {

                this.$(evt.currentTarget).parent().parent().find('select.estadoExisting').append($("<option>").val(returnArray[i].id).html(returnArray[i].name));
            }

            this.updateExistingDireccion($index, id_pais, 'pais');

            this.$(evt.currentTarget).parent().parent().find('select.estadoExisting').trigger('change');
        }

    },

    arraySearch: function (arr, val, tipo) {
        var returnArray = [];
        if (tipo == 'estado') {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i].id.startsWith("00" + val)) {
                    returnArray.push(arr[i]);
                }
            }
        }
        if (tipo == 'municipio') {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i].id.startsWith(val)) {
                    returnArray.push(arr[i]);
                }
            }
        }

        return returnArray;
    },

    /**
     * Busca el código postal y regresa la posición del arreglo en la que se encuentra el valor del cp
     *
     * @param {Array} Arreglo sobre el que se va a buscar.
     * @param {String} Valor que se quiere buscar.
     * @return {number} Índice encontrado donde se localizó el cp
     */
    getIndexOfAddress:function(arr,valor_buscar){

        var index='';

        if(arr.length > 0){

            for(var i=0;i<arr.length;i++){

                if(arr[i].postal_hidden==valor_buscar){
                    index=i;
                }

            }
        }

        return index;

    },

    populateColoniasByMunicipio: function (evt) {

        this.$('select.newColonia').select2('val','');
        this.$('select.newColonia').empty();

        var id_municipio = $(evt.currentTarget).val();
        var cp = this.$('#newPostalInputTemp').val();

        if (id_municipio != null && id_municipio != "") {

            //LLamada a api custom
            var strUrl = 'dire_Colonia?filter[0][codigo_postal]=' + cp + '&filter[0][id][$starts]=' + id_municipio + '&max_num=-1';

            this.$(".loadingIconColonia").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {
                    if (data.records.length > 0) {

                        this.$('select.newColonia').append($("<option>").val("1").html("Seleccionar Colonia"));
                        for (var i = 0; i < data.records.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            this.$('select.newColonia').append($("<option>").val(data.records[i].id).html(data.records[i].name));
                        }

                        //Se lanza evento change para observar el valor seteado de colonia con formato select2
                        this.$('select.newColonia').trigger('change');

                        $(".loadingIconColonia").hide();
                    }
                }, this)
            });

        }
    },

    populateColoniasByMunicipioExisting: function (evt) {

        this.evt = evt;
        var self = this;

        this.$(evt.currentTarget).parent().parent().find('select.coloniaExisting').select2('val','');
        this.$(evt.currentTarget).parent().parent().find('select.coloniaExisting').empty();

        var id_municipio = $(evt.currentTarget).val();

    
        var cp = this.$(evt.currentTarget).parent().parent().parent().find('.postalInputTempExisting').val();

        if (id_municipio != null && id_municipio != "") {

            //LLamada a api custom
            var strUrl = 'dire_Colonia?filter[0][codigo_postal]=' + cp + '&filter[0][id][$starts]=' + id_municipio + '&max_num=-1';

            this.$(evt.currentTarget).parent().parent().find(".loadingIconColoniaExisting").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {
                    if (data.records.length > 0) {

                        $(evt.currentTarget).parent().parent().find('select.coloniaExisting').append($("<option>").val("1").html("Seleccionar Colonia"));
                        for (var i = 0; i < data.records.length; i++) {
                            $(evt.currentTarget).parent().parent().find('select.coloniaExisting').append($("<option>").val(data.records[i].id).html(data.records[i].name));
                        }

                        //Creando variables para actualizar municipio en this.direcciones
                        var $input = self.$(self.evt.currentTarget);
                        var class_name = $input[0].className;
                        var $inputs = self.$('select.' + class_name),
                        $index = $inputs.index($input);
                        var id_municipio=self.$(self.evt.currentTarget).val();

                        //Actualizando municipio en this.direcciones
                        this.updateExistingDireccion($index, id_municipio, 'municipio');

                        //Se lanza evento change para observar el valor concatenado en campo coloniaExisting con formato select2
                        $(evt.currentTarget).parent().parent().find('select.coloniaExisting').trigger('change');

                        $(evt.currentTarget).parent().parent().find(".loadingIconColoniaExisting").hide();
                    }
                }, this)
            });

            

        }
    },

    populateCiudadesByEstado: function (evt) {

        this.$('select.newCiudad').select2('val','');
        this.$('select.newCiudad').empty();
        this.$('select.newMunicipio').select2('val','');
        this.$('select.newMunicipio').empty();

        var id_estado = $(evt.currentTarget).val();

        if (id_estado != null && id_estado != "") {
            var returnArray = this.arraySearch(this.municipios_list, id_estado, 'municipio');

            if (returnArray.length > 0) {
                for (var i = 0; i < returnArray.length; i++) {

                    this.$('select.newMunicipio').append($("<option>").val(returnArray[i].id).html(returnArray[i].name));
                }

                this.$('.newMunicipio').trigger('change');

            }

            //Llamando a api para filtrar ciudades
            var strUrl = 'dire_Ciudad?filter[0][id][$starts]=' + id_estado + '&max_num=-1';

            this.$(".loadingIconCiudad").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {
                    if (data.records.length > 0) {

                        this.$('select.newCiudad').append($("<option>").val("1").html("Seleccionar Ciudad"));
                        for (var i = 0; i < data.records.length; i++) {
                            this.$('select.newCiudad').append($("<option>").val(data.records[i].id).html(data.records[i].name));
                        }

                        //Se lanza evento change para observar el seteado en en campo de ciudad con formato select2
                        this.$('select.newCiudad').trigger('change');
                        
                        $(".loadingIconCiudad").hide();

                    }
                }, this)
            });

        }
    },

    populateCiudadesByEstadoExisting: function (evt) {

        this.$(evt.currentTarget).parent().parent().parent().find('select.ciudadExisting').select2('val','');
        this.$(evt.currentTarget).parent().parent().parent().find('select.ciudadExisting').empty();
        this.$(evt.currentTarget).parent().parent().parent().find('select.municipioExisting').select2('val','');
        this.$(evt.currentTarget).parent().parent().parent().find('select.municipioExisting').empty();

        var id_estado = $(evt.currentTarget).val();

        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className;
        var $inputs = this.$('select.' + class_name),
        $index = $inputs.index($input);

        if (id_estado != null && id_estado != "") {
            var returnArray = this.arraySearch(this.municipios_list, id_estado, 'municipio');

            if (returnArray.length > 0) {
                for (var i = 0; i < returnArray.length; i++) {

                    this.$(evt.currentTarget).parent().parent().parent().find('select.municipioExisting').append($("<option>").val(returnArray[i].id).html(returnArray[i].name));
                }

                this.updateExistingDireccion($index, id_estado, 'estado');

                this.$(evt.currentTarget).parent().parent().parent().find('select.municipioExisting').trigger('change');

            }

            //Llamando a api para filtrar ciudades
            var strUrl = 'dire_Ciudad?filter[0][id][$starts]=' + id_estado + '&max_num=-1';

            $(evt.currentTarget).parent().parent().parent().find(".loadingIconCiudadExisting").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {
                    if (data.records.length > 0) {

                        $(evt.currentTarget).parent().parent().parent().find('select.ciudadExisting').append($("<option>").val("1").html("Seleccionar Ciudad"));
                        for (var i = 0; i < data.records.length; i++) {
                            $(evt.currentTarget).parent().parent().parent().find('select.ciudadExisting').append($("<option>").val(data.records[i].id).html(data.records[i].name));
                        }

                        //Se lanza evento change para observar el valor concatenado en campo ciudadExisting con formato select2
                        $(evt.currentTarget).parent().parent().parent().find('select.ciudadExisting').trigger('change');

                        $(evt.currentTarget).parent().parent().parent().find(".loadingIconCiudadExisting").hide();

                    }
                }, this)
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
            dirError = true;
            dirErrorCounter++;
            this.$('#s2id_tipo_multiselect_id ul').css('border-color', 'red');
        } else {
            this.$('#s2id_tipo_multiselect_id ul').css('border-color', '');
        }

        //Valida indicador
        if (this.$('#indicador_multiselect_id').val() == null || this.$('#indicador_multiselect_id').val() == "") {
            errorMsg = 'Indicador de direcci\u00F3n requerido';

            dirError = true;
            dirErrorCounter++;

            this.$('#s2id_indicador_multiselect_id ul').css('border-color', 'red');  //Validación para pintar el campo Indicador.
        } else {
            this.$('#s2id_indicador_multiselect_id ul').css('border-color', '');
            //$('#multi1').css('border-color', '');

        }

        //Valida código postal
        if (this.$('#newPostalInputTemp').val() == '') {
            errorMsg = 'C\u00F3digo postal requerido';
            dirError = true;
            dirErrorCounter++;
            this.$('#newPostalInputTemp').css('border-color', 'red');
        } else {
            this.$('#newPostalInputTemp').css('border-color', '');

        }

        //Valida extensión de código postal y valida únicamente números
        var pattern = /^\d+$/;

        if (this.$('#newPostalInputTemp').val().length != 5 || !pattern.test(this.$('#newPostalInputTemp').val())) {
            this.$('#newPostalInputTemp').css('border-color', 'red');
        } else {
            this.$('#newPostalInputTemp').css('border-color', '');

        }

        //Valida Ciudad
        if (this.$('select.newCiudad').val() == '1') {
            errorMsg = 'Favor de seleccionar una ciudad';
            dirError = true;
            dirErrorCounter++;
            this.$('.select2-container.newCiudad').children().eq(0).css('border-color', 'red');
        } else {
            this.$('.select2-container.newCiudad').children().eq(0).css('border-color', '');

        }

        //Valida colonia
        if (this.$('select.newColonia').val() == '1') {
            errorMsg = 'Favor de seleccionar una colonia';
            dirError = true;
            dirErrorCounter++;
            this.$('.select2-container.newColonia').children().eq(0).css('border-color', 'red');
        } else {
            this.$('.select2-container.newColonia').children().eq(0).css('border-color', '');

        }

        //Valida Calle
        if (this.$('.newCalle').val() == '' || this.$('.newCalle').val() == null) {
            errorMsg = 'Calle es requerida';
            dirError = true;
            dirErrorCounter++;
            this.$('.newCalle').css('border-color', 'red');
        } else {
            this.$('.newCalle').css('border-color', '');

        }

        //Valida Num Ext
        if (this.$('.newNumExt').val() == '' || this.$('.newNumExt').val() == null) {
            errorMsg = 'Numero Exterior es requerido';
            dirError = true;
            dirErrorCounter++;
            this.$('.newNumExt').css('border-color', 'red');
        } else {
            this.$('.newNumExt').css('border-color', '');

        }

        if (dirError) {
            if (dirErrorCounter > 1) errorMsg = 'Hay campos vac\u00EDos en la direcci\u00F3n.'
            app.alert.show('list_delete_direccion_info', {
                level: 'error',
                autoClose: true,
                messages: errorMsg
            });
            return;
        }

        var nuevaDir = this.$('.newCalle').val() + this.$('.newNumExt').val() + this.$('.newNumInt').val() + this.$('.newColonia').val() + this.$('.newMunicipio').val() + this.$('.newEstado').val() + this.$('.newCiudad').val();
        nuevaDir = nuevaDir.replace(/ /g, "");
        nuevaDir = nuevaDir.toUpperCase();
        var existingDir = this.direcciones;
        if (this.context.attributes.create == true && existingDir == undefined) {
            existingDir = [];
        }
        var existente = false;

        for (var i = 0; i < existingDir.length; i++) {

            var actualDir = existingDir[i].calle + existingDir[i].numext + existingDir[i].numint + existingDir[i].colonia_seleccionada + existingDir[i].municipio_seleccionado + existingDir[i].estado_seleccionado + existingDir[i].ciudad_seleccionada
            actualDir = actualDir.replace(/ /g, "");
            actualDir = actualDir.toUpperCase();
            if (actualDir == nuevaDir) {
                existente = true;
            }
        }

        if (existente) {
            app.alert.show("direcciones_duplicadas", {
                level: "error",
                title: "Existe una o mas direcciones repetidas",
                autoClose: true
            });
            return;
        }

        var lista_paises_existing = {};
        $(".newPais option").each(function () {
            lista_paises_existing[$(this).attr('value')] = $(this).html();

        });

        var lista_estados_existing = {};
        $(".newEstado option").each(function () {
            lista_estados_existing[$(this).attr('value')] = $(this).html();

        });

        var lista_municipios_existing = {};
        $(".newMunicipio option").each(function () {
            lista_municipios_existing[$(this).attr('value')] = $(this).html();

        });

        var lista_ciudades_existing = {};
        $(".newCiudad option").each(function () {
            lista_ciudades_existing[$(this).attr('value')] = $(this).html();

        });

        var lista_colonias_existing = {};
        $(".newColonia option").each(function () {
            lista_colonias_existing[$(this).attr('value')] = $(this).html();

        });


        var direccion = {
            "id": "",
            "tipo_direccion_list_hide": this.def.dir_tipo_list_html,
            "tipo_seleccionado_hide": $('.newTipodedireccion').val(),
            "tipo_direccion_list": this.tipo_direccion_list,
            "tipos_seleccionados": $('select.multi_tipo').select2('val').join(),
            "indicador_list_hide": this.def.indicador_html,
            "indicador_seleccionado_hide": $('.newIndicador').val(),
            "indicador_list": this.indicador_list,
            "indicadores_seleccionados": $('select.multi1_n').select2('val').join(),
            "lista_paises_existing": lista_paises_existing,
            "pais_seleccionado": $('.newPais').select2('val'),
            "lista_estados_existing": lista_estados_existing,
            "estado_seleccionado": $('.newEstado').select2('val'),
            "lista_municipios_existing": lista_municipios_existing,
            "municipio_seleccionado": $('.newMunicipio').select2('val'),
            "lista_ciudades_existing": lista_ciudades_existing,
            "ciudad_seleccionada": $('.newCiudad').select2('val'),
            "lista_colonias_existing": lista_colonias_existing,
            "colonia_seleccionada": $('.newColonia').select2('val'),
            "codigo_postal": $('.newPostalInputTemp').val(),
            "postal_hidden": $('#newPostalHidden').val(),
            "calle": $('.newCalle').val(),
            "numext": $('.newNumExt').val(),
            "numint": $('.newNumInt').val(),
            "principal": false,
            "inactivo": false
        };

        //Obteniendo posición de dirección añadida
        var indexInsert = this.direcciones.push(direccion) - 1;
        if (this.direcciones.length === 1 && indexInsert == 0) {
            this.direcciones[indexInsert].principal = true;
        }
        var tipos_seleccionados = $('select.multi_tipo').select2('val');
        var indicadores_seleccionados = $('select.multi1_n').select2('val');
        
        //Agregando nuevo valor al modelo
        this.model.set('account_direcciones', this.direcciones);
        
        this.render();

        //Estableciendo valores para campos de Tipo y Tipo de dirección
        $('select.multi_tipo_existing').each(function () {
            //Obtener valores de los hiden
            var tipos_seleccionados = $(this).next().val();
            $(this).select2('val', tipos_seleccionados.split(","));
        });

        //multi1_n_existing
        $('select.multi1_n_existing').each(function () {
            //Obtener valores de los hiden
            var indicadores_seleccionados = $(this).next().val();
            $(this).select2('val', indicadores_seleccionados.split(","));
        });

    },

    checkcallenum: function (evt) {
        var limite = this.limitto100(evt);
        if (limite == false) {
            return false;
        }
    },

    checknumint: function (evt) {
        var limite = this.limitto50(evt);
        if (limite == false) {
            return false;
        }
    },

    limitto100: function (evt) {
        if (!evt) return;
        //get field that changed
        var $input = this.$(evt.currentTarget);

        var direccion = $input.val();

        if (direccion.length > 99 && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
            return false;
        }
    },

    limitto50: function (evt) {
        if (!evt) return;
        //get field that changed
        var $input = this.$(evt.currentTarget);
        var direccion = $input.val();
        if (direccion.length > 49 && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
            return false;
        }
    },

    /**
     * Establece campo original de Tipo de Dirección depende el valor del campo multiselect
     * @param  {object} evt, Objeto que contiene información del evento
     */
    updateValueTipoMultiselect: function (evt) {

        var $input = this.$(evt.currentTarget).siblings('select');
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            $index = $inputs.index($input),
            dropdown_value = $input.val();

        var valores = evt.val;
        var id = this._getTipoDireccion(null, valores)
        //Estableciendo valores para solo 1 valor seleccionado
        $(evt.currentTarget).siblings('select').val(id);
        var nuevo_valor = $(evt.currentTarget).siblings('select').val();
        //$('.newTipodedireccion').val(id);
        //$('.newTipodedireccion').trigger("change");
        this.updateExistingDireccion($index, nuevo_valor, 'tipo');

    },

    /**
     * Establece campo original de Indicador depende el valor del campo multiselect
     * @param  {object} evt, Objeto que contiene información del evento
     */
    updateValueIndicadorMultiselect: function (evt) {
        //this.$('.select2-container-multi').attr('style', 'width: 100%');
        //this.$('.select2-container-multi').addClass("select2-choices-pills-close");
        var valores = evt.val;
        var id = this._getIndicador(null, valores)
        //Estableciendo valores para solo 1 valor seleccionado
        $(evt.currentTarget).siblings('select').val(id)
        //$('.newIndicador').val(id);
        //$('.newIndicador').trigger("change");
        //Trigger que obliga a ejecutar la función updateIndicadores
        $(evt.currentTarget).siblings('select').trigger("change");

    },

    _getTipoDireccion: function (idSelected, valuesSelected) {

        //variable con resultado
        var result = null;

        //Arma objeto de mapeo
        var tipo_dir_map_list = App.lang.getAppListStrings('tipo_dir_map_list');

        var element = {};
        var object = [];
        var values = [];

        for (var key in tipo_dir_map_list) {
            var element = {};
            element.id = key;
            values = tipo_dir_map_list[key].split(",");
            element.values = values;
            object.push(element);
        }

        //Recupera arreglo de valores por id
        if (idSelected) {
            for (var i = 0; i < object.length; i++) {
                if ((object[i].id) == idSelected) {
                    result = object[i].values;
                }
            }
        }

        //Recupera id por valores
        if (valuesSelected) {
            result = [];
            for (var i = 0; i < object.length; i++) {
                if (object[i].values.length == valuesSelected.length) {
                    //Ordena arreglos y compara
                    valuesSelected.sort();
                    object[i].values.sort();
                    var tempVal = true;
                    for (var j = 0; j < valuesSelected.length; j++) {
                        if (valuesSelected[j] != object[i].values[j]) {
                            tempVal = false;
                        }
                    }
                    if (tempVal == true) {
                        result[0] = object[i].id;
                    }

                }
            }

        }

        return result;
    },

    /**
     * Establece identificador dependiendo "id"
     * @param  {string} idSelected, valor en campo indicador
     * @param  {object} valueSelected, valores en campo multiselect
     * @return  {array}, valor(es) a establecer en campo indicador
     */
    _getIndicador: function (idSelected, valuesSelected) {

        //variable con resultado
        var result = null;

        //Arma objeto de mapeo
        var dir_indicador_map_list = App.lang.getAppListStrings('dir_indicador_map_list');

        var element = {};
        var object = [];
        var values = [];

        for (var key in dir_indicador_map_list) {
            var element = {};
            element.id = key;
            values = dir_indicador_map_list[key].split(",");
            element.values = values;
            object.push(element);
        }

        //Recupera arreglo de valores por id
        if (idSelected) {
            for (var i = 0; i < object.length; i++) {
                if ((object[i].id) == idSelected) {
                    result = object[i].values;
                }
            }
        }

        //Recupera id por valores
        if (valuesSelected) {
            result = [];
            for (var i = 0; i < object.length; i++) {
                if (object[i].values.length == valuesSelected.length) {
                    //Ordena arreglos y compara
                    valuesSelected.sort();
                    object[i].values.sort();
                    var tempVal = true;
                    for (var j = 0; j < valuesSelected.length; j++) {
                        if (valuesSelected[j] != object[i].values[j]) {
                            tempVal = false;
                        }
                    }
                    if (tempVal == true) {
                        result[0] = object[i].id;
                    }

                }
            }

        }

        return result;
    },

    updateIndicadores: function (evt) {
        this.updateIndicadorFiscal(evt);
        this.updateIndicadorAdmin(evt);
    },
    /** BEGIN CUSTOMIZATION: jescamilla@levementum.com 6/18/2015 Description: detect multiple fiscal address*/
    updateIndicadorFiscal: function (evt) {

        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            $index = $inputs.index($input),
            dropdown_value = $input.val(),
            primaryRemoved;

        //contar las direcciones fiscales existentes
        var fiscalCounter = 0;
        this.$('.existingIndicador').each(function () {
            if (String($(this).find('option:selected').text()).toLowerCase().indexOf('fiscal') >= 0) {
                fiscalCounter = parseInt(fiscalCounter + 1);
            }

        });

        if (dropdown_value == "") {
            this.counterEmptyFields++;
        }

        //contar las direcciones fiscales nuevas
        this.$('.newIndicador').each(function () {
            if (String($(this).find('option:selected').text()).toLowerCase().indexOf('fiscal') >= 0) {
                fiscalCounter = parseInt(fiscalCounter + 1);
            }
        });

        this.fiscalCounter = fiscalCounter;

        if (this.fiscalCounter > 1) {
            var alertOptions = {title: "M\u00FAltiples direcciones fiscales, favor de corregir.", level: "error"};
            app.alert.show('validation', alertOptions);
            $input.val('');
            //evt.target.parentElement.previousElementSibling.children[1].value='';

            //Obtener valores de multiselect
            var valores = $(evt.currentTarget).siblings('select').val();

            //Obteniendo índice de "Fiscal"
            var index = valores.indexOf("2");
            //Eliminando el valor "Fiscal" del arreglo
            valores.splice(index, 1);
            //Estableciendo nuevo arreglo a campo multiselect (sin "Fiscal")
            $(evt.currentTarget).siblings('select').select2('val', valores);
            $(evt.currentTarget).val(this._getIndicador(null, valores));

            //Obteniendo valores multiselect existing
            /*
             var valoresExisting = $(evt.target).parent().parent().find('select.multi1_n').select2('val');
             var indexExisting = valoresExisting.indexOf("2");
             valoresExisting.splice(indexExisting, 1);
             $(evt.target).parent().parent().find('select.multi1_n').select2('val', valoresExisting);
             $(evt.target).val(this._getIndicador(null, valoresExisting));
             */

            $input.focus();
            this.fiscalCounter = 0;
        } else {
            if ($input.attr('class') == 'existingIndicador') {
                this.updateExistingDireccion($index, dropdown_value, 'indicador');
            }
        }
        /* END CUSTOMIZATION */
    },

    updateIndicadorAdmin: function (evt) {

        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            $index = $inputs.index($input),
            dropdown_value = $input.val(),
            primaryRemoved;

        //contar las direcciones Administrativas existentes
        var adminCounter = 0;
        this.$('.existingIndicador').each(function () {
            if (String($(this).find('option:selected').text()).toLowerCase().indexOf('administraci\u00F3n') >= 0) {
                adminCounter = parseInt(adminCounter + 1);
            }

        });

        if (dropdown_value == "") {
            this.counterEmptyFields++;
        }

        //contar las direcciones Administrativas nuevas
        this.$('.newIndicador').each(function () {
            if (String($(this).find('option:selected').text()).toLowerCase().indexOf('administraci\u00F3n') >= 0) {
                adminCounter = parseInt(adminCounter + 1);
            }
        });

        this.adminCounter = adminCounter;

        if (this.adminCounter > 1) {
            var alertOptions = {
                title: "M\u00FAltiples direcciones administrativas, favor de corregir.",
                level: "error"
            };
            app.alert.show('validation2', alertOptions);
            $input.val('');
            //evt.target.parentElement.previousElementSibling.children[1].value='';

            //Obtener valores de multiselect
            var valores = $(evt.currentTarget).siblings('select').val();

            //Obteniendo índice de "Administracion"
            var index = valores.indexOf("5");
            //Eliminando el valor "Administracion" del arreglo
            valores.splice(index, 4);
            //Estableciendo nuevo arreglo a campo multiselect (sin "Administracion")
            $(evt.currentTarget).siblings('select').select2('val', valores);
            $(evt.currentTarget).val(this._getIndicador(null, valores));

            //Obteniendo valores multiselect existing
            /*
             var valoresExisting = $(evt.target).parent().parent().find('select.multi1_n_existing').select2('val');
             var indexExisting = valoresExisting.indexOf("5");
             valoresExisting.splice(indexExisting, 4);
             $(evt.target).parent().parent().find('select.multi1_n_existing').select2('val', valoresExisting);
             $(evt.target).val(this._getIndicador(null, valoresExisting));
             */

            $input.focus();
            this.adminCounter = 0;
        } else {
            if ($input.attr('class') == 'existingIndicador') {
                this.updateExistingDireccion($index, dropdown_value, 'indicador');
            }
        }
        /* END CUSTOMIZATION */
    },

    updateExistingCiudad: function (evt) {

        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className;
        var $inputs = this.$('select.' + class_name),
            $index = $inputs.index($input),
            nuevo_valor = $input.val();

        this.updateExistingDireccion($index, nuevo_valor, 'ciudad');

    },

    updateExistingColonia: function (evt) {

        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className;
        var $inputs = this.$('select.' + class_name),
            $index = $inputs.index($input),
            nuevo_valor = $input.val();

        this.updateExistingDireccion($index, nuevo_valor, 'colonia');

    },

    updateExistingInputs: function (evt) {

        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].classList[0],
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            $index = $inputs.index($input),
            nuevo_valor = $input.val();

        this.updateExistingDireccion($index, nuevo_valor, field_name);

    },

    updateExistingDireccion: function (index, nuevo_valor, field_name) {

        if (field_name == 'tipo') {
            this.direcciones[index].tipo_seleccionado_hide = nuevo_valor;
        }

        if (field_name == 'indicador') {
            this.direcciones[index].indicador_seleccionado_hide = nuevo_valor;
        }

        if(field_name =='codigopostal'){
            this.direcciones[index].codigo_postal = nuevo_valor;
        }

        if(field_name =='codigopostalhidden'){
            this.direcciones[index].postal_hidden = nuevo_valor;
        }

        if(field_name =='pais'){
            this.direcciones[index].pais_seleccionado = nuevo_valor;
        }

        if(field_name =='estado'){
            this.direcciones[index].estado_seleccionado = nuevo_valor;
        }

        if(field_name =='municipio'){
            this.direcciones[index].municipio_seleccionado = nuevo_valor;
        }

        if(field_name =='ciudad'){
            this.direcciones[index].ciudad_seleccionada = nuevo_valor;
        }

        if(field_name =='colonia'){
            this.direcciones[index].colonia_seleccionada = nuevo_valor;
        }

        if (field_name == 'calle') {
            this.direcciones[index].calle = nuevo_valor;
        }

        if (field_name == 'numext') {
            this.direcciones[index].numext = nuevo_valor;
        }

        if (field_name == 'numint') {
            this.direcciones[index].numint = nuevo_valor;
        }

        this.model.set('account_direcciones',this.direcciones);
    },

    _doValidateEmptyTipo: function (fields, errors, callback) {
        if (this.counterTipoVacio > 0) {

            var alertOptions = {title: "Tipo de direcci\u00F3n requerido", level: "error"};
            app.alert.show('validation_tipo', alertOptions);
            $('select.existingTipodedireccion').each(function () {
                if ($(this).val() == null || $(this).val() == "") {
                    $(this).next().find('ul').css('border-color', 'red');
                } else {
                    $(this).next().find('ul').css('border-color', '');
                }
            });

            //Se establece un atributo (no existente) en array de errors, para detener la ejecución de guardado y no pintar ningún campo del modelo
            // ya que estos se pintan con jquery
            errors['account_direcciones_'] = errors['account_direcciones_'] || {};
            errors['account_direcciones_'].required = true;
        }

        callback(null, fields, errors);
    },

    _doValidateDireccionFiscal: function (fields, errors, callback) {
        if (this.fiscalCounter > 1) {

            var alertOptions = {title: "M\u00FAltiples direcciones fiscales, favor de corregir.", level: "error"};
            app.alert.show('validation', alertOptions);

            errors['account_direcciones'] = errors['account_direcciones'] || {};
            errors['account_direcciones'].required = true;
        }

        callback(null, fields, errors);
    },

    _doValidateDireccionFiscalCorrespondencia: function (fields, errors, callback) {

        //if(this.counterEmptyFields==0){

        if (this.model.get("tipo_registro_c") == "Cliente" || this.model.get("subtipo_cuenta_c") == "Integracion de Expediente" || this.model.get("subtipo_cuenta_c") == "Credito") {
            var correspondencia = false;
            var fiscal = false;
            var valuesI = [];
            var self = this;
            _.each(this.model.get("account_direcciones"), function (direccion, key) {

                //Recupera valores por indicador
                valuesI = self._getIndicador(direccion.indicador_seleccionado_hide, null);
                //Valida Fiscal
                if (valuesI.includes("2")) {
                    fiscal = true;
                }
                //Valida Correspondencia
                if (valuesI.includes("1")) {
                    correspondencia = true;
                }


            });

            if (fiscal == false || correspondencia == false) {
                var alertOptions = {
                    title: "Se requiere de al menos una direcci\u00F3n fiscal y una de correspondencia.",
                    level: "error"
                };
                app.alert.show('validation', alertOptions);
                errors['account_direcciones'] = errors['account_direcciones'] || {};
                errors['account_direcciones'].required = true;
            }
        }

        //}

        callback(null, fields, errors);
    },

    /*
     * Recorre arreglo this.direcciones para guardar relación con Cuentas
     */
    almacenaDirecciones: function (fields, errors, callback) {

        this.model.set('account_direcciones', this.direcciones);

        callback(null, fields, errors);
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

    /**
     * Called when formatting the value for display
     * @param value
     */
    format: function(value) {
        console.log('FORMAT DESDE DIRECCIONES');
        return this._super('format', [value]);
    },

    /**
     * Called when unformatting the value for storage
     * @param value
     */
    unformat: function(value) {
        console.log('UNFORMAT DESDE DIRECCIONES');
        return this._super('unformat', [value]);
    }

})