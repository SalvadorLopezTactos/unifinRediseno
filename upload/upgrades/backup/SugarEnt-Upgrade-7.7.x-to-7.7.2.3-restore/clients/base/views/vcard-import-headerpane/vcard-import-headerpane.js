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
({extendsFrom:'HeaderpaneView',events:{'click [name=vcard_cancel_button]':'initiateCancel'},initialize:function(options){this._super('initialize',[options]);this.context.on('vcard:import-finish-button:toggle',this._toggleFinishButton,this);},_toggleFinishButton:function(enabled){this.getField('vcard_finish_button').setDisabled(!enabled);},initiateCancel:function(){app.drawer.close();}})