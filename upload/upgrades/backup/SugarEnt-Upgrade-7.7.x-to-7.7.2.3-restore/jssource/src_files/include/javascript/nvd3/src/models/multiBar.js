nv.models.multiBar = function() {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 0, right: 0, bottom: 0, left: 0},
      width = 960,
      height = 500,
      x = d3.scale.ordinal(),
      y = d3.scale.linear(),
      id = Math.floor(Math.random() * 10000), //Create semi-unique ID in case user doesn't select one
      getX = function(d) { return d.x; },
      getY = function(d) { return d.y; },
      forceY = [0], // 0 is forced by default.. this makes sense for the majority of bar graphs... user can always do chart.forceY([]) to remove
      stacked = false,
      barColor = null, // adding the ability to set the color for each rather than the whole group
      disabled, // used in conjunction with barColor to communicate to multiBarChart what series are disabled
      clipEdge = true,
      showValues = false,
      valueFormat = d3.format(',.2s'),
      withLine = false,
      vertical = true,
      baseDimension = 60,
      direction = 'ltr',
      delay = 200,
      xDomain,
      yDomain,
      nice = false,
      color = function(d, i) { return nv.utils.defaultColor()(d, d.series); },
      fill = color,
      barColor = null, // adding the ability to set the color for each rather than the whole group
      classes = function(d, i) { return 'nv-group nv-series-' + d.series; },
      dispatch = d3.dispatch('chartClick', 'elementClick', 'elementDblClick', 'elementMouseover', 'elementMouseout', 'elementMousemove');

  //============================================================

  //============================================================
  // Private Variables
  //------------------------------------------------------------

  var x0,
      y0; //used to store previous scales

  //============================================================

  function chart(selection) {
    selection.each(function(data) {

      baseDimension = stacked ? vertical ? 72 : 30 : 20;

      var container = d3.select(this),
          orientation = vertical ? 'vertical' : 'horizontal',
          availableWidth = width - margin.left - margin.right,
          availableHeight = height - margin.top - margin.bottom,
          maxX = vertical ? availableWidth : availableHeight,
          maxY = vertical ? availableHeight : availableWidth,
          dimX = vertical ? 'width' : 'height',
          dimY = vertical ? 'height' : 'width',
          valX = vertical ? 'x' : 'y',
          valY = vertical ? 'y' : 'x',
          valuePadding = 0,
          seriesCount = 0,
          groupCount = 0;

      var barLength = function(d, i) {
        return Math.max(Math.round(Math.abs(y(getY(d, i)) - y(0))), 0);
      };
      var barThickness = function() {
        return x.rangeBand() / (stacked ? 1 : data.length);
      };

      if (stacked) {
        data = d3.layout.stack()
                 .offset('zero')
                 .values(function(d) { return d.values; })
                 .y(getY)(data);
      }

      //------------------------------------------------------------
      // HACK for negative value stacking
      if (stacked) {
        data[0].values.map(function(d, i) {
          var posBase = 0,
              negBase = 0;
          data.map(function(d) {
            var f = d.values[i];
            f.size = Math.abs(f.y);
            if (f.y < 0) {
              f.y1 = negBase - (vertical ? 0 : f.size);
              negBase = negBase - f.size;
            } else {
              f.y1 = posBase + (vertical ? f.size : 0);
              posBase = posBase + f.size;
            }
          });
        });
      }

      //------------------------------------------------------------
      // Setup Scales

      // remap and flatten the data for use in calculating the scales' domains
      var seriesData = (xDomain && yDomain) ?
            [] : // if we know xDomain and yDomain, no need to calculate
            d3.merge(data.map(function(d) {
              return d.values.map(function(d, i) {
                return {x: getX(d, i), y: getY(d, i), y0: d.y0, y1: d.y1};
              });
            }));

      groupCount = data[0].values.length;
      seriesCount = data.length;

      chart.resetDimensions = function(w, h) {
        width = w;
        height = h;
        availableWidth = w - margin.left - margin.right;
        availableHeight = h - margin.top - margin.bottom;
        resetScale();
      };

      function resetScale() {
        maxX = vertical ? availableWidth : availableHeight;
        maxY = vertical ? availableHeight : availableWidth;

        var boundsWidth = stacked ? baseDimension : baseDimension * seriesCount + baseDimension,
            gap = baseDimension * (stacked ? 0.25 : 1),
            outerPadding = Math.max(0.25, (maxX - (groupCount * boundsWidth) - gap) / (2 * boundsWidth));

        if (withLine) {
          /*TODO: used in reports to keep bars from being too wide
            breaks pareto chart, so need to update line to adjust x position */
          x .domain(xDomain || seriesData.map(function(d) { return d.x; }))
            .rangeBands([0, maxX], 0.3);
        } else {
          x .domain(xDomain || seriesData.map(function(d) { return d.x; }))
            .rangeRoundBands([0, maxX], 0.25, outerPadding);
        }

        y .domain(yDomain || d3.extent(seriesData.map(function(d) {
            var posOffset = (vertical ? 0 : d.y),
                negOffset = (vertical ? d.y : 0);
            return stacked ? (d.y > 0 ? d.y1 + posOffset : d.y1 + negOffset) : d.y;
          }).concat(forceY)))
          .range(vertical ? [availableHeight, 0] : [0, availableWidth]);

        if (nice) {
          y.nice();
        }

        x0 = x0 || x;
        y0 = y0 || y;

        // var expandDomain = y.invert(y(0) + (vertical ? -4 : 4));
        // y.domain(
        //   y.domain().map(function(d, i) {
        //     return d += expandDomain * (d < 0 ? -1 : d > 1 ? 1 : 0);
        //   })
        // );

        //------------------------------------------------------------
        // recalculate y.range if show values
        if (!stacked && (showValues === 'top' || showValues === true)) {
          valuePadding = nv.utils.maxStringSetLength(
              seriesData.map(function(d) { return d.y; }),
              container,
              valueFormat
            );
          valuePadding += 8;
          if (vertical) {
            y.range([
              maxY - (y.domain()[0] < 0 ? valuePadding : 0),
                      y.domain()[1] > 0 ? valuePadding : 0
            ]);
          } else {
            y.range([
                      y.domain()[0] < 0 ? valuePadding : 0,
              maxY - (y.domain()[1] > 0 ? valuePadding : 0)
            ]);
          }
        }
      }

      resetScale();


      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = container.selectAll('.nvd3.nv-wrap').data([data]);
      var wrapEnter = wrap.enter().append('g');
      var defsEnter = wrapEnter.append('defs');
      var gEnter = wrapEnter.append('g');
      var g = wrap.select('g');

      wrap.attr('class', 'nvd3 nv-wrap nv-multibar' + (vertical ? '' : 'Horizontal'));

      //set up the gradient constructor function
      chart.gradient = function(d, i, p) {
        return nv.utils.colorLinearGradient(d, id + '-' + i, p, color(d, i), wrap.select('defs'));
      };

      gEnter.append('g').attr('class', 'nv-groups');

      wrap.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

      //------------------------------------------------------------

      if (clipEdge) {
        defsEnter.append('clipPath')
          .attr('id', 'nv-edge-clip-' + id)
          .append('rect');
        wrap.select('#nv-edge-clip-' + id + ' rect')
          .attr('width', availableWidth)
          .attr('height', availableHeight);
      }
      g .attr('clip-path', clipEdge ? 'url(#nv-edge-clip-' + id + ')' : '');

      //------------------------------------------------------------

      var groups = wrap.select('.nv-groups').selectAll('.nv-group')
            .data(function(d) { return d; }, function(d) { return d.key; });

      groups.enter().append('g')
        .style('stroke-opacity', 1e-6)
        .style('fill-opacity', 1e-6);
      groups.exit()
        .style('stroke-opacity', 1e-6)
        .style('fill-opacity', 1e-6)
          .selectAll('g.nv-bar')
            .attr('y', function(d) {
              return stacked ? y0(d.y0) : y0(0);
            })
            .attr(dimX, 0)
            .remove();

      groups
        .attr('class', classes)
        .attr('fill', fill)
        .classed('hover', function(d) { return d.hover; })
        .classed('nv-active', function(d) { return d.active === 'active'; })
        .classed('nv-inactive', function(d) { return d.active === 'inactive'; })
        .style({'stroke-opacity': 1, 'fill-opacity': 1});

      var bars = groups.selectAll('g.nv-bar')
            .data(
              function(d) {
                return d.values;
              }, function(d, i) {
                return d.series + '-' + d.x;
              }
            );

      bars.exit().remove();

      var barsEnter = bars.enter().append('g')
            .attr('class', function(d, i) {
              return getY(d, i) < 0 ? 'nv-bar negative' : 'nv-bar positive';
            })
            .attr('transform', function(d, i, j) {
              var trans = {
                x: stacked ? 0 : (j * barThickness()) + x(getX(d, i)),
                y: y0(stacked ? d.y0 : 0)
              };
              return 'translate(' + trans[valX] + ',' + trans[valY] + ')';
            });

      barsEnter.append('rect')
        .attr(dimX, 0)
        .attr(dimY, 0);

      function buildEventObject(e, d, i, j) {
        return {
            value: getY(d, i),
            point: d,
            series: data[j],
            pointIndex: i,
            seriesIndex: j,
            id: id,
            e: e
          };
      }

      bars
        .on('mouseover', function(d, i, j) { //TODO: figure out why j works above, but not here
          d3.select(this).classed('hover', true);
          var eo = buildEventObject(d3.event, d, i, j);
          dispatch.elementMouseover(eo);
        })
        .on('mousemove', function(d, i, j) {
          dispatch.elementMousemove(d3.event);
        })
        .on('mouseout', function(d, i, j) {
          d3.select(this).classed('hover', false);
          dispatch.elementMouseout();
        })
        .on('click', function(d, i, j) {
          d3.event.stopPropagation();
          var eo = buildEventObject(d3.event, d, i, j);
          dispatch.elementClick(eo);
        })
        .on('dblclick', function(d, i, j) {
          d3.event.stopPropagation();
          // I have no clue why this was here
          // pos = [
          //     x(getX(d, i)) + (x.rangeBand() * (stacked ? data.length / 2 : j + 0.5) / data.length),
          //     y(getY(d, i) + (stacked ? d.y0 : 0))
          //   ];
          var eo = buildEventObject(d3.event, d, i, j);
          dispatch.elementDblClick(eo);
        });


      if (stacked) {
        bars
          .attr('transform', function(d, i) {
            var xScalar = (d.active && d.active === 'active') ? x.rangeBand() * 0.1 : 0;
            var trans = {
              x: Math.round(x(getX(d, i)) - xScalar),
              y: Math.round(y(d.y1))
            };
            return 'translate(' + trans[valX] + ',' + trans[valY] + ')';
          })
          .select('rect')
            .attr(valY, function(d, i) {
              return vertical ?
                        getY(d, i) < 0 ?  2 : -2 :
                        getY(d, i) < 0 ? -2 :  2 ;
            })
            .attr(valX, 0)
            .attr(dimY, barLength)
            .attr(dimX, function(d, i) {
              var xScalar = (d.active && d.active === 'active') ? 1.2 : 1.0;
              return x.rangeBand() * xScalar;
            });
      } else {
        bars
          .attr('transform', function(d, i, j) {
            var xScalar = (d.active && d.active === 'active') ? x.rangeBand() * 0.1 / data.length : 0;
            var trans = {
              x: Math.round((j * barThickness() + x(getX(d, i))) - xScalar),
              y: Math.round(getY(d, i) < 0 ? (vertical ? y(0) : y(getY(d, i))) : (vertical ? y(getY(d, i)) : y(0)))
            };
            return 'translate(' + trans[valX] + ',' + trans[valY] + ')';
          })
          .select('rect')
            .attr(valY, function(d, i) {
              return vertical ?
                        getY(d, i) < 0 ?  2 : -2 :
                        getY(d, i) < 0 ? -2 :  2 ;
            })
            .attr(valX, 0)
            .attr(dimY, barLength)
            .attr(dimX, function(d, i) {
              var xScalar = (d.active && d.active === 'active') ? 1.2 : 1.0;
              return Math.round(x.rangeBand() * xScalar / data.length);
            });
      }

      //begin, middle, end, top
      barsEnter.append('text')
        .attr('class', 'nv-label-value');
      var barText = bars.select('.nv-label-value');
      barText
        .text(function(d, i) {
          return showValues ? valueFormat(getY(d, i)) : '';
        })
        .attr('fill-opacity', 0)
        .attr('stroke-opacity-opacity', 0);

      if (showValues) {

        var valueBox = barText[0][0].getBoundingClientRect(),
            valueDim = vertical ? valueBox.height : valueBox.width;

        // KEEP: to be used in case you want rect behind text
        //var labelBoxWidth = x.rangeBand() - 8;
        // barsEnter.append('rect')
        //   .attr('class', 'nv-label-box')
        //   .attr('x', 4)
        //   .attr('y', 1)
        //   .attr('width', labelBoxWidth)
        //   .attr('height', 14)
        //   .attr('rx', 2)
        //   .attr('ry', 2)
        //   .style('fill', '#FFF')
        //   .style('stroke-width', 0)
        //   .style('fill-opacity', 0.3);

        barText
          .attr('text-anchor', function(d, i) {
            var anchor = 'middle',
                negative = getY(d, i) < 0;
            if (vertical && stacked) {
              anchor = 'middle';
            } else {
              switch (showValues) {
                case 'start':
                  anchor = negative ? 'end' : 'start';
                  break;
                case 'middle':
                  anchor = 'middle';
                  break;
                case 'end':
                  anchor = negative ? 'start' : 'end';
                  break;
                case 'top':
                default:
                  anchor = vertical ?
                    negative ? 'end' : 'start' :
                    stacked ?
                      negative ? 'start' : 'end' :
                      negative ? 'end' : 'start';
                  break;
              }
              anchor = direction === 'rtl' && anchor !== 'middle' ? anchor === 'start' ? 'end' : 'start' : anchor;
            }
            return anchor;
          })
          .attr('dy', function(d, i) {
            var dy = 0,
                negative = getY(d, i) < 0;
            if (stacked && vertical) {
              switch (showValues) {
                case 'start':
                  dy = negative ? '0.71em' : 0;
                  break;
                case 'middle':
                  dy = '0.35em';
                  break;
                case 'top':
                case 'end':
                default:
                  dy = negative ? 0 : '0.71em';
                  break;
              }
            } else {
              dy = '0.35em';
            }
            return dy;
          })
          .attr('x', function(d, i) {
            var offset = 0,
                negative = getY(d, i) < 0;
            if (vertical && stacked) {
              offset = barThickness() / 2;
            } else {
              switch (showValues) {
                case 'start':
                  offset = barLength(d, i) * (negative ? 0 : -1) + 6 * (negative ? -1 : 1);
                  break;
                case 'middle':
                  offset = -barLength(d, i) / 2;
                  break;
                case 'end':
                  offset = barLength(d, i) * (negative ? -1 : 0) + 4 * (negative ? 1 : -1);
                  break;
                case 'top':
                default:
                  offset = barLength(d, i) * (negative ? -1 : 0) + 4 * (negative ? -1 : 1) * (stacked ? -1 : 1);
                  break;
              }
              if (!vertical) {
                offset += barLength(d, i);
              }
            }
            return offset;
          })
          .attr('y', function(d, i) {
            var offset = 0,
                negative = getY(d, i) < 0;
            if (vertical && stacked) {
              switch (showValues) {
                case 'start':
                  offset = barLength(d, i) * (negative ? 0 : 1) + 6 * (negative ? 1 : -1);
                  break;
                case 'middle':
                  offset = barLength(d, i) / 2 + (negative ? 1 : -1);
                  break;
                case 'end':
                case 'top':
                default:
                  offset = barLength(d, i) * (negative ? 1 : 0) + 4 * (negative ? -1 : 1);
                  break;
              }
            } else {
              offset = barThickness() / 2;
            }
            return offset;
          })
          .attr('transform', 'rotate(' + (!stacked && vertical ? -90 : 0) + ' 0,0)')
          .style('fill', function(d, i, j) {
            if (!stacked && (showValues === 'top' || showValues === true)) {
              return '#000';
            }
            var backColor = d3.select(this.previousSibling).style('fill'),
                textColor = nv.utils.getTextContrast(backColor, i);
            return textColor;
          })
          .attr('fill-opacity', function(d, i) {
            var barHeight = barLength(d, i);
            return getY(d, i) === 0 || barHeight < valueDim ? 0 : 1;
          })
          .attr('stroke-opacity', function(d, i) {
            var barHeight = barLength(d, i);
            return getY(d, i) === 0 || barHeight < valueDim ? 0 : 1;
          });

        // KEEP: to be used in case you want rect behind text
        // bars.selectAll('text').each(function(d, i) {
        //       var width = this.getBoundingClientRect().width + 20;
        //       if (width > labelBoxWidth) {
        //         labelBoxWidth = width;
        //       }
        //     });
        // bars.selectAll('rect').each(function(d, i) {
        //       d3.select(this)
        //         .attr('width', labelBoxWidth)
        //         .attr('x', -labelBoxWidth / 2);
        //     });
      }

      // TODO: fix way of passing in a custom color function
      // if (barColor) {
      //   if (!disabled) {
      //     disabled = data.map(function() { return true; });
      //   }
      //   bars
      //     //.style('fill', barColor)
      //     //.style('stroke', barColor)
      //     //.style('fill', function(d,i,j) { return d3.rgb(barColor(d,i)).darker(j).toString(); })
      //     //.style('stroke', function(d,i,j) { return d3.rgb(barColor(d,i)).darker(j).toString(); })
      //     .style('fill', function(d, i, j) {
      //       return d3.rgb(barColor(d, i))
      //                .darker(disabled.map(function(d, i) { return i; })
      //                .filter(function(d, i) { return !disabled[i]; })[j])
      //                .toString();
      //     })
      //     .style('stroke', function(d, i, j) {
      //       return d3.rgb(barColor(d, i))
      //                .darker(disabled.map(function(d, i) { return i; })
      //                .filter(function(d, i) { return !disabled[i]; })[j])
      //                .toString();
      //     });
      // }

      //store old scales for use in transitions on update
      x0 = x.copy();
      y0 = y.copy();

    });

    return chart;
  }


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  chart.dispatch = dispatch;

  chart.color = function(_) {
    if (!arguments.length) {
      return color;
    }
    color = _;
    return chart;
  };
  chart.fill = function(_) {
    if (!arguments.length) {
      return fill;
    }
    fill = _;
    return chart;
  };
  chart.classes = function(_) {
    if (!arguments.length) {
      return classes;
    }
    classes = _;
    return chart;
  };
  chart.gradient = function(_) {
    if (!arguments.length) {
      return gradient;
    }
    gradient = _;
    return chart;
  };

  chart.x = function(_) {
    if (!arguments.length) {
      return getX;
    }
    getX = _;
    return chart;
  };

  chart.y = function(_) {
    if (!arguments.length) {
      return getY;
    }
    getY = _;
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

  chart.xScale = function(_) {
    if (!arguments.length) {
      return x;
    }
    x = _;
    return chart;
  };

  chart.yScale = function(_) {
    if (!arguments.length) {
      return y;
    }
    y = _;
    return chart;
  };

  chart.xDomain = function(_) {
    if (!arguments.length) {
      return xDomain;
    }
    xDomain = _;
    return chart;
  };

  chart.yDomain = function(_) {
    if (!arguments.length) {
      return yDomain;
    }
    yDomain = _;
    return chart;
  };

  chart.forceY = function(_) {
    if (!arguments.length) {
      return forceY;
    }
    forceY = _;
    return chart;
  };

  chart.stacked = function(_) {
    if (!arguments.length) {
      return stacked;
    }
    stacked = _;
    return chart;
  };

  chart.clipEdge = function(_) {
    if (!arguments.length) {
      return clipEdge;
    }
    clipEdge = _;
    return chart;
  };

  chart.barColor = function(_) {
    if (!arguments.length) {
      return barColor;
    }
    barColor = nv.utils.getColor(_);
    return chart;
  };

  chart.disabled = function(_) {
    if (!arguments.length) {
      return disabled;
    }
    disabled = _;
    return chart;
  };

  chart.id = function(_) {
    if (!arguments.length) {
      return id;
    }
    id = _;
    return chart;
  };

  chart.delay = function(_) {
    if (!arguments.length) {
      return delay;
    }
    delay = _;
    return chart;
  };

  chart.showValues = function(_) {
    if (!arguments.length) {
      return showValues;
    }
    showValues = _;
    return chart;
  };

  chart.valueFormat = function(_) {
    if (!arguments.length) {
      return valueFormat;
    }
    valueFormat = _;
    return chart;
  };

  chart.withLine = function(_) {
    if (!arguments.length) {
      return withLine;
    }
    withLine = _;
    return chart;
  };

  chart.vertical = function(_) {
    if (!arguments.length) {
      return vertical;
    }
    vertical = _;
    return chart;
  };

  chart.baseDimension = function(_) {
    if (!arguments.length) {
      return baseDimension;
    }
    baseDimension = _;
    return chart;
  };

  chart.direction = function(_) {
    if (!arguments.length) {
      return direction;
    }
    direction = _;
    return chart;
  };

  chart.nice = function(_) {
    if (!arguments.length) {
      return nice;
    }
    nice = _;
    return chart;
  };

  //============================================================

  return chart;
};
