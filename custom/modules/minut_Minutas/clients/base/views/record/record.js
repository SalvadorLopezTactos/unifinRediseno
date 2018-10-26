({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super("initialize", [options]);
        this.context.on('button:view_document:click', this.view_document, this);

        //Se añade evento para establecer registro como Solo Lectura
        this.model.on('sync', this.setNoEditAllFields, this);

    },

    view_document: function()
    {
        window.open('https://www.natura.com.mx/repositorio/descargas/consultorias/CONSULTORIA_C15-18.pdf','_blank');
        var cDate = new Date();
        this.model.set('fecha_y_hora_c',cDate);
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitud = position.coords.latitude;
            var longitud = position.coords.longitude;
            alert(latitud);
        });
        this.model.set('description',cDate);
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

})