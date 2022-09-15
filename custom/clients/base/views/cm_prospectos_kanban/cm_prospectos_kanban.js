({
    plugins: ['Dashlet'],

    events: {
        'click .contenedor-item': 'muestraChecklist',
        'click .fa-star':'setFavorite',
        'click .closeChecklist':'closeChecklist',
        'click .sortInteresado':'ordenaInteresado',
        'click .dropdown-field':'dropdownFieldStyle'
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        self=this;
        this.getRegistrosKanban();
    },

    getRegistrosKanban: function () {
        contextoKanban=this;
        App.alert.show('getRecordsKanban', {
            level: 'process',
            title: 'Cargando',
        });

        app.api.call('GET', app.api.buildURL('GetCMInfoKanban'), null, {
            success: function (data) {
                App.alert.dismiss('getRecordsKanban');
                contextoKanban.registrosKanban=data;
                contextoKanbanClientes.registrosKanbanClientes=data;

                contextoKanban.render();
                contextoKanbanClientes.render();

            },
            error: function (e) {
                throw e;
            }
        });

    },

    _render: function () {
        this._super("_render");
        $('.contenedor-grid').attr('style','grid-template-columns: repeat(5, 1fr)')
    },

    muestraChecklist:function(e){
        contextoKanban=this;
        this.id_registro=$(e.currentTarget).attr('data-id');
        this.subtipo=$(e.currentTarget).attr('data-tipo');
        this.tipo_registro=$(e.currentTarget).attr('data-registro');
        this.data_link=$(e.currentTarget).attr('data-link');
        this.nombre_link=$(e.currentTarget).attr('data-nombre');

        if(this.tipo_registro!=undefined){

            App.alert.show('getChecklistKanban', {
                level: 'process',
                title: 'Cargando',
            });
    
    
            app.api.call('GET', app.api.buildURL('GetChecklistKanban/'+this.id_registro+'/'+this.tipo_registro), null, {
                success: function (data) {
                    App.alert.dismiss('getChecklistKanban');
                    //Obteniendo la lista de valores que contiene el checklist
                    var lista=App.lang.getAppListStrings('cm_checklist_kanban_list');
                    var respuesta=data;
                    //Checklist unicamente pertenece a los subtipos Sin Contactar, Contactado e Interesado (1,2,7)
                    if(contextoKanban.subtipo==1 || contextoKanban.subtipo==2 || contextoKanban.subtipo==7){
    
                        var valores_unformat=lista[contextoKanban.subtipo];
                        var elementos_checklist=valores_unformat.split(',');
                        var string_elementos_checklist="";
                        for(var i=0;i<elementos_checklist.length;i++){
                            var elemento=elementos_checklist[i];
                            var elemento_split=elemento.split('|');
    
                            if(respuesta.includes(elemento_split[1])){
                                string_elementos_checklist+=`<p style="margin-top: 20px;font-size: 12px;">
                            <input type="checkbox" disabled checked>  `+elemento_split[0]+`
                        </p>`;
                            }else{
                                string_elementos_checklist+=`<p style="margin-top: 20px;font-size: 12px;">
                            <input type="checkbox" disabled>  `+elemento_split[0]+`
                        </p>`;
                            }
                            
                        }
    
                        $('.center-title-checklist').empty();
                        $('.center-title-checklist').append('<div><span class="close closeChecklist" tabindex="-1" style="margin:5px;color:black">X</span></div>');
                        $('.center-title-checklist').append('<p style="margin-top: 40px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><a href="#'+contextoKanban.data_link+'" target="_blank">'+contextoKanban.nombre_link+'</a><br><b>Checklist Actividades Pendientes</b></p>');
                        $('.center-title-checklist').append(string_elementos_checklist);      
                        
                        $('.checklist-item').removeClass('hide');
    
                    }else{
                        $('.checklist-item').addClass('hide');
                    }
                },
                error: function (e) {
                    throw e;
                }
            });

        }else{
            $('.checklist-item').addClass('hide');
        } 
    },

    closeChecklist:function(){
        $('.checklist-item').addClass('hide');
    },

    setFavorite:function(e){
        var id=$(e.currentTarget).attr('data-id');
        contextoKanban.idRegistroGlobal=id;
        var estilo=$(e.currentTarget).attr('style');
        var modulo=$(e.currentTarget).attr('data-modulo');
        contextoKanban.columna=$(e.currentTarget).attr('data-columna');

        if(estilo==undefined){//Establece como favorito
            $(e.currentTarget).attr('style','color: #3399FF');
            App.alert.show('setFavorite', {
                level: 'process',
                title: 'Estableciendo favorito',
            });
    
            app.api.call('update', app.api.buildURL(modulo+'/'+id+'/favorite'), null, {
                success: function (data) {
                    App.alert.dismiss('setFavorite');    
                    //Una vez establecido como favorito, se procede a buscar en el arreglo que se pinta para poder ubicar el indice y poder actualizar el valor a la clave "Favorito"
                    var indice=contextoKanban.searchIndexFavorite(contextoKanban.idRegistroGlobal,contextoKanban.registrosKanban[contextoKanban.columna].Registros);
                    //Una vez encontrado el índice, se forza a establecer valor a Favorito para que éste se pueda ordenar
                    contextoKanban.registrosKanban[contextoKanban.columna].Registros[indice].Favorito='1';
                    var valorColumna=contextoKanban.columna;

                    contextoKanban.registrosKanban[valorColumna].Registros.sort((a, b) => {
                        return b.Favorito - a.Favorito;
                    });
                    contextoKanban.render();
                },
                error: function (e) {
                    throw e;
                }
            });
            
        }else{//Quita favorito
            $(e.currentTarget).removeAttr('style');
            App.alert.show('quitFavorite', {
                level: 'process',
                title: 'Quitando favorito',
            });
    
            app.api.call('update', app.api.buildURL(modulo+'/'+id+'/unfavorite'), null, {
                success: function (data) {
                    App.alert.dismiss('quitFavorite');
                    
                    //Una vez establecido como favorito, se procede a buscar en el arreglo que se pinta para poder ubicar el indice y poder actualizar el valor a la clave "Favorito"
                    var indice=contextoKanban.searchIndexFavorite(contextoKanban.idRegistroGlobal,contextoKanban.registrosKanban[contextoKanban.columna].Registros);
                    //Una vez encontrado el índice, se forza a establecer valor a Favorito para que éste se pueda ordenar
                    contextoKanban.registrosKanban[contextoKanban.columna].Registros[indice].Favorito=null;
                    var valorColumna=contextoKanban.columna;
                    //Ordenando por favorito y después por nombre
                    contextoKanban.registrosKanban[valorColumna].Registros.sort((a, b) => {
                        return b.Favorito - a.Favorito;
                    });
                    contextoKanban.render();
                },
                error: function (e) {
                    throw e;
                }
            });
        }
        

    },

    searchIndexFavorite:function(id,arreglo){
        var indice=null;
        for (let index = 0; index < arreglo.length; index++) {
            if(arreglo[index].Id==id){
                indice=index;
                index=arreglo.length;
            }
        }
        return indice;

    },
    ordenaInteresado:function(e){
        var modoOrdenamiento=$(e.currentTarget).attr('modo-ordenamiento');
        var valorOrdenamiento="";
        if(this.registrosKanban.Prospecto_Interesado.Registros.length>0){
            if(modoOrdenamiento=='DESC'){
                valorOrdenamiento="ASC";
                this.registrosKanban.Prospecto_Interesado.Registros.sort((a, b) => {
                    return parseFloat(a.Monto_Cuenta.replace(/,/g, '')) - Number(b.Monto_Cuenta.replace(/,/g, ''));
                });
            
            }else{
                valorOrdenamiento="DESC";
                this.registrosKanban.Prospecto_Interesado.Registros.sort((a, b) => {
                    return parseFloat(b.Monto_Cuenta.replace(/,/g, '')) - Number(a.Monto_Cuenta.replace(/,/g, ''));
                });
            }

            this.render();
            $('.sortInteresado').attr('modo-ordenamiento',valorOrdenamiento)
        }        

    },

    dropdownFieldStyle:function(e){
        var $this = $(e.currentTarget);
        $this.children('ul').slideToggle(100);
        var $target = $(e.target);
        if ($target.is('li')) {
            $this.children('span').html($target.text());
            $this.find('input[type="hidden"]').val($target.attr('data-value'));
        }
    }

})