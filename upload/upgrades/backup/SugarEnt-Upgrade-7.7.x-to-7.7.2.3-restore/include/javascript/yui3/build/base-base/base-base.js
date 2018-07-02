/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('base-base',function(Y,NAME){var AttributeCore=Y.AttributeCore,AttributeExtras=Y.AttributeExtras,BaseCore=Y.BaseCore,BaseObservable=Y.BaseObservable;function Base(){BaseCore.apply(this,arguments);BaseObservable.apply(this,arguments);AttributeExtras.apply(this,arguments);}
Base._ATTR_CFG=BaseCore._ATTR_CFG.concat(BaseObservable._ATTR_CFG);Base._NON_ATTRS_CFG=BaseCore._NON_ATTRS_CFG.concat(BaseObservable._NON_ATTRS_CFG);Base.NAME='base';Base.ATTRS=AttributeCore.protectAttrs(BaseCore.ATTRS);Base.modifyAttrs=BaseCore.modifyAttrs;Y.mix(Base,BaseCore,false,null,1);Y.mix(Base,AttributeExtras,false,null,1);Y.mix(Base,BaseObservable,true,null,1);Base.prototype.constructor=Base;Y.Base=Base;},'3.15.0',{"requires":["attribute-base","base-core","base-observable"]});