/**
 * The file used to view record list for Survey module.
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
({
    extendsFrom: 'RecordListView',
    initialize: function (options) {

        this._super('initialize', [options]);

        // checking licence configuration ///////////////////////

        var url = App.api.buildURL("bc_survey", "checkingLicenseStatus", "", {});

        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data != 'success') {
                    location.assign('#bc_survey_automizer/layout/access-denied');
                }
            },
        });
        /////////////////////////////////////////////////////////

    },
    _render: function () {
        if (app.acl.hasAccess('admin', 'Administration')) {
            this._super('_render');
        } else {
            location.assign('#bc_survey_automizer/layout/access-denied');
        }
    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})
