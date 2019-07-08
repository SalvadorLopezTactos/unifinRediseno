({
    /**
 * The file used to manage survey automizer action list for Automizer 
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
        'click .create_action': 'create_action_clicked',
        'click .editAction': 'editActionClicked',
        'click .removeAction': 'removeActionClicked',
    },
    delegateButtonEvents: function () {
        this.context.on('button:edit_button:click', this.editClicked, this);
    },
    initialize: function (options) {
        this._super('initialize', [options]);
        console.log('Surey Automation Action....');
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


        var url = App.api.buildURL("bc_survey_actions", "DisplayActionList", "", {record: this.model.get('id')});

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
                        list += '            <span class="label-field"><input type="checkbox" disabled ';
                        if(value['emailtemplate'] == '1')
                        {
                           list += 'checked';
                        }
                        list += ' />';
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
    create_action_clicked: function (el) {
        var module = this.module;
        var self = this;
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }
        if (el.currentTarget.className != 'btn btn-primary create_action')
        {
            var isCreate = false;
        } else {
            var isCreate = true;
        }
        var Create_Survey_Auto_Action = this.layout.getComponent('Create_Survey_Auto_Action');
        if (!Create_Survey_Auto_Action) {
            /** Prepare the context object for the new quick create view*/
            var context = this.context.getChildContext({
                module: module,
                forceNew: true,
                create: true,
            });
            context.prepare();
            /** Create a new view object */
            Create_Survey_Auto_Action = app.view.createView({
                context: context,
                name: 'Create_Survey_Auto_Action',
                layout: this.layout,
                module: context.module,
                record_id: self.model.get('id'),
                target_module:self.model.get('target_module'),
                action_id: self.act_id,
                isCreate: isCreate
            });
            /** add the new view to the components list of the record layout*/
            this.layout._components.push(Create_Survey_Auto_Action);
            this.layout.$el.append(Create_Survey_Auto_Action.$el);
        }
        // if popup is already created earlier then pass action id when popup request come for update
        else if (self.act_id) {
            Create_Survey_Auto_Action.action_id = self.act_id;
            delete self.act_id;
        } else {
            Create_Survey_Auto_Action.isCreate = isCreate;
        }
        /**triggers an event to show the pop up quick create view*/
        this.layout.trigger("app:view:Create_Survey_Auto_Action");
    },
    editActionClicked: function (el) {
         
        var record_id = $(el.currentTarget).parents('.action_row').attr('id');
        this.act_id = record_id;
        this.create_action_clicked(el);
    },
    removeActionClicked: function (el) {
         
        var self = this;
        var record_id = $(el.currentTarget).parents('.action_row').attr('id');
        app.alert.show('remove_action', {
            level: 'confirmation',
            messages: "Are you sure want to remove this action ?",
            onConfirm: function () {
                var url = App.api.buildURL("bc_survey_actions", "removeAction", "", {record: record_id, parent_id: self.model.get('id')});

                App.api.call('GET', url, {}, {
                    success: function (data) {

                         
                        if (data) {
                            App.alert.show('msg', {
                                level: 'success',
                                messages: 'Survey Automation action deleted successfully.',
                                autoClose: true
                            });
                            // refresh current action list
                            self._render();
                        }
                    }
                });
            },
            onCancel: function () {
            },
            autoClose: false
        });
    }
})
