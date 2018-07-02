/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('json-stringify',function(Y,NAME){var COLON=':',_JSON=Y.config.global.JSON;Y.mix(Y.namespace('JSON'),{dateToString:function(d){function _zeroPad(v){return v<10?'0'+v:v;}
return d.getUTCFullYear()+'-'+
_zeroPad(d.getUTCMonth()+1)+'-'+
_zeroPad(d.getUTCDate())+'T'+
_zeroPad(d.getUTCHours())+COLON+
_zeroPad(d.getUTCMinutes())+COLON+
_zeroPad(d.getUTCSeconds())+'Z';},stringify:function(){return _JSON.stringify.apply(_JSON,arguments);},charCacheThreshold:100});},'3.15.0',{"requires":["yui-base"]});