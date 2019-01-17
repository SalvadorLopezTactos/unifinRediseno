({
    /**
     * Created by Salvador Lopez 17/01/2019.
     * salvador.lopez@tactos.com.mx
     */
    extendsFrom: 'FilterLayout',

    selectFilter: function(filterId) {
        var possibleFilters,
            selectedFilterId = filterId;

        if (selectedFilterId !== 'create') {
            possibleFilters = [selectedFilterId, this.filters.collection.defaultFilterFromMeta, 'all_records'];
            possibleFilters = _.filter(possibleFilters, this.filters.collection.get, this.filters.collection);
            selectedFilterId = _.first(possibleFilters);
        }
        this.trigger('filter:render:filter');
        this.trigger('filter:select:filter', selectedFilterId);

        if(this.module=='Accounts' && this.filters.collection._byId[selectedFilterId].get('name')=='Mis Cuentas'){
            $('.select2-container.select2.search-filter').css("pointer-events", "none");
        }

        return selectedFilterId;
    },
})
