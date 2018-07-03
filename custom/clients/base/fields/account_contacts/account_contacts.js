/**
 * Created by Jorge on 7/14/2015.
 */

({
    events: {
        'change .newPMPrimerNombre': '_addNewContactoToModel',
        'change .newPMSegundoNombre': '_addNewContactoToModel',
        'change .newPMApellidoPaterno': '_addNewContactoToModel',
        'change .newPMApellidoMaterno': '_addNewContactoToModel',
        'change .newPMEmail': '_addNewContactoToModel',
        'change .newPMEmail': 'checkEmailFormat',
        'change .newPMTelefono': '_addNewContactoToModel',
        'keydown .newPMTelefono': 'keyDownNewExtension',
    },

    plugins: ['Tooltip', 'ListEditable', 'EmailClientLaunch'],

    initialize: function (options) {

        self = this;
        options = options || {};
        options.def = options.def || {};

        this._super('initialize', [options]);

        //this.model.addValidationTask('check_required_fields', _.bind(this._doValidateRequieredFields, this));
        this.model.addValidationTask('check_email_format', _.bind(this._doValidateEmailFormat, this));
    },

    /**
     * When data changes, re-render the field only if it is not on edit (see MAR-1617).
     * @inheritdoc
     */
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    _addNewContactoToModel: function (contacto) {
        this.model.set('account_contacts', []);
        //console.log(this.model.get('account_contacts'));
        var existingContactos = app.utils.deepCopy(this.model.get('account_contacts'));
        //console.log(existingContactos);
        existingContactos.push({
            primerNombre: $('.newPMPrimerNombre').val(),
            segundoNombre: $('.newPMSegundoNombre').val(),
            apellidoPaterno: $('.newPMApellidoPaterno').val(),
            apellidoMaterno: $('.newPMApellidoMaterno').val(),
            emailContacto: $('.newPMEmail').val(),
            telefonoContacto: $('.newPMTelefono').val()
        });
        this.model.set(this.name, existingContactos);
        success = true;

        return success;
    },
    
    _updateExistingContactoInModel: function (index, newContacto, field_name) {
        var existingContactos = app.utils.deepCopy(this.model.get('account_contacts'));
        //Simply update the email address
        existingContactos[index][field_name] = newContacto;
        this.model.set(this.name, existingContactos);
    },

    _doValidateRequieredFields: function (fields, errors, callback){

        if(this.model.get('tipodepersona_c') == 'Persona Moral') {
            app.api.call("read", app.api.buildURL("Accounts/" + this.model.get('id') + "/link/rel_relaciones_accounts_1", null, null, {
                fields: name,
            }), null, {
                success: _.bind(function (data) {
                    var ContacFlag = false;
                    if (data.records.length > 0) {
                        $(data.records).each(function (index, value) {
                            if($.inArray("Contacto",value.relaciones_activas) > -1){
                                //Ya hay un contacto relacionado !!!!
                                ContacFlag = true;
                            }
                        });
                    }
                    if (ContacFlag == false) {
                        if (_.isEmpty($('.newPMPrimerNombre').val())) {
                            var alertOptions = {
                                title: "Primer Nombre en la Seccion de Contacto Relacionado es requerido",
                                level: "error"
                            };
                            app.alert.show('validation', alertOptions);
                            errors['account_contacts'] = errors['account_contacts'] || {};
                            errors['account_contacts'].required = true;
                        }
                        if (_.isEmpty($('.newPMApellidoPaterno').val())) {
                            var alertOptions = {
                                title: "Apellido Paterno en la Seccion de Contacto Relacionado es requerido",
                                level: "error"
                            };
                            app.alert.show('validation', alertOptions);
                            errors['account_contacts'] = errors['account_contacts'] || {};
                            errors['account_contacts'].required = true;
                        }
                    }
                }, this) 
            });
        }
        this.primerNombre = $('.newPMPrimerNombre').val();
        this.segundoNombre = $('.newPMSegundoNombre').val();
        this.apellidoPaterno = $('.newPMApellidoPaterno').val();
        this.apellidoMaterno = $('.newPMApellidoMaterno').val();
        this.emailContacto = $('.newPMEmail').val();
        this.telefonoContacto = $('.newPMTelefono').val();
        this._addNewContactoToModel();
        callback(null, fields, errors);
    },

    keyDownNewExtension: function (evt) {
        if (!evt) return;
        if(!this.checkNumOnly(evt)){
            return false;
        }

    },

    checkNumOnly:function(evt){
        if($.inArray(evt.keyCode,[110,188,190,45,33,36,46,35,34,8,9,20,16,17,37,40,39,38,16,49,50,51,52,53,54,55,56,57,48,96,97,98,99,100,101,102,103,104,105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Solo numeros son permitido en este campo.",
                autoClose: true
            });
            return false;
        }else{
            return true;
        }
    },

    checkEmailFormat:function(){
    	if ($('.newPMEmail').length > 0){
    		//console.log('Entro a validacion de e-mail' + $('.newPMEmail').length);
			//console.log($('.newPMEmail').val());
	        email = $('.newPMEmail').val();
	        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	        //console.log(emailReg.test(email));

	        if(emailReg.test(email) == false){
	            app.alert.show("Email Invalido", {
	                level: "error",
	                title: "Email Invalido.",
	                autoClose: true
	            });
	        }
	        return emailReg.test(email);	
		}else{
			//console.log('Sin correo de coontacto que validar');
			return true;
		}
    },

    _doValidateEmailFormat: function(fields, errors, callback){
        var validFormat = this.checkEmailFormat();

        if(validFormat == false){
            app.alert.show("Email Invalido", {
                level: "error",
                title: "Email Invalido.",
                autoClose: true
            });
            errors['account_contacts'] = errors['account_contacts'] || {};
            errors['account_contacts'].required = true;
        }
        this.primerNombre = $('.newPMPrimerNombre').val();
        this.segundoNombre = $('.newPMSegundoNombre').val();
        this.apellidoPaterno = $('.newPMApellidoPaterno').val();
        this.apellidoMaterno = $('.newPMApellidoMaterno').val();
        this.emailContacto = $('.newPMEmail').val();
        this.telefonoContacto = $('.newPMTelefono').val();
        this._addNewContactoToModel();
        callback(null, fields, errors);
    },
//Relacion account_contacts
})