/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('queue-promote',function(Y,NAME){Y.mix(Y.Queue.prototype,{indexOf:function(callback){return Y.Array.indexOf(this._q,callback);},promote:function(callback){var index=this.indexOf(callback);if(index>-1){this._q.unshift(this._q.splice(index,1)[0]);}},remove:function(callback){var index=this.indexOf(callback);if(index>-1){this._q.splice(index,1);}}});},'3.15.0',{"requires":["yui-base"]});