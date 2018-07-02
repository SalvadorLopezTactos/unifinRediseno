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
var Element=function(options){Base.call(this,options);this.x=null;this.y=null;this.width=null;this.height=null;this.html=null;this.style=null;this.visible=null;this.zOrder=null;Element.prototype.initObject.call(this,options);};Element.prototype=new Base();Element.prototype.type="Base";Element.prototype.family="Base";Element.prototype.initObject=function(options){var defaults={style:{cssProperties:{},cssClasses:[]},width:0,height:0,x:0,y:0,zOrder:1,visible:true};$.extend(true,defaults,options);this.setStyle(new Style({belongsTo:this,cssProperties:defaults.style.cssProperties,cssClasses:defaults.style.cssClasses})).setDimension(defaults.width,defaults.height).setPosition(defaults.x,defaults.y).setZOrder(defaults.zOrder).setVisible(defaults.visible);};Element.prototype.setId=function(newID){this.id=newID;if(this.html){this.html.id=this.id;}
return this;};Element.prototype.setX=function(x){if(typeof x==='number'){this.x=x;if(this.html){this.style.addProperties({left:this.x});}}else{throw new Error('setX: x param is not a number');}
return this;};Element.prototype.setY=function(y){if(typeof y==='number'){this.y=y;if(this.html){this.style.addProperties({top:this.y});}}else{throw new Error('setY: y param is not a number');}
return this;};Element.prototype.setWidth=function(w){if(typeof w==='number'){this.width=w;if(this.html){this.style.addProperties({width:this.width});}}else{throw new Error('setWidth: w is not a number');}
return this;};Element.prototype.setHeight=function(h){if(typeof h==='number'){this.height=h;if(this.html){this.style.addProperties({height:this.height});}}else{throw new Error('setHeight: h is not a number');}
return this;};Element.prototype.setPosition=function(x,y){this.setX(x);this.setY(y);return this;};Element.prototype.setDimension=function(w,h){this.setWidth(w);this.setHeight(h);return this;};Element.prototype.setZOrder=function(z){if(typeof z==='number'&&z>0){this.zOrder=z;if(this.html){this.style.addProperties({zIndex:this.zOrder});}}
return this;};Element.prototype.setVisible=function(value){if(_.isBoolean(value)){this.visible=value;if(this.html){if(value){this.style.addProperties({display:"inline"});}else{this.style.addProperties({display:"none"});}}}
return this;};Element.prototype.setStyle=function(style){if(style instanceof Style){this.style=style;}
return this;};Element.prototype.createHTMLElement=function(type){return document.createElement(type);};Element.prototype.createHTML=function(){if(!this.html){this.html=this.createHTMLElement('div');this.html.id=this.id;this.style.applyStyle();this.style.addProperties({position:"absolute",left:this.x,top:this.y,width:this.width,height:this.height,zIndex:this.zOrder});}
return this.html;};Element.prototype.paint=function(){};Element.prototype.getHTML=function(){if(!this.html){this.createHTML();}
return this.html;};Element.prototype.calculateWidth=function(text,font){var f=font||'12px arial',$o=$(this.createHTMLElement('div')),w;$o.text(text).css({'position':'absolute','float':'left','white-space':'nowrap','visibility':'hidden','font':f}).appendTo($('body')),w=$o.width();$o.remove();return w;};