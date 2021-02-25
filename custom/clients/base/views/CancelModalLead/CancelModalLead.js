/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    context_Lead: null,
    motivo_list: null,
    submotivo_list: null,

    events: {
        'click #btn-cancela': 'closeModal',
        'click #btn-aceptar': 'aceptarModal',
        'change #motivocancelacion': 'dependenciasMSC',
    },    

    initialize: function (options) {
        self_modal_ms = this;
        contextIdLead = options.contextIdLead;
        this.showSubmotivo = 0;

        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:CancelModalLead', function () {

                var temp_array_get = [];
                var newContext = options.context.get('model');

                //MOTIVO DE CANCELACION
                var motivos = App.lang.getAppListStrings('motivo_cancelacion_list');
                var list_html_mc = '<option value=""></option>';
                _.each(motivos, function (value, key) {
                    list_html_mc += '<option value="' + key + '">' + motivos[key] + '</option>';
                });
                self_modal_ms.motivo_list = list_html_mc;               

                self_modal_ms.context_Lead = options;
                self_modal_ms.render();
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
        //Muesta el campo de Submotivo
        if (this.showSubmotivo == 1) {
            $('#submotivos').show();            
        } else {
            $('#submotivos').hide();
        }
        //Jquery para que no se cierre el modal con ESC o al dar clic afuera del modal
        // $('#CancelModalLead').modal({ backdrop: 'static', keyboard: false });        
    },

    dependenciasMSC: function () {
        
        var setMotivo = $("#motivocancelacion").val(); //Guarda el valor de Motivo de Cancelación 
        
        //YA ES CLIENTE UNIFIN - LA EMPRESA YA NO EXISTE
        if ($("#motivocancelacion").val() == "1" || $("#motivocancelacion").val() == "4") {
            this.showSubmotivo = 0;
        }
        //NO ES PERFIL
        if ($("#motivocancelacion").val() == "2") {            
            this.showSubmotivo = 1;
            //Lista desplegable dependiente del Motivo de Cancelación
            var submotivos = App.lang.getAppListStrings('submotivo_cancelacion_list');
            var list_smc = '<option value=""></option>';
            _.each(submotivos, function (value, key) {

                if (key == 1 || key == 2 || key == 3 || key == 4 || key == 8) {
                    // console.log(key);
                    list_smc += '<option value="' + key + '">' + submotivos[key] + '</option>';
                }
            });
            self_modal_ms.submotivo_list = list_smc;            
        }
        //ILOCALIZABLE
        if ($("#motivocancelacion").val() == "3") {
            this.showSubmotivo = 1;
            //Lista desplegable dependiente del Motivo de Cancelación
            var submotivos = App.lang.getAppListStrings('submotivo_cancelacion_list');
            var list_smc = '<option value=""></option>';
            _.each(submotivos, function (value, key) {              

                if (key == 9 || key == 10 || key == 11) {
                    // console.log(key);                
                    list_smc += '<option value="' + key + '">' + submotivos[key] + '</option>';
                }
            });            
            self_modal_ms.submotivo_list = list_smc;
        }
        //SI ES PERFIL, NO ESTA INTERESADO
        if ($("#motivocancelacion").val() == "5") {
            this.showSubmotivo = 1;
            //Lista desplegable dependiente del Motivo de Cancelación
            var submotivos = App.lang.getAppListStrings('submotivo_cancelacion_list');
            var list_smc = '<option value=""></option>';
            _.each(submotivos, function (value, key) {              

                if (key == 5 || key == 6 || key == 7) {
                    // console.log(key);                
                    list_smc += '<option value="' + key + '">' + submotivos[key] + '</option>';
                }
            });            
            self_modal_ms.submotivo_list = list_smc;            
        }

        self_modal_ms.render();
        $("#motivocancelacion").select2('val', setMotivo); //Setea el valor de Motivo de Cancelación para que no lo quite el render
    },

    aceptarModal: function () {

        var KeyMotivoCancel = $("#motivocancelacion").val();
        var KeySubmotivoCancel = $("#submotivocancelacion").val();
        var emptyMotivoSubmotivo = 0;

        ////VALIDACION DE CAMPOS REQUERIDOS EN EL MODAL-MOTIVO DE CANCELACION////
        if ($("#motivocancelacion").val() == "") {
            $('#motivos').find('.select2-choice').css('border-color', 'red');
            emptyMotivoSubmotivo += 1;
        }
        if ($("#motivocancelacion").val() == "2" && $("#submotivocancelacion").val() == "") {
            $('#submotivos').find('.select2-choice').css('border-color', 'red');
            emptyMotivoSubmotivo += 1;
        }
        if ($("#motivocancelacion").val() == "3" && $("#submotivocancelacion").val() == "") {
            $('#submotivos').find('.select2-choice').css('border-color', 'red');
            emptyMotivoSubmotivo += 1;
        }
        if ($("#motivocancelacion").val() == "5" && $("#submotivocancelacion").val() == "") {
            $('#submotivos').find('.select2-choice').css('border-color', 'red');
            emptyMotivoSubmotivo += 1;
        }

        if (emptyMotivoSubmotivo > 0) {
            app.alert.show("falta-campos-ms-cancelacion", {
                level: "error",
                title: 'Debe seleccionar los campos faltantes de Motivo de Cancelación.',
                autoClose: false
            });
        }

        if (contextIdLead != "" && emptyMotivoSubmotivo == 0) {

            app.alert.show('cancel-lead-modal', {
                level: 'process',
                title: 'Cargando...',
            });

            var lead = app.data.createBean('Leads', { id: contextIdLead });
            lead.fetch({
                success: _.bind(function (model) {

                    app.alert.dismiss('cancel-lead-modal');

                    app.alert.show('lead-id-cancelado', {
                        level: 'success',
                        messages: 'Lead Cancelado!',
                        autoClose: true
                    });

                    model.set('lead_cancelado_c', true); //Activa bandera de Lead Cancelado
                    model.set('motivo_cancelacion_c', KeyMotivoCancel);  //Guarda el motivo de cancelacion seleccionado
                    model.set('submotivo_cancelacion_c', KeySubmotivoCancel); //Guarda el submotivo de cancelacion
                    model.save();
                    location.reload(); //refresca la página

                }, self_modal_ms)
            });
            self_modal_ms.closeModal();
        }
    },

    closeModal: function () {
        var modal = $('#CancelModalLead');
        if (modal) {
            modal.hide();
            modal.remove();
        }
        $('.modal').modal('hide');
        $('.modal').remove();
        $('.modal-backdrop').remove();
    },
})
