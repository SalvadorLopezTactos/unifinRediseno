/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('event-simulate',function(Y,NAME){(function(){var L=Y.Lang,win=Y.config.win,isFunction=L.isFunction,isString=L.isString,isBoolean=L.isBoolean,isObject=L.isObject,isNumber=L.isNumber,mouseEvents={click:1,dblclick:1,mouseover:1,mouseout:1,mousedown:1,mouseup:1,mousemove:1,contextmenu:1},pointerEvents=(win&&win.PointerEvent)?{pointerover:1,pointerout:1,pointerdown:1,pointerup:1,pointermove:1}:{MSPointerOver:1,MSPointerOut:1,MSPointerDown:1,MSPointerUp:1,MSPointerMove:1},keyEvents={keydown:1,keyup:1,keypress:1},uiEvents={submit:1,blur:1,change:1,focus:1,resize:1,scroll:1,select:1},bubbleEvents={scroll:1,resize:1,reset:1,submit:1,change:1,select:1,error:1,abort:1},touchEvents={touchstart:1,touchmove:1,touchend:1,touchcancel:1},gestureEvents={gesturestart:1,gesturechange:1,gestureend:1};Y.mix(bubbleEvents,mouseEvents);Y.mix(bubbleEvents,keyEvents);Y.mix(bubbleEvents,touchEvents);function simulateKeyEvent(target,type,bubbles,cancelable,view,ctrlKey,altKey,shiftKey,metaKey,keyCode,charCode)
{if(!target){Y.error("simulateKeyEvent(): Invalid target.");}
if(isString(type)){type=type.toLowerCase();switch(type){case"textevent":type="keypress";break;case"keyup":case"keydown":case"keypress":break;default:Y.error("simulateKeyEvent(): Event type '"+type+"' not supported.");}}else{Y.error("simulateKeyEvent(): Event type must be a string.");}
if(!isBoolean(bubbles)){bubbles=true;}
if(!isBoolean(cancelable)){cancelable=true;}
if(!isObject(view)){view=Y.config.win;}
if(!isBoolean(ctrlKey)){ctrlKey=false;}
if(!isBoolean(altKey)){altKey=false;}
if(!isBoolean(shiftKey)){shiftKey=false;}
if(!isBoolean(metaKey)){metaKey=false;}
if(!isNumber(keyCode)){keyCode=0;}
if(!isNumber(charCode)){charCode=0;}
var customEvent=null;if(isFunction(Y.config.doc.createEvent)){try{customEvent=Y.config.doc.createEvent("KeyEvents");customEvent.initKeyEvent(type,bubbles,cancelable,view,ctrlKey,altKey,shiftKey,metaKey,keyCode,charCode);}catch(ex){try{customEvent=Y.config.doc.createEvent("Events");}catch(uierror){customEvent=Y.config.doc.createEvent("UIEvents");}finally{customEvent.initEvent(type,bubbles,cancelable);customEvent.view=view;customEvent.altKey=altKey;customEvent.ctrlKey=ctrlKey;customEvent.shiftKey=shiftKey;customEvent.metaKey=metaKey;customEvent.keyCode=keyCode;customEvent.charCode=charCode;}}
target.dispatchEvent(customEvent);}else if(isObject(Y.config.doc.createEventObject)){customEvent=Y.config.doc.createEventObject();customEvent.bubbles=bubbles;customEvent.cancelable=cancelable;customEvent.view=view;customEvent.ctrlKey=ctrlKey;customEvent.altKey=altKey;customEvent.shiftKey=shiftKey;customEvent.metaKey=metaKey;customEvent.keyCode=(charCode>0)?charCode:keyCode;target.fireEvent("on"+type,customEvent);}else{Y.error("simulateKeyEvent(): No event simulation framework present.");}}
function simulateMouseEvent(target,type,bubbles,cancelable,view,detail,screenX,screenY,clientX,clientY,ctrlKey,altKey,shiftKey,metaKey,button,relatedTarget)
{if(!target){Y.error("simulateMouseEvent(): Invalid target.");}
if(isString(type)){if(!mouseEvents[type.toLowerCase()]&&!pointerEvents[type]){Y.error("simulateMouseEvent(): Event type '"+type+"' not supported.");}}
else{Y.error("simulateMouseEvent(): Event type must be a string.");}
if(!isBoolean(bubbles)){bubbles=true;}
if(!isBoolean(cancelable)){cancelable=(type!=="mousemove");}
if(!isObject(view)){view=Y.config.win;}
if(!isNumber(detail)){detail=1;}
if(!isNumber(screenX)){screenX=0;}
if(!isNumber(screenY)){screenY=0;}
if(!isNumber(clientX)){clientX=0;}
if(!isNumber(clientY)){clientY=0;}
if(!isBoolean(ctrlKey)){ctrlKey=false;}
if(!isBoolean(altKey)){altKey=false;}
if(!isBoolean(shiftKey)){shiftKey=false;}
if(!isBoolean(metaKey)){metaKey=false;}
if(!isNumber(button)){button=0;}
relatedTarget=relatedTarget||null;var customEvent=null;if(isFunction(Y.config.doc.createEvent)){customEvent=Y.config.doc.createEvent("MouseEvents");if(customEvent.initMouseEvent){customEvent.initMouseEvent(type,bubbles,cancelable,view,detail,screenX,screenY,clientX,clientY,ctrlKey,altKey,shiftKey,metaKey,button,relatedTarget);}else{customEvent=Y.config.doc.createEvent("UIEvents");customEvent.initEvent(type,bubbles,cancelable);customEvent.view=view;customEvent.detail=detail;customEvent.screenX=screenX;customEvent.screenY=screenY;customEvent.clientX=clientX;customEvent.clientY=clientY;customEvent.ctrlKey=ctrlKey;customEvent.altKey=altKey;customEvent.metaKey=metaKey;customEvent.shiftKey=shiftKey;customEvent.button=button;customEvent.relatedTarget=relatedTarget;}
if(relatedTarget&&!customEvent.relatedTarget){if(type==="mouseout"){customEvent.toElement=relatedTarget;}else if(type==="mouseover"){customEvent.fromElement=relatedTarget;}}
target.dispatchEvent(customEvent);}else if(isObject(Y.config.doc.createEventObject)){customEvent=Y.config.doc.createEventObject();customEvent.bubbles=bubbles;customEvent.cancelable=cancelable;customEvent.view=view;customEvent.detail=detail;customEvent.screenX=screenX;customEvent.screenY=screenY;customEvent.clientX=clientX;customEvent.clientY=clientY;customEvent.ctrlKey=ctrlKey;customEvent.altKey=altKey;customEvent.metaKey=metaKey;customEvent.shiftKey=shiftKey;switch(button){case 0:customEvent.button=1;break;case 1:customEvent.button=4;break;case 2:break;default:customEvent.button=0;}
customEvent.relatedTarget=relatedTarget;target.fireEvent("on"+type,customEvent);}else{Y.error("simulateMouseEvent(): No event simulation framework present.");}}
function simulateUIEvent(target,type,bubbles,cancelable,view,detail)
{if(!target){Y.error("simulateUIEvent(): Invalid target.");}
if(isString(type)){type=type.toLowerCase();if(!uiEvents[type]){Y.error("simulateUIEvent(): Event type '"+type+"' not supported.");}}else{Y.error("simulateUIEvent(): Event type must be a string.");}
var customEvent=null;if(!isBoolean(bubbles)){bubbles=(type in bubbleEvents);}
if(!isBoolean(cancelable)){cancelable=(type==="submit");}
if(!isObject(view)){view=Y.config.win;}
if(!isNumber(detail)){detail=1;}
if(isFunction(Y.config.doc.createEvent)){customEvent=Y.config.doc.createEvent("UIEvents");customEvent.initUIEvent(type,bubbles,cancelable,view,detail);target.dispatchEvent(customEvent);}else if(isObject(Y.config.doc.createEventObject)){customEvent=Y.config.doc.createEventObject();customEvent.bubbles=bubbles;customEvent.cancelable=cancelable;customEvent.view=view;customEvent.detail=detail;target.fireEvent("on"+type,customEvent);}else{Y.error("simulateUIEvent(): No event simulation framework present.");}}
function simulateGestureEvent(target,type,bubbles,cancelable,view,detail,screenX,screenY,clientX,clientY,ctrlKey,altKey,shiftKey,metaKey,scale,rotation){var customEvent;if(!Y.UA.ios||Y.UA.ios<2.0){Y.error("simulateGestureEvent(): Native gesture DOM eventframe is not available in this platform.");}
if(!target){Y.error("simulateGestureEvent(): Invalid target.");}
if(Y.Lang.isString(type)){type=type.toLowerCase();if(!gestureEvents[type]){Y.error("simulateTouchEvent(): Event type '"+type+"' not supported.");}}else{Y.error("simulateGestureEvent(): Event type must be a string.");}
if(!Y.Lang.isBoolean(bubbles)){bubbles=true;}
if(!Y.Lang.isBoolean(cancelable)){cancelable=true;}
if(!Y.Lang.isObject(view)){view=Y.config.win;}
if(!Y.Lang.isNumber(detail)){detail=2;}
if(!Y.Lang.isNumber(screenX)){screenX=0;}
if(!Y.Lang.isNumber(screenY)){screenY=0;}
if(!Y.Lang.isNumber(clientX)){clientX=0;}
if(!Y.Lang.isNumber(clientY)){clientY=0;}
if(!Y.Lang.isBoolean(ctrlKey)){ctrlKey=false;}
if(!Y.Lang.isBoolean(altKey)){altKey=false;}
if(!Y.Lang.isBoolean(shiftKey)){shiftKey=false;}
if(!Y.Lang.isBoolean(metaKey)){metaKey=false;}
if(!Y.Lang.isNumber(scale)){scale=1.0;}
if(!Y.Lang.isNumber(rotation)){rotation=0.0;}
customEvent=Y.config.doc.createEvent("GestureEvent");customEvent.initGestureEvent(type,bubbles,cancelable,view,detail,screenX,screenY,clientX,clientY,ctrlKey,altKey,shiftKey,metaKey,target,scale,rotation);target.dispatchEvent(customEvent);}
function simulateTouchEvent(target,type,bubbles,cancelable,view,detail,screenX,screenY,clientX,clientY,ctrlKey,altKey,shiftKey,metaKey,touches,targetTouches,changedTouches,scale,rotation){var customEvent;if(!target){Y.error("simulateTouchEvent(): Invalid target.");}
if(Y.Lang.isString(type)){type=type.toLowerCase();if(!touchEvents[type]){Y.error("simulateTouchEvent(): Event type '"+type+"' not supported.");}}else{Y.error("simulateTouchEvent(): Event type must be a string.");}
if(type==='touchstart'||type==='touchmove'){if(touches.length===0){Y.error('simulateTouchEvent(): No touch object in touches');}}else if(type==='touchend'){if(changedTouches.length===0){Y.error('simulateTouchEvent(): No touch object in changedTouches');}}
if(!Y.Lang.isBoolean(bubbles)){bubbles=true;}
if(!Y.Lang.isBoolean(cancelable)){cancelable=(type!=="touchcancel");}
if(!Y.Lang.isObject(view)){view=Y.config.win;}
if(!Y.Lang.isNumber(detail)){detail=1;}
if(!Y.Lang.isNumber(screenX)){screenX=0;}
if(!Y.Lang.isNumber(screenY)){screenY=0;}
if(!Y.Lang.isNumber(clientX)){clientX=0;}
if(!Y.Lang.isNumber(clientY)){clientY=0;}
if(!Y.Lang.isBoolean(ctrlKey)){ctrlKey=false;}
if(!Y.Lang.isBoolean(altKey)){altKey=false;}
if(!Y.Lang.isBoolean(shiftKey)){shiftKey=false;}
if(!Y.Lang.isBoolean(metaKey)){metaKey=false;}
if(!Y.Lang.isNumber(scale)){scale=1.0;}
if(!Y.Lang.isNumber(rotation)){rotation=0.0;}
if(Y.Lang.isFunction(Y.config.doc.createEvent)){if(Y.UA.android){if(Y.UA.android<4.0){customEvent=Y.config.doc.createEvent("MouseEvents");customEvent.initMouseEvent(type,bubbles,cancelable,view,detail,screenX,screenY,clientX,clientY,ctrlKey,altKey,shiftKey,metaKey,0,target);customEvent.touches=touches;customEvent.targetTouches=targetTouches;customEvent.changedTouches=changedTouches;}else{customEvent=Y.config.doc.createEvent("TouchEvent");customEvent.initTouchEvent(touches,targetTouches,changedTouches,type,view,screenX,screenY,clientX,clientY,ctrlKey,altKey,shiftKey,metaKey);}}else if(Y.UA.ios){if(Y.UA.ios>=2.0){customEvent=Y.config.doc.createEvent("TouchEvent");customEvent.initTouchEvent(type,bubbles,cancelable,view,detail,screenX,screenY,clientX,clientY,ctrlKey,altKey,shiftKey,metaKey,touches,targetTouches,changedTouches,scale,rotation);}else{Y.error('simulateTouchEvent(): No touch event simulation framework present for iOS, '+Y.UA.ios+'.');}}else{Y.error('simulateTouchEvent(): Not supported agent yet, '+Y.UA.userAgent);}
target.dispatchEvent(customEvent);}else{Y.error('simulateTouchEvent(): No event simulation framework present.');}}
Y.Event.simulate=function(target,type,options){options=options||{};if(mouseEvents[type]||pointerEvents[type]){simulateMouseEvent(target,type,options.bubbles,options.cancelable,options.view,options.detail,options.screenX,options.screenY,options.clientX,options.clientY,options.ctrlKey,options.altKey,options.shiftKey,options.metaKey,options.button,options.relatedTarget);}else if(keyEvents[type]){simulateKeyEvent(target,type,options.bubbles,options.cancelable,options.view,options.ctrlKey,options.altKey,options.shiftKey,options.metaKey,options.keyCode,options.charCode);}else if(uiEvents[type]){simulateUIEvent(target,type,options.bubbles,options.cancelable,options.view,options.detail);}else if(touchEvents[type]){if((Y.config.win&&("ontouchstart"in Y.config.win))&&!(Y.UA.phantomjs)&&!(Y.UA.chrome&&Y.UA.chrome<6)){simulateTouchEvent(target,type,options.bubbles,options.cancelable,options.view,options.detail,options.screenX,options.screenY,options.clientX,options.clientY,options.ctrlKey,options.altKey,options.shiftKey,options.metaKey,options.touches,options.targetTouches,options.changedTouches,options.scale,options.rotation);}else{Y.error("simulate(): Event '"+type+"' can't be simulated. Use gesture-simulate module instead.");}}else if(Y.UA.ios&&Y.UA.ios>=2.0&&gestureEvents[type]){simulateGestureEvent(target,type,options.bubbles,options.cancelable,options.view,options.detail,options.screenX,options.screenY,options.clientX,options.clientY,options.ctrlKey,options.altKey,options.shiftKey,options.metaKey,options.scale,options.rotation);}else{Y.error("simulate(): Event '"+type+"' can't be simulated.");}};})();},'3.15.0',{"requires":["event-base"]});