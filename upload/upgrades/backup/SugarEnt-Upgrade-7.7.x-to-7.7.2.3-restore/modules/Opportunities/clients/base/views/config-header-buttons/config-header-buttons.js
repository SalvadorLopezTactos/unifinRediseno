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
({extendsFrom:'ConfigHeaderButtonsView',currentOppsViewBySetting:undefined,isForecastsSetup:false,initialize:function(options){this._super('initialize',[options]);this.currentOppsViewBySetting=this.model.get('opps_view_by');this.isForecastsSetup=!!app.metadata.getModule('Forecasts','config').is_setup;},_beforeSaveConfig:function(){app.alert.show('opp.config.save',{level:'process',title:app.lang.getAppString('LBL_SAVING')});},showSavedConfirmation:function(onClose){app.alert.dismiss('opp.config.save');this._super('showSavedConfirmation',[onClose]);},displayWarningAlert:function(){app.alert.show('forecast-warning',{level:'confirmation',title:app.lang.get('LBL_WARNING'),messages:app.lang.get('LBL_OPPS_CONFIG_ALERT','Opportunities'),onConfirm:_.bind(function(){this._super('saveConfig');},this),onCancel:_.bind(function(){this.model.set('opps_view_by',this.currentOppsViewBySetting);},this)});},saveConfig:function(){if(this.isForecastsSetup&&this.currentOppsViewBySetting!==this.model.get('opps_view_by')){this.displayWarningAlert();}else{this._super('saveConfig');}},_saveConfig:function(){this.context.get('model').save({},{success:_.bind(function(model){this.showSavedConfirmation();if(app.drawer.count()){app.drawer.close(this.context,this.context.get('model'));app.sync();}else{app.router.navigate(this.module,{trigger:true});}},this),error:_.bind(function(){this.getField('save_button').setDisabled(false);},this)});}})