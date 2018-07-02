/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('pluginhost-base',function(Y,NAME){var L=Y.Lang;function PluginHost(){this._plugins={};}
PluginHost.prototype={plug:function(Plugin,config){var i,ln,ns;if(L.isArray(Plugin)){for(i=0,ln=Plugin.length;i<ln;i++){this.plug(Plugin[i]);}}else{if(Plugin&&!L.isFunction(Plugin)){config=Plugin.cfg;Plugin=Plugin.fn;}
if(Plugin&&Plugin.NS){ns=Plugin.NS;config=config||{};config.host=this;if(this.hasPlugin(ns)){if(this[ns].setAttrs){this[ns].setAttrs(config);}}else{this[ns]=new Plugin(config);this._plugins[ns]=Plugin;}}}
return this;},unplug:function(plugin){var ns=plugin,plugins=this._plugins;if(plugin){if(L.isFunction(plugin)){ns=plugin.NS;if(ns&&(!plugins[ns]||plugins[ns]!==plugin)){ns=null;}}
if(ns){if(this[ns]){if(this[ns].destroy){this[ns].destroy();}
delete this[ns];}
if(plugins[ns]){delete plugins[ns];}}}else{for(ns in this._plugins){if(this._plugins.hasOwnProperty(ns)){this.unplug(ns);}}}
return this;},hasPlugin:function(ns){return(this._plugins[ns]&&this[ns]);},_initPlugins:function(config){this._plugins=this._plugins||{};if(this._initConfigPlugins){this._initConfigPlugins(config);}},_destroyPlugins:function(){this.unplug();}};Y.namespace("Plugin").Host=PluginHost;},'3.15.0',{"requires":["yui-base"]});