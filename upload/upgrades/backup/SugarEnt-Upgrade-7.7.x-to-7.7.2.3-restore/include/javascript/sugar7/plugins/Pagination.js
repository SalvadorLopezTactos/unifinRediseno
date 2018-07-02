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
(function(app){app.events.on('app:init',function(){app.plugins.register('Pagination',['view'],{onAttach:function(component,plugin){this.on('init',function(){this.rowTemplate=app.template.getView(this.name+'.row',this.module)||app.template.getView(this.name+'.row')||this.rowTemplate;if(!_.contains(this.plugins,'Dashlet')||this.meta.config){return;}
if(this.layout){this.layout.on('init',this._initPaginationBottom,this);}},this);this.on('render',function(){this.$tableBody=this.$(this.tbodyTag||'tbody');},this);},_initPaginationBottom:function(){if(!this.layout){return;}
var pageComponent=this.layout.getComponent('list-bottom');if(pageComponent){return;}
pageComponent=app.view.createView({context:this.context,name:'list-bottom',meta:{template:'list-bottom.dashlet-bottom'},module:this.module,primary:false,layout:this.layout});this.layout.addComponent(pageComponent);},getNextPagination:function(options){var beanCollection;if(_.isFunction(this.getPaginationCollection)){beanCollection=this.getPaginationCollection();}
beanCollection=beanCollection||this.collection;if(!beanCollection.dataFetched){return;}
options=options||{};var originalOptions=_.extend({},this.collection.options,options);var defaultOnSuccess=options.success;options.success=null;if(_.isFunction(this.getPaginationOptions)){options=_.extend({},options,this.getPaginationOptions()||{});}
options.add=true;var origOnSuccess=options.success;options.success=_.bind(function(collection,data){if(_.isFunction(defaultOnSuccess)){defaultOnSuccess(collection,data);}
if(_.isFunction(origOnSuccess)){origOnSuccess(collection,data);}
if(this.disposed){return;}
if(this.module!==collection.module){this.rowTemplate=app.template.getView(this.name+'.row',collection.module)||this.rowTemplate;}
if(_.isEmpty(this.$tableBody)||!this.rowTemplate){app.logger.warn('Create a row.hbs template to avoid a full render.');this.render();return;}
if(!this.triggerBefore('render:rows',data)){return false;}
_.each(data,function(model){this._renderRow(this.collection.get(model.id));},this);this.trigger('render:rows');},this);if(this.limit){options.limit=this.limit;}
var _complete=options.complete;options.complete=_.bind(function(xhr,status){if(_.isFunction(_complete)){_complete.call(this,xhr,status);}
this.collection.options=originalOptions;},this);beanCollection.paginate(options);},_renderRow:function(model){this.rowModel=model;var $row=$(this.rowTemplate(this)),self=this;this.$tableBody.append($row);$row.find('span[sfuuid]').each(function(){var $this=$(this),sfId=$this.attr('sfuuid');if(self.fields[sfId]){self.fields[sfId].setElement($this);self.fields[sfId].render();}});}});});})(SUGAR.App);