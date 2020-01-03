({

    events: {

        'change #CargaLeads': '_geLeads',
        'click #btn_Duplicados': '_exportReport',
    },
    carga_list: "",
    leads: null,
    listaID: null,
    csv:null,


    initialize: function (options) {
        this._super("initialize", [options]);

        this.loadView = false;

        app.api.call("read", app.api.buildURL("GetNameLoad", null, null, {}), null, {
            success: _.bind(function (data) {

                console.log(data);

                var list_html = '';
                _.each(data, function (value, key) {

                    // console.log(data[value] + "  " + data[key]);
                    list_html += '<option value="' + data[key] + '">' + data[key] + '</option>';
                });

                this.carga_list = list_html;
                this.loadView = true;
                this.render();
            }, this)
        });

    },

    _render: function () {
        this._super("_render");
    },

    _geLeads: function () {

        self = this;
        var opcion = $("#CargaLeads").val();
        alert(opcion);
        var filter_arguments =
            {
                "filter": [
                    {
                        "nombre_de_cargar_c": opcion
                    }
                ],
                "deleted": true
                // "fields": ["id", "nombre_de_cargar_c"]
            };
        //console.log(filter_arguments);
        app.api.call("read", app.api.buildURL("Leads", null, null, filter_arguments), null, {
            success: _.bind(function (data) {
                //console.log(data);
                var listId = [];
                _.each(data.records, function (key, value) {
                    listId.push(key.id);
                });

                this.listaID = listId;

                console.log(listId)
                self.leads = data.records;
                self.render();
            }, this)
        });
    },

    _exportReport: function () {

        self=this;
        datosList = {
            "records": this.listaID,
            "module":"Leads"
        };

        app.api.call("create", app.api.buildURL("exportLeadsCSV", null, null, {}), datosList, {
            success: _.bind(function (list_data) {

                console.log("id de recordList " +list_data);
                window.open("#bwc/index.php?entryPoint=exportarBacklog&backlog_doc=" + list_data);
                window.close();


            }, this),
            failure: _.bind(function(list_data) {
                console.log("4" + list_data);
            }, this),
            error: _.bind(function(list_data) {
                console.log("5" + list_data);
            }, this)
        });



     /*   app.api.call("create", app.api.buildURL("Leads/record_list", null, null, datosList), null, {
            success: _.bind(function (list_data) {

                console.log("id de recordList " +list_data.id);

              //self._doExport(list_data.id);

              console.log("Response"+this.csv);

            }, this),
            failure: _.bind(function(list_data) {
                console.log("4" + list_data);
            }, this),
            error: _.bind(function(list_data) {
                console.log("5" + list_data);
            }, this)
        });*/


    },

    _doExport: function (record_List)
    {
self=this;
        app.api.call("read", app.api.buildURL("Leads/export/"+record_List, null, null, {}), null, {
            success: _.bind(function (data) {
                console.log("exportacion");
                console.log(data);

            }, this),
            failure: _.bind(function(data) {
                console.log("1" + data);
            }, this),
            error: _.bind(function(data) {
                console.log("2" + data);
                self.csv=data;

                console.log (data.response);
            }, this)

        });

    }


})