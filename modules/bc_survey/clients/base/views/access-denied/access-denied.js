/**
 * The file used to display no access view for User Group module when license is not validated.
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
({
    extendsFrom: 'AccessDeniedView',
    initialize: function (options) {

        this._super('initialize', [options]);

        // checking licence configuration 
        var url = App.api.buildURL("bc_survey", "checkingLicenseStatus", {}, {});
        var self = this;

        app.api.call('GET', url, {}, {
            success: function (data) {
                if (data != 'success') {
                    $('.disable-module').html(data);
                }
            },
        });

    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }


})