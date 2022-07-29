/**
     * The file used to handle action of survey submission filtered list based on survey referred 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */
/**
 * Layout for filtering a collection.
 * @class View.Layouts.Base.bc_survey_submissionFilterLayout
 * @alias SUGAR.App.view.layouts.BaseFilterLayout
 * @extends View.Layouts.Base.FilterLayout
 */
({
    extendsFrom: 'FilterLayout',
    initialize: function (options) {
        this._super('initialize', [options]);
        this.listenTo(this.layout,'filter:change:filter', this.handleFilterChange, this);
    },

    /**
     * @inheritdoc
     */
    handleFilterChange: function (id) {
        this.layout.setLastFilter(this.layout.layout.currentModule, this.layout.layoutType, id);

        var filter, editState = this.layout.retrieveFilterEditState();
        // Figure out if we have an edit state. This would mean user was editing the filter so we want him to retrieve
        // the filter form in the state he left it.
        filter = this.layout.filters.collection.get(id) || app.data.createBean('Filters', {module_name: this.layout.moduleName});
        if (editState && (editState.id === id || (id === 'create' && !editState.id))) {
            filter.set(editState);
        } else {
            
            editState = false;
        }

        this.layout.context.set('currentFilterId', filter.get('id'));

        var editable = filter.get('editable') !== false;

        // If the user selects a filter that has an incomplete filter
        // definition (i.e. filter definition != filter_template), open the
        // filterpanel to indicate it is ready for further editing.
        var isIncompleteFilter = filter.get('filter_template') &&
                JSON.stringify(filter.get('filter_definition')) !== JSON.stringify(filter.get('filter_template'));

        // If the user selects a filter template that gets populated by values
        // passed in the context/metadata, open the filterpanel to show the
        // actual search.
        var isTemplateFilter = filter.get('is_template');

        var modelHasChanged = !_.isEmpty(filter.changedAttributes(filter.getSynced()));

        if (editable &&
                (isIncompleteFilter || isTemplateFilter || editState || id === 'create' || modelHasChanged)
                ) {
            this.layout.layout.trigger('filter:set:name', '');
            this.trigger('filter:create:open', filter);
            this.layout.layout.trigger('filter:toggle:savestate', true);
        } else {
            // FIXME: TY-1457 should improve this
            this.context.editingFilter = null;
            this.layout.layout.trigger('filter:create:close');
        }

        var ctxList = this.layout.getRelevantContextList();
        var clear = false;
        //Determine if we need to clear the collections
        _.each(ctxList, function (ctx) {
            var filterDef = filter.get('filter_definition');
            
            // Override Survey id Filter to show referred survey transactions only
            if (localStorage['survey_id']) {
                filterDef[0] = {};
                filterDef[0]["bc_survey_submission_bc_surveybc_survey_ida"] = {};
                filterDef[0]["bc_survey_submission_bc_surveybc_survey_ida"]["$in"] = {};
                filterDef[0]["bc_survey_submission_bc_surveybc_survey_ida"]["$in"][0] = localStorage['survey_id'];
            
                delete localStorage['survey_id'];
            }
            var orig = ctx.get('collection').origFilterDef;
            ctx.get('collection').origFilterDef = filterDef;  //Set new filter def on each collection
            
            clear = true; // re call the filter
            
        });
        //If so, reset collections and trigger quicksearch to repopulate
        if (clear) {
            _.each(ctxList, function (ctx) {
                ctx.get('collection').resetPagination();
                // Silently reset the collection otherwise the view is re-rendered.
                // It will be re-rendered on request response.
                ctx.get('collection').reset(null, {silent: true});
            });
            this.layout.trigger('filter:apply');
        }
    },
})
