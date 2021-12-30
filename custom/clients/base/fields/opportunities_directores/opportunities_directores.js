/**
 * Created by salvadorlopez on 01/09/20.
 */
({
    events: {
        'change select.director_solicitud': 'setInfoDirector'
    },

    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        cont_tel = this;
        this._super('initialize', [options]);

        //this.setDirectores();
        this.model.on('data:sync:complete', this.setDirectores, this);

    },

    setDirectores:function () {
        var self=this;

        //var id_usuario="cdf63b76-233b-11e8-a1ec-00155d967307";
        var id_usuario=this.model.get('assigned_user_id');
        if(id_usuario != null && id_usuario!= undefined && id_usuario!=""){

            app.api.call('GET', app.api.buildURL('GetBossLeasing/' + id_usuario), null, {
                success: _.bind(function (data) {

                    if (data != "") {
                        var directores_list=[];
                        if(data.length>0){
                            //Añadiendo valor vacio para obligar que se ejecute evento change del director de solicitud
                            directores_list.push({"id": "","text": ""});
                            for(var i=0;i<data.length;i++){
                                //directores_list[{"id": data[i].id,"text": data[i].name}];
                                directores_list.push({"id": data[i].id,"text": data[i].name});
                            }
                            //Establecer nuevas opciones al campo de director
                            //this.model.fields['director_seleccionado_c'].options = directores_list;
                            self.directores_list=directores_list;
                            self.render();
                        }

                    }

                }, self),
            });

        }

    },

    setInfoDirector: function (evt) {
        var idDirector=$(evt.currentTarget).val();
        var nombreDirector=$( "select.director_solicitud option:selected" ).text();
        if(idDirector!=""){
            this.model.set("director_solicitud_c",idDirector+","+nombreDirector);
        }
    },

    /**
     * When data changes, re-render the field only if it is not on edit (see MAR-1617).
     * @inheritdoc
     */
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
            }
        }, this);
    },

    _render: function () {
        //Obteniendo valor de campo auxiliar que guarda informacion del director
        var infoDirector=this.model.get('director_solicitud_c');
        var producto = this.model.get('tipo_producto_c');
        var negocio = this.model.get('negocio_c');
        if(infoDirector!=null && infoDirector!=""){
            var res = infoDirector.split(",");
            this.directorSolicitud=res[1];
            this.directorSolicitudId=res[0];
        }else{
            this.directorSolicitud="";
        }


        if(this.view.action!="create"){
            if(this.model.get('tipo_producto_c')!=undefined){
                var producto = this.model.get('tipo_producto_c');
                var negocio = this.model.get('negocio_c');
                var prod_financiero=this.model.get('producto_financiero_c');
                var precalif_L=false;
                var precalif_CS=false;

                precalif_L=(producto == '1' && negocio == '5' && (prod_financiero == '' || prod_financiero == '0'))? true : false;
                precalif_CS=(producto=="2" && (negocio!="2" && negocio!="10"))? true : false;

                
                if(!precalif_L && !precalif_CS){ //Tipo 1 = LEASING Y CS
                    $('[data-type="opportunities_directores"]').hide();
                }else{
                    if (this.model.get('tct_etapa_ddw_c')=="SI" && this.model.get('estatus_c')=="") {
                        $('[data-type="opportunities_directores"]').hide();
                    }else if(typeof banderaExcluye !="undefined"){
                        if(banderaExcluye.check.includes(1)){
                            $('[data-type="opportunities_directores"]').hide();
                        }    
                    }
                    else{
                        $('[data-type="opportunities_directores"]').show();
                    }
                }
            }

        }


        if(this.model.get("vobo_dir_c")==true){
            $('[data-type="opportunities_directores"]').attr('style', 'pointer-events:none;');
        }


        this._super("_render");

        $('#director_solicitud').select2({width: '400px'});

    },

})
