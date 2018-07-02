/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('event-custom-base',function(Y,NAME){Y.Env.evt={handles:{},plugins:{}};var DO_BEFORE=0,DO_AFTER=1,DO={objs:null,before:function(fn,obj,sFn,c){var f=fn,a;if(c){a=[fn,c].concat(Y.Array(arguments,4,true));f=Y.rbind.apply(Y,a);}
return this._inject(DO_BEFORE,f,obj,sFn);},after:function(fn,obj,sFn,c){var f=fn,a;if(c){a=[fn,c].concat(Y.Array(arguments,4,true));f=Y.rbind.apply(Y,a);}
return this._inject(DO_AFTER,f,obj,sFn);},_inject:function(when,fn,obj,sFn){var id=Y.stamp(obj),o,sid;if(!obj._yuiaop){obj._yuiaop={};}
o=obj._yuiaop;if(!o[sFn]){o[sFn]=new Y.Do.Method(obj,sFn);obj[sFn]=function(){return o[sFn].exec.apply(o[sFn],arguments);};}
sid=id+Y.stamp(fn)+sFn;o[sFn].register(sid,fn,when);return new Y.EventHandle(o[sFn],sid);},detach:function(handle){if(handle.detach){handle.detach();}}};Y.Do=DO;DO.Method=function(obj,sFn){this.obj=obj;this.methodName=sFn;this.method=obj[sFn];this.before={};this.after={};};DO.Method.prototype.register=function(sid,fn,when){if(when){this.after[sid]=fn;}else{this.before[sid]=fn;}};DO.Method.prototype._delete=function(sid){delete this.before[sid];delete this.after[sid];};DO.Method.prototype.exec=function(){var args=Y.Array(arguments,0,true),i,ret,newRet,bf=this.before,af=this.after,prevented=false;for(i in bf){if(bf.hasOwnProperty(i)){ret=bf[i].apply(this.obj,args);if(ret){switch(ret.constructor){case DO.Halt:return ret.retVal;case DO.AlterArgs:args=ret.newArgs;break;case DO.Prevent:prevented=true;break;default:}}}}
if(!prevented){ret=this.method.apply(this.obj,args);}
DO.originalRetVal=ret;DO.currentRetVal=ret;for(i in af){if(af.hasOwnProperty(i)){newRet=af[i].apply(this.obj,args);if(newRet&&newRet.constructor===DO.Halt){return newRet.retVal;}else if(newRet&&newRet.constructor===DO.AlterReturn){ret=newRet.newRetVal;DO.currentRetVal=ret;}}}
return ret;};DO.AlterArgs=function(msg,newArgs){this.msg=msg;this.newArgs=newArgs;};DO.AlterReturn=function(msg,newRetVal){this.msg=msg;this.newRetVal=newRetVal;};DO.Halt=function(msg,retVal){this.msg=msg;this.retVal=retVal;};DO.Prevent=function(msg){this.msg=msg;};DO.Error=DO.Halt;var YArray=Y.Array,AFTER='after',CONFIGS=['broadcast','monitored','bubbles','context','contextFn','currentTarget','defaultFn','defaultTargetOnly','details','emitFacade','fireOnce','async','host','preventable','preventedFn','queuable','silent','stoppedFn','target','type'],CONFIGS_HASH=YArray.hash(CONFIGS),nativeSlice=Array.prototype.slice,YUI3_SIGNATURE=9,YUI_LOG='yui:log',mixConfigs=function(r,s,ov){var p;for(p in s){if(CONFIGS_HASH[p]&&(ov||!(p in r))){r[p]=s[p];}}
return r;};Y.CustomEvent=function(type,defaults){this._kds=Y.CustomEvent.keepDeprecatedSubs;this.id=Y.guid();this.type=type;this.silent=this.logSystem=(type===YUI_LOG);if(this._kds){this.subscribers={};this.afters={};}
if(defaults){mixConfigs(this,defaults,true);}};Y.CustomEvent.keepDeprecatedSubs=false;Y.CustomEvent.mixConfigs=mixConfigs;Y.CustomEvent.prototype={constructor:Y.CustomEvent,signature:YUI3_SIGNATURE,context:Y,preventable:true,bubbles:true,hasSubs:function(when){var s=0,a=0,subs=this._subscribers,afters=this._afters,sib=this.sibling;if(subs){s=subs.length;}
if(afters){a=afters.length;}
if(sib){subs=sib._subscribers;afters=sib._afters;if(subs){s+=subs.length;}
if(afters){a+=afters.length;}}
if(when){return(when==='after')?a:s;}
return(s+a);},monitor:function(what){this.monitored=true;var type=this.id+'|'+this.type+'_'+what,args=nativeSlice.call(arguments,0);args[0]=type;return this.host.on.apply(this.host,args);},getSubs:function(){var sibling=this.sibling,subs=this._subscribers,afters=this._afters,siblingSubs,siblingAfters;if(sibling){siblingSubs=sibling._subscribers;siblingAfters=sibling._afters;}
if(siblingSubs){if(subs){subs=subs.concat(siblingSubs);}else{subs=siblingSubs.concat();}}else{if(subs){subs=subs.concat();}else{subs=[];}}
if(siblingAfters){if(afters){afters=afters.concat(siblingAfters);}else{afters=siblingAfters.concat();}}else{if(afters){afters=afters.concat();}else{afters=[];}}
return[subs,afters];},applyConfig:function(o,force){mixConfigs(this,o,force);},_on:function(fn,context,args,when){var s=new Y.Subscriber(fn,context,args,when),firedWith;if(this.fireOnce&&this.fired){firedWith=this.firedWith;if(this.emitFacade&&this._addFacadeToArgs){this._addFacadeToArgs(firedWith);}
if(this.async){setTimeout(Y.bind(this._notify,this,s,firedWith),0);}else{this._notify(s,firedWith);}}
if(when===AFTER){if(!this._afters){this._afters=[];}
this._afters.push(s);}else{if(!this._subscribers){this._subscribers=[];}
this._subscribers.push(s);}
if(this._kds){if(when===AFTER){this.afters[s.id]=s;}else{this.subscribers[s.id]=s;}}
return new Y.EventHandle(this,s);},subscribe:function(fn,context){var a=(arguments.length>2)?nativeSlice.call(arguments,2):null;return this._on(fn,context,a,true);},on:function(fn,context){var a=(arguments.length>2)?nativeSlice.call(arguments,2):null;if(this.monitored&&this.host){this.host._monitor('attach',this,{args:arguments});}
return this._on(fn,context,a,true);},after:function(fn,context){var a=(arguments.length>2)?nativeSlice.call(arguments,2):null;return this._on(fn,context,a,AFTER);},detach:function(fn,context){if(fn&&fn.detach){return fn.detach();}
var i,s,found=0,subs=this._subscribers,afters=this._afters;if(subs){for(i=subs.length;i>=0;i--){s=subs[i];if(s&&(!fn||fn===s.fn)){this._delete(s,subs,i);found++;}}}
if(afters){for(i=afters.length;i>=0;i--){s=afters[i];if(s&&(!fn||fn===s.fn)){this._delete(s,afters,i);found++;}}}
return found;},unsubscribe:function(){return this.detach.apply(this,arguments);},_notify:function(s,args,ef){var ret;ret=s.notify(args,this);if(false===ret||this.stopped>1){return false;}
return true;},log:function(msg,cat){},fire:function(){var args=[];args.push.apply(args,arguments);return this._fire(args);},_fire:function(args){if(this.fireOnce&&this.fired){return true;}else{this.fired=true;if(this.fireOnce){this.firedWith=args;}
if(this.emitFacade){return this.fireComplex(args);}else{return this.fireSimple(args);}}},fireSimple:function(args){this.stopped=0;this.prevented=0;if(this.hasSubs()){var subs=this.getSubs();this._procSubs(subs[0],args);this._procSubs(subs[1],args);}
if(this.broadcast){this._broadcast(args);}
return this.stopped?false:true;},fireComplex:function(args){args[0]=args[0]||{};return this.fireSimple(args);},_procSubs:function(subs,args,ef){var s,i,l;for(i=0,l=subs.length;i<l;i++){s=subs[i];if(s&&s.fn){if(false===this._notify(s,args,ef)){this.stopped=2;}
if(this.stopped===2){return false;}}}
return true;},_broadcast:function(args){if(!this.stopped&&this.broadcast){var a=args.concat();a.unshift(this.type);if(this.host!==Y){Y.fire.apply(Y,a);}
if(this.broadcast===2){Y.Global.fire.apply(Y.Global,a);}}},unsubscribeAll:function(){return this.detachAll.apply(this,arguments);},detachAll:function(){return this.detach();},_delete:function(s,subs,i){var when=s._when;if(!subs){subs=(when===AFTER)?this._afters:this._subscribers;}
if(subs){i=YArray.indexOf(subs,s,0);if(s&&subs[i]===s){subs.splice(i,1);}}
if(this._kds){if(when===AFTER){delete this.afters[s.id];}else{delete this.subscribers[s.id];}}
if(this.monitored&&this.host){this.host._monitor('detach',this,{ce:this,sub:s});}
if(s){s.deleted=true;}}};Y.Subscriber=function(fn,context,args,when){this.fn=fn;this.context=context;this.id=Y.guid();this.args=args;this._when=when;};Y.Subscriber.prototype={constructor:Y.Subscriber,_notify:function(c,args,ce){if(this.deleted&&!this.postponed){if(this.postponed){delete this.fn;delete this.context;}else{delete this.postponed;return null;}}
var a=this.args,ret;switch(ce.signature){case 0:ret=this.fn.call(c,ce.type,args,c);break;case 1:ret=this.fn.call(c,args[0]||null,c);break;default:if(a||args){args=args||[];a=(a)?args.concat(a):args;ret=this.fn.apply(c,a);}else{ret=this.fn.call(c);}}
if(this.once){ce._delete(this);}
return ret;},notify:function(args,ce){var c=this.context,ret=true;if(!c){c=(ce.contextFn)?ce.contextFn():ce.context;}
if(Y.config&&Y.config.throwFail){ret=this._notify(c,args,ce);}else{try{ret=this._notify(c,args,ce);}catch(e){Y.error(this+' failed: '+e.message,e);}}
return ret;},contains:function(fn,context){if(context){return((this.fn===fn)&&this.context===context);}else{return(this.fn===fn);}},valueOf:function(){return this.id;}};Y.EventHandle=function(evt,sub){this.evt=evt;this.sub=sub;};Y.EventHandle.prototype={batch:function(f,c){f.call(c||this,this);if(Y.Lang.isArray(this.evt)){Y.Array.each(this.evt,function(h){h.batch.call(c||h,f);});}},detach:function(){var evt=this.evt,detached=0,i;if(evt){if(Y.Lang.isArray(evt)){for(i=0;i<evt.length;i++){detached+=evt[i].detach();}}else{evt._delete(this.sub);detached=1;}}
return detached;},monitor:function(what){return this.evt.monitor.apply(this.evt,arguments);}};var L=Y.Lang,PREFIX_DELIMITER=':',CATEGORY_DELIMITER='|',AFTER_PREFIX='~AFTER~',WILD_TYPE_RE=/(.*?)(:)(.*?)/,_wildType=Y.cached(function(type){return type.replace(WILD_TYPE_RE,"*$2$3");}),_getType=function(type,pre){if(!pre||!type||type.indexOf(PREFIX_DELIMITER)>-1){return type;}
return pre+PREFIX_DELIMITER+type;},_parseType=Y.cached(function(type,pre){var t=type,detachcategory,after,i;if(!L.isString(t)){return t;}
i=t.indexOf(AFTER_PREFIX);if(i>-1){after=true;t=t.substr(AFTER_PREFIX.length);}
i=t.indexOf(CATEGORY_DELIMITER);if(i>-1){detachcategory=t.substr(0,(i));t=t.substr(i+1);if(t==='*'){t=null;}}
return[detachcategory,(pre)?_getType(t,pre):t,after,t];}),ET=function(opts){var etState=this._yuievt,etConfig;if(!etState){etState=this._yuievt={events:{},targets:null,config:{host:this,context:this},chain:Y.config.chain};}
etConfig=etState.config;if(opts){mixConfigs(etConfig,opts,true);if(opts.chain!==undefined){etState.chain=opts.chain;}
if(opts.prefix){etConfig.prefix=opts.prefix;}}};ET.prototype={constructor:ET,once:function(){var handle=this.on.apply(this,arguments);handle.batch(function(hand){if(hand.sub){hand.sub.once=true;}});return handle;},onceAfter:function(){var handle=this.after.apply(this,arguments);handle.batch(function(hand){if(hand.sub){hand.sub.once=true;}});return handle;},parseType:function(type,pre){return _parseType(type,pre||this._yuievt.config.prefix);},on:function(type,fn,context){var yuievt=this._yuievt,parts=_parseType(type,yuievt.config.prefix),f,c,args,ret,ce,detachcategory,handle,store=Y.Env.evt.handles,after,adapt,shorttype,Node=Y.Node,n,domevent,isArr;this._monitor('attach',parts[1],{args:arguments,category:parts[0],after:parts[2]});if(L.isObject(type)){if(L.isFunction(type)){return Y.Do.before.apply(Y.Do,arguments);}
f=fn;c=context;args=nativeSlice.call(arguments,0);ret=[];if(L.isArray(type)){isArr=true;}
after=type._after;delete type._after;Y.each(type,function(v,k){if(L.isObject(v)){f=v.fn||((L.isFunction(v))?v:f);c=v.context||c;}
var nv=(after)?AFTER_PREFIX:'';args[0]=nv+((isArr)?v:k);args[1]=f;args[2]=c;ret.push(this.on.apply(this,args));},this);return(yuievt.chain)?this:new Y.EventHandle(ret);}
detachcategory=parts[0];after=parts[2];shorttype=parts[3];if(Node&&Y.instanceOf(this,Node)&&(shorttype in Node.DOM_EVENTS)){args=nativeSlice.call(arguments,0);args.splice(2,0,Node.getDOMNode(this));return Y.on.apply(Y,args);}
type=parts[1];if(Y.instanceOf(this,YUI)){adapt=Y.Env.evt.plugins[type];args=nativeSlice.call(arguments,0);args[0]=shorttype;if(Node){n=args[2];if(Y.instanceOf(n,Y.NodeList)){n=Y.NodeList.getDOMNodes(n);}else if(Y.instanceOf(n,Node)){n=Node.getDOMNode(n);}
domevent=(shorttype in Node.DOM_EVENTS);if(domevent){args[2]=n;}}
if(adapt){handle=adapt.on.apply(Y,args);}else if((!type)||domevent){handle=Y.Event._attach(args);}}
if(!handle){ce=yuievt.events[type]||this.publish(type);handle=ce._on(fn,context,(arguments.length>3)?nativeSlice.call(arguments,3):null,(after)?'after':true);if(type.indexOf("*:")!==-1){this._hasSiblings=true;}}
if(detachcategory){store[detachcategory]=store[detachcategory]||{};store[detachcategory][type]=store[detachcategory][type]||[];store[detachcategory][type].push(handle);}
return(yuievt.chain)?this:handle;},subscribe:function(){return this.on.apply(this,arguments);},detach:function(type,fn,context){var evts=this._yuievt.events,i,Node=Y.Node,isNode=Node&&(Y.instanceOf(this,Node));if(!type&&(this!==Y)){for(i in evts){if(evts.hasOwnProperty(i)){evts[i].detach(fn,context);}}
if(isNode){Y.Event.purgeElement(Node.getDOMNode(this));}
return this;}
var parts=_parseType(type,this._yuievt.config.prefix),detachcategory=L.isArray(parts)?parts[0]:null,shorttype=(parts)?parts[3]:null,adapt,store=Y.Env.evt.handles,detachhost,cat,args,ce,keyDetacher=function(lcat,ltype,host){var handles=lcat[ltype],ce,i;if(handles){for(i=handles.length-1;i>=0;--i){ce=handles[i].evt;if(ce.host===host||ce.el===host){handles[i].detach();}}}};if(detachcategory){cat=store[detachcategory];type=parts[1];detachhost=(isNode)?Y.Node.getDOMNode(this):this;if(cat){if(type){keyDetacher(cat,type,detachhost);}else{for(i in cat){if(cat.hasOwnProperty(i)){keyDetacher(cat,i,detachhost);}}}
return this;}}else if(L.isObject(type)&&type.detach){type.detach();return this;}else if(isNode&&((!shorttype)||(shorttype in Node.DOM_EVENTS))){args=nativeSlice.call(arguments,0);args[2]=Node.getDOMNode(this);Y.detach.apply(Y,args);return this;}
adapt=Y.Env.evt.plugins[shorttype];if(Y.instanceOf(this,YUI)){args=nativeSlice.call(arguments,0);if(adapt&&adapt.detach){adapt.detach.apply(Y,args);return this;}else if(!type||(!adapt&&Node&&(type in Node.DOM_EVENTS))){args[0]=type;Y.Event.detach.apply(Y.Event,args);return this;}}
ce=evts[parts[1]];if(ce){ce.detach(fn,context);}
return this;},unsubscribe:function(){return this.detach.apply(this,arguments);},detachAll:function(type){return this.detach(type);},unsubscribeAll:function(){return this.detachAll.apply(this,arguments);},publish:function(type,opts){var ret,etState=this._yuievt,etConfig=etState.config,pre=etConfig.prefix;if(typeof type==="string"){if(pre){type=_getType(type,pre);}
ret=this._publish(type,etConfig,opts);}else{ret={};Y.each(type,function(v,k){if(pre){k=_getType(k,pre);}
ret[k]=this._publish(k,etConfig,v||opts);},this);}
return ret;},_getFullType:function(type){var pre=this._yuievt.config.prefix;if(pre){return pre+PREFIX_DELIMITER+type;}else{return type;}},_publish:function(fullType,etOpts,ceOpts){var ce,etState=this._yuievt,etConfig=etState.config,host=etConfig.host,context=etConfig.context,events=etState.events;ce=events[fullType];if((etConfig.monitored&&!ce)||(ce&&ce.monitored)){this._monitor('publish',fullType,{args:arguments});}
if(!ce){ce=events[fullType]=new Y.CustomEvent(fullType,etOpts);if(!etOpts){ce.host=host;ce.context=context;}}
if(ceOpts){mixConfigs(ce,ceOpts,true);}
return ce;},_monitor:function(what,eventType,o){var monitorevt,ce,type;if(eventType){if(typeof eventType==="string"){type=eventType;ce=this.getEvent(eventType,true);}else{ce=eventType;type=eventType.type;}
if((this._yuievt.config.monitored&&(!ce||ce.monitored))||(ce&&ce.monitored)){monitorevt=type+'_'+what;o.monitored=what;this.fire.call(this,monitorevt,o);}}},fire:function(type){var typeIncluded=(typeof type==="string"),argCount=arguments.length,t=type,yuievt=this._yuievt,etConfig=yuievt.config,pre=etConfig.prefix,ret,ce,ce2,args;if(typeIncluded&&argCount<=3){if(argCount===2){args=[arguments[1]];}else if(argCount===3){args=[arguments[1],arguments[2]];}else{args=[];}}else{args=nativeSlice.call(arguments,((typeIncluded)?1:0));}
if(!typeIncluded){t=(type&&type.type);}
if(pre){t=_getType(t,pre);}
ce=yuievt.events[t];if(this._hasSiblings){ce2=this.getSibling(t,ce);if(ce2&&!ce){ce=this.publish(t);}}
if((etConfig.monitored&&(!ce||ce.monitored))||(ce&&ce.monitored)){this._monitor('fire',(ce||t),{args:args});}
if(!ce){if(yuievt.hasTargets){return this.bubble({type:t},args,this);}
ret=true;}else{if(ce2){ce.sibling=ce2;}
ret=ce._fire(args);}
return(yuievt.chain)?this:ret;},getSibling:function(type,ce){var ce2;if(type.indexOf(PREFIX_DELIMITER)>-1){type=_wildType(type);ce2=this.getEvent(type,true);if(ce2){ce2.applyConfig(ce);ce2.bubbles=false;ce2.broadcast=0;}}
return ce2;},getEvent:function(type,prefixed){var pre,e;if(!prefixed){pre=this._yuievt.config.prefix;type=(pre)?_getType(type,pre):type;}
e=this._yuievt.events;return e[type]||null;},after:function(type,fn){var a=nativeSlice.call(arguments,0);switch(L.type(type)){case'function':return Y.Do.after.apply(Y.Do,arguments);case'array':case'object':a[0]._after=true;break;default:a[0]=AFTER_PREFIX+type;}
return this.on.apply(this,a);},before:function(){return this.on.apply(this,arguments);}};Y.EventTarget=ET;Y.mix(Y,ET.prototype);ET.call(Y,{bubbles:false});YUI.Env.globalEvents=YUI.Env.globalEvents||new ET();Y.Global=YUI.Env.globalEvents;},'3.15.0',{"requires":["oop"]});