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
        vari = "1";
        
        app.alert.show('alert-actualiza', {
            level: 'process',
            title: 'Actualizando...',
        });
		
        /*
        data1 = '{"equipo":{"0":"1","9":"6","10":"CAN"},"region":{"0":"METROPOLITANA","1":"METRO 1","5":"EXPERIENCE","9":"METRO 2","10":"SUR"},"expediente":[{"equipo":"1","usuarios":[{"usuario":"Armando Calles Rodriguez","datos":[{"conteo":"31","EstatusProducto":null,"inactivo":"0","semaforo":"0"},{"conteo":"1","EstatusProducto":"1","inactivo":"0","semaforo":"1"}]},{"usuario":"Alejandra Restrepo Duque","datos":[{"conteo":"9","EstatusProducto":null,"inactivo":"0","semaforo":"0"}]},{"usuario":"Jorge Manuel Estudillo Cabrera","datos":[{"conteo":"8","EstatusProducto":null,"inactivo":"0","semaforo":"0"}]},{"usuario":"Jeanette Lucelia Orozco Moreno","datos":[{"conteo":"104","EstatusProducto":null,"inactivo":"0","semaforo":"0"},{"conteo":"5","EstatusProducto":"1","inactivo":"0","semaforo":"0"},{"conteo":"3","EstatusProducto":"3","inactivo":"1","semaforo":"0"}]}]},{"equipo":"6","usuarios":[{"usuario":"Benito Lozano Aguilar","datos":[{"conteo":"4","EstatusProducto":null,"inactivo":"0","semaforo":"0"}]}]}],"interesado":null,"contactado":null,"lead":[{"equipo":"1","usuarios":[{"usuario":"Jeanette Lucelia Orozco Moreno","datos":[{"conteo":"79","estatus":null,"inactivo":"0","semaforo":"0"},{"conteo":"8","estatus":"2","inactivo":"1","semaforo":"0"}]}]}]}';
        //data1 = '{"expediente_activo":{"records":[{"idCuenta":"582325f8-7917-dee9-89d8-5977c61951d3","nombreCuenta":"MANTENIMIENTO E INSTALACIONES MINERAS, S.C.","asesor":"Alma Socorro Medrano Armendariz","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"11892288-4353-9d0d-3c20-59cd2f822d71","oppNombre":"SOLICITUD 68946 - MANTENIMIENTO E INSTALACIONES MINERAS, S.C.","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 3000000"},{"idCuenta":"d44c8fbc-304f-7863-c969-5a8449018030","nombreCuenta":"GRANELERA LOEWEN, S.P.R. DE R.L. DE C.V.","asesor":"Alma Socorro Medrano Armendariz","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"08223a4c-4fac-11e8-bbae-00155d967307","oppNombre":"SOLICITUD 74371 - R\/I para LC77443_1521157776","oppEtapa":"RECHAZADO RECHAZADA CR\u00c9DITO","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 9040160"},{"idCuenta":"2755b1c1-47d3-66ff-c850-58a24fbd9298","nombreCuenta":"JOSE ANTONIO LEAL ALMEIDA","asesor":"Alma Socorro Medrano Armendariz","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"12fff857-e9a7-b902-5730-58ab8d00d5c1","oppNombre":"SOLICITUD 62695 - JOSE ANTONIO LEAL ALMEIDA","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 1000000"},{"idCuenta":"1aa1d2a8-17bd-1fcc-5eae-58a20c356157","nombreCuenta":"DMT ASESORIA ADMINISTRATIVA, S.C.","asesor":"Mar\u00eda Teresa Vizca\u00edno Moreno","equipo":"4","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"48e7c444-d86a-d96d-eeb1-58ab176f8a02","oppNombre":"LINEA DE CREDITO DMT","oppEtapa":"CLIENTE CON L\u00cdNEA AUTORIZADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 160587.83"},{"idCuenta":"8d801cca-69a8-11e8-844b-00155d967407","nombreCuenta":"CAMJIM, S.C.","asesor":"Monica de la Luz Vazquez Vidal","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"b1ec01a6-69b1-11e8-8447-00155d967307","oppNombre":"LC79890_1528469694","oppEtapa":"CLIENTE CON L\u00cdNEA AUTORIZADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 169616.31"},{"idCuenta":"704b17f7-1798-273f-c4fa-5a4e7b5aacc2","nombreCuenta":"CAFE TORINO, S.A. DE C.V.","asesor":"Stephanie Martinez Aguilar","equipo":"4","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"b0151e63-bb1d-36de-7d9a-5a56744c321b","oppNombre":"SOLICITUD 71439 - Cafe Torino Linea de Grupo Operadora Bajo de la Tintorera","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 3000000"},{"idCuenta":"4a54ba0c-1e3c-41e8-8d19-bc06f6fae7c0","nombreCuenta":"TRANSPORTES BAM BAN, S.A. DE C.V.","asesor":"Mar\u00eda Teresa Vizca\u00edno Moreno","equipo":"4","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"3a68f7ae-b8d2-302c-755c-5894daec55ef","oppNombre":"SOLICITUD 62231 - R\/I para LINEA DE CREDITO BAM BAN","oppEtapa":"CLIENTE CON L\u00cdNEA AUTORIZADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 5000000"},{"idCuenta":"a3640968-04ef-192c-753b-56a279043161","nombreCuenta":"PROMOTORA DE INFRAESTRUCTURA IMM, S.A. DE C.V.","asesor":"Mar\u00eda Teresa Vizca\u00edno Moreno","equipo":"4","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"062a2658-1ce6-11e8-8578-00155d967407","oppNombre":"SOLICITUD 72660 - R\/I para LINEA DE CREDITO PROMO IMM","oppEtapa":"CLIENTE CON L\u00cdNEA AUTORIZADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 0"},{"idCuenta":"9c36de6e-8367-3ffa-6fcc-5a833386d33b","nombreCuenta":"PECANINIS SA DE CV","asesor":"Monica de la Luz Vazquez Vidal","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"2d5a3ce6-223f-11e8-98df-00155d967407","oppNombre":"SOLICITUD 72839 - PECANINIS SA DE CV","oppEtapa":"RECHAZADO RECHAZADA CR\u00c9DITO","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 7000000"},{"idCuenta":"3d484745-b5d2-4fb6-9c2a-5a18f214c9cc","nombreCuenta":"TRITURACION EQUIPOS MAQUINARIA Y ARRENDADORA, S.A. DE C.V.","asesor":"Monica de la Luz Vazquez Vidal","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"39eaa413-1f52-4ab8-9eaf-885fbb8ca8c6","oppNombre":"SOLICITUD 47805 NUEVA LINEA","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 5000000"},{"idCuenta":"884826c5-2aac-e7cf-7c11-592e5e2e2212","nombreCuenta":"JOSE ADRIAN MENDEZ VAZQUEZ","asesor":"Alma Socorro Medrano Armendariz","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"a3866a18-f418-61ee-71a8-5948629b6bb7","oppNombre":"SOLICITUD 65884 - JOSE ADRIAN MENDEZ VAZQUEZ","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 30000000"},{"idCuenta":"b4206bc7-fc5b-e976-f221-57b24afa5568","nombreCuenta":"SERGIO IVAN GONZALEZ ORDO\u00d1EZ","asesor":"Alma Socorro Medrano Armendariz","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"366a5136-6849-11e8-8a0f-00155d967307","oppNombre":"SOLICITUD 75204 - SERGIO IVAN GONZALEZ ORDO\u00d1EZ","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 3600000"},{"idCuenta":"b1eb6154-590a-a3c5-057a-581cc94c884d","nombreCuenta":"DAVILA GOMEZ AUTOTRANSPORTES, S.A. DE C.V.","asesor":"Alma Socorro Medrano Armendariz","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"17a4cae2-f1a2-92d7-9dd4-5a024c44a603","oppNombre":"SOLICITUD 70057 - R\/I para SOLICITUD 60034 - DAVILA GOMEZ AUTOTRANSPORTES SA DE CV","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 10212488.87"},{"idCuenta":"0af2d272-5b0d-4acd-9d46-463a85d373a9","nombreCuenta":"NEOMEXICANA DE GNC S.A.P.I. DE C.V.","asesor":"Mar\u00eda Teresa Vizca\u00edno Moreno","equipo":"4","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"29f2df17-414b-4b51-a22d-9df9b4b29fc1","oppNombre":"LINEA DE CREDITO NEOMEXICANA DE GNC S.A.P.I. DE C.V.","oppEtapa":"CLIENTE CON L\u00cdNEA AUTORIZADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 1262894.2"},{"idCuenta":"4cc280b9-44d9-49cb-ec13-579b91f18693","nombreCuenta":"DISTRIBUIDORA Y MULTISERVICIOS RAMOS, S. DE R.L. DE C.V.","asesor":"Monica de la Luz Vazquez Vidal","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"3f3b6095-247f-82eb-8bca-57b5dddb8ac4","oppNombre":"SOLICITUD 57879 - DISTRIBUIDORA Y MULTISERVICIOS RAMOS, S. DE R.L. DE C.V.","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 700000"},{"idCuenta":"48cd3146-67dd-1c96-b260-56ce32b1b612","nombreCuenta":"CORPORACI\u00d3N ADMINISTRATIVA MEXICANA ROHA,S.A DE C.V.","asesor":"Fernando Nieto Calzada","equipo":"4","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"6e6cbf98-052f-2d83-a02c-5a67572370f4","oppNombre":"SOLICITUD 71675 - ROHA","oppEtapa":"RECHAZADO RECHAZADA CR\u00c9DITO","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 1000000"},{"idCuenta":"920a6b1f-53cc-c209-6fae-56951cb8c486","nombreCuenta":"HABITEU ARQUITECTURA, S.A. DE C.V.","asesor":"Mar\u00eda Teresa Vizca\u00edno Moreno","equipo":"4","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"b56708a2-a97e-9934-4504-569529fafd30","oppNombre":"LINEA DE CREDITO HABITEU ARQUITECTURA, S.A. DE C.V.","oppEtapa":"CLIENTE CON L\u00cdNEA AUTORIZADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 244670.38"},{"idCuenta":"8c4f37c9-e8b9-692b-d3e1-585ad47a5a9e","nombreCuenta":"AL-LUVA-RAM SERVICIOS M\u00daLTIPLE SA DE CV","asesor":"Monica de la Luz Vazquez Vidal","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"b9b83fe3-c531-ecd1-222a-586feec8f0a6","oppNombre":"SOLICITUD 61603 - AL-LUVA-RAM SERVICIOS M\u00daLTIPLE SA DE CV","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE CANCELADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 750000"},{"idCuenta":"8879f175-72a0-3248-1da6-57c86eba2fbc","nombreCuenta":"SEGURIDAD PRIVADA GINTHER DE OCCIDENTE, S. DE R.L. DE C.V.","asesor":"Monica de la Luz Vazquez Vidal","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"c920a9ea-69b5-11e8-b472-00155d967307","oppNombre":"SOLICITUD 75290 - R\/I para LINEA DE CREDITO SEGURIDAD PRIVADA GINTHER DE OCCIDENTE, S. DE R.L. DE C.V.","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE DEVUELTA POR CR\u00c9DITO","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 6138810.14"},{"idCuenta":"76c0f4ab-85b3-5676-57f3-58bfaade2d8e","nombreCuenta":"DESPEPITADORA EL LLANO SPR DE RL DE CV","asesor":"Monica de la Luz Vazquez Vidal","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"5c4400a0-808b-11e8-9a07-00155d967307","oppNombre":"LC80359_1533763702","oppEtapa":"CLIENTE CON L\u00cdNEA AUTORIZADA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 2500000"},{"idCuenta":"d11f7ab6-1e50-64f1-1ae3-5a1851467802","nombreCuenta":"MAP LAGUNA SA DE CV","asesor":"Monica de la Luz Vazquez Vidal","equipo":"CHI","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"50053ef3-e71c-44ac-db3a-5a205393ccf6","oppNombre":"SOLICITUD 70739 - MAP LAGUNA S.A DE C.V","oppEtapa":"RECHAZADO RECHAZADA CR\u00c9DITO","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2020-12-15 ","Monto":"$ 10000000"}]},"expediente_aplazado":null,"interesado_activo":{"records":[{"idCuenta":"986fe32c-625c-11eb-8ef0-00155da0710c","nombreCuenta":"HAPPYPATHMETODOLOGIA PFAE QA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"7940a544-625d-11eb-94e8-00155da0710c","oppNombre":"PRE - SOLICITUD 92737 - HAPPYPATHMETODOLOGIA PFAE QA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-29 18:11:56","Monto":"$ 20000000"},{"idCuenta":"53a57338-6c7a-11eb-84fe-00155da0710c","nombreCuenta":"CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"33d26394-6c7b-11eb-ab98-00155da0710c","oppNombre":"PRE - SOLICITUD 92852 - CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-02-11 15:09:56","Monto":"$ 1000000"}]},"interesado_aplazado":{"records":[{"idCuenta":"59f760fe-5747-11eb-94eb-00155da0710c","nombreCuenta":"WHIRLPOOL","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"e7c3b982-60b6-11eb-a8ab-00155da0710c","oppNombre":"PRE - SOLICITUD 92718 - WHIRLPOOL","oppEtapa":"SOLICITUD INICIAL CANCELADA","EstatusProducto":"2","semaforo":"0","fecha_asignacion":"2021-04-08 21:01:11","Monto":"$ 9000000"}]},"lead_activo":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"19a9e706-5abc-11eb-9a7b-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 15","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1af1e6ea-5abc-11eb-b797-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 19","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b4d4f62-5abc-11eb-ab6e-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 20","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b9fc4f4-5abc-11eb-baab-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 21","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"}]},"lead_aplazado":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"1eb669e8-5041-11eb-8d06-00155da0710c","nombre":"Dashlet PFAE Dashlet Uno","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-06 17:03:36","semaforo":"0"},{"idLead":"458e855e-4ec6-11eb-bb17-00155da0710c","nombre":"CASO DE PRUEBA CERO CUARENTA PFAE ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2021-01-04 19:51:44","semaforo":"0"},{"idLead":"5400374a-4aca-11eb-9243-00155da0710c","nombre":"PRUEBA NUEVA METODOLOGIA PF ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:10:41","semaforo":"0"},{"idLead":"59802aea-4eee-11eb-90f3-00155da0710c","nombre":"Lead PM 1","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-05 00:38:37","semaforo":"0"}]}}';';
        //data = '{"expediente_activo":{"records":[{"idCuenta":"9d302008-5c57-11eb-a553-00155da0710c","nombreCuenta":"YOUTUBE INC","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"51fa71dc-5c58-11eb-a2d7-00155da0710c","oppNombre":"SOLICITUD 92703 - YOUTUBE INC","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-22 ","Monto":"$ 1000000"},{"idCuenta":"3fe449fc-5f5d-11eb-a62f-00155da0710c","nombreCuenta":"PM LEAD DASHLET MANAGEMENT3","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"b4ab7202-5f6b-11eb-a376-00155da0710c","oppNombre":"SOLICITUD 92709 - PM LEAD DASHLET MANAGEMENT3","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-26 ","Monto":"$ 1000000"},{"idCuenta":"47f8be0a-60ef-11eb-b1da-00155da0710c","nombreCuenta":"ID PROCESO REPETIR","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"224e08a4-6185-11eb-867e-00155da0710c","oppNombre":"SOLICITUD 92729 - ID PROCESO REPETIR","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-28 ","Monto":"$ 1000000"},{"idCuenta":"ca165a70-6255-11eb-b632-00155da0710c","nombreCuenta":"HAPPY PATH PERSONA FISICA METODOLOGIA LEADS","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"6fcd12b0-6256-11eb-a9c6-00155da0710c","oppNombre":"SOLICITUD 92736 - HAPPY PATH PERSONA FISICA METODOLOGIA LEADS","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-29 ","Monto":"$ 1000000"},{"idCuenta":"2b36830e-6574-11eb-a36d-00155da0710c","nombreCuenta":"LEAD DE WENDY AMAIRINI REYES PERALTA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"1fc5b880-67ce-11eb-a65c-00155da0710c","oppNombre":"SOLICITUD 92813 - LEAD DE WENDY AMAIRINI REYES PERALTA","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-02-10 ","Monto":"$ 9999999"}]},"expediente_aplazado":null,"interesado_activo":{"records":[{"idCuenta":"986fe32c-625c-11eb-8ef0-00155da0710c","nombreCuenta":"HAPPYPATHMETODOLOGIA PFAE QA","asesor":"Jeanette Lucelia Orozco Moreno","fecha_asignacion":"2021-01-22 ","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"7940a544-625d-11eb-94e8-00155da0710c","oppNombre":"PRE - SOLICITUD 92737 - HAPPYPATHMETODOLOGIA PFAE QA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","semaforo":"0","Monto":"$ 20000000"},{"idCuenta":"53a57338-6c7a-11eb-84fe-00155da0710c","nombreCuenta":"CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","asesor":"Jeanette Lucelia Orozco Moreno","fecha_asignacion":"2021-01-22 ","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"33d26394-6c7b-11eb-ab98-00155da0710c","oppNombre":"PRE - SOLICITUD 92852 - CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","fecha_asignacion":"2021-01-22 ","semaforo":"0","Monto":"$ 1000000"}]},"interesado_aplazado":{"records":[{"idCuenta":"59f760fe-5747-11eb-94eb-00155da0710c","nombreCuenta":"WHIRLPOOL","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"e7c3b982-60b6-11eb-a8ab-00155da0710c","oppNombre":"PRE - SOLICITUD 92718 - WHIRLPOOL","oppEtapa":"SOLICITUD INICIAL CANCELADA","EstatusProducto":"2","semaforo":"0","Monto":"$ 9000000"}]},"lead_activo":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"19a9e706-5abc-11eb-9a7b-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 15","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1af1e6ea-5abc-11eb-b797-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 19","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b4d4f62-5abc-11eb-ab6e-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 20","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b9fc4f4-5abc-11eb-baab-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 21","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"}]},"lead_aplazado":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"1eb669e8-5041-11eb-8d06-00155da0710c","nombre":"Dashlet PFAE Dashlet Uno","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-06 17:03:36","semaforo":"0"},{"idLead":"458e855e-4ec6-11eb-bb17-00155da0710c","nombre":"CASO DE PRUEBA CERO CUARENTA PFAE ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2021-01-04 19:51:44","semaforo":"0"},{"idLead":"5400374a-4aca-11eb-9243-00155da0710c","nombre":"PRUEBA NUEVA METODOLOGIA PF ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:10:41","semaforo":"0"},{"idLead":"59802aea-4eee-11eb-90f3-00155da0710c","nombre":"Lead PM 1","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-05 00:38:37","semaforo":"0"}]}}';
        data2 = '{"expediente_activo":{"records":[{"idCuenta":"9d302008-5c57-11eb-a553-00155da0710c","nombreCuenta":"YOUTUBE INC","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"51fa71dc-5c58-11eb-a2d7-00155da0710c","oppNombre":"SOLICITUD 92703 - YOUTUBE INC","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-22 ","Monto":"$ 1000000"},{"idCuenta":"3fe449fc-5f5d-11eb-a62f-00155da0710c","nombreCuenta":"PM LEAD DASHLET MANAGEMENT3","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"b4ab7202-5f6b-11eb-a376-00155da0710c","oppNombre":"SOLICITUD 92709 - PM LEAD DASHLET MANAGEMENT3","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-26 ","Monto":"$ 1000000"},{"idCuenta":"47f8be0a-60ef-11eb-b1da-00155da0710c","nombreCuenta":"ID PROCESO REPETIR","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"224e08a4-6185-11eb-867e-00155da0710c","oppNombre":"SOLICITUD 92729 - ID PROCESO REPETIR","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-28 ","Monto":"$ 1000000"},{"idCuenta":"ca165a70-6255-11eb-b632-00155da0710c","nombreCuenta":"HAPPY PATH PERSONA FISICA METODOLOGIA LEADS","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"6fcd12b0-6256-11eb-a9c6-00155da0710c","oppNombre":"SOLICITUD 92736 - HAPPY PATH PERSONA FISICA METODOLOGIA LEADS","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-29 ","Monto":"$ 1000000"},{"idCuenta":"2b36830e-6574-11eb-a36d-00155da0710c","nombreCuenta":"LEAD DE WENDY AMAIRINI REYES PERALTA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"8","idOpp":"1fc5b880-67ce-11eb-a65c-00155da0710c","oppNombre":"SOLICITUD 92813 - LEAD DE WENDY AMAIRINI REYES PERALTA","oppEtapa":"INTEGRACI\u00d3N EXPEDIENTE EN ESPERA","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-02-10 ","Monto":"$ 9999999"}]},"expediente_aplazado":null,"interesado_activo":{"records":[{"idCuenta":"986fe32c-625c-11eb-8ef0-00155da0710c","nombreCuenta":"HAPPYPATHMETODOLOGIA PFAE QA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"7940a544-625d-11eb-94e8-00155da0710c","oppNombre":"PRE - SOLICITUD 92737 - HAPPYPATHMETODOLOGIA PFAE QA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-01-29 18:11:56","Monto":"$ 20000000"},{"idCuenta":"53a57338-6c7a-11eb-84fe-00155da0710c","nombreCuenta":"CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"33d26394-6c7b-11eb-ab98-00155da0710c","oppNombre":"PRE - SOLICITUD 92852 - CARLOS PRUEBA UAT PARA LEAD METODOLOG\u00cdA","oppEtapa":"SOLICITUD INICIAL EN VALIDACI\u00d3N COMERCIAL","EstatusProducto":"1","semaforo":"0","fecha_asignacion":"2021-02-11 15:09:56","Monto":"$ 1000000"}]},"interesado_aplazado":{"records":[{"idCuenta":"59f760fe-5747-11eb-94eb-00155da0710c","nombreCuenta":"WHIRLPOOL","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipoCuenta":"2","subtipoCuenta":"7","idOpp":"e7c3b982-60b6-11eb-a8ab-00155da0710c","oppNombre":"PRE - SOLICITUD 92718 - WHIRLPOOL","oppEtapa":"SOLICITUD INICIAL CANCELADA","EstatusProducto":"2","semaforo":"0","fecha_asignacion":"2021-04-08 21:01:11","Monto":"$ 9000000"}]},"lead_activo":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"19a9e706-5abc-11eb-9a7b-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 15","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1af1e6ea-5abc-11eb-b797-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 19","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b4d4f62-5abc-11eb-ab6e-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 20","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"},{"idLead":"1b9fc4f4-5abc-11eb-baab-00155da0710c","nombre":"PERSONA MORAL PARA RETEST METODOLOGIA 21","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":"1","fecha_asignacion":"2021-01-20 01:09:09","semaforo":"0"}]},"lead_aplazado":{"records":[{"idLead":"095e0e94-4acd-11eb-8b8f-00155da0710c","nombre":"LEAD NUEVA METODOLOGIA CASO CERO NUEVE","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:30:04","semaforo":"0"},{"idLead":"1eb669e8-5041-11eb-8d06-00155da0710c","nombre":"Dashlet PFAE Dashlet Uno","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-06 17:03:36","semaforo":"0"},{"idLead":"458e855e-4ec6-11eb-bb17-00155da0710c","nombre":"CASO DE PRUEBA CERO CUARENTA PFAE ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2021-01-04 19:51:44","semaforo":"0"},{"idLead":"5400374a-4aca-11eb-9243-00155da0710c","nombre":"PRUEBA NUEVA METODOLOGIA PF ","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"2","estatus":null,"fecha_asignacion":"2020-12-30 18:10:41","semaforo":"0"},{"idLead":"59802aea-4eee-11eb-90f3-00155da0710c","nombre":"Lead PM 1","asesor":"Jeanette Lucelia Orozco Moreno","equipo":"1","tipo":"1","subtipo":"1","estatus":null,"fecha_asignacion":"2021-01-05 00:38:37","semaforo":"0"}]}}';
        datos.objprincipal = JSON.parse(data1);
        datos.objdetalle = JSON.parse(data2);
        var list_html_mc = '';
        datos.var_equipo_list = datos.objprincipal.equipo;

        _.each(datos.objprincipal.equipo, function (value, key) {
            list_html_mc += '<option value="' + key + '">' + datos.objprincipal.equipo[key] + '</option>';
        });
        datos.equipos_list = list_html_mc;
        app.alert.dismiss('alert-actualiza');
        //datos.document.getElementById("btnactualiza").disabled = false;
        */
          
        app.api.call('GET', app.api.buildURL('GetResumenProspecto/'+vari), null, {
            success: function (data) {
				console.log(data);
                datos.objprincipal = data;
                
                if(datos.objprincipal != undefined && datos.objprincipal.equipo != null ){
                    datos.var_equipo_list = datos.objprincipal.equipo;
                    var list_html_mc = '';
                    _.each(datos.objprincipal.equipo, function (value, key) {
                        if(datos.indexselect == key){
                            list_html_mc += '<option value="' + key + '" selected>' + datos.objprincipal.equipo[key] + '</option>';
                        }else{
                            list_html_mc += '<option value="' + key + '">' + datos.objprincipal.equipo[key] + '</option>';
                        }
                    });

                    datos.equipos_list = list_html_mc;
                    datos.cuentasEmpresariales();
                    datos.render();
                }
            },
            error: function (e) {
                console.log(e);
                app.alert.dismiss('alert-actualiza');
                //datos.document.getElementById("btnactualiza").disabled = false;
                //throw e;
            }
        });
       
        app.api.call('GET', app.api.buildURL('GetDetalleLManagement/'+vari), null, {
            success: function (data) {
				console.log(data);
                datos.objdetalle = data;
                datos.cuentasEmpresarialesDetalle();
                app.alert.dismiss('alert-actualiza');
                //datos.document.getElementById("btnactualiza").disabled = false;
                datos.render();
                
            },
            error: function (e) {
                console.log(e);
                app.alert.dismiss('alert-actualiza');
                //datos.document.getElementById("btnactualiza").disabled = false;
                //throw e;
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

            for (l = 0; l < datos.resumenExpedientes.length; l++) {
                datos.resumenExpedientes[l].total1 = datos.resumenExpedientes[l].tiempo + datos.resumenExpedientes[l].atrasado;
                datos.resumenExpedientes[l].total2 = datos.resumenExpedientes[l].aplazados + datos.resumenExpedientes[l].Cancelados;
                
                datos.totalExpediente['Ttiempo'] = datos.totalExpediente['Ttiempo'] + datos.resumenExpedientes[l].tiempo ;
                datos.totalExpediente['TAtrasado'] = datos.totalExpediente['TAtrasado'] + datos.resumenExpedientes[l].atrasado;
                datos.totalExpediente['TAplazado'] = datos.totalExpediente['TAplazado'] + datos.resumenExpedientes[l].aplazados;
                datos.totalExpediente['TCancelado'] = datos.totalExpediente['TCancelado'] + datos.resumenExpedientes[l].Cancelados;
                datos.totalExpediente['TActivo'] = datos.totalExpediente['TActivo'] + datos.resumenExpedientes[l].total1;
                datos.totalExpediente['TInactivo'] = datos.totalExpediente['TInactivo'] + datos.resumenExpedientes[l].total2;
            }
            for (l = 0; l < datos.resumenInteresados.length; l++) {
                datos.resumenInteresados[l].total1 = datos.resumenInteresados[l].tiempo + datos.resumenInteresados[l].atrasado;
                datos.resumenInteresados[l].total2 = datos.resumenInteresados[l].aplazados + datos.resumenInteresados[l].Cancelados;
    
                datos.totalInteresado['Ttiempo'] = datos.totalInteresado['Ttiempo'] + datos.resumenInteresados[l].tiempo ;
                datos.totalInteresado['TAtrasado'] = datos.totalInteresado['TAtrasado'] + datos.resumenInteresados[l].atrasado;
                datos.totalInteresado['TAplazado'] = datos.totalInteresado['TAplazado'] + datos.resumenInteresados[l].aplazados;
                datos.totalInteresado['TCancelado'] = datos.totalInteresado['TCancelado'] + datos.resumenInteresados[l].Cancelados;
                datos.totalInteresado['TActivo'] = datos.totalInteresado['TActivo'] + datos.resumenInteresados[l].total1;
                datos.totalInteresado['TInactivo'] = datos.totalInteresado['TInactivo'] + datos.resumenInteresados[l].total2;
            }
            for (l = 0; l < datos.resumenContactados.length; l++) {
                datos.resumenContactados[l].total1 = datos.resumenContactados[l].tiempo + datos.resumenContactados[l].atrasado;
                datos.resumenContactados[l].total2 = datos.resumenContactados[l].aplazados + datos.resumenContactados[l].Cancelados;
    
                datos.totalContactado['Ttiempo'] = datos.totalContactado['Ttiempo'] + datos.resumenContactados[l].tiempo ;
                datos.totalContactado['TAtrasado'] = datos.totalContactado['TAtrasado'] + datos.resumenContactados[l].atrasado;
                datos.totalContactado['TAplazado'] = datos.totalContactado['TAplazado'] + datos.resumenContactados[l].aplazados;
                datos.totalContactado['TCancelado'] = datos.totalContactado['TCancelado'] + datos.resumenContactados[l].Cancelados;
                datos.totalContactado['TActivo'] = datos.totalContactado['TActivo'] + datos.resumenContactados[l].total1;
                datos.totalContactado['TInactivo'] = datos.totalContactado['TInactivo'] + datos.resumenContactados[l].total2;
            }
            for (l = 0; l < datos.resumenLeads.length; l++) {
                datos.resumenLeads[l].total1 = datos.resumenLeads[l].tiempo + datos.resumenLeads[l].atrasado;
                datos.resumenLeads[l].total2 = datos.resumenLeads[l].aplazados + datos.resumenLeads[l].Cancelados;
    
                datos.totalLead['Ttiempo'] = datos.totalLead['Ttiempo'] + datos.resumenLeads[l].tiempo ;
                datos.totalLead['TAtrasado'] = datos.totalLead['TAtrasado'] + datos.resumenLeads[l].atrasado;
                datos.totalLead['TAplazado'] = datos.totalLead['TAplazado'] + datos.resumenLeads[l].aplazados;
                datos.totalLead['TCancelado'] = datos.totalLead['TCancelado'] + datos.resumenLeads[l].Cancelados;
                datos.totalLead['TActivo'] = datos.totalLead['TActivo'] + datos.resumenLeads[l].total1;
                datos.totalLead['TInactivo'] = datos.totalLead['TInactivo'] + datos.resumenLeads[l].total2;
            }
            datos.totales['totalTiempo'] = datos.totalExpediente['Ttiempo'] + datos.totalInteresado['Ttiempo'] + datos.totalContactado['Ttiempo'] + datos.totalLead['Ttiempo'];
            datos.totales['totalAtrasado'] =datos.totalExpediente['TAtrasado'] + datos.totalInteresado['TAtrasado'] + datos.totalContactado['TAtrasado'] + datos.totalLead['TAtrasado'];
            datos.totales['totalActivo'] = datos.totalExpediente['TActivo'] + datos.totalInteresado['TActivo'] + datos.totalContactado['TActivo'] + datos.totalLead['TActivo'];
            datos.totales['totalAplazado'] = datos.totalExpediente['TAplazado'] + datos.totalInteresado['TAplazado'] + datos.totalContactado['TAplazado'] + datos.totalLead['TAplazado'];
            datos.totales['totalCancelado'] = datos.totalExpediente['TCancelado'] + datos.totalInteresado['TCancelado'] + datos.totalContactado['TCancelado'] + datos.totalLead['TCancelado'];
            datos.totales['totalInactivo'] = datos.totalExpediente['TInactivo'] + datos.totalInteresado['TInactivo'] + datos.totalContactado['TInactivo'] + datos.totalLead['TInactivo'];
           
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
                    return d1.equipo == selecrquipo;
                });
            }
            if(datos.dataCuentasExpAplazadoCompleto != null){
                datos.dataCuentasExpAplazado = datos.dataCuentasExpAplazadoCompleto.filter(function(d1) {
                    return d1.equipo == selecrquipo;
                });
            }
            if(datos.dataAccSolicitudesActivoCompleto != null){
                datos.dataAccSolicitudesActivo =  datos.dataAccSolicitudesActivoCompleto.filter(function(d1) {
                    return d1.equipo == selecrquipo;
                });
            }
            if(datos.dataAccSolicitudesAplazadosCompleto != null){
                datos.dataAccSolicitudesAplazados =  datos.dataAccSolicitudesAplazadosCompleto.filter(function(d1) {
                    return d1.equipo == selecrquipo;
                });
            }
            if(datos.dataAcProspectoContactadoActivoCompleto != null){
                datos.dataAcProspectoContactadoActivo =  datos.dataAcProspectoContactadoActivoCompleto.filter(function(d1) {
                    return d1.equipo == selecrquipo;
                });
            }
            if(datos.dataAcProspectoContactadoAplazadoCompleto != null){
                datos.dataAcProspectoContactadoAplazado =  datos.dataAcProspectoContactadoAplazadoCompleto.filter(function(d1) {
                    return d1.equipo == selecrquipo;
                });
            }
            if(datos.dataLeadActivosCompleto != null){
                datos.dataLeadActivos =  datos.dataLeadActivosCompleto.filter(function(d1) {
                    return d1.equipo == selecrquipo;
                });
            }
            if(datos.dataLeadAplazadoCompleto != null){
                datos.dataLeadAplazado =  datos.dataLeadAplazadoCompleto.filter(function(d1) {
                    return d1.equipo == selecrquipo;
                });
            }
            //datos.render();
        }
        
    },

    sumaTotales: function (arreglo , tipo , selecrquipo) {
        var i,j,k =0;
        var auxusuarios = null;
        var auxarr = [];
        var auxarr2 = [];
        var salidaarr = [];
        //var eid = document.getElementById("equipos");
        //var selecrquipo = eid.options[eid.selectedIndex].text;
        
        for (i = 0; i < arreglo.length; i++) {
            if(arreglo[i].equipo == selecrquipo){
                auxusuarios = arreglo[i].usuarios;
                for (j = 0; j < auxusuarios.length; j++) {                    
                    salidaarr ['nombre'] = auxusuarios[j].usuario;
                    salidaarr['total1'] = 0;
                    salidaarr['total2'] = 0;
                    auxarr = auxusuarios[j].datos;
                    for (k = 0; k < auxarr.length; k++) {
                        if(auxarr[k].inactivo == 0){
                                if(auxarr[k].semaforo == 1){
                                    salidaarr['tiempo'] = (salidaarr['tiempo'] == undefined ? 0 : parseInt(salidaarr['tiempo'])) + parseInt(auxarr[k].conteo);
                                }else{
                                    salidaarr['tiempo'] = (salidaarr['tiempo'] == undefined ? 0 : parseInt(salidaarr['tiempo'])) + 0;
                                }
                                if(auxarr[k].semaforo == 0){
                                    salidaarr['atrasado'] = (salidaarr['atrasado'] == undefined ? 0 : parseInt(salidaarr['atrasado'])) + parseInt(auxarr[k].conteo);
                                }else{
                                    salidaarr['atrasado'] = (salidaarr['atrasado'] == undefined ? 0 : parseInt(salidaarr['atrasado'])) + 0;
                                }
                        }else{
                            salidaarr['tiempo'] = (salidaarr['tiempo'] == undefined ? 0 : parseInt(salidaarr['tiempo'])) + 0;
                            salidaarr['atrasado'] = (salidaarr['atrasado'] == undefined ? 0 : parseInt(salidaarr['atrasado'])) + 0;
                        }

                        if(auxarr[k].inactivo == 1){                            
                                if(auxarr[k].EstatusProducto == 2){
                                    salidaarr['aplazados'] = (salidaarr['aplazados'] == undefined ? 0 : salidaarr['aplazados']) + parseInt(auxarr[k].conteo);
                                    
                                }else{
                                    salidaarr['aplazados'] = (salidaarr['aplazados'] == undefined ? 0 : salidaarr['aplazados']) + 0;
                                }
                                if(auxarr[k].EstatusProducto == 3){
                                    salidaarr['Cancelados'] = (salidaarr['Cancelados'] == undefined ? 0 : salidaarr['Cancelados']) + parseInt(auxarr[k].conteo);
                                    
                                }else{
                                    salidaarr['Cancelados'] = (salidaarr['Cancelados'] == undefined ? 0 : salidaarr['Cancelados']) + 0;
                                }
                            
                        }else{
                            salidaarr['aplazados'] = (salidaarr['aplazados'] == undefined ? 0 : salidaarr['aplazados']) + 0;
                            salidaarr['Cancelados'] = (salidaarr['Cancelados'] == undefined ? 0 : salidaarr['Cancelados']) + 0;
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
    },

    recargaData:function(){
        //datos.document.getElementById("btnactualiza").disabled = true;
        datos.restartTotales();
        datos.cargaInicial();
        //datos.render();
    },

    time_recargadatos:function(){

        setTimeout(function(){            
            datos.recargaData();
        }, 300000);
    },
    
})
