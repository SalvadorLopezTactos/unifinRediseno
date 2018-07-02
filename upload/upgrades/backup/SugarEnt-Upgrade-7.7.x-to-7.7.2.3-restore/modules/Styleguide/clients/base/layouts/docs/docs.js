/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     */
({plugins:['Prettify'],className:'row-fluid',initialize:function(options){this._super('initialize',[options]);app.events.trigger('app:dashletPreview:close');if($('head #styleguide_css').length===0){$('<link>').attr({rel:'stylesheet',href:'styleguide/assets/css/styleguide.css',id:'styleguide_css'}).appendTo('head');}},initComponents:function(components,context,module){var self=this,request={file:'',keys:[],page:{},page_data:{},parent_link:'',section:{},section_page:false},main;this._super('initComponents',[components,context,module]);request.page_data=app.metadata.getLayout(this.module,'docs').page_data;request.file=this.context.get('page_name');if(!_.isUndefined(request.file)&&!_.isEmpty(request.file)){request.keys=request.file.split('-');}
if(request.keys.length){if(request.keys[0]==='index'){if(request.keys.length>1){request.section=request.page_data[request.keys[1]];}else{request.section=request.page_data[request.keys[0]];}
request.section_page=true;request.file='index';}else if(request.keys.length>1){request.section=request.page_data[request.keys[0]];request.page=request.section.pages[request.keys[1]];request.parent_link='-'+request.keys[0];window.prettyPrint&&prettyPrint();}else{request.section=request.page_data[request.keys[0]];}}
main=this.getComponent('main-pane');main._addComponentsFromDef([{view:'docs-'+request.file,context:{module:'Styleguide',skipFetch:true,request:request}}]);this.render();},_placeComponent:function(component){if(component.meta.name){this.$("."+component.meta.name).append(component.$el);}}})