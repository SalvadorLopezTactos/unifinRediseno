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
 * @class View.Views.Base.DocuSignEnvelopes.RecipientSelectionHeaderpaneView
 * @alias SUGAR.App.view.views.BaseDocuSignEnvelopesRecipientSelectionHeaderpaneView
 * @extends View.Views.Base.View
 */
({
    initialize: function(options) {
        if (!options.context.get('templateDetails')) {
            options.meta.buttons = _.filter(options.meta.buttons, function(button) {
                return button.name !== 'back_button';
            });
        }

        this._super('initialize', [options]);
    },

    /**
     * @inheritdoc
     */
    _renderHtml: function() {
        this._super('_renderHtml');

        this.layout.off('selection:closedrawer:fire');
        this.layout.once(
            'selection:closedrawer:fire',
            _.once(
                _.bind(function closeDrawer() {
                    this.$el.off();
                    app.drawer.close({
                        closeEvent: true
                    });
                }, this)
            )
        );

        if (this.context.get('templateDetails')) {
            this.layout.off('selection:back:fire');
            this.layout.once(
                'selection:back:fire',
                _.once(
                    _.bind(function backClicked() {
                        this.$el.off();

                        app.drawer.close({
                            closeEvent: true
                        });

                        const openTemplatesDrawer = _.debounce(function() {
                            const controllerCtx = app.controller.context;
                            const controllerModel = controllerCtx.get('model');
                            const module = controllerModel.get('_module');
                            const modelId = controllerModel.get('id');
                            let documentCollection = app.controller.context.get('documentCollection');
                            if (documentCollection) {
                                documents = _.pluck(documentCollection.models, 'id');
                            } else {
                                documents = [];
                            }

                            const data = {
                                returnUrlParams: {
                                    parentRecord: module,
                                    parentId: modelId,
                                    token: app.api.getOAuthToken()
                                },
                                documents: documents
                            };
                            const step = 'selectTemplate';
                            app.events.trigger('docusign:send:initiate', data, step);
                        }, 1000);
                        openTemplatesDrawer();
                    }, this)
                )
            );
        }
    },
});
