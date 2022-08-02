({
    /**
     * The file used to handle action of create-survey component 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */

    className: 'create-survey',
    initialize: function (options) {
        this._super('initialize', [options]);
        var theme_list = app.lang.getAppListStrings('theme_list');
        this.theme_list = theme_list;
    },
    events: {
        'click .survey_theme_image': 'survey_theme_image_clicked',
        'click .page_component': 'page_component_clicked',
        'click .survey_theme': 'survey_theme_clicked',
    },
    _render: function (options) {
        this._super('_render', [options]);
    },
    /**
     * on click of image radio button of theme should be selected
     * 
     * @param el - current target
     */
    survey_theme_image_clicked: function (el) {
        $(el.currentTarget).parents('.SurveyTheme').find('[name=survey_theme]').prop('checked', 'checked');
    },
    /**page component tab clicked
     * 
     * @returns {undefined}
     */
    page_component_clicked: function () {
        $('.page_component_inner').show();
        $('.custom_theme_inner').hide();
        $('.page_component').addClass('active');
        $('.survey_theme').removeClass('active');
    },
    /**survey theme tab clicked
     * 
     * @returns {undefined}
     */
    survey_theme_clicked: function () {
        $('.page_component_inner').hide();
        $('.custom_theme_inner').show();
        $('.survey_theme').addClass('active');
        $('.page_component').removeClass('active');
    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})