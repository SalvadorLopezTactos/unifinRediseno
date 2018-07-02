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
 * @class Data.OfflineBean
 * @alias SUGAR.App.Offline.Bean
 * @extends Data.Bean
 */
(function(app) {

    var _updateProperty = function(bean, prop, attr, obj) {
        //"use strict";
        if (prop in obj) {
            bean[attr] = obj[prop];
            obj[prop] = undefined;
            // TODO: delete doesn't work because the obj is frozen
            // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Object/getOwnPropertyDescriptor
            //delete obj[prop];
        }
        return false;
    };

    app.Offline.Bean = app.Bean.extend({

        initialize: function(attrs) {
            this.syncState = null;
            this.modifiedAt = null;
            return app.Bean.prototype.initialize.call(this, attrs);
        },

        set: function(attrs, options) {
            // I want to handle syncState and modifiedAt separately from the attrs hash
            // TODO: Am I overcomplicating things?
            if (attrs) {
                _updateProperty(this, '_sync_state', 'syncState', attrs);
                _updateProperty(this, '_modified_at', 'modifiedAt', attrs);
            }
            return app.Bean.prototype.set.call(this, attrs, options);
        },

        toString: function() {
            return app.Bean.prototype.toString.call(this) + " [" + this.syncState + "/" + this.modifiedAt + "]";
        }

    });

})(SUGAR.App);
