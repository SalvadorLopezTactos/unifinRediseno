/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-candlestick',function(Y,NAME){function CandlestickSeries()
{CandlestickSeries.superclass.constructor.apply(this,arguments);}
CandlestickSeries.NAME="candlestickSeries";CandlestickSeries.ATTRS={type:{value:"candlestick"},graphic:{lazyAdd:false,setter:function(val){if(!this.get("rendered")){this.set("rendered",true);}
this.set("upcandle",val.addShape({type:"path"}));this.set("downcandle",val.addShape({type:"path"}));this.set("wick",val.addShape({type:"path"}));return val;}},upcandle:{},downcandle:{},wick:{}};Y.extend(CandlestickSeries,Y.RangeSeries,{_drawMarkers:function(xcoords,opencoords,highcoords,lowcoords,closecoords,len,width,halfwidth,styles)
{var upcandle=this.get("upcandle"),downcandle=this.get("downcandle"),candle,wick=this.get("wick"),wickStyles=styles.wick,wickWidth=wickStyles.width,cx,opencoord,highcoord,lowcoord,closecoord,left,right,top,bottom,height,leftPadding=styles.padding.left,up,i,isNumber=Y.Lang.isNumber;upcandle.set(styles.upcandle);downcandle.set(styles.downcandle);wick.set({fill:wickStyles.fill,stroke:wickStyles.stroke,shapeRendering:wickStyles.shapeRendering});upcandle.clear();downcandle.clear();wick.clear();for(i=0;i<len;i=i+1)
{cx=Math.round(xcoords[i]+leftPadding);left=cx-halfwidth;right=cx+halfwidth;opencoord=Math.round(opencoords[i]);highcoord=Math.round(highcoords[i]);lowcoord=Math.round(lowcoords[i]);closecoord=Math.round(closecoords[i]);up=opencoord>closecoord;top=up?closecoord:opencoord;bottom=up?opencoord:closecoord;height=bottom-top;candle=up?upcandle:downcandle;if(candle&&isNumber(left)&&isNumber(top)&&isNumber(width)&&isNumber(height))
{candle.drawRect(left,top,width,height);}
if(isNumber(cx)&&isNumber(highcoord)&&isNumber(lowcoord))
{wick.drawRect(cx-wickWidth/2,highcoord,wickWidth,lowcoord-highcoord);}}
upcandle.end();downcandle.end();wick.end();wick.toBack();},_toggleVisible:function(visible)
{this.get("upcandle").set("visible",visible);this.get("downcandle").set("visible",visible);this.get("wick").set("visible",visible);},destructor:function()
{var upcandle=this.get("upcandle"),downcandle=this.get("downcandle"),wick=this.get("wick");if(upcandle)
{upcandle.destroy();}
if(downcandle)
{downcandle.destroy();}
if(wick)
{wick.destroy();}},_getDefaultStyles:function()
{var styles={upcandle:{shapeRendering:"crispEdges",fill:{color:"#00aa00",alpha:1},stroke:{color:"#000000",alpha:1,weight:0}},downcandle:{shapeRendering:"crispEdges",fill:{color:"#aa0000",alpha:1},stroke:{color:"#000000",alpha:1,weight:0}},wick:{shapeRendering:"crispEdges",width:1,fill:{color:"#000000",alpha:1},stroke:{color:"#000000",alpha:1,weight:0}}};return this._mergeStyles(styles,CandlestickSeries.superclass._getDefaultStyles());}});Y.CandlestickSeries=CandlestickSeries;},'3.15.0',{"requires":["series-range"]});