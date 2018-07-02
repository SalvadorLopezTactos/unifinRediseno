/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('io-nodejs',function(Y,NAME){if(!Y.IO.request){Y.IO.request=require('request').defaults({jar:false});}
var codes=require('http').STATUS_CODES;var flatten=function(o){var str=[];Object.keys(o).forEach(function(name){str.push(name+': '+o[name]);});return str.join('\n');};Y.IO.transports.nodejs=function(){return{send:function(transaction,uri,config){config.notify('start',transaction,config);config.method=config.method||'GET';config.method=config.method.toUpperCase();var rconf={method:config.method,uri:uri};if(config.data){if(Y.Lang.isString(config.data)){rconf.body=config.data;}
if(rconf.body&&rconf.method==='GET'){rconf.uri+=(rconf.uri.indexOf('?')>-1?'&':'?')+rconf.body;rconf.body='';}}
if(config.headers){rconf.headers=config.headers;}
if(config.timeout){rconf.timeout=config.timeout;}
if(config.request){Y.mix(rconf,config.request);}
Y.IO.request(rconf,function(err,data){if(err){transaction.c=err;config.notify(((err.code==='ETIMEDOUT')?'timeout':'failure'),transaction,config);return;}
if(data){transaction.c={status:data.statusCode,statusCode:data.statusCode,statusText:codes[data.statusCode],headers:data.headers,responseText:data.body||'',responseXML:null,getResponseHeader:function(name){return this.headers[name];},getAllResponseHeaders:function(){return flatten(this.headers);}};}
config.notify('complete',transaction,config);config.notify(((data&&(data.statusCode>=200&&data.statusCode<=299))?'success':'failure'),transaction,config);});var ret={io:transaction};return ret;}};};Y.IO.defaultTransport('nodejs');},'3.15.0',{"requires":["io-base"]});