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
({events:{'click .addNote':'openNoteModal','click [data-action=loadPreview]':'loadPreview','click [name=show_more_button]':'showMoreRecords'},plugins:['RelativeTime','Tooltip'],_defaultSettings:{relativeTimeThreshold:2,useRelativeTime:true},_settings:{},emptyStream:false,initialize:function(options){this._super('initialize',[options]);this._addPreviewEvents();this._initSettings();},_initSettings:function(){this._settings=_.extend({},this._defaultSettings,this.meta&&this.meta.settings||{});if(this._settings.useRelativeTime===true){this.useRelativeTime();}
return this;},useRelativeTime:function(){if(_.isEmpty(this.collection.models)){return;}
_.each(this.collection.models,function(model){var date=model.get('date_entered'),diffInDays=app.date().diff(date,'days',true),useRelative=diffInDays<=this._settings.relativeTimeThreshold;model.set('showRelativeTime',useRelative);},this);return this;},_renderHtml:function(){if(this.hasLoadedActivities()){this.emptyStream=this.collection.length<1;}
var oViewName=this.name;this.name='list';if(this._settings.useRelativeTime===true){this.useRelativeTime();}
this._super('_renderHtml');this.name=oViewName;},hasLoadedActivities:function(){return _.isNumber(this.collection.page);},bindDataChange:function(){if(this.collection){this.collection.on("reset",this.render,this);}},_addPreviewEvents:function(){app.events.on("list:preview:decorate",this.decorateRow,this);this.collection.on("reset",function(){app.events.trigger("preview:collection:change",this.collection);if(this._previewed){this.decorateRow(this._previewed);}},this);},loadPreview:function(event){var $parent=this.$(event.currentTarget).parents("li.activity");var activityId=$parent.data("id");var activity=this.collection.get(activityId);this.decorateRow(activity);app.events.trigger("preview:render",activity,this.collection,false);},decorateRow:function(model){this._previewed=model;this.$("li.activity").removeClass("on");if(model){this.$("li.activity[data-id="+model.get("id")+"]").addClass("on");}},openNoteModal:function(event){if(Modernizr.touch){app.$contentEl.addClass('content-overflow-visible');}
this.layout.trigger("app:view:activity:editmodal");this.$('li.open').removeClass('open');return false;},showMoreRecords:function(event){var self=this,options;app.alert.show('show_more_records',{level:'process',title:app.lang.get('LBL_LOADING')});options=self.filterOpened?self.getSearchOptions():{};options.add=true;if(this.collection.link){options.relate=true;}
options.success=function(){app.alert.dismiss('show_more_records');self.layout.trigger("list:paginate:success");self.render();window.scrollTo(0,document.body.scrollHeight);};options.limit=this.limit;this.collection.paginate(options);}})