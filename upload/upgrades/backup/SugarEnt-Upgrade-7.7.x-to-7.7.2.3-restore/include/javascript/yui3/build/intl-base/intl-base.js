/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('intl-base',function(Y,NAME){var SPLIT_REGEX=/[, ]/;Y.mix(Y.namespace('Intl'),{lookupBestLang:function(preferredLanguages,availableLanguages){var i,language,result,index;function scan(language){var i;for(i=0;i<availableLanguages.length;i+=1){if(language.toLowerCase()===availableLanguages[i].toLowerCase()){return availableLanguages[i];}}}
if(Y.Lang.isString(preferredLanguages)){preferredLanguages=preferredLanguages.split(SPLIT_REGEX);}
for(i=0;i<preferredLanguages.length;i+=1){language=preferredLanguages[i];if(!language||language==='*'){continue;}
while(language.length>0){result=scan(language);if(result){return result;}else{index=language.lastIndexOf('-');if(index>=0){language=language.substring(0,index);if(index>=2&&language.charAt(index-2)==='-'){language=language.substring(0,index-2);}}else{break;}}}}
return'';}});},'3.15.0',{"requires":["yui-base"]});