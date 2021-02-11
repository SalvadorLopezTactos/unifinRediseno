({
    extendsFrom: 'RecordView',


    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
       
        //Al dar click mandara a la vista de creacion correspondiente a la minuta
        this.context.on('button:btn_meet_button:click', this.CreaMeet,this);
        this.context.on('button:btn_call_button:click', this.CreaCall,this);
        this.context.on('button:btn_pre_button:click', this.CreaPre,this);

      
    },

    _render: function (options) {
        this._super("_render");
        
    },

    CreaMeet:function(){
        var model=App.data.createBean('Meetings');
        // FECHA ACTUAL
        var startDate = new Date(this.model.get('date_end'));
        var startMonth = startDate.getMonth() + 1;
        var startDay = startDate.getDate();
        var startYear = startDate.getFullYear();
        var startDateText = startDay + "/" + startMonth + "/" + startYear;
        var name=this.model.get('name');
        //model.set('account_id_c', this.model.get('parent_id'));
        model.set('parent_id', this.model.get('lic_licitaciones_accounts_name'));
        model.set('lic_licitaciones_meetings_1lic_licitaciones_ida',this.model.get('id'));
        model.set('lic_licitaciones_meetings_1_name',this.model.get('name'));
        model.set('name',"Reunión"+" "+startDateText+" "+name);
        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'Meetings',
                    model: model
                },
            },
            function(){
                location.reload();
            }
        );
    },

    CreaCall:function(){
        var model=App.data.createBean('Calls');
        // FECHA ACTUAL
        var startDate = new Date(this.model.get('date_end'));
        var startMonth = startDate.getMonth() + 1;
        var startDay = startDate.getDate();
        var startYear = startDate.getFullYear();
        var startDateText = startDay + "/" + startMonth + "/" + startYear;
        var name=this.model.get('name');
        //model.set('account_id_c', this.model.get('parent_id'));
        model.set('parent_id', this.model.get('lic_licitaciones_accounts_name'));
        model.set('lic_licitaciones_calls_1lic_licitaciones_ida',this.model.get('id'));
        model.set('lic_licitaciones_calls_1',this.model.get('name'));
        model.set('name',"Llamada"+" "+startDateText+" "+name);
        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'Calls',
                    model: model
                },
            },
            function(){
                location.reload();
            }
        );
    },

    CreaPre:function(){
        var model=App.data.createBean('Opportunities');
        // FECHA ACTUAL
        var startDate = new Date(this.model.get('date_end'));
        var startMonth = startDate.getMonth() + 1;
        var startDay = startDate.getDate();
        var startYear = startDate.getFullYear();
        var startDateText = startDay + "/" + startMonth + "/" + startYear;
        var name=this.model.get('name');
        //model.set('account_id_c', this.model.get('parent_id'));
        model.set('account_name', this.model.get('lic_licitaciones_accounts_name'));
        model.set('account_id', this.model.get('lic_licitaciones_accountsaccounts_ida'));
        model.set('lic_licitaciones_opportunities_1lic_licitaciones_ida',this.model.get('id'));
        model.set('lic_licitaciones_opportunities_1_name',this.model.get('name'));
        model.set('name',"PRE-Solicitud"+" "+startDateText+" "+name);
        app.drawer.open({
              layout: 'create',
              context: {
                    create: true,
                    module: 'Opportunities',
                    model: model
                },
            },
            function(){
                location.reload();
            }
        );
    },
 
    
   
})