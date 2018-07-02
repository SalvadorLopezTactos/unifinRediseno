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
(function(app){app.events.on('app:init',function(){app.plugins.register('ListColumnEllipsis',['view'],{events:{'click [data-field-toggle]':'toggleColumn'},toggleColumn:function(event){var column=$(event.currentTarget).data('fieldToggle');if(this.isLastColumnVisible(column)){event.stopPropagation();return;}
this._toggleColumn(column);this.render();this._reopenFieldsDropdown(event);},_toggleColumn:function(column){var changedColumn={};var f=this._fields._byId[column];if(f){f.selected=!f.selected;changedColumn=f;}
this._fields.visible=_.where(this._fields.all,{selected:true});this.trigger('list:toggle:column',column,changedColumn.selected,changedColumn);},isLastColumnVisible:function(column){if(this._fields.visible.length===1){var f=this._fields._byId[column];return f&&f.selected;}
return false;},_reopenFieldsDropdown:function(event){this.$('[data-action="fields-toggle"]').dropdown('toggle');event.stopPropagation();},onAttach:function(component,plugin){this.before('render',function(){var lastActionColumn=_.last(this.rightColumns);if(lastActionColumn){lastActionColumn.isColumnDropdown=true;}},this);}});});})(SUGAR.App);