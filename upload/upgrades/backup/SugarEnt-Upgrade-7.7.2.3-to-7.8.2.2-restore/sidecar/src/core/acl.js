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
(function(app) {
    /**
     * Checks ACL for modules and fields.
     *
     * @class Core.Acl
     * @alias SUGAR.App.acl
     * @singleton
     */
    app.augment("acl", {

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
            "view": "read",
            "readonly": "read",
            "edit": "write",
            "detail": "read",
            "list": "read",
            "disabled": "write"
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
         * Checks ACLs to see if access is given to action.
         *
         * @param {String} action Action name.
         * @param {Object} acls ACL hash.
         * @return {Boolean} Flag indicating if the current user has access to the given action.
         */        
        _hasAccess: function(action, acls) {
            var access;

            if (acls.access === 'no') {
                access = 'no';
            }
            else {
                access = acls[action];
            }

            return access !== 'no';
        },

        /**
         * Checks ACLs to see if access is given to action on a given field.
         *
         * @param {String} action Action name.
         * @param {Object} acls ACL hash.
         * @param {String} field Name of the model field.
         * @return {Boolean} Flag indicating if the current user has access to the given action.
         */
        _hasAccessToField: function(action, acls, field) {
            var access;

            action = this.action2permission[action] || action;
            if(acls.fields[field] && acls.fields[field][action]) {
                access = acls.fields[field][action];
            }

            return access !== "no";
        },

        /**
         * Checks acls to see if the current user has access to action on a given module's field.
         *
         * @param {String} action Action name.
         * @param {Object} module Module name.
         * @param {String} ownerId(optional) ID of the record's owner (`assigned_user_id` attribute).
         * @param {String} field(optional) Name of the model field.
         * @param {String} recordAcls(optional) a record's acls.
         * @return {Boolean} Flag indicating if the current user has access to the given action.
         */
        hasAccess: function(action, module, ownerId, field, recordAcls) {
            //TODO Also add override for app full admins remember to add a test this means you
            var acls = app.user.getAcls()[module];
            var access = true;
            if(acls || recordAcls) {
                acls = acls || {};
                if (recordAcls) { // A record's acls take precedence over the module acls. If they are available, merge the acls.
                    acls = app.utils.deepCopy(acls); // deep clone acls
                    acls.fields = acls.fields || {};
                    _.extend(acls.fields, recordAcls.fields); // merge the field acls
                    var fields = acls.fields;
                    _.extend(acls, recordAcls); // merge record's acls with the module acls (shallow)
                    acls.fields = fields; // use the merged field acls

                }
                access = this._hasAccess(action, acls);
                if(field && acls.fields && access) {
                    // see if we have access to the field
                    access = this._hasAccessToField(action, acls, field);
                    // if the field is in a group, see if we have access to the group
                    var moduleMeta = app.metadata.getModule(module);
                    var fieldMeta = (moduleMeta && moduleMeta.fields) ? moduleMeta.fields[field] : null;
                    if (access && fieldMeta && fieldMeta.group) {
                        access = this._hasAccessToField(action, acls, fieldMeta.group);
                    }
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
            var id, module, assignedUserId, acls,
                access = true;
            if (model) {
                id = model.id;
                module = model.module;
                assignedUserId = model.original_assigned_user_id || model.get("assigned_user_id");
                acls = model.get('_acl') || { fields: {} };
            }

            if (action == 'edit' && !id) {
                action = 'create';
            }

            if (access === true) {
                access = this.hasAccess(action, module, assignedUserId, field, acls);
            }

            return access;
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
