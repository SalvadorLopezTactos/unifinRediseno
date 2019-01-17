({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super("initialize", [options]);
        //Se añade evento para establecer registro como Solo Lectura
        this.model.on('sync', this.setNoEditAllFields, this);
        this.model.on('data:sync:complete', this.hidedeletedocuments, this);
        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));
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

    },

    hidedeletedocuments: function () {
        //console.log('Entro a hidedeletedocuments()');
        $('div[data-subpanel-link="minut_minutas_documents_1"]').find('a[class="btn dropdown-toggle"]').hide()
        //$('div[data-subpanel-link="minut_minutas_documents_1"]').find('.flex-list-view.left-actions.right-actions.scroll-width').find('a[class="btn dropdown-toggle"]').hide();
    },

    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "minut_Minutas") + '</b><br>';
                    }
          		  }
       	    }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Minuta:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },
})
