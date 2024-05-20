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
 * @class View.Views.Base.Documents.DocusignDocumentsHeaderView
 * @alias SUGAR.App.view.views.BaseDocumentsDocusignDocumentsHeaderView
 * @extends View.Views.Base.View
 */
({
    className: 'docusign-documents-header',

    events: {
        'click a[name=clear_button]': 'clear',
        'click .addDocument': 'openDocumentsSelectionList',
        'click .sendEnvelope': 'sendToDocuSign'
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
    },

    /**
     * Clear collection
     */
    clear: function() {
        this.collection.reset();
    },

    /**
     * Open documents selection list
     */
    openDocumentsSelectionList: function() {
        app.drawer.open({
            layout: 'multi-selection-list',
            context: {
                module: 'Documents',
                isMultiSelect: true
            }
        }, _.bind(function(models) {
            if (!models) {
                return;
            }

            this.collection.add(models);
        }, this));
    },

    /**
     * Send to DocuSign
     */
    sendToDocuSign: function() {
        this.context.parent.trigger('sendDocumentsToDocuSign');
    }
})
