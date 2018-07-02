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
(function(app){app.augment("help",{_moduleLabelMap:undefined,get:function(module,view,context){var objModule=_.extend({'module_name':app.lang.getModuleName(module),'plural_module_name':app.lang.getModuleName(module,{plural:true})},context||{},this._getModuleLabelMap()),viewName=this._cleanupViewName(view).toUpperCase();return{'title':this._get('LBL_HELP_'+viewName+'_TITLE',module,objModule),'body':this._get('LBL_HELP_'+viewName,module,objModule),'more_help':this._get('LBL_HELP_MORE_INFO',module,objModule)};},_get:function(label,module,context){var text=app.lang.get(label,module,context);if(_.isEqual(label,text)){return undefined;}
return text;},_cleanupViewName:function(viewName){switch(viewName.toLowerCase()){case'list':return'records';case'detail':return'record';default:return viewName;}},_getModuleLabelMap:function(){if(!_.isUndefined(this._moduleLabelMap)){return this._moduleLabelMap;}
this._moduleLabelMap={};_.each(app.metadata.getModuleNames({filter:'enabled'}),function(module){var key=module.toLowerCase();this._moduleLabelMap[key+'_singular_module']=app.lang.getModuleName(module);this._moduleLabelMap[key+'_module']=app.lang.getModuleName(module,{plural:true});},this);return this._moduleLabelMap;},clearModuleLabelMap:function(){this._moduleLabelMap=undefined;},getMoreInfoHelpURL:function(layoutName,module){layoutName=layoutName||'list';module=module||app.controller.context.get('module');var serverInfo=app.metadata.getServerInfo(),lang=app.lang.getLanguage(),url;if(layoutName=='records'){layoutName='list';}
url='http://www.sugarcrm.com/crm/product_doc.php?edition='+serverInfo.flavor
+'&version='+serverInfo.version+'&lang='+lang+'&module='+module+'&route='+layoutName;if(layoutName=='bwc'){var action=window.location.hash.match(/#bwc.*action=(\w*)/i);if(action&&!_.isUndefined(action[1])){url+='&action='+action[1];}}
return url;}});app.events.on("app:sync:complete",function(){app.help.clearModuleLabelMap();});})(SUGAR.App);