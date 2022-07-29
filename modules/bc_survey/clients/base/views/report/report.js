/**
 * The file used to handle action of report page
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
({className: 'report',
    sid: '',
    GF_Filter_By: '',
    GF_Start_Date: '',
    GF_End_Date: '',
    isApplyGlobalFilter: false,
    GF_saved_question_logic: {},
    GF_all_questions: {},
    GF_match_case: '',
    button_clicked: '',
    events: {
        'click #Export': 'doExport',
        'click .numbers a': 'getQuestionReportPagination',
        'click .individual_div': 'getReports',
        'click #Search,#Clear,.sort_name,.sort_module,.sort_type,.sort_status,.sort_send_date,.sort_submission_date,.sort_change_req,.sort_consent_accepted': 'getSearchResult',
        'click .appReq': 'ApproveChRequest',
        'click .resend': 'reSendSurvey',
        'focus .show_datepicker': 'show_datepicker',
        'click .deleteSub': 'deleteSubmissionClicked',
        'click .status_email,.status_openended,.status_combined': 'load_status_report',
        'click .question_email,.question_openended,.question_combined': 'load_question_report',
        'click .page-next-records': 'getNextPageRecordsQwise',
        'click .page-prev-records': 'getPrevPageRecordsQwise',
        'click .switch_chart_report_icon': 'switch_chart_report',
        'click #closeSwitchChartModel': 'closeSwitchChartModel',
        'click .swichChart': 'swichChartOnClickChartIcon',
        'click .toggleStatsTable': 'toggleStatsTable',
        'click #global_filter': 'globalFilterBtnClicked',
        'click .normal-trend-tabs': 'toggleToTrendAndNormalReport',
        'click .question-normal-trend-tabs': 'toggleToTrendAndNormalQuestionReport',
        'change .trend_StatusDD': 'switchStatusTrendDataBasedOnRange',
        'change .trend_QuestionDD': 'switchQuestionTrendDataBasedOnRange',
        'click .questionImageExport': 'questionWiseExport',
        'click .questionPDFExport': 'questionWiseExport',
        'click .page-next-recordsIndividual': 'getNextPageRecordsIndividual',
        'click .page-prev-recordsIndividual': 'getPrevPageRecordsIndividual',
        'click .answerHistory': 'getAnswerHistory',
    },
    initialize: function (options) {
        this._super('initialize', [options]);
        // checking licence configuration ///////////////////////

        var url = App.api.buildURL("bc_survey", "checkingLicenseStatus", "", {});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data != 'success') {
                    location.assign('#bc_survey/layout/access-denied');
                }
            },
        });
        /////////////////////////////////////////////////////////
        this.sid = this.model.get('id');
        var self = this;
        this.load_status_report();
        this.survey_id = this.sid;
        this.user_id = App.user.get('id');
    },
    _render: function (options) {
        this._super('_render', [options]);
        var self = this;
        //open status report initailly hide all other report
        $('.status_report_heading').click(function () {

            self.load_status_report();
            $('#status_report_data_section').fadeIn();
            $('.status_report_heading').addClass('active');
            // close other collapse
            $('#question_report_data_section').fadeOut();
            $('#individual_report_data_section').fadeOut();
            $('.question_report_heading').removeClass('active');
            $('.individual_report_heading').removeClass('active');
        });
        $('.question_report_heading').click(function () {

            self.load_question_report();
            $('#question_report_data_section').fadeIn();
            $('.question_report_heading').addClass('active');
            //close other collapse
            $('#status_report_data_section').fadeOut();
            $('#individual_report_data_section').fadeOut();
            $('.status_report_heading').removeClass('active');
            $('.individual_report_heading').removeClass('active');
        });
        $('.individual_report_heading').click(function () {

            self.load_individual_report();
            $('#individual_report_data_section').fadeIn();
            $('.individual_report_heading').addClass('active');
            //close other collapse
            $('#status_report_data_section').fadeOut();
            $('#question_report_data_section').fadeOut();
            $('.status_report_heading').removeClass('active');
            $('.question_report_heading').removeClass('active');
        });
        // Retrieve all questions for Question Logic
        var url = App.api.buildURL("bc_survey", "getAllSurveyQuestions", "", {record_id: this.sid});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data) {
                    self.GF_all_questions = data;
                    localStorage['GF_all_questions'] = data;
                }
            },
        });
    },
    render: function (options) {
        this._super('render', [options]);
    },
    /**
     * Return user date format.
     *
     * @return {String} User date format.
     */
    getUserDateFormat: function () {
        return app.user.getPreference('datepref');
    },
    /**
     * Patches our `dom_cal_*` metadata for use with date picker plugin since
     * they're very similar.
     *
     * @private
     */
    _patchPickerMeta: function () {
        var pickerMap = [], pickerMapKey, calMapIndex, mapLen, domCalKey,
                calProp, appListStrings, calendarPropsMap, i, filterIterator;
        appListStrings = app.metadata.getStrings('app_list_strings');
        filterIterator = function (v, k, l) {
            return v[1] !== "";
        };
        // Note that ordering here is used in following for loop
        calendarPropsMap = ['dom_cal_day_long', 'dom_cal_day_short', 'dom_cal_month_long', 'dom_cal_month_short'];
        for (calMapIndex = 0, mapLen = calendarPropsMap.length; calMapIndex < mapLen; calMapIndex++) {

            domCalKey = calendarPropsMap[calMapIndex];
            calProp = appListStrings[domCalKey];
            // Patches the metadata to work w/datepicker; initially, "calProp" will look like:
            // {0: "", 1: "Sunday", 2: "Monday", 3: "Tuesday", 4: "Wednesday", 5: "Thursday", 6: "Friday", 7: "Saturday"}
            // But we need:
            // ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]
            if (!_.isUndefined(calProp) && !_.isNull(calProp)) {
                // Reject the first 0: "" element and then map out the new language tuple
                // so it's back to an array of strings
                calProp = _.filter(calProp, filterIterator).map(function (prop) {
                    return prop[1];
                });
                //e.g. pushed the Sun in front to end (as required by datepicker)
                calProp.push(calProp);
            }
            switch (calMapIndex) {
                case 0:
                    pickerMapKey = 'day';
                    break;
                case 1:
                    pickerMapKey = 'daysShort';
                    break;
                case 2:
                    pickerMapKey = 'months';
                    break;
                case 3:
                    pickerMapKey = 'monthsShort';
                    break;
            }
            pickerMap[pickerMapKey] = calProp;
        }
        return pickerMap;
    },
    /**
     * show date picker
     * 
     * @el current element
     */
    show_datepicker: function (el) {

        var self = this;
        var element = el;
        var userDateFormat = this.getUserDateFormat();
        var options = {
            format: app.date.toDatepickerFormat(userDateFormat),
            languageDictionary: this._patchPickerMeta(),
            weekStart: parseInt(app.user.getPreference('first_day_of_week'), 10)
        };
        $(el.currentTarget).datepicker(options);
        $('.accordion-inner').scroll(function () {
            // make sure the dom element exists before trying to place the datepicker
            $('.datepicker').datepicker('place');
        });
        $('.middle-content').scroll(function () {
            // make sure the dom element exists before trying to place the datepicker
            $('.datepicker').datepicker('place');
        });
        $('.middle-content').scroll(function () {
            // make sure the dom element exists before trying to place the datepicker
            if (self._getAppendToTarget()) {
                $('.ui-timepicker-wrapper').hide();
            }
        });
    },
    /**
     * Is this date range valid? It returns true when start date is before end date.
     * 
     * @curr_date current date
     * @get_date user given date
     * @return {boolean}
     */
    isDateRangeValid: function (curr_date, get_date) {

        curr_date = app.date(curr_date, App.date.getUserDateFormat());
        get_date = app.date(get_date, App.date.getUserDateFormat());
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
    /**load status report for the survey
     * 
     * @returns {undefined}
     */
    load_status_report: function (el) {
        $('#current_active_report_tab').val('status');
        $('#btn-export-report').show();
        app.alert.show('loading_report_view', {level: 'process', title: 'Please wait while report is loading', autoclose: false});
        var status_type = 'status_combined';
        var report_type = 'combined';
        if (el && $(el.currentTarget))
        {
            status_type = $(el.currentTarget).attr('class');
        }

        if (status_type == 'status_email')
        {
            report_type = 'email';
            $('#status_report_data_email').show();
            $('#status_report_data_openended').hide();
            $('#status_report_data_combined').hide();
        } else if (status_type == 'status_openended')
        {
            report_type = 'openended';
            $('#status_report_data_email').hide();
            $('#status_report_data_openended').show();
            $('#status_report_data_combined').hide();
        } else if (status_type == 'status_combined')
        {
            report_type = 'combined';
            $('#status_report_data_email').hide();
            $('#status_report_data_openended').hide();
            $('#status_report_data_combined').show();
        }
        var self = this;
        self.button_clicked = 'status';
        var url = App.api.buildURL("bc_survey", "get_report", "", {survey_id: self.sid, status: self.button_clicked, status_type: report_type});
        var status_report_html = '';
        var status_trend_report_html = '';
        // getting survey status from bc_surveyapi to render html of chart
        App.api.call('create', url, {}, {
            success: function (data) {
                var is_active = '';
                self.report_type = self.button_clicked;
                status_report_html += '<div class="report_header">Status Report for ' + data['html']['name'] + '</div>';
                status_report_html += '<ul class="nav nav-tabs">';
                if (status_type == 'status_combined')
                {
                    is_active = "active";
                }
                status_report_html += '  <li class="' + is_active + '"><a class="status_combined">Combined</a></li>';
                is_active = '';
                if (status_type == 'status_email')
                {
                    is_active = "active";
                }
                status_report_html += '  <li class="' + is_active + '">';
                status_report_html += '    <a class="status_email">Email</a>';
                status_report_html += '  </li>';
                is_active = '';
                if (status_type == 'status_openended')
                {
                    is_active = "active";
                }
                status_report_html += '  <li class="' + is_active + '"><a class="status_openended">Open Ended</a></li>';
                status_report_html += '</ul>';
                if (data['html']['status_report_detail'] != "There is no submission for this Survey.") {
                    //chart div
                    status_report_html += '<div id="status-trend-tabs" class="report-sub-tabs"><input type="hidden" id="reportType" value="' + report_type + '"><ul class="nav nav-tabs trend-tbs-ul">  <li class="active"><a id="status-normal-report" class="status_normal normal-trend-tabs">Normal</a></li>  <li class="">    <a id="status-trend-report" class="status_trend normal-trend-tabs">Trend</a>  </li>  </ul></div>';
                    status_report_html += '<div id="status_section"><div class="report_display" id="piechart_3d_' + report_type + '"  style="height: 400px;"></div><input type="hidden" id="pdf_chart_img_piechart_3d_' + report_type + '" />';
                    status_report_html += '<div id="line_chart_' + report_type + '" class="report_display" style=" height: 350px;"></div><input type="hidden" id="pdf_chart_img_line_chart_' + report_type + '" /></div>';
                    if (data['html']['status_report_detail']['email_not_opened'] != 'undefined') {
                        var email_not_opened = parseInt(data['html']['status_report_detail']['email_not_opened']);
                    } else {
                        var email_not_opened = 0;
                    }
                    if (data['html']['status_report_detail']['Pending'] != 'undefined') {
                        var Pending = parseInt(data['html']['status_report_detail']['Pending']);
                    } else {
                        var Pending = 0;
                    }
                    if (data['html']['status_report_detail']['Submitted'] != 'undefined') {
                        var Submitted = parseInt(data['html']['status_report_detail']['Submitted']);
                    } else {
                        var Submitted = 0;
                    }
                    status_trend_report_html = self.drawStatusTrendReportData(data, report_type);
                    status_report_html += status_trend_report_html;
                    // display report data
                    $('#status_report_data_' + report_type).html(status_report_html);
                    $.ajax({
                        url: 'https://www.google.com/jsapi',
                        cache: true,
                        dataType: 'script',
                        success: function () {
                            google.load('visualization', '1', {packages: ['corechart'], 'callback': function ()
                                {

                                    var data = google.visualization.arrayToDataTable([
                                        ['Task', 'Survey Status'],
                                        ['Not viewed', email_not_opened],
                                        ['Viewed', Pending],
                                        ['Submitted', Submitted],
                                    ]);
                                    var options = {
                                        title: '',
                                        is3D: true,
                                        pieSliceTextStyle: {
                                            color: 'white',
                                        },
                                        legend: 'none',
                                        colors: ['#237094', '#FF8000', '#30a7bc'],
                                    };
                                    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d' + '_' + report_type));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_piechart_3d' + '_' + report_type).value = chart.getImageURI();
                                }
                            });
                            //linear chart ///////////////////////////////////////
                            var start_date = data['html']['survey_start_date'];
                            var end_date = data['html']['survey_end_date'];
                            var lineChart_data = data['line_chart'];
                            var max_count = data['linechart_max_count'];
                            google.load('visualization', '1', {'packages': ['line'], 'callback': function () {
                                    var data = google.visualization.arrayToDataTable(lineChart_data);
                                    var options = {
                                        title: '',
                                        pointSize: 7,
                                        legend: {position: 'bottom'},
                                        hAxis: {viewWindowMode: "explicit", viewWindow: {min: start_date, max: end_date}},
                                        vAxis: {format: '0', viewWindowMode: "explicit", viewWindow: {min: 0, max: max_count}},
                                        is3D: true,
                                        colors: ['#30a7bc', '#FF8000'],
                                    };
                                    data.sort([{column: 0}]);
                                    var chart = new google.visualization.LineChart(document.getElementById('line_chart' + '_' + report_type));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_line_chart' + '_' + report_type).value = chart.getImageURI();
                                }
                            });
                            //////////////////////////////////////////////////////////////
                            $('#question_report').attr('style', 'border-top: 1px solid #dddddd;');
                        }
                    });
                    $('#hasSubmissions').val('true');
                } else {
                    status_report_html += '<div><p align="center">' + data['html']['status_report_detail'] + '</p></div>';
                    $('#status_report_data_' + report_type).html(status_report_html);
                    $('#hasSubmissions').val('false');
                }
                app.alert.dismiss('loading_report_view');
            },
        });
    },
    /**load individual report for the survey
     * 
     * @returns {undefined}
     */
    load_individual_report: function () {
        $('#btn-export-report').hide();
        var self = this;
        self.button_clicked = 'individual';
        var global_filter_by = getGlobalFilterURl(self);

        app.alert.show('loading_report_view', {level: 'process', title: 'Please wait while report is loading', autoclose: false});
        var individual_report_html = '';
        var url = App.api.buildURL("bc_survey", "get_report?survey_id=" + self.sid + '&status=' + self.button_clicked + global_filter_by, "", {});
        App.api.call('create', url, {}, {
            success: function (data) {
                individual_report_html += '<div class="report_header">Individual Report for ' + data['html']['survey_name'] + '</div>';
                if (data['html']['Individual_ReportData'] != null && data['html']['Individual_ReportData'].length != 0) {
                    individual_report_html += '<div>';
                    individual_report_html += '<div class="search-block row-fluid">';
                    individual_report_html += '<div class="span8" >';
                    individual_report_html += '    <span> Name <input type="text" name="name" id="name" placeholder=" Search By Name"></span>';
                    individual_report_html += '    <span> Module <select name="module_names" id="module_names" style="margin:0px">';
                    individual_report_html += '        <option value="">Select Module</option>';
                    individual_report_html += '        <option value="Accounts">Accounts</option>';
                    individual_report_html += '        <option value="Contacts">Contacts</option>';
                    individual_report_html += '        <option value="Leads">Leads</option>';
                    individual_report_html += '        <option value="Prospects">Targets</option>';
                    individual_report_html += '    </select></span>';
                    individual_report_html += '    <span>Type <select name="submission_type" id="submission_type" style="margin:0px">';
                    individual_report_html += '        <option value="Combined">Combined</option>';
                    individual_report_html += '        <option value="Email">Email</option>';
                    individual_report_html += '        <option value="Open Ended">Open Ended</option>';
                    individual_report_html += '    </select></span>';
                    individual_report_html += '</div>';
                    // Global Filter div START
                    var date_selected = '';
                    if (self.GF_Filter_By == 'by_date') {
                        date_selected = "selected";
                    }
                    var by_question_logic = '';
                    if (self.GF_Filter_By == 'by_question_logic') {
                        by_question_logic = "selected";
                    }
                    individual_report_html += '<div class="span4">';
                    individual_report_html += "<div class='pull-right' style='border-bottom:1px solid #ddd; background-color: #e9e9e9;height: 47px; box-shadow: 3px 3px 10px #ddd;'><span style='margin-left:3px;margin-top: 15px;'><i class='fa fa-filter' style='font-size:14px'>&nbsp;</i>Global Filter By &nbsp;&nbsp;</span><span style='margin-left: 3px;'><select name='global_filter_selection' style='margin-top: 5px;'><option value=''>Select Filter</option><option value='by_date' " + date_selected + ">Date</option><option value='by_question_logic' " + by_question_logic + ">Question Logic</option></select></span><span style='margin-top: 10px;margin-left: -8px;'><div title='Global Filter' class='btn btn-primary' data-surveyid='" + self.sid + "' data-button-clicked='Filter' id='global_filter'>Filter</div></span><span><div class='btn' data-surveyid='" + self.sid + "' data-button-clicked='Remove Filter' id='remove_global_filter' title='Reset Global Filter' style='margin-left: -5px; margin-right: 3px;margin-top: 5px;'  onclick='remove_logic(this,\"" + self.sid + "\");'><i class='fa fa-times'></i></div></span></div>";
                    individual_report_html += '</div>';
                    // Global Filter div END

                    individual_report_html += '</div>';
                    individual_report_html += '<div class="search-block row-fluid">';
                    individual_report_html += '<div class="span12" >';
                    individual_report_html += '    <span><input class="btn btn-primary" data-surveyid="' + data['html']['survey_id'] + '" data-button-clicked="search"  type="button" name="Search" id="Search" value="Search"  ></span>';
                    individual_report_html += '    <span><input class="btn btn-primary" data-surveyid="' + data['html']['survey_id'] + '" data-button-clicked="clear" type="button" name="Clear" id="Clear" value="Clear" ></span>';
                    individual_report_html += '    <span><input class="btn btn-primary" type="button" name="Export" id="Export" value="Export Result" ></span>';
                    individual_report_html += '</div>';
                    individual_report_html += '</div>';
                    individual_report_html += '<div id="validate_search"></div>';
                    individual_report_html += '<br/><br/>';
                    individual_report_html += '<div class="list-view" style="width:100%;">';
                    individual_report_html += '<table style="margin-bottom:5px !important; font-size: 15px;" class="table table-striped table-bordered table-condensed"><tbody><tr><td><div class="inside-pagination_individual" style="display:none;"><b>Survey Transactions</b> &nbsp;&nbsp;<i class="fa fa-chevron-left page-prev-recordsIndividual prev_individual" name="prev_individual"></i>&nbsp;<span class="min-record_individual"></span><span>-</span><span class="max-record_individual"></span>&nbsp;<i class="fa fa-chevron-right page-next-recordsIndividual next_individual" name="next_individual"></i> of <span class="total_records_individual"></span></div></td></tr></tbody></table>';
                    individual_report_html += '<input id="current_page_individual" type="hidden" value = "1" />';
                    individual_report_html += '<input id="max_records" type="hidden" value = "' + data['html']['max_records'] + '" />';
                    individual_report_html += '    <table class="table table-striped table-bordered table-condensed" id="search_result">';
                    individual_report_html += '        <thead><tr>';
                    individual_report_html += '            <th style="width:10%;" class="sort_name" data-surveyid="' + data['html']['survey_id'] + '">Name <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                    individual_report_html += '            <th style="width:10%;text-align:center;" class="sort_module" data-surveyid="' + data['html']['survey_id'] + '">Module <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                    individual_report_html += '            <th style="width:10%;text-align:center;" class="sort_type" data-surveyid="' + data['html']['survey_id'] + '">Type <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                    individual_report_html += '            <th style="width:15%;text-align:center;" class="sort_send_date" data-surveyid="' + data['html']['survey_id'] + '">Survey Send Date <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                    individual_report_html += '            <th style="width:15%;text-align:center;" class="sort_submission_date" data-surveyid="' + data['html']['survey_id'] + '">Survey Receive Date <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                    individual_report_html += '            <th style="width:15%;text-align:center;" class="sort_consent_accepted" data-surveyid="' + data['html']['survey_id'] + '">Consent Accepted? <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                    individual_report_html += '            <th style="width:15%;text-align:center;" class="sort_change_req" data-surveyid="' + data['html']['survey_id'] + '">Change Request <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                    individual_report_html += '            <th style="width:10%;text-align:center;">Resend</th>';
                    individual_report_html += '            <th style="width:5%;text-align:center;">Delete</th>';
                    individual_report_html += '        </tr></thead><tbody>';
                    var page_counter = 1;
                    var last_record = parseInt(data['html']['max_records']);
                    var max_records = parseInt(data['html']['max_records']);
                    var submitted_counter = 0;

                    $.each(data['html']['Individual_ReportData'], function (module, module_detail) {
                        if (module_detail['survey_status'] == 'Submitted')
                        {
                            submitted_counter++;
                            if (submitted_counter > last_record)
                            {
                                page_counter++;
                            }
                            individual_report_html += '<tr class="page_' + page_counter + ' record_individual">';
                            individual_report_html += '            <td><a href="javascript:void(0);" class="individual_div" data-surveyid="' + data['html']['survey_id'] + '" data-page="' + data['html']['page'] + '" data-module-id="' + module_detail['module_id'] + '" data-submission-id="' + module_detail['submission_id'] + '" >' + module_detail['name'] + '</a>';
                            individual_report_html += '            </td>';
                            individual_report_html += '            <td style="text-align:center">' + module_detail['module_type'] + '</td>';
                            individual_report_html += '            <td style="text-align:center">' + module_detail['submission_type'] + '</td>';
                            individual_report_html += '            <td style="text-align:center">' + module_detail['send_date'] + '</td>';
                            individual_report_html += '            <td style="text-align:center">' + module_detail['receive_date'] + '</td>';
                            individual_report_html += '            <td style="text-align:center">' + module_detail['consent_accepted'] + '</td>';
                            individual_report_html += '            <td id="request_status" style="text-align:center">';
                            if (module_detail['change_request'] == 'Pending') {
                                individual_report_html += "<a class='appReq' data-surveyid='" + data['html']['survey_id'] + "' data-module-id='" + module_detail['module_id'] + "' data-module-type='" + module_detail['module_name'] + "' data-submission-id='" + module_detail['submission_id'] + "' href='javascript:void(0);'>" + module_detail['change_request'] + "</a>";
                            } else {
                                individual_report_html += module_detail['change_request'];
                            }
                            individual_report_html += '</td><td id="re-send" style="text-align:center">';
                            if ((module_detail['survey_status'] == 'Submitted' || module_detail['survey_status'] == 'Viewed') && (module_detail['submission_type'] == 'Email')) {
                                individual_report_html += '<a class="resend" data-surveyid="' + data['html']['survey_id'] + '" data-module-id="' + module_detail['module_id'] + '" data-module-type="' + module_detail['module_name'] + '" data-submission-id="' + module_detail['submission_id'] + '" title="Re-send" href="javascript:void(0);" ><img src="custom/include/images/re-send.png" style="height: 22px;"></a>';
                            }
                            individual_report_html += '</td><td id="deleteSubmission" style="text-align:center">';
                            individual_report_html += '<a class="deleteSub" data-submissionId="' + module_detail['submission_id'] + '" title="Delete Response" href="javascript:void(0);" ><div class="btn"><i class="fa fa-times" style="font-size:16px">&nbsp;</i></div></a>';
                            individual_report_html += '</td></tr>';

                            if (submitted_counter == last_record + 1)
                            {
                                last_record += max_records;
                        }
                        }
                    });
                    individual_report_html += '</tbody></table></div></div>';
                    $('#hasSubmissions').val('true');
                } else {
                    individual_report_html += '<div>';
                    individual_report_html += '<div class="search-block row-fluid">';
                    individual_report_html += '<div class="span8"></div>';
                    // Global Filter div START
                    var date_selected = '';
                    if (self.GF_Filter_By == 'by_date') {
                        date_selected = "selected";
                    }
                    var by_question_logic = '';
                    if (self.GF_Filter_By == 'by_question_logic') {
                        by_question_logic = "selected";
                    }
                    individual_report_html += '<div class="span4">';
                    individual_report_html += "<div class='pull-right' style='border-bottom:1px solid #ddd; background-color: #e9e9e9;box-shadow: 3px 3px 10px #ddd;'><span><i class='fa fa-filter fa-2x'>&nbsp;</i>Global Filter By &nbsp;&nbsp;</span><span><select name='global_filter_selection'><option value=''>Select Filter</option><option value='by_date' " + date_selected + ">Date</option><option value='by_question_logic' " + by_question_logic + ">Question Logic</option></select></span><span><div title='Global Filter' class='btn btn-primary' data-surveyid='" + self.sid + "' data-button-clicked='Filter' id='global_filter'><i class='fa fa-search'></i>Filter</div></span><span><div class='btn' data-surveyid='" + self.sid + "' data-button-clicked='Remove Filter' id='remove_global_filter' title='Reset Global Filter' style='margin-left: -5px; margin-right: 3px;'  onclick='remove_logic(this,\"" + self.sid + "\");'><i class='fa fa-times'></i></div></span></div>";
                    individual_report_html += '</div>';
                    // Global Filter div END

                    individual_report_html += '</div>';
                    individual_report_html += '</div>';
                    individual_report_html += '<div id="question"><p align="center">There is no submission for this Survey.</p></div>';
                    $('#hasSubmissions').val('false');
                }
                $('#individual_report_data').html(individual_report_html);

                var values = submitted_counter;

                if (values && values <= max_records)
                {
                    $('.min-record_individual').html('1');
                    $('.max-record_individual').html(values);
                    $('.inside-pagination_individual').show();
                    $('.inside-pagination_individual').parents('table').show();
                    $('.prev_individual').css('color', '#d0d0d0').addClass('disabled');
                }
                if (values && values > max_records)
                {
                    $('.min-record_individual').html('1');
                    $('.max-record_individual').html(max_records);
                    $('.next_individual').css('color', '#000').removeClass('disabled').css('font-size', '16px').css('cursor', 'pointer');
                    $('.inside-pagination_individual').show();
                    $('.inside-pagination_individual').parents('table').show();
                    $('.prev_individual').css('color', '#d0d0d0').addClass('disabled');
                }
                if (values <= max_records)
                {
                    $('.next_individual').css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                    $('.prev_individual').css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                }
                if ($('.min-record_individual').parents('div').find('.answered_person').length != 0) {
                    $('.min-record_individual').parents('div').find('.answered_person').val(values);

                } else {
                    if ($('.min-record_individual').parents('div').find('.answered_person_individual').length == 0) {
                        $('.min-record_individual').parents('div').append('<input type="hidden" class="answered_person_individual" value="' + values + '" />');
                    } else {
                        $('.min-record_individual').parents('div').find('.answered_person_individual').val(values);
                    }
                }
                $('.total_records_individual').html(values + ' Records');
                $('.record_individual').hide();
                $('.min-record_individual').parents('div').find('.page_1').show();

                app.alert.dismiss('loading_report_view');
            }
        });
    },
    getNextPageRecordsIndividual: function (el) {
        if (!$(el.currentTarget).hasClass('disabled'))
        {
            var current_page = $('#current_page_individual').val();
            var next_page = parseInt(current_page) + 1;
            var total_records = $(el.currentTarget).parents('div').find('.answered_person_individual').val();
            var current_last_record = $('.max-record_individual').html();
            var next_page_first_record = parseInt(current_last_record) + 1;
            var next_page_last_record = '';
            var max_records = $('#max_records').val();
            var max_list_key = parseInt(max_records) - 1;
            total_records = parseInt(total_records);
            if (next_page_first_record + max_list_key >= total_records)
            {
                next_page_last_record = total_records;
                $('.next_individual').css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                $('.prev_individual').css('color', '#000').removeClass('disabled').css('font-size', '14px').css('cursor', 'pointer');
            } else {
                next_page_last_record = next_page_first_record + max_list_key;
                $('.prev_individual').css('color', '#000').removeClass('disabled').css('font-size', '14px').css('cursor', 'pointer');
            }
            $('.min-record_individual').html(next_page_first_record);
            $('.max-record_individual').html(next_page_last_record);
            $('#current_page_individual').val(next_page);
            if ($(el.currentTarget).parents('#individual_report_data_section').find('.page_' + next_page).length != 0)
            {
                $('.record_individual').hide();
                $(el.currentTarget).parents('#individual_report_data_section').find('.page_' + next_page).show();
            }
        }
    },
    getPrevPageRecordsIndividual: function (el) {

        if (!$(el.currentTarget).hasClass('disabled'))
        {

            var current_page = $('#current_page_individual').val();
            var prev_page = parseInt(current_page) - 1;
            var current_first_record = $('.min-record_individual').html();
            var next_page_last_record = parseInt(current_first_record) - 1;
            var max_records = $('#max_records').val();
            var max_list_key = parseInt(max_records) - 1;
            if (next_page_last_record > 0)
            {
                var next_page_first_record = next_page_last_record - max_list_key;
                if (prev_page == 1)
                {
                    $('.prev_individual').css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                }
                $('.next_individual').css('color', '#000').removeClass('disabled').css('font-size', '14px').css('cursor', 'pointer');
            }
            $('.min-record_individual').html(next_page_first_record);
            $('.max-record_individual').html(next_page_last_record);
            $('#current_page_individual').val(prev_page);
            if ($(el.currentTarget).parents('#individual_report_data_section').find('.page_' + prev_page).length != 0)
            {
                $('.record_individual').hide();
                $(el.currentTarget).parents('#individual_report_data_section').find('.page_' + prev_page).show();
            }
        }
    },
    /**load question wise report for the survey
     * 
     * @returns {undefined}
     */
    load_question_report: function (el) {
        $('#btn-export-report').show();
        $('#current_active_report_tab').val('question');
        app.alert.show('loading_report_view', {level: 'process', title: 'Please wait while report is loading', autoclose: false});
        var que_rep_type = 'question_combined';
        var report_type = 'combined';
        if (el && $(el.currentTarget))
        {
            que_rep_type = $(el.currentTarget).attr('class');
        }

        if (que_rep_type == 'question_email')
        {
            report_type = 'email';
            $('#question_report_data_email').show();
            $('#question_report_data_openended').hide();
            $('#question_report_data_combined').hide();
        } else if (que_rep_type == 'question_openended')
        {
            report_type = 'openended';
            $('#question_report_data_email').hide();
            $('#question_report_data_openended').show();
            $('#question_report_data_combined').hide();
        } else if (que_rep_type == 'question_combined')
        {
            report_type = 'combined';
            $('#question_report_data_email').hide();
            $('#question_report_data_openended').hide();
            $('#question_report_data_combined').show();
        }
        var self = this;
        self.button_clicked = 'question';
        var global_filter_by = getGlobalFilterURl(self);
        var result = new Array(), question_report_html = '';
        var url = App.api.buildURL("bc_survey", "get_report?survey_id=" + self.sid + '&status=' + self.button_clicked + '&status_type=' + report_type + global_filter_by, "", {});
        App.api.call('create', url, {}, {
            success: function (data) {
                var counter_display_matrix = data['counter_display_matrix'];
                result = self.Question_report_html(data, que_rep_type, report_type);
                question_report_html = result['question_report_html'];
                $('#question_report_data_' + report_type).html(question_report_html);
                if ($('#question_report_data_' + report_type).find('.numbers').length != 0)
                {
                    $('#question_report_data_' + report_type).find('.numbers').remove();
                }
                if (result['queReoort_pageNumbers'] != null && result['no_submission'] != "1") {
                    $('#question_report_data_' + report_type).append('<div class="numbers ' + report_type + '">' + result['queReoort_pageNumbers'] + '</div></div>');
                }

                if (result['max_record_counter'])
                {
                    $.each(result['max_record_counter'], function (qid, values) {

                        if (values && values > 1 && values <= 10)
                        {
                            $('.min-record_' + qid).html('1');
                            $('.max-record_' + qid).html(values);
                            $('.inside-pagination_' + qid).show();
                        }
                        if (values && values > 1 && values > 10)
                        {
                            $('.min-record_' + qid).html('1');
                            $('.max-record_' + qid).html('10');
                            $('.next_' + qid).css('color', '#000').css('font-size', '16px').css('cursor', 'pointer');
                            $('.inside-pagination_' + qid).show();
                        }
                        if (values <= 10)
                        {
                            $('.next_' + qid).css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                            $('.prev_' + qid).css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                        }
                        if ($('.min-record_' + qid).parents('th').find('.answered_person').length != 0) {
                            $('.min-record_' + qid).parents('th').find('.answered_person').val(values);
                        } else {
                            $('.min-record_' + qid).parents('th').append('<input type="hidden" class="answered_person" value="' + values + '" />');
                        }
                        $('.record_' + qid).hide();
                        $('.min-record_' + qid).parents('tbody').find('.page_1').show();
                    });
                }
                self.nps_chart_data_display(data, report_type);
                self.char_data_display(data, report_type);
                if (counter_display_matrix != null) {

                    // var submitted_counts = result['matrix_answers_counts'];
                    $.each(counter_display_matrix, function (qid, values) {
                        if (qid != 'page_title') {
                            $.each(values, function (row, row_values) {
                                $.each(row_values, function (col, value) {
                                    $('#multi_table_' + qid).find("#" + row + "_" + col + "").html(value);
                                });
                            });
                        }
                    });
                }
                app.alert.dismiss('loading_report_view');
            }
        });
    },
    /**generate question wise report html and required chart display
     * 
     * @param {type} data
     * @returns {Array|reportAnonym$0.Question_report_html.result}
     */
    Question_report_html: function (data, que_rep_type, report_type) {
        storeQuestionDefaultSettings('', '', '', true);
        var self = this;
        var html1, ans, is_active = '';
        var result = new Array();
        var matrix_answers_counts = new Object();
        var max_record_counter = new Object();
        var count_que = 0; //count question number for each page
        var submitted_ans, isTextField, isMultiChoiceField, rating, flag, chart_flag = 0;
        var question_report_html = '';
        var statsSupportedQtype = [
            'emojis', 'netpromoterscore', 'check-box', 'radio-button', 'dropdownlist', 'multiselectlist',
            'scale', 'matrix', 'boolean', 'rating'
        ];
        var statsTableForMatrix = '';
        var statsTableForOthers = '';
        var queReoort_pageNumbers = data['html']['queReoort_pageNumbers'];
        question_report_html += '<div class="report_header">Question Summary Report for ' + data['html']['survey_name'] + ' <span style="margin-right:10px;">(Total Responses :  ' + data['html']['total_submitted_que'] + ')</span></div>';
        question_report_html += '<div class="row-fluid">';
        question_report_html += '<div class="span8">';
        question_report_html += '<ul class="nav nav-tabs que-nav">';
        if (report_type == 'combined')
        {
            is_active = "active";
        }
        question_report_html += '  <li class="' + is_active + '"><a class="question_combined">Combined</a></li>';
        is_active = '';
        if (report_type == 'email')
        {
            is_active = "active";
        }
        question_report_html += '  <li class="' + is_active + '">';
        question_report_html += '    <a class="question_email">Email</a>';
        question_report_html += '  </li>';
        is_active = '';
        if (report_type == 'openended')
        {
            is_active = "active";
        }
        question_report_html += '  <li class="' + is_active + '"><a class="question_openended">Open Ended</a></li>';
        question_report_html += '</ul>';
        question_report_html += '</div>';
        // Global Filter div START
        question_report_html += '<div class="span4">';
        var date_selected = '';
        if (this.GF_Filter_By == 'by_date') {
            date_selected = "selected";
        }
        var by_question_logic = '';
        if (this.GF_Filter_By == 'by_question_logic') {
            by_question_logic = "selected";
        }
        question_report_html += "<div class='pull-right' style='border-bottom:1px solid #ddd; background-color: #e9e9e9;box-shadow: 3px 3px 10px #ddd;'><span style='margin-left:3px;'><i class='fa fa-filter' style='font-size:14px'>&nbsp;</i>Global Filter By &nbsp;&nbsp;</span><span style='margin-left: 3px;'><select name='global_filter_selection' style='margin-top: 9px;'><option value=''>Select Filter</option><option value='by_date' " + date_selected + ">Date</option><option value='by_question_logic' " + by_question_logic + ">Question Logic</option></select></span><span><div title='Global Filter' class='btn btn-primary' data-surveyid='" + self.sid + "' data-button-clicked='Filter' id='global_filter'>Filter</div></span><span><div class='btn' data-surveyid='" + self.sid + "' data-button-clicked='Remove Filter' id='remove_global_filter' title='Reset Global Filter' style='margin-left: 3px; margin-right: 3px;' onclick='remove_logic(this,\"" + self.sid + "\");'><i class='fa fa-times'></i></div></span></div>";
        question_report_html += '</div>';
        // Global Filter div END
        question_report_html += '</div>';
        question_report_html += '<div id=\'question_wise_data\'>';
        if ((typeof data['html']['QueReportData'] == "object" && data['html']['QueReportData'] != null) && data['html']['total_submitted_que'] != 0) {
            $.each(data['html']['QueReportData'], function (key, QueReportData) {
                $.each(QueReportData, function (key, survey_detail_array) {
                    $.each(survey_detail_array, function (qid, survey_detail) {
                        if (qid == 'page_title') {
                            if (typeof survey_detail == "object" && survey_detail != null) {
                                $.each(survey_detail, function (page_id, pagetitle) {
                                    if (page_id == data['html']['page'] && pagetitle !== null) {
                                        question_report_html += "<h1 class='alerts-info'>&nbsp;<i class='fa fa-file-text' style='color:#fff;'></i>&nbsp;" + pagetitle + "<i style='verticle-align:top;float:right; background-color:#fff;color:#0f7799; margin-bottom:5px;width:22px;height:22px;text-align:center;'><b>" + page_id + "</b></i></h1>";
                                    }
                                });
                            }
                        } else {
                            count_que++;
                            var Answered_person = 0;
                            var Skipped_person = 0;
                            var showExportButtons = true;
                            question_report_html += '<input class="" type="hidden" id="question_ID_val" value="' + qid + '">';
                            question_report_html += ' <table class="report_question_table" align="center" id="report_question_table_' + qid + '">';
                            question_report_html += '<tr class="question"><td colspan="3">&nbsp;<span style="verticle-align:top;float:left; background-color:#555; color:#fff;width:22px;height: 18px;text-align:center;">' + count_que + '</span>&nbsp; ' + survey_detail['name'] + '</td><tr>';
                            if (survey_detail['que_type'] == 'rating' || survey_detail['que_type'] == 'emojis' || survey_detail['que_type'] == 'netpromoterscore' || survey_detail['que_type'] == 'check-box' || survey_detail['que_type'] == 'radio-button' || survey_detail['que_type'] == 'dropdownlist' || survey_detail['que_type'] == 'multiselectlist' || survey_detail['que_type'] == 'scale' || survey_detail['que_type'] == 'matrix' || survey_detail['que_type'] == 'boolean')
                            {
                                question_report_html += '</table>';
                                question_report_html += '<div id="' + qid + '_' + report_type + '_question-trend-tabs" class="question-trend-tabs report-sub-tabs"><input class="reportview-hidden-info" type="hidden" id="' + qid + '_reportType" value="' + report_type + '"><ul class="nav nav-tabs question-trend-tbs-ul">  <li class="active"><a id="question-normal-report" class="question_normal question-normal-trend-tabs">Normal</a></li>  <li class="">    <a id="question-trend-report" class="question_trend question-normal-trend-tabs">Trend</a>  </li>  </ul></div>';
                                if (data['html']['AnsweredAndSkippedPerson'][qid]) {
                                    question_report_html += '<p align="center"><b>Answered Persons :&nbsp;</b>' + data['html']['AnsweredAndSkippedPerson'][qid]['answered'];
                                    question_report_html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' + data['html']['AnsweredAndSkippedPerson'][qid]['skipped'];
                                } else {
                                    showExportButtons = false;
                                    var multi_answered = 0;
                                    var multi_skipped = data['html']['total_submitted_que'];
                                    question_report_html += '<p align="center"><b>Answered Persons :&nbsp;</b>' + multi_answered;
                                    question_report_html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' + multi_skipped;
                                }
                                question_report_html += '</p>';
                                if (showExportButtons) {
                                question_report_html += '<div style="float: right;margin: -30px 27px 7px">Export As: <li title="PDF" class="fa fa-file-pdf-o questionPDFExport" id="questionPDFExport_' + qid + '"  style="font-size: 20px;padding: 0px 12px;cursor:pointer;"></li><li title="Image" class="fa fa-picture-o questionImageExport" id="questionImageExport_' + qid + '" style="font-size: 20px;cursor:pointer;"></li></div>';
                            }
                            }
                            if (survey_detail['que_type'] == 'contact-information')
                            {
                                if (data['html']['AnsweredAndSkippedPerson'][qid]) {
                                    question_report_html += '<tr><td><p align="center"><b>Answered Persons :&nbsp;</b>' + data['html']['AnsweredAndSkippedPerson'][qid]['answered'];
                                    question_report_html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' + data['html']['AnsweredAndSkippedPerson'][qid]['skipped'];
                                } else {
                                    showExportButtons = false;
                                    var multi_answered = 0;
                                    var multi_skipped = data['html']['total_submitted_que'];
                                    question_report_html += '<tr><td><p align="center"><b>Answered Persons :&nbsp;</b>' + multi_answered;
                                    question_report_html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' + multi_skipped;
                                }
                                question_report_html += '</p>';
                                if (showExportButtons) {
                                question_report_html += '<div style="float: right;margin: -27px 2px 7px;">Export As: <li title="PDF" class="fa fa-file-pdf-o questionPDFExport"  id="questionPDFExport_' + qid + '"  style="font-size: 20px;padding: 0px 10px;cursor:pointer;"></li></div>';
                                }
                                question_report_html += '</td></tr>';
                            }
                            if (survey_detail['que_type'] == 'contact-information' || survey_detail['que_type'] == 'commentbox' || survey_detail['que_type'] == 'textbox' || survey_detail['que_type'] == 'date-time' || survey_detail['que_type'] == 'doc-attachment') {
                                html1 = '';
                                if (survey_detail['que_type'] != 'doc-attachment')
                                {
                                    html1 += ' <tr class="thead">';
                                    html1 += '        <th width="80%" colspan="3">Submitted Data';
                                    if (survey_detail['que_type'] == 'commentbox' || survey_detail['que_type'] == 'textbox' || survey_detail['que_type'] == 'date-time' || survey_detail['que_type'] == 'doc-attachment')
                                    {
                                        html1 += '<div class="pull-right inside-pagination_' + qid + '" style="display:none;"><i class="fa fa-chevron-left page-prev-records prev_' + qid + '" name="prev_' + qid + '"></i>&nbsp;<span class="min-record_' + qid + '"></span><span>-</span><span class="max-record_' + qid + '"></span>&nbsp;<i class="fa fa-chevron-right page-next-records next_' + qid + '" name="next_' + qid + '"></i></div>';
                                        html1 += ' <input id="current_page_' + qid + '" type="hidden" value = "1" />';
                                        html1 += ' <input type="hidden" class="answered_person"  />';
                                    }
                                    html1 += '  </th>  </tr> ';
                                }
                            } else if (survey_detail['que_type'] == 'matrix') {
                                question_report_html += '</table><div id="chart_data_display" style="" class="question_structure ' + qid + '_' + report_type + '_normal_chartDiv" ><div><i title="Click to view different Charts and Stats" class="fa fa-bar-chart switch_chart_report_icon" style="cursor: pointer;font-size: 20px;margin-left: 30px;" id="' + qid + '_' + report_type + '"></i><input type="hidden" id="chart_selection_' + qid + '_' + report_type + '" value="stackedbarchart"><input type="hidden" class="question_type_' + qid + '" value="' + survey_detail['que_type'] + '"><input type="hidden" class="report_type_' + qid + '" value="' + report_type + '"><div id="switch_chart_popup_' + qid + '_' + report_type + '" style="display:none"> </div></div>';
                                question_report_html += '    <div class="row">';
                                question_report_html += '       <span  class = "span12" style = "">';
                                question_report_html += '       <div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_barchart" style = "width:100%; margin-left:0;margin-right:0;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_barchart" />';
                                question_report_html += '       <div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_columnchart" style = "width:100%; margin-left:0;margin-right:0;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_columnchart" />';
                                question_report_html += '       <div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_stackedcolumnchart" style = "width:100%; margin-left:0;margin-right:0;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_stackedcolumnchart" />';
                                question_report_html += '       <div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_stackedbarchart" style = "width:100%; margin-left:0;margin-right:0;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_stackedbarchart" />';
                                question_report_html += '       <div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_groupcolumnchart" style = "width:100%; margin-left:0;margin-right:0;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_groupcolumnchart" />';
                                question_report_html += '       </span ></div>';
                                question_report_html += '    <div class="">';
                                question_report_html += '       <span  class = "span12" style="margin-top:20px; margin-bottom:10px;" id="multi_table_' + qid + '">  ';
                                question_report_html += '       <div style=""> ';
                                var rows = survey_detail['matrix_row'];
                                var cols = survey_detail['matrix_col'];
                                //count number of rows & columns
                                if (typeof rows == 'object' & typeof cols == 'object')
                                {
                                    var row_count = Object.keys(rows).length + 1;
                                    var col_count = Object.keys(cols).length;
                                    // adjusting div width as per column
                                    var width = Math.round(70 / (col_count + 1)) - 1;
                                    question_report_html += '<table class="table table-striped  table-condensed">';
                                    for (var i = 1; i <= row_count; i++) {
                                        var firstTR = false;
                                        question_report_html += '<tr>';
                                        for (var j = 1; j <= col_count + 1; j++) {

                                            //First row & first column as blank
                                            if (j == 1 && i == 1) {
                                                firstTR = true;
                                                question_report_html += "<td class='matrix-span' style='width:" + width + "%;text-align:left;border: 1px solid #D4CECE; padding:10px; margin:0px;'>&nbsp;</td>";
                                            }
                                            // Rows Label
                                            if (j == 1 && i != 1) {
                                                question_report_html += "<td class='matrix-span' style='font-weight:bold; width:" + width + "%;;text-align:left;border: 1px solid #D4CECE;padding:10px; margin:0px;'>" + rows[i - 1] + "</td>";
                                            } else {
                                                //Columns label
                                                if (j <= col_count + 1 && cols[j - 1] != null && !(j == 1 && i == 1) && (i == 1 || j == 1))
                                                {
                                                    question_report_html += "<td class='matrix-span' style='font-weight:bold; width:" + width + "%;border: 1px solid #D4CECE;padding:10px; margin:0px;'><span class='stats-lbl ansSeqStats_" + qid + "' style='display:none; float:none; '>(" + parseInt(j - 1) + ")</span>&nbsp;" + cols[j - 1] + " </td>";
                                                }
                                                //Display answer input (RadioButton or Checkbox)
                                                else if (j != 1 && i != 1 && cols[j - 1] != null) {
                                                    var row = i - 1;
                                                    var col = j - 1;
                                                    question_report_html += "<td class='matrix-span' style='width:" + width + "%;border: 1px solid #D4CECE;padding:10px; margin:0px; '  id='" + row + "_" + col + "' name='matrix" + row + "'>0&nbsp;(0.00%)</td>";
                                                }
                                                // If no value then display none
                                                else {
                                                    question_report_html += "";
                                                }
                                            }

                                        }
                                        var sty = '';
                                        if (firstTR) {
                                            var lbl = 'Count';
                                            sty = 'font-weight:bold;';
                                        } else {
                                            if (typeof data['responseCountArray'][qid] == 'undefined') {
                                                var lbl = 0;
                                            } else {
                                                var lbl = 0
                                                if (typeof data['responseCountArray'][qid][row] != 'undefined') {
                                                    var lbl = data['responseCountArray'][qid][row];
                                                }
                                            }

                                        }
                                        question_report_html += "<td class='matrix-span' style='width:" + width + "%;text-align:left;border: 1px solid #D4CECE; padding:10px; margin:0px;" + sty + "'>" + lbl + "</td>";
                                        question_report_html += '</tr>';
                                    }
                                }
                                question_report_html += "</table>";
                                statsTableForOthers += '<span class="matrix-stats-data-table" ><table id="' + qid + '_stats_tbl_' + report_type + '" class = "table table-striped table-bordered table-condensed" align="left" style = "width:90%; margin-top:20px;display:none;" ><thead>';
                                statsTableForOthers += '<tr class="thead">';
                                statsTableForOthers += '<td rowspan="2">Row</td>';
                                statsTableForOthers += '<td colspan="2">Range</td> ';
                                statsTableForOthers += '<td colspan="2">Least Frequent</td>';
                                statsTableForOthers += '<td colspan="2">Most Frequent</td>';
                                statsTableForOthers += '<td rowspan="2">Mean</td>';
                                statsTableForOthers += '<td rowspan="2">Median</td>';
                                statsTableForOthers += '<td rowspan="2">Standard Deviation</td>';
                                statsTableForOthers += '<td rowspan="2">Variance</td>';
                                statsTableForOthers += '</tr>';
                                statsTableForOthers += '<tr class="thead">';
                                statsTableForOthers += '<td>From</td>';
                                statsTableForOthers += '<td>To</td>';
                                statsTableForOthers += '<td>Frequency</td>';
                                statsTableForOthers += '<td>Value</td>';
                                statsTableForOthers += '<td>Frequency</td>';
                                statsTableForOthers += '<td>Value</td>';
                                statsTableForOthers += '</tr></thead><tbody>';
                                if ($.inArray(survey_detail['que_type'], statsSupportedQtype) !== -1) {
                                    if (typeof data['statsDataArray'][qid] == 'undefined' || data['statsDataArray'][qid] == '') {
                                        statsTableForOthers += '<tr><td colspan="11" style="text-align: center;"> There is no stats data for this question.</td></tr>';
                                    } else {
                                        $.each(data['statsDataArray'][qid], function (key, statsDataArr) {
                                            statsTableForOthers += '<tr class="">';
                                            statsTableForOthers += '<td>' + key + '</td>';
                                            statsTableForOthers += '<td>' + statsDataArr['range']['from'] + '</td>';
                                            statsTableForOthers += '<td>' + statsDataArr['range']['to'] + '</td>';
                                            statsTableForOthers += '<td>' + statsDataArr['leastFreq']['lfreqCount'] + '</td>';
                                            statsTableForOthers += '<td>' + statsDataArr['leastFreq']['lfreqVal'] + '</td>';
                                            statsTableForOthers += '<td>' + statsDataArr['mostFreq']['mfreqCount'] + '</td>';
                                            statsTableForOthers += '<td>' + statsDataArr['mostFreq']['mfreqVal'] + '</td>';
                                            statsTableForOthers += '<td style="text-align: center;">' + statsDataArr['mean'] + '</td>';
                                            statsTableForOthers += '<td style="text-align: center;">' + statsDataArr['median'] + '</td>';
                                            statsTableForOthers += '<td style="text-align: center;">' + statsDataArr['sd'] + '</td>';
                                            statsTableForOthers += '<td style="text-align: center;">' + statsDataArr['variance'] + '</td>';
                                            statsTableForOthers += '</tr>';
                                        });
                                    }
                                }
                                statsTableForOthers += '</tbody></table></span>';
                                question_report_html += statsTableForOthers;
                                statsTableForOthers = '';
                                question_report_html += '</div><table>';
                            } else if (survey_detail['que_type'] == 'netpromoterscore') {
                                question_report_html += '<div id="chart_data_display" class="question_structure row ' + qid + '_' + report_type + '_normal_chartDiv"><div><i title="Click to view different Charts and Stats" class="fa fa-bar-chart switch_chart_report_icon" style="cursor: pointer;font-size: 20px;margin-left: 30px;" id="' + qid + '_' + report_type + '"></i><input type="hidden" id="chart_selection_' + qid + '_' + report_type + '" value="npsgaugechart"><input type="hidden" class="question_type_' + qid + '" value="' + survey_detail['que_type'] + '"><input type="hidden" class="report_type_' + qid + '" value="' + report_type + '"><div id="switch_chart_popup_' + qid + '_' + report_type + '" style="display:none"> </div></div>';
                            } else {
                                if (survey_detail['que_type'] == 'scale')
                                {
                                    question_report_html += '</table>';
                                }
                                statsTableForOthers += '<span class="stats-data-table" ><table id="' + qid + '_stats_tbl_' + report_type + '" align="left" class = "table table-striped table-bordered table-condensed" style = "width:90%; margin-top:6%;display:none;" ><thead>';
                                statsTableForOthers += '<tr class="thead">';
                                // statsTableForOthers += '<td rowspan="2">Row</td>';
                                statsTableForOthers += '<td colspan="2">Range</td> ';
                                statsTableForOthers += '<td colspan="2">Least Frequent</td>';
                                statsTableForOthers += '<td colspan="2">Most Frequent</td>';
                                statsTableForOthers += '<td rowspan="2">Mean</td>';
                                statsTableForOthers += '<td rowspan="2">Median</td>';
                                statsTableForOthers += '<td rowspan="2">Standard Deviation</td>';
                                statsTableForOthers += '<td rowspan="2">Variance</td>';
                                statsTableForOthers += '</tr>';
                                statsTableForOthers += '<tr class="thead">';
                                statsTableForOthers += '<td>From</td>';
                                statsTableForOthers += '<td>To</td>';
                                statsTableForOthers += '<td>Frequency</td>';
                                statsTableForOthers += '<td>Value</td>';
                                statsTableForOthers += '<td>Frequency</td>';
                                statsTableForOthers += '<td>Value</td>';
                                statsTableForOthers += '</tr></thead>';
                                question_report_html += '<div id="chart_data_display" class="question_structure row ' + qid + '_' + report_type + '_normal_chartDiv"><div style="top: 20px;"><i title="Click to view different Charts and Stats" class="fa fa-bar-chart switch_chart_report_icon" style="cursor: pointer;font-size: 20px;margin-left: 30px;" id="' + qid + '_' + report_type + '"></i><input type="hidden" id="chart_selection_' + qid + '_' + report_type + '" value="barchart"><input type="hidden" class="question_type_' + qid + '" value="' + survey_detail['que_type'] + '"><input type="hidden" class="report_type_' + qid + '" value="' + report_type + '"><div id="switch_chart_popup_' + qid + '_' + report_type + '" style="display:none"> </div></div>';
                                question_report_html += '       <span align = "center" class = "span12 charts-data-class report-data-table" >';
                                question_report_html += '<div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_barchart" style = "width: 100%; height: 300px;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_barchart" />';
                                question_report_html += '<div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_piechart" style = "width:70%; height: 300px;margin-left:360px" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_piechart" />';
                                question_report_html += '<div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_columnchart" style = "width: 100%; height: 300px;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_columnchart" />';
                                question_report_html += '<div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_linechart" style = "width: 100%; height: 300px;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_linechart" />';
                                question_report_html += ' </span >';
                                question_report_html += '       <span align = "center" class = "span12 table-data-class report-data-table" >';
                                if (survey_detail['que_type'] == 'check-box' || survey_detail['que_type'] == 'radio-button') {
                                    $.each(survey_detail['answers'], function (k, answers) {
                                        if (answers != "undefined" || answers != '' || answers != null) {
                                            question_report_html += answers['ans_image'];
                                        }
                                    });
                                    question_report_html += '';
                                }
                                question_report_html += '<div class="trend-tbl-class1 normal-table-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
                                question_report_html += '       <thead > <tr class = "thead" >';
                                question_report_html += '      <th width = "70%" ><b>Submitted Data</b> <div class="olFontClass"><b>Submitted Data</b></div> </th>';
                                if (survey_detail['enable_scoring'] == 1)
                                {
                                    question_report_html += '       <th width = "10%" style=""><b>Weight</b> <div class="olFontClass"><b>Weight</b></div>  </th>';
                                }
                                question_report_html += '       <th width = "10%" style=""> <b>Percentage</b> <div class="olFontClass"><b>Percentage</b></div>  </th>';
                                question_report_html += '       <th width = "10%" style=""> <b>Count</b> <div class="olFontClass"><b>Count</b></div> </th>';
                                question_report_html += '       </tr>';
                            }
                            if (survey_detail['que_type'] == 'contact-information' && (typeof survey_detail['answers'] != "undefined" && survey_detail['answers'] != null)) {
                                question_report_html += ' <tbody><tr><td class="two-col-table">';
                            }
                            var rating_div = 0;
                            var multi_data = Array('Task', 'Percentage');
                            var Answered_person_mutichoice = 0;
                            var Skipped_person_multichoice = 0;
                            var contact_flag = 0;
                            if (typeof survey_detail['answers'] != "undefined" && survey_detail['answers'] != null)
                            {
                                isMultiChoiceField = 1;
                                Answered_person_mutichoice++;
                                var isNullContactInfo = false;
                                //  var matrix_count = 0; // matrix answer index counter
                                //  matrix_answers_counts[qid] = new Array();
                                var page_counter = 1;
                                var last_record = 10;
                                var npstblThCounter = 0;
                                var emojisCounter = 0;
                                var emojisImges = {
                                    0: "<img src='custom/include/images/ext-unsatisfy.png' width='3%' />",
                                    1: "<img src='custom/include/images/unsatisfy.png'  width='3%' />",
                                    2: "<img src='custom/include/images/nuteral.png' width='3%' />",
                                    3: "<img src='custom/include/images/satisfy.png' width='3%' />",
                                    4: "<img src='custom/include/images/ext-satisfy.png' width='3%' />",
                                };
                                $.each(survey_detail['answers'], function (k, answers) {

                                    var count = 1; // matrix answer submission counter
                                    if (survey_detail['que_type'] == 'contact-information') {

                                        if (answers['ans_name'] && Object.keys(answers['ans_name']).length > 0) {
                                            question_report_html += '<table>';
                                            $.each(answers['ans_name'], function (title, answer_text) {
                                                if (title == 'Address') {
                                                    title = 'Street1';
                                                }
                                                if (title == 'Address2') {
                                                    title = 'Street2';
                                                }
                                                question_report_html += '<tr  class="respond_con"> <th>' + title + ' :</th><td>';
                                                if (answer_text) {
                                                    question_report_html += answer_text;
                                                } else {
                                                    question_report_html += 'N/A';
                                                }
                                                question_report_html += '</td></tr>';
                                            });
                                            if (answers['ans_name'] == "undefined" || answers['ans_name'] == '' || answers['ans_name'] == null) {
                                                question_report_html += '<td><p align="center">There is no submission for this Question.</p></td>';
                                            }
                                            question_report_html += '</table>';
                                            isNullContactInfo = false;
                                        } else {
                                            isNullContactInfo = true;
                                        }

                                        contact_flag = 1;
                                    } else if (survey_detail['que_type'] == 'commentbox' || survey_detail['que_type'] == 'textbox' || survey_detail['que_type'] == 'date-time') {

                                        if (typeof answers == "object" && answers != null && answers['ans_name'] != '') {
                                            $.each(answers, function (ans_label, ans) {
                                                if (ans != '') {
                                                    Answered_person++;
                                                    if (Answered_person > last_record)
                                                    {
                                                        page_counter++;
                                                    }
                                                } else {
                                                    Skipped_person++;
                                                }
                                                submitted_ans = ans != '' ? '<tr class="page_' + page_counter + ' record_' + qid + '"><td colspan="4">' + ans + '</td></tr>' : '';
                                                html1 += submitted_ans;
                                            });
                                        } else {
                                            submitted_ans = '<tr class="page_' + page_counter + ' record_' + qid + '"><td colspan="3">There is no submission for this question</td></tr>';
                                            html1 += submitted_ans;
                                        }

                                        if (Answered_person == last_record + 1)
                                        {
                                            last_record += 10;
                                        }

                                        if (survey_detail['total_answer_count']) {
                                            isTextField = 1;
                                        } else {
                                            question_report_html += '<tr><td colspan="3">There is no submission for this question</td></tr>';
                                            question_report_html += '</p>';
                                            question_report_html += '</td>';
                                            question_report_html += '</tr> ';
                                        }
                                    } else if (survey_detail['que_type'] == 'doc-attachment') {
                                        if (typeof answers == "object" && answers != null) {
                                            $.each(answers, function (ans_label, ans) {
                                                if (ans != '' && ans != 'N/A' && ans != 'n/a') {
                                                    Answered_person++;
                                                    if (Answered_person > last_record)
                                                    {
                                                        page_counter++;
                                                    }
                                                } else {
                                                    Skipped_person++;
                                                }
                                            });
                                        } else {

                                            if (ans != '') {
                                                Answered_person++;
                                            } else {
                                                Skipped_person++;
                                            }
                                        }

                                        if (survey_detail['total_answer_count']) {
                                            isTextField = 3;
                                        }
                                    }
                                    /*else if (survey_detail['que_type'] == 'rating') {
                                     question_report_html += '<tr>';
                                     if (rating_div == 0) {
                                     var rating_final_count = new Array();
                                     rating_final_count = data['html']['rating_final_count'][qid];
                                     question_report_html += '  <td>';
                                     if (survey_detail['max_size'] != null) {
                                     var starCount = survey_detail['max_size'];
                                     } else {
                                     var starCount = 5;
                                     }
                                     var star = new Array();
                                     for (var counter = starCount; counter > 0; counter--)
                                     {
                                     var stars = '';
                                     for (var star_loop = 0; star_loop < counter; star_loop++) {
                                     stars += '<i class="fa fa-star fa-2x" style="font-size:18px;color:#F4B30A; margin-right:3px;">&nbsp; </i>';
                                     }
                                     if (stars == null || stars == '') {
                                     stars = '<i class="fa fa-star fa-2x" style="font-size:18px; margin-right:3px;">&nbsp; </i>';
                                     }
                                     star[counter] = stars;
                                     }
                                     for (var counter = starCount; counter > 0; counter--)
                                     {
                                     question_report_html += '      <div class = "rating-block" > <div class = "rating" style="width:17%" > ' + star[counter] + '</div>  <div id="progressbar-' + counter + '_' + qid + '"  class="progress"><div class="bar"></div > </div> <div class="rating-count">' + rating_final_count[counter] + '</div > </div>';
                                     }
                                     question_report_html += '      </td>';
                                     if (typeof data['html']['survey_for_rating'][qid] == 'undefined') {
                                     question_report_html += '';
                                     } else {
                                     question_report_html += data['html']['survey_for_rating'][qid];
                                     }
                                     }
                                     rating_div = rating_div + 1;
                                     question_report_html += '</tr>';
                                     } */else if (survey_detail['que_type'] != 'emojis' && survey_detail['que_type'] != 'netpromoterscore' && survey_detail['que_type'] != 'image' && survey_detail['que_type'] != 'video' && survey_detail['que_type'] != 'matrix' && survey_detail['que_type'] != 'rating')
                                    {

                                        if (answers != "undefined" || answers != '' || answers != null) {

                                            question_report_html += '<tr width="50%">';
                                            question_report_html += ' <td > <span class="stats-lbl ansSeqStats_' + qid + '" style="display:none;float:none;">(' + answers['answer_sequence'] + ')</span> &nbsp;' + answers['ans_name'] + '</td>';
                                            if (survey_detail['enable_scoring'] == 1)
                                            {
                                                question_report_html += '<td style=""> ';
                                                question_report_html += answers['weight'];
                                                question_report_html += '</td>';
                                            }
                                            question_report_html += '<td style=""> ';
                                            if (answers['percent']) {
                                                question_report_html += answers['percent'] + '%';
                                            } else {
                                                question_report_html += 'N/A';
                                            }
                                            question_report_html += '</td>';
                                            question_report_html += '<td style="">' + answers['sub_ans'] + '</td>';
                                            question_report_html += '  </tr>';
                                            flag = 1;
                                        } else {
                                            question_report_html += '<tr><td colspan="3">There is no submission for this question</td></tr>';
                                            question_report_html += '</p>';
                                            question_report_html += '</td>';
                                            question_report_html += '</tr> ';
                                        }
                                    } else if (survey_detail['que_type'] == 'netpromoterscore')
                                    {
                                        if (npstblThCounter == 0) {
                                            question_report_html += '<div class="chart-nps nps_normal_chart" id="nps_normal_chart_' + qid + '" style="">';
                                            question_report_html += '       <span align = "center" class = "span6 charts-data-class report-data-table" > ';
                                            question_report_html += '<div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_npsbarchart" style = "width: 100%; height: 300px;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_npsbarchart" />';
                                            question_report_html += '<div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_piechart" style = "width: 70%; height: 300px;margin-left:360px" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_piechart" />';
                                            question_report_html += '<div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_columnchart" style = "width: 100%; height: 300px;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_columnchart" />';
                                            question_report_html += '<div class="' + qid + '_otherqueType" id = "' + qid + '_' + report_type + '_linechart" style = "width: 100%; height: 300px;" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_linechart" />';
                                            question_report_html += ' </span >';
                                            question_report_html += '       <span align = "center" class = "span6 table-data-class report-data-table" id="nps_normal_tbl_' + qid + '" >';
                                            question_report_html += '<div class="trend-tbl-class1 normal-table-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
                                            question_report_html += '       <tbody > <tr class = "thead" >';
                                            question_report_html += '      <th width = "70%" > <b>Submitted Data</b><div class="olFontClass"><b>Submitted Data</b></div> </th>';
                                            if (survey_detail['enable_scoring'] == 1)
                                            {
                                                question_report_html += '       <th width = "10%" style="" ><b>Weight</b><div class="olFontClass"><b>Weight</b></div>  </th>';
                                            }
                                            question_report_html += '       <th width = "10%" style=""> <b>Percentage</b><div class="olFontClass"><b>Percentage</b></div> </th>';
                                            question_report_html += '       <th width = "10%" style=""> <b>Count</b><div class="olFontClass"><b>Count</b></div> </th>';
                                            question_report_html += '       </tr>';
                                            npstblThCounter = 1;
                                        }
                                        if (answers != "undefined" || answers != '' || answers != null) {

                                            question_report_html += '<tr width="50%">';
                                            question_report_html += ' <td > <span class="stats-lbl ansSeqStats_' + qid + '" style="display:none;float:none;">(' + answers['answer_sequence'] + ')</span> ' + answers['ans_name'] + ' </td>';
                                            if (survey_detail['enable_scoring'] == 1)
                                            {
                                                question_report_html += '<td style=""> ';
                                                question_report_html += answers['weight'];
                                                question_report_html += '</td>';
                                            }
                                            question_report_html += '<td style=""> ';
                                            if (answers['percent']) {
                                                question_report_html += answers['percent'] + '%';
                                            } else {
                                                question_report_html += 'N/A';
                                            }
                                            question_report_html += '</td>';
                                            question_report_html += '<td style="">' + answers['sub_ans'] + '</td>';
                                            question_report_html += '  </tr>';
                                            flag = 1;
                                        } else {
                                            question_report_html += '<tr><td colspan="3">There is no submission for this question</td></tr>';
                                            question_report_html += '</p>';
                                            question_report_html += '</td>';
                                            question_report_html += '</tr>';
                                        }
                                    } else if (survey_detail['que_type'] == 'emojis') {
                                        if (answers != "undefined" || answers != '' || answers != null) {

                                            question_report_html += '<tr width="50%">';
                                            question_report_html += ' <td > <span class="stats-lbl ansSeqStats_' + qid + '" style="display:none;float:none;margin: 6px 3px 0 2px !important;">(' + answers['answer_sequence'] + ')</span> ' + emojisImges[emojisCounter] + ' ' + answers['ans_name'] + '  </td>';
                                            if (survey_detail['enable_scoring'] == 1)
                                            {
                                                question_report_html += '<td style=""> ';
                                                question_report_html += answers['weight'];
                                                question_report_html += '</td>';
                                            }
                                            question_report_html += '<td style=""> ';
                                            if (answers['percent']) {
                                                question_report_html += answers['percent'] + '%';
                                            } else {
                                                question_report_html += 'N/A';
                                            }
                                            question_report_html += '</td>';
                                            question_report_html += '<td style="">' + answers['sub_ans'] + '</td>';
                                            question_report_html += '  </tr>';
                                            flag = 1;
                                        } else {
                                            question_report_html += '<tr><td colspan="3">There is no submission for this question</td></tr>';
                                            question_report_html += '</p>';
                                            question_report_html += '</td>';
                                            question_report_html += '</tr> ';
                                        }
                                        emojisCounter++;
                                    } else if (survey_detail['que_type'] == 'matrix') {
                                        ;
                                        if (answers != "undefined" || answers != '' || answers != null) {
                                            // set other flags & div completion for matrix type report
                                            flag = 2;
                                        }
                                    }
                                });
                                if (survey_detail['que_type'] == 'rating') {
                                    if (survey_detail['max_size'] != null) {
                                        var starCount = survey_detail['max_size'];
                                    } else {
                                        var starCount = 5;
                                    }
                                    if (data['html']['rating_final_count'][qid] != "undefined" || data['html']['rating_final_count'][qid] != '' || data['html']['rating_final_count'][qid] != null) {
                                        var ratingPercent = data['html']['rating_final_percent'][qid];
                                        $.each(data['html']['rating_final_count'][qid], function (starNum, starSubVal) {
                                            if (starNum > 0) {
                                                var stars = '';
                                                question_report_html += '<tr width="50%">';
                                                for (var counter = 1; counter <= starNum; counter++)
                                                {
                                                    stars += '<i class="fa fa-star fa-2x" style="font-size:18px;color:#F4B30A; margin-right:3px;">&nbsp; </i>';
                                                }
                                                question_report_html += ' <td > <span class="stats-lbl ansSeqStats_' + qid + '" style="display:none;float:none;">(' + starNum + ')</span> &nbsp; ' + stars + '</td>';
                                                question_report_html += '<td style=""> ';
                                                if (ratingPercent[starNum]) {
                                                    question_report_html += ratingPercent[starNum] + '%';
                                                } else {
                                                    question_report_html += '0.00%';
                                                }
                                                question_report_html += '</td>';
                                                question_report_html += '<td style="">' + starSubVal + '</td>';
                                                question_report_html += '  </tr>';
                                            }
                                        });
                                        flag = 1;
                                    } else {
                                        question_report_html += '<tr><td colspan="3">There is no submission for this question</td></tr>';
                                        question_report_html += '</p>';
                                        question_report_html += '</td>';
                                        question_report_html += '</tr> ';
                                    }
                                }
                                if (survey_detail['que_type'] == 'netpromoterscore') {
                                    question_report_html += '</tbody ></table></div></div>';
                                    statsTableForOthers += '<span class="stats-data-table" ><table id="' + qid + '_stats_tbl_' + report_type + '" class = "table table-striped table-bordered table-condensed" align="left" style = "width:90%; margin-top:6%;display:none;" ><thead>';
                                    statsTableForOthers += '<tr class="thead">';
                                    // statsTableForOthers += '<td rowspan="2">Row</td>';
                                    statsTableForOthers += '<td colspan="2">Range</td> ';
                                    statsTableForOthers += '<td colspan="2">Least Frequent</td>';
                                    statsTableForOthers += '<td colspan="2">Most Frequent</td>';
                                    statsTableForOthers += '<td rowspan="2">Mean</td>';
                                    statsTableForOthers += '<td rowspan="2">Median</td>';
                                    statsTableForOthers += '<td rowspan="2">Standard Deviation</td>';
                                    statsTableForOthers += '<td rowspan="2">Variance</td>';
                                    statsTableForOthers += '</tr>';
                                    statsTableForOthers += '<tr class="thead">';
                                    statsTableForOthers += '<td>From</td>';
                                    statsTableForOthers += '<td>To</td>';
                                    statsTableForOthers += '<td>Frequency</td>';
                                    statsTableForOthers += '<td>Value</td>';
                                    statsTableForOthers += '<td>Frequency</td>';
                                    statsTableForOthers += '<td>Value</td>';
                                    statsTableForOthers += '</tr></thead><tbody>';
                                    if ($.inArray(survey_detail['que_type'], statsSupportedQtype) !== -1) {
                                        statsTableForOthers += '<tr class="">';
                                        if (typeof data['statsDataArray'][qid] == 'undefined' || data['statsDataArray'][qid] == '') {
                                            statsTableForOthers += '<td colspan="10" style="text-align: center;"> There is no stats data for this question.</td>';
                                        } else {
                                            statsTableForOthers += '<td>' + data['statsDataArray'][qid]['range']['from'] + '</td>';
                                            statsTableForOthers += '<td>' + data['statsDataArray'][qid]['range']['to'] + '</td>';
                                            statsTableForOthers += '<td>' + data['statsDataArray'][qid]['leastFreq']['lfreqCount'] + '</td>';
                                            statsTableForOthers += '<td>' + data['statsDataArray'][qid]['leastFreq']['lfreqVal'] + '</td>';
                                            statsTableForOthers += '<td>' + data['statsDataArray'][qid]['mostFreq']['mfreqCount'] + '</td>';
                                            statsTableForOthers += '<td>' + data['statsDataArray'][qid]['mostFreq']['mfreqVal'] + '</td>';
                                            statsTableForOthers += '<td style="text-align: center;">' + data['statsDataArray'][qid]['mean'] + '</td>';
                                            statsTableForOthers += '<td style="text-align: center;">' + data['statsDataArray'][qid]['median'] + '</td>';
                                            statsTableForOthers += '<td style="text-align: center;">' + data['statsDataArray'][qid]['sd'] + '</td>';
                                            statsTableForOthers += '<td style="text-align: center;">' + data['statsDataArray'][qid]['variance'] + '</td>';
                                        }
                                        statsTableForOthers += '</tr>';
                                    }
                                    statsTableForOthers += '</tbody></table></span>';
                                    question_report_html += '</span>';
                                    question_report_html += '</div>';
                                    question_report_html += '<div class="chart-nps nps_gauge_chart" id="nps_gauge_chart_' + qid + '" >';
                                    question_report_html += '       <span align = "center" class = "span12" > <div id = "' + qid + '_' + report_type + '_gauge" class="table-chart-new-class"  style = "display:table;width: auto; height: 300px; margin: 0px auto" > </div><input type="hidden" id="pdf_chart_img_' + qid + '_' + report_type + '_gauge" /></span >';
                                    question_report_html += '       <span align = "center" class = "span12" style="margin-left:0;"> <table align = "left" id = "multi_table" class = "normal-table-class1 table table-striped table-bordered table-condensed" style = "" >';
                                    question_report_html += '       <tbody > <tr class = "thead" >';
                                    question_report_html += '      <th > <span class="stats-lbl ansSeqStats_' + qid + '" style="display:none;float:none;">(1)</span> Detractors (0-6) </th>';
                                    question_report_html += '       <th> <span class="stats-lbl ansSeqStats_' + qid + '" style="display:none;float:none;">(2)</span> Passives (7-8) </th>';
                                    question_report_html += '       <th> <span class="stats-lbl ansSeqStats_' + qid + '" style="display:none;float:none;">(3)</span> Promoters (9-10)  </th>';
                                    question_report_html += '       <th> Net Promoter Score </th>';
                                    question_report_html += '       </tr>';
                                    question_report_html += '<tr width="50%">';
                                    question_report_html += ' <td style=""> ' + survey_detail['nps_default_data_table']['detractores'] + ' </td>';
                                    question_report_html += ' <td style=""> ' + survey_detail['nps_default_data_table']['passives'] + ' </td>';
                                    question_report_html += ' <td style=""> ' + survey_detail['nps_default_data_table']['promoters'] + ' </td>';
                                    question_report_html += ' <td style=""> ' + survey_detail['nps_default_data_table']['npsscore'] + ' </td>';
                                    question_report_html += '  </tr></tbody></table>';
                                    question_report_html += '</span></div>';
                                    question_report_html += statsTableForOthers;
                                    flag = 1;
                                }
                                // BugFix :: Rating answer is skipped then show blank submission table format of rating :: START
                                /*  if (survey_detail['answers'].length == 0 && survey_detail['que_type'] == 'rating') {
                                 question_report_html += '<tr>';
                                 if (rating_div == 0) {
                                 var rating_final_count = new Array();
                                 rating_final_count = data['html']['rating_final_count'][qid];
                                 question_report_html += '  <td>';
                                 if (survey_detail['max_size'] != null) {
                                 var starCount = survey_detail['max_size'];
                                 } else {
                                 var starCount = 5;
                                 }
                                 var star = new Array();
                                 for (var counter = starCount; counter > 0; counter--)
                                 {
                                 var stars = '';
                                 for (var star_loop = 0; star_loop < counter; star_loop++) {
                                 stars += '<i class="fa fa-star fa-2x" style="font-size:18px;color:#F4B30A; margin-right:3px;">&nbsp; </i>';
                                 }
                                 if (stars == null || stars == '') {
                                 stars = '<i class="fa fa-star fa-2x" style="font-size:18px; margin-right:3px;">&nbsp; </i>';
                                 }
                                 star[counter] = stars;
                                 }
                                 for (var counter = starCount; counter > 0; counter--)
                                 {
                                 question_report_html += '      <div class = "rating-block" > <div class = "rating" style="width:17%" > ' + star[counter] + '</div>  <div id="progressbar-' + counter + '_' + qid + '"  class="progress"><div class="bar"></div > </div> <div class="rating-count">' + rating_final_count[counter] + '</div > </div>';
                                 }
                                 question_report_html += '      </td>';
                                 if (typeof data['html']['survey_for_rating'][qid] == 'undefined') {
                                 question_report_html += '';
                                 } else {
                                 question_report_html += data['html']['survey_for_rating'][qid];
                                 }
                                 }
                                 rating_div = rating_div + 1;
                                 question_report_html += '</tr>';
                                 }*/
                                // BugFix :: Rating answer is skipped then show blank submission table format of rating :: END
                            } else {
                                if (survey_detail['que_type'] == 'scale')
                                {
                                    question_report_html += '<tr width="50%">';
                                    question_report_html += ' <td > 0 </td>';
                                    question_report_html += '<td style=""> ';
                                    question_report_html += 'N/A';
                                    question_report_html += '</td>';
                                    question_report_html += '<td style="">N/A</td>';
                                    question_report_html += '  </tr>';
                                    flag = 1;
                                }
                                if (survey_detail['que_type'] == 'textbox' || survey_detail['que_type'] == 'commentbox' || survey_detail['que_type'] == 'datetime')
                                {
                                    question_report_html += '<tr>';
                                    question_report_html += '<td style="text-align:center;"><p align="center">There is no response for this question.</p></td>';
                                    question_report_html += '</tr>';
                                }
                                isMultiChoiceField = 1;
                                Skipped_person_multichoice++;
                            }
                            if (isNullContactInfo)
                            {
                                question_report_html += '<p align="center">There is no response for this question.</p>';
                                question_report_html += ' </tbody></table>';
                            }
                            // set other flags & dip completion for contact-information type report
                            if (contact_flag == 1) {
                                question_report_html += ' </tbody></table>';
                                contact_flag = 0;
                            }
                            // set other flags & dip completion for multi choice type report
                            if (flag == 1 && survey_detail['que_type'] == 'netpromoterscore') {
                                question_report_html += "</div>";
                                question_report_html += self.drawQuestionTrendReportData(qid, data, report_type);
                                flag = 0; // reset flag for other question
                                chart_flag = 1; // to set flag for chart after all records data will be set in array and html
                            }
                            if (flag == 1 && survey_detail['que_type'] != 'netpromoterscore') {
                                question_report_html += "</table></div></div>";
                                if ($.inArray(survey_detail['que_type'], statsSupportedQtype) !== -1) {
                                    statsTableForOthers += '<tbody>';
                                    statsTableForOthers += '<tr class="">';
                                    if (typeof data['statsDataArray'][qid] == 'undefined' || data['statsDataArray'][qid] == '') {
                                        statsTableForOthers += '<td colspan="10" style="text-align: center;"> There is no stats data for this question.</td>';
                                    } else {
                                        statsTableForOthers += '<td>' + data['statsDataArray'][qid]['range']['from'] + '</td>';
                                        statsTableForOthers += '<td>' + data['statsDataArray'][qid]['range']['to'] + '</td>';
                                        statsTableForOthers += '<td>' + data['statsDataArray'][qid]['leastFreq']['lfreqCount'] + '</td>';
                                        statsTableForOthers += '<td>' + data['statsDataArray'][qid]['leastFreq']['lfreqVal'] + '</td>';
                                        statsTableForOthers += '<td>' + data['statsDataArray'][qid]['mostFreq']['mfreqCount'] + '</td>';
                                        statsTableForOthers += '<td>' + data['statsDataArray'][qid]['mostFreq']['mfreqVal'] + '</td>';
                                        statsTableForOthers += '<td style="text-align: center;">' + data['statsDataArray'][qid]['mean'] + '</td>';
                                        statsTableForOthers += '<td style="text-align: center;">' + data['statsDataArray'][qid]['median'] + '</td>';
                                        statsTableForOthers += '<td style="text-align: center;">' + data['statsDataArray'][qid]['sd'] + '</td>';
                                        statsTableForOthers += '<td style="text-align: center;">' + data['statsDataArray'][qid]['variance'] + '</td>';
                                    }
                                    statsTableForOthers += '</tr>';
                                    statsTableForOthers += '</tbody></table></span>';
                                }
                                question_report_html += "</span>";
                                question_report_html += statsTableForOthers;
                                statsTableForOthers = '';
                                question_report_html += "</div>";
                                question_report_html += self.drawQuestionTrendReportData(qid, data, report_type);
                                flag = 0; // reset flag for other question
                                chart_flag = 1; // to set flag for chart after all records data will be set in array and html
                            }
                            // set other flags & dip completion for matrix type report
                            if (flag == 2) {
                                question_report_html += "</table></span></div></div>";
                                question_report_html += self.drawQuestionTrendReportData(qid, data, report_type);
                                flag = 0; // reset flag for other question
                                chart_flag = 1; // to set flag for chart after all records data will be set in array and html
                            }
                            if (isTextField == 1) {
                                Skipped_person = data['html']['total_submitted_que'] - Answered_person;
                                max_record_counter[qid] = Answered_person;
                                question_report_html += ' <tr><td colspan="4"><p align="center"><b>Answered Persons :&nbsp;</b>' + Answered_person;
                                question_report_html += '&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' + Skipped_person + '</p>';
                                if (Answered_person != '0') {
                                question_report_html += '<div style="float: right;margin: -27px 2px 7px;">Export As: <li title="PDF" class="fa fa-file-pdf-o questionPDFExport"  id="questionPDFExport_' + qid + '"  style="font-size: 20px;padding: 0px 10px;cursor:pointer;"></li></div>';
                                }
                                question_report_html += '</td></tr>';
                                question_report_html += '</p>';
                                question_report_html += '</td>';
                                question_report_html += '</tr> ';
                                question_report_html += html1;
                                isTextField = 0;
                            }
                            if (isTextField == 2) {
                                Skipped_person = data['html']['total_submitted_que'] - Answered_person;
                                question_report_html += ' <tr><td colspan="4"><p align="center"><b>Answered Persons :&nbsp;</b>' + Answered_person;
                                question_report_html += '&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' + Skipped_person + '</p>';
                                if (Answered_person != '0') {
                                question_report_html += '<div style="float: right;margin: -27px 2px 7px;">Export As: <li title="PDF" class="fa fa-file-pdf-o questionPDFExport"  id="questionPDFExport_' + qid + '"  style="font-size: 20px;padding: 0px 10px;cursor:pointer;"></li></div>';
                                }
                                question_report_html += '</td></tr>';
                                question_report_html += '</p>';
                                question_report_html += '</td>';
                                question_report_html += '</tr> ';
                                isTextField = 0;
                            }
                            if (isTextField == 3) {
                                Skipped_person = data['html']['total_submitted_que'] - Answered_person;
                                max_record_counter[qid] = Answered_person;
                                question_report_html += ' <tr><td colspan="4"><p align="center"><b>Attached :&nbsp;</b>' + Answered_person;
                                question_report_html += '&nbsp;&nbsp;<b>Skipped :&nbsp;</b>' + Skipped_person + '</p></td></tr>';
                                question_report_html += '</p>';
                                question_report_html += '</td>';
                                question_report_html += '</tr> ';
                                question_report_html += html1;
                                isTextField = 0;
                            }
                            if (isMultiChoiceField == 1 && survey_detail['enable_scoring'] == "1") {
                                question_report_html += ' <tr><td colspan="4"><p align="center" style="font-size:16px;">';
                                question_report_html += '<b>Average Score :&nbsp;</b><b style="color:green;">' + survey_detail['average_score'] + '</b> out of ' + survey_detail['base_score'] + '</p></td></tr>';
                                question_report_html += '</p>';
                                question_report_html += '</td>';
                                question_report_html += '</tr> ';
                                isTextField = 0;
                            }
                        }
                    });
                });
            });
            if (chart_flag == 1) {
                chart_flag = 0;
            } else {
                question_report_html += '</td></tr>';
                question_report_html += '      </tbody>';
                question_report_html += '    </table>';
            }
            result['no_submission'] = "0";
            question_report_html += '<p style="border-bottom: 1px solid #dddddd;"></p>';
            $('#hasSubmissions').val('true');
        } else {
            result['no_submission'] = "1";
            question_report_html += '<div id="question"><p align="center">There is no submission for this Survey.</p></div>';
            $('#hasSubmissions').val('false');
        }

        result['max_record_counter'] = max_record_counter;
        result['question_report_html'] = question_report_html;
        result['queReoort_pageNumbers'] = queReoort_pageNumbers;
        //  result['matrix_answers_counts'] = matrix_answers_counts;
        return result;
    },
    getNextPageRecordsQwise: function (el) {

        if (!$(el.currentTarget).hasClass('disabled'))
        {
            var qid = $(el.currentTarget).attr('name').split('_')[1];
            var current_page = $('#current_page_' + qid).val();
            var next_page = parseInt(current_page) + 1;
            var total_records = $(el.currentTarget).parents('th').find('.answered_person').val();
            var current_last_record = $('.max-record_' + qid).html();
            var next_page_first_record = parseInt(current_last_record) + 1;
            var next_page_last_record = '';
            total_records = parseInt(total_records);
            if (next_page_first_record + 9 >= total_records)
            {
                next_page_last_record = total_records;
                $('.next_' + qid).css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                $('.prev_' + qid).css('color', '#000').removeClass('disabled').css('font-size', '14px').css('cursor', 'pointer');
            } else {
                next_page_last_record = next_page_first_record + 9;
                $('.prev_' + qid).css('color', '#000').removeClass('disabled').css('font-size', '14px').css('cursor', 'pointer');
            }
            $('.min-record_' + qid).html(next_page_first_record);
            $('.max-record_' + qid).html(next_page_last_record);
            $('#current_page_' + qid).val(next_page);
            if ($(el.currentTarget).parents('tbody').find('.page_' + next_page).length != 0)
            {
                $('.record_' + qid).hide();
                $(el.currentTarget).parents('tbody').find('.page_' + next_page).show();
            }
        }
    },
    getPrevPageRecordsQwise: function (el) {

        if (!$(el.currentTarget).hasClass('disabled'))
        {
            var qid = $(el.currentTarget).attr('name').split('_')[1];
            var current_page = $('#current_page_' + qid).val();
            var prev_page = parseInt(current_page) - 1;
            var current_first_record = $('.min-record_' + qid).html();
            var next_page_last_record = parseInt(current_first_record) - 1;
            if (next_page_last_record > 0)
            {
                var next_page_first_record = next_page_last_record - 9;
                if (prev_page == 1)
                {
                    $('.prev_' + qid).css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                }
                $('.next_' + qid).css('color', '#000').removeClass('disabled').css('font-size', '14px').css('cursor', 'pointer');
            }
            $('.min-record_' + qid).html(next_page_first_record);
            $('.max-record_' + qid).html(next_page_last_record);
            $('#current_page_' + qid).val(prev_page);
            if ($(el.currentTarget).parents('tbody').find('.page_' + prev_page).length != 0)
            {
                $('.record_' + qid).hide();
                $(el.currentTarget).parents('tbody').find('.page_' + prev_page).show();
            }
        }
    },
    nps_chart_data_display: function (data, report_type)
    {
        var datadisplay = data['multi_data_forNPS']; // data of bar chart
        if (data['chart_id']) { // if chart id exists to generate bar chart
            $.ajax({
                url: 'https://www.google.com/jsapi',
                cache: true,
                dataType: 'script',
                async: false,
                success: function () {
                    google.load('visualization', '1', {packages: ['gauge'], 'callback': function ()
                        {
                            $.each(data['chart_id'], function (key, value) {
                                var chart_id = value;
                                if (typeof datadisplay[chart_id] !== 'undefined') {
                                    var chartdata = datadisplay[chart_id]['nps_gauge_chart'];
                                    if (chartdata != null) {
                                        var rows = chartdata;
                                        var data = google.visualization.arrayToDataTable(rows);
                                        var options = {
                                            min: -100,
                                            max: 100,
                                            height: 300,
                                            redFrom: -100,
                                            redTo: 0,
                                            yellowFrom: 0,
                                            yellowTo: 50,
                                            greenFrom: 50,
                                            greenTo: 100,
                                            minorTicks: 5
                                        };
                                        var chart = new google.visualization.Gauge(document.getElementById(chart_id + '_' + report_type + '_gauge'));
                                        chart.draw(data, options);
                                        $('#nps_normal_tbl_' + chart_id).css('display', 'none');
                                    }
                                }
                            });
                        }
                    });
                }

            });
        }
    },
    char_data_display: function (data, report_type)
    {
        var datadisplay = data['data']; // data of bar chart
        var multi_data_forBarColMatrix = data['multi_data_forBarColMatrix'];
        var matrix_chart_colors = data['matrix_chart_colors'];
        var pie_chart_colors = data['pie_chart_colors'];
        if (data['chart_id']) { // if chart id exists to generate bar chart
            $.ajax({
                url: 'https://www.google.com/jsapi',
                cache: true,
                dataType: 'script',
                success: function () {
                    google.load('visualization', '1', {packages: ['corechart'], 'callback': function ()
                        {
                            $.each(data['chart_id'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        height: 300,
                                        legend: {position: 'none'},
                                        chart: {title: '',
                                            subtitle: ''},
                                        bars: 'horizontal', // Required for Material Bar Charts.
                                        axes: {
                                            x: {
                                                0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                            },
                                            y: {
                                                0: {label: 'Submitted Data'}
                                            }
                                        },
                                        bar: {groupWidth: 'auto'},
                                        vAxis: {title: 'Submitted Data'},
                                        hAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100], slantedText: true}
                                    };
                                    if (document.getElementById(chart_id + '_' + report_type + '_barchart') !== null) {
                                        var chart = new google.visualization.BarChart(document.getElementById(chart_id + '_' + report_type + '_barchart'));
                                        chart.draw(data, options);
                                        document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_barchart').value = chart.getImageURI();
                                    }
                                    if (document.getElementById(chart_id + '_' + report_type + '_npsbarchart') !== null) {
                                        var chart = new google.visualization.BarChart(document.getElementById(chart_id + '_' + report_type + '_npsbarchart'));
                                        chart.draw(data, options);
                                        document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_npsbarchart').value = chart.getImageURI();
                                        $("#" + chart_id + '_' + report_type + '_npsbarchart').css('display', 'none');
                                    }
                                    // $("#" + chart_id + '_' + report_type + '_barchart').css('display', 'none');
                                }
                            });
                            $.each(data['chart_id'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        height: 300,
                                        legend: {position: 'none'},
                                        axes: {
                                            x: {
                                                0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                            },
                                            y: {
                                                0: {label: 'Submitted Data'}
                                            }
                                        },
                                        hAxis: {title: 'Submitted Data'},
                                        vAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]}
                                    };
                                    var chart = new google.visualization.ColumnChart(document.getElementById(chart_id + '_' + report_type + '_columnchart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_columnchart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_columnchart').css('display', 'none');
                                }
                            });
                            $.each(data['chart_id'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        height: 300,
                                        pointSize: 7,
                                        legend: {position: 'none'},
                                        axes: {
                                            x: {
                                                0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                            },
                                            y: {
                                                0: {label: 'Submitted Data'}
                                            }
                                        },
                                        hAxis: {title: 'Submitted Data'},
                                        vAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]},
                                        is3D: true,
                                    };
                                    var chart = new google.visualization.LineChart(document.getElementById(chart_id + '_' + report_type + '_linechart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_linechart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_linechart').css('display', 'none');
                                }
                            });
                            $.each(data['chart_id'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        title: 'Submitted Data',
                                        is3D: true,
                                        pieSliceTextStyle: {
                                            color: 'white',
                                        },
                                        legend: true,
                                        chartArea: {height: 700},
                                        colors: pie_chart_colors[chart_id]['colors'],
                                    };
                                    var chart = new google.visualization.PieChart(document.getElementById(chart_id + '_' + report_type + '_piechart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_piechart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_piechart').css('display', 'none');
                                }
                            });
                            //scale type of question coulmn chart
                            $.each(data['scale_chart_ids'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        height: 300,
                                        legend: {position: 'none'},
                                        chart: {title: '',
                                            subtitle: ''},
                                        bars: 'horizontal', // Required for Material Bar Charts.
                                        axes: {
                                            x: {
                                                0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                            },
                                            y: {
                                                0: {label: 'Submitted Data'}
                                            }
                                        },
                                        bar: {groupWidth: 'auto'},
                                        vAxis: {title: 'Submitted Data'},
                                        hAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100], slantedText: true}
                                    };
                                    var chart = new google.visualization.BarChart(document.getElementById(chart_id + '_' + report_type + '_barchart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_barchart').value = chart.getImageURI();
                                }
                            });
                            $.each(data['scale_chart_ids'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        height: 300,
                                        legend: {position: 'none'},
                                        axes: {
                                            x: {
                                                0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                            },
                                            y: {
                                                0: {label: 'Submitted Data'}
                                            }
                                        },
                                        hAxis: {title: 'Submitted Data'},
                                        vAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]}
                                    };
                                    var chart = new google.visualization.ColumnChart(document.getElementById(chart_id + '_' + report_type + '_columnchart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_columnchart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_columnchart').css('display', 'none');
                                }
                            });
                            $.each(data['scale_chart_ids'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        height: 300,
                                        pointSize: 7,
                                        legend: {position: 'none'},
                                        axes: {
                                            x: {
                                                0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                            },
                                            y: {
                                                0: {label: 'Submitted Data'}
                                            }
                                        },
                                        hAxis: {title: 'Submitted Data'},
                                        vAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]},
                                        is3D: true,
                                    };
                                    var chart = new google.visualization.LineChart(document.getElementById(chart_id + '_' + report_type + '_linechart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_linechart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_linechart').css('display', 'none');
                                }
                            });
                            $.each(data['scale_chart_ids'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        title: 'Submitted Data',
                                        is3D: true,
                                        pieSliceTextStyle: {
                                            color: 'white',
                                        },
                                        legend: true,
                                        chartArea: {width: 800, height: 700},
                                        colors: pie_chart_colors[chart_id]['colors'],
                                    };
                                    var chart = new google.visualization.PieChart(document.getElementById(chart_id + '_' + report_type + '_piechart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_piechart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_piechart').css('display', 'none');
                                }
                            });
                            //matrix type of question coulmn chart with more options of rows & colmuns
                            $.each(data['matrix_chart_ids'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        isStacked: true,
                                        is3D: true,
                                        height: 400,
                                        bars: 'horizontal', // Required for Material Bar Charts.
                                        legendTextStyle: {color: '#000'},
                                        titleTextStyle: {color: '#000'},
                                        vAxis: {viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Rows'},
                                        hAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100], slantedText: true},
                                        colors: matrix_chart_colors[chart_id]['colors'],
                                    };
                                    var chart = new google.visualization.BarChart(document.getElementById(chart_id + '_' + report_type + '_stackedbarchart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_stackedbarchart').value = chart.getImageURI();
                                }
                            });
                            $.each(data['matrix_chart_ids'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        isStacked: true,
                                        is3D: true,
                                        height: 400,
                                        bars: 'horizontal', // Required for Material Bar Charts.
                                        legendTextStyle: {color: '#000'},
                                        titleTextStyle: {color: '#000'},
                                        hAxis: {viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Rows'},
                                        vAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]},
                                        colors: matrix_chart_colors[chart_id]['colors'],
                                    };
                                    var chart = new google.visualization.ColumnChart(document.getElementById(chart_id + '_' + report_type + '_stackedcolumnchart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_stackedcolumnchart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_stackedcolumnchart').css('display', 'none');
                                }
                            });
                            $.each(data['matrix_chart_ids'], function (key, value) {
                                var chart_id = value;
                                var chartdata = datadisplay[chart_id];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        is3D: true,
                                        height: 400,
                                        bars: 'horizontal', // Required for Material Bar Charts.
                                        legendTextStyle: {color: '#000'},
                                        titleTextStyle: {color: '#000'},
                                        hAxis: {viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Rows'},
                                        vAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]},
                                        colors: matrix_chart_colors[chart_id]['colors'],
                                    };
                                    var chart = new google.visualization.ColumnChart(document.getElementById(chart_id + '_' + report_type + '_groupcolumnchart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_groupcolumnchart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_groupcolumnchart').css('display', 'none');
                                }
                            });
                            $.each(data['multi_data_forBarColMatrix'], function (key, value) {
                                var chart_id = key;
                                var chartdata = multi_data_forBarColMatrix[chart_id]['bar-col'];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        height: 300,
                                        legend: {position: 'none'},
                                        chart: {title: '',
                                            subtitle: ''},
                                        bars: 'horizontal', // Required for Material Bar Charts.
                                        axes: {
                                            x: {
                                                0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                            },
                                            y: {
                                                0: {label: 'Rows'}
                                            }
                                        },
                                        bar: {groupWidth: 'auto'},
                                        vAxis: {title: 'Rows'},
                                        hAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100], slantedText: true}
                                    };
                                    var chart = new google.visualization.BarChart(document.getElementById(chart_id + '_' + report_type + '_barchart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_barchart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_barchart').css('display', 'none');
                                }
                            });
                            $.each(data['multi_data_forBarColMatrix'], function (key, value) {
                                var chart_id = key;
                                var chartdata = multi_data_forBarColMatrix[chart_id]['bar-col'];
                                if (chartdata != null) {
                                    var rows = chartdata;
                                    var data = google.visualization.arrayToDataTable(rows);
                                    var options = {
                                        height: 300,
                                        legend: {position: 'none'},
                                        axes: {
                                            x: {
                                                0: {side: 'top', label: 'Percentage'} // Top x-axis.
                                            },
                                            y: {
                                                0: {label: 'Rows'}
                                            }
                                        },
                                        hAxis: {title: 'Rows'},
                                        vAxis: {format: "#\'%\'", viewWindowMode: "explicit", viewWindow: {min: 0, max: 100}, title: 'Percentage', ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]}
                                    };
                                    var chart = new google.visualization.ColumnChart(document.getElementById(chart_id + '_' + report_type + '_columnchart'));
                                    chart.draw(data, options);
                                    document.getElementById('pdf_chart_img_' + chart_id + '_' + report_type + '_columnchart').value = chart.getImageURI();
                                    $("#" + chart_id + '_' + report_type + '_columnchart').css('display', 'none');

                                }
                            });
                        }
                    });
                }
            });
        }
    },
    /**export the individual report data
     * 
     * @returns {undefined}\
     */
    doExport: function () {
        app.alert.show('downloading_report_view', {level: 'process', title: 'Downloading', autoclose: false});
        var survey_id = this.model.id;
        var name_value = $("#name").val().replace(/([;&,\.\+\*\~':"\!\^#$%@?/{}\\[\]\(\)=>\|])/g, '');
        var name = (name_value) ? name_value.split(' ').join('_') : '';
        var module = ($("#module_names").val()) ? $("#module_names").val() : '';
        var type = ($("#submission_type").val()) ? $("#submission_type").val() : '';
        var status = ($("#survey_status").val()) ? $("#survey_status").val() : '';
        // search by submission date
        var submission_start_date = $('[name=start_date]').val();
        var submission_end_date = $('[name=end_date]').val();
        // set for only one date given
        if (!submission_start_date && submission_end_date) {
            submission_start_date = submission_end_date;
        }
        if (!submission_end_date && submission_start_date) {
            submission_end_date = submission_start_date;
        }
        this.customExportRecords({
            report_type: "individual", survey_id: survey_id, module_name: name, module_type: module, submission_type: type, survey_status: status, page: "1", 'submission_start_date': submission_start_date, 'submission_end_date': submission_end_date},
                this.$el,
                {
                    complete: function (data) {
                        app.alert.dismiss('downloading_report_view');
                    }
                }
        );
    },
    deleteSubmissionClicked: function (el) {

        var self = this;
        var submission_id = $(el.currentTarget).attr('data-submissionid');
        var surveyID = this.survey_id;
        app.alert.show('stop_confirmation', {
            level: 'confirmation',
            title: '',
            messages: 'Are you sure want to delete this response ?',
            onConfirm: function () {
                var url = App.api.buildURL("bc_survey", "delete_transaction", "", {submission_id: submission_id, surveyID: surveyID});
                App.api.call('GET', url, {}, {
                    success: function (result) {
                        if (result)
                        {
                            app.alert.show('deleted transaction', {
                                level: 'success',
                                messages: 'Survey Response deleted successfully.',
                                autoClose: true
                            });
                            // Reload individual report
                            self.load_individual_report();
                        }
                    }
                });
            },
            onCancel: function () {
                app.alert.dismiss('stop_confirmation');
            },
            autoClose: false
        });
    },
    /** export code for downloading excel file
     * 
     * @param {type} e
     * @param {type} t
     * @param {type} n
     * @param {type} r
     * @returns {_@call;omit.platformr.platform|_@call;omit.platforma|String|rr}
     */
    customExportRecords: function (e, t, n, r) {
        var a = 'base';
        return r = r || {},
                e = _.omit(e, ["uid", "module"]),
                r.platform !== undefined ? e.platform = r.platform : a && (e.platform = a),
                app.api.fileDownload(
                        app.api.buildURL(
                                "bc_survey", "exportToExcel", {report_type: e.report_type, survey_id: e.survey_id, module_name: e.name, module_type: e.module_type, submission_type: e.submission_type, survey_status: e.status, page: e.page}, e),
                        n,
                        {iframe: t}
                )


    },
    /**get question report paginated data
     * 
     * @param {type} el
     * @returns {undefined}
     */
    getQuestionReportPagination: function (el) {
        app.alert.show('loading_report_view', {level: 'process', title: 'Please wait while report is loading', autoclose: false});
        var que_rep_type = 'question_email';
        var report_type = 'email';
        if ($(el.currentTarget).parents('.numbers').hasClass('email'))
        {
            que_rep_type = 'question_email';
            report_type = 'email';
        } else if ($(el.currentTarget).parents('.numbers').hasClass('openended'))
        {
            que_rep_type = 'question_openended';
            report_type = 'openended';
        } else if ($(el.currentTarget).parents('.numbers').hasClass('combined'))
        {
            que_rep_type = 'question_combined';
            report_type = 'combined';
        }
        var self = this;
        var result = new Array(), question_report_html = '';
        var survey_id = el.currentTarget.attributes.getNamedItem('data-surveyid').value;
        var module_id = el.currentTarget.attributes.getNamedItem('data-module-id').value;
        var page = el.currentTarget.attributes.getNamedItem('data-page').value;
        var total_answer_count = el.currentTarget.attributes.getNamedItem('data-total-answer-count').value;
        var total_send_survey = el.currentTarget.attributes.getNamedItem('data-total-send-survey').value;
        //Global Filter :: Start
        var isApplyGlobalFilter = $('#content').find('[name=isApplyGlobalFilter]').length;
        if (isApplyGlobalFilter == 0) {
            isApplyGlobalFilter = 1;
        } else if (isApplyGlobalFilter == 1 && $('#content').find('[name=isApplyGlobalFilter]').val() == 1) {
            isApplyGlobalFilter = 1;
        } else if (isApplyGlobalFilter == 1 && $('#content').find('[name=isApplyGlobalFilter]').val() == 0) {
            isApplyGlobalFilter = 0;
        } else {
            isApplyGlobalFilter = 1;
        }


        var global_filter_by = '';
        if (self.GF_Filter_By == 'by_date') {
            if (isApplyGlobalFilter) {
                self.GF_Start_Date = $('[name=global_start_date]').val();
                self.GF_End_Date = $('[name=global_end_date]').val();
            }
            var gf_start_date = self.GF_Start_Date;
            var gf_end_date = self.GF_End_Date;
        } else if (self.GF_Filter_By == 'by_question_logic') {
            if (isApplyGlobalFilter) {
                self.GF_Start_Date = $('[name=global_start_date]').val();
                self.GF_End_Date = $('[name=global_end_date]').val();
            }
            var gf_start_date = self.GF_Start_Date;
            var gf_end_date = self.GF_End_Date;
            // Question wise logic
            if (isApplyGlobalFilter) {
                var global_question_wise_logic = {};
                var gl_count = 0;
                $.each($('.thumbnail_logic_section'), function () {
                    var logic_seq = $(this).attr('id').split('global_logic_row_')[1];
                    var que_id = $('#global_logic_que_' + logic_seq).val();
                    // logic operators
                    var logic_operator = '';
                    if ($('#que_logic_answer_' + logic_seq).find('[name=logic_operator_' + logic_seq + ']').length != 0) {
                        logic_operator = $('#que_logic_answer_' + logic_seq).find('[name=logic_operator_' + logic_seq + ']').val();
                    }

                    // logic values
                    var logic_values = {};
                    if ($('#que_logic_answer_' + logic_seq).find('[name=logic_value_' + logic_seq + ']').length != 0) {
                        var count = 0;
                        $.each($('#que_logic_answer_' + logic_seq).find('[name=logic_value_' + logic_seq + ']'), function () {
                            if ($(this).attr('type') == 'checkbox') {
                                if ($(this).prop('checked')) {
                                    logic_values[count] = $(this).val();
                                }
                            } else {
                                logic_values[count] = $(this).val();
                                if ($('#que_logic_answer_' + logic_seq).find('[name=logic_value2_' + logic_seq + ']').length != 0) {
                                    logic_values[count + 1] = $('#que_logic_answer_' + logic_seq).find('[name=logic_value2_' + logic_seq + ']').val();
                                }
                            }
                            count++;
                        });
                    }

                    // Global Logic Question Wise
                    if (que_id != '0') {
                        global_question_wise_logic[gl_count] = {'que_id': que_id, 'logic_operator': logic_operator, 'logic_values': logic_values};
                    }
                    gl_count++;
                });
                self.GF_saved_question_logic = global_question_wise_logic;
                self.GF_match_case = $('[name=GF_match_case]:checked').val();
            }
            global_filter_by = JSON.stringify(self.GF_saved_question_logic);

        }

        // Global Filter :: End
        var url = App.api.buildURL("bc_survey", "get_report", "", {survey_id: survey_id, module_id: module_id, page: page, total_answer_count: total_answer_count, total_send_survey: total_send_survey, status: 'question', status_type: report_type, gf_filter_by: self.GF_Filter_By, gf_start_date: gf_start_date, gf_end_date: gf_end_date, GF_saved_question_logic: global_filter_by, GF_match_case: self.GF_match_case});
        App.api.call('create', url, {}, {
            success: function (result) {
                var data = result;
                var counter_display_matrix = result['counter_display_matrix'];
                result = self.Question_report_html(result, que_rep_type, report_type);
                question_report_html = result['question_report_html'];
                $('#question_report_data_' + report_type).html(question_report_html);
                if ($('#question_report_data_' + report_type).find('.numbers').length != 0)
                {
                    $('#question_report_data_' + report_type).find('.numbers').remove();
                }
                if (result['queReoort_pageNumbers'] != null) {
                    $('#question_report_data_' + report_type).append('<div class="numbers ' + report_type + '">' + result['queReoort_pageNumbers'] + '</div></div>');
                }

                if (result['max_record_counter'])
                {
                    $.each(result['max_record_counter'], function (qid, values) {

                        if (values && values > 1 && values <= 10)
                        {
                            $('.min-record_' + qid).html('1');
                            $('.max-record_' + qid).html(values);
                            $('.inside-pagination_' + qid).show();
                        }
                        if (values && values > 1 && values > 10)
                        {
                            $('.min-record_' + qid).html('1');
                            $('.max-record_' + qid).html('10');
                            $('.next_' + qid).css('color', '#000').css('font-size', '16px').css('cursor', 'pointer');
                            $('.inside-pagination_' + qid).show();
                        }
                        if (values <= 10)
                        {
                            $('.next_' + qid).css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                            $('.prev_' + qid).css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                        }
                        if ($('.min-record_' + qid).parents('th').find('.answered_person').length != 0) {
                            $('.min-record_' + qid).parents('th').find('.answered_person').val(values);
                        } else {
                            $('.min-record_' + qid).parents('th').append('<input type="hidden" class="answered_person" value="' + values + '" />');
                        }
                        $('.record_' + qid).hide();
                        $('.min-record_' + qid).parents('tbody').find('.page_1').show();
                    });
                }
                self.nps_chart_data_display(data, report_type);
                self.char_data_display(data, report_type);
                if (counter_display_matrix != null) {

                    // var submitted_counts = result['matrix_answers_counts'];
                    $.each(counter_display_matrix, function (qid, values) {
                        if (qid != 'page_title') {
                            $.each(values, function (row, row_values) {
                                $.each(row_values, function (col, value) {
                                    $('#multi_table_' + qid).find("#" + row + "_" + col + "").html(value);
                                });
                            });
                        }
                    });
                }
                app.alert.dismiss('loading_report_view');
            }
        });
    },
    /** get individual reports data
     * 
     * @param {type} el current target
     * @returns {undefined}
     */
    getReports: function (el) {
        app.alert.show('loading_report_view', {level: 'process', title: 'Please wait while report is loading', autoclose: false});
        var self = this;
        var customer_name = $(el.currentTarget).html();
        var survey_id = el.currentTarget.attributes.getNamedItem('data-surveyid').value;
        var module_id = el.currentTarget.attributes.getNamedItem('data-module-id').value;
        var sub_id = el.currentTarget.attributes.getNamedItem('data-submission-id').value;
        var page = el.currentTarget.attributes.getNamedItem('data-page').value;
        $('<input>').attr({
            type: 'hidden',
            id: 'selectedRecord',
            name: 'selectedRecord'
        }).appendTo('head');
        $("#selectedRecord").val(module_id);
        var url = App.api.buildURL("bc_survey", "getIndividualPersonReport", "", {survey_id: survey_id, module_id: module_id, page: page, customer_name: customer_name, submission_id: sub_id});
        App.api.call('GET', url, {}, {
            success: function (result) {
                $('body').append('<div id="backgroundpopup">&nbsp;</div>');
                if ($("#indivisual_report_main_div").length == 0) {
                    $('body').append('\
                    <script type="text/javascript">function close_survey_div(el){ $("#backgroundpopup").fadeOut(function () {$("#backgroundpopup").remove();}); $("#indivisual_report_main_div").fadeOut(function () {$("#indivisual_report_main_div").remove();}); }</script>\n\
                         <div id="indivisual_report_main_div"> </div>');
                }
                $('#backgroundpopup').fadeIn();
                $('#indivisual_report_main_div').fadeIn();
                var html = '';
                var queReoort_pageNumbers = result['queReoort_pageNumbers'];
                if (result['row'][page]['customer_name'] != '' || result['row'][page]['customer_name'] != null) {

                    html += "<div class='desc_div' style='background-color:#e8e8e8; padding:3px; font-size:16px; height:25px; padding-top:10px;'>Individual Report for " + result['row'][page]['customer_name'] + "</div><input type='hidden' id='customer_name' value='" + result['row'][page]['customer_name'] + "' /><input type='hidden' id='individual_submission_id' value='" + sub_id + "' />";
                }

                if (result['row'][page]['status'] == 'Pending' || result['row'][page]['status'] == null) {
                    html = "<div id='individual'>There is no submission response for this Survey.</div>";
                }
                html += "<div class='middle-content'>";
                //get module_name
                if (result['row'][page]['status'] == 'Pending' || result['row'][page]['status'] == null) {
                } else {
                    if (result['row'][page]['customer_name'] != '' || result['row'][page]['customer_name'] != null) {

                        if (page == 1) {
                            if (result['row'][page]['description'] == 'null' || result['row'][page]['description'] == null) {
                                result['row'][page]['description'] = '';
                            }
                            html += "<div style='background-color:#f6f6f6;  font-size:14px; padding: 5px; '><div class='send-date' style='margin:6px'><p style='font-size:14px;'><strong>Description : </strong></p>" + result['row'][page]['description'] + "</div><div class='row'>";
                            if (result['row'][page]['send_date'] != '') {
                                html += "<div class='span4'>";
                                html += "<div class='send-date' style='margin:6px'><p style='font-size:14px;'><strong>Survey Send date : </strong></p> " + result['row'][page]['send_date'] + "</div>";
                                html += "</div>";
                            }
                            if (result['row'][page]['receive_date'] != '') {
                                html += "<div class='span4'>";
                                html += "<div class='receive-date' style='margin:6px'><p style='font-size:14px;'><strong>Survey Receive date : </strong></p> " + result['row'][page]['receive_date'] + "</div></div>";
                                html += "</div>";
                            }

                            html += "<div class='row'>";
                            html += "  <div class='span4'>";
                            html += "    <div class='track-time' style='margin:6px'><p style='font-size:14px;'><strong>Time Spent on Survey : </strong></p> " + result['row'][page]['track_time_spent_on_survey'] + "</div>";
                            html += "   </div>";
                            html += "</div>";
                            if (result['row'][page]['base_score'] != 0 && typeof result['row'][page]['obtained_score'] != "undefined")
                            {
                                html += "<div class='row'>";
                                html += "  <div class='span6'>";
                                html += "      <div class='score_weight' style='margin:6px'><p style='font-size:14px;'><strong>Survey Score : </strong></p><p style='font-size:14px;'>Obtained score <strong>" + result['row'][page]['obtained_score'] + "</strong> out of <strong>" + result['row'][page]['base_score'] + "</strong></p></div>";
                                html += "   </div>";
                                html += "</div>";
                            }

                            if (result['row'][page]['consent_accepted'] && result['row'][page]['consent_accepted'] != '') {
                                html += "<div class='row'>";
                                html += "   <div class='span4'>";
                                html += "       <div class='receive-date' style='margin:6px'><p style='font-size:14px;'><strong>Consent Accepted? : </strong></p> " + result['row'][page]['consent_accepted'] + "</div>";
                                html += "   </div>";
                                html += "</div>";
                            }
                            html += "</div>";
                        }
                    }
                }
                var matrix_answer_array = new Object();
                var ques_id = '';
                $.each(result['detail_array'], function (page_id, page_data) {
                    $.each(page_data, function (que_id, que_title) {

                        var question_report_html = '';
                        if (result['row'][page][que_id]['question_type'] == 'matrix') {

                            var rows = result['row'][page][que_id]['matrix_rows'];
                            var cols = result['row'][page][que_id]['matrix_cols'];
                            //count number of rows & columns
                            var row_count = Object.keys(rows).length + 1;
                            var col_count = Object.keys(cols).length;
                            // adjusting div width as per column
                            var width = Math.round(70 / (col_count + 1)) - 1;
                            question_report_html = '<span class="ans"><b>Answer</b><table style="margin-left: 5px;margin-top: 4px;" id="matrix_table_' + que_id + '">';
                            for (var i = 1; i <= row_count; i++) {
                                question_report_html += '<tr>';
                                for (var j = 1; j <= col_count + 1; j++) {

                                    //First row & first column as blank
                                    if (j == 1 && i == 1) {
                                        question_report_html += "<td class='matrix-span' style='width:" + width + "%;text-align:left;border: 1px solid #D4CECE; padding:10px; margin:0px;'>&nbsp;</td>";
                                    }
                                    // Rows Label
                                    if (j == 1 && i != 1) {
                                        question_report_html += "<td class='matrix-span' style='font-weight:bold; width:" + width + "%;;text-align:left;border: 1px solid #D4CECE;padding:10px; margin:0px;'>" + rows[i - 1] + "</td>";
                                    } else {
                                        //Columns label
                                        if (j <= col_count + 1 && cols[j - 1] != null && !(j == 1 && i == 1) && (i == 1 || j == 1))
                                        {
                                            question_report_html += "<td class='matrix-span' style='font-weight:bold; width:" + width + "%;border: 1px solid #D4CECE;padding:10px; margin:0px;'>" + cols[j - 1] + "</td>";
                                        }
                                        //Display answer input (RadioButton or Checkbox)
                                        else if (j != 1 && i != 1 && cols[j - 1] != null) {
                                            var row = i - 1;
                                            var col = j - 1;
                                            question_report_html += "<td class='matrix-span' style='width:" + width + "%;border: 1px solid #D4CECE;padding:10px; margin:0px; '  id='" + row + "_" + col + "' name='matrix" + row + "'><input type='radio' disabled></td>";
                                        }
                                        // If no value then display none
                                        else {
                                            question_report_html += "";
                                        }
                                    }

                                }
                                question_report_html += '</tr>';
                            }
                            question_report_html += "</table></span>";
                        }
                        matrix_answer_array[que_id] = new Object();
                        ques_id = que_id;
                        $.each(que_title, function (title, answers) {
                            if (title != "page_id") {
                                html += " <div class='que-rwo'>";
                                html += "    <p class='que'><b>Question</b>" + title;
                                if (typeof answers['obtained_que_score'] != "undefined" && answers['base_que_score'] && answers['base_que_score'] != 0)
                                {
                                    html += "<span data-action='answerHistory'><span class='btn btn-info pull-right answerHistory' onclick='getAnswerHistory(this)' style='margin-right: 3px;' data-que_id='"+que_id+"' title='History'><i class='fa fa-history'></i></span></span><span style='float:right;font-weight:bold;background-color: #DDDDDD; border-radius: 4px; height: 18px; padding:5px;'>  " + answers['obtained_que_score'] + " / " + answers['base_que_score'] + " </span></p>";
                                } else {
                                    html += "<span data-action='answerHistory'><span class='btn btn-info pull-right answerHistory' onclick='getAnswerHistory(this)' data-que_id='"+que_id+"'   title='History'><i class='fa fa-history'></i></span></span></p>";
                                }
                                $.each(answers, function (t, answer) {
                                    if (t == 'matrix_answer') {

                                        if (typeof answer != "undefined")
                                        {
                                            $.each(answer[0], function (i, ans) {
                                                matrix_answer_array[ques_id][i] = ans;
                                            });
                                        }
                                    } else if (t != 'page_id' && t != 'base_que_score' && t != 'obtained_que_score')
                                    {
                                        if (typeof answer == 'object' && answer != null) {
                                            if (t == 'all_answers')
                                            {
                                                html += "<div class='row'><span class='span1'><b>Answer</b></span> ";
                                                var html1 = '';
                                                html += "<span class='span6'>";
                                                var answer_submitted = false;
                                                $.each(answer, function (ans_label, ans) {
//
                                                    if (ans['selected'] == true) {

                                                        html1 += "<li>" + ans['ans'] + "" + "</li>";
                                                        answer_submitted = true;
                                                    }
                                                });
                                                if (!answer_submitted) {
                                                    html += '<span style="margin-left: -12px;">N/A</span>';
                                                } else {
                                                    html += "<ul style='margin-left:2px;' class='ind-reportr-ul-class'>" + html1 + "</ul>";
                                                }
                                                html += '</span>';
                                                html += "</div>";
                                            } else { // Contact Information
                                                var haveContactInfo = [];
                                                $.each(answer,function (k, v) {
                                                    if (v.trim() == '') {
                                                        haveContactInfo.push(false)
                                                    } else {
                                                        haveContactInfo.push(true)
                                                    }
                                                });
                                                html += "<div class='row'> <span class='ans span1'><b>Answer</b></span><div class='span6' style='margin-left:12px;'>";
                                                if (haveContactInfo.indexOf(true) !== -1) {
                                                html += "<b>Company Name : </b>" + answer['Company'];
                                                html += "<br/><b>Name : </b>" + answer['Name'];
                                                html += "<br/><b>Street1 :</b> " + answer['Address'];
                                                html += "<br/><b>Street2 : </b>" + answer['Address2'] + "<br/>";
                                                if (answer['City/Town'] != '')
                                                {
                                                    html += answer['City/Town'] + ", ";
                                                }
                                                if (answer['Zip/Postal Code'] != '')
                                                {
                                                    html += answer['Zip/Postal Code'] + ", ";
                                                }
                                                if (answer['State/Province'] != '')
                                                {
                                                    html += answer['State/Province'] + ", ";
                                                }
                                                if (answer['Country'] != '')
                                                {
                                                    html += answer['Country'];
                                                }
                                                html += "<br/><b>Email : </b>" + answer['Email Address'];
                                                html += "<br/><b>Phone : </b>" + answer['Phone Number'];
                                                } else {
                                                    html += "N/A";
                                                }
                                                html += "</div></div>";
                                            }
                                        } else {
                                            if (answer) {
                                                var submitted_answer = answer;
                                            } else {
                                                var submitted_answer = 'N/A';
                                            }
                                            if (result['row'][page][que_id]['question_type'] == 'doc-attachment' && answer && answer != 'N/A')
                                            {
                                                var splitted_answer = answer.split('_documentID_');
                                                var doc_id = splitted_answer[0];
                                                var doc_name = splitted_answer[1];
                                                var submitted_answer = '<a onclick=\' window.open("#bwc/index.php?module=Documents&action=DetailView&record=' + doc_id + '")\'>' + doc_name + '</a>';
                                            }
                                            html += "<span class='ans'><b>Answer</b> <div style='display: inline-block;vertical-align: top'>" + submitted_answer + "</div></p>";
                                        }
                                    }
                                });
                                html += question_report_html;
                                html += "</div>";
                            }
                        });
                    });
                });
                html += "</div>";
                if (queReoort_pageNumbers != null) {
                    html += "<div class='numbers'> " + queReoort_pageNumbers + "</div>";
                }

                $('#indivisual_report_main_div').html('<div id="indivisual_report">'
                        + html +
                        ' <a  href="javascript:void(0);" class="close_link" onclick="close_survey_div(this)"></a>' +
                        '</div>');
                //Check response submitted by user for matrix type question
                if (matrix_answer_array != null) {
                    $.each(matrix_answer_array, function (qid, values) {
                        ;
                        if (values) {
                            var qid = qid;
                            $.each(values, function (index, value) {
                                if (value) {
                                    value = value.split('_');
                                    $('#matrix_table_' + qid).find("#" + value[0] + "_" + value[1] + "").html("<input type='radio' checked disabled>");
                                }
                            });
                        }
                    });
                }
                app.alert.dismiss('loading_report_view');
            },
        });
    },
    /** get search result for individual report
     * 
     * @param {type} el
     * @returns {undefined}
     */
    getSearchResult: function (el) {
        var self = this;
        var validation = true;
        var survey_id = el.currentTarget.attributes.getNamedItem('data-surveyid').value;
        var report_type = "individual";
        var page = "1";
        // check sorting or not
        var sort = '';
        var sort_order = '';
        var sort_field_class = '';
        if ($(el.currentTarget).hasClass('sort_name'))
        {
            sort = 'customer_name';
            sort_field_class = 'sort_name';
        } else if ($(el.currentTarget).hasClass('sort_module')) {
            sort = 'module';
            sort_field_class = 'sort_module';
        } else if ($(el.currentTarget).hasClass('sort_type')) {
            sort = 'submission_type';
            sort_field_class = 'sort_type';
        } else if ($(el.currentTarget).hasClass('sort_status')) {
            sort = 'status';
            sort_field_class = 'sort_status';
        } else if ($(el.currentTarget).hasClass('sort_send_date')) {
            sort = 'schedule_on';
            sort_field_class = 'sort_send_date';
        } else if ($(el.currentTarget).hasClass('sort_submission_date')) {
            sort = 'submission_date';
            sort_field_class = 'sort_submission_date';
        } else if ($(el.currentTarget).hasClass('sort_consent_accepted')) {
            sort = 'consent_accepted';
            sort_field_class = 'sort_consent_accepted';
        } else if ($(el.currentTarget).hasClass('sort_change_req')) {
            sort = 'change_request';
            sort_field_class = 'sort_change_req';
        }

        if (sort) {
            if ($(el.currentTarget).hasClass('ASC'))
            {
                $(el.currentTarget).addClass('DESC');
                sort_order = 'DESC';
            } else {
                $(el.currentTarget).addClass('ASC');
                sort_order = 'ASC';
            }
        } else {
            var button_clicked = el.currentTarget.attributes.getNamedItem('data-button-clicked').value;
            if (button_clicked == 'clear') {
                $("#name").val('');
                $("#module_names").val('');
                $("#submission_type").val('Combined');
                $("#survey_status").val('');
                $('[name=start_date]').val('');
                $('[name=end_date]').val('');
            }
        }
        // search by submission date
        var submission_start_date = $('[name=start_date]').val();
        var submission_end_date = $('[name=end_date]').val();
        // set for only one date given
        if (!submission_start_date && submission_end_date) {
            submission_start_date = submission_end_date;
        }
        if (!submission_end_date && submission_start_date) {
            submission_end_date = submission_start_date;
        }

        // if both date for search is given then check for date validation
        if (submission_end_date && submission_start_date) {
            if (this.isDateRangeValid(submission_start_date, submission_end_date)) {
                validation = true;
                $('.input-append').attr('class', 'input-append date datetime');
                $('[name=end_date]').attr('class', "show_datepicker ui-datepicker-input");
                $('[name=start_date]').attr('class', "show_datepicker ui-datepicker-input");
                $('.error-date').attr('style', 'display:none;');
            } else {
                validation = false;
                $('.input-append').attr('class', 'input-append date datetime error');
                $('[name=end_date]').attr('class', "show_datepicker ui-datepicker-input error");
                $('[name=start_date]').attr('class', "show_datepicker ui-datepicker-input error");
                $('.error-date').attr('style', 'color:red;');
            }
        }

        //Global Filter :: Start
        var global_filter_by = '';
        if (self.GF_Filter_By == 'by_date') {
            self.GF_Start_Date = $('[name=global_start_date]').val();
            self.GF_End_Date = $('[name=global_end_date]').val();
            var gf_start_date = self.GF_Start_Date;
            var gf_end_date = self.GF_End_Date;
        } else if (self.GF_Filter_By == 'by_question_logic') {
            self.GF_Start_Date = $('[name=global_start_date]').val();
            self.GF_End_Date = $('[name=global_end_date]').val();
            var gf_start_date = self.GF_Start_Date;
            var gf_end_date = self.GF_End_Date;
            // Question wise logic
            var global_question_wise_logic = {};
            var gl_count = 0;
            $.each($('.thumbnail_logic_section'), function () {
                var logic_seq = $(this).attr('id').split('global_logic_row_')[1];
                var que_id = $('#global_logic_que_' + logic_seq).val();
                // logic operators
                var logic_operator = '';
                if ($('#que_logic_answer_' + logic_seq).find('[name=logic_operator_' + logic_seq + ']').length != 0) {
                    logic_operator = $('#que_logic_answer_' + logic_seq).find('[name=logic_operator_' + logic_seq + ']').val();
                }

                // logic values
                var logic_values = {};
                if ($('#que_logic_answer_' + logic_seq).find('[name=logic_value_' + logic_seq + ']').length != 0) {
                    var count = 0;
                    $.each($('#que_logic_answer_' + logic_seq).find('[name=logic_value_' + logic_seq + ']'), function () {
                        if ($(this).attr('type') == 'checkbox') {
                            if ($(this).prop('checked')) {
                                logic_values[count] = $(this).val();
                            }
                        } else {
                            logic_values[count] = $(this).val();
                            if ($('#que_logic_answer_' + logic_seq).find('[name=logic_value2_' + logic_seq + ']').length != 0) {
                                logic_values[count + 1] = $('#que_logic_answer_' + logic_seq).find('[name=logic_value2_' + logic_seq + ']').val();
                            }
                        }
                        count++;
                    });
                }

                // Global Logic Question Wise
                if (que_id != '0') {
                    global_question_wise_logic[gl_count] = {'que_id': que_id, 'logic_operator': logic_operator, 'logic_values': logic_values};
                }
                gl_count++;
            });
            self.GF_saved_question_logic = global_question_wise_logic;
            global_filter_by = JSON.stringify(global_question_wise_logic);
            self.GF_match_case = $('[name=GF_match_case]:checked').val();
        }
        // Global Filter :: End

        if (validation)
        {
            var name_value = $("#name").val();
            var name = (name_value) ? name_value : '';
            var module = ($("#module_names").val()) ? $("#module_names").val() : '';
            var type = ($("#submission_type").val()) ? $("#submission_type").val() : '';
            var status = ($("#survey_status").val()) ? $("#survey_status").val() : '';
            var dataArray = {'report_type': report_type,
                'survey_id': survey_id,
                'name': name,
                'search_value': name,
                'module_type': module,
                'submission_type': type,
                'survey_status': status,
                'submission_start_date': submission_start_date,
                'submission_end_date': submission_end_date,
                'page': page,
                'sort': sort,
                'sort_order': sort_order,
                'gf_filter_by': self.GF_Filter_By,
                'gf_start_date': gf_start_date,
                'gf_end_date': gf_end_date,
                'GF_saved_question_logic': global_filter_by,
                'GF_match_case': self.GF_match_case
            };
            var Data = JSON.stringify(dataArray);
            var url = App.api.buildURL("bc_survey", "getSearchResult", "", {newData: Data});
            App.api.call('GET', url, {}, {
                success: function (result) {
                    if (result != null) {
                        var html = '';
                        Object.keys(result['records']).length
                        if (Object.keys(result['records']).length > 0) {

                            html += "<tr>";
                            html += '            <th style="width:10%;" class="sort_name" data-surveyid="' + survey_id + '">Name <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                            html += '            <th style="width:10%;text-align:center;" class="sort_module" data-surveyid="' + survey_id + '">Module <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                            html += '            <th style="width:10%;text-align:center;" class="sort_type" data-surveyid="' + survey_id + '">Type <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                            html += '            <th style="width:15%;text-align:center;" class="sort_send_date" data-surveyid="' + survey_id + '">Survey Send Date <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                            html += '            <th style="width:15%;text-align:center;" class="sort_submission_date" data-surveyid="' + survey_id + '">Survey Receive Date <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                            html += '            <th style="width:15%;text-align:center;" class="sort_consent_accepted" data-surveyid="' + survey_id + '">Consent Accepted? <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                            html += '            <th style="width:15%;text-align:center;" class="sort_change_req" data-surveyid="' + survey_id + '">Change Request <span><i class="fa fa-caret-up pull-right"></i><i class="fa fa-caret-down pull-right"></i></span></th>';
                            html += '            <th style="width:10%;text-align:center;">Resend</th>';
                            html += '            <th style="width:5%;text-align:center;">Delete</th>';
                            html += "</tr>";

                            var page_counter = 1;
                            var last_record = parseInt(result['max_records']);
                            var max_records = parseInt(result['max_records']);
                            var submitted_counter = 0;

                            $.each(result['IndividualReportData'], function (module_id, module_detail) {
                                if (module_detail['survey_status'] == 'Submitted')
                                {
                                    submitted_counter++;
                                    if (submitted_counter > last_record)
                                    {
                                        page_counter++;
                                    }
                                    var record_name = module_detail['customer_name'];
                                    var record_id = module_detail['module_id'];
                                    html += '<tr class="page_' + page_counter + ' record_individual">';
                                    html += '         <td><a href="javascript:void(0);" class="individual_div" data-surveyid="' + survey_id + '" data-page="' + page + '" data-module-id="' + module_detail['module_id'] + '" data-submission-id="' + module_detail['submission_id'] + '">' + record_name + '</a>';
                                    html += "</td>";
                                    html += " <td style='text-align:center'>" + module_detail['module_type'] + "</td>";
                                    html += "<td style='text-align:center'>" + module_detail['submission_type'] + "</td>";
                                    html += "<td style='text-align:center'>" + module_detail['send_date'] + "</td>";
                                    html += "<td style='text-align:center'>" + module_detail['receive_date'] + "</td>";
                                    html += '<td style="text-align:center">' + module_detail['consent_accepted'] + '</td><td style="text-align:center">';
                                    if (module_detail['change_request'] == 'Pending') {
                                        html += "<span style='color:red;'>" + module_detail['change_request'] + "</span>";
                                    } else {
                                        html += module_detail['change_request'];
                                    }
                                    html += '</td><td id="re-send" style="text-align:center">';
                                    if ((module_detail['survey_status'] == 'Submitted' || module_detail['survey_status'] == 'Viewed') && (module_detail['submission_type'] == 'Email')) {
                                        html += ' <a class="resend" data-surveyid="' + survey_id + '" data-module-id="' + module_detail['module_id'] + '" data-module-type="' + module_detail['module_type'] + '" data-submission-id="' + module_detail['submission_id'] + '"  title="Re-send" href="javascript:void(0);"><img src="custom/include/images/re-send.png" style="height: 22px;"></a> ';
                                    }
                                    html += '</td><td id="deleteSubmission" style="text-align:center">';
                                    html += '<a class="deleteSub" data-submissionId="' + module_detail['submission_id'] + '" title="Delete Response" href="javascript:void(0);" ><div class="btn"><i class="fa fa-times" style="font-size:16px">&nbsp;</i></div></a>';
                                    html += '</td></tr>';

                                    if (submitted_counter == last_record + 1)
                                    {
                                        last_record += max_records;
                                }
                                }
                            });
                            if (result['Individual_Report_pageNumbers'] != null) {
                                var page_html = "<div class='numbers'> " + result['Individual_Report_pageNumbers'] + "</div>";
                            }
                        }
                        $("#search_result").html(html);
                        var values = submitted_counter;

                        if (values && values <= max_records)
                        {
                            $('.min-record_individual').html('1');
                            $('.max-record_individual').html(values);
                            $('.inside-pagination_individual').show();
                            $('.inside-pagination_individual').parents('table').show();
                            $('.prev_individual').css('color', '#d0d0d0').addClass('disabled');
                        }
                        if (values && values > max_records)
                        {
                            $('.min-record_individual').html('1');
                            $('.max-record_individual').html(max_records);
                            $('.next_individual').css('color', '#000').removeClass('disabled').css('font-size', '16px').css('cursor', 'pointer');
                            $('.inside-pagination_individual').show();
                            $('.inside-pagination_individual').parents('table').show();
                            $('.prev_individual').css('color', '#d0d0d0').addClass('disabled');
                        }
                        if (values <= max_records)
                        {
                            $('.next_individual').css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                            $('.prev_individual').css('color', '#d0d0d0').addClass('disabled').css('font-size', '16px').css('cursor', '');
                        }
                        if ($('.min-record_individual').parents('div').find('.answered_person').length != 0) {
                            $('.min-record_individual').parents('div').find('.answered_person').val(values);

                        } else {
                            if ($('.min-record_individual').parents('div').find('.answered_person_individual').length == 0) {
                                $('.min-record_individual').parents('div').append('<input type="hidden" class="answered_person_individual" value="' + values + '" />');
                            } else {
                                $('.min-record_individual').parents('div').find('.answered_person_individual').val(values);
                            }
                        }
                        $('.total_records_individual').html(values + ' Records');
                        $('.record_individual').hide();
                        $('.min-record_individual').parents('div').find('.page_1').show();
                        $('.numbers').html(page_html);
                        // add sorting order
                        if (sort_field_class !== '') {
                            if (sort_order) {
                                $('.' + sort_field_class).addClass(sort_order);
                            }
                            if (sort_order == 'ASC')
                            {
                                $('.' + sort_field_class).css('background-color', '#fff').find('.fa-caret-up').hide();
                            } else {
                                $('.' + sort_field_class).css('background-color', '#fff').find('.fa-caret-down').hide();
                            }
                        }
                    } else {
                        html = "<tr><td colspan='3'>No records found</td></tr>";
                        $("#search_result").html(html);
                        $(".inside-pagination_individual").parents('table').hide();
                    }
                }
            });
        }
    },
    /**approve change request of individual person from individual report
     * 
     * @param {type} el current target
     * @returns {undefined}
     */
    ApproveChRequest: function (el) {
        if (app.user.id == this.model.get('created_by') || app.user.attributes.type == "admin")
        {
            var survey_id = el.currentTarget.attributes.getNamedItem('data-surveyid').value;
            var module_id = el.currentTarget.attributes.getNamedItem('data-module-id').value;
            var module_type = el.currentTarget.attributes.getNamedItem('data-module-type').value;
            var submission_id = el.currentTarget.attributes.getNamedItem('data-submission-id').value;
            var status = $(el).text();
            el.currentTarget.hidden = true;
            var parent = el.currentTarget.parentElement;
            var dropdown = document.createElement('select');
            dropdown.id = 'status';
            dropdown.setAttribute('style', 'width:100px;');
            var op = document.createElement('option');
            op.value = "select";
            op.innerHTML = 'Select'
            dropdown.appendChild(op);
            var op_aprv = document.createElement('option');
            op_aprv.value = "Approved";
            op_aprv.innerHTML = 'Approve'
            dropdown.appendChild(op_aprv);
            el.currentTarget.parentElement.appendChild(dropdown);
            var dropDown = '<select id="status" style="width:100px;"><option value="N/A">Select</option><option value="Approved">Approved</option></select>';
            $('#status').change(function () {
                if ($("#survey_loader").length == 0) {
                    var p = document.createElement('i');
                    p.id = "survey_loader";
                    p.setAttribute('class', 'fa fa-spinner fa-spin fa-2x pull-left')
                    el.currentTarget.parentElement.appendChild(p);
                }
                var url = App.api.buildURL("bc_survey", "approveRequest", "", {survey_id: survey_id, module_name: module_type, module_id: module_id, status: $(this).val(), resubmit: 1, submission_id : submission_id});
                App.api.call('GET', url, {}, {
                    complete: function () {
                        $("#survey_loader").remove();
                    },
                    success: function (result) {
                        var response = JSON.parse(result);
                        if (response['status'] == "sucess") {
                            parent.innerHTML = response['request_status'];
                            App.alert.show('email_success', {
                                level: 'success',
                                title: '',
                                messages: 'Email has sent successfully.',
                                autoClose: true
                            });
                        } else {
                            App.alert.show('email_error', {
                                level: 'error',
                                title: '',
                                messages: 'It seems there is some error!',
                                autoClose: true
                            });
                        }
                    }
                });
            });
        } else {
            var created_by_user = this.model.get('created_by_name');
            if (created_by_user == "Administrator") {
                var msg = 'You are unauthorized to approve change request of this survey. Please contact  ' + created_by_user + ' to approve change request';
            } else {
                var msg = 'You are unauthorized to approve change request of this survey. Please contact Administrator or ' + created_by_user + ' to approve change request';
            }
            App.alert.show('email_error', {
                level: 'error',
                title: '',
                messages: msg,
                autoClose: false
            });
        }
    },
    /**resend survey to individual person from individual report
     * 
     * @param {type} el current target
     * @returns {undefined}
     */
    reSendSurvey: function (el) {

        if (app.user.id == this.model.get('created_by') || app.user.attributes.type == "admin")
        {
            var survey_id = el.currentTarget.attributes.getNamedItem('data-surveyid').value;
            var module_id = el.currentTarget.attributes.getNamedItem('data-module-id').value;
            var module_type = el.currentTarget.attributes.getNamedItem('data-module-type').value;
            var submission_id = el.currentTarget.attributes.getNamedItem('data-submission-id').value;
            if ($("#survey_loader").length == 0) {
                var p = document.createElement('i');
                p.id = "survey_loader";
                p.setAttribute('class', 'fa fa-spinner fa-spin fa-2x pull-left')
            }
            $(el.currentTarget).find('img').attr('src', 'custom/include/images/ajax_loader.gif');
            var url = App.api.buildURL("bc_survey", "approveRequest", "", {survey_id: survey_id, module_name: module_type, module_id: module_id, resend: 1, submission_id: submission_id});
            App.api.call('GET', url, {}, {
                complete: function () {
                    $(el.currentTarget).find('img').attr('src', 'custom/include/images/re-send.png');
                },
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
                }
            });
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
    },
    switch_chart_report: function (el) {
        var elm = el.currentTarget.id.split('_');
        var questionID = elm[0];
        var reportType = elm[1];
        var left = el.currentTarget.offsetLeft;
        var top = el.currentTarget.offsetTop;
        var queType = $(el.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement).find('.question_type_' + questionID).val();
        // var reportType = $(el.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement).find('.report_type_' + questionID).val();
        var url = App.api.buildURL("bc_survey", "openMutliChartOptionsModel?questionID=" + questionID + "&queType=" + queType + "&reportType=" + reportType, {});
        var currentChart = $('#chart_selection_' + questionID + '_' + reportType).val();
        App.api.call('GET', url, {}, {
            success: function (result) {
                $("#switch_chart_popup_" + questionID + '_' + reportType).show();
                $("#switch_chart_popup_" + questionID + '_' + reportType).html(result);
                $("#switch_chart_popup_" + questionID + '_' + reportType).find('.bottom').css('left', '190px');
                $("#switch_chart_popup_" + questionID + '_' + reportType).find('.bottom').css('top', '-100px');
                $('#icon_' + questionID + '_' + reportType + '_' + currentChart).css('background-color', 'black');
                $('#icon_' + questionID + '_' + reportType + '_' + currentChart).find('img').attr('src', 'custom/include/images/' + currentChart + '-white.png');
            }
        });
    },
    closeSwitchChartModel: function (el) {
        var elm = $(el.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement).find('.switch_chart_report_icon').attr('id').split('_');
        var qid = elm[0];
        var reportType = elm[1];
        $('#' + qid + '_stats_tbl_' + reportType).hide();
        el.currentTarget.parentElement.parentElement.remove();
        $('.ansSeqStats_' + qid).hide();
    },
    swichChartOnClickChartIcon: function (el) {
        var chartElement = el.currentTarget.id.split('_');
        var chartID = chartElement[3];
        var qid = chartElement[1];
        var reportType = chartElement[2];
        $(el.currentTarget).parents('#different_charts').find('.swichChart').css('background-color', '');
        $(el.currentTarget).parents('#different_charts').find('.swichChart').each(function (k, v) {
            var cID = $(this).attr('id').split('_');
            var chart_dID = cID[3];
            $(this).find('img').attr('src', 'custom/include/images/' + chart_dID + '.png');
        });
        $('#' + el.currentTarget.id).css('background-color', 'black');
        $('#chart_selection_' + qid + '_' + reportType).val(chartID);
        $('#' + el.currentTarget.id).find('img').attr('src', 'custom/include/images/' + chartID + '-white.png');
        $('.' + qid + '_otherqueType').hide();
        if (chartID == 'npsgaugechart') {
            chartID = 'npsbarchart';
            $('#nps_normal_chart_' + qid).hide();
            $('#nps_normal_tbl_' + qid).hide();
            $('#nps_gauge_chart_' + qid).show();
        } else {
            $('#nps_normal_chart_' + qid).show();
            $('#nps_normal_tbl_' + qid).show();
            $('#nps_gauge_chart_' + qid).hide();
            $('#' + el.currentTarget.id).show();
            $('#' + qid + '_' + reportType + '_' + chartID).show();
        }
            var imgUrl = $('#pdf_chart_img_' + qid + '_' + reportType + '_' + chartID).val();
            var statsVal = $('#stats_' + qid + '_' + reportType).prop("checked");
            if (statsVal) {
                statsVal = 'show';
            } else {
                statsVal = 'hide';
        }
            storeQuestionDefaultSettings(qid, imgUrl, statsVal, false);
    },
    /* To show/hide stats table*/
    toggleStatsTable: function (el) {
        var chartElement = el.currentTarget.id.split('_');
        var qid = chartElement[1];
        var reportType = chartElement[2];
        $('#' + qid + '_stats_tbl_' + reportType).hide();
        $('.ansSeqStats_' + qid).hide();
        var statsShowHideVal = 'hide';
        if (el.currentTarget.checked === true) {
            $('#' + qid + '_stats_tbl_' + reportType).show();
            $('.ansSeqStats_' + qid).show();
            $('#' + qid + '_stats_tbl_' + reportType).find('.option_image').hide();
            statsShowHideVal = 'show';
        }
        var selChart = $('#chart_selection_' + qid + '_' + reportType).val();
        if (selChart == 'npsgaugechart') {
            selChart = 'npsbarchart';
        }
        var ImgUrl = $('#pdf_chart_img_' + qid + '_' + reportType + '_' + selChart).val();
        storeQuestionDefaultSettings(qid, ImgUrl, statsShowHideVal, false);
    },
    /* To Show Hide Normal and Trend Report Section In Status Report Section */
    toggleToTrendAndNormalReport: function (el) {
        var reportType = $(el.currentTarget).parents('#status-trend-tabs').find('#reportType').val();
        $('#status_report_data_' + reportType).find('#trend_status_section').hide();
        $('#status_report_data_' + reportType).find('#status_section').show();
        $(el.currentTarget).parents('#status-trend-tabs').find('li').removeAttr('class');
        $(el.currentTarget).parents('li').attr('class', 'active');
        if (el.currentTarget.id == 'status-trend-report') {
            $('#status_report_data_' + reportType).find('#status_section').hide();
            $('#status_report_data_' + reportType).find('#trend_status_section').show();
        }
    },
    /* To Show Hide Normal and Trend Report Section In Question Report Section */
    toggleToTrendAndNormalQuestionReport: function (el) {
        var reportViewInfo = $(el.currentTarget).parents('.question-trend-tabs').find('.reportview-hidden-info').attr('id').split('_');
        var reportType = $(el.currentTarget).parents('.question-trend-tabs').find('.reportview-hidden-info').val();
        var qID = reportViewInfo[0];
        $('.' + qID + '_' + reportType + '_normal_chartDiv').show();
        $('#trend_status_section_' + qID + '_' + reportType).hide();
        var defaultTrendVal = $('#default_trendData_' + reportType + '_' + qID).val();
        $(el.currentTarget).parents('.question-trend-tabs').find('li').removeAttr('class');
        $(el.currentTarget).parents('li').attr('class', 'active');
        $('#current_question_wise_tab').val('normal');
        if (el.currentTarget.id == 'question-trend-report') {
            $('#current_question_wise_tab').val('trend');
            $('.' + qID + '_' + reportType + '_normal_chartDiv').hide();
            //$('#trend_status_section_' + qID + '_' + reportType).show();
            $('#trend_status_section_' + qID + '_' + reportType).show();
            $('#trend_line_chart_' + defaultTrendVal + '_' + reportType + '_' + qID).css('display', 'table');
            $('#trend_tbl_chart_' + defaultTrendVal + '_' + reportType + '_' + qID).show();
        }
    },
    /* To switch Status Trend Dats based on selected range govind*/
    switchStatusTrendDataBasedOnRange: function (el) {
        var elemnt = $(el.currentTarget).parents().attr('id').split('_');
        var reportType = elemnt[4];
        var range = el.currentTarget.value;
        $('#status_report_data_' + reportType).find('.trend_report_display').hide();
        $('#status_report_data_' + reportType).find('#trend_line_chart_' + range + '_' + reportType).show();
        $('#status_report_data_' + reportType).find('#trend_tbl_chart_' + range + '_' + reportType).show();
    },
    /* To switch Question Trend Dats based on selected range govind*/
    switchQuestionTrendDataBasedOnRange: function (el) {
        var elemnt = $(el.currentTarget).parents().attr('id').split('_');
        var reportType = elemnt[4];
        var qID = elemnt[5];
        var range = el.currentTarget.value;
        $('#trend_status_section_' + qID + '_' + reportType).find('.trend_report_display').hide();
        $('#trend_status_section_' + qID + '_' + reportType).find('#trend_line_chart_' + range + '_' + reportType + '_' + qID).css('display', 'table');
        $('#trend_status_section_' + qID + '_' + reportType).find('#trend_tbl_chart_' + range + '_' + reportType + '_' + qID).show();
    },
    /*
     * Show popup on click of Filter button
     */
    globalFilterBtnClicked: function (el) {
        var self = this;
        self.isApplyGlobalFilter = false;
        var isApplyGlobalFilter = $('#content').find('[name=isApplyGlobalFilter]').length;
        if (isApplyGlobalFilter == 0) {
            $('#content').append('<input type="hidden" name="isApplyGlobalFilter" value="0" />');
        } else {
            $('#content').find('[name=isApplyGlobalFilter]').val('0');
        }
        var userDateFormat = this.getUserDateFormat();
        var global_filter_by = $(el.currentTarget).parents('span').prev('span').find('[name=global_filter_selection]').val();
        // Set filter by selected option in global variable
        if (global_filter_by !== '') {
            self.GF_Filter_By = global_filter_by;
            var GF_Start_Date = '';
            if (typeof self.GF_Start_Date !== 'undefined') {
                GF_Start_Date = self.GF_Start_Date;
            }
            var GF_End_Date = '';
            if (typeof self.GF_End_Date !== 'undefined') {
                GF_End_Date = self.GF_End_Date;
            }
        if (global_filter_by == 'by_date') {
            var label = 'By Date';
            var logic_class = '';
        } else if (global_filter_by == 'by_question_logic') {
            var label = 'By Question Logic';
            var logic_class = 'global_filter_main_div_by_question_logic';
        }
        if ($('#global_filter_main_div').length != 0) {
            $('#global_filter_main_div').remove();
        }
        $('#content').append('<div id="globalFilterbackgroundpopup">&nbsp;</div>');
        if ($("#global_filter_main_div").length == 0) {
            // close global filter function
                $('#content').append('<div id="global_filter_main_div"> </div>');
        }
        if ($("#global_filter_main_div").length != 0 && logic_class == 'global_filter_main_div_by_question_logic') {
            $('#global_filter_main_div').addClass('global_filter_main_div_by_question_logic');
        }
        $('#globalFilterbackgroundpopup').fadeIn();
        $('#global_filter_main_div').fadeIn();
        var html = '';
        html += "<div class='desc_div' style='background-color:#e8e8e8; padding:3px; font-size:16px; height:25px; padding-top:10px;'><i class='fa fa-filter'>&nbsp;</i>Global Filter " + label + "</div>";
        if (global_filter_by == 'by_date') {
            html += "<div class='middle-content'>";
            // Start Date
            html += "   <div class='row'>"
            html += "       <div class='span2'>";
            html += "           <span class='label-field'>Start Date</span>";
            html += "       </div>";
            html += "       <div class='span2'>";
                html += '           <input style = "width:150px;margin-left:3px;" name = "global_start_date"  type = "text" data-type = "date" class = "show_datepicker datepicker ui-timepicker-input" value="' + GF_Start_Date + '" placeholder = "Start Date" aria-label = "Start Date">';
            html += "       </div>";
            html += "   </div>";
            // End Date
            html += "   <div class='row'>"
            html += "       <div class='span2'>";
            html += "           <span class='label-field'>End Date</span>";
            html += "       </div>";
            html += "       <div class='span2'>";
                html += '           <input style = "width:150px;margin-left:3px;" name = "global_end_date"  type = "text" data-type = "date" class = "show_datepicker datepicker ui-timepicker-input" value="' + GF_End_Date + '" placeholder = "End Date" aria-label = "End Date">';
            html += "       </div>";
            html += "   </div>";
            html += "   <div>"
            html += "       <b>Note:</b> This Filter will be applied to <b>Question Wise Report</b> and <b>Individual Report</b>";
            html += "   </div>";
            html += '</div>';
        } else if (global_filter_by == 'by_question_logic') {

            // Survey Questions
            var options_que_list = '<option value="0">Select survey question</option>';
            if (this.GF_all_questions) {
                $.each(this.GF_all_questions, function (k, que_data) {
                    options_que_list += '<option value="' + que_data['que_id'] + '">' + que_data['que_title'] + ' </option>';
                });
            }

            // Date filters
            html += "<div class='middle-content'>";
            // Start Date
            html += "   <div class='row'>"
            html += "       <div class='span2'>";
            html += "           <span class='label-field'>Start Date</span>";
            html += "       </div>";
            html += "       <div class='span2'>";
                html += '           <input style = "width:150px;margin-left:3px;" name = "global_start_date"  type = "text" data-type = "date" class = "show_datepicker datepicker ui-timepicker-input" value="' + GF_Start_Date + '" placeholder = "Start Date" aria-label = "Start Date">';
            html += "       </div>";
            html += "   </div>";
            // End Date
            html += "   <div class='row'>"
            html += "       <div class='span2'>";
            html += "           <span class='label-field'>End Date</span>";
            html += "       </div>";
            html += "       <div class='span2'>";
                html += '           <input style = "width:150px;margin-left:3px;" name = "global_end_date"  type = "text" data-type = "date" class = "show_datepicker datepicker ui-timepicker-input" value="' + GF_End_Date + '" placeholder = "End Date" aria-label = "End Date">';
            html += "       </div>";
            html += "   </div>";
            // check match case selected
            var match_all_selected = '';
            var match_any_selected = '';
            if (this.GF_match_case == 'OR') {
                match_any_selected = 'checked';
            } else {
                match_all_selected = 'checked';
            }

            // Question logic filter
            html += "   <div class='row'>"
            html += "       <div class='span7'>";
            html += "           <span class='label-field'><b style='font-size:16px;'>Question Logic</b></span>";
            html += '           <div class="match_cases_section pull-right">';
            html += '                   <span class="btn match_cases_span" title="Match All Question Logic">&nbsp;Match All&nbsp;<input type="radio" name="GF_match_case" value="AND" ' + match_all_selected + '></span>';
            html += '                   <span class="btn match_cases_span" title="Match Any One Question Logic">&nbsp;Match Any&nbsp;<input type="radio" name="GF_match_case" value="OR" ' + match_any_selected + '></span>';
            html += '           </div>';
            html += "       </div>";
            html += '       <div class="span1">';
            html += '           <div class=" btn btn-primary pull-right" style="width: 18px; margin-left:0px;" title="Reset Question Logic" onclick="reset_question_logic(this,\'' + self.sid + '\');"><i class="fa fa-refresh"></i></div>';
            html += '       </div>';
            html += "   </div>";
            html += "<div class='global_logic_section' style='width: 624px;'>";
            var logic_seq = 1;
            // load saved logic list
            if (Object.keys(this.GF_saved_question_logic).length != 0) {

                $.each(this.GF_saved_question_logic, function (k, data) {

                    // Survey Questions
                    var options_que_list = '<option value="0">Select survey question</option>';
                    if (self.GF_all_questions) {
                        $.each(self.GF_all_questions, function (k, que_data) {
                            var selected = '';
                            if (data['que_id'] == que_data['que_id']) {
                                selected = 'selected';
                            }
                            options_que_list += '<option ' + selected + ' value="' + que_data['que_id'] + '">' + que_data['que_title'] + ' </option>';
                        });
                    }

                    html += '<div id="global_logic_row_' + logic_seq + '" class="thumbnail thumbnail_logic_section dashlet ui-draggable" data-type="dashlet" data-action="droppable">';
                    html += '<div data-dashlet="toolbar"> ';
                    html += '        <div class="dashlet-header">';
                    html += '                <div class="btn-toolbar pull-right">';
                    html += '                        <div class="btn-group" style="margin-top:5px;">';
                    html += '                                <a id="' + logic_seq + '" data-toggle="dropdown" rel="tooltip" title="" class="dropdown-toggle btn btn-invisible page_toggle" onclick="collapsePage(this);" data-placement="bottom" data-original-title="Toggle Visibility"><i data-action="loading" class="fa fa-chevron-up" track="click:dashletToolbarCog"></i></a>';
                    html += '                                <a style="display:none;" id="' + logic_seq + '_close" data-toggle="dropdown" rel="tooltip" title="" class="remove-glb-filter-row dropdown-toggle btn btn-invisible page_toggle" onclick="removeCurrentFilterBox(this);" data-placement="bottom" data-original-title="Remove"><i data-action="loading" class="fa fa-times-circle"></i></a>';
                    html += '                        </div>';
                    html += '                </div>';
                    html += '                <h4 data-toggle="dashlet" style="min-height:20px; background-color: #c5c5c5; padding: 7px 0px 0px 10px;" class="dashlet-title">      ';
                    html += '                        <div class="">   <span style="font-size: 12px; vertical-align: text-top;">Question : </span>  ';
                    html += "                                <select class='global_logic_que' id='global_logic_que_" + logic_seq + "' onchange='getLogicQueWise(this, \"" + app.date.toDatepickerFormat(userDateFormat) + "\")'>" + options_que_list + "</select> ";
                    html += '                        </div> ';
                    html += '                </h4>';
                    html += '        </div>';
                    html += '</div>';
                    html += '<div id="que_logic_answer_' + logic_seq + '" class="data-page ui-droppable ui-sortable logic_answer_section" data-dashlet="dashlet">';
                    html += '</div>';
                    // based on selected question show logic section
                    var url = App.api.buildURL("bc_survey", "generateQueLogicSection", "", {que_id: data['que_id'], logic_seq: logic_seq});
                    App.api.call('GET', url, {}, {
                        success: function (response) {
                            if (response) {
                                logic_seq = response['logic_seq'];
                                $('#global_logic_row_' + logic_seq).find('.logic_answer_section').replaceWith(response['html']);
                                if (data['logic_operator'] != '') {
                                    $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=logic_operator_' + logic_seq + ']').val(data['logic_operator']);
                                }
                                var length = $('#global_filter_report').find('.global_logic_section').find('.thumbnail_logic_section').length;
                                $('#global_filter_report').find('.global_logic_section').find('.thumbnail_logic_section').find('.remove-glb-filter-row').show();
                                if (length <= 1) {
                                    $('#global_filter_report').find('.global_logic_section').find('.thumbnail_logic_section').find('#1_close').hide();
                                }

                                if (data['logic_values'] != '') {
                                    if (data['logic_operator'] == 'between' || data['logic_operator'] == 'not_between') {
                                        var qType = $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=queType_value_' + logic_seq + ']').val();
                                        var logic_values = JSON.parse(data['logic_values']);
                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=logic_value_' + logic_seq + ']').hide();
                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=logic_value2_' + logic_seq + ']').hide();
                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('.between_notbetween_text').show();
                                        if (qType == 'date-time') {
                                            var arrlength = Object.keys(logic_values).length;
                                            if (arrlength <= 2) {
                                                $.each(logic_values, function (k, value) {
                                                    if (k == 0) {
                                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=between_notbetween_start_logic_value_' + logic_seq + ']').val(value);
                                                    } else {
                                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=between_notbetween_end_logic_value_' + logic_seq + ']').val(value);
                                                    }
                                                });
                                            } else {
                                                $.each(logic_values, function (k, value) {
                                                    if (k == 0) {
                                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=between_notbetween_start_logic_value_' + logic_seq + ']').val(value);
                                                    } else if (k == 1) {
                                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=between_notbetween_start_logic_value2_' + logic_seq + ']').val(value);
                                                    } else if (k == 2) {
                                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=between_notbetween_end_logic_value_' + logic_seq + ']').val(value);
                                                    } else if (k == 3) {
                                                        $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=between_notbetween_end_logic_value2_' + logic_seq + ']').val(value);
                                                    }
                                                });
                                            }
                                        } else {
                                            $.each(logic_values, function (k, value) {
                                                if (k == 0) {
                                                    $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=between_notbetween_start_logic_value_' + logic_seq + ']').val(value);
                                                } else {
                                                    $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=between_notbetween_end_logic_value_' + logic_seq + ']').val(value);
                                                }
                                            });
                                        }
                                    } else {
                                        $.each(data['logic_values'], function (k, value) {
                                            var attrVal = $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=logic_value_' + logic_seq + ']').attr('type');
                                            if (attrVal == 'text' || typeof attrVal == 'undefined') {
                                                if (k == 1) {
                                                    $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=logic_value2_' + logic_seq + ']').val(value);
                                                } else {
                                                    $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[name=logic_value_' + logic_seq + ']').val(value);
                                                }
                                            }
                                            if (attrVal == 'checkbox') {
                                                $('#global_logic_row_' + logic_seq).find('.logic_answer_section').find('[value=' + value + ']').attr('checked', true);
                                            }
                                        });
                                    }
                                    var userDateFormat = self.getUserDateFormat();
                                    var options = {
                                        format: app.date.toDatepickerFormat(userDateFormat),
                                        languageDictionary: self._patchPickerMeta(),
                                        weekStart: parseInt(app.user.getPreference('first_day_of_week'), 10)
                                    };
                                    $('.show_datepicker').datepicker(options);
                                    options = {
                                        timeFormat: 'H:i',
                                        step: 1,
                                        disableTextInput: true
                                    };
                                    $('.show_timepicker').timepicker(options);
                                    $('.logic_checkbox').on('click', function () {
                                        if ($(this).parent().find('input[type=checkbox]:checked').length == 1) {
                                            $(this).parent().find('input[type=checkbox]').prop('checked', false);
                                        } else {
                                            $(this).parent().find('input[type=checkbox]').prop('checked', true);
                                        }
                                    });
                                }

                            } else {
                                // If no question selected then hide logic section
                                $('#global_logic_row_' + logic_seq).find('.logic_answer_section').replaceWith('');
                                $('.middle-content').find('#que_logic_answer_' + logic_seq).slideUp();
                                $('.middle-content').find('#' + logic_seq + '.dropdown-toggle').parents('#global_logic_row_' + logic_seq).find('.page_toggle').children()[0].className = "fa fa-chevron-up";
                            }
                        }
                    });
                    html += '</div>';
                    logic_seq++;
                });
            } else {
                // add new logic
                html += '<div id="global_logic_row_' + logic_seq + '" class="thumbnail thumbnail_logic_section dashlet ui-draggable" data-type="dashlet" data-action="droppable">';
                html += '<div data-dashlet="toolbar"> ';
                html += '        <div class="dashlet-header">';
                html += '                <div class="btn-toolbar pull-right">';
                html += '                        <div class="btn-group" style="margin-top:5px;">';
                html += '                                <a id="' + logic_seq + '" data-toggle="dropdown" rel="tooltip" title="" class="dropdown-toggle btn btn-invisible page_toggle" onclick="collapsePage(this);" data-placement="bottom" data-original-title="Toggle Visibility"><i data-action="loading" class="fa fa-chevron-up" track="click:dashletToolbarCog"></i></a>';
                html += '                                <a style="display:none;" id="' + logic_seq + '_close" data-toggle="dropdown" rel="tooltip" title="" class="remove-glb-filter-row dropdown-toggle btn btn-invisible page_toggle" onclick="removeCurrentFilterBox(this);" data-placement="bottom" data-original-title="Remove"><i data-action="loading" class="fa fa-times-circle"></i></a>';
                html += '                        </div>';
                html += '                </div>';
                html += '                <h4 data-toggle="dashlet" style="min-height:20px; background-color: #c5c5c5; padding: 7px 0px 0px 10px;" class="dashlet-title">      ';
                html += '                        <div class="">   <span style="font-size: 12px; vertical-align: text-top;">Question : </span>  ';
                html += "                                <select class='global_logic_que' id='global_logic_que_" + logic_seq + "' onchange='getLogicQueWise(this, \"" + app.date.toDatepickerFormat(userDateFormat) + "\")'>" + options_que_list + "</select> ";
                html += '                        </div> ';
                html += '                </h4>';
                html += '        </div>';
                html += '</div>';
                html += '<div id="que_logic_answer_' + logic_seq + '" class="data-page ui-droppable ui-sortable logic_answer_section" data-dashlet="dashlet">';
                html += '</div>';
                html += '</div>';
            }

            html += "</div>";
            html += '<div style="margin-top:10px;"><div class=" btn btn-primary" style="width: 18px; margin-left:0px;" title="Add Question Logic" onclick="add_question_logic(this,\'' + self.sid + '\');"><i class="fa fa-plus"></i></div></div>';
            html += "   <div style='margin-top:7px;'>"
            html += "       <b>Note:</b> This Filter will be applied to <b>Question Wise Report</b> and <b>Individual Report</b>";
            html += "   </div>";
            html += '</div>';
        }

        html += '<div class="desc_div" style="background-color:#e8e8e8;padding:3px;font-size:16px;height: 34px;padding-top:10px;">                 \n\
                    <div class="btn btn-primary save_gb" style="float:left;" onclick="ApplyGlogalFilter();" tabindex="-1" id="save_gb" title="Apply Global Filter">Apply Global Filter</div>       </div>';
        $('#global_filter_main_div').html('<div id="global_filter_report">'
                + html +
                ' <a  href="javascript:void(0);" class="close_global_filter" onclick="close_global_filter_div(this)"></a>' +
                '</div>');
        var options = {
            format: app.date.toDatepickerFormat(userDateFormat),
            languageDictionary: this._patchPickerMeta(),
            weekStart: parseInt(app.user.getPreference('first_day_of_week'), 10)
        };
        $('.show_datepicker').datepicker(options);
        options = {
            format: 'h:i'
        };
        $('.show_timepicker').timepicker(options);
        // Adjust Date picker on scroll
        $('.middle-content').scroll(function () {
            // make sure the dom element exists before trying to place the datepicker
            $('.datepicker').datepicker('place');
        });
        // Hide time picker on scroll
        $('.middle-content').scroll(function () {
            // make sure the dom element exists before trying to place the datepicker
            $('.ui-timepicker-wrapper').hide();
        });
        // Hide time picker on focus out
        $('.show_timepicker').focusout(function () {
            // make sure the dom element exists before trying to place the datepicker
            $('.ui-timepicker-wrapper').hide();
        });
        $('.logic_checkbox').on('click', function () {
            if ($(this).parent().find('input[type=checkbox]:checked').length == 1) {
                $(this).parent().find('input[type=checkbox]').prop('checked', false);
            } else {
                $(this).parent().find('input[type=checkbox]').prop('checked', true);
            }
        });
        $('.match_cases_span').on('click', function () {
            $(this).find('input[type=radio]').prop('checked', true);
        });
        } else {
            App.alert.show('global_filter_error', {
                level: 'error',
                title: '',
                messages: 'Please select atleast one of the filter option.',
                autoClose: true
            });
        }
    },

    /* Draw Status Trend Report Based On Survey Submission Statistics. */
    drawStatusTrendReportData: function (data, report_type) {
        var sel_by_day = '';
        var sel_by_week = '';
        var sel_by_month = '';
        var sel_by_year = '';
        var trend_line_chart_by_day = 'display:none;'
        var trend_tbl_chart_by_day = 'display:none;'
        var trend_line_chart_by_week = 'display:none;'
        var trend_tbl_chart_by_week = 'display:none;'
        var trend_line_chart_by_month = 'display:none;'
        var trend_tbl_chart_by_month = 'display:none;'
        var trend_line_chart_by_year = 'display:none;'
        var trend_tbl_chart_by_year = 'display:none;'
        var status_trend_report_html = '';
        switch (data['trendsStatusReportDataArray']['defaultLoadVal']) {
            case 'by_day':
                sel_by_day = 'selected';
                trend_line_chart_by_day = 'display:block;';
                trend_tbl_chart_by_day = 'display:block;';
                break;
            case 'by_week':
                sel_by_week = 'selected';
                trend_line_chart_by_week = 'display:block;';
                trend_tbl_chart_by_week = 'display:block;';
                break;
            case 'by_month':
                sel_by_month = 'selected';
                trend_line_chart_by_month = 'display:block;';
                trend_tbl_chart_by_month = 'display:block;';
                break;
            case 'by_year':
                sel_by_year = 'selected';
                trend_line_chart_by_year = 'display:block;';
                trend_tbl_chart_by_year = 'display:block;';
                break;

        }
        status_trend_report_html += '<div id="trend_status_section" style="display:none">';
        status_trend_report_html += '<div class="trend_report_display_dd" id="trend_report_dd_Div_' + report_type + '"  style="">';
        if (data['trendsStatusReportDataArray']['by_day'] == '') {
            status_trend_report_html += '<p align="center" class="trend-status-no-submission">There is no submission for this Survey.</p>';
        } else {
            status_trend_report_html += '<select id="trend_DD" class="trend_StatusDD">';
            status_trend_report_html += '<option value="by_day" ' + sel_by_day + ' >By Day</option>';
            status_trend_report_html += '<option value="by_week" ' + sel_by_week + ' >By Week</option>';
            status_trend_report_html += '<option value="by_month" ' + sel_by_month + ' >By Month</option>';
            status_trend_report_html += '<option value="by_year" ' + sel_by_year + ' >By Year</option>';
            status_trend_report_html += '</select>';
        }

        var thHtml = '<th  > <b>Date Range</b><div class="olFontClass"><b>Date Range</b></div> </th>';
        thHtml += '<th  > <b>Response Percent</b><div class="olFontClass"><b>Response Percent</b></div> </th>';
        thHtml += '<th  > <b>Response Count</b><div class="olFontClass"><b>Response Count</b></div> </th>';
        status_trend_report_html += '</div>';
        status_trend_report_html += '<div class="trend_report_display" id="trend_line_chart_by_day_' + report_type + '"  style="width:100%;"></div><input type="hidden" id="pdf_chart_img_trend_line_by_day_' + report_type + '" />';
        status_trend_report_html += '<div class="trend_report_display trend-tbl-report" id="trend_tbl_chart_by_day_' + report_type + '" style="height: 250px;margin-top:27px;margin-left: 5%;' + trend_tbl_chart_by_day + '">';
        status_trend_report_html += '<div class="trend-tbl-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
        status_trend_report_html += '<thead ><tr class="thead">';
        status_trend_report_html += thHtml;
        status_trend_report_html += '</tr></thead><tbody>';
        $.each(data['trendsStatusReportDataArray']['by_day'], function (dRange, arr) {
            status_trend_report_html += '<tr>';
            status_trend_report_html += '<td>' + arr.value + '</td>';
            status_trend_report_html += '<td>' + arr.percent + '%' + '</td>';
            status_trend_report_html += '<td>' + arr.count + '</td>';
            status_trend_report_html += '</tr>';
        });
        status_trend_report_html += '</tbody></table></div></div>';
        status_trend_report_html += '</div>';
        status_trend_report_html += '<div class="trend_report_display" id="trend_line_chart_by_week_' + report_type + '"  style="width:100%;"></div><input type="hidden" id="pdf_chart_img_trend_line_by_week_' + report_type + '" />';
        status_trend_report_html += '<div class="trend_report_display trend-tbl-report" id="trend_tbl_chart_by_week_' + report_type + '" style="height: 250px;margin-top:27px;margin-left: 5%;' + trend_tbl_chart_by_week + '">';
        status_trend_report_html += '<div class="trend-tbl-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
        status_trend_report_html += '<thead ><tr class="thead">';
        status_trend_report_html += thHtml;
        status_trend_report_html += '</tr></thead><tbody>';
        $.each(data['trendsStatusReportDataArray']['by_week'], function (dRange, arr) {
            status_trend_report_html += '<tr>';
            status_trend_report_html += '<td>' + arr.value + '</td>';
            status_trend_report_html += '<td>' + arr.percent + '%' + '</td>';
            status_trend_report_html += '<td>' + arr.count + '</td>';
            status_trend_report_html += '</tr>';
        });
        status_trend_report_html += '</tbody></table></div></div>';
        status_trend_report_html += '</div>';
        status_trend_report_html += '<div class="trend_report_display" id="trend_line_chart_by_month_' + report_type + '"  style="width:100%;"></div><input type="hidden" id="pdf_chart_img_trend_line_by_month_' + report_type + '" />';
        status_trend_report_html += '<div class="trend_report_display trend-tbl-report" id="trend_tbl_chart_by_month_' + report_type + '" style="height: 250px;margin-top:27px;margin-left: 5%;' + trend_tbl_chart_by_month + '">';
        status_trend_report_html += '<div class="trend-tbl-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
        status_trend_report_html += '<thead ><tr class="thead">';
        status_trend_report_html += thHtml;
        status_trend_report_html += '</tr></thead><tbody>';
        $.each(data['trendsStatusReportDataArray']['by_month'], function (dRange, arr) {
            status_trend_report_html += '<tr>';
            status_trend_report_html += '<td>' + arr.value + '</td>';
            status_trend_report_html += '<td>' + arr.percent + '%' + '</td>';
            status_trend_report_html += '<td>' + arr.count + '</td>';
            status_trend_report_html += '</tr>';
        });
        status_trend_report_html += '</tbody></table></div></div>';
        status_trend_report_html += '</div>';
        status_trend_report_html += '<div class="trend_report_display" id="trend_line_chart_by_year_' + report_type + '"  style="width:100%;"></div><input type="hidden" id="pdf_chart_img_trend_line_by_year_' + report_type + '" />';
        status_trend_report_html += '<div class="trend_report_display trend-tbl-report" id="trend_tbl_chart_by_year_' + report_type + '" style="height: 250px;margin-top:27px;margin-left: 5%;' + trend_tbl_chart_by_year + '">';
        status_trend_report_html += '<div class="trend-tbl-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
        status_trend_report_html += '<thead ><tr class="thead">';
        status_trend_report_html += thHtml;
        status_trend_report_html += '</tr></thead><tbody>';
        $.each(data['trendsStatusReportDataArray']['by_year'], function (dRange, arr) {
            status_trend_report_html += '<tr>';
            status_trend_report_html += '<td>' + arr.value + '</td>';
            status_trend_report_html += '<td>' + arr.percent + '%' + '</td>';
            status_trend_report_html += '<td>' + arr.count + '</td>';
            status_trend_report_html += '</tr>';
        });
        status_trend_report_html += '</tbody></table></div></div>';
        status_trend_report_html += '</div>';
        status_trend_report_html += '</div>';
        $.ajax({
            url: 'https://www.google.com/jsapi',
            cache: true,
            dataType: 'script',
            success: function () {
                var defaultLoadVal = data['trendsStatusReportDataArray']['defaultLoadVal'];
                $.each(data['trendsStatusReportDataArray']['trendStatuslineChartData'], function (rangeType, arr) {
                    google.load('visualization', '1', {'packages': ['line'], 'callback': function () {
                            var lineChart_data = arr;
                            var data = google.visualization.arrayToDataTable(lineChart_data);
                            var options = {
                                title: '',
                                pointSize: 7,
                                width: '1200',
                                height: 300,
                                legend: {position: 'top'},
                                hAxis: {viewWindowMode: "explicit", viewWindow: {}, slantedText: true, slantedTextAngle: 10},
                                vAxis: {format: '0', viewWindowMode: "explicit", viewWindow: {}},
                                is3D: true,
                            };
                            data.sort([{column: 0}]);
                            var chart = new google.visualization.LineChart(document.getElementById('trend_line_chart_' + rangeType + '_' + report_type));
                            chart.draw(data, options);
                            document.getElementById('pdf_chart_img_trend_line_' + rangeType + '_' + report_type).value = chart.getImageURI();
                            if (rangeType !== defaultLoadVal) {
                                $('#trend_line_chart_' + rangeType + '_' + report_type).css('display', 'none');
                            }
                        }
                    });
                });
            }
        });
        return status_trend_report_html;
    },
    /* Draw Question Trend Report Based On Survey Question Submission Statistics. */
    drawQuestionTrendReportData: function (qID, data, report_type) {
        var sel_by_day = '';
        var sel_by_week = '';
        var sel_by_month = '';
        var sel_by_year = '';
        var trend_line_chart_by_day = 'display:none;'
        var trend_tbl_chart_by_day = 'display:none;'
        var trend_line_chart_by_week = 'display:none;'
        var trend_tbl_chart_by_week = 'display:none;'
        var trend_line_chart_by_month = 'display:none;'
        var trend_tbl_chart_by_month = 'display:none;'
        var trend_line_chart_by_year = 'display:none;'
        var trend_tbl_chart_by_year = 'display:none;'
        var question_trend_report_html = '';
        question_trend_report_html += '<div class="trend_question_section" id="trend_status_section_' + qID + '_' + report_type + '" style="display:none"><div style="text-align:center;"><b>Global Filter(s)</b> will not be applied in <b>Trend Report</b>.</div>';
        if (typeof data['trendsQuestionReportDataArray'][qID] !== 'undefined') {
            switch (data['trendsQuestionReportDataArray'][qID]['defaultLoadVal']) {
                case 'by_day':
                    sel_by_day = 'selected';
                    trend_line_chart_by_day = 'display:table;';
                    trend_tbl_chart_by_day = 'display:block;';
                    break;
                case 'by_week':
                    sel_by_week = 'selected';
                    trend_line_chart_by_week = 'display:table;';
                    trend_tbl_chart_by_week = 'display:block;';
                    break;
                case 'by_month':
                    sel_by_month = 'selected';
                    trend_line_chart_by_month = 'display:table;';
                    trend_tbl_chart_by_month = 'display:block;';
                    break;
                case 'by_year':
                    sel_by_year = 'selected';
                    trend_line_chart_by_year = 'display:table;';
                    trend_tbl_chart_by_year = 'display:block;';
                    break;

            }
            question_trend_report_html += '<input type="hidden" id="default_trendData_' + report_type + '_' + qID + '" value="' + data['trendsQuestionReportDataArray'][qID]['defaultLoadVal'] + '">';
            question_trend_report_html += '<div class="trend_report_display_dd" id="trend_report_dd_Div_' + report_type + '_' + qID + '"  style="">';
            if (data['trendsQuestionReportDataArray'][qID]['trendQuestiontableData']['by_day'] == '') {
                question_trend_report_html += '<p align="center" class="trend-status-no-submission">There is no submission for this Survey.</p>';
            } else {
                question_trend_report_html += '<select id="trend_DD" class="trend_QuestionDD">';
                question_trend_report_html += '<option value="by_day" ' + sel_by_day + ' >By Day</option>';
                question_trend_report_html += '<option value="by_week" ' + sel_by_week + ' >By Week</option>';
                question_trend_report_html += '<option value="by_month" ' + sel_by_month + ' >By Month</option>';
                question_trend_report_html += '<option value="by_year" ' + sel_by_year + ' >By Year</option>';
                question_trend_report_html += '</select>';
            }

            var thHtml = '<th  > <b>Date Range</b><div class="olFontClass"><b>Date Range</b></div> </th>';
            thHtml += '<th  > <b>Response Percent</b><div class="olFontClass"><b>Response Percent</b></div> </th>';
            thHtml += '<th  > <b>Response Count</b><div class="olFontClass"><b>Response Count</b></div> </th>';
            question_trend_report_html += '</div>';
            question_trend_report_html += '<div class="trend_report_display" id="trend_line_chart_by_day_' + report_type + '_' + qID + '"  style="' + trend_line_chart_by_day + '"></div><input type="hidden" id="pdf_chart_img_trend_line_by_day_' + report_type + '_' + qID + '" />';
            question_trend_report_html += '<div class="trend_report_display trend-tbl-report" id="trend_tbl_chart_by_day_' + report_type + '_' + qID + '" style="height: 250px;margin-top:27px;' + trend_tbl_chart_by_day + '">';
            question_trend_report_html += '<div class="trend-tbl-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
            question_trend_report_html += '<thead ><tr class="thead">';
            question_trend_report_html += thHtml;
            question_trend_report_html += '</tr></thead><tbody>';
            $.each(data['trendsQuestionReportDataArray'][qID]['trendQuestiontableData']['by_day'], function (dRange, arr) {
                question_trend_report_html += '<tr>';
                question_trend_report_html += '<td>' + arr.value + '</td>';
                question_trend_report_html += '<td>' + arr.percent + '%' + '</td>';
                question_trend_report_html += '<td>' + arr.count + '</td>';
                question_trend_report_html += '</tr>';
            });
            question_trend_report_html += '</tbody></table></div></div>';
            question_trend_report_html += '</div>';
            question_trend_report_html += '<div class="trend_report_display" id="trend_line_chart_by_week_' + report_type + '_' + qID + '"  style="' + trend_line_chart_by_week + '"></div><input type="hidden" id="pdf_chart_img_trend_line_by_week_' + report_type + '_' + qID + '" />';
            question_trend_report_html += '<div class="trend_report_display trend-tbl-report" id="trend_tbl_chart_by_week_' + report_type + '_' + qID + '" style="height: 250px;margin-top:27px;' + trend_tbl_chart_by_week + '">';
            question_trend_report_html += '<div class="trend-tbl-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
            question_trend_report_html += '<thead ><tr class="thead">';
            question_trend_report_html += thHtml;
            question_trend_report_html += '</tr></thead><tbody>';
            $.each(data['trendsQuestionReportDataArray'][qID]['trendQuestiontableData']['by_week'], function (dRange, arr) {
                question_trend_report_html += '<tr>';
                question_trend_report_html += '<td>' + arr.value + '</td>';
                question_trend_report_html += '<td>' + arr.percent + '%' + '</td>';
                question_trend_report_html += '<td>' + arr.count + '</td>';
                question_trend_report_html += '</tr>';
            });
            question_trend_report_html += '</tbody></table></div></div>';
            question_trend_report_html += '</div>';
            question_trend_report_html += '<div class="trend_report_display" id="trend_line_chart_by_month_' + report_type + '_' + qID + '"  style="' + trend_line_chart_by_month + '"></div><input type="hidden" id="pdf_chart_img_trend_line_by_month_' + report_type + '_' + qID + '" />';
            question_trend_report_html += '<div class="trend_report_display trend-tbl-report" id="trend_tbl_chart_by_month_' + report_type + '_' + qID + '" style="height: 250px;margin-top:27px;' + trend_tbl_chart_by_month + '">';
            question_trend_report_html += '<div class="trend-tbl-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
            question_trend_report_html += '<thead ><tr class="thead">';
            question_trend_report_html += thHtml;
            question_trend_report_html += '</tr></thead><tbody>';
            $.each(data['trendsQuestionReportDataArray'][qID]['trendQuestiontableData']['by_month'], function (dRange, arr) {
                question_trend_report_html += '<tr>';
                question_trend_report_html += '<td>' + arr.value + '</td>';
                question_trend_report_html += '<td>' + arr.percent + '%' + '</td>';
                question_trend_report_html += '<td>' + arr.count + '</td>';
                question_trend_report_html += '</tr>';
            });
            question_trend_report_html += '</tbody></table></div></div>';
            question_trend_report_html += '</div>';
            question_trend_report_html += '<div class="trend_report_display" id="trend_line_chart_by_year_' + report_type + '_' + qID + '"  style="' + trend_line_chart_by_year + '"></div><input type="hidden" id="pdf_chart_img_trend_line_by_year_' + report_type + '_' + qID + '" />';
            question_trend_report_html += '<div class="trend_report_display trend-tbl-report" id="trend_tbl_chart_by_year_' + report_type + '_' + qID + '" style="height: 250px;margin-top:27px;' + trend_tbl_chart_by_year + '">';
            question_trend_report_html += '<div class="trend-tbl-class1"><div class="trend-tbl-class2" ><table align = "left" id = "multi_table" class = "model-tbl table table-striped table-bordered table-condensed" style = "" >';
            question_trend_report_html += '<thead ><tr class="thead">';
            question_trend_report_html += thHtml;
            question_trend_report_html += '</tr></thead><tbody>';
            $.each(data['trendsQuestionReportDataArray'][qID]['trendQuestiontableData']['by_year'], function (dRange, arr) {
                question_trend_report_html += '<tr>';
                question_trend_report_html += '<td>' + arr.value + '</td>';
                question_trend_report_html += '<td>' + arr.percent + '%' + '</td>';
                question_trend_report_html += '<td>' + arr.count + '</td>';
                question_trend_report_html += '</tr>';
            });
            question_trend_report_html += '</tbody></table></div></div>';
            question_trend_report_html += '</div>';
            $.ajax({
                url: 'https://www.google.com/jsapi',
                cache: true,
                dataType: 'script',
                success: function () {
                    $.each(data['trendsQuestionReportDataArray'][qID]['trendQuestionChartData'], function (rangeType, arr) {
                        google.load('visualization', '1', {'packages': ['line'], 'callback': function () {
                                var lineChart_data = arr;
                                var data = google.visualization.arrayToDataTable(lineChart_data);
                                var options = {
                                    title: '',
                                    pointSize: 7,
                                    width: 1200,
                                    height: 300,
                                    legend: {position: 'top'},
                                    hAxis: {viewWindowMode: "explicit", viewWindow: {}, slantedText: true, slantedTextAngle: 10},
                                    vAxis: {format: '0', viewWindowMode: "explicit", viewWindow: {}},
                                    is3D: true,
                                };
                                data.sort([{column: 0}]);
                                var chart = new google.visualization.LineChart(document.getElementById('trend_line_chart_' + rangeType + '_' + report_type + '_' + qID));
                                chart.draw(data, options);
                                document.getElementById('pdf_chart_img_trend_line_' + rangeType + '_' + report_type + '_' + qID).value = chart.getImageURI();
                            }
                        });
                    });
                }
            });
        } else {
            question_trend_report_html += '<p style="text-align: center;">There is no submission for this question.</p>';
        }

        question_trend_report_html += '</div>';
        return question_trend_report_html;
    },
    questionWiseExport: function (el) {
        var GF_saved_question_logic = $('#current_global_filter_logic').val();
        var globalfilterLogics = GF_saved_question_logic.split('&');
        var globalfilterlogicObj = {};
        $.each(globalfilterLogics, function (k, v) {
            if (v != '') {
                var pair = v.split('=');
                var key = pair[0];
                var value = pair[1];
                globalfilterlogicObj[key] = value;
            }
        });
        var JsonGfData = JSON.stringify(globalfilterlogicObj);
        var exportfrom = 'combined';
        var reportType = $('#current_active_report_tab').val();
        if (typeof $('#' + reportType + '_report_data_section') !== 'undefined') {
            $('#' + reportType + '_report_data_section').find('.accordion-inner').each(function () {
                if ($(this).is(":hidden") === false) {
                    var id_split = $(this).attr('id').split('_');
                    exportfrom = id_split[3];
                }
            });
        }
        var fromIndividualQuestion = true;
        var qIDParam = $(el.currentTarget).attr('id').split('_');
        var qID = qIDParam[1];
        var exportAS = 'image';
        if (qIDParam[0] == 'questionPDFExport') {
            exportAS = 'pdf';
            $(el.currentTarget).removeClass('fa fa-file-pdf-o').addClass('fa fa-refresh fa-spin');
            $(el.currentTarget).css('cursor', 'default');
        } else {
            $(el.currentTarget).removeClass('fa fa-picture-o').addClass('fa fa-refresh fa-spin');
            $(el.currentTarget).css('cursor', 'default');
        }
        
        var exportby = '';
        var selectedRange = {};
        var selectedRangeVal = '';
        var questionPDFData = '';
        var exportReport = $('#current_question_wise_tab').val();
        var selChart = $('#chart_selection_' + qID + '_' + exportfrom).val();
        if (selChart == 'npsgaugechart') {
            selChart = 'npsbarchart';
        }
        var ImgUrl = $('#pdf_chart_img_' + qID + '_' + exportfrom + '_' + selChart).val();
        var getSelDetails = $('#export_question_selection_details').val();
        if (exportReport == 'trend') {
            exportby = $('#trend_report_dd_Div_' + exportfrom + '_' + qID).find('.trend_QuestionDD').val();
            selectedRange = {'range': exportby};
            ImgUrl = $('#pdf_chart_img_trend_line_' + exportby + '_' + exportfrom + '_' + qID).val();
            getSelDetails = $('#export_question_selection_details_trend').val();
            selectedRangeVal = JSON.stringify(selectedRange);
        }
        var survey_id = $('#questionWiseImageExport').find('input[name=survey_id]').val();
        var getCanvas; // global variable
        var canvasURL = '';
        if (getSelDetails !== '') {
            getSelDetails = JSON.parse(getSelDetails);
            getSelDetails[qID] = {'stats': 'hide', 'chartImg': ImgUrl};
            questionPDFData = JSON.stringify(getSelDetails);
        } else {
            if (typeof getSelDetails !== 'object') {
                getSelDetails = {};
                getSelDetails[qID] = {'stats': 'hide', 'chartImg': ImgUrl};
                questionPDFData = JSON.stringify(getSelDetails);
            }
        }

        var url = App.api.buildURL("bc_survey", "makeQuestionWiseExportContent");
        App.api.call('create', url, {survey_id: survey_id, status_type: exportfrom, JsonGfData: JsonGfData, exportReport: exportReport, selectedRangeVal: selectedRangeVal, fromIndividualQuestion: fromIndividualQuestion, qID: qID, questionPDFData: questionPDFData,exportAS:exportAS}, {
            success: function (qchartData) {
                $('#demoImage').html('');
                $('#demoImage').show()
                $('#demoImage').append(qchartData);
                var htmlContent = $('#demoImage')[0];
                html2canvas(htmlContent).then(function (canvas) {
                    $('#demoImage').hide();
                    getCanvas = canvas;
                    canvasURL = getCanvas.toDataURL("image/png");
                    
                    if (exportAS == 'image') {
                        canvasURL = canvasURL.replace("data:image/png;base64,", "");
                    }
                    $('#questionWiseImageExport').find('input[name=canvasUrl]').val(canvasURL);
                    $('#questionWiseImageExport').find('input[name=que_id]').val(qID);
                    $('#questionWiseImageExport').find('input[name=exportAS]').val(exportAS);
                    $('#questionWiseImageExport').find('input[name=textHtml]').val(qchartData);
                    $('#questionWiseImageExport').submit();
                    if (exportAS == 'image') {
                        $(el.currentTarget).removeClass('fa fa-refresh fa-spin').addClass('fa fa-picture-o');
                        $(el.currentTarget).css('cursor', 'pointer');
                    } else {
                        $(el.currentTarget).removeClass('fa fa-refresh fa-spin').addClass('fa fa-file-pdf-o');
                        $(el.currentTarget).css('cursor', 'pointer');
                    }
                });
            }
        });
    },
})
