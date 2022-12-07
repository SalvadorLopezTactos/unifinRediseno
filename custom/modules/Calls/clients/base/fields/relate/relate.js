({
     extendsFrom: 'RelateField',
     initialize: function(options) {
         this._super('initialize', [options]);
         this.hoy = new Date();
         this.hoy = this.hoy.getFullYear() + "-" + (this.hoy.getMonth()+1) + "-" + this.hoy.getDate();
     },

     openSelectDrawer: function() {
        var filterOptions = new app.utils.FilterOptions()
	      .config({
   	      'initial_filter': 'FilterCampana',
	        'initial_filter_label': 'Activas',
       	  'filter_populate': {
       	    'start_date': this.hoy,
       	    'end_date': this.hoy,
          }
        })
        .format();

        var filterOptionsAsigned = new app.utils.FilterOptions()
        .config({
            'initial_filter': 'filterActiveUsers',
            'initial_filter_label': 'LBL_ACTIVE_USER',
            'filter_populate': {
                'status': ['Active'],
            }
        })
        .format();
        //this custom code will effect for all relate fields in Enrollment module.But we need initial filter only for Courses relate field.
        filterOptions = (this.getSearchModule() == "Campaigns") ? filterOptions : this.getFilterOptions();
        filterOptions = (this.def.name == "assigned_user_name") ? filterOptionsAsigned : this.getFilterOptions();
        if(window.abre) {
          app.drawer.open({
               layout: 'selection-list',
               context: {
                   module: this.getSearchModule(),
                   fields: this.getSearchFields(),
                   filterOptions: filterOptions,
                   parent: this.context
               }
          }, _.bind(this.setValue, this));
          window.abre = 0;
        }
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