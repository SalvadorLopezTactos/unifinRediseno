/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    /**
     * @inheritdoc
     * @param options
     */
    motivo_list: null,
    submotivo_list: null,
    held:0,

    events: {
		'change #motivocancelacionCuenta':'dependenciasNV',
    },

    initialize: function (options) {
        //Inicializa campo custom minut_leasing
        self = this;
        this._super('initialize', [options]);

        var temp_array_get = [];
        /********************************* */
        var motivos = app.lang.getAppListStrings('motivo_cancelacion_list');
        var list_html = '<option value="" >  </option>';
        _.each(motivos, function (value, key) {
            list_html += '<option value="' + key + '">' + motivos[key] + '</option>';
        });
		self.motivo_list = list_html;
        self.context_Call = options;

        var submotivos = app.lang.getAppListStrings('submotivo_cancelacion_list');
        var list_html1 = '<option value="" >  </option>';
        _.each(submotivos, function (value, key) {
            list_html1 += '<option value="' + key + '">' + submotivos[key] + '</option>';
        });
		self.submotivo_list = list_html1;
        self.context_Call = options;
        /*************************************** */
        
    },

    _render: function () {
        self = this;
        this._super("_render");
                
    },
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

    dependenciasNV: function () {

        //Campos ocultos dependendientes de no viable
        $('#submotivo_cancelacion').hide();
        /******************************* */
        //Motivos Cancelacion LEad
        MotCancelacion = $("#motivocancelacionCuenta").val();        
        if (MotCancelacion == "2" || MotCancelacion == "5") {
            $('#submotivo_cancelacion').show();
        }
		
    },

})
