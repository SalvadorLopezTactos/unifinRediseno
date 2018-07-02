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
({extendsFrom:'BaseField',initialize:function(options){this._super('initialize',[options]);},_render:function(){this._super('_render');this.styleLabel();},styleLabel:function(){var $label;$label=this.$el.children(0);$label.removeClass('ellipsis_inline');switch(this.value){case'IN PROGRESS':$label.addClass('label label-Leads');break;case'COMPLETED':$label.addClass('label label-success');break;case'TERMINATED':$label.addClass('label label-success');break;case'CANCELLED':$label.addClass('label label-warning');break;default:$label.addClass('label label-important');break;}}})