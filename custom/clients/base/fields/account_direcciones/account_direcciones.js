/**
 * @file   custom/clients/base/fields/account_direcciones/account_direcciones.js
 * @author trobinson@levementum.com
 * @date   6/9/2015 4:07 PM
 * @brief  js for custom accounts direcciones field
 */
({
    // CustomAccount_direcciones Field (base)

    events: {
        'change .existingTipodedireccion': 'updateExistingDireccion',
        'keydown .existingCalle': 'checkcallenum',
        'keydown .existingNumInt': 'checknumint',
        'keydown .existingNumExt': 'checkcallenum',
        'keydown .newCalle': 'limitto100',
        'keydown .newNumInt': 'limitto50',
        'keydown .newNumExt': 'limitto100',        
        'blur .existingCalle': 'checkcallenum',
        'blur .existingNumInt': 'checknumint',
        'blur .existingNumExt': 'checkcallenum',
        'blur .newCalle': 'limitto100',
        'blur .newNumInt': 'limitto50',
        'blur .newNumExt': 'limitto100',
        'change .existingPais': 'updateExistingDireccionDropdown',
        'change .existingEstado': 'updateExistingDireccionDropdown',
        //'change .existingIndicador': 'updateIndicador',
        //'change .newIndicador': 'updateIndicador',
        'change .existingIndicador': 'updateIndicadores',
        'change .newIndicador': 'updateIndicadores',
        'change .existingMunicipio': 'updateExistingDireccionDropdown',
        'change .existingCiudad': 'updateExistingDireccionDropdown',
        'change .existingPostal': 'updateExistingDireccionDropdown',
        'click  .btn-edit': 'toggleExistingDireccionProperty',
        'click  .removeDireccion': 'removeExistingDireccion',
        'click  .addDireccion': 'addNewDireccion',
        'change .newPaisDir': 'updateExistingDireccionDropdown',
        'change .newEstado': 'updateExistingDireccionDropdown',
        'change .newMunicipio': 'updateExistingDireccionDropdown',
        'change .newCiudad': 'updateExistingDireccionDropdown',
        'change .newPostal': 'updateExistingDireccionDropdown',
        'change .newColonia': 'updateExistingDireccionDropdown',
        'change .existingColonia': 'updateExistingDireccionDropdown',
        'change #multi1': 'updateValueIndicadorMultiselect',
        'change select.existingMultiClass': 'updateValueIndicadorExisting',
        //Declarando eventos para redisño de direcciones
        //Author: Salvador Lopez <salvador.lopez@tactos.com.mx>
        'change #postalInputTemp': 'getInfoAboutCP',
        'change #existingPostalInput': 'getInfoAboutCPExisting',

        //Eventos change para actualizar valores de direcciones existentes

        'change #existingPostalHidden': 'updateExistingDireccionDropdown',
        'change .existingPaisTemp': 'updateExistingDireccionDropdown',
        'change .existingEstadoTemp': 'updateExistingDireccionDropdown',
        'change .existingMunicipioTemp': 'updateExistingDireccionDropdown',
        'change .existingCiudadTemp': 'updateExistingDireccionDropdown',
        'change .existingColoniaTemp': 'updateExistingDireccionDropdown',


    },
    _flag2Deco: {
        principal: {lbl: "LBL_DIRECCION_PRIMARY", cl: "primary"},
        opt_out: {lbl: "LBL_DIRECCION_OPT_OUT", cl: "opted-out"},
        invalid_direccion: {lbl: "LBL_DIRECCION_INVALID", cl: "invalid"}
    },
    plugins: ['Tooltip', 'ListEditable'],


    /**
     * @inheritdoc
     * @param options
     */
    initialize: function (options) {
        self = this;
        options = options || {};
        options.def = options.def || {};

        // By default, compose direccion link should be allowed
        if (_.isUndefined(options.def.direccionLink)) {
            options.def.direccionLink = true;
        }

        if (options.view.action === 'filter-rows') {
            options.viewName = 'filter-rows-edit';
        }

        this._super('initialize', [options]);
        //*
        //get related direcciones trobinson@levementum.com
        var dir_tipo_list = app.lang.getAppListStrings('tipodedirecion_list');
        var dir_tipo_keys = app.lang.getAppListKeys('tipodedirecion_list');
        var dir_tipo_list_html = '';
        //dynamicly populate dropdown options based on language values
        for (dir_tipo_key in dir_tipo_list) {
            dir_tipo_list_html += '<option value="' + dir_tipo_key + '">' + dir_tipo_list[dir_tipo_key] + '</option>'

        }
        this.def.dir_tipo_list_html = dir_tipo_list_html;

        //build the country list
        var country_list = app.metadata.getCountries();
        var pais_list_html = '<option value=""></option>';
        for (var key in country_list) {
            pais_list_html += '<option value="' + country_list[key].id + '" >' + country_list[key].name + '</option>'
        }

        //Añadiendo opciones para códigos postales
        var postal_list = app.metadata.getPostalCodes();
        var postal_list_html = '<option value=""></option>';
        for (var key in postal_list) {
            postal_list_html += '<option value="' + postal_list[key].id + '" >' + postal_list[key].name + '</option>'
        }

        this.def.pais_list_html = pais_list_html;
        this.def.estado_html = '<option value="">Seleccionar Estado </option>';
        this.def.municipio_html = '<option value="">Seleccionar Municipio </option>';
        this.def.postal_html = '<option value="">Seleccionar Codigo Postal </option>';
        this.def.postal_htmlTemp = postal_list_html;

        /*
         this.def.postal_list_global=postal_list;

         var lista_global_cps=this.def.postal_list_global;

         var newArr=[];
         for (var key in lista_global_cps) {
         if (lista_global_cps.hasOwnProperty(key)) {
         newArr.push(lista_global_cps[key]);
         }
         }

         this.def.dataNew=[];
         for(var i=0;i<newArr.length;i++) {
         var item = {};
         item.id = newArr[i].id;
         item.text = newArr[i].name;
         this.def.dataNew.push(item);
         }
         */

        var dir_indicador_list = app.lang.getAppListStrings('dir_Indicador_list');
        var indicador_options = '<option value=""></option>'
        for (indicador_id in dir_indicador_list) {
            indicador_options += '<option value="' + indicador_id + '" >' + dir_indicador_list[indicador_id] + '</option>';
        }
        this.def.indicador_html = indicador_options;

        //Indicador multiselect
        var dir_indicador_unique_list = app.lang.getAppListStrings('dir_indicador_unique_list');
        var indicador_multi_options = '<option value=""></option>'
        for (indicador_id in dir_indicador_unique_list) {
            indicador_multi_options += '<option value="' + indicador_id + '" >' + dir_indicador_unique_list[indicador_id] + '</option>';
        }
        this.def.indicador_multi_html = indicador_multi_options;

        //*
        var fields = ['id', 'name', 'calle', 'inactivo', 'numext', 'numint', 'indicador', 'principal', 'secuencia', 'tipodedireccion'
            , 'dire_direccion_dire_ciudaddire_ciudad_ida', 'dire_direccion_dire_codigopostaldire_codigopostal_ida', 'dire_direccion_dire_coloniadire_colonia_ida',
            'dire_direccion_dire_estadodire_estado_ida', 'dire_direccion_dire_municipiodire_municipio_ida', 'dire_direccion_dire_paisdire_pais_ida'];
        //api request apamaters
        var api_params = {
            'fields': fields.join(','),
            'max_num': 42,
            'order_by': 'date_entered:desc',
            'filter': [{'accounts_dire_direccion_1accounts_ida': this.model.id}]
        };
        var pull_direccion_url = app.api.buildURL('dire_Direccion',
            null, null, api_params);

        app.api.call('READ', pull_direccion_url, {}, {
            success: function (data) {
                //get mapping arrays and keys
                var dir_tipo_list = app.lang.getAppListStrings('tipodedirecion_list');
                var dir_tipo_keys = app.lang.getAppListKeys('tipodedirecion_list');
                var dir_indicador_list = app.lang.getAppListStrings('dir_Indicador_list');
                var country_list = app.metadata.getCountries();
                var estado_list = app.metadata.getStates();
                var municipio_list = app.metadata.getMunicipalities();
                var city_list = app.metadata.getCities();
                var postal_list = app.metadata.getPostalCodes();
                for (var i = 0; i < data.records.length; i++) {
                    //populate fields to match id
                    data.records[i].pais = data.records[i].dire_direccion_dire_paisdire_pais_ida;
                    data.records[i].estado = data.records[i].dire_direccion_dire_estadodire_estado_ida;
                    data.records[i].municipio = data.records[i].dire_direccion_dire_municipiodire_municipio_ida;
                    data.records[i].ciudad = data.records[i].dire_direccion_dire_ciudaddire_ciudad_ida;
                    data.records[i].codigopostal = data.records[i].dire_direccion_dire_codigopostaldire_codigopostal_ida;
                    data.records[i].postal = data.records[i].dire_direccion_dire_codigopostaldire_codigopostal_ida;
                    data.records[i].colonia = data.records[i].dire_direccion_dire_coloniadire_colonia_ida;
                    //self.value[i] = data.records[i].direccion;
                    //handle dirrection list now that it changed keys
                    data.records[i].tipo_label = '';
                    for (dir_tipo_key in dir_tipo_list) {
                        if ($.inArray(dir_tipo_key, data.records[i].tipodedireccion) != -1) {
                            if (data.records[i].tipo_label != '') {
                                data.records[i].tipo_label += ', '
                            }
                            data.records[i].tipo_label += dir_tipo_list[dir_tipo_key];

                        }

                    }
                    for (a_country in country_list) {
                        if (country_list[a_country].id == data.records[i].dire_direccion_dire_paisdire_pais_ida) {
                            data.records[i].country_code_label = country_list[a_country].name;
                        }
                    }
                    for (a_estado in estado_list) {
                        if (a_estado == data.records[i].dire_direccion_dire_estadodire_estado_ida) {
                            data.records[i].estado_code_label = estado_list[a_estado].name;
                        }
                    }
                    for (a_municipio in municipio_list) {
                        if (a_municipio == data.records[i].dire_direccion_dire_municipiodire_municipio_ida) {
                            data.records[i].municipio_code_label = municipio_list[a_municipio].name;
                        }
                    }
                    for (a_ciudad in city_list) {
                        if (a_ciudad == data.records[i].dire_direccion_dire_ciudaddire_ciudad_ida) {
                            data.records[i].ciudad_label = city_list[a_ciudad].name;
                        }
                    }
                    for(a_codigopostal in postal_list){
                        if(a_codigopostal == data.records[i].dire_direccion_dire_codigopostaldire_codigopostal_ida){
                            data.records[i].postal_code_label = postal_list[a_codigopostal].name;
                            // console.log("Cuando se inicializa el record");
                            //console.log(data.records[i].postal_code_label);
                        }
                    }

                    //if (data.records[i].dire_direccion_dire_codigopostaldire_codigopostal_ida != '') {
                    //    data.records[i].postal_code_label = postal_list[data.records[i].dire_direccion_dire_codigopostaldire_codigopostal_ida].name;
                    //}

                    //Get all colonias according to the Postal ID if populated
                    data.records[i].colonia_html = '<option value=""></option>';


                    for (indicador_code in dir_indicador_list) {
                        if (indicador_code == data.records[i].indicador) {
                            data.records[i].indicador_label = dir_indicador_list[indicador_code];
                        }
                    }


                }
                //set model so tpl detail tpl can read data
                self.model.set('account_direcciones', data.records);
                self.model._previousAttributes.account_direcciones = data.records;
                self.model._syncedAttributes.account_direcciones = data.records;
                self.format();
                self._render();

            }
        });

        this.fiscalCounter = 0;

        this.counterEmptyFields=0;

        this.model.addValidationTask('check_multiple_fiscal', _.bind(this._doValidateDireccionFiscal, this));
        this.model.addValidationTask('check_multiple_fiscalCorrespondencia', _.bind(this._doValidateDireccionFiscalCorrespondencia, this));
        //Ajuste Dirección Nacional
        this.model.addValidationTask('check_direccion_nacional', _.bind(this._doValidateDireccionNacional, this));
    },

    /**
     * Establece campo original de Indicador depende el valor del campo multiselect
     * @param  {object} evt, Objeto que contiene información del evento
     */
    updateValueIndicadorMultiselect:function (evt) {
        var valores=evt.val;
        var id= this._getIndicador(null,valores)
        //Estableciendo valores para solo 1 valor seleccionado
        $('.newIndicador').val(id);
        $('.newIndicador').trigger("change");

    },

    /**
     * Establece campo original de Indicador en direcciones ya agregadas dependiendo el valor del campo multiselect
     * @param  {object} evt, Objeto que contiene información del evento
     */
    updateValueIndicadorExisting:function (evt) {
        var valorEx=evt.val;
        var id = this._getIndicador(null,valorEx)
        evt.target.parentElement.children[1].value=id;
        $(evt.target).parent().parent().find('.existingIndicador').trigger('change');

    },
    updateIndicadores:function (evt) {
        this.updateIndicador(evt);
        this.updateIndicador2(evt);
    },
    /** BEGIN CUSTOMIZATION: jescamilla@levementum.com 6/18/2015 Description: detect multiple fiscal address*/
    updateIndicador: function (evt) {

        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            index = $inputs.index($input),
            dropdown_value = $input.val(),
            primaryRemoved;

        //contar las direcciones fiscales existentes
        var fiscalCounter = 0;
        $('.existingIndicador').each(function(){
            if (String($(this).find('option:selected').text()).toLowerCase().indexOf('fiscal') >= 0) {
                fiscalCounter = parseInt(fiscalCounter + 1);
            }

        });

        if(dropdown_value==""){
            this.counterEmptyFields++;
        }

        //contar las direcciones fiscales nuevas
        $('.newIndicador').each(function(){
            if (String($(this).find('option:selected').text()).toLowerCase().indexOf('fiscal') >= 0) {
                fiscalCounter = parseInt(fiscalCounter + 1);
            }
        });

        this.fiscalCounter = fiscalCounter;

        if (this.fiscalCounter > 1) {
            var alertOptions = {title: "Multiples direcciones fiscales, favor de corregir.", level: "error"};
            app.alert.show('validation', alertOptions);
            $input.val('');
            //evt.target.parentElement.previousElementSibling.children[1].value='';

            //Obtener valores de multiselect
            var valores= $("#multi1").select2('val');

            //Obteniendo índice de "Fiscal"
            var index = valores.indexOf("2");
            //Eliminando el valor "Fiscal" del arreglo
            valores.splice(index,1);
            //Estableciendo nuevo arreglo a campo multiselect (sin "Fiscal")
            $("#multi1").select2('val',valores);
            $('.newIndicador').val(this._getIndicador(null,valores));

            //Obteniendo valores multiselect existing
            var valoresExisting=$(evt.target).parent().parent().find('select.existingMultiClass').select2('val');
            var indexExisting=valoresExisting.indexOf("2");
            valoresExisting.splice(indexExisting,1);
            $(evt.target).parent().parent().find('select.existingMultiClass').select2('val',valoresExisting);
            $(evt.target).val(this._getIndicador(null,valoresExisting));

            $input.focus();
            this.fiscalCounter = 0;
        } else {
            if($input.attr('class') == 'existingIndicador'){
                this._updateExistingDireccionInModel(index, dropdown_value, 'indicador');
            }
        }
        /* END CUSTOMIZATION */
    },

    updateIndicador2: function (evt) {

        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            index = $inputs.index($input),
            dropdown_value = $input.val(),
            primaryRemoved;

        //contar las direcciones Administrativas existentes
        var adminCounter = 0;
        $('.existingIndicador').each(function(){
            if (String($(this).find('option:selected').text()).toLowerCase().indexOf('administraci\u00F3n') >= 0) {
                adminCounter = parseInt(adminCounter + 1);
            }

        });

        if(dropdown_value==""){
            this.counterEmptyFields++;
        }

        //contar las direcciones Administrativas nuevas
        $('.newIndicador').each(function(){
            if (String($(this).find('option:selected').text()).toLowerCase().indexOf('administraci\u00F3n') >= 0) {
                adminCounter = parseInt(adminCounter + 1);
            }
        });

        this.adminCounter = adminCounter;

        if (this.adminCounter > 1) {
            var alertOptions = {title: "Multiples direcciones administrativas, favor de corregir.", level: "error"};
            app.alert.show('validation2', alertOptions);
            $input.val('');
            //evt.target.parentElement.previousElementSibling.children[1].value='';

            //Obtener valores de multiselect
            var valores= $("#multi1").select2('val');

            //Obteniendo índice de "Administracion"
            var index = valores.indexOf("5");
            //Eliminando el valor "Administracion" del arreglo
            valores.splice(index,4);
            //Estableciendo nuevo arreglo a campo multiselect (sin "Administracion")
            $("#multi1").select2('val',valores);
            $('.newIndicador').val(this._getIndicador(null,valores));

            //Obteniendo valores multiselect existing
            var valoresExisting=$(evt.target).parent().parent().find('select.existingMultiClass').select2('val');
            var indexExisting=valoresExisting.indexOf("5");
            valoresExisting.splice(indexExisting,4);
            $(evt.target).parent().parent().find('select.existingMultiClass').select2('val',valoresExisting);
            $(evt.target).val(this._getIndicador(null,valoresExisting));

            $input.focus();
            this.adminCounter = 0;
        } else {
            if($input.attr('class') == 'existingIndicador'){
                this._updateExistingDireccionInModel(index, dropdown_value, 'indicador');
            }
        }
        /* END CUSTOMIZATION */
    },
    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 7/9/2015 Description: Validacion, No debe de haber mas de una direccion fiscal */

    _doValidateDireccionNacional: function (fields, errors, callback) {
        if(this.model.get('tipodepersona_c') != 'Persona Moral') {

            console.log('Validación Nacional');
            console.log(this.name);

            // var alertOptions = {title: "Multiples direcciones fiscales, favor de corregir.", level: "error"};
            // app.alert.show('validation', alertOptions);

            // errors['account_direcciones'] = errors['account_direcciones'] || {};
            // errors['account_direcciones'].required = true;
        }

        callback(null, fields, errors);
    },

    _doValidateDireccionFiscal: function (fields, errors, callback) {
        if (this.fiscalCounter > 1) {

            var alertOptions = {title: "Multiples direcciones fiscales, favor de corregir.", level: "error"};
            app.alert.show('validation', alertOptions);

            errors['account_direcciones'] = errors['account_direcciones'] || {};
            errors['account_direcciones'].required = true;
        }

        callback(null, fields, errors);
    },

    _doValidateDireccionFiscalCorrespondencia: function (fields, errors, callback){

        if(this.counterEmptyFields==0){

            if(this.model.get("tipo_registro_c") == "Cliente" || this.model.get("subtipo_cuenta_c") == "Integracion de Expediente" || this.model.get("subtipo_cuenta_c") == "Credito")
            {
                var correspondencia = false;
                var fiscal = false;
                var valuesI = [];
                var self = this;
                _.each(this.model.get("account_direcciones"), function(direccion, key) {

                    //Recupera valores por indicador
                    valuesI = self._getIndicador(direccion.indicador,null);
                    //Valida Fiscal
                    if(valuesI.includes("2")){
                        fiscal = true;
                    }
                    //Valida Correspondencia
                    if(valuesI.includes("1")){
                        correspondencia = true;
                    }

                    /*if(direccion.indicador == "1"){
                     correspondencia = true;
                     }
                     if(direccion.indicador == "5"){
                     correspondencia = true;
                     }
                     if(direccion.indicador == "2"){
                     fiscal = true;
                     }
                     if(direccion.indicador == "6"){
                     fiscal = true;
                     }
                     if(direccion.indicador == "3"){
                     fiscal = true;
                     correspondencia = true;
                     }
                     if(direccion.indicador == "7"){
                     fiscal = true;
                     correspondencia = true;
                     }*/

                });

                if(fiscal == false || correspondencia == false){
                    var alertOptions = {title: "Se requiere de al menos una direccion fiscal y una de correspondencia.", level: "error"};
                    app.alert.show('validation', alertOptions);
                    errors['account_direcciones'] = errors['account_direcciones'] || {};
                    errors['account_direcciones'].required = true;
                }
            }

        }

        callback(null, fields, errors);
    },

    /**
     * @author trobinson@levementum.com
     * @date   6/10/11
     * @brief  on change update child dropdown value
     *
     * @param  n/a
     * @return updates dropdown html
     */
    updateExistingDireccionDropdown: function (evt) {
        if (!evt) return;

        console.log("LANZANDO DESDE "+this.$(evt.currentTarget).attr('data-field'));
        //get field that changed
        var $input = this.$(evt.currentTarget);
        //get field type
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            index = $inputs.index($input),
            dropdown_value = $input.val(),
            primaryRemoved;
        var codigo_postal_list=app.metadata.getPostalCodes();
        var paises_list=app.metadata.getCountries();
        var municipios_list=app.metadata.getMunicipalities();

        //update state dropdown when country changes
        if (field_name == 'pais') {
            console.log("Pais");
            //debuger;
            var country_list = app.metadata.getCountries();
            var pais_id = country_list[dropdown_value].id;
            //clear child options
            var $selEstado = $input.closest('td').next().find("[placeholder='estado']");
            $selEstado.empty();
            var $codigoPostal = $input.parent().parent().parent().find("[placeholder='Codigo Postal']");
            $codigoPostal.empty();
            var $selColonia = $input.parent().parent().parent().find("[placeholder='colonia']");
            $selColonia.empty();
            //get states
            var state_list = app.metadata.getStates();
            //add correct options
            $selEstado.append($("<option>").val('').html(''));
            for (state_id in state_list) {
                if (state_list[state_id].pais_id == country_list[dropdown_value].id) {
                    $selEstado.append($("<option>").val(state_list[state_id].id).html(state_list[state_id].name));

                }
            }
            //pass id instead of dropdown value for relationship generation purposes
            dropdown_value = pais_id;
            $selEstado.change();
            // console.log("$selEstado");
            //console.log($selEstado);
        }

        //update munipipo dropdown if estado chagnes
        if (field_name == 'estado') {

            var $codigoPostal = $input.parent().parent().parent().find("[placeholder='Codigo Postal']");
            $codigoPostal.empty();
            var $selColonia = $input.parent().parent().parent().find("[placeholder='colonia']");
            $selColonia.empty();
            var $selMunicipio = $input.closest('td').next().find("[placeholder='municipio']");
            //clear child options
            $selMunicipio.empty();
            var municipio_list = app.metadata.getMunicipalities();
            $selMunicipio.append($("<option>").val('').html(''));
            for (municipo_id in municipio_list) {
                if (municipio_list[municipo_id].estado_id == dropdown_value) {
                    $selMunicipio.append($("<option>").val(municipio_list[municipo_id].id).html(municipio_list[municipo_id].name));
                }
            }

            var $selCiudad = $input.closest('tr').next().find("[placeholder='ciudad']");
            //clear child options
            $selCiudad.empty();
            var city_list = app.metadata.getCities();
            $selCiudad.append($("<option>").val('').html(''));
            for (city_id in city_list) {
                if (city_list[city_id].estado_id == dropdown_value) {
                    $selCiudad.append($("<option>").val(city_list[city_id].id).html(city_list[city_id].name));
                }


            }
            // console.log("$selMunicipio");
            // console.log($selMunicipio);
            $selMunicipio.change();

        }
        //update ciudad dropdown on municpo change
        if (field_name == 'municipio') {
            //var $codigoPostal = $input.parent().parent().parent().find("[placeholder='Codigo Postal']");
            //$codigoPostal.val('');
            var $selColonia = $input.parent().parent().parent().find("[placeholder='colonia']");
            $selColonia.val('');
            var $selCiudad = $input.parent().parent().parent().find("[placeholder='ciudad']");
            $selCiudad.val('');
            var $codigoPostal = $input.parent().parent().parent().find("[placeholder='Codigo Postal']");
            $codigoPostal.empty();
            var codigopostal_list = app.metadata.getPostalCodes();
            $codigoPostal.append($("<option>").val('').html(''));
            //console.log("dropdown_value");
            // console.log(dropdown_value);
            //console.log("input");
            // console.log($input);
            var lista = "";
            for(codigopostal_id in codigopostal_list){
                if(codigopostal_list[codigopostal_id].id_municipio == dropdown_value){
                    $codigoPostal.append($("<option>").val(codigopostal_list[codigopostal_id].id).html(codigopostal_list[codigopostal_id].name));
                }
            }
            //console.log("$codigoPostal");
            //console.log($codigoPostal);
            $codigoPostal.change();
        }

        //update postal dropdown on ciudad change
        if (field_name == 'ciudad') {

        }

        if (field_name == 'codigopostal') {

            //console.log("Traemos las colonias pintar");
            // vamos a colocar las colonias
            var $codigoPostal = $input.parent().parent().parent().find("[placeholder='Codigo Postal']");
            var $selColonia = $input.parent().parent().parent().find("[placeholder='colonia']");

            var $selColoniaTemp = $input.parent().parent().parent().find("select.existingColoniaTemp");
            var $iconLoading = $input.parent().parent().parent().find(".loadingIconColoniaTemp");

            $selColonia.empty();
            $selColoniaTemp.empty();
            //Cargamos los
            console.log("CODIGO a lanzar")
            //console.log($('select.'+class_name+' :selected').text());

            //console.log('$input');
            //console.log($input);
            var zipcode_to_trigger = "";
            var zipcode_to_triggerTemp = "";
            //zipcode_to_trigger =$('select.'+class_name+' :selected').text();
            zipcode_to_trigger = $input.find(":selected").text();
            zipcode_to_triggerTemp = $input.parent().parent().parent().find('#existingPostalInput').val();
            id_codigo = $input.find(":selected").val();
            id_codigoTemp = $input.parent().parent().parent().find('#existingPostalHidden').val();
            id_filtro_colonia = id_codigoTemp.substr(0, 9) +""+zipcode_to_triggerTemp;

            $selColonia.append($("<option>").val('').html(''));
            var url = app.api.buildURL("dire_Colonia", null, null, {
                fields: "name",
                //max_num: 10,
                "filter": [
                    {
                        /*
                         "id": {
                         "$starts" : id_filtro_colonia
                         }
                         */
                        "codigo_postal":{
                            "$equals": zipcode_to_triggerTemp
                        }

                    }
                ]
            });
            console.log(url);

            $iconLoading.show();
            app.api.call('read', url, null, {
                success: _.bind(function (colonias) {
                    $.each(colonias.records, function (colonia_id, colonia) {
                        //console.log(colonia.name);
                        if (colonia.id == $selColonia.next().val()) {
                            $selColonia.append($("<option selected='selected'>").val(colonia.id).html(colonia.name));
                            $selColoniaTemp.append($("<option selected='selected'>").val(colonia.id).html(colonia.name));
                            $iconLoading.hide();
                        } else {
                            $selColoniaTemp.append($("<option>").val(colonia.id).html(colonia.name));
                            $iconLoading.hide();
                        }
                    });
                }, this)
            });
        }


        //update model with new value
        //only update model on existing records
        if ($.inArray(class_name, ['existingPais', 'existingEstado', 'existingMunicipio', 'existingPostal', 'existingIndicador',
                'existingCiudad', 'existingColonia','existingPaisTemp','existingPostalIdHidden','existingEstadoTemp','existingMunicipioTemp','existingCiudadTemp','existingColoniaTemp']) != -1) {

            this._updateExistingDireccionInModel(index, dropdown_value, field_name);
        }

    },

    getInfoAboutCP: function(evt){
        //var $inputCP = this.$(evt.currentTarget);
        //this.$(evt.currentTarget).val()

        var cp=evt.currentTarget.value;
        var str_length=cp.length;
        var self = this;

        var pattern = /^\d+$/;
        var isNumber= pattern.test(cp);
        if(str_length==5 && isNumber){

            //Limpiado campos select
            $('select.newPaisTemp').empty();
            $('select.newEstadoTemp').empty();
            $('select.newMunicipioTemp').empty();
            $('select.newCiudadTemp').empty();
            $('select.newColoniaTemp').empty();


            //LLamada a api custom
            var strUrl='DireccionesCP/'+cp;
            $(".loadingIcon").show();
            $(".loadingIconEstado").show();
            $(".loadingIconMunicipio").show();
            $(".loadingIconCiudad").show();
            $(".loadingIconColonia").show();
            app.api.call('GET', app.api.buildURL(strUrl), null, {
                success: _.bind(function (data) {

                    if (data.paises.length == 0) {
                        app.alert.show('invalid_cp_exist', {
                            level: 'error',
                            autoClose: true,
                            messages: 'El C\u00F3digo Postal no existe'
                        });
                        $(".loadingIcon").hide();
                        $(".loadingIconEstado").hide();
                        $(".loadingIconMunicipio").hide();
                        $(".loadingIconCiudad").hide();
                        $(".loadingIconColonia").hide();

                        $('#postalInputTemp').css('border-color', 'red');

                    }else{

                        //Añadiendo id de cp
                        $('#postalHidden').val(data.idCP);

                        var list_paises = data.paises;
                        var list_municipios = data.municipios;
                        var list_estados = data.estados;
                        var list_colonias = data.colonias;

                        var paises_options = '';
                        for (var i = 0; i < list_paises.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            $('select.newPaisTemp').append($("<option>").val(list_paises[i].idPais).html(list_paises[i].namePais));
                        }

                        for (var i = 0; i < list_estados.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            $('select.newEstadoTemp').append($("<option>").val(list_estados[i].idEstado).html(list_estados[i].nameEstado));
                        }

                        for (var i = 0; i < list_municipios.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            $('select.newMunicipioTemp').append($("<option>").val(list_municipios[i].idMunicipio).html(list_municipios[i].nameMunicipio));
                        }

                        $('select.newColoniaTemp').append($("<option>").val("1").html("Seleccionar Colonia"));
                        for (var i = 0; i < list_colonias.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            $('select.newColoniaTemp').append($("<option>").val(list_colonias[i].idColonia).html(list_colonias[i].nameColonia));
                        }

                        $(".loadingIcon").hide();
                        $(".loadingIconEstado").hide();
                        $(".loadingIconMunicipio").hide();
                        $(".loadingIconColonia").hide();

                        var ciudades_list = app.metadata.getCities();
                        $('select.newEstadoTemp').val();
                        //var ciudad_html = '<option value="xkcd"> Seleccionar Ciudad</option>';
                        for (city_id in ciudades_list) {
                            if (ciudades_list[city_id].estado_id == $('select.newEstadoTemp').val()) {
                                $('select.newCiudadTemp').append($("<option>").val(city_id).html(ciudades_list[city_id].name));
                                /*
                                 if (city_id == direccion.ciudad) {
                                 ciudad_html += '<option value="' + city_id + '" selected="true">' + city_list[city_id].name + '</option>';
                                 }
                                 else {
                                 ciudad_html += '<option value="' + city_id + '" >' + city_list[city_id].name + '</option>';
                                 }
                                 */
                            }
                        }
                        $(".loadingIconCiudad").hide();
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

    getInfoAboutCPExisting: function(evt){
        //var $inputCP = this.$(evt.currentTarget);
        //this.$(evt.currentTarget).val()
        this.cpEvt=evt;
        var cp=evt.currentTarget.value;
        var str_length=cp.length;
        var self = this;

        if(str_length==0){
            this.counterEmptyFields++;
        }

        var pattern = /^\d+$/;
        var isNumber= pattern.test(cp);
        if(str_length==5 && isNumber){

            this.$(evt.target).css('border-color', '');

            this.$(evt.target).parent().parent().find('select.existingPaisTemp').empty();
            this.$(evt.target).parent().parent().find('select.existingEstadoTemp').empty();
            this.$(evt.target).parent().parent().next('tr').children().eq(0).find('select.existingMunicipioTemp').empty();
            this.$(evt.target).parent().parent().next('tr').children().eq(1).find('select.existingCiudadTemp').empty();
            this.$(evt.target).parent().parent().next('tr').children().eq(2).find('select.existingColoniaTemp').empty();


            //Limpiado campos select
            /*
             $('select.existingPaisTemp').empty();
             $('select.existingEstadoTemp').empty();
             $('select.existingMunicipioTemp').empty();
             $('select.existingCiudadTemp').empty();
             $('select.existingColoniaTemp').empty();
             */


            //LLamada a api custom
            var strUrl='DireccionesCP/'+cp;
            /*
             $(".loadingIconPaisTemp").show();
             $(".loadingIconEdoTemp").show();
             $(".loadingIconMunicipioTemp").show();
             $(".loadingIconCiudadTemp").show();
             $(".loadingIconColoniaTemp").show();
             */
            this.$(evt.target).parent().parent().find('.loadingIconPaisTemp').show();
            this.$(evt.target).parent().parent().find('.loadingIconEdoTemp').show();
            this.$(evt.target).parent().parent().next('tr').children().eq(0).find('.loadingIconMunicipioTemp').show();
            this.$(evt.target).parent().parent().next('tr').children().eq(1).find('.loadingIconCiudadTemp').show();
            this.$(evt.target).parent().parent().next('tr').children().eq(2).find('.loadingIconColoniaTemp').show();


            app.api.call('GET', app.api.buildURL(strUrl), evt, {
                success: _.bind(function (data) {
                    //self.cpEvt

                    if (data.paises.length == 0) {
                        app.alert.show('invalid_cp_exist', {
                            level: 'error',
                            autoClose: true,
                            messages: 'El C\u00F3digo Postal no existe'
                        });
                        $(self.cpEvt.target).parent().parent().find('.loadingIconPaisTemp').hide();
                        $(self.cpEvt.target).parent().parent().find('.loadingIconEdoTemp').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(0).find('.loadingIconMunicipioTemp').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(1).find('.loadingIconCiudadTemp').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(2).find('.loadingIconColoniaTemp').hide();

                        //$('#existingPostalInput').css('border-color', 'red');
                        $(self.cpEvt.target).css('border-color', 'red');

                    }else{

                        //Añadiendo id de cp
                        //$('#existingPostalHidden').val(data.idCP);
                        $(self.cpEvt.target).parent().parent().find('#existingPostalHidden').val(data.idCP);

                        var list_paises = data.paises;
                        var list_municipios = data.municipios;
                        var list_estados = data.estados;
                        var list_colonias = data.colonias;

                        /*
                         evt.target.parentElement.children[1].value=id;
                         $(evt.target).parent().parent().find('.existingIndicador').trigger('change');
                         * */

                        var paises_options = '';
                        for (var i = 0; i < list_paises.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            //$('select.existingPaisTemp').append($("<option>").val(list_paises[i].idPais).html(list_paises[i].namePais));
                            $(self.cpEvt.target).parent().parent().find('select.existingPaisTemp').append($("<option>").val(list_paises[i].idPais).html(list_paises[i].namePais));

                        }

                        for (var i = 0; i < list_estados.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            //$('select.existingEstadoTemp').append($("<option>").val(list_estados[i].idEstado).html(list_estados[i].nameEstado));
                            $(self.cpEvt.target).parent().parent().find('select.existingEstadoTemp').append($("<option>").val(list_estados[i].idEstado).html(list_estados[i].nameEstado));
                        }

                        for (var i = 0; i < list_municipios.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            //$('select.existingMunicipioTemp').append($("<option>").val(list_municipios[i].idMunicipio).html(list_municipios[i].nameMunicipio));
                            $(self.cpEvt.target).parent().parent().next('tr').children().eq(0).find('select.existingMunicipioTemp').append($("<option>").val(list_municipios[i].idMunicipio).html(list_municipios[i].nameMunicipio));
                        }

                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(2).find('select.existingColoniaTemp').append($("<option>").val("1").html("Seleccionar Colonia"));;

                        for (var i = 0; i < list_colonias.length; i++) {
                            //paises_options +='<option value="' + list_paises[i].idPais + '" >' + list_paises[i].namePais + '</option>';
                            //$('select.existingColoniaTemp').append($("<option>").val(list_colonias[i].idColonia).html(list_colonias[i].nameColonia));
                            $(self.cpEvt.target).parent().parent().next('tr').children().eq(2).find('select.existingColoniaTemp').append($("<option>").val(list_colonias[i].idColonia).html(list_colonias[i].nameColonia));;
                        }

                        $(self.cpEvt.target).parent().parent().find('.loadingIconPaisTemp').hide();
                        $(self.cpEvt.target).parent().parent().find('.loadingIconEdoTemp').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(0).find('.loadingIconMunicipioTemp').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(1).find('.loadingIconCiudadTemp').hide();
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(2).find('.loadingIconColoniaTemp').hide();

                        var ciudades_list = app.metadata.getCities();
                        $('select.newEstadoTemp').val();
                        //var ciudad_html = '<option value="xkcd"> Seleccionar Ciudad</option>';
                        for (city_id in ciudades_list) {
                            if (ciudades_list[city_id].estado_id == $(self.cpEvt.target).parent().parent().find('select.existingEstadoTemp').val()) {

                                //('select.existingCiudadTemp').append($("<option>").val(city_id).html(ciudades_list[city_id].name));
                                $(self.cpEvt.target).parent().parent().next('tr').children().eq(1).find('select.existingCiudadTemp').append($("<option>").val(city_id).html(ciudades_list[city_id].name));

                            }

                        }

                        //Lanzando eventos change de todos los campos actualizados

                        $(self.cpEvt.target).parent().parent().find('#existingPostalHidden').trigger("change");
                        $(self.cpEvt.target).parent().parent().find('.existingPaisTemp').trigger("change");
                        $(self.cpEvt.target).parent().parent().find('.existingEstadoTemp').trigger("change")
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(0).find('.existingMunicipioTemp').trigger("change");
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(2).find('.existingColoniaTemp').trigger("change");
                        $(self.cpEvt.target).parent().parent().next('tr').children().eq(1).find('.existingCiudadTemp').trigger("change");

                    }
                },this)
            });

        }else{

            app.alert.show('invalid_cp', {
                level: 'error',
                autoClose: true,
                messages: 'C\u00F3digo Postal inv\u00E1lido'
            });

            this.$(evt.target).css('border-color', 'red');
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

    /**
     * In edit mode, render telefono input fields using the edit-telefono-field template.
     * @inheritdoc
     * @private
     */
    _render: function () {
        var direccionsHtml = '';
        //var $select = $('#multi1');
        this._super("_render");
        //Se establece formato de multiselect a campo select con id "multi1"
        $('#multi1').select2({
            width:'100%',
            //minimumResultsForSearch:7,
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        var data = [
            { id: 0, text: 'enhancement' },
            { id: 1, text: 'bug' },
            { id: 2, text: 'duplicate' },
            { id: 3, text: 'invalid' },
            { id: 4, text: 'wontfix' }
        ];


        //data:{ results: data, text: function(item) { return item.tag; } }
        /*
         var lista_global_cps=this.def.postal_list_global;

         var newArr=[];
         for (var key in lista_global_cps) {
         if (lista_global_cps.hasOwnProperty(key)) {
         newArr.push(lista_global_cps[key]);
         }
         }

         var dataNew=[];
         for(var i=0;i<newArr.length;i++){
         var item={};
         item.id=newArr[i].id;
         item.text=newArr[i].name;
         dataNew.push(item);

         }
         */

        //TEEEEMP
        /*
         $('#postalInputTemp').select2({
         width:'100%',
         //minimumResultsForSearch:7,
         placeholder: 'Ingresa C\u00F3digo Postal',
         allowClear: true,
         data:this.def.dataNew
         });
         */

        ///////


        if (this.tplName === 'edit') {
            //get realted records
            _.each(this.model.get('account_direcciones'), function (direccion) {
                direccionsHtml += this._buildDireccionFieldHtml(direccion);
            }, this);
            this.$el.prepend(direccionsHtml);

            $('select.existingIndicador').hide();
            $('.rowPem').hide();
            $('.rowCPcc').hide();


            //Se establece formato multiselect a cada campo select con la clase "existingMultiClass"
            $('select.existingMultiClass').each(function(){
                $(this).select2({
                    width:'100%',
                    closeOnSelect: false,
                    containerCssClass: 'select2-choices-pills-close'
                });
            });

            //Obteniendo valores de Indicador
            self=this;
            //Se establece valor de multiselect dependiendo el valor de select que se encuentra en la misma fila
            $("select.existingIndicador").each(function(i, obj) {
                var valuesI=self._getIndicador($(this).val(),null)
                $('select.existingMultiClass').eq(i).select2('val',valuesI);

            });



            //now populate colonias
            //Because colonias depends on the Zip Code we can't preload the list of colonias because the API calls are asynchronous and so if we request the list of
            //colonias when the zip code is available, the code continues executing and by the time we have the colonias its too late.
            //therefore we are re-calculating the colonias after the fact.
            $('.existingPostal').each(function () {
                $(this).change();
            });

            /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 7/9/2015 Description: Contar direcciones fiscales al cargarse la pagina */
            var count = 0;
            _.each(this.model.get('account_direcciones'), function (index, value) {
                if (String(index.indicador_label).toLowerCase().indexOf('fiscal') > 0 ) {
                    count++;
                }
            }, this);
            this.fiscalCounter = count;
            /* END CUSTOMIZATION */

        } //if edit


    },

    /**
     * Establece identificador dependiendo "id"
     * @param  {string} idSelected, valor en campo indicador
     * @param  {object} valueSelected, valores en campo multiselect
     * @return  {array}, valor(es) a establecer en campo indicador
     */
    _getIndicador: function(idSelected, valuesSelected) {

        //variable con resultado
        var result = null;

        //Arma objeto de mapeo
        var dir_indicador_map_list = app.lang.getAppListStrings('dir_indicador_map_list');

        var element = {};
        var object = [];
        var values = [];

        for(var key in dir_indicador_map_list) {
            var element = {};
            element.id = key;
            values = dir_indicador_map_list[key].split(",");
            element.values = values;
            object.push(element);
        }

        //Recupera arreglo de valores por id
        if(idSelected){
            for(var i=0; i<object.length; i++) {
                if ((object[i].id) == idSelected) {
                    result = object[i].values;
                }
            }
            console.log(result);
        }

        //Recupera id por valores
        if(valuesSelected){
            result = [];
            for(var i=0; i<object.length; i++) {
                if (object[i].values.length == valuesSelected.length) {
                    //Ordena arreglos y compara
                    valuesSelected.sort();
                    object[i].values.sort();
                    var tempVal = true;
                    for(var j=0; j<valuesSelected.length; j++) {
                        if(valuesSelected[j] != object[i].values[j]){
                            tempVal = false;
                        }
                    }
                    if( tempVal == true){
                        result[0] = object[i].id;
                    }

                }
            }

            console.log(result);
        }

        return result;
    },


    /**
     * Get HTML for direccion input field.
     * @param {Object} direccion
     * @returns {Object}
     * @private
     */
    _buildDireccionFieldHtml: function (direccion) {
        var editDireccionFieldTemplate = app.template.getField('account_direcciones', 'edit-account-direcciones'),
            direcciones = this.model.get('account_direcciones'),
            index = _.indexOf(direcciones, direccion);

        //get mapping arrays and keys
        var dir_tipo_list = app.lang.getAppListStrings('tipodedirecion_list');
        var dir_tipo_keys = app.lang.getAppListKeys('tipodedirecion_list');
        var dir_indicador_list = app.lang.getAppListStrings('dir_Indicador_list');
        var dir_indicador_unique_list = app.lang.getAppListStrings('dir_indicador_unique_list');

        var country_list = app.metadata.getCountries();
        var estado_list = app.metadata.getStates();
        var municipio_list = app.metadata.getMunicipalities();
        var city_list = app.metadata.getCities();
        var postal_list = app.metadata.getPostalCodes();
        var colonia_list = app.metadata.getColonias();
        var dir_tipo_list_html = '',
            tel_estatus_list_html = '',
            pais_list_html = '<option value=""></option>';
        //dynamicly populate dropdown options based on language values

        var postal_htmlTemp=direccion.postal_code_label;
        for (dir_tipo_key in dir_tipo_list) {
            if ($.inArray(dir_tipo_key, direccion.tipodedireccion) != -1) {
                dir_tipo_list_html += '<option value="' + dir_tipo_key + '" selected="true">' + dir_tipo_list[dir_tipo_key] + '</option>';

            }
            else {
                dir_tipo_list_html += '<option value="' + dir_tipo_key + '">' + dir_tipo_list[dir_tipo_key] + '</option>';

            }
        }

        for (a_country in country_list) {
            if (country_list[a_country].id == direccion.dire_direccion_dire_paisdire_pais_ida) {
                pais_list_html += '<option value="' + a_country + '" selected="true">' + country_list[a_country].name + '</option>';

            }
            else {
                pais_list_html += '<option value="' + a_country + '" >' + country_list[a_country].name + '</option>';

            }
        }

        var estado_html = '<option value="xkcd"> Seleccionar Estado</option>';
        for (state_id in estado_list) {
            if (estado_list[state_id].pais_id == direccion.dire_direccion_dire_paisdire_pais_ida) {
                if (state_id == direccion.dire_direccion_dire_estadodire_estado_ida) {
                    estado_html += '<option value="' + state_id + '" selected="true">' + estado_list[state_id].name + '</option>';

                }
                else {
                    estado_html += '<option value="' + state_id + '" >' + estado_list[state_id].name + '</option>';

                }
            }
        }


        var municipio_html = '<option value="xkcd"> Selecionar Municipio</option>';
        for (municipo_id in municipio_list) {
            if (municipio_list[municipo_id].estado_id == direccion.dire_direccion_dire_estadodire_estado_ida) {
                if (municipo_id == direccion.dire_direccion_dire_municipiodire_municipio_ida) {
                    municipio_html += '<option value="' + municipo_id + '" selected="true">' + municipio_list[municipo_id].name + '</option>';
                }
                else {
                    municipio_html += '<option value="' + municipo_id + '" >' + municipio_list[municipo_id].name + '</option>';
                }
            }
        }

        var indicador_html = '<option value=""></option>';
        for (indicador_id in dir_indicador_list) {
            if (indicador_id == direccion.indicador) {
                indicador_html += '<option value="' + indicador_id + '" selected="true">' + dir_indicador_list[indicador_id] + '</option>';
            } else {
                indicador_html += '<option value="' + indicador_id + '" >' + dir_indicador_list[indicador_id] + '</option>';
            }
        }

        //Obteniendo valores recibidos del template principal
        var valores_get=direccion.indicador_multi;
        //indicador multiseelct
        var indicador_multi_html = '<option value=""></option>';
        for (indicador_id in dir_indicador_unique_list) {
            indicador_multi_html += '<option value="' + indicador_id + '" >' + dir_indicador_unique_list[indicador_id] + '</option>';
        }

        var ciudad_html = '<option value="xkcd"> Seleccionar Ciudad</option>';
        for (city_id in city_list) {
            if (city_list[city_id].estado_id == direccion.dire_direccion_dire_estadodire_estado_ida) {
                if (city_list[city_id].id==direccion.ciudad) {
                    ciudad_html += '<option value="' + city_id + '" selected="true">' + city_list[city_id].name + '</option>';
                }
                else {
                    ciudad_html += '<option value="' + city_id + '" >' + city_list[city_id].name + '</option>';
                }
            }

        }


        var postal_html = '<option value="xkcd"> Seleccionar Codigo Postal</option>';
        var postal = '';
        for (codigopostal_id in postal_list) {
            if (postal_list[codigopostal_id].id_municipio == direccion.dire_direccion_dire_municipiodire_municipio_ida){
                if (postal_list[codigopostal_id].id == direccion.dire_direccion_dire_codigopostaldire_codigopostal_ida) {
                    postal_html += '<option value="' + codigopostal_id + '" selected="true">' + postal_list[codigopostal_id].name + '</option>';
                    postal = direccion.dire_direccion_dire_codigopostaldire_codigopostal_ida;
                }
                else {
                    postal_html += '<option value="' + codigopostal_id + '" >' + postal_list[codigopostal_id].name + '</option>';

                }

            }

        }

        //var postal_html=direccion.postal_code_label;

        //var postal_html = '';
        //var postal = '';
        //if (direccion.dire_direccion_dire_codigopostaldire_codigopostal_ida != '') {
        //    postal_html = postal_list[direccion.dire_direccion_dire_codigopostaldire_codigopostal_ida].name;
        //    postal = direccion.dire_direccion_dire_codigopostaldire_codigopostal_ida;
        //}

        var colonia_id = '';
        if (direccion.dire_direccion_dire_coloniadire_colonia_ida != '') {
            colonia_id = direccion.dire_direccion_dire_coloniadire_colonia_ida;
            // console.log(colonia_id);
        }

        //If this came from a new control, the colonias seleccion is going to be included in the direcciones variable
        var colonia_html = '';
        //console.log(direccion);
        if (typeof(direccion.colonia_new_html) != 'undefined') {
            //console.log("colonia new html");
            $(direccion.colonia_new_html).each(function () {
                if ($(this).val() == direccion.colonia) {
                    $(this).attr("selected", "selected");
                    colonia_html += '<option value="' + $(this).val() + '" selected="true">' + $(this).text() + '</option>';
                } else {
                    colonia_html += '<option value="' + $(this).val() + '" >' + $(this).text() + '</option>';
                }
            });
        } else { //this is for an existing address

        }


        //Traer los id_municipio que tengan name postal_code_label en postal_list
        var municipios_html="";
        for(var pos in postal_list){
            if (postal_list[pos].name == direccion.postal_code_label) {
                //Obtener etiqueta del municipio
                var id_municipio=postal_list[pos].id_municipio;
                for(var pos_mun in municipio_list){
                    if(municipio_list[pos_mun].id == id_municipio){
                        municipios_html += '<option value="' + id_municipio + '" selected="true">' + municipio_list[pos_mun].name + '</option>';

                    }
                }
            }

        }

        //Obtener el estado perteneciente a los municipios
        var estados_list_html="";
        for(var pos_mun in municipio_list){

            if(municipio_list[pos_mun].id== direccion.municipio){
                //Obtener etiqueta del estado
                var id_estado=municipio_list[pos_mun].estado_id;
                for(var pos_es in estado_list){
                    if(estado_list[pos_es].id== id_estado){
                        estados_list_html += '<option value="' + id_estado + '" selected="true">' + estado_list[pos_es].name + '</option>';

                    }

                }

            }

        }

        var paises_list_html="";
        for(var pos_est in estado_list){

            if(estado_list[pos_est].name== direccion.estado_code_label){
                //Obtener etiqueta del estado
                var id_pais=estado_list[pos_est].pais_id;
                for(var pos_pais in country_list){
                    if(country_list[pos_pais].id== id_pais){
                        paises_list_html += '<option value="' + id_pais + '" selected="true">' + country_list[pos_pais].name + '</option>';

                    }

                }

            }

        }


        return editDireccionFieldTemplate({
            max_length: this.def.len,
            index: index === -1 ? direcciones.length - 1 : index,
            tipodedireccion: dir_tipo_list_html,
            pais: pais_list_html,
            paises_list: paises_list_html,
            estado_html: estado_html,
            estados_html: estados_list_html,
            municipio_html: municipio_html,
            municipios_html: municipios_html,
            indicador_html: indicador_html,
            indicador_multi_html: indicador_multi_html,
            ciudad_html: ciudad_html,
            postal_html: postal_html,
            postal: postal,
            postal_htmlTemp: postal_htmlTemp,
            colonia_html: colonia_html,
            colonia_id: colonia_id,
            direccion: direccion.direccion,
            principal: direccion.principal,
            inactivo: direccion.inactivo,
            calle: direccion.calle,
            numint: direccion.numint,
            numext: direccion.numext

        });
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


        //Valida tipo de direccion
        if ($('.newTipodedireccion').val() == '0' || $('.newTipodedireccion').val() == null) {
            errorMsg = 'Tipo de direccion requerido';
            dirError = true; dirErrorCounter++;
            $('.newTipodedireccion').css('border-color', 'red');
        } else {
            $('.newTipodedireccion').css('border-color', '');
        }

        //Valida indicador
        if ($('#multi1').val() == null) {
            errorMsg = 'Indicador de direcci\u00F3n requerido';

            dirError = true; dirErrorCounter++;

            $('#s2id_multi1 ul').css('border-color', 'red');  //Validación para pintar el campo Indicador.
        } else {
            $('#s2id_multi1 ul').css('border-color', '');
            //$('#multi1').css('border-color', '');

        }

        //Valida código postal
        if ($('#postalInputTemp').val() == '') {
            errorMsg = 'C\u00F3digo postal requerido';
            dirError = true; dirErrorCounter++;
            $('#postalInputTemp').css('border-color', 'red');
        } else {
            $('#postalInputTemp').css('border-color', '');

        }

        //Valida extensión de código postal y valida únicamente números
         var pattern = /^\d+$/;

        if ($('#postalInputTemp').val().length !=5 || !pattern.test($('#postalInputTemp').val())) {

            $('#postalInputTemp').css('border-color', 'red');
            return;


        } else {
            $('#postalInputTemp').css('border-color', '');

        }

        //Valida colonia
        if ($('select.newColoniaTemp').val() == '1') {
            errorMsg = 'Favor de seleccionar una colonia';
            dirError = true; dirErrorCounter++;
            $('select.newColoniaTemp').css('border-color', 'red');
        } else {
            $('select.newColoniaTemp').css('border-color', '');

        }


        /*
         //Valida pais
         if ($('.newPaisDir').val() == '') {
         errorMsg = 'Pais es requerido';
         dirError = true; dirErrorCounter++;
         $('.newPaisDir').css('border-color', 'red');
         } else {
         $('.newPaisDir').css('border-color', '');

         }

         //Valida estado
         if ($('.newEstado').val() == '') {
         errorMsg = 'Estado es requerido';
         dirError = true; dirErrorCounter++;
         $('.newEstado').css('border-color', 'red');
         } else {
         $('.newEstado').css('border-color', '');

         }

         //Valida municipio
         if ($('.newMunicipio').val() == '') {
         errorMsg = 'Municipio es requerido';
         dirError = true; dirErrorCounter++;
         $('.newMunicipio').css('border-color', 'red');
         } else {
         $('.newMunicipio').css('border-color', '');

         }

         //Valida codigo postal
         if ($('.newPostal').val() == '') {
         errorMsg = 'Codigo Postal es requerido';
         dirError = true; dirErrorCounter++;
         $('.newPostal').css('border-color', 'red');
         } else {
         $('.newPostal').css('border-color', '');

         }

         //Valida ciudad
         if ($('.newCiudad').val() == '' || $('.newCiudad').val() == null) {
         errorMsg = 'Ciudad es requerida';
         dirError = true; dirErrorCounter++;
         $('.newCiudad').css('border-color', 'red');
         } else {
         $('.newCiudad').css('border-color', '');

         }

         //Valida colonia
         if ($('.newColonia').val() == '' || $('.newColonia').val() == null) {
         errorMsg = 'Colonia es requerida';
         dirError = true; dirErrorCounter++;
         $('.newColonia').css('border-color', 'red');
         } else {
         $('.newColonia').css('border-color', '');

         }
         */

        //Valida Calle
        if ($('.newCalle').val() == '' || $('.newCalle').val() == null) {
            errorMsg = 'Calle es requerida';
            dirError = true; dirErrorCounter++;
            $('.newCalle').css('border-color', 'red');
        } else {
            $('.newCalle').css('border-color', '');

        }

        //Valida Num Ext
        if ($('.newNumExt').val() == '' || $('.newNumExt').val() == null) {
            errorMsg = 'Numero Exterior es requerido';
            dirError = true; dirErrorCounter++;
            $('.newNumExt').css('border-color', 'red');
        } else {
            $('.newNumExt').css('border-color', '');

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

        calle = $.trim(calle);


        if ((calle !== '') && (this._addNewDireccionToModel(calle))) {
            // build the new direccion field
            //var country_model = app.metadata.getCountry($('.newPaisDir').val());
            var country_model = app.metadata.getCountry($('.newPaisTemp').val());

            //var postal_model = app.metadata.getPostalCode($('.newPostal').val());
            var postal_model = app.metadata.getPostalCode($('#postalHidden').val());

            var dir_tipo_list = app.lang.getAppListStrings('tipodedirecion_list');
            var dir_indicador_list = app.lang.getAppListStrings('dir_Indicador_list');

            var country_id = '';
            if (country_model != undefined) {
                country_id = country_model.id;
            }

            var postal_id = '';
            if (postal_model != undefined) {
                postal_id = postal_model.id;
            }

            currentValue = this.model.get(this.name);
            //console.log("AGREGA UNA NUEVA DIRECCION");
            // console.log($('.newPostal').val());
            direccionFieldHtml = this._buildDireccionFieldHtml({
                tipodedireccion: $('.newTipodedireccion').val(),
                tipo_label: dir_tipo_list[$('.newTipodedireccion').val()],

                //pais: $('.newPaisDir').val(),
                pais: $('.newPaisTemp').val(),

                //dire_direccion_dire_paisdire_pais_ida: country_id,
                dire_direccion_dire_paisdire_pais_ida: country_id,

                //estado: $('.newEstado').val(),
                estado: $('.newEstadoTemp').val(),
                estado_code_label:$('.newEstadoTemp option:selected').text(),

                //dire_direccion_dire_estadodire_estado_ida: $('.newEstado').val(),
                dire_direccion_dire_estadodire_estado_ida: $('.newEstadoTemp').val(),

                //municipio: $('.newMunicipio').val(),
                municipio: $('.newMunicipioTemp').val(),
                municipio_code_label:$('.newMunicipioTemp option:selected').text(),

                indicador: $('.newIndicador').val(),
                indicador_label: dir_indicador_list[$('.newIndicador').val()],
                //Añadiendo nuevo atributo
                indicador_multi:$("#multi1").val(),

                //dire_direccion_dire_municipiodire_municipio_ida: $('.newMunicipio').val(),
                dire_direccion_dire_municipiodire_municipio_ida: $('.newMunicipioTemp').val(),

                //ciudad: $('.newCiudad').val(),
                ciudad: $('.newCiudadTemp').val(),

                //dire_direccion_dire_ciudaddire_ciudad_ida: $('.newCiudad').val(),
                dire_direccion_dire_ciudaddire_ciudad_ida: $('.newCiudadTemp').val(),

                //postal: $('.newPostal').val(),
                postal: $('#postalHidden').val(),

                postal_code_label: $('#postalInputTemp').val(),

                //dire_direccion_dire_codigopostaldire_codigopostal_ida: $('.newPostal').val(),
                dire_direccion_dire_codigopostaldire_codigopostal_ida: $('#postalHidden').val(),

                //colonia_new_html: $('.newColonia').html(),
                colonia_new_html: $('.newColoniaTemp').html(),

                //colonia: $('.newColonia').val(),
                colonia: $('.newColoniaTemp').val(),

                //dire_direccion_dire_coloniadire_colonia_ida: $('.newColonia').val(),
                dire_direccion_dire_coloniadire_colonia_ida: $('.newColoniaTemp').val(),

                calle: calle,
                numint: $('.newNumInt').val(),
                numext: $('.newNumExt').val(),
                principal: currentValue && (currentValue.length === 1)
            });


            // append the new field before the new direccion input
            $newDireccionField = this._getNewDireccionField()
                .closest('.direccion')
                .before(direccionFieldHtml);

            $('select.existingIndicador').hide();
            $('.rowPem').hide();
            $('.rowCPcc').hide();

            //Establece formato multiselect a campo select que contenga clase "existingMultiClass"
            $('select.existingMultiClass').each(function(){
                $(this).select2({
                    width:'100%',
                    closeOnSelect: false,
                    containerCssClass: 'select2-choices-pills-close'
                });
            });

            //Obteniendo valores de Indicador
            //Establece valores a campo multiselect dependiendo el valor del campo select original
            self=this;
            $("select.existingIndicador").each(function(i, obj) {
                var valuesI=self._getIndicador($(this).val(),null)
                $('select.existingMultiClass').eq(i).select2('val',valuesI);

            });


            // add tooltips
            //this.addPluginTooltips($newDireccionField.prev());

            if (this.def.required && this._shouldRenderRequiredPlaceholder()) {
                // we need to remove the required place holder now
                var label = app.lang.get('LBL_REQUIRED_FIELD', this.module),
                    el = this.$(this.fieldTag).last(),
                    placeholder = el.prop('placeholder').replace('(' + label + ') ', '');

                el.prop('placeholder', placeholder.trim()).removeClass('required');
            }
            this._clearNewDireccionField();

        }
        else {
            app.alert.show('Direcci\u00F3n', {
                level: 'error',
                autoClose: true,
                messages: 'La Direcci\u00F3n ya se encuentra reigistrada'
            });
        }

    },

    checkcallenum: function(evt){
        var limite=this.limitto100(evt);
        if(limite==false){
            return false;
        }
        this.updateExistingDireccion(evt);
    },

    limitto100: function(evt){
        if (!evt) return;
        //get field that changed
        var $input = this.$(evt.currentTarget);

        var direccion = $input.val();

        if(direccion.length>99 && evt.key!="Backspace" && evt.key!="Tab" && evt.key!="ArrowLeft" && evt.key!="ArrowRight"){
            return false;
        }
    },

    checknumint: function(evt){
        var limite=this.limitto50(evt);
        if(limite==false){
            return false;
        }
        this.updateExistingDireccion(evt);
    },

    limitto50: function(evt){
        if (!evt) return;
        //get field that changed
        var $input = this.$(evt.currentTarget);
        var direccion = $input.val();
        if(direccion.length>49 && evt.key!="Backspace" && evt.key!="Tab" && evt.key!="ArrowLeft" && evt.key!="ArrowRight"){
            return false;
        }
    },

    /**
     * Event handler to update a direccion.
     * @param {Event} evt
     */
    updateExistingDireccion: function (evt) {
        if (!evt) return;
        //get field that changed
        var $input = this.$(evt.currentTarget);
        //get field type
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            index = $inputs.index($input),
            newDireccion = $input.val(),
            primaryRemoved;

        if (newDireccion === '') {
            // remove direccion if direccion is empty
            /*
             primaryRemoved = this._removeExistingDireccionInModel(index);

             $input
             .closest('.direccion')
             .remove();

             if (primaryRemoved) {
             // on list views we need to set the current value on the input
             if (this.view && this.view.action === 'list') {
             var direcciones = this.model.get(this.name) || [];
             var primaryDireccion = _.filter(direcciones, function (direccion) {
             if (direccion.principal) {
             return true;
             }
             });
             if (primaryDireccion[0] && primaryDireccion[0].direccion_direccion) {
             app.alert.show('list_delete_direccion_info', {
             level: 'info',
             autoClose: true,
             messages: app.lang.get('LBL_LIST_REMOVE_DIRECCION_INFO')
             });
             $input.val(primaryDireccion[0].direccion_direccion);
             }
             }
             this.$('[data-direccionproperty=principal]')
             .first()
             .addClass('active');
             }
             */
            this.counterEmptyFields++;
        }
        else {
            this._updateExistingDireccionInModel(index, newDireccion, field_name);
        }
    },

    /**
     * Event handler to remove an direccion direccion.
     * @param {Event} evt
     */
    removeExistingDireccion: function (evt) {
        if (!evt) return;

        var $deleteButtons = this.$('.removeDireccion'),
            $deleteButton = this.$(evt.currentTarget),
            index = $deleteButtons.index($deleteButton),
            primaryRemoved,
            $removeThisField;

        primaryRemoved = this._removeExistingDireccionInModel(index);

        $removeThisField = $deleteButton.closest('.direccion');
        this.removePluginTooltips($removeThisField); // remove tooltips
        $removeThisField.remove();

        if (primaryRemoved) {
            // If primary has been removed, the first direccion direccion is the primary direccion.
            this.$('[data-direccionproperty=principal]')
                .first()
                .addClass('active');
        }

        // if this field is required, and there is nothing in the model, then we should decorate it as required
        if (this.def.required && _.isEmpty(this.model.get(this.name))) {
            this.decorateRequired();
        }
    },

    /**
     * Event handler to toggle direccion direccion properties.
     * @param {Event} evt
     */
    toggleExistingDireccionProperty: function (evt) {
        if (!evt) return;

        var $property = this.$(evt.currentTarget),
            property = $property.data('direccionproperty'),
            $properties = this.$('[data-direccionproperty=' + property + ']'),
            index = $properties.index($property);

        if (property === 'principal') {
            $properties.removeClass('active');
        }

        this._toggleExistingDireccionPropertyInModel(index, property);
    },

    /**
     * Add the new direccion direccion to the model.
     * @param {String} direccion
     * @returns {Boolean} Returns true when a new direccion is added.  Returns false if duplicate is found,
     *          and was not added to the model.
     * @private
     */


    _addNewDireccionToModel: function (calle) {
        //var existingDirecciones = this.model.get('account_direcciones');
        var existingDirecciones = app.utils.deepCopy(this.model.get('account_direcciones'));
        var country_model = app.metadata.getCountry($('.newPaisDir').val());
        var country_modelTemp = app.metadata.getCountry($('.newPaisTemp').val());
        var postal_model = app.metadata.getPostalCode($('.newPostal').val());
        var postal_modelTemp = app.metadata.getPostalCode($('#postalHidden').val());
        var dir_tipo_list = app.lang.getAppListStrings('tipodedirecion_list');
        var dir_indicador_list = app.lang.getAppListStrings('dir_Indicador_list');

        var country_id = '';
        var country_idTemp = '';

        if (country_model != undefined) {
            country_id = country_model.id;
        }

        if (country_modelTemp != undefined) {
            country_idTemp = country_modelTemp.id;
        }

        var postal_id = '';
        var postal_idTemp = '';

        if (postal_model != undefined) {
            postal_idTemp = postal_modelTemp.id;
        }


        // VALIDA QUE LA DIRECCION NO SEA LA MISMA
        // si regresa el valor verdadero significa que si esta duplicado por lo tanto no debe agregar la direccion
       // var success=false;
       // if(!this.direccionExistente(existingDirecciones,calle))
       // {
            existingDirecciones.push({
                tipodedireccion: $('.newTipodedireccion').val(),
                tipo_label: dir_tipo_list[$('.newTipodedireccion').val()],
                //pais: $('.newPaisDir').val(),

                pais: country_idTemp,
                //paisTemp: country_idTemp,

                //dire_direccion_dire_paisdire_pais_ida: country_id,
                dire_direccion_dire_paisdire_pais_ida: country_idTemp,

                //estado: $('.newEstado').val(),
                estado: $('.newEstadoTemp').val(),

                //dire_direccion_dire_estadodire_estado_ida: $('.newEstado').val(),
                dire_direccion_dire_estadodire_estado_ida: $('.newEstadoTemp').val(),

                //municipio: $('.newMunicipio').val(),
                municipio: $('.newMunicipioTemp').val(),

                //dire_direccion_dire_municipiodire_municipio_ida: $('.newMunicipio').val(),
                dire_direccion_dire_municipiodire_municipio_ida: $('.newMunicipioTemp').val(),

                indicador: $('.newIndicador').val(),
                indicador_label: dir_indicador_list[$('.newIndicador').val()],

                //ciudad: $('.newCiudad').val(),
                ciudad: $('.newCiudadTemp').val(),

                //dire_direccion_dire_ciudaddire_ciudad_ida: $('.newCiudad').val(),
                dire_direccion_dire_ciudaddire_ciudad_ida: $('.newCiudadTemp').val(),

                //postal: $('.newPostal').val(),
                postal: $('#postalHidden').val(),

                //codigopostal: $('.newPostal').val(),
                codigopostal: $('#postalHidden').val(),

                //dire_direccion_dire_codigopostaldire_codigopostal_ida: $('.newPostal').val(),
                dire_direccion_dire_codigopostaldire_codigopostal_ida: $('#postalHidden').val(),

                //colonia: $('.newColonia').val(),
                colonia: $('.newColoniaTemp').val(),

                //dire_direccion_dire_coloniadire_colonia_ida: $('.newColonia').val(),
                dire_direccion_dire_coloniadire_colonia_ida: $('.newColoniaTemp').val(),

                //colonia_new_html: $('.newColonia').html(),
                colonia_new_html: $('.newColoniaTemp').html(),

                calle: calle,
                numint: $('.newNumInt').val(),
                numext: $('.newNumExt').val(),
                principal: (existingDirecciones.length === 0),
                inactivo: false
            });

            console.log("existingDirecciones");
            console.log(existingDirecciones);
            this.model.set(this.name, existingDirecciones);
            success = true;

        //}



        return success;
    },


    direccionExistente: function (objDireccion, Calle1) {
        var direccValida = false;

        // Cambiamos los id por Descripcion
        var postal_modelTemp1 = app.metadata.getPostalCode($('#postalHidden').val());

        var strDireccion = Calle1 + $('.newNumInt').val() + $('.newNumExt').val() + $('.newColoniaTemp option:selected').text() + $('.newMunicipioTemp option:selected').text()
            + $('.newEstadoTemp option:selected').text() + $('.newCiudadTemp option:selected').text() + postal_modelTemp1.name;


  /*      if (objDireccion != "" && objDireccion != undefined) {
            for (var i = 0; i < objDireccion.length; i++) {
                var tempDireccion = objDireccion[i].calle + objDireccion[i].numint + objDireccion[i].numext + objDireccion[i].colonia
                    + objDireccion[i].municipio_code_label + objDireccion[i].estado_code_label + objDireccion[i].ciudad + objDireccion[i].postal_code_label;

                if (strDireccion.replace(/\s/g, "").toUpperCase()  == tempDireccion.replace(/\s/g, "").toUpperCase() ) {
                    direccValida = true;
                }

            }

        }*/
        // si regresa el valor verdadero significa que si esta duplicado por lo tanto no debe agregar la

        var objDirecciones = $('.control-group.direccion')
        var concatDirecciones = [];
        var strDireccionTemp = "";
        for (var i = 0; i < objDirecciones.length-1; i++) {
            strDireccionTemp = objDirecciones.eq(i).find('.existingCalle').val() +
                objDirecciones.eq(i).find('.existingNumExt').val() +
                objDirecciones.eq(i).find('.existingNumInt').val() +
                objDirecciones.eq(i).find('select.existingColoniaTemp option:selected').text() +
                objDirecciones.eq(i).find('select.existingMunicipioTemp option:selected').text() +
                objDirecciones.eq(i).find('select.existingEstadoTemp option:selected').text() +
                objDirecciones.eq(i).find('select.existingCiudadTemp option:selected').text() +
                objDirecciones.eq(i).find('#existingPostalInput').val();

            concatDirecciones.push(strDireccionTemp.replace(/\s/g, "").toUpperCase());

        }

        for (var j = 0; j < concatDirecciones.length; j++) {

                if (concatDirecciones[j] ==strDireccion.replace(/\s/g, "").toUpperCase() ) {
                    direccValida = true;
                }


        }
        return direccValida;
    },


    /**
     * Update direccion direccion in the model.
     * @param {Number} index
     * @param {String} newdireccion
     * @private
     */
    _updateExistingDireccionInModel: function (index, newDireccion, field_name) {
        var existingDirecciones = app.utils.deepCopy(this.model.get('account_direcciones'));

        if(field_name=='postal_temp'){
            field_name='codigopostal';
        }

        if(field_name=='pais_temp'){
            field_name='pais';
        }

        if(field_name=='estado_temp'){
            field_name='estado';
        }

        if(field_name=='municipio_temp'){
            field_name='municipio';
        }

        if(field_name=='ciudad_temp'){
            field_name='ciudad';
        }

        if(field_name=='colonia_temp'){
            field_name='colonia';
        }
        //Simply update the direccion direccion
        console.log("---------Simply update the direccion direccion---------");
        console.log("index");
        console.log(index);
        console.log("newDireccion");
        console.log(newDireccion);
        console.log("field_name");
        console.log(field_name);
        console.log(existingDirecciones[index][field_name]);

        existingDirecciones[index][field_name] = newDireccion;
        if(field_name == 'colonia'){
            existingDirecciones[index]['dire_direccion_dire_coloniadire_colonia_ida'] = newDireccion;
            //  existingDirecciones[index]['colonia'] = '';
        }
        if(field_name == 'ciudad'){
            existingDirecciones[index]['dire_direccion_dire_ciudaddire_ciudad_ida'] = newDireccion;
        }
        if(field_name == 'codigopostal'){
            existingDirecciones[index]['postal'] = newDireccion;
            existingDirecciones[index]['dire_direccion_dire_codigopostaldire_codigopostal_ida'] = newDireccion;
        }
        if(field_name == 'municipio'){
            existingDirecciones[index]['dire_direccion_dire_municipiodire_municipio_ida'] = newDireccion;
        }
        if(field_name == 'estado'){
            existingDirecciones[index]['dire_direccion_dire_estadodire_estado_ida'] = newDireccion;
        }
        if(field_name == 'pais'){
            existingDirecciones[index]['dire_direccion_dire_paisdire_pais_ida'] = newDireccion;
        }

        if(field_name == 'indicador'){
            existingDirecciones[index][field_name] = newDireccion;
        }

        //Nuevas validaciones para actualizar direcciones



        console.log(existingDirecciones[index][field_name]);
        console.log("this.name");
        console.log(this.name);

        this.model.set(this.name, existingDirecciones);
        console.log("existingDirecciones");
        console.log(existingDirecciones);
        console.log("---------Simply update the direccion direccion---------");

    },

    /**
     * Toggle direccion direccion properties: primary, opt-out, and invalid.
     * @param {Number} index
     * @param {String} property
     * @private
     */
    _toggleExistingDireccionPropertyInModel: function (index, property) {
        var existingDirecciones = app.utils.deepCopy(this.model.get(this.name));

        //If property is principal, we want to make sure one and only one primary direccion is set
        //As a consequence we reset all the principal properties to 0 then we toggle property for this index.
        if (property === 'principal') {
            existingDirecciones[index][property] = false;
            _.each(existingDirecciones, function (direccion, i) {
                if (direccion[property]) {
                    existingDirecciones[i][property] = false;
                }
            });
        }

        // Toggle property for this direccion
        if (existingDirecciones[index][property]) {
            existingDirecciones[index][property] = false;
        }
        else {
            existingDirecciones[index][property] = true;
        }

        this.model.set(this.name, existingDirecciones);
    },

    /**
     * Remove direccion direccion from the model.
     * @param {Number} index
     * @returns {Boolean} Returns true if the removed direccion was the primary direccion.
     * @private
     */
    _removeExistingDireccionInModel: function (index) {
        var existingDirecciones = app.utils.deepCopy(this.model.get(this.name)),
            primaryDireccionRemoved = !!existingDirecciones[index]['principal'];

        //Reject this index from existing direcciones
        existingDirecciones = _.reject(existingDirecciones, function (direccionInfo, i) {
            return i == index;
        });

        // If a removed direccion was the primary direccion, we still need at least one direccion to be set as the primary direccion
        if (primaryDireccionRemoved) {
            //Let's pick the first one
            var direccion = _.first(existingDirecciones);
            if (direccion) {
                direccion.principal = true;
            }
        }

        this.model.set(this.name, existingDirecciones);
        return primaryDireccionRemoved;
    },

    /**
     * Clear out the new direccion direccion field.
     * @private
     */
    _clearNewDireccionField: function () {
        this._getNewDireccionField()
            .val('');
        $('.newTipodedireccion').val([]);
        $('.newPaisDir').val('');
        $('.newEstado').val('');
        $('.newMunicipio').val('');
        $('.newIndicador').val('');
        $('.newPostal').val('');
        $('.newPostalId').val('');
        $('.newCalle').val('');
        $('.newCiudad').val('');
        $('.newNumExt').val('');
        $('.newNumInt').val('');
        $('.newColonia').empty();

        //Limpiando campos que se llenan automáticamente por api custom
        $('#postalInputTemp').val('');
        $('#postalHidden').val('');
        $('.newPaisTemp').val('');
        $('.newEstadoTemp').val('');
        $('.newMunicipioTemp').val('');
        $('.newCiudadTemp').val('');
        $('.newColoniaTemp').val('');

        //limpiando campo multiSelect
        $("#multi1").select2('val',[]);
        $("#multi1").trigger('change');
        $('[data-type="account_direcciones"]').removeClass('error');
        $('.direcciondashlet').css('border-color', '');
    },

    /**
     * Get the new direccion direccion input field.
     * @returns {jQuery}
     * @private
     */
    _getNewDireccionField: function () {
        return this.$('.newCalle');
    },

    /**
     * Custom error styling for the e-mail field
     * @param {Object} errors
     * @override BaseField
     */
    decorateError: function (errors) {
        var direccions;

        this.$el.closest('.record-cell').addClass("error");

        //Select all existing direccions
        direccions = this.$('input:not(.newCalle)');

        _.each(errors, function (errorContext, errorName) {
            //For `direccion` validator the error is specific to an direccion
            if (errorName === 'direccion' || errorName === 'duplicateDireccion') {

                // For each of our `sub-direccion` fields
                _.each(direccions, function (e) {
                    var $direccion = this.$(e),
                        direccion = $direccion.val();

                    var isError = _.find(errorContext, function (direccionError) {
                        return direccionError === direccion;
                    });
                    // if we're on an direccion sub field where error occurred, add error styling
                    if (!_.isUndefined(isError)) {
                        this._addErrorDecoration($direccion, errorName, [isError]);
                    }
                }, this);
                //For required or primaryDireccion we want to decorate only the first direccion
            }
            else {
                var $direccion = this.$('input:first');
                this._addErrorDecoration($direccion, errorName, errorContext);
            }
        }, this);
    },

    _addErrorDecoration: function ($input, errorName, errorContext) {
        var isWrapped = $input.parent().hasClass('input-append');
        if (!isWrapped)
            $input.wrap('<div class="input-append error ' + this.fieldTag + '">');
        $input.next('.error-tooltip').remove();
        $input.after(this.exclamationMarkTemplate([app.error.getErrorString(errorName, errorContext)]));
        //this.createErrorTooltips($input.next('.error-tooltip'));
    },

    /**
     * Binds DOM changes to set field value on model.
     * @param {Backbone.Model} model model this field is bound to.
     * @param {String} fieldName field name.
     */
    bindDomChange: function () {
        if (this.tplName === 'list-edit') {
            this._super("bindDomChange");
        }
    },

    /**
     * To display representation
     * @param {String|Array} value single direccion direccion or set of direccion direcciones
     */
    format: function (value) {
        value = app.utils.deepCopy(value);
        if (_.isArray(value) && value.length > 0) {
            // got an array of direccion direcciones
            _.each(value, function (direccion) {
                // On render, determine which e-mail direcciones need anchor tag included
                // Needed for handlebars template, can't accomplish this boolean expression with handlebars
                direccion.hasAnchor = this.def.direccionLink && !direccion.opt_out && !direccion.invalid_direccion;
            }, this);
        }
        else if ((_.isString(value) && value !== "") || this.view.action === 'list') {
            // expected an array with a single direccion but got a string or an empty array
            value = [{
                direccion_direccion: value[0].direccion,
                principal: true,
                hasAnchor: true
            }];
        }

        value = this.addFlagLabels(value);
        return value;
    },

    /**
     * Build label that gets displayed in tooltips.
     * @param {Object} value
     * @returns {Object}
     */
    addFlagLabels: function (value) {
        var flagStr = "", flagArray;
        _.each(value, function (direccionObj) {
            flagStr = "";
            flagArray = _.map(direccionObj, function (flagValue, key) {
                if (!_.isUndefined(this._flag2Deco[key]) && this._flag2Deco[key].lbl && flagValue) {
                    return app.lang.get(this._flag2Deco[key].lbl);
                }
            }, this);
            flagArray = _.without(flagArray, undefined);
            if (flagArray.length > 0) {
                flagStr = flagArray.join(", ");
            }
            direccionObj.flagLabel = flagStr;
        }, this);
        return value;
    },

    /**
     * To API representation
     * @param {String|Array} value single telefono direccion or set of telefono direcciones
     */
    unformat: function (value) {
        if (this.view.action === 'list') {
            var direcciones = app.utils.deepCopy(this.model.get(this.name));

            if (!_.isArray(direcciones)) { // direcciones is empty, initialize array
                direcciones = [];
            }

            direcciones = _.map(direcciones, function (direccion) {
                if (direccion.principal && direccion.direccion_direccion !== value) {
                    direccion.direccion_direccion = value;
                }
                return direccion;
            }, this);

            // Adding a new direccion
            if (direcciones.length == 0) {
                direcciones.push({
                    direccion_direccion: value,
                    principal: true
                });
            }

            return direcciones;
        }

        if (this.view.action === 'filter-rows') {
            return value;
        }
    },

    /**
     * Apply focus on the new direccion input field.
     */
    focus: function () {
        if (this.action !== 'disabled') {
            this._getNewDireccionField().focus();
        }
    },

    /**
     * Retrieve link specific telefono options for launching the telefono client
     * Builds upon telefonoOptions on this
     *
     * @param $link
     * @private
     */
    _retrieveDireccionOptionsFromLink: function ($link) {
        return {
            to_direcciones: [
                {
                    direccion: $link.data('direccion-to'),
                    bean: this.direccionOptions.related
                }
            ]
        };
    }


})
