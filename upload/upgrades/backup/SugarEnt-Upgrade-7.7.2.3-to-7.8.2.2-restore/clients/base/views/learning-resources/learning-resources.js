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
 * Learning resources dashlet that will contain the content and links to
 * SugarCRM training material.
 *
 * The resources information is populated through metadata. More can be added:
 * ```
 * // ...
 * 'resources' => array(
 *     'resource_id' => array(
 *         'css_class' => 'resource-class',
 *         'color' => 'resource-color',
 *         'icon' => 'fa-resource-icon',
 *         'url' => 'http://url.for.resource.com/',
 *         'link' => 'LBL_LEARNING_RESOURCES_RESOURCE_LINK',
 *         'teaser' => 'LBL_LEARNING_RESOURCES_RESOURCE_TEASER',
 *     ),
 *     //...
 * ),
 * //...
 * ```
 *
 * @class View.Views.Base.LearningResourcesView
 * @alias SUGAR.App.view.views.BaseLearningResourcesView
 * @extends View.View
 *
 * @deprecated Since 7.7. Will be removed in 7.9.
 */
({
    tagName: 'ul',
    className: 'resource-list',

    plugins: ['Dashlet'],

    /**
     * The resources map that are metadata driven.
     */
    resources: {},

    initialize: function(options) {
        this._super('initialize', [options]);
        app.logger.warn('View.Views.Base.LearningResourcesView is deprecated since 7.7. Will be removed in 7.9.');
    },

    /**
     * @inheritdoc
     *
     * Define the {@link #resources} directly from the metadata.
     *
     * FIXME this is on `_renderHtml` instead of `initialize` because
     * `dashletConfig` (metadata) is only available at this time.
     * This needs to be reviewed after the SC-1373 refactor goes in.
     */
    _renderHtml: function() {
        this.resources = this.dashletConfig.resources;
        this._super('_renderHtml');
    }
})
