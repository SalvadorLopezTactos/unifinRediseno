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

[
    {pattern: 'tests/fixtures/*.json', included: false, served: true, watched: false},
    {pattern: 'lib/jasmine/jasmine.css', included: false, served: true, watched: false},

    'lib/backbone/underscore.js',
    'lib/jquery/jquery.min.js',
    'lib/jquery-ui/js/jquery-ui-1.11.4.custom.min.js',
    'lib/backbone/backbone.js',
    'lib/handlebars/handlebars.js',
    'lib/sugarapi/sugarapi.js',
    'lib/sugar/sugar.searchahead.js',
    'lib/stash/stash.js',
    'lib/async/async.js',
    'lib/php-js/version_compare.js',
    'lib/momentjs/min/moment.min.js',
    'lib/mousetrap/mousetrap.min.js',
    'lib/sinon/sinon.js',
    'lib/jasmine-sinon/jasmine-sinon.js',
    //'lib/jasmine-jquery/jasmine-jquery.js',

    'src/app.js',
    'src/core/events.js',
    'src/core/controller.js',
    'src/core/*.js',
    'src/data/bean-collection.js',
    'src/data/mixed-bean-collection.js',
    'src/data/*.js',
    // offline folder wasn't included in jasmine runner
    // 'src/offline/*.js',
    'src/utils/*.js',
    'src/view/view-manager.js',
    'src/view/component.js',
    'src/view/view.js',
    'src/view/*.js',

    'lib/sugaranalytics/sugaranalytics.js',
    'lib/sugaranalytics/googleanalyticsconnector.js',
    'lib/sugaraccessibility/sugaraccessibility.js',
    'lib/sugaraccessibility/click.js',
    'lib/sugaraccessibility/label.js',

    'tests/fixtures/*.js',

    'tests/config.js',
    'tests/spec-helper.js'
]
