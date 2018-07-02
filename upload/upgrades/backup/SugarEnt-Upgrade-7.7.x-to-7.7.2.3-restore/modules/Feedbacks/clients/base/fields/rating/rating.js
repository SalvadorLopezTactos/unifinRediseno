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
({initialize:function(options){this._super('initialize',[options]);this.def.rate=this.def.rate||3;this.model.setDefault(this.name,this.def.default);},format:function(value){this.stars=_.map(_.range(1,this.def.rate+1),function(n){return n<=value;});return value;},unformat:function(value){return value+1;},bindDomChange:function(){if(!this.model){return;}
var $el=this.$('[data-value]');$el.on('click',_.bind(function(evt){var value=$(evt.currentTarget).data('value');this.model.set(this.name,this.unformat(value));},this));},bindDataChange:function() {if(this.model){this.model.on('change:'+this.name,this.render,this);}}})