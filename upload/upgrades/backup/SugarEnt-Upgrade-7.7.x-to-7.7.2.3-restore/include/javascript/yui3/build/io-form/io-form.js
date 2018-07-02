/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('io-form',function(Y,NAME){var eUC=encodeURIComponent;Y.IO.stringify=function(form,options){options=options||{};var s=Y.IO.prototype._serialize({id:form,useDisabled:options.useDisabled},options.extra&&typeof options.extra==='object'?Y.QueryString.stringify(options.extra):options.extra);return s;};Y.mix(Y.IO.prototype,{_serialize:function(c,s){var data=[],df=c.useDisabled||false,item=0,id=(typeof c.id==='string')?c.id:c.id.getAttribute('id'),e,f,n,v,d,i,il,j,jl,o;if(!id){id=Y.guid('io:');c.id.setAttribute('id',id);}
f=Y.config.doc.getElementById(id);if(!f||!f.elements){return s||'';}
for(i=0,il=f.elements.length;i<il;++i){e=f.elements[i];d=e.disabled;n=e.name;if(df?n:n&&!d){n=eUC(n)+'=';v=eUC(e.value);switch(e.type){case'select-one':if(e.selectedIndex>-1){o=e.options[e.selectedIndex];data[item++]=n+eUC(o.attributes.value&&o.attributes.value.specified?o.value:o.text);}
break;case'select-multiple':if(e.selectedIndex>-1){for(j=e.selectedIndex,jl=e.options.length;j<jl;++j){o=e.options[j];if(o.selected){data[item++]=n+eUC(o.attributes.value&&o.attributes.value.specified?o.value:o.text);}}}
break;case'radio':case'checkbox':if(e.checked){data[item++]=n+v;}
break;case'file':case undefined:case'reset':case'button':break;case'submit':default:data[item++]=n+v;}}}
if(s){data[item++]=s;}
return data.join('&');}},true);},'3.15.0',{"requires":["io-base","node-base"]});