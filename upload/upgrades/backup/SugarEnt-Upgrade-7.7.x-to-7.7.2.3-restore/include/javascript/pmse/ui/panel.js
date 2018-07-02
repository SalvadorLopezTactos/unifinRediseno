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
var Panel=function(options){Container.call(this,options);this.header=null;this.footer=null;this.layout=null;this.language={};Panel.prototype.initObject.call(this,options);};Panel.prototype=new Container();Panel.prototype.type='Panel';Panel.prototype.family='Panel';Panel.prototype.initObject=function(options){var defaults={layout:null};$.extend(true,defaults,options);this.setHeader(defaults.header).setFooter(defaults.footer).setLayout(defaults.layout);};Panel.prototype.setHeader=function(h){this.header=h;return this;};Panel.prototype.setFooter=function(f){this.footer=f;return this;};Panel.prototype.setLayout=function(layout){if(layout&&layout.family&&layout.family==='Layout'){this.layout=layout;}else{this.layout=new Layout(layout);}
return this;};Panel.prototype.createHTML=function(){var headerDiv,footerDiv;Container.prototype.createHTML.call(this);this.style.removeProperties(['width','height','position','top','left','z-index']);this.style.addClasses(['adam-panel']);if(this.header){this.html.insertBefore(this.header,this.body);}else{headerDiv=this.createHTMLElement('div');headerDiv.className='adam-panel-header';this.html.insertBefore(headerDiv,this.body);this.header=headerDiv;}
if(this.footer){this.html.appendChild(this.footer);}else{footerDiv=this.createHTMLElement('div');footerDiv.className='adam-panel-footer';this.html.appendChild(footerDiv);this.footer=footerDiv;}
this.body.className='adam-panel-body';return this.html;};Panel.prototype.load=function(){};