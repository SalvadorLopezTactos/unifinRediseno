/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-plot-util',function(Y,NAME){var Y_Lang=Y.Lang,_getClassName=Y.ClassNameManager.getClassName,SERIES_MARKER=_getClassName("seriesmarker");function Plots(cfg)
{var attrs={markers:{getter:function()
{return this._markers;}}};this.addAttrs(attrs,cfg);}
Plots.prototype={_plotDefaults:null,drawPlots:function()
{if(!this.get("xcoords")||this.get("xcoords").length<1)
{return;}
var isNumber=Y_Lang.isNumber,style=this._copyObject(this.get("styles").marker),w=style.width,h=style.height,xcoords=this.get("xcoords"),ycoords=this.get("ycoords"),i=0,len=xcoords.length,top=ycoords[0],left,marker,offsetWidth=w/2,offsetHeight=h/2,xvalues,yvalues,fillColors=null,borderColors=null,graphOrder=this.get("graphOrder"),groupMarkers=this.get("groupMarkers");if(groupMarkers)
{xvalues=[];yvalues=[];for(;i<len;++i)
{xvalues.push(parseFloat(xcoords[i]-offsetWidth));yvalues.push(parseFloat(ycoords[i]-offsetHeight));}
this._createGroupMarker({xvalues:xvalues,yvalues:yvalues,fill:style.fill,border:style.border,dimensions:{width:w,height:h},graphOrder:graphOrder,shape:style.shape});return;}
if(Y_Lang.isArray(style.fill.color))
{fillColors=style.fill.color.concat();}
if(Y_Lang.isArray(style.border.color))
{borderColors=style.border.color.concat();}
this._createMarkerCache();for(;i<len;++i)
{top=parseFloat(ycoords[i]-offsetHeight);left=parseFloat(xcoords[i]-offsetWidth);if(!isNumber(left)||!isNumber(top))
{this._markers.push(null);continue;}
if(fillColors)
{style.fill.color=fillColors[i%fillColors.length];}
if(borderColors)
{style.border.color=borderColors[i%borderColors.length];}
style.x=left;style.y=top;marker=this.getMarker(style,graphOrder,i);}
this._clearMarkerCache();},_groupShapes:{circle:Y.CircleGroup,rect:Y.RectGroup,ellipse:Y.EllipseGroup,diamond:Y.DiamondGroup},_getGroupShape:function(shape)
{if(Y_Lang.isString(shape))
{shape=this._groupShapes[shape];}
return shape;},_getPlotDefaults:function()
{var defs={fill:{type:"solid",alpha:1,colors:null,alphas:null,ratios:null},border:{weight:1,alpha:1},width:10,height:10,shape:"circle"};defs.fill.color=this._getDefaultColor(this.get("graphOrder"),"fill");defs.border.color=this._getDefaultColor(this.get("graphOrder"),"border");return defs;},_markers:null,_markerCache:null,getMarker:function(styles,order,index)
{var marker,border=styles.border;styles.id=this._getChart().get("id")+"_"+order+"_"+index;border.opacity=border.alpha;styles.stroke=border;styles.fill.opacity=styles.fill.alpha;if(this._markerCache.length>0)
{while(!marker)
{if(this._markerCache.length<1)
{marker=this._createMarker(styles);break;}
marker=this._markerCache.shift();}
marker.set(styles);}
else
{marker=this._createMarker(styles);}
this._markers.push(marker);return marker;},_createMarker:function(styles)
{var graphic=this.get("graphic"),marker,cfg=this._copyObject(styles);cfg.type=cfg.shape;marker=graphic.addShape(cfg);marker.addClass(SERIES_MARKER);return marker;},_createMarkerCache:function()
{if(this._groupMarker)
{this._groupMarker.destroy();this._groupMarker=null;}
if(this._markers&&this._markers.length>0)
{this._markerCache=this._markers.concat();}
else
{this._markerCache=[];}
this._markers=[];},_createGroupMarker:function(styles)
{var marker,markers=this.get("markers"),border=styles.border,graphic,cfg,shape;if(markers&&markers.length>0)
{while(markers.length>0)
{marker=markers.shift();marker.destroy();}
this.set("markers",[]);}
border.opacity=border.alpha;cfg={id:this._getChart().get("id")+"_"+styles.graphOrder,stroke:border,fill:styles.fill,dimensions:styles.dimensions,xvalues:styles.xvalues,yvalues:styles.yvalues};cfg.fill.opacity=styles.fill.alpha;shape=this._getGroupShape(styles.shape);if(shape)
{cfg.type=shape;}
if(styles.hasOwnProperty("radius")&&!isNaN(styles.radius))
{cfg.dimensions.radius=styles.radius;}
if(this._groupMarker)
{this._groupMarker.destroy();}
graphic=this.get("graphic");this._groupMarker=graphic.addShape(cfg);graphic._redraw();},_toggleVisible:function(visible)
{var marker,markers=this.get("markers"),i=0,len;if(markers)
{len=markers.length;for(;i<len;++i)
{marker=markers[i];if(marker)
{marker.set("visible",visible);}}}},_clearMarkerCache:function()
{var marker;while(this._markerCache.length>0)
{marker=this._markerCache.shift();if(marker)
{marker.destroy();}}},updateMarkerState:function(type,i)
{if(this._markers&&this._markers[i])
{var w,h,styles=this._copyObject(this.get("styles").marker),state=this._getState(type),xcoords=this.get("xcoords"),ycoords=this.get("ycoords"),marker=this._markers[i],markerStyles=state==="off"||!styles[state]?styles:styles[state];markerStyles.fill.color=this._getItemColor(markerStyles.fill.color,i);markerStyles.border.color=this._getItemColor(markerStyles.border.color,i);markerStyles.stroke=markerStyles.border;marker.set(markerStyles);w=markerStyles.width;h=markerStyles.height;marker.set("x",(xcoords[i]-w/2));marker.set("y",(ycoords[i]-h/2));marker.set("visible",this.get("visible"));}},_getItemColor:function(val,i)
{if(Y_Lang.isArray(val))
{return val[i%val.length];}
return val;},_setStyles:function(val)
{val=this._parseMarkerStyles(val);return Y.Renderer.prototype._setStyles.apply(this,[val]);},_parseMarkerStyles:function(val)
{if(val.marker)
{var defs=this._getPlotDefaults();val.marker=this._mergeStyles(val.marker,defs);if(val.marker.over)
{val.marker.over=this._mergeStyles(val.marker.over,val.marker);}
if(val.marker.down)
{val.marker.down=this._mergeStyles(val.marker.down,val.marker);}}
return val;},_getState:function(type)
{var state;switch(type)
{case"mouseout":state="off";break;case"mouseover":state="over";break;case"mouseup":state="over";break;case"mousedown":state="down";break;}
return state;},_stateSyles:null,drawSeries:function()
{this.drawPlots();},_getDefaultStyles:function()
{var styles=this._mergeStyles({marker:this._getPlotDefaults()},this.constructor.superclass._getDefaultStyles());return styles;}};Y.augment(Plots,Y.Attribute);Y.Plots=Plots;},'3.15.0');