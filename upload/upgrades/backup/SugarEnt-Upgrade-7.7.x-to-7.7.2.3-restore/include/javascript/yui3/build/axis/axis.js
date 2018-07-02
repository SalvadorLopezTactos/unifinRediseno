/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('axis',function(Y,NAME){var CONFIG=Y.config,DOCUMENT=CONFIG.doc,Y_Lang=Y.Lang,IS_STRING=Y_Lang.isString,Y_DOM=Y.DOM,LeftAxisLayout,RightAxisLayout,BottomAxisLayout,TopAxisLayout;LeftAxisLayout=function(){};LeftAxisLayout.prototype={_getDefaultMargins:function()
{return{top:0,left:0,right:4,bottom:0};},setTickOffsets:function()
{var host=this,majorTicks=host.get("styles").majorTicks,tickLength=majorTicks.length,halfTick=tickLength*0.5,display=majorTicks.display;host.set("topTickOffset",0);host.set("bottomTickOffset",0);switch(display)
{case"inside":host.set("rightTickOffset",tickLength);host.set("leftTickOffset",0);break;case"outside":host.set("rightTickOffset",0);host.set("leftTickOffset",tickLength);break;case"cross":host.set("rightTickOffset",halfTick);host.set("leftTickOffset",halfTick);break;default:host.set("rightTickOffset",0);host.set("leftTickOffset",0);break;}},drawTick:function(path,pt,tickStyles)
{var host=this,style=host.get("styles"),padding=style.padding,tickLength=tickStyles.length,start={x:padding.left,y:pt.y},end={x:tickLength+padding.left,y:pt.y};host.drawLine(path,start,end);},getLineStart:function()
{var style=this.get("styles"),padding=style.padding,majorTicks=style.majorTicks,tickLength=majorTicks.length,display=majorTicks.display,pt={x:padding.left,y:0};if(display==="outside")
{pt.x+=tickLength;}
else if(display==="cross")
{pt.x+=tickLength/2;}
return pt;},getLabelPoint:function(point)
{return{x:point.x-this.get("leftTickOffset"),y:point.y};},updateMaxLabelSize:function(labelWidth,labelHeight)
{var host=this,props=this._labelRotationProps,rot=props.rot,absRot=props.absRot,sinRadians=props.sinRadians,cosRadians=props.cosRadians,max;if(rot===0)
{max=labelWidth;}
else if(absRot===90)
{max=labelHeight;}
else
{max=(cosRadians*labelWidth)+(sinRadians*labelHeight);}
host._maxLabelSize=Math.max(host._maxLabelSize,max);},getExplicitlySized:function(styles)
{if(this._explicitWidth)
{var host=this,w=host._explicitWidth,totalTitleSize=host._totalTitleSize,leftTickOffset=host.get("leftTickOffset"),margin=styles.label.margin.right;host._maxLabelSize=w-(leftTickOffset+margin+totalTitleSize);return true;}
return false;},positionTitle:function(label)
{var host=this,bounds=host._titleBounds,margin=host.get("styles").title.margin,props=host._titleRotationProps,w=bounds.right-bounds.left,labelWidth=label.offsetWidth,labelHeight=label.offsetHeight,x=(labelWidth*-0.5)+(w*0.5),y=(host.get("height")*0.5)-(labelHeight*0.5);props.labelWidth=labelWidth;props.labelHeight=labelHeight;if(margin&&margin.left)
{x+=margin.left;}
props.x=x;props.y=y;props.transformOrigin=[0.5,0.5];host._rotate(label,props);},positionLabel:function(label,pt,styles,i)
{var host=this,offset=parseFloat(styles.label.offset),tickOffset=host.get("leftTickOffset"),totalTitleSize=this._totalTitleSize,leftOffset=pt.x+totalTitleSize-tickOffset,topOffset=pt.y,props=this._labelRotationProps,rot=props.rot,absRot=props.absRot,maxLabelSize=host._maxLabelSize,labelWidth=this._labelWidths[i],labelHeight=this._labelHeights[i];if(rot===0)
{leftOffset-=labelWidth;topOffset-=labelHeight*offset;}
else if(rot===90)
{leftOffset-=labelWidth*0.5;topOffset=topOffset+labelWidth/2-(labelWidth*offset);}
else if(rot===-90)
{leftOffset-=labelWidth*0.5;topOffset=topOffset-labelHeight+labelWidth/2-(labelWidth*offset);}
else
{leftOffset-=labelWidth+(labelHeight*absRot/360);topOffset-=labelHeight*offset;}
props.labelWidth=labelWidth;props.labelHeight=labelHeight;props.x=Math.round(maxLabelSize+leftOffset);props.y=Math.round(topOffset);this._rotate(label,props);},_setRotationCoords:function(props)
{var rot=props.rot,absRot=props.absRot,leftOffset,topOffset,labelWidth=props.labelWidth,labelHeight=props.labelHeight;if(rot===0)
{leftOffset=labelWidth;topOffset=labelHeight*0.5;}
else if(rot===90)
{topOffset=0;leftOffset=labelWidth*0.5;}
else if(rot===-90)
{leftOffset=labelWidth*0.5;topOffset=labelHeight;}
else
{leftOffset=labelWidth+(labelHeight*absRot/360);topOffset=labelHeight*0.5;}
props.x-=leftOffset;props.y-=topOffset;},_getTransformOrigin:function(rot)
{var transformOrigin;if(rot===0)
{transformOrigin=[0,0];}
else if(rot===90)
{transformOrigin=[0.5,0];}
else if(rot===-90)
{transformOrigin=[0.5,1];}
else
{transformOrigin=[1,0.5];}
return transformOrigin;},offsetNodeForTick:function()
{},setCalculatedSize:function()
{var host=this,graphic=this.get("graphic"),style=host.get("styles"),label=style.label,tickOffset=host.get("leftTickOffset"),max=host._maxLabelSize,totalTitleSize=this._totalTitleSize,ttl=Math.round(totalTitleSize+tickOffset+max+label.margin.right);if(this._explicitWidth)
{ttl=this._explicitWidth;}
this.set("calculatedWidth",ttl);graphic.set("x",ttl-tickOffset);}};Y.LeftAxisLayout=LeftAxisLayout;RightAxisLayout=function(){};RightAxisLayout.prototype={_getDefaultMargins:function()
{return{top:0,left:4,right:0,bottom:0};},setTickOffsets:function()
{var host=this,majorTicks=host.get("styles").majorTicks,tickLength=majorTicks.length,halfTick=tickLength*0.5,display=majorTicks.display;host.set("topTickOffset",0);host.set("bottomTickOffset",0);switch(display)
{case"inside":host.set("leftTickOffset",tickLength);host.set("rightTickOffset",0);break;case"outside":host.set("leftTickOffset",0);host.set("rightTickOffset",tickLength);break;case"cross":host.set("rightTickOffset",halfTick);host.set("leftTickOffset",halfTick);break;default:host.set("leftTickOffset",0);host.set("rightTickOffset",0);break;}},drawTick:function(path,pt,tickStyles)
{var host=this,style=host.get("styles"),padding=style.padding,tickLength=tickStyles.length,start={x:padding.left,y:pt.y},end={x:padding.left+tickLength,y:pt.y};host.drawLine(path,start,end);},getLineStart:function()
{var host=this,style=host.get("styles"),padding=style.padding,majorTicks=style.majorTicks,tickLength=majorTicks.length,display=majorTicks.display,pt={x:padding.left,y:padding.top};if(display==="inside")
{pt.x+=tickLength;}
else if(display==="cross")
{pt.x+=tickLength/2;}
return pt;},getLabelPoint:function(point)
{return{x:point.x+this.get("rightTickOffset"),y:point.y};},updateMaxLabelSize:function(labelWidth,labelHeight)
{var host=this,props=this._labelRotationProps,rot=props.rot,absRot=props.absRot,sinRadians=props.sinRadians,cosRadians=props.cosRadians,max;if(rot===0)
{max=labelWidth;}
else if(absRot===90)
{max=labelHeight;}
else
{max=(cosRadians*labelWidth)+(sinRadians*labelHeight);}
host._maxLabelSize=Math.max(host._maxLabelSize,max);},getExplicitlySized:function(styles)
{if(this._explicitWidth)
{var host=this,w=host._explicitWidth,totalTitleSize=this._totalTitleSize,rightTickOffset=host.get("rightTickOffset"),margin=styles.label.margin.right;host._maxLabelSize=w-(rightTickOffset+margin+totalTitleSize);return true;}
return false;},positionTitle:function(label)
{var host=this,bounds=host._titleBounds,margin=host.get("styles").title.margin,props=host._titleRotationProps,labelWidth=label.offsetWidth,labelHeight=label.offsetHeight,w=bounds.right-bounds.left,x=this.get("width")-(labelWidth*0.5)-(w*0.5),y=(host.get("height")*0.5)-(labelHeight*0.5);props.labelWidth=labelWidth;props.labelHeight=labelHeight;if(margin&&margin.right)
{x-=margin.left;}
props.x=x;props.y=y;props.transformOrigin=[0.5,0.5];host._rotate(label,props);},positionLabel:function(label,pt,styles,i)
{var host=this,offset=parseFloat(styles.label.offset),tickOffset=host.get("rightTickOffset"),labelStyles=styles.label,margin=0,leftOffset=pt.x,topOffset=pt.y,props=this._labelRotationProps,rot=props.rot,absRot=props.absRot,labelWidth=this._labelWidths[i],labelHeight=this._labelHeights[i];if(labelStyles.margin&&labelStyles.margin.left)
{margin=labelStyles.margin.left;}
if(rot===0)
{topOffset-=labelHeight*offset;}
else if(rot===90)
{leftOffset-=labelWidth*0.5;topOffset=topOffset-labelHeight+labelWidth/2-(labelWidth*offset);}
else if(rot===-90)
{topOffset=topOffset+labelWidth/2-(labelWidth*offset);leftOffset-=labelWidth*0.5;}
else
{topOffset-=labelHeight*offset;leftOffset+=labelHeight/2*absRot/90;}
leftOffset+=margin;leftOffset+=tickOffset;props.labelWidth=labelWidth;props.labelHeight=labelHeight;props.x=Math.round(leftOffset);props.y=Math.round(topOffset);this._rotate(label,props);},_setRotationCoords:function(props)
{var rot=props.rot,absRot=props.absRot,leftOffset=0,topOffset=0,labelWidth=props.labelWidth,labelHeight=props.labelHeight;if(rot===0)
{topOffset=labelHeight*0.5;}
else if(rot===90)
{leftOffset=labelWidth*0.5;topOffset=labelHeight;}
else if(rot===-90)
{leftOffset=labelWidth*0.5;}
else
{topOffset=labelHeight*0.5;leftOffset=labelHeight/2*absRot/90;}
props.x-=leftOffset;props.y-=topOffset;},_getTransformOrigin:function(rot)
{var transformOrigin;if(rot===0)
{transformOrigin=[0,0];}
else if(rot===90)
{transformOrigin=[0.5,1];}
else if(rot===-90)
{transformOrigin=[0.5,0];}
else
{transformOrigin=[0,0.5];}
return transformOrigin;},offsetNodeForTick:function(cb)
{var host=this,tickOffset=host.get("leftTickOffset"),offset=0-tickOffset;cb.setStyle("left",offset);},setCalculatedSize:function()
{var host=this,styles=host.get("styles"),labelStyle=styles.label,totalTitleSize=this._totalTitleSize,ttl=Math.round(host.get("rightTickOffset")+host._maxLabelSize+totalTitleSize+labelStyle.margin.left);if(this._explicitWidth)
{ttl=this._explicitWidth;}
host.set("calculatedWidth",ttl);host.get("contentBox").setStyle("width",ttl);}};Y.RightAxisLayout=RightAxisLayout;BottomAxisLayout=function(){};BottomAxisLayout.prototype={_getDefaultMargins:function()
{return{top:4,left:0,right:0,bottom:0};},setTickOffsets:function()
{var host=this,majorTicks=host.get("styles").majorTicks,tickLength=majorTicks.length,halfTick=tickLength*0.5,display=majorTicks.display;host.set("leftTickOffset",0);host.set("rightTickOffset",0);switch(display)
{case"inside":host.set("topTickOffset",tickLength);host.set("bottomTickOffset",0);break;case"outside":host.set("topTickOffset",0);host.set("bottomTickOffset",tickLength);break;case"cross":host.set("topTickOffset",halfTick);host.set("bottomTickOffset",halfTick);break;default:host.set("topTickOffset",0);host.set("bottomTickOffset",0);break;}},getLineStart:function()
{var style=this.get("styles"),padding=style.padding,majorTicks=style.majorTicks,tickLength=majorTicks.length,display=majorTicks.display,pt={x:0,y:padding.top};if(display==="inside")
{pt.y+=tickLength;}
else if(display==="cross")
{pt.y+=tickLength/2;}
return pt;},drawTick:function(path,pt,tickStyles)
{var host=this,style=host.get("styles"),padding=style.padding,tickLength=tickStyles.length,start={x:pt.x,y:padding.top},end={x:pt.x,y:tickLength+padding.top};host.drawLine(path,start,end);},getLabelPoint:function(point)
{return{x:point.x,y:point.y+this.get("bottomTickOffset")};},updateMaxLabelSize:function(labelWidth,labelHeight)
{var host=this,props=this._labelRotationProps,rot=props.rot,absRot=props.absRot,sinRadians=props.sinRadians,cosRadians=props.cosRadians,max;if(rot===0)
{max=labelHeight;}
else if(absRot===90)
{max=labelWidth;}
else
{max=(sinRadians*labelWidth)+(cosRadians*labelHeight);}
host._maxLabelSize=Math.max(host._maxLabelSize,max);},getExplicitlySized:function(styles)
{if(this._explicitHeight)
{var host=this,h=host._explicitHeight,totalTitleSize=host._totalTitleSize,bottomTickOffset=host.get("bottomTickOffset"),margin=styles.label.margin.right;host._maxLabelSize=h-(bottomTickOffset+margin+totalTitleSize);return true;}
return false;},positionTitle:function(label)
{var host=this,bounds=host._titleBounds,margin=host.get("styles").title.margin,props=host._titleRotationProps,h=bounds.bottom-bounds.top,labelWidth=label.offsetWidth,labelHeight=label.offsetHeight,x=(host.get("width")*0.5)-(labelWidth*0.5),y=host.get("height")-labelHeight/2-h/2;props.labelWidth=labelWidth;props.labelHeight=labelHeight;if(margin&&margin.bottom)
{y-=margin.bottom;}
props.x=x;props.y=y;props.transformOrigin=[0.5,0.5];host._rotate(label,props);},positionLabel:function(label,pt,styles,i)
{var host=this,offset=parseFloat(styles.label.offset),tickOffset=host.get("bottomTickOffset"),labelStyles=styles.label,margin=0,props=host._labelRotationProps,rot=props.rot,absRot=props.absRot,leftOffset=Math.round(pt.x),topOffset=Math.round(pt.y),labelWidth=host._labelWidths[i],labelHeight=host._labelHeights[i];if(labelStyles.margin&&labelStyles.margin.top)
{margin=labelStyles.margin.top;}
if(rot===90)
{topOffset-=labelHeight/2*rot/90;leftOffset=leftOffset+labelHeight/2-(labelHeight*offset);}
else if(rot===-90)
{topOffset-=labelHeight/2*absRot/90;leftOffset=leftOffset-labelWidth+labelHeight/2-(labelHeight*offset);}
else if(rot>0)
{leftOffset=leftOffset+labelHeight/2-(labelHeight*offset);topOffset-=labelHeight/2*rot/90;}
else if(rot<0)
{leftOffset=leftOffset-labelWidth+labelHeight/2-(labelHeight*offset);topOffset-=labelHeight/2*absRot/90;}
else
{leftOffset-=labelWidth*offset;}
topOffset+=margin;topOffset+=tickOffset;props.labelWidth=labelWidth;props.labelHeight=labelHeight;props.x=leftOffset;props.y=topOffset;host._rotate(label,props);},_setRotationCoords:function(props)
{var rot=props.rot,absRot=props.absRot,labelWidth=props.labelWidth,labelHeight=props.labelHeight,leftOffset,topOffset;if(rot>0)
{leftOffset=0;topOffset=labelHeight/2*rot/90;}
else if(rot<0)
{leftOffset=labelWidth;topOffset=labelHeight/2*absRot/90;}
else
{leftOffset=labelWidth*0.5;topOffset=0;}
props.x-=leftOffset;props.y-=topOffset;},_getTransformOrigin:function(rot)
{var transformOrigin;if(rot>0)
{transformOrigin=[0,0.5];}
else if(rot<0)
{transformOrigin=[1,0.5];}
else
{transformOrigin=[0,0];}
return transformOrigin;},offsetNodeForTick:function(cb)
{var host=this;cb.setStyle("top",0-host.get("topTickOffset"));},setCalculatedSize:function()
{var host=this,styles=host.get("styles"),labelStyle=styles.label,totalTitleSize=host._totalTitleSize,ttl=Math.round(host.get("bottomTickOffset")+host._maxLabelSize+labelStyle.margin.top+totalTitleSize);if(host._explicitHeight)
{ttl=host._explicitHeight;}
host.set("calculatedHeight",ttl);}};Y.BottomAxisLayout=BottomAxisLayout;TopAxisLayout=function(){};TopAxisLayout.prototype={_getDefaultMargins:function()
{return{top:0,left:0,right:0,bottom:4};},setTickOffsets:function()
{var host=this,majorTicks=host.get("styles").majorTicks,tickLength=majorTicks.length,halfTick=tickLength*0.5,display=majorTicks.display;host.set("leftTickOffset",0);host.set("rightTickOffset",0);switch(display)
{case"inside":host.set("bottomTickOffset",tickLength);host.set("topTickOffset",0);break;case"outside":host.set("bottomTickOffset",0);host.set("topTickOffset",tickLength);break;case"cross":host.set("topTickOffset",halfTick);host.set("bottomTickOffset",halfTick);break;default:host.set("topTickOffset",0);host.set("bottomTickOffset",0);break;}},getLineStart:function()
{var host=this,style=host.get("styles"),padding=style.padding,majorTicks=style.majorTicks,tickLength=majorTicks.length,display=majorTicks.display,pt={x:0,y:padding.top};if(display==="outside")
{pt.y+=tickLength;}
else if(display==="cross")
{pt.y+=tickLength/2;}
return pt;},drawTick:function(path,pt,tickStyles)
{var host=this,style=host.get("styles"),padding=style.padding,tickLength=tickStyles.length,start={x:pt.x,y:padding.top},end={x:pt.x,y:tickLength+padding.top};host.drawLine(path,start,end);},getLabelPoint:function(pt)
{return{x:pt.x,y:pt.y-this.get("topTickOffset")};},updateMaxLabelSize:function(labelWidth,labelHeight)
{var host=this,props=this._labelRotationProps,rot=props.rot,absRot=props.absRot,sinRadians=props.sinRadians,cosRadians=props.cosRadians,max;if(rot===0)
{max=labelHeight;}
else if(absRot===90)
{max=labelWidth;}
else
{max=(sinRadians*labelWidth)+(cosRadians*labelHeight);}
host._maxLabelSize=Math.max(host._maxLabelSize,max);},getExplicitlySized:function(styles)
{if(this._explicitHeight)
{var host=this,h=host._explicitHeight,totalTitleSize=host._totalTitleSize,topTickOffset=host.get("topTickOffset"),margin=styles.label.margin.right;host._maxLabelSize=h-(topTickOffset+margin+totalTitleSize);return true;}
return false;},positionTitle:function(label)
{var host=this,bounds=host._titleBounds,margin=host.get("styles").title.margin,props=host._titleRotationProps,labelWidth=label.offsetWidth,labelHeight=label.offsetHeight,h=bounds.bottom-bounds.top,x=(host.get("width")*0.5)-(labelWidth*0.5),y=h/2-labelHeight/2;props.labelWidth=labelWidth;props.labelHeight=labelHeight;if(margin&&margin.top)
{y+=margin.top;}
props.x=x;props.y=y;props.transformOrigin=[0.5,0.5];host._rotate(label,props);},positionLabel:function(label,pt,styles,i)
{var host=this,offset=parseFloat(styles.label.offset),totalTitleSize=this._totalTitleSize,maxLabelSize=host._maxLabelSize,leftOffset=pt.x,topOffset=pt.y+totalTitleSize+maxLabelSize,props=this._labelRotationProps,rot=props.rot,absRot=props.absRot,labelWidth=this._labelWidths[i],labelHeight=this._labelHeights[i];if(rot===0)
{leftOffset-=labelWidth*offset;topOffset-=labelHeight;}
else
{if(rot===90)
{leftOffset=leftOffset-labelWidth+labelHeight/2-(labelHeight*offset);topOffset-=(labelHeight*0.5);}
else if(rot===-90)
{leftOffset=leftOffset+labelHeight/2-(labelHeight*offset);topOffset-=(labelHeight*0.5);}
else if(rot>0)
{leftOffset=leftOffset-labelWidth+labelHeight/2-(labelHeight*offset);topOffset-=labelHeight-(labelHeight*rot/180);}
else
{leftOffset=leftOffset+labelHeight/2-(labelHeight*offset);topOffset-=labelHeight-(labelHeight*absRot/180);}}
props.x=Math.round(leftOffset);props.y=Math.round(topOffset);props.labelWidth=labelWidth;props.labelHeight=labelHeight;this._rotate(label,props);},_setRotationCoords:function(props)
{var rot=props.rot,absRot=props.absRot,labelWidth=props.labelWidth,labelHeight=props.labelHeight,leftOffset,topOffset;if(rot===0)
{leftOffset=labelWidth*0.5;topOffset=labelHeight;}
else
{if(rot===90)
{leftOffset=labelWidth;topOffset=(labelHeight*0.5);}
else if(rot===-90)
{topOffset=(labelHeight*0.5);}
else if(rot>0)
{leftOffset=labelWidth;topOffset=labelHeight-(labelHeight*rot/180);}
else
{topOffset=labelHeight-(labelHeight*absRot/180);}}
props.x-=leftOffset;props.y-=topOffset;},_getTransformOrigin:function(rot)
{var transformOrigin;if(rot===0)
{transformOrigin=[0,0];}
else
{if(rot===90)
{transformOrigin=[1,0.5];}
else if(rot===-90)
{transformOrigin=[0,0.5];}
else if(rot>0)
{transformOrigin=[1,0.5];}
else
{transformOrigin=[0,0.5];}}
return transformOrigin;},offsetNodeForTick:function()
{},setCalculatedSize:function()
{var host=this,graphic=host.get("graphic"),styles=host.get("styles"),labelMargin=styles.label.margin,totalLabelSize=labelMargin.bottom+host._maxLabelSize,totalTitleSize=host._totalTitleSize,topTickOffset=this.get("topTickOffset"),ttl=Math.round(topTickOffset+totalLabelSize+totalTitleSize);if(this._explicitHeight)
{ttl=this._explicitHeight;}
host.set("calculatedHeight",ttl);graphic.set("y",ttl-topTickOffset);}};Y.TopAxisLayout=TopAxisLayout;Y.Axis=Y.Base.create("axis",Y.Widget,[Y.AxisBase],{getLabelByIndex:function(i,l)
{var position=this.get("position"),direction=position==="left"||position==="right"?"vertical":"horizontal";return this._getLabelByIndex(i,l,direction);},bindUI:function()
{this.after("dataReady",Y.bind(this._dataChangeHandler,this));this.after("dataUpdate",Y.bind(this._dataChangeHandler,this));this.after("stylesChange",this._updateHandler);this.after("overlapGraphChange",this._updateHandler);this.after("positionChange",this._positionChangeHandler);this.after("widthChange",this._handleSizeChange);this.after("heightChange",this._handleSizeChange);this.after("calculatedWidthChange",this._handleSizeChange);this.after("calculatedHeightChange",this._handleSizeChange);},_calculatedWidth:0,_calculatedHeight:0,_dataChangeHandler:function()
{if(this.get("rendered"))
{this._drawAxis();}},_positionChangeHandler:function(e)
{this._updateGraphic(e.newVal);this._updateHandler();},_updateGraphic:function(position)
{var graphic=this.get("graphic");if(position==="none")
{if(graphic)
{graphic.destroy();}}
else
{if(!graphic)
{this._setCanvas();}}},_updateHandler:function()
{if(this.get("rendered"))
{this._drawAxis();}},renderUI:function()
{this._updateGraphic(this.get("position"));},syncUI:function()
{var layout=this._layout,defaultMargins,styles,label,title,i;if(layout)
{defaultMargins=layout._getDefaultMargins();styles=this.get("styles");label=styles.label.margin;title=styles.title.margin;for(i in defaultMargins)
{if(defaultMargins.hasOwnProperty(i))
{label[i]=label[i]===undefined?defaultMargins[i]:label[i];title[i]=title[i]===undefined?defaultMargins[i]:title[i];}}}
this._drawAxis();},_setCanvas:function()
{var cb=this.get("contentBox"),bb=this.get("boundingBox"),p=this.get("position"),pn=this._parentNode,w=this.get("width"),h=this.get("height");bb.setStyle("position","absolute");bb.setStyle("zIndex",2);w=w?w+"px":pn.getStyle("width");h=h?h+"px":pn.getStyle("height");if(p==="top"||p==="bottom")
{cb.setStyle("width",w);}
else
{cb.setStyle("height",h);}
cb.setStyle("position","relative");cb.setStyle("left","0px");cb.setStyle("top","0px");this.set("graphic",new Y.Graphic());this.get("graphic").render(cb);},_getDefaultStyles:function()
{var axisstyles={majorTicks:{display:"inside",length:4,color:"#dad8c9",weight:1,alpha:1},minorTicks:{display:"none",length:2,color:"#dad8c9",weight:1},line:{weight:1,color:"#dad8c9",alpha:1},majorUnit:{determinant:"count",count:11,distance:75},top:"0px",left:"0px",width:"100px",height:"100px",label:{color:"#808080",alpha:1,fontSize:"85%",rotation:0,offset:0.5,margin:{top:undefined,right:undefined,bottom:undefined,left:undefined}},title:{color:"#808080",alpha:1,fontSize:"85%",rotation:undefined,margin:{top:undefined,right:undefined,bottom:undefined,left:undefined}},hideOverlappingLabelTicks:false};return Y.merge(Y.Renderer.prototype._getDefaultStyles(),axisstyles);},_handleSizeChange:function(e)
{var attrName=e.attrName,pos=this.get("position"),vert=pos==="left"||pos==="right",cb=this.get("contentBox"),hor=pos==="bottom"||pos==="top";cb.setStyle("width",this.get("width"));cb.setStyle("height",this.get("height"));if((hor&&attrName==="width")||(vert&&attrName==="height"))
{this._drawAxis();}},_layoutClasses:{top:TopAxisLayout,bottom:BottomAxisLayout,left:LeftAxisLayout,right:RightAxisLayout},drawLine:function(path,startPoint,endPoint)
{path.moveTo(startPoint.x,startPoint.y);path.lineTo(endPoint.x,endPoint.y);},_getTextRotationProps:function(styles)
{if(styles.rotation===undefined)
{switch(this.get("position"))
{case"left":styles.rotation=-90;break;case"right":styles.rotation=90;break;default:styles.rotation=0;break;}}
var rot=Math.min(90,Math.max(-90,styles.rotation)),absRot=Math.abs(rot),radCon=Math.PI/180,sinRadians=parseFloat(parseFloat(Math.sin(absRot*radCon)).toFixed(8)),cosRadians=parseFloat(parseFloat(Math.cos(absRot*radCon)).toFixed(8));return{rot:rot,absRot:absRot,radCon:radCon,sinRadians:sinRadians,cosRadians:cosRadians,textAlpha:styles.alpha};},_drawAxis:function()
{if(this._drawing)
{this._callLater=true;return;}
this._drawing=true;this._callLater=false;if(this._layout)
{var styles=this.get("styles"),line=styles.line,labelStyles=styles.label,majorTickStyles=styles.majorTicks,drawTicks=majorTickStyles.display!=="none",len,i=0,layout=this._layout,layoutLength,lineStart,label,labelWidth,labelHeight,labelFunction=this.get("labelFunction"),labelFunctionScope=this.get("labelFunctionScope"),labelFormat=this.get("labelFormat"),graphic=this.get("graphic"),path=this.get("path"),tickPath,explicitlySized,position=this.get("position"),labelData,labelValues,point,points,firstPoint,lastPoint,firstLabel,lastLabel,staticCoord,dynamicCoord,edgeOffset,explicitLabels=this._labelValuesExplicitlySet?this.get("labelValues"):null,direction=(position==="left"||position==="right")?"vertical":"horizontal";this._labelWidths=[];this._labelHeights=[];graphic.set("autoDraw",false);path.clear();path.set("stroke",{weight:line.weight,color:line.color,opacity:line.alpha});this._labelRotationProps=this._getTextRotationProps(labelStyles);this._labelRotationProps.transformOrigin=layout._getTransformOrigin(this._labelRotationProps.rot);layout.setTickOffsets.apply(this);layoutLength=this.getLength();len=this.getTotalMajorUnits();edgeOffset=this.getEdgeOffset(len,layoutLength);this.set("edgeOffset",edgeOffset);lineStart=layout.getLineStart.apply(this);if(direction==="vertical")
{staticCoord="x";dynamicCoord="y";}
else
{staticCoord="y";dynamicCoord="x";}
labelData=this._getLabelData(lineStart[staticCoord],staticCoord,dynamicCoord,this.get("minimum"),this.get("maximum"),edgeOffset,layoutLength-edgeOffset-edgeOffset,len,explicitLabels);points=labelData.points;labelValues=labelData.values;len=points.length;if(!this._labelValuesExplicitlySet)
{this.set("labelValues",labelValues,{src:"internal"});}
if(this.get("hideFirstMajorUnit"))
{firstPoint=points.shift();firstLabel=labelValues.shift();len=len-1;}
if(this.get("hideLastMajorUnit"))
{lastPoint=points.pop();lastLabel=labelValues.pop();len=len-1;}
if(len<1)
{this._clearLabelCache();}
else
{this.drawLine(path,lineStart,this.getLineEnd(lineStart));if(drawTicks)
{tickPath=this.get("tickPath");tickPath.clear();tickPath.set("stroke",{weight:majorTickStyles.weight,color:majorTickStyles.color,opacity:majorTickStyles.alpha});for(i=0;i<len;i=i+1)
{point=points[i];if(point)
{layout.drawTick.apply(this,[tickPath,points[i],majorTickStyles]);}}}
this._createLabelCache();this._maxLabelSize=0;this._totalTitleSize=0;this._titleSize=0;this._setTitle();explicitlySized=layout.getExplicitlySized.apply(this,[styles]);for(i=0;i<len;i=i+1)
{point=points[i];if(point)
{label=this.getLabel(labelStyles);this._labels.push(label);this.get("appendLabelFunction")(label,labelFunction.apply(labelFunctionScope,[labelValues[i],labelFormat]));labelWidth=Math.round(label.offsetWidth);labelHeight=Math.round(label.offsetHeight);if(!explicitlySized)
{this._layout.updateMaxLabelSize.apply(this,[labelWidth,labelHeight]);}
this._labelWidths.push(labelWidth);this._labelHeights.push(labelHeight);}}
this._clearLabelCache();if(this.get("overlapGraph"))
{layout.offsetNodeForTick.apply(this,[this.get("contentBox")]);}
layout.setCalculatedSize.apply(this);if(this._titleTextField)
{this._layout.positionTitle.apply(this,[this._titleTextField]);}
len=this._labels.length;for(i=0;i<len;++i)
{layout.positionLabel.apply(this,[this.get("labels")[i],points[i],styles,i]);}
if(firstPoint)
{points.unshift(firstPoint);}
if(lastPoint)
{points.push(lastPoint);}
if(firstLabel)
{labelValues.unshift(firstLabel);}
if(lastLabel)
{labelValues.push(lastLabel);}
this._tickPoints=points;}}
this._drawing=false;if(this._callLater)
{this._drawAxis();}
else
{this._updatePathElement();this.fire("axisRendered");}},_setTotalTitleSize:function(styles)
{var title=this._titleTextField,w=title.offsetWidth,h=title.offsetHeight,rot=this._titleRotationProps.rot,bounds,size,margin=styles.margin,position=this.get("position"),matrix=new Y.Matrix();matrix.rotate(rot);bounds=matrix.getContentRect(w,h);if(position==="left"||position==="right")
{size=bounds.right-bounds.left;if(margin)
{size+=margin.left+margin.right;}}
else
{size=bounds.bottom-bounds.top;if(margin)
{size+=margin.top+margin.bottom;}}
this._titleBounds=bounds;this._totalTitleSize=size;},_updatePathElement:function()
{var path=this._path,tickPath=this._tickPath,redrawGraphic=false,graphic=this.get("graphic");if(path)
{redrawGraphic=true;path.end();}
if(tickPath)
{redrawGraphic=true;tickPath.end();}
if(redrawGraphic)
{graphic._redraw();}},_setTitle:function()
{var i,styles,customStyles,title=this.get("title"),titleTextField=this._titleTextField,parentNode;if(title!==null&&title!==undefined)
{customStyles={rotation:"rotation",margin:"margin",alpha:"alpha"};styles=this.get("styles").title;if(!titleTextField)
{titleTextField=DOCUMENT.createElement('span');titleTextField.style.display="block";titleTextField.style.whiteSpace="nowrap";titleTextField.setAttribute("class","axisTitle");this.get("contentBox").append(titleTextField);}
else if(!DOCUMENT.createElementNS)
{if(titleTextField.style.filter)
{titleTextField.style.filter=null;}}
titleTextField.style.position="absolute";for(i in styles)
{if(styles.hasOwnProperty(i)&&!customStyles.hasOwnProperty(i))
{titleTextField.style[i]=styles[i];}}
this.get("appendTitleFunction")(titleTextField,title);this._titleTextField=titleTextField;this._titleRotationProps=this._getTextRotationProps(styles);this._setTotalTitleSize(styles);}
else if(titleTextField)
{parentNode=titleTextField.parentNode;if(parentNode)
{parentNode.removeChild(titleTextField);}
this._titleTextField=null;this._totalTitleSize=0;}},getLabel:function(styles)
{var i,label,labelCache=this._labelCache,customStyles={rotation:"rotation",margin:"margin",alpha:"alpha"};if(labelCache&&labelCache.length>0)
{label=labelCache.shift();}
else
{label=DOCUMENT.createElement("span");label.className=Y.Lang.trim([label.className,"axisLabel"].join(' '));this.get("contentBox").append(label);}
if(!DOCUMENT.createElementNS)
{if(label.style.filter)
{label.style.filter=null;}}
label.style.display="block";label.style.whiteSpace="nowrap";label.style.position="absolute";for(i in styles)
{if(styles.hasOwnProperty(i)&&!customStyles.hasOwnProperty(i))
{label.style[i]=styles[i];}}
return label;},_createLabelCache:function()
{if(this._labels)
{while(this._labels.length>0)
{this._labelCache.push(this._labels.shift());}}
else
{this._clearLabelCache();}
this._labels=[];},_clearLabelCache:function()
{if(this._labelCache)
{var len=this._labelCache.length,i=0,label;for(;i<len;++i)
{label=this._labelCache[i];this._removeChildren(label);Y.Event.purgeElement(label,true);label.parentNode.removeChild(label);}}
this._labelCache=[];},getLineEnd:function(pt)
{var w=this.get("width"),h=this.get("height"),pos=this.get("position");if(pos==="top"||pos==="bottom")
{return{x:w,y:pt.y};}
else
{return{x:pt.x,y:h};}},getLength:function()
{var l,style=this.get("styles"),padding=style.padding,w=this.get("width"),h=this.get("height"),pos=this.get("position");if(pos==="top"||pos==="bottom")
{l=w-(padding.left+padding.right);}
else
{l=h-(padding.top+padding.bottom);}
return l;},getFirstPoint:function(pt)
{var style=this.get("styles"),pos=this.get("position"),padding=style.padding,np={x:pt.x,y:pt.y};if(pos==="top"||pos==="bottom")
{np.x+=padding.left+this.get("edgeOffset");}
else
{np.y+=this.get("height")-(padding.top+this.get("edgeOffset"));}
return np;},_rotate:function(label,props)
{var rot=props.rot,x=props.x,y=props.y,filterString,textAlpha,matrix=new Y.Matrix(),transformOrigin=props.transformOrigin||[0,0],offsetRect;if(DOCUMENT.createElementNS)
{matrix.translate(x,y);matrix.rotate(rot);Y_DOM.setStyle(label,"transformOrigin",(transformOrigin[0]*100)+"% "+(transformOrigin[1]*100)+"%");Y_DOM.setStyle(label,"transform",matrix.toCSSText());}
else
{textAlpha=props.textAlpha;if(Y_Lang.isNumber(textAlpha)&&textAlpha<1&&textAlpha>-1&&!isNaN(textAlpha))
{filterString="progid:DXImageTransform.Microsoft.Alpha(Opacity="+Math.round(textAlpha*100)+")";}
if(rot!==0)
{matrix.rotate(rot);offsetRect=matrix.getContentRect(props.labelWidth,props.labelHeight);matrix.init();matrix.translate(offsetRect.left,offsetRect.top);matrix.translate(x,y);this._simulateRotateWithTransformOrigin(matrix,rot,transformOrigin,props.labelWidth,props.labelHeight);if(filterString)
{filterString+=" ";}
else
{filterString="";}
filterString+=matrix.toFilterText();label.style.left=matrix.dx+"px";label.style.top=matrix.dy+"px";}
else
{label.style.left=x+"px";label.style.top=y+"px";}
if(filterString)
{label.style.filter=filterString;}}},_simulateRotateWithTransformOrigin:function(matrix,rot,transformOrigin,w,h)
{var transformX=transformOrigin[0]*w,transformY=transformOrigin[1]*h;transformX=!isNaN(transformX)?transformX:0;transformY=!isNaN(transformY)?transformY:0;matrix.translate(transformX,transformY);matrix.rotate(rot);matrix.translate(-transformX,-transformY);},getMaxLabelBounds:function()
{return this._getLabelBounds(this.getMaximumValue());},getMinLabelBounds:function()
{return this._getLabelBounds(this.getMinimumValue());},_getLabelBounds:function(val)
{var layout=this._layout,labelStyles=this.get("styles").label,matrix=new Y.Matrix(),label,props=this._getTextRotationProps(labelStyles);props.transformOrigin=layout._getTransformOrigin(props.rot);label=this.getLabel(labelStyles);this.get("appendLabelFunction")(label,this.get("labelFunction").apply(this,[val,this.get("labelFormat")]));props.labelWidth=label.offsetWidth;props.labelHeight=label.offsetHeight;this._removeChildren(label);Y.Event.purgeElement(label,true);label.parentNode.removeChild(label);props.x=0;props.y=0;layout._setRotationCoords(props);matrix.translate(props.x,props.y);this._simulateRotateWithTransformOrigin(matrix,props.rot,props.transformOrigin,props.labelWidth,props.labelHeight);return matrix.getContentRect(props.labelWidth,props.labelHeight);},_removeChildren:function(node)
{if(node.hasChildNodes())
{var child;while(node.firstChild)
{child=node.firstChild;this._removeChildren(child);node.removeChild(child);}}},destructor:function()
{var cb=this.get("contentBox").getDOMNode(),labels=this.get("labels"),graphic=this.get("graphic"),label,len=labels?labels.length:0;if(len>0)
{while(labels.length>0)
{label=labels.shift();this._removeChildren(label);cb.removeChild(label);label=null;}}
if(graphic)
{graphic.destroy();}},_maxLabelSize:0,_setText:function(textField,val)
{textField.innerHTML="";if(Y_Lang.isNumber(val))
{val=val+"";}
else if(!val)
{val="";}
if(IS_STRING(val))
{val=DOCUMENT.createTextNode(val);}
textField.appendChild(val);},getTotalMajorUnits:function()
{var units,majorUnit=this.get("styles").majorUnit,len;if(majorUnit.determinant==="count")
{units=majorUnit.count;}
else if(majorUnit.determinant==="distance")
{len=this.getLength();units=(len/majorUnit.distance)+1;}
return units;},getMajorUnitDistance:function(len,uiLen,majorUnit)
{var dist;if(majorUnit.determinant==="count")
{if(!this.get("calculateEdgeOffset"))
{len=len-1;}
dist=uiLen/len;}
else if(majorUnit.determinant==="distance")
{dist=majorUnit.distance;}
return dist;},_hasDataOverflow:function()
{if(this.get("setMin")||this.get("setMax"))
{return true;}
return false;},getMinimumValue:function()
{return this.get("minimum");},getMaximumValue:function()
{return this.get("maximum");}},{ATTRS:{width:{lazyAdd:false,getter:function()
{if(this._explicitWidth)
{return this._explicitWidth;}
return this._calculatedWidth;},setter:function(val)
{this._explicitWidth=val;return val;}},height:{lazyAdd:false,getter:function()
{if(this._explicitHeight)
{return this._explicitHeight;}
return this._calculatedHeight;},setter:function(val)
{this._explicitHeight=val;return val;}},calculatedWidth:{getter:function()
{return this._calculatedWidth;},setter:function(val)
{this._calculatedWidth=val;return val;}},calculatedHeight:{getter:function()
{return this._calculatedHeight;},setter:function(val)
{this._calculatedHeight=val;return val;}},edgeOffset:{value:0},graphic:{},path:{readOnly:true,getter:function()
{if(!this._path)
{var graphic=this.get("graphic");if(graphic)
{this._path=graphic.addShape({type:"path"});}}
return this._path;}},tickPath:{readOnly:true,getter:function()
{if(!this._tickPath)
{var graphic=this.get("graphic");if(graphic)
{this._tickPath=graphic.addShape({type:"path"});}}
return this._tickPath;}},node:{},position:{lazyAdd:false,setter:function(val)
{var LayoutClass=this._layoutClasses[val];if(val&&val!=="none")
{this._layout=new LayoutClass();}
return val;}},topTickOffset:{value:0},bottomTickOffset:{value:0},leftTickOffset:{value:0},rightTickOffset:{value:0},labels:{readOnly:true,getter:function()
{return this._labels;}},tickPoints:{readOnly:true,getter:function()
{if(this.get("position")==="none")
{return this.get("styles").majorUnit.count;}
return this._tickPoints;}},overlapGraph:{value:true,validator:function(val)
{return Y_Lang.isBoolean(val);}},maxLabelSize:{getter:function()
{return this._maxLabelSize;},setter:function(val)
{this._maxLabelSize=val;return val;}},title:{value:null},appendLabelFunction:{valueFn:function()
{return this._setText;}},appendTitleFunction:{valueFn:function()
{return this._setText;}},labelValues:{lazyAdd:false,setter:function(val)
{var opts=arguments[2];if(!val||(opts&&opts.src&&opts.src==="internal"))
{this._labelValuesExplicitlySet=false;}
else
{this._labelValuesExplicitlySet=true;}
return val;}},hideFirstMajorUnit:{value:false},hideLastMajorUnit:{value:false}}});Y.AxisType=Y.Base.create("baseAxis",Y.Axis,[],{});},'3.15.0',{"requires":["dom","widget","widget-position","widget-stack","graphics","axis-base"]});