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
({events:{'click .dropdown-toggle':'toggleClicked','click a[data-id]':'navigateClicked'},dashboards:null,toggleClicked:function(evt){var self=this;if(!_.isEmpty(this.dashboards)){return;}
var contextBro=this.context.parent.getChildContext({module:'Home'});var collection=contextBro.get('collection').clone();var pattern=/^(LBL|TPL|NTC|MSG)_(_|[a-zA-Z0-9])*$/;collection.remove(self.model,{silent:true});_.each(collection.models,function(model){if(pattern.test(model.get('name'))){model.set('name',app.lang.get(model.get('name'),collection.module||null));}});self.dashboards=collection;var optionTemplate=app.template.getField(self.type,'options',self.module);self.$('.dropdown-menu').html(optionTemplate(collection));},navigateClicked:function(evt){var id=$(evt.currentTarget).data('id'),type=$(evt.currentTarget).data('type');this.navigate(id,type);},navigate:function(id,type){if(this.view.layout.isSearchContext()){var contextBro=this.context.parent.getChildContext({module:'Home'});contextBro.set('currentDashboardIndex',id);}
this.view.layout.navigateLayout(id,type);},format:function(value){var module=this.context.parent&&this.context.parent.get('module')||this.context.get('module');return app.lang.get(value,module)||value;},_loadTemplate:function(){app.view.Field.prototype._loadTemplate.call(this);if(this.context&&this.context.get('model')&&this.context.get('model').dashboardModule==='Home'){this.template=app.template.getField('base',this.tplName)||this.template;}},setMaxWidth:function(width){this.$el.css({'max-width':width});},getCellPadding:function(){var padding=0,$cell=this.$('.dropdown-toggle');if(!_.isEmpty($cell)){padding=parseInt($cell.css('padding-left'),10)+parseInt($cell.css('padding-right'),10);}
return padding;}})