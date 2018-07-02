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
 * @class View.Fields.Base.Htmleditable_tinymceField
 * @alias SUGAR.App.view.fields.BaseHtmleditable_tinymceField
 * @extends View.Fields.Base.BaseField
 */
({
    plugins: ['Tinymce', 'EllipsisInline'],

    fieldSelector: '.htmleditable', //iframe or textarea selector
    _htmleditor: null, // TinyMCE html editor
    _isDirty: false,
    // When the model already has the value being set, there is no need to trigger the "SetContent" event, which calls
    // our callback to save the content to the model. But we don't want to short-circuit events in TinyMCE's workflow,
    // so the following flag can be toggled to false to indicate that we don't need to save the content to the model
    // inside of the callback.
    _saveOnSetContent: true,

    /**
     * Render an editor for edit view or an iframe for others
     *
     * @private
     */
    _render: function() {

        this.destroyTinyMCEEditor();

        app.view.Field.prototype._render.call(this);

        this._getHtmlEditableField().attr('name', this.name);
        if (this._isEditView()) {
            this._renderEdit(this.def.tinyConfig || null);
        } else {
            this._renderView();
        }
    },

    /**
     * Populate the editor or textarea with the value from the model
     */
    bindDataChange: function() {
        this.model.on('change:' + this.name, function(model, value) {
            if (this._isEditView()) {
                this._saveOnSetContent = false; // the model already has the value being set, so don't set it again
                this.setEditorContent(value);
            } else {
                this.setViewContent(value)
            }
        }, this);
    },

    /**
     * Sets the content displayed in the non-editor view
     *
     * @param {String} value Sanitized HTML to be placed in view
     */
    setViewContent: function(value){
        var editable = this._getHtmlEditableField();
        if (!editable) {
            return;
        }
        if (!_.isUndefined(editable.get(0)) && !_.isEmpty(editable.get(0).contentDocument)) {
            if (editable.contents().find('body').length > 0) {
                editable.contents().find('body').html(value);
            }
        } else {
            editable.html(value);
        }
    },

    /**
     * Render editor for edit view
     *
     * @param {Array} value TinyMCE config settings
     * @private
     */
    _renderEdit: function(options) {
        var self = this;
        this.initTinyMCEEditor(options);
        this._getHtmlEditableField().on('change', function(){
            self.model.set(self.name, self._getHtmlEditableField().val());
        });


    },

    /**
     * Render read-only view for other views
     *
     * @private
     */
    _renderView: function() {
        this.setViewContent(this.value);
    },

    /**
     * Is this an edit view?  If the field contains a textarea, it will assume that it's in an edit view.
     *
     * @return {Boolean}
     * @private
     */
    _isEditView: function() {
        return (this._getHtmlEditableField().prop('tagName') === 'TEXTAREA');
    },

    /**
     * Returns a default TinyMCE init configuration for the htmleditable widget.
     * This function can be overridden to provide a custom TinyMCE configuration.
     *
     * See [TinyMCE Configuration Documentation](http://www.tinymce.com/wiki.php/Configuration)for details.
     *
     * @return {Object} TinyMCE configuration to use with this widget
     */
    getTinyMCEConfig: function(){
        return {
            // Location of TinyMCE script
            script_url: 'include/javascript/tiny_mce/tiny_mce.js',

            // General options
            theme: "advanced",
            skin: "sugar7",
            plugins: "style,table,advhr,advimage,advlink,iespell,inlinepopups,media,searchreplace,print,contextmenu,paste,noneditable,visualchars,nonbreaking,xhtmlxtras",
            entity_encoding: "raw",
            browser_spellcheck: true,

            // Theme options
            theme_advanced_buttons1: "code,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,fontsizeselect,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,iespell,media,advhr,|,print,|",
            theme_advanced_buttons2: "cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,|,forecolor,backcolor,tablecontrols,|,",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "none",
            theme_advanced_resizing: true,
            schema: "html5",

            // Drop lists for link/image/media/template dialogs
            template_external_list_url: "lists/template_list.js",
            media_external_list_url: "lists/media_list.js",

            //plugin theme settings
            theme_advanced_path: false,
            theme_advanced_source_editor_width: 500,
            theme_advanced_source_editor_height: 400,
            inlinepopups_skin: "sugar7modal",
            relative_urls: false,
            remove_script_host: false
        };
    },

    /**
     * Initializes the TinyMCE editor.
     *
     * @param {Object} optConfig Optional TinyMCE config to use when initializing editor.  If none provided, will load config provided from {@link getTinyMCEConfig}.
     */
    initTinyMCEEditor: function(optConfig) {
        var self = this;
        if(_.isEmpty(this._htmleditor)){
            var config = _.extend({}, this.getTinyMCEConfig(), optConfig || {});
            var __superSetup__ = config.setup;
            // Preserve custom setup if it exists, add setup function needed for widget to work properly
            config.setup = function(editor){
                if(_.isFunction(__superSetup__)){
                    __superSetup__.call(this, editor);
                }
                self._htmleditor = editor;
                self._htmleditor.onInit.add(function(ed) {
                    self.setEditorContent(self.getFormattedValue());
                    $(ed.getWin()).blur(function(e){ // Editor window lost focus, update model immediately
                        self._saveEditor();
                    });
                });
                self._htmleditor.onDeactivate.add(function(ed){
                    self._saveEditor();
                });
                self._htmleditor.onSetContent.add(function(ed) {
                    if (self._saveOnSetContent) {
                        self._saveEditor(true);
                    }
                    self._saveOnSetContent = true; // flip it back so that we're sure we save the next time
                });
                self._htmleditor.onChange.add(function(ed, l) {
                    // Changes have been made, mark widget as dirty so we don't lose them
                    self._isDirty = true;
                });
            };
            config.oninit = function(inst) {
                self.context.trigger('tinymce:oninit', inst);
            };

            this._getHtmlEditableField().tinymce(config);
        }
    },

    /**
     * Destroy TinyMCE Editor instance
     */
    destroyTinyMCEEditor: function() {
        // Clean up existing TinyMCE editor
        if(!_.isNull(this._htmleditor)){
            this._saveEditor(true);
            this._htmleditor.remove();
            this._htmleditor.destroy();
            this._htmleditor = null;
        }
    },

    /**
     * Save the TinyMCE editor's contents to the model
     * @private
     */
    _saveEditor: function(force){
        var save = force | this._isDirty;
        if(save){
            this.model.set(this.name, this.getEditorContent(), {silent: true});
            this._isDirty = false;
        }
    },

    /**
     * Finds textarea or iframe element in the field template
     *
     * @return {HTMLElement} element from field template
     * @private
     */
    _getHtmlEditableField: function() {
        return this.$el.find(this.fieldSelector);
    },

    /**
     * Sets TinyMCE editor content
     *
     * @param {String} value HTML content to place into HTML editor body
     */
    setEditorContent: function(value) {
        if(_.isEmpty(value)){
            value = "";
        }
        if (this._isEditView() && this._htmleditor && this._htmleditor.dom) {
            this._htmleditor.setContent(value);
        }
    },

    /**
     * Retrieves the  TinyMCE editor content
     *
     * @return {String} content from the editor
     */
    getEditorContent: function() {
        return this._htmleditor.getContent({format: 'raw'});
    },

    /**
     * Destroy TinyMCE Editor on dispose
     *
     * @private
     */
    _dispose: function() {
        this.destroyTinyMCEEditor();
        app.view.Field.prototype._dispose.call(this);
    }

})
