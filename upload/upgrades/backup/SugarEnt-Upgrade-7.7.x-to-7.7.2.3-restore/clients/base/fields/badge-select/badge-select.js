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
({extendsFrom:'EnumField',initialize:function(options){this._super('initialize',[options]);if(this.view&&this.view.layout){this.view.layout.on('headerpane:adjust_fields',this.repositionDropdown,this);}
this.statusClasses={'important':'label-important','warning':'label-warning','pending':'label-pending','success':'label-success','info':'label-info','inverse':'label-inverse','unknown':'label-unknown','log':'label-log'};},repositionDropdown:function(){var $el=this.$(this.fieldTag).select2('container');if($el.hasClass('select2-dropdown-open')){this.$(this.fieldTag).data('select2').dropdown.css({'left':$el.offset().left});}},_loadTemplate:function(){if(this.action==='edit'){this.type='enum';}
this._super('_loadTemplate');this.type='badge-select';},format:function(value){if(!value||this.action==='edit'){return value;}
this.statusClass=this.styleLabel(value);return this.items[value]||value;},styleLabel:function(status){if(this.action==='edit'){return;}
if(this.action==='disabled'){return'label-disabled';}
return this.statusClasses[status];},_dispose:function(){if(this.view&&this.view.layout){this.view.layout.off(null,null,this);}
this._super('_dispose');}})