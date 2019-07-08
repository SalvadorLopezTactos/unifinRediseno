
({
    /**
     * The file used to handle action survey send summary view of recipient 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */
    className: 'survey_sent_summary_view',
    sid: '',
    button_clicked: '',
    initialize: function (options) {
        this._super('initialize', [options]);
        this.events = _.extend({}, this.events, {
            'click [name=show_more_button]': 'fetchRecordsOnShowMore',
            'click [name=SendReminder]': 'sendSurveyReminderEmail',
            'change [name=reminder_chkAll]': 'selectDeselectReminderChk',
        });

        this.load_summary_view(this);

    },
    /** fetch other records on click of show more link
     * 
     * @param {type} el current target
     * @returns {undefined}
     */
    fetchRecordsOnShowMore: function (el) {

        var currentListRecordsCount = new Array();
        $('.reminder_chk').each(function () {
            currentListRecordsCount.push($(this).val());
        });
        //  var offset_value = el.currentTarget.attributes.getNamedItem('data-offset-value').value;
        var currentRecordCount = currentListRecordsCount.length;
        this.load_summary_view(currentRecordCount);
    },
    /**load summary view of recipient
     * 
     * @param {type} element -c current element
     * @returns {undefined}
     */
    load_summary_view: function (element) {

        var self = this;
        var currentRecordCount = '';
        if (typeof element == 'string' || typeof element == 'number') {
            currentRecordCount = element;
        }
        var module_name = '';
        var type = this.options.context.attributes.action;
        var survey_ID = this.options.context.attributes.modelId;
        if (type == 'pending_res') {
            var surveyPendingResArraDetails = JSON.parse(localStorage['pending_res_type_' + survey_ID]);
            module_name = surveyPendingResArraDetails['survey_module'];
            var pending_response_record = surveyPendingResArraDetails['pending_res_records'];
        } else {
            var surveyOptedOutArraDetails = JSON.parse(localStorage['opted_out_type_' + survey_ID]);
            module_name = surveyOptedOutArraDetails['survey_module'];
            var opted_out_record = surveyOptedOutArraDetails['opted_out_record'];
        }

        var arg = 'bc_survey/' + survey_ID + '/openSummaryDetailView';
        app.api.call('create', app.api.buildURL(arg), {type: type, module_name: module_name, pending_res_record: pending_response_record, opted_out_record: opted_out_record, currentRecordCount: currentRecordCount},
        {
            success: function (data) {

                self.SummaryData = data['SummaryData'];
                self.type_view = data['type'];
                self.survey_module = data['module_name'];
                self.survey_id = data['survey_id'];
                self.have_records = data['have_records'];
                self.show_more = data['show_more'];
                self.offset_param = data['offset_param'];
                self.render();
            }
        }
        );
    },
    /** select or deselect reminder checkbox 
     * 
     * @param {type} el
     * @returns {undefined}
     */
    selectDeselectReminderChk: function (el) {
        var isChecked = el.currentTarget.checked;
        if (isChecked) {
            _.each($('input[name="reminder_records"]'), function (el, item) {
                $('input[name="reminder_records"]')[item].checked = true;
            }, this);
        } else {
            _.each($('input[name="reminder_records"]'), function (el, item) {
                $('input[name="reminder_records"]')[item].checked = false;
            }, this);
        }
    },
    /**send survey reminder mail who have not submitted survey
     * 
     * @param {type} el current target
     * @returns {undefined}
     */
    sendSurveyReminderEmail: function (el) {

        var surveyID = el.currentTarget.attributes.getNamedItem('data-survey-rem-id').value;
        var module_name = el.currentTarget.attributes.getNamedItem('data-survey-rem-module').value;
        var allReminderChk = new Array();
        var moduleIDs = new Array();
        $('.reminder_chk').each(function () {
            if ($(this).is(":checked")) {
                allReminderChk.push(true);
                moduleIDs.push($(this).val());
            } else {
                allReminderChk.push(false);
            }
        });
        var allmodulesIDs = JSON.stringify(moduleIDs);
        if ($.inArray(true, allReminderChk) != -1) {
            var arg = 'bc_survey/' + surveyID + '/SendSurveyReminder';
            app.api.call('create', app.api.buildURL(arg), {moduleID: allmodulesIDs, moduleName: module_name},
            {
                success: function (data) {
                    if (data.trim() == 'scheduled') {
                        app.alert.show('Show Success Message For Sent Reminder Email.', {
                            level: 'success',
                            title: '',
                            messages: 'Survey reminder mail scheduled successfully',
                            autoClose: false
                        });
                    }
                }
            });
        } else {
            app.alert.show('Allow User To Select Atleast Single Checkbox to Send Reminder Email.', {
                level: 'error',
                title: '',
                messages: 'Please check atleast one checkbox',
                autoClose: false
            });
        }
    }
})


