/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('base-core',function(Y,NAME){var O=Y.Object,L=Y.Lang,DOT=".",INITIALIZED="initialized",DESTROYED="destroyed",INITIALIZER="initializer",VALUE="value",OBJECT_CONSTRUCTOR=Object.prototype.constructor,DEEP="deep",SHALLOW="shallow",DESTRUCTOR="destructor",AttributeCore=Y.AttributeCore,_wlmix=function(r,s,wlhash){var p;for(p in s){if(wlhash[p]){r[p]=s[p];}}
return r;};function BaseCore(cfg){if(!this._BaseInvoked){this._BaseInvoked=true;this._initBase(cfg);}}
BaseCore._ATTR_CFG=AttributeCore._ATTR_CFG.concat("cloneDefaultValue");BaseCore._NON_ATTRS_CFG=["plugins"];BaseCore.NAME="baseCore";BaseCore.ATTRS={initialized:{readOnly:true,value:false},destroyed:{readOnly:true,value:false}};BaseCore.modifyAttrs=function(ctor,configs){if(typeof ctor!=='function'){configs=ctor;ctor=this;}
var attrs,attr,name;attrs=ctor.ATTRS||(ctor.ATTRS={});if(configs){ctor._CACHED_CLASS_DATA=null;for(name in configs){if(configs.hasOwnProperty(name)){attr=attrs[name]||(attrs[name]={});Y.mix(attr,configs[name],true);}}}};BaseCore.prototype={_initBase:function(config){Y.stamp(this);this._initAttribute(config);var PluginHost=Y.Plugin&&Y.Plugin.Host;if(this._initPlugins&&PluginHost){PluginHost.call(this);}
if(this._lazyAddAttrs!==false){this._lazyAddAttrs=true;}
this.name=this.constructor.NAME;this.init.apply(this,arguments);},_initAttribute:function(){AttributeCore.call(this);},init:function(cfg){this._baseInit(cfg);return this;},_baseInit:function(cfg){this._initHierarchy(cfg);if(this._initPlugins){this._initPlugins(cfg);}
this._set(INITIALIZED,true);},destroy:function(){this._baseDestroy();return this;},_baseDestroy:function(){if(this._destroyPlugins){this._destroyPlugins();}
this._destroyHierarchy();this._set(DESTROYED,true);},_getClasses:function(){if(!this._classes){this._initHierarchyData();}
return this._classes;},_getAttrCfgs:function(){if(!this._attrs){this._initHierarchyData();}
return this._attrs;},_getInstanceAttrCfgs:function(allCfgs){var cfgs={},cfg,val,subAttr,subAttrs,subAttrPath,attr,attrCfg,allSubAttrs=allCfgs._subAttrs,attrCfgProperties=this._attrCfgHash();for(attr in allCfgs){if(allCfgs.hasOwnProperty(attr)&&attr!=="_subAttrs"){attrCfg=allCfgs[attr];cfg=cfgs[attr]=_wlmix({},attrCfg,attrCfgProperties);val=cfg.value;if(val&&(typeof val==="object")){this._cloneDefaultValue(attr,cfg);}
if(allSubAttrs&&allSubAttrs.hasOwnProperty(attr)){subAttrs=allCfgs._subAttrs[attr];for(subAttrPath in subAttrs){subAttr=subAttrs[subAttrPath];if(subAttr.path){O.setValue(cfg.value,subAttr.path,subAttr.value);}}}}}
return cfgs;},_filterAdHocAttrs:function(allAttrs,userVals){var adHocs,nonAttrs=this._nonAttrs,attr;if(userVals){adHocs={};for(attr in userVals){if(!allAttrs[attr]&&!nonAttrs[attr]&&userVals.hasOwnProperty(attr)){adHocs[attr]={value:userVals[attr]};}}}
return adHocs;},_initHierarchyData:function(){var ctor=this.constructor,cachedClassData=ctor._CACHED_CLASS_DATA,c,i,l,attrCfg,attrCfgHash,needsAttrCfgHash=!ctor._ATTR_CFG_HASH,nonAttrsCfg,nonAttrs={},classes=[],attrs=[];c=ctor;if(!cachedClassData){while(c){classes[classes.length]=c;if(c.ATTRS){attrs[attrs.length]=c.ATTRS;}
if(needsAttrCfgHash){attrCfg=c._ATTR_CFG;attrCfgHash=attrCfgHash||{};if(attrCfg){for(i=0,l=attrCfg.length;i<l;i+=1){attrCfgHash[attrCfg[i]]=true;}}}
nonAttrsCfg=c._NON_ATTRS_CFG;if(nonAttrsCfg){for(i=0,l=nonAttrsCfg.length;i<l;i++){nonAttrs[nonAttrsCfg[i]]=true;}}
c=c.superclass?c.superclass.constructor:null;}
if(needsAttrCfgHash){ctor._ATTR_CFG_HASH=attrCfgHash;}
cachedClassData=ctor._CACHED_CLASS_DATA={classes:classes,nonAttrs:nonAttrs,attrs:this._aggregateAttrs(attrs)};}
this._classes=cachedClassData.classes;this._attrs=cachedClassData.attrs;this._nonAttrs=cachedClassData.nonAttrs;},_attrCfgHash:function(){return this.constructor._ATTR_CFG_HASH;},_cloneDefaultValue:function(attr,cfg){var val=cfg.value,clone=cfg.cloneDefaultValue;if(clone===DEEP||clone===true){cfg.value=Y.clone(val);}else if(clone===SHALLOW){cfg.value=Y.merge(val);}else if((clone===undefined&&(OBJECT_CONSTRUCTOR===val.constructor||L.isArray(val)))){cfg.value=Y.clone(val);}},_aggregateAttrs:function(allAttrs){var attr,attrs,subAttrsHash,cfg,path,i,cfgPropsHash=this._attrCfgHash(),aggAttr,aggAttrs={};if(allAttrs){for(i=allAttrs.length-1;i>=0;--i){attrs=allAttrs[i];for(attr in attrs){if(attrs.hasOwnProperty(attr)){cfg=_wlmix({},attrs[attr],cfgPropsHash);path=null;if(attr.indexOf(DOT)!==-1){path=attr.split(DOT);attr=path.shift();}
aggAttr=aggAttrs[attr];if(path&&aggAttr&&aggAttr.value){subAttrsHash=aggAttrs._subAttrs;if(!subAttrsHash){subAttrsHash=aggAttrs._subAttrs={};}
if(!subAttrsHash[attr]){subAttrsHash[attr]={};}
subAttrsHash[attr][path.join(DOT)]={value:cfg.value,path:path};}else if(!path){if(!aggAttr){aggAttrs[attr]=cfg;}else{if(aggAttr.valueFn&&VALUE in cfg){aggAttr.valueFn=null;}
_wlmix(aggAttr,cfg,cfgPropsHash);}}}}}}
return aggAttrs;},_initHierarchy:function(userVals){var lazy=this._lazyAddAttrs,constr,constrProto,i,l,ci,ei,el,ext,extProto,exts,instanceAttrs,initializers=[],classes=this._getClasses(),attrCfgs=this._getAttrCfgs(),cl=classes.length-1;for(ci=cl;ci>=0;ci--){constr=classes[ci];constrProto=constr.prototype;exts=constr._yuibuild&&constr._yuibuild.exts;if(constrProto.hasOwnProperty(INITIALIZER)){initializers[initializers.length]=constrProto.initializer;}
if(exts){for(ei=0,el=exts.length;ei<el;ei++){ext=exts[ei];ext.apply(this,arguments);extProto=ext.prototype;if(extProto.hasOwnProperty(INITIALIZER)){initializers[initializers.length]=extProto.initializer;}}}}
instanceAttrs=this._getInstanceAttrCfgs(attrCfgs);if(this._preAddAttrs){this._preAddAttrs(instanceAttrs,userVals,lazy);}
if(this._allowAdHocAttrs){this.addAttrs(this._filterAdHocAttrs(attrCfgs,userVals),userVals,lazy);}
this.addAttrs(instanceAttrs,userVals,lazy);for(i=0,l=initializers.length;i<l;i++){initializers[i].apply(this,arguments);}},_destroyHierarchy:function(){var constr,constrProto,ci,cl,ei,el,exts,extProto,classes=this._getClasses();for(ci=0,cl=classes.length;ci<cl;ci++){constr=classes[ci];constrProto=constr.prototype;exts=constr._yuibuild&&constr._yuibuild.exts;if(exts){for(ei=0,el=exts.length;ei<el;ei++){extProto=exts[ei].prototype;if(extProto.hasOwnProperty(DESTRUCTOR)){extProto.destructor.apply(this,arguments);}}}
if(constrProto.hasOwnProperty(DESTRUCTOR)){constrProto.destructor.apply(this,arguments);}}},toString:function(){return this.name+"["+Y.stamp(this,true)+"]";}};Y.mix(BaseCore,AttributeCore,false,null,1);BaseCore.prototype.constructor=BaseCore;Y.BaseCore=BaseCore;},'3.15.0',{"requires":["attribute-core"]});