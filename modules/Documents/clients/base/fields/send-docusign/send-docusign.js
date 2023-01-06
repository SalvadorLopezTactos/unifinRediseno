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
 * @class View.Fields.Base.Documents.SendDocusignField
 * @alias SUGAR.App.view.fields.BaseDocumentsSendDocusignField
 * @extends View.Fields.Base.RowactionField
 */
 ({
    extendsFrom: 'RowactionField',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        options.def.events = _.extend({}, options.def.events, {
            'click [name=send-docusign]': 'sendToDocuSign'
        });

        this._super('initialize', [options]);

        this.type = 'rowaction';
    },

    /**
     * Initiate the send process, by opening the tab
     */
    sendToDocuSign: function(e) {
        app.alert.show('load-tab-for-sending', {
            level: 'process',
            title: app.lang.get('LBL_LOADING')
        });

        var controllerCtx = app.controller.context;
        var controllerModel = controllerCtx.get('model');
        var module = controllerModel.get('_module');
        var modelId = controllerModel.get('id');
        var documents = [this.model.id];
        var recipients = [];

        var data = {
            returnUrlParams: {
                parentRecord: module,
                parentId: modelId,
                token: app.api.getOAuthToken()
            },
            recipients: recipients,
            documents: documents
        };

        var docusignPageURL = app.api.buildURL('DocuSign', 'loadPage');
        var docusignTab = window.open(docusignPageURL);//makes the browser consider the action as user not script made

        app.api.call('create', app.api.buildURL('DocuSign/send'), data, {
            success: _.bind(function viewLoaded(res) {
                if ((res.status && res.status === 'error') || res.envelopeStatus === 'deleted') {
                    var minifiedErrorMessage = res.message.toLowerCase();
                    if (minifiedErrorMessage === 'cancel') {
                        // do nothing
                    } else if (/envelope status in docusign is now/.test(minifiedErrorMessage)) {
                        if (res.envelopeStatus === 'deleted') {
                            this.confirmDelete(res);
                        } else {
                            this.confirmEnvelopeStatusUpdate(res);
                        }
                    } else {
                        if (!_.isEmpty(res.message)) {
                            app.alert.show('ds_error', {
                                level: 'error',
                                messages: res.message,
                                autoClose: false
                            });
                        }
                    }
                    docusignTab.close();
                    return;
                }

                docusignTab.location.href = res.url;

                $(window).on('storage.docusignAction', function checkDocuSignActionOnStorageChange(e) {
                    if (e.originalEvent.key !== 'docusignAction') {
                        return;
                    }
                    var action = e.originalEvent.newValue;
                    if (!action) {
                        return;
                    }

                    $(window).off('storage.docusignAction');

                    if (app.controller.context.attributes.module === 'pmse_Inbox' &&
                        app.controller.layout.name === 'show-case') {
                        app.router.goBack();
                    } else {
                        app.events.trigger('docusign:reload');
                    }
                });
            }, this),
            error: function(error) {
                app.alert.show('error-loading-tab', {
                    level: 'error',
                    messages: error.message
                });
            },
            complete: function() {
                app.alert.dismiss('load-tab-for-sending');
            }
        });
    }
})
