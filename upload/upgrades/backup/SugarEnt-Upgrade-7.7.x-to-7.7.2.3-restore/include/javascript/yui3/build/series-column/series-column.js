/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-column',function(Y,NAME){Y.ColumnSeries=Y.Base.create("columnSeries",Y.MarkerSeries,[Y.Histogram],{_getMarkerDimensions:function(xcoord,ycoord,calculatedSize,offset)
{var config={left:xcoord+offset};if(this._bottomOrigin>=ycoord)
{config.top=ycoord;config.calculatedSize=this._bottomOrigin-config.top;}
else
{config.top=this._bottomOrigin;config.calculatedSize=ycoord-this._bottomOrigin;}
return config;},updateMarkerState:function(type,i)
{if(this._markers&&this._markers[i])
{var styles=this._copyObject(this.get("styles").marker),markerStyles,state=this._getState(type),xcoords=this.get("xcoords"),ycoords=this.get("ycoords"),marker=this._markers[i],markers,seriesStyles,seriesCollection=this.get("seriesTypeCollection"),seriesLen=seriesCollection?seriesCollection.length:0,seriesSize=0,offset=0,renderer,n=0,xs=[],order=this.get("order"),config;markerStyles=state==="off"||!styles[state]?this._copyObject(styles):this._copyObject(styles[state]);markerStyles.fill.color=this._getItemColor(markerStyles.fill.color,i);markerStyles.border.color=this._getItemColor(markerStyles.border.color,i);config=this._getMarkerDimensions(xcoords[i],ycoords[i],styles.width,offset);markerStyles.height=config.calculatedSize;markerStyles.width=Math.min(this._maxSize,markerStyles.width);marker.set(markerStyles);for(;n<seriesLen;++n)
{xs[n]=xcoords[i]+seriesSize;seriesStyles=seriesCollection[n].get("styles").marker;seriesSize+=Math.min(this._maxSize,seriesStyles.width);if(order>n)
{offset=seriesSize;}
offset-=seriesSize/2;}
for(n=0;n<seriesLen;++n)
{markers=seriesCollection[n].get("markers");if(markers)
{renderer=markers[i];if(renderer&&renderer!==undefined)
{renderer.set("x",(xs[n]-seriesSize/2));}}}}}},{ATTRS:{type:{value:"column"}}});},'3.15.0',{"requires":["series-marker","series-histogram-base"]});