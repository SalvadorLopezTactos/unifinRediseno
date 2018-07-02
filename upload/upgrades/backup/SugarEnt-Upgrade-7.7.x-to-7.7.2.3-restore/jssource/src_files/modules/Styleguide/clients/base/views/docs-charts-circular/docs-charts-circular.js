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

  // charts circular
  _renderHtml: function() {
    this._super('_renderHtml');

    // Pie Chart
    d3.json('styleguide/content/charts/data/pie_data.json', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.pieChart()
              .x(function(d) { return d.key })
              .y(function(d) { return d.value })
              .showLabels(true)
              .showTitle(false)
              .direction(app.lang.direction)
              .colorData('default')
              .tooltipContent(function(key, x, y, e, graph) {
                return '<p>Stage: <b>' + key + '</b></p>' +
                       '<p>Amount: <b>$' + parseInt(y) + 'K</b></p>' +
                       '<p>Percent: <b>' + x + '%</b></p>';
              });

          d3.select('#pie svg')
              .datum(data)
            .transition().duration(500)
              .call(chart);

        return chart;
      });
    });

    // Donut Chart
    d3.json('styleguide/content/charts/data/pie_data.json', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.pieChart()
              .x(function(d) { return d.key })
              .y(function(d) { return d.value })
              .showLabels(true)
              .showTitle(false)
              .donut(true)
              .donutRatio(0.4)
              .donutLabelsOutside(true)
              .hole(10)
              .direction(app.lang.direction)
              .colorData('default')
              .tooltipContent(function(key, x, y, e, graph) {
                return '<p>Stage: <b>' + key + '</b></p>' +
                       '<p>Amount: <b>$' + parseInt(y) + 'K</b></p>' +
                       '<p>Percent: <b>' + x + '%</b></p>';
              });

          d3.select('#donut svg')
              .datum(data)
            .transition().duration(1200)
              .call(chart);

        return chart;
      });
    });
  }
})
