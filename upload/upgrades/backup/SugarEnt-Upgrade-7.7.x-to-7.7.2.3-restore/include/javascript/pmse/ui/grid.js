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
var Grid=function(options){Container.call(this,options);this.columns=[];this.store=null;Grid.prototype.initObject.call(this,options);};Grid.prototype=new Container();Grid.prototype.type='Grid';Grid.prototype.family='Panel';Grid.prototype.initObject=function(options){var defaults={store:null,columns:[]};$.extend(true,defaults,options);this.setStore(defaults.store).setColumns(defaults.columns);};Grid.prototype.createHTML=function(){var i,table,record;Container.prototype.createHTML.call(this);table=document.createElement('table');this.createTableHeaders(table,this.columns);for(i=0;this.store&&i<this.store.getSize();i+=1){record=this.store.getRecord(i);this.createTableRow(table,this.columns,record);}
this.body.html.appendChild(table);};Grid.prototype.createTableHeaders=function(table,headers){var row=document.createElement('tr'),th,i;for(i=0;i<headers.length;i+=1){th=document.createElement('th');th.innerHTML=headers[i].text;row.appendChild(th);}
table.appendChild(row);return table;};Grid.prototype.setParent=function(parent){this.parent=parent;return this;}
Grid.prototype.createTableRow=function(table,columns,record){var i,td,row=document.createElement('tr');for(i=0;i<columns.length;i+=1){td=document.createElement('td');td.innerHTML=record[columns[i].dataIndex]||"";row.appendChild(td);}
table.appendChild(row);return table;};Grid.prototype.setStore=function(newStore){this.store=newStore;return this;};Grid.prototype.getStore=function(){return this.store;};Grid.prototype.setColumns=function(newColumns){this.columns=newColumns;return this;};Grid.prototype.getColumns=function(){return this.columns;};