({
    /**
     * Modified by Adrian Arauz 21/11/2019
     */
    //Declaración de Listas de valores
    activo_list: null,
    plazo_list: null,

    events: {
        'click  .addCondicionFinanciera': 'addNewCondicionFinanciera',
        'click  .removeCondicionFinanciera': 'removeCondicionFinanciera',
        'change .newActivo': 'ActualizaActivoFinanciera',
        'change .newPlazo': 'ActualizaPlazoFinanciera',
        //Eventos para campos de tipo Select2
        'change .existingActivo': 'updateActivo',
        'change .existingPlazo': 'updatePlazo',
        //Eventos para campos tipo input
        'change .existingTasaMinima': 'updatevalores',
        'change .existingTasaMaxima': 'updatevalores',
        'change .existingVRCMinimo': 'updatevalores',
        'change .existingVRCMaximo': 'updatevalores',
        'change .existingVRIMinimo': 'updatevalores',
        'change .existingVRIMaximo': 'updatevalores',
        'change .existingComisionMinima': 'updatevalores',
        'change .existingComisionMaxima': 'updatevalores',
        'change .existingRentaInicialMinima': 'updatevalores',
        'change .existingRentaInicialMaxima': 'updatevalores',
        //Eventos para campos tipo checkbox
        'change .existingDeposito': 'updatechecks',
        'change .existingUsoParticular': 'updatechecks',
        'change .existingUsoEmpresarial': 'updatechecks',
        'change .existingActivoNuevo': 'updatechecks',

    },

    initialize: function (options) {

        //window.contador=0;
        options = options || {};
        options.def = options.def || {};
        cont_cf = this;
        this._super('initialize', [options]);
        this.listascf();


    },

    listascf: function () {
    this.activo_list = app.lang.getAppListStrings('idactivo_list');
    this.plazo_list = app.lang.getAppListStrings('plazo_0');
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
        var inputs = this.$('[data-field="Activo"].existingActivo'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var tipo = input.val();
        //Pregunta que el nuevo activo sea diferente al del modelo para establecer
        // todos los valores acorde al plazo 1_12 del activo nuevo.

        if(cont_cf.oFinanciera.condicion[index].idactivo !=tipo){
            cont_cf.oFinanciera.condicion[index].idactivo=tipo;
            cont_cf.oFinanciera.condicion[index].plazo="1_12";
            cont_cf.oFinanciera.condicion[index].tasa_minima=cont_cf.activos[tipo]["1_12"].tasa_minima;
            cont_cf.oFinanciera.condicion[index].tasa_maxima=cont_cf.activos[tipo]["1_12"].tasa_maxima;
            cont_cf.oFinanciera.condicion[index].vrc_minimo=cont_cf.activos[tipo]["1_12"].vrc_minimo;
            cont_cf.oFinanciera.condicion[index].vrc_maximo=cont_cf.activos[tipo]["1_12"].vrc_maximo;
            cont_cf.oFinanciera.condicion[index].vri_minimo=cont_cf.activos[tipo]["1_12"].vri_minimo;
            cont_cf.oFinanciera.condicion[index].vri_maximo=cont_cf.activos[tipo]["1_12"].vri_maximo;
            cont_cf.oFinanciera.condicion[index].comision_minima=cont_cf.activos[tipo]["1_12"].comision_minima;
            cont_cf.oFinanciera.condicion[index].comision_maxima=cont_cf.activos[tipo]["1_12"].comision_maxima;
            cont_cf.oFinanciera.condicion[index].renta_inicial_minima=cont_cf.activos[tipo]["1_12"].renta_inicial_minima;
            cont_cf.oFinanciera.condicion[index].renta_inicial_maxima=cont_cf.activos[tipo]["1_12"].renta_inicial_maxima;
            cont_cf.oFinanciera.condicion[index].deposito_en_garantia=cont_cf.activos[tipo]["1_12"].deposito_en_garantia;
            cont_cf.oFinanciera.condicion[index].uso_particular=cont_cf.activos[tipo]["1_12"].uso_particular;
            cont_cf.oFinanciera.condicion[index].uso_empresarial=cont_cf.activos[tipo]["1_12"].uso_empresarial;
            cont_cf.oFinanciera.condicion[index].activo_nuevo=cont_cf.activos[tipo]["1_12"].activo_nuevo;
            cont_cf.render();
        }
    },
    //Evento que actualiza los campos de la condicion con base en el plazo seleccionado (condiciones existentes)
    updatePlazo: function(evt) {
        var inputs = this.$('[data-field="Plazo"].existingPlazo'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var plazo = input.val();
        var activoselect = cont_cf.oFinanciera.condicion[index].idactivo;
        //Pregunta si el plazo es diferente al actual del modelo, sino actualiza dicho modelo
        // con base en el objeto cont_cf que contiene combinaciones de plazos y campos.
        if( cont_cf.oFinanciera.condicion[index].plazo!= plazo) {
            cont_cf.oFinanciera.condicion[index].plazo= plazo;
            cont_cf.oFinanciera.condicion[index].tasa_minima = cont_cf.activos[activoselect][plazo].tasa_minima;
            cont_cf.oFinanciera.condicion[index].tasa_maxima = cont_cf.activos[activoselect][plazo].tasa_maxima;
            cont_cf.oFinanciera.condicion[index].vrc_minimo = cont_cf.activos[activoselect][plazo].vrc_minimo;
            cont_cf.oFinanciera.condicion[index].vrc_maximo = cont_cf.activos[activoselect][plazo].vrc_maximo;
            cont_cf.oFinanciera.condicion[index].vri_minimo = cont_cf.activos[activoselect][plazo].vri_minimo;
            cont_cf.oFinanciera.condicion[index].vri_maximo = cont_cf.activos[activoselect][plazo].vri_maximo;
            cont_cf.oFinanciera.condicion[index].comision_minima = cont_cf.activos[activoselect][plazo].comision_minima;
            cont_cf.oFinanciera.condicion[index].comision_maxima = cont_cf.activos[activoselect][plazo].comision_maxima;
            cont_cf.oFinanciera.condicion[index].renta_inicial_minima = cont_cf.activos[activoselect][plazo].renta_inicial_minima;
            cont_cf.oFinanciera.condicion[index].renta_inicial_maxima = cont_cf.activos[activoselect][plazo].renta_inicial_maxima;
            cont_cf.oFinanciera.condicion[index].deposito_en_garantia = cont_cf.activos[activoselect][plazo].deposito_en_garantia;
            cont_cf.oFinanciera.condicion[index].uso_particular = cont_cf.activos[activoselect][plazo].uso_particular;
            cont_cf.oFinanciera.condicion[index].uso_empresarial = cont_cf.activos[activoselect][plazo].uso_empresarial;
            cont_cf.oFinanciera.condicion[index].activo_nuevo = cont_cf.activos[activoselect][plazo].activo_nuevo;
            cont_cf.render();
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
        this.oFinanciera.condicion[index][nombre]=valor;

    },

    updatevalores: function(evt){
        //Recupera valor del campo modificado, obtiene nombre y concatena el name para obtener su posicion en el arreglo.
        var input = this.$(evt.currentTarget);
        var nombre= input[0].dataset.name;
        var inputs= this.$("[data-name='"+nombre+"']");
        var index = inputs.index(input);
        var numero= input.val();
        //Actualiza modelo con el valor de los campos modificados
        this.oFinanciera.condicion[index][nombre]=numero;

    },

    addNewCondicionFinanciera: function (options) {
        if (this.oFinanciera == undefined) {
            //Crea el objeto
            this.oFinanciera = [];
            this.oFinanciera.condicion = [];
            this.prev_oFinanciera=[];
            this.prev_oFinanciera.prev_condicion=[];
        }
        if (this.$('.newActivo').select2('val') !="" && this.$('.newActivo').select2('val')!=null) {
            //Valida Plazo Requerido
            if (this.$('.newPlazo').select2('val') === '') {
                this.$('.newPlazo').find('.select2-choice').css('border-color', 'red');
                app.alert.show("Plazo requerido", {
                    level: "error",
                    title: "El campo Plazo es requerido.",
                    autoClose: false
                });
            }else {

                //Obtiene Valores de los campos
                var idActivo = this.$('.newActivo').select2('val');
                var idplazo = this.$('.newPlazo').select2('val');
                var tasa_minima = $('.newTasaMinima').val();
                var tasa_maxima = $('.newTasaMaxima').val();
                var vrc_minimo = $('.newVRCMinimo').val();
                var vrc_maximo = $('.newVRCMaximo').val();
                var vri_minimo = $('.newVRIMinimo').val();
                var vri_maximo = $('.newVRIMaximo').val();
                var comision_minima = $('.newComisionMinima').val();
                var comision_maxima = $('.newComisionMaxima').val();
                var renta_inicial_minima = $('.newRentaInicialMinima').val();
                var renta_inicial_maxima = $('.newRentaInicialMaxima').val();
                var deposito_en_garantia = $('.newDeposito').prop("checked");
                var uso_particular = $('.newUsoParticular').prop("checked");
                var uso_empresarial = $('.newUsoEmpresarial').prop("checked");
                var activo_nuevo = $('.newActivoNuevo').prop("checked");




                //Crea objeto condiciones financieras
                var condfin = {
                    "id":"",
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
                this.oFinanciera.condicion.push(condfin);
                this.model.set('condiciones_financieras', this.oFinanciera.condicion);
                this.render();
            }
        }else{
            $('.newActivo').find('.select2-choice').css('border-color', 'red');
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
        this.oFinanciera.condicion.splice([index],1);
        this.render();
    },

    //Evento que actualiza los campos de la condicion con base en el activo seleccionado
    ActualizaActivoFinanciera: function (evt){
        var inputs = this.$('.newActivo'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var tipo = input.val();

        cont_cf.$('.newActivo').select2('val', tipo);
        cont_cf.$('.newPlazo').select2("val", "1_12");
        cont_cf.$('.newTasaMinima').val(cont_cf.activos[tipo]["1_12"].tasa_minima);
        $('.newTasaMaxima').val(cont_cf.activos[tipo]["1_12"].tasa_maxima);
        $('.newVRCMinimo').val(cont_cf.activos[tipo]["1_12"].vrc_minimo);
        $('.newVRCMaximo').val(cont_cf.activos[tipo]["1_12"].vrc_maximo);
        $('.newVRIMinimo').val(cont_cf.activos[tipo]["1_12"].vri_minimo);
        $('.newVRIMaximo').val(cont_cf.activos[tipo]["1_12"].vri_maximo);
        $('.newComisionMinima').val(cont_cf.activos[tipo]["1_12"].comision_minima);
        $('.newComisionMaxima').val(cont_cf.activos[tipo]["1_12"].comision_maxima);
        $('.newRentaInicialMinima').val(cont_cf.activos[tipo]["1_12"].renta_inicial_minima);
        $('.newRentaInicialMaxima').val(cont_cf.activos[tipo]["1_12"].renta_inicial_maxima);
        $('.newDeposito').prop('checked',cont_cf.activos[tipo]["1_12"].deposito_en_garantia);
        $('.newUsoParticular').prop('checked',cont_cf.activos[tipo]["1_12"].uso_particular);
        $('.newUsoEmpresarial').prop('checked',cont_cf.activos[tipo]["1_12"].uso_empresarial);
        $('.newActivoNuevo').prop('checked',cont_cf.activos[tipo]["1_12"].activo_nuevo);
    },
    //Evento que actualiza los campos de la condicion con base en el Plazo seleccionado
    ActualizaPlazoFinanciera: function (evt){
        var inputs = this.$('.newPlazo'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var plazo = input.val();
        var activoselect = cont_cf.$('.newActivo')[1].value;


        cont_cf.$('.newPlazo').select2("val", plazo);
        cont_cf.$('.newTasaMinima').val(cont_cf.activos[activoselect][plazo].tasa_minima);
        $('.newTasaMaxima').val(cont_cf.activos[activoselect][plazo].tasa_maxima);
        $('.newVRCMinimo').val(cont_cf.activos[activoselect][plazo].vrc_minimo);
        $('.newVRCMaximo').val(cont_cf.activos[activoselect][plazo].vrc_maximo);
        $('.newVRIMinimo').val(cont_cf.activos[activoselect][plazo].vri_minimo);
        $('.newVRIMaximo').val(cont_cf.activos[activoselect][plazo].vri_maximo);
        $('.newComisionMinima').val(cont_cf.activos[activoselect][plazo].comision_minima);
        $('.newComisionMaxima').val(cont_cf.activos[activoselect][plazo].comision_maxima);
        $('.newRentaInicialMinima').val(cont_cf.activos[activoselect][plazo].renta_inicial_minima);
        $('.newRentaInicialMaxima').val(cont_cf.activos[activoselect][plazo].renta_inicial_maxima);
        $('.newDeposito').prop('checked',cont_cf.activos[activoselect][plazo].deposito_en_garantia);
        $('.newUsoParticular').prop('checked',cont_cf.activos[activoselect][plazo].uso_particular);
        $('.newUsoEmpresarial').prop('checked',cont_cf.activos[activoselect][plazo].uso_empresarial);
        $('.newActivoNuevo').prop('checked',cont_cf.activos[activoselect][plazo].activo_nuevo);

    },
})
