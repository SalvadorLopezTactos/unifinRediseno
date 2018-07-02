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
 * @class View.Views.Portal.KBDocuments.RecordView
 * @alias SUGAR.App.view.views.PortalKBDocumentsRecordView
 * @extends View.View.Base.RecordView
 */
({
    extendsFrom: 'RecordView',

    initialize: function(options) {
        app.bwc.login(false);
        this._super("initialize", [options]);
    }
})
