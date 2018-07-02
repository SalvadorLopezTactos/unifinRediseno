/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-areaspline',function(Y,NAME){Y.AreaSplineSeries=Y.Base.create("areaSplineSeries",Y.AreaSeries,[Y.CurveUtil],{drawSeries:function()
{this.drawAreaSpline();}},{ATTRS:{type:{value:"areaSpline"}}});},'3.15.0',{"requires":["series-area","series-curve-util"]});