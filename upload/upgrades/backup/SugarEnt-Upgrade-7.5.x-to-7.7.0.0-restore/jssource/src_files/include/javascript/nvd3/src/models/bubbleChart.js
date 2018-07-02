nv.models.bubbleChart = function () {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 10, right: 10, bottom: 10, left: 10},
      width = null,
      height = null,
      showTitle = false,
      showControls = false,
      showLegend = true,
      getX = function (d) { return d.x; },
      getY = function (d) { return d.y; },
      forceY = [0], // 0 is forced by default.. this makes sense for the majority of bar graphs... user can always do chart.forceY([]) to remove
      xDomain,
      yDomain,
      delay = 200,
      groupBy = function (d) { return d.y; },
      filterBy = function (d) { return d.y; },
      clipEdge = false, // if true, masks lines within x and y scale
      seriesLength = 0,
      reduceYTicks = false, // if false a tick will show for every data point
      bubbleClick = function (e) { return; },
      format = d3.time.format("%Y-%m-%d"),
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

  var scatter = nv.models.scatter()
        .padData(true)
        .padDataOuter(0)
        .size(function (d){ return d.y; })
        .sizeRange([256,1024])
        .singlePoint(true),
      xAxis = nv.models.axis()
        .orient('bottom')
        .tickSize(0)
        .tickPadding(5)
        .highlightZero(false)
        .showMaxMin(false)
        .ticks(d3.time.months, 1)
        .tickFormat(function (d) {
          return d3.time.format('%b')(new Date(d));
        }),
      yAxis = nv.models.axis()
        .orient('left')
        .tickPadding(7)
        .highlightZero(false)
        .showMaxMin(false),
      legend = nv.models.legend()
        .align('center');

  var showTooltip = function (e, offsetElement, properties) {
    var left = e.pos[0],
        top = e.pos[1],
        x = e.point.x,
        y = e.point.y,
        content = tooltipContent(e.series.key, x, y, e, chart);

    tooltip = nv.tooltip.show([left, top], content, e.value < 0 ? 'n' : 's', null, offsetElement);
  };

  //============================================================

  function chart(selection) {

    selection.each(function (chartData) {

      var properties = chartData.properties,
          data = chartData.data,
          container = d3.select(this),
          that = this;

      chart.update = function () {
        container.transition().call(chart);
      };

      chart.container = this;

      if (!data || !data.length) {
        return chart;
      }

      //------------------------------------------------------------
      // Process data

      // Calculate the x-axis ticks
      function getTimeTicks(data) {
        function daysInMonth(date) {
          return 32 - new Date(date.getFullYear(), date.getMonth(), 32).getDate();
        }
        var timeExtent =
              d3.extent(
                d3.merge(
                  data.map(function (d) {
                    return d.values.map(function (d, i) {
                      return d3.time.format("%Y-%m-%d").parse(getX(d));
                    });
                  })
                )
              );
        var timeRange =
              d3.time.month.range(
                d3.time.month.floor(timeExtent[0]),
                d3.time.month.ceil(timeExtent[1])
              );
        var timeTicks =
              timeRange.map(function (d) {
                return d3.time.day.offset(d3.time.month.floor(d), daysInMonth(d) / 2 - 1);
              });
        return timeTicks;
      }

      // Group data by groupBy function to prep data for calculating y-axis groups
      // and y scale value for points
      function getGroupTicks(data) {

        var groupedData = d3.nest()
              .key(groupBy)
              .entries(data);

        // Calculate y scale parameters
        var gHeight = 1000 / groupedData.length,
            gOffset = gHeight * 0.25,
            gDomain = [0,1],
            gRange = [0,1],
            gScale = d3.scale.linear().domain(gDomain).range(gRange),
            yValues = [],
            total = 0;

        // Calculate total for each data group and
        // point y value
        groupedData
          .map(function (s, i) {
            s.total = 0;

            s.values = s.values.sort(function (a, b) {
                return b.y < a.y ? -1 : b.y > a.y ? 1 : 0;
              })
              .map(function (p) {
                s.total += p.y;
                return p;
              });

            s.group = i;
            return s;
          })
          .sort(function (a, b) {
            return a.total < b.total ? -1 : a.total > b.total ? 1 : 0;
          })
          .map(function (s, i) {
            total += s.total;

            gDomain = d3.extent(s.values.map(function (p){ return p.y; }));
            gRange = [gHeight * i + gOffset, gHeight * (i + 1) - gOffset];
            gScale.domain(gDomain).range(gRange);

            s.values = s.values
              .map(function (p) {
                p.group = s.group;
                p.opportunity = p.y;
                p.y = gScale(p.opportunity);
                return p;
              });

            yValues.push({y: d3.min(s.values.map(function (p){ return p.y; })), key: s.key});

            return s;
          });

        return yValues;
      }

      //set state.disabled
      state.disabled = data.map(function (d) { return !!d.disabled; });

      // Now that group calculations are done,
      // group the data by filter so that legend filters
      var filteredData = d3.nest()
            .key(filterBy)
            .entries(data);

      //add series index to each data point for reference
      filteredData = filteredData
        .sort(function (a, b){
          //sort legend by key
          return parseInt(a.key, 10) < parseInt(b.key, 10) ? -1 : parseInt(a.key, 10) > parseInt(b.key, 10) ? 1 : 0;
        })
        .map(function (d, i) {
          d.series = i;
          d.classes = d.values[0].classes;
          d.color = d.values[0].color;
          return d;
        });

      var timeExtent = d3.extent(
            d3.merge(
              filteredData.map(function (d) {
                return d.values.map(function (d, i) {
                  return d3.time.format("%Y-%m-%d").parse(d.x);
                });
              })
            )
          );

      var xD = [
        d3.time.month.floor(timeExtent[0]),
        d3.time.day.offset(d3.time.month.ceil(timeExtent[1]), -1)
      ];

      var yValues = getGroupTicks(data);

      var yD = d3.extent(
            d3.merge(
              filteredData.map(function (d) {
                return d.values.map(function (d, i) {
                  return getY(d,i);
                });
              })
            ).concat(forceY)
          );

      //------------------------------------------------------------
      // Setup Scales

      x = scatter.xScale();
      y = scatter.yScale();

      xAxis
        .scale(x);
      yAxis
        .scale(y);

      chart.render = function () {

        var width = width  || parseInt(container.style('width'), 10 || 960),
            height = height || parseInt(container.style('height'), 10 || 400),
            availableWidth = width - margin.left - margin.right,
            availableHeight = height - margin.top - margin.bottom,
            innerWidth = availableWidth,
            innerHeight = availableHeight,
            innerMargin = {top: 0, right: 0, bottom: 0, left: 0},
            maxBubbleSize = Math.sqrt(scatter.sizeRange()[1] / Math.PI);

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
        // Setup containers and skeleton of chart

        var wrap = container.selectAll('g.nv-wrap.nv-bubbleChart').data([filteredData]),
            gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-bubbleChart').append('g'),
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
        gEnter.append('g').attr('class', 'nv-bubblesWrap');
        var bubblesWrap = g.select('.nv-bubblesWrap');
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
            .height(availableHeight - innerMargin.top)
            .key(function (d){ return d.key + '%'; });
          legendWrap
            .datum(filteredData)
            .call(legend);

          legend
            .arrange(availableWidth);
          legendWrap
            .attr('transform', 'translate(0,' + innerMargin.top + ')');
        }

        // Recalc inner margins
        innerMargin.top += legend.height();
        innerHeight = availableHeight - innerMargin.top - innerMargin.bottom;

        //------------------------------------------------------------
        // Setup Axes

        //------------------------------------------------------------
        // X-Axis

        xAxis
          .tickValues(getTimeTicks(filteredData));

        xAxisWrap
          .call(xAxis);

        innerMargin[xAxis.orient()] += xAxis.height();
        innerMargin.top += maxBubbleSize;
        innerHeight = availableHeight - innerMargin.top - innerMargin.bottom;

        //------------------------------------------------------------
        // Y-Axis
        yAxis
          .ticks(yValues.length)
          .tickValues(yValues.map(function (d, i) {
            return yValues[i].y;
          }))
          .tickFormat(function (d, i) {
            return yValues[i].key;
          });

        yAxisWrap
          .call(yAxis);

        innerMargin[yAxis.orient()] += yAxis.width();
        innerWidth = availableWidth - innerMargin.left - innerMargin.right;

        //------------------------------------------------------------
        // Main Chart Components
        // Recall to set final size

        scatter
          .xDomain(xD)
          .yDomain(yD)
          .width(innerWidth)
          .height(innerHeight)
          .id(chart.id());

        bubblesWrap
          .datum(filteredData.filter(function (d) {
            return !d.disabled;
          }))
          .attr('transform', 'translate(' + innerMargin.left + ',' + innerMargin.top + ')')
          .transition().duration(chart.delay())
            .call(scatter);

        xAxisWrap
          .attr('transform', 'translate(' + innerMargin.left + ',' + (xAxis.orient() === 'bottom' ? innerHeight + innerMargin.top : innerMargin.top) + ')')
          .transition()
            .call(xAxis);

        yAxis
          .tickSize(-innerWidth, 0);

        yAxisWrap
          .attr('transform', 'translate(' + (yAxis.orient() === 'left' ? innerMargin.left : innerMargin.left + innerWidth) + ',' + innerMargin.top + ')')
          .transition()
            .call(yAxis);

      };

      //============================================================
      // Event Handling/Dispatching (in chart's scope)
      //------------------------------------------------------------

      legend.dispatch.on('legendClick', function (d, i) {
        d.disabled = !d.disabled;

        if (!data.filter(function (d) {
          return !d.disabled;
        }).length) {
          data.map(function (d) {
            d.disabled = false;
            g.selectAll('.nv-series').classed('disabled', false);
            return d;
          });
        }

        state.disabled = data.map(function (d) {
          return !!d.disabled;
        });
        dispatch.stateChange(state);

        container.transition().call(chart.render);
      });

      dispatch.on('tooltipShow', function (e) {
        if (tooltips) {
          showTooltip(e, that.parentNode);
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
          data.forEach(function (series,i) {
            series.disabled = e.disabled[i];
          });
          state.disabled = e.disabled;
        }

        container.transition().call(chart);
      });

      dispatch.on('chartClick', function (e) {
        if (legend.enabled()) {
          legend.dispatch.closeMenu(e);
        }
      });

      //============================================================

      chart.render();
    });

    return chart;
  }

  //============================================================
  // Event Handling/Dispatching (out of chart's scope)
  //------------------------------------------------------------

  scatter.dispatch.on('elementMouseover.tooltip', function (e) {
    dispatch.tooltipShow(e);
  });

  scatter.dispatch.on('elementMouseout.tooltip', function (e) {
    dispatch.tooltipHide(e);
  });

  scatter.dispatch.on('elementMousemove.tooltip', function (e) {
    dispatch.tooltipMove(e);
  });

  scatter.dispatch.on('elementClick', function (e) {
    bubbleClick(e);
    nv.tooltip.cleanup();
  });

  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  // expose chart's sub-components
  chart.dispatch = dispatch;
  chart.scatter = scatter;
  chart.legend = legend;
  chart.xAxis = xAxis;
  chart.yAxis = yAxis;

  d3.rebind(chart, scatter, 'id', 'x', 'y', 'xScale', 'yScale', 'xDomain', 'yDomain', 'forceX', 'forceY', 'clipEdge', 'delay', 'color', 'fill', 'classes', 'gradient');
  d3.rebind(chart, scatter, 'size', 'zScale', 'sizeDomain', 'forceSize', 'interactive', 'clipVoronoi', 'clipRadius');
  d3.rebind(chart, xAxis, 'rotateTicks', 'reduceXTicks', 'staggerTicks', 'wrapTicks');

  chart.colorData = function (_) {
    var colors = function (d, i) {
          return nv.utils.defaultColor()(d, d.series);
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
        return d3.interpolateHsl(d3.rgb(c1), d3.rgb(c2))(d.series / l);
      };
      break;
    case 'class':
      colors = function () {
        return 'inherit';
      };
      classes = function (d, i) {
        var iClass = (d.series*(params.step || 1)) % 14;
        return 'nv-group nv-series-' + i + ' ' + (d.classes || 'nv-fill' + (iClass > 9 ? '' : '0') + iClass);
      };
      break;
    }

    var fill = (!params.gradient) ? colors : function (d,i) {
      return scatter.gradient(d,d.series);
    };

    scatter.color(colors);
    scatter.fill(fill);
    scatter.classes(classes);

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

  chart.delay = function(_) {
    if (!arguments.length) {
      return delay;
    }
    delay = _;
    return chart;
  };

  chart.bubbleClick = function (_) {
    if (!arguments.length) {
      return bubbleClick;
    }
    bubbleClick = _;
    return chart;
  };

  chart.groupBy = function (_) {
    if (!arguments.length) {
      return groupBy;
    }
    groupBy = _;
    return chart;
  };

  chart.filterBy = function (_) {
    if (!arguments.length) {
      return filterBy;
    }
    filterBy = _;
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
