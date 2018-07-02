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
({className:'businessrules',loadData:function(options){this.br_uid=this.options.context.attributes.modelId;},initialize:function(options){app.view.View.prototype.initialize.call(this,options);this.context.off("businessRules:save:finish",null,this);this.context.on("businessRules:save:finish",this.saveBusinessRules,this);this.context.off("businessRules:save:save",null,this);this.context.on("businessRules:save:save",this.saveOnlyBusinessRules,this);this.context.off("businessRules:cancel:button",null,this);this.context.on("businessRules:cancel:button",this.cancelBusinessRules,this);this.myDefaultLayout=this.closestComponent('sidebar');app.routing.before('route',this.beforeRouteChange,this);this._currentUrl=Backbone.history.getFragment();},render:function(){app.view.View.prototype.render.call(this);renderBusinessRule(this.br_uid,this.myDefaultLayout);},saveBusinessRules:function(){saveBR(App.router.buildRoute("pmse_Business_Rules"),this.model.id);},saveOnlyBusinessRules:function(){saveBR(null,this.model.id);},cancelBusinessRules:function(){app.router.navigate('pmse_Business_Rules',{trigger:true});},beforeRouteChange:function(){var targetUrl=Backbone.history.getFragment();if(decision_table.getIsDirty()){app.router.navigate(this._currentUrl,{trigger:false,replace:true});app.alert.show('leave_confirmation',{level:'confirmation',messages:app.lang.get('LBL_WARN_UNSAVED_CHANGES',this.module),onConfirm:function(){decision_table.setIsDirty(false,true);app.router.navigate(targetUrl,{trigger:true,replace:true});},onCancel:$.noop});return false;}
return true;}})