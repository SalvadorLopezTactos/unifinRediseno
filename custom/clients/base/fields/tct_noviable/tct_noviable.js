({
    razones_ddw_list: null,
    fuera_de_perfil_ddw_list:null,
    no_producto_requiere_list: null,


            initialize: function (options) {
                this._super('initialize', [options]);
                lnv = this;

                if (this.model.get('id')!= "" || this.model.get('id')!= null){
                    lnv.loadData();
                    lnv.bindDataChange();
                }

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
                    "PromotorLeasing":"",
                    "PromotorFactoraje":"",
                    "PromotorCreditA":"",
                    "id":""
                };
                this.model.on('sync', this.loadData, this);
                this.model.addValidationTask('GuardaNoViable', _.bind(this.SaveLeadsnoViable, this));
            },

            loadData: function (options) {
                //Recupera data existente
                //Recupera datos para vista de detalle
                var idCuenta = lnv.model.get('id');
                if (idCuenta=="" || idCuenta == undefined) {
                    idCuenta = '1';
                }
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
           //this.ocultacampos();

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

            $('.campo5nvf').change(function(evt) {
                lnv.Campo8();
            });

            $('.campo6nvca').change(function(evt) {
                lnv.Campo9();
            });

            //Pregunta el tipo de producto del usuario para poder editar campo de Lead no Viable
            $('[data-field="campo1chk"]').attr('style', 'pointer-events:none;');
            $('[data-field="campo2chk"]').attr('style', 'pointer-events:none;');
            $('[data-field="campo3chk"]').attr('style', 'pointer-events:none;');

            lnv.nvproductos();
            lnv.Muestracampo4();
            lnv.Muestracampo5();
            lnv.Muestracampo6();
            lnv.Campo7();
            lnv.Campo8();
            lnv.Campo9();
            lnv.noeditables();

        },
        cargalistas: function () {
            lnv.razones_ddw_list = app.lang.getAppListStrings('razones_ddw_list');
            lnv.fuera_de_perfil_ddw_list = app.lang.getAppListStrings('fuera_de_perfil_ddw_list');
            lnv.no_producto_requiere_list = app.lang.getAppListStrings('no_producto_requiere_list');

        },

       /* ocultacampos: function (){
            try {
                //Campos nacen ocultos Leasing
                $('.campo4').hide();
                $('.campo7').hide();
                $('.campo10').hide();
                $('.campo13').hide();
                $('.campo16').hide();
                //Campos nacen ocultos factoraje
                $('.campo5').hide();
                $('.campo8').hide();
                $('.campo11').hide();
                $('.campo14').hide();
                $('.campo17').hide();
                //Campos nacen ocultos Credito Automotriz
                $('.campo6').hide();
                $('.campo9').hide();
                $('.campo12').hide();
                $('.campo15').hide();
                $('.campo18').hide();
            }catch (err){
                    console.log(err.message);
                }
        },*/

            Muestracampo4: function () {
                    $('.campo4').hide();
                    $('.campo7').hide();
                    $('.campo10').hide();
                    $('.campo13').hide();
                    $('.campo16').hide();
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
                if ($('.campo3chk')[0].checked) {
                    $('.campo6').show();
                }
            },

            Campo7: function () {
                if (($('.campo4nvl').select2('val') == "Fuera de Perfil" || $('.campo4nvl option:selected').text()=="Fuera de Perfil" || $('.campo4nvl')[0].innerText.trim()== "Fuera de Perfil") && $('.campo1chk')[0].checked) {
                    $('.campo7').show();
                } else {
                    $('.campo7').hide();
                }
                if (($('.campo4nvl').select2('val') == "Competencia" || $('.campo4nvl option:selected').text()=="Competencia" || $('.campo4nvl')[0].innerText.trim()== "Competencia") && $('.campo1chk')[0].checked) {
                    $('.campo10').show();
                    $('.campo13').show();
                } else {
                    $('.campo10').hide();
                    $('.campo13').hide();
                }
                if (($('.campo4nvl').select2('val') == "No tenemos el producto que requiere" || $('.campo4nvl option:selected').text()=="No tenemos el producto que requiere" ||$('.campo4nvl')[0].innerText.trim()== "No tenemos el producto que requiere") && $('.campo1chk')[0].checked) {
                    $('.campo16').show();
                } else {
                    $('.campo16').hide();
                }
            },
            Campo8: function () {
                if (($('.campo5nvf').select2('val') == "Fuera de Perfil" || $('.campo5nvf option:selected').text()=="Fuera de Perfil" ||$('.campo5nvf')[0].innerText.trim()== "Fuera de Perfil") && $('.campo2chk')[0].checked) {
                    $('.campo8').show();
                } else {
                    $('.campo8').hide();
                }
                if (($('.campo5nvf').select2('val') == "Competencia" || $('.campo5nvf option:selected').text()=="Competencia" || $('.campo5nvf')[0].innerText.trim()== "Competencia") && $('.campo2chk')[0].checked) {
                    $('.campo11').show();
                    $('.campo14').show();
                } else {
                    $('.campo11').hide();
                    $('.campo14').hide();
                }
                if (($('.campo5nvf').select2('val') == "No tenemos el producto que requiere" || $('.campo5nvf option:selected').text()=="No tenemos el producto que requiere" ||  $('.campo5nvf')[0].innerText.trim()== "No tenemos el producto que requiere") &&
                    $('.campo2chk')[0].checked) {
                    $('.campo17').show();
                } else {
                    $('.campo17').hide();
                }
            },
            Campo9: function () {
                if (($('.campo6nvca').select2('val') == "Fuera de Perfil" || $('.campo6nvca option:selected').text()=="Fuera de Perfil" || $('.campo6nvca')[0].innerText.trim()== "Fuera de Perfil") && $('.campo3chk')[0].checked) {
                    $('.campo9').show();
                } else {
                    $('.campo9').hide();
                }
                if (($('.campo6nvca').select2('val') == "Competencia" ||  $('.campo6nvca option:selected').text()=="Competencia" || $('.campo6nvca')[0].innerText.trim()== "Competencia") && $('.campo3chk')[0].checked) {
                    $('.campo12').show();
                    $('.campo15').show();
                } else {
                    $('.campo12').hide();
                    $('.campo15').hide();
                }
                if (($('.campo6nvca').select2('val') == "No tenemos el producto que requiere" ||  $('.campo6nvca option:selected').text()=="No tenemos el producto que requiere" ||  $('.campo6nvca')[0].innerText.trim()== "No tenemos el producto que requiere")  &&
                    $('.campo3chk')[0].checked) {
                    $('.campo18').show();
                } else {
                    $('.campo18').hide();
                }
            },

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
                if (this.model.get('tipo_registro_c')=="Lead" && this.model.get('id')!= "" && this.model.get('id')!= undefined && ($('.campo1chk')[0].checked== true || $('.campo2chk')[0].checked== true || $('.campo3chk')[0].checked== true)){
                    //Mapea los campos del modulo No viable en el objeto lnv.leadNoViable
                    lnv.leadNoViable.campo1chk = $('.campo1chk')[0].checked;
                    lnv.leadNoViable.campo2chk = $('.campo2chk')[0].checked;
                    lnv.leadNoViable.campo3chk = $('.campo3chk')[0].checked;
                    lnv.leadNoViable.razonleasing = $('.campo4nvl').select2('val');
                    lnv.leadNoViable.razonfactoraje = $('.campo5nvf').select2('val');
                    lnv.leadNoViable.razonca = $('.campo6nvca').select2('val');
                    lnv.leadNoViable.fueraperfilL = $('.campo7nvl').select2('val');
                    lnv.leadNoViable.fueraperfilF = $('.campo8nvf').select2('val');
                    lnv.leadNoViable.fueraperfilCA = $('.campo9nvca').select2('val');
                    lnv.leadNoViable.quienl = $('.campo10nvl').val();
                    lnv.leadNoViable.porquel = $('.campo13nvl').val();
                    lnv.leadNoViable.noproducl = $('.campo16nvl').select2('val');
                    lnv.leadNoViable.quienf = $('.campo11nvf').val();
                    lnv.leadNoViable.porquef = $('.campo14nvf').val();
                    lnv.leadNoViable.noproducf = $('.campo17nvf').select2('val');
                    lnv.leadNoViable.quienca = $('.campo12nvca').val();
                    lnv.leadNoViable.porqueca = $('.campo15nvca').val();
                    lnv.leadNoViable.noproducca = $('.campo18nvca').select2('val');

                    if ($('.campo1chk')[0].checked== true && lnv.leadNoViable.PromotorLeasing==""){
                        lnv.leadNoViable.PromotorLeasing = App.user.attributes.id;
                    }
                    if ($('.campo2chk')[0].checked== true && lnv.leadNoViable.PromotorFactoraje==""){
                        lnv.leadNoViable.PromotorFactoraje = App.user.attributes.id;
                    }
                    if ($('.campo3chk')[0].checked== true && lnv.leadNoViable.PromotorCreditA==""){
                        lnv.leadNoViable.PromotorCreditA = App.user.attributes.id;
                    }
                    //Establece el objeto lnv.leadNoViable para guardar
                    this.model.set('tct_noviable',  lnv.leadNoViable);
                }
                callback(null, fields, errors);
            },

           noeditables: function (){
              if ($('.campo1chk')[0].checked){
                  //Campos sin editar Leasing
                  $('.campo1chk').css({pointerEvents:"none"});
                  $('.campo4').css({pointerEvents:"none"});
                  $('.campo7').css({pointerEvents:"none"});
                  $('.campo10').css({pointerEvents:"none"});
                  $('.campo13').css({pointerEvents:"none"});
                  $('.campo16').css({pointerEvents:"none"});
              }
               if($('.campo2chk')[0].checked){
                   //Campos sin editar Factoraje
                   $('.campo2chk').css({pointerEvents:"none"});
                   $('.campo5').css({pointerEvents:"none"});
                   $('.campo8').css({pointerEvents:"none"});
                   $('.campo11').css({pointerEvents:"none"});
                   $('.campo14').css({pointerEvents:"none"});
                   $('.campo17').css({pointerEvents:"none"});
               }
               if ($('.campo3chk')[0].checked){
                   //Campos sin editar Credito Automotriz
                   $('.campo3chk').css({pointerEvents:"none"});
                   $('.campo6').css({pointerEvents:"none"});
                   $('.campo9').css({pointerEvents:"none"});
                   $('.campo12').css({pointerEvents:"none"});
                   $('.campo15').css({pointerEvents:"none"});
                   $('.campo18').css({pointerEvents:"none"});
              }


            },
})