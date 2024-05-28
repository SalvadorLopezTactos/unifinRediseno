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

(function DocuSignConsole(app) {

    app.DocuSign = app.DocuSign || {};

    app.events.on('app:sync:complete', function DocuSignConsoleAppStart() {
        app.events.on('docusign:send:initiate', app.DocuSign.utils.initiateSend, app.DocuSign.utils);

        app.api.call('read', app.api.buildURL('DocuSign', 'getGlobalConfig'), {}, {
            success: function(data) {
                app.DocuSign.showRecipients = data.recipientSelection === 'show';
            }
        });
        app.DocuSign._loadPageUrl = app.api.buildURL('DocuSign', 'loadPage');
    });

    const utils = {
        /**
         * Initiate send
         *
         * @param {Object} payload
         */
        initiateSend: function(payload, step) {
            const ctxModel = app.controller.context;
            const recordViewContext = ctxModel.get('layout') === 'record';
            const homeModule = ctxModel.get('module') === 'Home';

            const showRecipients = !!app.DocuSign.showRecipients && recordViewContext && !homeModule;

            if (_.isUndefined(step) && showRecipients) {
                let contextModule = this._getEnvelopeSourceModule();
                let ctxModelId = this._getEnvelopeSourceModelId();

                let recipientsListContext = {
                    module: 'DocuSignEnvelopes',
                    contextModule: contextModule,
                    ctxModelId: ctxModelId,
                    isMultiSelect: true,
                };
                if (payload.template) {
                    recipientsListContext.templateDetails = payload.template;
                }
                app.drawer.open(
                    {
                        layout: 'recipients-list',
                        type: 'recipients-list',
                        context: recipientsListContext
                    },
                    _.bind(function(selected) {
                        if (selected.closeEvent) {
                            return;
                        }
                        payload.recipients = [];
                        _.each(selected, function(recipient) {
                            payload.recipients.push(recipient);
                        });
                        const nextStep = 'openEnvelope';
                        this.initiateSend(payload, nextStep);
                    }, this)
                );

                return;
            }

            if (_.isUndefined(step) && !showRecipients) {
                const nextStep = 'openEnvelope';
                this.initiateSend(payload, nextStep);

                return;
            }

            if (step === 'openEnvelope') {
                //make the browser consider the action as user not script made
                const tab = window.open(app.DocuSign._loadPageUrl);

                this.openEnvelope(payload, tab);

                return;
            }

            if (step === 'selectTemplate') {
                app.drawer.open(
                    {
                        layout: 'templates-list',
                        type: 'templates-list',
                        context: {
                            module: 'DocuSignEnvelopes',
                        }
                    },
                    _.bind(function(selected) {
                        if (selected.closeEvent) {
                            return;
                        }
                        payload.templateSelected = selected;
                        const step = 'getTemplate';
                        this.initiateSend(payload, step);
                    }, this)
                );

                return;
            }

            if (step === 'getTemplate') {
                app.api.call('create', app.api.buildURL('DocuSign/getTemplateDetails'), {
                    template: payload.templateSelected
                }, {
                    success: _.bind(function(template) {
                        payload.template = template;
                        this.initiateSend(payload);
                    }, this),
                });

                return;
            }
        },

        /**
         * Opens an envelope in DocuSign.
         *
         * If it's not created yet, creates it first, and then it opens
         *
         * @param {Object} payload
         * @param {Object} tab Tab opened for DocuSign
         */
        openEnvelope: function(payload, tab) {
            app.alert.show('load-tab-for-sending', {
                level: 'process',
                title: app.lang.get('LBL_LOADING')
            });

            app.api.call('create', app.api.buildURL('DocuSign/send'), payload, {
                success: _.bind(this.succesGettingEnvelope, this, tab),
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
        },

        /**
         * Success getting envelope to open
         *
         * @param {Object} tab
         * @param {Object} res
         */
        succesGettingEnvelope: function(tab, res) {
            if ((res.status && res.status === 'error') || res.envelopeStatus === 'deleted') {
                var minifiedErrorMessage = res.message.toLowerCase();
                if (minifiedErrorMessage.includes('envelope status in docusign is now')) {
                    if (res.envelopeStatus === 'deleted') {
                        this.confirmDelete(res);
                    } else {
                        this.confirmUpdate(res);
                    }
                } else if (minifiedErrorMessage !== 'cancel' && !_.isEmpty(res.message)) {
                    app.alert.show('ds_error', {
                        level: 'error',
                        messages: res.message,
                        autoClose: false
                    });
                }
                tab.close();
                return;
            }

            tab.location.href = res.url;

            this.listenForTabClosing();
        },

        /**
         * Creates a confirmation alert and ask for permission to delete the draft
         *
         * @param {Object} data
         */
        confirmDelete: function(data) {
            app.alert.show('draft-does-not-exist', {
                level: 'confirmation',
                messages: app.lang.get('LBL_DRAFT_DELETED_CONFIRMATION', 'DocuSignEnvelopes'),
                autoClose: false,
                onConfirm: function() {
                    let removeCallbacks = this.getConfirmationCallbacks({
                        successMessage: app.lang.get('LBL_DRAFT_DELETE_SUCCESS', 'DocuSignEnvelopes'),
                        errorMessage: app.lang.get('LBL_DRAFT_DELETE_ERROR', 'DocuSignEnvelopes')
                    });
                    app.api.call(
                        'create',
                        app.api.buildURL('DocuSign/removeEnvelope'), {
                            envelopeId: data.envelopeId
                        }, removeCallbacks
                    );
                    app.alert.show('envelope-loading', {
                        level: 'process',
                        title: app.lang.get('LBL_LOADING')
                    });
                },
            });
        },

        /**
         * Confirm envelope status update
         *
         * @param {Object} data
         */
        confirmUpdate: function(data) {
            app.alert.show('draft-does-not-exist', {
                level: 'confirmation',
                messages: app.lang.get('LBL_DRAFT_CHANGED_CONFIRM', 'DocuSignEnvelopes', {status: data.status}),
                autoClose: false,
                onConfirm: function() {
                    let updateCallbacks = this.getConfirmationCallbacks({
                        successMessage: app.lang.get('LBL_DRAFT_CHANGED_SUCCESS', 'DocuSignEnvelopes'),
                        errorMessage: app.lang.get('LBL_DRAFT_CHANGED_ERROR', 'DocuSignEnvelopes')
                    });
                    app.api.call(
                        'create',
                        app.api.buildURL('DocuSign/updateEnvelope'), {
                            envelopeId: data.envelopeId
                        }, updateCallbacks
                    );

                    app.alert.show('envelope-loading', {
                        level: 'process',
                        title: app.lang.get('LBL_LOADING')
                    });
                },
            });
        },

        /**
         * Get confirmation callbacks
         *
         * @param {Object} options
         * @return {Object}
         */
        getConfirmationCallbacks: function(options) {
            return {
                success: function(res) {
                    if (res) {
                        app.alert.show('succes-change-envelope', {
                            level: 'success',
                            messages: options.successMessage,
                            autoClose: true
                        });
                        app.events.trigger('docusign:reload');
                    } else {
                        app.alert.show('error-change-envelope', {
                            level: 'error',
                            messages: options.errorMessage,
                            autoClose: true,
                            autoCloseDelay: '10000'
                        });
                    }
                },
                error: function(error) {
                    app.alert.show('error-change-envelope', {
                        level: 'error',
                        messages: error.message
                    });
                },
                complete: function() {
                    app.alert.dismiss('envelope-loading');
                }
            };
        },

        /**
         * Listen for tab closing
         */
        listenForTabClosing: function() {
            $(window).on('storage.docusignAction', function(e) {
                if (e.originalEvent.key !== 'docusignAction') {
                    return;
                }
                const action = e.originalEvent.newValue;
                if (!action) {
                    return;
                }

                $(window).off('storage.docusignAction');

                app.events.trigger('docusign:send:finished');

                if (app.controller.context.get('module') === 'pmse_Inbox' &&
                    app.controller.layout.name === 'show-case') {
                    return;
                }

                app.events.trigger('docusign:reload');
            });
        },

        /**
         * Get envelope source module
         *
         * @return {string}
         */
        _getEnvelopeSourceModule: function() {
            var module = app.controller.context.get('module');

            if (module === 'pmse_Inbox' && app.controller.layout.name === 'show-case') {
                try {
                    var sourceModel = app.controller.layout._components[0]
                        .getComponent('sidebar')
                        .getComponent('main-pane')
                        .model;

                    return sourceModel.get('_module');
                } catch (showCaseError) {
                    app.log.error(`_getEnvelopeSourceModule. show-case layout error: ${showCaseError}`);
                }
            }

            return module;
        },

        /**
         * Get envelope source id
         *
         * @return {string}
         */
        _getEnvelopeSourceModelId: function() {
            var module = app.controller.context.get('module');
            var modelId = app.controller.context.get('modelId');

            if (module === 'pmse_Inbox' && app.controller.layout.name === 'show-case') {
                try {
                    var sourceModel = app.controller.layout._components[0]
                        .getComponent('sidebar')
                        .getComponent('main-pane')
                        .model;

                    return sourceModel.get('id');
                } catch (showCaseError) {
                    app.log.error(`_getEnvelopeSourceModelId. show-case layout error: ${showCaseError}`);
                }
            }

            return modelId;
        }

    };

    app.DocuSign.utils = utils;
})(SUGAR.App);
