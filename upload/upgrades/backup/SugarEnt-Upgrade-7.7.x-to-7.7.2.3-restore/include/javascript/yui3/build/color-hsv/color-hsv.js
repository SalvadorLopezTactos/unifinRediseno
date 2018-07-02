/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('color-hsv',function(Y,NAME){Color={REGEX_HSV:/hsva?\(([.\d]*), ?([.\d]*)%, ?([.\d]*)%,? ?([.\d]*)?\)/,STR_HSV:'hsv({*}, {*}%, {*}%)',STR_HSVA:'hsva({*}, {*}%, {*}%, {*})',toHSV:function(str){var clr=Y.Color._convertTo(str,'hsv');return clr.toLowerCase();},toHSVA:function(str){var clr=Y.Color._convertTo(str,'hsva');return clr.toLowerCase();},_rgbToHsv:function(str,toArray){var h,s,v,rgb=Y.Color.REGEX_RGB.exec(str),r=rgb[1]/ 255,g=rgb[2]/ 255,b=rgb[3]/ 255,max=Math.max(r,g,b),min=Math.min(r,g,b),delta=max-min;if(max===min){h=0;}else if(max===r){h=60*(g-b)/ delta;}else if(max===g){h=(60*(b-r)/ delta)+120;}else{h=(60*(r-g)/ delta)+240;}
s=(max===0)?0:1-(min / max);while(h<0){h+=360;}
h%=360;h=Math.round(h);s=Math.round(s*100);v=Math.round(max*100);if(toArray){return[h,s,v];}
return Y.Color.fromArray([h,s,v],Y.Color.TYPES.HSV);},_hsvToRgb:function(str,toArray){var hsv=Y.Color.REGEX_HSV.exec(str),h=parseInt(hsv[1],10),s=parseInt(hsv[2],10)/ 100,v=parseInt(hsv[3],10)/ 100,r,g,b,i=Math.floor(h / 60)%6,f=(h / 60)-i,p=v*(1-s),q=v*(1-(s*f)),t=v*(1-(s*(1-f)));if(s===0){r=v;g=v;b=v;}else{switch(i){case 0:r=v;g=t;b=p;break;case 1:r=q;g=v;b=p;break;case 2:r=p;g=v;b=t;break;case 3:r=p;g=q;b=v;break;case 4:r=t;g=p;b=v;break;case 5:r=v;g=p;b=q;break;}}
r=Math.min(255,Math.round(r*256));g=Math.min(255,Math.round(g*256));b=Math.min(255,Math.round(b*256));if(toArray){return[r,g,b];}
return Y.Color.fromArray([r,g,b],Y.Color.TYPES.RGB);}};Y.Color=Y.mix(Color,Y.Color);Y.Color.TYPES=Y.mix(Y.Color.TYPES,{'HSV':'hsv','HSVA':'hsva'});Y.Color.CONVERTS=Y.mix(Y.Color.CONVERTS,{'hsv':'toHSV','hsva':'toHSVA'});},'3.15.0',{"requires":["color-base"]});