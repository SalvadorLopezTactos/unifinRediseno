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
    events: {
        'click [name="record-close"]': 'closeClicked',
        'click [name="record-close-new"]': 'closeNewClicked'
    },
    extendsFrom: 'RowactionField',
    initialize: function (options) {
        this._super("initialize", [options]);
        this.type = 'rowaction';
    },
    closeClicked: function () {
        this._close(false);
    },
    closeNewClicked: function () {
        this._close(true);
    },
    /**
     * Override so we can have a custom hasAccess for closed status
     *
     * @returns {Boolean} true if it has aclAccess and status is not closed
     */
    hasAccess: function() {
        var acl = this._super("hasAccess");
        return acl && this.model.get('status') !== 'Completed';
    },
    _close: function (createNew) {
        var self = this;

        this.model.set('status', 'Completed');
        this.model.save({}, {
            success: function () {
                app.alert.show('close_task_success', {level: 'success', autoClose: true, title: app.lang.get('LBL_TASK_CLOSE_SUCCESS', self.module)});
                if (createNew) {
                    var module = app.metadata.getModule(self.model.module);
                    var prefill = app.data.createBean(self.model.module);
                    prefill.copy(self.model);

                    if (module.fields.status && module.fields.status['default']) {
                        prefill.set('status', module.fields.status['default']);
                    } else {
                        prefill.unset('status');
                    }

                    app.drawer.open({
                        layout: 'create-actions',
                        context: {
                            create: true,
                            model: prefill
                        }
                    }, function () {
                        if (self.parent) {
                            self.parent.render();
                        } else {
                            self.render();
                        }
                    });
                }
            },
            error: function (error) {
                app.alert.show('close_task_error', {level: 'error', title: app.lang.getAppString('ERR_AJAX_LOAD')});
                app.logger.error('Failed to close a task. ' + error);

                // we didn't save, revert!
                self.model.revertAttributes();
            }
        });
    },
    bindDataChange: function () {
        if (this.model) {
            this.model.on("change:status", this.render, this);
        }
    }
})
