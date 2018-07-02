/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('app-transitions',function(Y,NAME){function AppTransitions(){}
AppTransitions.ATTRS={transitions:{setter:'_setTransitions',value:false}};AppTransitions.FX={fade:{viewIn:'app:fadeIn',viewOut:'app:fadeOut'},slideLeft:{viewIn:'app:slideLeft',viewOut:'app:slideLeft'},slideRight:{viewIn:'app:slideRight',viewOut:'app:slideRight'}};AppTransitions.prototype={transitions:{navigate:'fade',toChild:'slideLeft',toParent:'slideRight'},_setTransitions:function(transitions){var defTransitions=this.transitions;if(transitions&&transitions===true){return Y.merge(defTransitions);}
return transitions;}};Y.App.Transitions=AppTransitions;Y.Base.mix(Y.App,[AppTransitions]);Y.mix(Y.App.CLASS_NAMES,{transitioning:Y.ClassNameManager.getClassName('app','transitioning')});},'3.15.0',{"requires":["app-base"]});