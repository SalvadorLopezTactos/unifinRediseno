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
({className:'columns',plugins:['Editable'],initialize:function(options){options.meta=this._getMeta(options);this._super('initialize',[options]);this._bindEvents();},_getMeta:function(options){return _.extend({},app.metadata.getView(null,'sweetspot-config-theme'),app.metadata.getView(this.module,'sweetspot-config-theme'),options.meta);},_bindEvents:function(){this.context.on('sweetspot:ask:configs',this.generateConfig,this);},_renderHtml:function(){this._super('_renderHtml');this._initTheme();},_initTheme:function(){var prefs=app.user.getPreference('sweetspot');var theme=prefs&&prefs.theme;this.model.set('theme',theme);},generateConfig:function(){var theme=this._getSelectedTheme();if(!theme){return;}
var data=this._formatForUserPrefs(theme);this.context.trigger('sweetspot:receive:configs',data);},_formatForUserPrefs:function(theme){return{theme:theme};},_getSelectedTheme:function(){var theme=this.model.get('theme');if(theme==='default'){return;}
return theme;},hasUnsavedChanges:function(){var prefs=app.user.getPreference('sweetspot');var oldConfig=prefs&&prefs.theme;var newConfig=this._getSelectedTheme();var isChanged=!_.isEqual(oldConfig,newConfig);return isChanged;}})