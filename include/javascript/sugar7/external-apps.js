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
(function(app) {
    var findDashboardPreviewLayout = function(meta, layoutName, targetLayout, layoutMeta) {
        if (meta.name && meta.name === layoutName) {
            targetLayout = meta;
            return targetLayout;
        }

        if (_.isArray(meta)) {
            var len = meta.length;
            for (var i = 0; i < len; i++) {
                if (_.isArray(meta[i]) || _.isObject(meta[i])) {
                    targetLayout = findDashboardPreviewLayout(meta[i], layoutName, targetLayout, layoutMeta);
                }
                if (!_.isEmpty(targetLayout)) {
                    return targetLayout;
                }
            }
        } else {
            for (var prop in meta) {
                if (_.isArray(meta[prop]) || _.isObject(meta[prop])) {
                    targetLayout = findDashboardPreviewLayout(meta[prop], layoutName, targetLayout, layoutMeta);

                    if (!_.isEmpty(targetLayout)) {
                        return targetLayout;
                    }
                }
            }
        }
    };

    var addCompToLayout = function(metadata, targetModule, targetLayout, def) {
        var modMeta = metadata.modules[targetModule];
        var layoutPieces = targetLayout.split('-');
        var hasLayoutInModule;
        var dashPrevLayout;
        var meta;
        var layoutName;

        if (modMeta) {
            modMeta.layouts = modMeta.layouts || {};
            // try to get the metadata for the specific module layout
            meta = modMeta.layouts[targetLayout];
            hasLayoutInModule = !!meta;

            // if the targetLayout has 2 pieces "extra-info", "record-dashboard", etc
            // and the second piece is either "dashboard" or "preview"
            // we need to handle these components in a different way to "extra-info" components
            if (layoutPieces.length === 2 && (layoutPieces[1] === 'dashboard' || layoutPieces[1] === 'preview')) {
                // if the first piece of he layout is "list" then we want the "records" layout
                // otherwise we want the "record" layout
                layoutName = layoutPieces[0] === 'list' ? 'records' : 'record';

                // try to get layout for the module. if the layout does not exist
                // getLayout will return us the base/core layoutName
                meta = app.metadata.getLayout(targetModule, layoutName);

                // recurse through the records or record layout metadata
                // to find "dashboard-pane" or "preview-pane" layout
                dashPrevLayout = findDashboardPreviewLayout(meta, layoutPieces[1] + '-pane', {});

                if (dashPrevLayout) {
                    // we've found the "dashboard-pane" or "preview-pane" layout
                    // now push the new component def into its components
                    dashPrevLayout.components.push(def);

                    // begin building the component layout structure we need to push back to metadata
                    if (!modMeta.layouts[layoutName]) {
                        modMeta.layouts[layoutName] = {};
                    }
                    if (!modMeta.layouts[layoutName].meta) {
                        modMeta.layouts[layoutName].meta = {};
                    }
                    if (!modMeta.layouts[layoutName].meta.components) {
                        modMeta.layouts[layoutName].meta.components = [];
                    }

                    metadata.modules[targetModule].layouts[layoutName].meta.components = meta.components;

                    // Set the whole metadata block back onto the app so it can be fetched again
                    // by app.metadata.getLayout if there are multiple dashboard/preview components
                    // that need to be set here
                    App.metadata.set(metadata);
                } else {
                    // wat?! somehow there's no dashboard-pane or preview-pane component in the layout
                    App.logger.warn('The ' + layoutName + ' layout for the ' + targetModule + ' does not contain a ' +
                        layoutPieces[1] + '-pane component inside the layout.');
                }
            } else if (!hasLayoutInModule) {
                // Merge with the global metadata before modifying if the module
                // didn't originally specify a config for this layout.
                modMeta.layouts[targetLayout] = {
                    meta: app.metadata.getLayout('', targetLayout) || {components: []}
                };

                modMeta.layouts[targetLayout].meta.components.push(def);
            } else {
                if (!meta.meta) {
                    meta.meta = {};
                }
                if (!meta.meta.components) {
                    meta.meta.components = [];
                }

                meta.meta.components.push(def);
            }
        }
    };

    app.metadata.addSyncTask(function(metadata, options) {
        if (!app.config.catalogEnabled) {
            // if Sugar Catalog is not enabled, stop execution
            return;
        }
        var catalogUrl = app.config.catalogUrl;

        if (options.getPublic) {
            // skipping external app sync for public metadata
            return Promise.resolve();
        }

        if (catalogUrl && catalogUrl !== '') {
            catalogUrl = catalogUrl.match(/^.+\:\/\/[^\/]+/)[0] + '/catalog?isAuthorized=true';

            var getCatalog = function(onSuccess, onError, onLogin) {
                $.ajax({
                    url: catalogUrl,
                    xhrFields: {
                        withCredentials: true,
                        cors: true
                    },
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    crossDomain: true,
                    success: function(catalog) {
                        if (catalog.loginRedirect && onLogin) {
                            onLogin(catalog.loginRedirect);
                        } else {
                            onSuccess(catalog);
                        }
                    },
                    error: function(error) {
                        onError(error);
                    }
                });
            };

            return new Promise(function(res, error) {
                var fetchAppLayout = function(app) {
                    $.ajax({
                        url: app.src,
                        dataType: 'json',
                        xhrFields: {
                            withCredentials: true
                        },
                        crossDomain: true,
                        contentType: 'application/json; charset=utf-8',
                        mode: 'cors',
                        success: function(catalog) {
                            _.each(catalog.layouts, function(def) {
                                if (def.module && def.layout) {
                                    var catalogEnv = {};
                                    if (catalog.env) {
                                        catalogEnv = catalog.env;
                                    }
                                    addCompToLayout(metadata, def.module, def.layout, {
                                        'view': {
                                            'type': 'external-app',
                                            'name': catalog.name,
                                            'src': catalog.src,
                                            'srn': catalog.srn,
                                            'env': catalogEnv
                                        }
                                    });
                                }
                            });
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                };

                var handleCatalog = function(catalog) {
                    _.each(catalog.apps, function(app) {
                        fetchAppLayout(app);
                    });

                    res();
                };

                var onError = function(err) {
                    app.logger.error(err.message);
                    res();
                };

                getCatalog(handleCatalog, onError, function(loginUrl) {
                    var iframe = document.createElement('iframe');
                    var cleanup = function() {
                        iframe.parentElement.removeChild(iframe);
                        window.removeEventListener('message', eventCallback);
                    };
                    var eventCallback = function(event) {
                        // TODO: Verify the catalog service origin instead of assuming any
                        // origin besides the one we are on is correct

                        var iframeOrigin = window.location.href.match(/^.+\:\/\/[^\/]+/)[0];
                        if (event.origin === iframeOrigin) {
                            cleanup();
                            // After the iframe event callback, we need to load the catalog again
                            // but this time expect to get data.
                            getCatalog(handleCatalog, onError, function(url) {
                                var err = 'Unable to authenticate with catalog service: Second Login URL:' + url;
                                app.logger.error(err);
                                res();
                            });
                        }
                    };

                    iframe.onload = function() {
                        console.log('loaded before we got the event ', arguments);
                        cleanup();
                        res();
                    };
                    iframe.src = loginUrl;
                    iframe.style = 'display:none;\n' +
                        'position: absolute;\n' +
                        'width: 500px;\n' +
                        'height: 500px;\n' +
                        'top: calc(50% - 250px);\n' +
                        'left: calc(50% - 250px);';

                    window.addEventListener('message', eventCallback);
                    document.body.appendChild(iframe);
                });
            });
        }
        return Promise.resolve();
    });
})(SUGAR.App);
