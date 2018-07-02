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
({extendsFrom:'PreviewView',events:{'click .minify':'toggleMinify'},toggleMinify:function(evt){var $el=this.$('.dashlet-toggle > i'),collapsed=$el.is('.icon-chevron-up');if(collapsed){$('.dashlet-toggle > i').removeClass('icon-chevron-up');$('.dashlet-toggle > i').addClass('icon-chevron-down');}else{$('.dashlet-toggle > i').removeClass('icon-chevron-down');$('.dashlet-toggle > i').addClass('icon-chevron-up');}
$('.dashlet').toggleClass('collapsed');$('.dashlet-content').toggleClass('hide');},_renderPreview:function(model,collection,fetch,previewId){var self=this;if(app.drawer&&!app.drawer.isActive(this.$el)){return;}
if(this.model&&model&&(this.model.get("id")==model.get("id")&&previewId==this.previewId)){app.events.trigger("list:preview:decorate",false);app.events.trigger('preview:close');return;}
if(app.metadata.getModule(model.module).isBwcEnabled){return;}
if(model){var viewName='preview',previewMeta=app.metadata.getView(model.module,'preview'),recordMeta=app.metadata.getView(model.module,'record');if(_.isEmpty(previewMeta)||_.isEmpty(previewMeta.panels)){viewName='record';}
this.meta=this._previewifyMetadata(_.extend({},recordMeta,previewMeta));if(model.get('id2')){model.set('id',model.get('id2'));}
if(fetch){model.fetch({showAlerts:true,success:function(model){self.renderPreview(model,collection);},view:viewName});}else{this.renderPreview(model,collection);}
var pmseInboxUrl=app.api.buildFileURL({module:'pmse_Inbox',id:model.get('cas_id')||(self.collection.get(model)).get('cas_id'),field:'id'},{cleanCache:true});this.image_preview_url=pmseInboxUrl;}
this.previewId=previewId;}})