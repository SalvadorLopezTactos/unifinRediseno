/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('datatype-number-format',function(Y,NAME){var LANG=Y.Lang;Y.mix(Y.namespace("Number"),{format:function(data,config){if(LANG.isNumber(data)){config=config||{};var isNeg=(data<0),output=data+"",decPlaces=config.decimalPlaces,decSep=config.decimalSeparator||".",thouSep=config.thousandsSeparator,decIndex,newOutput,count,i;if(LANG.isNumber(decPlaces)&&(decPlaces>=0)&&(decPlaces<=20)){output=data.toFixed(decPlaces);}
if(decSep!=="."){output=output.replace(".",decSep);}
if(thouSep){decIndex=output.lastIndexOf(decSep);decIndex=(decIndex>-1)?decIndex:output.length;newOutput=output.substring(decIndex);for(count=0,i=decIndex;i>0;i--){if((count%3===0)&&(i!==decIndex)&&(!isNeg||(i>1))){newOutput=thouSep+newOutput;}
newOutput=output.charAt(i-1)+newOutput;count++;}
output=newOutput;}
output=(config.prefix)?config.prefix+output:output;output=(config.suffix)?output+config.suffix:output;return output;}
else{return(LANG.isValue(data)&&data.toString)?data.toString():"";}}});Y.namespace("DataType");Y.DataType.Number=Y.Number;},'3.15.0');