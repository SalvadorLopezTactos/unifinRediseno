/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('graphics-canvas',function(Y,NAME){var IMPLEMENTATION="canvas",SHAPE="shape",SPLITPATHPATTERN=/[a-z][^a-z]*/ig,SPLITARGSPATTERN=/[\-]?[0-9]*[0-9|\.][0-9]*/g,DOCUMENT=Y.config.doc,Y_LANG=Y.Lang,AttributeLite=Y.AttributeLite,CanvasShape,CanvasPath,CanvasRect,CanvasEllipse,CanvasCircle,CanvasPieSlice,Y_DOM=Y.DOM,Y_Color=Y.Color,PARSE_INT=parseInt,PARSE_FLOAT=parseFloat,IS_NUMBER=Y_LANG.isNumber,RE=RegExp,TORGB=Y_Color.toRGB,TOHEX=Y_Color.toHex,_getClassName=Y.ClassNameManager.getClassName;function CanvasDrawing()
{}
CanvasDrawing.prototype={_pathSymbolToMethod:{M:"moveTo",m:"relativeMoveTo",L:"lineTo",l:"relativeLineTo",C:"curveTo",c:"relativeCurveTo",Q:"quadraticCurveTo",q:"relativeQuadraticCurveTo",z:"closePath",Z:"closePath"},_currentX:0,_currentY:0,_toRGBA:function(val,alpha){alpha=(alpha!==undefined)?alpha:1;if(!Y_Color.re_RGB.test(val)){val=TOHEX(val);}
if(Y_Color.re_hex.exec(val)){val='rgba('+[PARSE_INT(RE.$1,16),PARSE_INT(RE.$2,16),PARSE_INT(RE.$3,16)].join(',')+','+alpha+')';}
return val;},_toRGB:function(val){return TORGB(val);},setSize:function(w,h){if(this.get("autoSize"))
{if(w>this.node.getAttribute("width"))
{this.node.style.width=w+"px";this.node.setAttribute("width",w);}
if(h>this.node.getAttribute("height"))
{this.node.style.height=h+"px";this.node.setAttribute("height",h);}}},_updateCoords:function(x,y)
{this._xcoords.push(x);this._ycoords.push(y);this._currentX=x;this._currentY=y;},_clearAndUpdateCoords:function()
{var x=this._xcoords.pop()||0,y=this._ycoords.pop()||0;this._updateCoords(x,y);},_updateNodePosition:function()
{var node=this.get("node"),x=this.get("x"),y=this.get("y");node.style.position="absolute";node.style.left=(x+this._left)+"px";node.style.top=(y+this._top)+"px";},_updateDrawingQueue:function(val)
{this._methods.push(val);},lineTo:function()
{this._lineTo.apply(this,[Y.Array(arguments),false]);return this;},relativeLineTo:function()
{this._lineTo.apply(this,[Y.Array(arguments),true]);return this;},_lineTo:function(args,relative)
{var point1=args[0],i,len,x,y,wt=this._stroke&&this._strokeWeight?this._strokeWeight:0,relativeX=relative?parseFloat(this._currentX):0,relativeY=relative?parseFloat(this._currentY):0;if(!this._lineToMethods)
{this._lineToMethods=[];}
len=args.length-1;if(typeof point1==='string'||typeof point1==='number'){for(i=0;i<len;i=i+2){x=parseFloat(args[i]);y=parseFloat(args[i+1]);x=x+relativeX;y=y+relativeY;this._updateDrawingQueue(["lineTo",x,y]);this._trackSize(x-wt,y-wt);this._trackSize(x+wt,y+wt);this._updateCoords(x,y);}}
else
{for(i=0;i<len;i=i+1)
{x=parseFloat(args[i][0]);y=parseFloat(args[i][1]);this._updateDrawingQueue(["lineTo",x,y]);this._lineToMethods[this._lineToMethods.length]=this._methods[this._methods.length-1];this._trackSize(x-wt,y-wt);this._trackSize(x+wt,y+wt);this._updateCoords(x,y);}}
this._drawingComplete=false;return this;},moveTo:function()
{this._moveTo.apply(this,[Y.Array(arguments),false]);return this;},relativeMoveTo:function()
{this._moveTo.apply(this,[Y.Array(arguments),true]);return this;},_moveTo:function(args,relative){var wt=this._stroke&&this._strokeWeight?this._strokeWeight:0,relativeX=relative?parseFloat(this._currentX):0,relativeY=relative?parseFloat(this._currentY):0,x=parseFloat(args[0])+relativeX,y=parseFloat(args[1])+relativeY;this._updateDrawingQueue(["moveTo",x,y]);this._trackSize(x-wt,y-wt);this._trackSize(x+wt,y+wt);this._updateCoords(x,y);this._drawingComplete=false;return this;},curveTo:function(){this._curveTo.apply(this,[Y.Array(arguments),false]);return this;},relativeCurveTo:function(){this._curveTo.apply(this,[Y.Array(arguments),true]);return this;},_curveTo:function(args,relative){var w,h,cp1x,cp1y,cp2x,cp2y,x,y,pts,right,left,bottom,top,i,len,relativeX=relative?parseFloat(this._currentX):0,relativeY=relative?parseFloat(this._currentY):0;len=args.length-5;for(i=0;i<len;i=i+6)
{cp1x=parseFloat(args[i])+relativeX;cp1y=parseFloat(args[i+1])+relativeY;cp2x=parseFloat(args[i+2])+relativeX;cp2y=parseFloat(args[i+3])+relativeY;x=parseFloat(args[i+4])+relativeX;y=parseFloat(args[i+5])+relativeY;this._updateDrawingQueue(["bezierCurveTo",cp1x,cp1y,cp2x,cp2y,x,y]);this._drawingComplete=false;right=Math.max(x,Math.max(cp1x,cp2x));bottom=Math.max(y,Math.max(cp1y,cp2y));left=Math.min(x,Math.min(cp1x,cp2x));top=Math.min(y,Math.min(cp1y,cp2y));w=Math.abs(right-left);h=Math.abs(bottom-top);pts=[[this._currentX,this._currentY],[cp1x,cp1y],[cp2x,cp2y],[x,y]];this._setCurveBoundingBox(pts,w,h);this._currentX=x;this._currentY=y;}},quadraticCurveTo:function(){this._quadraticCurveTo.apply(this,[Y.Array(arguments),false]);return this;},relativeQuadraticCurveTo:function(){this._quadraticCurveTo.apply(this,[Y.Array(arguments),true]);return this;},_quadraticCurveTo:function(args,relative){var cpx,cpy,x,y,w,h,pts,right,left,bottom,top,i,len=args.length-3,relativeX=relative?parseFloat(this._currentX):0,relativeY=relative?parseFloat(this._currentY):0;for(i=0;i<len;i=i+4)
{cpx=parseFloat(args[i])+relativeX;cpy=parseFloat(args[i+1])+relativeY;x=parseFloat(args[i+2])+relativeX;y=parseFloat(args[i+3])+relativeY;this._drawingComplete=false;right=Math.max(x,cpx);bottom=Math.max(y,cpy);left=Math.min(x,cpx);top=Math.min(y,cpy);w=Math.abs(right-left);h=Math.abs(bottom-top);pts=[[this._currentX,this._currentY],[cpx,cpy],[x,y]];this._setCurveBoundingBox(pts,w,h);this._updateDrawingQueue(["quadraticCurveTo",cpx,cpy,x,y]);this._updateCoords(x,y);}
return this;},drawCircle:function(x,y,radius){var startAngle=0,endAngle=2*Math.PI,wt=this._stroke&&this._strokeWeight?this._strokeWeight:0,circum=radius*2;circum+=wt;this._drawingComplete=false;this._trackSize(x+circum,y+circum);this._trackSize(x-wt,y-wt);this._updateCoords(x,y);this._updateDrawingQueue(["arc",x+radius,y+radius,radius,startAngle,endAngle,false]);return this;},drawDiamond:function(x,y,width,height)
{var midWidth=width*0.5,midHeight=height*0.5;this.moveTo(x+midWidth,y);this.lineTo(x+width,y+midHeight);this.lineTo(x+midWidth,y+height);this.lineTo(x,y+midHeight);this.lineTo(x+midWidth,y);return this;},drawEllipse:function(x,y,w,h){var l=8,theta=-(45/180)*Math.PI,angle=0,angleMid,radius=w/2,yRadius=h/2,i,centerX=x+radius,centerY=y+yRadius,ax,ay,bx,by,cx,cy,wt=this._stroke&&this._strokeWeight?this._strokeWeight:0;ax=centerX+Math.cos(0)*radius;ay=centerY+Math.sin(0)*yRadius;this.moveTo(ax,ay);for(i=0;i<l;i++)
{angle+=theta;angleMid=angle-(theta / 2);bx=centerX+Math.cos(angle)*radius;by=centerY+Math.sin(angle)*yRadius;cx=centerX+Math.cos(angleMid)*(radius / Math.cos(theta / 2));cy=centerY+Math.sin(angleMid)*(yRadius / Math.cos(theta / 2));this._updateDrawingQueue(["quadraticCurveTo",cx,cy,bx,by]);}
this._trackSize(x+w+wt,y+h+wt);this._trackSize(x-wt,y-wt);this._updateCoords(x,y);return this;},drawRect:function(x,y,w,h){this._drawingComplete=false;this.moveTo(x,y);this.lineTo(x+w,y);this.lineTo(x+w,y+h);this.lineTo(x,y+h);this.lineTo(x,y);return this;},drawRoundRect:function(x,y,w,h,ew,eh){this._drawingComplete=false;this.moveTo(x,y+eh);this.lineTo(x,y+h-eh);this.quadraticCurveTo(x,y+h,x+ew,y+h);this.lineTo(x+w-ew,y+h);this.quadraticCurveTo(x+w,y+h,x+w,y+h-eh);this.lineTo(x+w,y+eh);this.quadraticCurveTo(x+w,y,x+w-ew,y);this.lineTo(x+ew,y);this.quadraticCurveTo(x,y,x,y+eh);return this;},drawWedge:function(x,y,startAngle,arc,radius,yRadius)
{var wt=this._stroke&&this._strokeWeight?this._strokeWeight:0,segs,segAngle,theta,angle,angleMid,ax,ay,bx,by,cx,cy,i=0;yRadius=yRadius||radius;this._drawingComplete=false;this._updateDrawingQueue(["moveTo",x,y]);yRadius=yRadius||radius;if(Math.abs(arc)>360)
{arc=360;}
segs=Math.ceil(Math.abs(arc)/ 45);segAngle=arc / segs;theta=-(segAngle / 180)*Math.PI;angle=(startAngle / 180)*Math.PI;if(segs>0)
{ax=x+Math.cos(startAngle / 180*Math.PI)*radius;ay=y+Math.sin(startAngle / 180*Math.PI)*yRadius;this.lineTo(ax,ay);for(i=0;i<segs;++i)
{angle+=theta;angleMid=angle-(theta / 2);bx=x+Math.cos(angle)*radius;by=y+Math.sin(angle)*yRadius;cx=x+Math.cos(angleMid)*(radius / Math.cos(theta / 2));cy=y+Math.sin(angleMid)*(yRadius / Math.cos(theta / 2));this._updateDrawingQueue(["quadraticCurveTo",cx,cy,bx,by]);}
this._updateDrawingQueue(["lineTo",x,y]);}
this._trackSize(-wt,-wt);this._trackSize((radius*2)+wt,(radius*2)+wt);return this;},end:function(){this._closePath();return this;},closePath:function()
{this._updateDrawingQueue(["closePath"]);this._updateDrawingQueue(["beginPath"]);return this;},clear:function(){this._initProps();if(this.node)
{this._context.clearRect(0,0,this.node.width,this.node.height);}
return this;},_getLinearGradient:function(){var isNumber=Y.Lang.isNumber,fill=this.get("fill"),stops=fill.stops,opacity,color,stop,i,len=stops.length,gradient,x=0,y=0,w=this.get("width"),h=this.get("height"),r=fill.rotation||0,x1,x2,y1,y2,cx=x+w/2,cy=y+h/2,offset,radCon=Math.PI/180,tanRadians=parseFloat(parseFloat(Math.tan(r*radCon)).toFixed(8));if(Math.abs(tanRadians)*w/2>=h/2)
{if(r<180)
{y1=y;y2=y+h;}
else
{y1=y+h;y2=y;}
x1=cx-((cy-y1)/tanRadians);x2=cx-((cy-y2)/tanRadians);}
else
{if(r>90&&r<270)
{x1=x+w;x2=x;}
else
{x1=x;x2=x+w;}
y1=((tanRadians*(cx-x1))-cy)*-1;y2=((tanRadians*(cx-x2))-cy)*-1;}
gradient=this._context.createLinearGradient(x1,y1,x2,y2);for(i=0;i<len;++i)
{stop=stops[i];opacity=stop.opacity;color=stop.color;offset=stop.offset;if(isNumber(opacity))
{opacity=Math.max(0,Math.min(1,opacity));color=this._toRGBA(color,opacity);}
else
{color=TORGB(color);}
offset=stop.offset||i/(len-1);gradient.addColorStop(offset,color);}
return gradient;},_getRadialGradient:function(){var isNumber=Y.Lang.isNumber,fill=this.get("fill"),r=fill.r,fx=fill.fx,fy=fill.fy,stops=fill.stops,opacity,color,stop,i,len=stops.length,gradient,x=0,y=0,w=this.get("width"),h=this.get("height"),x1,x2,y1,y2,r2,xc,yc,xn,yn,d,offset,ratio,stopMultiplier;xc=x+w/2;yc=y+h/2;x1=w*fx;y1=h*fy;x2=x+w/2;y2=y+h/2;r2=w*r;d=Math.sqrt(Math.pow(Math.abs(xc-x1),2)+Math.pow(Math.abs(yc-y1),2));if(d>=r2)
{ratio=d/r2;if(ratio===1)
{ratio=1.01;}
xn=(x1-xc)/ratio;yn=(y1-yc)/ratio;xn=xn>0?Math.floor(xn):Math.ceil(xn);yn=yn>0?Math.floor(yn):Math.ceil(yn);x1=xc+xn;y1=yc+yn;}
if(r>=0.5)
{gradient=this._context.createRadialGradient(x1,y1,r,x2,y2,r*w);stopMultiplier=1;}
else
{gradient=this._context.createRadialGradient(x1,y1,r,x2,y2,w/2);stopMultiplier=r*2;}
for(i=0;i<len;++i)
{stop=stops[i];opacity=stop.opacity;color=stop.color;offset=stop.offset;if(isNumber(opacity))
{opacity=Math.max(0,Math.min(1,opacity));color=this._toRGBA(color,opacity);}
else
{color=TORGB(color);}
offset=stop.offset||i/(len-1);offset*=stopMultiplier;if(offset<=1)
{gradient.addColorStop(offset,color);}}
return gradient;},_initProps:function(){this._methods=[];this._lineToMethods=[];this._xcoords=[0];this._ycoords=[0];this._width=0;this._height=0;this._left=0;this._top=0;this._right=0;this._bottom=0;this._currentX=0;this._currentY=0;},_drawingComplete:false,_createGraphic:function(){var graphic=Y.config.doc.createElement('canvas');return graphic;},getBezierData:function(points,t){var n=points.length,tmp=[],i,j;for(i=0;i<n;++i){tmp[i]=[points[i][0],points[i][1]];}
for(j=1;j<n;++j){for(i=0;i<n-j;++i){tmp[i][0]=(1-t)*tmp[i][0]+t*tmp[parseInt(i+1,10)][0];tmp[i][1]=(1-t)*tmp[i][1]+t*tmp[parseInt(i+1,10)][1];}}
return[tmp[0][0],tmp[0][1]];},_setCurveBoundingBox:function(pts,w,h)
{var i=0,left=this._currentX,right=left,top=this._currentY,bottom=top,len=Math.round(Math.sqrt((w*w)+(h*h))),t=1/len,wt=this._stroke&&this._strokeWeight?this._strokeWeight:0,xy;for(i=0;i<len;++i)
{xy=this.getBezierData(pts,t*i);left=isNaN(left)?xy[0]:Math.min(xy[0],left);right=isNaN(right)?xy[0]:Math.max(xy[0],right);top=isNaN(top)?xy[1]:Math.min(xy[1],top);bottom=isNaN(bottom)?xy[1]:Math.max(xy[1],bottom);}
left=Math.round(left*10)/10;right=Math.round(right*10)/10;top=Math.round(top*10)/10;bottom=Math.round(bottom*10)/10;this._trackSize(right+wt,bottom+wt);this._trackSize(left-wt,top-wt);},_trackSize:function(w,h){if(w>this._right){this._right=w;}
if(w<this._left)
{this._left=w;}
if(h<this._top)
{this._top=h;}
if(h>this._bottom)
{this._bottom=h;}
this._width=this._right-this._left;this._height=this._bottom-this._top;}};Y.CanvasDrawing=CanvasDrawing;CanvasShape=function()
{this._transforms=[];this.matrix=new Y.Matrix();CanvasShape.superclass.constructor.apply(this,arguments);};CanvasShape.NAME="shape";Y.extend(CanvasShape,Y.GraphicBase,Y.mix({init:function()
{this.initializer.apply(this,arguments);},initializer:function(cfg)
{var host=this,graphic=cfg.graphic,data=this.get("data");host._initProps();host.createNode();host._xcoords=[0];host._ycoords=[0];if(graphic)
{this._setGraphic(graphic);}
if(data)
{host._parsePathData(data);}
host._updateHandler();},_setGraphic:function(render)
{var graphic;if(render instanceof Y.CanvasGraphic)
{this._graphic=render;}
else
{graphic=new Y.CanvasGraphic({render:render});graphic._appendShape(this);this._graphic=graphic;}},addClass:function(className)
{var node=this.get("node");Y.DOM.addClass(node,className);},removeClass:function(className)
{var node=this.get("node");Y.DOM.removeClass(node,className);},getXY:function()
{var graphic=this.get("graphic"),parentXY=graphic.getXY(),x=this.get("x"),y=this.get("y");return[parentXY[0]+x,parentXY[1]+y];},setXY:function(xy)
{var graphic=this.get("graphic"),parentXY=graphic.getXY(),x=xy[0]-parentXY[0],y=xy[1]-parentXY[1];this._set("x",x);this._set("y",y);this._updateNodePosition(x,y);},contains:function(needle)
{var node=needle instanceof Y.Node?needle._node:needle;return node===this.node;},test:function(selector)
{return Y.Selector.test(this.node,selector);},compareTo:function(refNode){var node=this.node;return node===refNode;},_getDefaultFill:function(){return{type:"solid",opacity:1,cx:0.5,cy:0.5,fx:0.5,fy:0.5,r:0.5};},_getDefaultStroke:function()
{return{weight:1,dashstyle:"none",color:"#000",opacity:1.0};},_left:0,_right:0,_top:0,_bottom:0,createNode:function()
{var host=this,node=Y.config.doc.createElement('canvas'),id=host.get("id"),concat=host._camelCaseConcat,name=host.name;host._context=node.getContext('2d');node.setAttribute("overflow","visible");node.style.overflow="visible";if(!host.get("visible"))
{node.style.visibility="hidden";}
node.setAttribute("id",id);id="#"+id;host.node=node;host.addClass(_getClassName(SHAPE)+" "+
_getClassName(concat(IMPLEMENTATION,SHAPE))+" "+
_getClassName(name)+" "+
_getClassName(concat(IMPLEMENTATION,name)));},on:function(type,fn)
{if(Y.Node.DOM_EVENTS[type])
{return Y.on(type,fn,"#"+this.get("id"));}
return Y.on.apply(this,arguments);},_setStrokeProps:function(stroke)
{var color,weight,opacity,linejoin,linecap,dashstyle;if(stroke)
{color=stroke.color;weight=PARSE_FLOAT(stroke.weight);opacity=PARSE_FLOAT(stroke.opacity);linejoin=stroke.linejoin||"round";linecap=stroke.linecap||"butt";dashstyle=stroke.dashstyle;this._miterlimit=null;this._dashstyle=(dashstyle&&Y.Lang.isArray(dashstyle)&&dashstyle.length>1)?dashstyle:null;this._strokeWeight=weight;if(IS_NUMBER(weight)&&weight>0)
{this._stroke=1;}
else
{this._stroke=0;}
if(IS_NUMBER(opacity)){this._strokeStyle=this._toRGBA(color,opacity);}
else
{this._strokeStyle=color;}
this._linecap=linecap;if(linejoin==="round"||linejoin==="bevel")
{this._linejoin=linejoin;}
else
{linejoin=parseInt(linejoin,10);if(IS_NUMBER(linejoin))
{this._miterlimit=Math.max(linejoin,1);this._linejoin="miter";}}}
else
{this._stroke=0;}},set:function()
{var host=this;AttributeLite.prototype.set.apply(host,arguments);if(host.initialized)
{host._updateHandler();}},_setFillProps:function(fill)
{var isNumber=IS_NUMBER,color,opacity,type;if(fill)
{color=fill.color;type=fill.type;if(type==="linear"||type==="radial")
{this._fillType=type;}
else if(color)
{opacity=fill.opacity;if(isNumber(opacity))
{opacity=Math.max(0,Math.min(1,opacity));color=this._toRGBA(color,opacity);}
else
{color=TORGB(color);}
this._fillColor=color;this._fillType='solid';}
else
{this._fillColor=null;}}
else
{this._fillType=null;this._fillColor=null;}},translate:function(x,y)
{this._translateX+=x;this._translateY+=y;this._addTransform("translate",arguments);},translateX:function(x)
{this._translateX+=x;this._addTransform("translateX",arguments);},translateY:function(y)
{this._translateY+=y;this._addTransform("translateY",arguments);},skew:function()
{this._addTransform("skew",arguments);},skewX:function()
{this._addTransform("skewX",arguments);},skewY:function()
{this._addTransform("skewY",arguments);},rotate:function()
{this._addTransform("rotate",arguments);},scale:function()
{this._addTransform("scale",arguments);},_transform:"",_addTransform:function(type,args)
{args=Y.Array(args);this._transform=Y_LANG.trim(this._transform+" "+type+"("+args.join(", ")+")");args.unshift(type);this._transforms.push(args);if(this.initialized)
{this._updateTransform();}},_updateTransform:function()
{var node=this.node,key,transform,transformOrigin=this.get("transformOrigin"),matrix=this.matrix,i,len=this._transforms.length;if(this._transforms&&this._transforms.length>0)
{for(i=0;i<len;++i)
{key=this._transforms[i].shift();if(key)
{matrix[key].apply(matrix,this._transforms[i]);}}
transform=matrix.toCSSText();}
this._graphic.addToRedrawQueue(this);transformOrigin=(100*transformOrigin[0])+"% "+(100*transformOrigin[1])+"%";Y_DOM.setStyle(node,"transformOrigin",transformOrigin);if(transform)
{Y_DOM.setStyle(node,"transform",transform);}
this._transforms=[];},_updateHandler:function()
{this._draw();this._updateTransform();},_draw:function()
{var node=this.node;this.clear();this._closePath();node.style.left=this.get("x")+"px";node.style.top=this.get("y")+"px";},_closePath:function()
{if(!this._methods)
{return;}
var node=this.get("node"),w=this._right-this._left,h=this._bottom-this._top,context=this._context,methods=[],cachedMethods=this._methods.concat(),i,j,method,args,argsLen,len=0;this._context.clearRect(0,0,node.width,node.height);if(this._methods)
{len=cachedMethods.length;if(!len||len<1)
{return;}
for(i=0;i<len;++i)
{methods[i]=cachedMethods[i].concat();args=methods[i];argsLen=(args[0]==="quadraticCurveTo"||args[0]==="bezierCurveTo")?args.length:3;for(j=1;j<argsLen;++j)
{if(j%2===0)
{args[j]=args[j]-this._top;}
else
{args[j]=args[j]-this._left;}}}
node.setAttribute("width",Math.min(w,2000));node.setAttribute("height",Math.min(2000,h));context.beginPath();for(i=0;i<len;++i)
{args=methods[i].concat();if(args&&args.length>0)
{method=args.shift();if(method)
{if(method==="closePath")
{context.closePath();this._strokeAndFill(context);}
else if(method&&method==="lineTo"&&this._dashstyle)
{args.unshift(this._xcoords[i]-this._left,this._ycoords[i]-this._top);this._drawDashedLine.apply(this,args);}
else
{context[method].apply(context,args);}}}}
this._strokeAndFill(context);this._drawingComplete=true;this._clearAndUpdateCoords();this._updateNodePosition();this._methods=cachedMethods;}},_strokeAndFill:function(context)
{if(this._fillType)
{if(this._fillType==="linear")
{context.fillStyle=this._getLinearGradient();}
else if(this._fillType==="radial")
{context.fillStyle=this._getRadialGradient();}
else
{context.fillStyle=this._fillColor;}
context.closePath();context.fill();}
if(this._stroke){if(this._strokeWeight)
{context.lineWidth=this._strokeWeight;}
context.lineCap=this._linecap;context.lineJoin=this._linejoin;if(this._miterlimit)
{context.miterLimit=this._miterlimit;}
context.strokeStyle=this._strokeStyle;context.stroke();}},_drawDashedLine:function(xStart,yStart,xEnd,yEnd)
{var context=this._context,dashsize=this._dashstyle[0],gapsize=this._dashstyle[1],segmentLength=dashsize+gapsize,xDelta=xEnd-xStart,yDelta=yEnd-yStart,delta=Math.sqrt(Math.pow(xDelta,2)+Math.pow(yDelta,2)),segmentCount=Math.floor(Math.abs(delta / segmentLength)),radians=Math.atan2(yDelta,xDelta),xCurrent=xStart,yCurrent=yStart,i;xDelta=Math.cos(radians)*segmentLength;yDelta=Math.sin(radians)*segmentLength;for(i=0;i<segmentCount;++i)
{context.moveTo(xCurrent,yCurrent);context.lineTo(xCurrent+Math.cos(radians)*dashsize,yCurrent+Math.sin(radians)*dashsize);xCurrent+=xDelta;yCurrent+=yDelta;}
context.moveTo(xCurrent,yCurrent);delta=Math.sqrt((xEnd-xCurrent)*(xEnd-xCurrent)+(yEnd-yCurrent)*(yEnd-yCurrent));if(delta>dashsize)
{context.lineTo(xCurrent+Math.cos(radians)*dashsize,yCurrent+Math.sin(radians)*dashsize);}
else if(delta>0)
{context.lineTo(xCurrent+Math.cos(radians)*delta,yCurrent+Math.sin(radians)*delta);}
context.moveTo(xEnd,yEnd);},getBounds:function()
{var type=this._type,w=this.get("width"),h=this.get("height"),x=this.get("x"),y=this.get("y");if(type==="path")
{x=x+this._left;y=y+this._top;w=this._right-this._left;h=this._bottom-this._top;}
return this._getContentRect(w,h,x,y);},_getContentRect:function(w,h,x,y)
{var transformOrigin=this.get("transformOrigin"),transformX=transformOrigin[0]*w,transformY=transformOrigin[1]*h,transforms=this.matrix.getTransformArray(this.get("transform")),matrix=new Y.Matrix(),i,len=transforms.length,transform,key,contentRect;if(this._type==="path")
{transformX=transformX+x;transformY=transformY+y;}
transformX=!isNaN(transformX)?transformX:0;transformY=!isNaN(transformY)?transformY:0;matrix.translate(transformX,transformY);for(i=0;i<len;i=i+1)
{transform=transforms[i];key=transform.shift();if(key)
{matrix[key].apply(matrix,transform);}}
matrix.translate(-transformX,-transformY);contentRect=matrix.getContentRect(w,h,x,y);return contentRect;},toFront:function()
{var graphic=this.get("graphic");if(graphic)
{graphic._toFront(this);}},toBack:function()
{var graphic=this.get("graphic");if(graphic)
{graphic._toBack(this);}},_parsePathData:function(val)
{var method,methodSymbol,args,commandArray=Y.Lang.trim(val.match(SPLITPATHPATTERN)),i,len,str,symbolToMethod=this._pathSymbolToMethod;if(commandArray)
{this.clear();len=commandArray.length||0;for(i=0;i<len;i=i+1)
{str=commandArray[i];methodSymbol=str.substr(0,1);args=str.substr(1).match(SPLITARGSPATTERN);method=symbolToMethod[methodSymbol];if(method)
{if(args)
{this[method].apply(this,args);}
else
{this[method].apply(this);}}}
this.end();}},destroy:function()
{var graphic=this.get("graphic");if(graphic)
{graphic.removeShape(this);}
else
{this._destroy();}},_destroy:function()
{if(this.node)
{Y.Event.purgeElement(this.node,true);if(this.node.parentNode)
{this.node.style.visibility="";this.node.parentNode.removeChild(this.node);}
this._context=null;this.node=null;}}},Y.CanvasDrawing.prototype));CanvasShape.ATTRS={transformOrigin:{valueFn:function()
{return[0.5,0.5];}},transform:{setter:function(val)
{this.matrix.init();this._transforms=this.matrix.getTransformArray(val);this._transform=val;return val;},getter:function()
{return this._transform;}},node:{readOnly:true,getter:function()
{return this.node;}},id:{valueFn:function()
{return Y.guid();},setter:function(val)
{var node=this.node;if(node)
{node.setAttribute("id",val);}
return val;}},width:{value:0},height:{value:0},x:{value:0},y:{value:0},visible:{value:true,setter:function(val){var node=this.get("node"),visibility=val?"visible":"hidden";if(node)
{node.style.visibility=visibility;}
return val;}},fill:{valueFn:"_getDefaultFill",setter:function(val)
{var fill,tmpl=this.get("fill")||this._getDefaultFill();fill=(val)?Y.merge(tmpl,val):null;if(fill&&fill.color)
{if(fill.color===undefined||fill.color==="none")
{fill.color=null;}}
this._setFillProps(fill);return fill;}},stroke:{valueFn:"_getDefaultStroke",setter:function(val)
{var tmpl=this.get("stroke")||this._getDefaultStroke(),wt;if(val&&val.hasOwnProperty("weight"))
{wt=parseInt(val.weight,10);if(!isNaN(wt))
{val.weight=wt;}}
val=(val)?Y.merge(tmpl,val):null;this._setStrokeProps(val);return val;}},autoSize:{value:false},pointerEvents:{value:"visiblePainted"},data:{setter:function(val)
{if(this.get("node"))
{this._parsePathData(val);}
return val;}},graphic:{readOnly:true,getter:function()
{return this._graphic;}}};Y.CanvasShape=CanvasShape;CanvasPath=function()
{CanvasPath.superclass.constructor.apply(this,arguments);};CanvasPath.NAME="path";Y.extend(CanvasPath,Y.CanvasShape,{_type:"path",_draw:function()
{this._closePath();this._updateTransform();},createNode:function()
{var host=this,node=Y.config.doc.createElement('canvas'),name=host.name,concat=host._camelCaseConcat,id=host.get("id");host._context=node.getContext('2d');node.setAttribute("overflow","visible");node.setAttribute("pointer-events","none");node.style.pointerEvents="none";node.style.overflow="visible";node.setAttribute("id",id);id="#"+id;host.node=node;host.addClass(_getClassName(SHAPE)+" "+
_getClassName(concat(IMPLEMENTATION,SHAPE))+" "+
_getClassName(name)+" "+
_getClassName(concat(IMPLEMENTATION,name)));},end:function()
{this._draw();return this;}});CanvasPath.ATTRS=Y.merge(Y.CanvasShape.ATTRS,{width:{getter:function()
{var offset=this._stroke&&this._strokeWeight?(this._strokeWeight*2):0;return this._width-offset;},setter:function(val)
{this._width=val;return val;}},height:{getter:function()
{var offset=this._stroke&&this._strokeWeight?(this._strokeWeight*2):0;return this._height-offset;},setter:function(val)
{this._height=val;return val;}},path:{readOnly:true,getter:function()
{return this._path;}}});Y.CanvasPath=CanvasPath;CanvasRect=function()
{CanvasRect.superclass.constructor.apply(this,arguments);};CanvasRect.NAME="rect";Y.extend(CanvasRect,Y.CanvasShape,{_type:"rect",_draw:function()
{var w=this.get("width"),h=this.get("height");this.clear();this.drawRect(0,0,w,h);this._closePath();}});CanvasRect.ATTRS=Y.CanvasShape.ATTRS;Y.CanvasRect=CanvasRect;CanvasEllipse=function()
{CanvasEllipse.superclass.constructor.apply(this,arguments);};CanvasEllipse.NAME="ellipse";Y.extend(CanvasEllipse,CanvasShape,{_type:"ellipse",_draw:function()
{var w=this.get("width"),h=this.get("height");this.clear();this.drawEllipse(0,0,w,h);this._closePath();}});CanvasEllipse.ATTRS=Y.merge(CanvasShape.ATTRS,{xRadius:{setter:function(val)
{this.set("width",val*2);},getter:function()
{var val=this.get("width");if(val)
{val*=0.5;}
return val;}},yRadius:{setter:function(val)
{this.set("height",val*2);},getter:function()
{var val=this.get("height");if(val)
{val*=0.5;}
return val;}}});Y.CanvasEllipse=CanvasEllipse;CanvasCircle=function()
{CanvasCircle.superclass.constructor.apply(this,arguments);};CanvasCircle.NAME="circle";Y.extend(CanvasCircle,Y.CanvasShape,{_type:"circle",_draw:function()
{var radius=this.get("radius");if(radius)
{this.clear();this.drawCircle(0,0,radius);this._closePath();}}});CanvasCircle.ATTRS=Y.merge(Y.CanvasShape.ATTRS,{width:{setter:function(val)
{this.set("radius",val/2);return val;},getter:function()
{return this.get("radius")*2;}},height:{setter:function(val)
{this.set("radius",val/2);return val;},getter:function()
{return this.get("radius")*2;}},radius:{lazyAdd:false}});Y.CanvasCircle=CanvasCircle;CanvasPieSlice=function()
{CanvasPieSlice.superclass.constructor.apply(this,arguments);};CanvasPieSlice.NAME="canvasPieSlice";Y.extend(CanvasPieSlice,Y.CanvasShape,{_type:"path",_draw:function()
{var x=this.get("cx"),y=this.get("cy"),startAngle=this.get("startAngle"),arc=this.get("arc"),radius=this.get("radius");this.clear();this._left=x;this._right=radius;this._top=y;this._bottom=radius;this.drawWedge(x,y,startAngle,arc,radius);this.end();}});CanvasPieSlice.ATTRS=Y.mix({cx:{value:0},cy:{value:0},startAngle:{value:0},arc:{value:0},radius:{value:0}},Y.CanvasShape.ATTRS);Y.CanvasPieSlice=CanvasPieSlice;function CanvasGraphic(){CanvasGraphic.superclass.constructor.apply(this,arguments);}
CanvasGraphic.NAME="canvasGraphic";CanvasGraphic.ATTRS={render:{},id:{valueFn:function()
{return Y.guid();},setter:function(val)
{var node=this._node;if(node)
{node.setAttribute("id",val);}
return val;}},shapes:{readOnly:true,getter:function()
{return this._shapes;}},contentBounds:{readOnly:true,getter:function()
{return this._contentBounds;}},node:{readOnly:true,getter:function()
{return this._node;}},width:{setter:function(val)
{if(this._node)
{this._node.style.width=val+"px";}
return val;}},height:{setter:function(val)
{if(this._node)
{this._node.style.height=val+"px";}
return val;}},autoSize:{value:false},preserveAspectRatio:{value:"xMidYMid"},resizeDown:{value:false},x:{getter:function()
{return this._x;},setter:function(val)
{this._x=val;if(this._node)
{this._node.style.left=val+"px";}
return val;}},y:{getter:function()
{return this._y;},setter:function(val)
{this._y=val;if(this._node)
{this._node.style.top=val+"px";}
return val;}},autoDraw:{value:true},visible:{value:true,setter:function(val)
{this._toggleVisible(val);return val;}}};Y.extend(CanvasGraphic,Y.GraphicBase,{set:function()
{var host=this,attr=arguments[0],redrawAttrs={autoDraw:true,autoSize:true,preserveAspectRatio:true,resizeDown:true},key,forceRedraw=false;AttributeLite.prototype.set.apply(host,arguments);if(host._state.autoDraw===true&&Y.Object.size(this._shapes)>0)
{if(Y_LANG.isString&&redrawAttrs[attr])
{forceRedraw=true;}
else if(Y_LANG.isObject(attr))
{for(key in redrawAttrs)
{if(redrawAttrs.hasOwnProperty(key)&&attr[key])
{forceRedraw=true;break;}}}}
if(forceRedraw)
{host._redraw();}},_x:0,_y:0,getXY:function()
{var node=this._node,xy;if(node)
{xy=Y.DOM.getXY(node);}
return xy;},initializer:function(){var render=this.get("render"),visibility=this.get("visible")?"visible":"hidden",w=this.get("width")||0,h=this.get("height")||0;this._shapes={};this._redrawQueue={};this._contentBounds={left:0,top:0,right:0,bottom:0};this._node=DOCUMENT.createElement('div');this._node.style.position="absolute";this._node.style.visibility=visibility;this.set("width",w);this.set("height",h);if(render)
{this.render(render);}},render:function(render){var parentNode=render||DOCUMENT.body,node=this._node,w,h;if(render instanceof Y.Node)
{parentNode=render._node;}
else if(Y.Lang.isString(render))
{parentNode=Y.Selector.query(render,DOCUMENT.body,true);}
w=this.get("width")||parseInt(Y.DOM.getComputedStyle(parentNode,"width"),10);h=this.get("height")||parseInt(Y.DOM.getComputedStyle(parentNode,"height"),10);parentNode.appendChild(node);node.style.display="block";node.style.position="absolute";node.style.left=this.get("x")+"px";node.style.top=this.get("y")+"px";this.set("width",w);this.set("height",h);this.parentNode=parentNode;return this;},destroy:function()
{this.removeAllShapes();if(this._node)
{this._removeChildren(this._node);if(this._node.parentNode)
{this._node.parentNode.removeChild(this._node);}
this._node=null;}},addShape:function(cfg)
{cfg.graphic=this;if(!this.get("visible"))
{cfg.visible=false;}
var ShapeClass=this._getShapeClass(cfg.type),shape=new ShapeClass(cfg);this._appendShape(shape);return shape;},_appendShape:function(shape)
{var node=shape.node,parentNode=this._frag||this._node;if(this.get("autoDraw"))
{parentNode.appendChild(node);}
else
{this._getDocFrag().appendChild(node);}},removeShape:function(shape)
{if(!(shape instanceof CanvasShape))
{if(Y_LANG.isString(shape))
{shape=this._shapes[shape];}}
if(shape&&shape instanceof CanvasShape)
{shape._destroy();delete this._shapes[shape.get("id")];}
if(this.get("autoDraw"))
{this._redraw();}
return shape;},removeAllShapes:function()
{var shapes=this._shapes,i;for(i in shapes)
{if(shapes.hasOwnProperty(i))
{shapes[i].destroy();}}
this._shapes={};},clear:function(){this.removeAllShapes();},_removeChildren:function(node)
{if(node&&node.hasChildNodes())
{var child;while(node.firstChild)
{child=node.firstChild;this._removeChildren(child);node.removeChild(child);}}},_toggleVisible:function(val)
{var i,shapes=this._shapes,visibility=val?"visible":"hidden";if(shapes)
{for(i in shapes)
{if(shapes.hasOwnProperty(i))
{shapes[i].set("visible",val);}}}
if(this._node)
{this._node.style.visibility=visibility;}},_getShapeClass:function(val)
{var shape=this._shapeClass[val];if(shape)
{return shape;}
return val;},_shapeClass:{circle:Y.CanvasCircle,rect:Y.CanvasRect,path:Y.CanvasPath,ellipse:Y.CanvasEllipse,pieslice:Y.CanvasPieSlice},getShapeById:function(id)
{var shape=this._shapes[id];return shape;},batch:function(method)
{var autoDraw=this.get("autoDraw");this.set("autoDraw",false);method();this.set("autoDraw",autoDraw);},_getDocFrag:function()
{if(!this._frag)
{this._frag=DOCUMENT.createDocumentFragment();}
return this._frag;},_redraw:function()
{var autoSize=this.get("autoSize"),preserveAspectRatio=this.get("preserveAspectRatio"),box=this.get("resizeDown")?this._getUpdatedContentBounds():this._contentBounds,contentWidth,contentHeight,w,h,xScale,yScale,translateX=0,translateY=0,matrix,node=this.get("node");if(autoSize)
{if(autoSize==="sizeContentToGraphic")
{contentWidth=box.right-box.left;contentHeight=box.bottom-box.top;w=parseFloat(Y_DOM.getComputedStyle(node,"width"));h=parseFloat(Y_DOM.getComputedStyle(node,"height"));matrix=new Y.Matrix();if(preserveAspectRatio==="none")
{xScale=w/contentWidth;yScale=h/contentHeight;}
else
{if(contentWidth/contentHeight!==w/h)
{if(contentWidth*h/contentHeight>w)
{xScale=yScale=w/contentWidth;translateY=this._calculateTranslate(preserveAspectRatio.slice(5).toLowerCase(),contentHeight*w/contentWidth,h);}
else
{xScale=yScale=h/contentHeight;translateX=this._calculateTranslate(preserveAspectRatio.slice(1,4).toLowerCase(),contentWidth*h/contentHeight,w);}}}
Y_DOM.setStyle(node,"transformOrigin","0% 0%");translateX=translateX-(box.left*xScale);translateY=translateY-(box.top*yScale);matrix.translate(translateX,translateY);matrix.scale(xScale,yScale);Y_DOM.setStyle(node,"transform",matrix.toCSSText());}
else
{this.set("width",box.right);this.set("height",box.bottom);}}
if(this._frag)
{this._node.appendChild(this._frag);this._frag=null;}},_calculateTranslate:function(position,contentSize,boundsSize)
{var ratio=boundsSize-contentSize,coord;switch(position)
{case"mid":coord=ratio*0.5;break;case"max":coord=ratio;break;default:coord=0;break;}
return coord;},addToRedrawQueue:function(shape)
{var shapeBox,box;this._shapes[shape.get("id")]=shape;if(!this.get("resizeDown"))
{shapeBox=shape.getBounds();box=this._contentBounds;box.left=box.left<shapeBox.left?box.left:shapeBox.left;box.top=box.top<shapeBox.top?box.top:shapeBox.top;box.right=box.right>shapeBox.right?box.right:shapeBox.right;box.bottom=box.bottom>shapeBox.bottom?box.bottom:shapeBox.bottom;this._contentBounds=box;}
if(this.get("autoDraw"))
{this._redraw();}},_getUpdatedContentBounds:function()
{var bounds,i,shape,queue=this._shapes,box={};for(i in queue)
{if(queue.hasOwnProperty(i))
{shape=queue[i];bounds=shape.getBounds();box.left=Y_LANG.isNumber(box.left)?Math.min(box.left,bounds.left):bounds.left;box.top=Y_LANG.isNumber(box.top)?Math.min(box.top,bounds.top):bounds.top;box.right=Y_LANG.isNumber(box.right)?Math.max(box.right,bounds.right):bounds.right;box.bottom=Y_LANG.isNumber(box.bottom)?Math.max(box.bottom,bounds.bottom):bounds.bottom;}}
box.left=Y_LANG.isNumber(box.left)?box.left:0;box.top=Y_LANG.isNumber(box.top)?box.top:0;box.right=Y_LANG.isNumber(box.right)?box.right:0;box.bottom=Y_LANG.isNumber(box.bottom)?box.bottom:0;this._contentBounds=box;return box;},_toFront:function(shape)
{var contentNode=this.get("node");if(shape instanceof Y.CanvasShape)
{shape=shape.get("node");}
if(contentNode&&shape)
{contentNode.appendChild(shape);}},_toBack:function(shape)
{var contentNode=this.get("node"),targetNode;if(shape instanceof Y.CanvasShape)
{shape=shape.get("node");}
if(contentNode&&shape)
{targetNode=contentNode.firstChild;if(targetNode)
{contentNode.insertBefore(shape,targetNode);}
else
{contentNode.appendChild(shape);}}}});Y.CanvasGraphic=CanvasGraphic;},'3.15.0',{"requires":["graphics"]});