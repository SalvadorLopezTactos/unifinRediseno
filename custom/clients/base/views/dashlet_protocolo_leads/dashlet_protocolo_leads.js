({
    plugins: ['Dashlet'],

    events: {
        'click #assign_cp': 'asignarCP',
        'click #assign_asesor': 'asignarPorAsesor',
        'click #assign_bd': 'asignarPorBD',
        'click #assign_cancel': 'asignarPorCancelados',
        'click .modalRecordsCancel': 'closeModal',

    },

    initialize: function (options) {
        this._super("initialize", [options]);
    },

    asignarCP: function (evt) {

    	app.alert.show('navigateToNotificationCP', {
    		level: 'confirmation',
    		messages: 'Se le enviará una notificación al Centro de Prospección.<br>¿Está seguro?',
    		autoClose: false,
    		onConfirm: function(){
    			alert("Enviando notificación...");
    		},
    		onCancel: function(){
    			alert("Cancelando operación!..");
    		}
    	});
    },

    asignarPorAsesor:function(evt){

    	var objLead = {
            action: 'edit',
            copy: true,
            create: true,
            layout: 'create',
            module: 'Leads',
            dataFromProtocolo:'1'
        };

    	app.controller.loadView(objLead);

    	// update the browser URL with the proper
    	app.router.navigate('#Leads/create', {trigger: false});

    },

    asignarPorBD:function(){

    	//Obtener registros para asignar automáticamente
    	alert("Asignación por base de datos");

    },

    asignarPorCancelados:function(){

    	var modal = $('#modalRecordsCancel');
            if (modal) {
                modal.show();
            }
    },

    closeModal:function(){
    	
    	var modal = $('#modalRecordsCancel');
    	if (modal) {
    		modal.hide();
      	}
    }




})