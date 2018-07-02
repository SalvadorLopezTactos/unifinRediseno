/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('event-focus',function(Y,NAME){var Event=Y.Event,YLang=Y.Lang,isString=YLang.isString,arrayIndex=Y.Array.indexOf,useActivate=(function(){var supported=false,doc=Y.config.doc,p;if(doc){p=doc.createElement("p");p.setAttribute("onbeforeactivate",";");supported=(p.onbeforeactivate!==undefined);}
return supported;}());function define(type,proxy,directEvent){var nodeDataKey='_'+type+'Notifiers';Y.Event.define(type,{_useActivate:useActivate,_attach:function(el,notifier,delegate){if(Y.DOM.isWindow(el)){return Event._attach([type,function(e){notifier.fire(e);},el]);}else{return Event._attach([proxy,this._proxy,el,this,notifier,delegate],{capture:true});}},_proxy:function(e,notifier,delegate){var target=e.target,currentTarget=e.currentTarget,notifiers=target.getData(nodeDataKey),yuid=Y.stamp(currentTarget._node),defer=(useActivate||target!==currentTarget),directSub;notifier.currentTarget=(delegate)?target:currentTarget;notifier.container=(delegate)?currentTarget:null;if(!notifiers){notifiers={};target.setData(nodeDataKey,notifiers);if(defer){directSub=Event._attach([directEvent,this._notify,target._node]).sub;directSub.once=true;}}else{defer=true;}
if(!notifiers[yuid]){notifiers[yuid]=[];}
notifiers[yuid].push(notifier);if(!defer){this._notify(e);}},_notify:function(e,container){var currentTarget=e.currentTarget,notifierData=currentTarget.getData(nodeDataKey),axisNodes=currentTarget.ancestors(),doc=currentTarget.get('ownerDocument'),delegates=[],count=notifierData?Y.Object.keys(notifierData).length:0,target,notifiers,notifier,yuid,match,tmp,i,len,sub,ret;currentTarget.clearData(nodeDataKey);axisNodes.push(currentTarget);if(doc){axisNodes.unshift(doc);}
axisNodes._nodes.reverse();if(count){tmp=count;axisNodes.some(function(node){var yuid=Y.stamp(node),notifiers=notifierData[yuid],i,len;if(notifiers){count--;for(i=0,len=notifiers.length;i<len;++i){if(notifiers[i].handle.sub.filter){delegates.push(notifiers[i]);}}}
return!count;});count=tmp;}
while(count&&(target=axisNodes.shift())){yuid=Y.stamp(target);notifiers=notifierData[yuid];if(notifiers){for(i=0,len=notifiers.length;i<len;++i){notifier=notifiers[i];sub=notifier.handle.sub;match=true;e.currentTarget=target;if(sub.filter){match=sub.filter.apply(target,[target,e].concat(sub.args||[]));delegates.splice(arrayIndex(delegates,notifier),1);}
if(match){e.container=notifier.container;ret=notifier.fire(e);}
if(ret===false||e.stopped===2){break;}}
delete notifiers[yuid];count--;}
if(e.stopped!==2){for(i=0,len=delegates.length;i<len;++i){notifier=delegates[i];sub=notifier.handle.sub;if(sub.filter.apply(target,[target,e].concat(sub.args||[]))){e.container=notifier.container;e.currentTarget=target;ret=notifier.fire(e);}
if(ret===false||e.stopped===2||(e.stopped&&delegates[i+1]&&delegates[i+1].container!==notifier.container)){break;}}}
if(e.stopped){break;}}},on:function(node,sub,notifier){sub.handle=this._attach(node._node,notifier);},detach:function(node,sub){sub.handle.detach();},delegate:function(node,sub,notifier,filter){if(isString(filter)){sub.filter=function(target){return Y.Selector.test(target._node,filter,node===target?null:node._node);};}
sub.handle=this._attach(node._node,notifier,true);},detachDelegate:function(node,sub){sub.handle.detach();}},true);}
if(useActivate){define("focus","beforeactivate","focusin");define("blur","beforedeactivate","focusout");}else{define("focus","focus","focus");define("blur","blur","blur");}},'3.15.0',{"requires":["event-synthetic"]});