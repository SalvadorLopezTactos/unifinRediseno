({

    mReferencias : null,

    events: {
        'click  .addReferencia': 'addReferencia',
        'keydown .newCampo5R':'keyDownNewExtension',
        'keydown .campo5SelectR':'keyDownNewExtension',
        'keydown .newCampo5R':'checkInVentas',
        'change .campo4SelectR':'validaMailRef',
        'change select.refRegimenFiscal':'showRazonSocial',
        'change select.existingRefRegimenFiscal':'showRazonSocial'
    },

    initialize: function (options) {
        //Inicializa campo custom
        selfRef= this;
        this._super('initialize', [options]);

        var regimen_list = App.lang.getAppListStrings('tipo');
         var regimen_options = '<option value=""></option>'
         for (regimen_id in regimen_list) {
            regimen_options += '<option value="' + regimen_id + '" >' + regimen_list[regimen_id] + '</option>';
        }
        this.regimen_fiscal= regimen_options;

        this.model.addValidationTask('GuardarReferencias', _.bind(this.estableceReferencias, this));


        this.mReferencias=[];
        this.mReferencias['referencias']=[];
        this.model.on('sync', this.loadData, this);

    },

    loadData: function (options){
        if (this.model.get('tct_ref_json_c')!="" && this.model.get('tct_ref_json_c')!=null && this.model.get('tct_ref_json_c')!=undefined) {
            this.detalle = JSON.parse(this.model.get('tct_ref_json_c'));
        }
        this.render();
    },

    _render: function (fields, errors, callback) {
        this._super("_render");

        this.$('select.existingRefRegimenFiscal').select2({
            width:'100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        this.$('select.refRegimenFiscal').select2({
            width:'100%',
            closeOnSelect: false,
            containerCssClass: 'select2-choices-pills-close'
        });

        //Instrucción para alinear el campo con formato select2 con los campos ubicados debajo (nombre y correo)
        $('.existingRefRegimenFiscal.select2-container').css('margin','0');
        $('.refRegimenFiscal.select2-container').css('margin','0');
        $("div.record-label[data-name='minuta_referencias']").attr('style', 'display:none;');
        $("[data-name='tct_ref_json_c']").attr('style', 'display:none;');

        $('.updateRecords').change(function(evt) {
            //var Indice se posiciona para tener la posicion del tr cercano para encontrar el campo actualizado
            //var valorch obtiene el nombre del campo modificado (clase)
            //Actualiza el objeto mReferencias con el campo ubicao y el valor actualizado
            var campo=$(this).closest("tr");
            var valorch=$(evt.currentTarget).attr('data-field');
            //var nombreCampo = campo.context.getAttribute('data-field');
            var nombreCampo = valorch;
            selfRef.mReferencias.referencias[campo.index()][valorch]=$(evt.currentTarget).val();
            //Validacion para campos requeridos solamente
            if($(evt.currentTarget).val().trim()=="" || $(evt.currentTarget).val().trim()==null){
                if( nombreCampo == 'apaterno' || nombreCampo == 'nombres'){
                    selfRef.$(evt.currentTarget).css('border-color', 'red');
                    app.alert.show("ReferenciaVacia", {
                        level: "error",
                        title: "La referencia ingresada contiene valor vacío. <br> Se requieren un Nombre y Apellido Paterno.",
                        autoClose: true
                    });
                }
                if(nombreCampo=='razon_social'){

                    selfRef.$(evt.currentTarget).css('border-color', 'red');
                    app.alert.show("ReferenciaVacia", {
                        level: "error",
                        title: "La referencia ingresada contiene valor vacío. <br> Se requieren una Razón Social.",
                        autoClose: true
                    });

                }
                if((nombreCampo == 'correo' || nombreCampo == 'telefono') && (selfRef.mReferencias.referencias[campo.index()].correo == "" && selfRef.mReferencias.referencias[campo.index()].telefono=="" )){
                    selfRef.$(evt.currentTarget).css('border-color', 'red');
                    // selfRef.mReferencias.referencias[campo.index()][valorch]=$(evt.currentTarget).val("");
                    app.alert.show("ReferenciaVacia", {
                        level: "error",
                        title: "La referencia ingresada contiene valor vacío. <br> Se requieren un correo o un tel\u00E9fono.",
                        autoClose: false
                    });
                }

            }else{ //Validación que entra para cuando el valor actualizado no es vacío
                selfRef.$(evt.currentTarget).css('border-color', '');
                if (nombreCampo == 'nombres' || nombreCampo == 'apaterno' || nombreCampo == 'amaterno'){
                    if(!selfRef.ValidaCaracter($(evt.currentTarget).val().trim())){
                        selfRef.$(evt.currentTarget).css('border-color', 'red');
                        selfRef.$(evt.currentTarget).val('');
                        app.alert.show("ReferenciaTelDif", {
                            level: "error",
                            title: "El campo no permite ingresar caracteres especiales.",
                            autoClose: true
                        });
                    }
                }
                if (nombreCampo == 'telefono'){
                    if(!selfRef.validaTelRef(selfRef.mReferencias.referencias[campo.index()].telefono.length, selfRef.mReferencias.referencias[campo.index()].telefono)){
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
                if (nombreCampo == 'correo'){
                    selfRef.$(evt.currentTarget).css('border-color', '');
                    if(!selfRef.validaMailRef(selfRef.mReferencias.referencias[campo.index()].correo.length ,selfRef.mReferencias.referencias[campo.index()].correo)){
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
            }
            selfRef.mReferencias.referencias[campo.index()][valorch]=$(evt.currentTarget).val();
        });

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

        Object.keys(selfRef.mReferencias.referencias).forEach(function (key) {
            if(!selfRef.ValidaCaracter(selfRef.mReferencias.referencias[key].nombre)){

            }
        });

        this.model.set('minuta_referencias',  selfRef.mReferencias.referencias);
        this.model.set('tct_ref_json_c',  JSON.stringify(selfRef.mReferencias.referencias));


        callback(null, fields, errors);
    },


    /* Función para agregar los datos y crear:
     Cuenta tipo Lead y Persona relacionada para "Persona Moral"
     Cuenta tipo Lead para "Persona Fisica"
     */
    addReferencia: function (options) {
        //Estableciendo el color de borde original en cada campo
        $('.select2-container.refRegimenFiscal').children().eq(0).css('border-color', '');
        $('.newRazonSocial').css('border-color','');
        $('.newCampo1R').css('border-color', '');
        $('.newCampo2R').css('border-color', '');
        $('.newCampo3R').css('border-color', '');
        $('.newCampo4R').css('border-color', '');
        $('.newCampo5R').css('border-color', '');

        //Obteniendo valores de los campos
        var tipo=$('select.refRegimenFiscal').val();
        var razon=$('.newRazonSocial').val();
        var valor1 = $('.newCampo1R')[0].value.trim();
        var valor2 = $('.newCampo2R')[0].value.trim();
        var valor3 = $('.newCampo3R')[0].value.trim();
        var valor4 = $('.newCampo4R')[0].value;
        var valor5 = $('.newCampo5R')[0].value;

        var registro = {
            "id": "",
            "regimen_fiscal":tipo,
            "regimen_list":App.lang.getAppListStrings('tipo'),
            "razon_social":razon,
            "nombres": valor1,
            "apaterno": valor2,
            "amaterno": valor3,
            "telefono": valor5,
            "correo": valor4,
            "clean_name":"",
            "clean_name_moral":"",
            "id_cuenta": this.model.get('account_id_c')
        };

        //Valida campos requeridos
        var faltantes = 0;
        if(tipo==''){
            $('.select2-container.refRegimenFiscal').children().eq(0).css('border-color', 'red');
            faltantes++;
        }

        if($('.newRazonSocial').is(":visible") && razon.trim()==''){

            $('.newRazonSocial').css('border-color','red');
            faltantes++;
        }
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

            if (selfRef.mReferencias.referencias.length >=0) {

            var duplicados= false;

            Object.keys(selfRef.mReferencias.referencias).forEach(function(key) {
                var tipo=$('select.refRegimenFiscal').val();
                var iteracion="";
                if(tipo=="Persona Moral"){

                    iteracion = selfRef.mReferencias.referencias[key].razon_social;
                }else{

                    iteracion = selfRef.mReferencias.referencias[key].nombres + selfRef.mReferencias.referencias[key].apaterno + selfRef.mReferencias.referencias[key].amaterno;
                }
                iteracion = iteracion.replace(/\s+/gi,'');
                iteracion = iteracion.toUpperCase();
                var valores='';
                if(tipo=="Persona Moral"){

                    valores=$('.newRazonSocial').val().trim();

                }else{

                    valores = $('.newCampo1R').val().trim() + $('.newCampo2R').val().trim() + $('.newCampo3R').val().trim();
                }
                valores = valores.replace(/\s+/gi,'');
                valores = valores.toUpperCase();
                if (iteracion == valores) {
                    duplicados = true;
                }
            });
            if(duplicados== true){
                $(".newRazonSocial").val("");
                $(".newCampo1R").val("");
                $(".newCampo2R").val("");
                $(".newCampo3R").val("");
                $(".newCampo4R").val("");
                $(".newCampo5R").val("");
                app.alert.show('Referencia_duplicada_+', {
                    level: 'error',
                    autoClose: true,
                    title: "No se puede agregar la referencia. <br> Esta persona ya ha sido registrada."
                });
            }
            else{

            App.alert.show('loadingRender', {
                level: 'process',
                title: 'Cargando, por favor espere.',
            });

            $('.addReferencia').bind('click', false);

            // Conforma el Clean Name en Persona Fisica
            var original_name = $(".newCampo1R").val() + $(".newCampo2R").val() + $(".newCampo3R").val();
            var list_check = app.lang.getAppListStrings('validacion_duplicados_list');
            var simbolos = app.lang.getAppListStrings('validacion_simbolos_list');
            original_name = original_name.replace(/\s+/gi, '');
            original_name = original_name.toUpperCase();
            registro.clean_name = original_name;

             if(tipo == 'Persona Moral') {
                //Conforma el clean name para persona Moral
                var clean_name="";
                clean_name = $('.newRazonSocial').val();
                clean_name = clean_name.toUpperCase();
                var list_check = app.lang.getAppListStrings('validacion_duplicados_list');
                var simbolos = app.lang.getAppListStrings('validacion_simbolos_list');
                //Define arreglos para guardar nombre de cuenta
                var clean_name_split = [];
                var clean_name_split_full = [];
                clean_name_split = clean_name.split(" ");
                //Elimina simbolos: Ej. . , -
                _.each(clean_name_split, function (value, key) {
                    _.each(simbolos, function (simbolo, index) {
                        var clean_value = value.split(simbolo).join('');
                        if (clean_value != value) {
                            clean_name_split[key] = clean_value;
                        }
                    });
                });
                clean_name_split_full = App.utils.deepCopy(clean_name_split);
                //Elimina tipos de sociedad: Ej. SA, de , CV...
                var totalVacio = 0;
                _.each(clean_name_split, function (value, key) {
                    _.each(list_check, function (index, nomenclatura) {
                        var upper_value = value.toUpperCase();
                        if (upper_value == nomenclatura) {
                            var clean_value = upper_value.replace(nomenclatura, "");
                            clean_name_split[key] = clean_value;
                        }
                    });
                });
                //Genera clean_name con arreglo limpio
                var clean_name = "";
                _.each(clean_name_split, function (value, key) {
                    clean_name += value;
                    //Cuenta elementos vacíos
                    if (value == "") {
                        totalVacio++;
                    }
                });

                //Valida que exista más de un elemento, caso cotrarioe establece para clean_name valores con tipo de sociedad
                if ((clean_name_split.length - totalVacio) <= 1) {
                    clean_name = "";
                    _.each(clean_name_split_full, function (value, key) {
                        clean_name += value;
                    });
                }
                    clean_name = clean_name.toUpperCase();
                    registro.clean_name_moral= clean_name;
                }
                if (tipo=="Persona Moral"){
                    //Realiza Api call para buscar duplicados en las cuentas con clean_name_moral
                    var campos = ["primernombre_c", "apellidopaterno_c","apellidomaterno_c","razonsocial_c","nombre_comercial_c"];
                    app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                        campos: campos.join(','),
                        max_num: 4,
                        "filter": [
                            {
                                "clean_name": registro.clean_name_moral
                            }
                        ]
                    }), null, {
                        success: _.bind(function (cuenta) {
                            if (cuenta.records.length > 0) {
                                $(".newRazonSocial").val("");
                                $(".newCampo1R").val("");
                                $(".newCampo2R").val("");
                                $(".newCampo3R").val("");
                                $(".newCampo4R").val("");
                                $(".newCampo5R").val("");
                                app.alert.show("ReferenciaDuplicada", {
                                    level: "error",
                                    title: "No se puede agregar la referencia. <br> Esta persona moral ya ha sido registrada.",
                                    autoClose: true
                                });
                            }
                            else {
                                if(registro.regimen_fiscal=='Persona Moral'){
                                    registro.moral="Moral";
                                }
                                var indexInsert=selfRef.mReferencias.referencias.push(registro)-1;
                                selfRef.render();
                                //Instrucción para establecer el valor de regimen fiscal en referencia existente
                                //selfRef.$('select.existingRefRegimenFiscal').eq(indexInsert).select2('val',registro.regimen_fiscal);
                                //Se lanza evento change para mostrat/oculta campo de Razón Social
                                //selfRef.$('select.existingRefRegimenFiscal').eq(indexInsert).trigger('change');

                                selfRef.$('select.existingRefRegimenFiscal').each(function(){
                                    $(this).trigger('change');
                                });

                            }
                            $('.addReferencia').unbind('click', false);
                            App.alert.dismiss('loadingRender');
                        }, this)
                    });

                }else {
                    //Realiza Api call para buscar duplicados en las cuentas con clean_name_fisica
                    var campos = ["primernombre_c", "apellidopaterno_c", "apellidomaterno_c", "razonsocial_c", "nombre_comercial_c"];
                    app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                        campos: campos.join(','),
                        max_num: 4,
                        "filter": [
                            {
                                "clean_name": registro.clean_name
                            }
                        ]
                    }), null, {
                        success: _.bind(function (cuenta) {
                            if (cuenta.records.length > 0) {
                                $(".newRazonSocial").val("");
                                $(".newCampo1R").val("");
                                $(".newCampo2R").val("");
                                $(".newCampo3R").val("");
                                $(".newCampo4R").val("");
                                $(".newCampo5R").val("");
                                app.alert.show("ReferenciaDuplicada", {
                                    level: "error",
                                    title: "No se puede agregar la referencia. <br> Esta persona ya ha sido registrada.",
                                    autoClose: true
                                });
                            }
                            else {
                                if (registro.regimen_fiscal == 'Persona Moral') {
                                    registro.moral = "Moral";
                                }
                                var indexInsert = selfRef.mReferencias.referencias.push(registro) - 1;
                                selfRef.render();
                                //Instrucción para establecer el valor de regimen fiscal en referencia existente
                                //selfRef.$('select.existingRefRegimenFiscal').eq(indexInsert).select2('val',registro.regimen_fiscal);
                                //Se lanza evento change para mostrat/oculta campo de Razón Social
                                //selfRef.$('select.existingRefRegimenFiscal').eq(indexInsert).trigger('change');

                                selfRef.$('select.existingRefRegimenFiscal').each(function () {
                                    $(this).trigger('change');
                                });

                            }
                            $('.addReferencia').unbind('click', false);
                            App.alert.dismiss('loadingRender');
                        }, this)
                    });
                }
            }
        }
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

    showRazonSocial:function(evt){
        var tipo=$(evt.currentTarget).val();
        if(tipo=="Persona Moral"){
            //this.$(".newRazonSocial").parent().removeClass('hide');
            this.$(evt.currentTarget).parent().parent().children().eq(1).removeClass('hide');
        }else{
            //this.$(".newRazonSocial").parent().addClass('hide');
            this.$(evt.currentTarget).parent().parent().children().eq(1).addClass('hide');
        }

    },

    ValidaCaracter: function(texto) {
        var valido=false;
        if (texto!="" && texto!=undefined) {
            var letter = /^[a-zA-ZÀ-ÿ\s]*$/g;
            if (texto.match(letter)) {
                valido = true;
            }
        }
        return valido;
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

    keyDownNewExtension: function (evt) {
        if (!evt) return;
        if(!this.validatelefono(evt)){
            return false;
        }
    },
    validatelefono:function(evt){
        if($.inArray(evt.keyCode,[110,188,190,45,33,36,46,35,34,8,9,20,16,17,37,40,39,38,16,49,50,51,52,53,54,55,56,57,48,96,97,98,99,100,101,102,103,104,105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Solo n\u00FAmeros son permitidos en este campo.",
                autoClose: true
            });
            return false;

        }else{
            return true;
        }
    },

    checkInVentas:function (evt) {
        var enteros=this.checkmoneyint(evt);
        var decimales=this.checkmoneydec(evt);
        $.fn.selectRange = function(start, end) {
            if(!end) end = start;
            return this.each(function() {
                if (this.setSelectionRange) {
                    this.focus();
                    this.setSelectionRange(start, end);
                } else if (this.createTextRange) {
                    var range = this.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', end);
                    range.moveStart('character', start);
                    range.select();
                }
            });
        };
        (function ($, undefined) {
            $.fn.getCursorPosition = function() {
                var el = $(this).get(0);
                var pos = [];
                if('selectionStart' in el) {
                    pos = [el.selectionStart,el.selectionEnd];
                } else if('selection' in document) {
                    el.focus();
                    var Sel = document.selection.createRange();
                    var SelLength = document.selection.createRange().text.length;
                    Sel.moveStart('character', -el.value.length);
                    pos = Sel.text.length - SelLength;
                }
                return pos;
            }
        })(jQuery); //funcion para obtener cursor
        var cursor=$(evt.handleObj.selector).getCursorPosition();//setear cursor


        if (enteros == "false" && decimales == "false") {
            if(cursor[0]==cursor[1]) {
                return false;
            }
        }else if (typeof enteros == "number" && decimales == "false") {
            if (cursor[0] < enteros) {
                $(evt.handleObj.selector).selectRange(cursor[0], cursor[1]);
            } else {
                $(evt.handleObj.selector).selectRange(enteros);
            }
        }

    },

    checkmoneyint: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var digitos = $input.val().split('.');
        if($input.val().includes('.')) {
            var justnum = /[\d]+/;
        }else{
            var justnum = /[\d.]+/;
        }
        var justint = /^[\d]{0,14}$/;

        if((justnum.test(evt.key))==false && evt.key!="Backspace" && evt.key!="Tab" && evt.key!="ArrowLeft" && evt.key!="ArrowRight"){
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }

        if(typeof digitos[0]!="undefined") {
            if (justint.test(digitos[0]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                //console.log('no se cumplen enteros')
                if(!$input.val().includes('.')) {
                    $input.val($input.val()+'.')
                }
                return "false";

            } else {
                return digitos[0].length;
            }
        }
    },

    checkmoneydec: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var digitos = $input.val().split('.');
        if($input.val().includes('.')) {
            var justnum = /[\d]+/;
        }else{
            var justnum = /[\d.]+/;
        }
        var justdec = /^[\d]{0,1}$/;

        if((justnum.test(evt.key))==false && evt.key!="Backspace" && evt.key!="Tab" && evt.key!="ArrowLeft" && evt.key!="ArrowRight"){
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }
        if(typeof digitos[1]!="undefined") {
            if (justdec.test(digitos[1]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                //console.log('no se cumplen dec')
                return "false";
            } else {
                return "true";
            }
        }
    },
})
