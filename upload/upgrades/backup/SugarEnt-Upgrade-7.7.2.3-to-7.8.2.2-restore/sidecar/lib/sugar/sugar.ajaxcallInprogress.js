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
//The SUGAR namespace must be defined
SUGAR = SUGAR || {};
(function(S) {
    S.util = S.util || {};
    var oldFunction = S.util.ajaxCallInProgress;
    /**
     * SUGAR.util.ajaxCallInProgress will return true when a ajax call is pending
     * to allow tools to detect when a given page has truely finished loading.
     */
    S.util.ajaxCallInProgress = function(){
        //Call the previous version of ajaxCallInProgress if it exists
        //This would mean we are running sidecar in sugar, so a call can come from either
        if (oldFunction && oldFunction())
            return true;

        return SUGAR.Api.getCallsInProgressCount() > 0;
    };
})(SUGAR);