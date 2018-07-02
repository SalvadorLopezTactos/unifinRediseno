nv.models.pieChart = function () {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 10, right: 10, bottom: 10, left: 10},
      width = null,
      height = null,
      showTitle = false,
      showLegend = true,
      hole = false,
      tooltip = null,
      durationMs = 0,
      tooltips = true,
      tooltipContent = function (key, x, y, e, graph) {
        return '<h3>' + key + ' - ' + x + '</h3>' +
               '<p>' +  y + '</p>';
      },
      state = {},
      strings = {
        legend: {close: 'Hide legend', open: 'Show legend'},
        controls: {close: 'Hide controls', open: 'Show controls'},
        noData: 'No Data Available.'
      },
      dispatch = d3.dispatch('chartClick', 'tooltipShow', 'tooltipHide', 'tooltipMove', 'stateChange', 'changeState');

  //============================================================
  // Private Variables
  //------------------------------------------------------------

  var pie = nv.models.pie(),
      legend = nv.models.legend()
        .align('center');

  var showTooltip = function (e, offsetElement, total) {
    var left = e.pos[0],
        top = e.pos[1],
        x = (pie.y()(e.point) * 100 / total).toFixed(1),
        y = pie.valueFormat()( pie.y()(e.point)),
        content = tooltipContent(e.point.key, x, y, e, chart);

    tooltip = nv.tooltip.show([left, top], content, null, null, offsetElement);
  };

  //============================================================

  function chart(selection) {

    selection.each(function (chartData) {

      var properties = chartData.properties,
          data = chartData.data,
          container = d3.select(this),
          that = this,
          availableWidth = (width || parseInt(container.style('width'), 10) || 960) - margin.left - margin.right,
          availableHeight = (height || parseInt(container.style('height'), 10) || 400) - margin.top - margin.bottom,
          total = d3.sum( data.map( function (d) { return d.value; }) ),
          innerWidth = availableWidth,
          innerHeight = availableHeight,
          innerMargin = {top: 0, right: 0, bottom: 0, left: 0};

      chart.update = function () {
        container.transition().duration(durationMs).call(chart);
      };

      chart.container = this;

      //------------------------------------------------------------
      // Display No Data message if there's nothing to show.

      if (!data || !data.length) {
        var noDataText = container.selectAll('.nv-noData').data([chart.strings().noData]);

        noDataText.enter().append('text')
          .attr('class', 'nvd3 nv-noData')
          .attr('dy', '-.7em')
          .style('text-anchor', 'middle');

        noDataText
          .attr('x', margin.left + availableWidth / 2)
          .attr('y', margin.top + availableHeight / 2)
          .text(function (d) {
            return d;
          });

        return chart;
      } else {
        container.selectAll('.nv-noData').remove();
      }

      //------------------------------------------------------------
      // Process data
      //add series index to each data point for reference
      var pieData = data.map(function(d, i) {
          d.series = i;
          return d;
        });

      //set state.disabled
      state.disabled = pieData.map(function (d) { return !!d.disabled; });

      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = container.selectAll('g.nv-wrap.nv-pieChart').data([pieData]),
          gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-pieChart').append('g'),
          g = wrap.select('g').attr('class', 'nv-chartWrap');

      gEnter.append('rect').attr('class', 'nv-background')
        .attr('x', -margin.left)
        .attr('y', -margin.top)
        .attr('width', availableWidth + margin.left + margin.right)
        .attr('height', availableHeight + margin.top + margin.bottom)
        .attr('fill', '#FFF');

      gEnter.append('g').attr('class', 'nv-titleWrap');
      var titleWrap = g.select('.nv-titleWrap');
      gEnter.append('g').attr('class', 'nv-pieWrap');
      var pieWrap = g.select('.nv-pieWrap');
      gEnter.append('g').attr('class', 'nv-holeWrap');
      var holeWrap = g.select('.nv-holeWrap');
      gEnter.append('g').attr('class', 'nv-legendWrap');
      var legendWrap = g.select('.nv-legendWrap');

      wrap.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

      //------------------------------------------------------------
      // Title & Legend

      if (showTitle && properties.title) {
        titleWrap.select('.nv-title').remove();

        titleWrap
          .append('text')
            .attr('class', 'nv-title')
            .attr('x', 0)
            .attr('y', 0)
            .attr('dy', '.71em')
            .attr('text-anchor', 'start')
            .text(properties.title)
            .attr('stroke', 'none')
            .attr('fill', 'black');

        innerMargin.top += parseInt(g.select('.nv-title').node().getBBox().height / 1.15, 10) +
          parseInt(g.select('.nv-title').style('margin-top'), 10) +
          parseInt(g.select('.nv-title').style('margin-bottom'), 10);
      }

      if (showLegend) {
        legend
          .id('legend_' + chart.id())
          .strings(chart.strings().legend)
          .height(availableHeight - innerMargin.top);
        legendWrap
          .datum(pieData)
          .call(legend);

        legend
          .arrange(availableWidth);
        legendWrap
          .attr('transform', 'translate(0,' + innerMargin.top + ')');
      }

      //------------------------------------------------------------
      // Recalc inner margins

      innerMargin.top += legend.height() + 4;
      innerHeight = availableHeight - innerMargin.top - innerMargin.bottom;
      innerWidth = availableWidth - innerMargin.left - innerMargin.right;

      //------------------------------------------------------------
      // Main Chart Component(s)

      pie
        .width(innerWidth)
        .height(innerHeight);

      pieWrap
        .datum(pieData.filter(function (d) { return !d.disabled; }))
        .attr('transform', 'translate(' + innerMargin.left + ',' + innerMargin.top + ')')
        .transition().duration(durationMs)
          .call(pie);

      if (hole) {
        holeWrap.select('text').remove();
        holeWrap.append('text')
          .text(hole)
          .attr('text-anchor', 'middle')
          .attr('class', 'nv-pie-hole')
          .attr('dy', '.35em')
          .style('fill', '#333')
          .style('font-size', '32px')
          .style('font-weight', 'bold');
        holeWrap
          .attr('transform', 'translate(' + (innerWidth / 2 + innerMargin.left) + ',' + (innerHeight / 2 + innerMargin.top) + ')');
      }

      //============================================================
      // Event Handling/Dispatching (in chart's scope)
      //------------------------------------------------------------

      legend.dispatch.on('legendClick', function (d, i) {
        d.disabled = !d.disabled;

        if (!pie.values()(pieData).filter(function (d) { return !d.disabled; }).length) {
          pie.values()(data).map(function (d) {
            d.disabled = false;
            wrap.selectAll('.nv-series').classed('disabled', false);
            return d;
          });
        }

        state.disabled = pieData.map(function (d) { return !!d.disabled; });
        dispatch.stateChange(state);

        container.transition().duration(durationMs).call(chart);
      });

      dispatch.on('tooltipShow', function (e) {
        if (tooltips) {
          showTooltip(e, that.parentNode, total);
        }
      });

      dispatch.on('tooltipHide', function () {
        if (tooltips) {
          nv.tooltip.cleanup();
        }
      });

      dispatch.on('tooltipMove', function (e) {
        if (tooltip) {
          nv.tooltip.position(tooltip, e.pos);
        }
      });

      // Update chart from a state object passed to event handler
      dispatch.on('changeState', function (e) {
        if (typeof e.disabled !== 'undefined') {
          pieData.forEach(function (series,i) {
            series.disabled = e.disabled[i];
          });
          state.disabled = e.disabled;
        }

        container.transition().duration(durationMs).call(chart);
      });

      dispatch.on('chartClick', function (e) {
        if (legend.enabled()) {
          legend.dispatch.closeMenu(e);
        }
      });

    });

    return chart;
  }

  //============================================================
  // Event Handling/Dispatching (out of chart's scope)
  //------------------------------------------------------------

  pie.dispatch.on('elementMouseover.tooltip', function (e) {
    dispatch.tooltipShow(e);
  });

  pie.dispatch.on('elementMouseout.tooltip', function (e) {
    dispatch.tooltipHide(e);
  });

  pie.dispatch.on('elementMousemove.tooltip', function (e) {
    dispatch.tooltipMove(e);
  });

  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  // expose chart's sub-components
  chart.dispatch = dispatch;
  chart.pie = pie;
  chart.legend = legend;

  d3.rebind(chart, pie, 'id', 'x', 'y', 'color', 'fill', 'classes', 'gradient');
  d3.rebind(chart, pie, 'valueFormat', 'values', 'description', 'showLabels', 'showLeaders', 'donutLabelsOutside', 'pieLabelsOutside', 'donut', 'donutRatio', 'labelThreshold');

  chart.colorData = function (_) {
    var colors = function (d, i) {
          return nv.utils.defaultColor()(d, i);
        },
        classes = function (d, i) {
          return 'nv-slice nv-series-' + i;
        },
        type = arguments[0],
        params = arguments[1] || {};

    switch (type) {
      case 'graduated':
        var c1 = params.c1
          , c2 = params.c2
          , l = params.l;
        colors = function (d, i) {
          return d3.interpolateHsl(d3.rgb(c1), d3.rgb(c2))(i / l);
        };
        break;
      case 'class':
        colors = function () {
          return 'inherit';
        };
        classes = function (d, i) {
          var iClass = (i * (params.step || 1)) % 14;
          return 'nv-slice nv-series-' + i + ' ' + (d.classes || 'nv-fill' + (iClass > 9 ? '' : '0') + iClass);
        };
        break;
    }

    var fill = (!params.gradient) ? colors : function (d, i) {
      return pie.gradient(d, i);
    };

    pie.color(colors);
    pie.fill(fill);
    pie.classes(classes);

    legend.color(colors);
    legend.classes(classes);

    return chart;
  };

  chart.margin = function (_) {
    if (!arguments.length) {
      return margin;
    }
    for (var prop in _) {
      if (_.hasOwnProperty(prop)) {
        margin[prop] = _[prop];
      }
    }
    return chart;
  };

  chart.width = function (_) {
    if (!arguments.length) {
      return width;
    }
    width = _;
    return chart;
  };

  chart.height = function (_) {
    if (!arguments.length) {
      return height;
    }
    height = _;
    return chart;
  };

  chart.showTitle = function (_) {
    if (!arguments.length) {
      return showTitle;
    }
    showTitle = _;
    return chart;
  };

  chart.showLegend = function (_) {
    if (!arguments.length) {
      return showLegend;
    }
    showLegend = _;
    return chart;
  };

  chart.tooltip = function (_) {
    if (!arguments.length) {
      return tooltip;
    }
    tooltip = _;
    return chart;
  };

  chart.tooltips = function (_) {
    if (!arguments.length) {
      return tooltips;
    }
    tooltips = _;
    return chart;
  };

  chart.tooltipContent = function (_) {
    if (!arguments.length) {
      return tooltipContent;
    }
    tooltipContent = _;
    return chart;
  };

  chart.state = function (_) {
    if (!arguments.length) {
      return state;
    }
    state = _;
    return chart;
  };

  chart.hole = function (_) {
    if (!arguments.length) {
      return hole;
    }
    hole = _;
    return chart;
  };

  chart.colorFill = function (_) {
    return chart;
  };

  chart.strings = function (_) {
    if (!arguments.length) {
      return strings;
    }
    for (var prop in _) {
      if (_.hasOwnProperty(prop)) {
        strings[prop] = _[prop];
      }
    }
    return chart;
  };

  //============================================================

  return chart;
};
