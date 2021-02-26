/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    razon_nv_list: null,
    fuera_perfil_list: null,
    condiciones_financieras_list: null,
    no_producto_list: null,
    no_interesado_list: null,
    context_NoViable: null,

    events: {
        'click #btn-cancela': 'closeModal',
        'click #btn-aceptar': 'aceptarModal',
    },

    initialize: function (options) {
        self_modal_get = this;
        contextIdCuentas = options.contextIdCuenta;

        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:ModalNoViableCuentas', function () {

                var temp_array_get = [];
                var newContext = options.context.get('model');

                // RAZON CUENTA NO VIABLE
                var razon_noviable = app.lang.getAppListStrings('razones_ddw_list');
                var list_html_nv = '<option value=""></option>';
                _.each(razon_noviable, function (value, key) {
                    list_html_nv += '<option value="' + key + '">' + razon_noviable[key] + '</option>';
                });
                self_modal_get.razon_nv_list = list_html_nv;

                // RAZON FUERA DE PERFIL
                var razon_fueraperfil = app.lang.getAppListStrings('fuera_de_perfil_ddw_list');
                var list_html_fp = '<option value=""></option>';
                _.each(razon_fueraperfil, function (value, key) {
                    list_html_fp += '<option value="' + key + '">' + razon_fueraperfil[key] + '</option>';
                });
                self_modal_get.fuera_perfil_list = list_html_fp;

                //CONDICIONES FINANCIERAS
                var condiciones_financieras = app.lang.getAppListStrings('razones_cf_list');
                var list_html_cf = '<option value=""></option>';
                _.each(condiciones_financieras, function (value, key) {
                    list_html_cf += '<option value="' + key + '">' + condiciones_financieras[key] + '</option>';
                });
                self_modal_get.condiciones_financieras_list = list_html_cf;

                //NO TENEMOS EL PRODUCTO QUE REQUIERE
                var no_producto = app.lang.getAppListStrings('no_producto_requiere_list');
                var list_html_npr = '<option value=""></option>';
                _.each(no_producto, function (value, key) {
                    list_html_npr += '<option value="' + key + '">' + no_producto[key] + '</option>';
                });
                self_modal_get.no_producto_list = list_html_npr;

                //NO SE ENCUENTRA INTERESADO
                var no_interesado = app.lang.getAppListStrings('tct_razon_ni_l_ddw_c_list');
                var list_html_ni = '<option value=""></option>';
                _.each(no_interesado, function (value, key) {
                    list_html_ni += '<option value="' + key + '">' + no_interesado[key] + '</option>';
                });
                self_modal_get.no_interesado_list = list_html_ni;

                self_modal_get.context_NoViable = options;
                self_modal_get.render();
                this.$('.modal').modal({
                    backdrop: '',
                    // keyboard: true,
                    // focus: true
                });
                this.$('.modal').modal('show');
                $('.datepicker').css('z-index', '2000px');
                app.$contentEl.attr('aria-hidden', true);
                $('.modal-backdrop').insertAfter($('.modal'));
                /**If any validation error occurs, system will throw error and we need to enable the buttons back*/
                this.context.get('model').on('error:validation', function () {
                    this.disableButtons(false);
                }, this);
            }, this);
        }
        this.bindDataChange();
    },

    _render: function () {
        this._super("_render");

        $('#RazonNoViable').change(function (evt) {
            self_modal_get.dependenciasNV();
        });
        self_modal_get.dependenciasNV();

        //Jquery para que no se cierre el modal con ESC o al dar clic afuera del modal
        $('#ModalNoViableCuentas').modal({backdrop: 'static', keyboard: false});
    },

    dependenciasNV: function () {

        KeyRazonNV = $("#RazonNoViable").val();
        
        //Campos ocultos dependendientes de no viable
        $('#fuera_perfil').hide();
        $('#cond_financieras').hide();
        $('#competencia_quien').hide();
        $('#competencia_porque').hide();
        $('#no_product').hide();
        $('#otro_producto').hide();
        $('#no_interesado').hide();

        //FUERA DE PERFIL
        if (KeyRazonNV == "1") {
            $('#fuera_perfil').show();
        }
        //CONDICIONES FINANCIERAS
        if (KeyRazonNV == "2") {
            $('#cond_financieras').show();
        }
        //YA ESTA CON LA COMPETENCIA
        if (KeyRazonNV == "3") {
            $('#competencia_quien').show();
            $('#competencia_porque').show();
        }
        //NO TENEMOS EL PRODUCTO QUE REQUIERE
        if (KeyRazonNV == "4") {
            $('#no_product').show();
        }
        //OPCION "OTRO" EN NO TENEMOS EL PRODUCTO QUE REQUIERE
        $('#noProducto').change(function (evt) {
            $('#otro_producto').hide();
            
            if ($("#noProducto").val() == "4"){
                $('#otro_producto').show();
            }
        });
        //NO SE ENCUENTRA INTERESADO
        if (KeyRazonNV == "7") {
            $('#no_interesado').show();
        }
    },

    aceptarModal: function () {

        self_prodnv = this;

        var KeyRazonNV = $("#RazonNoViable").val();
        var keyfueradePerfil = $("#FueradePerfil").val();
        var keycondFinancieras = $("#condFinancieras").val();
        var txtcomp_quien = $("#comp_quien").val();
        var txtcomp_porque = $("#comp_porque").val();
        var keynoProducto = $("#noProducto").val();
        var txtotroProducto = $("#otroProducto").val();
        var keynoInteresado = $("#noInteresado").val();

        var idProdM = '';
        var usertipoproducto = App.user.attributes.tipodeproducto_c; //Tipo de producto que tiene el usuario
        var emptynoviable = 0;
        
        ////////////////////////////VALIDACION DE CAMPOS REQUERIDOS EN EL MODAL//////////////////////////
        if ($("#RazonNoViable").val() == "" || $("#RazonNoViable").val() == "0") {
            // $('#RazonNoViable').css('border-color', 'red');
            $('#razon_noviable').find('.select2-choice').css('border-color', 'red');
            emptynoviable += 1;
        }
        if ($("#RazonNoViable").val() == "1" && ($("#FueradePerfil").val() == "" || $("#FueradePerfil").val() == "0")) {
            // $('#FueradePerfil').css('border-color', 'red');
            $('#fuera_perfil').find('.select2-choice').css('border-color', 'red');
            emptynoviable += 1;
        }
        if ($("#RazonNoViable").val() == "2" && ($("#condFinancieras").val() == "" || $("#condFinancieras").val() == "0")) {
            //  $('#condFinancieras').css('border-color', 'red');
            $('#cond_financieras').find('.select2-choice').css('border-color', 'red');
            emptynoviable += 1;
        }
        if ($("#RazonNoViable").val() == "3" && $('#comp_quien').val().trim() == "" && $('#comp_porque').val().trim() == "") {
            $('#comp_quien').css('border-color', 'red');
            $('#comp_porque').css('border-color', 'red');
            emptynoviable += 1;
        }
        if ($("#RazonNoViable").val() == "3" && $('#comp_quien').val().trim() == "" && $('#comp_porque').val().trim() != "") {
            $('#comp_quien').css('border-color', 'red');
            emptynoviable += 1;
        }
        if ($("#RazonNoViable").val() == "3" && $('#comp_porque').val().trim() == "" && $('#comp_quien').val().trim() != "") {
            $('#comp_porque').css('border-color', 'red');
            emptynoviable += 1;
        }
        if ($("#RazonNoViable").val() == "4" && ($("#noProducto").val() == "" || $("#noProducto").val() == "0")) {
            // $('#noProducto').css('border-color', 'red');
            $('#no_product').find('.select2-choice').css('border-color', 'red');
            emptynoviable += 1;
        }
        if ($("#RazonNoViable").val() == "4" && $("#noProducto").val() == "4" && $("#otroProducto").val() == "") {
            $('#otroProducto').css('border-color', 'red');
            emptynoviable += 1;
        }
        if ($("#RazonNoViable").val() == "7" && ($("#noInteresado").val() == "" || $("#noInteresado").val() == "0")) {
            // $('#noInteresado').css('border-color', 'red');
            $('#no_interesado').find('.select2-choice').css('border-color', 'red');
            emptynoviable += 1;
        }
        if (emptynoviable > 0) {
            app.alert.show("Falta-campos-no-viable", {
                level: "error",
                title: 'Debe seleccionar los campos faltantes de No viable.',
                autoClose: false
            });
        }

        if (contextIdCuentas != "" && emptynoviable == 0) {

            app.alert.show('no-viable-modal', {
                level: 'process',
                title: 'Cargando...',
            });

            app.api.call('GET', app.api.buildURL('GetProductosCuentas/' + contextIdCuentas), null, {
                success: function (data) {
                    Productos = data;

                    _.each(Productos, function (value, key) {

                        var tipoProducto = Productos[key].tipo_producto;

                        if (tipoProducto == usertipoproducto) {

                            idProdM = Productos[key].id;
                            // console.log("idProdM " + idProdM);

                            var producto = app.data.createBean('uni_Productos', { id: idProdM });
                            producto.fetch({
                                success: _.bind(function (model) {

                                    app.alert.dismiss('no-viable-modal');

                                    app.alert.show('no-viable-producto', {
                                        level: 'success',
                                        messages: 'Se establecio el producto como No Viable!',
                                        autoClose: true
                                    });

                                    model.set('no_viable', true); //CHECK NO VIABLE
                                    model.set('status_management_c', '3'); //ESTATUS PRODUCTO CANCELADO
                                    model.set('no_viable_razon', KeyRazonNV); //RAZON NO VIABLE
                                    model.set('no_viable_razon_fp', keyfueradePerfil); //FUERA DE PERFIL
                                    model.set('no_viable_razon_cf', keycondFinancieras); //CONDICIONES FINANCIERAS
                                    model.set('no_viable_quien', txtcomp_quien); //YA ESTA CON LA COMPETENCIA - ¿QUIEN? TEXTO
                                    model.set('no_viable_porque', txtcomp_porque); //YA ESTA CON LA COMPETENCIA -¿POR QUE? TEXTO
                                    model.set('no_viable_producto', keynoProducto); //NO TENEMOS EL PRODUCTO - ¿QUE PRODUCTO?
                                    model.set('no_viable_otro_c', txtotroProducto); //NO TENEMOS EL PRODUCTO - ¿QUE PRODUCTO? TEXTO
                                    model.set('no_viable_razon_ni', keynoInteresado); //NO SE ENCUENTRA INTERESADO
                                    model.save();
                                    location.reload(); //refresca la página

                                }, self_prodnv)
                            });
                        }
                    });
                },
                error: function (e) {
                    throw e;
                }
            });
            self_prodnv.closeModal();
        }
    },

    closeModal: function () {
        var modal = $('#ModalNoViableCuentas');
        if (modal) {
            modal.hide();
            modal.remove();
        }
        $('.modal').modal('hide');
        $('.modal').remove();
        $('.modal-backdrop').remove();
    },
})
