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
    var _oldMetadataSet = app.metadata.set;
    /**
     * Hack the metadata to fix teamset type
     * @param data
     */
    app.metadata.set = function(data){
        _.each(data.modules, function(module){
            if (!_.isUndefined(module.fields)) {
                var field = module.fields.team_name;
                if (field) {
                    delete field.len;
                    field.type = "teamset";
                }

                _.each(module.fields,function(field) {
                    // Metadata is invalid for relate fields like "account_id"
                    // In certain cases, their type is "relate" and source is "non-db"
                    // See bug 60632
                    if  (field.name &&
                        (field.type === "relate") &&
                        // ends with "_id"
                        (field.name.length > 2 &&
                            (field.name.length -
                             field.name.lastIndexOf("_id")) === 3))
                    {
                        field.type = "id";
                        delete field.source;
                    }
                });
            }
        }, this);
        _oldMetadataSet.apply(this, arguments);
    };
})(SUGAR.App);
