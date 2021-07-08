/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',

    events: {
        'click #btn-cancel-save': 'closeModalCheckDuplicado',
        'click #btn-guardar': 'omiteMatchGuardaRegistro',
        'click .closeModalDuplicadosLead': 'closeModalDuplicadosLead'
    },

    initialize: function (options) {
        self_modal=this;
        
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:ValidaDuplicadoModal', function () {
                //obtiene modelo
                var modelo=this.options.context.attributes.model;
                var array_coincidencias=[];
                //Mandar petición solo cuando ya se han llenado todos los capos requeridos
                if(Object.keys(this.options.registros).length>0){
                    self_modal.duplicados=this.options.registros;
                    //Omitir match, Guardar
                    //Se recorren todos los registros para saber si existe al menos una coincidencia del 100%
                    //formateando el nivel match
                    for (var property in self_modal.duplicados) {
                        array_coincidencias.push(self.duplicados[property].coincidencia);
                    }
                    self_modal.textoBotonGuardar="Omitir match, Guardar";
                    
                    if(array_coincidencias.includes('100')){
                        self_modal.textoBotonGuardar="Es homónimo, Guardar";
                    }

                    this.render();
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
       self_modal.options.context.trigger('button:cancel_button:click');

    },

    omiteMatchGuardaRegistro:function(){
        //self_modal.options.context.attributes.model.save();
        //Se agrega este atributo para identificar del lado del validationTask de Leads y 
        //no se ejecute la petición al servicio de duplicado nuevamente
        self_modal.options.context.flagGuardar="1";
        if(self_modal.textoBotonGuardar=="Es homónimo, Guardar"){
            self_modal.model.set('homonimo_c',1);
        }else{
            self_modal.model.set('omite_match_c',1);
        }
        self_modal.options.context.trigger('button:save_button:click');
    },

    closeModalDuplicadosLead:function(){
        this._disposeView();
    },

    _render: function () {
        this._super("_render");
    },
})
