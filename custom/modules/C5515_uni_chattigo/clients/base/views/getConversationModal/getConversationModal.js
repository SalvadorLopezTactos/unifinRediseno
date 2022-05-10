/**
  * @class View.Views.Base.QuickCreateView
  * @alias SUGAR.App.view.views.BaseQuickCreateView
  * @extends View.Views.Base.BaseeditmodalView
 */

({
	extendsFrom:'BaseeditmodalView',
	fallbackFieldTemplate: 'edit',
	prod_list: null,
    events: {
        'click #btn-cancela': 'closeModal',
    },
	objconver: null,
	nombre: null,
	
	respuesta_msj: "",
	initialize: function(options) {
        self_modal = this;
		this._super('initialize', [options]);
		
		app.view.View.prototype.initialize.call(this, options);
		if (this.layout) {
			this.layout.on('app:view:getConversationModal', function() {
				
				var mensajes = options.context.get('model').attributes.description;
				var nombre_cuenta = options.context.get('model').attributes.name;
				
				console.log(mensajes);
				console.log(nombre_cuenta);
				//var obj = JSON.stringify(mensajes.toString());
				//var obj = JSON.parse(mensajes);
				if (mensajes != '') {
					var chat = JSON.parse(mensajes);
					console.log(chat);
					for(var i = chat.length; i--;){
						if (chat[i].type !== "OUTBOUND" && chat[i].type !== "INBOUND"){ chat.splice(i, 1);}
						else{
							chat[i].type = (chat[i].type === "INBOUND") ? 1: 0;
							chat[i].createdAt = new Date(chat[i].createdAt);
							chat[i].horamsg = this.horatrans(chat[i].createdAt);
						}
					}
				}
				
				chat.sort(function(a, b) {
					var dateA = new Date(a.createdAt), dateB = new Date(b.createdAt);
					return dateA - dateB;
				});
				
				console.log(chat[1].content);
				
				this.objconver = chat;
				this.nombre = nombre_cuenta;
				
				this.render();
				this.$('.modal').modal({
					backdrop: 'static'
				});
				this.$('.modal').modal('show');
				app.$contentEl.attr('aria-hidden', true);
				$('.modal-backdrop').insertAfter($('.modal'));
		
				/**If any validation error occurs, system will throw error and we need to enable the buttons back*/
				this.context.get('model').on('error:validation', function() {
					this.disableButtons(false);
				}, this);
			}, this);
		}
		this.bindDataChange();
	},

	_render: function () {
        this._super("_render");
    },
	
	horatrans: function(tiempoA) {
		var tiempo = new Date(tiempoA);
		//consol.log(tiempo.getUTCHours());
		//consol.log(tiempo.getUTCMinutes());
		var salidat = tiempo.getHours()+":"+tiempo.getMinutes();
		return salidat;
	},
	
	/**Overriding the base cancelButton method*/
	cancelButton: function() {
		this._super('cancelButton');
		app.$contentEl.removeAttr('aria-hidden');
		this._disposeView();
	},
	
	 closeModal: function () {
        var modal = $('#getConversationModal');
        if (modal) {
            modal.hide();
        }
        $('.modal').modal('hide');
        $('.modal-backdrop').remove();

    },
	
	 /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'getConversationModal'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },	
	
})