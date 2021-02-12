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
        $('[name="create_meet"]').hide();
        $('[name="create_call"]').hide();
        $('[name="create_pre"]').hide();
        //Evento para mostrar botones dependiendo de opcion elegida
        this.model.on("change:resultado_licitacion_c",_.bind(this.ocultarBotones, this));
    },

    _render: function (options) {
        this._super("_render");
        
    },

    CreaMeet:function(){
        var model=App.data.createBean('Meetings');
        var name=this.model.get('name');
        //model.set('account_id_c', this.model.get('parent_id'));
        model.set('parent_id', this.model.get('lic_licitaciones_accounts_name'));
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
        );
    },

    CreaCall:function(){
        var model=App.data.createBean('Calls');
        var name=this.model.get('name');
        //model.set('account_id_c', this.model.get('parent_id'));
        model.set('parent_id', this.model.get('lic_licitaciones_accounts_name'));
        model.set('lic_licitaciones_calls_1lic_licitaciones_ida',this.model.get('id'));
        model.set('lic_licitaciones_calls_1',this.model.get('name'));
        model.set('name',"Llamada"+" "+name);
        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'Calls',
                    model: model
                },
            },
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
        if (this.model.get('resultado_licitacion_c')=="1" && App.user.attributes.productos_c.includes('^1^')){
            $('[name="create_pre"]').show();
        }else{
            $('[name="create_pre"]').hide();
        }
    },
 
    
   
})