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
 * @class View.Views.Base.Tags.CreateView
 * @alias SUGAR.App.view.views.TagsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

    saveAndCreateAnotherButtonName: 'save_create_button',

    /**
     * Add event listener for the save and create another button
     * @override
     * @param options
     */
    initialize: function(options) {
        this._super("initialize", [options]);

        // Uncomment this line to add back Save and Create Another functionality
        //this.context.on('button:' + this.saveAndCreateAnotherButtonName + ':click', this.saveAndCreateAnother, this);
    },

    /**
     * Save and reload drawer to allow another save
     */
    saveAndCreateAnother: function() {
        this.initiateSave(_.bind(function () {
            //reload the drawer
            if (app.drawer) {
                app.drawer.load({
                    layout: 'create',
                    context: {
                        create: true
                    }
                });

                //Change the context on the cancel button
                app.drawer.getActiveDrawerLayout().context.on('button:' + this.cancelButtonName + ':click', this.multiSaveCancel, this);
            }
        }, this));
    },

    /**
     * When cancelling, re-render the Tags listview to show updates from previous save
     */
    multiSaveCancel: function() {
        if (app.drawer) {
            var route = app.router.buildRoute('Tags');
            app.router.navigate(route, {trigger: true});
            app.drawer.close(app.drawer.context);
        }
    }
})
