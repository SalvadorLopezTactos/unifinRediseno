/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('view',function(Y,NAME){function View(){View.superclass.constructor.apply(this,arguments);}
Y.View=Y.extend(View,Y.Base,{containerTemplate:'<div/>',events:{},template:'',_allowAdHocAttrs:true,initializer:function(config){config||(config={});config.containerTemplate&&(this.containerTemplate=config.containerTemplate);config.template&&(this.template=config.template);this.events=config.events?Y.merge(this.events,config.events):this.events;this.after('containerChange',this._afterContainerChange);},destroy:function(options){if(options&&(options.remove||options['delete'])){this.onceAfter('destroy',function(){this._destroyContainer();});}
return View.superclass.destroy.call(this);},destructor:function(){this.detachEvents();delete this._container;},attachEvents:function(events){var container=this.get('container'),owns=Y.Object.owns,handler,handlers,name,selector;this.detachEvents();events||(events=this.events);for(selector in events){if(!owns(events,selector)){continue;}
handlers=events[selector];for(name in handlers){if(!owns(handlers,name)){continue;}
handler=handlers[name];if(typeof handler==='string'){handler=this[handler];}
if(!handler){continue;}
this._attachedViewEvents.push(container.delegate(name,handler,selector,this));}}
return this;},create:function(container){return container?Y.one(container):Y.Node.create(this.containerTemplate);},detachEvents:function(){Y.Array.each(this._attachedViewEvents,function(handle){if(handle){handle.detach();}});this._attachedViewEvents=[];return this;},remove:function(){var container=this.get('container');container&&container.remove();return this;},render:function(){return this;},_destroyContainer:function(){var container=this.get('container');container&&container.remove(true);},_getContainer:function(value){if(!this._container){if(value){this._container=value;this.attachEvents();}else{value=this._container=this.create();this._set('container',value);}}
return value;},_afterContainerChange:function(){this.attachEvents(this.events);}},{NAME:'view',ATTRS:{container:{getter:'_getContainer',setter:Y.one,writeOnce:true}},_NON_ATTRS_CFG:['containerTemplate','events','template']});},'3.15.0',{"requires":["base-build","node-event-delegate"]});