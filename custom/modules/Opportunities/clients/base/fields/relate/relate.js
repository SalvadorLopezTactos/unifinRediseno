/**
 * Created by Levementum on 5/4/2017.
 * User: jgarcia@levementum.com
 */

({

    extendsFrom: 'RelateField',
    initialize: function (opts) {
        this._super('initialize', [opts]);

        if(_.isUndefined(this.model.get("id"))) {
            if (this.name == "referenciador_c") {

                if(this.model.get("account_id")) {
                    this.referenciador();
                }

                this.model.on("change:account_id", _.bind(this.referenciador, this));
            }
        }

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

        return filterBeanClass.combineFilterDefinitions(filterDef, searchTermFilter);
    },

    openSelectDrawer: function () {

        if(this.name == "referenciador_c"){
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

    referenciador: function(){
        var id = this.model.get("account_id");
        var name = this.model.get("account_name");

        app.api.call("read", app.api.buildURL("Accounts/" + id, null, null, {}), null, {
            success: _.bind(function (data) {

                if (data != null) {
                    if (data.account_id_c != ''){
                        console.log('Entra a asignar referenciador: ' + data.account_id_c);
                        this.model.set("referenciada_c", true);
                        this.setValue({id: data.account_id_c});
                        this.setValue({value: data.referenciador_c})
                    }
                }
            }, this)
        });
    },

})
