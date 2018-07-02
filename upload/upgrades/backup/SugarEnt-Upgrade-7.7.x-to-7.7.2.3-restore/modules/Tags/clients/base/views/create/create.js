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
({extendsFrom:'CreateView',saveAndCreateAnotherButtonName:'save_create_button',initialize:function(options){this._super("initialize",[options]);},saveAndCreateAnother:function(){this.initiateSave(_.bind(function(){if(app.drawer){app.drawer.load({layout:'create',context:{create:true}});app.drawer.getActiveDrawerLayout().context.on('button:'+this.cancelButtonName+':click',this.multiSaveCancel,this);}},this));},multiSaveCancel:function(){if(app.drawer){var route=app.router.buildRoute('Tags');app.router.navigate(route,{trigger:true});app.drawer.close(app.drawer.context);}}})