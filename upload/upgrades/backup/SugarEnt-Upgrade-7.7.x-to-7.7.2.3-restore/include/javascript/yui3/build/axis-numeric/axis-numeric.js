/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('axis-numeric',function(Y,NAME){var Y_Lang=Y.Lang;Y.NumericAxis=Y.Base.create("numericAxis",Y.Axis,[Y.NumericImpl],{_getLabelByIndex:function(i,l)
{var min=this.get("minimum"),max=this.get("maximum"),increm=(max-min)/(l-1),label,roundingMethod=this.get("roundingMethod");l-=1;if(i===0)
{label=min;}
else if(i===l)
{label=max;}
else
{label=(i*increm);if(roundingMethod==="niceNumber")
{label=this._roundToNearest(label,increm);}
label+=min;}
return parseFloat(label);},_getLabelData:function(constantVal,staticCoord,dynamicCoord,min,max,edgeOffset,layoutLength,count,dataValues)
{var dataValue,i,points=[],values=[],point,isVertical=staticCoord==="x",offset=isVertical?layoutLength+edgeOffset:edgeOffset;dataValues=dataValues||this._getDataValuesByCount(count,min,max);for(i=0;i<count;i=i+1)
{dataValue=parseFloat(dataValues[i]);if(dataValue<=max&&dataValue>=min)
{point={};point[staticCoord]=constantVal;point[dynamicCoord]=this._getCoordFromValue(min,max,layoutLength,dataValue,offset,isVertical);points.push(point);values.push(dataValue);}}
return{points:points,values:values};},_hasDataOverflow:function()
{var roundingMethod,min,max;if(this.get("setMin")||this.get("setMax"))
{return true;}
roundingMethod=this.get("roundingMethod");min=this._actualMinimum;max=this._actualMaximum;if(Y_Lang.isNumber(roundingMethod)&&((Y_Lang.isNumber(max)&&max>this._dataMaximum)||(Y_Lang.isNumber(min)&&min<this._dataMinimum)))
{return true;}
return false;}});},'3.15.0',{"requires":["axis","axis-numeric-base"]});