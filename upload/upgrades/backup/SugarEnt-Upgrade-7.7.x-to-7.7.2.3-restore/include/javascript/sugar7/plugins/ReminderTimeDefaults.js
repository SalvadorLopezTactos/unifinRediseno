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
(function(app){app.events.on('app:init',function(){app.plugins.register('ReminderTimeDefaults',['view'],{onAttach:function(){this.on('init',this._defaultReminderTimes,this);},_defaultReminderTimes:function(){var defaultPopupReminderTime=parseInt(app.user.getPreference('reminder_time'),10),defaultEmailReminderTime=parseInt(app.user.getPreference('email_reminder_time'),10),popupReminderTimeChanged=this.model.hasChanged('reminder_time'),emailReminderTimeChanged=this.model.hasChanged('email_reminder_time');if(!popupReminderTimeChanged&&!_.isNaN(defaultPopupReminderTime)){this.model.setDefault('reminder_time',defaultPopupReminderTime);this.model.set('reminder_time',defaultPopupReminderTime);}
if(!emailReminderTimeChanged&&!_.isNaN(defaultEmailReminderTime)){this.model.setDefault('email_reminder_time',defaultEmailReminderTime);this.model.set('email_reminder_time',defaultEmailReminderTime);}}});});})(SUGAR.App);