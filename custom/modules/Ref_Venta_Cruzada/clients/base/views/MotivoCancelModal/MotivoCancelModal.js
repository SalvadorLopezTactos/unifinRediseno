/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    motivo_list: null,
    avance_list:null,
    events: {
        'click #btn-cancela': 'closeModal',
        'click #btn-asigna': 'assignedAccount',
    },

    context_Call: null,
    initialize: function (options) {
        self_modal_get = this;

        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:MotivoCancelModal', function () {

                var temp_array_get = [];
                var motivos = app.lang.getAppListStrings('referencia_motivo_rechazo_list');
                var avance = app.lang.getAppListStrings('referencia_avance_cliente_list');
                var list_html = '';
                _.each(motivos, function (value, key) {
                    list_html += '<option value="' + key + '">' + motivos[key] + '</option>';
                });
                this.motivo_list = list_html;
                list_html = '';
                _.each(avance, function (value, key) {
                    list_html += '<option value="' + key + '">' + avance[key] + '</option>';
                });
                this.avance_list = list_html;
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

    assignedAccount: function () {
        scall = this;

        var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd
		}
		if (mm < 10) {
			mm = '0' + mm
		}
		today = yyyy + '-' + mm + '-' + dd;

        var keyselect = null;
        var keyselect1 = null;
        var textarea = null;
        var errorstext = "";
        keyselect = this.$('#motivorechazo').val();
        keyselect1 = this.$('#avanceprevio').val();
        textarea = this.$('#descrechazo').val();

        if (keyselect1 == "" || keyselect1 == null) {
            errorstext = "Avance previo con el cliente. <br>";
        }
        if (keyselect == "" || keyselect == null) {
            errorstext = "Motivo de rechazo. <br>";
        }
        if (textarea.trim() == "" || textarea == null) {
            errorstext = "Explicación del rechazo. <br>";
        }

        if(errorstext != ""){
            app.alert.show("Motivo de Rechazo", {
                level: "error",
                title: "Debe llenar los dato(s): <br>" + errorstext,
                autoClose: false
            });
        }else{           
            self.model.attributes.estatus = "3";
            self.model.attributes.user_id3_c = App.user.id;
            self.model.attributes.fecha_validacion_c = today;
            self.model.attributes.accion_validacion_c = "2" ;
            self.model.attributes.cancelado = true;
            self.model.attributes.avance_cliente = keyselect1;
            self.model.attributes.motivo_rechazo = keyselect;
            self.model.attributes.explicacion_rechazo = textarea;
            self.model.save();
            app.alert.show('message-id', {
                level: 'success',
                messages: 'Motivo de cancelación de Lead guardado',
                autoClose: true
            });
            scall.closeModal();
            self.render();
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
        $('#MotivoCancelModal').modal({backdrop: 'static', keyboard: false});
        $('.record').attr('style', 'pointer-events:none');
        $('.dashboard').attr('style', 'pointer-events:none');
        $('.navbar').attr('style', 'pointer-events:none');
    },
})