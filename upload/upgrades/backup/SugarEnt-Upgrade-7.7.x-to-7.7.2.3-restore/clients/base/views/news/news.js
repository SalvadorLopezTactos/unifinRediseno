/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Views.Base.NewsView
 * @alias SUGAR.App.view.views.BaseNewsView
 * @extends View.View
 */
({
    plugins: ['Dashlet'],
    initDashlet: function() {
        if(this.meta.config) {
            var limit = this.settings.get("limit") || "5";
            this.settings.set("limit", limit);
        }
        this.model.on("change:name", this.loadData, this);
    },
    loadData: function (options) {
        var name, limit;

        if(_.isUndefined(this.model)){
            return;
        }
        var name = this.model.get("account_name") || this.model.get('name') || this.model.get('full_name'),
            limit = parseInt(this.settings.get('limit') || 5, 10);
        if (_.isEmpty(name)) {
            return;
        }
        $.ajax({
            url: 'https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=' +
                name.toLowerCase() + '&rsz=' + limit,
            dataType: 'jsonp',
            success: function (data) {
                if (this.disposed) {
                    return;
                }
                _.extend(this, data);
                this.render();
            },
            context: this,
            complete: options ? options.complete : null
        });
    }
})
