/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('yui-later',function(Y,NAME){var NO_ARGS=[];Y.later=function(when,o,fn,data,periodic){when=when||0;data=(!Y.Lang.isUndefined(data))?Y.Array(data):NO_ARGS;o=o||Y.config.win||Y;var cancelled=false,method=(o&&Y.Lang.isString(fn))?o[fn]:fn,wrapper=function(){if(!cancelled){if(!method.apply){method(data[0],data[1],data[2],data[3]);}else{method.apply(o,data||NO_ARGS);}}},id=(periodic)?setInterval(wrapper,when):setTimeout(wrapper,when);return{id:id,interval:periodic,cancel:function(){cancelled=true;if(this.interval){clearInterval(id);}else{clearTimeout(id);}}};};Y.Lang.later=Y.later;},'3.15.0',{"requires":["yui-base"]});