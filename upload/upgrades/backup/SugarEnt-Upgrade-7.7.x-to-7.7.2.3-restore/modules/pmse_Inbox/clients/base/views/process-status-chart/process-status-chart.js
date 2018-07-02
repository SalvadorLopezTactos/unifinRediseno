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
({plugins:['Dashlet','Chart'],processCollection:null,currentValue:'all',chartCollection:null,hasData:false,total:0,initialize:function(options){this._super('initialize',[options]);this.chart=nv.models.multiBarChart().showTitle(false).showControls(true).showValues(false).stacked(true).tooltipContent(function(key,x,y,e,graph){return'<p><b>'+parseInt(y,10)+'</b></p>';}).tooltips(true);},hasChartData:function(){return this.hasData;},renderChart:function(){if(!this.isChartReady()){return;}
d3.select(this.el).select('svg#'+this.cid).datum(this.chartCollection).transition().duration(500).call(this.chart);this.chart_loaded=_.isFunction(this.chart.update);this.displayNoData(!this.chart_loaded);},loadData:function(options){var self=this,url;if(this.meta.config){return;}
if(!this.currentValue){return;}
url=app.api.buildURL('pmse_Inbox/processStatusChart/'+this.currentValue);this.hasData=false;app.api.call('GET',url,null,{success:function(data){self.evaluateResponse(data);self.renderChart();},complete:options?options.complete:null});},evaluateResponse:function(response){var total=d3.sum(response.data,function(d){return d3.sum(d.values,function(h){return h.y;});});this.hasData=!!total;this.chartCollection=response;}})