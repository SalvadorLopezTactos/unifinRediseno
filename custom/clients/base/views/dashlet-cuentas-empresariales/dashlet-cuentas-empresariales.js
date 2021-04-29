({
    plugins: ['Dashlet'],

    events: {
        'click #btnCompExpActivo': 'CompExpedienteActivo',
    },

    equipos_list:[],
    resumenExpediente:[],
    resumenInteresados:[],
    resumenContactados:[],
    resumenLeads:[],
    dataCuentasExpActivo:[],
    dataCuentasExpAplazado:[],
    dataAccSolicitudesActivo:[],
    dataAccSolicitudesAplazados:[],
    dataAcProspectoContactadoActivo:[],
    dataAcProspectoContactadoAplazado:[],
    dataLeadActivos:[],
    dataLeadAplazado:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        datos = this;
        this.cuentasEmpresariales();
        this.cuentasEmpresarialesDetalle();
    },

    cuentasEmpresariales: function () {
        //DASHLET: CUENTAS EMPRESARIALES Director Equipo
		vari = "1";
        app.api.call('GET', app.api.buildURL('GetResumenProspecto/'+vari), null, {
            success: function (data) {
				console.log(data);
                datos.equipos_list = data.records.equipo;
            },
            error: function (e) {
                console.log(e);
                throw e;
            }
        });
    },

    cuentasEmpresarialesDetalle: function () {
        //DASHLET: CUENTAS EMPRESARIALES Director Equipo
		vari = "1";
        app.api.call('GET', app.api.buildURL('GetDetalleLManagement/'+vari), null, {
            success: function (data) {
				console.log(data);
                //datos.dataCuentasExpActivo = data.records.expediente_activo;
                //datos.dataCuentasExpAplazado = data.records.expediente_activo;
                //datos.dataAccSolicitudesActivo = data.records.expediente_activo;
                //datos.dataAccSolicitudesAplazados = data.records.expediente_activo;
                //datos.dataAcProspectoContactadoActivo = data.records.expediente_activo;
                //datos.dataAcProspectoContactadoAplazado = data.records.expediente_activo;
                //datos.dataLeadActivos = data.records.lead_activo;
                //datos.dataLeadAplazado = data.records.lead_aplazado;
            },
            error: function (e) {
                console.log(e);
                throw e;
            }
        });
    },

    CompExpedienteActivo: function () {

        app.alert.show('go-to-compexp-activo', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para completar el Expediente.',
            autoClose: false
        });
    },

})
