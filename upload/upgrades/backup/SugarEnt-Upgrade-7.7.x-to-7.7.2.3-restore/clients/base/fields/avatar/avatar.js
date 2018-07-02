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
({extendsFrom:'ImageField',plugins:['File','FieldDuplicate','Tooltip'],MAPSIZECLASS:{'large':'label-module-lg','medium':'label-module-md','button':'label-module-btn','default':'','small':'label-module-sm','mini':'label-module-mini'},_render:function(){var template,className;this._super("_render");if(this.action!=='edit'||this.view.name==='merge-duplicates'){if(_.isEmpty(this.value)){className=_.isUndefined(this.MAPSIZECLASS[this.def.size])?this.MAPSIZECLASS['large']:this.MAPSIZECLASS[this.def.size];template=app.template.getField(this.type,'module-icon',this._getModuleName());if(template){this.$('.image_field').replaceWith(template({module:this._getModuleName(),labelSizeClass:className,tooltipPlacement:app.lang.direction==='ltr'?'right':'left'}));}}else{this.$('.image_field').addClass('image_rounded');}}
return this;},_getModuleName:function(){if(this.view.name==='history-summary'){return this.model.get('_module');}
return this.module;},_loadTemplate:function(){this.type='image';this._super("_loadTemplate");this.type=this.def.type;}})