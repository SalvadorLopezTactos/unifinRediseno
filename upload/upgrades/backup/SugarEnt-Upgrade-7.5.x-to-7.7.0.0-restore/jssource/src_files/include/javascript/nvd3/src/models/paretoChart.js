nv.models.paretoChart = function () {
  //'use strict';
  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 10, right: 10, bottom: 10, left: 10},
      width = null,
      height = null,
      getX = function (d) { return d.x; },
      getY = function (d) { return d.y; },
      showTitle = false,
      showLegend = true,
      tooltip = null,
      tooltips = true,
      tooltipBar = function (key, x, y, e, graph) {
        return '<p><b>' + key + '</b></p>' +
          '<p><b>' + y + '</b></p>' +
          '<p><b>' + x + '%</b></p>';
      },
      tooltipLine = function (key, x, y, e, graph) {
        return '<p><p>' + key + ': <b>' + y + '</b></p>';
      },
      tooltipQuota = function (key, x, y, e, graph) {
        return '<p>' + e.key + ': <b>' + y + '</b></p>';
      },
      yAxisTickFormat = function (d) {
        return d3.format(',.2s')(d);
      },
      quotaTickFormat = function (d) {
        return d3.format(',.3s')(d);
      },
      x,
      y,
      strings = {
        barlegend: {close: 'Hide bar legend', open: 'Show bar legend'},
        linelegend: {close: 'Hide line legend', open: 'Show line legend'},
        controls: {close: 'Hide controls', open: 'Show controls'},
        noData: 'No Data Available.'
      },
      dispatch = d3.dispatch('chartClick', 'tooltipShow', 'tooltipHide', 'tooltipMove');

  //============================================================
  // Private Variables
  //------------------------------------------------------------

  var multibar = nv.models.multiBar()
        .stacked(true)
        .clipEdge(false)
        .withLine(true),
      lines1 = nv.models.line()
        .useVoronoi(false),
      lines2 = nv.models.line()
        .useVoronoi(true),
      xAxis = nv.models.axis()
        .orient('bottom')
        .tickSize(0)
        .tickPadding(7)
        .wrapTicks(true)
        .highlightZero(false)
        .showMaxMin(false)
        .tickFormat(function (d) { return d; }),
      yAxis = nv.models.axis()
        .orient('left')
        .tickPadding(7)
        .showMaxMin(false),
      barLegend = nv.models.legend()
        .align('left')
        .position('middle'),
      lineLegend = nv.models.legend()
        .align('right')
        .position('middle');

  var showTooltip = function (e, offsetElement, dataGroup) {
    var left = e.pos[0],
        top = e.pos[1],
        per = (e.point.y * 100 / dataGroup[e.pointIndex].t).toFixed(1),
        amt = yAxis.tickFormat()(lines2.y()(e.point, e.pointIndex)),
        content = (e.series.type === 'bar' ? tooltipBar(e.series.key, per, amt, e, chart) : tooltipLine(e.series.key, per, amt, e, chart));

    tooltip = nv.tooltip.show([left, top], content, 's', null, offsetElement);
  };

  var showQuotaTooltip = function (e, offsetElement) {
    var left = e.pos[0],
        top = e.pos[1],
        amt = d3.format(',.2s')(e.val),
        content = tooltipQuota(e.key, 0, amt, e, chart);

    tooltip = nv.tooltip.show([left, top], content, 's', null, offsetElement);
  };

  var barClick = function (data, e, container) {
    var d = e.series,
        selectedSeries = e.seriesIndex;

    d.disabled = !d.disabled;

    if (!chart.stacked()) {
      data.filter(function (d) {
        return d.series === selectedSeries && d.type === 'line';
      }).map(function (d) {
        d.disabled = !d.disabled;
        return d;
      });
    }

    // if there are no enabled data series, enable them all
    if (!data.filter(function (d) {
      return !d.disabled && d.type === 'bar';
    }).length) {
      data.map(function (d) {
        d.disabled = false;
        container.selectAll('.nv-series').classed('disabled', false);
        return d;
      });
    }

    container.call(chart);
  };

  var getAbsoluteXY = function (element) {
    var viewportElement = document.documentElement,
        box = element.getBoundingClientRect(),
        scrollLeft = viewportElement.scrollLeft + document.body.scrollLeft,
        scrollTop = viewportElement.scrollTop + document.body.scrollTop,
        x = box.left + scrollLeft,
        y = box.top + scrollTop;

    return {"x": x, "y": y};
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
          maxBarLegendWidth = 0,
          maxLineLegendWidth = 0,
          widthRatio = 0;

      chart.update = function () {
        container.call(chart);
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

      var dataBars = data.filter(function (d) {
            return !d.disabled && (!d.type || d.type === 'bar');
          }),
          dataLines = data.filter(function (d) {
            return !d.disabled && d.type === 'line';
          }).map(function(lineData) {
            if (!multibar.stacked()) {
              lineData.values = lineData.valuesOrig.map(function(v, i) {
                return {'series': v.series, 'x': (v.x + v.series * 0.25 - i * 0.25), 'y': v.y};
              });
            } else {
              lineData.values.map(function(v) {
                v.y = 0;
              });
              dataBars
                .map(function(v, i) {
                  v.values.map(function(v, i) {
                    lineData.values[i].y += v.y;
                  });
                });
              lineData.values.map(function(v, i) {
                if (i > 0) {
                  v.y += lineData.values[i - 1].y;
                }
              });
            }
            return lineData;
          }),
          dataGroup = properties.groupData,
          quotaValue = properties.quota || 0,
          quotaLabel = properties.quotaLabel || '',
          targetQuotaValue = properties.targetQuota || 0,
          targetQuotaLabel = properties.targetQuotaLabel || '';

      dataBars = dataBars.length ? dataBars : [{values:[]}];
      dataLines = dataLines.length ? dataLines : [{values: []}];

      // line legend data
      var lineLegendData = [{'key': quotaLabel, 'type': 'dash', 'color': '#444', 'values': {'series': 0, 'x': 0, 'y': 0}}];
      if (targetQuotaValue > 0) {
        lineLegendData.push({'key': targetQuotaLabel, 'type': 'dash', 'color': '#777', 'values': {'series': 0, 'x': 0, 'y': 0}});
      }

      var seriesX = data.filter(function (d) {
            return !d.disabled;
          }).map(function (d) {
            return d.valuesOrig.map(function (d, i) {
              return getX(d, i);
            });
          });

      var seriesY = data.map(function (d) {
            return d.valuesOrig.map(function (d, i) {
              return getY(d, i);
            });
          });

      //------------------------------------------------------------
      // Setup Scales

      x = multibar.xScale();
      y = multibar.yScale();

      xAxis
        .scale(x);
      yAxis
        .scale(y)
        .tickFormat(yAxisTickFormat);

      if (dataGroup.length) {
        xAxis
          .tickFormat(function (d, i) {
            return dataGroup[i] ? dataGroup[i].l : 'asfd';
          });
      }

      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = container.selectAll('g.nv-wrap.nv-multiBarWithLegend').data([data]),
          gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-multiBarWithLegend').append('g'),
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
      gEnter.append('g').attr('class', 'nv-quotaWrap');
      var quotaWrap = g.select('.nv-quotaWrap');

      gEnter.append('g').attr('class', 'nv-linesWrap1');
      var linesWrap1 = g.select('.nv-linesWrap1');
      gEnter.append('g').attr('class', 'nv-linesWrap2');
      var linesWrap2 = g.select('.nv-linesWrap2');

      gEnter.append('g').attr('class', 'nv-legendWrap nv-barLegend');
      var barLegendWrap = g.select('.nv-legendWrap.nv-barLegend');
      gEnter.append('g').attr('class', 'nv-legendWrap nv-lineLegend');
      var lineLegendWrap = g.select('.nv-legendWrap.nv-lineLegend');

      wrap.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

      //------------------------------------------------------------
      // Title & Legend

      if (showTitle && properties.title) {
        titleWrap.select('.nv-title').remove();

        titleWrap
          .append('text')
            .text(properties.title)
            .attr('class', 'nv-title')
            .attr('x', 0)
            .attr('y', 0)
            .attr('dy', '.71em')
            .attr('text-anchor', 'start')
            .attr('stroke', 'none')
            .attr('fill', 'black');

        innerMargin.top += parseInt(g.select('.nv-title').node().getBoundingClientRect().height / 1.15, 10) +
          parseInt(g.select('.nv-title').style('margin-top'), 10) +
          parseInt(g.select('.nv-title').style('margin-bottom'), 10);
      }

      if (showLegend) {

        // bar series legend
        barLegend
          .id('barlegend_' + chart.id())
          .strings(chart.strings().barlegend)
          .height(availableHeight - innerMargin.top);
        barLegendWrap
          .datum(
            data.filter(function (d) {
              return d.type === 'bar';
            })
          )
          .call(barLegend);

        maxBarLegendWidth = barLegend.calculateWidth() + barLegend.margin().left;

        // line series legend
        lineLegend
          .id('linelegend_' + chart.id())
          .strings(chart.strings().linelegend)
          .height(availableHeight - innerMargin.top);
        lineLegendWrap
          .datum(
            data.filter(function (d) {
              return d.type === 'line';
            }).concat(lineLegendData)
          )
          .call(lineLegend);

        maxLineLegendWidth = lineLegend.calculateWidth() + lineLegend.margin().right;

        // calculate proportional available space
        widthRatio = availableWidth / (maxBarLegendWidth + maxLineLegendWidth);

        barLegend
          .arrange(Math.floor(widthRatio * maxBarLegendWidth));
        barLegendWrap
          .attr('transform', 'translate(0,' + innerMargin.top + ')');

        lineLegend
          .arrange(Math.floor(availableWidth - barLegend.width() + lineLegend.margin().right));
        lineLegendWrap
          .attr('transform', 'translate(' + (barLegend.width() - barLegend.margin().left) + ',' + innerMargin.top + ')');
      }

      //------------------------------------------------------------
      // Recalculate inner margins based on legend size

      innerMargin.top += Math.max(barLegend.height(), lineLegend.height()) + 4;
      innerHeight = availableHeight - innerMargin.top - innerMargin.bottom;

      //------------------------------------------------------------
      // Initial call of Main Chart Components

      var lx = x.domain(d3.merge(seriesX)).rangeBands([0, availableWidth - margin.left - margin.right], 0.3),
          ly = Math.max(d3.max(d3.merge(seriesY)), quotaValue, targetQuotaValue || 0),
          forceY = Math.round(ly * 0.1) * 10,
          lOffset = lx(1) + lx.rangeBand() / (multibar.stacked() || dataLines.length === 1 ? 2 : 4);

      // Main Bar Chart
      multibar
        .width(innerWidth)
        .height(innerHeight)
        .forceY([0, forceY])
        .id(chart.id());
      barsWrap
        .datum(dataBars)
        .call(multibar);

      // Main Line Chart
      lines1
        .margin({top: 0, right: lOffset, bottom: 0, left: lOffset})
        .width(innerWidth)
        .height(innerHeight)
        .forceY([0, forceY])
        .useVoronoi(false)
        .id('outline_' + chart.id());
      lines2
        .margin({top: 0, right: lOffset, bottom: 0, left: lOffset})
        .width(innerWidth)
        .height(innerHeight)
        .forceY([0, forceY])
        .useVoronoi(false)
        .size(function(){ return Math.pow(6,2) * Math.PI; })
        .id('foreground_' + chart.id());
      linesWrap1
        .datum(dataLines)
        .call(lines1);
      linesWrap2
        .datum(dataLines)
        .call(lines2);

      // Axis
      xAxisWrap
        .call(xAxis);
      yAxisWrap
        .style('opacity', dataBars.length ? 1 : 0)
        .call(yAxis);

      //------------------------------------------------------------
      // Calculate intial dimensions based on first Axis call

      innerWidth = availableWidth - innerMargin.left - innerMargin.right - yAxis.width();
      innerHeight = availableHeight - innerMargin.top - innerMargin.bottom - xAxis.height();

      //------------------------------------------------------------
      // Recall Main Chart and Axis

      multibar
        .width(innerWidth)
        .height(innerHeight);
      barsWrap
        .call(multibar);
      xAxisWrap
        .call(xAxis);
      yAxisWrap
        .call(yAxis);

      //------------------------------------------------------------
      // Recalculate final dimensions based on new Axis size

      innerMargin[yAxis.orient()] += yAxis.width();
      innerWidth = availableWidth - innerMargin.left - innerMargin.right;
      innerMargin[xAxis.orient()] += xAxis.height();
      innerHeight = availableHeight - innerMargin.top - innerMargin.bottom;

      //------------------------------------------------------------
      // Quota Line

      quotaWrap.selectAll('line').remove();
      yAxisWrap.selectAll('text.nv-quotaValue').remove();
      yAxisWrap.selectAll('text.nv-targetQuotaValue').remove();
      var tickTextHeight = 14;

      if (quotaValue > 0) {

        quotaWrap.append('line')
          .attr('class', 'nv-quotaLine')
          .attr('x1', 0)
          .attr('y1', 0)
          .attr('x2', innerWidth)
          .attr('y2', 0)
          .attr('transform', 'translate(0,' + y(quotaValue) + ')')
          .style('stroke-dasharray', '8, 8');

        quotaWrap.append('line')
          .datum({key:quotaLabel, val:quotaValue})
          .attr('class', 'nv-quotaLine nv-quotaLineBackground')
          .attr('x1', 0)
          .attr('y1', 0)
          .attr('x2', innerWidth)
          .attr('y2', 0)
          .attr('transform', 'translate(0,' + y(quotaValue) + ')');

        // Quota line label
        yAxisWrap.append('text')
          .text(chart.quotaTickFormat()(quotaValue))
          .attr('class', 'nv-quotaValue')
          .attr('dy', '.36em')
          .attr('dx', '0')
          .attr('text-anchor', 'end')
          .attr('transform', 'translate(' + -yAxis.tickPadding() + ',' + y(quotaValue) + ')');

        tickTextHeight = Math.round(parseInt(g.select('text.nv-quotaValue').node().getBoundingClientRect().height, 10) / 1.15);
        //check if tick lines overlap quota values, if so, hide the values that overlap
        yAxisWrap.selectAll('g.tick')
          .each(function(d, i) {
            if (y(d) <= y(quotaValue) + tickTextHeight && y(d) >= y(quotaValue) - tickTextHeight) {
              d3.select(this).select('line').style('opacity', 0);
              d3.select(this).select('text').style('opacity', 0);
            }
          });
        if (yAxis.showMaxMin) {
          yAxisWrap.selectAll('g.nv-axisMaxMin')
            .each(function(d, i) {
              if (Math.abs(y(d) - y(quotaValue)) <= tickTextHeight) {
                d3.select(this).select('text').style('opacity', 0);
              }
            });
        }
      }

      // Target Quota Line
      if (targetQuotaValue > 0) {

        quotaWrap.append('line')
          .attr('class', 'nv-quotaLineTarget')
          .attr('x1', 0)
          .attr('y1', 0)
          .attr('x2', innerWidth)
          .attr('y2', 0)
          .attr('transform', 'translate(0,' + y(targetQuotaValue) + ')')
          .style('stroke-dasharray', '8, 8');

        quotaWrap.append('line')
          .datum({key:targetQuotaLabel, val:targetQuotaValue})
          .attr('class', 'nv-quotaLineTarget nv-quotaLineBackground')
          .attr('x1', 0)
          .attr('y1', 0)
          .attr('x2', innerWidth)
          .attr('y2', 0)
          .attr('transform', 'translate(0,' + y(targetQuotaValue) + ')');

        // Target Quota line label
        yAxisWrap.append('text')
          .text(chart.quotaTickFormat()(targetQuotaValue))
          .attr('class', 'nv-targetQuotaValue')
          .attr('dy', '.36em')
          .attr('dx', '0')
          .attr('text-anchor', 'end')
          .attr('transform', 'translate(' + -yAxis.tickPadding() + ',' + y(targetQuotaValue) + ')');

        tickTextHeight = Math.round(parseInt(g.select('text.nv-targetQuotaValue').node().getBoundingClientRect().height, 10) / 1.15);
        //check if tick lines overlap quota values, if so, hide the values that overlap
        yAxisWrap.selectAll('g.tick')
          .each(function(d, i) {
            if (y(d) <= y(targetQuotaValue) + tickTextHeight && y(d) >= y(targetQuotaValue) - tickTextHeight) {
              d3.select(this).select('text').style('opacity', 0);
              d3.select(this).select('line').style('opacity', 0);
            }
          });
        if (yAxis.showMaxMin) {
          yAxisWrap.selectAll('g.nv-axisMaxMin')
            .each(function(d, i) {
              if (Math.abs(y(d) - y(targetQuotaValue)) <= tickTextHeight) {
                d3.select(this).select('text').style('opacity', 0);
              }
            });
        }
      }

      quotaWrap.selectAll('line.nv-quotaLineBackground')
        .on('mouseover', function (d) {
          var e = {
            pos: [d3.event.pageX, d3.event.pageY],
            val: d.val,
            key: d.key
          };
          showQuotaTooltip(e, that.parentNode);
        })
        .on('mouseout', function () {
          dispatch.tooltipHide();
        })
        .on('mousemove', function () {
          dispatch.tooltipMove({
            pos: [d3.event.pageX, d3.event.pageY]
          });
        });

      //------------------------------------------------------------
      // Recall Main Chart Components based on final dimensions

      multibar
        .width(innerWidth)
        .height(innerHeight);

      barsWrap
        .attr('transform', 'translate(' + innerMargin.left + ',' + innerMargin.top + ')')
        .call(multibar);

      lines1
        .width(innerWidth)
        .height(innerHeight);
      lines2
        .width(innerWidth)
        .height(innerHeight);

      linesWrap1
        .attr('transform', 'translate(' + innerMargin.left + ',' + innerMargin.top + ')')
        .call(lines1);
      linesWrap2
        .attr('transform', 'translate(' + innerMargin.left + ',' + innerMargin.top + ')')
        .call(lines2);

      quotaWrap
        .attr('transform', 'translate(' + innerMargin.left + ',' + innerMargin.top + ')');

      xAxisWrap
        .attr('transform', 'translate(' + innerMargin.left + ',' + (xAxis.orient() === 'bottom' ? innerHeight + innerMargin.top : innerMargin.top) + ')')
        .call(xAxis);

      yAxis
        .ticks(innerHeight / 100)
        .tickSize(-innerWidth, 0);

      yAxisWrap
        .attr('transform', 'translate(' + (yAxis.orient() === 'left' ? innerMargin.left : innerMargin.left + innerWidth) + ',' + innerMargin.top + ')')
        .call(yAxis);

      //============================================================
      // Event Handling/Dispatching (in chart's scope)
      //------------------------------------------------------------

      barLegend.dispatch.on('legendClick', function (d, i) {
        var selectedSeries = d.series;
        //swap bar disabled
        d.disabled = !d.disabled;
        //swap line disabled for same series
        if (!chart.stacked()) {
          data.filter(function (d) {
            return d.series === selectedSeries && d.type === 'line';
          }).map(function (d) {
            d.disabled = !d.disabled;
            return d;
          });
        }
        // if there are no enabled data series, enable them all
        if (!data.filter(function (d) {
          return !d.disabled && d.type === 'bar';
        }).length) {
          data.map(function (d) {
            d.disabled = false;
            g.selectAll('.nv-series').classed('disabled', false);
            return d;
          });
        }
        container.call(chart);
      });

      dispatch.on('tooltipShow', function (e) {
        if (tooltips) {
          showTooltip(e, that.parentNode, dataGroup);
        }
      });

      dispatch.on('tooltipHide', function () {
        if (tooltips) {
          nv.tooltip.cleanup();
        }
      });

      dispatch.on('tooltipMove', function (e) {
        if (tooltip) {
          nv.tooltip.position(tooltip, e.pos, 's');
        }
      });

      dispatch.on('chartClick', function (e) {
        if (barLegend.enabled()) {
          barLegend.dispatch.closeMenu(e);
        }
        if (lineLegend.enabled()) {
          lineLegend.dispatch.closeMenu(e);
        }
      });

      multibar.dispatch.on('elementClick', function (e) {
        barClick(data, e, container);
      });

    });

    return chart;
  }

  //============================================================
  // Event Handling/Dispatching (out of chart's scope)
  //------------------------------------------------------------

  lines2.dispatch.on('elementMouseover.tooltip', function (e) {
    dispatch.tooltipShow(e);
  });

  lines2.dispatch.on('elementMouseout.tooltip', function (e) {
    dispatch.tooltipHide(e);
  });

  lines2.dispatch.on('elementMousemove', function (e) {
    dispatch.tooltipMove(e);
  });

  multibar.dispatch.on('elementMouseover.tooltip', function (e) {
    dispatch.tooltipShow(e);
  });

  multibar.dispatch.on('elementMouseout.tooltip', function (e) {
    dispatch.tooltipHide(e);
  });

  multibar.dispatch.on('elementMousemove', function (e) {
    dispatch.tooltipMove(e);
  });


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  // expose chart's sub-components
  chart.dispatch = dispatch;
  chart.lines1 = lines1;
  chart.lines2 = lines2;
  chart.multibar = multibar;
  chart.barLegend = barLegend;
  chart.lineLegend = lineLegend;
  chart.xAxis = xAxis;
  chart.yAxis = yAxis;

  d3.rebind(chart, multibar, 'id', 'x', 'y', 'xScale', 'yScale', 'xDomain', 'yDomain', 'forceX', 'forceY', 'clipEdge', 'color', 'fill', 'classes', 'gradient');
  d3.rebind(chart, multibar, 'stacked', 'showValues', 'valueFormat');
  d3.rebind(chart, xAxis, 'rotateTicks', 'reduceXTicks', 'staggerTicks', 'wrapTicks');

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
      var p = {orientation: params.orientation || 'vertical', position: params.position || 'middle'};
      return multibar.gradient(d, i, p);
    };

    multibar.color(colors);
    multibar.fill(fill);
    multibar.classes(classes);

    lines1.color(function (d, i) { return '#FFF'; });
    lines1.fill(function (d, i) { return '#FFF'; });

    lines2.color(function (d, i) {
      return d3.interpolateHsl(d3.rgb('#1A8221'), d3.rgb('#62B464'))(i / 1);
    });
    lines2.fill(function (d, i) {
      return d3.interpolateHsl(d3.rgb('#1A8221'), d3.rgb('#62B464'))(i / 1);
    });
    lines2.classes(classes);

    barLegend.color(colors);
    barLegend.classes(classes);

    lineLegend.color(function (d, i) {
      return d.color || d3.interpolateHsl(d3.rgb('#1A8221'), d3.rgb('#62B464'))(i / 1);
    });
    lineLegend.classes(classes);

    return chart;
  };

  chart.x = function (_) {
    if (!arguments.length) {
      return getX;
    }
    getX = _;
    lines.x(_);
    multibar.x(_);
    return chart;
  };

  chart.y = function (_) {
    if (!arguments.length) {
      return getY;
    }
    getY = _;
    lines.y(_);
    multibar.y(_);
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

  chart.showControls = function (_) {
    if (!arguments.length) {
      return false;
    }
    return chart;
  };

  chart.tooltipBar = function (_) {
    if (!arguments.length) {
      return tooltipBar;
    }
    tooltipBar = _;
    return chart;
  };

  chart.tooltipLine = function (_) {
    if (!arguments.length) {
      return tooltipLine;
    }
    tooltipLine = _;
    return chart;
  };

  chart.tooltipQuota = function (_) {
    if (!arguments.length) {
      return tooltipQuota;
    }
    tooltipQuota = _;
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

  chart.barClick = function (_) {
    if (!arguments.length) {
      return barClick;
    }
    barClick = _;
    return chart;
  };

  chart.colorFill = function (_) {
    return chart;
  };

  chart.yAxisTickFormat = function (_) {
    if (!arguments.length) {
      return yAxisTickFormat;
    }
    yAxisTickFormat = _;
    return chart;
  };

  chart.quotaTickFormat = function (_) {
    if (!arguments.length) {
      return quotaTickFormat;
    }
    quotaTickFormat = _;
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
