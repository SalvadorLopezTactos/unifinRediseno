({

    events: {

        'change #CargaLeads': '_geLeads',
        'click #btn_Duplicados': '_exportReport',
        'click #previous_offset': '_previousOffset',
        'click #next_offset': '_nextOffset',
    },

    carga_list: "",
    leads: null,
    leads_temp: null,
    back_page: 0,
    next_page: 20,
    total_page_all: null,
    total_page: null,
    listaID: null,
    csv: null,


    initialize: function (options) {
        this._super("initialize", [options]);
        this.loadView = false;

        app.api.call("read", app.api.buildURL("GetNameLoad", null, null, {}), null, {
            success: _.bind(function (data) {

                var list_html = '<option value="" >  </option>';
                _.each(data, function (value, key) {
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

        if (opcion != "") {
            app.alert.show('upload', {level: 'process', title: 'LBL_LOADING', autoclose: false});

            var from_set = $("#offset_value").attr("from_set");
            var to_set = $("#offset_value").attr("to_set");
            var current_set = $("#offset_value").html();
            var from_set_num = parseInt(from_set);

            if (isNaN(from_set_num)) {
                from_set_num = 0;
            }
            var filter_arguments =
                {
                    "offset": from_set_num,
                    "nombre_de_cargar_c": opcion,
                };

            app.api.call("read", app.api.buildURL("GetLeadsAll", null, null, filter_arguments), null, {
                success: _.bind(function (data) {
                    //console.log(data);

                    for (var i = 0; i < data.Leads.length; i++) {
                        if (data.Leads[i].regimen_fiscal_c == 'Persona Fisica') {
                            data.Leads[i].isFisica = true;
                        }
                        else {
                            data.Leads[i].isFisica = false;
                        }

                        data.Leads[i].tipo_registro_c = app.lang.getAppListStrings("tipo_registro_c_list")[data.Leads[i].tipo_registro_c];
                        data.Leads[i].subtipo_registro_c = app.lang.getAppListStrings("subtipo_registro_c_list")[data.Leads[i].subtipo_registro_c]
                        
                    }
                    ;
                    self.leads_temp = data.Leads;


                    self.total_page = data.total_leads;
                    self.total_page_all = data.Leads_all;

                    self.render();
                    app.alert.dismiss('upload');

                    if (to_set > self.total_page_all) {
                        to_set = self.total_page_all;
                    } else {
                        to_set = from_set_num + self.total_page;
                    }

                    current_set = (parseInt(from_set) + 1) + " a " + to_set + " de " + self.total_page_all;
                    if (_.isEmpty(from_set)) {
                        from_set = 0;
                        to_set = 20;

                        if (to_set > self.total_page_all) {
                            to_set = self.total_page_all;
                        }

                        current_set = (parseInt(from_set) + 1) + " a " + to_set + " de " + self.total_page_all;
                    }
                    $("#offset_value").html(current_set);
                    $("#offset_value").attr("from_set", from_set);
                    $("#offset_value").attr("to_set", to_set);
                    $("#CargaLeads").val(opcion);

                    if (to_set == self.total_page_all) {
                        //$("#next_offset").css("pointer-events", "none");
                        $("#next_offset").attr('style', 'pointer-events:none')
                    }

                }, this)
            });
        }
        else {
            self.leads_temp = null;
            self.render();
        }
    },


    _nextOffset: function () {
        var current_set = $("#offset_value").html();
        var from_set = $("#offset_value").attr("from_set");
        var next_from_set = parseInt(from_set) + 20;
        var to_set = $("#offset_value").attr("to_set");
        var next_to_set = parseInt(to_set) + 20;

        if (next_to_set > this.total_page_all) {
            next_to_set = this.total_page_all;

            /* if(from_set > 0){
                 next_from_set = from_set;
             }else{
                 next_from_set = next_from_set;
             }*/
            next_from_set = next_from_set;


        }

        $("#offset_value").html(current_set);
        $("#offset_value").attr("from_set", next_from_set);
        $("#offset_value").attr("to_set", next_to_set);
        this._geLeads();
    },

    _previousOffset: function () {
        var current_set = $("#offset_value").html();
        var from_set = $("#offset_value").attr("from_set");
        var next_from_set = parseInt(from_set) - 20;
        var to_set = $("#offset_value").attr("to_set");
        var next_to_set = parseInt(to_set) - 20;

        if (next_from_set < 0) {
            next_from_set = 0;
            next_to_set = 20;
        }

        $("#offset_value").html(current_set);
        $("#offset_value").attr("from_set", next_from_set);
        $("#offset_value").attr("to_set", next_to_set);
        this._geLeads();
    },

    _exportReport: function () {

        self = this;
        var opcion1 = $("#CargaLeads").val();

        datosList = {
            "records": this.listaID,
            "module": "Leads",
            "name_load": opcion1

        };
        $("#btn_Duplicados").attr('disabled', 'disabled');

        app.alert.show('upload', {level: 'process', title: 'LBL_LOADING', autoclose: false});

        app.api.call("create", app.api.buildURL("exportLeadsCSV", null, null, {}), datosList, {
            success: _.bind(function (list_data) {
                window.open("#bwc/index.php?entryPoint=exportarBacklog&backlog_doc=" + list_data);
                app.alert.dismiss('upload');
                $("#btn_Duplicados").removeAttr('disabled');

            }, this),
            failure: _.bind(function (list_data) {
                console.log("4" + list_data);
            }, this),
            error: _.bind(function (list_data) {
                console.log("5" + list_data);
            }, this)
        });

    },


})