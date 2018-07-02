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
({className:'error-page',cubeOptions:{spin:false},events:{'click .sugar-cube':'spinCube'},initialize:function(options){app.metadata.set(this._metadata);app.data.declareModels();app.controller.context.prepare(true);this.options.meta=this._metadata.modules[this.options.module].views[this.options.name].meta;app.view.View.prototype.initialize.call(this,options);},_render:function(){if(this.context.get('errorType')){var attributes=this.getErrorAttributes();this.model.set(attributes);}
app.view.View.prototype._render.call(this);},getErrorAttributes:function(){var errorType=this.context.get('errorType'),attributes;switch(errorType){case'400':attributes={title:'ERR_HTTP_400_TITLE',type:'ERR_HTTP_400_TYPE',messages:['ERR_HTTP_400_TEXT_LINE1','ERR_HTTP_400_TEXT_LINE2'],linkText:app.lang.get('ERR_HTTP_400_ACTION')};break;case'404':attributes={title:'ERR_HTTP_404_TITLE',type:'ERR_HTTP_404_TYPE',messages:['ERR_HTTP_404_TEXT_LINE1','ERR_HTTP_404_TEXT_LINE2'],linkText:app.lang.get('ERR_HTTP_404_ACTION')};break;case'422':attributes={title:'ERR_HTTP_DEFAULT_TEXT',type:error.status||'ERR_HTTP_DEFAULT_TYPE',messages:['ERR_CONTACT_TECH_SUPPORT'],linkText:app.lang.get('ERR_HTTP_DEFAULT_ACTION')};break;case'500':attributes={title:'ERR_HTTP_500_TITLE',type:'ERR_HTTP_500_TYPE',messages:['ERR_HTTP_500_TEXT_LINE1','ERR_HTTP_500_TEXT_LINE2'],linkText:app.lang.get('ERR_HTTP_500_ACTION')};break;default:var error=this.context.get('error')||{};var title=null;if(error.status&&error.errorThrown){title='HTTP: '+error.status+' '+error.errorThrown;}
attributes={title:title||'ERR_HTTP_DEFAULT_TITLE',type:error.status||'ERR_HTTP_DEFAULT_TYPE',messages:[error.message||'ERR_HTTP_DEFAULT_TEXT']};break;}
return attributes;},_metadata:{"modules":{"Error":{"views":{"error":{"meta":{}}},"layouts":{"error":{"meta":{"type":"simple","components":[{view:"error"}]}}}}},'module_tab_map':{'Error':''}},spinCube:function(){this.cubeOptions.spin=!this.cubeOptions.spin;this.render();}})