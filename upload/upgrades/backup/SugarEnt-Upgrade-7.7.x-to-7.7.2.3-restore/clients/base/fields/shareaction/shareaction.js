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
({extendsFrom:'EmailactionField',plugins:['EmailClientLaunch'],shareTplSubject:null,shareTplBody:null,shareTplBodyHtml:null,initialize:function(options){this._super('initialize',[options]);this.type='emailaction';this._initShareTemplates();this._setShareOptions();this.model.on('change',this._setShareOptions,this);},_initShareTemplates:function(){this.shareTplSubject=app.template.getView('share.subject',this.module)||app.template.getView('share.subject');this.shareTplBody=app.template.getView('share.body',this.module)||app.template.getView('share.body');this.shareTplBodyHtml=app.template.getView('share.body-html',this.module)||app.template.getView('share.body-html');},_setShareOptions:function(){var shareParams=this._getShareParams(),subject=this.shareTplSubject(shareParams),body=this.shareTplBody(shareParams),bodyHtml=this.shareTplBodyHtml(shareParams);this.addEmailOptions({subject:subject,html_body:bodyHtml||body,text_body:body});},_getShareParams:function(){var moduleString=app.lang.getModuleName(this.module);return _.extend({},this.model.attributes,{module:moduleString,appId:app.config.appId,url:window.location.href,name:new Handlebars.SafeString(app.utils.getRecordName(this.model))});},shareWithSugarEmailClient:function(){this.launchSugarEmailClient(this.emailOptions);},getShareMailtoUrl:function(){return this._buildMailToURL(this.emailOptions);}})