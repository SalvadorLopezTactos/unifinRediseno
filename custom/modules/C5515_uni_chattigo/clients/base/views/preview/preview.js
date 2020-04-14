({

    extendsFrom:'PreviewView',
    initialize:function(options){
        this._super("initialize", [options])
        //Establece conversaciones por registro
        pre = this;
    	  pre.options.context.attributes.model.attributes.chat=[];
        pre.options.context.attributes.model.collection.models.forEach(function(entry) {
            //Itera interacciones por conversación
            try {
              var chat = JSON.parse(entry.attributes.description);
            }
            catch(err) {
              var chat = [];
            }
            for(var i = chat.length-1; i--;){
            	 if (chat[i].type !== "OUTBOUND" && chat[i].type !== "INBOUND") chat.splice(i, 1);
               chat[i].type = (chat[i].type === "OUTBOUND") ? 1: 0;
               chat[i].url = (chat[i].type === "OUTBOUND") ? 'styleguide/assets/img/logo.svg': 'styleguide/assets/img/logo.svg';
            }
            entry.attributes.chat = chat;
        });
        pre.render();
    },
})
