/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('axis-stacked-base',function(Y,NAME){function StackedImpl()
{}
StackedImpl.NAME="stackedImpl";StackedImpl.prototype={_type:"stacked",_updateMinAndMax:function()
{var max=0,min=0,pos=0,neg=0,len=0,i=0,key,num,keys=this.get("keys"),setMin=this.get("setMin"),setMax=this.get("setMax");for(key in keys)
{if(keys.hasOwnProperty(key))
{len=Math.max(len,keys[key].length);}}
for(;i<len;++i)
{pos=0;neg=0;for(key in keys)
{if(keys.hasOwnProperty(key))
{num=keys[key][i];if(isNaN(num))
{continue;}
if(num>=0)
{pos+=num;}
else
{neg+=num;}}}
if(pos>0)
{max=Math.max(max,pos);}
else
{max=Math.max(max,neg);}
if(neg<0)
{min=Math.min(min,neg);}
else
{min=Math.min(min,pos);}}
this._actualMaximum=max;this._actualMinimum=min;if(setMax)
{max=this._setMaximum;}
if(setMin)
{min=this._setMinimum;}
this._roundMinAndMax(min,max,setMin,setMax);}};Y.StackedImpl=StackedImpl;Y.StackedAxisBase=Y.Base.create("stackedAxisBase",Y.NumericAxisBase,[Y.StackedImpl]);},'3.15.0',{"requires":["axis-numeric-base"]});