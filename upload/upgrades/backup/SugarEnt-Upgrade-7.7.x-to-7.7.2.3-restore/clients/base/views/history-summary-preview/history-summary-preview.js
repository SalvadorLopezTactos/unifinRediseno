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
({extendsFrom:'PreviewView',_renderPreview:function(model,collection,fetch,previewId){var self=this,newModel;if(app.drawer&&!app.drawer.isActive(this.$el)){return;}
if(this.model&&model&&(this.model.get("id")==model.get("id")&&previewId==this.previewId)){app.events.trigger("list:preview:decorate",false);app.events.trigger('preview:close');return;}
if(app.metadata.getModule(model.module).isBwcEnabled){return;}
if(model){var viewName='preview',previewMeta=app.metadata.getView(model.module,'preview'),recordMeta=app.metadata.getView(model.module,'record');if(_.isEmpty(previewMeta)||_.isEmpty(previewMeta.panels)){viewName='record';}
this.meta=this._previewifyMetadata(_.extend({},recordMeta,previewMeta));newModel=app.data.createBean(model.module);newModel.set('id',model.id);if(fetch){newModel.fetch({showAlerts:true,success:function(model){self.renderPreview(model,collection);},view:viewName});}else{newModel.copy(model);this.renderPreview(newModel,collection);}}
this.previewId=previewId;}})