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
        'change .module_selection': 'Field_selection_for_condition',
        'change .field_selection': 'Operator_selection_for_condition',
        'change .operator_selection': 'Type_selection_for_condition',
        'change .type_selection': 'Value_selection_for_condition',
        'click .cancel_condition': '_disposeView',
        'click .save_condition': 'saveCondition',
        'click .update_condition': 'saveCondition',
        'focus .date_picker': 'show_datepicker',
        'focus .time_picker': 'show_timepicker',
    },
    initialize: function (options) {
        this.record_id = options.record_id;
        this.module = options.context.attributes.module;
        if (options.isCreate == false)
        {
            this.condition_id = options.condition_id;
        }


        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:Create_Survey_Auto_Condition', function () {
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

    },
    _render: function () {
        this._super('_render');
        var self = this;
        if (self.options.isCreate == false)
        {
            $('.modal-header').find('h4').html("Update Survey Automation Condition");
            $('.modal-body').append('<input type="hidden" value="' + this.condition_id + '" id="condition_id"/>')
            $('.modal-footer').find('.save_condition').replaceWith("<div class='btn btn-primary update_condition' style='float:left; margin-top:-9px; margin-left:-10px;' >Update Condition</div>");
        }
         
        //Get Condition modules list
        var url = App.api.buildURL("bc_survey_condition", "getConditionModules", "", {record: this.record_id});

        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data) {
                    var options = '';
                    $.each(data, function (key, module) {
                        options += '<option value="' + key + '" data-module="' + module + '">' + module + '</option>';
                    });
                    $('.module_selection').html(options);


                    if (self.options.isCreate == false)
                    {
                        var url = App.api.buildURL("bc_survey_condition", "getConditionRecord", "", {condition_id: self.condition_id});

                        App.api.call('GET', url, {}, {
                            success: function (data) {
                                if (data) {
                                    self.selected_field = data['field'];
                                    self.selected_operator = data['operator'];
                                    self.selected_value_type = data['value_type'];
                                    self.selected_value = data['value'];
                                    self.filter_by = data['filter_by'];

                                    // for date & time
                                    self.selected_value1 = data['date'];
                                    self.selected_value2 = data['time'];

                                    $('.module_selection').val(data['module']);
                                    $('.module_selection').trigger('change');

                                    $('.field_selection').trigger('change');

//                                    $('.type_selection').val(data['value_type']);
//                                    $('.type_selection').trigger('change');
//
//                                    $('.value_selection').val(data['value']);
//                                    $('.value_selection').trigger('change');
                                }
                            },
                        });
                    } else {
                        $('.module_selection').trigger('change');
                    }
                }
            },
        });

    },
    /**
     * Return user date format.
     *
     * @return {String} User date format.
     */
    getUserDateFormat: function() {
        return app.user.getPreference('datepref');
    },
    /**
     * Patches our `dom_cal_*` metadata for use with date picker plugin since
     * they're very similar.
     *
     * @private
     */
    _patchPickerMeta: function() {
        var pickerMap = [], pickerMapKey, calMapIndex, mapLen, domCalKey,
                calProp, appListStrings, calendarPropsMap, i, filterIterator;

        appListStrings = app.metadata.getStrings('app_list_strings');

        filterIterator = function(v, k, l) {
            return v[1] !== "";
        };

        // Note that ordering here is used in following for loop
        calendarPropsMap = ['dom_cal_day_long', 'dom_cal_day_short', 'dom_cal_month_long', 'dom_cal_month_short'];

        for (calMapIndex = 0, mapLen = calendarPropsMap.length; calMapIndex < mapLen; calMapIndex++) {

            domCalKey = calendarPropsMap[calMapIndex];
            calProp  = appListStrings[domCalKey];

            // Patches the metadata to work w/datepicker; initially, "calProp" will look like:
            // {0: "", 1: "Sunday", 2: "Monday", 3: "Tuesday", 4: "Wednesday", 5: "Thursday", 6: "Friday", 7: "Saturday"}
            // But we need:
            // ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]
            if (!_.isUndefined(calProp) && !_.isNull(calProp)) {
                // Reject the first 0: "" element and then map out the new language tuple
                // so it's back to an array of strings
                calProp = _.filter(calProp, filterIterator).map(function(prop) {
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

        $('.date_picker').datepicker(options);
    },
    /**
     * Return user time format.
     *
     * @return {String} User time format.
     */
    getUserTimeFormat: function() {
        return app.user.getPreference('timepref');
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
            timeFormat: this.getUserTimeFormat(),
        };

        $('.time_picker').timepicker(options);
    },
    /*
     * change field list as per  module selected
     * @returns {undefined}
     */
    Field_selection_for_condition: function () {
        var self = this;
        var rel_mod_name = $('.module_selection').val();
        var target_module = $('[data-fieldname=target_module]').find('div').html().trim();
        if (target_module == 'Targets')
        {
            target_module = 'Prospects';
        }
        if (target_module == 'Target Lists')
        {
            target_module = 'ProspectLists';
        }
        if (rel_mod_name != target_module)
        {
            $('.filter_by_row').show();
            if (self.filter_by)
            {
                $('.filter_by_selection').val(self.filter_by);
            }
        } else {
            $('.filter_by_row').hide();
        }
        var url = App.api.buildURL("bc_survey_condition", "getConditionFields", "", {rel_mod_name: rel_mod_name, record_id: self.record_id});

        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data) {
                    var options = '<option value="none">None</option>';
                    $.each(data, function (key, module) {
                        options += '<option value="' + key + '">' + module + '</option>';
                    });
                    $('.condition_field_row').show();
                    $('.field_selection').html(options).show();
                    if (self.selected_field)
                    {
                        $('.field_selection').val(self.selected_field);
                        $('.field_selection').trigger('change');
                        $('.condition_operator_row').show();
                        delete self.selected_field;
                    } else {
                        //hide other already selected options
                        $('.condition_operator_row').hide();
                        $('.condition_type_row').hide();
                        $('.condition_value_row').hide();
                    }
                }
            },
        });
    },
    /*
     * change operator selection list as per field selection
     * @returns {undefined}
     */
    Operator_selection_for_condition: function () {
         
        var self = this;
        var field_selected = $('.field_selection').val();
        var rel_field = $('.module_selection').val();
        var type_selcted = self.selected_value_type;
        var value_selected = self.selected_value;

        if (field_selected != 'none')
        {
            var url = App.api.buildURL("bc_survey_condition", "getOperator", "", {record_id: this.record_id, rel_field: rel_field, selected_field: field_selected, type_selcted: type_selcted, value_selected: value_selected});

            App.api.call('GET', url, {}, {
                success: function (data) {
                    if (data) {
                        var options = '';
                        $.each(data['operator'], function (key, module) {
                            options += '<option value="' + key + '">' + module + '</option>';
                        });
                        $('.condition_operator_row').show();
                        $('.operator_selection').html(options).show();

                        if (self.selected_operator)
                        {
                            $('.operator_selection').val(self.selected_operator);
                            delete self.selected_operator;
                        }
                        var operator = $('.operator_selection').val();
                        if (operator != 'is_null' && operator != 'Any_Change')
                        {
                            // get related field type
                            if (data['type'])
                            {
                                options = '';
                                $.each(data['type'], function (key, module) {
                                    options += '<option value="' + key + '">' + module + '</option>';
                                });
                                $('.condition_type_row').show();
                                $('.type_selection').html(options).show();
                                if (self.selected_value_type)
                                {
                                    $('.type_selection').val(self.selected_value_type);
                                    delete self.selected_value_type;
                                }
                            } else {
                                $('.operator_selection').trigger('change');
                            }

                            //get related value
                            if (data['value'])
                            {
                                $('.condition_value_row').show();

                                $('.conditional_value').html(data['value']).show();
                                if (self.selected_value && type_selcted == 'Multi')
                                {
                                    var value_selected = self.selected_value.split(',');

                                    $('#filter__field_value').val(value_selected);
                                    delete self.selected_value;

                                } else if (self.selected_value1 && self.selected_value2) {
                                    $('.date_picker').val(self.selected_value1);
                                    $('.time_picker').val(self.selected_value2);
                                    delete self.selected_value1;
                                    delete self.selected_value2;
                                } else if (self.selected_value) {
                                    $('#filter__field_value').val(self.selected_value);
                                    delete self.selected_value;
                                }
                            }
                        }

                        //hide other already selected options
                        // $('.condition_type_row').hide();
                        // $('.condition_value_row').hide();
                    }
                }
            });
        }
    },
    /*
     * change type selection row as per operator selection
     * @returns {undefined}
     */
    Type_selection_for_condition: function () {
        var self = this;
        var sel_fieldname = $('.field_selection').val();
        var rel_module = $('.module_selection').val();
        var operator = $('.operator_selection').val();
        var type_selcted = self.selected_value_type;
        var value_selected = self.selected_value;

        var url = App.api.buildURL("bc_survey_condition", "getFieldTypeOptions", "", {sel_fieldname: sel_fieldname, rel_module: rel_module, record_id: self.record_id, type_selcted: type_selcted});

        App.api.call('GET', url, {}, {
            success: function (data) {
                if (operator == 'Any_Change' || operator == 'is_null')
                {
                    //hide other already selected options
                    $('.condition_type_row').hide();
                    $('.condition_value_row').hide();
                }
                
                // for date field
                if(operator != 'Equal_To'){
                    // check if Date Option exists or not
                    var date_exists = $('.type_selection').find('[value=Date]').length;
                    if(date_exists == 1){
                        $('.type_selection').find('[value=Date]').css('display','none');
                        $('.type_selection').val('Value');
                        $('.type_selection').trigger('change');
                    }
                }
                else if (data) {
                    var options = '';
                    $.each(data['type'], function (key, module) {
                        options += '<option value="' + key + '">' + module + '</option>';
                    });
                    $('.condition_type_row').show();
                    $('.type_selection').html(options).show();

                    if (self.selected_value_type)
                    {
                        $('.type_selection').val(self.selected_value_type);
                        delete self.selected_value_type;
                    }
                    //get related value
                    if (data['value'])
                    {
                        $('.condition_value_row').show();

                        $('.conditional_value').html(data['value']).show();
                        if (self.selected_value && type_selcted == 'Multi')
                        {
                            var value_selected = self.selected_value.split(',');

                            $('#filter__field_value').val(value_selected);
                            delete self.selected_value;

                        } else if (self.selected_value1 && self.selected_value2) {
                            $('.date_picker').val(self.selected_value1);
                            $('.time_picker').val(self.selected_value2);
                            delete self.selected_value1;
                            delete self.selected_value2;
                        } else if (self.selected_value) {
                            $('#filter__field_value').val(self.selected_value);
                            delete self.selected_value;
                        }
                    } else {
                        $('.type_selection').trigger('change');
                    }

                    //hide other already selected options
                    //$('.condition_value_row').hide();
                }
            }
        });
    },
    /*
     * change value row as per selection of value type
     * @returns {undefined}
     */
    Value_selection_for_condition: function () {
         
        var self = this;
        var sel_type = $('.type_selection').val();
        var current_sel_field = $('.field_selection').val();
        var sel_fieldname = $('.module_selection').val();
        var data = '';

        var url = App.api.buildURL("bc_survey_condition", "getConditionValue", "",
                {
                    rel_field: current_sel_field,
                    sel_fieldname: sel_fieldname,
                    sel_type: sel_type,
                    record_id: self.record_id
                });

        App.api.call('GET', url, {}, {
            success: function (result) {
                if (result) {
                    $('.condition_value_row').show();

                    $('.conditional_value').html(result).show();


                    if (self.selected_value && sel_type == 'Multi')
                    {
                        var value_selected = self.selected_value.split(',');

                        $('#filter__field_value').val(value_selected);
                        delete self.selected_value;

                    }
                    else if (self.selected_value1 && self.selected_value2) {
                        $('.date_picker').val(self.selected_value1);
                        $('.time_picker').val(self.selected_value2);
                        delete self.selected_value1;
                        delete self.selected_value2;
                    }
                    else if (self.selected_value) {
                        $('#filter__field_value').val(self.selected_value);
                        delete self.selected_value;
                    }
                } else {
                    $('.condition_value_row').hide();
                }
            },
        });

    },
    saveCondition: function () {
        var self = this;
         
        //   var sel_module = $('.module_selection').val();
        //   var module = '{' + $('.module_selection').find($('[value=' + sel_module + ']')).attr('data-module') + '}';
        var id = $('#condition_id').val();
        var module = $('.module_selection').val();
        var filter_by = $('.filter_by_selection').val();
        var field = $('.field_selection').val();
        var operator = $('.operator_selection').val();
        if (operator == 'Any_Change' || operator == 'is_null')
        {
            var type = '';
            var value = '';
        } else {
            var type = $('.type_selection').val();
            var value = $('#filter__field_value').val();
        }
        if (!module)
        {
            $('.module_selection').addClass('error-custom');
            var parent = $('.module_selection').addClass('error-custom').parent();
            if (parent.find('.err-msg').length == 0)
            {
                parent.append('<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
            } else {
                parent.find('.err-msg').show();
            }
        } else {
            $('.module_selection').removeClass('error-custom');
            $('.module_selection').parent().find('.err-msg').hide();
        }
        if (!field || field == 'none')
        {
            $('.field_selection').addClass('error-custom');
            var parent = $('.field_selection').addClass('error-custom').parent();
            if (parent.find('.err-msg').length == 0)
            {
                parent.append('<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
            } else {
                parent.find('.err-msg').show();
            }
        } else {
            $('.field_selection').removeClass('error-custom');
            $('.field_selection').parent().find('.err-msg').hide();
        }

        //validate value 
        if (type == 'Value' && !value)
        {
            $('#filter__field_value').addClass('error-custom');
            var parent = $('#filter__field_value').addClass('error-custom').parent();
            if (parent.find('.err-msg').length == 0)
            {
                parent.append('&nbsp;<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
            } else {
                parent.find('.err-msg').show();
            }

        } else if ($('.time_picker').length != 0 && !$('.time_picker').val() && operator != 'Any_Change') {
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
        if ($('.time_picker').length != 0 && $('.time_picker').val()) {
            value = value + " " + $('.time_picker').val();
        }
        var errors = $('.error-custom').length;
        if (errors == 0)
        {
            var url = App.api.buildURL("bc_survey_condition", "saveConditions", "",
                    {
                        record_id: this.record_id,
                        module: module,
                        filter_by: filter_by,
                        field: field,
                        operator: operator,
                        type: type,
                        value: value,
                        condition_id: id
                    });

            App.api.call('create', url, {}, {
                success: function (result) {
                    if (result) {
                        App.alert.show('msg', {
                            level: 'success',
                            messages: 'Survey Automizer condition saved successfully.',
                            autoClose: true
                        });
                        self._disposeView();
                       // self.refreshConditionList();
                       window.location.reload();
                    }
                },
            });
        }
    },
    refreshConditionList: function () {
        var url = App.api.buildURL("bc_survey_condition", "DisplayConditionList", "", {record: this.record_id});

        App.api.call('GET', url, {}, {
            success: function (data) {

                 
                if (data) {
                    // self.hasList = true;
                    // self.conditionList = data;
                    var list = '';
                    var index = 0;
                    $.each(data, function (k, value) {
                        index = parseInt(index) + 1;
                        list += '<tr class="condition_row" id="' + value['id'] + '">';

                        list += '     <td>';
                        list += '            <span class="label-field">' + index + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['module'] + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['field'] + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['operator'] + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['value_type'] + '</span>';
                        list += '     </td>';

                        list += '     <td>';
                        list += '            <span class="label-field">' + value['value'] + '</span>';
                        list += '     </td>';

                        list += '     <td style="text-align:center;">';
                        list += '           <a class="editCondition"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="removeCondition"><i class="fa fa-times"></i></a>';
                        list += '     </td>';

                        list += '</tr>';
                    });
                    $('.ConditionListBody').html(list);
                }

            },
        });
    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'Create_Survey_Auto_Condition'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})