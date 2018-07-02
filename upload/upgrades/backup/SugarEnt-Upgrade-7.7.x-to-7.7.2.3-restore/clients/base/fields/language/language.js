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
({extendsFrom:'EnumField',initialize:function(options){this._super('initialize',[options]);this.model.setDefault(this.name,this._getDefaultOption());},_loadTemplate:function(){this.type='enum';app.view.Field.prototype._loadTemplate.call(this);this.type='language';},format:function(value){if(!this.items[value]){value=this._getDefaultOption();this.model.set(this.name,value);}
return value;},_getDefaultOption:function(optionsKeys){return app.lang.getDefaultLanguage();},})