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
 * @class View.Views.Base.BaseeditmodalView
 * @alias SUGAR.App.view.views.BaseBaseeditmodalView
 * @extends View.View
 */
({
    events: {
        'click [name=save_button]': 'saveButton',
        'click [name=cancel_button]': 'cancelButton'
    },
    // Delegate events
    saveButton: function() {
        var self = this,
            createModel = this.context.get('createModel');

        self.$('[name=save_button]').attr('data-loading-text', app.lang.get('LBL_LOADING'));
        self.$('[name=save_button]').button('loading');

        self.processModel(createModel);

        // saves the related bean
        createModel.save(null, {
            relate: true,
            fieldsToValidate: this.getFields(this.module),
            success: function() {
                var view = _.extend({}, self, {model: createModel});
                app.file.checkFileFieldsAndProcessUpload(view, {
                    success: function() { self.saveComplete(); }
                });
            },
            error: function() {
                self.resetButton();
            }

        });
    },
    /**
     * Preprocess the model before saving. This function is here so that children may override it as necessary.
     * @param {object} model
     */
    processModel: function(model) {

    },
    cancelButton: function() {
        if (Modernizr.touch) {
            app.$contentEl.removeClass('content-overflow-visible');
        }
        this.$('.modal').modal('hide').find('form').get(0).reset();
        if (this.context.has('createModel')) {
            this.context.get('createModel').clear();
        }
    },
    saveComplete: function() {
        //reset the form
        this.$('.modal').modal('hide').find('form').get(0).reset();
        //reset the `Save` button
        this.resetButton();
        //add the new model to the collection
        this.collection.fetch({relate: true});
    },
    resetButton: function() {
        this.$('[name=save_button]').button('reset');
    }
})
