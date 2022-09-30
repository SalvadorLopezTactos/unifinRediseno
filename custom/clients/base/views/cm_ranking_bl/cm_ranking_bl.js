({
    plugins: ['Dashlet'],

    events: {
        'click .dropdown-field':'muestraOpcionesOrdenamiento',
        'click .ordenamiento_bl':'ordenamientoBacklogs'
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        contextoRanking=this;
        this.getRankingBL();
    },

    _render: function () {
        this._super("_render");
    },

    getRankingBL:function(){
        contextoKanban=this;
        App.alert.show('getRankingBL', {
            level: 'process',
            title: 'Cargando',
        });

        app.api.call('GET', app.api.buildURL('getBacklogDirector'), null, {
            success: function (data) {
                App.alert.dismiss('getRankingBL');
                contextoRanking.registrosRankingBL=data;
                contextoRanking.posicion_operativa=App.user.attributes.posicion_operativa_c;

                contextoRanking.directorEquipo=null;
                contextoRanking.directorRegional=null;

                contextoRanking.posicion_operativa.includes('^1^') ? contextoRanking.directorEquipo=true : contextoRanking.directorEquipo=null;
                contextoRanking.posicion_operativa.includes('^2^') ? contextoRanking.directorRegional=true : contextoRanking.directorRegional=null;

                contextoRanking.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    muestraOpcionesOrdenamiento:function(e){
        
        var $this = $(e.currentTarget);
        $this.children('ul').slideToggle(100);
        var $target = $(e.target);
        if ($target.is('li')) {
            $this.children('span').html($target.text());
            $this.find('input[type="hidden"]').val($target.attr('data-value'));
        }
    },

    ordenamientoBacklogs:function(e){

        var tipo_ordenamiento=$(e.currentTarget).attr('data-value');
        var columna=$(e.currentTarget).attr('data-columna');
        var registros=this.ordenaRegistrosBL(contextoRanking.registrosRankingBL,columna,tipo_ordenamiento);

        contextoRanking.registrosRankingBL[columna].Registros=registros;
        this.render();
    },

    ordenaRegistrosBL:function(arreglo,columna, tipo){
        var return_registros=[];
        //BA : Backlog Ascendente, BD: Backlog Descendente
        //MA : Monto Ascendente, MD: Monto Descendente
        //CA : Nombre Cliente Ascendente, CD: Nombre Cliente Descendente
        //EA : Nombre Equipo Ascendente, ED: Nombre Equipo Descendente
        switch (tipo) {
            case 'BA':
                return_registros=arreglo[columna].Registros.sort((a, b) => {
                    return parseInt(a.NoBacklog.replace(/,/g, '')) - parseInt(b.NoBacklog.replace(/,/g, ''));
                });
                break;
            
            case 'BD':
                return_registros=arreglo[columna].Registros.sort((a, b) => {
                    return parseInt(b.NoBacklog.replace(/,/g, '')) - parseInt(a.NoBacklog.replace(/,/g, ''));
                });
                break;
            
            case 'MA':
                return_registros=arreglo[columna].Registros.sort((a, b) => {
                    return parseFloat(a.Monto.replace(/,/g, '')) - parseFloat(b.Monto.replace(/,/g, ''));
                });
                break;
            case 'MD':
                return_registros=arreglo[columna].Registros.sort((a, b) => {
                    return parseFloat(b.Monto.replace(/,/g, '')) - parseFloat(a.Monto.replace(/,/g, ''));
                });
                break;
            case 'CA':
                return_registros=arreglo[columna].Registros.sort((a,b) =>{
                    const nameA = a.Cliente.toUpperCase().trim();
                    const nameB = b.Cliente.toUpperCase().trim();
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }
                    return 0;
                });
                break;
            case 'CD':
                return_registros=arreglo[columna].Registros.sort((a, b) => {
                    const nameA = a.Cliente.toUpperCase().trim();
                    const nameB = b.Cliente.toUpperCase().trim();
                    if (nameA < nameB) {
                        return 1;
                    }
                    if (nameA > nameB) {
                        return -1;
                    }
                    return 0;
                });
                break;
            case 'EA':
                return_registros=arreglo[columna].Registros.sort((a,b) =>{
                    const nameA = a.Equipo.toUpperCase().trim();
                    const nameB = b.Equipo.toUpperCase().trim();
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }
                    return 0;
                });
                break;
            case 'ED':
                return_registros=arreglo[columna].Registros.sort((a, b) => {
                    const nameA = a.Equipo.toUpperCase().trim();
                    const nameB = b.Equipo.toUpperCase().trim();
                    if (nameA < nameB) {
                        return 1;
                    }
                    if (nameA > nameB) {
                        return -1;
                    }
                    return 0;
                });
                break;
            default:
                return_registros=arreglo[columna].Registros;
                break;
        }

        return return_registros;

    }

})