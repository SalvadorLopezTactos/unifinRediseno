({
    extendsFrom: 'RecordView',

    events: {
        'click  .clearfix': 'hidedeletedocuments',
        'click  .a11y-wrapper': 'hidedeletedocuments',
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        //Se añade evento para establecer registro como Solo Lectura
        this.model.on('sync', this.setNoEditAllFields, this);

        this.events['click a[class=dropdown-toggle]'] = 'hidedeletedocuments';
    },

    render: function(){

        this._super("render");
        //Quita etiquetas de campos custom
        $('[data-name=minuta_participantes]').find('.record-label').addClass('hide');
        $('[data-name=minuta_objetivos]').find('.record-label').addClass('hide');
        $('[data-name=minuta_compromisos]').find('.record-label').addClass('hide');
        $('[data-name=minuta_division]').find('.record-label').addClass('hide');

        //Oculta panel con campos de checkin en minuta
        $('[data-panelname="LBL_RECORDVIEW_PANEL4"]').addClass('hide');


        this.events['click a[class=dropdown-toggle]'] = 'hidedeletedocuments';
    },

    setNoEditAllFields: function () {
        //Estableciendo registro completo como solo lectura

        //Se establecen todos los campos como solo lectura
        $('.record-cell').attr("style", "pointer-events:none");
        //Excepto los campos de tipo relacionado para permitir la navegación hacia el registro
        $('.record-cell[data-type="relate"]').removeAttr("style");
        $('.record-cell[data-name="date_entered_by"]').removeAttr("style");
        $('.record-cell[data-name="date_modified_by"]').removeAttr("style");

        //Se oculta botón de edición
        $('[name="edit_button"]').hide();

        //Contrae panel de documentos
        $('.subpanel.clearfix').addClass('closed');

    },

    hidedeletedocuments: function () {
        console.log('Entro a hidedeletedocuments()');
        $('div[data-subpanel-link="minut_minutas_documents_1"]').find('a[class="btn dropdown-toggle"]').hide()
        //$('div[data-subpanel-link="minut_minutas_documents_1"]').find('.flex-list-view.left-actions.right-actions.scroll-width').find('a[class="btn dropdown-toggle"]').hide();
    }

})
