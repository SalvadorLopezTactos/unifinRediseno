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
 * @class View.Views.Base.PreviewHeaderView
 * @alias SUGAR.App.view.views.BasePreviewHeaderView
 * @extends View.View
 */
({
    className: 'preview-headerbar',

    events: {
        'click [data-direction]': 'triggerPagination',
        'click .preview-headerbar .closeSubdetail': 'triggerClose'
    },

    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.off("preview:pagination:update", null, this);
            this.layout.on("preview:pagination:update", this.render, this);
        }
    },

    triggerPagination: function(e) {
        var direction = this.$(e.currentTarget).data();
        this.layout.trigger("preview:pagination:fire", direction);
    },

    triggerClose: function() {
        app.events.trigger("list:preview:decorate", null, this);
        app.events.trigger("preview:close");
    }
})
