 /**
  * @extends View.Views.Base.RecordView
 */
({
	extendsFrom:'RecordView',
	
	initialize:function(options){
		
		this._super('initialize',[options]);
		this.model.on('sync', this.hideButtonsModal_Account, this)
		this.context.on('button:conversation_modal:click',this._openConversationModal,this);
		this.context.on('button:conversation_modal_sp:click',this._openConversationModal,this);

		//Recupera cliente asociado
        this.model.on('sync', this._getCliente, this);
	},
	
	/**Function to open the note create pop-up*/
	_openConversationModal: function() {
		/**add class content-overflow-visible if client has touch feature*/
		if (Modernizr.touch) {
			app.$contentEl.addClass('content-overflow-visible');
		}
		/**check whether the view already exists in the layout.
		* If not we will create a new view and will add to the 
		components list of the record layout
		* */
		var conversationModal = this.layout.getComponent('getConversationModal');
		if (!conversationModal) {
            /** Create a new view object */
            conversationModal = app.view.createView({
                context: this.context,
                name: 'getConversationModal',
                layout: this.layout,
                module: 'C5515_uni_chattigo'
            });
            /** add the new view to the components list of the record layout*/
            this.layout._components.push(conversationModal);
            this.layout.$el.append(conversationModal.$el);
        }
        /**triggers an event to show the pop up quick create view*/
        this.layout.trigger("app:view:getConversationModal");
    
	},
})