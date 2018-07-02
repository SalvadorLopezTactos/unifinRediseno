/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('array-extras',function(Y,NAME){var A=Y.Array,L=Y.Lang,ArrayProto=Array.prototype;A.lastIndexOf=L._isNative(ArrayProto.lastIndexOf)?function(a,val,fromIndex){return fromIndex||fromIndex===0?a.lastIndexOf(val,fromIndex):a.lastIndexOf(val);}:function(a,val,fromIndex){var len=a.length,i=len-1;if(fromIndex||fromIndex===0){i=Math.min(fromIndex<0?len+fromIndex:fromIndex,len);}
if(i>-1&&len>0){for(;i>-1;--i){if(i in a&&a[i]===val){return i;}}}
return-1;};A.unique=function(array,testFn){var i=0,len=array.length,results=[],j,result,resultLen,value;outerLoop:for(;i<len;i++){value=array[i];for(j=0,resultLen=results.length;j<resultLen;j++){result=results[j];if(testFn){if(testFn.call(array,value,result,i,array)){continue outerLoop;}}else if(value===result){continue outerLoop;}}
results.push(value);}
return results;};A.filter=L._isNative(ArrayProto.filter)?function(a,f,o){return ArrayProto.filter.call(a,f,o);}:function(a,f,o){var i=0,len=a.length,results=[],item;for(;i<len;++i){if(i in a){item=a[i];if(f.call(o,item,i,a)){results.push(item);}}}
return results;};A.reject=function(a,f,o){return A.filter(a,function(item,i,a){return!f.call(o,item,i,a);});};A.every=L._isNative(ArrayProto.every)?function(a,f,o){return ArrayProto.every.call(a,f,o);}:function(a,f,o){for(var i=0,l=a.length;i<l;++i){if(i in a&&!f.call(o,a[i],i,a)){return false;}}
return true;};A.map=L._isNative(ArrayProto.map)?function(a,f,o){return ArrayProto.map.call(a,f,o);}:function(a,f,o){var i=0,len=a.length,results=ArrayProto.concat.call(a);for(;i<len;++i){if(i in a){results[i]=f.call(o,a[i],i,a);}}
return results;};A.reduce=L._isNative(ArrayProto.reduce)?function(a,init,f,o){return ArrayProto.reduce.call(a,function(init,item,i,a){return f.call(o,init,item,i,a);},init);}:function(a,init,f,o){var i=0,len=a.length,result=init;for(;i<len;++i){if(i in a){result=f.call(o,result,a[i],i,a);}}
return result;};A.find=function(a,f,o){for(var i=0,l=a.length;i<l;i++){if(i in a&&f.call(o,a[i],i,a)){return a[i];}}
return null;};A.grep=function(a,pattern){return A.filter(a,function(item,index){return pattern.test(item);});};A.partition=function(a,f,o){var results={matches:[],rejects:[]};A.each(a,function(item,index){var set=f.call(o,item,index,a)?results.matches:results.rejects;set.push(item);});return results;};A.zip=function(a,a2){var results=[];A.each(a,function(item,index){results.push([item,a2[index]]);});return results;};A.flatten=function(a){var result=[],i,len,val;if(!a){return result;}
for(i=0,len=a.length;i<len;++i){val=a[i];if(L.isArray(val)){result.push.apply(result,A.flatten(val));}else{result.push(val);}}
return result;};},'3.15.0',{"requires":["yui-base"]});