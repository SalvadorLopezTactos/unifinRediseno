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
({extendsFrom:'ConfigHeaderButtonsView',initialize:function(options){this._super('initialize',[options]);var model=this.context.get('model');model._save=model.save;model.save=function(key,val,options){this.doValidate(null,function(isValid){if(isValid){model._save(key,val,options)}else{val.error();}});}},_saveConfig:function(){var self=this;this.context.get('model').save({},{success:_.bind(function(model){app.metadata.sync(function(){self.showSavedConfirmation();if(app.drawer){app.drawer.close(self.context,self.context.get('model'));}
if(self.context.parent&&self.context.parent.get('module')===self.module){self.context.parent.reloadData();}});},this),error:_.bind(function(){this.getField('save_button').setDisabled(false);},this)});}})