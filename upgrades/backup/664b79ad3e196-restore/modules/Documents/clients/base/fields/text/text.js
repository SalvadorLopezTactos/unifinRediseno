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
 * @class View.Fields.Base.Documents.TextField
 * @alias SUGAR.App.view.fields.BaseDocumentsTextField
 * @extends View.Fields.Base.TextField
 */
({
    extendsFrom: 'TextField',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        // The revision field should only be editable when the Document is first being created
        if (options.def.name === 'revision' && options.view.action === 'create') {
            options.def.readonly = false;
        }

        this._super('initialize', [options]);
    }
})
