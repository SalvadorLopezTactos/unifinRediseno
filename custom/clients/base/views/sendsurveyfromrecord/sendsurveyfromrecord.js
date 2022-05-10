({
    className: "hidden",
    _render: function () {
        //No-op, Do nothing here
    },
    initialize: function (options) {

        this._super('initialize', [options]);
        
        this.context.on('button:send_survey:click', this.getListRecordsSurvey, this);
        this.context.on('button:send_poll:click', this.getListRecordsPoll, this);
    },
    // get list of selected records for survey
    getListRecordsSurvey: function () {
        var self = this;
        var type = 'survey';
        var module_name = this.module;
        if (this.model.get('name') != null) {
            var record_name = this.model.get('name');
        }
        if (this.model.get('last_name') != null) {
            var record_name = this.model.get('last_name');
        }

        var msg = 'You are going to send ' + type + ' to ' + record_name + '. Are you sure that you want to proceed ?';
        app.alert.show('stop_confirmation', {
            level: 'confirmation',
            messages: msg,
            onConfirm: function () {
                var module_name = self.module;
                self.create_SendSurveydiv(self.model.get('id'), module_name,1, type);
            },
            onCancel: function () {
                app.alert.dismiss('stop_confirmation');
            },
            autoClose: false
        });
    },
    // get list of selected records for poll
    getListRecordsPoll: function () {
        var self = this;
        var type = 'poll';
        var module_name = this.module;
        if (this.model.get('name') != null) {
            var record_name = this.model.get('name');
        }
        if (this.model.get('last_name') != null) {
            var record_name = this.model.get('last_name');
        }

        var msg = 'You are going to send ' + type + ' to ' + record_name + '. Are you sure that you want to proceed ?';
        app.alert.show('stop_confirmation', {
            level: 'confirmation',
            messages: msg,
            onConfirm: function () {
                var module_name = self.module;
                self.create_SendSurveydiv(self.model.get('id'), module_name,1, type);
            },
            onCancel: function () {
                app.alert.dismiss('stop_confirmation');
            },
            autoClose: false
        });
    },
    // create send survey popup
    create_SendSurveydiv: function (record, module, sendPeopleCount, type) {

        var self = this;
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
                isSendNow: true,
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