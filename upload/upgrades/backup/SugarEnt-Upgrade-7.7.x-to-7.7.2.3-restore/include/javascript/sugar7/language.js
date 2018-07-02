/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     */
(function(app){app.events.on('app:init',function(){app.lang=_.extend(app.lang,{getModuleSingular:function(module){app.logger.warn('The `app.lang.getModuleSingular` function has been deprecated since 7.6.0. Please '+
+'upgrade your code to use `app.lang.getModuleName`.');var modString=app.metadata.getStrings('mod_strings')[module],moduleSingular=(modString?modString['LBL_MODULE_NAME_SINGULAR']:'')||app.lang.getAppListStrings('moduleListSingular')[module]||app.lang.getAppListStrings('moduleList')[module]||module;return moduleSingular;},getModuleIconLabel:function(module){var name=app.lang.getAppListStrings('moduleIconList')[module]||app.lang.getModuleName(module);var space=name.indexOf(' ');var hasSpace=space!==-1;var result;if(hasSpace){result=name.substring(0,1)+name.substring(space+1,space+2);}else{result=name.substring(0,2);}
return result;}});});app.events.on('app:sync:complete',function(){var language=app.user.getPreference('language')
if(language){language=language.replace('_','-')
app.date.lang(language.toLowerCase());if($.fn.select2.locales){var twoLetterCode=language.substring(0,2).toLowerCase();if(twoLetterCode in $.fn.select2.locales){$.extend($.fn.select2.defaults,$.fn.select2.locales[twoLetterCode]);}
if(language in $.fn.select2.locales){$.extend($.fn.select2.defaults,$.fn.select2.locales[language]);}}}});app.events.on('lang:direction:change',function(){var direction=app.lang.direction,isRTL=direction==='rtl';$('html').toggleClass('rtl',isRTL);});})(SUGAR.App);