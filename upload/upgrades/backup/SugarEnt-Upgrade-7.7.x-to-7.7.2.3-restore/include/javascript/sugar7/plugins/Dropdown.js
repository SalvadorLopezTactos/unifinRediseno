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
(function(app){app.events.on('app:init',function(){app.plugins.register('Dropdown',['layout','view'],{events:{'keydown':'handleDropdownKeydown'},onAttach:function(component,plugin){this.on('init',function(){if(app.bwc){this.listenTo(app.bwc,'clicked',this.closeDropdown);}
app.routing.before('route',this.closeDropdown,this);});},isDropdownOpen:function(){return!!this.$('[data-toggle="dropdown"]').parent().hasClass('open');},handleDropdownKeydown:function(event){var $items,$focusItem,keysCaptured;if(!this.isDropdownOpen()){return;}
if(event.keyCode===$.ui.keyCode.ESCAPE||event.keyCode===$.ui.keyCode.TAB){this.closeDropdown();}else{$items=this._getDropdownItems();$focusItem=$items.filter(':focus');this._focusSubmenuItem(event.keyCode,$items.index($focusItem),$items);if(event.keyCode===$.ui.keyCode.RIGHT||event.keyCode===$.ui.keyCode.LEFT){this._toggleSubmenu($focusItem);}}
keysCaptured=[$.ui.keyCode.ESCAPE,$.ui.keyCode.UP,$.ui.keyCode.DOWN,$.ui.keyCode.LEFT,$.ui.keyCode.RIGHT];if(_.contains(keysCaptured,event.keyCode)){event.stopPropagation();event.preventDefault();}},_getDropdownItems:function(){return this.$(this.dropdownItemSelector||'[role=menu] li:not(.divider) a:visible');},_focusSubmenuItem:function(key,index,$items){var $menuItemToFocus;if(key===$.ui.keyCode.UP&&index>0){index--;}
if(key===$.ui.keyCode.DOWN&&index<$items.length-1){index++;}
if(!~index){index=0;}
$menuItemToFocus=$items.eq(index).focus();this._scrollToMenuItem($menuItemToFocus);},_scrollToMenuItem:function($menuItem){var $dropdownMenu=this.$('.dropdown-menu'),menuHeight,menuItemHeight,menuItemTopPosition;if($dropdownMenu.hasClass('scroll')){menuHeight=$dropdownMenu.height();menuItemHeight=$menuItem.height();menuItemTopPosition=$menuItem.position().top;if((menuItemTopPosition+menuItemHeight)>menuHeight){$dropdownMenu.scrollTop($dropdownMenu.scrollTop()+menuHeight/2);}else if(menuItemTopPosition<0){$dropdownMenu.scrollTop($dropdownMenu.scrollTop()-menuHeight/2);}}},_toggleSubmenu:function($dropdown){var $submenuButton=$dropdown.find('.dropdown-submenu');if($submenuButton.length>0){$submenuButton.click();}},closeDropdown:function(){this.$('.open .dropdown-menu').trigger('click.bs.dropdown');},unbindBeforeHandler:function(){app.routing.offBefore('route',this.closeDropdown,this);},onDetach:function(){app.events.off('app:view:change',null,this);app.routing.offBefore('route',this.closeDropdown,this);this.unbindBeforeHandler();}});});})(SUGAR.App);