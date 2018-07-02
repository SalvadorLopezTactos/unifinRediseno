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
 * @class View.Views.Base.pmse_Inbox.PreviewView
 * @alias SUGAR.App.view.views.Basepmse_InboxPreviewView
 * @extends View.Views.Base.PreviewView
 */
({
    extendsFrom: 'PreviewView',

    events: {
        'click .minify': 'toggleMinify'
    },

    toggleMinify: function(evt) {
        var $el = this.$('.dashlet-toggle > i'),
            collapsed = $el.is('.icon-chevron-up');
            if(collapsed){
                $('.dashlet-toggle > i').removeClass('icon-chevron-up');
            $('.dashlet-toggle > i').addClass('icon-chevron-down');
        }else{
                $('.dashlet-toggle > i').removeClass('icon-chevron-down');
                $('.dashlet-toggle > i').addClass('icon-chevron-up');
            }
        $('.dashlet').toggleClass('collapsed');
        $('.dashlet-content').toggleClass('hide');
    },

    /**
     * Renders the preview dialog with the data from the current model and collection.
     * @param model Model for the object to preview
     * @param collection Collection of related objects to the current model
     * @param {Boolean} fetch Optional Indicates if model needs to be synched with server to populate with latest data
     * @param {Number|String} previewId Optional identifier use to determine event origin. If event origin is not the same
     * but the model id is the same, preview should still render the same model.
     *
     * @override we load the preview image of the process design instead of the usual fields from the record
     * @private
     */
    _renderPreview: function(model, collection, fetch, previewId){
        var self = this;

        // If there are drawers there could be multiple previews, make sure we are only rendering preview for active drawer
        if(app.drawer && !app.drawer.isActive(this.$el)){
            return;  //This preview isn't on the active layout
        }

        // Close preview if we are already displaying this model
        if(this.model && model && (this.model.get("id") == model.get("id") && previewId == this.previewId)) {
            // Remove the decoration of the highlighted row
            app.events.trigger("list:preview:decorate", false);
            // Close the preview panel
            app.events.trigger('preview:close');
            return;
        }

        if (app.metadata.getModule(model.module).isBwcEnabled) {
            // if module is in BWC mode, just return
            return;
        }

        if (model) {
            // Use preview view if available, otherwise fallback to record view
            var viewName = 'preview',
                previewMeta = app.metadata.getView(model.module, 'preview'),
                recordMeta = app.metadata.getView(model.module, 'record');
            if (_.isEmpty(previewMeta) || _.isEmpty(previewMeta.panels)) {
                viewName = 'record';
            }
            this.meta = this._previewifyMetadata(_.extend({}, recordMeta, previewMeta));

            //only use id2 if it's available
            if (model.get('id2')) {
                model.set('id', model.get('id2'));
            }
            if (fetch) {
                model.fetch({
                    //Show alerts for this request
                    showAlerts: true,
                    success: function(model) {
                        self.renderPreview(model, collection);
                    },
                    //The view parameter is used at the server end to construct field list
                    view: viewName
                });
            } else {
                this.renderPreview(model, collection);
            }

            var pmseInboxUrl = app.api.buildFileURL({
                module: 'pmse_Inbox',
                id: model.get('cas_id') || (self.collection.get(model)).get('cas_id'),
                field: 'id'
            }, {cleanCache: true});
            this.image_preview_url = pmseInboxUrl;
        }

        this.previewId = previewId;
    }
})