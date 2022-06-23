({
    plugins: ['Dashlet'],

    events: {
        'click .contenedor-item': 'muestraChecklist',
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        self=this;
        this.getRegistrosKanban();
    },

    getRegistrosKanban: function () {

        App.alert.show('getRecordsKanban', {
            level: 'process',
            title: 'Cargando',
        });

        app.api.call('GET', app.api.buildURL('GetCMInfoKanban'), null, {
            success: function (data) {
                App.alert.dismiss('getRecordsKanban');
                self.registrosKanban=data;

                self.render();
            },
            error: function (e) {
                throw e;
            }
        });

    },

    _render: function () {
        this._super("_render");
        $('.contenedor-grid').attr('style','grid-template-columns: repeat(8, 1fr)')
    },

    muestraChecklist:function(e){
        var subtipo=$(e.currentTarget).attr('data-tipo');

        //Obteniendo la lista de valores que contiene el checklist
        var lista=App.lang.getAppListStrings('cm_checklist_kanban_list');
        //Checklist unicamente pertenece a los subtipos Sin Contactar, Contactado e Interesado (1,2,7)
        if(subtipo==1 || subtipo==2 || subtipo==7){
            var valores_unformat=lista[subtipo];
            var elementos_checklist=valores_unformat.split(',');
            var string_elementos_checklist="";
            for(var i=0;i<elementos_checklist.length;i++){
                string_elementos_checklist+=`<p style="margin-top: 20px;font-size: 12px;">
                <input type="checkbox" disabled>  `+elementos_checklist[i]+`
            </p>`
            }

            $('.center-title-checklist').empty();
            $('.center-title-checklist').append('<p style="margin-top: 40px;"><b>Checklist Actividades Pendientes</b></p>');
            $('.center-title-checklist').append(string_elementos_checklist);      
            
            $('.checklist-item').removeClass('hide');

        }else{
            $('.checklist-item').addClass('hide');
        }
        
    }


})