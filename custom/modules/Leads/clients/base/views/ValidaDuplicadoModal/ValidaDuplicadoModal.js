/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',

    events: {
        'click #btn-cancel-save': 'closeModalCheckDuplicado',
        //'click #bbtn-guardar': 'assignedAccount',
    },

    initialize: function (options) {
        self_modal=this;
        
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:ValidaDuplicadoModal', function () {
                //obitene modelo
                var modelo=this.options.context.attributes.model;
                //Mandar petición solo cuando ya se han llenado todos los capos requeridos
                if(Object.keys(this.options.errors).length==0){
                    //Obteniendo teléfonos
                    var telefonos=[];
                    if(modelo.get('phone_mobile')!="" && modelo.get('phone_mobile')!=undefined){
                        telefonos.push(modelo.get('phone_mobile'));
                    }

                    if(modelo.get('phone_home')!="" && modelo.get('phone_home')!=undefined){
                        telefonos.push(modelo.get('phone_home'));
                    }

                    if(modelo.get('phone_work')!="" && modelo.get('phone_work')!=undefined){
                        telefonos.push(modelo.get('phone_work'));
                    }
                    var email="";
                    if(modelo.attributes.email !=undefined){
                        if(modelo.attributes.email.length>0){
                            email=modelo.attributes.email[0].email_address
                        }
                    }
                    //Parámetros para consumir servicio
                    /*
                    var params = {
                        'nombre': modelo.get('clean_name_c'),
                        'correo': email,
                        'telefonos': telefonos,
                        'rfc': "",
                    };
                    */
                    var params={
                        "nombre":"27 MICRAS INTERNACIONAL",
                        "correo":"GGONZALEZ@UNIFIN.COM.MX",
                        "telefonos":[
                            "12345643",
                            "323232344",
                            "5579389732"
                        ],
                        "rfc":""
                    };

                    var urlValidaDuplicados = app.api.buildURL("validaDuplicado", '', {}, {});
                    App.alert.show('obteniendoDuplicados', {
                        level: 'process',
                        title: 'Cargando',
                    });

                    app.api.call("create", urlValidaDuplicados, params, {
                        success: _.bind(function (data) {
                            App.alert.dismiss('obteniendoDuplicados');
                            if(data.code=='200'){
                                self_modal.duplicados=data.registros;
                            }
                            //formateando el nivel match
                            for (var property in self_modal.duplicados) {
                                self_modal.duplicados[property].nivelMatch= self_modal.duplicados[property].nivelMatch[0];
                            }
                            
                            self_modal.render();
                        }, this)
                    });

                    //this.render();
                }
                

            }, this);
        }
        this.bindDataChange();
    },

    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, { name: 'ValidaDuplicadoModal' }));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },

    closeModalCheckDuplicado: function () {

       this._disposeView();

    },

    _render: function () {
        this._super("_render");
    },
})
