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

module.exports = function(config) {
    var sauceLaunchers = {
        sl_safari: {
            base: 'SauceLabs',
            browserName: 'safari',
            platform: 'OS X 10.11',
            version: '9.0'
        }
    };

    config.set({
        basePath: '../',
        frameworks: [
            'jasmine'
        ],
        plugins: [
            'karma-jasmine',
            'karma-chrome-launcher',
            'karma-firefox-launcher',
            'karma-phantomjs-launcher',
            'karma-safari-launcher',
            'karma-sauce-launcher',
            'karma-coverage',
            'karma-junit-reporter'
        ],
        proxies: {
            // FIXME we need a better way to load fixtures that is stable
            // it should be:
            // '/tests': '/base/tests',
            // so that we can provide all test requests in the correct /base/ path
            '/fixtures': '/base/tests/fixtures',
            '/sidecar/tests/fixtures': '/base/tests/fixtures',
            '/sidecar/lib': '/base/lib',
            '/src': '/base/src'
        },
        reportSlowerThan: 500,
        browserDisconnectTimeout: 5000,
        browserDisconnectTolerance: 5,
        sauceLabs: {
            testName: 'Safari CI Unit Tests'
        },
        customLaunchers: sauceLaunchers
    });
};
