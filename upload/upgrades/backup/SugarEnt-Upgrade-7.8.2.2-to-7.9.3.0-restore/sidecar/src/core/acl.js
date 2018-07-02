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
    /**
     * Checks ACL for modules and fields.
     *
     * @class Core.Acl
     * @alias SUGAR.App.acl
     * @singleton
     */
    app.augment('acl', {

        /**
         * Cache for {@link Core.Acl#hasAccessToAny} function.
         * @property {Object} _accessToAny
         * @private
         */
        _accessToAny: {},

        /**
         * Dictionary that maps actions to permissions.
         * @property {Object}
         */
        action2permission: {
            'view': 'read',
            'readonly': 'read',
            'edit': 'write',
            'detail': 'read',
            'list': 'read',
            'disabled': 'write',
        },

        /**
         * Initialization
         *
         * Setup handler on `app:sync:complete` event to clear cache.
         * @param {App} app
         */
        init: function(app) {
            if (app) {
                app.events.on('app:sync:complete', this.clearCache, this);
            }
        },

        /**
         * Clear cached variables for acl.
         */
        clearCache: function() {
            this._accessToAny = {};
        },

        /**
         * ACL helper to convert ACLs data into booleans.
         *
         * @param {string} action Action name.
         * @param {Object} acls ACL hash.
         * @return {boolean} Flag indicating if the current user has access.
         */
        _hasAccess: function (action, acls) {
            var access;

            if (acls.access === 'no') {
                access = 'no';
            } else {
                access = acls[action];
            }

            return access !== 'no';
        },

        /**
         * ACL helper to convert ACLs data on fields into booleans.
         *
         * @param {string} action Action name.
         * @param {Object} acls ACL hash.
         * @param {string} field Name of the Module's field.
         * @return {boolean} Flag indicating if the current user has access.
         */
        _hasAccessToField: function (action, acls, field) {
            var access;

            action = this.action2permission[action] || action;
            if (acls.fields[field] && acls.fields[field][action]) {
                access = acls.fields[field][action];
            }

            return access !== 'no';
        },

        /**
         * Checks ACLs to see if the current user has access to action on a
         * given module or record.
         *
         * @param {string} action Action name.
         * @param {string} module Module name.
         * @param {Object} [options] Options.
         * @param {string} [options.field] Name of the field to check access.
         * @param {string} [options.acls] Record's ACLs that take precedence
         *   over the module's ACLs. These are normally supplied by the server
         *   as part of the data response in `_acl`.
         * @return {boolean} Flag indicating if the current user has access.
         */
        hasAccess: function (action, module, options) {
            var field;
            var recordAcls;

            if (!_.isObject(options)) {
                // TODO: Throw deprecation warning and remove this code.
                field = arguments[3];
                recordAcls = arguments[4];
            } else {
                field = options.field;
                recordAcls = options.acls;
            }

            var acls = app.user.getAcls()[module];
            if (!acls && !recordAcls) {
                return true;
            }

            acls = acls || {};
            if (recordAcls) {
                var fieldAcls = _.extend({}, acls.fields, recordAcls.fields);
                acls = _.extend({}, acls, recordAcls);
                acls.fields = fieldAcls;
            }

            var access = this._hasAccess(action, acls);
            if (access && field && acls.fields) {
                access = this._hasAccessToField(action, acls, field);

                // if the field is in a group, see if we have access to the group
                var moduleMeta = app.metadata.getModule(module);
                var fieldMeta = (moduleMeta && moduleMeta.fields) ? moduleMeta.fields[field] : null;
                if (access && fieldMeta && fieldMeta.group) {
                    access = this._hasAccessToField(action, acls, fieldMeta.group);
                }
            }

            return access;
        },

        /**
         * Checks ACLs to see if the current user has access to action on a given model's field.
         *
         * @param {String} action Action name.
         * @param {Object} model(optional) Model instance.
         * @param {String} field(optional) Name of the model field.
         * @return {Boolean} Flag indicating if the current user has access to the given action.
         */
        hasAccessToModel: function(action, model, field) {
            var id;
            var module;
            var assignedUserId;
            var acls;

            if (model) {
                id = model.id;
                module = model.module;
                assignedUserId = model.original_assigned_user_id || model.get("assigned_user_id");
                acls = model.get('_acl') || { fields: {} };
            }

            if (action == 'edit' && !id) {
                action = 'create';
            }

            return this.hasAccess(action, module, assignedUserId, field, acls);
        },

        /**
         * Checks ACLs to see if the current user has access to any module with defined action.
         *
         * @param {String} action Action name.
         * @return {Boolean} Flag indicating if the current user has access to the given action.
         *
         *     // Check whether user has `admin` access for any module.
         *     app.acl.hasAccessToAny('admin');
         *
         *     // Check whether user has `developer` access for any module.
         *     app.acl.hasAccessToAny('developer');
         */
        hasAccessToAny: function(action) {
            if (_.isUndefined(this._accessToAny[action])) {
                this._accessToAny[action] = _.some(app.user.getAcls(), function(obj, module) {
                    return this.hasAccess(action, module);
                }, this);
            }
            return this._accessToAny[action];
        }
    }, true);

})(SUGAR.App);
