/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('jsonp',function(Y,NAME){var isFunction=Y.Lang.isFunction;function JSONPRequest(){this._init.apply(this,arguments);}
JSONPRequest.prototype={_init:function(url,callback){this.url=url;this._requests={};this._timeouts={};callback=(isFunction(callback))?{on:{success:callback}}:callback||{};var subs=callback.on||{};if(!subs.success){subs.success=this._defaultCallback(url,callback);}
this._config=Y.merge({context:this,args:[],format:this._format,allowCache:false},callback,{on:subs});},_defaultCallback:function(){},send:function(){var self=this,args=Y.Array(arguments,0,true),config=self._config,proxy=self._proxy||Y.guid(),url;if(config.allowCache){self._proxy=proxy;}
if(self._requests[proxy]===undefined){self._requests[proxy]=0;}
if(self._timeouts[proxy]===undefined){self._timeouts[proxy]=0;}
self._requests[proxy]++;args.unshift(self.url,'YUI.Env.JSONP.'+proxy);url=config.format.apply(self,args);if(!config.on.success){return self;}
function wrap(fn,isTimeout){return(isFunction(fn))?function(data){var execute=true,counter='_requests';if(isTimeout){++self._timeouts[proxy];--self._requests[proxy];}else{if(!self._requests[proxy]){execute=false;counter='_timeouts';}
--self[counter][proxy];}
if(!self._requests[proxy]&&!self._timeouts[proxy]){delete YUI.Env.JSONP[proxy];}
if(execute){fn.apply(config.context,[data].concat(config.args));}}:null;}
YUI.Env.JSONP[proxy]=wrap(config.on.success);Y.Get.js(url,{onFailure:wrap(config.on.failure),onTimeout:wrap(config.on.timeout,true),timeout:config.timeout,charset:config.charset,attributes:config.attributes,async:config.async}).execute();return self;},_format:function(url,proxy){return url.replace(/\{callback\}/,proxy);}};Y.JSONPRequest=JSONPRequest;Y.jsonp=function(url,c){var req=new Y.JSONPRequest(url,c);return req.send.apply(req,Y.Array(arguments,2,true));};if(!YUI.Env.JSONP){YUI.Env.JSONP={};}},'3.15.0',{"requires":["get","oop"]});