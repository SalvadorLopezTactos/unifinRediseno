/**
 * Created by Levementum on 5/4/2017.
 * User: jgarcia@levementum.com
 */

({

    extendsFrom: 'RelateField',
    initialize: function (opts) {
        this._super('initialize', [opts]);

    },

    buildFilterDefinition: function (searchTerm) {
        if (!app.metadata.getModule('Filters') || !this.filters) {
            return [];
        }
        var filterBeanClass = app.data.getBeanClass('Filters').prototype, filterOptions = this.getFilterOptions() || {},
            filter = this.filters.collection.get(filterOptions.initial_filter), filterDef, populate, searchTermFilter,
            searchModule;
        if (filter) {
            populate = filter.get('is_template') && filterOptions.filter_populate;
            filterDef = filterBeanClass.populateFilterDefinition(filter.get('filter_definition') || {}, populate);
            searchModule = filter.moduleName;
        }

        searchTermFilter = filterBeanClass.buildSearchTermFilter(searchModule || this.getSearchModule(), searchTerm);

        if(this.name == "referenciador_c"){
            searchTermFilter.push({
                'es_referenciador_c':{
                    '$equals': 1,
                }
            })
        }

        if(this.name == "asignar_a_promotor"){
            var productos_label = app.lang.getAppListStrings('tipo_producto_list');
            var producto = $("#Productos").val();

            if(!_.isEmpty(producto)) {
                var producto_filtrado = [];

                _.each(productos_label, function (value, key) {
                    if (value == producto) {
                        producto_filtrado.push(key);
                    }
                });

                searchTermFilter.push({
                    'productos_c': {
                        '$contains': producto_filtrado,
                    }
                })
            }
        }

        if(this.name == "users_accounts_1_name"){
            var producto = $("#Productos").val();
            if(!_.isEmpty(producto)) {
                searchTermFilter[0].$and[0].status.$not_equals = "";
            }
        }

        return filterBeanClass.combineFilterDefinitions(filterDef, searchTermFilter);
    },

    openSelectDrawer: function () {

        if(this.name == "referenciador_c" || this.name == "asignar_a_promotor"){
            return;
        }

        app.drawer.open({
            layout: 'selection-list',
            context: {
                module: this.getSearchModule(),
                fields: this.getSearchFields(),
                filterOptions: this.getFilterOptions()
            }
        }, _.bind(this.setValue, this));
    },

})
