/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Views.Base.ActivityCardDetailView
 * @alias SUGAR.App.view.views.BaseActivityCardDetailView
 * @extends View.Views.Base.ActivityCardView
 */
({
    extendsFrom: 'ActivityCardView',

    className: 'activity-card-detail',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.initDateDetails();
    },

    /**
     * Initializes hbs date variables with date_entered
     */
    initDateDetails: function() {
        let fieldName;
        if (this.activity) {
            if (this.meta.panels[0].dateTimeStamp) {
                fieldName = this.meta.panels[0].dateTimeStamp.name;
                this.detailDateTimeTooltip = this.meta.panels[0].dateTimeStamp.tooltip;
                if (!this.detailDateTimeTooltip) {
                    let field = app.metadata.getField({module: this.activity.module, name: fieldName});
                    this.detailDateTimeTooltip = field.label || field.vname;
                }
            } else {
                fieldName = 'date_entered';
                this.detailDateTimeTooltip = 'LBL_LIST_DATE_ENTERED';
            }
            this.setDateDetails(this.activity.get(fieldName));
        }
    },

    /**
     * Set date variables for use in the hbs template
     *
     * @param dateString the date string
     */
    setDateDetails: function(dateString) {
        if (dateString) {
            var date = app.date(dateString);

            this.detailDay = date.format('dddd');
            this.detailDateTime = date.formatUser();
        }
    }
})
