({
    /**
     * The file used to handle create survey page components layout for survey template
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
    },
    _render: function (options) {
        this._super('_render', [options]);

    },
    _dispose: function () {
        //additional stuff before calling the core create _dispose goes here
        this._super('_dispose');
    }
})