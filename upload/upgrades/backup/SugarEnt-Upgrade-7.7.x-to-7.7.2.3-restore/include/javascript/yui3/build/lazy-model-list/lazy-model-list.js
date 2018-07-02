/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('lazy-model-list',function(Y,NAME){var AttrProto=Y.Attribute.prototype,GlobalEnv=YUI.namespace('Env.Model'),Lang=Y.Lang,YArray=Y.Array,EVT_ADD='add',EVT_ERROR='error',EVT_RESET='reset';Y.LazyModelList=Y.Base.create('lazyModelList',Y.ModelList,[],{initializer:function(){this.after('*:change',this._afterModelChange);},free:function(model){var index;if(model){index=Lang.isNumber(model)?model:this.indexOf(model);if(index>=0){delete this._models[index];}}else{this._models=[];}
return this;},get:function(name){if(this.attrAdded(name)){return AttrProto.get.apply(this,arguments);}
return YArray.map(this._items,function(item){return item[name];});},getAsHTML:function(name){if(this.attrAdded(name)){return Y.Escape.html(AttrProto.get.apply(this,arguments));}
return YArray.map(this._items,function(item){return Y.Escape.html(item[name]);});},getAsURL:function(name){if(this.attrAdded(name)){return encodeURIComponent(AttrProto.get.apply(this,arguments));}
return YArray.map(this._items,function(item){return encodeURIComponent(item[name]);});},indexOf:function(model){return YArray.indexOf(model&&model._isYUIModel?this._models:this._items,model);},reset:function(items,options){items||(items=[]);options||(options={});var facade=Y.merge({src:'reset'},options);items=items._isYUIModelList?items.map(this._modelToObject):YArray.map(items,this._modelToObject);facade.models=items;if(options.silent){this._defResetFn(facade);}else{if(this.comparator){items.sort(Y.bind(this._sort,this));}
this.fire(EVT_RESET,facade);}
return this;},revive:function(item){var i,len,models;if(item||item===0){return this._revive(Lang.isNumber(item)?item:this.indexOf(item));}else{models=[];for(i=0,len=this._items.length;i<len;i++){models.push(this._revive(i));}
return models;}},toJSON:function(){return this.toArray();},_add:function(item,options){var facade;options||(options={});item=this._modelToObject(item);if(!('clientId'in item)){item.clientId=this._generateClientId();}
if(this._isInList(item)){this.fire(EVT_ERROR,{error:'Model is already in the list.',model:item,src:'add'});return;}
facade=Y.merge(options,{index:'index'in options?options.index:this._findIndex(item),model:item});options.silent?this._defAddFn(facade):this.fire(EVT_ADD,facade);return item;},_clear:function(){YArray.each(this._models,this._detachList,this);this._clientIdMap={};this._idMap={};this._items=[];this._models=[];},_generateClientId:function(){GlobalEnv.lastId||(GlobalEnv.lastId=0);return this.model.NAME+'_'+(GlobalEnv.lastId+=1);},_isInList:function(item){return!!(('clientId'in item&&this._clientIdMap[item.clientId])||('id'in item&&this._idMap[item.id]));},_modelToObject:function(model){if(model._isYUIModel){model=model.getAttrs();delete model.destroyed;delete model.initialized;}
return model;},_remove:function(item,options){if(item._isYUIModel){item=this.indexOf(item);}
return Y.ModelList.prototype._remove.call(this,item,options);},_revive:function(index){var item,model;if(index<0){return null;}
item=this._items[index];if(!item){return null;}
model=this._models[index];if(!model){model=new this.model(item);model._set('clientId',item.clientId);this._attachList(model);this._models[index]=model;}
return model;},_afterModelChange:function(e){var changed=e.changed,item=this._clientIdMap[e.target.get('clientId')],name;if(item){for(name in changed){if(changed.hasOwnProperty(name)){item[name]=changed[name].newVal;}}}},_defAddFn:function(e){var item=e.model;this._clientIdMap[item.clientId]=item;if(Lang.isValue(item.id)){this._idMap[item.id]=item;}
this._items.splice(e.index,0,item);},_defRemoveFn:function(e){var index=e.index,item=e.model,model=this._models[index];delete this._clientIdMap[item.clientId];if('id'in item){delete this._idMap[item.id];}
if(model){this._detachList(model);}
this._items.splice(index,1);this._models.splice(index,1);}});},'3.15.0',{"requires":["model-list"]});