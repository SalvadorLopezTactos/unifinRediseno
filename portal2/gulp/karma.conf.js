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

module.exports = function(config) {
    config.set({
        basePath: '../../',
        frameworks: [
            'jasmine'
        ],
        plugins: [
            'karma-chrome-launcher',
            'karma-coverage',
            'karma-firefox-launcher',
            'karma-jasmine',
            'karma-junit-reporter',
            'karma-phantomjs-launcher',
            'karma-safari-launcher'
        ],
        proxies: {
            '/clients': '/base/clients',
            '/fixtures': '/base/tests/fixtures',
            '/tests/modules': '/base/tests/modules',
            '/include': '/base/include',
            '/modules': '/base/modules',
            '/portal2': '/base/portal2'
        },
        reportSlowerThan: 500,
        browserDisconnectTimeout: 5000,
        browserDisconnectTolerance: 5,
    });
};
