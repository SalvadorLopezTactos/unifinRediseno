/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-line',function(Y,NAME){Y.LineSeries=Y.Base.create("lineSeries",Y.CartesianSeries,[Y.Lines],{drawSeries:function()
{this.drawLines();},_setStyles:function(val)
{if(!val.line)
{val={line:val};}
return Y.LineSeries.superclass._setStyles.apply(this,[val]);},_getDefaultStyles:function()
{var styles=this._mergeStyles({line:this._getLineDefaults()},Y.LineSeries.superclass._getDefaultStyles());return styles;}},{ATTRS:{type:{value:"line"}}});},'3.15.0',{"requires":["series-cartesian","series-line-util"]});