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

(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('File', ['field'], {
            /**
             * Asynchronously uploads files on toggle.
             *
             * @param {Object} component
             * @param {Object} plugin
             * @return {void}
             */
            onAttach: function(component, plugin) {
                this.before('toggleField', function(viewName) {
                    if (this.action === 'edit') {
                        app.file.checkFileFieldsAndProcessUpload(this, null, {deleteIfFails: false}, true);
                    }
                    return true;
                }, null, this);
            },
            /**
             * TODO: Empty function shouldn't be needed when SC-1576 is fixed.
             *
             * {@inheritDoc}
             * @return {void}
             */
            bindKeyDown: function() {},
            /**
             * TODO: Empty function shouldn't be needed when SC-1576 is fixed.
             *
             * {@inheritDoc}
             * @return {void}
             */
            bindDocumentMouseDown: function() {}
        });
    });
})(SUGAR.App);
