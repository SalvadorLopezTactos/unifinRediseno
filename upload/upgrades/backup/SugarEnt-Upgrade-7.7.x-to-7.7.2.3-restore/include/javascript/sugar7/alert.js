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
(function(app){app.events.on('app:sync',function(){app.alert.show('app:sync',{level:'process',title:app.lang.get('LBL_LOADING')});});app.events.on('app:sync:complete app:sync:error',function(){app.alert.dismiss('app:sync');});var _contextProto=_.clone(app.Context.prototype);app.Context.prototype.loadData=function(options){if(!this.parent){options=options||{};options.showAlerts=true;}
_contextProto.loadData.call(this,options);};var processAlert={_count:0,dismiss:function(){this._count--;if(this._count<1){this._count=0;app.alert.dismiss('data:sync:process');}},show:function(options){this._count++;app.alert.show('data:sync:process',options);}};app.events.on('data:sync:start',function(method,model,options){options=options||{};if(!options.showAlerts){return;}
if(options.showAlerts.process===false){return;}
var alertOpts={level:'process'};if(method==='read'){alertOpts.title=app.lang.get('LBL_LOADING');}
else if(method==='delete'){alertOpts.title=options.relate?app.lang.get('LBL_UNLINKING'):app.lang.get('LBL_DELETING');}
else{alertOpts.title=app.lang.get('LBL_SAVING');}
if(_.isObject(options.showAlerts.process)){_.extend(alertOpts,options.showAlerts.process);}
processAlert.show(alertOpts);});var syncCompleteHandler=function(type,messages,method,model,options){options=options||{};var alertOpts={level:type,messages:messages};alertOpts.autoClose=(alertOpts.level==='error')?false:true;if(!options.showAlerts)return;if(method==='read')return;if(options.showAlerts[type]===false)return;if(_.isObject(options.showAlerts[type])){_.extend(alertOpts,options.showAlerts[type]);}
app.alert.show('data:sync:'+type,alertOpts);};app.events.on('data:sync:success',function(method,model,options){var messages;if(method==='delete'){messages=options.relate?'LBL_UNLINKED':'LBL_DELETED';}
else{messages='LBL_SAVED';}
syncCompleteHandler('success',messages,method,model,options);});app.events.on('data:sync:error',function(method,model,options,error){var suppressErrorMessageFor=[409,412];if(!error||(!error.handled&&_.indexOf(suppressErrorMessageFor,error.status)===-1)){syncCompleteHandler('error','ERR_GENERIC_SERVER_ERROR',method,model,options);}});app.events.on('data:sync:complete',function(method,model,options){if(options.showAlerts&&options.showAlerts.process!==false){processAlert.dismiss();}});})(SUGAR.App);