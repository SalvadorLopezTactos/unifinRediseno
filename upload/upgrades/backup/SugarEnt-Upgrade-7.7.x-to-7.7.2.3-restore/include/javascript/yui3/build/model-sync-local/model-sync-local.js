/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('model-sync-local',function(Y,NAME){function LocalSync(){}
LocalSync._NON_ATTRS_CFG=['root'];LocalSync._hasLocalStorage=(function(){var LS=Y.config.win.localStorage,test=Y.guid();try{LS.setItem(test,test);LS.removeItem(test);return true;}catch(e){return false;}})(),LocalSync._data=LocalSync._data||{};LocalSync._store=LocalSync._store||{};LocalSync.prototype={root:'',storage:null,initializer:function(config){var store,data;config||(config={});if('root'in config){this.root=config.root||'';}
if(!this.root&&this.model&&this.model.prototype.root){this.root=this.model.prototype.root;}
if(LocalSync._hasLocalStorage){this.storage=Y.config.win.localStorage;store=this.storage.getItem(this.root);}else{}
if(store){LocalSync._store[this.root]=store.split('|')||[];Y.Array.each(LocalSync._store[this.root],function(id){LocalSync._data[id]=Y.JSON.parse(this.storage.getItem(id));},this);}else{LocalSync._store[this.root]||(LocalSync._store[this.root]=[]);}},sync:function(action,options,callback){options||(options={});var response,errorInfo;try{switch(action){case'read':if(this._isYUIModelList){response=this._index(options);}else{response=this._show(options);}
break;case'create':response=this._create(options);break;case'update':response=this._update(options);break;case'delete':response=this._destroy(options);break;}}catch(error){errorInfo=error.message;}
if(response){callback(null,response);}else if(errorInfo){callback(errorInfo);}else{callback("Data not found in LocalStorage");}},generateID:function(pre){return Y.guid(pre+'_');},_index:function(){var store=LocalSync._store[this.root],data=Y.Array.map(store,function(id){return LocalSync._data[id];});return data;},_show:function(){return LocalSync._data[this.get('id')]||null;},_create:function(){var hash=this.toJSON();hash.id=this.generateID(this.root);LocalSync._data[hash.id]=hash;if(this.storage){this.storage.setItem(hash.id,hash);}
LocalSync._store[this.root].push(hash.id);this._save();return hash;},_update:function(){var hash=this.toJSON(),id=this.get('id');LocalSync._data[id]=hash;if(this.storage){this.storage.setItem(id,hash);}
if(Y.Array.indexOf(LocalSync._store[this.root],id)===-1){LocalSync._store[this.root].push(id);}
this._save();return hash;},_destroy:function(){var id=this.get('id'),storage=this.storage;if(!LocalSync._data[id]){return;}
delete LocalSync._data[id];if(storage){storage.removeItem(id);}
LocalSync._store[this.root]=Y.Array.filter(LocalSync._store[this.root],function(item){return item.id!=id;});this._save();return this.toJSON();},_save:function(){if(LocalSync._hasLocalStorage&&this.storage){this.storage.setItem(this.root,LocalSync._store[this.root].join('|'));}}};Y.namespace('ModelSync').Local=LocalSync;},'3.15.0',{"requires":["model","json-stringify"]});