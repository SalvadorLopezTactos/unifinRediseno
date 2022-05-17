({/**
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
    events: {
        'change .rec_type_selection': 'getRecipientModules',
        'change .rec_module_selection': 'getFilterOptions',
        'change .filter_by_selection': 'getModuleFields',
        'change .rec_field_selection': 'getOperatorSelection',
        'change .survey_selection': 'checkEmailTemplate',
        'click .cancel_action': '_disposeView',
        'click .save_action': 'saveAction',
        'click .update_action': 'saveAction',
        'click .createEmailTemplate': 'createEmailTemplateClicked'
    },
    initialize: function (options) {

        this.record_id = options.record_id;
        this.module = options.context.attributes.module;
        if (options.isCreate == false)
        {
            this.action_id = options.action_id;
        }


        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:Create_Survey_Auto_Action', function () {
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

        var rec_type = app.lang.getAppListStrings('recipient_type');
        this.recipient_type = rec_type;

        var target_module = options.target_module;
        if (target_module == 'Accounts' || target_module == 'Contacts' || target_module == 'Leads' || target_module == 'Prospects')
        {
            this.allowTargetToSendSurvey = true;
        }
    },
    _render: function () {
        this._super('_render');
        var self = this;

        if (self.options.isCreate == false)
        {
            $('.modal-header').find('h4').html("Update Survey Automation Action");
            $('.modal-body').append('<input type="hidden" value="' + this.action_id + '" id="action_id"/>')
            $('.modal-footer').find('.save_action').replaceWith("<div class='btn btn-primary update_action' style='float:left; margin-top:-9px; margin-left:-10px;' >Update Action</div>");
        }

        //Get Recipient type options
        var url = App.api.buildURL("bc_survey_actions", "getRecModules", "",
                {
                    record_id: this.record_id,
                    rec_type: 'target_module',
                });
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (!self.allowTargetToSendSurvey && (!data || data.length == 0)) {
                    $('.rec_type_selection').find('[value="target_module"]').hide();
                }
            }
        });
        var url = App.api.buildURL("bc_survey_actions", "getRecModules", "",
                {
                    record_id: this.record_id,
                    rec_type: 'related_module',
                });
        App.api.call('GET', url, {}, {
            success: function (data) {
                if ((!data || data.length == 0)) {
                    $('.rec_type_selection').find('[value="related_module"]').hide();
                }
            }
        });

        var url = App.api.buildURL("bc_survey_actions", "getSurveyList", "", {automizer_id: self.record_id, action_id: self.action_id, isCreate: self.options.isCreate});

        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data.length != 0) {
                    var options = '<option value="0">Select Survey</option>';
                    $.each(data, function (key, survey) {
                        options += '<option value="' + key + '">' + survey + '</option>';
                    });
                    $('.survey_selection').html(options);
                    // Retrive record to Update
                    if (self.options.isCreate == false)
                    {
                        var url = App.api.buildURL("bc_survey_actions", "getActionRecord", "", {action_id: self.action_id});

                        App.api.call('GET', url, {}, {
                            success: function (data) {
                                if (data) {
                                    self.rec_type = data['rec_type'];
                                    self.rec_module = data['rec_module'];
                                    self.filter_by = data['filter_by'];
                                    self.rec_field = data['rec_field'];
                                    self.operator = data['operator'];
                                    self.value = data['value'];
                                    self.email_field = data['email_field'];
                                    self.survey = data['survey'];

                                    $('.rec_type_selection').val(data['rec_type']);
                                    $('.rec_type_selection').trigger('change');

                                    $('.action_module_row').show();

                                    $('.action_email_row').show();
                                    $('.action_survey_row').show();

                                    $('.field_selection').val(data['email_field']);

                                    $('.survey_selection').val(data['survey']);
                                    $('.survey_selection').trigger('change');
                                    if (self.survey)
                                    {
                                        $('.action_email_temp_row').show();
                                    }
                                }
                            },
                        });
                    }
                }
                else {
                    $('.survey_selection').parent().html('Survey not found. <a onclick="javascript:SUGAR.App.router.navigate(\'bc_survey/create\', {trigger: true});"> click here</a> to create new one.');
                }
            }
        });

    },
    getRecipientModules: function () {
        var self = this;
        var rec_type = $('.rec_type_selection').val();
        var filter_type = $('.filterRecord_selection').val();
        var target_module = self.options.target_module;

        if (rec_type == 'target_module')
        {
            $('.action_module_row').show();
            $('.action_module_row').find('.label-field').html('Related Field');
            $('.action_operator_row').hide();
            $('.action_value_row').hide();
            $('.action_filterBy_row').hide();
            $('.action_field_row').hide();
        } else {
            $('.action_module_row').find('.label-field').html('Recipient Module');
            $('.action_module_row').show();
        }

        var url = App.api.buildURL("bc_survey_actions", "getRecModules", "",
                {
                    record_id: this.record_id,
                    rec_type: rec_type,
                });
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data) {

                    var options = '';
                    if (rec_type == 'target_module' && (target_module == 'Accounts' || target_module == 'Contacts' || target_module == 'Leads' || target_module == 'Prospects'))
                    {
                        options += '<option value="email1">Email Address</option>';
                    }
                    $.each(data, function (key, module) {
                        options += '<option value="' + key + '">' + module + '</option>';
                    });
                    $('.rec_module_selection').html(options);
                    if (self.rec_module)
                    {
                        $('.rec_module_selection').val(self.rec_module);
                        if (self.filter_by)
                        {
                            $('.action_filterBy_row').show();
                            $('.filter_by_selection').val(self.filter_by);
                            $('.filter_by_selection').trigger('change');
                        }
                    }
                    if (filter_type != 'target_record')
                    {
                        $('.action_module_row').show();
                    }
                    $('.action_email_row').show();
                    $('.action_survey_row').show();
                    if (self.survey)
                    {
                        $('.action_email_temp_row').show();
                    } else {
                        $('.action_email_temp_row').hide();
                    }
                } else {
                    $('.action_email_row').show();
                    if (filter_type != 'target_record')
                    {
                        $('.action_module_row').show();
                    }
                    $('.action_survey_row').show();
                    if (self.survey)
                    {
                        $('.action_email_temp_row').show();
                    } else {
                        $('.action_email_temp_row').hide();
                    }
                }

            },
        });
    },
    getModuleFields: function () {
        var self = this;
        var filter_by = $('.filter_by_selection').val();
        var rel_mod_name = $('.rec_module_selection').val();
        if (filter_by == 'any_related')
        {
            // Get related module fields for filtering
            var url = App.api.buildURL("bc_survey_condition", "getConditionFields", "", {record_id: this.record_id, rel_mod_name: rel_mod_name, type: 'action'});
            App.api.call('GET', url, {}, {
                success: function (data) {
                    if (data != '') {
                        $('.action_field_row').show();
                        var options = '<option value="none">None</option>';
                        $.each(data, function (key, module) {
                            options += '<option value="' + key + '">' + module + '</option>';
                        });
                        $('.rec_field_selection').html(options).show();
                        if (self.rec_field)
                        {
                            $('.rec_field_selection').val(self.rec_field);
                            $('.rec_field_selection').trigger('change');
                        }
                    }
                }
            });
        } else {
            $('.action_field_row').hide();
            $('.action_operator_row').hide();
            $('.action_value_row').hide();
        }
    },
    getOperatorSelection: function () {

        var self = this;
        $('.action_operator_row').show();
        if (self.operator)
        {
            $('.operator_selection').val(self.operator);
        }
        var rel_field = $('.rec_field_selection').val();
        var sel_fieldname = $('.rec_module_selection').val();

        // show values for selected field
        var url = App.api.buildURL("bc_survey_condition", "getConditionValue", "", {record_id: this.record_id, rel_field: rel_field, sel_type: 'Value', sel_fieldname: sel_fieldname});
        App.api.call('GET', url, {}, {
            success: function (data) {

                if (data != '') {
                    $('.action_value_row').show();
                    $('.value_selection_div').html(data).show();
                    if (self.value)
                    {
                        $('#filter__field_value').val(self.value);
                    }
                }
            }
        });
    },
    getFilterOptions: function () {
        var rec_type = $('.rec_type_selection').val();
        $('.action_operator_row').hide();
        $('.action_value_row').hide();
        $('.action_field_row').hide();
        if (rec_type == 'related_module')
        {
            $('.action_filterBy_row').show();
            $('.filter_by_selection').val('all_related');
            $('.action_email_row').show();
            $('.action_survey_row').show();
            if (this.survey)
            {
                $('.action_email_temp_row').show();
            } else {
                $('.action_email_temp_row').hide();
            }
        } else {
            $('.action_filterBy_row').hide();
            $('.action_email_row').show();
            $('.action_survey_row').show();
            if (this.survey)
            {
                $('.action_email_temp_row').show();
            } else {
                $('.action_email_temp_row').hide();
            }
        }
    },
    createEmailTemplateClicked: function () {

        var survey_ID = $('.survey_selection').val();
        var url = App.api.buildURL("bc_survey", "checkEmailTemplateForSurvey", "", {survey_ID: survey_ID});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data.trim() != '') {
                    $('.previewEmailTemplate').show();
                    $('.createEmailTemplate').hide();
                    $('.previewEmailTemplate').attr('onclick',"window.open(\'#bwc/index.php?module=EmailTemplates&action=DetailView&record=" + data + "')");

                } else {
                    window.open('#bwc/index.php?module=EmailTemplates&action=EditView&return_module=EmailTemplates&return_action=DetailView&survey_id=' + survey_ID);
                }
            }
        });
    },
    checkEmailTemplate: function () {
        var survey_ID = $('.survey_selection').val();
        var url = App.api.buildURL("bc_survey", "checkEmailTemplateForSurvey", "", {survey_ID: survey_ID});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data.trim() != '') {
                    $('.previewEmailTemplate').show();
                    $('.createEmailTemplate').hide();
                    $('.previewEmailTemplate').attr('onclick',"window.open(\'#bwc/index.php?module=EmailTemplates&action=DetailView&record=" + data + "')");
                } else {
                    $('.createEmailTemplate').show();
                    $('.previewEmailTemplate').hide();
                }
            }
        });
    },
    saveAction: function () {
        var self = this;
        var id = $('#action_id').val();
        var rec_type = $('.rec_type_selection').val(); // recipient type selection
        var survey_ID = $('.survey_selection').val(); // selected survey
        var rec_module = $('.rec_module_selection').val(); // email field or any related module or field
        var email_field = $('.field_selection').val(); // to,cc,bcc
        var filter_by = null;
        if (rec_type == 'related_module')
        {
            filter_by = $('.filter_by_selection').val();

            var operator = null;
            var value = null;
            var rec_field = null;
            if (filter_by == 'any_related')
            {
                rec_field = $('.rec_field_selection').val();
            }
            if (filter_by == 'any_related' && rec_field && rec_field != 'none')
            {
                operator = $('.operator_selection').val();
                value = $('#filter__field_value').val();
                // remove validations
                $('.rec_field_selection').removeClass('error-custom');
                $('.rec_field_selection').parent().find('.err-msg').hide();
            } else if (filter_by == 'any_related' && (!rec_field || rec_field == 'none')) {
                $('.rec_field_selection').addClass('error-custom');
                var parent = $('.rec_field_selection').addClass('error-custom').parent();
                if (parent.find('.err-msg').length == 0)
                {
                    parent.append('<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
                } else {
                    parent.find('.err-msg').show();
                }
            }
        }
        //validation for selecting recipient type
        if (!rec_type || rec_type == '0')
        {
            $('.rec_type_selection').addClass('error-custom');
            var parent = $('.rec_type_selection').addClass('error-custom').parent();
            if (parent.find('.err-msg').length == 0)
            {
                parent.append('<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
            } else {
                parent.find('.err-msg').show();
            }
        } else {
            $('.rec_type_selection').removeClass('error-custom');
            $('.rec_type_selection').parent().find('.err-msg').hide();
        }

        //validation for selecting recipient module
        if (rec_type == 'related_module' && !rec_module || rec_module == '0')
        {
            $('.rec_module_selection').addClass('error-custom');
            var parent = $('.rec_module_selection').addClass('error-custom').parent();
            if (parent.find('.err-msg').length == 0)
            {
                parent.append('<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
            } else {
                parent.find('.err-msg').show();
            }
        } else {
            $('.rec_module_selection').removeClass('error-custom');
            $('.rec_module_selection').parent().find('.err-msg').hide();
        }

        //validate value 
        if (filter_by == 'any_related' && !value)
        {
            $('#filter__field_value').addClass('error-custom');
            var parent = $('#filter__field_value').addClass('error-custom').parent();
            if (parent.find('.err-msg').length == 0)
            {
                parent.append('&nbsp;<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
            } else {
                parent.find('.err-msg').show();
            }
        } else {
            $('#filter__field_value').removeClass('error-custom');
            $('#filter__field_value').parent().find('.err-msg').hide();
        }

        //validation for selecting survey
        if (rec_type && !survey_ID || survey_ID == '0')
        {
            $('.survey_selection').addClass('error-custom');
            var parent = $('.survey_selection').addClass('error-custom').parent();
            if (parent.find('.err-msg').length == 0)
            {
                parent.append('<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
            } else {
                parent.find('.err-msg').show();
            }
        } else {
            $('.survey_selection').removeClass('error-custom');
            $('.survey_selection').parent().find('.err-msg').hide();
        }

        var errors = $('.error-custom').length;
        if (errors == 0)
        {

            if (survey_ID != '' && typeof survey_ID != 'undefined') {
                var url = App.api.buildURL("bc_survey", "checkEmailTemplateForSurvey", "", {survey_ID: survey_ID});
                App.api.call('GET', url, {}, {
                    success: function (data) {
                        if (data.trim() != '') {
                            var url = App.api.buildURL("bc_survey_actions", "saveActions", "",
                                    {
                                        action_id: id,
                                        record_id: self.record_id,
                                        rec_type: rec_type,
                                        rec_module: rec_module,
                                        filter_by: filter_by,
                                        rec_field: rec_field,
                                        operator: operator,
                                        value: value,
                                        email_field: email_field,
                                        surveyid: survey_ID,
                                        email_temp_id: data.trim()
                                    });

                            App.api.call('create', url, {}, {
                                success: function (result) {
                                    if (result) {
                                        App.alert.show('msg', {
                                            level: 'success',
                                            messages: 'Survey Automizer action saved successfully.',
                                            autoClose: true
                                        });
                                        self._disposeView();
                                        // self.refreshActionList();
                                        window.location.reload();
                                    }
                                },
                            });
                        } else {
                            App.alert.show('msg', {
                                level: 'error',
                                messages: 'Please create email template for selected survey.',
                                autoClose: true
                            });
                        }
                    }
                });

            } else {
                App.alert.show('msg', {
                    level: 'error',
                    messages: 'You must have to create/select survey to proceed.',
                    autoClose: true
                });
            }
        }
    },
    refreshActionList: function () {
        var self = this;
        var url = App.api.buildURL("bc_survey_actions", "DisplayActionList", "", {record: this.record_id});

        App.api.call('GET', url, {}, {
            success: function (data) {


                if (data) {
                    self.hasList = true;
                    self.actionList = data;
                    var list = '';
                    var index = 0;
                    $.each(data, function (k, value) {
                        index = parseInt(index) + 1;
                        list += '<tr class="action_row" id="' + value['id'] + '">';

                        list += '     <td>';
                        list += '            <span class="label-field">' + index + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['rec_type'] + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['rec_module'] + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['email_field'] + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['survey'] + '</span>';
                        list += '     </td>';

                        list += '     <td style="text-align:center;">';
                        list += '           <a class="editAction"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="removeAction"><i class="fa fa-times"></i></a>';
                        list += '     </td>';

                        list += '</tr>';
                    });
                    if (!list)
                    {
                        list += '<tr>';
                        list += '     <td colspan="7">';
                        list += '           <p align="center">No Records Found.</p>';
                        list += '     </td>';

                        list += '</tr>';
                    }
                    $('.ActionListBody').html(list);
                }

            },
        });
    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'Create_Survey_Auto_Action'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})