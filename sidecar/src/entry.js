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

require('script!crosstab');

var SUGAR = require('imports?SUGAR=>window.SUGAR!exports?SUGAR!app.js');

// globalize these for Mango bwc:
require('script!jquery/dist/jquery.min.js');
require('script!underscore/underscore-min.js');
require('script!backbone/backbone.min.js');
require('script!handlebars/dist/handlebars.min.js');
window.async = require('async');
require('script!moment/min/moment.min.js');
require('script!store/store.min.js');
window.SUGAR = SUGAR;

require('script!jquery/jquery-migrate-1.2.1.min.js');
require('script!jquery-ui/js/jquery-ui-1.11.4.custom.min.js');
require('script!jquery/jquery.iframe.transport.js');

require('script!php-js/version_compare.js');

require('script!big.js');

require('imports?SUGAR=>window.SUGAR!sugarapi/sugarapi.js');
require('utils/utils.js');
require('utils/date.js');
require('utils/math.js');
require('utils/currency.js');
require('core/before-event.js');
require('core/cache.js');
require('core/cookie.js');
require('core/events.js');
require('core/error.js');
require('view/template.js');
require('core/context.js');
require('core/controller.js');
require('core/router.js');
require('core/language.js');
require('core/metadata-manager.js');
require('core/acl.js');
require('core/user.js');
require('core/plugin-manager.js');
require('utils/logger.js');
require('data/bean.js');
require('data/bean-collection.js');
require('data/mixed-bean-collection.js');
require('data/data-manager.js');
require('data/validation.js');
require('view/hbs-helpers.js');
require('view/view-manager.js');
require('view/component.js');
require('view/view.js');
require('view/field.js');
require('view/layout.js');
require('view/alert.js');
require('sugaranalytics/sugaranalytics.js');
require('sugaranalytics/googleanalyticsconnector.js');
require('sugar/sugar.liverelativedate.js');
require('utils/underscore-mixins.js');
