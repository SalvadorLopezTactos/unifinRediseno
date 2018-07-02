/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('datatype-date-parse',function(Y,NAME){Y.mix(Y.namespace("Date"),{parse:function(data){var val=new Date(+data||data);if(Y.Lang.isDate(val)){return val;}else{return null;}}});Y.namespace("Parsers").date=Y.Date.parse;Y.namespace("DataType");Y.DataType.Date=Y.Date;},'3.15.0');