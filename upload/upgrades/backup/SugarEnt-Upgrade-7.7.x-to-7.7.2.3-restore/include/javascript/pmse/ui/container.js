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
var Container=function(options){Element.call(this,options);this.items=[];this.body=null;this.bodyHeight=null;Container.prototype.initObject.call(this,options);};Container.prototype=new Element();Container.prototype.type="Container";Container.prototype.family="Container";Container.prototype.initObject=function(options){var defaults={items:[],body:null};$.extend(true,defaults,options);this.setItems(defaults.items).setBody(defaults.body).setBodyHeight(defaults.bodyHeight);};Container.prototype.setItems=function(items){this.items=items;return this;};Container.prototype.setBodyHeight=function(height){this.bodyHeight=height;if(this.body){if(typeof height==='number'){this.body.style.height=height+'px';}else{this.bodyHeight=null;this.body.style.height='';}
this.height=$(this.html).height();}
return this;};Container.prototype.setBody=function(html){this.body=html;return this;};Container.prototype.getBody=function(){return this.body;};Container.prototype.createHTML=function(){var body;Element.prototype.createHTML.call(this);body=this.createHTMLElement('div');body.className='j-container';this.html.appendChild(body);this.body=body;this.setBodyHeight(this.bodyHeight);return this.html;};