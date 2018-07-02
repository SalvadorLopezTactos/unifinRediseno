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
(function(app){app.events.on("app:init",function(){Handlebars.registerHelper('moduleIconLabel',function(module){return app.lang.getModuleIconLabel(module);});Handlebars.registerHelper('moduleIconToolTip',function(module){return app.lang.getModuleName(module);});Handlebars.registerHelper('getDDLabel',function(value,key){return app.lang.getAppListStrings(key)[value]||value;});Handlebars.registerHelper('subViewTemplate',function(key,data,options){var frame,template;template=app.template.getView(key,options.hash.module);frame=_.extend(Handlebars.createFrame(options.data||{}),options.hash);return template?template(data,{data:frame}):'';});Handlebars.registerHelper('subFieldTemplate',function(fieldName,view,data,options){var frame,template;template=app.template.getField(fieldName,view,options.hash.module);frame=_.extend(Handlebars.createFrame(options.data||{}),options.hash);return template?template(data,{data:frame}):'';});Handlebars.registerHelper('subLayoutTemplate',function(key,data,options){var frame,template;template=app.template.getLayout(key,options.hash.module);frame=_.extend(Handlebars.createFrame(options.data||{}),options.hash);return template?template(data,{data:frame}):'';});Handlebars.registerHelper('buildUrl',function(options){return new Handlebars.SafeString(app.utils.buildUrl(options.hash.url));});Handlebars.registerHelper('loading',function(str,options){str=app.lang.get(str);var cssClass=['loading'];if(_.isString(options.hash.cssClass)){cssClass=_.unique(cssClass.concat(Handlebars.Utils.escapeExpression(options.hash.cssClass).split(' ')));}
return new Handlebars.SafeString('<div class="'+cssClass.join(' ')+'">'
+Handlebars.Utils.escapeExpression(str)
+'<i class="l1">&#46;</i><i class="l2">&#46;</i><i class="l3">&#46;</i>'
+'</div>');});});})(SUGAR.App);