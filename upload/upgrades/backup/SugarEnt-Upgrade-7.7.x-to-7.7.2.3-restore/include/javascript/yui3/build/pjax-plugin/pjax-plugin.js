/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('pjax-plugin',function(Y,NAME){Y.Plugin.Pjax=Y.Base.create('pjaxPlugin',Y.Pjax,[Y.Plugin.Base],{initializer:function(config){this.set('container',config.host);}},{NS:'pjax'});},'3.15.0',{"requires":["node-pluginhost","pjax","plugin"]});