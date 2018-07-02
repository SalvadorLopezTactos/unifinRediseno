/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('io-xdr',function(Y,NAME){var E_XDR_READY=Y.publish('io:xdrReady',{fireOnce:true}),_cB={},_rS={},d=Y.config.doc,w=Y.config.win,xdr=w&&w.XDomainRequest;function _swf(uri,yid,uid){var o='<object id="io_swf" type="application/x-shockwave-flash" data="'+
uri+'" width="0" height="0">'+'<param name="movie" value="'+uri+'">'+'<param name="FlashVars" value="yid='+yid+'&uid='+uid+'">'+'<param name="allowScriptAccess" value="always">'+'</object>',c=d.createElement('div');d.body.appendChild(c);c.innerHTML=o;}
function _data(o,u,d){if(u==='flash'){o.c.responseText=decodeURI(o.c.responseText);}
if(d==='xml'){o.c.responseXML=Y.DataType.XML.parse(o.c.responseText);}
return o;}
function _abort(o,c){return o.c.abort(o.id,c);}
function _isInProgress(o){return xdr?_rS[o.id]!==4:o.c.isInProgress(o.id);}
Y.mix(Y.IO.prototype,{_transport:{},_ieEvt:function(o,c){var io=this,i=o.id,t='timeout';o.c.onprogress=function(){_rS[i]=3;};o.c.onload=function(){_rS[i]=4;io.xdrResponse('success',o,c);};o.c.onerror=function(){_rS[i]=4;io.xdrResponse('failure',o,c);};o.c.ontimeout=function(){_rS[i]=4;io.xdrResponse(t,o,c);};o.c[t]=c[t]||0;},xdr:function(uri,o,c){var io=this;if(c.xdr.use==='flash'){_cB[o.id]=c;w.setTimeout(function(){try{o.c.send(uri,{id:o.id,uid:o.uid,method:c.method,data:c.data,headers:c.headers});}
catch(e){io.xdrResponse('transport error',o,c);delete _cB[o.id];}},Y.io.xdr.delay);}
else if(xdr){io._ieEvt(o,c);o.c.open(c.method||'GET',uri);setTimeout(function(){o.c.send(c.data);},0);}
else{o.c.send(uri,o,c);}
return{id:o.id,abort:function(){return o.c?_abort(o,c):false;},isInProgress:function(){return o.c?_isInProgress(o.id):false;},io:io};},xdrResponse:function(e,o,c){c=_cB[o.id]?_cB[o.id]:c;var io=this,m=xdr?_rS:_cB,u=c.xdr.use,d=c.xdr.dataType;switch(e){case'start':io.start(o,c);break;case'success':io.success(_data(o,u,d),c);delete m[o.id];break;case'timeout':case'abort':case'transport error':o.c={status:0,statusText:e};case'failure':io.failure(_data(o,u,d),c);delete m[o.id];break;}},_xdrReady:function(yid,uid){Y.fire(E_XDR_READY,yid,uid);},transport:function(c){if(c.id==='flash'){_swf(Y.UA.ie?c.src+'?d='+new Date().valueOf().toString():c.src,Y.id,c.uid);Y.IO.transports.flash=function(){return d.getElementById('io_swf');};}}});Y.io.xdrReady=function(yid,uid){var io=Y.io._map[uid];Y.io.xdr.delay=0;io._xdrReady.apply(io,[yid,uid]);};Y.io.xdrResponse=function(e,o,c){var io=Y.io._map[o.uid];io.xdrResponse.apply(io,[e,o,c]);};Y.io.transport=function(c){var io=Y.io._map['io:0']||new Y.IO();c.uid=io._uid;io.transport.apply(io,[c]);};Y.io.xdr={delay:100};},'3.15.0',{"requires":["io-base","datatype-xml-parse"]});