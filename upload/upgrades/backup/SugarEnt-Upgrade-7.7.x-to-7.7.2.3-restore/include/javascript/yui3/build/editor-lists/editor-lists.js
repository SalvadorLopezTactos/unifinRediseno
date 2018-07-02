/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('editor-lists',function(Y,NAME){var EditorLists=function(){EditorLists.superclass.constructor.apply(this,arguments);},LI='li',OL='ol',UL='ul',HOST='host';Y.extend(EditorLists,Y.Base,{_onNodeChange:function(e){var inst=this.get(HOST).getInstance(),li,newList,sTab,par,moved=false,tag,focusEnd=false;if(e.changedType==='tab'){if(e.changedNode.test(LI+', '+LI+' *')){e.changedEvent.halt();e.preventDefault();li=e.changedNode;sTab=e.changedEvent.shiftKey;par=li.ancestor(OL+','+UL);tag=UL;if(par.get('tagName').toLowerCase()===OL){tag=OL;}
if(!li.test(LI)){li=li.ancestor(LI);}
if(sTab){if(li.ancestor(LI)){li.ancestor(LI).insert(li,'after');moved=true;focusEnd=true;}}else{if(li.previous(LI)){newList=inst.Node.create('<'+tag+'></'+tag+'>');li.previous(LI).append(newList);newList.append(li);moved=true;}}}
if(moved){if(!li.test(LI)){li=li.ancestor(LI);}
li.all(EditorLists.REMOVE).remove();if(Y.UA.ie){li=li.append(EditorLists.NON).one(EditorLists.NON_SEL);}
(new inst.EditorSelection()).selectNode(li,true,focusEnd);}}},initializer:function(){this.get(HOST).on('nodeChange',Y.bind(this._onNodeChange,this));}},{NON:'<span class="yui-non">&nbsp;</span>',NON_SEL:'span.yui-non',REMOVE:'br',NAME:'editorLists',NS:'lists',ATTRS:{host:{value:false}}});Y.namespace('Plugin');Y.Plugin.EditorLists=EditorLists;},'3.15.0',{"requires":["editor-base"]});