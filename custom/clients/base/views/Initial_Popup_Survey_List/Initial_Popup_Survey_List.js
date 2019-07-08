({
    /**
     * The file used to show popup of send survey & perfoem related actions of send survey 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */

    extendsFrom: 'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    isSendNow: false,
    events: {
        'click #create_new_survey': 'create_new_survey',
        'click #create_from_survey_template': 'create_from_survey_template',
        'focus .show_datepicker': 'show_datepicker',
        'focus .show_timepicker': 'show_timepicker',
        'click .fa-clock-o': 'show_timepickerfromicon',
    },
    initialize: function (options) {
        this.selected_record_ids = options.selected_record_ids;
        this.module = options.context.attributes.module;
        if (options.totalSelectedRecord)
        {
            this.totalSelectedRecord = options.totalSelectedRecord;
        } else {
            this.totalSelectedRecord = 1;
        }
        this.send_type = options.send_type;
        if (options.isSendNow) {
            this.isSendNow = true;
        }
        this.events = _.extend({}, this.events, {
            'click [name=open_survey_list]': 'getSurveyLists',
            'click [name=back_button]': 'go_back',
            'click [name=search_button]': 'getSurveyListsBySearch',
            'click [name=search_template_button]': 'getSurveyTemplateListsBySearch',
            'click [name=clear_search]': 'clearTextAndGetAllSurveyList',
            'click [name=clear_template_search]': 'clearTextAndGetAllSurveyTemplateList',
            'click [name=create_using_survey_button]': 'createusingTemplate',
            'click [name=preview_emailTemplate]': 'redirectToEmailTemplate',
            'click [name=send_later_button]': 'schedule_survey_form',
            'click [name=schedule_button]': 'schedule_survey',
            'click [name=schedule_cancel_button]': 'cancel_schedule_survey',
            'click [name=send_survey_button]': 'schedule_survey',
            'click [name=ViewPendingRes]': 'openPendingResView',
            'click [name=ViewOptedOutRes]': 'openOptedOutView',
        });
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:Initial_Popup_Survey_List', function () {
                this.render();
                this.$('.modal').modal({
                    backdrop: 'static'
                });
                this.$('.modal').modal('show');
                $('.datepicker').css('z-index', '20000');
                app.$contentEl.attr('aria-hidden', true);
                $('.modal-backdrop').insertAfter($('.modal'));
                /**If any validation error occurs, system will throw error and we need to enable the buttons back*/
                this.context.get('model').on('error:validation', function () {
                    this.disableButtons(false);
                }, this);
            }, this);
        }
        this.bindDataChange();
        if (this.send_type == 'poll')
        {
            this.getSurveyLists();
            this.isSurvey = false;
        } else {
            this.isSurvey = true;
        }
    },
    _render: function () {

        this._super('_render');
        if (this.send_type == 'poll')
        {
            this.getSurveyLists();
            this.isSurvey = false;
        } else {
            this.isSurvey = true;
        }
    },
    /**
     * open pending response view to new tab
     * 
     * @el current element
     */
    openPendingResView: function (el) {
        var survey_id = el.currentTarget.attributes.getNamedItem('data-survey-id').value;
        var survey_module = el.currentTarget.attributes.getNamedItem('data-survey-module').value;
        var pending_res_records = el.currentTarget.attributes.getNamedItem('data-pending-response-record').value;
        var surveyPendingResArray = {"survey_module": survey_module, "pending_res_records": pending_res_records};
        localStorage['pending_res_type_' + survey_id] = JSON.stringify(surveyPendingResArray);
        var url = '#bc_survey/' + survey_id + '/layout/survey_sent_summary_view/pending_res';
        var newWin = window.open(url, "_blank");
        if (typeof newWin == "undefined") {
            app.alert.show('info', {
                level: 'info',
                messages: 'Please allow your browser to show pop-ups.',
                autoClose: true
            });
        }
    },
    /**
     * open opted out view to new tab
     * 
     * @el current element
     */
    openOptedOutView: function (el) {
        var survey_id = el.currentTarget.attributes.getNamedItem('data-survey-id').value;
        var survey_module = el.currentTarget.attributes.getNamedItem('data-survey-module').value;
        var opted_out_record = el.currentTarget.attributes.getNamedItem('data-opted-out-record').value;
        var surveyOptedOutArray = {"survey_module": survey_module, "opted_out_record": opted_out_record};
        localStorage['opted_out_type_' + survey_id] = JSON.stringify(surveyOptedOutArray);
        var url = '#bc_survey/' + survey_id + '/layout/survey_sent_summary_view/opted_out';
        var newWin = window.open(url, "_blank");
        if (typeof newWin == "undefined") {
            app.alert.show('info', {
                level: 'info',
                messages: 'Please allow your browser to show pop-ups.',
                autoClose: true
            });
        }
    },
    /**
     * show date picker
     * 
     * @el current element
     */
    show_datepicker: function (el) {
        var self = this;
        var element = el;
        var options = {
            dateFormat: app.user.getPreference('datepref'),
        };
        $('.show_datepicker').datepicker(options);
        $('.modal-body').scroll(function () {
            // make sure the dom element exists before trying to place the datepicker
            if (self._getAppendToTarget()) {
                // $('.datepicker').focus();
                $('.datepicker').datepicker('place');

            }
        });
    },
    /**
     * show time picker
     * 
     * @el current element
     */
    show_timepicker: function (el) {
        var self = this;
        var element = el;
        var options = {
            timeFormat: app.user.getPreference('timepref'),
        };
        $('.show_timepicker').timepicker(options);
        $('.modal-body').scroll(function () {
            // make sure the dom element exists before trying to place the datepicker
            if (self._getAppendToTarget()) {
                $('.ui-timepicker-wrapper').hide();
            }
        });
    },
    /**
     * Retrieve an element against which the date picker should be appended to.
     *
     * FIXME: find a proper way to do this and avoid scrolling issues SC-2739
     *
     * @return {jQuery/undefined} Element against which the date picker should
     *   be appended to, `undefined` if none.
     * @private
     */
    _getAppendToTarget: function () {
        var component = this;

        if (component) {
            return component.$el;
        }

        return;
    },
    /**
     * show time picker on click of picker icon
     * 
     * @el current element
     */
    show_timepickerfromicon: function (el) {
        $(el.currentTarget.parentElement.parentElement.children.show_timepicker).focus();
    },
    /**
     * Get All Survey Lists When Click On Select Survey List Button
     * 
     * @el current element
     */
    getSurveyLists: function () {
        var self = this;
        var search_string = '';
        var html = '';
        var surveyModule = $('input[name="send_module_name"]').val();
        if (this.send_type == 'poll')
        {
            surveyModule = 'poll';
        }
        var url = App.api.buildURL("bc_survey", "GetSurveys", "", {surveyModule: surveyModule, search_string: search_string, current_recipient_module: this.module});
        App.api.call('GET', url, {}, {
            success: function (data) {
                $('#survey_main_div').hide();
                $("#customerMailPopup").hide();
                var html = self.surveyListHtml(data);

                $('#survey_list_content').html(html);
                $('#survey_list_content').show();
                if (self.send_type != 'poll')
                {
                    $('.modal-footer').show();
                }
                $('.schedule_later_div').hide();
            }
        });
    },
    /**
     * create survey list html
     * 
     * @data survey data
     * @search_string search string to search for survey
     */
    surveyListHtml: function (data, search_string) {
        //check survey search condition
        var search_type = 'Survey';
        if (this.send_type == 'poll')
        {
            search_type = 'Poll';
        }
        var condition = '';
        if (data[1] != null && search_string != null && search_string != "undefined") {
            condition = search_string;
        }
        var html = '';
        if (data[1] != null && data[1]['id'] != null) {
            // generate survey list table
            html += "<table class='zebra table table-bordered table-striped' style='width: 99%;'>";
            html += "             <thead>";
            html += "                 <tr>";
            html += "                    <th style='width: 8%;height: 21px;'><div style='text-align:left; padding:10px 10px 8px 10px; font-size: 14px;'>No.</div></th>";
            html += "                    <th style='width: 86%; padding:10px 10px 10px 10px;height: 21px;' colspan='2'><div style='float:left; margin-top: 4px; font-size:14px;'>" + search_type + "</div><div style='float:right;'><input type='text' name='survey_search_text' value='" + condition + "' style='vertical-align: bottom;'> <input  class='btn btn-primary' type='button' name='search_button' value='Search'>&nbsp;<input class='btn' type='button' value='Clear' name='clear_search' ></div></th>";
            html += "                 </tr>";
            html += "             </thead>";
            html += "             <tbody>";

            $.each(data, function (index, list) {

                html += "<tr>";
                html += "        <td style = 'width: 8%;text-align:center;' > " + index + " </td>";
                html += "        <td style = 'width: 55%;text-align: left;' > " + list['title'] + " </td>";
                html += "        <td style = 'width: 20%; text-align: right;white-space: nowrap;' colspan = '3' >";
                html += "        <div class = 'btn btn-primary' title = 'Send' name = 'send_survey_button' currnet-date-data-value = '" + list['current_date'] + "' survey-id-data-value = '" + list['id'] + "' >";
                html += "        <i class = 'fa fa-envelope' > </i>&nbsp;Send</div> ";
                html += "        <div class = 'btn' title = 'Send Later' name = 'send_later_button' send-later-data-value = '" + list['id'] + "' >";
                html += "        <i class = 'fa fa-clock-o' > </i>&nbsp;Send Later</div > ";
                html += "        <div class = 'btn' title = 'Preview Email-Template' name = 'preview_emailTemplate' preview-data-value = '" + list['id'] + "' >";
                html += "        <i class = 'fa  fa-envelope' > </i></div>";
                html += "        </td>";
                html += "</tr>";
                html += "<tr class = 'schedule_later_div' id = '" + list['schedule_surveyTRID'] + "' >";
                html += "        <td colspan = '5' align = 'left' style = 'width: 99%;' >";
                html += "        <div id = '" + list['schedule_surveyDivID'] + "' style = 'display: none; background-color: rgb(232, 232, 232); border-radius:5px; box-shadow:2px 2px 2px #e8e8e8; padding:5px; margin-bottom:10px; border:1px solid #e8e8e8; width:96%'>";
                html += '        <div class = "fieldset-field" data-type = "datetimecombo" data-name = "start_date" >';
                html += '        <div class = "record-label" style = "text-align:left;" data-name = "start_date" > Select Date </div>';
                html += '        <span sfuuid = "335" class = "edit" >';
                html += '        <div class = "input-append date datetime" >';
                html += '        <input style = "width:150px;margin-left:3px;" name = "show_datepicker" class = "show_datepicker datepicker" type = "text" data-type = "date" class = "ui-timepicker-input" placeholder = "(Required)Date" aria-label = "Start Date">';
                html += '        <span name = "date_error" class = "error-tooltip add-on " style = "display:none;" data-container = "body" rel = "tooltip"  title = "Error. The date and time of this field is require and must be after current Date and Time." > <i class = "fa fa-exclamation-circle" > </i></span >';
                html += '        <span class = "add-on date" data-icon = "calendar" > <i class = "fa fa-calendar" > </i></span >';
                html += '        <input style = "width:120px;" type = "text" name = "show_timepicker"  class = "show_timepicker ui-timepicker-input timepicker" data-type = "time" autocomplete = "off" placeholder = "(Required)Time" class = "ui-timepicker-input" aria-label = "Start &amp; End Date" >';
                html += '        <span name = "time_error" class = "error-tooltip add-on" style = "display:none;" data-container = "body" rel = "tooltip" title = "Error. The date and time of this field is require and must be after current Date and Time." > <i class = "fa fa-exclamation-circle" > </i></span >';
                html += '        <span class = "add-on time" data-action = "show-timepicker" tabindex = "-1" > <i class = "fa fa-clock-o" > </i></span >';
                html += "        <div class = 'btn' name = 'schedule_button' send-later-data-value = '" + list['id'] + "' > Schedule </div>&nbsp;&nbsp;";
                html += "        <div style = 'margin-left:5px;' class = 'btn'  name = 'schedule_cancel_button' cancel-data-value = '" + list['id'] + "' > Cancel </div>";
                html += "        </div>";
                html += "        </span>";
                html += "        </div></div>";
                html += "        </td>";
                html += "</tr>";

            });

            html += "       </tbody>";
            html += "</table>";
        } else {
            // generate survey list table
            html += "<table class='zebra table table-bordered table-striped' style='width: 99%;'>";
            html += "             <thead>";
            html += "                 <tr>";
            html += "                    <th style='width: 8%;height: 21px;'><div style='text-align:left; padding:10px 10px 8px 10px; font-size: 14px;'>No.</div></th>";
            html += "                    <th style='width: 86%; padding:10px 10px 10px 10px;height: 21px;' colspan='2'><div style='float:left; margin-top: 4px; font-size:14px;'>" + search_type + "</div><div style='float:right;'><input type='text' name='survey_search_text' value='" + condition + "' style='vertical-align: bottom;'> <input  class='btn btn-primary' type='button' name='search_button' value='Search'>&nbsp;<input class='btn' type='button' value='Clear' name='clear_search' ></div></th>";
            html += "                 </tr>";
            html += "             </thead>";
            html += "             <tbody>";
            html += "                <tr><td colspan='3'><p align='center' > No records found. </p></td></tr>";
            html += "             </tbody>";
            html += "</table>";
        }

        return html;
    },
    /**
     * Get All Survey Lists By Search Value
     */
    getSurveyListsBySearch: function () {
        var self = this;
        var search_string = $('input[name="survey_search_text"]').val();
        var surveyModule = $('input[name="send_module_name"]').val();
        if (this.send_type == 'poll')
        {
            surveyModule = 'poll';
        }
        var url = App.api.buildURL("bc_survey", "GetSurveys", "", {surveyModule: surveyModule, search_string: search_string, current_recipient_module: this.module});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data == 0) {
                    data = new Array();
                    data[1] = Array('condition');
                    data[1]['condition'] = search_string;
                }
                $('#survey_main_div').hide();
                $("#customerMailPopup").hide();
                var html = self.surveyListHtml(data, search_string);
                $('#survey_list_content').html(html);
                $('#survey_list_content').show();
                if (self.send_type != 'poll')
                {
                    $('.modal-footer').show();
                }
                $('.schedule_later_div').hide();
            }
        });
    },
    /**
     * Get All Survey Template Lists By Search Value
     */
    getSurveyTemplateListsBySearch: function () {
        var self = this;
        var search_string = $('input[name="survey_search_text"]').val();
        var surveyModule = $('input[name="send_module_name"]').val();
        var url = App.api.buildURL("bc_survey", "GetSurveyTemplates", "", {surveyModule: surveyModule, search_string: search_string});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data == 0) {
                    data = new Array();
                    data[1] = Array('condition');
                    data[1]['condition'] = search_string;
                }
                $('#survey_main_div').hide();
                $("#customerMailPopup").hide();
                var html = self.surveyTemplateListHtml(data, search_string);
                $('#survey_list_content').html(html);
                $('#survey_list_content').show();
                $('.modal-footer').show();
            }
        });
    },
    /**
     * Get All Survey Lists By Search Clear Value
     */
    clearTextAndGetAllSurveyList: function () {
        var search_string = '';
        var self = this;
        var surveyModule = $('input[name="send_module_name"]').val();
        if (this.send_type == 'poll')
        {
            surveyModule = 'poll';
        }
        var url = App.api.buildURL("bc_survey", "GetSurveys", "", {surveyModule: surveyModule, search_string: search_string, current_recipient_module: this.module});
        App.api.call('GET', url, {}, {
            success: function (data) {
                $('input[name="survey_search_text"]').val('');
                $('#survey_main_div').hide();
                $("#customerMailPopup").hide();
                var html = self.surveyListHtml(data);
                $('#survey_list_content').html(html);
                $('#survey_list_content').show();
                if (self.send_type != 'poll')
                {
                    $('.modal-footer').show();
                }
                $('.schedule_later_div').hide();
            }
        });
    },
    /**
     * Get All Survey Template Lists By Search Clear Value
     */
    clearTextAndGetAllSurveyTemplateList: function () {
        var search_string = '';
        var self = this;
        var surveyModule = $('input[name="send_module_name"]').val();
        var url = App.api.buildURL("bc_survey", "GetSurveyTemplates", "", {surveyModule: surveyModule, search_string: search_string});
        App.api.call('GET', url, {}, {
            success: function (data) {
                $('input[name="survey_search_text"]').val('');
                $('#survey_main_div').hide();
                $("#customerMailPopup").hide();
                var html = self.surveyTemplateListHtml(data, search_string);
                $('#survey_list_content').html(html);
                $('#survey_list_content').show();
                $('.modal-footer').show();
            }
        });
    },
    /**
     *Get Confirmation for Preview Email Template On Click Preview Button
     * 
     * @el current element
     */
    redirectToEmailTemplate: function (el) {
        var self = this;
        var survey_ID = el.currentTarget.attributes.getNamedItem('preview-data-value').value;
        var url = App.api.buildURL("bc_survey", "checkEmailTemplateForSurvey", "", {survey_ID: survey_ID});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data && data.trim() != '') {
                    var newWin = window.open("#bwc/index.php?module=EmailTemplates&action=DetailView&record=" + data);
                    if (typeof newWin == "undefined") {
                        app.alert.show('info', {
                            level: 'info',
                            messages: 'Please allow your browser to show pop-ups.',
                            autoClose: true
                        });
                    }
                } else {
                    app.alert.show('stop_confirmation', {
                        level: 'confirmation',
                        title: '',
                        messages: 'Preview is not available because email template does not exist. Click Confirm to create email template.',
                        onConfirm: _.bind(self.confirmRedirect, self),
                        onCancel: function () {
                            app.alert.dismiss('stop_confirmation');
                            el.currentTarget.setAttribute('class', 'btn btn-primary');
                        },
                        autoClose: false
                    });
                }
            }
        });
    },
    /**
     * Preview Email Template On Click Confirm Button
     */
    confirmRedirect: function (survey_ID, surveyModule) {
        var newWin = window.open('#bwc/index.php?module=EmailTemplates&action=EditView&return_module=EmailTemplates&return_action=DetailView&survey_id=' + survey_ID + '&survey_module=' + surveyModule);
        if (typeof newWin == "undefined") {
            app.alert.show('info', {
                level: 'info',
                messages: 'Please allow your browser to show pop-ups.',
                autoClose: true
            });
        }
    },
    /**
     * cancel clicked for not redirecting to email template
     **/
    cancelRedirect: function () {
        app.alert.dismiss('stop_confirmation');
        //  this.srcElement.setAttribute('class', 'btn btn-primary');
    },
    /**
     * schadeule later survey layout set
     * 
     * @el current element
     */
    schedule_survey_form: function (el) {
        $('[name=send_survey_button]').addClass('disabled');
        // hide other schedule div
        $.each($('.schedule_later_div'), function () {
            $(this).hide();
        });

        var survey_ID = el.currentTarget.attributes.getNamedItem('send-later-data-value').value;
        $('#sehedule_row_' + survey_ID).slideDown();
        $('#sehedule_div_' + survey_ID).slideDown();
        $('#sehedule_div_' + survey_ID).find('.show_datepicker').val('');
        $('#sehedule_div_' + survey_ID).find('[name=date_error]').hide();
        $('#sehedule_div_' + survey_ID).find('[name=time_error]').hide();
        $.each($('#sehedule_div_' + survey_ID).find('.error'), function () {
            $(this).removeClass('error');
        });
        $('.show_datepicker').datepicker();
        $('.show_timepicker').timepicker();
    },
    /**
     * Cancel schedule survey so hide schedule tab
     * 
     * @el current element
     */
    cancel_schedule_survey: function (el) {
        $('[name=send_survey_button]').removeClass('disabled');
        $('[name=send_later_button]').removeClass('disabled');
        var survey_ID = el.currentTarget.attributes.getNamedItem('cancel-data-value').value;
        $('#show_error').html('&nbsp;');
        $('#sehedule_div_' + survey_ID).slideUp();
        $('#sehedule_row_' + survey_ID).slideUp();
    },
    /**
     * Immidiate send mail from record view
     * 
     * @el current element
     */
    Immidiate_send_survey: function (el) {

        var self = this;
        var surveyType = '';
        if (typeof self.send_type !== 'undefined') {
            surveyType = self.send_type.charAt(0).toUpperCase() + self.send_type.slice(1);
        }
        var dateNow = app.date();
        var schedule_later_flag = 0;
        var current_date = dateNow.format(app.date.convertFormat(app.user.getPreference('datepref')));
        var current_time = dateNow.format(app.date.convertFormat(app.user.getPreference('timepref')));
        if (el.currentTarget.attributes.getNamedItem('send-later-data-value') == null) {
            var survey_ID = el.currentTarget.attributes.getNamedItem('survey-id-data-value').value;
        } else {
            schedule_later_flag = 1;
            var survey_ID = el.currentTarget.attributes.getNamedItem('send-later-data-value').value;
            var get_date_unformated = el.currentTarget.parentElement.children.show_datepicker.value;
            var get_date = app.date(get_date_unformated).format(app.date.convertFormat(app.user.getPreference('datepref')));
            var get_time = el.currentTarget.parentElement.children.show_timepicker.value;
        }

        var records = this.selected_record_ids;
        var surveyModule = this.module;
        var surveySingularModule = App.lang.getAppListStrings("moduleListSingular")[surveyModule];
        var sendPeopleCount = this.totalSelectedRecord;
        var schedule_on_date = undefined, schedule_on_time = undefined;
        if (typeof schedule_on_date == 'undefined' && typeof schedule_on_time == 'undefined' && get_date != '' && get_time != '') {

            if (this.isDateRangeValid(dateNow, get_date_unformated)) {
                schedule_on_date = get_date;
                schedule_on_time = get_time;
            } else {
                if (schedule_later_flag != 0) {
                    el.currentTarget.parentElement.attributes.getNamedItem('class').value = "input-append date datetime error";
                    el.currentTarget.parentElement.children.show_datepicker.attributes.getNamedItem('class').value = "show_datepicker datepicker ui-datepicker-input error";
                    el.currentTarget.parentElement.children.show_timepicker.attributes.getNamedItem('class').value = "show_timepicker  ui-timepicker-input error";
                    el.currentTarget.parentElement.children.date_error.attributes.getNamedItem('style').value = "";
                    el.currentTarget.parentElement.children.time_error.attributes.getNamedItem('style').value = "";
                }
            }
            if (schedule_later_flag != 1) {
                schedule_on_date = 'current_date';
                schedule_on_time = 'current_time';
            }
        } else if (get_date == '' || get_time == '') {
            if (schedule_later_flag != 0) {
                el.currentTarget.parentElement.attributes.getNamedItem('class').value = "input-append date datetime error";
                el.currentTarget.parentElement.children.show_datepicker.attributes.getNamedItem('class').value = "show_datepicker datepicker ui-datepicker-input error";
                el.currentTarget.parentElement.children.show_timepicker.attributes.getNamedItem('class').value = "show_timepicker  ui-timepicker-input error";
                el.currentTarget.parentElement.children.date_error.attributes.getNamedItem('style').value = "";
                el.currentTarget.parentElement.children.time_error.attributes.getNamedItem('style').value = "";
            }
        }
        if ((typeof schedule_on_date != 'undefined' && typeof schedule_on_time != 'undefined') || schedule_later_flag == 0) {
            var url = App.api.buildURL("bc_survey", "checkEmailTemplateForSurvey", "", {survey_ID: survey_ID});
            App.api.call('GET', url, {}, {
                success: function (data) {

                    el.currentTarget.setAttribute('class', 'btn active disabled');
                    if (data && data.trim() != '') {
                        if (schedule_on_date == null || schedule_on_time == null && (get_date == null && get_time == null)) {
                            schedule_on_date = 'current_date';
                            schedule_on_time = 'current_time';
                        } else if (get_date != null && get_time != null) {
                            schedule_on_date = get_date;
                            schedule_on_time = get_time;
                        }
                        var url = App.api.buildURL("bc_survey", "SendImmediateEmail?module_name=" + surveyModule +
                                "&id_survey=" + survey_ID +
                                "&records=" + records +
                                "&schedule_on_date=" + schedule_on_date +
                                "&schedule_on_time=" + schedule_on_time +
                                "&total_selected=" + sendPeopleCount +
                                "&surveySingularModule=" + surveySingularModule,
                                {});
                        App.api.call('GET', url, {}, {
                            success: function (result) {

                                var resultObj = JSON.parse(result);
                                var content = resultObj.contentPopUP;
                                $('#survey_main_div').hide();
                                $('#survey_list_content').hide();
                                $("#customerMailPopup").show();
                                $("#customerMailPopup").html(content);
                                $('.modal-footer').hide();
                            }
                        });
                    } else {
                        $('[name=send_survey_button]').removeClass('disabled');
                        $('[name=send_later_button]').removeClass('disabled');
                        el.currentTarget.setAttribute('class', 'btn active');
                        app.alert.show('stop_confirmation', {
                            level: 'confirmation',
                            messages: 'Email template does not exist.Click Confirm to create email template for this ' + surveyType + '.',
                            onConfirm: _.bind(self.confirmRedirect, self, survey_ID, surveyModule),
                            onCancel: _.bind(self.cancelRedirect, self),
                            autoClose: false
                        });
                    }
                }
            });
        }
    },
    /**
     * Scadule, Send survey
     * 
     * @el current element
     */
    schedule_survey: function (el) {
        if (!el.currentTarget.classList.contains('disabled'))
        {
            $('[name=send_survey_button]').addClass('disabled');
            $('[name=send_later_button]').addClass('disabled');
            //if sending from record view to one record and not scheduling survey then immidiate send
            if (this.isSendNow && el.currentTarget.attributes.getNamedItem('send-later-data-value') == null) {
                this.Immidiate_send_survey(el);
            } else {
                var self = this;
                var surveyType = '';
                if (typeof self.send_type !== 'undefined') {
                    surveyType = self.send_type.charAt(0).toUpperCase() + self.send_type.slice(1);
                }
                var dateNow = app.date();
                var schedule_later_flag = 0;
                var current_date = dateNow.format(app.date.convertFormat(app.user.getPreference('datepref')));
                var current_time = dateNow.format(app.date.convertFormat(app.user.getPreference('timepref')));

                if (el.currentTarget.attributes.getNamedItem('send-later-data-value') == null) {
                    var survey_ID = el.currentTarget.attributes.getNamedItem('survey-id-data-value').value;
                } else {
                    schedule_later_flag = 1;
                    var survey_ID = el.currentTarget.attributes.getNamedItem('send-later-data-value').value;
                    var get_date_unformated = el.currentTarget.parentElement.children.show_datepicker.value;
                    var get_date = app.date(get_date_unformated).format(app.date.convertFormat(app.user.getPreference('datepref')));
                    var get_time = el.currentTarget.parentElement.children.show_timepicker.value;
                }

                var records = this.selected_record_ids;
                var surveyModule = this.module;
                var surveySingularModule = App.lang.getAppListStrings("moduleListSingular")[surveyModule];
                var sendPeopleCount = this.totalSelectedRecord;
                var schedule_on_date = undefined, schedule_on_time = undefined;
                if (typeof schedule_on_date == 'undefined' && typeof schedule_on_time == 'undefined' && get_date != '' && get_time != '') {

                    if (this.isDateRangeValid(dateNow, app.date(get_date_unformated))) {
                        schedule_on_date = get_date;
                        schedule_on_time = get_time;
                    } else {
                        if (schedule_later_flag != 0) {
                            el.currentTarget.parentElement.attributes.getNamedItem('class').value = "input-append date datetime error";
                            el.currentTarget.parentElement.children.show_datepicker.attributes.getNamedItem('class').value = "show_datepicker datepicker ui-datepicker-input error";
                            el.currentTarget.parentElement.children.show_timepicker.attributes.getNamedItem('class').value = "show_timepicker ui-timepicker-input error";
                            el.currentTarget.parentElement.children.date_error.attributes.getNamedItem('style').value = "";
                            el.currentTarget.parentElement.children.time_error.attributes.getNamedItem('style').value = "";
                        }
                    }
                    if (schedule_later_flag != 1) {
                        schedule_on_date = 'current_date';
                        schedule_on_time = 'current_time';
                    }
                } else if (get_date == '' || get_time == '') {
                    if (schedule_later_flag != 0) {
                        el.currentTarget.parentElement.attributes.getNamedItem('class').value = "input-append date datetime error";
                        el.currentTarget.parentElement.children.show_datepicker.attributes.getNamedItem('class').value = "show_datepicker datepicker ui-datepicker-input error";
                        el.currentTarget.parentElement.children.show_timepicker.attributes.getNamedItem('class').value = "show_timepicker ui-timepicker-input error";
                        el.currentTarget.parentElement.children.date_error.attributes.getNamedItem('style').value = "";
                        el.currentTarget.parentElement.children.time_error.attributes.getNamedItem('style').value = "";
                    }
                }
                if ((typeof schedule_on_date != 'undefined' && typeof schedule_on_time != 'undefined') || schedule_later_flag == 0) {
                    var url = App.api.buildURL("bc_survey", "checkEmailTemplateForSurvey", "", {survey_ID: survey_ID});
                    App.api.call('GET', url, {}, {
                        success: function (data) {


                            el.currentTarget.setAttribute('class', 'btn active disabled');
                            if (data && data.trim() != '') {
                                if (schedule_on_date == null || schedule_on_time == null && (get_date == null && get_time == null)) {
                                    schedule_on_date = 'current_date';
                                    schedule_on_time = 'current_time';
                                } else if (get_date != null && get_time != null) {
                                    schedule_on_date = get_date;
                                    schedule_on_time = get_time;
                                }
                                App.alert.show('loading_send_survey', {level: 'process', title: 'Please wait while survey is scheduling', autoclose: false});
                                var url = App.api.buildURL("bc_survey/" + survey_ID + "/SendSurveyEmail");
                                App.api.call('create', url, {module_name: surveyModule, id_survey: survey_ID, records: records, schedule_on_date: schedule_on_date, schedule_on_time: schedule_on_time, total_selected: sendPeopleCount, surveySingularModule: surveySingularModule}, {
                                    success: function (result) {
                                        var resultObj = JSON.parse(result);
                                        var content = resultObj.contentPopUP;
                                        $('#survey_main_div').hide();
                                        $('#survey_list_content').hide();
                                        $("#customerMailPopup").show();
                                        $("#customerMailPopup").html(content);
                                        $('.modal-footer').hide();
                                        app.alert.dismiss('loading_send_survey');
                                    }
                                });
                            } else {
                                $('[name=send_survey_button]').removeClass('disabled');
                                $('[name=send_later_button]').removeClass('disabled');
                                el.currentTarget.setAttribute('class', 'btn active');
                                app.alert.show('stop_confirmation', {
                                    level: 'confirmation',
                                    messages: 'Email template does not exist.Click Confirm to create email template for this ' + surveyType + '.',
                                    onConfirm: _.bind(self.confirmRedirect, self, survey_ID, surveyModule),
                                    onCancel: _.bind(self.cancelRedirect, self),
                                    autoClose: false
                                });
                            }
                        }
                    });
                }
            }
        }
    },
    /**
     * Is this date range valid? It returns true when start date is before end date.
     * 
     * @curr_date current date
     * @get_date user given date
     * @return {boolean}
     */
    isDateRangeValid: function (curr_date, get_date) {
        var isValid = false;
        // check if curr date & compare to schedule later date exist or not if exist then compare it
        if (typeof curr_date != "undefined" && typeof get_date != "undefined") {
            var curr_date_formated = curr_date._d.getDate() + '-' + curr_date._d.getMonth() + '-' + curr_date._d.getFullYear();
            var get_date_formated = get_date._d.getDate() + '-' + get_date._d.getMonth() + '-' + get_date._d.getFullYear();
            if (app.date.compare(curr_date, get_date) < 1 || curr_date_formated == get_date_formated) {
                isValid = true;
            }
        }

        return isValid;
    },
    /**
     * Go back to prev page
     */
    go_back: function () {
        $('#survey_list_content').hide();
        $('#survey_main_div').show();
        $('.modal-footer').hide();
    },
    /**Overriding the base saveComplete method*/
    close_popup: function () {
        this._disposeView();
    },
    /**
     * create new survey
     */
    create_new_survey: function () {
        var self = this;
        var url = App.api.buildURL("bc_survey", "isSurveySend", {});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data['sugar_latest'] == '1')
                {
                    var create_view = 'create';
                } else {
                    var create_view = 'create-actions';
                }
                self.$('.Initial_Popup_Survey_List').modal('hide'); // hide the current popup
                App.drawer.open({
                    layout: create_view,
                    context: {
                        create: true,
                        module: 'bc_survey',
                        isCreateFromSendSurveyNew: true,
                        selected_record_ids: self.selected_record_ids,
                        totalSelectedRecord: self.totalSelectedRecord,
                        module_to_send: self.module,
                    }
                });
            }
        });

        // javascript:parent.SUGAR.App.router.navigate("bc_survey/create", {trigger: true});
    },
    /**
     * Create survey from survey template
     */
    create_from_survey_template: function () {
        var self = this;
        var search_string = '';
        var surveyModule = $('input[name="send_module_name"]').val();
        var url = App.api.buildURL("bc_survey", "GetSurveyTemplates", {surveyModule: surveyModule, search_string: search_string});
        App.api.call('GET', url, {}, {
            success: function (data) {
                $('#survey_main_div').hide();
                $("#customerMailPopup").hide();
                var html = self.surveyTemplateListHtml(data);
                $('#survey_list_content').html(html);
                $('#survey_list_content').show();
                $('.modal-footer').show();
            }
        });
    },
    /**
     * Survey Template list html
     */
    surveyTemplateListHtml: function (data, search_string) {
        //check survey search condition
        var html = '';
        var condition = '';
        if (data[1] != null && search_string != null && search_string != "undefined") {
            var condition = search_string;
        }
        if (data[1] != null && data[1]['id'] != null) {

            html += "<div id='survey_template_list'>";
            html += "<table class=\"zebra table table-bordered table-striped\"  style='width: 99%;'>";
            html += "          <thead><tr><th style='width: 6%;height: 21px;'><div style='text-align:left; padding:10px 10px 8px 10px; font-size: 14px;'>No.</div></th><th style='width: 93%; padding:10px 10px 10px 10px;height: 21px;' colspan='2'><div style='float:left; margin-top: 4px; font-size:14px;'>Templates</div>";
            html += "          <div style='float:right;'><input type='text' name='survey_search_text' value='" + condition + "' style='vertical-align: bottom;'> <input  class='btn btn-primary' type='button' name='search_template_button' value='Search'>&nbsp;";
            html += "         <input type='button' class='btn' value='Clear' name='clear_template_search' ></div></th></tr></thead>";
            html += "          <tbody>";
            if (data[1] != "undefined") {
                $.each(data, function (index, list) {
                    html += "<tr><td style='width: 8%;text-align:center;'>" + index + "</td><td style='width: 70%;text-align: left;'>" + list['title'] + "</td><td style='width: 5%; text-align: right;white-space: nowrap;' colspan='3'>"
                    html += "<div class='btn btn-primary' title='Create Survey' name='create_using_survey_button' survey-id-data-value = '" + list['id'] + "'>Create Survey</div>&nbsp;</td></tr>";
                });
            } else {
                html += "<tr>";
                html += "        <td colspan = '4' align = 'center' > No records found. </td><td></td>";
                html += "</tr>";
            }
            html += "       </tbody>";
            html += "</table>";
        } else {
            html += "<table class=\"zebra table table-bordered table-striped\"  style='width: 99%;'>";
            html += "          <thead><tr><th style='width: 6%;height: 21px;'><div style='text-align:left; padding:10px 10px 8px 10px; font-size: 14px;'>No.</div></th><th style='width: 93%; padding:10px 10px 10px 10px;height: 21px;' colspan='2'><div style='float:left; margin-top: 4px; font-size:14px;'>Templates</div>";
            html += "          <div style='float:right;'><input type='text' name='survey_search_text' value='" + condition + "' style='vertical-align: bottom;'> <input  class='btn btn-primary' type='button' name='search_template_button' value='Search'>&nbsp;";
            html += "         <input type='button' class='btn' value='Clear' name='clear_template_search' ></div></th></tr></thead>";
            html += "          <tbody>";
            html += "            <tr><td colspan='3'><p align='center' >No records found.</p></td></tr>";
            html += "       </tbody>";
            html += "</table>";
        }

        return html;
    },
    /* Create survey using Survey Template
     * * 
     * @el current element
     */
    createusingTemplate: function (el) {
        //Create duplicate record as a survey
        if (!$(el.currentTarget).hasClass('disabled'))
        {
            $(el.currentTarget).addClass('disabled');
            var templ_id = el.currentTarget.attributes.getNamedItem('survey-id-data-value').nodeValue;
            var SurveyTemplateBean = app.data.createBean('bc_survey_template', {id: templ_id});
            var self = this,
                    prefill = app.data.createBean('bc_survey');
            var request = SurveyTemplateBean.fetch();
            request.xhr.done(function () {
                SurveyTemplateBean.attributes.description = SurveyTemplateBean.get('description');
                SurveyTemplateBean.attributes.name = SurveyTemplateBean.get('name');
                prefill.copy(SurveyTemplateBean);
                prefill.unset('id');

                var url = App.api.buildURL("bc_survey", "isSurveySend", {});
                App.api.call('GET', url, {}, {
                    success: function (data) {
                        if (data['sugar_latest'] == '1')
                        {
                            var create_view = 'create';
                        } else {
                            var create_view = 'create-actions';
                        }
                        //Set id to storage for getting survey pages
                        localStorage['survey_record_id'] = SurveyTemplateBean.get('id');
                        app.drawer.open({
                            layout: create_view,
                            context: {
                                create: true,
                                model: prefill,
                                module: 'bc_survey',
                                isCreateFromSendSurvey: true,
                                copiedFromModelPopupId: SurveyTemplateBean.get('id')
                            }
                        }, function (context, newModel) {
                            if (newModel && newModel.id) {
                                app.router.navigate('bc_survey' + '/' + newModel.id, {trigger: true});
                            }
                        });
                        self.$('.Initial_Popup_Survey_List').modal('hide'); // hide the current popup
                        prefill.trigger('duplicate:field', 'bc_survey');
                    }
                });
            });
        }
    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'Initial_Popup_Survey_List'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})
