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
({extendsFrom:'HeaderpaneView',events:{'click a[name=cancel_button]':'cancel'},initialize:function(options){this._super('initialize',[options]);this.model=this.context.parent&&this.context.parent.get('model')||this.model;},_formatTitle:function(title){var parent=this._getParentModel();var recordName=this._getParentModelName();if(parent&&recordName){return new Handlebars.SafeString(app.lang.get(title,parent.module,{name:recordName}));}
return title;},_getParentModel:function(){return this.context.parent.get('model');},_getParentModelName:function(){var parent=this._getParentModel();return app.utils.formatNameModel(parent.module,parent.attributes)||parent.get('name');},cancel:function(){app.drawer.close();}})