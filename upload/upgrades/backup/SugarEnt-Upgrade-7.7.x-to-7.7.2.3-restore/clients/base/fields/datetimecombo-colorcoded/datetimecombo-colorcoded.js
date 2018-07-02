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
({extendsFrom:'DatetimecomboField',colorCodeClasses:{overdue:'label label-important',upcoming:'label label-info'},_render:function(){this.type='datetimecombo';this._super('_render');this.setColorCoding();},bindDataChange:function(){this._super('bindDataChange');this.model.on('change:status',this.setColorCoding,this);},setColorCoding:function(){var colorCodeClass;this._clearColorCode();if(!this.model||this.action!=='list'){return;}
colorCodeClass=this._isCompletedStatus()?null:this._getColorCodeClass();this._setColorCodeClass(colorCodeClass);},_isCompletedStatus:function(){if(_.isUndefined(this.def.completed_status_value)){return false;}
return(this.model.get('status')===this.def.completed_status_value);},_getColorCodeClass:function(){var eventDate,today,nextDay;if(_.isEmpty(this.model.get(this.name))){return null;}
eventDate=app.date(this.model.get(this.name));today=app.date();nextDay=app.date().add(1,'days');if(eventDate.isBefore(today)){return this.colorCodeClasses.overdue;}else if(eventDate.isBefore(nextDay)){return this.colorCodeClasses.upcoming;}else{return null;}},_setColorCodeClass:function(colorCodeClass){if(!_.isNull(colorCodeClass)){this.$el.addClass(colorCodeClass);}},_clearColorCode:function(){_.each(this.colorCodeClasses,function(colorCodeClass){this.$el.removeClass(colorCodeClass);},this);}})