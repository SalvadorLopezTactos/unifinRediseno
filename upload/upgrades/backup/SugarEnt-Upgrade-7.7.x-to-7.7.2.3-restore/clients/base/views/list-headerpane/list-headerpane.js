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
({extendsFrom:'HeaderpaneView',initialize:function(options){options.meta=_.extend({},app.metadata.getView(null,'list-headerpane'),app.metadata.getView(options.module,'list-headerpane'),options.meta);this._super('initialize',[options]);app.shortcuts.register('List:Headerpane:Create','a',function(){var $createButton=this.$('a[name=create_button]');if($createButton.is(':visible')&&!$createButton.hasClass('disabled')){$createButton.get(0).click();}},this);}})