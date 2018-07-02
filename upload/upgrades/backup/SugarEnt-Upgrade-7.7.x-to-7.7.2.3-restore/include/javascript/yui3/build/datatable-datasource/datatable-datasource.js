/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('datatable-datasource',function(Y,NAME){function DataTableDataSource(){DataTableDataSource.superclass.constructor.apply(this,arguments);}
Y.mix(DataTableDataSource,{NS:"datasource",NAME:"dataTableDataSource",ATTRS:{datasource:{setter:"_setDataSource"},initialRequest:{setter:"_setInitialRequest"}}});Y.extend(DataTableDataSource,Y.Plugin.Base,{_setDataSource:function(ds){return ds||new Y.DataSource.Local(ds);},_setInitialRequest:function(){},initializer:function(config){if(!Y.Lang.isUndefined(config.initialRequest)){this.load({request:config.initialRequest});}},load:function(config){config=config||{};config.request=config.request||this.get("initialRequest");config.callback=config.callback||{success:Y.bind(this.onDataReturnInitializeTable,this),failure:Y.bind(this.onDataReturnInitializeTable,this),argument:this.get("host").get("state")};var ds=(config.datasource||this.get("datasource"));if(ds){ds.sendRequest(config);}},onDataReturnInitializeTable:function(e){var records=(e.response&&e.response.results)||[];this.get("host").set("data",records);}});Y.namespace("Plugin").DataTableDataSource=DataTableDataSource;},'3.15.0',{"requires":["datatable-base","plugin","datasource-local"]});