({
    extendsFrom: 'RecordView',


    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        //Al dar click mandara a la vista de creacion correspondiente a la minuta
        this.context.on('button:btn_meet_button:click', this.CreaMeet,this);
        this.context.on('button:btn_call_button:click', this.CreaCall,this);
        this.context.on('button:btn_pre_button:click', this.CreaPre,this);
        //Validacion para mostrar los botones +
        this.model.on('sync', this.ocultarBotones, this);
        //Validacion para ocultar los botones de creacion de llamadas, reuniones desde la vista de subpanel
        this.model.on('sync', this.ocultarQuickCreate, this);

        $('[name="create_meet"]').hide();
        $('[name="create_call"]').hide();
        $('[name="create_pre"]').hide();
        //Evento para mostrar botones dependiendo de opcion elegida
        this.model.on("change:resultado_licitacion_c",_.bind(this.ocultarBotones, this));
        //Validacion para impedir que se guarde registro sin cuenta asociada
        this.model.addValidationTask('Valida_cuenta', _.bind(this.validacuenta, this));
        this.model.addValidationTask('Valida_noViable', _.bind(this.validaNoViable, this));

    },

    _render: function (options) {
        this._super("_render");
       
    },

    CreaMeet:function(){
        var model=App.data.createBean('Meetings');
        var name=this.model.get('name');
        var parent_type = (this.model.get('lic_licitaciones_accounts_name')!='') ? 'Accounts':'Leads';
        var parent_name= (parent_type=='Accounts') ? this.model.get('lic_licitaciones_accounts_name') : this.model.get('leads_lic_licitaciones_1_name');
        var parent_id = (parent_type=='Accounts') ? this.model.get('lic_licitaciones_accountsaccounts_ida') : this.model.get('leads_lic_licitaciones_1leads_ida');
        model.set('parent_type', parent_type);
        model.set('parent_name', parent_name);
        model.set('parent_id', parent_id);
        model.set('lic_licitaciones_meetings_1lic_licitaciones_ida',this.model.get('id'));
        model.set('lic_licitaciones_meetings_1_name',this.model.get('name'));
        model.set('name',"Reunión"+" "+name);
        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'Meetings',
                    model: model
                },
            },
            function(variable){
                location.reload();
            }
        );
    },

    CreaCall:function(){
        var model=App.data.createBean('Calls');
        var name=this.model.get('name');
        var parent_type = (this.model.get('lic_licitaciones_accounts_name')!='') ? 'Accounts':'Leads';
        var parent_name= (parent_type=='Accounts') ? this.model.get('lic_licitaciones_accounts_name') : this.model.get('leads_lic_licitaciones_1_name');
        var parent_id = (parent_type=='Accounts') ? this.model.get('lic_licitaciones_accountsaccounts_ida') : this.model.get('leads_lic_licitaciones_1leads_ida');
        model.set('parent_type', parent_type);
        model.set('parent_name', parent_name);
        model.set('parent_id', parent_id);
        model.set('lic_licitaciones_calls_1_name', this.model.get('name'));
        model.set('lic_licitaciones_calls_1lic_licitaciones_ida',this.model.get('id'));
        model.set('name',"Llamada"+" "+name);
        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'Calls',
                    model: model
                },
            },
            function(variable){
                location.reload();
            }
        );
    },

    CreaPre:function(){
        var model=App.data.createBean('Opportunities');
        var name=this.model.get('name');
        //model.set('account_id_c', this.model.get('parent_id'));
        model.set('account_name', this.model.get('lic_licitaciones_accounts_name'));
        model.set('account_id', this.model.get('lic_licitaciones_accountsaccounts_ida'));
        model.set('lic_licitaciones_opportunities_1lic_licitaciones_ida',this.model.get('id'));
        model.set('lic_licitaciones_opportunities_1_name',this.model.get('name'));
        model.set('name',"PRE-Solicitud"+" "+name);
        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'Opportunities',
                    model: model
                },
            },
        );
    },

    ocultarBotones:function (){
        if (this.model.get('resultado_licitacion_c')=="1"){
            $('[name="create_meet"]').show();
            $('[name="create_call"]').show();
        }else{
            $('[name="create_meet"]').hide();
            $('[name="create_call"]').hide();
        }
        if (this.model.get('lic_licitaciones_accounts_name') != '' && this.model.get('lic_licitaciones_accounts_name') != null && this.model.get('resultado_licitacion_c')=="1" && App.user.attributes.productos_c.includes('^1^')){
            $('[name="create_pre"]').show();
        }else{
            $('[name="create_pre"]').hide();
        }
    },

    validacuenta: function (fields, errors, callback) {
        var cuenta=this.model.get('lic_licitaciones_accounts_name');
        var cuenta=this.model.get('lic_licitaciones_accounts_name');
        var lead = this.model.get('leads_lic_licitaciones_1_name');
        if ((cuenta==""|| cuenta==null) && (lead==""|| lead==null)) {
            app.alert.show("cuentaFaltante", {
                level: "error",
                title: "No se puede guardar el registro sin un lead o cuenta asociada. Favor de verificar.",
                autoClose: false
            });
            errors['lic_licitaciones_accounts_name'] = errors['lic_licitaciones_accounts_name'] || {};
            errors['lic_licitaciones_accounts_name'].required = true;
        }
        callback(null, fields, errors);
    },

    validaNoViable: function (fields, errors, callback) {
        var resultado=this.model.get('resultado_licitacion_c');
        var razon=this.model.get('razon_no_viable_c');
        if (resultado=="2" && razon=="") {
            app.alert.show("noViableFaltante", {
                level: "error",
                title: "Hace falta seleccionar una razón de no viable.",
                autoClose: false
            });
            errors['razon_no_viable_c'] = errors['razon_no_viable_c'] || {};
            errors['razon_no_viable_c'].required = true;
        }
        callback(null, fields, errors);

    },

    ocultarQuickCreate:function (){
        $('.subpanel-controls').addClass("hide");
    },

})
