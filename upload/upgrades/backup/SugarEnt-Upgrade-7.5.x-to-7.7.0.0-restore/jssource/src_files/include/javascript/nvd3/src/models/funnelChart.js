
nv.models.funnelChart = function() {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 10, right: 10, bottom: 10, left: 10},
      width = null,
      height = null,
      showTitle = false,
      showLegend = true,
      tooltip = null,
      tooltips = true,
      tooltipContent = function(key, x, y, e, graph) {
        return '<h3>' + key + ' - ' + x + '</h3>' +
               '<p>' + y + '</p>';
      },
      x,
      y,
      durationMs = 0,
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

  var funnel = nv.models.funnel(),
      yAxis = nv.models.axis()
        .orient('left')
        .tickFormat(function(d) {
          return '';
        }),
      legend = nv.models.legend()
        .align('center'),
      yScale = d3.scale.linear();

  var showTooltip = function(e, offsetElement, properties) {
    var xVal = 0;
    // defense against the dark divide-by-zero arts
    if (properties.total > 0) {
      xVal = (e.point.value * 100 / properties.total).toFixed(1);
    }
    var left = e.pos[0],
        top = e.pos[1],
        x = xVal,
        y = e.point.value,
        content = tooltipContent(e.series.key, x, y, e, chart);
    tooltip = nv.tooltip.show([left, top], content, e.value < 0 ? 'n' : 's', null, offsetElement);
  };

  var seriesClick = function(data, e) {
    return;
  };

  //============================================================

  function chart(selection) {

    selection.each(function(chartData) {

      var properties = chartData.properties,
          data = chartData.data,
          container = d3.select(this),
          that = this,
          availableWidth = (width || parseInt(container.style('width'), 10) || 960) - margin.left - margin.right,
          availableHeight = (height || parseInt(container.style('height'), 10) || 400) - margin.top - margin.bottom,
          innerWidth = availableWidth,
          innerHeight = availableHeight,
          innerMargin = {top: 0, right: 0, bottom: 0, left: 0},
          minSliceHeight = 30;

      chart.update = function() {
        container.transition().duration(durationMs).call(chart);
      };

      chart.dataSeriesActivate = function(e) {
        var series = e.series;

        series.active = (!series.active || series.active === 'inactive') ? 'active' : 'inactive';
        series.values[0].active = series.active;

        // if you have activated a data series, inactivate the rest
        if (series.active === 'active') {
          data.filter(function(d) {
            return d.active !== 'active';
          }).map(function(d) {
            d.values[0].active = 'inactive';
            d.active = 'inactive';
            return d;
          });
        }

        // if there are no active data series, activate them all
        if (!data.filter(function(d) {
          return d.active === 'active';
        }).length) {
          data.map(function(d) {
            d.active = '';
            d.values[0].active = '';
            container.selectAll('.nv-series').classed('nv-inactive', false);
            return d;
          });
        }

        container.call(chart);
      };

      chart.container = this;

      //------------------------------------------------------------
      // Display No Data message if there's nothing to show.

      if (!data || !data.length || !data.filter(function(d) {
        return d.values.length;
      }).length) {
        var noDataText = container.selectAll('.nv-noData').data([chart.strings().noData]);

        noDataText.enter().append('text')
          .attr('class', 'nvd3 nv-noData')
          .attr('dy', '-.7em')
          .style('text-anchor', 'start');

        noDataText
          .attr('x', margin.left + availableWidth / 2)
          .attr('y', margin.top + availableHeight / 2)
          .text(function(d) {
            return d;
          });

        return chart;
      } else {
        container.selectAll('.nv-noData').remove();
      }

      //------------------------------------------------------------
      // Process data
      //add series index to each data point for reference
      var funnelData = data.map(function(d, i) {
          d.series = i;
          d.values.map(function(v) {
            v.series = d.series;
          });
          return d;
        });

      //set state.disabled
      state.disabled = funnelData.map(function(d) { return !!d.disabled; });

      //------------------------------------------------------------
      // Setup Scales

      y = funnel.yScale(); //see below

      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = container.selectAll('g.nv-wrap.nv-funnelChart').data([funnelData]),
          gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-funnelChart').append('g'),
          g = wrap.select('g').attr('class', 'nv-chartWrap');

      gEnter.append('rect').attr('class', 'nv-background')
        .attr('x', -margin.left)
        .attr('y', -margin.top)
        .attr('width', availableWidth + margin.left + margin.right)
        .attr('height', availableHeight + margin.top + margin.bottom)
        .attr('fill', '#FFF');

      gEnter.append('g').attr('class', 'nv-titleWrap');
      var titleWrap = g.select('.nv-titleWrap');
      gEnter.append('g').attr('class', 'nv-y nv-axis');
      var yAxisWrap = g.select('.nv-y.nv-axis');
      gEnter.append('g').attr('class', 'nv-funnelWrap');
      var funnelWrap = g.select('.nv-funnelWrap');
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
          .datum(funnelData)
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

      //------------------------------------------------------------
      // Main Chart Component(s)

      funnel
        .width(innerWidth)
        .height(innerHeight);

      funnelWrap
        .datum(funnelData.filter(function(d) { return !d.disabled; }))
        .attr('transform', 'translate(' + innerMargin.left + ',' + innerMargin.top + ')')
          .call(funnel);

      //------------------------------------------------------------
      // Setup Scales (again, not sure why it has to be here and not above?)

      var tickValues = resetScale(yScale, funnelData);

      //------------------------------------------------------------
      // Main Chart Components

      yAxis
        .tickSize(-innerWidth, 0)
        .scale(yScale)
        .highlightZero(true)
        .showMaxMin(false)
        .tickValues(tickValues)
        .textAnchor('start')
        .tickFormat(function(d, i) {
          return i === 0 ? '' : funnelData[i - 1].key;
        });

      yAxisWrap
        .attr('transform', 'translate(' + (yAxis.orient() === 'left' ? innerMargin.left : innerWidth) + ',' + innerMargin.top + ')')
          .call(yAxis);

      yAxisWrap.selectAll('.tick.major text')
        .style('font-size', innerWidth < 500 ? '11px' : '15px')
        .each(fmtAxisLabel);


      // Build array of tick label dimensions
      var tickDimensions = yAxisWrap.selectAll('.tick.major text')[0].map(function(d, i) {
            var bbox = d.getBoundingClientRect(),
                w = parseInt(bbox.width, 10),
                h = Math.round(parseInt(bbox.height, 10) + 4);
            return {
              key: funnelData[i - 1] ? funnelData[i - 1].key : 'Base',
              width: w,
              height: h,
              widthOffset: w,
              textOffset: 0,
              lineOffset: 0,
              thickness: 0,
              showLabel: false,
              ends: false
            };
          });

      var minimumOffset = recalcDimensions(tickValues, tickDimensions);


      // Recall to set final size
      funnel
        .offset(minimumOffset);

      funnelWrap
        .transition().duration(durationMs)
          .call(funnel);

      tickValues = resetScale(yScale, funnelData);

      yAxis
        .tickValues(tickValues);

      yAxisWrap
        .transition().duration(durationMs)
          .call(yAxis);

      minimumOffset = recalcDimensions(tickValues, tickDimensions);


      // Reposition main funnel
      funnelWrap.selectAll('g.nv-wrap.nv-funnel')
        .attr('transform', 'translate(' + (minimumOffset / 2) + ',0)');

      // Reposition tick elements and update label
      yAxisWrap.selectAll('.tick.major text')
        // .attr('x', function(d, i) {
        //   var t = tickDimensions[i];
        //   return t.widthOffset / 2 + t.height + 'px';
        // })
        .attr('dy', function(d, i) {
          var t = tickDimensions[i]
              y = t.textOffset;
          return y + 'px';
        })
        .each(fmtAxisLabel);

      // Set leaders
      yAxisWrap.selectAll('.tick.major line')
        .attr('x1', function(d, i) {
          var t = tickDimensions[i];
          return t.widthOffset + t.lineOffset / 2;
        })
        .attr('x2', function(d, i) {
          var t = tickDimensions[i];
          return (innerWidth - t.widthOffset) / 2 + t.widthOffset;
        })
        .style('opacity', function(d, i) {
          var t = tickDimensions[i];
          return !t.previousLabel ? 0 : 1;
        });

      yAxisWrap.selectAll('.tick.major polyline').remove();
      yAxisWrap.selectAll('.tick.major')
        .insert('polyline', 'text').attr('class', 'nv-label-leader')
          .attr('points', function(d, i) {
            var t = tickDimensions[i],
                h = t.lineOffset,
                w = t.widthOffset;
            return '0,' + h + ' ' + w + ',' + h + ' ' + (w + h / 2) + ',0';
          })
          .style('opacity', function(d, i) {
            var t = tickDimensions[i];
            return !t.previousLabel ? 0 : 1;
          });


      function recalcDimensions(values, dimensions) {
        values.reverse();
        dimensions.reverse();

        dimensions.map(function(d, i, t) {
          var p;
          if (!i) {
            d.ends = true;
            p = {
                  key: 'Previous',
                  width: 0,
                  height: 32,
                  widthOffset: 0,
                  textOffset: 12,
                  lineOffset: 0,
                  thickness: 33,
                  showLabel: false,
                  ends: true
                };
          } else {
            p = t[i - 1]; //previous tick
          }
          if (i === t.length - 1) {
            d.ends = true;
          } else {
            d.thickness = Math.round(values[i] - values[i + 1]);
          }

          var previousOverflow = p.textOffset + (p.showLabel ? p.height : 0) - p.thickness;

          d.showLabel = d.thickness <= d.height;
          d.previousLabel = p.showLabel;
          d.textOffset = Math.max(previousOverflow, 12);
          d.lineOffset = Math.max(previousOverflow - 12, 0);

          if (d.width > p.width && d.lineOffset) {
            d.widthOffset = Math.max(p.width, p.widthOffset);
          } else if (d.previousLabel) {
            d.widthOffset = Math.max(p.width, p.widthOffset, d.width);
          }

          if (i === t.length - 1 && (p.showLabel || previousOverflow > 12)) {
            innerMargin.bottom += Math.max(0, d.height - d.thickness, previousOverflow - 12);
            innerHeight = availableHeight - innerMargin.top - innerMargin.bottom;
            funnel
              .height(innerHeight);
          }

        });

        var minimumOffset = d3.max(
          dimensions.map(function(d, i) {
            if (!i) {
              return 0;
            }
            return d.widthOffset + d.lineOffset / 2 - y(values[i - 1]) * 0.3 + 10;
          })
        );

        values.reverse();
        dimensions.reverse();

        return Math.round(minimumOffset);
      }

      function fmtAxisLabel(d, i) {
        var data, tick, node, count;

        node = d3.select(this);
        node.text('');

        if (!i) {
          return;
        }
        if (tickDimensions) {
          tick = tickDimensions[i];
          if (tick.thickness > tick.height) {
            return;
          }
        }

        data = funnelData[i - 1];

        count = isNaN(data.count) ? '' : ' (' + data.count + ')';

        node.append('tspan')
          .attr('x', 0)
          .style('font-size', '11px')
          .text(data.key + count);

        node.append('tspan')
          .attr('x', 0)
          .attr('dy', '1em')
          .style('font-size', '15px')
          .text(funnel.fmtValueLabel()(data.values[0]));
      }

      function resetScale(scale, data) {
        var series1 = [0];
        var series2 = data.filter(function(d) {
                return !d.disabled;
              })
              .map(function(d) {
                return d.values.map(function(d, i) {
                  return d.y0 + d.y;
                });
              });
        var tickValues = d3.merge(series1.concat(series2));

        yScale
          .domain(tickValues)
          .range(tickValues.map(function(d) { return y(d); }));

        return tickValues;
      }

      //============================================================
      // Event Handling/Dispatching (in chart's scope)
      //------------------------------------------------------------

      legend.dispatch.on('legendClick', function(d, i) {
        d.disabled = !d.disabled;

        if (!funnelData.filter(function(d) { return !d.disabled; }).length) {
          funnelData.map(function(d) {
            d.disabled = false;
            wrap.selectAll('.nv-series').classed('disabled', false);
            return d;
          });
        }

        state.disabled = funnelData.map(function(d) { return !!d.disabled; });
        dispatch.stateChange(state);

        container.transition().duration(durationMs).call(chart);
      });

      dispatch.on('tooltipShow', function(e) {
        if (tooltips) {
          showTooltip(e, that.parentNode, properties);
        }
      });

      dispatch.on('tooltipHide', function() {
        if (tooltips) {
          nv.tooltip.cleanup();
        }
      });

      dispatch.on('tooltipMove', function(e) {
        if (tooltip) {
          nv.tooltip.position(tooltip, e.pos);
        }
      });

      // Update chart from a state object passed to event handler
      dispatch.on('changeState', function(e) {
        if (typeof e.disabled !== 'undefined') {
          funnelData.forEach(function(series, i) {
            series.disabled = e.disabled[i];
          });
          state.disabled = e.disabled;
        }

        container.transition().duration(durationMs).call(chart);
      });

      dispatch.on('chartClick', function(e) {
        if (legend.enabled()) {
          legend.dispatch.closeMenu(e);
        }
      });

      funnel.dispatch.on('elementClick', function(e) {
        seriesClick(data, e);
      });

    });

    return chart;
  }

  //============================================================
  // Event Handling/Dispatching (out of chart's scope)
  //------------------------------------------------------------

  funnel.dispatch.on('elementMouseover.tooltip', function(e) {
    dispatch.tooltipShow(e);
  });

  funnel.dispatch.on('elementMouseout.tooltip', function(e) {
    dispatch.tooltipHide(e);
  });

  funnel.dispatch.on('elementMousemove.tooltip', function(e) {
    dispatch.tooltipMove(e);
  });

  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  // expose chart's sub-components
  chart.dispatch = dispatch;
  chart.funnel = funnel;
  chart.legend = legend;
  chart.yAxis = yAxis;

  d3.rebind(chart, funnel, 'id', 'x', 'y', 'xDomain', 'yDomain', 'forceX', 'forceY', 'color', 'fill', 'classes', 'gradient');
  d3.rebind(chart, funnel, 'fmtValueLabel', 'clipEdge', 'delay');

  chart.colorData = function(_) {
    var colors = function(d, i) {
          return nv.utils.defaultColor()(d, i);
        },
        classes = function(d, i) {
          return 'nv-group nv-series-' + i;
        },
        type = arguments[0],
        params = arguments[1] || {};

    switch (type) {
      case 'graduated':
        var c1 = params.c1,
            c2 = params.c2,
            l = params.l;
        colors = function(d, i) {
          return d3.interpolateHsl(d3.rgb(c1), d3.rgb(c2))(i / l);
        };
        break;
      case 'class':
        colors = function() {
          return 'inherit';
        };
        classes = function(d, i) {
          var iClass = (i * (params.step || 1)) % 14;
          return 'nv-group nv-series-' + i + ' ' + (d.classes || 'nv-fill' + (iClass > 9 ? '' : '0') + iClass);
        };
        break;
    }

    var fill = (!params.gradient) ? colors : function(d, i) {
      var p = {orientation: params.orientation || 'vertical', position: params.position || 'middle'};
      return funnel.gradient(d, i, p);
    };

    funnel.color(colors);
    funnel.fill(fill);
    funnel.classes(classes);

    legend.color(colors);
    legend.classes(classes);

    return chart;
  };

  chart.x = function(_) {
    if (!arguments.length) { return getX; }
    getX = _;
    funnelWrap.x(_);
    return chart;
  };

  chart.y = function(_) {
    if (!arguments.length) { return getY; }
    getY = _;
    funnel.y(_);
    return chart;
  };

  chart.margin = function(_) {
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

  chart.width = function(_) {
    if (!arguments.length) {
      return width;
    }
    width = _;
    return chart;
  };

  chart.height = function(_) {
    if (!arguments.length) {
      return height;
    }
    height = _;
    return chart;
  };

  chart.showTitle = function(_) {
    if (!arguments.length) {
      return showTitle;
    }
    showTitle = _;
    return chart;
  };

  chart.showLegend = function(_) {
    if (!arguments.length) {
      return showLegend;
    }
    showLegend = _;
    return chart;
  };

  chart.tooltip = function(_) {
    if (!arguments.length) {
      return tooltip;
    }
    tooltip = _;
    return chart;
  };

  chart.tooltips = function(_) {
    if (!arguments.length) {
      return tooltips;
    }
    tooltips = _;
    return chart;
  };

  chart.tooltipContent = function(_) {
    if (!arguments.length) {
      return tooltipContent;
    }
    tooltipContent = _;
    return chart;
  };

  chart.state = function(_) {
    if (!arguments.length) {
      return state;
    }
    state = _;
    return chart;
  };

  chart.strings = function(_) {
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

  chart.seriesClick = function(_) {
    if (!arguments.length) {
      return seriesClick;
    }
    seriesClick = _;
    return chart;
  };

  //============================================================

  return chart;
};
