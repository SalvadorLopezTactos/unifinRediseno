/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('dataschema-xml',function(Y,NAME){var Lang=Y.Lang,okNodeType={1:true,9:true,11:true},SchemaXML;SchemaXML={apply:function(schema,data){var xmldoc=data,data_out={results:[],meta:{}};if(xmldoc&&okNodeType[xmldoc.nodeType]&&schema){data_out=SchemaXML._parseResults(schema,xmldoc,data_out);data_out=SchemaXML._parseMeta(schema.metaFields,xmldoc,data_out);}else{data_out.error=new Error("XML schema parse failure");}
return data_out;},_getLocationValue:function(field,context){var locator=field.locator||field.key||field,xmldoc=context.ownerDocument||context,result,res,value=null;try{result=SchemaXML._getXPathResult(locator,context,xmldoc);while((res=result.iterateNext())){value=res.textContent||res.value||res.text||res.innerHTML||res.innerText||null;}
return Y.DataSchema.Base.parse.call(this,value,field);}catch(e){}
return null;},_getXPathResult:function(locator,context,xmldoc){if(!Lang.isUndefined(xmldoc.evaluate)){return xmldoc.evaluate(locator,context,xmldoc.createNSResolver(context.ownerDocument?context.ownerDocument.documentElement:context.documentElement),0,null);}
else{var values=[],locatorArray=locator.split(/\b\/\b/),i=0,l=locatorArray.length,location,subloc,m,isNth;try{try{xmldoc.setProperty("SelectionLanguage","XPath");}catch(e){}
values=context.selectNodes(locator);}
catch(e){for(;i<l&&context;i++){location=locatorArray[i];if((location.indexOf("[")>-1)&&(location.indexOf("]")>-1)){subloc=location.slice(location.indexOf("[")+1,location.indexOf("]"));subloc--;context=context.children[subloc];isNth=true;}
else if(location.indexOf("@")>-1){subloc=location.substr(location.indexOf("@"));context=subloc?context.getAttribute(subloc.replace('@','')):context;}
else if(-1<location.indexOf("//")){subloc=context.getElementsByTagName(location.substr(2));context=subloc.length?subloc[subloc.length-1]:null;}
else if(l!=i+1){for(m=context.childNodes.length-1;0<=m;m-=1){if(location===context.childNodes[m].tagName){context=context.childNodes[m];m=-1;}}}}
if(context){if(Lang.isString(context)){values[0]={value:context};}
else if(isNth){values[0]={value:context.innerHTML};}
else{values=Y.Array(context.childNodes,0,true);}}}
return{index:0,iterateNext:function(){if(this.index>=this.values.length){return undefined;}
var result=this.values[this.index];this.index+=1;return result;},values:values};}},_parseField:function(field,result,context){var key=field.key||field,parsed;if(field.schema){parsed={results:[],meta:{}};parsed=SchemaXML._parseResults(field.schema,context,parsed);result[key]=parsed.results;}else{result[key]=SchemaXML._getLocationValue(field,context);}},_parseMeta:function(metaFields,xmldoc_in,data_out){if(Lang.isObject(metaFields)){var key,xmldoc=xmldoc_in.ownerDocument||xmldoc_in;for(key in metaFields){if(metaFields.hasOwnProperty(key)){data_out.meta[key]=SchemaXML._getLocationValue(metaFields[key],xmldoc);}}}
return data_out;},_parseResult:function(fields,context){var result={},j;for(j=fields.length-1;0<=j;j--){SchemaXML._parseField(fields[j],result,context);}
return result;},_parseResults:function(schema,context,data_out){if(schema.resultListLocator&&Lang.isArray(schema.resultFields)){var xmldoc=context.ownerDocument||context,fields=schema.resultFields,results=[],node,nodeList,i=0;if(schema.resultListLocator.match(/^[:\-\w]+$/)){nodeList=context.getElementsByTagName(schema.resultListLocator);for(i=nodeList.length-1;i>=0;--i){results[i]=SchemaXML._parseResult(fields,nodeList[i]);}}else{nodeList=SchemaXML._getXPathResult(schema.resultListLocator,context,xmldoc);while((node=nodeList.iterateNext())){results[i]=SchemaXML._parseResult(fields,node);i+=1;}}
if(results.length){data_out.results=results;}else{data_out.error=new Error("XML schema result nodes retrieval failure");}}
return data_out;}};Y.DataSchema.XML=Y.mix(SchemaXML,Y.DataSchema.Base);},'3.15.0',{"requires":["dataschema-base"]});