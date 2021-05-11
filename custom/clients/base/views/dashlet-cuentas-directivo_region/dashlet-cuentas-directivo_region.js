({
    plugins: ['Dashlet'],

    events: {
        'click #btnactualiza': 'recargaData',
        'change #equipos': 'reloadData',
    },

    equipos_list:[],
    var_equipo_list:[],
    totales:[],
    totalExpediente:[],
    totalInteresado:[],
    totalContactado:[],
    totalLead:[],
    resumenExpedientes:[],
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
    dataCuentasExpActivoCompleto:[],
    dataCuentasExpAplazadoCompleto:[],
    dataAccSolicitudesActivoCompleto:[],
    dataAccSolicitudesAplazadosCompleto:[],
    dataAcProspectoContactadoActivoCompleto:[],
    dataAcProspectoContactadoAplazadoCompleto:[],
    dataLeadActivosCompleto:[],
    dataLeadAplazadoCompleto:[],
    varselect:"",
    indexselect:"",
    objprincipal:null,
    objdetalle:null,

    initialize: function (options) {
        this._super("initialize", [options]);
        datos = this;
        
        this.model.on('sync', this.time_recargadatos, this);

        this.restartTotales();
        this.cargaInicial();
        //this.cuentasEmpresariales();
        //this.cuentasEmpresarialesDetalle();
    },

    cargaInicial: function () {
        vari = "2";
       
        /*
        //data1 = '{"equipo":["7"],"region":["METRO 2","METROPOLITANA"],"expediente":[{"region":"METRO 2","equipo":"7","conteo":"82","EstatusProducto":"","inactivo":"0","semaforo":"0"}],"interesado":[],"contactado":[{"region":"METRO 2","equipo":"7","conteo":"34","EstatusProducto":null,"inactivo":"0","semaforo":"1"}],"lead":[]}';
        data1 = '{"equipo":{"0":"1","37":"6","54":"7"},"region":{"0":"METRO 1","6":"METROPOLITANA","20":"EXPERIENCE","37":"METRO 2","41":"METRO"},"expediente":[{"region":"METRO 1","equipos":[{"equipo":"1","datos":[{"inactivo":"0","actinct":[{"conteo":"236","EstatusProducto":null,"semaforo":"0"}]}]}]},{"region":"EXPERIENCE","equipos":[{"equipo":"1","datos":[{"inactivo":"0","actinct":[{"conteo":"60","EstatusProducto":null,"semaforo":"0"}]},{"inactivo":"1","actinct":[{"conteo":"2","EstatusProducto":"2","semaforo":"0"}]}]}]}],"contactado":[{"region":"EXPERIENCE","equipos":[{"equipo":"1","datos":[{"inactivo":"0","actinct":[{"conteo":"479","EstatusProducto":null,"semaforo":"1"},{"conteo":"29","EstatusProducto":"1","semaforo":"1"}]},{"inactivo":"1","actinct":[{"conteo":"4","EstatusProducto":"2","semaforo":"1"},{"conteo":"19","EstatusProducto":"3","semaforo":"1"}]}]}]}],"lead":[{"region":"EXPERIENCE","equipos":[{"equipo":"1","datos":[{"inactivo":"0","actinct":[{"conteo":"78","estatus":null,"semaforo":"0"}]},{"inactivo":"1","actinct":[{"conteo":"7","estatus":"2","semaforo":"0"}]}]}]},{"region":"METRO 1","equipos":[{"equipo":"1","datos":[{"inactivo":"0","actinct":[{"conteo":"501","estatus":null,"semaforo":"0"}]}]}]},{"region":"METRO","equipos":[{"equipo":"6","datos":[{"inactivo":"0","actinct":[{"conteo":"113","estatus":null,"semaforo":"0"}]}]}]}]}';
        //data = '{"expediente_activo":{"records":[{"idCuenta":"9d302008-5c57-11eb-a553-00155da0710c","nombreCuenta":"YOUTUBE INC","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"51fa71dc-5c58-11eb-a2d7-00155da0710c","oppNombre":"SOLICITUD 92703 - YOUTUBE INC","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-22 ","Monto":"$ 1000000"},{"idCuenta":"3fe449fc-5f5d-11eb-a62f-00155da0710c","nombreCuenta":"PM LEAD DASHLET MANAGEMENT3","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"b4ab7202-5f6b-11eb-a376-00155da0710c","oppNombre":"SOLICITUD 92709 - PM LEAD DASHLET MANAGEMENT3","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-26 ","Monto":"$ 1000000"},{"idCuenta":"47f8be0a-60ef-11eb-b1da-00155da0710c","nombreCuenta":"ID PROCESO REPETIR","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"224e08a4-6185-11eb-867e-00155da0710c","oppNombre":"SOLICITUD 92729 - ID PROCESO REPETIR","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-28 ","Monto":"$ 1000000"},{"idCuenta":"ca165a70-6255-11eb-b632-00155da0710c","nombreCuenta":"HAPPY PATH PERSONA FISICA METODOLOGIA LEADS","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"6fcd12b0-6256-11eb-a9c6-00155da0710c","oppNombre":"SOLICITUD 92736 - HAPPY PATH PERSONA FISICA METODOLOGIA LEADS","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-29 ","Monto":"$ 1000000"},{"idCuenta":"2b36830e-6574-11eb-a36d-00155da0710c","nombreCuenta":"LEAD DE WENDY AMAIRINI REYES PERALTA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"1fc5b880-67ce-11eb-a65c-00155da0710c","oppNombre":"SOLICITUD 92813 - LEAD DE WENDY AMAIRINI REYES PERALTA","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-02-10 ","Monto":"$ 9999999"}]},"expediente_aplazado":null,"interesado_activo":{"records":[{"idCuenta":"986fe32c-625c-11eb-8ef0-00155da0710c","nombreCuenta":"HAPPYPATHMETODOLOGIA PFAE QA","asesor":"Jeanette Lucelia Orozco Moreno","fecha_asignacion":"2021-01-22 ","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"7940a544-625d-11eb-94e8-00155da0710c","oppNombre":"PRE - SOLICITUD 92737 - HAPPYPATHMETODOLOGIA PFAE QA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","semaforo":"0","Monto":"$ 20000000"},{"idCuenta":"53a57338-6c7a-11eb-84fe-00155da0710c","nombreCuenta":"CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","asesor":"Jeanette Lucelia Orozco Moreno","fecha_asignacion":"2021-01-22 ","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"33d26394-6c7b-11eb-ab98-00155da0710c","oppNombre":"PRE - SOLICITUD 92852 - CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","fecha_asignacion":"2021-01-22 ","semaforo":"0","Monto":"$ 1000000"}]},"interesado_aplazado":{"records":[{"idCuenta":"59f760fe-5747-11eb-94eb-00155da0710c","nombreCuenta":"WHIRLPOOL","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"e7c3b982-60b6-11eb-a8ab-00155da0710c","oppNombre":"PRE - SOLICITUD 92718 - WHIRLPOOL","oppEtapa":"SOLICITUD INICIAL CANCELADA","EstatusProducto":"2","semaforo":"0","Monto":"$ 9000000"}]},"lead_activo":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"19a9e706-5abc-11eb-9a7b-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 15","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1af1e6ea-5abc-11eb-b797-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 19","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b4d4f62-5abc-11eb-ab6e-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 20","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b9fc4f4-5abc-11eb-baab-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 21","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"}]},"lead_aplazado":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"1eb669e8-5041-11eb-8d06-00155da0710c","nombre":"Dashlet PFAE Dashlet Uno","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-06 17:03:36","semaforo":"0"},{"idLead":"458e855e-4ec6-11eb-bb17-00155da0710c","nombre":"CASO DE PRUEBA CERO CUARENTA PFAE ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2021-01-04 19:51:44","semaforo":"0"},{"idLead":"5400374a-4aca-11eb-9243-00155da0710c","nombre":"PRUEBA NUEVA METODOLOGIA PF ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:10:41","semaforo":"0"},{"idLead":"59802aea-4eee-11eb-90f3-00155da0710c","nombre":"Lead PM 1","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-05 00:38:37","semaforo":"0"}]}}';
        data2 = '{"expediente_activo":{"records":[{"idCuenta":"9d302008-5c57-11eb-a553-00155da0710c","nombreCuenta":"YOUTUBE INC","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","region":"METRO 1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"51fa71dc-5c58-11eb-a2d7-00155da0710c","oppNombre":"SOLICITUD 92703 - YOUTUBE INC","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-22 ","Monto":"$ 1000000"},{"idCuenta":"3fe449fc-5f5d-11eb-a62f-00155da0710c","nombreCuenta":"PM LEAD DASHLET MANAGEMENT3","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","region":"METRO 1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"b4ab7202-5f6b-11eb-a376-00155da0710c","oppNombre":"SOLICITUD 92709 - PM LEAD DASHLET MANAGEMENT3","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-26 ","Monto":"$ 1000000"},{"idCuenta":"47f8be0a-60ef-11eb-b1da-00155da0710c","nombreCuenta":"ID PROCESO REPETIR","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","region":"METRO 1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"224e08a4-6185-11eb-867e-00155da0710c","oppNombre":"SOLICITUD 92729 - ID PROCESO REPETIR","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-28 ","Monto":"$ 1000000"},{"idCuenta":"ca165a70-6255-11eb-b632-00155da0710c","nombreCuenta":"HAPPY PATH PERSONA FISICA METODOLOGIA LEADS","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","region":"EXPERIENCE","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"6fcd12b0-6256-11eb-a9c6-00155da0710c","oppNombre":"SOLICITUD 92736 - HAPPY PATH PERSONA FISICA METODOLOGIA LEADS","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-29 ","Monto":"$ 1000000"},{"idCuenta":"2b36830e-6574-11eb-a36d-00155da0710c","nombreCuenta":"LEAD DE WENDY AMAIRINI REYES PERALTA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","region":"EXPERIENCE","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"1fc5b880-67ce-11eb-a65c-00155da0710c","oppNombre":"SOLICITUD 92813 - LEAD DE WENDY AMAIRINI REYES PERALTA","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-02-10 ","Monto":"$ 9999999"}]},"expediente_aplazado":null,"interesado_activo":{"records":[{"idCuenta":"986fe32c-625c-11eb-8ef0-00155da0710c","nombreCuenta":"HAPPYPATHMETODOLOGIA PFAE QA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","region":"EXPERIENCE","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"7940a544-625d-11eb-94e8-00155da0710c","oppNombre":"PRE - SOLICITUD 92737 - HAPPYPATHMETODOLOGIA PFAE QA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-29 18:11:56","Monto":"$ 20000000"},{"idCuenta":"53a57338-6c7a-11eb-84fe-00155da0710c","nombreCuenta":"CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","region":"METRO 1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"33d26394-6c7b-11eb-ab98-00155da0710c","oppNombre":"PRE - SOLICITUD 92852 - CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-02-11 15:09:56","Monto":"$ 1000000"}]},"interesado_aplazado":{"records":[{"idCuenta":"59f760fe-5747-11eb-94eb-00155da0710c","nombreCuenta":"WHIRLPOOL","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"e7c3b982-60b6-11eb-a8ab-00155da0710c","oppNombre":"PRE - SOLICITUD 92718 - WHIRLPOOL","oppEtapa":"SOLICITUD INICIAL CANCELADA","EstatusProducto":"2","semaforo":"0","fecha_asignacion":"2021-04-08 21:01:11","Monto":"$ 9000000"}]},"lead_activo":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"19a9e706-5abc-11eb-9a7b-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 15","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1af1e6ea-5abc-11eb-b797-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 19","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b4d4f62-5abc-11eb-ab6e-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 20","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b9fc4f4-5abc-11eb-baab-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 21","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"}]},"lead_aplazado":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"1eb669e8-5041-11eb-8d06-00155da0710c","nombre":"Dashlet PFAE Dashlet Uno","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-06 17:03:36","semaforo":"0"},{"idLead":"458e855e-4ec6-11eb-bb17-00155da0710c","nombre":"CASO DE PRUEBA CERO CUARENTA PFAE ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2021-01-04 19:51:44","semaforo":"0"},{"idLead":"5400374a-4aca-11eb-9243-00155da0710c","nombre":"PRUEBA NUEVA METODOLOGIA PF ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:10:41","semaforo":"0"},{"idLead":"59802aea-4eee-11eb-90f3-00155da0710c","nombre":"Lead PM 1","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-05 00:38:37","semaforo":"0"}]}}';
        datos.objprincipal = JSON.parse(data1);
        datos.objdetalle = JSON.parse(data2);
        var list_html_mc = '';
        datos.var_equipo_list = datos.objprincipal.region;

        _.each(datos.objprincipal.region, function (value, key) {
            list_html_mc += '<option value="' + key + '">' + datos.objprincipal.region[key] + '</option>';
        });
        datos.equipos_list = list_html_mc;
        datos.cuentasEmpresariales();
        datos.cuentasEmpresarialesDetalle();
        datos.render();
        app.alert.dismiss('alert-actualiza');
        datos.$('[data-name="btnactualiza"]').attr('style', 'pointer-events:none;');
		*/
        
        app.api.call('GET', app.api.buildURL('GetResumenProspecto/'+vari), null, {
            success: function (data) {
				console.log(data);
                datos.objprincipal = data;
                
                if(datos.objprincipal != undefined && datos.objprincipal.equipo != null){
                    datos.var_equipo_list = datos.objprincipal.equipo;
                    var list_html_mc = '';
                    datos.var_equipo_list = datos.objprincipal.region;
            
                    _.each(datos.objprincipal.region, function (value, key) {
                        list_html_mc += '<option value="' + key + '">' + datos.objprincipal.region[key] + '</option>';
                    });
                    datos.equipos_list = list_html_mc;
                    datos.cuentasEmpresariales();
                    datos.render();
                }
            },
            error: function (e) {
                console.log(e);
                app.alert.dismiss('alert-actualiza');
                datos.$('[data-name="btnactualiza"]').attr('style', 'pointer-events:none;');
                throw e;
            }
        });
        
        app.api.call('GET', app.api.buildURL('GetDetalleLManagement/'+vari), null, {
            success: function (data) {
				console.log(data);
                datos.objdetalle = data;
                datos.cuentasEmpresarialesDetalle();
                app.alert.dismiss('alert-actualiza');
                datos.$('[data-name="btnactualiza"]').attr('style', 'pointer-events:none;')
                datos.render();
            },
            error: function (e) {
                console.log(e);
                app.alert.dismiss('alert-actualiza');
                datos.$('[data-name="btnactualiza"]').attr('style', 'pointer-events:none;');
                throw e;
            }
        });
		
    },

    cuentasEmpresariales: function () {
        //DASHLET: CUENTAS EMPRESARIALES Director Equipo
		var selecrquipo ="";
        selecrquipo = (datos.varselect == "")? datos.var_equipo_list[0] :datos.varselect ;
        /*if(datos.varselect == ""){
            selecrquipo = datos.var_equipo_list[0];
        }else{ 
            selecrquipo = datos.varselect
        }*/
        if(datos.objprincipal != null){
            if(datos.objprincipal.expediente != null){
                this.sumaTotales(datos.objprincipal.expediente,'expediente',selecrquipo);
            }
            if(datos.objprincipal.interesado != null){
                this.sumaTotales(datos.objprincipal.interesado,'interesado',selecrquipo);
            }
            if(datos.objprincipal.contactado != null){
                this.sumaTotales(datos.objprincipal.contactado,'contactado',selecrquipo);
            }
            if(datos.objprincipal.lead != null){
                this.sumaTotales(datos.objprincipal.lead,'lead',selecrquipo);
            }
            //console.log(datos.resumenExpedientes);
            //datos.render();
        }
    },

    cuentasEmpresarialesDetalle: function () {
        //DASHLET: CUENTAS EMPRESARIALES Director Equipo
        var selecrquipo ="";
        selecrquipo = (datos.varselect == "")? datos.var_equipo_list[0] :datos.varselect ;
        /*if(datos.varselect == ""){
            selecrquipo = datos.var_equipo_list[0];
        }else{ 
            selecrquipo = datos.varselect
        }*/
        if(datos.objdetalle != null){
            datos.dataCuentasExpActivoCompleto = datos.objdetalle.expediente_activo != null ? datos.objdetalle.expediente_activo.records : null;
            datos.dataCuentasExpAplazadoCompleto = datos.objdetalle.expediente_aplazado != null ? datos.objdetalle.expediente_aplazado.records : null;
            datos.dataAccSolicitudesActivoCompleto = datos.objdetalle.interesado_activo != null ? datos.objdetalle.interesado_activo.records: null;
            datos.dataAccSolicitudesAplazadosCompleto = datos.objdetalle.interesado_aplazado != null ? datos.objdetalle.interesado_aplazado.records: null;
            datos.dataAcProspectoContactadoActivoCompleto = datos.objdetalle.contactado_activo != null ? datos.objdetalle.contactado_activo.records : null;
            datos.dataAcProspectoContactadoAplazadoCompleto = datos.objdetalle.contactado_aplazado != null ? datos.objdetalle.contactado_aplazado.records : null;
            datos.dataLeadActivosCompleto = datos.objdetalle.lead_activo != null ? datos.objdetalle.lead_activo.records : null;
            datos.dataLeadAplazadoCompleto = datos.objdetalle.lead_aplazado != null ? datos.objdetalle.lead_aplazado.records : null;

            if(datos.dataCuentasExpActivoCompleto != null){
                datos.dataCuentasExpActivo = datos.dataCuentasExpActivoCompleto.filter(function(d1) {
                    return d1.region == selecrquipo;
                });
            }
            if(datos.dataCuentasExpAplazadoCompleto != null){
                datos.dataCuentasExpAplazado = datos.dataCuentasExpAplazadoCompleto.filter(function(d1) {
                    return d1.region == selecrquipo;
                });
            }
            if(datos.dataAccSolicitudesActivoCompleto != null){
                datos.dataAccSolicitudesActivo =  datos.dataAccSolicitudesActivoCompleto.filter(function(d1) {
                    return d1.region == selecrquipo;
                });
            }
            if(datos.dataAccSolicitudesAplazadosCompleto != null){
                datos.dataAccSolicitudesAplazados =  datos.dataAccSolicitudesAplazadosCompleto.filter(function(d1) {
                    return d1.region == selecrquipo;
                });
            }
            if(datos.dataAcProspectoContactadoActivoCompleto != null){
                datos.dataAcProspectoContactadoActivo =  datos.dataAcProspectoContactadoActivoCompleto.filter(function(d1) {
                    return d1.region == selecrquipo;
                });
            }
            if(datos.dataAcProspectoContactadoAplazadoCompleto != null){
                datos.dataAcProspectoContactadoAplazado =  datos.dataAcProspectoContactadoAplazadoCompleto.filter(function(d1) {
                    return d1.region == selecrquipo;
                });
            }
            if(datos.dataLeadActivosCompleto != null){
                datos.dataLeadActivos =  datos.dataLeadActivosCompleto.filter(function(d1) {
                    return d1.region == selecrquipo;
                });
            }
            if(datos.dataLeadAplazadoCompleto != null){
                datos.dataLeadAplazado =  datos.dataLeadAplazadoCompleto.filter(function(d1) {
                    return d1.region == selecrquipo;
                });
            }
            //datos.render();
        }
        
    },

    sumaTotales: function (arreglo , tipo , selecrgion) {
        var i,j,k =0;
        var auxequipo = null;
        var auxarr = [];
        var auxarr2 = [];
        var salidaarr = [];
        //var eid = document.getElementById("equipos");
        //var selecrquipo = eid.options[eid.selectedIndex].text;
        
        for (i = 0; i < arreglo.length; i++) {
            if(arreglo[i].region == selecrgion){
                auxequipo = arreglo[i].equipos;
                for (j = 0; j < auxequipo.length; j++) {
                    salidaarr ['equipo'] = 'Equipo: ' + auxequipo[j].equipo;
                    salidaarr['total1'] = 0;
                    salidaarr['total2'] = 0;
                    auxarr = auxequipo[j].datos;
                    for (k = 0; k < auxarr.length; k++) {
                        if(auxarr[k].inactivo == 0){
                            auxarr2 = auxarr[k].actinct;
                            for (l = 0; l < auxarr2.length; l++) {
                                if(auxarr2[l].semaforo == 0){
                                    salidaarr['tiempo'] = (salidaarr['tiempo'] == undefined ? 0 : parseInt(salidaarr['tiempo'])) + parseInt(auxarr2[l].conteo);
                                    datos.totales['totalTiempo'] = datos.totales['totalTiempo'] + salidaarr['tiempo'] ;
                                    if(tipo == 'expediente'){
                                        datos.totalExpediente['Ttiempo'] = datos.totalExpediente['Ttiempo'] + salidaarr['tiempo'] ;
                                    }
                                    if(tipo == 'interesado'){
                                        datos.totalInteresado['Ttiempo'] = datos.totalInteresado['Ttiempo'] + salidaarr['tiempo'] ;
                                    }
                                    if(tipo == 'contactado'){
                                        datos.totalContactado['Ttiempo'] = datos.totalContactado['Ttiempo'] + salidaarr['tiempo'] ;
                                    }
                                    if(tipo == 'lead'){
                                        datos.totalLead['Ttiempo'] = datos.totalLead['Ttiempo'] + salidaarr['tiempo'] ;
                                    }
                                    
                                }else{
                                    salidaarr['tiempo'] = (salidaarr['tiempo'] == undefined ? 0 : parseInt(salidaarr['tiempo'])) + 0;
                                }
                                if(auxarr[l].semaforo == 1){
                                    salidaarr['atrasado'] = (salidaarr['atrasado'] == undefined ? 0 : parseInt(salidaarr['atrasado'])) + parseInt(auxarr2[l].conteo);
                                    datos.totales['totalAtrasado'] = datos.totales['totalAtrasado'] + salidaarr['atrasado'] ;
                                    
                                    if(tipo == 'expediente'){
                                        datos.totalExpediente['TAtrasado'] = datos.totalExpediente['TAtrasado'] + salidaarr['atrasado'] ;
                                    }
                                    if(tipo == 'interesado'){
                                        datos.totalInteresado['TAtrasado'] = datos.totalInteresado['TAtrasado'] + salidaarr['atrasado'] ;
                                    }
                                    if(tipo == 'contactado'){
                                        datos.totalContactado['TAtrasado'] = datos.totalContactado['TAtrasado'] + salidaarr['atrasado'] ;
                                    }
                                    if(tipo == 'lead'){
                                        datos.totalLead['TAtrasado'] = datos.totalLead['TAtrasado'] + salidaarr['atrasado'] ;
                                    }
                                }else{
                                    salidaarr['atrasado'] = (salidaarr['atrasado'] == undefined ? 0 : parseInt(salidaarr['atrasado'])) + 0;
                                }
                                salidaarr['total1'] = salidaarr['total1'] + salidaarr['tiempo'] + salidaarr['atrasado'];
                                datos.totales['totalActivo'] = datos.totales['totalActivo'] + salidaarr['total1'] ;
                                
                                if(tipo == 'expediente'){
                                    datos.totalExpediente['TActivo'] = datos.totalExpediente['TActivo'] + salidaarr['total1'] ;
                                }
                                if(tipo == 'interesado'){
                                    datos.totalInteresado['TActivo'] = datos.totalInteresado['TActivo'] + salidaarr['total1'] ;
                                }
                                if(tipo == 'contactado'){
                                    datos.totalContactado['TActivo'] = datos.totalContactado['TActivo'] + salidaarr['total1'] ;
                                }
                                if(tipo == 'lead'){
                                    datos.totalLead['TActivo'] = datos.totalLead['TActivo'] + salidaarr['total1'] ;
                                }
                            }
                        }else{
                            salidaarr['tiempo'] = (salidaarr['tiempo'] == undefined ? 0 : parseInt(salidaarr['tiempo'])) + 0;
                            salidaarr['atrasado'] = (salidaarr['atrasado'] == undefined ? 0 : parseInt(salidaarr['atrasado'])) + 0;
                        }
                        //salidaarr['total1'] = salidaarr['total1'] + salidaarr['tiempo'] + salidaarr['atrasado'];

                        if(auxarr[k].inactivo == 1){
                            auxarr2 = auxarr[k].actinct;
                            for (l = 0; l < auxarr2.length; l++) {
                                if(auxarr2[l].estatus == 2){
                                    salidaarr['aplazados'] = (salidaarr['aplazados'] == undefined ? 0 : salidaarr['aplazados']) + parseInt(auxarr2[l].conteo);
                                    datos.totales['totalAplazado'] = datos.totales['totalAplazado'] + salidaarr['aplazados'] ;
                                    if(tipo == 'expediente'){
                                        datos.totalExpediente['TAplazado'] = datos.totalExpediente['TAplazado'] + salidaarr['aplazados'] ;
                                    }
                                    if(tipo == 'interesado'){
                                        datos.totalInteresado['TAplazado'] = datos.totalInteresado['TAplazado'] + salidaarr['aplazados'] ;
                                    }
                                    if(tipo == 'contactado'){
                                        datos.totalContactado['TAplazado'] = datos.totalContactado['TAplazado'] + salidaarr['aplazados'] ;
                                    }
                                    if(tipo == 'lead'){
                                        datos.totalLead['TAplazado'] = datos.totalLead['TAplazado'] + salidaarr['aplazados'] ;
                                    }
                                }else{
                                    salidaarr['aplazados'] = (salidaarr['aplazados'] == undefined ? 0 : salidaarr['aplazados']) + 0;
                                }
                                if(auxarr2[l].estatus == 3){
                                    salidaarr['Cancelados'] = (salidaarr['Cancelados'] == undefined ? 0 : salidaarr['Cancelados']) + auxarr[l].conteo;
                                    datos.totales['totalCancelado'] = datos.totales['totalCancelado'] + salidaarr['Cancelados'] ;
                                    
                                    if(tipo == 'expediente'){
                                        datos.totalExpediente['TCancelado'] = datos.totalExpediente['TCancelado'] + salidaarr['Cancelados'] ;
                                    }
                                    if(tipo == 'interesado'){
                                        datos.totalInteresado['TCancelado'] = datos.totalInteresado['TCancelado'] + salidaarr['Cancelados'] ;
                                    }
                                    if(tipo == 'contactado'){
                                        datos.totalContactado['TCancelado'] = datos.totalContactado['TCancelado'] + salidaarr['Cancelados'] ;
                                    }
                                    if(tipo == 'lead'){
                                        datos.totalLead['TCancelado'] = datos.totalLead['TCancelado'] + salidaarr['Cancelados'] ;
                                    }
                                }else{
                                    salidaarr['Cancelados'] = (salidaarr['Cancelados'] == undefined ? 0 : salidaarr['Cancelados']) + 0;
                                }
                            }
                        }else{
                            salidaarr['aplazados'] = (salidaarr['aplazados'] == undefined ? 0 : salidaarr['aplazados']) + 0;
                            salidaarr['Cancelados'] = (salidaarr['Cancelados'] == undefined ? 0 : salidaarr['Cancelados']) + 0;
                        }
                        salidaarr['total2'] = salidaarr['total2'] + salidaarr['aplazados'] + salidaarr['Cancelados'];
                        datos.totales['totalInactivo'] = datos.totales['totalInactivo'] + salidaarr['total2'] ;
                        
                        if(tipo == 'expediente'){
                            datos.totalExpediente['TInactivo'] = datos.totalExpediente['TInactivo'] + salidaarr['total2'] ;
                        }
                        if(tipo == 'interesado'){
                            datos.totalInteresado['TInactivo'] = datos.totalInteresado['TInactivo'] + salidaarr['total2'] ;
                        }
                        if(tipo == 'contactado'){
                            datos.totalContactado['TInactivo'] = datos.totalContactado['TInactivo'] + salidaarr['total2'] ;
                        }
                        if(tipo == 'lead'){
                            datos.totalLead['TInactivo'] = datos.totalLead['TInactivo'] + salidaarr['total2'] ;
                        }
                    }
                    if(tipo == 'expediente'){
                        datos.resumenExpedientes[j] = salidaarr;
                    }
                    if(tipo == 'interesado'){
                        datos.resumenInteresados[j] = salidaarr;
                    }
                    if(tipo == 'contactado'){
                        datos.resumenContactados[j] = salidaarr;
                    }
                    if(tipo == 'lead'){
                        datos.resumenLeads[j] = salidaarr;
                    }
                    salidaarr = [];
                }
            }
        }
    },

    reloadData: function () {
        var teamselect = document.getElementById("equipos");
        //datos.indexselect = teamselect.selectedIndex;
        datos.varselect = teamselect.options[teamselect.selectedIndex].text;
        datos.indexselect = teamselect.value;

        this.restartTotales();
        datos.cuentasEmpresariales();
        datos.cuentasEmpresarialesDetalle();
        datos.render();

        document.getElementById("equipos").value = datos.indexselect;   

        app.alert.show('reload-data', {
            level: 'info',
            title: 'Actualizando Información. <br> Equipo: '+datos.varselect+'.',
            autoClose: true,
        });
    },

    restartTotales: function(){
        datos.totales['totalTiempo']=0;
        datos.totales['totalAtrasado']=0;
        datos.totales['totalActivo']=0;
        datos.totales['totalAplazado']=0;
        datos.totales['totalCancelado']=0;
        datos.totales['totalInactivo']=0;
        datos.totalExpediente['Ttiempo']=0;
        datos.totalExpediente['TAtrasado']=0;
        datos.totalExpediente['TActivo']=0;
        datos.totalExpediente['TAplazado']=0;
        datos.totalExpediente['TCancelado']=0;
        datos.totalExpediente['TInactivo']=0;
        datos.totalInteresado['Ttiempo']=0;
        datos.totalInteresado['TAtrasado']=0;
        datos.totalInteresado['TActivo']=0;
        datos.totalInteresado['TAplazado']=0;
        datos.totalInteresado['TCancelado']=0;
        datos.totalInteresado['TInactivo']=0;
        datos.totalContactado['Ttiempo']=0;
        datos.totalContactado['TAtrasado']=0;
        datos.totalContactado['TActivo']=0;
        datos.totalContactado['TAplazado']=0;
        datos.totalContactado['TCancelado']=0;
        datos.totalContactado['TInactivo']=0;
        datos.totalLead['Ttiempo']=0;
        datos.totalLead['TAtrasado']=0;
        datos.totalLead['TActivo']=0;
        datos.totalLead['TAplazado']=0;
        datos.totalLead['TCancelado']=0;
        datos.totalLead['TInactivo']=0;
        datos.resumenExpedientes =  [];
        datos.resumenInteresados = [];
        datos.resumenContactados = [];
        datos.resumenLeads = [];
        datos.objdetalle = null;
    },

    recargaData:function(){
        app.alert.show('alert-actualiza', {
            level: 'process',
            title: 'Actualizando...',
        });
        datos.$('[data-name="btnactualiza"]').attr('style', 'pointer-events:block;');
        this.restartTotales();
        this.cargaInicial();
        var teamselect = document.getElementById("equipos");
		datos.varselect = "";
        //this.cuentasEmpresariales();
        //this.cuentasEmpresarialesDetalle();
        datos.render();
    },

    time_recargadatos:function(){

        setTimeout(function(){
            this.recargaData();
        }, 600000);
    },
})
