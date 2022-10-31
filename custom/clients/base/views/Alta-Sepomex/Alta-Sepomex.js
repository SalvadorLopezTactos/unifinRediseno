({

    className: 'Alta-Sepomex',

    events: {
        'click .openModalCheckCP': 'openModalCheckCP',
        'click .closemodalCheckCP': 'closeModalCheckCP',
        'click .cancelCheckCP': 'cancelCheckCP',
        'click .checkNacExt':'setCheckNacionalExt',
        'click .continueCheckCP':'continueCheckCP',
        'click .cancelSaveRecord':'cancelSaveRecord',
        'click .saveRecordCP':'saveRecordCP',
    },

    flagClickModal:null,

    initialize: function(options){
        this._super("initialize", [options]);
        self=this;
        this.paises_list=App.lang.getAppListStrings('paises_list');
        //Eliminando la opción de México, ya que es un registro extranjero
        Object.keys(this.paises_list).forEach(function (key) {
            if (key == "2") {
                delete self.paises_list[key];
            }
        });

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
        // ToDO: Antes de mostrar el modal previo, mostrar advertencia en caso de que algún campo contenga valor y no se han guardado los cambios
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
        //self=this;
        if(cpValue==""){
            app.alert.show('errorCP', {
                level: 'error',
                messages: 'Favor de ingresar un Código Postal',
                autoClose: true
            });
            $('#codigoPostal').attr('style','border:1px solid red;');
            return;
        }else{
            if(this.nacionalidad=="nacional"){
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

            }else{//else para dirección extranjera
                self.isNational=false;
                self.flagClickModal=true;
                self.render();
                self.closeModalCheckCP();
                self.openModalRecordCP();
            }
        }
    },

    saveRecordCP:function(e){

        //Se valida si el CP es nacional, ya que los registros nacionales se obtienen a través de "selects" y las extranjeras son "inputs"
        if(this.isNational){
            var cp=$('#codigoPostalSave').val();
            var pais=$('#paisRecord').attr('data-id');
            var labelPais=$('#paisRecord').val();
            var estado=$('#estado').val();
            var labelEstado=$('#estado option:selected').text();
            var ciudad=$('#ciudad').val();
            var labelCiudad=$('#ciudad option:selected').text();
            var municipio=$('#municipio').val();
            var labelMunicipio=$('#municipio option:selected').text();
            var colonia=$('#colonia').val().trim();
        }else{
            var cp=$('#codigoPostalSave').val();
            var pais=$('#paisRecord option:selected').val();
            var labelPais=$('#paisRecord option:selected').text();
            var estado='';
            var labelEstado=$('#estado').val().trim();
            var ciudad='';
            var labelCiudad=$('#ciudad').val().trim();
            var municipio='';
            var labelMunicipio=$('#municipio').val().trim();
            var colonia=$('#colonia').val().trim().trim();
        }
        

        var body={
            "cp":cp,
            "pais":pais,
            "labelPais":labelPais,
            "estado":estado,
            "labelEstado":labelEstado,
            "ciudad":ciudad,
            "labelCiudad":labelCiudad,
            "municipio":municipio,
            "labelMunicipio":labelMunicipio,
            //"colonia":colonia, únicamente se inserta la etiqueta, ya que el id no se conoce
            "labelColonia":colonia
        }

        var url=app.api.buildURL("CheckSaveSepomex", '', {}, {});

        //Al ser nacional solo se valida la Colonia, ya que los otros campos vienen pre llenos
        if(this.isNational){
            if(colonia !=""){
                $('#processingSaveCheckCP').show();
                $(e.currentTarget).addClass('disabled');
    
                app.api.call('create', url, body,{
                    success: function (data){
                        if(data.result=='error'){
                            app.alert.show('errorSaveSepomex', {
                                level: 'error',
                                messages: data.msg,
                                autoClose: true
                            });
                        }else{
                            app.alert.show('successSaveSepomex', {
                                level: 'success',
                                messages: data.msg,
                                autoClose: true
                            });
    
                            App.router.navigate('#dir_Sepomex', {trigger:true});
                        }
    
                        $('#processingSaveCheckCP').hide();
                        $(e.currentTarget).removeClass('disabled');
    
                    }
                });
    
            }else{
                app.alert.show('errorColonia', {
                    level: 'error',
                    messages: 'Favor de ingresar Colonia',
                    autoClose: true
                });
                $('#colonia').attr('style','border:1px solid red;');
            }
        }else{//Else para extranjero y validar todos los campos vacíos
            var inputs=$('.formField');
            var fieldsNoFill=[];
            for (let index = 0; index < inputs.length; index++) {
                if(index==0 && inputs.eq(index).val() != ""){//El primer índice corresponde al código postal
                    var cp_value=inputs.eq(index).val();
                    var str_length = cp_value.length;
                    //Valida formato
                    var pattern = /^\d+$/;
                    var isNumber = pattern.test(cp_value);
                    if (str_length == 5 && isNumber){

                    }else{
                        app.alert.show('invalid_cp', {
                            level: 'error',
                            autoClose: true,
                            messages: 'C\u00F3digo Postal inv\u00E1lido'
                        });
                    }
                }

                if(inputs.eq(index).val() ==""){
                    fieldsNoFill.push('1');
                }else{
                    fieldsNoFill.push('0');
                }
            }

            if(fieldsNoFill.includes('1')){
                app.alert.show('invalid_cp', {
                    level: 'error',
                    autoClose: true,
                    messages: 'Favor de llenar todos los campos'
                });
                

            }else{
                //Guardar dirección
                $('#processingSaveCheckCP').show();
                $(e.currentTarget).addClass('disabled');
                app.api.call('create', url, body,{
                    success: function (data){
                        if(data.result=='error'){
                            app.alert.show('errorSaveSepomex', {
                                level: 'error',
                                messages: data.msg,
                                autoClose: true
                            });
                        }else{
                            app.alert.show('successSaveSepomex', {
                                level: 'success',
                                messages: data.msg,
                                autoClose: true
                            });
    
                            App.router.navigate('#dir_Sepomex', {trigger:true});
                        }
    
                        $('#processingSaveCheckCP').hide();
                        $(e.currentTarget).removeClass('disabled');
    
                    }
                });

            }

        }

    }
})
