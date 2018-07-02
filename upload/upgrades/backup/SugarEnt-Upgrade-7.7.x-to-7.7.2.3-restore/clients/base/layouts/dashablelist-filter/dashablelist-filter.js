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
({className:'dashablelist-filter',initComponents:function(components,context,module){this._super('initComponents',[components,context,module]);var filterPanelLayout=this.getComponent('filterpanel');if(filterPanelLayout){filterPanelLayout.before('render',this._reinitializeFilterPanel,this);this.listenTo(this.layout,'dashlet:filter:reinitialize',filterPanelLayout.render);}},_reinitializeFilterPanel:function(){var filterPanelLayout=this.getComponent('filterpanel');if(!filterPanelLayout){return;}
var moduleName=this.model.get('module'),id=this.model.get('filter_id');filterPanelLayout.currentModule=moduleName;this.context.set('currentFilterId',id);}})