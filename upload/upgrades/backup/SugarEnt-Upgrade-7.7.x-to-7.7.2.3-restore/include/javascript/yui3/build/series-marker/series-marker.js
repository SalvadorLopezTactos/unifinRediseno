/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-marker',function(Y,NAME){Y.MarkerSeries=Y.Base.create("markerSeries",Y.CartesianSeries,[Y.Plots],{_setStyles:function(val)
{if(!val.marker)
{val={marker:val};}
val=this._parseMarkerStyles(val);return Y.MarkerSeries.superclass._mergeStyles.apply(this,[val,this._getDefaultStyles()]);}},{ATTRS:{type:{value:"marker"}}});},'3.15.0',{"requires":["series-cartesian","series-plot-util"]});