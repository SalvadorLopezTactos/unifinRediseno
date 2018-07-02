/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-area-stacked',function(Y,NAME){Y.StackedAreaSeries=Y.Base.create("stackedAreaSeries",Y.AreaSeries,[Y.StackingUtil],{setAreaData:function()
{Y.StackedAreaSeries.superclass.setAreaData.apply(this);this._stackCoordinates.apply(this);},drawSeries:function()
{this.drawFill.apply(this,this._getStackedClosingPoints());}},{ATTRS:{type:{value:"stackedArea"}}});},'3.15.0',{"requires":["series-stacked","series-area"]});