/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('datatable-core',function(Y,NAME){var INVALID=Y.Attribute.INVALID_VALUE,Lang=Y.Lang,isFunction=Lang.isFunction,isObject=Lang.isObject,isArray=Lang.isArray,isString=Lang.isString,isNumber=Lang.isNumber,toArray=Y.Array,keys=Y.Object.keys,Table;Table=Y.namespace('DataTable').Core=function(){};Table.ATTRS={columns:{validator:isArray,setter:'_setColumns',getter:'_getColumns'},recordType:{getter:'_getRecordType',setter:'_setRecordType'},data:{valueFn:'_initData',setter:'_setData',lazyAdd:false},recordset:{setter:'_setRecordset',getter:'_getRecordset',lazyAdd:false},columnset:{setter:'_setColumnset',getter:'_getColumnset',lazyAdd:false}};Y.mix(Table.prototype,{getColumn:function(name){var col,columns,i,len,cols;if(isObject(name)&&!isArray(name)){if(name instanceof Y.Node){col=this.body.getColumn(name);}else{col=name;}}else{col=this.get('columns.'+name);}
if(col){return col;}
columns=this.get('columns');if(isNumber(name)||isArray(name)){name=toArray(name);cols=columns;for(i=0,len=name.length-1;cols&&i<len;++i){cols=cols[name[i]]&&cols[name[i]].children;}
return(cols&&cols[name[i]])||null;}
return null;},getRecord:function(seed){var record=this.data.getById(seed)||this.data.getByClientId(seed);if(!record){if(isNumber(seed)){record=this.data.item(seed);}
if(!record&&this.view&&this.view.getRecord){record=this.view.getRecord.apply(this.view,arguments);}}
return record||null;},_allowAdHocAttrs:true,_afterColumnsChange:function(e){this._setColumnMap(e.newVal);},_afterDataChange:function(e){var modelList=e.newVal;this.data=e.newVal;if(!this.get('columns')&&modelList.size()){this._initColumns();}},_afterRecordTypeChange:function(e){var data=this.data.toJSON();this.data.model=e.newVal;this.data.reset(data);if(!this.get('columns')&&data){if(data.length){this._initColumns();}else{this.set('columns',keys(e.newVal.ATTRS));}}},_createRecordClass:function(attrs){var ATTRS,i,len;if(isArray(attrs)){ATTRS={};for(i=0,len=attrs.length;i<len;++i){ATTRS[attrs[i]]={};}}else if(isObject(attrs)){ATTRS=attrs;}
return Y.Base.create('record',Y.Model,[],null,{ATTRS:ATTRS});},destructor:function(){new Y.EventHandle(Y.Object.values(this._eventHandles)).detach();},_getColumns:function(columns,name){return name.length>8?this._columnMap:columns;},_getColumnset:function(_,name){return this.get(name.replace(/^columnset/,'columns'));},_getRecordType:function(val){return val||(this.data&&this.data.model);},_initColumns:function(){var columns=this.get('columns')||[],item;if(!columns.length&&this.data.size()){item=this.data.item(0);if(item.toJSON){item=item.toJSON();}
this.set('columns',keys(item));}
this._setColumnMap(columns);},_initCoreEvents:function(){this._eventHandles.coreAttrChanges=this.after({columnsChange:Y.bind('_afterColumnsChange',this),recordTypeChange:Y.bind('_afterRecordTypeChange',this),dataChange:Y.bind('_afterDataChange',this)});},_initData:function(){var recordType=this.get('recordType'),modelList=new Y.ModelList();if(recordType){modelList.model=recordType;}
return modelList;},_initDataProperty:function(data){var recordType;if(!this.data){recordType=this.get('recordType');if(data&&data.each&&data.toJSON){this.data=data;if(recordType){this.data.model=recordType;}}else{this.data=new Y.ModelList();if(recordType){this.data.model=recordType;}}
this.data.addTarget(this);}},initializer:function(config){var data=config.data,columns=config.columns,recordType;this._initDataProperty(data);if(!columns){recordType=(config.recordType||config.data===this.data)&&this.get('recordType');if(recordType){columns=keys(recordType.ATTRS);}else if(isArray(data)&&data.length){columns=keys(data[0]);}
if(columns){this.set('columns',columns);}}
this._initColumns();this._eventHandles={};this._initCoreEvents();},_setColumnMap:function(columns){var map={};function process(cols){var i,len,col,key;for(i=0,len=cols.length;i<len;++i){col=cols[i];key=col.key;if(key&&!map[key]){map[key]=col;}
map[col._id]=col;if(col.children){process(col.children);}}}
process(columns);this._columnMap=map;},_setColumns:function(val){var keys={},known=[],knownCopies=[],arrayIndex=Y.Array.indexOf;function copyObj(o){var copy={},key,val,i;known.push(o);knownCopies.push(copy);for(key in o){if(o.hasOwnProperty(key)){val=o[key];if(isArray(val)){copy[key]=val.slice();}else if(isObject(val,true)){i=arrayIndex(known,val);copy[key]=i===-1?copyObj(val):knownCopies[i];}else{copy[key]=o[key];}}}
return copy;}
function genId(name){name=name.replace(/\s+/,'-');if(keys[name]){name+=(keys[name]++);}else{keys[name]=1;}
return name;}
function process(cols,parent){var columns=[],i,len,col,yuid;for(i=0,len=cols.length;i<len;++i){columns[i]=col=isString(cols[i])?{key:cols[i]}:copyObj(cols[i]);yuid=Y.stamp(col);if(!col.id){col.id=yuid;}
if(col.field){col.name=col.field;}
if(parent){col._parent=parent;}else{delete col._parent;}
col._id=genId(col.name||col.key||col.id);if(isArray(col.children)){col.children=process(col.children,col);}}
return columns;}
return val&&process(val);},_setColumnset:function(val){this.set('columns',val);return isArray(val)?val:INVALID;},_setData:function(val){if(val===null){val=[];}
if(isArray(val)){this._initDataProperty();this.data.reset(val,{silent:true});val=this.data;}else if(!val||!val.each||!val.toJSON){val=INVALID;}
return val;},_setRecordset:function(val){var data;if(val&&Y.Recordset&&val instanceof Y.Recordset){data=[];val.each(function(record){data.push(record.get('data'));});val=data;}
this.set('data',val);return val;},_setRecordType:function(val){var modelClass;if(isFunction(val)&&val.prototype.toJSON&&val.prototype.setAttrs){modelClass=val;}else if(isObject(val)){modelClass=this._createRecordClass(val);}
return modelClass||INVALID;}});},'3.15.0',{"requires":["escape","model-list","node-event-delegate"]});