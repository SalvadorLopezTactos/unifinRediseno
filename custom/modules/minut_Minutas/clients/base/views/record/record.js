({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super("initialize", [options]);
        this.context.on('button:view_document:click', this.view_document, this);

        //Se añade evento para establecer registro como Solo Lectura
        this.model.on('sync', this.setNoEditAllFields, this);

    },

    view_document: function () {
        var pdf = window.location.origin + window.location.pathname + "/custom/pdf/ladas.pdf";
        window.open(pdf, '_blank');
        var cDate = new Date();
        this.model.set('fecha_y_hora_c', cDate);
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var geocoder = new google.maps.Geocoder();
            var latlng = {lat: lat, lng: lng};
            geocoder.geocode({'location': latlng}, function (results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        var direccion = results[0].formatted_address;
                        alert(direccion);
                    } else {
                        window.alert('No se encontro la direcci\u00F3n');
                    }
                } else {
                    window.alert('Error de Google: ' + status);
                }
            });
        });
        this.model.set('description', cDate);
        this.model.save();
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