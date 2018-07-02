/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('array-invoke',function(Y,NAME){Y.Array.invoke=function(items,name){var args=Y.Array(arguments,2,true),isFunction=Y.Lang.isFunction,ret=[];Y.Array.each(Y.Array(items),function(item,i){if(item&&isFunction(item[name])){ret[i]=item[name].apply(item,args);}});return ret;};},'3.15.0',{"requires":["yui-base"]});