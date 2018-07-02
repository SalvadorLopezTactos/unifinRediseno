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
({
  className: 'container-fluid',

  // charts line
  _renderHtml: function() {
    this._super('_renderHtml');

    // Line chart
    d3.json('styleguide/content/charts/data/line_data.json', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.lineChart()
              .x(function(d) { return d[0]; })
              .y(function(d) { return d[1]; })
              .showTitle(false)
              .tooltips(true)
              .useVoronoi(false)
              .showControls(false)
              .direction(app.lang.direction)
              .tooltipContent(function(key, x, y, e, graph) {
                  return '<p>Category: <b>' + key + '</b></p>' +
                         '<p>Amount: <b>$' + parseInt(y, 10) + 'M</b></p>' +
                         '<p>Date: <b>' + x + '</b></p>';
              });

        chart.xAxis
            .tickFormat(function(d) { return d3.time.format('%x')(new Date(d)); });

        chart.yAxis
            .axisLabel('Voltage (v)')
            .tickFormat(d3.format(',.2f'));

        d3.select('#line1 svg')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        return chart;
      });
    });

    // Stacked area chart
    d3.json('styleguide/content/charts/data/line_data.json', function(data) {
      nv.addGraph(function() {

        var chart = nv.models.stackedAreaChart()
              .x(function(d) { return d[0]; })
              .y(function(d) { return d[1]; })
              .tooltipContent(function(key, x, y, e, graph) {
                  return '<p>Category: <b>' + key + '</b></p>' +
                         '<p>Amount: <b>$' + parseInt(y, 10) + 'M</b></p>' +
                         '<p>Date: <b>' + x + '</b></p>';
                })
              .showTitle(false)
              .tooltips(true)
              .useVoronoi(false)
              .showControls(false)
              .direction(app.lang.direction)
              .colorData('graduated', {c1: '#e8e2ca', c2: '#3e6c0a', l: data.data.length});
              //.colorData( 'class' )
              //.colorData( 'default' )
              //.clipEdge(true)

        chart.xAxis
            .tickFormat(function(d) { return d3.time.format('%x')(new Date(d)); });

        chart.yAxis
            .axisLabel('Expenditures ($)')
            .tickFormat(d3.format(',.2f'));

        d3.select('#area svg')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        return chart;
      });
    });
  }
})
