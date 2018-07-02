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
({commit_date:undefined,data_points:[],points:[],events:{'click':'triggerHistoryLog'},initialize:function(options){this._super('initialize',[options]);this.points=[];this.data_points=[];_.each(options.def.datapoints,function(point){if(app.utils.getColumnVisFromKeyMap(point,'forecastsWorksheet')){this.points.push(point);}},this);},triggerHistoryLog:function(){this.$('i').toggleClass('fa-caret-down fa-caret-up');this.context.trigger('forecast:commit_log:trigger');},bindDataChange:function(){this.collection.on('reset',function(){this.data_points=[];var model=_.first(this.collection.models)
if(!_.isUndefined(model)){this.commit_date=model.get('date_modified');this.data_points=this.processDataPoints(model);}else{this.commit_date=undefined;}
if(!this.disposed){this.render();}},this);},processDataPoints:function(model){var points=[],noAccessTemplate=app.template.getField('base','noaccess')(this);_.each(this.points,function(point){var point_data={};if(app.acl.hasAccess('read','ForecastWorksheets',app.user.get('id'),point)){point_data.value=model.get(point)}else{point_data.error=noAccessTemplate;}
points.push(point_data);},this);return points;}})