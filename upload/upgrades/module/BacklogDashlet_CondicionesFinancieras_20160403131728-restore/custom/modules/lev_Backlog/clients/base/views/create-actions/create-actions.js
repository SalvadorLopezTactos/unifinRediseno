/**
 * Created by Levementum on 3/2/2016.
 * User: jgarcia@levementum.com
 */

({
    extendsFrom: 'CreateView',
    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);


        this.getCurrentYearMonth("loading");
        this.getTipoOperacion();
        this.model.on("change:anio", _.bind(this.getCurrentYearMonth, this));
        this.model.on("change:cliente", _.bind(this.getTipoCliente, this));

        this.model.on("change:anio", _.bind(this.getTipoOperacion, this));
        this.model.on("change:mes", _.bind(this.getTipoOperacion, this));

        this.model.addValidationTask('check_monto_c', _.bind(this._ValidateAmount, this));
        this.model.addValidationTask('check_tipo_cliente', _.bind(this._ValidateTipo, this));

        var usuario = app.data.createBean('Users',{id:app.user.get('id')});
        usuario.fetch({
            success: _.bind(function(modelo) {
                this.model.set("region", modelo.get("region_c"));
                this.productos = modelo.get('productos_c');
                this.productoUsuario = modelo.get('tipodeproducto_c');
                this.multiProducto = modelo.get('multiproducto_c');


                var op = app.lang.getAppListStrings('tipo_producto_list');
                var op2 = {};
                for (id in this.productos){
                    op2[this.productos[id]] = op[this.productos[id]];
                }
                var lista = this.getField('producto');
                lista.items = op2;
                lista.render();

                if(this.productos[0] == "4"){
                    this.model.set('producto','4');
                }else if(this.productos[0] == "1"){
                    this.model.set('producto','1');
                }else if(this.productos[0] == "3"){
                    this.model.set('producto','3');
                }else if(this.productos[0] == "2"){
                    this.model.set('producto','3');
                }
                else if(this.productos[0] == "5"){
                    this.model.set('producto','5');
                }
            },this)
        });
    },

    _render: function() {
        this._super("_render");

        this.$('[data-name=editar]').hide();
        if(this.$('[data-fieldname=lev_backlog_opportunities_name]').children().children(['data-original-title']).html() != null&&
            this.$('[data-fieldname=lev_backlog_opportunities_name]').children().children(['data-original-title']).html() != ""){
            this.model.set("editar", false);
        }

        var usuario = app.data.createBean('Users',{id:app.user.get('id')});
        usuario.fetch({
            success: _.bind(function(modelo) {
                this.model.set("region", modelo.get("region_c"));
                this.model.set("equipo", modelo.get("equipo_c"));
                this.productos = modelo.get('productos_c');
                this.productoUsuario = modelo.get('tipodeproducto_c');
                this.multiProducto = modelo.get('multiproducto_c');


                var op = app.lang.getAppListStrings('tipo_producto_list');
                var op2 = {};
                for (id in this.productos){
                    op2[this.productos[id]] = op[this.productos[id]];
                }
                var lista = this.getField('producto');
                lista.items = op2;
                lista.render();

                if(this.productos[0] == "4"){
                    this.model.set('producto','4');
                }else if(this.productos[0] == "1"){
                    this.model.set('producto','1');
                }else if(this.productos[0] == "3"){
                    this.model.set('producto','3');
                }else if(this.productos[0] == "2"){
                    this.model.set('producto','3');
                }
                else if(this.productos[0] == "5"){
                    this.model.set('producto','5');
                }
            },this)
        });
    },

    getCurrentYearMonth: function(stage){

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        //currentMonth += 1;

        if(currentDay < 20){
            currentMonth += 1;
        }
        if(currentDay >= 20){
            currentMonth += 2;
        }

        var opciones_year = app.lang.getAppListStrings('anio_list');
        Object.keys(opciones_year).forEach(function(key){
            if(key < currentYear){
                delete opciones_year[key];
            }
        });
        this.model.fields['anio'].options = opciones_year;

        var opciones_mes = app.lang.getAppListStrings('mes_list');
        if(this.model.get("anio") <= currentYear){
            Object.keys(opciones_mes).forEach(function(key){
                if(key < currentMonth){
                    delete opciones_mes[key];
                }
            });
        }

        this.model.fields['mes'].options = opciones_mes;
        this.model.set("mes", currentMonth);
        if(stage != "loading"){
            this.render();
        }
    },

    getTipoCliente: function(){
        app.api.call("read", app.api.buildURL("Accounts/" + this.model.get('account_id_c'), null, null, {
            fields: name,
        }), null, {
            success: _.bind(function (data) {

                if(data.tipo_registro_c == "Prospecto"){
                    this.model.set("tipo","Prospecto");

                }else if(data.tipo_registro_c == "Cliente"){
                    this.model.set("tipo","Cliente");
                }else{
                    this.model.set("tipo","Persona");
                }

                if(data.tipo_registro_c == "Cliente" && data.estatus_c == "Integracion de Expediente"){
                    this.model.set("tipo","Prospecto");
                }

            }, this)
        });
    },

    getTipoOperacion: function (){

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        //currentMonth += 1;

        if(currentDay < 20){
            currentMonth += 1;
        }
        if(currentDay >= 20){
            currentMonth += 2;
        }

        if(this.model.get("anio") <= currentYear){

            if(currentMonth == this.model.get("mes")){
                this.model.set("tipo_de_operacion", "Adicional");
            }else{
                this.model.set("tipo_de_operacion", "Original");
            }

        }else{
            this.model.set("tipo_de_operacion", "Original");
        }

    },

    _ValidateAmount: function (fields, errors, callback){
        if (parseFloat(this.model.get('monto_comprometido')) <= 0)
        {
            errors['monto_comprometido'] = errors['monto_comprometido'] || {};
            errors['monto_comprometido'].required = true;  
        }

        if (parseFloat(this.model.get('renta_inicial_comprometida')) <= 0)
        {
            errors['renta_inicial_comprometida'] = errors['renta_inicial_comprometida'] || {};
            errors['renta_inicial_comprometida'].required = true;
        }

        callback(null, fields, errors);
    },

    _ValidateTipo: function(fields, errors, callback){
        if(this.model.get("tipo") == "Persona"){

            errors['tipo'] = errors['tipo'] || {};
            errors['tipo'].required = true;

            app.alert.show('tipo de persona', {
                level: 'error',
                messages: 'No se puede crear un Backlog para este tipo',
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },
})