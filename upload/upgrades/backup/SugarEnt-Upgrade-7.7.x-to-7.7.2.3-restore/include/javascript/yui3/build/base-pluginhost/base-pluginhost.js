/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('base-pluginhost',function(Y,NAME){var Base=Y.Base,PluginHost=Y.Plugin.Host;Y.mix(Base,PluginHost,false,null,1);Base.plug=PluginHost.plug;Base.unplug=PluginHost.unplug;},'3.15.0',{"requires":["base-base","pluginhost"]});