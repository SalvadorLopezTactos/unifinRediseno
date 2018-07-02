/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('get',function(Y,NAME){var Module=require('module'),path=require('path'),fs=require('fs'),request=require('request'),end=function(cb,msg,result){if(Y.Lang.isFunction(cb.onEnd)){cb.onEnd.call(Y,msg,result);}},pass=function(cb){if(Y.Lang.isFunction(cb.onSuccess)){cb.onSuccess.call(Y,cb);}
end(cb,'success','success');},fail=function(cb,er){er.errors=[er];if(Y.Lang.isFunction(cb.onFailure)){cb.onFailure.call(Y,er,cb);}
end(cb,er,'fail');};Y.Get=function(){};Y.config.base=path.join(__dirname,'../');YUI.require=require;YUI.process=process;Y.Get._exec=function(data,url,cb){if(data.charCodeAt(0)===0xFEFF){data=data.slice(1);}
var mod=new Module(url,module);mod.filename=url;mod.paths=Module._nodeModulePaths(path.dirname(url));if(typeof YUI._getLoadHook==='function'){data=YUI._getLoadHook(data,url);}
mod._compile('module.exports = function (YUI) {'+'return (function () {'+data+'\n;return YUI;}).apply(global);'+'};',url);YUI=mod.exports(YUI);mod.loaded=true;cb(null,url);};Y.Get._include=function(url,cb){var cfg,mod,self=this;if(url.match(/^https?:\/\//)){cfg={url:url,timeout:self.timeout};request(cfg,function(err,response,body){if(err){cb(err,url);}else{Y.Get._exec(body,url,cb);}});}else{try{url=Module._findPath(url,Module._resolveLookupPaths(url,module.parent.parent)[1]);if(Y.config.useSync){mod=fs.readFileSync(url,'utf8');}else{fs.readFile(url,'utf8',function(err,mod){if(err){cb(err,url);}else{Y.Get._exec(mod,url,cb);}});return;}}catch(err){cb(err,url);return;}
Y.Get._exec(mod,url,cb);}};Y.Get.js=function(s,options){var urls=Y.Array(s),url,i,l=urls.length,c=0,check=function(){if(c===l){pass(options);}};for(i=0;i<l;i++){url=urls[i];if(Y.Lang.isObject(url)){url=url.url;}
url=url.replace(/'/g,'%27');Y.Get._include(url,function(err,url){if(!Y.config){Y.config={debug:true};}
if(options.onProgress){options.onProgress.call(options.context||Y,url);}
if(err){fail(options,err);}else{c++;check();}});}
return{execute:function(){}};};Y.Get.script=Y.Get.js;Y.Get.css=function(s,cb){pass(cb);};},'@VERSION@');