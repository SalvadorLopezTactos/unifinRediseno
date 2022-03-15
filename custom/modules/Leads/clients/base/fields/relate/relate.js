/**
 * Created by Adrian Arauz.
 */

 ({

    extendsFrom: 'RelateField',
    initialize: function (opts) {
        this._super('initialize', [opts]);

    },

    openSelectDrawer: function() {
        console.log("Entra validacion para asignar filtro VENDORS al campo Referido.");
        var filterOptions = new app.utils.FilterOptions()
        .config({
            'initial_filter': 'VendorFilter',
            'initial_filter_label': 'LBL_VENDOR_FILTER',
            'filter_populate': {
                'accounts': this.model.get('referido_cliente_prov_c'),
            }
        })
        .format();
        //this custom code will effect for all relate fields in Enrollment module.But we need initial filter only for Courses relate field.
        filterOptions = (this.getSearchModule() == "Accounts") ? filterOptions : this.getFilterOptions();
        app.drawer.open({
            layout: 'selection-list',
            context: {
                module: this.getSearchModule(),
                fields: this.getSearchFields(),
                filterOptions: filterOptions,
            }
        }, _.bind(this.setValue, this));
    },

})
