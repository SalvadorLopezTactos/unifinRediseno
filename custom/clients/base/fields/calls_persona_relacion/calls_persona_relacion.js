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
        this._super('initialize', [options]);

    },

    _render: function () {
        this._super("_render");
        //this.hidePErsonaEdit();
        this.model.get('persona_relacion_c');
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
            }
        }, this);
    },

    getidPersona: function () {
        var idUserRel = $('#personasRel').val();
        this.model.set('persona_relacion_c', idUserRel);
    },





})