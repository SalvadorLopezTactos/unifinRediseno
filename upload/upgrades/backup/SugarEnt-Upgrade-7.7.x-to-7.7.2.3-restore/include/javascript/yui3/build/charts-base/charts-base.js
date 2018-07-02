/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('charts-base',function(Y,NAME){var CONFIG=Y.config,WINDOW=CONFIG.win,DOCUMENT=CONFIG.doc,Y_Lang=Y.Lang,IS_STRING=Y_Lang.isString,_getClassName=Y.ClassNameManager.getClassName,SERIES_MARKER=_getClassName("seriesmarker");Y.Gridlines=Y.Base.create("gridlines",Y.Base,[Y.Renderer],{_path:null,remove:function()
{var path=this._path;if(path)
{path.destroy();}},draw:function()
{if(this.get("axis")&&this.get("graph"))
{this._drawGridlines();}},_drawGridlines:function()
{var path,axis=this.get("axis"),axisPosition=axis.get("position"),points,i=0,l,direction=this.get("direction"),graph=this.get("graph"),w=graph.get("width"),h=graph.get("height"),line=this.get("styles").line,color=line.color,weight=line.weight,alpha=line.alpha,count=this.get("count"),length,lineFunction;if(isFinite(w)&&isFinite(h)&&w>0&&h>0)
{if(count&&Y.Lang.isNumber(count))
{points=this._getPoints(count,w,h);}
else if(axisPosition!=="none"&&axis&&axis.get("tickPoints"))
{points=axis.get("tickPoints");}
else
{points=this._getPoints(axis.get("styles").majorUnit.count,w,h);}
l=points.length;path=graph.get("gridlines");path.set("width",w);path.set("height",h);path.set("stroke",{weight:weight,color:color,opacity:alpha});if(direction==="vertical")
{lineFunction=this._verticalLine;length=h;}
else
{lineFunction=this._horizontalLine;length=w;}
for(i=0;i<l;i=i+1)
{lineFunction(path,points[i],length);}
path.end();}},_getPoints:function(count,w,h)
{var i,points=[],multiplier,divisor=count-1;for(i=0;i<count;i=i+1)
{multiplier=i/divisor;points[i]={x:w*multiplier,y:h*multiplier};}
return points;},_horizontalLine:function(path,pt,w)
{path.moveTo(0,pt.y);path.lineTo(w,pt.y);},_verticalLine:function(path,pt,h)
{path.moveTo(pt.x,0);path.lineTo(pt.x,h);},_getDefaultStyles:function()
{var defs={line:{color:"#f0efe9",weight:1,alpha:1}};return defs;}},{ATTRS:{direction:{},axis:{},graph:{},count:{}}});Y.Graph=Y.Base.create("graph",Y.Widget,[Y.Renderer],{bindUI:function()
{var bb=this.get("boundingBox");bb.setStyle("position","absolute");this.after("widthChange",this._sizeChangeHandler);this.after("heightChange",this._sizeChangeHandler);this.after("stylesChange",this._updateStyles);this.after("groupMarkersChange",this._drawSeries);},syncUI:function()
{var background,cb,bg,sc=this.get("seriesCollection"),series,i=0,len=sc?sc.length:0,hgl=this.get("horizontalGridlines"),vgl=this.get("verticalGridlines");if(this.get("showBackground"))
{background=this.get("background");cb=this.get("contentBox");bg=this.get("styles").background;bg.stroke=bg.border;bg.stroke.opacity=bg.stroke.alpha;bg.fill.opacity=bg.fill.alpha;bg.width=this.get("width");bg.height=this.get("height");bg.type=bg.shape;background.set(bg);}
for(;i<len;++i)
{series=sc[i];if(series instanceof Y.SeriesBase)
{series.render();}}
if(hgl&&hgl instanceof Y.Gridlines)
{hgl.draw();}
if(vgl&&vgl instanceof Y.Gridlines)
{vgl.draw();}},seriesTypes:null,getSeriesByIndex:function(val)
{var col=this.get("seriesCollection"),series;if(col&&col.length>val)
{series=col[val];}
return series;},getSeriesByKey:function(val)
{var obj=this._seriesDictionary,series;if(obj&&obj.hasOwnProperty(val))
{series=obj[val];}
return series;},addDispatcher:function(val)
{if(!this._dispatchers)
{this._dispatchers=[];}
this._dispatchers.push(val);},_seriesCollection:null,_seriesDictionary:null,_parseSeriesCollection:function(val)
{if(!val)
{return;}
var len=val.length,i=0,series,seriesKey;this._seriesCollection=[];this._seriesDictionary={};this.seriesTypes=[];for(;i<len;++i)
{series=val[i];if(!(series instanceof Y.CartesianSeries)&&!(series instanceof Y.PieSeries))
{this._createSeries(series);continue;}
this._addSeries(series);}
len=this._seriesCollection.length;for(i=0;i<len;++i)
{series=this.get("seriesCollection")[i];seriesKey=series.get("direction")==="horizontal"?"yKey":"xKey";this._seriesDictionary[series.get(seriesKey)]=series;}},_addSeries:function(series)
{var type=series.get("type"),seriesCollection=this.get("seriesCollection"),graphSeriesLength=seriesCollection.length,seriesTypes=this.seriesTypes,typeSeriesCollection;if(!series.get("graph"))
{series.set("graph",this);}
seriesCollection.push(series);if(!seriesTypes.hasOwnProperty(type))
{this.seriesTypes[type]=[];}
typeSeriesCollection=this.seriesTypes[type];series.set("graphOrder",graphSeriesLength);series.set("order",typeSeriesCollection.length);typeSeriesCollection.push(series);series.set("seriesTypeCollection",typeSeriesCollection);this.addDispatcher(series);series.after("drawingComplete",Y.bind(this._drawingCompleteHandler,this));this.fire("seriesAdded",series);},_createSeries:function(seriesData)
{var type=seriesData.type,seriesCollection=this.get("seriesCollection"),seriesTypes=this.seriesTypes,typeSeriesCollection,SeriesClass,series;seriesData.graph=this;if(!seriesTypes.hasOwnProperty(type))
{seriesTypes[type]=[];}
typeSeriesCollection=seriesTypes[type];seriesData.graph=this;seriesData.order=typeSeriesCollection.length;seriesData.graphOrder=seriesCollection.length;SeriesClass=this._getSeries(seriesData.type);series=new SeriesClass(seriesData);this.addDispatcher(series);series.after("drawingComplete",Y.bind(this._drawingCompleteHandler,this));typeSeriesCollection.push(series);seriesCollection.push(series);series.set("seriesTypeCollection",typeSeriesCollection);if(this.get("rendered"))
{series.render();}},_seriesMap:{line:Y.LineSeries,column:Y.ColumnSeries,bar:Y.BarSeries,area:Y.AreaSeries,candlestick:Y.CandlestickSeries,ohlc:Y.OHLCSeries,stackedarea:Y.StackedAreaSeries,stackedline:Y.StackedLineSeries,stackedcolumn:Y.StackedColumnSeries,stackedbar:Y.StackedBarSeries,markerseries:Y.MarkerSeries,spline:Y.SplineSeries,areaspline:Y.AreaSplineSeries,stackedspline:Y.StackedSplineSeries,stackedareaspline:Y.StackedAreaSplineSeries,stackedmarkerseries:Y.StackedMarkerSeries,pie:Y.PieSeries,combo:Y.ComboSeries,stackedcombo:Y.StackedComboSeries,combospline:Y.ComboSplineSeries,stackedcombospline:Y.StackedComboSplineSeries},_getSeries:function(type)
{var seriesClass;if(Y_Lang.isString(type))
{seriesClass=this._seriesMap[type];}
else
{seriesClass=type;}
return seriesClass;},_markerEventHandler:function(e)
{var type=e.type,markerNode=e.currentTarget,strArr=markerNode.getAttribute("id").split("_"),series=this.getSeriesByIndex(strArr[1]),index=strArr[2];series.updateMarkerState(type,index);},_dispatchers:null,_updateStyles:function()
{var styles=this.get("styles").background,border=styles.border;border.opacity=border.alpha;styles.stroke=border;styles.fill.opacity=styles.fill.alpha;this.get("background").set(styles);this._sizeChangeHandler();},_sizeChangeHandler:function()
{var hgl=this.get("horizontalGridlines"),vgl=this.get("verticalGridlines"),w=this.get("width"),h=this.get("height"),bg=this.get("styles").background,weight,background;if(bg&&bg.border)
{weight=bg.border.weight||0;}
if(this.get("showBackground"))
{background=this.get("background");if(w&&h)
{background.set("width",w);background.set("height",h);}}
if(this._gridlines)
{this._gridlines.clear();}
if(hgl&&hgl instanceof Y.Gridlines)
{hgl.draw();}
if(vgl&&vgl instanceof Y.Gridlines)
{vgl.draw();}
this._drawSeries();},_drawSeries:function()
{if(this._drawing)
{this._callLater=true;return;}
var sc,i,len,graphic=this.get("graphic");graphic.set("autoDraw",false);graphic.set("width",this.get("width"));graphic.set("height",this.get("height"));this._callLater=false;this._drawing=true;sc=this.get("seriesCollection");i=0;len=sc?sc.length:0;for(;i<len;++i)
{sc[i].draw();if((!sc[i].get("xcoords")||!sc[i].get("ycoords"))&&!sc[i]instanceof Y.PieSeries)
{this._callLater=true;break;}}
this._drawing=false;if(this._callLater)
{this._drawSeries();}},_drawingCompleteHandler:function(e)
{var series=e.currentTarget,graphic,index=Y.Array.indexOf(this._dispatchers,series);if(index>-1)
{this._dispatchers.splice(index,1);}
if(this._dispatchers.length<1)
{graphic=this.get("graphic");if(!graphic.get("autoDraw"))
{graphic._redraw();}
this.fire("chartRendered");}},_getDefaultStyles:function()
{var defs={background:{shape:"rect",fill:{color:"#faf9f2"},border:{color:"#dad8c9",weight:1}}};return defs;},destructor:function()
{if(this._graphic)
{this._graphic.destroy();this._graphic=null;}
if(this._background)
{this._background.get("graphic").destroy();this._background=null;}
if(this._gridlines)
{this._gridlines.get("graphic").destroy();this._gridlines=null;}}},{ATTRS:{x:{setter:function(val)
{this.get("boundingBox").setStyle("left",val+"px");return val;}},y:{setter:function(val)
{this.get("boundingBox").setStyle("top",val+"px");return val;}},chart:{getter:function(){var chart=this._state.chart||this;return chart;}},seriesCollection:{getter:function()
{return this._seriesCollection;},setter:function(val)
{this._parseSeriesCollection(val);return this._seriesCollection;}},showBackground:{value:true},seriesDictionary:{readOnly:true,getter:function()
{return this._seriesDictionary;}},horizontalGridlines:{value:null,setter:function(val)
{var cfg,key,gl=this.get("horizontalGridlines");if(gl&&gl instanceof Y.Gridlines)
{gl.remove();}
if(val instanceof Y.Gridlines)
{gl=val;val.set("graph",this);return val;}
else if(val)
{cfg={direction:"horizonal",graph:this};for(key in val)
{if(val.hasOwnProperty(key))
{cfg[key]=val[key];}}
gl=new Y.Gridlines(cfg);return gl;}}},verticalGridlines:{value:null,setter:function(val)
{var cfg,key,gl=this.get("verticalGridlines");if(gl&&gl instanceof Y.Gridlines)
{gl.remove();}
if(val instanceof Y.Gridlines)
{gl=val;val.set("graph",this);return val;}
else if(val)
{cfg={direction:"vertical",graph:this};for(key in val)
{if(val.hasOwnProperty(key))
{cfg[key]=val[key];}}
gl=new Y.Gridlines(cfg);return gl;}}},background:{getter:function()
{if(!this._background)
{this._backgroundGraphic=new Y.Graphic({render:this.get("contentBox")});this._backgroundGraphic.get("node").style.zIndex=0;this._background=this._backgroundGraphic.addShape({type:"rect"});}
return this._background;}},gridlines:{readOnly:true,getter:function()
{if(!this._gridlines)
{this._gridlinesGraphic=new Y.Graphic({render:this.get("contentBox")});this._gridlinesGraphic.get("node").style.zIndex=1;this._gridlines=this._gridlinesGraphic.addShape({type:"path"});}
return this._gridlines;}},graphic:{readOnly:true,getter:function()
{if(!this._graphic)
{this._graphic=new Y.Graphic({render:this.get("contentBox")});this._graphic.get("node").style.zIndex=2;this._graphic.set("autoDraw",false);}
return this._graphic;}},groupMarkers:{value:false}}});function ChartBase(){}
ChartBase.ATTRS={dataProvider:{lazyAdd:false,valueFn:function()
{var defDataProvider=[];if(!this._wereSeriesKeysExplicitlySet())
{this.set("seriesKeys",this._buildSeriesKeys(defDataProvider),{src:"internal"});}
return defDataProvider;},setter:function(val)
{var dataProvider=this._setDataValues(val);if(!this._wereSeriesKeysExplicitlySet())
{this.set("seriesKeys",this._buildSeriesKeys(dataProvider),{src:"internal"});}
return dataProvider;}},seriesKeys:{lazyAdd:false,setter:function(val)
{var opts=arguments[2];if(!val||(opts&&opts.src&&opts.src==="internal"))
{this._seriesKeysExplicitlySet=false;}
else
{this._seriesKeysExplicitlySet=true;}
return val;}},ariaLabel:{value:"Chart Application",setter:function(val)
{var cb=this.get("contentBox");if(cb)
{cb.setAttribute("aria-label",val);}
return val;}},ariaDescription:{value:"Use the up and down keys to navigate between series. Use the left and right keys to navigate through items in a series.",setter:function(val)
{if(this._description)
{this._description.set("text",val);}
return val;}},tooltip:{valueFn:"_getTooltip",setter:function(val)
{return this._updateTooltip(val);}},categoryKey:{value:"category"},categoryType:{value:"category"},interactionType:{value:"marker"},axesCollection:{},graph:{valueFn:"_getGraph"},groupMarkers:{value:false}};ChartBase.prototype={_wereSeriesKeysExplicitlySet:function()
{var seriesKeys=this.get("seriesKeys");return seriesKeys&&this._seriesKeysExplicitlySet;},_groupMarkersChangeHandler:function(e)
{var graph=this.get("graph"),useGroupMarkers=e.newVal;if(graph)
{graph.set("groupMarkers",useGroupMarkers);}},_itemRendered:function(e)
{this._itemRenderQueue=this._itemRenderQueue.splice(1+Y.Array.indexOf(this._itemRenderQueue,e.currentTarget),1);if(this._itemRenderQueue.length<1)
{this._redraw();}},_getGraph:function()
{var graph=new Y.Graph({chart:this,groupMarkers:this.get("groupMarkers")});graph.after("chartRendered",Y.bind(function(){this.fire("chartRendered");},this));return graph;},getSeries:function(val)
{var series=null,graph=this.get("graph");if(graph)
{if(Y_Lang.isNumber(val))
{series=graph.getSeriesByIndex(val);}
else
{series=graph.getSeriesByKey(val);}}
return series;},getAxisByKey:function(val)
{var axis,axes=this.get("axes");if(axes&&axes.hasOwnProperty(val))
{axis=axes[val];}
return axis;},getCategoryAxis:function()
{var axis,key=this.get("categoryKey"),axes=this.get("axes");if(axes.hasOwnProperty(key))
{axis=axes[key];}
return axis;},_direction:"horizontal",_dataProvider:null,_setDataValues:function(val)
{if(Y_Lang.isArray(val[0]))
{var hash,dp=[],cats=val[0],i=0,l=cats.length,n,sl=val.length;for(;i<l;++i)
{hash={category:cats[i]};for(n=1;n<sl;++n)
{hash["series"+n]=val[n][i];}
dp[i]=hash;}
return dp;}
return val;},_seriesCollection:null,_setSeriesCollection:function(val)
{this._seriesCollection=val;},_getAxisClass:function(t)
{return this._axisClass[t];},_axisClass:{stacked:Y.StackedAxis,numeric:Y.NumericAxis,category:Y.CategoryAxis,time:Y.TimeAxis},_axes:null,initializer:function()
{this._itemRenderQueue=[];this._seriesIndex=-1;this._itemIndex=-1;this.after("dataProviderChange",this._dataProviderChangeHandler);},renderUI:function()
{var tt=this.get("tooltip"),bb=this.get("boundingBox"),cb=this.get("contentBox");bb.setStyle("position","absolute");cb.setStyle("position","absolute");this._addAxes();this._addSeries();if(tt&&tt.show)
{this._addTooltip();}
this._setAriaElements(bb,cb);},_setAriaElements:function(bb,cb)
{var description=this._getAriaOffscreenNode(),id=this.get("id")+"_description",liveRegion=this._getAriaOffscreenNode();cb.set("tabIndex",0);cb.set("role","img");cb.setAttribute("aria-label",this.get("ariaLabel"));cb.setAttribute("aria-describedby",id);description.set("id",id);description.set("tabIndex",-1);description.set("text",this.get("ariaDescription"));liveRegion.set("id","live-region");liveRegion.set("aria-live","polite");liveRegion.set("aria-atomic","true");liveRegion.set("role","status");bb.setAttribute("role","application");bb.appendChild(description);bb.appendChild(liveRegion);this._description=description;this._liveRegion=liveRegion;},_getAriaOffscreenNode:function()
{var node=Y.Node.create("<div></div>"),ie=Y.UA.ie,clipRect=(ie&&ie<8)?"rect(1px 1px 1px 1px)":"rect(1px, 1px, 1px, 1px)";node.setStyle("position","absolute");node.setStyle("height","1px");node.setStyle("width","1px");node.setStyle("overflow","hidden");node.setStyle("clip",clipRect);return node;},syncUI:function()
{this._redraw();},bindUI:function()
{this.after("tooltipChange",Y.bind(this._tooltipChangeHandler,this));this.after("widthChange",this._sizeChanged);this.after("heightChange",this._sizeChanged);this.after("groupMarkersChange",this._groupMarkersChangeHandler);var tt=this.get("tooltip"),hideEvent="mouseout",showEvent="mouseover",cb=this.get("contentBox"),interactionType=this.get("interactionType"),i=0,len,markerClassName="."+SERIES_MARKER,isTouch=((WINDOW&&("ontouchstart"in WINDOW))&&!(Y.UA.chrome&&Y.UA.chrome<6));Y.on("keydown",Y.bind(function(e){var key=e.keyCode,numKey=parseFloat(key),msg;if(numKey>36&&numKey<41)
{e.halt();msg=this._getAriaMessage(numKey);this._liveRegion.set("text",msg);}},this),this.get("contentBox"));if(interactionType==="marker")
{hideEvent=tt.hideEvent;showEvent=tt.showEvent;if(isTouch)
{Y.delegate("touchend",Y.bind(this._markerEventDispatcher,this),cb,markerClassName);Y.on("touchend",Y.bind(function(e){if(cb.contains(e.target))
{e.halt(true);}
if(this._activeMarker)
{this._activeMarker=null;this.hideTooltip(e);}},this));}
else
{Y.delegate("mouseenter",Y.bind(this._markerEventDispatcher,this),cb,markerClassName);Y.delegate("mousedown",Y.bind(this._markerEventDispatcher,this),cb,markerClassName);Y.delegate("mouseup",Y.bind(this._markerEventDispatcher,this),cb,markerClassName);Y.delegate("mouseleave",Y.bind(this._markerEventDispatcher,this),cb,markerClassName);Y.delegate("click",Y.bind(this._markerEventDispatcher,this),cb,markerClassName);Y.delegate("mousemove",Y.bind(this._positionTooltip,this),cb,markerClassName);}}
else if(interactionType==="planar")
{if(isTouch)
{this._overlay.on("touchend",Y.bind(this._planarEventDispatcher,this));}
else
{this._overlay.on("mousemove",Y.bind(this._planarEventDispatcher,this));this.on("mouseout",this.hideTooltip);}}
if(tt)
{this.on("markerEvent:touchend",Y.bind(function(e){var marker=e.series.get("markers")[e.index];if(this._activeMarker&&marker===this._activeMarker)
{this._activeMarker=null;this.hideTooltip(e);}
else
{this._activeMarker=marker;tt.markerEventHandler.apply(this,[e]);}},this));if(hideEvent&&showEvent&&hideEvent===showEvent)
{this.on(interactionType+"Event:"+hideEvent,this.toggleTooltip);}
else
{if(showEvent)
{this.on(interactionType+"Event:"+showEvent,tt[interactionType+"EventHandler"]);}
if(hideEvent)
{if(Y_Lang.isArray(hideEvent))
{len=hideEvent.length;for(;i<len;++i)
{this.on(interactionType+"Event:"+hideEvent[i],this.hideTooltip);}}
this.on(interactionType+"Event:"+hideEvent,this.hideTooltip);}}}},_markerEventDispatcher:function(e)
{var type=e.type,cb=this.get("contentBox"),markerNode=e.currentTarget,strArr=markerNode.getAttribute("id").split("_"),index=strArr.pop(),seriesIndex=strArr.pop(),series=this.getSeries(parseInt(seriesIndex,10)),items=this.getSeriesItems(series,index),isTouch=e&&e.hasOwnProperty("changedTouches"),pageX=isTouch?e.changedTouches[0].pageX:e.pageX,pageY=isTouch?e.changedTouches[0].pageY:e.pageY,x=pageX-cb.getX(),y=pageY-cb.getY();if(type==="mouseenter")
{type="mouseover";}
else if(type==="mouseleave")
{type="mouseout";}
series.updateMarkerState(type,index);e.halt();this.fire("markerEvent:"+type,{originEvent:e,pageX:pageX,pageY:pageY,categoryItem:items.category,valueItem:items.value,node:markerNode,x:x,y:y,series:series,index:index,seriesIndex:seriesIndex});},_dataProviderChangeHandler:function(e)
{var dataProvider=e.newVal,axes,i,axis;this._seriesIndex=-1;this._itemIndex=-1;if(this instanceof Y.CartesianChart)
{this.set("axes",this.get("axes"));this.set("seriesCollection",this.get("seriesCollection"));}
axes=this.get("axes");if(axes)
{for(i in axes)
{if(axes.hasOwnProperty(i))
{axis=axes[i];if(axis instanceof Y.Axis)
{if(axis.get("position")!=="none")
{this._addToAxesRenderQueue(axis);}
axis.set("dataProvider",dataProvider);}}}}},toggleTooltip:function(e)
{var tt=this.get("tooltip");if(tt.visible)
{this.hideTooltip();}
else
{tt.markerEventHandler.apply(this,[e]);}},_showTooltip:function(msg,x,y)
{var tt=this.get("tooltip"),node=tt.node;if(msg)
{tt.visible=true;tt.setTextFunction(node,msg);node.setStyle("top",y+"px");node.setStyle("left",x+"px");node.setStyle("visibility","visible");}},_positionTooltip:function(e)
{var tt=this.get("tooltip"),node=tt.node,cb=this.get("contentBox"),x=(e.pageX+10)-cb.getX(),y=(e.pageY+10)-cb.getY();if(node)
{node.setStyle("left",x+"px");node.setStyle("top",y+"px");}},hideTooltip:function()
{var tt=this.get("tooltip"),node=tt.node;tt.visible=false;node.set("innerHTML","");node.setStyle("left",-10000);node.setStyle("top",-10000);node.setStyle("visibility","hidden");},_addTooltip:function()
{var tt=this.get("tooltip"),id=this.get("id")+"_tooltip",cb=this.get("contentBox"),oldNode=DOCUMENT.getElementById(id);if(oldNode)
{cb.removeChild(oldNode);}
tt.node.set("id",id);tt.node.setStyle("visibility","hidden");cb.appendChild(tt.node);},_updateTooltip:function(val)
{var tt=this.get("tooltip")||this._getTooltip(),i,styles,node,props={markerLabelFunction:"markerLabelFunction",planarLabelFunction:"planarLabelFunction",setTextFunction:"setTextFunction",showEvent:"showEvent",hideEvent:"hideEvent",markerEventHandler:"markerEventHandler",planarEventHandler:"planarEventHandler",show:"show"};if(Y_Lang.isObject(val))
{styles=val.styles;if(val.node&&tt.node)
{tt.node.destroy(true);node=Y.one(val.node);}
else
{node=tt.node;}
if(styles)
{for(i in styles)
{if(styles.hasOwnProperty(i))
{node.setStyle(i,styles[i]);}}}
for(i in props)
{if(val.hasOwnProperty(i))
{tt[i]=val[i];}}
tt.node=node;}
return tt;},_getTooltip:function()
{var node=DOCUMENT.createElement("div"),tooltipClass=_getClassName("chart-tooltip"),tt={setTextFunction:this._setText,markerLabelFunction:this._tooltipLabelFunction,planarLabelFunction:this._planarLabelFunction,show:true,hideEvent:"mouseout",showEvent:"mouseover",markerEventHandler:function(e)
{var tt=this.get("tooltip"),msg=tt.markerLabelFunction.apply(this,[e.categoryItem,e.valueItem,e.index,e.series,e.seriesIndex]);this._showTooltip(msg,e.x+10,e.y+10);},planarEventHandler:function(e)
{var tt=this.get("tooltip"),msg,categoryAxis=this.get("categoryAxis");msg=tt.planarLabelFunction.apply(this,[categoryAxis,e.valueItem,e.index,e.items,e.seriesIndex]);this._showTooltip(msg,e.x+10,e.y+10);}};node=Y.one(node);node.set("id",this.get("id")+"_tooltip");node.setStyle("fontSize","85%");node.setStyle("opacity","0.83");node.setStyle("position","absolute");node.setStyle("paddingTop","2px");node.setStyle("paddingRight","5px");node.setStyle("paddingBottom","4px");node.setStyle("paddingLeft","2px");node.setStyle("backgroundColor","#fff");node.setStyle("border","1px solid #dbdccc");node.setStyle("pointerEvents","none");node.setStyle("zIndex",3);node.setStyle("whiteSpace","noWrap");node.setStyle("visibility","hidden");node.addClass(tooltipClass);tt.node=Y.one(node);return tt;},_planarLabelFunction:function(categoryAxis,valueItems,index,seriesArray)
{var msg=DOCUMENT.createElement("div"),valueItem,i=0,len=seriesArray.length,axis,categoryValue,seriesValue,series;if(categoryAxis)
{categoryValue=categoryAxis.get("labelFunction").apply(this,[categoryAxis.getKeyValueAt(this.get("categoryKey"),index),categoryAxis.get("labelFormat")]);if(!Y_Lang.isObject(categoryValue))
{categoryValue=DOCUMENT.createTextNode(categoryValue);}
msg.appendChild(categoryValue);}
for(;i<len;++i)
{series=seriesArray[i];if(series.get("visible"))
{valueItem=valueItems[i];axis=valueItem.axis;seriesValue=axis.get("labelFunction").apply(this,[axis.getKeyValueAt(valueItem.key,index),axis.get("labelFormat")]);msg.appendChild(DOCUMENT.createElement("br"));msg.appendChild(DOCUMENT.createTextNode(valueItem.displayName));msg.appendChild(DOCUMENT.createTextNode(": "));if(!Y_Lang.isObject(seriesValue))
{seriesValue=DOCUMENT.createTextNode(seriesValue);}
msg.appendChild(seriesValue);}}
return msg;},_tooltipLabelFunction:function(categoryItem,valueItem)
{var msg=DOCUMENT.createElement("div"),categoryValue=categoryItem.axis.get("labelFunction").apply(this,[categoryItem.value,categoryItem.axis.get("labelFormat")]),seriesValue=valueItem.axis.get("labelFunction").apply(this,[valueItem.value,valueItem.axis.get("labelFormat")]);msg.appendChild(DOCUMENT.createTextNode(categoryItem.displayName));msg.appendChild(DOCUMENT.createTextNode(": "));if(!Y_Lang.isObject(categoryValue))
{categoryValue=DOCUMENT.createTextNode(categoryValue);}
msg.appendChild(categoryValue);msg.appendChild(DOCUMENT.createElement("br"));msg.appendChild(DOCUMENT.createTextNode(valueItem.displayName));msg.appendChild(DOCUMENT.createTextNode(": "));if(!Y_Lang.isObject(seriesValue))
{seriesValue=DOCUMENT.createTextNode(seriesValue);}
msg.appendChild(seriesValue);return msg;},_tooltipChangeHandler:function()
{if(this.get("tooltip"))
{var tt=this.get("tooltip"),node=tt.node,show=tt.show,cb=this.get("contentBox");if(node&&show)
{if(!cb.contains(node))
{this._addTooltip();}}}},_setText:function(textField,val)
{textField.empty();if(Y_Lang.isNumber(val))
{val=val+"";}
else if(!val)
{val="";}
if(IS_STRING(val))
{val=DOCUMENT.createTextNode(val);}
textField.appendChild(val);},_getAllKeys:function(dp)
{var i=0,len=dp.length,item,key,keys={};for(;i<len;++i)
{item=dp[i];for(key in item)
{if(item.hasOwnProperty(key))
{keys[key]=true;}}}
return keys;},_buildSeriesKeys:function(dataProvider)
{var allKeys,catKey=this.get("categoryKey"),keys=[],i;if(this._seriesKeysExplicitlySet)
{return this._seriesKeys;}
allKeys=this._getAllKeys(dataProvider);for(i in allKeys)
{if(allKeys.hasOwnProperty(i)&&i!==catKey)
{keys.push(i);}}
return keys;}};Y.ChartBase=ChartBase;Y.CartesianChart=Y.Base.create("cartesianChart",Y.Widget,[Y.ChartBase,Y.Renderer],{renderUI:function()
{var bb=this.get("boundingBox"),cb=this.get("contentBox"),tt=this.get("tooltip"),overlayClass=_getClassName("overlay");bb.setStyle("position","absolute");cb.setStyle("position","absolute");this._addAxes();this._addGridlines();this._addSeries();if(tt&&tt.show)
{this._addTooltip();}
if(this.get("interactionType")==="planar")
{this._overlay=Y.Node.create("<div></div>");this._overlay.set("id",this.get("id")+"_overlay");this._overlay.setStyle("position","absolute");this._overlay.setStyle("background","#fff");this._overlay.setStyle("opacity",0);this._overlay.addClass(overlayClass);this._overlay.setStyle("zIndex",4);cb.append(this._overlay);}
this._setAriaElements(bb,cb);this._redraw();},_planarEventDispatcher:function(e)
{var graph=this.get("graph"),bb=this.get("boundingBox"),cb=graph.get("contentBox"),isTouch=e&&e.hasOwnProperty("changedTouches"),pageX=isTouch?e.changedTouches[0].pageX:e.pageX,pageY=isTouch?e.changedTouches[0].pageY:e.pageY,posX=pageX-bb.getX(),posY=pageY-bb.getY(),offset={x:pageX-cb.getX(),y:pageY-cb.getY()},sc=graph.get("seriesCollection"),series,i=0,index,oldIndex=this._selectedIndex,item,items=[],categoryItems=[],valueItems=[],direction=this.get("direction"),hasMarkers,catAxis,valAxis,coord,markerPlane,len,coords;e.halt(true);if(direction==="horizontal")
{catAxis="x";valAxis="y";}
else
{valAxis="x";catAxis="y";}
coord=offset[catAxis];if(sc)
{len=sc.length;while(i<len&&!markerPlane)
{if(sc[i])
{markerPlane=sc[i].get(catAxis+"MarkerPlane");}
i++;}}
if(markerPlane)
{len=markerPlane.length;for(i=0;i<len;++i)
{if(coord<=markerPlane[i].end&&coord>=markerPlane[i].start)
{index=i;break;}}
len=sc.length;for(i=0;i<len;++i)
{series=sc[i];coords=series.get(valAxis+"coords");hasMarkers=series.get("markers");if(hasMarkers&&!isNaN(oldIndex)&&oldIndex>-1)
{series.updateMarkerState("mouseout",oldIndex);}
if(coords&&coords[index]>-1)
{if(hasMarkers&&!isNaN(index)&&index>-1)
{series.updateMarkerState("mouseover",index);}
item=this.getSeriesItems(series,index);categoryItems.push(item.category);valueItems.push(item.value);items.push(series);}}
this._selectedIndex=index;if(index>-1)
{this.fire("planarEvent:mouseover",{categoryItem:categoryItems,valueItem:valueItems,x:posX,y:posY,pageX:pageX,pageY:pageY,items:items,index:index,originEvent:e});}
else
{this.fire("planarEvent:mouseout");}}},_type:"combo",_itemRenderQueue:null,_addToAxesRenderQueue:function(axis)
{if(!this._itemRenderQueue)
{this._itemRenderQueue=[];}
if(Y.Array.indexOf(this._itemRenderQueue,axis)<0)
{this._itemRenderQueue.push(axis);}},_addToAxesCollection:function(position,axis)
{var axesCollection=this.get(position+"AxesCollection");if(!axesCollection)
{axesCollection=[];this.set(position+"AxesCollection",axesCollection);}
axesCollection.push(axis);},_getDefaultSeriesCollection:function()
{var seriesCollection,dataProvider=this.get("dataProvider");if(dataProvider)
{seriesCollection=this._parseSeriesCollection();}
return seriesCollection;},_parseSeriesCollection:function(val)
{var dir=this.get("direction"),seriesStyles=this.get("styles").series,stylesAreArray=seriesStyles&&Y_Lang.isArray(seriesStyles),stylesIndex,setStyles,globalStyles,sc=[],catAxis,valAxis,tempKeys=[],series,seriesKeys=this.get("seriesKeys").concat(),i,index,l,type=this.get("type"),key,catKey,seriesKey,graph,orphans=[],categoryKey=this.get("categoryKey"),showMarkers=this.get("showMarkers"),showAreaFill=this.get("showAreaFill"),showLines=this.get("showLines");val=val?val.concat():[];if(dir==="vertical")
{catAxis="yAxis";catKey="yKey";valAxis="xAxis";seriesKey="xKey";}
else
{catAxis="xAxis";catKey="xKey";valAxis="yAxis";seriesKey="yKey";}
l=val.length;while(val&&val.length>0)
{series=val.shift();key=this._getBaseAttribute(series,seriesKey);if(key)
{index=Y.Array.indexOf(seriesKeys,key);if(index>-1)
{seriesKeys.splice(index,1);tempKeys.push(key);sc.push(series);}
else
{orphans.push(series);}}
else
{orphans.push(series);}}
while(orphans.length>0)
{series=orphans.shift();if(seriesKeys.length>0)
{key=seriesKeys.shift();this._setBaseAttribute(series,seriesKey,key);tempKeys.push(key);sc.push(series);}
else if(series instanceof Y.CartesianSeries)
{series.destroy(true);}}
if(seriesKeys.length>0)
{tempKeys=tempKeys.concat(seriesKeys);}
l=tempKeys.length;for(i=0;i<l;++i)
{series=sc[i]||{type:type};if(series instanceof Y.CartesianSeries)
{this._parseSeriesAxes(series);}
else
{series[catKey]=series[catKey]||categoryKey;series[seriesKey]=series[seriesKey]||seriesKeys.shift();series[catAxis]=this._getCategoryAxis();series[valAxis]=this._getSeriesAxis(series[seriesKey]);series.type=series.type||type;series.direction=series.direction||dir;if(series.type==="combo"||series.type==="stackedcombo"||series.type==="combospline"||series.type==="stackedcombospline")
{if(showAreaFill!==null)
{series.showAreaFill=(series.showAreaFill!==null&&series.showAreaFill!==undefined)?series.showAreaFill:showAreaFill;}
if(showMarkers!==null)
{series.showMarkers=(series.showMarkers!==null&&series.showMarkers!==undefined)?series.showMarkers:showMarkers;}
if(showLines!==null)
{series.showLines=(series.showLines!==null&&series.showLines!==undefined)?series.showLines:showLines;}}
if(seriesStyles)
{stylesIndex=stylesAreArray?i:series[seriesKey];globalStyles=seriesStyles[stylesIndex];if(globalStyles)
{setStyles=series.styles;if(setStyles)
{series.styles=this._mergeStyles(setStyles,globalStyles);}
else
{series.styles=globalStyles;}}}
sc[i]=series;}}
if(sc)
{graph=this.get("graph");graph.set("seriesCollection",sc);sc=graph.get("seriesCollection");}
return sc;},_parseSeriesAxes:function(series)
{var axes=this.get("axes"),xAxis=series.get("xAxis"),yAxis=series.get("yAxis"),YAxis=Y.Axis,axis;if(xAxis&&!(xAxis instanceof YAxis)&&Y_Lang.isString(xAxis)&&axes.hasOwnProperty(xAxis))
{axis=axes[xAxis];if(axis instanceof YAxis)
{series.set("xAxis",axis);}}
if(yAxis&&!(yAxis instanceof YAxis)&&Y_Lang.isString(yAxis)&&axes.hasOwnProperty(yAxis))
{axis=axes[yAxis];if(axis instanceof YAxis)
{series.set("yAxis",axis);}}},_getCategoryAxis:function()
{var axis,axes=this.get("axes"),categoryAxisName=this.get("categoryAxisName")||this.get("categoryKey");axis=axes[categoryAxisName];return axis;},_getSeriesAxis:function(key,axisName)
{var axes=this.get("axes"),i,keys,axis;if(axes)
{if(axisName&&axes.hasOwnProperty(axisName))
{axis=axes[axisName];}
else
{for(i in axes)
{if(axes.hasOwnProperty(i))
{keys=axes[i].get("keys");if(keys&&keys.hasOwnProperty(key))
{axis=axes[i];break;}}}}}
return axis;},_getBaseAttribute:function(item,key)
{if(item instanceof Y.Base)
{return item.get(key);}
if(item.hasOwnProperty(key))
{return item[key];}
return null;},_setBaseAttribute:function(item,key,value)
{if(item instanceof Y.Base)
{item.set(key,value);}
else
{item[key]=value;}},_setAxes:function(val)
{var hash=this._parseAxes(val),axes={},axesAttrs={edgeOffset:"edgeOffset",calculateEdgeOffset:"calculateEdgeOffset",position:"position",overlapGraph:"overlapGraph",labelValues:"labelValues",hideFirstMajorUnit:"hideFirstMajorUnit",hideLastMajorUnit:"hideLastMajorUnit",labelFunction:"labelFunction",labelFunctionScope:"labelFunctionScope",labelFormat:"labelFormat",appendLabelFunction:"appendLabelFunction",appendTitleFunction:"appendTitleFunction",maximum:"maximum",minimum:"minimum",roundingMethod:"roundingMethod",alwaysShowZero:"alwaysShowZero",scaleType:"scaleType",title:"title",width:"width",height:"height"},dp=this.get("dataProvider"),ai,i,pos,axis,axisPosition,dh,AxisClass,config,axesCollection;for(i in hash)
{if(hash.hasOwnProperty(i))
{dh=hash[i];if(dh instanceof Y.Axis)
{axis=dh;}
else
{axis=null;config={};config.dataProvider=dh.dataProvider||dp;config.keys=dh.keys;if(dh.hasOwnProperty("roundingUnit"))
{config.roundingUnit=dh.roundingUnit;}
pos=dh.position;if(dh.styles)
{config.styles=dh.styles;}
config.position=dh.position;for(ai in axesAttrs)
{if(axesAttrs.hasOwnProperty(ai)&&dh.hasOwnProperty(ai))
{config[ai]=dh[ai];}}
if(val)
{axis=this.getAxisByKey(i);}
if(axis&&axis instanceof Y.Axis)
{axisPosition=axis.get("position");if(pos!==axisPosition)
{if(axisPosition!=="none")
{axesCollection=this.get(axisPosition+"AxesCollection");axesCollection.splice(Y.Array.indexOf(axesCollection,axis),1);}
if(pos!=="none")
{this._addToAxesCollection(pos,axis);}}
axis.setAttrs(config);}
else
{AxisClass=this._getAxisClass(dh.type);axis=new AxisClass(config);axis.after("axisRendered",Y.bind(this._itemRendered,this));}}
if(axis)
{axesCollection=this.get(pos+"AxesCollection");if(axesCollection&&Y.Array.indexOf(axesCollection,axis)>0)
{axis.set("overlapGraph",false);}
axes[i]=axis;}}}
return axes;},_addAxes:function()
{var axes=this.get("axes"),i,axis,pos,w=this.get("width"),h=this.get("height"),node=Y.Node.one(this._parentNode);if(!this._axesCollection)
{this._axesCollection=[];}
for(i in axes)
{if(axes.hasOwnProperty(i))
{axis=axes[i];if(axis instanceof Y.Axis)
{if(!w)
{this.set("width",node.get("offsetWidth"));w=this.get("width");}
if(!h)
{this.set("height",node.get("offsetHeight"));h=this.get("height");}
this._addToAxesRenderQueue(axis);pos=axis.get("position");if(!this.get(pos+"AxesCollection"))
{this.set(pos+"AxesCollection",[axis]);}
else
{this.get(pos+"AxesCollection").push(axis);}
this._axesCollection.push(axis);if(axis.get("keys").hasOwnProperty(this.get("categoryKey")))
{this.set("categoryAxis",axis);}
axis.render(this.get("contentBox"));}}}},_addSeries:function()
{var graph=this.get("graph");graph.render(this.get("contentBox"));},_addGridlines:function()
{var graph=this.get("graph"),hgl=this.get("horizontalGridlines"),vgl=this.get("verticalGridlines"),direction=this.get("direction"),leftAxesCollection=this.get("leftAxesCollection"),rightAxesCollection=this.get("rightAxesCollection"),bottomAxesCollection=this.get("bottomAxesCollection"),topAxesCollection=this.get("topAxesCollection"),seriesAxesCollection,catAxis=this.get("categoryAxis"),hAxis,vAxis;if(this._axesCollection)
{seriesAxesCollection=this._axesCollection.concat();seriesAxesCollection.splice(Y.Array.indexOf(seriesAxesCollection,catAxis),1);}
if(hgl)
{if(leftAxesCollection&&leftAxesCollection[0])
{hAxis=leftAxesCollection[0];}
else if(rightAxesCollection&&rightAxesCollection[0])
{hAxis=rightAxesCollection[0];}
else
{hAxis=direction==="horizontal"?catAxis:seriesAxesCollection[0];}
if(!this._getBaseAttribute(hgl,"axis")&&hAxis)
{this._setBaseAttribute(hgl,"axis",hAxis);}
if(this._getBaseAttribute(hgl,"axis"))
{graph.set("horizontalGridlines",hgl);}}
if(vgl)
{if(bottomAxesCollection&&bottomAxesCollection[0])
{vAxis=bottomAxesCollection[0];}
else if(topAxesCollection&&topAxesCollection[0])
{vAxis=topAxesCollection[0];}
else
{vAxis=direction==="vertical"?catAxis:seriesAxesCollection[0];}
if(!this._getBaseAttribute(vgl,"axis")&&vAxis)
{this._setBaseAttribute(vgl,"axis",vAxis);}
if(this._getBaseAttribute(vgl,"axis"))
{graph.set("verticalGridlines",vgl);}}},_getDefaultAxes:function()
{var axes;if(this.get("dataProvider"))
{axes=this._parseAxes();}
return axes;},_parseAxes:function(axes)
{var catKey=this.get("categoryKey"),axis,attr,keys,newAxes={},claimedKeys=[],newKeys=[],categoryAxisName=this.get("categoryAxisName")||this.get("categoryKey"),valueAxisName=this.get("valueAxisName"),seriesKeys=this.get("seriesKeys").concat(),i,l,ii,ll,cIndex,direction=this.get("direction"),seriesPosition,categoryPosition,valueAxes=[],seriesAxis=this.get("stacked")?"stacked":"numeric";if(direction==="vertical")
{seriesPosition="bottom";categoryPosition="left";}
else
{seriesPosition="left";categoryPosition="bottom";}
if(axes)
{for(i in axes)
{if(axes.hasOwnProperty(i))
{axis=axes[i];keys=this._getBaseAttribute(axis,"keys");attr=this._getBaseAttribute(axis,"type");if(attr==="time"||attr==="category")
{categoryAxisName=i;this.set("categoryAxisName",i);if(Y_Lang.isArray(keys)&&keys.length>0)
{catKey=keys[0];this.set("categoryKey",catKey);}
newAxes[i]=axis;}
else if(i===categoryAxisName)
{newAxes[i]=axis;}
else
{newAxes[i]=axis;if(i!==valueAxisName&&keys&&Y_Lang.isArray(keys))
{ll=keys.length;for(ii=0;ii<ll;++ii)
{claimedKeys.push(keys[ii]);}
valueAxes.push(newAxes[i]);}
if(!(this._getBaseAttribute(newAxes[i],"type")))
{this._setBaseAttribute(newAxes[i],"type",seriesAxis);}
if(!(this._getBaseAttribute(newAxes[i],"position")))
{this._setBaseAttribute(newAxes[i],"position",this._getDefaultAxisPosition(newAxes[i],valueAxes,seriesPosition));}}}}}
cIndex=Y.Array.indexOf(seriesKeys,catKey);if(cIndex>-1)
{seriesKeys.splice(cIndex,1);}
l=seriesKeys.length;for(i=0;i<l;++i)
{cIndex=Y.Array.indexOf(claimedKeys,seriesKeys[i]);if(cIndex>-1)
{newKeys=newKeys.concat(claimedKeys.splice(cIndex,1));}}
claimedKeys=newKeys.concat(claimedKeys);l=claimedKeys.length;for(i=0;i<l;i=i+1)
{cIndex=Y.Array.indexOf(seriesKeys,claimedKeys[i]);if(cIndex>-1)
{seriesKeys.splice(cIndex,1);}}
if(!newAxes.hasOwnProperty(categoryAxisName))
{newAxes[categoryAxisName]={};}
if(!(this._getBaseAttribute(newAxes[categoryAxisName],"keys")))
{this._setBaseAttribute(newAxes[categoryAxisName],"keys",[catKey]);}
if(!(this._getBaseAttribute(newAxes[categoryAxisName],"position")))
{this._setBaseAttribute(newAxes[categoryAxisName],"position",categoryPosition);}
if(!(this._getBaseAttribute(newAxes[categoryAxisName],"type")))
{this._setBaseAttribute(newAxes[categoryAxisName],"type",this.get("categoryType"));}
if(!newAxes.hasOwnProperty(valueAxisName)&&seriesKeys&&seriesKeys.length>0)
{newAxes[valueAxisName]={keys:seriesKeys};valueAxes.push(newAxes[valueAxisName]);}
if(claimedKeys.length>0)
{if(seriesKeys.length>0)
{seriesKeys=claimedKeys.concat(seriesKeys);}
else
{seriesKeys=claimedKeys;}}
if(newAxes.hasOwnProperty(valueAxisName))
{if(!(this._getBaseAttribute(newAxes[valueAxisName],"position")))
{this._setBaseAttribute(newAxes[valueAxisName],"position",this._getDefaultAxisPosition(newAxes[valueAxisName],valueAxes,seriesPosition));}
this._setBaseAttribute(newAxes[valueAxisName],"type",seriesAxis);this._setBaseAttribute(newAxes[valueAxisName],"keys",seriesKeys);}
if(!this._wereSeriesKeysExplicitlySet())
{this.set("seriesKeys",seriesKeys,{src:"internal"});}
return newAxes;},_getDefaultAxisPosition:function(axis,valueAxes,position)
{var direction=this.get("direction"),i=Y.Array.indexOf(valueAxes,axis);if(valueAxes[i-1]&&valueAxes[i-1].position)
{if(direction==="horizontal")
{if(valueAxes[i-1].position==="left")
{position="right";}
else if(valueAxes[i-1].position==="right")
{position="left";}}
else
{if(valueAxes[i-1].position==="bottom")
{position="top";}
else
{position="bottom";}}}
return position;},getSeriesItems:function(series,index)
{var xAxis=series.get("xAxis"),yAxis=series.get("yAxis"),xKey=series.get("xKey"),yKey=series.get("yKey"),categoryItem,valueItem;if(this.get("direction")==="vertical")
{categoryItem={axis:yAxis,key:yKey,value:yAxis.getKeyValueAt(yKey,index)};valueItem={axis:xAxis,key:xKey,value:xAxis.getKeyValueAt(xKey,index)};}
else
{valueItem={axis:yAxis,key:yKey,value:yAxis.getKeyValueAt(yKey,index)};categoryItem={axis:xAxis,key:xKey,value:xAxis.getKeyValueAt(xKey,index)};}
categoryItem.displayName=series.get("categoryDisplayName");valueItem.displayName=series.get("valueDisplayName");categoryItem.value=categoryItem.axis.getKeyValueAt(categoryItem.key,index);valueItem.value=valueItem.axis.getKeyValueAt(valueItem.key,index);return{category:categoryItem,value:valueItem};},_sizeChanged:function()
{if(this._axesCollection)
{var ac=this._axesCollection,i=0,l=ac.length;for(;i<l;++i)
{this._addToAxesRenderQueue(ac[i]);}
this._redraw();}},_getTopOverflow:function(set1,set2,height)
{var i=0,len,overflow=0,axis;if(set1)
{len=set1.length;for(;i<len;++i)
{axis=set1[i];overflow=Math.max(overflow,Math.abs(axis.getMaxLabelBounds().top)-axis.getEdgeOffset(axis.get("styles").majorTicks.count,height));}}
if(set2)
{i=0;len=set2.length;for(;i<len;++i)
{axis=set2[i];overflow=Math.max(overflow,Math.abs(axis.getMaxLabelBounds().top)-axis.getEdgeOffset(axis.get("styles").majorTicks.count,height));}}
return overflow;},_getRightOverflow:function(set1,set2,width)
{var i=0,len,overflow=0,axis;if(set1)
{len=set1.length;for(;i<len;++i)
{axis=set1[i];overflow=Math.max(overflow,axis.getMaxLabelBounds().right-axis.getEdgeOffset(axis.get("styles").majorTicks.count,width));}}
if(set2)
{i=0;len=set2.length;for(;i<len;++i)
{axis=set2[i];overflow=Math.max(overflow,axis.getMaxLabelBounds().right-axis.getEdgeOffset(axis.get("styles").majorTicks.count,width));}}
return overflow;},_getLeftOverflow:function(set1,set2,width)
{var i=0,len,overflow=0,axis;if(set1)
{len=set1.length;for(;i<len;++i)
{axis=set1[i];overflow=Math.max(overflow,Math.abs(axis.getMinLabelBounds().left)-axis.getEdgeOffset(axis.get("styles").majorTicks.count,width));}}
if(set2)
{i=0;len=set2.length;for(;i<len;++i)
{axis=set2[i];overflow=Math.max(overflow,Math.abs(axis.getMinLabelBounds().left)-axis.getEdgeOffset(axis.get("styles").majorTicks.count,width));}}
return overflow;},_getBottomOverflow:function(set1,set2,height)
{var i=0,len,overflow=0,axis;if(set1)
{len=set1.length;for(;i<len;++i)
{axis=set1[i];overflow=Math.max(overflow,axis.getMinLabelBounds().bottom-axis.getEdgeOffset(axis.get("styles").majorTicks.count,height));}}
if(set2)
{i=0;len=set2.length;for(;i<len;++i)
{axis=set2[i];overflow=Math.max(overflow,axis.getMinLabelBounds().bottom-axis.getEdgeOffset(axis.get("styles").majorTicks.count,height));}}
return overflow;},_redraw:function()
{if(this._drawing)
{this._callLater=true;return;}
this._drawing=true;this._callLater=false;var w=this.get("width"),h=this.get("height"),leftPaneWidth=0,rightPaneWidth=0,topPaneHeight=0,bottomPaneHeight=0,leftAxesCollection=this.get("leftAxesCollection"),rightAxesCollection=this.get("rightAxesCollection"),topAxesCollection=this.get("topAxesCollection"),bottomAxesCollection=this.get("bottomAxesCollection"),i=0,l,axis,graphOverflow="visible",graph=this.get("graph"),topOverflow,bottomOverflow,leftOverflow,rightOverflow,graphWidth,graphHeight,graphX,graphY,allowContentOverflow=this.get("allowContentOverflow"),diff,rightAxesXCoords,leftAxesXCoords,topAxesYCoords,bottomAxesYCoords,graphRect={};if(leftAxesCollection)
{leftAxesXCoords=[];l=leftAxesCollection.length;for(i=l-1;i>-1;--i)
{leftAxesXCoords.unshift(leftPaneWidth);leftPaneWidth+=leftAxesCollection[i].get("width");}}
if(rightAxesCollection)
{rightAxesXCoords=[];l=rightAxesCollection.length;i=0;for(i=l-1;i>-1;--i)
{rightPaneWidth+=rightAxesCollection[i].get("width");rightAxesXCoords.unshift(w-rightPaneWidth);}}
if(topAxesCollection)
{topAxesYCoords=[];l=topAxesCollection.length;for(i=l-1;i>-1;--i)
{topAxesYCoords.unshift(topPaneHeight);topPaneHeight+=topAxesCollection[i].get("height");}}
if(bottomAxesCollection)
{bottomAxesYCoords=[];l=bottomAxesCollection.length;for(i=l-1;i>-1;--i)
{bottomPaneHeight+=bottomAxesCollection[i].get("height");bottomAxesYCoords.unshift(h-bottomPaneHeight);}}
graphWidth=w-(leftPaneWidth+rightPaneWidth);graphHeight=h-(bottomPaneHeight+topPaneHeight);graphRect.left=leftPaneWidth;graphRect.top=topPaneHeight;graphRect.bottom=h-bottomPaneHeight;graphRect.right=w-rightPaneWidth;if(!allowContentOverflow)
{topOverflow=this._getTopOverflow(leftAxesCollection,rightAxesCollection);bottomOverflow=this._getBottomOverflow(leftAxesCollection,rightAxesCollection);leftOverflow=this._getLeftOverflow(bottomAxesCollection,topAxesCollection);rightOverflow=this._getRightOverflow(bottomAxesCollection,topAxesCollection);diff=topOverflow-topPaneHeight;if(diff>0)
{graphRect.top=topOverflow;if(topAxesYCoords)
{i=0;l=topAxesYCoords.length;for(;i<l;++i)
{topAxesYCoords[i]+=diff;}}}
diff=bottomOverflow-bottomPaneHeight;if(diff>0)
{graphRect.bottom=h-bottomOverflow;if(bottomAxesYCoords)
{i=0;l=bottomAxesYCoords.length;for(;i<l;++i)
{bottomAxesYCoords[i]-=diff;}}}
diff=leftOverflow-leftPaneWidth;if(diff>0)
{graphRect.left=leftOverflow;if(leftAxesXCoords)
{i=0;l=leftAxesXCoords.length;for(;i<l;++i)
{leftAxesXCoords[i]+=diff;}}}
diff=rightOverflow-rightPaneWidth;if(diff>0)
{graphRect.right=w-rightOverflow;if(rightAxesXCoords)
{i=0;l=rightAxesXCoords.length;for(;i<l;++i)
{rightAxesXCoords[i]-=diff;}}}}
graphWidth=graphRect.right-graphRect.left;graphHeight=graphRect.bottom-graphRect.top;graphX=graphRect.left;graphY=graphRect.top;if(topAxesCollection)
{l=topAxesCollection.length;i=0;for(;i<l;i++)
{axis=topAxesCollection[i];if(axis.get("width")!==graphWidth)
{axis.set("width",graphWidth);}
axis.get("boundingBox").setStyle("left",graphX+"px");axis.get("boundingBox").setStyle("top",topAxesYCoords[i]+"px");}
if(axis._hasDataOverflow())
{graphOverflow="hidden";}}
if(bottomAxesCollection)
{l=bottomAxesCollection.length;i=0;for(;i<l;i++)
{axis=bottomAxesCollection[i];if(axis.get("width")!==graphWidth)
{axis.set("width",graphWidth);}
axis.get("boundingBox").setStyle("left",graphX+"px");axis.get("boundingBox").setStyle("top",bottomAxesYCoords[i]+"px");}
if(axis._hasDataOverflow())
{graphOverflow="hidden";}}
if(leftAxesCollection)
{l=leftAxesCollection.length;i=0;for(;i<l;++i)
{axis=leftAxesCollection[i];axis.get("boundingBox").setStyle("top",graphY+"px");axis.get("boundingBox").setStyle("left",leftAxesXCoords[i]+"px");if(axis.get("height")!==graphHeight)
{axis.set("height",graphHeight);}}
if(axis._hasDataOverflow())
{graphOverflow="hidden";}}
if(rightAxesCollection)
{l=rightAxesCollection.length;i=0;for(;i<l;++i)
{axis=rightAxesCollection[i];axis.get("boundingBox").setStyle("top",graphY+"px");axis.get("boundingBox").setStyle("left",rightAxesXCoords[i]+"px");if(axis.get("height")!==graphHeight)
{axis.set("height",graphHeight);}}
if(axis._hasDataOverflow())
{graphOverflow="hidden";}}
this._drawing=false;if(this._callLater)
{this._redraw();return;}
if(graph)
{graph.get("boundingBox").setStyle("left",graphX+"px");graph.get("boundingBox").setStyle("top",graphY+"px");graph.set("width",graphWidth);graph.set("height",graphHeight);graph.get("boundingBox").setStyle("overflow",graphOverflow);}
if(this._overlay)
{this._overlay.setStyle("left",graphX+"px");this._overlay.setStyle("top",graphY+"px");this._overlay.setStyle("width",graphWidth+"px");this._overlay.setStyle("height",graphHeight+"px");}},destructor:function()
{var graph=this.get("graph"),i=0,len,seriesCollection=this.get("seriesCollection"),axesCollection=this._axesCollection,tooltip=this.get("tooltip").node;if(this._description)
{this._description.empty();this._description.remove(true);}
if(this._liveRegion)
{this._liveRegion.empty();this._liveRegion.remove(true);}
len=seriesCollection?seriesCollection.length:0;for(;i<len;++i)
{if(seriesCollection[i]instanceof Y.CartesianSeries)
{seriesCollection[i].destroy(true);}}
len=axesCollection?axesCollection.length:0;for(i=0;i<len;++i)
{if(axesCollection[i]instanceof Y.Axis)
{axesCollection[i].destroy(true);}}
if(graph)
{graph.destroy(true);}
if(tooltip)
{tooltip.empty();tooltip.remove(true);}
if(this._overlay)
{this._overlay.empty();this._overlay.remove(true);}},_getAriaMessage:function(key)
{var msg="",series,items,categoryItem,valueItem,seriesIndex=this._seriesIndex,itemIndex=this._itemIndex,seriesCollection=this.get("seriesCollection"),len=seriesCollection.length,dataLength;if(key%2===0)
{if(len>1)
{if(key===38)
{seriesIndex=seriesIndex<1?len-1:seriesIndex-1;}
else if(key===40)
{seriesIndex=seriesIndex>=len-1?0:seriesIndex+1;}
this._itemIndex=-1;}
else
{seriesIndex=0;}
this._seriesIndex=seriesIndex;series=this.getSeries(parseInt(seriesIndex,10));msg=series.get("valueDisplayName")+" series.";}
else
{if(seriesIndex>-1)
{msg="";series=this.getSeries(parseInt(seriesIndex,10));}
else
{seriesIndex=0;this._seriesIndex=seriesIndex;series=this.getSeries(parseInt(seriesIndex,10));msg=series.get("valueDisplayName")+" series.";}
dataLength=series._dataLength?series._dataLength:0;if(key===37)
{itemIndex=itemIndex>0?itemIndex-1:dataLength-1;}
else if(key===39)
{itemIndex=itemIndex>=dataLength-1?0:itemIndex+1;}
this._itemIndex=itemIndex;items=this.getSeriesItems(series,itemIndex);categoryItem=items.category;valueItem=items.value;if(categoryItem&&valueItem&&categoryItem.value&&valueItem.value)
{msg+=categoryItem.displayName+": "+
categoryItem.axis.formatLabel.apply(this,[categoryItem.value,categoryItem.axis.get("labelFormat")])+", ";msg+=valueItem.displayName+": "+
valueItem.axis.formatLabel.apply(this,[valueItem.value,valueItem.axis.get("labelFormat")])+", ";}
else
{msg+="No data available.";}
msg+=(itemIndex+1)+" of "+dataLength+". ";}
return msg;}},{ATTRS:{allowContentOverflow:{value:false},axesStyles:{lazyAdd:false,getter:function()
{var axes=this.get("axes"),i,styles=this._axesStyles;if(axes)
{for(i in axes)
{if(axes.hasOwnProperty(i)&&axes[i]instanceof Y.Axis)
{if(!styles)
{styles={};}
styles[i]=axes[i].get("styles");}}}
return styles;},setter:function(val)
{var axes=this.get("axes"),i;for(i in val)
{if(val.hasOwnProperty(i)&&axes.hasOwnProperty(i))
{this._setBaseAttribute(axes[i],"styles",val[i]);}}
return val;}},seriesStyles:{lazyAdd:false,getter:function()
{var styles=this._seriesStyles,graph=this.get("graph"),dict,i;if(graph)
{dict=graph.get("seriesDictionary");if(dict)
{styles={};for(i in dict)
{if(dict.hasOwnProperty(i))
{styles[i]=dict[i].get("styles");}}}}
return styles;},setter:function(val)
{var i,l,s;if(Y_Lang.isArray(val))
{s=this.get("seriesCollection");i=0;l=val.length;for(;i<l;++i)
{this._setBaseAttribute(s[i],"styles",val[i]);}}
else
{for(i in val)
{if(val.hasOwnProperty(i))
{s=this.getSeries(i);this._setBaseAttribute(s,"styles",val[i]);}}}
return val;}},graphStyles:{lazyAdd:false,getter:function()
{var graph=this.get("graph");if(graph)
{return(graph.get("styles"));}
return this._graphStyles;},setter:function(val)
{var graph=this.get("graph");this._setBaseAttribute(graph,"styles",val);return val;}},styles:{lazyAdd:false,getter:function()
{var styles={axes:this.get("axesStyles"),series:this.get("seriesStyles"),graph:this.get("graphStyles")};return styles;},setter:function(val)
{if(val.hasOwnProperty("axes"))
{if(this.get("axesStyles"))
{this.set("axesStyles",val.axes);}
else
{this._axesStyles=val.axes;}}
if(val.hasOwnProperty("series"))
{if(this.get("seriesStyles"))
{this.set("seriesStyles",val.series);}
else
{this._seriesStyles=val.series;}}
if(val.hasOwnProperty("graph"))
{this.set("graphStyles",val.graph);}}},axes:{lazyAdd:false,valueFn:"_getDefaultAxes",setter:function(val)
{if(this.get("dataProvider"))
{val=this._setAxes(val);}
return val;}},seriesCollection:{lazyAdd:false,valueFn:"_getDefaultSeriesCollection",setter:function(val)
{if(this.get("dataProvider"))
{return this._parseSeriesCollection(val);}
return val;}},leftAxesCollection:{},bottomAxesCollection:{},rightAxesCollection:{},topAxesCollection:{},stacked:{value:false},direction:{getter:function()
{var type=this.get("type");if(type==="bar")
{return"vertical";}
else if(type==="column")
{return"horizontal";}
return this._direction;},setter:function(val)
{this._direction=val;return this._direction;}},showAreaFill:{},showMarkers:{},showLines:{},categoryAxisName:{},valueAxisName:{value:"values"},horizontalGridlines:{getter:function()
{var graph=this.get("graph");if(graph)
{return graph.get("horizontalGridlines");}
return this._horizontalGridlines;},setter:function(val)
{var graph=this.get("graph");if(val&&!Y_Lang.isObject(val))
{val={};}
if(graph)
{graph.set("horizontalGridlines",val);}
else
{this._horizontalGridlines=val;}}},verticalGridlines:{getter:function()
{var graph=this.get("graph");if(graph)
{return graph.get("verticalGridlines");}
return this._verticalGridlines;},setter:function(val)
{var graph=this.get("graph");if(val&&!Y_Lang.isObject(val))
{val={};}
if(graph)
{graph.set("verticalGridlines",val);}
else
{this._verticalGridlines=val;}}},type:{getter:function()
{if(this.get("stacked"))
{return"stacked"+this._type;}
return this._type;},setter:function(val)
{if(this._type==="bar")
{if(val!=="bar")
{this.set("direction","horizontal");}}
else
{if(val==="bar")
{this.set("direction","vertical");}}
this._type=val;return this._type;}},categoryAxis:{}}});Y.PieChart=Y.Base.create("pieChart",Y.Widget,[Y.ChartBase],{_getSeriesCollection:function()
{if(this._seriesCollection)
{return this._seriesCollection;}
var axes=this.get("axes"),sc=[],seriesKeys,i=0,l,type=this.get("type"),key,catAxis="categoryAxis",catKey="categoryKey",valAxis="valueAxis",seriesKey="valueKey";if(axes)
{seriesKeys=axes.values.get("keyCollection");key=axes.category.get("keyCollection")[0];l=seriesKeys.length;for(;i<l;++i)
{sc[i]={type:type};sc[i][catAxis]="category";sc[i][valAxis]="values";sc[i][catKey]=key;sc[i][seriesKey]=seriesKeys[i];}}
this._seriesCollection=sc;return sc;},_parseAxes:function(hash)
{if(!this._axes)
{this._axes={};}
var i,pos,axis,dh,config,AxisClass,type=this.get("type"),w=this.get("width"),h=this.get("height"),node=Y.Node.one(this._parentNode);if(!w)
{this.set("width",node.get("offsetWidth"));w=this.get("width");}
if(!h)
{this.set("height",node.get("offsetHeight"));h=this.get("height");}
for(i in hash)
{if(hash.hasOwnProperty(i))
{dh=hash[i];pos=type==="pie"?"none":dh.position;AxisClass=this._getAxisClass(dh.type);config={dataProvider:this.get("dataProvider")};if(dh.hasOwnProperty("roundingUnit"))
{config.roundingUnit=dh.roundingUnit;}
config.keys=dh.keys;config.width=w;config.height=h;config.position=pos;config.styles=dh.styles;axis=new AxisClass(config);axis.on("axisRendered",Y.bind(this._itemRendered,this));this._axes[i]=axis;}}},_addAxes:function()
{var axes=this.get("axes"),i,axis,p;if(!axes)
{this.set("axes",this._getDefaultAxes());axes=this.get("axes");}
if(!this._axesCollection)
{this._axesCollection=[];}
for(i in axes)
{if(axes.hasOwnProperty(i))
{axis=axes[i];p=axis.get("position");if(!this.get(p+"AxesCollection"))
{this.set(p+"AxesCollection",[axis]);}
else
{this.get(p+"AxesCollection").push(axis);}
this._axesCollection.push(axis);}}},_addSeries:function()
{var graph=this.get("graph"),seriesCollection=this.get("seriesCollection");this._parseSeriesAxes(seriesCollection);graph.set("showBackground",false);graph.set("width",this.get("width"));graph.set("height",this.get("height"));graph.set("seriesCollection",seriesCollection);this._seriesCollection=graph.get("seriesCollection");graph.render(this.get("contentBox"));},_parseSeriesAxes:function(c)
{var i=0,len=c.length,s,axes=this.get("axes"),axis;for(;i<len;++i)
{s=c[i];if(s)
{if(s instanceof Y.PieSeries)
{axis=s.get("categoryAxis");if(axis&&!(axis instanceof Y.Axis))
{s.set("categoryAxis",axes[axis]);}
axis=s.get("valueAxis");if(axis&&!(axis instanceof Y.Axis))
{s.set("valueAxis",axes[axis]);}
continue;}
s.categoryAxis=axes.category;s.valueAxis=axes.values;if(!s.type)
{s.type=this.get("type");}}}},_getDefaultAxes:function()
{var catKey=this.get("categoryKey"),seriesKeys=this.get("seriesKeys").concat(),seriesAxis="numeric";return{values:{keys:seriesKeys,type:seriesAxis},category:{keys:[catKey],type:this.get("categoryType")}};},getSeriesItems:function(series,index)
{var categoryItem={axis:series.get("categoryAxis"),key:series.get("categoryKey"),displayName:series.get("categoryDisplayName")},valueItem={axis:series.get("valueAxis"),key:series.get("valueKey"),displayName:series.get("valueDisplayName")};categoryItem.value=categoryItem.axis.getKeyValueAt(categoryItem.key,index);valueItem.value=valueItem.axis.getKeyValueAt(valueItem.key,index);return{category:categoryItem,value:valueItem};},_sizeChanged:function()
{this._redraw();},_redraw:function()
{var graph=this.get("graph"),w=this.get("width"),h=this.get("height"),dimension;if(graph)
{dimension=Math.min(w,h);graph.set("width",dimension);graph.set("height",dimension);}},_tooltipLabelFunction:function(categoryItem,valueItem,itemIndex,series)
{var msg=DOCUMENT.createElement("div"),total=series.getTotalValues(),pct=Math.round((valueItem.value / total)*10000)/100;msg.appendChild(DOCUMENT.createTextNode(categoryItem.displayName+": "+categoryItem.axis.get("labelFunction").apply(this,[categoryItem.value,categoryItem.axis.get("labelFormat")])));msg.appendChild(DOCUMENT.createElement("br"));msg.appendChild(DOCUMENT.createTextNode(valueItem.displayName+": "+valueItem.axis.get("labelFunction").apply(this,[valueItem.value,valueItem.axis.get("labelFormat")])));msg.appendChild(DOCUMENT.createElement("br"));msg.appendChild(DOCUMENT.createTextNode(pct+"%"));return msg;},_getAriaMessage:function(key)
{var msg="",categoryItem,items,series,valueItem,seriesIndex=0,itemIndex=this._itemIndex,len,total,pct,markers;series=this.getSeries(parseInt(seriesIndex,10));markers=series.get("markers");len=markers&&markers.length?markers.length:0;if(key===37)
{itemIndex=itemIndex>0?itemIndex-1:len-1;}
else if(key===39)
{itemIndex=itemIndex>=len-1?0:itemIndex+1;}
this._itemIndex=itemIndex;items=this.getSeriesItems(series,itemIndex);categoryItem=items.category;valueItem=items.value;total=series.getTotalValues();pct=Math.round((valueItem.value / total)*10000)/100;if(categoryItem&&valueItem)
{msg+=categoryItem.displayName+": "+
categoryItem.axis.formatLabel.apply(this,[categoryItem.value,categoryItem.axis.get("labelFormat")])+", ";msg+=valueItem.displayName+": "+valueItem.axis.formatLabel.apply(this,[valueItem.value,valueItem.axis.get("labelFormat")])+", ";msg+="Percent of total "+valueItem.displayName+": "+pct+"%,";}
else
{msg+="No data available,";}
msg+=(itemIndex+1)+" of "+len+". ";return msg;},destructor:function()
{var series,axis,tooltip=this.get("tooltip"),tooltipNode=tooltip.node,graph=this.get("graph"),axesCollection=this._axesCollection,seriesCollection=this.get("seriesCollection");while(seriesCollection.length>0)
{series=seriesCollection.shift();series.destroy(true);}
while(axesCollection.length>0)
{axis=axesCollection.shift();if(axis instanceof Y.Axis)
{axis.destroy(true);}}
if(this._description)
{this._description.empty();this._description.remove(true);}
if(this._liveRegion)
{this._liveRegion.empty();this._liveRegion.remove(true);}
if(graph)
{graph.destroy(true);}
if(tooltipNode)
{tooltipNode.empty();tooltipNode.remove(true);}}},{ATTRS:{ariaDescription:{value:"Use the left and right keys to navigate through items.",setter:function(val)
{if(this._description)
{this._description.set("text",val);}
return val;}},axes:{getter:function()
{return this._axes;},setter:function(val)
{this._parseAxes(val);}},seriesCollection:{lazyAdd:false,getter:function()
{return this._getSeriesCollection();},setter:function(val)
{return this._setSeriesCollection(val);}},type:{value:"pie"}}});function Chart(cfg)
{if(cfg.type!=="pie")
{return new Y.CartesianChart(cfg);}
else
{return new Y.PieChart(cfg);}}
Y.Chart=Chart;},'3.15.0',{"requires":["dom","event-mouseenter","event-touch","graphics-group","axes","series-pie","series-line","series-marker","series-area","series-spline","series-column","series-bar","series-areaspline","series-combo","series-combospline","series-line-stacked","series-marker-stacked","series-area-stacked","series-spline-stacked","series-column-stacked","series-bar-stacked","series-areaspline-stacked","series-combo-stacked","series-combospline-stacked"]});