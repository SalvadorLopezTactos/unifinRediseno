({
    events :{
        'change .campo1PA': 'nodigitos',
        'change .campo2PA': 'nodigitos',
        'change .campo3PA': 'nodigitos',
        'change .campo4PA': 'nodigitos',
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        Pautos = this;
        Pautos.autos={};
    },
    //Funcion para eliminar duplicados en cada campo.
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                // this.render();
            }
        }, this);
    },
    //Validacion para que los campos acepten solamente números enteros con base en una expresión regular
    nodigitos: function (evt) {
        if($('.campo1pa').val()!="") {
            var expreg = /^[0-9]{1,10}$/;
            var num1= $('.campo1pa').val();
            if (!expreg.test(num1)) {
                app.alert.show('error-numero-potencial', {
                    level: 'error',
                    autoClose: true,
                    messages: 'El campo Número de Autos Utilitarios no permite ingresar números negativos.'
                });
            }
        }
        if($('.campo2pa').val()!="") {
            var expreg = /^[0-9]{1,10}$/;
            var num2= $('.campo2pa').val();
            if (!expreg.test(num2)) {
                app.alert.show('error-numero-potencial', {
                    level: 'error',
                    autoClose: true,
                    messages: 'El campo Número de Autos Ejecutivos no permite ingresar números negativos.'
                });
            }
        }
        if($('.campo3pa').val()!="") {
            var expreg = /^[0-9]{1,10}$/;
            var num3= $('.campo3pa').val();
            if (!expreg.test(num3)) {
                app.alert.show('error-numero-potencial', {
                    level: 'error',
                    autoClose: true,
                    messages: 'El campo Número de Motos no permite ingresar números negativos.'
                });
            }
        }
        if($('.campo4pa').val()!="") {
            var expreg = /^[0-9]{1,10}$/;
            var num4= $('.campo4pa').val();
            if (!expreg.test(num4)) {
                app.alert.show('error-numero-potencial', {
                    level: 'error',
                    autoClose: true,
                    messages: 'El campo Número de Camiones no permite ingresar números negativos.'
                });
            }
        }
    },

})