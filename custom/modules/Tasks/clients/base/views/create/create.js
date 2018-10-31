({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.on('render',this.disableparentsfields,this);
        this.model.addValidationTask('checkdate', _.bind(this.checkdate, this));
    },

    _render: function () {
        this._super("_render");


    },



    /* @Alvador Lopez Y Adrian Arauz
    Oculta los campos relacionados
    */
    disableparentsfields:function () {
        if(this.createMode){//Evalua si es la vista de creacion
            if(this.model.get('parent_id')!=undefined){
                this.$('[data-name="parent_name"]').attr('style','pointer-events:none;')
            }
        }
    },

    checkdate: function (fields, errors, callback) {
        var start_date = new Date(this.model.get('date_start'));
        var due_date = new Date(this.model.get('date_due'));
        var now = new Date();
        if(start_date<now ){
            app.alert.show("start_invalid", {
                level: "error",
                title: "La fecha de inicio no puede ser menor al d\u00EDa de hoy",
                autoClose: false
            });
            errors['date_start'] = errors['date_start'] || {};
            errors['date_start'].datetime = true;
        }
        if(due_date<now ){
            app.alert.show("due_invalid", {
                level: "error",
                title: "La fecha de vencimiento no puede ser menor al d\u00EDa de hoy",
                autoClose: false
            });
            errors['date_due'] = errors['date_due'] || {};
            errors['date_due'].datetime = true;
        }
        callback(null,fields,errors);
    },

})