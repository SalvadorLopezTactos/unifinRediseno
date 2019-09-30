({

    tel_tipo_list: null,
    pais_list: null,
    estatus_list: null,

    events: {
        'keydown .existingTelephono': 'keyDownNewExtension',
        'keydown .newTelefono': 'keyDownNewExtension',
        'click  .addTelefono': 'addNewTelefono',
        'click  .mcall': 'makecall',
        /*
          * Eventos para actualizacion de valores en modelo Telefonos
        */
        'click .principal': 'updatePrincipal',          //Principal
        'change .Tipotelefonot': 'updateTipotelefonot', //Tipo
        'change .Paist': 'updatePaist',                 //País
        'change .Estatust': 'updateEstatust',           //Estatus
        'change .Extensiont': 'updateExtensiont',       //Extensión
        'change .Telefonot': 'updateTelefonot',         //Teléfono
    },
    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        cont_tel = this;
        this._super('initialize', [options]);
        this.Listas();
    },

    Listas: function () {
        this.tel_tipo_list = app.lang.getAppListStrings('tel_tipo_list');
        this.pais_list = app.lang.getAppListStrings('paises_list');
        this.estatus_list = app.lang.getAppListStrings('tel_estatus_list');
    },

    /**
     * When data changes, re-render the field only if it is not on edit (see MAR-1617).
     * @inheritdoc
     */
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                // this.render();
            }
        }, this);
    },

    _render: function () {
        this._super("_render");
        //cont_tel = this;
        this.$("div.record-label[data-name='account_telefonos']").attr('style', 'display:none;');
    },

    keyDownNewExtension: function (evt) {
        if (!evt) return;
        if(!this.checkNumOnly(evt)){
            return false;
        }

    },

    //UNI349 Control Telefonos - En el campo teléfono, extensión no se debe permitir caracteres diferentes a numéricos
    checkNumOnly:function(evt){
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

    validaTamano: function (ValTel) {
        var telefonoTam = ValTel.length;
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
        return banderTelefono;
    },

    addNewTelefono: function (options) {
        if (this.oTelefonos == undefined) {
            this.oTelefonos = contexto_cuenta.oTelefonos;
        }
        //Estableciendo el color de borde original en cada campo en telefonos
        $('.newTipotelefono').find('.select2-choice').css('border-color','');
        $('.newPais').find('.select2-choice').css('border-color','');
        $('.newEstatus').find('.select2-choice').css('border-color','');
        $('.newTipotelefono').find('.select2-choice').css('border-color','');
        this.$('.newTelefono').css('border-color', '');
        this.$('.newTelefono').css('border-color', '');

        //Obteniendo valores de los campos
        var valor1 = this.$('.newTipotelefono').select2('val');
        var valor2 = this.$('.newPais').select2('val');
        var valor3 = this.$('.newEstatus').select2('val');
        var valor4 = this.$('.newTelefono').val();
        var valor5 = this.$('.newExtension').val();;

        var sec=this.oTelefonos.telefono.length+1;


        var telefono = {
            "name":valor4,
            "tipotelefono": valor1,
            "pais": valor2,
            "estatus": valor3,
            "extension": valor5,
            "telefono": valor4,
            "principal":1,
            "secuencia":sec,
            "id_cuenta": this.model.get('account_id_c')
        };

        //Valida campos requeridos
        var faltantes = 0;
        if (valor1 == '') {
            $('.newTipotelefono').find('.select2-choice').css('border-color','red');
            faltantes++;
        }
        if (valor2 == '' ) {
            $('.newPais').find('.select2-choice').css('border-color','red');
            faltantes++;
        }
        if (valor3 == '') {
            $('.newEstatus').find('.select2-choice').css('border-color','red');
            app.alert.show('error_campo_telefono', {
                level: 'error',
                autoClose: true,
                messages: 'Favor de agregar estatus del <b>Tel\u00E9fono</b>'
            });
            faltantes++
        }
        if ((valor4 == '' || valor4.trim() == '')) {

            $('.newTelefono').css('border-color', 'red');
            app.alert.show('error_campo_telefono', {
                level: 'error',
                autoClose: false,
                messages: 'Favor de agregar un <b>Tel\u00E9fono</b>'
            });
            faltantes++;
        }
        if (valor4 != "") {
            //Control de errores
            var msjError = "";
            //Valida númerico
            var valNumerico = /^\d+$/;
            if (!valNumerico.test(valor4)) {
                faltantes++;
                msjError += '<br><b>Solo números son permitidos</b>';
            }
            //Valida longitud
            if (valor4.length<8) {
                faltantes++;
                msjError += '<br><b>Debe contener 8 o más dígitos</b>';
            }

            //Valida números repetidos
            if(valor4.length > 1){
                var repetido = true;
                for (var iValor4 = 0; iValor4 < valor4.length; iValor4++) {
                  repetido = (valor4[0] != valor4[iValor4]) ? false : repetido;
                }
                if (repetido) {
                    faltantes++;
                    msjError += '<br><b>Caracter repetido</b>';
                }
            }

            //Muestra errores
            if(msjError!= ""){
                $('.newTelefono').css('border-color', 'red');
                app.alert.show('phone_add_error', {
                    level: 'error',
                    autoClose: true,
                    messages: 'No se puede agregar el número:'+ msjError
                });
            }

        }
        if (faltantes == 0) {
            if (cont_tel.oTelefonos.telefono.length >=1) {
                var duplicados= false;
                cont_tel.oTelefonos.telefono.forEach(function(element) {
                    var iteracion = element.telefono;
                    iteracion = iteracion.replace(/\s+/gi,'');

                    var ntelefonico = this.$('.newTelefono').val().trim();
                    if (iteracion == ntelefonico) {
                        duplicados = true;
                    }
                });
                if(duplicados== true){
                    this.$('.newTelefono').val("");
                    app.alert.show('Numero_duplicado', {
                        level: 'error',
                        autoClose: true,
                        messages: "No se puede agregar el número: <br> <b>Ya ha sido registrado.</b>"
                    });
                }
                else{
                    telefono.principal=0;
                    this.oTelefonos.telefono.push(telefono);
                    this.render();
                }
            }else{
                //Actualiza estado como activo
                telefono.estatus = 'Activo';
                this.oTelefonos.telefono.push(telefono);
                this.model.set('account_telefonos', this.oTelefonos.telefono);
                this.render();
            }
        }
    },

    makecall: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);

        var tel_client=$input.closest("tr").find("td").eq(1).html();
        var tel_usr=app.user.attributes.ext_c;
        //var urlSugar="http://{$_SERVER['SERVER_NAME']}/unifin"; //////Activar esta variable


        /*if(this.multiSearchOr($input.closest("tr").find("td").eq(0).html(),["CELULAR"])=='1'){
             issabel='custom/Levementum/call_unifin.php?numero=044'+tel_client+'&userexten='+tel_usr;
        }else {
            issabel = 'custom/Levementum/call_unifin.php?numero=' + tel_client + '&userexten=' + tel_usr;
        }*/
        issabel = 'custom/Levementum/call_unifin.php?numero=' + tel_client + '&userexten=' + tel_usr;

        _.extend(this, issabel);

        if(tel_usr!='' || tel_usr!=null){
            if(tel_client!='' || tel_client!=null){
                context=this;
                app.alert.show('do-call', {
                    level: 'confirmation',
                    messages: '¿Realmente quieres realizar la llamada? <br><br><b>NOTA: La marcaci\u00F3n se realizar\u00E1 tal cual el n\u00FAmero est\u00E1 registrado</b>',
                    autoClose: false,
                    onConfirm: function(){
                        context.createcall(context.resultCallback);
                    },
                });
            }else{
                app.alert.show('error_tel_client', {
                    level: 'error',
                    autoClose: true,
                    messages: 'El cliente al que quieres llamar no tiene <b>N\u00FAmero telefonico</b>.'
                });
            }
        }else {
            app.alert.show('error_tel_usr', {
                level: 'error',
                autoClose: true,
                messages: 'El usuario con el que estas logueado no tiene <b>Extensi\u00F3n</b>.'
            });
        }
    },

    createcall: function (callback) {
        self=this;
        var id_call='';
        var name_client=this.model.get('name');
        var id_client=this.model.get('id');
        var Params=[id_client,name_client];
        app.api.call('create', app.api.buildURL('createcall'),{data: Params}, {
            success: _.bind(function (data) {
                id_call=data;
                console.log('Llamada creada, id: '+id_call);
                app.alert.show('message-to', {
                    level: 'info',
                    messages: 'Usted esta llamando a '+name_client,
                    autoClose: true
                });
                callback(id_call,self);
            }, this),
        });
    },

    resultCallback:function(id_call,context) {
        self=context;
        issabel+='&id_call='+id_call;
        console.log('Issabel_link:'+issabel);
        $.ajax({
            cache:false,
            type: "get",
            url: issabel,
        });

    },

    updatePrincipal: function(evt) {
          var inputs = this.$('.principal'),
              input = this.$(evt.currentTarget),
              index = inputs.index(input);
          if (this.oTelefonos.telefono[index].principal == 0) {
              if (this.oTelefonos.telefono[index].estatus == "Activo") {
                  for (var i = 0; i < this.oTelefonos.telefono.length; i++) {
                      this.oTelefonos.telefono[i].principal = 0;
                  }
                  this.oTelefonos.telefono[index].principal = 1;
              }else{
                  //No puede marcar como principal teléfono inactivo
                  app.alert.show('no_principal', {
                      level: 'warning',
                      messages: 'No se puede tener un teléfono inactivo como principal',
                      autoClose: true
                  });
              }
          }
          this.render();
    },

    updateTipotelefonot: function(evt) {
        var inputs = this.$('[data-field="campo1tel"].Tipotelefonot'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var tipo = input.val();
        this.oTelefonos.telefono[index].tipotelefono = tipo;
        //this.render();
    },

    updatePaist: function(evt) {
        var inputs = this.$('[data-field="campo2tel"].Paist'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var pais = input.val();
        this.oTelefonos.telefono[index].pais = pais;
        //this.render();
    },

    updateEstatust: function(evt) {
        var inputs = this.$('[data-field="campo3tel"].Estatust'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var estatus = input.val();
        //valida que no sea principal
        if (this.oTelefonos.telefono[index].principal == 1 && estatus == "Inactivo") {
            //No puede marcar como principal teléfono inactivo
            app.alert.show('no_principal_estatus', {
                level: 'warning',
                messages: 'No se puede tener un teléfono inactivo como principal',
                autoClose: true
            });
        }else{
            this.oTelefonos.telefono[index].estatus = estatus;
        }
        this.render();
    },

    updateExtensiont: function(evt) {
        var inputs = this.$('.Extensiont'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var extension = input.val();
        this.oTelefonos.telefono[index].extension = extension;
        //this.render();
    },

    updateTelefonot: function(evt) {
        var inputs = this.$('.Telefonot'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        var telefono = input.val();
        // if ((this.validaTamano(telefono)==false) || (this.validaTamano(telefono) && telefono=="")) {
        //     this.$('[data-name="Teléfono"]').eq(index).css('border-color', 'red');
        //     app.alert.show('telfono_cuenta_error', {
        //         level: 'error',
        //         autoClose: true,
        //         messages: 'Formato de tel\u00E9fono incorrecto'
        //     });
        //     this.$('.Telefonot').eq(index).find('input').val('');
        // }
        // else {
        //     this.$('[data-name="Teléfono"]').eq(index).css('border-color', '');
        this.oTelefonos.telefono[index].telefono = telefono;
        //}
        //this.render();
    },

})
