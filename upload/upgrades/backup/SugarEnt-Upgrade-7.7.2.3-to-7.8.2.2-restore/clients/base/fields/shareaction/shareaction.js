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
 * Share row action.
 *
 * This allows an user to share a record that is currently mapped with this
 * field context.
 *
 * @class View.Fields.Base.ShareactionField
 * @alias SUGAR.App.view.fields.BaseShareactionField
 * @extends View.Fields.Base.EmailactionField
 */
({
    extendsFrom: 'EmailactionField',

    plugins: ['EmailClientLaunch'],

    /**
     * Share template for subject.
     *
     * See {@link #_initShareTemplates}.
     */
    shareTplSubject: null,

    /**
     * Share template for body.
     *
     * See {@link #_initShareTemplates}.
     */
    shareTplBody: null,

    /**
     * Share template for body in HTML format.
     *
     * See {@link #_initShareTemplates}.
     */
    shareTplBodyHtml: null,

    /**
     * @inheritdoc
     *
     * Adds the share options for use when launching the email client and
     * refreshes the share options if the model data changes. The contents
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.type = 'emailaction';
        this._initShareTemplates();
        this._setShareOptions();
        this.model.on('change', this._setShareOptions, this);
    },

    /**
     * Initializes the sharing feature templates.
     *
     * This will get the templates from either the current module (since we
     * might want to customize it per module) or from core templates.
     *
     * Please define your templates on:
     *
     * - `custom/clients/{platform}/view/share/subject.hbs`
     * - `custom/clients/{platform}/view/share/body.hbs`
     * - `custom/clients/{platform}/view/share/body-html.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/share/subject.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/share/body.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/share/body-html.hbs`
     *
     * @template
     * @protected
     */
    _initShareTemplates: function() {
        this.shareTplSubject = app.template.getView('share.subject', this.module) ||
            app.template.getView('share.subject');
        this.shareTplBody = app.template.getView('share.body', this.module) ||
            app.template.getView('share.body');
        this.shareTplBodyHtml = app.template.getView('share.body-html', this.module) ||
            app.template.getView('share.body-html');
    },

    /**
     * Set subject and body settings for the EmailClientLaunch plugin to use
     *
     * @protected
     */
    _setShareOptions: function() {
        var shareParams = this._getShareParams(),
            subject = this.shareTplSubject(shareParams),
            body = this.shareTplBody(shareParams),
            bodyHtml = this.shareTplBodyHtml(shareParams);

        this.addEmailOptions({
            subject: subject,
            html_body: bodyHtml || body,
            text_body: body
        });
    },

    /**
     * Get the params required by the templates defined on
     * {@link #_initShareTemplates}.
     *
     * Override this if your templates need more information to be sent on the
     * share email.
     *
     * @template
     * @protected
     */
    _getShareParams: function() {
        var moduleString = app.lang.getModuleName(this.module);

        return _.extend({}, this.model.attributes, {
            module: moduleString,
            appId: app.config.appId,
            url: window.location.href,
            name: new Handlebars.SafeString(app.utils.getRecordName(this.model))
        });
    },

    /**
     * Explicit share action to launch the sugar email client with share info
     * (used by bwc)
     */
    shareWithSugarEmailClient: function() {
        this.launchSugarEmailClient(this.emailOptions);
    },

    /**
     * Retrieve a mailto URL to launch an external mail client with share info
     * (used by bwc)
     */
    getShareMailtoUrl: function() {
        return this._buildMailToURL(this.emailOptions);
    }
})
