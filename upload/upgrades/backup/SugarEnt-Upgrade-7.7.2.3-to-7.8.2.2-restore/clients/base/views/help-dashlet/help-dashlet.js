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
 * @class View.Views.Base.HelpDashletView
 * @alias SUGAR.App.view.views.BaseHelpDashletView
 * @extends View.View
 *
 * @deprecated Since 7.7. Will be removed in 7.9.
 */
({
    plugins: ['Dashlet'],

    /**
     * Holds the Object returned by app.help.get()
     * <pre><code>
     * {
     *    title: '',
     *    body: '',
     *    more_help: ''
     * }
     * </code></pre>
     * @type {Object}
     */
    helpObject: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        app.logger.warn('View.Views.Base.HelpDashletView is deprecated since 7.7. Will be removed in 7.9.');

        this.getHelpObject();
    },

    /**
     * Method to fetch the help object from the app.help utility
     */
    getHelpObject: function() {
        var helpUrl = {
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
    },

    /**
     * @inheritdoc
     */
    initDashlet: function() {
        this.settings.set({
            label: this.helpObject.title
        });
    },

    /**
     * @inheritdoc
     */
    getLabel: function() {
        return this.helpObject.title;
    },

    /**
     * Collects server version, language, module, and route and returns an HTML link to be used
     * in the template
     *
     * @return {string} The HTML a-tag for the More Help link
     */
    createMoreHelpLink: function() {
        var serverInfo = app.metadata.getServerInfo(),
            lang = app.lang.getLanguage(),
            module = app.controller.context.get('module'),
            route = this.context.get('layout');

        if (route == 'records') {
            route = 'list';
        }

        var url = 'http://www.sugarcrm.com/crm/product_doc.php?edition=' + serverInfo.flavor
            + '&version=' + serverInfo.version + '&lang=' + lang + '&module=' + module + '&route=' + route;
        if (route == 'bwc') {
            var action = window.location.hash.match(/#bwc.*action=(\w*)/i);
            if (action && !_.isUndefined(action[1])) {
                url += '&action=' + action[1];
            }
        }

        return '<a href="' + url + '" target="_blank">';
    },

    /**
     * @inheritdoc
     *
     * Overriding to pass this.helpObject as the template model to use,
     * and this.options in case templateOptions get passed down
     */
    _renderHtml: function() {
        this._super('_renderHtml', [this.helpObject, this.options]);
    }
})
