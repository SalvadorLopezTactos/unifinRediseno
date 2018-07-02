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

    var _db = null;
    var _executeStatements = function(tx, statements) {
        _.each(statements, function(stmt) {
            app.logger.trace(stmt);
            tx.executeSql(stmt);
        });
    };

    var _executeSql = function(sql, params, success, failure) {
        _db.transaction(function(tx) {
            app.logger.trace(sql);
            _preprocessParams(params);
            tx.executeSql(sql, params, success, failure);
        });
    };

    var _preprocessParams = function(params) {
        _.each(params, function(value, key) {
            if (_.isBoolean(value)) {
                params[key] = value ? 1 : 0;
            }
        });
    };

    /**
     * WebSQL wrapper.
     * @ignore
     */
    app.augment("webSqlAdapter", {

        open: function(name, version, size) {
            if (_db) return;
            _db = window.openDatabase(name, version, name, size);
            if (!_db) throw new Error('"openDatabase" returned nothing');
            app.logger.debug('Opened database ' + name + ' ' + version + ' (' + size + ' bytes)');
        },

        executeInTransaction: function(callback, success, failure) {
            _db.transaction(callback, failure, success);
        },

        executeStatements: function(tx, statements, success, failure) {
            if (tx) {
                _executeStatements(tx, statements);
            }
            else {
                _db.transaction(function(tx) {
                    _executeStatements(tx, statements);
                }, failure, success);
            }
        },

        executeStatement: function(tx, stmt, params) {
            app.logger.trace(stmt);
            _preprocessParams(params);
            tx.executeSql(stmt, params);
        },

        executeSql: function(tx, sql, params, success, failure) {
            (tx ?
                this.executeStatement(tx, sql, params) :
                _executeSql(sql, params, success, failure));
        }

    });

})(SUGAR.App);