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

  // charts custom
  _renderHtml: function() {
    this._super('_renderHtml');

    // Funnel Chart
    d3.json('styleguide/content/charts/data/funnel_data.json', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.funnelChart()
              .showTitle(false)
              .direction(app.lang.direction)
              .fmtValueLabel(function(d) { return '$' + (d.label || d.value || d) + 'K'; })
              .tooltipContent(function(key, x, y, e, graph) {
                return '<p>Stage: <b>' + key + '</b></p>' +
                       '<p>Amount: <b>$' + parseInt(y, 10) + 'K</b></p>' +
                       '<p>Percent: <b>' + x + '%</b></p>';
              });

        d3.select('#funnel1 svg')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        return chart;
      });
    });

    // Gauge Chart
    d3.json('styleguide/content/charts/data/gauge_data.json', function(data) {
      nv.addGraph(function() {
        var gauge = nv.models.gaugeChart()
              .x(function(d) { return d.key; })
              .y(function(d) { return d.y; })
              .showLabels(true)
              .showTitle(false)
              .colorData('default')
              .ringWidth(50)
              .maxValue(9)
              .direction(app.lang.direction)
              .transitionMs(4000);

        d3.select('#gauge svg')
            .datum(data)
          .transition().duration(500)
            .call(gauge);

        return gauge;
      });
    });

    // Treemap flare chart
    d3.json('styleguide/content/charts/data/flare.json', function(data) {
      nv.addGraph(function() {

        var chart = nv.models.treemapChart()
              .leafClick(function(d) {
                alert('leaf clicked');
              })
              .showTitle(false)
              .tooltips(true)
              .getSize(function(d) { return d.size; })
              .direction(app.lang.direction)
              .colorData('default');

        d3.select('#treemap1 svg')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        return chart;
      });
    });

    // Tree org chart
    d3.json('styleguide/content/charts/data/tree_data.json', function(data) {
      nv.addGraph(function() {

        var nodeRenderer = function(d) {
          return '<img src="styleguide/content/charts/img/' + d.image +
            '" class="rep-avatar" width="32" height="32"><div class="rep-name">' + d.name +
            '</div><div class="rep-title">' + d.title + '</div>';
        };

        var chart = nv.models.tree()
              .duration(300)
              .nodeSize({ 'width': 124, 'height': 56 })
              .nodeRenderer(nodeRenderer)
              .zoomExtents({ 'min': 0.25, 'max': 4 });

        d3.select('#org svg')
            .datum(data)
          .transition().duration(700)
            .call(chart);

        nv.utils.windowResize(function() { chart.resize(); });

        return chart;
      });
    });

    // Bubble chart
    nv.addGraph(function() {
      var format = d3.time.format('%Y-%m-%d'),
          now = new Date(),
          duration = 12,
          startDate = new Date(now.getFullYear(), (duration === 12 ? 0 : Math.ceil((now.getMonth()) / 3) - 1 + duration), 1),
          endDate = new Date(now.getFullYear(), (duration === 12 ? 12 : startDate.getMonth() + 3), 0),
          dateRange = [startDate, endDate];

      d3.json('styleguide/content/charts/data/bubble_data.json', function(data) {
        /*var bubble_data = {
              data: d3.nest()
                      .key(function(d){ return d.assigned_user_name;})
                      .entries(
                          json.records
                              .filter(function(d){
                                  var oppDate = Date.parse(d.date_closed);
                                  return  oppDate >= dateRange[0] && oppDate <= dateRange[1];
                              })
                              .slice(0,10)
                              .map(function(d){
                                  return {
                                      id: d.id,
                                      x: d.date_closed,
                                      y: parseInt(d.amount,10),
                                      shape: 'circle',
                                      account_name: d.account_name,
                                      assigned_user_name: d.assigned_user_name,
                                      sales_stage: d.sales_stage,
                                      probability: d.probability
                                  };
                              })
                      ),
              properties: { title: "Top 10 Opportunities", value: json.records.length }
        };*/
        //chart.colorData( 'graduated', {c1: '#e8e2ca', c2: '#3e6c0a', l: bubble_data.data.length} );

        var chart = nv.models.bubbleChart()
            .x(function(d) { return format.parse(d.x); })
            .y(function(d) { return d.y; })
            .tooltipContent(function(key, x, y, e, graph) {
                return '<p>Assigned: <b>' + key + '</b></p>' +
                       '<p>Amount: <b>$' + d3.format(',.02d')(e.point.opportunity) + '</b></p>' +
                       '<p>Cloase Date: <b>' + d3.time.format('%x')(format.parse(e.point.x)) + '</b></p>';
              })
            .showTitle(false)
            .tooltips(true)
            .showLegend(true)
            .direction(app.lang.direction)
            .colorData('graduated', {c1: '#d9edf7', c2: '#134158', l: data.data.length});

        d3.select('#bubble svg')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        nv.utils.windowResize(chart.update);

        return chart;
      });

    });

    // Treemap opportunities chart
    d3.json('styleguide/content/charts/data/treemap_data.json', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.treemapChart()
              .leafClick(function(d) { alert('leaf clicked'); })
              .getSize(function(d) { return d.value; })
              .showTitle(false)
              .tooltips(false)
              .direction(app.lang.direction)
              .colorData('class');
        d3.select('#treemap2 svg')
            .datum(parseData(data.records))
          .transition().duration(500)
            .call(chart);
        return chart;
      });
    });

    function parseData(data) {
      var root = {
            name: 'Opportunities',
            children: [],
            x: 0,
            y: 0,
            dx: parseInt(document.getElementById('treemap2').offsetWidth, 10),
            dy: parseInt(document.getElementById('treemap2').offsetHeight, 10),
            depth: 0,
            colorIndex: '0root_Opportunities'
          },
          colorIndices = ['0root_Opportunities'],
          colors = d3.scale.category20().range();

      var today = new Date();
          today.setUTCHours(0, 0, 0, 0);

      var day_ms = 1000 * 60 * 60 * 24,
          d1 = new Date(today.getTime() + 31 * day_ms);

      var data = data.filter(function(model) {
        // Filter for 30 days from now.
        var d2 = new Date(model.date_closed || '1970-01-01');
        return (d2 - d1) / day_ms <= 30;
      }).map(function(d) {
        // Include properties to be included in leaves
        return {
          assigned_user_name: d.assigned_user_name,
          sales_stage: d.sales_stage,
          name: d.name,
          amount_usdollar: d.amount_usdollar,
          color: d.color
        };
      });

      data = _.groupBy(data, function(m) {
        return m.assigned_user_name;
      });

      _.each(data, function(value, key, list) {
        list[key] = _.groupBy(value, function(m) {
          return m.sales_stage;
        });
      });

      _.each(data, function(value1, key1) {
        var child = [];
        _.each(value1, function(value2, key2) {
          if (colorIndices.indexOf('2oppgroup_' + key2) === -1) {
            colorIndices.push('2oppgroup_' + key2);
          }
          _.each(value2, function(record) {
            record.className = 'stage_' + record.sales_stage.toLowerCase().replace(' ', '');
            record.value = parseInt(record.amount_usdollar, 10);
            record.colorIndex = '2oppgroup_' + key2;
          });
          child.push({
            name: key2,
            className: 'stage_' + key2.toLowerCase().replace(' ', ''),
            children: value2,
            colorIndex: '2oppgroup_' + key2
          });
        });
        if (colorIndices.indexOf('1rep_' + key1) === -1) {
          colorIndices.push('1rep_' + key1);
        }
        root.children.push({
          name: key1,
          children: child,
          colorIndex: '1rep_' + key1
        });
      });

      function accumulate(d) {
        if (d.children) {
          return d.value = d.children.reduce(function(p, v) { return p + accumulate(v); }, 0);
        }
        return d.value;
      }

      accumulate(root);

      colorIndices.sort(d3.ascending());

      //build color indexes
      function setColorIndex(d) {
        var i, l;
        d.colorIndex = colorIndices.indexOf(d.colorIndex);
        if (d.children) {
          l = d.children.length;
          for (i = 0; i < l; i += 1) {
            setColorIndex(d.children[i]);
          }
        }
      }

      setColorIndex(root);

      return root;
    }
  }
})
