/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('yui-log',function(Y,NAME){var INSTANCE=Y,LOGEVENT='yui:log',UNDEFINED='undefined',LEVELS={debug:1,info:2,warn:4,error:8};INSTANCE.log=function(msg,cat,src,silent){var bail,excl,incl,m,f,minlevel,Y=INSTANCE,c=Y.config,publisher=(Y.fire)?Y:YUI.Env.globalEvents;if(c.debug){src=src||"";if(typeof src!=="undefined"){excl=c.logExclude;incl=c.logInclude;if(incl&&!(src in incl)){bail=1;}else if(incl&&(src in incl)){bail=!incl[src];}else if(excl&&(src in excl)){bail=excl[src];}
if((typeof cat==='undefined')||!(cat in LEVELS)){cat='info';}
Y.config.logLevel=Y.config.logLevel||'debug';minlevel=LEVELS[Y.config.logLevel.toLowerCase()];if(cat in LEVELS&&LEVELS[cat]<minlevel){bail=1;}}
if(!bail){if(c.useBrowserConsole){m=(src)?src+': '+msg:msg;if(Y.Lang.isFunction(c.logFn)){c.logFn.call(Y,msg,cat,src);}else if(typeof console!==UNDEFINED&&console.log){f=(cat&&console[cat]&&(cat in LEVELS))?cat:'log';console[f](m);}else if(typeof opera!==UNDEFINED){opera.postError(m);}}
if(publisher&&!silent){if(publisher===Y&&(!publisher.getEvent(LOGEVENT))){publisher.publish(LOGEVENT,{broadcast:2});}
publisher.fire(LOGEVENT,{msg:msg,cat:cat,src:src});}}}
return Y;};INSTANCE.message=function(){return INSTANCE.log.apply(INSTANCE,arguments);};},'3.15.0',{"requires":["yui-base"]});