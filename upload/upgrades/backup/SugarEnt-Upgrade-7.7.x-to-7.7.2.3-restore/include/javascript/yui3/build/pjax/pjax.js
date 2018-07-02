/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('pjax',function(Y,NAME){var defaultRoute=['loadContent','_defaultRoute'],EVT_ERROR='error',EVT_LOAD='load';Y.Pjax=Y.Base.create('pjax',Y.Router,[Y.PjaxBase,Y.PjaxContent],{initializer:function(){this.publish(EVT_ERROR,{defaultFn:this._defCompleteFn});this.publish(EVT_LOAD,{defaultFn:this._defCompleteFn});},_defaultRoute:function(req,res,next){var ioResponse=res.ioResponse,status=ioResponse.status,event=status>=200&&status<300?EVT_LOAD:EVT_ERROR;this.fire(event,{content:res.content,responseText:ioResponse.responseText,status:status,url:req.ioURL});next();},_defCompleteFn:function(e){var container=this.get('container'),content=e.content;if(container&&content.node){container.setHTML(content.node);}
if(content.title&&Y.config.doc){Y.config.doc.title=content.title;}}},{ATTRS:{container:{value:null,setter:Y.one},routes:{value:[{path:'*',callbacks:defaultRoute}]}},defaultRoute:defaultRoute});},'3.15.0',{"requires":["pjax-base","pjax-content"]});