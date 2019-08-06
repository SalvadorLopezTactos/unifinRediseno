/**
 * Created by Tactos - 08/12/2017.
 **/

({
  //Definición de eventos
  events: {
      //Despliegue de detalle
      'click .openModalAnexos': 'getAnexos',
      'click .openModalCesiones': 'getCesiones',
      'click .openModalContratos': 'getContratos',

      //Cierre de detalle
      'click .closeModalAnexos': 'closeModal',

      //Ordenamiento
      // Anexos
      'click #orderByAnexo': 'orderAnexo',
      'click #orderByAnexoContrata': 'orderAnexoContratacion',
      'click #orderByAnexoTermino': 'orderAnexoTerminacion',
      //Contratos
      'click #orderByContrato': 'orderContrato',
      'click #orderByContratoContrata': 'orderContratoContratacion',
      'click #orderByContratoTermino': 'orderContratoTerminacion',
      //Cesiones
      'click #orderByCesion': 'orderCesion',
      'click #orderByCesionVencimiento': 'orderCesionVencimiento',
      'click .btn-Guardar': 'Save_comentario',
      'click #btn-Descargar':'descargapdf',

  },

  //Inicia
  initialize: function(options) {
    this._super('initialize', [options]);

    //if(typeof v360 == 'undefined'){
    v360 = this;
    // }else{
    //   if (typeof v360.ResumenCliente == 'undefined') {
    //     v360 = this;
    //   }else{
    //     _.extend(this, v360.ResumenCliente);
    //     v360.render();
    //   }
    // }

    //Define variables de ordenamiento
    this.sortAnexo = "ASC";
    this.sortAnexoContratacion = "ASC";
    this.sortAnexoTerminacion = "ASC";

    this.model.on('sync', this.loadData, this);
  },

  loadData: function(options){
    //Recupera id de cliente
    var id = v360.model.id;

    if (id!= '' && id != undefined && id!= null) {
      //Forma url de petición
      var url = app.api.buildURL('ResumenCliente/'+id, null, null, );
      //Ejecuta petición ResumenCliente
      app.api.call('GET', url, {},{
        success: function (data){
          v360.ResumenCliente = data;
          _.extend(this, v360.ResumenCliente);
          v360.render();

        }
      });
    }
  },

  /**
    Funciones de cosulta:
     - Anexos: getAnexos
     - Cesiones: getCesiones
     - Contratos: getContratos

  */
  getAnexos: function () {
    var id = this.model.get('idcliente_c');
    var peticion = "anexos_activos";
    this.getData(peticion, id);
  },

  getCesiones: function () {
    var id = this.model.get('idcliente_c');
    var peticion = "cesiones_activas";
    this.getData(peticion, id);
  },

  getContratos: function () {
    var id = this.model.get('idcliente_c');
    var peticion = "contratos_activos";
    this.getData(peticion, id);
  },


  /**
    Funciones de despliegue:
     - getData: consume servicio para obtención de información y despliegue de resultado
     - closeModal: Cierra modal con detalle
  */
  getData: function (peticion, id, records=null ) {
      console.log("getAnexos - clic");

      //Bloque botones
      $("#openAnexos").removeClass("openModalAnexos");
      $("#openCesiones").removeClass("openModalCesiones");
      $("#openContratos").removeClass("openModalContratos");

      if (!records) {
        //Genera petición
        var Params = {
            'id_cliente': id,
            'tipo_peticion': peticion,
        };
        var url = app.api.buildURL('ConsultaAnexos','', {}, {});

        //
        App.alert.show('openAnexos', {
            level: 'process'
        });

        // $("#myModal1").show();
        // $(".loadingIcon").show();

        //Ejecuta petición
        var self = this;
        app.api.call('create', url, {data: Params},{
          success: function (data){
            //Logs
            console.log('data:');
            console.log(data);

            //var records2 = data;
            _.extend(self, {anexosdata:data});
            self.render();

            //Muestra modal
            App.alert.dismiss('openAnexos');

            // $("#loadingIcon").hide();
            // $(".myModal1").hide();

            var modal = $('#myModal');
            if (modal) {
                modal.show();
            }

            //Bloque botones
            $("#openAnexos").removeClass("openModalAnexos");
            $("#openCesiones").removeClass("openModalCesiones");
            $("#openContratos").removeClass("openModalContratos");

          }
        });
      }else {
        this.anexosdata = records;
        this.render();
        var modal = $('#myModal');
        if (modal) {
            modal.show();
        }
      }
  },

  closeModal: function () {
      console.log("closeModal - clic");
      var modal = $('#myModal');
      if (modal) {
          modal.hide();
      }

      //Habilita botones
      $("#openAnexos").addClass("openModalAnexos");
      $("#openCesiones").addClass("openModalCesiones");
      $("#openContratos").addClass("openModalContratos");

  },


  /**
    Funciones de ordenamiento:
     - Anexos: orderAnexo, orderAnexoContratacion, orderAnexoTerminacion
     - Cesiones: orderCesion, orderCesionVencimiento
     - Contratos: orderContrato, orderContratoContratacion, orderContratoTerminacion

  */
  orderAnexo: function(){
    //Ordenamiento: Anexos por Anexo - Columna 2
    // console.log('--anexosdata--');
    // console.log(this.anexosdata);

    var orderData = this.anexosdata;
    if (this.sortAnexo == "ASC") {
      orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
      if (a.columna2 > b.columna2) {
          return 1;
        }
        if (a.columna2 < b.columna2) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });
      this.sortAnexo = "DESC";
    }else{
      orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
      if (a.columna2 < b.columna2) {
          return 1;
        }
        if (a.columna2 > b.columna2) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });

      this.sortAnexo = "ASC";
    }


    this.getData(null,null,orderData);
  },

  orderAnexoContratacion: function(){
    //Ordenamiento: Anexos por fecha de contratación - Columna 3
    // console.log('--anexosdata--');
    // console.log(this.anexosdata);
    var self = this;
    var orderData = this.anexosdata;
    if (this.sortAnexoContratacion == "ASC") {
      orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
        if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
          return 1;
        }
        if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });
      this.sortAnexoContratacion = "DESC";
    }else{
      orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
        if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
          return 1;
        }
        if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });

      this.sortAnexoContratacion = "ASC";
    }


    this.getData(null,null,orderData);
  },

  orderAnexoTerminacion: function(){
    //Ordenamiento: Anexos por fecha de terminación - Columna 4
    // console.log('--anexosdata--');
    // console.log(this.anexosdata);
    var self = this;
    var orderData = this.anexosdata;
    if (this.sortAnexoTerminacion == "ASC") {
      orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
      if (self.fDate(a.columna4) > self.fDate(b.columna4)) {
          return 1;
        }
        if (self.fDate(a.columna4) < self.fDate(b.columna4)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });
      this.sortAnexoTerminacion = "DESC";
    }else{
      orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
      if (self.fDate(a.columna4) < self.fDate(b.columna4)) {
          return 1;
        }
        if (self.fDate(a.columna4) > self.fDate(b.columna4)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });

      this.sortAnexoTerminacion = "ASC";
    }
    this.getData(null,null,orderData);
  },

  orderContrato: function(){
    //Ordenamiento: Anexos por Anexo - Columna 2
    // console.log('--anexosdata--');
    // console.log(this.anexosdata);

    var orderData = this.anexosdata;
    if (this.sortAnexo == "ASC") {
      orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
      if (a.columna2 > b.columna2) {
          return 1;
        }
        if (a.columna2 < b.columna2) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });
      this.sortAnexo = "DESC";
    }else{
      orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
      if (a.columna2 < b.columna2) {
          return 1;
        }
        if (a.columna2 > b.columna2) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });

      this.sortAnexo = "ASC";
    }


    this.getData(null,null,orderData);
  },

  orderContratoContratacion: function(){
    //Ordenamiento: Anexos por fecha de contratación - Columna 3
    // console.log('--anexosdata--');
    // console.log(this.anexosdata);
    var self = this;
    var orderData = this.anexosdata;
    if (this.sortAnexoContratacion == "ASC") {
      orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
        if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
          return 1;
        }
        if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });
      this.sortAnexoContratacion = "DESC";
    }else{
      orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
        if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
          return 1;
        }
        if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });

      this.sortAnexoContratacion = "ASC";
    }


    this.getData(null,null,orderData);
  },

  orderContratoTerminacion: function(){
    //Ordenamiento: Anexos por fecha de terminación - Columna 4
    // console.log('--anexosdata--');
    // console.log(this.anexosdata);
    var self = this;
    var orderData = this.anexosdata;
    if (this.sortAnexoTerminacion == "ASC") {
      orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
      if (self.fDate(a.columna4) > self.fDate(b.columna4)) {
          return 1;
        }
        if (self.fDate(a.columna4) < self.fDate(b.columna4)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });
      this.sortAnexoTerminacion = "DESC";
    }else{
      orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
      if (self.fDate(a.columna4) < self.fDate(b.columna4)) {
          return 1;
        }
        if (self.fDate(a.columna4) > self.fDate(b.columna4)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });

      this.sortAnexoTerminacion = "ASC";
    }
    this.getData(null,null,orderData);
  },

  Save_comentario: function(){
    var self =this;
        var comentario = this.$('#txtComment').val();
        //alert("comentarios  " +comentario);
        if(comentario!="")
        {
          app.api.call("update", app.api.buildURL("tct02_Resumen/"+this.model.get('id')),{"tct_datos_clave_txa_c":comentario
           }, {
               success: _.bind(function (data) {
                   if (data!=null) {
                       app.alert.show("alerta_datos_clave", {
                           level: "info",
                           title: "Datos creados",
                           autoClose: false
                       });
                   }
               }, this)
           });

        }
  },
  orderCesion: function(){
    //Ordenamiento: Anexos por Anexo - Columna 2
    // console.log('--anexosdata--');
    // console.log(this.anexosdata);

    var orderData = this.anexosdata;
    if (this.sortAnexo == "ASC") {
      orderData.cesiones_activas = this.anexosdata.cesiones_activas.sort(function (a, b) {
      if (a.columna1 > b.columna1) {
          return 1;
        }
        if (a.columna1 < b.columna1) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });
      this.sortAnexo = "DESC";
    }else{
      orderData.cesiones_activas = this.anexosdata.cesiones_activas.sort(function (a, b) {
      if (a.columna1 < b.columna1) {
          return 1;
        }
        if (a.columna1 > b.columna1) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });

      this.sortAnexo = "ASC";
    }


    this.getData(null,null,orderData);
  },

  orderCesionVencimiento: function(){
    //Ordenamiento: Anexos por fecha de contratación - Columna 3
    // console.log('--anexosdata--');
    // console.log(this.anexosdata);
    var self = this;
    var orderData = this.anexosdata;
    if (this.sortAnexoTerminacion == "ASC") {
      orderData.cesiones_activas = this.anexosdata.cesiones_activas.sort(function (a, b) {
        if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
          return 1;
        }
        if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });
      this.sortAnexoTerminacion = "DESC";
    }else{
      orderData.cesiones_activas = this.anexosdata.cesiones_activas.sort(function (a, b) {
        if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
          return 1;
        }
        if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
          return -1;
        }
        // a must be equal to b
        return 0;
      });

      this.sortAnexoTerminacion = "ASC";
    }


    this.getData(null,null,orderData);
  },
  // Función para comparación de fechas
  fDate: function(s) {
    var d = new Date();
    s = s.split('/');
    d.setFullYear(s[2]);
    d.setMonth(s[1]);
    d.setDate(s[0]);
    return d;
  },
    //Funcion para descargar el pdf de la seccion vista 360
    descargapdf: function() {

        var url_list= App.lang.getAppListStrings('noticias_list');
        var url = url_list[1];
        window.open(url, 'Noticias', 'width=450, height=500, top=85, left=50', true);

    },

})
