({
  extendsFrom: 'PanelTopView',
  initialize:function(options)
  {
    this._super('initialize', [options]);
    var parentModule=this.context.parent.get('model').module;  
    var parentCollection = this.context.parent.get('collection');  
    var parentModel=this.context.parent.get('model');  
    parentCollection.on('data:sync:complete', function() {
      if(_.isEqual(parentModel.get('documentos_c'),3) && _.isEqual(parentModule,'minut_Minutas')){  
        this.$('a[name=create_button]').addClass('disabled btn');    
        this.$('a[data-original-title=Actions]').addClass('disabled btn');  
      }    
    },this);  
  },
})