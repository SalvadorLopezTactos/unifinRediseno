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
/**
 * @class View.Views.Base.DataArchiver.RecordView
 * @alias SUGAR.App.view.views.BaseDataArchiverRecordView
 * @extends View.Views.Base.RecordView
 */
({
    extendsFrom: 'RecordView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.events = _.extend({}, this.events, {
            'click [name="perform_button"]': 'performClicked',
        });
    },

    /**
     * Function that defines behavior when the Archive Now button is clicked on the record view
     */
    performClicked: function() {
        if (this.disposed) {
            return;
        }
        var self = this;
        var url = app.api.buildURL('DataArchiver/' + this.model.id + '/run', null, null, null);
        var data = this.model.attributes;
        self.disposed = true;
        app.api.call('create', url, {}, {
            success: function(results) {
                app.alert.show('success', {
                    level: 'success',
                    autoClose: true,
                    autoCloseDelay: 10000,
                    title: app.lang.get('LBL_ARCHIVE_SUCCESS_TITLE', 'DataArchiver') + ':',
                    messages: data.process_type === 'archive' ? app.lang.get('LBL_ARCHIVE_SUCCESS', 'DataArchiver') :
                        app.lang.get('LBL_DELETE_SUCCESS', 'DataArchiver')
                });
                self.layout.trigger('subpanel_refresh');
            },
            error: function(e) {
                app.alert.show('error', {
                    level: 'error',
                    title: app.lang.get('LBL_ARCHIVE_ERROR', 'DataArchiver') + ':',
                    messages: ['ERR_HTTP_500_TEXT_LINE1', 'ERR_HTTP_500_TEXT_LINE2']
                });
            },
            complete: function() {
                self.disposed = false;
            }
        });
    },
})
