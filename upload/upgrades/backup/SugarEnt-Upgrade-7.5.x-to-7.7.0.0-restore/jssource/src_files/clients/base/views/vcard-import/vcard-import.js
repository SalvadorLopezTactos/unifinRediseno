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
/**
 * @class View.Views.Base.VcardImportView
 * @alias SUGAR.App.view.views.BaseVcardImportView
 * @extends View.View
 */
({
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        this.context.off("vcard:import:finish", null, this);
        this.context.on("vcard:import:finish", this.importVCard, this);
    },

    /**
     * {@inheritdocs}
     *
     * Sets up the file field to edit mode
     *
     * @param {View.Field} field
     * @private
     */
    _renderField: function(field) {
        app.view.View.prototype._renderField.call(this, field);
        if (field.name === 'vcard_import') {
            field.setMode('edit');
        }
    },

    importVCard: function() {
        var self = this,
            vcardFile = $('[name=vcard_import]');

        if (_.isEmpty(vcardFile.val())) {
            app.alert.show('error_validation_vcard', {
                level: 'error',
                messages: 'LBL_EMPTY_VCARD'
            });
        } else {
            app.file.checkFileFieldsAndProcessUpload(self, {
                    success: function (data) {
                        var route = app.router.buildRoute(self.module, data.vcard_import);
                        app.router.navigate(route, {trigger: true});
                        app.alert.show('vcard-import-saved', {
                            level: 'success',
                            messages: app.lang.get('LBL_IMPORT_VCARD_SUCCESS', self.module),
                            autoClose: true
                        });
                    },
                    error: function(error) {
                        app.alert.show('error_validation_vcard', {
                            level: 'error',
                            messages: app.lang.get('TPL_IMPORT_VCARD_FAILURE', self.module, {module: self.module})
                        });
                    }
                },
                {deleteIfFails: true, htmlJsonFormat: true}
            );
        }
    }
})
