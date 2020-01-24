({
    /**
     * Modified by Adrian Arauz 20/12/2019
     */
    //Declaración de Listas de valores
    activo_listRI: null,
    plazo_listRI: null,

    events: {
        'click  .add_incremento_CondicionFinanciera': 'addNewCondicionFinanciera',
        'click  .remove_incremento_CondicionFinanciera': 'removeCondicionFinanciera',
        'change .new_incremento_Activo': 'ActualizaActivoFinanciera',
        'change .new_incremento_Plazo': 'ActualizaPlazoFinanciera',
        'change .porcentaje': 'checarPorcentajeRango',
        //Eventos para campos de tipo Select2
        'change .existing_incremento_Activo': 'updateActivo',
        'change .existing_incremento_Plazo': 'updatePlazo',
        //Eventos para campos tipo input
        'change .existing_incremento_TasaMinima': 'updatevalores',
        'change .existing_incremento_TasaMaxima': 'updatevalores',
        'change .existing_incremento_VRCMinimo': 'updatevalores',
        'change .existing_incremento_VRCMaximo': 'updatevalores',
        'change .existing_incremento_VRIMinimo': 'updatevalores',
        'change .existing_incremento_VRIMaximo': 'updatevalores',
        'change .existing_incremento_ComisionMinima': 'updatevalores',
        'change .existing_incremento_ComisionMaxima': 'updatevalores',
        'change .existing_incremento_RentaInicialMinima': 'updatevalores',
        'change .existing_incremento_RentaInicialMaxima': 'updatevalores',
        //Eventos para campos tipo checkbox
        'change .existing_incremento_Deposito': 'updatechecks',
        'change .existing_incremento_UsoParticular': 'updatechecks',
        'change .existing_incremento_UsoEmpresarial': 'updatechecks',
        'change .existing_incremento_ActivoNuevo': 'updatechecks',
    },


    initialize: function (options) {

        options = options || {};
        options.def = options.def || {};
        contRI = this;
        this._super('initialize', [options]);
        this.listascfRI();



    },

    listascfRI: function () {
        this.activo_listRI = app.lang.getAppListStrings('idactivo_list');
        this.plazo_listRI = app.lang.getAppListStrings('plazo_0');
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    bindDomChange: function () {
        if (this.tplName === 'list-edit') {
            this._super("bindDomChange");
        }
    },

    _render: function () {
        this._super("_render");
    },

    //Evento que actualiza los campos de la condicion con base en el activo seleccionado (condiciones existentes)
    updateActivo: function(evt) {
        var inputs = this.$('[data-field="ActivoRI"].existing_incremento_Activo'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var tipo = input.val();
        //Pregunta que el nuevo activo sea diferente al del modelo para establecer
        // todos los valores acorde al plazo 1_12 del activo nuevo.

        if(contRI.oFinancieraRI.ratificacion[index].idactivo !=tipo){
            contRI.oFinancieraRI.ratificacion[index].idactivo=tipo;
            contRI.oFinancieraRI.ratificacion[index].plazo="1_12";
            contRI.oFinancieraRI.ratificacion[index].tasa_minima=cont_cf.activos[tipo]["1_12"].tasa_minima;
            contRI.oFinancieraRI.ratificacion[index].tasa_maxima=cont_cf.activos[tipo]["1_12"].tasa_maxima;
            contRI.oFinancieraRI.ratificacion[index].vrc_minimo=cont_cf.activos[tipo]["1_12"].vrc_minimo;
            contRI.oFinancieraRI.ratificacion[index].vrc_maximo=cont_cf.activos[tipo]["1_12"].vrc_maximo;
            contRI.oFinancieraRI.ratificacion[index].vri_minimo=cont_cf.activos[tipo]["1_12"].vri_minimo;
            contRI.oFinancieraRI.ratificacion[index].vri_maximo=cont_cf.activos[tipo]["1_12"].vri_maximo;
            contRI.oFinancieraRI.ratificacion[index].comision_minima=cont_cf.activos[tipo]["1_12"].comision_minima;
            contRI.oFinancieraRI.ratificacion[index].comision_maxima=cont_cf.activos[tipo]["1_12"].comision_maxima;
            contRI.oFinancieraRI.ratificacion[index].renta_inicial_minima=cont_cf.activos[tipo]["1_12"].renta_inicial_minima;
            contRI.oFinancieraRI.ratificacion[index].renta_inicial_maxima=cont_cf.activos[tipo]["1_12"].renta_inicial_maxima;
            contRI.oFinancieraRI.ratificacion[index].deposito_en_garantia=cont_cf.activos[tipo]["1_12"].deposito_en_garantia;
            contRI.oFinancieraRI.ratificacion[index].uso_particular=cont_cf.activos[tipo]["1_12"].uso_particular;
            contRI.oFinancieraRI.ratificacion[index].uso_empresarial=cont_cf.activos[tipo]["1_12"].uso_empresarial;
            contRI.oFinancieraRI.ratificacion[index].activo_nuevo=cont_cf.activos[tipo]["1_12"].activo_nuevo;
            contRI.render();
        }
    },
    //Evento que actualiza los campos de la condicion con base en el plazo seleccionado (condiciones existentes)
    updatePlazo: function(evt) {
        var inputs = this.$('[data-field="PlazoRI"].existing_incremento_Plazo'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var plazo = input.val();
        var activoselect = contRI.oFinancieraRI.ratificacion[index].idactivo;
        //Pregunta si el plazo es diferente al actual del modelo, sino actualiza dicho modelo
        // con base en el objeto cont_cf que contiene combinaciones de plazos y campos.
        if(contRI.oFinancieraRI.ratificacion[index].plazo!= plazo) {
            contRI.oFinancieraRI.ratificacion[index].plazo= plazo;
            contRI.oFinancieraRI.ratificacion[index].tasa_minima = cont_cf.activos[activoselect][plazo].tasa_minima;
            contRI.oFinancieraRI.ratificacion[index].tasa_maxima = cont_cf.activos[activoselect][plazo].tasa_maxima;
            contRI.oFinancieraRI.ratificacion[index].vrc_minimo = cont_cf.activos[activoselect][plazo].vrc_minimo;
            contRI.oFinancieraRI.ratificacion[index].vrc_maximo = cont_cf.activos[activoselect][plazo].vrc_maximo;
            contRI.oFinancieraRI.ratificacion[index].vri_minimo = cont_cf.activos[activoselect][plazo].vri_minimo;
            contRI.oFinancieraRI.ratificacion[index].vri_maximo = cont_cf.activos[activoselect][plazo].vri_maximo;
            contRI.oFinancieraRI.ratificacion[index].comision_minima = cont_cf.activos[activoselect][plazo].comision_minima;
            contRI.oFinancieraRI.ratificacion[index].comision_maxima = cont_cf.activos[activoselect][plazo].comision_maxima;
            contRI.oFinancieraRI.ratificacion[index].renta_inicial_minima = cont_cf.activos[activoselect][plazo].renta_inicial_minima;
            contRI.oFinancieraRI.ratificacion[index].renta_inicial_maxima = cont_cf.activos[activoselect][plazo].renta_inicial_maxima;
            contRI.oFinancieraRI.ratificacion[index].deposito_en_garantia = cont_cf.activos[activoselect][plazo].deposito_en_garantia;
            contRI.oFinancieraRI.ratificacion[index].uso_particular = cont_cf.activos[activoselect][plazo].uso_particular;
            contRI.oFinancieraRI.ratificacion[index].uso_empresarial = cont_cf.activos[activoselect][plazo].uso_empresarial;
            contRI.oFinancieraRI.ratificacion[index].activo_nuevo = cont_cf.activos[activoselect][plazo].activo_nuevo;
            contRI.render();
        }
    },

    updatechecks: function(evt){
        //Recupera valor del check modificado, obtiene nombre y concatena el name para obtener su posicion en el arreglo.
        var input = this.$(evt.currentTarget);
        var nombre= input[0].dataset.name;
        var inputs= this.$("[data-name='"+nombre+"']");
        var index = inputs.index(input);
        var valor= input.prop('checked');
        //Actualiza modelo con el valor de los checks modificados
        this.oFinancieraRI.ratificacion[index][nombre]=valor;

    },

    updatevalores: function(evt){
        //Recupera valor del campo modificado, obtiene nombre y concatena el name para obtener su posicion en el arreglo.
        var input = this.$(evt.currentTarget);
        var nombre= input[0].dataset.name;
        var inputs= this.$("[data-name='"+nombre+"']");
        var index = inputs.index(input);
        var numero= input.val();
        var exp= /(^100([.]0{1,2})?)$|(^\d{1,2}([.]\d{1,2})?)$|(^([.]\d{1,2})?)$/;
        if (!exp.test(numero)) {
            input.val("");
            input.css('border-color', 'red');
            app.alert.show('error_formatonumero_CFRI', {
                level: 'error',
                autoClose: false,
                messages: 'Sólo números son permitidos.'
            });
        }else {
            input.css('border-color', '');
            //Actualiza modelo con el valor de los campos modificados
            contRI.oFinancieraRI.ratificacion[index][nombre] = numero;
        }

    },

    addNewCondicionFinanciera: function (options) {
        if (this.oFinancieraRI == undefined) {
            //Crea el objeto
            this.oFinancieraRI = [];
            this.oFinancieraRI.ratificacion = [];
            this.prev_oFinancieraRI=[];
            this.prev_oFinancieraRI.prev_ratificacion=[];
        }
        if (this.$('.new_incremento_Activo').select2('val') !="" && this.$('.new_incremento_Activo').select2('val')!=null) {
            //Valida Plazo Requerido
            if (this.$('.new_incremento_Plazo').select2('val') === '') {
                this.$('.new_incremento_Plazo').find('.select2-choice').css('border-color', 'red');
                app.alert.show("Plazo requerido", {
                    level: "error",
                    title: "El campo Plazo es requerido.",
                    autoClose: false
                });
            }else {

                //Obtiene Valores de los campos
                var idActivo = this.$('.new_incremento_Activo').select2('val');
                var idplazo = this.$('.new_incremento_Plazo').select2('val');
                var tasa_minima = $('.new_incremento_TasaMinima').val();
                var tasa_maxima = $('.new_incremento_TasaMaxima').val();
                var vrc_minimo = $('.new_incremento_VRCMinimo').val();
                var vrc_maximo = $('.new_incremento_VRCMaximo').val();
                var vri_minimo = $('.new_incremento_VRIMinimo').val();
                var vri_maximo = $('.new_incremento_VRIMaximo').val();
                var comision_minima = $('.new_incremento_ComisionMinima').val();
                var comision_maxima = $('.new_incremento_ComisionMaxima').val();
                var renta_inicial_minima = $('.new_incremento_RentaInicialMinima').val();
                var renta_inicial_maxima = $('.new_incremento_RentaInicialMaxima').val();
                var deposito_en_garantia = $('.new_incremento_Deposito').prop("checked");
                var uso_particular = $('.new_incremento_UsoParticular').prop("checked");
                var uso_empresarial = $('.new_incremento_UsoEmpresarial').prop("checked");
                var activo_nuevo = $('.new_incremento_ActivoNuevo').prop("checked");

                //Valida formato de los campos, deben cumplir con la expreg
                var formato = 0;
                var exp = /(^100([.]0{1,2})?)$|(^\d{1,2}([.]\d{1,2})?)$|(^([.]\d{1,2})?)$/;
                if (!exp.test(tasa_minima)) {
                    formato++;
                    this.$('.new_incremento_TasaMinima').val("");
                    this.$('.new_incremento_TasaMinima').css('border-color', 'red');
                }
                if (!exp.test(tasa_maxima)) {
                    formato++;
                    this.$('.new_incremento_TasaMaxima').val("");
                    this.$('.new_incremento_TasaMaxima').css('border-color', 'red');
                }
                if (!exp.test(vrc_minimo)) {
                    formato++;
                    $('.new_incremento_VRCMinimo').val("");
                    $('.new_incremento_VRCMinimo').css('border-color', 'red');
                }
                if (!exp.test(vrc_maximo)) {
                    formato++;
                    $('.new_incremento_VRCMaximo').val("");
                    $('.new_incremento_VRCMaximo').css('border-color', 'red');
                }
                if (!exp.test(vri_minimo)) {
                    formato++;
                    $('.new_incremento_VRIMinimo').val("");
                    $('.new_incremento_VRIMinimo').css('border-color', 'red');
                }
                if (!exp.test(vri_maximo)) {
                    formato++;
                    $('.new_incremento_VRIMaximo').val("");
                    $('.new_incremento_VRIMaximo').css('border-color', 'red');
                }
                if (!exp.test(comision_minima)) {
                    formato++;
                    $('.new_incremento_ComisionMinima').val("");
                    $('.new_incremento_ComisionMinima').css('border-color', 'red');
                }
                if (!exp.test(comision_maxima)) {
                    formato++;
                    $('.new_incremento_ComisionMaxima').val("");
                    $('.new_incremento_ComisionMaxima').css('border-color', 'red');
                }
                if (!exp.test(renta_inicial_minima)) {
                    formato++;
                    $('.new_incremento_RentaInicialMinima').val("");
                    $('.new_incremento_RentaInicialMinima').css('border-color', 'red');
                }
                if (!exp.test(renta_inicial_maxima)) {
                    formato++;
                    $('.new_incremento_RentaInicialMaxima').val("");
                    $('.new_incremento_RentaInicialMaxima').css('border-color', 'red');
                }
                if (formato > 0) {
                    app.alert.show('Campos_sin_formato adecuado_RI', {
                        level: 'error',
                        autoClose: false,
                        messages: "Alguno de los campos a agregar no cumple con el formato.<br>Sólo números son permitidos."
                    });
                } else {
                    //Crea objeto condiciones financieras RI
                    var condfinRI = {
                        "id": "",
                        "idactivo": idActivo,
                        "plazo": idplazo,
                        "tasa_minima": tasa_minima,
                        "tasa_maxima": tasa_maxima,
                        "vrc_minimo": vrc_minimo,
                        "vrc_maximo": vrc_maximo,
                        "vri_minimo": vri_minimo,
                        "vri_maximo": vri_maximo,
                        "comision_minima": comision_minima,
                        "comision_maxima": comision_maxima,
                        "renta_inicial_minima": renta_inicial_minima,
                        "renta_inicial_maxima": renta_inicial_maxima,
                        "deposito_en_garantia": deposito_en_garantia,
                        "uso_particular": uso_particular,
                        "uso_empresarial": uso_empresarial,
                        "activo_nuevo": activo_nuevo
                    };

                    //Setea valores al objeto
                    this.oFinancieraRI.ratificacion.push(condfinRI);
                    this.model.set('condiciones_financieras_incremento_ratificacion', this.oFinancieraRI.ratificacion);
                    this.render();
                }
            }
        }else{
            $('.new_incremento_Activo').find('.select2-choice').css('border-color', 'red');
            app.alert.show("Activo requerido", {
                level: "error",
                title: "El campo Activo es requerido.",
                autoClose: false
            });
        }

    },
    //Evento que remueve la condicion del objeto
    removeCondicionFinanciera: function (evt){
        var input = this.$(evt.currentTarget);
        var nombre= input[0].dataset.name;
        var inputs= this.$("[data-name='"+nombre+"']");
        var index = inputs.index(input);
        //Elimina el objeto de la lista
        contRI.oFinancieraRI.ratificacion.splice([index],1);
        contRI.render();
    },

    //Evento que actualiza los campos de la condicion con base en el activo seleccionado
    ActualizaActivoFinanciera: function (evt){
        var inputs = this.$('.new_incremento_Activo'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var tipo = input.val();

        contRI.$('.new_incremento_Activo').select2('val', tipo);
        contRI.$('.new_incremento_Plazo').select2("val", "1_12");
        contRI.$('.new_incremento_TasaMinima').val(cont_cf.activos[tipo]["1_12"].tasa_minima);
        $('.new_incremento_TasaMaxima').val(cont_cf.activos[tipo]["1_12"].tasa_maxima);
        $('.new_incremento_VRCMinimo').val(cont_cf.activos[tipo]["1_12"].vrc_minimo);
        $('.new_incremento_VRCMaximo').val(cont_cf.activos[tipo]["1_12"].vrc_maximo);
        $('.new_incremento_VRIMinimo').val(cont_cf.activos[tipo]["1_12"].vri_minimo);
        $('.new_incremento_VRIMaximo').val(cont_cf.activos[tipo]["1_12"].vri_maximo);
        $('.new_incremento_ComisionMinima').val(cont_cf.activos[tipo]["1_12"].comision_minima);
        $('.new_incremento_ComisionMaxima').val(cont_cf.activos[tipo]["1_12"].comision_maxima);
        $('.new_incremento_RentaInicialMinima').val(cont_cf.activos[tipo]["1_12"].renta_inicial_minima);
        $('.new_incremento_RentaInicialMaxima').val(cont_cf.activos[tipo]["1_12"].renta_inicial_maxima);
        $('.new_incremento_Deposito').prop('checked',cont_cf.activos[tipo]["1_12"].deposito_en_garantia);
        $('.new_incremento_UsoParticular').prop('checked',cont_cf.activos[tipo]["1_12"].uso_particular);
        $('.new_incremento_UsoEmpresarial').prop('checked',cont_cf.activos[tipo]["1_12"].uso_empresarial);
        $('.new_incremento_ActivoNuevo').prop('checked',cont_cf.activos[tipo]["1_12"].activo_nuevo);
    },
    //Evento que actualiza los campos de la condicion con base en el Plazo seleccionado
    ActualizaPlazoFinanciera: function (evt){
        var inputs = this.$('.new_incremento_Plazo'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var plazo = input.val();
        var activoselect = contRI.$('.new_incremento_Activo')[1].value;


        contRI.$('.new_incremento_Plazo').select2("val", plazo);
        contRI.$('.new_incremento_TasaMinima').val(cont_cf.activos[activoselect][plazo].tasa_minima);
        $('.new_incremento_TasaMaxima').val(cont_cf.activos[activoselect][plazo].tasa_maxima);
        $('.new_incremento_VRCMinimo').val(cont_cf.activos[activoselect][plazo].vrc_minimo);
        $('.new_incremento_VRCMaximo').val(cont_cf.activos[activoselect][plazo].vrc_maximo);
        $('.new_incremento_VRIMinimo').val(cont_cf.activos[activoselect][plazo].vri_minimo);
        $('.new_incremento_VRIMaximo').val(cont_cf.activos[activoselect][plazo].vri_maximo);
        $('.new_incremento_ComisionMinima').val(cont_cf.activos[activoselect][plazo].comision_minima);
        $('.new_incremento_ComisionMaxima').val(cont_cf.activos[activoselect][plazo].comision_maxima);
        $('.new_incremento_RentaInicialMinima').val(cont_cf.activos[activoselect][plazo].renta_inicial_minima);
        $('.new_incremento_RentaInicialMaxima').val(cont_cf.activos[activoselect][plazo].renta_inicial_maxima);
        $('.new_incremento_Deposito').prop('checked',cont_cf.activos[activoselect][plazo].deposito_en_garantia);
        $('.new_incremento_UsoParticular').prop('checked',cont_cf.activos[activoselect][plazo].uso_particular);
        $('.new_incremento_UsoEmpresarial').prop('checked',cont_cf.activos[activoselect][plazo].uso_empresarial);
        $('.new_incremento_ActivoNuevo').prop('checked',cont_cf.activos[activoselect][plazo].activo_nuevo);

    },

    //Función que vaida el tamaño de los campos de %//
    checarPorcentajeRango: function(evt){
        var valor_campo = $(evt.currentTarget).val();
        var valor_maximo = $('.' +$(evt.currentTarget).attr('data-max')).val();
        var valor_minimo = $('.' +$(evt.currentTarget).attr('data-min')).val();

        if(parseInt(valor_campo) > 99.99){
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MAYOR_RANGO', 'lev_CondicionesFinancieras')
            });
            $(evt.currentTarget).val('99.99');
            $(evt.currentTarget).focus();
        }

        if(parseInt(valor_campo) < 1){
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MENOR_RANGO', 'lev_CondicionesFinancieras')
            });
            $(evt.currentTarget).val('1');
            $(evt.currentTarget).focus();
        }

        if(parseInt(valor_campo) >  valor_maximo && !_.isEmpty(valor_maximo)){
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MAYOR_A_MAXIMO', 'lev_CondicionesFinancieras') + " : " + valor_maximo
            });
            $(evt.currentTarget).val(valor_maximo);
            $(evt.currentTarget).focus();
        }

        if(parseInt(valor_campo) < valor_minimo && !_.isEmpty(valor_minimo)){
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MENOR_MINIMO', 'lev_CondicionesFinancieras') + " : " + valor_minimo
            });
            $(evt.currentTarget).val(valor_minimo);
            $(evt.currentTarget).focus();
        }
        var input = this.$(evt.currentTarget);
        var nombre= input[0].dataset.name;
        var inputs= this.$("[data-name='"+nombre+"']");
        var index = inputs.index(input);
        contRI.oFinancieraRI.ratificacion[index][nombre]=input[index].value;
    },
})
