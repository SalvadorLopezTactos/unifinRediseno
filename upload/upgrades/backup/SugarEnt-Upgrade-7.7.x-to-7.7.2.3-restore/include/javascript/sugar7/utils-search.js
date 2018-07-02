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
(function(app){app.events.on('app:init',function(){app.utils=_.extend(app.utils,{'GlobalSearch':{formatRecords:function(collection,linkableHighlights){collection.each(function(model){if(model.formatted){return;}
var module=app.metadata.getModule(model.get('_module'));var nameFormatValues=_.values(module.nameFormat);var personModuleType=!!nameFormatValues.length;var attrs={};_.each(model.toJSON(),function(val,key){attrs[key]=Handlebars.Utils.escapeExpression(val);});if(personModuleType&&!model.get('name')){var name=new Handlebars.SafeString(app.utils.formatNameModel(model.get('_module'),attrs));model.set('name',name);}
var highlights=model.get('_highlights');if(!highlights){model.formatted=true;return;}
var formattedHighlights=_.map(highlights,function(val,key){if(key==='email'){if(val.primary){val=new Handlebars.SafeString(_.first(val.primary));var label='LBL_PRIMARY_EMAIL';}else{return false;}}else{val=new Handlebars.SafeString(_.first(val));}
attrs[key]=val;return{name:key,value:val,label:label||module.fields[key].vname,link:linkableHighlights,highlighted:true};});formattedHighlights=_.reject(formattedHighlights,function(highlight){return highlight===false;});var highlightedSecondaryEmail=highlights.email?highlights.email.secondary:null;if(highlightedSecondaryEmail){formattedHighlights.push({name:'secondaryEmail',type:'email',value:new Handlebars.SafeString(highlightedSecondaryEmail.join(', ')),label:module.fields['email'].vname,link:linkableHighlights,highlighted:true});}
if(personModuleType){var personName=new Handlebars.SafeString(app.utils.formatNameModel(model.get('_module'),attrs));formattedHighlights.push({name:'name',value:personName,label:module.fields.name.vname,link:linkableHighlights,highlighted:true});}
model.set('_highlights',formattedHighlights);model.formatted=true;});},getFieldsMeta:function(module,options){options=options||{};var fieldsMeta={};var meta=_.extend({},this.meta,app.metadata.getView(module,'search-list'));_.each(meta.panels,function(panel){if(panel.name==='primary'){fieldsMeta.primaryFields=this._setFieldsCategory(panel.fields,'primary',options);}else if(panel.name==='secondary'){fieldsMeta.secondaryFields=this._setFieldsCategory(panel.fields,'secondary',options);}},this);fieldsMeta.rowactions=meta.rowactions;return fieldsMeta;},_setFieldsCategory:function(fields,category,options){var fieldList={};_.each(fields,function(field){if(!fieldList[field.name]){fieldList[field.name]=_.extend({},fieldList[field.name],field);}
fieldList[field.name][category]=true;fieldList[field.name].ellipsis=false;if(category==='primary'&&options.linkablePrimary===false){fieldList[field.name].link=false;}
if(category==='secondary'){fieldList[field.name].link=false;if(field.type==='email'){fieldList[field.name].emailLink=false;}}});return fieldList;},highlightFields:function(model,viewDefs,add){var highlighted=model.get('_highlights');var varDefs=model.fields;viewDefs=_.clone(viewDefs)||{};_.each(highlighted,function(field){var hasViewDefs=viewDefs[field.name];var addOrPatchExisting=(hasViewDefs||add);if(!addOrPatchExisting){return;}
var nameFormatValues=_.values(app.metadata.getModule(model.module).nameFormat);if(_.contains(nameFormatValues,field.name)&&!hasViewDefs){return;}
if(!_.isUndefined(model.primaryFields)&&model.primaryFields[field.name]){return;}
viewDefs[field.name]=_.extend({},varDefs[field.name],viewDefs[field.name],field);});return viewDefs;},buildSearchRoute:function(term,options){options=options||{};term=term?encodeURIComponent(term):'';var paramString='?';var firstParamDefined=false;var modules=options.modules;if(modules&&modules.length>0){paramString=paramString+'modules='+modules.join(',');firstParamDefined=true;}
var tags=options.tags;if(tags&&tags.length>0){if(firstParamDefined){paramString=paramString+'&'}
var encodedTags=_.map(tags,function(tag){return encodeURIComponent(tag);});paramString=paramString+'tags='+encodedTags.join(',');}
return app.router.buildRoute('search',term+paramString);}}});});})(SUGAR.App);