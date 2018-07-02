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
({
    extendsFrom: 'HelpDashletView',

    /**
     * @override
     *
     * We also add the forecast_by module to the context, that we are passing in, so we can have a dynamic name for
     * for when we are using the help dashlet on the forecast module
     */
    getHelpObject: function() {
        var config = app.metadata.getModule('Forecasts', 'config'),
            helpUrl = {
                forecastby_singular_module: app.lang.getModuleName(config.forecast_by),
                forecastby_module: app.lang.getModuleName(config.forecast_by, {plural: true}),
                more_info_url: this.createMoreHelpLink(),
                more_info_url_close: '</a>'
            },
            ctx = this.context && this.context.parent || this.context,
            layout = (this.meta.preview) ? 'preview' : ctx.get('layout');

        this.helpObject = app.help.get(ctx.get('module'), layout, helpUrl);

        // if title is empty for some reason, use the dashlet label as the fallback
        if (_.isEmpty(this.helpObject.title)) {
            this.helpObject.title = app.lang.get(this.meta.label);
        }
    }
})
