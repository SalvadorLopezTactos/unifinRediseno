({
    initialize: function (options) {

        selfDisposiciones = this;
        options = options || {};
        options.def = options.def || {};

        this._super('initialize', [options]);
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

})