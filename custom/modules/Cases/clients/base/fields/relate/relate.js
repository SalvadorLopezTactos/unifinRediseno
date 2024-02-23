 ({

    extendsFrom: 'RelateField',
    initialize: function (opts) {
        this._super('initialize', [opts]);

    },

    openSelectDrawer: function() {
        var filterOptions = new app.utils.FilterOptions()
        .config({
            'initial_filter': 'filterOppsRelatedToAccount',
            'initial_filter_label': 'LBL_FILTER_OPPS_RELATED_TO_ACCOUNT',
            'filter_populate': {
                'account_id': [this.model.get('account_id')],
                'estatus_c': ['K']
            }
        })
        .format();

        //this custom code will effect for all relate fields in Enrollment module.But we need initial filter only for Courses relate field.
        filterOptions = (this.getSearchModule() == "Opportunities") ? filterOptions : this.getFilterOptions();
        app.drawer.open({
            layout: 'selection-list',
            context: {
                module: this.getSearchModule(),
                fields: this.getSearchFields(),
                filterOptions: filterOptions,
            }
        }, _.bind(this.setValue, this));
    },

    buildFilterDefinition: function(searchTerm) {
        if (!app.metadata.getModule('Filters') || !this.filters) {
            return [];
        }

        var filterBeanClass = app.data.getBeanClass('Filters').prototype,
            filterOptions = this.getFilterOptions() || {},
            filter = this.filters.collection.get(filterOptions.initial_filter),
            filterDef,
            populate,
            searchTermFilter,
            searchModule;

        if (filter) {
            populate = filter.get('is_template') && filterOptions.filter_populate;
            filterDef = filterBeanClass.populateFilterDefinition(filter.get('filter_definition') || {}, populate);
            searchModule = filter.moduleName;
        }

        searchTermFilter = filterBeanClass.buildSearchTermFilter(searchModule || this.getSearchModule(), searchTerm);

        if(this.def.name == "assigned_user_name"){
            searchTermFilter.push({
                'status':{
                    '$in': ['Active'],
                }
            })
        }

        return filterBeanClass.combineFilterDefinitions(filterDef, searchTermFilter);
    },

})
