({
    plugins: ['Dashlet'],

    events: {
        'click .fa-star':'setFavorite',
        'click .sortTipo':'ordenaMontoClientes',
        'click .dropdown-field-clientes':'dropdownFieldStyleClientes',
        'click .ordenamiento_categoria':'ordenamientoPorTipoClientes'
    },

    registrosKanbanClientes:null,

    initialize: function (options) {
        this._super("initialize", [options]);
        contextoKanbanClientes=this;
    },

    _render: function () {
        this._super("_render");
        $('.contenedor-grid-clientes').attr('style','grid-template-columns: repeat(3, 1fr)');
    },

    setFavorite:function(e){
        var id=$(e.currentTarget).attr('data-id');
        contextoKanbanClientes.idRegistroGlobal=id;
        var estilo=$(e.currentTarget).attr('style');
        var modulo=$(e.currentTarget).attr('data-modulo');
        contextoKanbanClientes.columna=$(e.currentTarget).attr('data-columna');

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
                    var indice=contextoKanbanClientes.searchIndexFavorite(contextoKanbanClientes.idRegistroGlobal,contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros);
                    //Una vez encontrado el índice, se forza a establecer valor a Favorito para que éste se pueda ordenar
                    contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros[indice].Favorito='1';

                    //Ordenando por favorito y después por nombre
                    var favoritos=[];
                    var no_favoritos=[];
                    for (let index = 0; index < contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros.length; index++) {
                        if(contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros[index].Favorito != null){
                            favoritos.push(contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros[index]);
                        }else{
                            no_favoritos.push(contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros[index]);
                        }
                    }

                    //Ordenando los Favoritos
                    if(favoritos.length>0){
                        favoritos.sort((a, b) => {
                            const nameA = a.Nombre.toUpperCase().trim();
                            const nameB = b.Nombre.toUpperCase().trim();
                            if (nameA < nameB) {
                                return -1;
                            }
                            if (nameA > nameB) {
                                return 1;
                            }
                            return 0;
                        });
                    }

                    if(no_favoritos.length>0){
                        no_favoritos.sort((a, b) => {
                            const nameA = a.Nombre.toUpperCase().trim();
                            const nameB = b.Nombre.toUpperCase().trim();
                            if (nameA < nameB) {
                                return -1;
                            }
                            if (nameA > nameB) {
                                return 1;
                            }
                            return 0;
                        });
                    }
                    
                    var registros=favoritos.concat(no_favoritos);
                    contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros=registros;
                    contextoKanbanClientes.render();
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
                    var indice=contextoKanbanClientes.searchIndexFavorite(contextoKanbanClientes.idRegistroGlobal,contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros);
                    //Una vez encontrado el índice, se forza a establecer valor a Favorito para que éste se pueda ordenar
                    contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros[indice].Favorito=null;
                    //Ordenando por favorito y después por nombre
                    var favoritos=[];
                    var no_favoritos=[];
                    for (let index = 0; index < contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros.length; index++) {
                        if(contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros[index].Favorito != null){
                            favoritos.push(contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros[index]);
                        }else{
                            no_favoritos.push(contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros[index]);
                        }
                    }

                    //Ordenando los Favoritos
                    if(favoritos.length>0){
                        favoritos.sort((a, b) => {
                            const nameA = a.Nombre.toUpperCase().trim();
                            const nameB = b.Nombre.toUpperCase().trim();
                            if (nameA < nameB) {
                                return -1;
                            }
                            if (nameA > nameB) {
                                return 1;
                            }
                            return 0;
                        });
                    }

                    if(no_favoritos.length>0){
                        no_favoritos.sort((a, b) => {
                            const nameA = a.Nombre.toUpperCase().trim();
                            const nameB = b.Nombre.toUpperCase().trim();
                            if (nameA < nameB) {
                                return -1;
                            }
                            if (nameA > nameB) {
                                return 1;
                            }
                            return 0;
                        });
                    }
                    
                    var registros=favoritos.concat(no_favoritos);
                    contextoKanbanClientes.registrosKanbanClientes[contextoKanbanClientes.columna].Registros=registros;
                    contextoKanbanClientes.render();
                },
                error: function (e) {
                    throw e;
                }
            });
        }
        

    },

    ordenaMontoClientes:function(e){
        var modoOrdenamiento=$(e.currentTarget).attr('modo-ordenamiento');
        var columna=$(e.currentTarget).attr('data-columna');
        var valorOrdenamiento="";
        if(contextoKanbanClientes.registrosKanbanClientes[columna].Registros.length>0){
            if(modoOrdenamiento=='DESC'){
                valorOrdenamiento="ASC";
                contextoKanbanClientes.registrosKanbanClientes[columna].Registros.sort((a, b) => {
                    return parseFloat(a.Monto_Cuenta.replace(/,/g, '')) - parseFloat(b.Monto_Cuenta.replace(/,/g, ''));
                });
            
            }else{
                valorOrdenamiento="DESC";
                contextoKanbanClientes.registrosKanbanClientes[columna].Registros.sort((a, b) => {
                    return parseFloat(b.Monto_Cuenta.replace(/,/g, '')) - parseFloat(a.Monto_Cuenta.replace(/,/g, ''));
                });
            }

            contextoKanbanClientes.render();
            //$(e.target).attr('modo-ordenamiento',valorOrdenamiento);
            $('[data-columna="'+columna+'"].sortTipo').attr('modo-ordenamiento',valorOrdenamiento)
        }      
    },

    dropdownFieldStyleClientes:function(e){
        var $this = $(e.currentTarget);
        $this.children('ul').slideToggle(100);
        var $target = $(e.target);
        if ($target.is('li')) {
            $this.children('span').html($target.text());
            $this.find('input[type="hidden"]').val($target.attr('data-value'));
        }
    },

    ordenamientoPorTipoClientes:function(e){
        var tipo_ordenamiento=$(e.currentTarget).attr('data-value');
        var columna=$(e.currentTarget).attr('data-columna');
        var registros=this.ordenaRegistrosClientes(contextoKanbanClientes.registrosKanbanClientes,columna,tipo_ordenamiento);

        contextoKanbanClientes.registrosKanbanClientes[columna].Registros=registros;
        this.render();
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

    ordenaRegistrosClientes:function(arreglo,columna, tipo){
        var return_registros=[];
        //MA : Monto Ascendente, MD: Monto Descendente
        //NA : Nombre Ascendente, ND: Nombre Descendente
        switch (tipo) {
            case 'MA':

                var favoritos=[];
                var no_favoritos=[];

                for (let index = 0; index < arreglo[columna].Registros.length; index++) {
                    if(arreglo[columna].Registros[index].Favorito != null){
                        favoritos.push(arreglo[columna].Registros[index]);
                    }else{
                        no_favoritos.push(arreglo[columna].Registros[index]);
                    }
                }

                //Ordena Favoritos
                if(favoritos.length>0){
                    favoritos=favoritos.sort((a, b) => {
                        return parseFloat(a.Monto_Cuenta.replace(/,/g, '')) - parseFloat(b.Monto_Cuenta.replace(/,/g, ''));
                    });
                }

                //Ordena No Favoritos
                if(no_favoritos.length>0){
                    no_favoritos=no_favoritos.sort((a, b) => {
                        return parseFloat(a.Monto_Cuenta.replace(/,/g, '')) - parseFloat(b.Monto_Cuenta.replace(/,/g, ''));
                    });
                }

                return_registros=favoritos.concat(no_favoritos);
                break;
            
            case 'MD':
                var favoritos=[];
                var no_favoritos=[];

                for (let index = 0; index < arreglo[columna].Registros.length; index++) {
                    if(arreglo[columna].Registros[index].Favorito != null){
                        favoritos.push(arreglo[columna].Registros[index]);
                    }else{
                        no_favoritos.push(arreglo[columna].Registros[index]);
                    }
                }

                //Ordena Favoritos
                if(favoritos.length>0){
                    favoritos=favoritos.sort((a, b) => {
                        return parseFloat(b.Monto_Cuenta.replace(/,/g, '')) - parseFloat(a.Monto_Cuenta.replace(/,/g, ''));
                    });
                }

                //Ordena No Favoritos
                if(no_favoritos.length>0){
                    no_favoritos=no_favoritos.sort((a, b) => {
                        return parseFloat(b.Monto_Cuenta.replace(/,/g, '')) - parseFloat(a.Monto_Cuenta.replace(/,/g, ''));
                    });
                }

                return_registros=favoritos.concat(no_favoritos);
                break;
            
            case 'NA':
                var favoritos=[];
                var no_favoritos=[];

                for (let index = 0; index < arreglo[columna].Registros.length; index++) {
                    if(arreglo[columna].Registros[index].Favorito != null){
                        favoritos.push(arreglo[columna].Registros[index]);
                    }else{
                        no_favoritos.push(arreglo[columna].Registros[index]);
                    }
                }

                //Ordena Favoritos
                if(favoritos.length>0){
                    favoritos=favoritos.sort((a, b) => {
                        const nameA = a.Nombre.toUpperCase().trim();
                        const nameB = b.Nombre.toUpperCase().trim();
                        if (nameA < nameB) {
                            return -1;
                        }
                        if (nameA > nameB) {
                            return 1;
                        }
                        return 0;
                    });
                }

                //Ordena No Favoritos
                if(no_favoritos.length>0){
                    no_favoritos=no_favoritos.sort((a, b) => {
                        const nameA = a.Nombre.toUpperCase().trim();
                        const nameB = b.Nombre.toUpperCase().trim();
                        if (nameA < nameB) {
                            return -1;
                        }
                        if (nameA > nameB) {
                            return 1;
                        }
                        return 0;  
                    });
                }

                return_registros=favoritos.concat(no_favoritos);  
                break;
            case 'ND':
                var favoritos=[];
                var no_favoritos=[];

                for (let index = 0; index < arreglo[columna].Registros.length; index++) {
                    if(arreglo[columna].Registros[index].Favorito != null){
                        favoritos.push(arreglo[columna].Registros[index]);
                    }else{
                        no_favoritos.push(arreglo[columna].Registros[index]);
                    }
                }

                //Ordena Favoritos
                if(favoritos.length>0){
                    favoritos=favoritos.sort((a, b) => {
                        const nameA = a.Nombre.toUpperCase().trim();
                        const nameB = b.Nombre.toUpperCase().trim();
                        if (nameA < nameB) {
                            return 1;
                        }
                        if (nameA > nameB) {
                            return -1;
                        }
                        return 0;
                    });
                }

                //Ordena No Favoritos
                if(no_favoritos.length>0){
                    no_favoritos=no_favoritos.sort((a, b) => {
                        const nameA = a.Nombre.toUpperCase().trim();
                        const nameB = b.Nombre.toUpperCase().trim();
                        if (nameA < nameB) {
                            return 1;
                        }
                        if (nameA > nameB) {
                            return -1;
                        }
                        return 0;
                    });
                }

                return_registros=favoritos.concat(no_favoritos); 
                break;
            default:
                return_registros=arreglo[columna].Registros;
                break;
        }

        return return_registros;

    }

})