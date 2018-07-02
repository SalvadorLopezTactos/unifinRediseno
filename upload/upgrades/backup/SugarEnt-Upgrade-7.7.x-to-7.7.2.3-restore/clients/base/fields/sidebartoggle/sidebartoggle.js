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
({events:{'click':'toggle'},_state:'open',_render:function(){this._super('_render');this.dataPlacement=app.lang.direction==='rtl'?'right':'left';return this;},initialize:function(options){this._super('initialize',[options]);var defaultLayout=this.closestComponent('sidebar');if(defaultLayout&&_.isFunction(defaultLayout.isSidePaneVisible)){this.toggleState(defaultLayout.isSidePaneVisible()?'open':'close');this.listenTo(defaultLayout,'sidebar:state:changed',this.toggleState);}
app.shortcuts.register('Sidebar:Toggle','t',this.toggle,this);},toggleState:function(state){if(state!=='open'&&state!=='close'){state=(this._state==='open')?'close':'open';}
this._state=state;if(!this.disposed){this.render();}},toggle:function(event){var defaultLayout=this.closestComponent('sidebar');if(defaultLayout){defaultLayout.trigger('sidebar:toggle');}}})