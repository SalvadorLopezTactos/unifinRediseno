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
({
    extendsFrom: 'ClosebuttonField',

    closedStatus: 'Held', //status indicating that the it is closed or complete

    /**
     * @inheritdoc
     */
    showSuccessMessage: function() {
        app.alert.show('close_meeting_success', {
            level: 'success',
            autoClose: true,
            title: app.lang.get('LBL_MEETING_CLOSE_SUCCESS', this.module)
        });
    }
})
