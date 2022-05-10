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
    razon_nv_list: null,
    fuera_perfil_list: null,
    condiciones_financieras_list: null,
    no_producto_list: null,
    no_interesado_list: null,
    held:0,

    events: {
		'click #presolicitud': 'crearSolicitud',
		'click #cancelado': 'cancelarAcc',
        'change #motivocancelacionCuenta':'dependenciasNV',
        'change #RazonNoViable':'dependenciasNV',
		'keydown .otroProducto': 'PuroTexto', 
        'keydown .comp_porque': 'PuroTexto', 
        'keydown .comp_quien': 'PuroTexto',
    },

    initialize: function (options) {
        //Inicializa campo custom minut_leasing
        self = this;
        this._super('initialize', [options]);

        var temp_array_get = [];
        
        /*************************************** */
        var temp_array_get = [];
        var newContext = options.context.get('model');

        // RAZON CUENTA NO VIABLE
        var razon_noviable = app.lang.getAppListStrings('razones_ddw_list');
        var list_html_nv = '';
        _.each(razon_noviable, function (value, key) {
            list_html_nv += '<option value="' + key + '">' + razon_noviable[key] + '</option>';
        });
        self.razon_nv_list = list_html_nv;

        // RAZON FUERA DE PERFIL
        var razon_fueraperfil = app.lang.getAppListStrings('fuera_de_perfil_ddw_list');
        var list_html_fp = '';
        _.each(razon_fueraperfil, function (value, key) {
            list_html_fp += '<option value="' + key + '">' + razon_fueraperfil[key] + '</option>';
        });
        self.fuera_perfil_list = list_html_fp;

        //CONDICIONES FINANCIERAS
        var condiciones_financieras = app.lang.getAppListStrings('razones_cf_list');
        var list_html_cf = '';
        _.each(condiciones_financieras, function (value, key) {
            list_html_cf += '<option value="' + key + '">' + condiciones_financieras[key] + '</option>';
        });
        self.condiciones_financieras_list = list_html_cf;

        //NO TENEMOS EL PRODUCTO QUE REQUIERE
        var no_producto = app.lang.getAppListStrings('no_producto_requiere_list');
        var list_html_npr = '';
        _.each(no_producto, function (value, key) {
            list_html_npr += '<option value="' + key + '">' + no_producto[key] + '</option>';
        });
        self.no_producto_list = list_html_npr;

        //NO SE ENCUENTRA INTERESADO
        var no_interesado = app.lang.getAppListStrings('tct_razon_ni_l_ddw_c_list');
        var list_html_ni = '';
        _.each(no_interesado, function (value, key) {
            list_html_ni += '<option value="' + key + '">' + no_interesado[key] + '</option>';
        });
        self.no_interesado_list = list_html_ni;      
    

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

    cancelarAcc: function() {
        this.$('#motivos').show();
       
	},
	
	crearSolicitud: function() {
        this.$('#motivos').hide();
    },
    
    dependenciasNV: function () {

        KeyRazonNV = $("#RazonNoViable").val();
        
        //Campos ocultos dependendientes de no viable
        $('#fuera_perfil').hide();
        $('#cond_financieras').hide();
        $('#competencia_quien').hide();
        $('#competencia_porque').hide();
        $('#no_product').hide();
        $('#otro_producto').hide();
        $('#no_interesado').hide();
        $('#submotivo_cancelacion').hide();

        //FUERA DE PERFIL
        if (KeyRazonNV == "1") {
            $('#fuera_perfil').show();
        }
        //CONDICIONES FINANCIERAS
        if (KeyRazonNV == "2") {
            $('#cond_financieras').show();
        }
        //YA ESTA CON LA COMPETENCIA
        if (KeyRazonNV == "3") {
            $('#competencia_quien').show();
            $('#competencia_porque').show();
        }
        //NO TENEMOS EL PRODUCTO QUE REQUIERE
        if (KeyRazonNV == "4") {
            $('#no_product').show();
        }
        //NO TENEMOS EL PRODUCTO QUE REQUIERE
        if (KeyRazonNV == "7") {
            $('#no_interesado').show();
        }
        //OPCION "OTRO" EN NO TENEMOS EL PRODUCTO QUE REQUIERE
        $('#noProducto').change(function (evt) {
            $('#otro_producto').hide();
            
            if ($("#noProducto").val() == "4"){
                $('#otro_producto').show();
            }
        });

        //SIN VALOR
        if (KeyRazonNV == "") {
            $('#no_interesado').hide();
            $('#fuera_perfil').hide();
            $('#cond_financieras').hide();
            $('#competencia_quien').hide();
            $('#competencia_porque').hide();
            $('#no_product').hide();
            $('#otro_producto').hide();
            $('#no_interesado').hide();
        }       
    },

    //Funcion que acepta solo letras (a-z), puntos(.) y comas(,)
    PuroTexto: function (evt) {
        //console.log(evt.keyCode);
        if ($.inArray(evt.keyCode, [9, 16, 17, 110, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192]) < 0) {
            if (evt.keyCode != 186) {
                app.alert.show("Caracter Invalido", {
                    level: "error",
                    title: "Solo texto es permitido en este campo.",
                    autoClose: true
                });
                return false;
            }
        }
    },

})
