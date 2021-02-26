/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    context_Call: null,
    motivo_list: null,
    submotivo_list: null,

    events: {
        'click #btn-cancela': 'closeModal',
        'click #btn-asigna': 'assignedAccount',
        'change #motivocancelacion': 'dependenciasMSC',
    },

    initialize: function (options) {
        self_modal_get = this;
        this.showSubmotivo = 0;

        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:MotivoCancelModal', function () {

                var temp_array_get = [];
                var newContext = options.context.get('model');
                
                //MOTIVO DE CANCELACION
                var motivos = app.lang.getAppListStrings('motivo_cancelacion_list');
                var list_html = '<option value="" >  </option>';
                _.each(motivos, function (value, key) {
                    list_html += '<option value="' + key + '">' + motivos[key] + '</option>';
                });
                this.motivo_list = list_html;

                this.context_Call = options;
                this.render();
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

    closeModal: function () {
        var modal = $('#MotivoCancelModal');
        if (modal) {
            modal.hide();
            modal.remove();
        }
        $('.modal').modal('hide');
        $('.modal').remove();
        $('.modal-backdrop').remove();
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
            self_modal_get.submotivo_list = list_smc;            
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
            self_modal_get.submotivo_list = list_smc;
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
            self_modal_get.submotivo_list = list_smc;            
        }

        self_modal_get.render();
        $("#motivocancelacion").select2('val', setMotivo); //Setea el valor de Motivo de Cancelación para que no lo quite el render
    },

    assignedAccount: function () {
        scall = this;
        var keyselect = null;

        keyselect = this.$('#motivocancelacion').val();
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
            app.alert.show("falta-call-ms-cancelacion", {
                level: "error",
                title: 'Debe seleccionar los campos faltantes de Motivo de Cancelación.',
                autoClose: false
            });
        }

        if (keyselect != "" && keyselect != null && emptyMotivoSubmotivo == 0) {

            $('.record').removeAttr('style');
            $('.dashboard').removeAttr('style');
            $('.navbar').removeAttr('style');

            app.alert.show('cancel-call-modal', {
                level: 'process',
                title: 'Cargando...',
            });

            var lead = app.data.createBean('Leads', { id: this.model.get('parent_id') });
            lead.fetch({
                success: _.bind(function (model) {

                    app.alert.dismiss('cancel-call-modal');

                    app.alert.show('message-id', {
                        level: 'success',
                        messages: 'Motivo de cancelación de Lead guardado',
                        autoClose: true
                    });

                    model.set('lead_cancelado_c', true);
                    model.set('motivo_cancelacion_c', keyselect);
                    model.set('submotivo_cancelacion_c', KeySubmotivoCancel);
                    model.save();
                    
                }, this)
            });
            scall.closeModal();
        } 
    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, { name: 'setAccountModal' }));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },

    _render: function () {
        this._super("_render");
        // $('#MotivoCancelModal').modal({backdrop: 'static', keyboard: false});
        $('.record').attr('style', 'pointer-events:none');
        $('.dashboard').attr('style', 'pointer-events:none');
        $('.navbar').attr('style', 'pointer-events:none');

        //Muesta el campo de Submotivo
        if (this.showSubmotivo == 1) {
            $('#submotivos').show();            
        } else {
            $('#submotivos').hide();
        }
    },
})
