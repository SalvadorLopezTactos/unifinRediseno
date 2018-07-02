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
({extendsFrom:'CurrencyField',bindDataChange:function(){this._super('bindDataChange');this.model.on('change:discount_select',this.render,this);},_loadTemplate:function(){if(this.model.get('discount_select')==true){this._super('_loadTemplate');}else{this.template=app.template.getField('currency',this.action||this.view.action,this.module)||app.template.empty;this.tplName=this.action||this.view.action;}},format:function(value){if(this.model.get('discount_select')==true){return app.utils.formatNumberLocale(value);}else{return this._super('format',[value]);}},unformat:function(value){if(this.model.get('discount_select')==true){var unformattedValue=app.utils.unformatNumberStringLocale(value,true);return _.isFinite(unformattedValue)?unformattedValue:value;}else{return this._super('unformat',[value]);}}})