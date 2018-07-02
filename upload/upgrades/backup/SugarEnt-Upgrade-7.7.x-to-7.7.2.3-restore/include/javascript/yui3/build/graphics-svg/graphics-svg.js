/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('graphics-svg',function(Y,NAME){var IMPLEMENTATION="svg",SHAPE="shape",SPLITPATHPATTERN=/[a-z][^a-z]*/ig,SPLITARGSPATTERN=/[\-]?[0-9]*[0-9|\.][0-9]*/g,Y_LANG=Y.Lang,AttributeLite=Y.AttributeLite,SVGGraphic,SVGShape,SVGCircle,SVGRect,SVGPath,SVGEllipse,SVGPieSlice,DOCUMENT=Y.config.doc,_getClassName=Y.ClassNameManager.getClassName;function SVGDrawing(){}
SVGDrawing.prototype={_round:function(val){return Math.round(val*100)/100;},_pathSymbolToMethod:{M:"moveTo",m:"relativeMoveTo",L:"lineTo",l:"relativeLineTo",C:"curveTo",c:"relativeCurveTo",Q:"quadraticCurveTo",q:"relativeQuadraticCurveTo",z:"closePath",Z:"closePath"},_currentX:0,_currentY:0,_type:"path",curveTo:function(){this._curveTo.apply(this,[Y.Array(arguments),false]);return this;},relativeCurveTo:function(){this._curveTo.apply(this,[Y.Array(arguments),true]);return this;},_curveTo:function(args,relative){var w,h,pts,cp1x,cp1y,cp2x,cp2y,x,y,right,left,bottom,top,i,len,pathArrayLen,currentArray,command=relative?"c":"C",relativeX=relative?parseFloat(this._currentX):0,relativeY=relative?parseFloat(this._currentY):0;this._pathArray=this._pathArray||[];if(this._pathType!==command)
{this._pathType=command;currentArray=[command];this._pathArray.push(currentArray);}
else
{currentArray=this._pathArray[Math.max(0,this._pathArray.length-1)];if(!currentArray)
{currentArray=[];this._pathArray.push(currentArray);}}
pathArrayLen=this._pathArray.length-1;this._pathArray[pathArrayLen]=this._pathArray[pathArrayLen].concat(args);len=args.length-5;for(i=0;i<len;i=i+6)
{cp1x=parseFloat(args[i])+relativeX;cp1y=parseFloat(args[i+1])+relativeY;cp2x=parseFloat(args[i+2])+relativeX;cp2y=parseFloat(args[i+3])+relativeY;x=parseFloat(args[i+4])+relativeX;y=parseFloat(args[i+5])+relativeY;right=Math.max(x,Math.max(cp1x,cp2x));bottom=Math.max(y,Math.max(cp1y,cp2y));left=Math.min(x,Math.min(cp1x,cp2x));top=Math.min(y,Math.min(cp1y,cp2y));w=Math.abs(right-left);h=Math.abs(bottom-top);pts=[[this._currentX,this._currentY],[cp1x,cp1y],[cp2x,cp2y],[x,y]];this._setCurveBoundingBox(pts,w,h);this._currentX=x;this._currentY=y;}},quadraticCurveTo:function(){this._quadraticCurveTo.apply(this,[Y.Array(arguments),false]);return this;},relativeQuadraticCurveTo:function(){this._quadraticCurveTo.apply(this,[Y.Array(arguments),true]);return this;},_quadraticCurveTo:function(args,relative){var cpx,cpy,x,y,pathArrayLen,currentArray,w,h,pts,right,left,bottom,top,i,len,command=relative?"q":"Q",relativeX=relative?parseFloat(this._currentX):0,relativeY=relative?parseFloat(this._currentY):0;this._pathArray=this._pathArray||[];if(this._pathType!==command)
{this._pathType=command;currentArray=[command];this._pathArray.push(currentArray);}
else
{currentArray=this._pathArray[Math.max(0,this._pathArray.length-1)];if(!currentArray)
{currentArray=[];this._pathArray.push(currentArray);}}
pathArrayLen=this._pathArray.length-1;this._pathArray[pathArrayLen]=this._pathArray[pathArrayLen].concat(args);len=args.length-3;for(i=0;i<len;i=i+4)
{cpx=parseFloat(args[i])+relativeX;cpy=parseFloat(args[i+1])+relativeY;x=parseFloat(args[i+2])+relativeX;y=parseFloat(args[i+3])+relativeY;right=Math.max(x,cpx);bottom=Math.max(y,cpy);left=Math.min(x,cpx);top=Math.min(y,cpy);w=Math.abs(right-left);h=Math.abs(bottom-top);pts=[[this._currentX,this._currentY],[cpx,cpy],[x,y]];this._setCurveBoundingBox(pts,w,h);this._currentX=x;this._currentY=y;}},drawRect:function(x,y,w,h){this.moveTo(x,y);this.lineTo(x+w,y);this.lineTo(x+w,y+h);this.lineTo(x,y+h);this.lineTo(x,y);return this;},drawRoundRect:function(x,y,w,h,ew,eh){this.moveTo(x,y+eh);this.lineTo(x,y+h-eh);this.quadraticCurveTo(x,y+h,x+ew,y+h);this.lineTo(x+w-ew,y+h);this.quadraticCurveTo(x+w,y+h,x+w,y+h-eh);this.lineTo(x+w,y+eh);this.quadraticCurveTo(x+w,y,x+w-ew,y);this.lineTo(x+ew,y);this.quadraticCurveTo(x,y,x,y+eh);return this;},drawCircle:function(x,y,radius){var circum=radius*2;this._drawingComplete=false;this._trackSize(x,y);this._trackSize(x+circum,y+circum);this._pathArray=this._pathArray||[];this._pathArray.push(["M",x+radius,y]);this._pathArray.push(["A",radius,radius,0,1,0,x+radius,y+circum]);this._pathArray.push(["A",radius,radius,0,1,0,x+radius,y]);this._currentX=x;this._currentY=y;return this;},drawEllipse:function(x,y,w,h){var radius=w*0.5,yRadius=h*0.5;this._drawingComplete=false;this._trackSize(x,y);this._trackSize(x+w,y+h);this._pathArray=this._pathArray||[];this._pathArray.push(["M",x+radius,y]);this._pathArray.push(["A",radius,yRadius,0,1,0,x+radius,y+h]);this._pathArray.push(["A",radius,yRadius,0,1,0,x+radius,y]);this._currentX=x;this._currentY=y;return this;},drawDiamond:function(x,y,width,height)
{var midWidth=width*0.5,midHeight=height*0.5;this.moveTo(x+midWidth,y);this.lineTo(x+width,y+midHeight);this.lineTo(x+midWidth,y+height);this.lineTo(x,y+midHeight);this.lineTo(x+midWidth,y);return this;},drawWedge:function(x,y,startAngle,arc,radius,yRadius)
{var segs,segAngle,theta,angle,angleMid,ax,ay,bx,by,cx,cy,i,diameter=radius*2,currentArray,pathArrayLen;this._pathArray=this._pathArray||[];yRadius=yRadius||radius;if(this._pathType!=="M")
{this._pathType="M";currentArray=["M"];this._pathArray.push(currentArray);}
else
{currentArray=this._getCurrentArray();}
pathArrayLen=this._pathArray.length-1;this._pathArray[pathArrayLen].push(x);this._pathArray[pathArrayLen].push(x);if(Math.abs(arc)>360)
{arc=360;}
segs=Math.ceil(Math.abs(arc)/ 45);segAngle=arc / segs;theta=-(segAngle / 180)*Math.PI;angle=(startAngle / 180)*Math.PI;if(segs>0)
{ax=x+Math.cos(startAngle / 180*Math.PI)*radius;ay=y+Math.sin(startAngle / 180*Math.PI)*yRadius;this._pathType="L";pathArrayLen++;this._pathArray[pathArrayLen]=["L"];this._pathArray[pathArrayLen].push(this._round(ax));this._pathArray[pathArrayLen].push(this._round(ay));pathArrayLen++;this._pathType="Q";this._pathArray[pathArrayLen]=["Q"];for(i=0;i<segs;++i)
{angle+=theta;angleMid=angle-(theta / 2);bx=x+Math.cos(angle)*radius;by=y+Math.sin(angle)*yRadius;cx=x+Math.cos(angleMid)*(radius / Math.cos(theta / 2));cy=y+Math.sin(angleMid)*(yRadius / Math.cos(theta / 2));this._pathArray[pathArrayLen].push(this._round(cx));this._pathArray[pathArrayLen].push(this._round(cy));this._pathArray[pathArrayLen].push(this._round(bx));this._pathArray[pathArrayLen].push(this._round(by));}}
this._currentX=x;this._currentY=y;this._trackSize(diameter,diameter);return this;},lineTo:function()
{this._lineTo.apply(this,[Y.Array(arguments),false]);return this;},relativeLineTo:function()
{this._lineTo.apply(this,[Y.Array(arguments),true]);return this;},_lineTo:function(args,relative){var point1=args[0],i,len,pathArrayLen,currentArray,x,y,command=relative?"l":"L",relativeX=relative?parseFloat(this._currentX):0,relativeY=relative?parseFloat(this._currentY):0;this._pathArray=this._pathArray||[];this._shapeType="path";len=args.length;if(this._pathType!==command)
{this._pathType=command;currentArray=[command];this._pathArray.push(currentArray);}
else
{currentArray=this._getCurrentArray();}
pathArrayLen=this._pathArray.length-1;if(typeof point1==='string'||typeof point1==='number'){for(i=0;i<len;i=i+2){x=parseFloat(args[i]);y=parseFloat(args[i+1]);this._pathArray[pathArrayLen].push(x);this._pathArray[pathArrayLen].push(y);x=x+relativeX;y=y+relativeY;this._currentX=x;this._currentY=y;this._trackSize.apply(this,[x,y]);}}
else
{for(i=0;i<len;++i){x=parseFloat(args[i][0]);y=parseFloat(args[i][1]);this._pathArray[pathArrayLen].push(x);this._pathArray[pathArrayLen].push(y);this._currentX=x;this._currentY=y;x=x+relativeX;y=y+relativeY;this._trackSize.apply(this,[x,y]);}}},moveTo:function()
{this._moveTo.apply(this,[Y.Array(arguments),false]);return this;},relativeMoveTo:function()
{this._moveTo.apply(this,[Y.Array(arguments),true]);return this;},_moveTo:function(args,relative){var pathArrayLen,currentArray,x=parseFloat(args[0]),y=parseFloat(args[1]),command=relative?"m":"M",relativeX=relative?parseFloat(this._currentX):0,relativeY=relative?parseFloat(this._currentY):0;this._pathArray=this._pathArray||[];this._pathType=command;currentArray=[command];this._pathArray.push(currentArray);pathArrayLen=this._pathArray.length-1;this._pathArray[pathArrayLen]=this._pathArray[pathArrayLen].concat([x,y]);x=x+relativeX;y=y+relativeY;this._currentX=x;this._currentY=y;this._trackSize(x,y);},end:function()
{this._closePath();return this;},clear:function()
{this._currentX=0;this._currentY=0;this._width=0;this._height=0;this._left=0;this._right=0;this._top=0;this._bottom=0;this._pathArray=[];this._path="";this._pathType="";return this;},_closePath:function()
{var pathArray,segmentArray,pathType,len,val,i,path="",node=this.node,left=parseFloat(this._left),top=parseFloat(this._top),fill=this.get("fill");if(this._pathArray)
{pathArray=this._pathArray.concat();while(pathArray&&pathArray.length>0)
{segmentArray=pathArray.shift();len=segmentArray.length;pathType=segmentArray[0];if(pathType==="A")
{path+=pathType+segmentArray[1]+","+segmentArray[2];}
else if(pathType==="z"||pathType==="Z")
{path+=" z ";}
else if(pathType==="C"||pathType==="c")
{path+=pathType+(segmentArray[1]-left)+","+(segmentArray[2]-top);}
else
{path+=" "+pathType+parseFloat(segmentArray[1]-left);}
switch(pathType)
{case"L":case"l":case"M":case"m":case"Q":case"q":for(i=2;i<len;++i)
{val=(i%2===0)?top:left;val=segmentArray[i]-val;path+=", "+parseFloat(val);}
break;case"A":val=" "+parseFloat(segmentArray[3])+" "+parseFloat(segmentArray[4]);val+=","+parseFloat(segmentArray[5])+" "+parseFloat(segmentArray[6]-left);val+=","+parseFloat(segmentArray[7]-top);path+=" "+val;break;case"C":case"c":for(i=3;i<len-1;i=i+2)
{val=parseFloat(segmentArray[i]-left);val=val+", ";val=val+parseFloat(segmentArray[i+1]-top);path+=" "+val;}
break;}}
if(fill&&fill.color)
{path+='z';}
Y.Lang.trim(path);if(path)
{node.setAttribute("d",path);}
this._path=path;this._fillChangeHandler();this._strokeChangeHandler();this._updateTransform();}},closePath:function()
{this._pathArray.push(["z"]);return this;},_getCurrentArray:function()
{var currentArray=this._pathArray[Math.max(0,this._pathArray.length-1)];if(!currentArray)
{currentArray=[];this._pathArray.push(currentArray);}
return currentArray;},getBezierData:function(points,t){var n=points.length,tmp=[],i,j;for(i=0;i<n;++i){tmp[i]=[points[i][0],points[i][1]];}
for(j=1;j<n;++j){for(i=0;i<n-j;++i){tmp[i][0]=(1-t)*tmp[i][0]+t*tmp[parseInt(i+1,10)][0];tmp[i][1]=(1-t)*tmp[i][1]+t*tmp[parseInt(i+1,10)][1];}}
return[tmp[0][0],tmp[0][1]];},_setCurveBoundingBox:function(pts,w,h)
{var i,left=this._currentX,right=left,top=this._currentY,bottom=top,len=Math.round(Math.sqrt((w*w)+(h*h))),t=1/len,xy;for(i=0;i<len;++i)
{xy=this.getBezierData(pts,t*i);left=isNaN(left)?xy[0]:Math.min(xy[0],left);right=isNaN(right)?xy[0]:Math.max(xy[0],right);top=isNaN(top)?xy[1]:Math.min(xy[1],top);bottom=isNaN(bottom)?xy[1]:Math.max(xy[1],bottom);}
left=Math.round(left*10)/10;right=Math.round(right*10)/10;top=Math.round(top*10)/10;bottom=Math.round(bottom*10)/10;this._trackSize(right,bottom);this._trackSize(left,top);},_trackSize:function(w,h){if(w>this._right){this._right=w;}
if(w<this._left)
{this._left=w;}
if(h<this._top)
{this._top=h;}
if(h>this._bottom)
{this._bottom=h;}
this._width=this._right-this._left;this._height=this._bottom-this._top;}};Y.SVGDrawing=SVGDrawing;SVGShape=function()
{this._transforms=[];this.matrix=new Y.Matrix();this._normalizedMatrix=new Y.Matrix();SVGShape.superclass.constructor.apply(this,arguments);};SVGShape.NAME="shape";Y.extend(SVGShape,Y.GraphicBase,Y.mix({_x:0,_y:0,init:function()
{this.initializer.apply(this,arguments);},initializer:function(cfg)
{var host=this,graphic=cfg.graphic,data=this.get("data");host.createNode();if(graphic)
{host._setGraphic(graphic);}
if(data)
{host._parsePathData(data);}
host._updateHandler();},_setGraphic:function(render)
{var graphic;if(render instanceof Y.SVGGraphic)
{this._graphic=render;}
else
{graphic=new Y.SVGGraphic({render:render});graphic._appendShape(this);this._graphic=graphic;}},addClass:function(className)
{var node=this.node;node.className.baseVal=Y_LANG.trim([node.className.baseVal,className].join(' '));},removeClass:function(className)
{var node=this.node,classString=node.className.baseVal;classString=classString.replace(new RegExp(className+' '),className).replace(new RegExp(className),'');node.className.baseVal=classString;},getXY:function()
{var graphic=this._graphic,parentXY=graphic.getXY(),x=this._x,y=this._y;return[parentXY[0]+x,parentXY[1]+y];},setXY:function(xy)
{var graphic=this._graphic,parentXY=graphic.getXY();this._x=xy[0]-parentXY[0];this._y=xy[1]-parentXY[1];this.set("transform",this.get("transform"));},contains:function(needle)
{var node=needle instanceof Y.Node?needle._node:needle;return node===this.node;},compareTo:function(refNode){var node=this.node;return node===refNode;},test:function(selector)
{return Y.Selector.test(this.node,selector);},_getDefaultFill:function(){return{type:"solid",opacity:1,cx:0.5,cy:0.5,fx:0.5,fy:0.5,r:0.5};},_getDefaultStroke:function()
{return{weight:1,dashstyle:"none",color:"#000",opacity:1.0};},createNode:function()
{var host=this,node=DOCUMENT.createElementNS("http://www.w3.org/2000/svg","svg:"+this._type),id=host.get("id"),name=host.name,concat=host._camelCaseConcat,pointerEvents=host.get("pointerEvents");host.node=node;host.addClass(_getClassName(SHAPE)+" "+
_getClassName(concat(IMPLEMENTATION,SHAPE))+" "+
_getClassName(name)+" "+
_getClassName(concat(IMPLEMENTATION,name)));if(id)
{node.setAttribute("id",id);}
if(pointerEvents)
{node.setAttribute("pointer-events",pointerEvents);}
if(!host.get("visible"))
{Y.DOM.setStyle(node,"visibility","hidden");}
Y.DOM.setAttribute(this.node,"shape-rendering",this.get("shapeRendering"));},on:function(type,fn)
{if(Y.Node.DOM_EVENTS[type])
{return Y.on(type,fn,"#"+this.get("id"));}
return Y.on.apply(this,arguments);},_strokeChangeHandler:function()
{var node=this.node,stroke=this.get("stroke"),strokeOpacity,dashstyle,dash,linejoin;if(stroke&&stroke.weight&&stroke.weight>0)
{linejoin=stroke.linejoin||"round";strokeOpacity=parseFloat(stroke.opacity);dashstyle=stroke.dashstyle||"none";dash=Y_LANG.isArray(dashstyle)?dashstyle.toString():dashstyle;stroke.color=stroke.color||"#000000";stroke.weight=stroke.weight||1;stroke.opacity=Y_LANG.isNumber(strokeOpacity)?strokeOpacity:1;stroke.linecap=stroke.linecap||"butt";node.setAttribute("stroke-dasharray",dash);node.setAttribute("stroke",stroke.color);node.setAttribute("stroke-linecap",stroke.linecap);node.setAttribute("stroke-width",stroke.weight);node.setAttribute("stroke-opacity",stroke.opacity);if(linejoin==="round"||linejoin==="bevel")
{node.setAttribute("stroke-linejoin",linejoin);}
else
{linejoin=parseInt(linejoin,10);if(Y_LANG.isNumber(linejoin))
{node.setAttribute("stroke-miterlimit",Math.max(linejoin,1));node.setAttribute("stroke-linejoin","miter");}}}
else
{node.setAttribute("stroke","none");}},_fillChangeHandler:function()
{var node=this.node,fill=this.get("fill"),fillOpacity,type;if(fill)
{type=fill.type;if(type==="linear"||type==="radial")
{this._setGradientFill(fill);node.setAttribute("fill","url(#grad"+this.get("id")+")");}
else if(!fill.color)
{node.setAttribute("fill","none");}
else
{fillOpacity=parseFloat(fill.opacity);fillOpacity=Y_LANG.isNumber(fillOpacity)?fillOpacity:1;node.setAttribute("fill",fill.color);node.setAttribute("fill-opacity",fillOpacity);}}
else
{node.setAttribute("fill","none");}},_setGradientFill:function(fill){var offset,opacity,color,stopNode,newStop,isNumber=Y_LANG.isNumber,graphic=this._graphic,type=fill.type,gradientNode=graphic.getGradientNode("grad"+this.get("id"),type),stops=fill.stops,w=this.get("width"),h=this.get("height"),rotation=fill.rotation||0,radCon=Math.PI/180,tanRadians=parseFloat(parseFloat(Math.tan(rotation*radCon)).toFixed(8)),i,len,def,stop,x1="0%",x2="100%",y1="0%",y2="0%",cx=fill.cx,cy=fill.cy,fx=fill.fx,fy=fill.fy,r=fill.r,stopNodes=[];if(type==="linear")
{cx=w/2;cy=h/2;if(Math.abs(tanRadians)*w/2>=h/2)
{if(rotation<180)
{y1=0;y2=h;}
else
{y1=h;y2=0;}
x1=cx-((cy-y1)/tanRadians);x2=cx-((cy-y2)/tanRadians);}
else
{if(rotation>90&&rotation<270)
{x1=w;x2=0;}
else
{x1=0;x2=w;}
y1=((tanRadians*(cx-x1))-cy)*-1;y2=((tanRadians*(cx-x2))-cy)*-1;}
x1=Math.round(100*x1/w);x2=Math.round(100*x2/w);y1=Math.round(100*y1/h);y2=Math.round(100*y2/h);x1=isNumber(x1)?x1:0;x2=isNumber(x2)?x2:100;y1=isNumber(y1)?y1:0;y2=isNumber(y2)?y2:0;gradientNode.setAttribute("spreadMethod","pad");gradientNode.setAttribute("width",w);gradientNode.setAttribute("height",h);gradientNode.setAttribute("x1",x1+"%");gradientNode.setAttribute("x2",x2+"%");gradientNode.setAttribute("y1",y1+"%");gradientNode.setAttribute("y2",y2+"%");}
else
{gradientNode.setAttribute("cx",(cx*100)+"%");gradientNode.setAttribute("cy",(cy*100)+"%");gradientNode.setAttribute("fx",(fx*100)+"%");gradientNode.setAttribute("fy",(fy*100)+"%");gradientNode.setAttribute("r",(r*100)+"%");}
len=stops.length;def=0;for(i=0;i<len;++i)
{if(this._stops&&this._stops.length>0)
{stopNode=this._stops.shift();newStop=false;}
else
{stopNode=graphic._createGraphicNode("stop");newStop=true;}
stop=stops[i];opacity=stop.opacity;color=stop.color;offset=stop.offset||i/(len-1);offset=Math.round(offset*100)+"%";opacity=isNumber(opacity)?opacity:1;opacity=Math.max(0,Math.min(1,opacity));def=(i+1)/ len;stopNode.setAttribute("offset",offset);stopNode.setAttribute("stop-color",color);stopNode.setAttribute("stop-opacity",opacity);if(newStop)
{gradientNode.appendChild(stopNode);}
stopNodes.push(stopNode);}
while(this._stops&&this._stops.length>0)
{gradientNode.removeChild(this._stops.shift());}
this._stops=stopNodes;},_stops:null,set:function()
{var host=this;AttributeLite.prototype.set.apply(host,arguments);if(host.initialized)
{host._updateHandler();}},translate:function()
{this._addTransform("translate",arguments);},translateX:function()
{this._addTransform("translateX",arguments);},translateY:function()
{this._addTransform("translateY",arguments);},skew:function()
{this._addTransform("skew",arguments);},skewX:function()
{this._addTransform("skewX",arguments);},skewY:function()
{this._addTransform("skewY",arguments);},rotate:function()
{this._addTransform("rotate",arguments);},scale:function()
{this._addTransform("scale",arguments);},_addTransform:function(type,args)
{args=Y.Array(args);this._transform=Y_LANG.trim(this._transform+" "+type+"("+args.join(", ")+")");args.unshift(type);this._transforms.push(args);if(this.initialized)
{this._updateTransform();}},_updateTransform:function()
{var isPath=this._type==="path",node=this.node,key,transform,transformOrigin,x,y,tx,ty,matrix=this.matrix,normalizedMatrix=this._normalizedMatrix,i,len=this._transforms.length;if(isPath||(this._transforms&&this._transforms.length>0))
{x=this._x;y=this._y;transformOrigin=this.get("transformOrigin");tx=x+(transformOrigin[0]*this.get("width"));ty=y+(transformOrigin[1]*this.get("height"));if(isPath)
{if(!(this instanceof Y.SVGPath))
{tx=this._left+(transformOrigin[0]*this.get("width"));ty=this._top+(transformOrigin[1]*this.get("height"));}
normalizedMatrix.init({dx:x+this._left,dy:y+this._top});}
normalizedMatrix.translate(tx,ty);for(i=0;i<len;++i)
{key=this._transforms[i].shift();if(key)
{normalizedMatrix[key].apply(normalizedMatrix,this._transforms[i]);matrix[key].apply(matrix,this._transforms[i]);}
if(isPath)
{this._transforms[i].unshift(key);}}
normalizedMatrix.translate(-tx,-ty);transform="matrix("+normalizedMatrix.a+","+
normalizedMatrix.b+","+
normalizedMatrix.c+","+
normalizedMatrix.d+","+
normalizedMatrix.dx+","+
normalizedMatrix.dy+")";}
this._graphic.addToRedrawQueue(this);if(transform)
{node.setAttribute("transform",transform);}
if(!isPath)
{this._transforms=[];}},_draw:function()
{var node=this.node;node.setAttribute("width",this.get("width"));node.setAttribute("height",this.get("height"));node.setAttribute("x",this._x);node.setAttribute("y",this._y);node.style.left=this._x+"px";node.style.top=this._y+"px";this._fillChangeHandler();this._strokeChangeHandler();this._updateTransform();},_updateHandler:function()
{this._draw();},_transform:"",getBounds:function()
{var type=this._type,stroke=this.get("stroke"),w=this.get("width"),h=this.get("height"),x=type==="path"?0:this._x,y=type==="path"?0:this._y,wt=0;if(stroke&&stroke.weight)
{wt=stroke.weight;w=(x+w+wt)-(x-wt);h=(y+h+wt)-(y-wt);x-=wt;y-=wt;}
return this._normalizedMatrix.getContentRect(w,h,x,y);},toFront:function()
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
{this.node.parentNode.removeChild(this.node);}
this.node=null;}}},Y.SVGDrawing.prototype));SVGShape.ATTRS={transformOrigin:{valueFn:function()
{return[0.5,0.5];}},transform:{setter:function(val)
{this.matrix.init();this._normalizedMatrix.init();this._transforms=this.matrix.getTransformArray(val);this._transform=val;return val;},getter:function()
{return this._transform;}},id:{valueFn:function()
{return Y.guid();},setter:function(val)
{var node=this.node;if(node)
{node.setAttribute("id",val);}
return val;}},x:{getter:function()
{return this._x;},setter:function(val)
{var transform=this.get("transform");this._x=val;if(transform)
{this.set("transform",transform);}}},y:{getter:function()
{return this._y;},setter:function(val)
{var transform=this.get("transform");this._y=val;if(transform)
{this.set("transform",transform);}}},width:{value:0},height:{value:0},visible:{value:true,setter:function(val){var visibility=val?"visible":"hidden";if(this.node)
{this.node.style.visibility=visibility;}
return val;}},shapeRendering:{value:"auto",setter:function(val){if(this.node)
{Y.DOM.setAttribute(this.node,"shape-rendering",val);}
return val;}},fill:{valueFn:"_getDefaultFill",setter:function(val)
{var fill,tmpl=this.get("fill")||this._getDefaultFill();fill=(val)?Y.merge(tmpl,val):null;if(fill&&fill.color)
{if(fill.color===undefined||fill.color==="none")
{fill.color=null;}}
return fill;}},stroke:{valueFn:"_getDefaultStroke",setter:function(val)
{var tmpl=this.get("stroke")||this._getDefaultStroke(),wt;if(val&&val.hasOwnProperty("weight"))
{wt=parseInt(val.weight,10);if(!isNaN(wt))
{val.weight=wt;}}
return(val)?Y.merge(tmpl,val):null;}},pointerEvents:{valueFn:function()
{var val="visiblePainted",node=this.node;if(node)
{node.setAttribute("pointer-events",val);}
return val;},setter:function(val)
{var node=this.node;if(node)
{node.setAttribute("pointer-events",val);}
return val;}},node:{readOnly:true,getter:function()
{return this.node;}},data:{setter:function(val)
{if(this.get("node"))
{this._parsePathData(val);}
return val;}},graphic:{readOnly:true,getter:function()
{return this._graphic;}}};Y.SVGShape=SVGShape;SVGPath=function()
{SVGPath.superclass.constructor.apply(this,arguments);};SVGPath.NAME="path";Y.extend(SVGPath,Y.SVGShape,{_left:0,_right:0,_top:0,_bottom:0,_type:"path",_path:""});SVGPath.ATTRS=Y.merge(Y.SVGShape.ATTRS,{path:{readOnly:true,getter:function()
{return this._path;}},width:{getter:function()
{var val=Math.max(this._right-this._left,0);return val;}},height:{getter:function()
{return Math.max(this._bottom-this._top,0);}}});Y.SVGPath=SVGPath;SVGRect=function()
{SVGRect.superclass.constructor.apply(this,arguments);};SVGRect.NAME="rect";Y.extend(SVGRect,Y.SVGShape,{_type:"rect"});SVGRect.ATTRS=Y.SVGShape.ATTRS;Y.SVGRect=SVGRect;SVGEllipse=function()
{SVGEllipse.superclass.constructor.apply(this,arguments);};SVGEllipse.NAME="ellipse";Y.extend(SVGEllipse,SVGShape,{_type:"ellipse",_draw:function()
{var node=this.node,w=this.get("width"),h=this.get("height"),x=this.get("x"),y=this.get("y"),xRadius=w*0.5,yRadius=h*0.5,cx=x+xRadius,cy=y+yRadius;node.setAttribute("rx",xRadius);node.setAttribute("ry",yRadius);node.setAttribute("cx",cx);node.setAttribute("cy",cy);this._fillChangeHandler();this._strokeChangeHandler();this._updateTransform();}});SVGEllipse.ATTRS=Y.merge(SVGShape.ATTRS,{xRadius:{setter:function(val)
{this.set("width",val*2);},getter:function()
{var val=this.get("width");if(val)
{val*=0.5;}
return val;}},yRadius:{setter:function(val)
{this.set("height",val*2);},getter:function()
{var val=this.get("height");if(val)
{val*=0.5;}
return val;}}});Y.SVGEllipse=SVGEllipse;SVGCircle=function()
{SVGCircle.superclass.constructor.apply(this,arguments);};SVGCircle.NAME="circle";Y.extend(SVGCircle,Y.SVGShape,{_type:"circle",_draw:function()
{var node=this.node,x=this.get("x"),y=this.get("y"),radius=this.get("radius"),cx=x+radius,cy=y+radius;node.setAttribute("r",radius);node.setAttribute("cx",cx);node.setAttribute("cy",cy);this._fillChangeHandler();this._strokeChangeHandler();this._updateTransform();}});SVGCircle.ATTRS=Y.merge(Y.SVGShape.ATTRS,{width:{setter:function(val)
{this.set("radius",val/2);return val;},getter:function()
{return this.get("radius")*2;}},height:{setter:function(val)
{this.set("radius",val/2);return val;},getter:function()
{return this.get("radius")*2;}},radius:{value:0}});Y.SVGCircle=SVGCircle;SVGPieSlice=function()
{SVGPieSlice.superclass.constructor.apply(this,arguments);};SVGPieSlice.NAME="svgPieSlice";Y.extend(SVGPieSlice,Y.SVGShape,Y.mix({_type:"path",_draw:function()
{var x=this.get("cx"),y=this.get("cy"),startAngle=this.get("startAngle"),arc=this.get("arc"),radius=this.get("radius");this.clear();this.drawWedge(x,y,startAngle,arc,radius);this.end();}},Y.SVGDrawing.prototype));SVGPieSlice.ATTRS=Y.mix({cx:{value:0},cy:{value:0},startAngle:{value:0},arc:{value:0},radius:{value:0}},Y.SVGShape.ATTRS);Y.SVGPieSlice=SVGPieSlice;SVGGraphic=function(){SVGGraphic.superclass.constructor.apply(this,arguments);};SVGGraphic.NAME="svgGraphic";SVGGraphic.ATTRS={render:{},id:{valueFn:function()
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
{this._toggleVisible(val);return val;}},pointerEvents:{value:"none"}};Y.extend(SVGGraphic,Y.GraphicBase,{set:function()
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
return xy;},initializer:function(){var render=this.get("render"),visibility=this.get("visible")?"visible":"hidden";this._shapes={};this._contentBounds={left:0,top:0,right:0,bottom:0};this._gradients={};this._node=DOCUMENT.createElement('div');this._node.style.position="absolute";this._node.style.left=this.get("x")+"px";this._node.style.top=this.get("y")+"px";this._node.style.visibility=visibility;this._contentNode=this._createGraphics();this._contentNode.style.visibility=visibility;this._contentNode.setAttribute("id",this.get("id"));this._node.appendChild(this._contentNode);if(render)
{this.render(render);}},render:function(render){var parentNode=render||DOCUMENT.body,w,h;if(render instanceof Y.Node)
{parentNode=render._node;}
else if(Y.Lang.isString(render))
{parentNode=Y.Selector.query(render,DOCUMENT.body,true);}
w=this.get("width")||parseInt(Y.DOM.getComputedStyle(parentNode,"width"),10);h=this.get("height")||parseInt(Y.DOM.getComputedStyle(parentNode,"height"),10);parentNode.appendChild(this._node);this.set("width",w);this.set("height",h);return this;},destroy:function()
{this.removeAllShapes();if(this._contentNode)
{this._removeChildren(this._contentNode);if(this._contentNode.parentNode)
{this._contentNode.parentNode.removeChild(this._contentNode);}
this._contentNode=null;}
if(this._node)
{this._removeChildren(this._node);if(this._node.parentNode)
{this._node.parentNode.removeChild(this._node);}
this._node=null;}},addShape:function(cfg)
{cfg.graphic=this;if(!this.get("visible"))
{cfg.visible=false;}
var ShapeClass=this._getShapeClass(cfg.type),shape=new ShapeClass(cfg);this._appendShape(shape);return shape;},_appendShape:function(shape)
{var node=shape.node,parentNode=this._frag||this._contentNode;if(this.get("autoDraw"))
{parentNode.appendChild(node);}
else
{this._getDocFrag().appendChild(node);}},removeShape:function(shape)
{if(!(shape instanceof SVGShape))
{if(Y_LANG.isString(shape))
{shape=this._shapes[shape];}}
if(shape&&shape instanceof SVGShape)
{shape._destroy();delete this._shapes[shape.get("id")];}
if(this.get("autoDraw"))
{this._redraw();}
return shape;},removeAllShapes:function()
{var shapes=this._shapes,i;for(i in shapes)
{if(shapes.hasOwnProperty(i))
{shapes[i]._destroy();}}
this._shapes={};},_removeChildren:function(node)
{if(node.hasChildNodes())
{var child;while(node.firstChild)
{child=node.firstChild;this._removeChildren(child);node.removeChild(child);}}},clear:function(){this.removeAllShapes();},_toggleVisible:function(val)
{var i,shapes=this._shapes,visibility=val?"visible":"hidden";if(shapes)
{for(i in shapes)
{if(shapes.hasOwnProperty(i))
{shapes[i].set("visible",val);}}}
if(this._contentNode)
{this._contentNode.style.visibility=visibility;}
if(this._node)
{this._node.style.visibility=visibility;}},_getShapeClass:function(val)
{var shape=this._shapeClass[val];if(shape)
{return shape;}
return val;},_shapeClass:{circle:Y.SVGCircle,rect:Y.SVGRect,path:Y.SVGPath,ellipse:Y.SVGEllipse,pieslice:Y.SVGPieSlice},getShapeById:function(id)
{var shape=this._shapes[id];return shape;},batch:function(method)
{var autoDraw=this.get("autoDraw");this.set("autoDraw",false);method();this.set("autoDraw",autoDraw);},_getDocFrag:function()
{if(!this._frag)
{this._frag=DOCUMENT.createDocumentFragment();}
return this._frag;},_redraw:function()
{var autoSize=this.get("autoSize"),preserveAspectRatio=this.get("preserveAspectRatio"),box=this.get("resizeDown")?this._getUpdatedContentBounds():this._contentBounds,left=box.left,right=box.right,top=box.top,bottom=box.bottom,width=right-left,height=bottom-top,computedWidth,computedHeight,computedLeft,computedTop,node;if(autoSize)
{if(autoSize==="sizeContentToGraphic")
{node=this._node;computedWidth=parseFloat(Y.DOM.getComputedStyle(node,"width"));computedHeight=parseFloat(Y.DOM.getComputedStyle(node,"height"));computedLeft=computedTop=0;this._contentNode.setAttribute("preserveAspectRatio",preserveAspectRatio);}
else
{computedWidth=width;computedHeight=height;computedLeft=left;computedTop=top;this._state.width=width;this._state.height=height;if(this._node)
{this._node.style.width=width+"px";this._node.style.height=height+"px";}}}
else
{computedWidth=width;computedHeight=height;computedLeft=left;computedTop=top;}
if(this._contentNode)
{this._contentNode.style.left=computedLeft+"px";this._contentNode.style.top=computedTop+"px";this._contentNode.setAttribute("width",computedWidth);this._contentNode.setAttribute("height",computedHeight);this._contentNode.style.width=computedWidth+"px";this._contentNode.style.height=computedHeight+"px";this._contentNode.setAttribute("viewBox",""+left+" "+top+" "+width+" "+height+"");}
if(this._frag)
{if(this._contentNode)
{this._contentNode.appendChild(this._frag);}
this._frag=null;}},addToRedrawQueue:function(shape)
{var shapeBox,box;this._shapes[shape.get("id")]=shape;if(!this.get("resizeDown"))
{shapeBox=shape.getBounds();box=this._contentBounds;box.left=box.left<shapeBox.left?box.left:shapeBox.left;box.top=box.top<shapeBox.top?box.top:shapeBox.top;box.right=box.right>shapeBox.right?box.right:shapeBox.right;box.bottom=box.bottom>shapeBox.bottom?box.bottom:shapeBox.bottom;box.width=box.right-box.left;box.height=box.bottom-box.top;this._contentBounds=box;}
if(this.get("autoDraw"))
{this._redraw();}},_getUpdatedContentBounds:function()
{var bounds,i,shape,queue=this._shapes,box={};for(i in queue)
{if(queue.hasOwnProperty(i))
{shape=queue[i];bounds=shape.getBounds();box.left=Y_LANG.isNumber(box.left)?Math.min(box.left,bounds.left):bounds.left;box.top=Y_LANG.isNumber(box.top)?Math.min(box.top,bounds.top):bounds.top;box.right=Y_LANG.isNumber(box.right)?Math.max(box.right,bounds.right):bounds.right;box.bottom=Y_LANG.isNumber(box.bottom)?Math.max(box.bottom,bounds.bottom):bounds.bottom;}}
box.left=Y_LANG.isNumber(box.left)?box.left:0;box.top=Y_LANG.isNumber(box.top)?box.top:0;box.right=Y_LANG.isNumber(box.right)?box.right:0;box.bottom=Y_LANG.isNumber(box.bottom)?box.bottom:0;this._contentBounds=box;return box;},_createGraphics:function(){var contentNode=this._createGraphicNode("svg"),pointerEvents=this.get("pointerEvents");contentNode.style.position="absolute";contentNode.style.top="0px";contentNode.style.left="0px";contentNode.style.overflow="auto";contentNode.setAttribute("overflow","auto");contentNode.setAttribute("pointer-events",pointerEvents);return contentNode;},_createGraphicNode:function(type,pe)
{var node=DOCUMENT.createElementNS("http://www.w3.org/2000/svg","svg:"+type),v=pe||"none";if(type!=="defs"&&type!=="stop"&&type!=="linearGradient"&&type!=="radialGradient")
{node.setAttribute("pointer-events",v);}
return node;},getGradientNode:function(key,type)
{var gradients=this._gradients,gradient,nodeType=type+"Gradient";if(gradients.hasOwnProperty(key)&&gradients[key].tagName.indexOf(type)>-1)
{gradient=this._gradients[key];}
else
{gradient=this._createGraphicNode(nodeType);if(!this._defs)
{this._defs=this._createGraphicNode("defs");this._contentNode.appendChild(this._defs);}
this._defs.appendChild(gradient);key=key||"gradient"+Math.round(100000*Math.random());gradient.setAttribute("id",key);if(gradients.hasOwnProperty(key))
{this._defs.removeChild(gradients[key]);}
gradients[key]=gradient;}
return gradient;},_toFront:function(shape)
{var contentNode=this._contentNode;if(shape instanceof Y.SVGShape)
{shape=shape.get("node");}
if(contentNode&&shape)
{contentNode.appendChild(shape);}},_toBack:function(shape)
{var contentNode=this._contentNode,targetNode;if(shape instanceof Y.SVGShape)
{shape=shape.get("node");}
if(contentNode&&shape)
{targetNode=contentNode.firstChild;if(targetNode)
{contentNode.insertBefore(shape,targetNode);}
else
{contentNode.appendChild(shape);}}}});Y.SVGGraphic=SVGGraphic;},'3.15.0',{"requires":["graphics"]});