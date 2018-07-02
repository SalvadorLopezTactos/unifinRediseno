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
({plugins:['Dashlet'],helpObject:undefined,initialize:function(options){this._super('initialize',[options]);app.logger.warn('View.Views.Base.HelpDashletView is deprecated since 7.7. Will be removed in 7.9.');this.getHelpObject();},getHelpObject:function(){var helpUrl={more_info_url:this.createMoreHelpLink(),more_info_url_close:'</a>'},ctx=this.context&&this.context.parent||this.context,layout=(this.meta.preview)?'preview':ctx.get('layout');this.helpObject=app.help.get(ctx.get('module'),layout,helpUrl);if(_.isEmpty(this.helpObject.title)){this.helpObject.title=app.lang.get(this.meta.label);}},initDashlet:function(){this.settings.set({label:this.helpObject.title});},getLabel:function(){return this.helpObject.title;},createMoreHelpLink:function(){var serverInfo=app.metadata.getServerInfo(),lang=app.lang.getLanguage(),module=app.controller.context.get('module'),route=this.context.get('layout');if(route=='records'){route='list';}
var url='http://www.sugarcrm.com/crm/product_doc.php?edition='+serverInfo.flavor
+'&version='+serverInfo.version+'&lang='+lang+'&module='+module+'&route='+route;if(route=='bwc'){var action=window.location.hash.match(/#bwc.*action=(\w*)/i);if(action&&!_.isUndefined(action[1])){url+='&action='+action[1];}}
return'<a href="'+url+'" target="_blank">';},_renderHtml:function(){this._super('_renderHtml',[this.helpObject,this.options]);}})