({
    extendsFrom: 'SelectionListView',


    initialize: function(options) {

        this._super('initialize', [options]);
        console.log('DESDE CUSTOM SELECTION-LIST_USERS');

        //para validación
        //options.context.parent.get('module');

    },

    _render: function (options) {
        this._super("_render");

        if(this.context.parent.get('module')=='Meetings' && $('input[value="filterAgentesTelefonicosTemplate"]').val()=='filterAgentesTelefonicosTemplate'){
            //Ocultando ícono que elimina filtro
            $('.choice-filter-close').hide();
            $('.choice-filter-label').parent('.choice-filter-clickable').attr('style','pointer-events:none');
            $('.select2-choices').attr('style','pointer-events:none');
            $('[data-filter="operator"]').attr('style','pointer-events:none');
            $('[data-filter="field"]').attr('style','pointer-events:none');

        }

        //Obteniendo el modulo padre para generar validación
        //this.context.parent.get('module')=='Meetings'
        //Si el modulo padre es Meetings y la etiqueta equivale al valor filterAgentesTelefonicosTemplate
        //Bloqueando el campo con el valor $('.select2-choices').attr('style','pointer-events:none');
        //Bloqueando el operador $('[data-filter="operator"]').attr('style','pointer-events:none');
        //Bloqueando el campo $('[data-filter="field"]').attr('style','pointer-events:none');
        //Ocultando el icono para evitar eliminar el filtro

    },


})