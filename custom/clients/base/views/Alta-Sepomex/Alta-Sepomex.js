({

    className: 'Alta-Sepomex',

    events: {
        'click .openModalCheckCP': 'openModalCheckCP',
        'click .closemodalCheckCP': 'closeModalCheckCP',
        'click .cancelCheckCP': 'cancelCheckCP',
        'click .checkNacExt':'setCheckNacionalExt',
        'click .continueCheckCP':'continueCheckCP'
    },

    initialize: function(options){
        this._super("initialize", [options]);

    },

    _render: function () {
        this._super("_render");
        $(".openModalCheckCP").trigger('click');
    },

    openModalCheckCP:function(){
        var modal = $('#modalCheckCP');
        if (modal) {
            modal.show();
        }
    },

    closeModalCheckCP:function(){
        var modal = $('#modalCheckCP');
        if (modal) {
            modal.hide();
        }
    },

    openModalRecordCP:function(){
        var modal = $('#modalRecord');
        if (modal) {
            modal.show();
        }
    },

    closeModalRecordCP:function(){
        var modal = $('#modalRecord');
        if (modal) {
            modal.hide();
        }
    },

    cancelCheckCP:function(){
        App.router.navigate('#dir_Sepomex', {trigger:true});
    },

    setCheckNacionalExt:function(e){
        var checked=$(e.currentTarget).is(":checked");
        if(checked){
            //Se desactiva el check hermano para que únicamente se mantenga un solo checkbox seleccionado
            $(e.currentTarget).parent().siblings().children('input').prop( "checked", false );
        }
    },

    continueCheckCP:function(e){
        var cpValue=$('#codigoPostal').val();
        this.e=e;
        self=this;
        if(cpValue==""){
            app.alert.show('errorCP', {
                level: 'error',
                messages: 'Favor de ingresar un Código Postal',
                autoClose: true
            });
            $('#codigoPostal').attr('style','border:1px solid red;');
            return;
        }else{
            $(e.currentTarget).addClass('disabled');
            $('#processingCheckCP').show();

            var str_length = cpValue.length;
            //Valida formato
            var pattern = /^\d+$/;
            var isNumber = pattern.test(cpValue);
            if (str_length >= 5 && isNumber){

                //LLamada a api custom
                app.alert.show('loadingCheckCP', {
                    level: 'process',
                    title: 'Cargando información de Código Postal ...',
                });

                var strUrl = 'DireccionesCP/' + cpValue + '/0';

                app.api.call('GET', app.api.buildURL(strUrl), null, {
                    success: _.bind(function (data) {
                        console.log("CPP");

                        $(self.e.currentTarget).removeClass('disabled');
                        app.alert.dismiss('loadingCheckCP');
                        $('#processingCheckCP').hide();
                        $('#codigoPostal').attr('style','');

                        self.closeModalCheckCP();
                        self.openModalRecordCP();

                    }, self)
                });
                
            }else{
                $(e.currentTarget).removeClass('disabled');
                $('#processingCheckCP').hide();
                $('#codigoPostal').attr('style','border:1px solid red;');
                
                app.alert.show('invalid_cp', {
                    level: 'error',
                    autoClose: true,
                    messages: 'C\u00F3digo Postal inv\u00E1lido'
                });

            } 
        }
    }
})
