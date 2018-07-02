/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('arraysort',function(Y,NAME){var LANG=Y.Lang,ISVALUE=LANG.isValue,ISSTRING=LANG.isString;var ArraySort=Y.ArraySort={compare:function(a,b,desc){if(!ISVALUE(a)){if(!ISVALUE(b)){return 0;}
else{return 1;}}
else if(!ISVALUE(b)){return-1;}
if(ISSTRING(a)){a=a.toLowerCase();}
if(ISSTRING(b)){b=b.toLowerCase();}
if(a<b){return(desc)?1:-1;}
else if(a>b){return(desc)?-1:1;}
else{return 0;}},naturalCompare:function(a,b,options){a+='';b+='';if(!options||!options.caseSensitive){a=a.toLowerCase();b=b.toLowerCase();}
var aParts=ArraySort._splitAlphaNum(a),bParts=ArraySort._splitAlphaNum(b),length=Math.min(aParts.length,bParts.length),result=0,aPart,bPart,i;for(i=0;i<length;i++){aPart=aParts[i];bPart=bParts[i];if(aPart!==bPart){result=aPart-bPart;if(!result){result=aPart>bPart?1:-1;}
break;}}
result||(result=a.length-b.length);return options&&options.descending?-result:result;},_splitAlphaNum:function(string){var parts=[],regex=/(\d+|\D+)/g,match;while(match=regex.exec(string)){parts.push(match[1]);}
return parts;}};},'3.15.0',{"requires":["yui-base"]});