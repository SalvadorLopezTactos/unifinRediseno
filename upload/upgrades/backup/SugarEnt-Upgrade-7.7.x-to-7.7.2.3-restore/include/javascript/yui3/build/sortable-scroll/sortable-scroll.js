/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('sortable-scroll',function(Y,NAME){var SortScroll=function(){SortScroll.superclass.constructor.apply(this,arguments);};Y.extend(SortScroll,Y.Base,{initializer:function(){var host=this.get('host');host.plug(Y.Plugin.DDNodeScroll,{node:host.get('container')});host.delegate.on('drop:over',function(e){if(this.dd.nodescroll&&e.drag.nodescroll){e.drag.nodescroll.set('parentScroll',Y.one(this.get('container')));}});}},{ATTRS:{host:{value:''}},NAME:'SortScroll',NS:'scroll'});Y.namespace('Y.Plugin');Y.Plugin.SortableScroll=SortScroll;},'3.15.0',{"requires":["dd-scroll","sortable"]});