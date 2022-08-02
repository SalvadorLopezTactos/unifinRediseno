({
    /**
     * The file used to show popup of send survey & perfoem related actions of send survey 
     *
     * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
     * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
     * agreed to the terms and conditions of the License, and you may not use this file except in compliance
     * with the License.
     *
     * @author     Biztech Consultancy
     */

    extendsFrom: 'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    isSendNow: false,
    events: {
        'click [name=save_button]': 'save_language',
        'click [name=cancel_button]': '_disposeView',
    },
    initialize: function (options) {

        this.module_id = options.context.attributes.module_id;
        this.module = options.context.attributes.module;
        this.mode = options.context.attributes.mode;
        this.lang_id = options.lang_id;

        // availabel lang
        var available_language = app.lang.getAppListStrings('available_language_dom');
        this.available_language = available_language;

        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:Add_Supported_language', function () {
                this.render();
                this.$('.modal').modal({
                    backdrop: 'static'
                });
                this.$('.modal').modal('show');
                $('.datepicker').css('z-index', '20000');
                app.$contentEl.attr('aria-hidden', true);
                $('.modal-backdrop').insertAfter($('.modal'));
                /**If any validation error occurs, system will throw error and we need to enable the buttons back*/
                this.context.get('model').on('error:validation', function () {
                    this.disableButtons(false);
                }, this);
            }, this);
        }
        this.bindDataChange();
    },
    _render: function () {
        this._super('_render');

        // set header
        if (this.mode == 'edit')
        {
            $('.popup_header').html('Edit Language');
            $('[name=status]').parents('.row').show();
        }
        var self = this;
        // call api to get language via php
        var url = App.api.buildURL("bc_survey", "get_survey_language", "", {survey_id: this.module_id, lang_id: self.lang_id});
        App.api.call('GET', url, {}, {
            success: function (data) {
                if (data)
                {

                    var default_options = '';
                    var selected = '';
                    Array.prototype.contains = function (needle) {
                        for (i in this) {
                            if (this[i] == needle)
                                return true;
                        }
                        return false;
                    }

                    if (self.mode == 'edit')
                    {
                        $('[name=lang_id]').val(self.lang_id);
                        $.each(self.available_language, function (key, value) {
                            if (key == data['edit_lang_detail']['survey_lang'])
                            {
                                selected = 'selected';
                            } else {
                                selected = '';
                            }
                            default_options += '<option value="' + key + '" ' + selected + '>' + value + '</option>';

                        });
                        $('[name=add_new_language]').append(default_options).attr('disabled', true);
                        $('[name=status]').val(data['edit_lang_detail']['status']);
                        $('[name=text_direction]').val(data['edit_lang_detail']['text_direction']);
                        $('.allow_copy').parents('.span6').hide();
                    } else {
                        $('.allow_copy').parents('.span6').show();
                        $.each(self.available_language, function (key, value) {
                            selected = '';
                            if (key != data['default_crm_language'] && key != data['default_survey_language'] && !(data['supported_survey_language'].contains(key)))
                            {
                                default_options += '<option value="' + key + '" >' + value + '</option>';
                            }
                        });
                        $('[name=add_new_language]').append(default_options);
                    }

                }

            }
        });
    },
    save_language: function () {
        var self = this;
        if (!$('[name=save_button]').hasClass('disabled'))
        {
            var new_lang = $('[name=add_new_language').val();
            var allow_copy = $('.allow_copy:checked').length;
            var text_direction = $('[name=text_direction]').val();
            var status = $('[name=status]').val();
            var parent = $('[name=add_new_language').parent();
            if (!self.mode && !new_lang || new_lang == 'Select Language')
            {
                if (parent.find('.err-msg').length == 0)
                {
                    parent.append('<span title="This Field is required" class="error-tooltip add-on err-msg" data-container="body" rel="tooltip" title="" data-original-title="Error. This field is required."><i class="fa fa-exclamation-circle" style="color:red;"></i></span>');
                }
            } else {
                
                $('[name=save_button]').addClass('disabled');
                parent.find('.err-msg').remove();

                // call api to get language via php
                var url = App.api.buildURL("bc_survey", "save_new_language", "", {survey_id: this.module_id, new_lang: new_lang, allow_copy: allow_copy, text_direction: text_direction, status: status, lang_id: self.lang_id});
                App.api.call('GET', url, {}, {
                    success: function (data) {

                        self._disposeView();

                        var translate_survey = self.layout.getComponent('translate-survey');
                        $('.translate-survey-view').remove();
                        /** Create a new view object */
                        translate_survey = app.view.createView({
                            name: 'translate-survey',
                            layout: self.layout
                        });
                        translate_survey.module = 'bc_survey';
                        if (self.mode != 'edit')
                        {
                            translate_survey.lang_id = data;
                            translate_survey.recentAddedLanguage = new_lang;
                            translate_survey.allow_copy = allow_copy;
                            translate_survey.text_direction = text_direction;
                        }
                        /** add the new view to the components list of the record layout*/
                        self.layout._components.push(translate_survey);
                        self.layout.$el.append(translate_survey.$el);


                        /**triggers an event to show the pop up quick create view*/
                        self.layout.trigger("app:view:translate-survey");

                    }
                });
            }
        }
    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'Add_Supported_language'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})