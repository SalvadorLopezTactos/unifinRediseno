/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('parallel',function(Y,NAME){Y.Parallel=function(o){this.config=o||{};this.results=[];this.context=this.config.context||Y;this.total=0;this.finished=0;};Y.Parallel.prototype={results:null,total:null,finished:null,add:function(fn){var self=this,index=self.total;self.total+=1;return function(){self.finished++;self.results[index]=(fn&&fn.apply(self.context,arguments))||(arguments.length===1?arguments[0]:Y.Array(arguments));self.test();};},test:function(){var self=this;if(self.finished>=self.total&&self.callback){self.callback.call(self.context,self.results,self.data);}},done:function(callback,data){this.callback=callback;this.data=data;this.test();}};},'3.15.0',{"requires":["yui-base"]});