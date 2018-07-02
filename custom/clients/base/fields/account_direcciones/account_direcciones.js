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
        'change .existingCalle': 'updateExistingDireccion',
        'change .existingNumInt': 'updateExistingDireccion',
        'change .existingNumExt': 'updateExistingDireccion',
        'change .existingPais': 'updateExistingDireccionDropdown',
        'change .existingEstado': 'updateExistingDireccionDropdown',
        'change .existingIndicador': 'updateIndicador',
        'change .newIndicador': 'updateIndicador',
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
        //'change .existingMultiClass': 'updateIndicador',

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
        this.def.pais_list_html = pais_list_html;
        this.def.estado_html = '<option value="">Seleccionar Estado </option>';
        this.def.municipio_html = '<option value="">Seleccionar Municipio </option>';
        this.def.postal_html = '<option value="">Seleccionar Codigo Postal </option>';

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

        this.model.addValidationTask('check_multiple_fiscal', _.bind(this._doValidateDireccionFiscal, this));
        this.model.addValidationTask('check_multiple_fiscalCorrespondencia', _.bind(this._doValidateDireccionFiscalCorrespondencia, this));
        //Ajuste Dirección Nacional
        this.model.addValidationTask('check_direccion_nacional', _.bind(this._doValidateDireccionNacional, this));
    },

    updateValueIndicadorMultiselect:function (evt) {
        var valores=evt.val;
        var id= this._getIndicador(null,valores);
        //Estableciendo valores para solo 1 valor seleccionado
        /*
        if(valores.length==1){
            if(valores[0]=="1"){
                $('.newIndicador').val("1");
            }else if(valores[0]=="2"){
                $('.newIndicador').val("2");
            }else if(valores[0]=="3"){
                $('.newIndicador').val("4");
            }else if(valores[0]==""){
                $('.newIndicador').val("");
            }

        }
        //Estableciendo valores para 2 valores seleccionados
        else if(valores.length==2){
            //var a = fruits.indexOf("Banana");
            if(valores.indexOf("1") != -1 && valores.indexOf("2") != -1){
                $('.newIndicador').val("3");
            }
            else if(valores.indexOf("1") != -1 && valores.indexOf("3") != -1){
                $('.newIndicador').val("5");
            }
            else if(valores.indexOf("2") != -1 && valores.indexOf("3") != -1){
                $('.newIndicador').val("6");
            }

        }
        //Estableciendo opcion para cuando se eligen los 3 valores
        else if(valores.length==3){
            $('.newIndicador').val("7");
        }
        //Estableciendo valor vacio
        else if(valores.length==0){
            $('.newIndicador').val("");
        }
         */
        $('.newIndicador').val(id);
        $('.newIndicador').trigger("change");

    },

    updateValueIndicadorExisting:function (evt) {
        var valorEx=evt.val;
        var id = this._getIndicador(null,valorEx);
        //evt.target.parentElement.previousElementSibling.children[1].value=“3”
        /*
        //Estableciendo valores para solo 1 valor seleccionado
        if(valorEx.length==1){
            if(valorEx[0]=="1"){
                evt.target.parentElement.previousElementSibling.children[1].value="1";
            }else if(valorEx[0]=="2"){
                evt.target.parentElement.previousElementSibling.children[1].value="2";
            }else if(valorEx[0]=="3"){
                evt.target.parentElement.previousElementSibling.children[1].value="4";
            }else if(valorEx[0]==""){
                evt.target.parentElement.previousElementSibling.children[1].value="";
            }

        }
        //Estableciendo valores para 2 valores seleccionados
        else if(valorEx.length==2){
            //var a = fruits.indexOf("Banana");
            if(valorEx.indexOf("1") != -1 && valorEx.indexOf("2") != -1){
                evt.target.parentElement.previousElementSibling.children[1].value="3";
            }
            else if(valorEx.indexOf("1") != -1 && valorEx.indexOf("3") != -1){
                evt.target.parentElement.previousElementSibling.children[1].value="5";
            }
            else if(valorEx.indexOf("2") != -1 && valorEx.indexOf("3") != -1){
                evt.target.parentElement.previousElementSibling.children[1].value="6";
            }

        }
        //Estableciendo opcion para cuando se eligen los 3 valores
        else if(valorEx.length==3){
            evt.target.parentElement.previousElementSibling.children[1].value="7";
        }
        //Estableciendo valor vacio
        else if(valorEx.length==0){
            evt.target.parentElement.previousElementSibling.children[1].value="";
        }*/

        //evt.target.parentElement.previousElementSibling.children[1].value=id;
        evt.target.parentElement.children[1].value=id;
        //$('.existingIndicador').trigger("change");
        //Lanzando evento change para únicamente borrar el valor de indicador correspondiente a la misma fila del multiselect modificado
        //$(evt.target).parent().parent().children().eq(1).trigger('change');
        $(evt.target).parent().parent().find('.existingIndicador').trigger('change');


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
            /*
            if(valores.length==2){
                if(valores.indexOf("1") != -1 && valores.indexOf("3") != -1){
                    $('.newIndicador').val("5");
                }
            }
            if(valores.length==1){
                if(valores.indexOf("1") != -1){
                    $('.newIndicador').val("1");
                }else if(valores.indexOf("3")!= -1){
                    $('.newIndicador').val("4");
                }
            }
             */

            //Obteniendo valores multiselect existing
            var valoresExisting=$(evt.target).parent().parent().find('select.existingMultiClass').select2('val');
            var indexExisting=valoresExisting.indexOf("2");
            valoresExisting.splice(indexExisting,1);
            $(evt.target).parent().parent().find('select.existingMultiClass').select2('val',valoresExisting);
            $(evt.target).val(this._getIndicador(null,valoresExisting));
            /*
            if(valoresExisting.length==2){
                if(valoresExisting.indexOf("1") != -1 && valoresExisting.indexOf("3") != -1){
                    $(evt.target).val("5");
                }
            }
            if(valoresExisting.length==1){
                if(valoresExisting.indexOf("1") != -1){
                    $(evt.target).val("1");
                }else if(valoresExisting.indexOf("3")!= -1){
                    $(evt.target).val("1");
                }
            }
             */

            $input.focus();
            this.fiscalCounter = 0;
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

        if(this.model.get("tipo_registro_c") == "Cliente"){
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
                var alertOptions = {title: "Se requiere de almenos una direccion fiscal y una de correspondencia.", level: "error"};
                app.alert.show('validation', alertOptions);

                errors['account_direcciones'] = errors['account_direcciones'] || {};
                errors['account_direcciones'].required = true;
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
        //get field that changed
        var $input = this.$(evt.currentTarget);
        //get field type
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            index = $inputs.index($input),
            dropdown_value = $input.val(),
            primaryRemoved;

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
            $selColonia.empty();
            //Cargamos los
            console.log("CODIGO a lanzar")
            //console.log($('select.'+class_name+' :selected').text());

            //console.log('$input');
            //console.log($input);
            var zipcode_to_trigger = "";
            //zipcode_to_trigger =$('select.'+class_name+' :selected').text();
            zipcode_to_trigger = $input.find(":selected").text();
            id_codigo = $input.find(":selected").val();
            id_filtro_colonia = id_codigo.substr(0, 9) +""+zipcode_to_trigger;

            $selColonia.append($("<option>").val('').html(''));
            var url = app.api.buildURL("dire_Colonia", null, null, {
                fields: "name",
                max_num: 50,
                "filter": [
                    {
                        "id": {
                            "$starts" : id_filtro_colonia
                            }

                    }
                ]
            });
            console.log(url);
            app.api.call('read', url, null, {
                success: _.bind(function (colonias) {
                    $.each(colonias.records, function (colonia_id, colonia) {
                        //console.log(colonia.name);
                        if (colonia.id == $selColonia.next().val()) {
                            $selColonia.append($("<option selected='selected'>").val(colonia.id).html(colonia.name));
                        } else {
                            $selColonia.append($("<option>").val(colonia.id).html(colonia.name));
                        }
                    });
                }, this)
            });
        }

        //*/
        //*
        //update model with new value
        //only update model on existing records
        if ($.inArray(class_name, ['existingPais', 'existingEstado', 'existingMunicipio', 'existingPostal', 'existingIndicador', 'existingCiudad', 'existingColonia']) != -1) {
            this._updateExistingDireccionInModel(index, dropdown_value, field_name);
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
        $('#multi1').select2({
            width:'100%',
            //minimumResultsForSearch:7,
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        /*
        $('#existingMulti1').select2({
            width:'100%',
            //minimumResultsForSearch:7,
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });
         */

        //Obteniendo valores de multiselect
        //$('#multi1').select2('val');
        if (this.tplName === 'edit') {
            //get realted records
            _.each(this.model.get('account_direcciones'), function (direccion) {
                direccionsHtml += this._buildDireccionFieldHtml(direccion);
            }, this);
            this.$el.prepend(direccionsHtml);

            $('select.existingIndicador').hide();

            //Cambia estructura para multiseelct
            $('select.existingMultiClass').each(function(){
                $(this).select2({
                    width:'100%',
                    closeOnSelect: false,
                    containerCssClass: 'select2-choices-pills-close'
                });
            });

            //Obteniendo valores de Indicador
            self=this;
            $("select.existingIndicador").each(function(i, obj) {
                var valuesI=self._getIndicador($(this).val(),null);
                $('select.existingMultiClass').eq(i).select2('val',valuesI);

                //$('select.existingMultiClass').select2('val',['1','2'])
            });


            //Establece valor para multiselect
            /*
            var arrrayA = [];
            var c=0;
            $('select.existingIndicador').each(function(){
                //console.log($(this).find('.existingIndicador').val())
                arrrayA[c] = $(this).val();
                c++;

            });

            var c=0;
            var self = this;
            $("select.existingMultiClass").each(function(){
                //console.log($(this));
                var valuesI =  self._getIndicador(arrrayA[c]); //['1'];
                $(this).val(valuesI);
                $(this).trigger('change');
                c++;
            });
             */


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

    _getIndicador: function(idSelected, valuesSelected) {

    //idSelected = valor en campo indicador
    //valuesSelected =  valore en multiselect

    //variable con resultado
    var result = null;

    //Arma objeto de mapeo
    var dir_indicador_map_list = app.lang.getAppListStrings('dir_indicador_map_list');

    var element = {};
    var object = [];
    var values = [];

    for(var key in dir_indicador_map_list) {
        console.log(key);
        console.log(dir_indicador_map_list[key]);
        var element = {};
        element.id = key;
        values = dir_indicador_map_list[key].split(",");
        element.values = values;
        object.push(element);
    }
    console.log(object);


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
        /*
        var dir_indicadorMulti_list = {
            "1":"Correspondencia",
            "2":"Fiscal",
            "1":"Entrega de Bienes",
        }
         */


        /*
        $('#existingMulti1').select2({
            width:'100%',
            //minimumResultsForSearch:7,
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });
         */



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
        //$("#existingMulti1").val(valores_get);
        //$("#existingMulti1").trigger("change");
        /*
        $('#existingMulti1').select2(valores_get);
        $('#existingMulti1').trigger('change');
         */

         //indicador multiseelct
        var indicador_multi_html = '<option value=""></option>';
        for (indicador_id in dir_indicador_unique_list) {
            indicador_multi_html += '<option value="' + indicador_id + '" >' + dir_indicador_unique_list[indicador_id] + '</option>';
        }

        var ciudad_html = '<option value="xkcd"> Seleccionar Ciudad</option>';
        for (city_id in city_list) {
            if (city_list[city_id].estado_id == direccion.dire_direccion_dire_estadodire_estado_ida) {
                if (city_id == direccion.ciudad) {
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

        return editDireccionFieldTemplate({
            max_length: this.def.len,
            index: index === -1 ? direcciones.length - 1 : index,
            tipodedireccion: dir_tipo_list_html,
            pais: pais_list_html,
            estado_html: estado_html,
            municipio_html: municipio_html,
            indicador_html: indicador_html,
            indicador_multi_html: indicador_multi_html,
            ciudad_html: ciudad_html,
            postal_html: postal_html,
            postal: postal,
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
        if ($('.newTipodedireccion').val() == '0') {
            errorMsg = 'Tipo de direccion requerido';
            dirError = true; dirErrorCounter++;
            $('.newTipodedireccion').css('border-color', 'red');
        } else {
            $('.newTipodedireccion').css('border-color', '');
        }

        //Valida indicador
        if ($('.newIndicador').val() == '') {
            errorMsg = 'Indicador de direccion requerido';
            dirError = true; dirErrorCounter++;
            $('.newIndicador').css('border-color', 'red');
        } else {
            $('.newIndicador').css('border-color', '');

        }

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
            if(dirErrorCounter > 1) errorMsg = 'Hay campos vacios en la direccion.'
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
            var country_model = app.metadata.getCountry($('.newPaisDir').val());
            var postal_model = app.metadata.getPostalCode($('.newPostal').val());
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
                pais: $('.newPaisDir').val(),
                dire_direccion_dire_paisdire_pais_ida: country_id,
                estado: $('.newEstado').val(),
                dire_direccion_dire_estadodire_estado_ida: $('.newEstado').val(),
                municipio: $('.newMunicipio').val(),
                indicador: $('.newIndicador').val(),
                indicador_label: dir_indicador_list[$('.newIndicador').val()],
                //Añadiendo nuevo atributo
                indicador_multi:$("#multi1").val(),

                dire_direccion_dire_municipiodire_municipio_ida: $('.newMunicipio').val(),
                ciudad: $('.newCiudad').val(),
                dire_direccion_dire_ciudaddire_ciudad_ida: $('.newCiudad').val(),
                postal: $('.newPostal').val(),
                dire_direccion_dire_codigopostaldire_codigopostal_ida: $('.newPostal').val(),
                colonia_new_html: $('.newColonia').html(),
                colonia: $('.newColonia').val(),
                dire_direccion_dire_coloniadire_colonia_ida: $('.newColonia').val(),
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

            $('select.existingMultiClass').each(function(){
                $(this).select2({
                    width:'100%',
                    closeOnSelect: false,
                    containerCssClass: 'select2-choices-pills-close'
                });
            });

            //Obteniendo valores de Indicador
            self=this;
            $("select.existingIndicador").each(function(i, obj) {
                var valuesI=self._getIndicador($(this).val(),null);
                $('select.existingMultiClass').eq(i).select2('val',valuesI);

                //$('select.existingMultiClass').select2('val',['1','2'])
            });

            /*
             var arrrayA = [];
             var c=0;
             $('select.existingIndicador').each(function(){
             //console.log($(this).find('.existingIndicador').val())
             arrrayA[c] = $(this).val();
             c++;

             });

             var c=0;
             var self = this;
             $("select.existingMultiClass").each(function(){
             //console.log($(this));
             var valuesI =  self._getIndicador(arrrayA[c]); //['1'];
             $(this).val(valuesI);
             $(this).trigger('change');
             c++;
             });
             */


            /*
            var valores=$("#multi1").val();
            $("#existingMulti1").val(valores);
            $("#existingMulti1").trigger("change");
             */

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
        var postal_model = app.metadata.getPostalCode($('.newPostal').val());
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
        existingDirecciones.push({
            tipodedireccion: $('.newTipodedireccion').val(),
            tipo_label: dir_tipo_list[$('.newTipodedireccion').val()],
            //pais: $('.newPaisDir').val(),
            pais: country_id,
            dire_direccion_dire_paisdire_pais_ida: country_id,
            estado: $('.newEstado').val(),
            dire_direccion_dire_estadodire_estado_ida: $('.newEstado').val(),
            municipio: $('.newMunicipio').val(),
            dire_direccion_dire_municipiodire_municipio_ida: $('.newMunicipio').val(),
            indicador: $('.newIndicador').val(),
            indicador_label: dir_indicador_list[$('.newIndicador').val()],
            ciudad: $('.newCiudad').val(),
            dire_direccion_dire_ciudaddire_ciudad_ida: $('.newCiudad').val(),
            postal: $('.newPostal').val(),
            codigopostal: $('.newPostal').val(),
            dire_direccion_dire_codigopostaldire_codigopostal_ida: $('.newPostal').val(),
            colonia: $('.newColonia').val(),
            dire_direccion_dire_coloniadire_colonia_ida: $('.newColonia').val(),
            colonia_new_html: $('.newColonia').html(),
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

        return success;
    },
    /**
     * Update direccion direccion in the model.
     * @param {Number} index
     * @param {String} newdireccion
     * @private
     */
    _updateExistingDireccionInModel: function (index, newDireccion, field_name) {
        var existingDirecciones = app.utils.deepCopy(this.model.get('account_direcciones'));
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

        //limpiando campo multiSelect
        $("#multi1").select2('val',[]);
        $("#multi1").trigger('change');

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
