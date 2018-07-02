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
(function(app){app.events.on('app:init',function(){var getSystemActions=function(){var actions=[{callback:'openConfig',action:'config',name:app.lang.get('LBL_SWEETSPOT_CONFIG'),icon:'fa-cog'}];return actions;};var hasAccessToAction=function(module,action){if(module&&action.acl_action){if(!app.acl.hasAccess(action.acl_action,module)){return false;}
return action;}
if(action.acl_action==='admin'&&action['label']==='LBL_ADMIN'){if(!app.acl.hasAccessToAny('developer')){return false;}
return action;}
return action;};var getModuleLinks=function(){var actions=[];var moduleList=app.metadata.getModuleNames({filter:'display_tab',access:true});if(app.user.get('type')==='admin'&&app.metadata.getModule('Administration')){moduleList.push('Administration');moduleList=_.uniq(moduleList);}
_.each(moduleList,function(module){var moduleMeta=app.metadata.getModule(module);var menuMeta=moduleMeta&&moduleMeta.menu;var headerMeta=menuMeta&&menuMeta.header&&menuMeta.header.meta||[];var sweetspotMeta=menuMeta&&menuMeta.sweetspot&&menuMeta.sweetspot.meta||[];_.each(headerMeta.concat(sweetspotMeta),function(action){if(hasAccessToAction(action.acl_module||module,action)===false){return;}
var name;var jsFunc='push';var weight;var bwcModuleRoute='#'+app.bwc.buildRoute(module);var sidecarModuleRoute='#'+module;var isIndexRoute=action.route===sidecarModuleRoute||action.route===bwcModuleRoute;var isCreateRoute=(action.route==='#'+module+'/create');if(isIndexRoute){jsFunc='unshift';name=app.lang.getModuleName(module,{plural:true});weight=10;}else if(isCreateRoute){weight=20;name=app.lang.get(action.label,module)}else{weight=30;name=app.lang.get(action.label,module)}
actions[jsFunc]({module:module,label:app.lang.getModuleIconLabel(module),name:name,route:action.route,icon:action.icon,weight:weight});});});var profileActions=app.metadata.getView(null,'profileactions');_.each(profileActions,function(action){if(hasAccessToAction(action.acl_module,action)===false){return;}
actions.push({name:app.lang.get(action.label),route:action.route,icon:action.icon,weight:10});});return actions;};app.metadata.getSweetspotActions=function(){var collection={};var actions=getModuleLinks().concat(getSystemActions());_.each(actions,function(action){if(!action.label){action.label=app.lang.getModuleIconLabel(action.name);}
collection[action.route||action.callback]=action;});return collection;};});})(SUGAR.App);