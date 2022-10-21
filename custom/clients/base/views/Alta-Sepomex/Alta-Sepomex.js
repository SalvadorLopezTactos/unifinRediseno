({

    className: 'Alta-Sepomex',

    events: {
        'click .openModalCheckCP': 'openModalCheckCP',
        'click .closemodalCheckCP': 'closeModalCheckCP',
        'click .cancelCheckCP': 'cancelCheckCP',
        'click .checkNacExt':'setCheckNacionalExt',
        'click .continueCheckCP':'continueCheckCP',
        'click .cancelSaveRecord':'cancelSaveRecord'
    },

    flagClickModal:null,

    initialize: function(options){
        this._super("initialize", [options]);
        this.paises_list=App.lang.getAppListStrings('paises_list');
    },

    _render: function () {
        this._super("_render");
        if(this.flagClickModal===null){
            $(".openModalCheckCP").trigger('click');
        }
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

    cancelSaveRecord:function(){
        // ToDO: Antes de mostrar el modal previo, mostrar advertencia en caso de que algún campo contenga valor
        this.closeModalRecordCP();
        this.openModalCheckCP();
    },

    /* Función para establecer valor a solo un checkbox */
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
        this.cpValue=cpValue;
        //Obteniendo valores de checkbox para saber si es una dirección Nacional o Extranjera
        var valueChkNac=$('#checkNacional').is(':checked');
        this.nacionalidad= (valueChkNac) ? 'nacional':'extranjero';
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
                        if(data.paises.length>0){
                            console.log(self.nacionalidad);
                            self.isNational=(self.nacionalidad=='nacional') ? true:false;

                            if(self.isNational){
                                self.estados_list={};
                                self.ciudades_list={};
                                self.municipios_list={};
                                self.paisId=data.paises[0].idPais;
                                self.paisName=data.paises[0].namePais;
                                
                                for (let index = 0; index < data.estados.length; index++) {
                                    self.estados_list[data.estados[index].idEstado]=data.estados[index].nameEstado;
                                }

                                for (let index = 0; index < data.ciudades.length; index++) {
                                    self.ciudades_list[data.ciudades[index].idCiudad]=data.ciudades[index].nameCiudad;
                                }

                                for (let index = 0; index < data.municipios.length; index++) {
                                    self.municipios_list[data.municipios[index].idMunicipio]=data.municipios[index].nameMunicipio;
                                }
                            }

                            $(self.e.currentTarget).removeClass('disabled');
                            app.alert.dismiss('loadingCheckCP');
                            $('#processingCheckCP').hide();
                            $('#codigoPostal').attr('style','');

                            self.flagClickModal=true;
                            self.render();
                            self.closeModalCheckCP();
                            self.openModalRecordCP();
                        }else{
                            $(self.e.currentTarget).removeClass('disabled');
                            app.alert.dismiss('loadingCheckCP');
                            $('#processingCheckCP').hide();

                            app.alert.show('invalid_cp', {
                                level: 'error',
                                autoClose: true,
                                messages: 'El C\u00F3digo Postal ingresado no existe'
                            });
                        }
                    
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
