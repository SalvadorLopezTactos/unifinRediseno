/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('datasource-polling',function(Y,NAME){function Pollable(){this._intervals={};}
Pollable.prototype={_intervals:null,setInterval:function(msec,request){var x=Y.later(msec,this,this.sendRequest,[request],true);this._intervals[x.id]=x;Y.later(0,this,this.sendRequest,[request]);return x.id;},clearInterval:function(id,key){id=key||id;if(this._intervals[id]){this._intervals[id].cancel();delete this._intervals[id];}},clearAllIntervals:function(){Y.each(this._intervals,this.clearInterval,this);}};Y.augment(Y.DataSource.Local,Pollable);},'3.15.0',{"requires":["datasource-local"]});