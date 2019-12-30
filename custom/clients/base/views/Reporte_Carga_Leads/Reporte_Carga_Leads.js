({

    events: {

        'change #CargaLeads': '_geLeads',
    },
    carga_list: "",

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

        var opcion = $("#CargaLeads").val();
        alert(opcion);

        var filter_arguments =
            {
                "filter": [
                    {
                        "nombre_de_cargar_c": "CARGA_301219"
                    }
                ],
                "deleted": true
               // "fields": ["id", "nombre_de_cargar_c"]
            };

        console.log(filter_arguments);

        app.api.call("read", app.api.buildURL("Leads", null, null, {}), filter_arguments, {
            success: _.bind(function (data) {

                console.log(data);

            }, this)
        });


    }


})