/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    /**
     * @inheritdoc
     * @param options
     */
    initialize: function (options) {
        //Inicializa campo custom
        self = this;
        this._super('initialize', [options]);
        this.model.addValidationTask('ObtenerObjetivos', _.bind(this.almacenaobjetivos, this));

        this.myobjmin = {};
        this.myobjmin.records = [];

        //Carga datos:
        //Creación
        this.loadData();
        //Registro
        this.model.on('sync', this.loadData, this);
    },


    loadData: function (options) {
        myobjmin = "";
        var selfvalue = this;

        //Condición para cargar objetivos relacionados a la REUNIÓN
        if (this.action == 'detail') {
            var idReunion=this.model.get('id');

                if (this.model.get("minut_minutas_meetingsmeetings_idb") != "") {
                    app.api.call('GET', app.api.buildURL('minut_Minutas/' + idReunion + '/link/minut_minutas_minut_objetivos'), null, {
                        success: function (data) {
                        selfvalue.myobjmin = data;
                        _.extend(this, selfvalue.myobjmin);
                        selfvalue.render();
                    },
                    error: function (e) {
                        throw e;
                    }
                });
            }

        }
        //Condición para cargar objetivos de la Reunión, desde la vista de Minuta
        else if(this.context.parent){
            var idReunion=this.context.parent.get('modelId');

            app.api.call('GET', app.api.buildURL('Meetings/' + idReunion + '/link/meetings_minut_objetivos_1'), null, {
                success: function (data) {
                    selfvalue.myobjmin = data;
                    //Obteniendo el objetivo general de la Reunión (parent)
                    var modeloReunion=selfvalue.context.parent.get('model');
                    var objetivoGral=App.lang.getAppListStrings('objetivo_list')[modeloReunion.get('objetivo_c')];
                    var item = {
                        "name":objetivoGral,"cumplimiento":""
                    };
                    //Se añade el objetivo general al principio del arreglo
                    selfvalue.myobjmin.records.unshift(item);
                    _.extend(this, selfvalue.myobjmin);
                    selfvalue.render();
                },
                error: function (e) {
                    throw e;
                }
            });

        }

    },


    _render: function () {
        self = this;
        this._super("_render");

        $('.updateRecord').click(function (evt) {
            var row = $(this).closest("tr");    // Find the row
            if (self.myobjmin.records[row.index()].cumplimiento == 1) {
                self.myobjmin.records[row.index()].cumplimiento = 0;
            } else {
                self.myobjmin.records[row.index()].cumplimiento = 1;
            }
            self.render();
        });

    },

    // /**
    //  * Binds DOM changes to set field value on model.
    //  * @param {Backbone.Model} model model this field is bound to.
    //  * @param {String} fieldName field name.
    //  */
    // bindDomChange: function () {
    //     if (this.tplName === 'list-edit') {
    //         this._super("bindDomChange");
    //     }
    // },

    /**
     * When data changes, re-render the field only if it is not on edit (see MAR-1617).
     * @inheritdoc
     */
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    almacenaobjetivos: function (fields, errors, callback) {

        this.model.set('minuta_objetivos', this.myobjmin);

        callback(null, fields, errors);
    },


})
