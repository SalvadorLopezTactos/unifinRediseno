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
({className:'dashlet-header',cssIconDefault:'fa-cog',cssIconRefresh:'fa-refresh fa-spin',defaultActions:{'dashlet:edit:clicked':'editClicked','dashlet:refresh:clicked':'refreshClicked','dashlet:delete:clicked':'removeClicked','dashlet:toggle:clicked':'toggleMinify'},plugins:['Tooltip'],initialize:function(options){_.extend(options.meta,app.metadata.getView(null,'dashlet-toolbar'),options.meta.toolbar);app.view.View.prototype.initialize.call(this,options);},refreshClicked:function(){var $el=this.$("[data-action=loading]"),self=this,options={};if($el.length>0){$el.removeClass(this.cssIconDefault).addClass(this.cssIconRefresh);options.complete=function(){if(self.disposed){return;}
$el.removeClass(self.cssIconRefresh).addClass(self.cssIconDefault);};}
this.layout.reloadDashlet(options);},removeClicked:function(evt){app.alert.show('delete_confirmation',{level:'confirmation',messages:app.lang.get('LBL_REMOVE_DASHLET_CONFIRM',this.module),onConfirm:_.bind(function(){this.layout.removeDashlet();},this)});},editClicked:function(evt){this.layout.editDashlet();},toggleClicked:function(evt){var $btn=$(evt.currentTarget),expanded=_.isUndefined($btn.data('expanded'))?true:$btn.data('expanded'),label=expanded?'LBL_DASHLET_MAXIMIZE':'LBL_DASHLET_MINIMIZE';$btn.html(app.lang.get(label,this.module));this.layout.collapse(expanded);$btn.data('expanded',!expanded);},toggleMinify:function(evt){var $el=this.$('.dashlet-toggle > i'),collapsed=$el.is('.fa-chevron-up');this.layout.collapse(collapsed);this.layout.trigger('dashlet:collapse',collapsed);}})