/**
 * Created by salvadorlopez salvador.lopez@tactos.com.mx
 */
({
  events: {
    "keyup #filtroBuro": "buscarClientesBuro",
    "click #btnBuscarClientesSinBuro": "buscarClientesSinBuro",
    "click #btnBorraBuroCredito": "borraClienteBuroCredito",
    "click #btnAgregarBuroCredito": "agregarClienteBuroCredito",
  },

  initialize: function (options) {
    this._super("initialize", [options]);

    var mostrar = this.validaPermiso();
    this.loadViewBuro = false;

    if (!mostrar) {
      var alertOptionsBuro = {
        title: "Información",
        messages: "No cuentas con el privilegio para accesar a esta vista",
        level: "warning",
      };
      app.alert.show("sinPrivilegioBuro", alertOptionsBuro);
      var route = app.router.buildRoute(this.module, null, "");
      app.router.navigate(route, { trigger: true });
    }

    this.cuentasBuro = [];
    this.cuentasSinBuro = [];

    this.getCuentasBuro();
  },

  validaPermiso: function () {
    var privilegio_buro = App.user.get("seguimiento_bc_c");

    var permiso = false;

    if (privilegio_buro == 1) {
      permiso = true;
    }

    return permiso;
  },

  /*
  Al cargar la vista, se obtienen las Cuentas que han sido marcadas para seguimiento de Buró de Crédito
  */
  getCuentasBuro: function () {
    self = this;
    var url = app.api.buildURL("ClientesBuroCredito", null, null, {});

    app.alert.show("getCuentasBuroMsg", {
      level: "process",
      title: "Cargando información", //change title to modify display from 'Loading...'
    });

    app.api.call("read", url, null, {
      success: _.bind(function (data) {
        app.alert.dismiss("getCuentasBuroMsg");

        if (data.length > 0) {
          self.cuentasBuro = data;
          self.tempCuentasBuro = data;
        } else {
          self.cuentasBuro = [];
          self.tempCuentasBuro = [];
        }

        self.render();
      }, this),
    });
  },

  buscarClientesBuro: function () {
    this.tempCuentasBuro = this.cuentasBuro.filter((obj) => {
      if (
        obj.name.toUpperCase().includes($("#filtroBuro").val().toUpperCase())
      ) {
        return true;
      } else {
        return false;
      }
    });

    var nameEscrito = $("#filtroBuro").val();
    this.render();
    $("#filtroBuro").val(nameEscrito);
    $("#filtroBuro").focus();
  },

  buscarClientesSinBuro: function () {
    var filtroName = $("#filtroSinBuro").val();

    if (filtroName == "") {
      var alertOptions = {
        title: "Error",
        messages: "Favor de agregar un nombre para búsqueda",
        level: "error",
      };
      app.alert.show("validation", alertOptions);
      return;
    }

    var url = app.api.buildURL(
      "ClientesSinBuroCredito?q=" + filtroName,
      null,
      null,
      {}
    );

    $("#processingSinBuro").show();
    $("#btnBuscarClientesSinBuro").attr("disabled", "disabled");

    app.api.call("read", url, null, {
      success: _.bind(function (data) {
        $("#processingSinBuro").hide();
        $("#btnBuscarClientesSinBuro").removeAttr("disabled");

        if (data.length > 0) {
          self.cuentasSinBuro = data;
        } else {
          app.alert.show("sinRegistrosParaBuro", {
            level: "info",
            messages: "No se encontraron registros con el nombre especificado",
            autoClose: true,
          });
        }

        self.render();
        console.log("el dataa");
      }, this),
    });
  },

  borraClienteBuroCredito: function (e) {
    self = this;
    var idBorrar = $(e.currentTarget).attr("val-id");
    var name = $(e.currentTarget).attr("val-name");

    app.alert.show("confirmBorrarBuro", {
      level: "confirmation",
      messages:
        "Se procederá a eliminar del seguimiento al cliente:<br>" +
        name +
        "<br>¿Estás seguro?",
      autoClose: false,
      onConfirm: function () {
        console.log("SE ELIMINARÁ EL ID: " + idBorrar);
        app.alert.show("deleteBuro", {
          level: "process",
          title: "Eliminando del seguimiento.",
          autoClose: false,
        });
        var urlBorrar = app.api.buildURL("BorrarClienteBuroCredito","",{},{});

        app.api.call("create", urlBorrar, { idCliente: idBorrar },{
            success: _.bind(function (data) {
              app.alert.dismiss("deleteBuro");
              app.alert.show("successDelete", {
                level: "success",
                title: data.msg,
                autoClose: true,
              });

              //Una vez eliminado de la lista, se procede a cargar de nuevo para actualizar la lista
              self.getCuentasBuro();
            }, this),
          }
        );
      },
      onCancel: function () {},
    });
  },

  agregarClienteBuroCredito: function (e){
    self = this;
    var idBorrar = $(e.currentTarget).attr("val-id");
    var name = $(e.currentTarget).attr("val-name");

    app.alert.show("confirmAgregarBuro", {
      level: "confirmation",
      messages:
        "Se procederá a establecer seguimiento al cliente:<br>" +
        name +
        "<br>¿Estás seguro?",
      autoClose: false,
      onConfirm: function () {
        
        app.alert.show("agregaBuro", {
          level: "process",
          title: "Agregando a Seguimiento de Buró de Crédito",
          autoClose: false,
        });
        var urlAgregar = app.api.buildURL("AgregarClienteBuroCredito","",{},{});
        app.api.call("create",urlAgregar,{ idCliente: idBorrar },{
            success: _.bind(function (data) {
              app.alert.dismiss("agregaBuro");
              app.alert.show("successAgrega", {
                level: "success",
                title: data.msg,
                autoClose: true,
              });

              //Una vez eliminado de la lista, se procede a cargar de nuevo para actualizar la lista
              self.cuentasSinBuro = [];
              self.getCuentasBuro();
            }, this),
          }
        );
      },
      onCancel: function () {},
    });

  },

  _render: function () {
    this._super("_render");
  },
});
