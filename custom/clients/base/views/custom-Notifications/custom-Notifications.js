/**
 * Created by Jorge on 8/2/2015.
 */

({
    extendsFrom: "CreateActionsView",

    events: {
        'click #enviar': 'enviar',
        'click #cancelarDrawer': 'cancelarDrawer',
    },

    enviar: function () {

        var description = $('#NotificationDescription').val();
        var self = this;
        var Params = {
            'assignedOppId': this.assignedOppId,
            'oppName': this.oppName,
            'description': description,
        };
        var dnbProfileUrl = app.api.buildURL("SalesforceAutomationActions", '', {}, {});
        app.api.call("create", dnbProfileUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                app.drawer.close();
            })
        });

    },

    cancelarDrawer: function () {
        app.drawer.close();
    },

    bindDataChange: function () {
        this._super("bindDataChange");

        this.assignedOppId = this.context.get("assignedOppId");
        this.oppName = this.context.get("oppName");
        this.oppOwner = this.context.get("oppOwner");

        app.api.call("read", app.api.buildURL("Users/" + this.assignedOppId, null, null, {}), null, {
            success: _.bind(function (data) {
                if(data != null){
                    this.ReportTo = data.reports_to_name;

                    if(this.oppOwner == null){
                        this.oppOwner = data.full_name;
                    }

                    this.render();
                }
            }, this)
        });
    },
})