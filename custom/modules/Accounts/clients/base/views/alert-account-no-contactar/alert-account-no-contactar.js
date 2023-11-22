/**
* @class View.Views.Base.QuickCreateView
* @alias SUGAR.App.view.views.BaseQuickCreateView
* @extends View.Views.Base.BaseeditmodalView
*/
({
  extendsFrom: "BaseeditmodalView",
  fallbackFieldTemplate: "edit",
  prod_list: null,

  events: {
    "click #btn-consultar": "consultarEstado",
    "click #btn-cerrar-modal-estado": "cerrarModalEstado",
    "click .closeModalCuentaBloqueada": "closeModalCuentaBloqueada",
  },

  initialize: function (options) {
    self_modal_get = this;
    this.texto_mostrar = options.context.param_equipo;
    this.texto_mostrar = this.texto_mostrar.replaceAll("<br>", ", ");

    //Se quita del string la ùltima coma
    if (this.texto_mostrar.charAt(this.texto_mostrar.length - 2) == ',') {
      this.texto_mostrar = this.texto_mostrar.slice(0, -2);
    }
    app.view.View.prototype.initialize.call(this, options);
    if (this.layout) {
      this.layout.on(
        "app:view:alert-account-no-contactar",
        function () {
          this.render();
          this.$(".modal").modal({
            backdrop: "",
            // keyboard: true,
            // focus: true
          });
          this.$(".modal").modal("show");
          $(".datepicker").css("z-index", "2000px");
          app.$contentEl.attr("aria-hidden", true);
          $(".modal-backdrop").insertAfter($(".modal"));

          /**If any validation error occurs, system will throw error and we need to enable the buttons back*/
          this.context.get("model").on(
            "error:validation",
            function () {
              this.disableButtons(false);
            },
            this
          );
        },
        this
      );
    }
    this.bindDataChange();
  },

  closeModalCuentaBloqueada: function () {
    var modal = $("#alert-account-no-contactar");
    if (modal) {
      modal.hide();
      modal.remove();
    }
    $(".modal").modal("hide");
    $(".modal").remove();
    $(".modal-backdrop").remove();
  },
  /**Custom method to dispose the view*/
  _disposeView: function () {
    /**Find the index of the view in the components list of the layout*/
    var index = _.indexOf(
      this.layout._components,
      _.findWhere(this.layout._components, {
        name: "alert-account-no-contactar",
      })
    );
    if (index > -1) {
      /** dispose the view so that the evnets, context elements etc created by it will be released*/
      this.layout._components[index].dispose();
      /**remove the view from the components list**/
      this.layout._components.splice(index, 1);
    }
  },

  consultarEstado: function (e) {
    app.alert.show("uni2-disp-estado", {
      level: "process",
      closeable: false,
      messages: app.lang.get("LBL_LOADING"),
    });
    var id_cuenta = this.model.get("id");
    app.api.call(
      "read",
      app.api.buildURL("Accounts/" + id_cuenta, null, null, {}),
      null,
      {
        success: _.bind(function (account) {
          if (account) {
            app.api.call(
              "read",
              app.api.buildURL("tct02_Resumen/" + id_cuenta, null, null, {}),
              null,
              {
                success: _.bind(function (data) {
                  if (this.disposed) return;
                  //Declara objeto para control de estado de bloqueo
                  this.registroBloqueo = [];
                  var detalleBloqueo = {
                    estado: "Sin bloqueo",
                    condicion: "",
                    razon: "",
                    motivo: "",
                    detalle: "",
                    responsableIngesta: "",
                    responsableValidacion: "",
                  };
                  this.registroBloqueo["cartera"] =
                    App.utils.deepCopy(detalleBloqueo);
                  this.registroBloqueo["credito"] =
                    App.utils.deepCopy(detalleBloqueo);
                  this.registroBloqueo["cumplimiento"] =
                    App.utils.deepCopy(detalleBloqueo);

                  if (data) {
                    //Validaciones para estado
                    if (
                      account.tct_no_contactar_chk_c &&
                      !data.bloqueo_cartera_c
                    )
                      this.registroBloqueo.cartera.estado =
                        "Pendiente de aprobar bloqueo";
                    if (data.bloqueo_credito_c && !data.bloqueo2_c)
                      this.registroBloqueo.credito.estado =
                        "Pendiente de aprobar bloqueo";
                    if (data.bloqueo_cumple_c && !data.bloqueo3_c)
                      this.registroBloqueo.cumplimiento.estado =
                        "Pendiente de aprobar bloqueo";

                    if (
                      account.tct_no_contactar_chk_c &&
                      data.bloqueo_cartera_c
                    )
                      this.registroBloqueo.cartera.estado = "Cuenta bloqueada";
                    if (data.bloqueo_credito_c && data.bloqueo2_c)
                      this.registroBloqueo.credito.estado = "Cuenta bloqueada";
                    if (data.bloqueo_cumple_c && data.bloqueo3_c)
                      this.registroBloqueo.cumplimiento.estado =
                        "Cuenta bloqueada";

                    if (
                      !account.tct_no_contactar_chk_c &&
                      data.bloqueo_cartera_c
                    )
                      this.registroBloqueo.cartera.estado =
                        "Pendiente de aprobar desbloqueo";
                    if (!data.bloqueo_credito_c && data.bloqueo2_c)
                      this.registroBloqueo.credito.estado =
                        "Pendiente de aprobar desbloqueo";
                    if (!data.bloqueo_cumple_c && data.bloqueo3_c)
                      this.registroBloqueo.cumplimiento.estado =
                        "Pendiente de aprobar desbloqueo";
                    //Obtención de variables con detalle
                    this.registroBloqueo["nombreCuenta"] = account.name;
                    //Cartera
                    this.registroBloqueo.cartera.condicion =
                      data.condicion_cliente_c;
                    this.registroBloqueo.cartera.razon = data.razon_c;
                    this.registroBloqueo.cartera.motivo = data.motivo_c;
                    this.registroBloqueo.cartera.detalle = data.detalle_c;
                    this.registroBloqueo.cartera.responsableIngesta =
                      data.ingesta_c;
                    this.registroBloqueo.cartera.responsableValidacion =
                      data.validacion_c;
                    //Crédito
                    this.registroBloqueo.credito.condicion = data.condicion2_c;
                    this.registroBloqueo.credito.razon = data.razon2_c;
                    this.registroBloqueo.credito.motivo = data.motivo2_c;
                    this.registroBloqueo.credito.detalle = data.detalle2_c;
                    this.registroBloqueo.credito.responsableIngesta =
                      data.ingesta2_c;
                    this.registroBloqueo.credito.responsableValidacion =
                      data.validacion2_c;
                    //Cumplimiento
                    this.registroBloqueo.cumplimiento.condicion =
                      data.condicion3_c;
                    this.registroBloqueo.cumplimiento.razon = data.razon3_c;
                    this.registroBloqueo.cumplimiento.motivo = data.motivo3_c;
                    this.registroBloqueo.cumplimiento.detalle = data.detalle3_c;
                    this.registroBloqueo.cumplimiento.responsableIngesta =
                      data.ingesta3_c;
                    this.registroBloqueo.cumplimiento.responsableValidacion =
                      data.validacion3_c;
                  }
                  this.render();
                  app.alert.dismiss("uni2-disp-estado");
                  var modal = $("#consultarEstadoModal");
                  modal.show();
                }, this),
              }
            );
          }
        }, this),
      }
    );
  },

  cerrarModalEstado: function () {
    var modal = $("#consultarEstadoModal");
    if (modal) {
      modal.hide();
      modal.remove();
    }
    $(".modal").modal("hide");
    $(".modal").remove();
    $(".modal-backdrop").remove();
  },
});
            
