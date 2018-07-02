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
({initialize:function(options){this._super('initialize',[options]);this._bindEvents();},_placeComponent:function(component){this.$('.main-pane').append(component.el);},_bindEvents:function(){this.context.on('sweetspot:cancel:config',this.cancelConfig,this);this.context.on('button:save_button:click',this.saveConfig,this);this.context.on('button:cancel_button:click',this.cancelConfig,this);},_formatForUserPrefs:function(data){return{sweetspot:data};},_getAllConfigs:function(){var config={};this.context.off('sweetspot:receive:configs');this.context.on('sweetspot:receive:configs',function(data){_.extend(config,data);});this.context.trigger('sweetspot:ask:configs');return config;},saveConfig:function(){var data=this._getAllConfigs();data=this._formatForUserPrefs(data);this.context.trigger('sweetspot:config:enableButtons',false);app.alert.show('sweetspot',{level:'process',title:app.lang.get('LBL_SAVING'),autoClose:false});app.user.updatePreferences(data,_.bind(this._saveConfigCallback,this));},_saveConfigCallback:function(err){app.alert.dismiss('sweetspot');if(err){var errorMsg=app.lang.get('LBL_SWEETSPOT_CONFIG_ERR',this.module,{errorMsg:err});this.context.trigger('sweetspot:config:enableButtons',true);app.alert.show('config-failed',{level:'error',title:'LBL_SWEETSPOT',messages:errorMsg});return;}
app.drawer.close(this.collection);app.events.trigger('sweetspot:reset');},cancelConfig:function(){app.drawer.close();},_dispose:function(){this.context.off('sweetspot:receive:configs');this._super('_dispose');}})