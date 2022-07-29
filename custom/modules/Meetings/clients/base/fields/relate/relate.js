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
        //this custom code will effect for all relate fields in Enrollment module.But we need initial filter only for Courses relate field.
        filterOptions = (this.getSearchModule() == "Campaigns") ? filterOptions : this.getFilterOptions();
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
     }
})