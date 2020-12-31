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
        'click #btn-asigna': 'assignedAccount',
    },

    context_Call: null,
    initialize: function (options) {
        self_modal_get = this;
		
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:MotivoCancelModal', function () {
				
				var temp_array_get = [];
                var newContext = options.context.get('model');
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
	
	assignedAccount: function () {
        scall = this;
		var keyselect = null;
		
		keyselect = this.$('#motivocancelacion').val();
		if(keyselect != "" && keyselect != null){
			var lead = app.data.createBean('Leads', {id:this.model.get('parent_id')});
			lead.fetch({
				success: _.bind(function (model) {
					model.set('lead_cancelado_c', true);
					model.set('motivo_cancelacion_c', keyselect);
					model.save();
					
					app.alert.show('message-id', {
						level: 'success',
						messages: 'Motivo de cancelación de Lead guardado',
						autoClose: true
					});
				}, this)
			});
			scall.closeModal();
		}else{
			app.alert.show("Motivo de Cancelación", {
                   level: "error",
                   title: "Debe seleccionar motivo de Cancelación de Lead.",
                   autoClose: false
               });
		}
    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'setAccountModal'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})
