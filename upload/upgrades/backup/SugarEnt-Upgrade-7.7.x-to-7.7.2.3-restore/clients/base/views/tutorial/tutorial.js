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
({extendsFrom:app.view.TutorialView,className:'',initialize:function(options){app.events.trigger('app:help:hide');this.resizeCallback=_.debounce(_.bind(function(){this.highlightItem(this.index);},this),400);$(window).on('resize',this.resizeCallback);this.keyupCallback=_.bind(this.processKeyCode,this);$(document).on('keyup',this.keyupCallback);app.view.TutorialView.prototype.initialize.call(this,options);app.events.on("cache:clean",function(callback){callback(["tutorialPrefs"]);});},processKeyCode:function(e){switch(e.which){case 37:this.back(e);break;case 39:case 13:this.next(e);break;case 27:this.hide(e);break;default:return;}
e.preventDefault();},remove:function(){$(window).off('resize',this.resizeCallback);$(document).off('keyup',this.keyupCallback);app.view.TutorialView.prototype.remove.call(this);var prefs=app.cache.get('tutorialPrefs')||{};if(prefs.showTooltip){this.showTooltip();this.removeTooltip(3000);}},showTooltip:function(){$('[data-action=tour]').tooltip({container:'body',trigger:'manual'}).tooltip('show');},removeTooltip:function(delayTime){if(!delayTime){$('[data-action=tour]').tooltip('hide');}else{_.delay(function(){$('[data-action=tour]').tooltip('hide');},delayTime);}}})