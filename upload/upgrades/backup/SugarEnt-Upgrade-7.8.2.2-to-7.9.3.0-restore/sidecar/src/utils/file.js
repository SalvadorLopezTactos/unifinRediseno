
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

(function(app) {

    /**
     * The File module no longer contains any methods. It is only provided for
     * backwards compatibility.
     *
     * @class Utils.File
     * @alias SUGAR.App.file
     * @singleton
     * @deprecated 7.8 It will be removed on 7.9.
     */
    Object.defineProperty(app, 'file', {
        get: function() {
            app.logger.warn('app.file is deprecated as of 7.8 and will be removed in 7.9.');
            return {};
        },
        set: _.noop,
    });
})(SUGAR.App);
