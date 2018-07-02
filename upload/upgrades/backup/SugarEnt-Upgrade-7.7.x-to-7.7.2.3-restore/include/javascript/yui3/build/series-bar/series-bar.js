/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-bar',function(Y,NAME){Y.BarSeries=Y.Base.create("barSeries",Y.MarkerSeries,[Y.Histogram],{_getMarkerDimensions:function(xcoord,ycoord,calculatedSize,offset)
{var config={top:ycoord+offset};if(xcoord>=this._leftOrigin)
{config.left=this._leftOrigin;config.calculatedSize=xcoord-config.left;}
else
{config.left=xcoord;config.calculatedSize=this._leftOrigin-xcoord;}
return config;},updateMarkerState:function(type,i)
{if(this._markers&&this._markers[i])
{var styles=this._copyObject(this.get("styles").marker),markerStyles,state=this._getState(type),xcoords=this.get("xcoords"),ycoords=this.get("ycoords"),marker=this._markers[i],markers,seriesCollection=this.get("seriesTypeCollection"),seriesLen=seriesCollection?seriesCollection.length:0,seriesStyles,seriesSize=0,offset=0,renderer,n=0,ys=[],order=this.get("order"),config;markerStyles=state==="off"||!styles[state]?styles:styles[state];markerStyles.fill.color=this._getItemColor(markerStyles.fill.color,i);markerStyles.border.color=this._getItemColor(markerStyles.border.color,i);config=this._getMarkerDimensions(xcoords[i],ycoords[i],styles.height,offset);markerStyles.width=config.calculatedSize;markerStyles.height=Math.min(this._maxSize,markerStyles.height);marker.set(markerStyles);for(;n<seriesLen;++n)
{ys[n]=ycoords[i]+seriesSize;seriesStyles=seriesCollection[n].get("styles").marker;seriesSize+=Math.min(this._maxSize,seriesStyles.height);if(order>n)
{offset=seriesSize;}
offset-=seriesSize/2;}
for(n=0;n<seriesLen;++n)
{markers=seriesCollection[n].get("markers");if(markers)
{renderer=markers[i];if(renderer&&renderer!==undefined)
{renderer.set("y",(ys[n]-seriesSize/2));}}}}}},{ATTRS:{type:{value:"bar"},direction:{value:"vertical"}}});},'3.15.0',{"requires":["series-marker","series-histogram-base"]});