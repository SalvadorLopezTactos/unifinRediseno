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
({className:'container-fluid',_renderHtml:function(){this._super('_renderHtml');this.chart1=nv.models.multiBarChart().vertical(false).margin({top:10,right:10,bottom:10,left:10}).showValues(true).showTitle(false).tooltips(true).stacked(true).showControls(false).direction(app.lang.direction).tooltipContent(function(key,x,y,e,graph){return'<p>Outcome: <b>'+key+'</b></p>'+'<p>Lead Source: <b>'+x+'</b></p>'+'<p>Amount: <b>$'+parseInt(y)+'K</b></p>';});this.chart1.yAxis.tickFormat(d3.format(',.2f'));nv.utils.windowResize(this.chart1.update);this.chart2=nv.models.multiBarChart().vertical(false).margin({top:10,right:10,bottom:10,left:10}).showValues(true).showTitle(false).tooltips(true).showControls(false).stacked(false).direction(app.lang.direction).tooltipContent(function(key,x,y,e,graph){return'<p>Outcome: <b>'+key+'</b></p>'+'<p>Lead Source: <b>'+x+'</b></p>'+'<p>Amount: <b>$'+parseInt(y)+'K</b></p>';});this.chart2.yAxis.tickFormat(d3.format(',.2f'));nv.utils.windowResize(this.chart2.update);this.loadData();},loadData:function(options){d3.json('styleguide/content/charts/data/multibar_data_opportunities.json',_.bind(function(data){d3.select('#horiz1 svg').datum(data).transition().duration(500).call(this.chart1);},this));d3.json('styleguide/content/charts/data/multibar_data_negative.json',_.bind(function(data){d3.select('#horiz2 svg').datum(data).transition().duration(500).call(this.chart2);},this));}})