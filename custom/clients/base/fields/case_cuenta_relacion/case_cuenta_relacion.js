({
    events: {
        'change #personasRel': 'getidPersona',
    },
    personasRel_list: null,
    nombrePersona: null,
    personasRelData_list: null,
    namePErson: null,
    initialize: function (options) {
        options = options || {};
        options.def = options.def || {};
        selfPerson = this;
        //selfPerson.seleccionado = (this.model.attributes.contacto_principal_c != '') ? this.model.attributes.contacto_principal_c : '';
        this._super('initialize', [options]);

    },

    _render: function () {
        this._super("_render");
        //this.hidePErsonaEdit();
        this.model.get('contacto_principal_c');
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
            }
        }, this);
    },

    getidPersona: function () {
        var idUserRel = $('#personasRel').val();
        var nameUserRel = $("#personasRel option:selected").text();
        this.model.set('account_id_c', idUserRel);
        this.model.set('contacto_principal_c', nameUserRel);
        selfPerson.seleccionado = nameUserRel;
        //this.model.set('contacto_principal_c', selfPerson.seleccionado);
    },

})
