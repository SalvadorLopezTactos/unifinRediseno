({
    /**
     * The file used to handle action of survey submission record list component 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */
    extendsFrom: 'RecordListView',
    contextEvents: {
        "list:resend_survey:fire": "resendSurvey",
        "list:deleterow:fire": "warnDelete",
    },
    initialize: function (options) {

        // checking licence configuration ///////////////////////

        var url = App.api.buildURL("bc_survey", "checkingLicenseStatus", "", {});

        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data != 'success') {
                    location.assign('#bc_survey_submission/layout/access-denied');
                }
            },
        });
        this._super('initialize', [options]);

        /////////////////////////////////////////////////////////

    },
    resendSurvey: function (model) {

        console.log(model);
        var submission_id = model.id;
        var module_id = model.attributes.target_parent_id;
        var module_type = model.attributes.target_parent_type;

        if (!module_id) {
            App.alert.show('email_error', {
                level: 'error',
                title: '',
                messages: 'Sorry, you can not resend survey to this recipient as it was submitted via open survey link.',
                autoClose: false
            });
        } else {

            // check is Survey Submitted or not
            app.alert.show('send_confirm', {
                level: 'confirmation',
                title: 'Notice',
                messages: "Are you sure want to resend survey ?",
                onConfirm: function () {
                    if (app.user.id == model.get('created_by') || app.user.attributes.type == "admin")
                    {
                        // loading alert for resend processing
                        app.alert.show('loading_resend_survey', {level: 'process', title: 'Processing', autoclose: false});

                        var survey_id = model.attributes.bc_survey_submission_bc_surveybc_survey_ida;
                        var module_id = model.attributes.target_parent_id;
                        var module_type = model.attributes.target_parent_type;
                        if (survey_id && module_id && module_type)
                        {
                            var url = App.api.buildURL("bc_survey", "approveRequest", "", {survey_id: survey_id, module_name: module_type, module_id: module_id, resendFromSubpanel: 1, isSurveyAlreadySend: model.attributes.survey_send,submission_id:submission_id});
                            App.api.call('GET', url, {}, {
                                success: function (result) {
                                    var response = JSON.parse(result);
                                    if (response['status'] == "sucess") {
                                        $("#survey_loader").remove();
                                        App.alert.show('email_success', {
                                            level: 'success',
                                            title: '',
                                            messages: 'Email for resubmission survey has sent successfully.',
                                            autoClose: true
                                        });
                                    } else {
                                        App.alert.show('email_error', {
                                            level: 'error',
                                            title: '',
                                            messages: response['status'],
                                            autoClose: true
                                        });
                                    }
                                },
                                complete: function () {
                                    app.alert.dismiss('loading_resend_survey');
                                }
                            });
                        } else {
                            app.alert.dismiss('loading_resend_survey');
                            App.alert.show('email_error', {
                                level: 'error',
                                title: '',
                                messages: 'There is some error to resend a survey.',
                                autoClose: false
                            });
                        }
                    } else {
                        var created_by_user = this.model.get('created_by_name');
                        if (created_by_user == "Administrator") {
                            var msg = 'You are unauthorized to resend this survey. Please contact  ' + created_by_user + ' to resend this survey';
                        } else {
                            var msg = 'You are unauthorized to resend this survey. Please contact Administrator or ' + created_by_user + ' to resend this survey';
                        }
                        App.alert.show('email_error', {
                            level: 'error',
                            title: '',
                            messages: msg,
                            autoClose: false
                        });
                    }
                }
            });
        }
    },
    /**
     * Popup dialog message to confirm delete action
     *
     * @param {Backbone.Model} model the bean to delete
     */
    warnDelete: function (model) {
        this._super('warnDelete', [model]);
    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})