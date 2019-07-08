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
    contextEvents: {
        "list:editrow:fire": "editClicked",
        "list:deleterow:fire": "warnDelete",
        "list:previewsurvey:fire": "previewClicked",
        "list:view_report:fire": "viewReportClicked",
        "list:get_shareable_link:fire": "getShareableLink"
    },
    events: {
        "click [name=create_poll_button]": 'create_poll'
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

        if (localStorage['isListPoll'] && options.context.get("dataView") == "list") {
            options.context.set("currentFilterId", "poll-records");
        } else {
            delete localStorage['isListPoll'];
            options.context.set("currentFilterId", "survey-records");
        }
        // Survey Status :: LoadedTech Customization
        // Bind "Set red Next Review Date" functionality with data syncronization
        this.listenTo(this.collection, 'data:sync:complete', this.displayColoredStatus);
    },

    _setRowFields: function () {
     this._super('_setRowFields');
     if (typeof $('.flex-list-view-content').find('.reorderable-columns').find('tr.single') != 'undefined') {
            $('.flex-list-view-content').find('.reorderable-columns').find('tr.single').each(function () {
                var elment = this;
                var name = $(elment).attr('name').split('_');
                var recID = name[2];
                var url = App.api.buildURL("bc_survey", "generate_unique_survey_submit_id", "", {survey_id: recID, status: ''});
                App.api.call('GET', url, {}, {
                    success: function (copyText) {
                         $(elment).find('td').eq(-2).append("<div id='div_shareable_link_" + recID + "' style='display:none;'><input type='text' id='shareable_link_" + recID + "' value='" + copyText + "'></div>");
                    }
                });

            });
        }
    },
    _render: function () {

        this._super('_render');
        // To enable and put Get Shareable Link In Listview.
        var self = this;

        // End
        // If View Poll then change headerpane as per Poll
        if (localStorage['isListPoll'])
        {
            delete localStorage['isListPoll'];

            var html = '';
            html += '<div class="headerpane">';
            html += '    <h1>';
            html += '                <span class="record-cell" data-type="label" data-name="title">';
            html += '                    <span class="table-cell-wrapper">';
            html += '                        <span class="index" data-fieldname="title" data-index="">';
            html += '                            <span sfuuid="775" class="list-headerpane"> Poll</span>';
            html += '                        </span>';
            html += '                    </span>';
            html += '                </span>';
            html += '            <div class="btn-toolbar pull-right dropdown">';
            html += '                    <span sfuuid="776" class="list-headerpane">';
            html += '    <a class="btn btn-primary" href="#bc_survey/create" onclick="localStorage[\'isCreatePoll\'] = true;" name="create_poll_button">';
            html += '    Create</a>';
            html += '    </span>';
            html += '                    <span sfuuid="777" class="list-headerpane" tabindex="-1">';
            html += '    <button class="btn btn-invisible sidebar-toggle" rel="tooltip" title="" data-placement="left" track="click:togglesidebar" data-original-title="Open/Close Dashboard">';
            html += '        <i class="fa fa-angle-double-right"></i>';
            html += '    </button>';
            html += '    </span>';
            html += '            </div>';
            html += '        </h1>';
            html += '</div>';
            $('.headerpane').replaceWith(html);
        }
        
        // Bind "Set red Next Review Date" functionality with data syncronization
        this.listenTo(this.collection, 'data:sync:complete', this.displayColoredStatus);
    },
    displayColoredStatus: function () {
        

        _.each(this.rowFields, function (field) {
            
            $.each(field, function (key, value) {
                if (field[key].model.get('survey_send_status') == 'active' && value.name == 'survey_send_status')
                {
                    field[key].$el.css('color', '#fff');
                    field[key].$el.css('background-color', 'green');
                    field[key].$el.css('text-align', 'center');
                    field[key].$el.css('border-radius', '3px');
                    field[key].$el.attr('rel', 'tooltip');
                    field[key].$el.attr('data-original-title', 'Published');
                } else if (field[key].model.get('survey_send_status') == 'inactive' && value.name == 'survey_send_status') {
                    field[key].$el.css('border', '1px solid #555');
                    field[key].$el.css('text-align', 'center');
                    field[key].$el.css('border-radius', '3px');
                    field[key].$el.attr('rel', 'tooltip');
                    field[key].$el.css('background-color', '#e5a117');
                    field[key].$el.css('border', '1px solid #e5a117');
                    field[key].$el.css('color', '#fff');
                    field[key].$el.attr('data-original-title', 'Unpublished');
                }
                
                if (field[key].model.get('survey_status') == 'Active' && value.name == 'survey_status')
                {
                    field[key].$el.css('color', '#fff');
                    field[key].$el.css('background-color', 'green');
                    field[key].$el.css('text-align', 'center');
                    field[key].$el.css('border-radius', '3px');
                    field[key].$el.attr('rel', 'tooltip');
                    field[key].$el.attr('data-original-title', 'Active');
                } else if (field[key].model.get('survey_status') == 'Inactive' && value.name == 'survey_status') {
                    field[key].$el.css('border', '1px solid #555');
                    field[key].$el.css('text-align', 'center');
                    field[key].$el.css('border-radius', '3px');
                    field[key].$el.attr('rel', 'tooltip');
                    field[key].$el.css('background-color', '#e5a117');
                    field[key].$el.css('border', '1px solid #e5a117');
                    field[key].$el.css('color', '#fff');
                    field[key].$el.attr('data-original-title', 'Inactive');
                }
            });
        });
    },
    create_poll: function () {

        localStorage['isCreatePoll'] = true;
        javascript:parent.SUGAR.App.router.navigate("bc_survey/create", {trigger: true});
    },
    /**
     * Toggle the selected model's fields when edit is clicked.
     *
     * @param {Backbone.Model} model Selected row's model.
     */
    editClicked: function (model, field) {
        //check restrict edit or not   //////////////////////////
        var url = App.api.buildURL("bc_survey", "isSurveySend", "", {record: model.id});
        var self = this;
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data['restrict_edit'] == "1") {
                    if (self.model.get('survey_type') == 'poll')
                    {
                        var sent_msg = 'You can not edit a poll which is already sent.';
                    } else {
                        var sent_msg = 'You can not edit a survey which is already sent.';
                    }
                    app.alert.show('error', {
                        level: 'error',
                        messages: sent_msg,
                        autoClose: true
                    });
                } else {
                    if (field.def.full_form) {
                        self.createRelatedRecord(self.module, self.context.get('link'), model.id);
                    } else {
                        self.toggleRow(model.id, true);
                        //check to see if horizontal scrolling needs to be enabled
                        self.resize();
                    }
                }

            },
        });
    },
    /**
     * Popup dialog message to confirm delete action
     *
     * @param {Backbone.Model} model the bean to delete
     */
    warnDelete: function (model) {
        var self = this;
        this._modelToDelete = model;

        self._targetUrl = Backbone.history.getFragment();
        //Replace the url hash back to the current staying page
        if (self._targetUrl !== self._currentUrl) {
            app.router.navigate(self._currentUrl, {trigger: false, replace: true});
        }

        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: self.getDeleteMessages(model).confirmation,
            onConfirm: _.bind(self.deleteModel, self),
            onCancel: function () {
                self._modelToDelete = null;
            }
        });

    },
    viewReportClicked: function (model) {
        var self = this;
        var record_id = model.id;
        javascript:parent.SUGAR.App.router.navigate("bc_survey/" + record_id + "/layout/report", {trigger: true});
    },
    getShareableLink: function (model) {
        var self = this;
        var record_id = model.id;
        $('#div_shareable_link_' + record_id).show();
        var copyTextElment = document.getElementById("shareable_link_" + record_id)
        copyTextElment.select();
        /* Copy the text inside the text field */
        document.execCommand("Copy");
        $('#div_shareable_link_' + record_id).hide();
        app.alert.show('survey_link_copied', {
            level: 'success',
            messages: 'Survey Shareable Link copied to clipboard.',
            autoClose: true
        });
    },
    /*
     * Preview of survey
     */
    previewClicked: function (model) {

        var record_id = model.get("id");
        $.ajax({
            url: "index.php?entryPoint=preview_survey",
            type: "POST",
            data: {method: 'preview_survey'},
            success: function (data)
            {
                var newWin = window.open(data + '/preview_survey.php?survey_id=' + record_id);
                if (typeof newWin == "undefined") {
                    app.alert.show('info', {
                        level: 'info',
                        messages: 'Please allow your browser to show pop-ups.',
                        autoClose: true
                    });
                }

            },
        });
    },
    /**
     * Refreshes the `ReorderableColumns` when the table height changes.
     *
     * The `ReorderableColumns` plugin listens to the window `resize` event to
     * update and position the handlers correctly.
     *
     * @private
     */
    _refreshReorderableColumns: function() {
        
        $(window).resize();
        this.displayColoredStatus();
    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})
