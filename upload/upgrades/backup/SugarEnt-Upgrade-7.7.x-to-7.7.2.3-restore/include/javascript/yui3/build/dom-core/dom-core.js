/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('dom-core',function(Y,NAME){var NODE_TYPE='nodeType',OWNER_DOCUMENT='ownerDocument',DOCUMENT_ELEMENT='documentElement',DEFAULT_VIEW='defaultView',PARENT_WINDOW='parentWindow',TAG_NAME='tagName',PARENT_NODE='parentNode',PREVIOUS_SIBLING='previousSibling',NEXT_SIBLING='nextSibling',CONTAINS='contains',COMPARE_DOCUMENT_POSITION='compareDocumentPosition',EMPTY_ARRAY=[],supportsContainsTextNode=(function(){var node=Y.config.doc.createElement('div'),textNode=node.appendChild(Y.config.doc.createTextNode('')),result=false;try{result=node.contains(textNode);}catch(e){}
return result;})(),Y_DOM={byId:function(id,doc){return Y_DOM.allById(id,doc)[0]||null;},getId:function(node){var id;if(node.id&&!node.id.tagName&&!node.id.item){id=node.id;}else if(node.attributes&&node.attributes.id){id=node.attributes.id.value;}
return id;},setId:function(node,id){if(node.setAttribute){node.setAttribute('id',id);}else{node.id=id;}},ancestor:function(element,fn,testSelf,stopFn){var ret=null;if(testSelf){ret=(!fn||fn(element))?element:null;}
return ret||Y_DOM.elementByAxis(element,PARENT_NODE,fn,null,stopFn);},ancestors:function(element,fn,testSelf,stopFn){var ancestor=element,ret=[];while((ancestor=Y_DOM.ancestor(ancestor,fn,testSelf,stopFn))){testSelf=false;if(ancestor){ret.unshift(ancestor);if(stopFn&&stopFn(ancestor)){return ret;}}}
return ret;},elementByAxis:function(element,axis,fn,all,stopAt){while(element&&(element=element[axis])){if((all||element[TAG_NAME])&&(!fn||fn(element))){return element;}
if(stopAt&&stopAt(element)){return null;}}
return null;},contains:function(element,needle){var ret=false;if(!needle||!element||!needle[NODE_TYPE]||!element[NODE_TYPE]){ret=false;}else if(element[CONTAINS]&&(needle[NODE_TYPE]===1||supportsContainsTextNode)){ret=element[CONTAINS](needle);}else if(element[COMPARE_DOCUMENT_POSITION]){if(element===needle||!!(element[COMPARE_DOCUMENT_POSITION](needle)&16)){ret=true;}}else{ret=Y_DOM._bruteContains(element,needle);}
return ret;},inDoc:function(element,doc){var ret=false,rootNode;if(element&&element.nodeType){(doc)||(doc=element[OWNER_DOCUMENT]);rootNode=doc[DOCUMENT_ELEMENT];if(rootNode&&rootNode.contains&&element.tagName){ret=rootNode.contains(element);}else{ret=Y_DOM.contains(rootNode,element);}}
return ret;},allById:function(id,root){root=root||Y.config.doc;var nodes=[],ret=[],i,node;if(root.querySelectorAll){ret=root.querySelectorAll('[id="'+id+'"]');}else if(root.all){nodes=root.all(id);if(nodes){if(nodes.nodeName){if(nodes.id===id){ret.push(nodes);nodes=EMPTY_ARRAY;}else{nodes=[nodes];}}
if(nodes.length){for(i=0;node=nodes[i++];){if(node.id===id||(node.attributes&&node.attributes.id&&node.attributes.id.value===id)){ret.push(node);}}}}}else{ret=[Y_DOM._getDoc(root).getElementById(id)];}
return ret;},isWindow:function(obj){return!!(obj&&obj.scrollTo&&obj.document);},_removeChildNodes:function(node){while(node.firstChild){node.removeChild(node.firstChild);}},siblings:function(node,fn){var nodes=[],sibling=node;while((sibling=sibling[PREVIOUS_SIBLING])){if(sibling[TAG_NAME]&&(!fn||fn(sibling))){nodes.unshift(sibling);}}
sibling=node;while((sibling=sibling[NEXT_SIBLING])){if(sibling[TAG_NAME]&&(!fn||fn(sibling))){nodes.push(sibling);}}
return nodes;},_bruteContains:function(element,needle){while(needle){if(element===needle){return true;}
needle=needle.parentNode;}
return false;},_getRegExp:function(str,flags){flags=flags||'';Y_DOM._regexCache=Y_DOM._regexCache||{};if(!Y_DOM._regexCache[str+flags]){Y_DOM._regexCache[str+flags]=new RegExp(str,flags);}
return Y_DOM._regexCache[str+flags];},_getDoc:function(element){var doc=Y.config.doc;if(element){doc=(element[NODE_TYPE]===9)?element:element[OWNER_DOCUMENT]||element.document||Y.config.doc;}
return doc;},_getWin:function(element){var doc=Y_DOM._getDoc(element);return doc[DEFAULT_VIEW]||doc[PARENT_WINDOW]||Y.config.win;},_batch:function(nodes,fn,arg1,arg2,arg3,etc){fn=(typeof fn==='string')?Y_DOM[fn]:fn;var result,i=0,node,ret;if(fn&&nodes){while((node=nodes[i++])){result=result=fn.call(Y_DOM,node,arg1,arg2,arg3,etc);if(typeof result!=='undefined'){(ret)||(ret=[]);ret.push(result);}}}
return(typeof ret!=='undefined')?ret:nodes;},generateID:function(el){var id=el.id;if(!id){id=Y.stamp(el);el.id=id;}
return id;}};Y.DOM=Y_DOM;},'3.15.0',{"requires":["oop","features"]});