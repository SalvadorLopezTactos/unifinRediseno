({
    /**
 * The file used to manage condition list for Automizer 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
    extendsFrom: 'RecordView',
    events: {
        'click .create_condition': 'create_condtion_clicked',
        'click .editCondition': 'editConditionClicked',
        'click .removeCondition': 'removeConditionClicked',
    },
    delegateButtonEvents: function() {
        this.context.on('button:edit_button:click', this.editClicked, this);
    },
    initialize: function (options) {
         
        this._super('initialize', [options]);
        console.log('Surey Automation Condition....');
        //show or hide as per view action
        if (this.context.get('action') == 'edit')
        {
            this.editview = true;
            this.detailview = false;
        } else {
            this.detailview = true;
            this.editview = false;
        }

        //get Target Module
        var targetModule = $('input[name=target_module]').val();
        this.targetModule = targetModule;


    },
    _render: function () {
         
        this._super('_render');
        var self = this;
        $(".accordion").collapse('show', {toggle: false});

        //show detailview on click of cancel button
        $('[name=cancel_button]').click(function () {
            self.cancelClicked();
        });


        var url = App.api.buildURL("bc_survey_condition", "DisplayConditionList", "", {record: this.model.get('id')});

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

                        list += '     <td >';
                        list += '            <span class="label-field">' + value['value'] + '</span>';
                        list += '     </td>';

                        list += '     <td style="text-align:center;">';
                        list += '           <a class="editCondition"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="removeCondition"><i class="fa fa-times"></i></a>';
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
                    $('.ConditionListBody').html(list);
                }

            },
        });

    },
    cancelClicked: function () {
        this._super('cancelClicked');
        this.detailview = true;
        this.editview = false;
        this._render();
    },
    editClicked: function () {
        this._super('editClicked');
        this.detailview = false;
        this.editview = true;
        this._render();
    },
    editConditionClicked: function (el) {
         
        var record_id = $(el.currentTarget).parents('.condition_row').attr('id');
        this.con_id = record_id;
        this.create_condtion_clicked(el);
    },
    removeConditionClicked: function (el) {
         
        var self = this;
        var record_id = $(el.currentTarget).parents('.condition_row').attr('id');
        app.alert.show('remove_condition', {
            level: 'confirmation',
            messages: "Are you sure want to remove this condition ?",
            onConfirm: function () {
                var url = App.api.buildURL("bc_survey_condition", "removeCondition", "", {record: record_id, parent_id: self.model.get('id')});

                App.api.call('GET', url, {}, {
                    success: function (data) {

                         
                        if (data) {
                            App.alert.show('msg', {
                                level: 'success',
                                messages: 'Survey Automation condition deleted successfully.',
                                autoClose: true
                            });
                            // refresh current condition list
                            self._render();
                        }
                    }
                });
            },
            onCancel: function () {
            },
            autoClose: false
        });

    },
    create_condtion_clicked: function (el) {
        var module = this.module;
        var self = this;
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }
        if (el.currentTarget.className != 'btn btn-primary create_condition')
        {
            var isCreate = false;
        } else {
            var isCreate = true;
        }
        var Create_Survey_Auto_Condition = this.layout.getComponent('Create_Survey_Auto_Condition');
        if (!Create_Survey_Auto_Condition) {
            /** Prepare the context object for the new quick create view*/
            var context = this.context.getChildContext({
                module: module,
                forceNew: true,
                create: true,
            });
            context.prepare();
            /** Create a new view object */
            Create_Survey_Auto_Condition = app.view.createView({
                context: context,
                name: 'Create_Survey_Auto_Condition',
                layout: this.layout,
                module: context.module,
                record_id: self.model.get('id'),
                condition_id: self.con_id,
                isCreate: isCreate,
            });
            /** add the new view to the components list of the record layout*/
            this.layout._components.push(Create_Survey_Auto_Condition);
            this.layout.$el.append(Create_Survey_Auto_Condition.$el);
        }
        // if popup is already created earlier then pass condition id when popup request come for update
        else if (self.con_id) {
            Create_Survey_Auto_Condition.condition_id = self.con_id;
            delete self.con_id;
        } else{
            Create_Survey_Auto_Condition.isCreate = isCreate;
        }
        /**triggers an event to show the pop up quick create view*/
        this.layout.trigger("app:view:Create_Survey_Auto_Condition");
    },
})
