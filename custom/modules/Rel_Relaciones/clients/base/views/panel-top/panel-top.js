({
  extendsFrom: 'PanelTopView',
  initialize:function(options){

    this._super('initialize', [options]);

    var parentCollection = this.context.parent.get('collection');  
    parentCollection.on('data:sync:complete', function() {

      if(this.collection.link.name=='accounts_rel_relaciones_1'){
        //Se deshabilita botón de creación y link sobre el subpanel de Relaciones con otros clientes
        this.$('a[name=create_button]').addClass('disabled btn');    
        this.$('a[data-original-title=Actions]').addClass('disabled btn');  
      }
    },this);
  },
})