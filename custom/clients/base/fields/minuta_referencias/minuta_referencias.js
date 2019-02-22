({

    mReferencias : null,

    events: {
        'click  .addReferencia': 'addReferencia',
        'keydown .newCampo1R': 'OnlyText',
        'keydown .newCampo2R': 'OnlyText',
        'keydown .newCampo3R': 'OnlyText',
        //'change  .newCampo5R': 'validaTelRef',
        'change .updateRecords': 'actualizacampos',
        'change .campo5SelectR':'validaTelRef',
        'change .campo4SelectR':'validaMailRef'
    },

    initialize: function (options) {
        //Inicializa campo custom
        selfRef= this;
        this._super('initialize', [options]);

        this.model.addValidationTask('GuardarReferencias', _.bind(this.estableceReferencias, this));


        this.mReferencias=[];
        this.mReferencias['referencias']=[];
        this.model.on('sync', this.loadData, this);

    },

    loadData: function (options){
        if (this.model.get('tct_ref_json_c')!="" || this.model.get('tct_ref_json_c')!=null || this.model.get('tct_ref_json_c')!=undefined) {
            this.detalle = JSON.parse(this.model.get('tct_ref_json_c'));
        }
        this.render();
    },

    _render: function (fields, errors, callback) {
        this._super("_render");

        $("div.record-label[data-name='minuta_referencias']").attr('style', 'display:none;');
        $("[data-name='tct_ref_json_c']").attr('style', 'display:none;');
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },


    estableceReferencias:function(fields, errors, callback) {
        //Establece el objeto mReferencias a minuta_referencias para guardar y a un campo cstm para obtener de él sus datos para visualizacion

        this.model.set('minuta_referencias',  selfRef.mReferencias.referencias);
        this.model.set('tct_ref_json_c',  JSON.stringify(selfRef.mReferencias.referencias));


        callback(null, fields, errors);
    },

    //Funcion que acepta solo letras (a-z), puntos(.) y comas(,)
    OnlyText: function (evt) {
        //console.log(evt.keyCode);
        if ($.inArray(evt.keyCode, [9, 16, 17, 110,190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192]) < 0) {
            if (evt.keyCode != 186) {
                app.alert.show("Caracter Invalido", {
                    level: "error",
                    title: "Solo texto es permitido en este campo.",
                    autoClose: true
                });
                return false;
            }
        }
    },

    /* Función para agregar los datos y crear una cuenta LEAD
     */
    addReferencia: function (options) {
        //Estableciendo el color de borde original en cada campo
        $('.newCampo1R').css('border-color', '');
        $('.newCampo2R').css('border-color', '');
        $('.newCampo3R').css('border-color', '');
        $('.newCampo4R').css('border-color', '');
        $('.newCampo5R').css('border-color', '');

        //Obteniendo valores de los campos
        var valor1 = $('.newCampo1R')[0].value;
        var valor2 = $('.newCampo2R')[0].value;
        var valor3 = $('.newCampo3R')[0].value;
        var valor4 = $('.newCampo4R')[0].value;
        var valor5 = $('.newCampo5R')[0].value;

        var lead = {
            "id": "",
            "nombres": valor1,
            "apaterno": valor2,
            "amaterno": valor3,
            "telefono": valor5,
            "correo": valor4,
            "id_cuenta": this.model.get('account_id_c')
        };

        //Valida campos requeridos
        var faltantes = 0;
        //Nombres
        if (valor1 == '' || valor1.trim() == '') {

            $('.newCampo1R').css('border-color', 'red');
            faltantes++;
        }

        if ((valor1 != '' || valor1.trim() != '')) {

            if (!this.ValidaCaracter(valor1)) {
                $('.newCampo1R').css('border-color', 'red');

                app.alert.show('name_referencia_error', {
                    level: 'error',
                    autoClose: true,
                    messages: 'Formato de nombre incorrecto'

                });
                faltantes++;
            }
        }


        //Apellido Paterno
        if (valor2 == '' || valor2.trim() == '') {
            $('.newCampo2R').css('border-color', 'red');
            faltantes++
        }

        if ((valor2 != '' || valor2.trim() != '')) {

            if (!this.ValidaCaracter(valor2)) {
                $('.newCampo2R').css('border-color', 'red');

                app.alert.show('name_referencia_error', {
                    level: 'error',
                    autoClose: true,
                    messages: 'Formato de nombre incorrecto'

                });
                faltantes++;
            }
        }

        // Apellido Materno
        if ((valor3 != '' || valor3.trim() != '')) {

            if (!this.ValidaCaracter(valor3)) {
                $('.newCampo3R').css('border-color', 'red');

                app.alert.show('name_referencia_error', {
                    level: 'error',
                    autoClose: true,
                    messages: 'Formato de nombre incorrecto'

                });
                faltantes++;
            }
        }

        //Correo o Teléfono
        if (valor4 == '' && valor5 == '') {
            $('.newCampo4R').css('border-color', 'red');
            $('.newCampo5R').css('border-color', 'red');
            app.alert.show('email_telefono_error', {
                level: 'error',
                autoClose: true,
                messages: 'Favor de agregar un <b>Tel\u00E9fono</b> o un <b>Correo</b>'

            });
            faltantes++
        }

        if (valor5 != "") {
            if (!this.validaTelRef($('.newCampo5R').val().length, $('.newCampo5R').val())) {
                $('.newCampo5R').css('border-color', 'red');
                faltantes++;
                app.alert.show('phone_participante_error', {
                    level: 'error',
                    autoClose: true,
                    messages: 'Formato de tel\u00E9fono incorrecto.'

                });
            }
        }
        // valida la máscara del correo
        if (valor4 != "") {
            if (!this.validaMailRef($('.newCampo4R').val().length, $('.newCampo4R').val())) {
                $('.newCampo4R').css('border-color', 'red');
                faltantes++;
                app.alert.show('mail_participante_error', {
                    level: 'error',
                    autoClose: true,
                    messages: 'Formato de correo incorrecto.'

                });
            }
        }

        if (faltantes == 0) {

            App.alert.show('loadingRender', {
                level: 'process',
                title: 'Cargando, por favor espere.',
            });

            $('.addReferencia').bind('click', false);

            // Valida si existen duplicados
            var nombre = $(".newCampo1R").val();
            var apellidop = $(".newCampo2R").val();
            var apellidom = $(".newCampo3R").val();
            var condicion = {
                "$equals": apellidom
                        };

            if (apellidom== "" || apellidom==null){
                condicion = {
                    "$is_null": apellidom
                };
            }

            var campos = ["primernombre_c", "apellidopaterno_c","apellidomaterno_c"];
            app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                campos: campos.join(','),
                max_num: 4,
                "filter": [
                    {
                        "primernombre_c": nombre,
                        "apellidopaterno_c": apellidop,
                        "apellidomaterno_c":  condicion
                    }
                ]
            }), null, {
                success: _.bind(function (cuenta) {
                    if (cuenta.records.length > 0) {
                        $(".newCampo1R").val("");
                        $(".newCampo2R").val("");
                        $(".newCampo3R").val("");
                        $(".newCampo4R").val("");
                        $(".newCampo5R").val("");
                        app.alert.show("ReferenciaDuplicada", {
                            level: "error",
                            title: "La referencia ingresada ya existe. No es posible registrarla como un nuevo Lead.",
                            autoClose: true
                        });
                    }
                    else {
                        selfRef.mReferencias.referencias.push(lead);
                        selfRef.render();
                    }
                    $('.addReferencia').unbind('click', false);
                    App.alert.dismiss('loadingRender');
                }, this)
            });
        }
    },

    validaMailRef:function(correoTam, ValMail) {

        var banderCorreo=false;
        var emailPattern = /^\S+@\S+\.\S+[$%&|<>#]?$/;

        if ( emailPattern.test(ValMail) ) {
            banderCorreo=true;
        }
        return banderCorreo;
    },

    ValidaCaracter: function(texto)
    {
        var valido=false;
        var cont = 0;
        var contDosPuntos = 0;
        var ValText = texto;
        var TextTam = texto.length;
        for (var j = 0; j < TextTam; j++) {

            if (ValText.charAt(j)==".") {
                cont++;
            }
            if (ValText.charAt(j)==":") {
                contDosPuntos++;
            }
        }

        if (cont < 2 && contDosPuntos==0 ) {
            valido = true;
        }
        if (cont == 1 && TextTam==1) {
            valido = false;
        }
        return valido;
    },

    actualizacampos: function (evt){
        //var Indice se posiciona para tener la posicion del tr cercano para encontrar el campo actualizado
        //var valorch obtiene el nombre del campo modificado (clase)
        //Actualiza el objeto mReferencias con el campo ubicao y el valor actualizado
        var campo=$(evt.currentTarget).parent().parent().parent().parent();
        var valorch=$(evt.currentTarget).attr('data-field');
        var nombreCampo = campo.context.getAttribute('data-field');
        selfRef.mReferencias.referencias[campo.index()][valorch]=$(evt.currentTarget).val();
        //Validacion para campos requeridos solamente
        if(campo.context.value=="" || campo.context.value==null ){
            if( nombreCampo == 'apaterno' || nombreCampo == 'nombres'){
                selfRef.$(evt.currentTarget).css('border-color', 'red');
                app.alert.show("ReferenciaVacia", {
                    level: "error",
                    title: "La referencia ingresada contiene valor vacío. <br> Se requieren un Nombre y Apellido Paterno.",
                    autoClose: true
                });
            }
            if((nombreCampo == 'correo' || nombreCampo == 'telefono') && (selfRef.mReferencias.referencias[campo.index()].correo == "" && selfRef.mReferencias.referencias[campo.index()].telefono=="" )){
                selfRef.$(evt.currentTarget).css('border-color', 'red');
               // selfRef.mReferencias.referencias[campo.index()][valorch]=$(evt.currentTarget).val("");
                app.alert.show("ReferenciaVacia", {
                    level: "error",
                    title: "La referencia ingresada contiene valor vacío. <br> Se requieren un correo o un tel\u00E9fono.",
                    autoClose: true
                });
            }

        }else{
            selfRef.$(evt.currentTarget).css('border-color', '');
             if (nombreCampo == 'telefono'){
                if(!this.validaTelRef(selfRef.mReferencias.referencias[campo.index()].telefono.length, selfRef.mReferencias.referencias[campo.index()].telefono)){
                    selfRef.$(evt.currentTarget).css('border-color', 'red');
                    selfRef.$(evt.currentTarget).val('');
                    app.alert.show("ReferenciaTelDif", {
                        level: "error",
                        title: "El Formato de tel\u00E9fono es incorrecto.",
                        autoClose: true
                    });
                    selfRef.mReferencias.referencias[campo.index()][valorch]="";
                }
            }
        }
            if (nombreCampo == 'correo'){
                selfRef.$(evt.currentTarget).css('border-color', '');
                if(!this.validaMailRef(selfRef.mReferencias.referencias[campo.index()].correo.length ,selfRef.mReferencias.referencias[campo.index()].correo)){
                    selfRef.$(evt.currentTarget).css('border-color', 'red');
                    selfRef.$(evt.currentTarget).val('');
                    app.alert.show("ReferenciaTelDif", {
                        level: "error",
                        title: "Formato de correo incorrecto.",
                        autoClose: true
                    });
                    selfRef.mReferencias.referencias[campo.index()][valorch]="";
                }
            }
        selfRef.mReferencias.referencias[campo.index()][valorch]=$(evt.currentTarget).val();
    },

    validaTelRef: function (telefonoTam,ValTel) {

        var banderTelefono = false;
        var expreg = /^[0-9]{8,13}$/;

        if (telefonoTam >= 8 && telefonoTam <= 13) {

            if (expreg.test(ValTel)) {

                var cont = 0;
                for (var j = 0; j < telefonoTam; j++) {

                    if (ValTel.charAt(0) == ValTel.charAt(j)) {
                        cont++;
                    }
                }
                if (cont != telefonoTam) {
                    banderTelefono = true;
                }
            }
        }
        else {
            /*   app.alert.show("N\u00FAmero incorrecto", {
               level: "error",
               title: "Formato invalido",
               autoClose: true
               });*/

        }
        return banderTelefono;
    },
})
