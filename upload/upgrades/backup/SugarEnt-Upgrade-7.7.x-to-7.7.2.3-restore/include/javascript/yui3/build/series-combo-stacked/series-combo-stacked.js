/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('series-combo-stacked',function(Y,NAME){Y.StackedComboSeries=Y.Base.create("stackedComboSeries",Y.ComboSeries,[Y.StackingUtil],{setAreaData:function()
{Y.StackedComboSeries.superclass.setAreaData.apply(this);this._stackCoordinates.apply(this);},drawSeries:function()
{if(this.get("showAreaFill"))
{this.drawFill.apply(this,this._getStackedClosingPoints());}
if(this.get("showLines"))
{this.drawLines();}
if(this.get("showMarkers"))
{this.drawPlots();}}},{ATTRS:{type:{value:"stackedCombo"},showAreaFill:{value:true}}});},'3.15.0',{"requires":["series-stacked","series-combo"]});