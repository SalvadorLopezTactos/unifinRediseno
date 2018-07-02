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
({extendsFrom:'HeaderpaneView',initialize:function(options){this._super('initialize',[options]);var moduleMeta=app.metadata.getModule(options.module),isBwcEnabled=(moduleMeta&&moduleMeta.isBwcEnabled),multiSelect=options.context.get('isMultiSelect'),buttonsToRemove=[],additionalEvents={};this.isMultiLink=options.context.has('recLink');if(isBwcEnabled||multiSelect||this.isMultiLink){buttonsToRemove.push('create_button');}else{additionalEvents['click [name=create_button]']='createAndSelect';this.events=_.extend({},this.events,additionalEvents);}
if(this.isMultiLink){var linkTitleLabel=_.find(this.meta.fields,function(field){return field.name==='title';},this);linkTitleLabel.default_value='TPL_SEARCH_AND_ADD';}else{buttonsToRemove.push('link_button');}
if(!multiSelect){buttonsToRemove.push('select_button');}
this._removeButtons(buttonsToRemove);},_renderHtml:function(){this._super('_renderHtml');this.layout.on('selection:closedrawer:fire',_.once(_.bind(function(){this.$el.off();app.drawer.close();},this)));if(this.isMultiLink){this.layout.on('selection:link:fire',function(){this.context.trigger('selection-list:link:multi');});}},_formatTitle:function(title){var moduleName=app.lang.get('LBL_MODULE_NAME',this.module);return app.lang.get(title,this.module,{module:moduleName});},createAndSelect:function(){app.drawer.open({layout:'create-nodupecheck',context:{module:this.module,create:true}},_.bind(function(context,model){if(model){this.context.trigger('selection-list:select',context,model);}},this));},_removeButtons:function(buttons){if(!buttons.length){return;}
var mainDropdown=_.find(this.meta.buttons,function(button){return button.name==='main_dropdown';});if(!mainDropdown){return;}
mainDropdown.buttons=_.filter(mainDropdown.buttons,function(button){return!_.contains(buttons,button.name);});}})