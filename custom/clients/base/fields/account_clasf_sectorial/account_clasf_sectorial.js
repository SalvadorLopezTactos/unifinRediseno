({
    //Carga de Listas de valores
    actividadeconomica_list: null,
    subsectoreconomico_list: null,
    sectoreconomico_list: null,
    tct_macro_sector_ddw_list: null,
    inegi_actividad_c_list: null,
    inegi_subsector_c_list: null,
    inegi_sector_c_list: null,
    inegi_macro_c_list: null,

    initialize: function (options) {
        //Inicializa campo custom
        this._super('initialize', [options]);
        options = options || {};
        options.def = options.def || {};
        clasf_sectorial = this;

        //Guarda valores en los campos de clasificacion sectorial
        this.model.addValidationTask('GuardaClasfSectorial', _.bind(this.SaveClasfSectorial, this));
        this.model.on('sync', this.loadData, this);

        this.ActividadEconomica = {
            'combinaciones': '',
            'ae': {
                'id': '',
            },
            'sse': {
                'id': '',
            },
            'se': {
                'id': '',
            },
            'ms': {
                'id': '',
            },
        };

        this.prevActEconomica = {
            'combinaciones': '',
            'ae': {
                'id': '',
            },
            'sse': {
                'id': '',
            },
            'se': {
                'id': '',
            },
            'ms': {
                'id': '',
            },
        };
    },

    loadData: function () {
        clasf_sectorial = this;

        clasf_sectorial.ActividadEconomica.ae.id = this.model.get("actividadeconomica_c");
        clasf_sectorial.ActividadEconomica.sse.id = this.model.get("subsectoreconomico_c");
        clasf_sectorial.ActividadEconomica.se.id = this.model.get("sectoreconomico_c");
        clasf_sectorial.ActividadEconomica.ms.id = this.model.get("tct_macro_sector_ddw_c");

        clasf_sectorial['prevActEconomica'] = app.utils.deepCopy(clasf_sectorial.ActividadEconomica);
        clasf_sectorial.render();

        //Api ResumenCliente para los campos de INEGI
        var idCuenta = clasf_sectorial.model.id; //Id de la Cuenta
        if (idCuenta != '' && idCuenta != undefined && idCuenta != null) {
            var url = app.api.buildURL('ResumenCliente/' + idCuenta, null, null,);

            app.api.call('GET', url, {}, {
                success: function (data) {
                    clasf_sectorial.ResumenCliente = data;
                    _.extend(this, clasf_sectorial.ResumenCliente);
                    clasf_sectorial.render();
                }
            });
        }
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
            }
        }, this);
    },

    _render: function () {
        this._super("_render");
        //campo custom account_clasf_sectorial ocualta la Etiqueta
        $("div.record-label[data-name='account_clasf_sectorial']").attr('style', 'display:none;');
        //funcion de cargar listas
        this.cargalistas();
        //Funcion para dar estilo select2 a las listas deplegables.
        var $select = $('select.select2');
        $select.select2();
        //Muestra campos dependientes de Actividad Economica
        this.MuestraCamposAE();
        //Campos INEGI de Solo Lectura 
        $(".campoIAE").attr('style', 'pointer-events:none;');
        $(".campoISSE").attr('style', 'pointer-events:none;');
        $(".campoISE").attr('style', 'pointer-events:none;');
        $(".campoIMS").attr('style', 'pointer-events:none;');
        //Carga los valores en los campos dependientes de Actividad Económica al momento de hacer el change
        $('.list_ae').change(function (evt) {
            clasf_sectorial.ClasfSectorialApi();
            clasf_sectorial.MuestraCamposAE();
        });
    },

    MuestraCamposAE: function () {

        if ($('.list_ae').select2('val') == "" || $('.list_ae')[0].innerText.trim() == "") {
            // console.log("Hide");
            $('.campoSSE').hide();
            $('.campoSE').hide();
            $('.campoMS').hide();

        } else {
            // console.log("Show");
            $('.campoSSE').show();
            $('.campoSE').show();
            $('.campoMS').show();
        }
    },

    ClasfSectorialApi: function () {

        clasf_sectorial = this;
        dataCS = [];

        var idActEconomica = $('.list_ae').select2('val');
        console.log("AE " + idActEconomica);
        if (idActEconomica != '' && idActEconomica != null && idActEconomica != undefined) {

            app.api.call('GET', app.api.buildURL('GetClasfSectorial/' + idActEconomica), null, {
                success: function (data) {
                    dataCS = data;

                    if (dataCS != '') {
                        clasf_sectorial['ActividadEconomica'] = dataCS;
                        clasf_sectorial.render();
                    }
                },
                error: function (e) {
                    throw e;
                }
            });
        }
    },

    SaveClasfSectorial: function (fields, errors, callback) {

        if ($('.list_ae').select2('val') != '') {
            this.ActividadEconomica = clasf_sectorial.ActividadEconomica;
        }
        //Establece el objeto para guardar en los campos de Clasificacion Sectorial 
        this.model.set('account_clasf_sectorial', this.ActividadEconomica);

        callback(null, fields, errors);
    },

    //Carga las listas desplegables para los campos.
    cargalistas: function () {
        //LISTAS CNBV
        clasf_sectorial.actividadeconomica_list = app.lang.getAppListStrings('actividadeconomica_list');
        clasf_sectorial.subsectoreconomico_list = app.lang.getAppListStrings('subsectoreconomico_list');
        clasf_sectorial.sectoreconomico_list = app.lang.getAppListStrings('sectoreconomico_list');
        clasf_sectorial.tct_macro_sector_ddw_list = app.lang.getAppListStrings('tct_macro_sector_ddw_list');

        //LISTAS INEGI
        clasf_sectorial.inegi_actividad_c_list = app.lang.getAppListStrings('inegi_actividad_c_list');
        clasf_sectorial.inegi_subsector_c_list = app.lang.getAppListStrings('inegi_subsector_c_list');
        clasf_sectorial.inegi_sector_c_list = app.lang.getAppListStrings('inegi_sector_c_list');
        clasf_sectorial.inegi_macro_c_list = app.lang.getAppListStrings('inegi_macro_c_list');
    },
})
