
({
    extendsFrom: 'EmailsCreateView',
    
    _render: function (fields, errors, callback) {
        this._super("_render");

    },

    initialize: function (options) {
        self = this;
        contexto_mail = this;
        this._super("initialize", [options]);

        this.context.on('button:send_button:click', this.check_correo_valido, this);
        //this.model.addValidationTask('check_correo_valido', _.bind(this.check_correo_valido, this));
    },

    check_correo_valido:function () {

        if (this.model.get('parent').type == "Accounts") {

            var puesto_usuario = App.user.attributes.puestousuario_c;
            var estatusCuenta = self.model.attributes.parent.tipo_registro_cuenta_c
            var idUsuarioLogeado = App.user.attributes.id;
            var reus = false;
            var emailREUS = false;
            var idCuenta = this.model.get('parent').id;

            var data = [];
            var to = null;
            var cc = null;
            var cco = null;

            var aux = null;
            for (var i = 0; i < self.model.attributes.to_collection.models.length; i++) {
                aux = null;
                if (self.model.attributes.to_collection.models[i].attributes.parent_type != undefined) {
                    aux = {
                        "tipo" : "to" , 
                        "email" : "" , 
                        "modulo": self.model.attributes.to_collection.models[i].attributes.parent_type , 
                        "id" : self.model.attributes.to_collection.models[0].attributes.id 
                    };
                }else{
                    aux = {
                        "tipo" : "to" , 
                        "email" :  self.model.attributes.to_collection.models[i].attributes.email_address , 
                        "modulo": "" , 
                        "id" : "" 
                    };
                }
                data.push(aux);
            }

            for (var i = 0; i < self.model.attributes.cc_collection.models.length; i++) {
                aux = null;
                if (self.model.attributes.cc_collection.models[i].attributes.parent_type != undefined) {
                    aux = {
                        "tipo" : "cc" , 
                        "email" : "" , 
                        "modulo": self.model.attributes.cc_collection.models[i].attributes.parent_type , 
                        "id" : self.model.attributes.cc_collection.models[0].attributes.id 
                    };
                }else{
                    aux = {
                        "tipo" : "cc" , 
                        "email" :  self.model.attributes.cc_collection.models[i].attributes.email_address , 
                        "modulo": "" , 
                        "id" : "" 
                    };
                }
                data.push(aux);
            }

            for (var i = 0; i < self.model.attributes.bcc_collection.models.length; i++) {
                aux = null;
                if (self.model.attributes.bcc_collection.models[i].attributes.parent_type != undefined) {
                    aux = {
                        "tipo" : "bcc" , 
                        "email" : "" , 
                        "modulo": self.model.attributes.bcc_collection.models[i].attributes.parent_type , 
                        "id" : self.model.attributes.bcc_collection.models[0].attributes.id 
                    };
                }else{
                    aux = {
                        "tipo" : "bcc" , 
                        "email" :  self.model.attributes.bcc_collection.models[i].attributes.email_address , 
                        "modulo": "" , 
                        "id" : "" 
                    };
                }
                data.push(aux);
            }
             console.log(data);
            
            app.api.call('GET', app.api.buildURL('emailReus/'  ), null, {
                success: _.bind(function (data) {
                    alert("Asincorno");
                    if (data == true) {
                        alert("va bien - 2");
                    } 
                }, this),
            });
            alert("va bien");
        } 
    },
       
})
