/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('io-upload-iframe',function(Y,NAME){var w=Y.config.win,d=Y.config.doc,_std=(d.documentMode&&d.documentMode>=8),_d=decodeURIComponent,_end=Y.IO.prototype.end;function _cFrame(o,c,io){var i=Y.Node.create('<iframe src="#" id="io_iframe'+o.id+'" name="io_iframe'+o.id+'" />');i._node.style.position='absolute';i._node.style.top='-1000px';i._node.style.left='-1000px';Y.one('body').appendChild(i);Y.on("load",function(){io._uploadComplete(o,c);},'#io_iframe'+o.id);}
function _dFrame(id){Y.Event.purgeElement('#io_iframe'+id,false);Y.one('body').removeChild(Y.one('#io_iframe'+id));}
Y.mix(Y.IO.prototype,{_addData:function(f,s){if(Y.Lang.isObject(s)){s=Y.QueryString.stringify(s);}
var o=[],m=s.split('='),i,l;for(i=0,l=m.length-1;i<l;i++){o[i]=d.createElement('input');o[i].type='hidden';o[i].name=_d(m[i].substring(m[i].lastIndexOf('&')+1));o[i].value=(i+1===l)?_d(m[i+1]):_d(m[i+1].substring(0,(m[i+1].lastIndexOf('&'))));f.appendChild(o[i]);}
return o;},_removeData:function(f,o){var i,l;for(i=0,l=o.length;i<l;i++){f.removeChild(o[i]);}},_setAttrs:function(f,id,uri){this._originalFormAttrs={action:f.getAttribute('action'),target:f.getAttribute('target')};f.setAttribute('action',uri);f.setAttribute('method','POST');f.setAttribute('target','io_iframe'+id);f.setAttribute(Y.UA.ie&&!_std?'encoding':'enctype','multipart/form-data');},_resetAttrs:function(f,a){Y.Object.each(a,function(v,p){if(v){f.setAttribute(p,v);}
else{f.removeAttribute(p);}});},_startUploadTimeout:function(o,c){var io=this;io._timeout[o.id]=w.setTimeout(function(){o.status=0;o.statusText='timeout';io.complete(o,c);io.end(o,c);},c.timeout);},_clearUploadTimeout:function(id){var io=this;w.clearTimeout(io._timeout[id]);delete io._timeout[id];},_uploadComplete:function(o,c){var io=this,d=Y.one('#io_iframe'+o.id).get('contentWindow.document'),b=d.one('body'),p;if(c.timeout){io._clearUploadTimeout(o.id);}
try{if(b){p=b.one('pre:first-child');o.c.responseText=p?p.get('text'):b.get('text');}
else{o.c.responseXML=d._node;}}
catch(e){o.e="upload failure";}
io.complete(o,c);io.end(o,c);w.setTimeout(function(){_dFrame(o.id);},0);},_upload:function(o,uri,c){var io=this,f=(typeof c.form.id==='string')?d.getElementById(c.form.id):c.form.id,fields;io._setAttrs(f,o.id,uri);if(c.data){fields=io._addData(f,c.data);}
if(c.timeout){io._startUploadTimeout(o,c);}
f.submit();io.start(o,c);if(c.data){io._removeData(f,fields);}
return{id:o.id,abort:function(){o.status=0;o.statusText='abort';if(Y.one('#io_iframe'+o.id)){_dFrame(o.id);io.complete(o,c);io.end(o,c);}
else{return false;}},isInProgress:function(){return Y.one('#io_iframe'+o.id)?true:false;},io:io};},upload:function(o,uri,c){_cFrame(o,c,this);return this._upload(o,uri,c);},end:function(transaction,config){var form,io;if(config){form=config.form;if(form&&form.upload){io=this;form=(typeof form.id==='string')?d.getElementById(form.id):form.id;if(form){io._resetAttrs(form,this._originalFormAttrs);}}}
return _end.call(this,transaction,config);}},true);},'3.15.0',{"requires":["io-base","node-base"]});