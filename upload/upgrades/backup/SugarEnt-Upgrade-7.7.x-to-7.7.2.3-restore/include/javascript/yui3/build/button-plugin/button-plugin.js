/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('button-plugin',function(Y,NAME){function ButtonPlugin(){ButtonPlugin.superclass.constructor.apply(this,arguments);}
Y.extend(ButtonPlugin,Y.ButtonCore,{_afterNodeGet:function(name){var ATTRS=this.constructor.ATTRS,fn=ATTRS[name]&&ATTRS[name].getter&&this[ATTRS[name].getter];if(fn){return new Y.Do.AlterReturn('get '+name,fn.call(this));}},_afterNodeSet:function(name,val){var ATTRS=this.constructor.ATTRS,fn=ATTRS[name]&&ATTRS[name].setter&&this[ATTRS[name].setter];if(fn){fn.call(this,val);}},_initNode:function(config){var node=config.host;this._host=node;Y.Do.after(this._afterNodeGet,node,'get',this);Y.Do.after(this._afterNodeSet,node,'set',this);},destroy:function(){}},{ATTRS:Y.merge(Y.ButtonCore.ATTRS),NAME:'buttonPlugin',NS:'button'});ButtonPlugin.createNode=function(node,config){var template;if(node&&!config){if(!(node.nodeType||node.getDOMNode||typeof node==='string')){config=node;node=config.srcNode;}}
config=config||{};template=config.template||Y.Plugin.Button.prototype.TEMPLATE;node=node||config.srcNode||Y.DOM.create(template);return Y.one(node).plug(Y.Plugin.Button,config);};Y.namespace('Plugin').Button=ButtonPlugin;},'3.15.0',{"requires":["button-core","cssbutton","node-pluginhost"]});