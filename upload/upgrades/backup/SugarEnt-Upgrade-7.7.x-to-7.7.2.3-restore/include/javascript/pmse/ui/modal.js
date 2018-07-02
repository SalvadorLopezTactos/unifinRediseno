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
var Modal=function(options){Base.call(this,options);this.visible=null;this.loaded=false;this.html=null;this.clickHander=null;Modal.prototype.initObject.call(this,options);};Modal.prototype=new Base();Modal.prototype.type="Modal";Modal.prototype.initObject=function(options){var defaults={visible:false,clickHander:function(){}};$.extend(true,defaults,options);this.setVisible(defaults.visible).setClickHandler(defaults.clickHander);};Modal.prototype.setVisible=function(value){this.visible=value;return this;};Modal.prototype.setClickHandler=function(fn){this.clickHander=fn;return this;};Modal.prototype.show=function(child){var modalDiv;if(!this.html){modalDiv=document.createElement('div');modalDiv.className='adam-modal';modalDiv.id=this.id;this.html=modalDiv;}
if(child instanceof Element){this.html.appendChild(child.getHTML());}
document.body.appendChild(this.html);this.setVisible(true);if(!this.loaded){this.attachListeners();this.loaded=true;}};Modal.prototype.hide=function(){var parentElement;if(this.visible){parentElement=this.html.parentElement;parentElement.removeChild(this.html);this.setVisible(false);}};Modal.prototype.attachListeners=function(){var self=this;if(this.html){$(this.html).click(function(e){e.stopPropagation();if(self.clickHander){self.clickHander();}}).mouseover(function(e){e.stopPropagation();}).mouseout(function(e){e.stopPropagation();}).mousedown(function(e){e.stopPropagation();});}};