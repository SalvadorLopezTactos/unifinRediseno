({
    /**
     * Send survey from list view
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */

    className: "hidden",
    _render: function () {
        //No-op, Do nothing here
    },
    initialize: function (options) {
        this._super('initialize', [options]);
        //add listener for custom button
        this.context.on('list:sendsurvey:fire', this.getListRecordsSurvey, this);
        this.context.on('list:sendpoll:fire', this.getListRecordsPoll, this);
    },
    //get list of selected record
    getListRecordsSurvey: function () {
        
        var type = 'survey';
        var record_ids = '';
        var self = this;
        var sendPeopleCount = this.context.get('mass_collection').length;
        var module_name = this.module;
        var surveySingularModule = App.lang.getAppListStrings("moduleListSingular")[module_name] ;
        var msg = 'You are going to send ' + type + ' to ' + sendPeopleCount + ' ' + surveySingularModule + '(s). Are you sure that you want to proceed ?';
        app.alert.show('stop_confirmation', {
            level: 'confirmation',
            messages: msg,
            onConfirm: function () {
                var sendPeopleCount = self.context.get('mass_collection').length;
                var module_name = self.module;
                var selected_record_idsArr = new Array();
                _.each(self.context.get('mass_collection').models, function (arra_val) {
                    selected_record_idsArr.push(arra_val.id);
                }, self);
                var selected_record_idsStr = selected_record_idsArr.toString();
                self.create_SendSurveydiv(selected_record_idsStr, module_name, sendPeopleCount, type);
            },
            onCancel: _.bind(self.cancelSend, self),
            autoClose: false
        });

    },
    //get list of selected record
    getListRecordsPoll: function () {
        
        var type = 'poll';
        var record_ids = '';
        var self = this;
        var sendPeopleCount = this.context.get('mass_collection').length;
        var module_name = this.module;
        var surveySingularModule = App.lang.getAppListStrings("moduleListSingular")[module_name] ;
        var msg = 'You are going to send ' + type + ' to ' + sendPeopleCount + ' ' + surveySingularModule + '(s). Are you sure that you want to proceed ?';
        app.alert.show('stop_confirmation', {
            level: 'confirmation',
            messages: msg,
            onConfirm: function () {
                var sendPeopleCount = self.context.get('mass_collection').length;
                var module_name = self.module;
                var selected_record_idsArr = new Array();
                _.each(self.context.get('mass_collection').models, function (arra_val) {
                    selected_record_idsArr.push(arra_val.id);
                }, self);
                var selected_record_idsStr = selected_record_idsArr.toString();
                self.create_SendSurveydiv(selected_record_idsStr, module_name, sendPeopleCount, type);
            },
            onCancel: _.bind(self.cancelSend, self),
            autoClose: false
        });

    },
    /**
     * Resume the mass job once user were requested to resume.
     * Update screen in proper way.
     */
    cancelSend: function () {
        app.alert.dismiss('stop_confirmation');
    },
    // create send survey popup
    create_SendSurveydiv: function (record, module, sendPeopleCount, type) {
        

        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }
        var Initial_Popup_Survey_List = this.layout.getComponent('Initial_Popup_Survey_List');
        if (!Initial_Popup_Survey_List) {
            /** Prepare the context object for the new quick create view*/
            var context = this.context.getChildContext({
                module: module,
                forceNew: true,
                create: true,
            });
            context.prepare();
            /** Create a new view object */
            Initial_Popup_Survey_List = app.view.createView({
                context: context,
                name: 'Initial_Popup_Survey_List',
                layout: this.layout,
                module: context.module,
                selected_record_ids: record,
                totalSelectedRecord: sendPeopleCount,
                send_type: type
            });
            /** add the new view to the components list of the record layout*/
            this.layout._components.push(Initial_Popup_Survey_List);
            this.layout.$el.append(Initial_Popup_Survey_List.$el);
        } else {
            // if popup already exists then pass current selected records ids and count to popup
            Initial_Popup_Survey_List.selected_record_ids = record;
            Initial_Popup_Survey_List.totalSelectedRecord = sendPeopleCount;
            Initial_Popup_Survey_List.send_type = type;
        }
        /**triggers an event to show the pop up quick create view*/
        this.layout.trigger("app:view:Initial_Popup_Survey_List");
    },
})