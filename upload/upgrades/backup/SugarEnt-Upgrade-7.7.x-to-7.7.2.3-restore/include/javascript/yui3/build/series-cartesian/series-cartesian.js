/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-cartesian',function(Y,NAME){var Y_Lang=Y.Lang;Y.CartesianSeries=Y.Base.create("cartesianSeries",Y.SeriesBase,[],{_xDisplayName:null,_yDisplayName:null,_leftOrigin:null,_bottomOrigin:null,addListeners:function()
{var xAxis=this.get("xAxis"),yAxis=this.get("yAxis");if(xAxis)
{this._xDataReadyHandle=xAxis.after("dataReady",Y.bind(this._xDataChangeHandler,this));this._xDataUpdateHandle=xAxis.after("dataUpdate",Y.bind(this._xDataChangeHandler,this));}
if(yAxis)
{this._yDataReadyHandle=yAxis.after("dataReady",Y.bind(this._yDataChangeHandler,this));this._yDataUpdateHandle=yAxis.after("dataUpdate",Y.bind(this._yDataChangeHandler,this));}
this._xAxisChangeHandle=this.after("xAxisChange",this._xAxisChangeHandler);this._yAxisChangeHandle=this.after("yAxisChange",this._yAxisChangeHandler);this._stylesChangeHandle=this.after("stylesChange",function(){var axesReady=this._updateAxisBase();if(axesReady)
{this.draw();}});this._widthChangeHandle=this.after("widthChange",function(){var axesReady=this._updateAxisBase();if(axesReady)
{this.draw();}});this._heightChangeHandle=this.after("heightChange",function(){var axesReady=this._updateAxisBase();if(axesReady)
{this.draw();}});this._visibleChangeHandle=this.after("visibleChange",this._handleVisibleChange);},_xAxisChangeHandler:function()
{var xAxis=this.get("xAxis");xAxis.after("dataReady",Y.bind(this._xDataChangeHandler,this));xAxis.after("dataUpdate",Y.bind(this._xDataChangeHandler,this));},_yAxisChangeHandler:function()
{var yAxis=this.get("yAxis");yAxis.after("dataReady",Y.bind(this._yDataChangeHandler,this));yAxis.after("dataUpdate",Y.bind(this._yDataChangeHandler,this));},GUID:"yuicartesianseries",_xDataChangeHandler:function()
{var axesReady=this._updateAxisBase();if(axesReady)
{this.draw();}},_yDataChangeHandler:function()
{var axesReady=this._updateAxisBase();if(axesReady)
{this.draw();}},_updateAxisBase:function()
{var xAxis=this.get("xAxis"),yAxis=this.get("yAxis"),xKey=this.get("xKey"),yKey=this.get("yKey"),yData,xData,xReady,yReady,ready;if(!xAxis||!yAxis||!xKey||!yKey)
{ready=false;}
else
{xData=xAxis.getDataByKey(xKey);yData=yAxis.getDataByKey(yKey);if(Y_Lang.isArray(xKey))
{xReady=(xData&&Y.Object.size(xData)>0)?this._checkForDataByKey(xData,xKey):false;}
else
{xReady=xData?true:false;}
if(Y_Lang.isArray(yKey))
{yReady=(yData&&Y.Object.size(yData)>0)?this._checkForDataByKey(yData,yKey):false;}
else
{yReady=yData?true:false;}
ready=xReady&&yReady;if(ready)
{this.set("xData",xData);this.set("yData",yData);}}
return ready;},_checkForDataByKey:function(obj,keys)
{var i,len=keys.length,hasData=false;for(i=0;i<len;i=i+1)
{if(obj[keys[i]])
{hasData=true;break;}}
return hasData;},validate:function()
{if((this.get("xData")&&this.get("yData"))||this._updateAxisBase())
{this.draw();}
else
{this.fire("drawingComplete");}},setAreaData:function()
{var w=this.get("width"),h=this.get("height"),xAxis=this.get("xAxis"),yAxis=this.get("yAxis"),xData=this._copyData(this.get("xData")),yData=this._copyData(this.get("yData")),direction=this.get("direction"),dataLength=direction==="vertical"?yData.length:xData.length,xOffset=xAxis.getEdgeOffset(xAxis.getTotalMajorUnits(),w),yOffset=yAxis.getEdgeOffset(yAxis.getTotalMajorUnits(),h),padding=this.get("styles").padding,leftPadding=padding.left,topPadding=padding.top,dataWidth=w-(leftPadding+padding.right+xOffset*2),dataHeight=h-(topPadding+padding.bottom+yOffset*2),xMax=xAxis.get("maximum"),xMin=xAxis.get("minimum"),yMax=yAxis.get("maximum"),yMin=yAxis.get("minimum"),graphic=this.get("graphic"),yAxisType=yAxis.get("type"),reverseYCoords=(yAxisType==="numeric"||yAxisType==="stacked"),xcoords,ycoords,xOriginValue=xAxis.getOrigin(),yOriginValue=yAxis.getOrigin();graphic.set("width",w);graphic.set("height",h);xOffset=xOffset+leftPadding;yOffset=reverseYCoords?yOffset+dataHeight+topPadding+padding.bottom:topPadding+yOffset;this._leftOrigin=Math.round(xAxis._getCoordFromValue(xMin,xMax,dataWidth,xOriginValue,xOffset,false));this._bottomOrigin=Math.round(yAxis._getCoordFromValue(yMin,yMax,dataHeight,yOriginValue,yOffset,reverseYCoords));xcoords=this._getCoords(xMin,xMax,dataWidth,xData,xAxis,xOffset,false);ycoords=this._getCoords(yMin,yMax,dataHeight,yData,yAxis,yOffset,reverseYCoords);this.set("xcoords",xcoords);this.set("ycoords",ycoords);this._dataLength=dataLength;this._setXMarkerPlane(xcoords,dataLength);this._setYMarkerPlane(ycoords,dataLength);},_getCoords:function(min,max,length,data,axis,offset,reverse)
{var coords,key;if(Y_Lang.isArray(data))
{coords=axis._getCoordsFromValues(min,max,length,data,offset,reverse);}
else
{coords={};for(key in data)
{if(data.hasOwnProperty(key))
{coords[key]=this._getCoords.apply(this,[min,max,length,data[key],axis,offset,reverse]);}}}
return coords;},_copyData:function(val)
{var copy,key;if(Y_Lang.isArray(val))
{copy=val.concat();}
else
{copy={};for(key in val)
{if(val.hasOwnProperty(key))
{copy[key]=val[key].concat();}}}
return copy;},_setXMarkerPlane:function(coords,dataLength)
{var i=0,xMarkerPlane=[],xMarkerPlaneOffset=this.get("xMarkerPlaneOffset"),nextX;if(Y_Lang.isArray(coords))
{for(i=0;i<dataLength;i=i+1)
{nextX=coords[i];xMarkerPlane.push({start:nextX-xMarkerPlaneOffset,end:nextX+xMarkerPlaneOffset});}
this.set("xMarkerPlane",xMarkerPlane);}},_setYMarkerPlane:function(coords,dataLength)
{var i=0,yMarkerPlane=[],yMarkerPlaneOffset=this.get("yMarkerPlaneOffset"),nextY;if(Y_Lang.isArray(coords))
{for(i=0;i<dataLength;i=i+1)
{nextY=coords[i];yMarkerPlane.push({start:nextY-yMarkerPlaneOffset,end:nextY+yMarkerPlaneOffset});}
this.set("yMarkerPlane",yMarkerPlane);}},_getFirstValidIndex:function(coords)
{var coord,i=-1,limit=coords.length;while(!Y_Lang.isNumber(coord)&&i<limit)
{i+=1;coord=coords[i];}
return i;},_getLastValidIndex:function(coords)
{var coord,i=coords.length,limit=-1;while(!Y_Lang.isNumber(coord)&&i>limit)
{i-=1;coord=coords[i];}
return i;},draw:function()
{var w=this.get("width"),h=this.get("height"),xcoords,ycoords;if(this.get("rendered"))
{if((isFinite(w)&&isFinite(h)&&w>0&&h>0)&&((this.get("xData")&&this.get("yData"))||this._updateAxisBase()))
{if(this._drawing)
{this._callLater=true;return;}
this._drawing=true;this._callLater=false;this.setAreaData();xcoords=this.get("xcoords");ycoords=this.get("ycoords");if(xcoords&&ycoords&&xcoords.length>0)
{this.drawSeries();}
this._drawing=false;if(this._callLater)
{this.draw();}
else
{this._toggleVisible(this.get("visible"));this.fire("drawingComplete");}}}},_defaultPlaneOffset:4,destructor:function()
{if(this.get("rendered"))
{if(this._xDataReadyHandle)
{this._xDataReadyHandle.detach();}
if(this._xDataUpdateHandle)
{this._xDataUpdateHandle.detach();}
if(this._yDataReadyHandle)
{this._yDataReadyHandle.detach();}
if(this._yDataUpdateHandle)
{this._yDataUpdateHandle.detach();}
if(this._xAxisChangeHandle)
{this._xAxisChangeHandle.detach();}
if(this._yAxisChangeHandle)
{this._yAxisChangeHandle.detach();}}}},{ATTRS:{seriesTypeCollection:{},xDisplayName:{getter:function()
{return this._xDisplayName||this.get("xKey");},setter:function(val)
{this._xDisplayName=val.toString();return val;}},yDisplayName:{getter:function()
{return this._yDisplayName||this.get("yKey");},setter:function(val)
{this._yDisplayName=val.toString();return val;}},categoryDisplayName:{lazyAdd:false,getter:function()
{return this.get("direction")==="vertical"?this.get("yDisplayName"):this.get("xDisplayName");},setter:function(val)
{if(this.get("direction")==="vertical")
{this._yDisplayName=val;}
else
{this._xDisplayName=val;}
return val;}},valueDisplayName:{lazyAdd:false,getter:function()
{return this.get("direction")==="vertical"?this.get("xDisplayName"):this.get("yDisplayName");},setter:function(val)
{if(this.get("direction")==="vertical")
{this._xDisplayName=val;}
else
{this._yDisplayName=val;}
return val;}},type:{value:"cartesian"},order:{},graphOrder:{},xcoords:{},ycoords:{},xAxis:{},yAxis:{},xKey:{setter:function(val)
{if(Y_Lang.isArray(val))
{return val;}
else
{return val.toString();}}},yKey:{setter:function(val)
{if(Y_Lang.isArray(val))
{return val;}
else
{return val.toString();}}},xData:{},yData:{},xMarkerPlane:{},yMarkerPlane:{},xMarkerPlaneOffset:{getter:function(){var marker=this.get("styles").marker;if(marker&&marker.width&&isFinite(marker.width))
{return marker.width*0.5;}
return this._defaultPlaneOffset;}},yMarkerPlaneOffset:{getter:function(){var marker=this.get("styles").marker;if(marker&&marker.height&&isFinite(marker.height))
{return marker.height*0.5;}
return this._defaultPlaneOffset;}},direction:{value:"horizontal"}}});},'3.15.0',{"requires":["series-base"]});