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
        'click #btn-asigna': 'assignedAccount',
		'click #presolicitud': 'crearSolicitud',
		'click #cancelado': 'cancelarAcc',
		'change #RazonNoViable':'dependenciasNV',
		'keydown .otroProducto': 'PuroTexto', 
        'keydown .comp_porque': 'PuroTexto', 
        'keydown .comp_quien': 'PuroTexto',
    },
	
    context_Call: null,
    initialize: function (options) {
        self_modal_get = this;
		
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:SegundaReunionModal', function () {
				
				var temp_array_get = [];
                var newContext = options.context.get('model');

                // RAZON CUENTA NO VIABLE
                var razon_noviable = app.lang.getAppListStrings('razones_ddw_list');
                var list_html_nv = '';
                _.each(razon_noviable, function (value, key) {
                    list_html_nv += '<option value="' + key + '">' + razon_noviable[key] + '</option>';
                });
                self_modal_get.razon_nv_list = list_html_nv;

                // RAZON FUERA DE PERFIL
                var razon_fueraperfil = app.lang.getAppListStrings('fuera_de_perfil_ddw_list');
                var list_html_fp = '';
                _.each(razon_fueraperfil, function (value, key) {
                    list_html_fp += '<option value="' + key + '">' + razon_fueraperfil[key] + '</option>';
                });
                self_modal_get.fuera_perfil_list = list_html_fp;

                //CONDICIONES FINANCIERAS
                var condiciones_financieras = app.lang.getAppListStrings('razones_cf_list');
                var list_html_cf = '';
                _.each(condiciones_financieras, function (value, key) {
                    list_html_cf += '<option value="' + key + '">' + condiciones_financieras[key] + '</option>';
                });
                self_modal_get.condiciones_financieras_list = list_html_cf;

                //NO TENEMOS EL PRODUCTO QUE REQUIERE
                var no_producto = app.lang.getAppListStrings('no_producto_requiere_list');
                var list_html_npr = '';
                _.each(no_producto, function (value, key) {
                    list_html_npr += '<option value="' + key + '">' + no_producto[key] + '</option>';
                });
                self_modal_get.no_producto_list = list_html_npr;

                //NO SE ENCUENTRA INTERESADO
                var no_interesado = app.lang.getAppListStrings('tct_razon_ni_l_ddw_c_list');
                var list_html_ni = '';
                _.each(no_interesado, function (value, key) {
                    list_html_ni += '<option value="' + key + '">' + no_interesado[key] + '</option>';
                });
                self_modal_get.no_interesado_list = list_html_ni;
               
				/************************************/				
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

        $('#SegundaReunionlModal').modal({backdrop: 'static', keyboard: false});
    },
	
	closeModal: function () {
		var modal = $('#SegundaReunionModal');
		if (modal) {
			modal.hide();
			modal.remove();
		}
		$('.modal').modal('hide');
		$('.modal').remove();
		$('.modal-backdrop').remove();
    },
	
	cancelarAcc: function() {
		this.$('#motivos').show();
	},
	
	crearSolicitud: function() {
		this.$('#motivos').hide();
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
	
	assignedAccount: function () {
		var userprod = (app.user.attributes.productos_c).replace(/\^/g, "");
		var userprodprin = App.user.attributes.tipodeproducto_c;
        smeet = this;
		var keyselect = null;
		var idProdM='';
		var idCuenta = this.model.get('parent_id');
		
		if(this.$('#presolicitud')[0].checked != true && this.$('#cancelado')[0].checked != true){
			app.alert.show("Seleccionar una opción:", {
				level: "error",
				title: "Debe seleccionar una opción.",
				autoClose: false
			});
		}else if(this.$('#presolicitud')[0].checked == true){
			var urla = window.location.href;
			urla = urla.substring(0,urla.indexOf('#'))
			app.alert.show("Creación Solicitud", {
				level: "info",
				title: "Se redirigió a la vista de creación de solicitudes.<br> Cuenta con lo que resta del día en curso para registrar una pre solicitud",
				autoClose: false
			});
			
			app.api.call("read", app.api.buildURL("Accounts/"+idCuenta, null, null, {
                fields: "name",
            }), null, {
                success: _.bind(function (data) {
					var objOpp = {
						action: 'edit',
						copy: true,
						create: true,
						layout: 'create',
						module: 'Opportunities',
						idAccount: idCuenta,
						idNameAccount: data.name
					};
					app.controller.loadView(objOpp);
					// update the browser URL with the proper
					app.router.navigate('#Opportunities/create', {trigger: false});
				}, this)
            });			
			smeet.closeModal();
		}else if(this.$('#cancelado')[0].checked == true){
			var emptynoviable = 0;
        
	        ////////////////////////////VALIDACION DE CAMPOS REQUERIDOS EN EL MODAL//////////////////////////
	        if ($("#RazonNoViable").val() == "" || $("#RazonNoViable").val() == "0") {
	            $('#RazonNoViable').css('border-color', 'red');
	            emptynoviable += 1;
	        }
	        if ($("#RazonNoViable").val() == "1" && ($("#FueradePerfil").val() == "" || $("#FueradePerfil").val() == "0")) {
	            $('#FueradePerfil').css('border-color', 'red');
	            emptynoviable += 1;
	        }
	        if ($("#RazonNoViable").val() == "2" && ($("#condFinancieras").val() == "" || $("#condFinancieras").val() == "0")) {
	             $('#condFinancieras').css('border-color', 'red');
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
	            $('#noProducto').css('border-color', 'red');
	            emptynoviable += 1;
	        }
	        if ($("#RazonNoViable").val() == "4" && $("#noProducto").val() == "4" && $("#otroProducto").val() == "") {
	            $('#otroProducto').css('border-color', 'red');
	            emptynoviable += 1;
	        }
	        if ($("#RazonNoViable").val() == "7" && ($("#noInteresado").val() == "" || $("#noInteresado").val() == "0")) {
	            $('#noInteresado').css('border-color', 'red');
	            emptynoviable += 1;
	        }
	        if (emptynoviable > 0) {
	            app.alert.show("Falta-campos-no-viable", {
	                level: "error",
	                title: 'Debe seleccionar los campos faltantes para cancelación',
	                autoClose: false
	            });
	        }

	        /////////////////////////////VALIDACION DE VALORES QUE NO SE VAYAN VACIOS//////////////////////////////////
	        //Valor de la lista de Razon no viable
	        if ($("#RazonNoViable").val() != "" || $("#RazonNoViable").val() != "0") {
	            var KeyRazonNV = $("#RazonNoViable").val();
	        }
	        //Se obtiene los valores de los campos seleccionados en el modal
	        if ($("#FueradePerfil").val() != "" || $("#FueradePerfil").val() != "0") {
	            var keyfueradePerfil = $("#FueradePerfil").val();
	        }
	        if ($("#condFinancieras").val() != "" || $("#condFinancieras").val() != "0") {
	             var keycondFinancieras = $("#condFinancieras").val();
	        }
	        if ($("#comp_quien").val() != "") {
	            var txtcomp_quien = $("#comp_quien").val();
	        }
	        if ($("#comp_porque").val() != "") {
	            var txtcomp_porque = $("#comp_porque").val();
	        }
	        if ($("#noProducto").val() != "" || $("#noProducto").val() != "0") {
	            var keynoProducto = $("#noProducto").val();
	        }
	        if ($("#otroProducto").val() != "") {
	            var txtotroProducto = $("#otroProducto").val();
	        }
	        if ($("#noInteresado").val() != "" || $("#noInteresado").val() != "0") {
	            var keynoInteresado = $("#noInteresado").val();
	        }
			keyselect = this.$('#RazonNoViable').val();
			if(keyselect != "" && keyselect != null && keyselect != "0" && emptynoviable == 0){

				/*********************************************************/
				app.api.call('GET', app.api.buildURL('GetProductosCuentas/' + idCuenta), null, {
					success: function (data) {
						Productos = data;
						ResumenProductos = [];
						_.each(Productos, function (value, key) {
							var tipoProducto = Productos[key].tipo_producto;
							if(tipoProducto == userprodprin){
								idProdM = Productos[key].id;
								var producto = app.data.createBean('uni_Productos', {id:idProdM});
								producto.fetch({
									success: _.bind(function (model) {
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
										
										app.alert.show('message-id', {
											level: 'success',
											messages: 'Cuenta Cancelada',
											autoClose: true
										});
									}, this)
								});
							}
						});
					},
					error: function (e) {
						throw e;
					}
				});
				smeet.closeModal();
			}
			/*
			else{
				$('#RazonNoViable').css('border-color', 'red');
				app.alert.show("Motivo de Cancelación", {
				level: "error",
				title: "Debe seleccionar motivo de Cancelación de Lead.",
				autoClose: false
			});				
			}
			*/
		}
    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'setAccountModal'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
	
	//Funcion que acepta solo letras (a-z), puntos(.) y comas(,)
    PuroTexto: function (evt) {
        //console.log(evt.keyCode);
        if ($.inArray(evt.keyCode, [9, 16, 17, 110, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192]) < 0) {
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
