/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    motivo_list: null,

    events: {
        'click #btn-cancela': 'closeModal',
        'click #btn-aceptar': 'aceptarModal',
    },

    context_Lead: null,

    initialize: function (options) {
        self_modal_get = this;
        contextIdLead = options.contextIdLead;

        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:CancelModalLead', function () {

                var temp_array_get = [];
                var newContext = options.context.get('model');
                var motivos = app.lang.getAppListStrings('motivo_cancelacion_list');
                var list_html = '<option value=""></option>';
                _.each(motivos, function (value, key) {
                    list_html += '<option value="' + key + '">' + motivos[key] + '</option>';
                });
                self_modal_get.motivo_list = list_html;
                self_modal_get.context_Lead = options;
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

    aceptarModal: function () {

        var Keycancel = $("#motivocancelacion").val();

        if (contextIdLead != "" && Keycancel != "") {
            
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
                    model.set('motivo_cancelacion_c', Keycancel);  //Guarda el motivo de cancelacion seleccionado
                    model.save();
                    location.reload(); //refresca la página

                }, self_modal_get)
            });
        }
        self_modal_get.closeModal();

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
