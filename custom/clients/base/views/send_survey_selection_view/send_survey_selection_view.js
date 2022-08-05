({
    /**
     * Send survey selection view
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */

    className: 'send_survey_selection_view tcenter',
    initialize: function (options) {
        this._super("initialize", [options]);
        this.events = _.extend({}, this.events, {
            'click [name=open_survey_list]': 'open_survey_list',
        });
        this.selected_record_ids = options.context.attributes.selected_record_ids;
        this.module = options.context.attributes.module;
    },
    // open survey list
    open_survey_list: function () {
        var call = 'GetSurveys';
        var search_string = 'demo';
        var surveyModule = $('input[name="send_module_name"]').val();
        var arg = 'bc_survey/' + search_string + '/GetSurveys';
        app.api.call('create', app.api.buildURL(arg), {surveyModule: surveyModule},
        {
            success: function (data) {
                var survey_details = $.parseJSON(data);
                var survey_data = '';
                var edit_flag = 0;
                survey_data = self.detailview_data(survey_details, edit_flag);

                // edit page data on click of edit icon located on page header
                $(document).on('click', '.edit_page', function () {

                    var id = this.id;
                    edit_flag = 1;
                    self.detailview_data(survey_details, edit_flag, id);
                    $(document).find($('.create-survey')).show(); // show side-pane page-component

                });
                // Print html for current record survey pages 
                $('#detail_view').html(survey_data);

                //hide page data when first page load
                $(document).find($('.page_toggle').closest('.thumbnail').find('.data-page')).hide();
            }

        });
    }
});