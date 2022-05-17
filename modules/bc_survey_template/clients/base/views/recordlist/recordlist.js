/**
 * The file used to view record list for User Group module.
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
                    location.assign('#bc_survey_template/layout/access-denied');
                }
            },
        });
        /////////////////////////////////////////////////////////
        this.context.on('list:create_survey:fire', this.create_surveyClicked, this);
    },
    render: function () {
        this._super('render');
    },
    /**create survey from template button clicked so prefill data for creating survey
     * 
     * @param {type} model
     * @returns {undefined}
     */
    create_surveyClicked: function (model) {
        if (localStorage['isLoadingFromTemplate'])
        {
            app.alert.show('info_survey', {
                level: 'info',
                messages: 'Please wait while survey is loading.',
                autoClose: false
            });
        } else {
            localStorage['isLoadingFromTemplate'] = true;
            //Create duplicate record as a survey
            var self = this,
                    prefill = app.data.createBean('bc_survey');

            prefill.copy(model);
            //set prefill data to localStorage
            localStorage['survey_record_id'] = model.get("id");
            localStorage['prefill'] = JSON.stringify(prefill);
            localStorage['copiedFromModelId'] = model.get("id");

            //redirect to create survey drawer
            var newWin = window.open("#bc_survey/create", "_blank");
            if (typeof newWin == "undefined") {
                app.alert.show('info', {
                    level: 'info',
                    messages: 'Please allow your browser to show pop-ups.',
                    autoClose: true
                });
            }
        }
    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})