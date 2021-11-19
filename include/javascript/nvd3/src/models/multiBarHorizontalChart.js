nv.models.multiBarHorizontalChart = function () {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 10, right: 10, bottom: 10, left: 10},
      width = null,
      height = null,
      showTitle = false,
      showControls = false,
      showLegend = true,
      tooltip = null,
      tooltips = true,
      tooltipContent = function (key, x, y, e, graph) {
        return '<h3>' + key + '</h3>' +
               '<p>' +  y + ' on ' + x + '</p>';
      },
      x,
      y,
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

  var multibar = nv.models.multiBar()
        .vertical(false)
        .stacked(false),
      xAxis = nv.models.axis()
        .orient('left')
        .tickSize(0)
        .tickPadding(7)
        .highlightZero(false)
        .showMaxMin(false)
        .tickFormat(function (d) { return d; }),
      yAxis = nv.models.axis()
        .orient('bottom')
        .tickPadding(4)
        .tickFormat(d3.format(',.1f')),
      legend = nv.models.legend()
        .align('right'),
      controls = nv.models.legend()
        .align('left')
        .color(['#444']);

  var showTooltip = function (e, offsetElement, groupTotals) {
    var left = e.pos[0],
        top = e.pos[1],
        x = (groupTotals) ?
              (e.point.y * 100 / groupTotals[e.pointIndex].t).toFixed(1) :
              xAxis.tickFormat()(multibar.x()(e.point, e.pointIndex)),
        y = yAxis.tickFormat()(multibar.y()(e.point, e.pointIndex)),
        content = tooltipContent(e.series.key, x, y, e, chart);

    tooltip = nv.tooltip.show([left, top], content, e.value < 0 ? 'e' : 'w', null, offsetElement);
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
          innerWidth = availableWidth,
          innerHeight = availableHeight,
          innerMargin = {top: 0, right: 0, bottom: 0, left: 0},
          maxControlsWidth = 0,
          maxLegendWidth = 0,
          widthRatio = 0;

      chart.update = function () {
        container.transition().call(chart);
      };

      chart.container = this;

      //------------------------------------------------------------
      // Display No Data message if there's nothing to show.

      if (!data || !data.length || !data.filter(function (d) {
        return d.values.length;
      }).length) {
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

      //set state.disabled
      state.disabled = data.map(function (d) { return !!d.disabled; });
      state.stacked = !multibar.stacked();

      var dataBars = data.filter(function (d) {
            return !d.disabled && (!d.type || d.type === 'bar');
          }),
          groupLabels = properties.labels,
          groupTotals = properties.values;
      dataBars = dataBars.length ? dataBars : [{values:[]}];

      var controlsData = [
        { key: 'Grouped', disabled: !state.stacked },
        { key: 'Stacked', disabled: state.stacked }
      ];

      //------------------------------------------------------------
      // Setup Scales

      x = multibar.xScale();
      y = multibar.yScale();

      xAxis
        .scale(x);
      yAxis
        .scale(y);

      if (groupLabels) {
        xAxis
          .tickFormat(function (d, i) {
            return groupLabels[i] ? groupLabels[i].l : 'undefined';
          });
      }

      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = container.selectAll('g.nv-wrap.nv-multiBarHorizontalChart').data([data]),
          gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-multiBarHorizontalChart').append('g'),
          g = wrap.select('g').attr('class', 'nv-chartWrap');

      gEnter.append('rect').attr('class', 'nv-background')
        .attr('x', -margin.left)
        .attr('y', -margin.top)
        .attr('width', availableWidth + margin.left + margin.right)
        .attr('height', availableHeight + margin.top + margin.bottom)
        .attr('fill', '#FFF');

      gEnter.append('g').attr('class', 'nv-titleWrap');
      var titleWrap = g.select('.nv-titleWrap');
      gEnter.append('g').attr('class', 'nv-x nv-axis');
      var xAxisWrap = g.select('.nv-x.nv-axis');
      gEnter.append('g').attr('class', 'nv-y nv-axis');
      var yAxisWrap = g.select('.nv-y.nv-axis');
      gEnter.append('g').attr('class', 'nv-barsWrap');
      var barsWrap = g.select('.nv-barsWrap');
      gEnter.append('g').attr('class', 'nv-controlsWrap');
      var controlsWrap = g.select('.nv-controlsWrap');
      gEnter.append('g').attr('class', 'nv-legendWrap');
      var legendWrap = g.select('.nv-legendWrap');

      wrap.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

      //------------------------------------------------------------
      // Title & Legend & Controls

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

      if (showControls) {
        controls
          .id('controls_' + chart.id())
          .strings(chart.strings().controls)
          .height(availableHeight - innerMargin.top);
        controlsWrap
          .datum(controlsData)
          .call(controls);

        maxControlsWidth = controls.calculateWidth() + controls.margin().left;
      }

      if (showLegend) {
        if (multibar.barColor()) {
          data.forEach(function (series, i) {
            series.color = d3.rgb('#ccc').darker(i * 1.5).toString();
          });
        }

        legend
          .id('legend_' + chart.id())
          .strings(chart.strings().legend)
          .height(availableHeight - innerMargin.top);
        legendWrap
          .datum(data)
          .call(legend);

        maxLegendWidth = legend.calculateWidth() + legend.margin().right;
      }

      // calculate proportional available space
      widthRatio = availableWidth / (maxControlsWidth + maxLegendWidth);

      if (showControls) {
        controls
          .arrange(Math.floor(widthRatio * maxControlsWidth));
        controlsWrap
          .attr('transform', 'translate(0,' + innerMargin.top + ')');
      }

      if (showLegend) {
        legend
          .arrange(Math.floor(availableWidth - controls.width() + legend.margin().right));
        legendWrap
          .attr('transform', 'translate(' + (controls.width() - controls.margin().left) + ',' + innerMargin.top + ')');
      }

      //------------------------------------------------------------
      // Recalc inner margins

      innerMargin.top += Math.max(legend.height(), controls.height()) + 4;
      innerHeight = availableHeight - innerMargin.top - innerMargin.bottom;

      //------------------------------------------------------------
      // Main Chart Component(s)

      multibar
        .disabled(data.map(function (series) { return series.disabled; }))
        .width(innerWidth)
        .height(innerHeight)
        .id(chart.id());
      barsWrap
        .datum(dataBars)
        .call(multibar);

      //------------------------------------------------------------
      // Setup Axes

      //------------------------------------------------------------
      // X-Axis

      xAxisWrap
        .call(xAxis);

      innerMargin[xAxis.orient()] += xAxis.width();
      innerWidth = availableWidth - innerMargin.left - innerMargin.right;

      //------------------------------------------------------------
      // Y-Axis

      yAxisWrap
        .call(yAxis);

      innerMargin[yAxis.orient()] += yAxis.height();
      innerHeight = availableHeight - innerMargin.top - innerMargin.bottom;

      //------------------------------------------------------------
      // Main Chart Components
      // Recall to set final size

      multibar
        .width(innerWidth)
        .height(innerHeight);

      barsWrap
        .attr('transform', 'translate(' + innerMargin.left + ',' + innerMargin.top + ')')
        .transition()
          .call(multibar);

      xAxisWrap
        .attr('transform', 'translate(' + (xAxis.orient() === 'left' ? innerMargin.left : innerMargin.left + innerWidth) + ',' + innerMargin.top + ')')
        .transition()
          .call(xAxis);

      yAxis
        .ticks(innerWidth / 50)
        .tickSize(-innerHeight, 0);

      yAxisWrap
        .attr('transform', 'translate(' + innerMargin.left + ',' + (yAxis.orient() === 'bottom' ? innerHeight + innerMargin.top : innerMargin.top) + ')')
        .transition()
          .call(yAxis);

      //============================================================
      // Event Handling/Dispatching (in chart's scope)
      //------------------------------------------------------------

      legend.dispatch.on('legendClick', function (d, i) {
        d.disabled = !d.disabled;

        if (!data.filter(function (d) { return !d.disabled; }).length) {
          data.map(function (d) {
            d.disabled = false;
            g.selectAll('.nv-series').classed('disabled', false);
            return d;
          });
        }

        state.disabled = data.map(function (d) { return !!d.disabled; });
        dispatch.stateChange(state);

        container.transition().call(chart);
      });

      controls.dispatch.on('legendClick', function (d, i) {

        if (!d.disabled) {
          return;
        }

        controlsData = controlsData.map(function (s) {
          s.disabled = true;
          return s;
        });
        d.disabled = false;

        switch (d.key) {
        case 'Grouped':
          multibar.stacked(false);
          break;
        case 'Stacked':
          multibar.stacked(true);
          break;
        }

        state.stacked = multibar.stacked();
        dispatch.stateChange(state);

        container.transition().call(chart);
      });

      dispatch.on('tooltipShow', function (e) {
        if (tooltips) {
          showTooltip(e, that.parentNode, groupTotals);
        }
      });

      dispatch.on('tooltipHide', function () {
        if (tooltips) {
          nv.tooltip.cleanup();
        }
      });

      dispatch.on('tooltipMove', function (e) {
        if (tooltip) {
          nv.tooltip.position(tooltip, e.pos, 'w');
        }
      });

      // Update chart from a state object passed to event handler
      dispatch.on('changeState', function (e) {
        if (typeof e.disabled !== 'undefined') {
          data.forEach(function (series,i) {
            series.disabled = e.disabled[i];
          });
          state.disabled = e.disabled;
        }

        if (typeof e.stacked !== 'undefined') {
          multibar.stacked(e.stacked);
          state.stacked = e.stacked;
        }

        container.transition().call(chart);
      });

      dispatch.on('chartClick', function (e) {
        if (controls.enabled()) {
          controls.dispatch.closeMenu(e);
        }
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

  multibar.dispatch.on('elementMouseover.tooltip', function (e) {
    dispatch.tooltipShow(e);
  });

  multibar.dispatch.on('elementMouseout.tooltip', function (e) {
    dispatch.tooltipHide(e);
  });

  multibar.dispatch.on('elementMousemove.tooltip', function (e) {
    dispatch.tooltipMove(e);
  });

  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  // expose chart's sub-components
  chart.dispatch = dispatch;
  chart.multibar = multibar;
  chart.legend = legend;
  chart.controls = controls;
  chart.xAxis = xAxis;
  chart.yAxis = yAxis;

  d3.rebind(chart, multibar, 'id', 'x', 'y', 'xScale', 'yScale', 'xDomain', 'yDomain', 'forceX', 'forceY', 'clipEdge', 'delay', 'color', 'fill', 'classes', 'gradient');
  d3.rebind(chart, multibar, 'stacked', 'showValues', 'valueFormat');
  d3.rebind(chart, xAxis, 'rotateTicks', 'reduceXTicks', 'staggerTicks', 'wrapTicks');
  d3.rebind(chart, legend, 'closeMenu');

  chart.colorData = function (_) {
    var colors = function (d, i) {
          return nv.utils.defaultColor()(d, i);
        },
        classes = function (d, i) {
          return 'nv-group nv-series-' + i;
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
        return 'nv-group nv-series-' + i + ' ' + (d.classes || 'nv-fill' + (iClass > 9 ? '' : '0') + iClass);
      };
      break;
    }

    var fill = (!params.gradient) ? colors : function (d, i) {
      var p = {orientation: params.orientation || 'horizontal', position: params.position || 'middle'};
      return multibar.gradient(d, i, p);
    };

    multibar.color(colors);
    multibar.fill(fill);
    multibar.classes(classes);

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

  chart.showControls = function (_) {
    if (!arguments.length) {
      return showControls;
    }
    showControls = _;
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
