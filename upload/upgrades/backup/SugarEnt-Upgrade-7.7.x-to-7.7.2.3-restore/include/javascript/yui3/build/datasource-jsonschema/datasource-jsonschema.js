/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('datasource-jsonschema',function(Y,NAME){var DataSourceJSONSchema=function(){DataSourceJSONSchema.superclass.constructor.apply(this,arguments);};Y.mix(DataSourceJSONSchema,{NS:"schema",NAME:"dataSourceJSONSchema",ATTRS:{schema:{}}});Y.extend(DataSourceJSONSchema,Y.Plugin.Base,{initializer:function(config){this.doBefore("_defDataFn",this._beforeDefDataFn);},_beforeDefDataFn:function(e){var data=e.data&&(e.data.responseText||e.data),schema=this.get('schema'),payload=e.details[0];payload.response=Y.DataSchema.JSON.apply.call(this,schema,data)||{meta:{},results:data};this.get("host").fire("response",payload);return new Y.Do.Halt("DataSourceJSONSchema plugin halted _defDataFn");}});Y.namespace('Plugin').DataSourceJSONSchema=DataSourceJSONSchema;},'3.15.0',{"requires":["datasource-local","plugin","dataschema-json"]});