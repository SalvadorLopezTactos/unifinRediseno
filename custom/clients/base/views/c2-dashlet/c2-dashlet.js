({
    plugins: ['Dashlet'],

    events: {
        'click .Promotor': 'mostrarCuentas',
        'click .mostrarOpps': 'mostrarOperaciones', //DEPRECATED
        'click .mostrarCli': 'mostrarClientes', //DEPRECATED
        'click .Director': 'mostrarPromotores',
        'click #ClienteSort': 'ordenarPorCliente',
        'click #BacklogSort': 'ordenarPorBacklog',
        'click #PipelineSort': 'ordenarPorPipeline',
        'click #30Sort': 'ordenarPor30Sort',
        'click #60Sort': 'ordenarPor60Sort',
        'click #90Sort': 'ordenarPor90Sort',
        'click #90MasSort': 'ordenarPor90MasSort',
        'change #Colfiltro': 'ocultarColumna',
        'click .forecastTime': 'moverForecast',
        'click .Notification': 'crearNotification',
        'click .Cita': 'crearCita',
        'click .Llamada': 'crearLlamada',
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        this.clienteOrden = "Off";
        this.BacklogOrden = "Off";
        this.PipelineOrden = "Off";
        this.treintaOrden = "Off";
        this.sesentaOrden = "Off";
        this.noventaOrden = "Off";
        this.noventaOrdenMas = "Off";
        this.reporteesEndpoint = app.api.buildURL('Forecasts', 'orgtree/' + app.user.get('id'), null, {'level': 10});

        self = this;
    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;

        app.api.call("read", this.reporteesEndpoint, {}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                if (!_.isEmpty(data.children)) {
                    _.extend(self, {Subordinados: data.children});
                    //_.each(data.children, self.getSubordinadoOperaciones);
                }
                var sfa_options = {
                    user_id: app.user.get('id'),
                    data_source: 'operaciones',
                    subordinados: self.Subordinados
                }
                app.api.call("create", app.api.buildURL("C2Dashlet", '', {}, {}), {data: sfa_options}, {
                    success: _.bind(function (data) {
                        if (self.disposed) {
                            return;
                        }
                        _.extend(self, {c2_rows: data});
                        $.when(self.render()).done(function(){

                            var C2ClonedHeaderRow;
                            $(".c2_box").each(function () {

                                var columnSizes = {}
                                $(".c2_box").find('th').each(function (i, el) {
                                    columnSizes[i] = $(el).width();
                                });

                                C2ClonedHeaderRow = $(".c2_header", this);

                                C2ClonedHeaderRow
                                    .before(C2ClonedHeaderRow.clone())
                                    .css("width", C2ClonedHeaderRow.width())
                                    .addClass("c2HeaderFloat")
                                    .css('top', C2ClonedHeaderRow.position().top - 90 + "px");

                                C2ClonedHeaderRow.find('th').each(function (i, el) {
                                    $(el).css('width', columnSizes[i] + "px");
                                });

                            });
                            $('.dashlet-content > div').each(function(){
                                if($(this).children('div').attr('class') == 'c2-dashlet-wrapper'){
                                    $(this).scroll(C2toggleHeader)
                                    $(this).trigger("scroll");
                                }
                            });
                            function C2toggleHeader() {
                                console.log('C2toggleHeader');
                                var scrollTop = $('.c2-dashlet-wrapper').parent().offset().top;
                                $(".c2_box").each(function () {
                                    var el = $(this),
                                        offset = el.offset(),
                                        c2HeaderFloat = $(".c2HeaderFloat", this)

                                    console.log ('(C2) scrollTop: ' + scrollTop + ' - offset.top: ' + offset.top + ' -  el.height(): ' +  el.height());
                                    var trackingOffset = offset.top + 42;
                                    if ((scrollTop > trackingOffset) && (scrollTop < trackingOffset + el.height())) {
                                        $('.c2HeaderFloat').css('top', scrollTop + 'px');
                                        c2HeaderFloat.css({
                                            "visibility": "visible"
                                        });
                                    } else {
                                        c2HeaderFloat.css({
                                            "visibility": "hidden"
                                        });
                                    }
                                    ;
                                });
                            }
                        });


                    })
                });


            })
        });

    },

    getSubordinadoOperaciones: function (e) {
        var sfa_options = {user_id: e.metadata.id, data_source: 'subordinado_operaciones'};
        app.api.call("create", app.api.buildURL("C2Dashlet", '', {}, {}), {data: sfa_options}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                _.extend(e, {myAccounts: data});
                self.render();
            })
        });
        _.each(e.children, self.getSubordinadoOperaciones); //recursion
    },

    obtenOperaciones: function (sfa_options) {
        var obtenOperacionesUrl = app.api.buildURL("C2Dashlet", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: sfa_options}, {
            success: _.bind(function (data) {
                return data;
            })
        });
    },

    mostrarCuentas: function (e) {
        var uId = $(e.target).children("#PromotorId").val();
        $('.PromotoresActt' + uId).toggle();
    },

    mostrarPromotores: function (e) {
        var uId = $(e.target).children("#DirectorId").val();
        $('.DirectoresEmployees' + uId).toggle();
    },

    mostrarOperaciones: function (e) {
        var uId = $(e.target).parent().next().next().val()
        $('.PromotorgroupedId' + uId).toggle();
    },

    mostrarClientes: function (e) {
        var uId = $(e.target).parent().parent().parent().next(".ClientesTotales");
        $(uId).toggle();
    },

    ocultarColumna: function (e) {
        var selectionVal = $(e.target).val();
        $('.BacklogCol').hide();
        $('.PipelineCol').hide();
        $('.Col30').hide();
        $('.Col60').hide();
        $('.Col90').hide();
        $('.Col90Plus').hide();
        $("." + selectionVal).show();

        if (selectionVal == "sinFiltro") {
            $('.BacklogCol').show();
            $('.PipelineCol').show();
            $('.Col30').show();
            $('.Col60').show();
            $('.Col90').show();
            $('.Col90Plus').show();
        }
    },

    ordenarPorCliente: function (e) {
        $('#ClienteSort').hide();
        var order = '';
        if (this.clienteOrden == "Off") {
            this.clienteOrden = "On";
            order = "DESC";
        } else {
            this.clienteOrden = "Off";
            order = "ASC";
        }
        var self = this;
        var Params = {
            'clienteOrden': order,
        };
        var obtenOperacionesUrl = app.api.buildURL("C2Dashlet", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                _.extend(self, {totalAccounts: data});
                self.evaluateResult(data);
                self.render();
            })
        });
    },

    ordenarPorBacklog: function () {
        $('#BacklogSort').hide();
        var order = '';
        if (this.BacklogOrden == "Off") {
            this.BacklogOrden = "On";
            order = "DESC";
        } else {
            this.BacklogOrden = "Off";
            order = "ASC";
        }
        var self = this;
        var Params = {
            'BacklogOrden': order,
        };
        var obtenOperacionesUrl = app.api.buildURL("C2Dashlet", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                _.extend(self, {totalAccounts: data});
                self.evaluateResult(data);
                self.render();
            })
        });
    },

    ordenarPorPipeline: function () {
        $('#PipelineSort').hide();
        var order = '';
        if (this.PipelineOrden == "Off") {
            this.PipelineOrden = "On";
            order = "DESC";
        } else {
            this.PipelineOrden = "Off";
            order = "ASC";
        }
        var self = this;
        var Params = {
            'PipelineOrden': order,
        };
        var obtenOperacionesUrl = app.api.buildURL("C2Dashlet", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                _.extend(self, {totalAccounts: data});
                self.evaluateResult(data);
                self.render();
            })
        });
    },

    ordenarPor30Sort: function () {
        $('#30Sort').hide();
        var order = '';
        if (this.treintaOrden == "Off") {
            this.treintaOrden = "On";
            order = "DESC";
        } else {
            this.treintaOrden = "Off";
            order = "ASC";
        }
        var self = this;
        var Params = {
            'treintaOrden': order,
        };
        var obtenOperacionesUrl = app.api.buildURL("C2Dashlet", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                _.extend(self, {totalAccounts: data});
                self.evaluateResult(data);
                self.render();

                //$(".col30").hide();

            })
        });
    },

    ordenarPor60Sort: function () {
        $('#60Sort').hide();
        var order = '';
        if (this.sesentaOrden == "Off") {
            this.sesentaOrden = "On";
            order = "DESC";
        } else {
            this.sesentaOrden = "Off";
            order = "ASC";
        }
        var self = this;
        var Params = {
            'sesentaOrden': order,
        };
        var obtenOperacionesUrl = app.api.buildURL("C2Dashlet", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                _.extend(self, {totalAccounts: data});
                self.evaluateResult(data);
                self.render();
            })
        });
    },

    ordenarPor90Sort: function () {
        $('#90Sort').hide();
        var order = '';
        if (this.noventaOrden == "Off") {
            this.noventaOrden = "On";
            order = "DESC";
        } else {
            this.noventaOrden = "Off";
            order = "ASC";
        }
        var self = this;
        var Params = {
            'noventaOrden': order,
        };
        var obtenOperacionesUrl = app.api.buildURL("C2Dashlet", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                _.extend(self, {totalAccounts: data});
                self.evaluateResult(data);
                self.render();
                //this.ocultarColumna('90Col');
            })
        });
    },

    ordenarPor90MasSort: function () {
        $('#90MasSort').hide();
        var order = '';
        if (this.noventaOrdenMas == "Off") {
            this.noventaOrdenMas = "On";
            order = "DESC";
        } else {
            this.noventaOrdenMas = "Off";
            order = "ASC";
        }
        var self = this;
        var Params = {
            'noventaOrdenMas': order,
        };
        var obtenOperacionesUrl = app.api.buildURL("C2Dashlet", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                _.extend(self, {totalAccounts: data});
                self.evaluateResult(data);
                self.render();
            })
        });
    },


    moverForecast: function (e) {
        var forecastVal = $(e.target).attr("value");
        var forecastClick = "";

        var oppId = e.currentTarget.getAttribute('data-id');

        if (forecastVal == "P") {
            forecastClick = "Pipeline";
        }
        if (forecastVal == "B") {
            forecastClick = "Backlog";
        }
        if (forecastVal == "30") {
            forecastClick = "30";
        }
        if (forecastVal == "60") {
            forecastClick = "60";
        }
        if (forecastVal == "90") {
            forecastClick = "90";
        }
        if (forecastVal == "90Mas") {
            forecastClick = "90mas";
        }

        var self = this;
        var Params = {
            'forecastSelected': forecastClick,
            'oppId': oppId,
        };
        var obtenOperacionesUrl = app.api.buildURL("C2DashletActions", '', {}, {});
        app.api.call("create", obtenOperacionesUrl, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }

                app.alert.show('modify-operacion', {
                    level: 'info',
                    messages: 'Procesando Operacion...',
                    autoClose: true
                });

                self.loadData();
                self.render();
            })
        });
    },

    crearNotification: function (e) {

        var assignedOppId = e.currentTarget.getAttribute('data-assignedUser');
        var oppName = e.currentTarget.getAttribute('data-name');
        var oppOwner = e.currentTarget.getAttribute('data-owner');

        if ($('.c2HeaderFloat').is(':visible')) {
            $('.c2HeaderFloat').css({
                "visibility": "hidden"
            });
        }

        app.drawer.open({
            layout: 'custom-Notifications',
            context: {
                assignedOppId: assignedOppId,
                oppName: oppName,
                oppOwner: oppOwner
            }
        });

    },

    compareCurrentRole: function (templateRole, options) {
        if (this.currentRole == templateRole) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    },

    crearCita: function (e) {
        var oppId = e.currentTarget.getAttribute('data-id');
        var oppName = e.currentTarget.getAttribute('data-name');
        //var assignedOppId = $(e.target).parent().parent().next().next('.OppAssignedUser').val();

        window.open("#bwc/index.php?module=Meetings&action=EditView&name=" + oppName + "&parent_name=" + oppName + "&parent_id=" + oppId + "&parent_type=Opportunities");

    },

    crearLlamada: function (e) {
        var oppId = e.currentTarget.getAttribute('data-id');
        var oppName = e.currentTarget.getAttribute('data-name');

        window.open("#bwc/index.php?module=Calls&action=EditView&name=" + oppName + "&parent_name=" + oppName + "&parent_id=" + oppId + "&parent_type=Opportunities");
    },

})


