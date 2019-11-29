({
    //Carga de Listas de valores
    razones_ddw_list: null,
    fuera_de_perfil_ddw_list:null,
    no_producto_requiere_list: null,
    razones_cf_list: null,
    tct_razon_ni_l_ddw_c_list: null,

            events: {
                'keydown .campo10nvl': 'PuroTexto',
                'keydown .campo13nvl': 'PuroTexto',
                'keydown .campo11nvf': 'PuroTexto',
                'keydown .campo14nvf': 'PuroTexto',
                'keydown .campo12nvca': 'PuroTexto',
                'keydown .campo15nvca': 'PuroTexto',
            },


            initialize: function (options) {
                this._super('initialize', [options]);
                lnv = this;

                // if (this.model.get('id')!= "" && this.model.get('id')!= null){
                //     lnv.loadData();
                //     lnv.bindDataChange();
                // }
                //Creacion de objeto para guardar datos hacia el modulo tct3_noviable
                lnv.leadNoViable = {
                    "campo1chk":"",
                    "campo2chk":"",
                    "campo3chk":"",
                    "razonleasing":"",
                    "razonfactoraje":"",
                    "razonca":"",
                    "fueraperfilL":"",
                    "fueraperfilF":"",
                    "fueraperfilCA":"",
                    "quienl":"",
                    "porquel":"",
                    "noproducl":"",
                    "quienf":"",
                    "porquef":"",
                    "noproducf":"",
                    "quienca":"",
                    "porqueca":"",
                    "noproducca":"",
                    //nuevos campos
                    "razoncfl":"",
                    "razonnil":"",
                    "queprodl":"",
                    "razoncff":"",
                    "razonnif":"",
                    "queprodf":"",
                    "razoncfca":"",
                    "razonnica":"",
                    "queprodca":"",
                    "PromotorLeasing":"",
                    "PromotorFactoraje":"",
                    "PromotorCreditA":"",
                    "id":""
                };
                this.model.on('sync', this.loadData, this);
                //Validación para guardar el objeto LeadNoViable
                this.model.addValidationTask('GuardaNoViable', _.bind(this.SaveLeadsnoViable, this));
            },

            loadData: function (options) {
                //Recupera data existente
                //Recupera datos para vista de detalle
                var idCuenta = lnv.model.get('id');
                if (idCuenta=="" && idCuenta == undefined) {
                    return;
                }
                //Api Call para recuperar valores de los campos del módulo tct3_noviable.
            app.api.call('GET', app.api.buildURL('Accounts/'+idCuenta+'/link/accounts_tct3_noviable_1'), null, {
                success: function (data) {

                    if (data.records.length>0) {
                    //Genera Mapeo
                    lnv.leadNoViable.campo1chk = data.records[0].no_viable_leasing_chk_c;
                    lnv.leadNoViable.campo2chk = data.records[0].no_viable_factoraje_chk_c;
                    lnv.leadNoViable.campo3chk = data.records[0].no_viable_ca_chk_c;
                    lnv.leadNoViable.razonleasing = data.records[0].razones_leasing_ddw_c;
                    lnv.leadNoViable.razonfactoraje = data.records[0].razones_factoraje_ddw_c;
                    lnv.leadNoViable.razonca = data.records[0].razones_ca_ddw_c;
                    lnv.leadNoViable.fueraperfilL = data.records[0].fuera_perfil_l_ddw_c;
                    lnv.leadNoViable.fueraperfilF = data.records[0].fuera_perfil_f_ddw_c;
                    lnv.leadNoViable.fueraperfilCA = data.records[0].fuera_perfil_ca_ddw_c;
                    lnv.leadNoViable.quienl = data.records[0].tct_competencia_quien_l_txf_c;
                    lnv.leadNoViable.porquel = data.records[0].tct_competencia_porque_l_txf_c;
                    lnv.leadNoViable.noproducl = data.records[0].no_producto_requiere_l_ddw_c;
                    lnv.leadNoViable.quienf = data.records[0].tct_competencia_quien_f_txf_c;
                    lnv.leadNoViable.porquef = data.records[0].tct_competencia_porque_f_txf_c;
                    lnv.leadNoViable.noproducf = data.records[0].no_producto_requiere_f_ddw_c;
                    lnv.leadNoViable.quienca = data.records[0].tct_competencia_quien_ca_txf_c;
                    lnv.leadNoViable.porqueca = data.records[0].tct_competencia_porque_ca_txf_c;
                    lnv.leadNoViable.noproducca = data.records[0].no_producto_requiere_ca_ddw_c;
                    //Nuevos Campos
                    lnv.leadNoViable.razoncfl= data.records[0].tct_razon_cf_l_ddw_c;
                    lnv.leadNoViable.razonnil= data.records[0].tct_razon_ni_l_ddw_c;
                    lnv.leadNoViable.queprodl= data.records[0].tct_que_producto_l_txf_c;
                    lnv.leadNoViable.razoncff= data.records[0].tct_razon_cf_f_ddw_c;
                    lnv.leadNoViable.razonnif= data.records[0].tct_razon_ni_f_ddw_c;
                    lnv.leadNoViable.queprodf= data.records[0].tct_que_producto_f_txf_c;
                    lnv.leadNoViable.razoncfca= data.records[0].tct_razon_cf_ca_ddw_c;
                    lnv.leadNoViable.razonnica= data.records[0].tct_razon_ni_ca_ddw_c;
                    lnv.leadNoViable.queprodca= data.records[0].tct_que_producto_ca_txf_c;

                    lnv.leadNoViable.PromotorLeasing= data.records[0].user_id_c;
                    lnv.leadNoViable.PromotorFactoraje= data.records[0].user_id1_c;
                    lnv.leadNoViable.PromotorCreditA= data.records[0].user_id2_c;
                    lnv.leadNoViable.id = data.records[0].id;

                    _.extend(this, lnv.leadNoViable);
                    lnv.render();
                    }
                },
                error: function (e) {
                    throw e;
                }
            });
            //this.render();
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
            $("div.record-label[data-name='tct_noviable']").attr('style', 'display:none;');
           this.cargalistas();
            //Funciones de visibilidad para campos conforme al check en cada producto.
            $('.campo1chk').change(function(evt) {
                lnv.Muestracampo4();
            });

            $('.campo2chk').change(function(evt) {
                lnv.Muestracampo5();
            });

            $('.campo3chk').change(function(evt) {
                lnv.Muestracampo6();
            });
            $('.campo4nvl').change(function(evt) {
                lnv.Campo7();
            });
            $('.campo16nvl').change(function(evt) {
                lnv.Campo7();
            });
            $('.campo5nvf').change(function(evt) {
                lnv.Campo8();
            });
            $('.campo17nvf').change(function(evt) {
                lnv.Campo8();
            });
            $('.campo6nvca').change(function(evt) {
                lnv.Campo9();
            });
            $('.campo18nvca').change(function(evt) {
                lnv.Campo9();
            });


            //Pregunta el tipo de producto del usuario para poder editar campo de Lead no Viable
            $('[data-field="campo1chk"]').attr('style', 'pointer-events:none;');
            $('[data-field="campo2chk"]').attr('style', 'pointer-events:none;');
            $('[data-field="campo3chk"]').attr('style', 'pointer-events:none;');
            try {
                lnv.nvproductos();
                lnv.Muestracampo4();
                lnv.Muestracampo5();
                lnv.Muestracampo6();
                lnv.Campo7();
                lnv.Campo8();
                lnv.Campo9();
                lnv.noeditables();
            }catch (err){
                console.log(err.message);
            }
            //Funcion para dar estilo select2 a las listas deplegables.
            var $select = $('select.select2');
            $select.select2();

        },
        //Carga las listas desplegables para los campos.
        cargalistas: function () {
            lnv.razones_ddw_list = app.lang.getAppListStrings('razones_ddw_list');
            lnv.fuera_de_perfil_ddw_list = app.lang.getAppListStrings('fuera_de_perfil_ddw_list');
            lnv.no_producto_requiere_list = app.lang.getAppListStrings('no_producto_requiere_list');
            lnv.razones_cf_list = app.lang.getAppListStrings('razones_cf_list');
            lnv.tct_razon_ni_l_ddw_c_list = app.lang.getAppListStrings('tct_razon_ni_l_ddw_c_list');

        },

            Muestracampo4: function () {
                    $('.campo4').hide();
                    $('.campo7').hide();
                    $('.campo10').hide();
                    $('.campo13').hide();
                    $('.campo16').hide();
                    $('.campo19').hide();
                    $('.campo22').hide();
                    $('.campo25').hide();
                if ($('.campo1chk')[0].checked) {
                    $('.campo4').show();
                }
            },
            Muestracampo5: function () {
                    $('.campo5').hide();
                    $('.campo8').hide();
                    $('.campo11').hide();
                    $('.campo14').hide();
                    $('.campo17').hide();
                    $('.campo20').hide();
                    $('.campo23').hide();
                    $('.campo26').hide();
                if ($('.campo2chk')[0].checked) {
                    $('.campo5').show();
                }
            },
            Muestracampo6: function () {
                    $('.campo6').hide();
                    $('.campo9').hide();
                    $('.campo12').hide();
                    $('.campo15').hide();
                    $('.campo18').hide();
                    $('.campo21').hide();
                    $('.campo24').hide();
                    $('.campo27').hide();
                if ($('.campo3chk')[0].checked) {
                    $('.campo6').show();
                }
            },

            Campo7: function () {
                if (($('.campo4nvl').select2('val') == "Fuera de Perfil" || $('.campo4nvl option:selected').text()=="Fuera de Perfil" || $('.campo4nvl')[0].innerText.trim()== "Fuera de Perfil") && $('.campo1chk')[0].checked) {
                    $('.campo7').show();
                } else {
                    $('.campo7').hide();
                    $('.campo7nvl').select2('val',"");
                }
                if (($('.campo4nvl').select2('val') == "Competencia" || $('.campo4nvl option:selected').text()=="Competencia" || $('.campo4nvl')[0].innerText.trim()== "Competencia" || $('.campo4nvl option:selected').text()=="Ya está con la competencia") && $('.campo1chk')[0].checked) {
                    $('.campo10').show();
                    $('.campo13').show();
                } else {
                    $('.campo10').hide();
                    $('.campo13').hide();
                    $('.campo10nvl').val("");
                    $('.campo13nvl').val("");
                }
                if (($('.campo4nvl').select2('val') == "No tenemos el producto que requiere" || $('.campo4nvl option:selected').text()=="No tenemos el producto que requiere" ||$('.campo4nvl')[0].innerText.trim()== "No tenemos el producto que requiere") && $('.campo1chk')[0].checked) {
                    $('.campo16').show();
                } else {
                    $('.campo16').hide();
                    $('.campo16nvl').select2('val',"");
                }
                if (($('.campo4nvl').select2('val') == "Condiciones Financieras" || $('.campo4nvl option:selected').text()=="Condiciones Financieras" ||$('.campo4nvl')[0].innerText.trim()== "Condiciones Financieras") && $('.campo1chk')[0].checked) {
                    $('.campo19').show();
                } else {
                    $('.campo19').hide();
                    $('.campo19nvl').select2('val',"");
                }
                if (($('.campo4nvl').select2('val') == "No tenemos el producto que requiere" || $('.campo4nvl option:selected').text()=="No tenemos el producto que requiere" ||$('.campo4nvl')[0].innerText.trim()== "No tenemos el producto que requiere") && ($('.campo16nvl').select2('val') == "Otro" || $('.campo16nvl option:selected').text()=="Otro" ||$('.campo16nvl')[0].innerText.trim()== "Otro") && $('.campo1chk')[0].checked) {
                    $('.campo22').show();
                } else {
                    $('.campo22').hide();
                    $('.campo22nvl').val("");
                }
                if (($('.campo4nvl').select2('val') == "No se encuentra interesado" || $('.campo4nvl option:selected').text()=="No se encuentra interesado" ||$('.campo4nvl')[0].innerText.trim()== "No se encuentra interesado") && $('.campo1chk')[0].checked) {
                    $('.campo25').show();
                } else {
                    $('.campo25').hide();
                    $('.campo25nvl').select2('val',"");
                }
            },
            Campo8: function () {
                if (($('.campo5nvf').select2('val') == "Fuera de Perfil" || $('.campo5nvf option:selected').text()=="Fuera de Perfil" ||$('.campo5nvf')[0].innerText.trim()== "Fuera de Perfil") && $('.campo2chk')[0].checked) {
                    $('.campo8').show();
                } else {
                    $('.campo8').hide();
                    $('.campo8nvf').select2('val',"");
                }
                if (($('.campo5nvf').select2('val') == "Competencia" || $('.campo5nvf option:selected').text()=="Competencia" || $('.campo5nvf')[0].innerText.trim()== "Competencia" || $('.campo5nvf option:selected').text()=="Ya está con la competencia") && $('.campo2chk')[0].checked) {
                    $('.campo11').show();
                    $('.campo14').show();
                } else {
                    $('.campo11').hide();
                    $('.campo14').hide();
                    $('.campo11nvf').val("");
                    $('.campo14nvf').val("");
                }
                if (($('.campo5nvf').select2('val') == "No tenemos el producto que requiere" || $('.campo5nvf option:selected').text()=="No tenemos el producto que requiere" ||  $('.campo5nvf')[0].innerText.trim()== "No tenemos el producto que requiere") &&
                    $('.campo2chk')[0].checked) {
                    $('.campo17').show();
                } else {
                    $('.campo17').hide();
                    $('.campo17nvf').select2('val',"");
                }
                if (($('.campo5nvf').select2('val') == "Condiciones Financieras" || $('.campo5nvf option:selected').text()=="Condiciones Financieras" ||$('.campo5nvf')[0].innerText.trim()== "Condiciones Financieras") && $('.campo2chk')[0].checked) {
                    $('.campo20').show();
                } else {
                    $('.campo20').hide();
                    $('.campo20nvf').select2('val',"");
                }
                if (($('.campo5nvf').select2('val') == "No tenemos el producto que requiere" || $('.campo5nvf option:selected').text()=="No tenemos el producto que requiere" ||  $('.campo5nvf')[0].innerText.trim()== "No tenemos el producto que requiere") &&($('.campo17nvf').select2('val') == "Otro" || $('.campo17nvf option:selected').text()=="Otro" ||$('.campo17nvf')[0].innerText.trim()== "Otro") && $('.campo2chk')[0].checked) {
                    $('.campo23').show();
                } else {
                    $('.campo23nvf').val("");
                    $('.campo23').hide();
                }
                if (($('.campo5nvf').select2('val') == "No se encuentra interesado" || $('.campo5nvf option:selected').text()=="No se encuentra interesado" ||$('.campo5nvf')[0].innerText.trim()== "No se encuentra interesado") && $('.campo2chk')[0].checked) {
                    $('.campo26').show();
                } else {
                    $('.campo26').hide();
                    $('.campo26nvf').select2('val',"");
                }
            },
            Campo9: function () {
                if (($('.campo6nvca').select2('val') == "Fuera de Perfil" || $('.campo6nvca option:selected').text()=="Fuera de Perfil" || $('.campo6nvca')[0].innerText.trim()== "Fuera de Perfil") && $('.campo3chk')[0].checked) {
                    $('.campo9').show();
                } else {
                    $('.campo9').hide();
                    $('.campo9nvca').select2('val',"");
                }
                if (($('.campo6nvca').select2('val') == "Competencia" ||  $('.campo6nvca option:selected').text()=="Competencia" || $('.campo6nvca')[0].innerText.trim()== "Competencia" || $('.campo6nvca option:selected').text()=="Ya está con la competencia") && $('.campo3chk')[0].checked) {
                    $('.campo12').show();
                    $('.campo15').show();
                } else {
                    $('.campo12').hide();
                    $('.campo15').hide();
                    $('.campo12nvca').val("");
                    $('.campo15nvca').val("");
                }
                if (($('.campo6nvca').select2('val') == "No tenemos el producto que requiere" ||  $('.campo6nvca option:selected').text()=="No tenemos el producto que requiere" ||  $('.campo6nvca')[0].innerText.trim()== "No tenemos el producto que requiere")  &&
                    $('.campo3chk')[0].checked) {
                    $('.campo18').show();
                } else {
                    $('.campo18').hide();
                    $('.campo18nvca').select2('val',"");
                }
                if (($('.campo6nvca').select2('val') == "Condiciones Financieras" || $('.campo6nvca option:selected').text()=="Condiciones Financieras" ||$('.campo6nvca')[0].innerText.trim()== "Condiciones Financieras") && $('.campo3chk')[0].checked) {
                    $('.campo21').show();
                } else {
                    $('.campo21').hide();
                    $('.campo21nvca').select2('val',"");
                }
                if (($('.campo6nvca').select2('val') == "No tenemos el producto que requiere" ||  $('.campo6nvca option:selected').text()=="No tenemos el producto que requiere" ||  $('.campo6nvca')[0].innerText.trim()== "No tenemos el producto que requiere") &&($('.campo18nvca').select2('val') == "Otro" || $('.campo18nvca option:selected').text()=="Otro" ||$('.campo18nvca')[0].innerText.trim()== "Otro") && $('.campo3chk')[0].checked) {
                    $('.campo24').show();
                } else {
                    $('.campo24nvca').val("");
                    $('.campo24').hide();
                }
                if (($('.campo6nvca').select2('val') == "No se encuentra interesado" || $('.campo6nvca option:selected').text()=="No se encuentra interesado" ||$('.campo6nvca')[0].innerText.trim()== "No se encuentra interesado") && $('.campo3chk')[0].checked) {
                    $('.campo27').show();
                } else {
                    $('.campo27').hide();
                    $('.campo27nvca').select2('val',"");
                }

            },

            //Funcion para habilitar la funcionalidad de los checks de cada producto dependiendo del producto que tenga el usuario logueado.
            nvproductos: function (){
                var productos = App.user.attributes.productos_c;
                if (productos.includes("1")) {
                    $('[data-field="campo1chk"]').attr('style', 'pointer-events:block;');
                }
                if (productos.includes("4")) {
                    $('[data-field="campo2chk"]').attr('style', 'pointer-events:block;');
                }
                if (productos.includes("3")) {
                    $('[data-field="campo3chk"]').attr('style', 'pointer-events:block;');
                }
            },

            SaveLeadsnoViable: function (fields, errors, callback) {
                if (Oproductos.productos != undefined) {
                  if ((Oproductos.productos.tct_tipo_l_txf_c == 'Lead' || Oproductos.productos.tct_tipo_f_txf_c == 'Lead' || Oproductos.productos.tct_tipo_ca_txf_c == 'Lead') && this.model.get('id')!= "" && this.model.get('id')!= undefined){
                      //Mapea los campos del modulo No viable con producto LEASING en el objeto lnv.leadNoViable
                      if($('.campo1chk')[0].checked== true && typeof $('.campo4nvl').select2('val')=="string"){
                          lnv.leadNoViable.campo1chk = $('.campo1chk')[0].checked;
                          lnv.leadNoViable.razonleasing = $('.campo4nvl').select2('val');
                          lnv.leadNoViable.fueraperfilL = $('.campo7nvl').select2('val');
                          lnv.leadNoViable.quienl = $('.campo10nvl').val().trim();
                          lnv.leadNoViable.porquel = $('.campo13nvl').val().trim();
                          lnv.leadNoViable.noproducl = $('.campo16nvl').select2('val');
                          lnv.leadNoViable.razoncfl = $('.campo19nvl').select2('val');
                          lnv.leadNoViable.queprodl= $('.campo22nvl').val().trim();
                          lnv.leadNoViable.razonnil = $('.campo25nvl').select2('val');
                      }
                      //Mapea los campos del modulo No viable con producto FACTORAJE en el objeto lnv.leadNoViable
                      if ( $('.campo2chk')[0].checked== true && typeof $('.campo5nvf').select2('val')=="string"){
                          lnv.leadNoViable.campo2chk = $('.campo2chk')[0].checked;
                          lnv.leadNoViable.razonfactoraje = $('.campo5nvf').select2('val');
                          lnv.leadNoViable.fueraperfilF = $('.campo8nvf').select2('val');
                          lnv.leadNoViable.quienf = $('.campo11nvf').val().trim();
                          lnv.leadNoViable.porquef = $('.campo14nvf').val().trim();
                          lnv.leadNoViable.noproducf = $('.campo17nvf').select2('val');
                          lnv.leadNoViable.razoncff = $('.campo20nvf').select2('val');
                          lnv.leadNoViable.queprodf = $('.campo23nvf').val().trim();
                          lnv.leadNoViable.razonnif= $('.campo26nvf').select2('val');
                      }
                      //Mapea los campos del modulo No viable con producto CREDITO AUTOMOTRIZ en el objeto lnv.leadNoViable
                      if($('.campo3chk')[0].checked== true && typeof $('.campo6nvca').select2('val')=="string"){
                          lnv.leadNoViable.campo3chk = $('.campo3chk')[0].checked;
                          lnv.leadNoViable.razonca = $('.campo6nvca').select2('val');
                          lnv.leadNoViable.fueraperfilCA = $('.campo9nvca').select2('val');
                          lnv.leadNoViable.quienca = $('.campo12nvca').val().trim();
                          lnv.leadNoViable.porqueca = $('.campo15nvca').val().trim();
                          lnv.leadNoViable.noproducca = $('.campo18nvca').select2('val');
                          lnv.leadNoViable.razoncfca = $('.campo21nvca').select2('val');
                          lnv.leadNoViable.queprodca= $('.campo24nvca').val().trim();
                          lnv.leadNoViable.razonnica= $('.campo27nvca').select2('val');
                      }
                      //Establece el objeto lnv.leadNoViable para guardar
                      if ($('.campo1chk')[0].checked== true || $('.campo2chk')[0].checked== true || $('.campo3chk')[0].checked== true) {
                          this.model.set('tct_noviable',  lnv.leadNoViable);
                      }
                  }
                }
                callback(null, fields, errors);
            },
            //Validación para dejar sin editar los campos de producto después de haberlos editado por primera y única vez.
           noeditables: function (){
              if ($('.campo1chk')[0].checked){
                  //Campos sin editar Leasing
                  $('.campo1chk').prop("disabled", true);
                  $('.campo4nvl').prop("disabled", true);
                  $('.campo7nvl').prop("disabled", true);
                  $('.campo10nvl').prop("disabled", true);
                  $('.campo13nvl').prop("disabled", true);
                  $('.campo16nvl').prop("disabled", true);
                  $('.campo19nvl').prop("disabled",true);
                  $('.campo22nvl').prop("disabled",true);
                  $('.campo25nvl').prop("disabled", true);
              }
               if($('.campo2chk')[0].checked){
                   //Campos sin editar Factoraje
                   $('.campo2chk').prop("disabled", true);
                   $('.campo5nvf').prop("disabled", true);
                   $('.campo8nvf').prop("disabled", true);
                   $('.campo11nvf').prop("disabled", true);
                   $('.campo14nvf').prop("disabled", true);
                   $('.campo17nvf').prop("disabled", true);
                   $('.campo20nvf').prop("disabled", true);
                   $('.campo23nvf').prop("disabled", true);
                   $('.campo26nvf').prop("disabled", true);
               }
               if ($('.campo3chk')[0].checked){
                   //Campos sin editar Credito Automotriz
                   $('.campo3chk').prop("disabled", true);
                   $('.campo6nvca').prop("disabled", true);
                   $('.campo9nvca').prop("disabled", true);
                   $('.campo12nvca').prop("disabled", true);
                   $('.campo15nvca').prop("disabled", true);
                   $('.campo18nvca').prop("disabled", true);
                   $('.campo21nvca').prop("disabled", true);
                   $('.campo24nvca').prop("disabled", true);
                   $('.campo27nvca').prop("disabled", true);
              }

            },

            //Funcion que acepta solo letras (a-z), puntos(.) y comas(,)
            PuroTexto: function (evt) {
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
})
