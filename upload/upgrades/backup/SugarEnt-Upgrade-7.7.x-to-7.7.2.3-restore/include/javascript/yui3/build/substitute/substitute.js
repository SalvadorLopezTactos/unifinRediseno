/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('substitute',function(Y,NAME){var L=Y.Lang,DUMP='dump',SPACE=' ',LBRACE='{',RBRACE='}',savedRegExp=/(~-(\d+)-~)/g,lBraceRegExp=/\{LBRACE\}/g,rBraceRegExp=/\{RBRACE\}/g,substitute=function(s,o,f,recurse){var i,j,k,key,v,meta,saved=[],token,dump,lidx=s.length;for(;;){i=s.lastIndexOf(LBRACE,lidx);if(i<0){break;}
j=s.indexOf(RBRACE,i);if(i+1>=j){break;}
token=s.substring(i+1,j);key=token;meta=null;k=key.indexOf(SPACE);if(k>-1){meta=key.substring(k+1);key=key.substring(0,k);}
v=o[key];if(f){v=f(key,v,meta);}
if(L.isObject(v)){if(!Y.dump){v=v.toString();}else{if(L.isArray(v)){v=Y.dump(v,parseInt(meta,10));}else{meta=meta||'';dump=meta.indexOf(DUMP);if(dump>-1){meta=meta.substring(4);}
if(v.toString===Object.prototype.toString||dump>-1){v=Y.dump(v,parseInt(meta,10));}else{v=v.toString();}}}}else if(L.isUndefined(v)){v='~-'+saved.length+'-~';saved.push(token);}
s=s.substring(0,i)+v+s.substring(j+1);if(!recurse){lidx=i-1;}}
return s.replace(savedRegExp,function(str,p1,p2){return LBRACE+saved[parseInt(p2,10)]+RBRACE;}).replace(lBraceRegExp,LBRACE).replace(rBraceRegExp,RBRACE);};Y.substitute=substitute;L.substitute=substitute;},'3.15.0',{"requires":["yui-base"],"optional":["dump"]});