({
    /**
     * The file used to set actions for preview survey page 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */

    extendsFrom: 'PreviewView',
    initialize: function (options) {
        this._super('initialize', [options]);
    },
    /**
     * Add event listeners
     *
     * @private
     */
    _delegateEvents: function () {
        this._super('_delegateEvents');
    },
    // redirect to preview page of survey
    _renderPreview: function (model, collection, fetch, previewId) {
        var self = this;
        if (model.module == 'bc_survey') {
            var record_id = model.get("id");
            $.ajax({
                url: "index.php?entryPoint=preview_survey",
                type: "POST",
                data: {method: 'preview_survey'},
                success: function (data)
                {
                    var newWin = window.open(data + '/preview_survey.php?survey_id=' + record_id);
                    if (typeof newWin == "undefined") {
                        app.alert.show('info', {
                            level: 'info',
                            messages: 'Please allow your browser to show pop-ups.',
                            autoClose: true
                        });
                    }

                },
            });

        } else {
            this._super('_renderPreview');
        }
    },
})