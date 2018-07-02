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
({defaults:{editable:true},fieldTypeMap:{'datetime':'date','datetimecombo':'date'},buildSearchTermFilter:function(moduleName,searchTerm){if(moduleName==='all_modules'||!searchTerm){return[];}
searchTerm=searchTerm.trim();var splitTermFilter;var filterList=[];var searchMeta=app.data.getBeanClass('Filters').prototype.getModuleQuickSearchMeta(moduleName);var fieldNames=searchMeta.fieldNames;_.each(fieldNames,function(name){if(!_.isArray(name)){var filter=this._buildFilterDef(name,'$starts',searchTerm);if(filter){filterList.push(filter);}
return;}
if(splitTermFilter){app.logger.error('Cannot have more than 1 split term filter');return;}
splitTermFilter=this._buildSplitTermFilterDef(name,'$starts',searchTerm);},this);if(splitTermFilter){filterList.push(splitTermFilter);}
if(filterList.length>1){var filter=this._joinFilterDefs('$or',filterList);if(filter){filterList=[filter];}}
if(moduleName==='Users'||moduleName==='Employees'){filterList=this._simplifyFilterDef(filterList);filterList=[{'$and':[{'status':{'$not_equals':'Inactive'}},filterList]}];}
return filterList;},combineFilterDefinitions:function(baseFilter,searchTermFilter){var isBaseFilter=_.size(baseFilter)>0,isSearchTermFilter=_.size(searchTermFilter)>0;baseFilter=_.isArray(baseFilter)?baseFilter:[baseFilter];if(isBaseFilter&&isSearchTermFilter){baseFilter.push(searchTermFilter[0]);return[{'$and':baseFilter}];}else if(isBaseFilter){return baseFilter;}else if(isSearchTermFilter){return searchTermFilter;}
return[];},getFilterableFields:function(moduleName){var moduleMeta=app.metadata.getModule(moduleName),operatorMap=app.metadata.getFilterOperators(moduleName),fieldMeta=moduleMeta.fields,fields={};if(moduleMeta.filters){_.each(moduleMeta.filters,function(templateMeta){if(templateMeta.meta&&templateMeta.meta.fields){fields=_.extend(fields,templateMeta.meta.fields);}});}
_.each(fields,function(fieldFilterDef,fieldName){var fieldMetaData=app.utils.deepCopy(fieldMeta[fieldName]);if(_.isEmpty(fieldFilterDef)){fields[fieldName]=fieldMetaData||{};}else{fields[fieldName]=_.extend({name:fieldName},fieldMetaData,fieldFilterDef);}
delete fields[fieldName]['readonly'];});var validFields={};_.each(fields,function(value,key){var type=this.fieldTypeMap[value.type]||value.type;var hasAccess=app.acl.hasAccess('detail',moduleName,null,key);if(hasAccess&&(operatorMap[type]||value.predefined_filter===true)){validFields[key]=value;}},this);return validFields;},getModuleQuickSearchMeta:function(moduleName){moduleName=moduleName||this.get('module_name');var prototype=app.data.getBeanClass('Filters').prototype;prototype._moduleQuickSearchMeta=prototype._moduleQuickSearchMeta||{};prototype._moduleQuickSearchMeta[moduleName]=prototype._moduleQuickSearchMeta[moduleName]||this._getQuickSearchMetaByPriority(moduleName);return prototype._moduleQuickSearchMeta[moduleName];},populateFilterDefinition:function(filterDef,populateObj){if(!populateObj){return filterDef;}
filterDef=app.utils.deepCopy(filterDef);_.each(filterDef,function(row){_.each(row,function(filter,field){var hasNoOperator=(_.isString(filter)||_.isNumber(filter));if(hasNoOperator){filter={'$equals':filter};}
var operator=_.keys(filter)[0],value=filter[operator],isValueEmpty=!_.isNumber(value)&&_.isEmpty(value);if(isValueEmpty&&populateObj&&!_.isUndefined(populateObj[field])){value=populateObj[field];}
if(hasNoOperator){row[field]=value;}else{row[field][operator]=value;}});});return filterDef;},_getQuickSearchMetaByPriority:function(searchModule){var meta=app.metadata.getModule(searchModule),filters=meta?meta.filters:[],fieldNames=[],priority=0,splitTerms=false;_.each(filters,function(value){if(value&&value.meta&&value.meta.quicksearch_field&&priority<value.meta.quicksearch_priority){fieldNames=value.meta.quicksearch_field;priority=value.meta.quicksearch_priority;if(_.isBoolean(value.meta.quicksearch_split_terms)){splitTerms=value.meta.quicksearch_split_terms;}}});return{fieldNames:fieldNames,splitTerms:splitTerms};},_simplifyFilterDef:function(filterList){return filterList.length>1?filterList:filterList[0];},_buildFilterDef:function(fieldName,operator,searchTerm){var def={};var filter={};filter[operator]=searchTerm;def[fieldName]=filter;return def;},_joinFilterDefs:function(operator){var filterDefs=Array.prototype.slice.call(arguments,1);if(_.isEmpty(filterDefs)){return[];}
if(_.isArray(filterDefs[0])){filterDefs=filterDefs[0];}
if(filterDefs.length<2){return filterDefs[0];}
var filter={};filter[operator]=filterDefs;return filter;},_buildSplitTermFilterDef:function(fieldNames,operator,searchTerm){if(fieldNames.length>2){app.logger.error('Cannot have more than 2 fields in a complex filter');return;}
if(fieldNames.length===1){return this._buildFilterDef(fieldNames[0],operator,searchTerm);}
var filterList=[];var tokens=searchTerm.split(' ');for(var i=1;i<tokens.length;++i){var first=_.first(tokens,i).join(' ');var rest=_.rest(tokens,i).join(' ');var tokenFilter=[this._buildFilterDef(fieldNames[0],operator,first),this._buildFilterDef(fieldNames[1],operator,rest)];filterList.push(this._joinFilterDefs('$and',tokenFilter));}
_.each(fieldNames,function(name){filterList.push(this._buildFilterDef(name,operator,searchTerm));},this);return this._joinFilterDefs('$or',filterList);}})