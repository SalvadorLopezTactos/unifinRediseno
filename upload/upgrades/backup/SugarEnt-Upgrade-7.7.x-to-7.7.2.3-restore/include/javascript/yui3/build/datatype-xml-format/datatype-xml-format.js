/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('datatype-xml-format',function(Y,NAME){var LANG=Y.Lang;Y.mix(Y.namespace("XML"),{format:function(data){try{if(!LANG.isUndefined(data.getXml)){return data.getXml();}
if(!LANG.isUndefined(XMLSerializer)){return(new XMLSerializer()).serializeToString(data);}}
catch(e){if(data&&data.xml){return data.xml;}
else{return(LANG.isValue(data)&&data.toString)?data.toString():"";}}}});Y.namespace("DataType");Y.DataType.XML=Y.XML;},'3.15.0');