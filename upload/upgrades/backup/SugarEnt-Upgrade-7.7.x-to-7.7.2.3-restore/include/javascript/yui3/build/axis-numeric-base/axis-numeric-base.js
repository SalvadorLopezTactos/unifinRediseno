/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('axis-numeric-base',function(Y,NAME){var Y_Lang=Y.Lang;function NumericImpl()
{}
NumericImpl.NAME="numericImpl";NumericImpl.ATTRS={alwaysShowZero:{value:true},labelFormat:{value:{prefix:"",thousandsSeparator:"",decimalSeparator:"",decimalPlaces:"0",suffix:""}},roundingMethod:{value:"niceNumber"},scaleType:{value:"linear"}};NumericImpl.prototype={initializer:function(){this.after("alwaysShowZeroChange",this._keyChangeHandler);this.after("roundingMethodChange",this._keyChangeHandler);this.after("scaleTypeChange",this._keyChangeHandler);},formatLabel:function(val,format)
{if(format)
{return Y.DataType.Number.format(val,format);}
return val;},getTotalByKey:function(key)
{var total=0,values=this.getDataByKey(key),i=0,val,len=values?values.length:0;for(;i<len;++i)
{val=parseFloat(values[i]);if(!isNaN(val))
{total+=val;}}
return total;},getOrigin:function(){var origin=0,min=this.get("minimum"),max=this.get("maximum");origin=Math.max(origin,min);origin=Math.min(origin,max);return origin;},_type:"numeric",_getMinimumUnit:function(max,min,units)
{return this._getNiceNumber(Math.ceil((max-min)/units));},_getNiceNumber:function(roundingUnit)
{var tempMajorUnit=roundingUnit,order=Math.ceil(Math.log(tempMajorUnit)*0.4342944819032518),roundedMajorUnit=Math.pow(10,order),roundedDiff;if(roundedMajorUnit / 2>=tempMajorUnit)
{roundedDiff=Math.floor((roundedMajorUnit / 2-tempMajorUnit)/(Math.pow(10,order-1)/2));tempMajorUnit=roundedMajorUnit/2-roundedDiff*Math.pow(10,order-1)/2;}
else
{tempMajorUnit=roundedMajorUnit;}
if(!isNaN(tempMajorUnit))
{return tempMajorUnit;}
return roundingUnit;},_updateMinAndMax:function()
{var data=this.get("data"),max,min,len,num,i=0,setMax=this.get("setMax"),setMin=this.get("setMin");if(!setMax||!setMin)
{if(data&&data.length&&data.length>0)
{len=data.length;for(;i<len;i++)
{num=data[i];if(isNaN(num))
{max=setMax?this._setMaximum:max;min=setMin?this._setMinimum:min;continue;}
if(setMin)
{min=this._setMinimum;}
else if(min===undefined)
{min=num;}
else
{min=Math.min(num,min);}
if(setMax)
{max=this._setMaximum;}
else if(max===undefined)
{max=num;}
else
{max=Math.max(num,max);}
this._actualMaximum=max;this._actualMinimum=min;}}
if(this.get("scaleType")!=="logarithmic")
{this._roundMinAndMax(min,max,setMin,setMax);}
else
{this._dataMaximum=max;this._dataMinimum=min;}}},_roundMinAndMax:function(min,max,setMin,setMax)
{var roundingUnit,minimumRange,minGreaterThanZero=min>=0,maxGreaterThanZero=max>0,dataRangeGreater,maxRound,minRound,topTicks,botTicks,tempMax,tempMin,units=this.getTotalMajorUnits()-1,alwaysShowZero=this.get("alwaysShowZero"),roundingMethod=this.get("roundingMethod"),useIntegers=(max-min)/units>=1;if(roundingMethod)
{if(roundingMethod==="niceNumber")
{roundingUnit=this._getMinimumUnit(max,min,units);if(minGreaterThanZero&&maxGreaterThanZero)
{if((alwaysShowZero||min<roundingUnit)&&!setMin)
{min=0;roundingUnit=this._getMinimumUnit(max,min,units);}
else
{min=this._roundDownToNearest(min,roundingUnit);}
if(setMax)
{if(!alwaysShowZero)
{min=max-(roundingUnit*units);}}
else if(setMin)
{max=min+(roundingUnit*units);}
else
{max=this._roundUpToNearest(max,roundingUnit);}}
else if(maxGreaterThanZero&&!minGreaterThanZero)
{if(alwaysShowZero)
{topTicks=Math.round(units/((-1*min)/max+1));topTicks=Math.max(Math.min(topTicks,units-1),1);botTicks=units-topTicks;tempMax=Math.ceil(max/topTicks);tempMin=Math.floor(min/botTicks)*-1;if(setMin)
{while(tempMin<tempMax&&botTicks>=0)
{botTicks--;topTicks++;tempMax=Math.ceil(max/topTicks);tempMin=Math.floor(min/botTicks)*-1;}
if(botTicks>0)
{max=tempMin*topTicks;}
else
{max=min+(roundingUnit*units);}}
else if(setMax)
{while(tempMax<tempMin&&topTicks>=0)
{botTicks++;topTicks--;tempMin=Math.floor(min/botTicks)*-1;tempMax=Math.ceil(max/topTicks);}
if(topTicks>0)
{min=tempMax*botTicks*-1;}
else
{min=max-(roundingUnit*units);}}
else
{roundingUnit=Math.max(tempMax,tempMin);roundingUnit=this._getNiceNumber(roundingUnit);max=roundingUnit*topTicks;min=roundingUnit*botTicks*-1;}}
else
{if(setMax)
{min=max-(roundingUnit*units);}
else if(setMin)
{max=min+(roundingUnit*units);}
else
{min=this._roundDownToNearest(min,roundingUnit);max=this._roundUpToNearest(max,roundingUnit);}}}
else
{if(setMin)
{if(alwaysShowZero)
{max=0;}
else
{max=min+(roundingUnit*units);}}
else if(!setMax)
{if(alwaysShowZero||max===0||max+roundingUnit>0)
{max=0;roundingUnit=this._getMinimumUnit(max,min,units);min=max-(roundingUnit*units);}
else
{min=this._roundDownToNearest(min,roundingUnit);max=this._roundUpToNearest(max,roundingUnit);}}
else
{min=max-(roundingUnit*units);}}}
else if(roundingMethod==="auto")
{if(minGreaterThanZero&&maxGreaterThanZero)
{if((alwaysShowZero||min<(max-min)/units)&&!setMin)
{min=0;}
roundingUnit=(max-min)/units;if(useIntegers)
{roundingUnit=Math.ceil(roundingUnit);max=min+(roundingUnit*units);}
else
{max=min+Math.ceil(roundingUnit*units*100000)/100000;}}
else if(maxGreaterThanZero&&!minGreaterThanZero)
{if(alwaysShowZero)
{topTicks=Math.round(units /((-1*min)/max+1));topTicks=Math.max(Math.min(topTicks,units-1),1);botTicks=units-topTicks;if(useIntegers)
{tempMax=Math.ceil(max/topTicks);tempMin=Math.floor(min/botTicks)*-1;roundingUnit=Math.max(tempMax,tempMin);max=roundingUnit*topTicks;min=roundingUnit*botTicks*-1;}
else
{tempMax=max/topTicks;tempMin=min/botTicks*-1;roundingUnit=Math.max(tempMax,tempMin);max=Math.ceil(roundingUnit*topTicks*100000)/100000;min=Math.ceil(roundingUnit*botTicks*100000)/100000*-1;}}
else
{roundingUnit=(max-min)/units;if(useIntegers)
{roundingUnit=Math.ceil(roundingUnit);}
min=Math.round(this._roundDownToNearest(min,roundingUnit)*100000)/100000;max=Math.round(this._roundUpToNearest(max,roundingUnit)*100000)/100000;}}
else
{roundingUnit=(max-min)/units;if(useIntegers)
{roundingUnit=Math.ceil(roundingUnit);}
if(alwaysShowZero||max===0||max+roundingUnit>0)
{max=0;roundingUnit=(max-min)/units;if(useIntegers)
{Math.ceil(roundingUnit);min=max-(roundingUnit*units);}
else
{min=max-Math.ceil(roundingUnit*units*100000)/100000;}}
else
{min=this._roundDownToNearest(min,roundingUnit);max=this._roundUpToNearest(max,roundingUnit);}}}
else if(!isNaN(roundingMethod)&&isFinite(roundingMethod))
{roundingUnit=roundingMethod;minimumRange=roundingUnit*units;dataRangeGreater=(max-min)>minimumRange;minRound=this._roundDownToNearest(min,roundingUnit);maxRound=this._roundUpToNearest(max,roundingUnit);if(setMax)
{min=max-minimumRange;}
else if(setMin)
{max=min+minimumRange;}
else if(minGreaterThanZero&&maxGreaterThanZero)
{if(alwaysShowZero||minRound<=0)
{min=0;}
else
{min=minRound;}
max=min+minimumRange;}
else if(maxGreaterThanZero&&!minGreaterThanZero)
{min=minRound;max=maxRound;}
else
{if(alwaysShowZero||maxRound>=0)
{max=0;}
else
{max=maxRound;}
min=max-minimumRange;}}}
this._dataMaximum=max;this._dataMinimum=min;},_roundToNearest:function(number,nearest)
{nearest=nearest||1;var roundedNumber=Math.round(this._roundToPrecision(number / nearest,10))*nearest;return this._roundToPrecision(roundedNumber,10);},_roundUpToNearest:function(number,nearest)
{nearest=nearest||1;return Math.ceil(this._roundToPrecision(number / nearest,10))*nearest;},_roundDownToNearest:function(number,nearest)
{nearest=nearest||1;return Math.floor(this._roundToPrecision(number / nearest,10))*nearest;},_getCoordFromValue:function(min,max,length,dataValue,offset,reverse)
{var range,multiplier,valuecoord,isNumber=Y_Lang.isNumber;dataValue=parseFloat(dataValue);if(isNumber(dataValue))
{if(this.get("scaleType")==="logarithmic"&&min>0)
{min=Math.log(min);max=Math.log(max);dataValue=Math.log(dataValue);}
range=max-min;multiplier=length/range;valuecoord=(dataValue-min)*multiplier;valuecoord=reverse?offset-valuecoord:offset+valuecoord;}
else
{valuecoord=NaN;}
return valuecoord;},_roundToPrecision:function(number,precision)
{precision=precision||0;var decimalPlaces=Math.pow(10,precision);return Math.round(decimalPlaces*number)/ decimalPlaces;}};Y.NumericImpl=NumericImpl;Y.NumericAxisBase=Y.Base.create("numericAxisBase",Y.AxisBase,[Y.NumericImpl]);},'3.15.0',{"requires":["axis-base"]});