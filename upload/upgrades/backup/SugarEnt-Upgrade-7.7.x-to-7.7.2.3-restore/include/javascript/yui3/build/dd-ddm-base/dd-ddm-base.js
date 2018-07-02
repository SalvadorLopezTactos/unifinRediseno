/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('dd-ddm-base',function(Y,NAME){var DDMBase=function(){DDMBase.superclass.constructor.apply(this,arguments);};DDMBase.NAME='ddm';DDMBase.ATTRS={dragCursor:{value:'move'},clickPixelThresh:{value:3},clickTimeThresh:{value:1000},throttleTime:{value:-1},dragMode:{value:'point',setter:function(mode){this._setDragMode(mode);return mode;}}};Y.extend(DDMBase,Y.Base,{_createPG:function(){},_active:null,_setDragMode:function(mode){if(mode===null){mode=Y.DD.DDM.get('dragMode');}
switch(mode){case 1:case'intersect':return 1;case 2:case'strict':return 2;case 0:case'point':return 0;}
return 0;},CSS_PREFIX:Y.ClassNameManager.getClassName('dd'),_activateTargets:function(){},_drags:[],activeDrag:false,_regDrag:function(d){if(this.getDrag(d.get('node'))){return false;}
if(!this._active){this._setupListeners();}
this._drags.push(d);return true;},_unregDrag:function(d){var tmp=[];Y.Array.each(this._drags,function(n){if(n!==d){tmp[tmp.length]=n;}});this._drags=tmp;},_setupListeners:function(){this._createPG();this._active=true;var doc=Y.one(Y.config.doc);doc.on('mousemove',Y.throttle(Y.bind(this._docMove,this),this.get('throttleTime')));doc.on('mouseup',Y.bind(this._end,this));},_start:function(){this.fire('ddm:start');this._startDrag();},_startDrag:function(){},_endDrag:function(){},_dropMove:function(){},_end:function(){if(this.activeDrag){this._shimming=false;this._endDrag();this.fire('ddm:end');this.activeDrag.end.call(this.activeDrag);this.activeDrag=null;}},stopDrag:function(){if(this.activeDrag){this._end();}
return this;},_shimming:false,_docMove:function(ev){if(!this._shimming){this._move(ev);}},_move:function(ev){if(this.activeDrag){this.activeDrag._move.call(this.activeDrag,ev);this._dropMove();}},cssSizestoObject:function(gutter){var x=gutter.split(' ');switch(x.length){case 1:x[1]=x[2]=x[3]=x[0];break;case 2:x[2]=x[0];x[3]=x[1];break;case 3:x[3]=x[1];break;}
return{top:parseInt(x[0],10),right:parseInt(x[1],10),bottom:parseInt(x[2],10),left:parseInt(x[3],10)};},getDrag:function(node){var drag=false,n=Y.one(node);if(n instanceof Y.Node){Y.Array.each(this._drags,function(v){if(n.compareTo(v.get('node'))){drag=v;}});}
return drag;},swapPosition:function(n1,n2){n1=Y.DD.DDM.getNode(n1);n2=Y.DD.DDM.getNode(n2);var xy1=n1.getXY(),xy2=n2.getXY();n1.setXY(xy2);n2.setXY(xy1);return n1;},getNode:function(n){if(n instanceof Y.Node){return n;}
if(n&&n.get){if(Y.Widget&&(n instanceof Y.Widget)){n=n.get('boundingBox');}else{n=n.get('node');}}else{n=Y.one(n);}
return n;},swapNode:function(n1,n2){n1=Y.DD.DDM.getNode(n1);n2=Y.DD.DDM.getNode(n2);var p=n2.get('parentNode'),s=n2.get('nextSibling');if(s===n1){p.insertBefore(n1,n2);}else if(n2===n1.get('nextSibling')){p.insertBefore(n2,n1);}else{n1.get('parentNode').replaceChild(n2,n1);p.insertBefore(n1,s);}
return n1;}});Y.namespace('DD');Y.DD.DDM=new DDMBase();},'3.15.0',{"requires":["node","base","yui-throttle","classnamemanager"]});