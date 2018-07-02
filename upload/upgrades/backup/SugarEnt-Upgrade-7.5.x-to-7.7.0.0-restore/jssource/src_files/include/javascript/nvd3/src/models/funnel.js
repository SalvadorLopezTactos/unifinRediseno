
nv.models.funnel = function() {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 0, right: 0, bottom: 0, left: 0},
      width = 960,
      height = 500,
      y = d3.scale.linear(),
      id = Math.floor(Math.random() * 10000), //Create semi-unique ID in case user doesn't select one
      getX = function(d) { return d.x; },
      getY = function(d) { return d.height; },
      getV = function(d) { return d.value; },
      forceY = [0], // 0 is forced by default.. this makes sense for the majority of bar graphs... user can always do chart.forceY([]) to remove
      clipEdge = true,
      yDomain,
      delay = 0,
      funnelOffset = 0,
      durationMs = 0,
      fmtValueLabel = function(d) { return d.label || d.value || d; },
      color = nv.utils.defaultColor(),
      fill = color,
      classes = function(d, i) { return 'nv-bar positive'; },
      dispatch = d3.dispatch('chartClick', 'elementClick', 'elementDblClick', 'elementMouseover', 'elementMouseout', 'elementMousemove');

  //============================================================


  //============================================================
  // Private Variables
  //------------------------------------------------------------

  var y0; //used to store previous scales

  //============================================================

  function chart(selection) {
    selection.each(function(data) {
      var availableWidth = width - margin.left - margin.right,
          availableHeight = height - margin.top - margin.bottom,
          container = d3.select(this),
          labelBoxWidth = 20,
          funnelTotal = 0,
          funnelArea = 0,
          funnelBase = 0,
          funnelShift = 0,
          funnelMinHeight = 32,
          funnelRight = 0;

      //MATH: don't delete
      // h = 666.666
      // w = 600
      // m = 200
      // at what height is m = 200
      // w = h * 0.3 = 666 * 0.3 = 200
      // maxheight = ((w - m) / 2) / 0.3 = (w - m) / 0.6 = h
      // (600 - 200) / 0.6 = 400 / 0.6 = 666

      var w = Math.max(Math.min(availableHeight / 1.1, availableWidth - funnelOffset), 40), //width
          r = 0.3, // ratio of width to height (or slope)
          c = availableWidth / 2; //center

      availableHeight = Math.min(availableHeight, (w - w * r) / (2 * r));

      // TODO: use scales instead of ratio algebra
      // var funnelScale = d3.scale.linear()
      //       .domain([w / 2, minimum])
      //       .range([0, maxy1*thenscalethistopreventminimumfrompassing ]);

      function pointsTrapezoid(y0, y1, h) {
        var w0 = w / 2 - r * y0,
            w1 = w / 2 - r * y1;
        return (
          (c - w0) + ',' + (y0 * h) + ' ' +
          (c - w1) + ',' + (y1 * h) + ' ' +
          (c + w1) + ',' + (y1 * h) + ' ' +
          (c + w0) + ',' + (y0 * h)
        );
      }

      //MATH: don't delete
      // v = 1/2 * h * (b + b + 2*r*h);
      // 2v = h * (b + b + 2*r*h);
      // 2v = h * (2*b + 2*r*h);
      // 2v = 2*b*h + 2*r*h*h;
      // v = b*h + r*h*h;
      // v - b*h - r*h*h = 0;
      // v/r - b*h/r - h*h = 0;
      // b/r*h + h*h + b/r/2*b/r/2 = v/r + b/r/2*b/r/2;
      // h*h + b/r*h + b/r/2*b/r/2 = v/r + b/r/2*b/r/2;
      // (h + b/r/2)(h + b/r/2) = v/r + b/r/2*b/r/2;
      // h + b/r/2 = Math.sqrt(v/r + b/r/2*b/r/2);
      // h  = Math.abs(Math.sqrt(v/r + b/r/2*b/r/2)) - b/r/2;

      function heightTrapezoid(a, b) {
        var x = b / r / 2;
        return Math.abs(Math.sqrt(a / r + x * x)) - x;
      }

      function areaTrapezoid(h, w) {
        return h * (w - h * r);
      }

      funnelArea = areaTrapezoid(availableHeight, w);
      funnelBase = w - 2 * r * availableHeight;

      //add series index to each data point for reference
      data.map(function(series, i) {
        series.values = series.values.map(function(point) {
          point.series = i;
          // if value is undefined, not a legitimate 0 value, use point.y
          if (typeof point.value == 'undefined') {
            point.value = point.y;
          }
          funnelTotal += point.value;
          return point;
        });
        return series;
      });

      //adjust points for relative size of slice
      data.map(function(series, i) {
        series.values = series.values.map(function(point) {
          point.height = 0;
          if (funnelTotal > 0) {
            point.height = heightTrapezoid(funnelArea * point.value / funnelTotal, funnelBase);
          }
          if (point.height < funnelMinHeight / 2) {
            funnelShift += point.height - funnelMinHeight / 2;
            point.height = funnelMinHeight / 2;
          } else if (funnelShift < 0 && point.height + funnelShift > funnelMinHeight / 2) {
            point.height += funnelShift;
            funnelShift = 0;
          }
          funnelBase += 2 * r * point.height;
          return point;
        });
        return series;
      });

      data = d3.layout.stack()
               .offset('zero')
               .values(function(d) { return d.values; })
               .y(getY)(data);

      //------------------------------------------------------------
      // Setup Scales

      // remap and flatten the data for use in calculating the scales' domains
      var seriesData = (yDomain) ? [] : // if we know yDomain, no need to calculate
            data.map(function(d) {
              return d.values.map(function(d, i) {
                return { x: getX(d, i), y: getY(d, i), y0: d.y0 };
              });
            });

      y .domain(yDomain || d3.extent(d3.merge(seriesData).map(function(d) { return d.y + d.y0; }).concat(forceY)))
        .range([availableHeight, 0]);

      y0 = y0 || y;

      //------------------------------------------------------------


      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = container.selectAll('g.nv-wrap.nv-funnel').data([data]);
      var wrapEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-funnel');
      var defsEnter = wrapEnter.append('defs');
      var gEnter = wrapEnter.append('g');
      var g = wrap.select('g');

      //set up the gradient constructor function
      chart.gradient = function(d, i, p) {
        return nv.utils.colorLinearGradient(d, id + '-' + i, p, color(d, i), wrap.select('defs'));
      };

      gEnter.append('g').attr('class', 'nv-groups');
      wrap.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

      //------------------------------------------------------------
      // Clip Path

      defsEnter.append('clipPath')
        .attr('id', 'nv-edge-clip-' + id)
          .append('rect');
      wrap.select('#nv-edge-clip-' + id + ' rect')
        .attr('width', availableWidth)
        .attr('height', availableHeight);
      g.attr('clip-path', clipEdge ? 'url(#nv-edge-clip-' + id + ')' : '');

      //------------------------------------------------------------

      var groups = wrap.select('.nv-groups').selectAll('.nv-group')
            .data(function(d) { return d; }, function(d) { return d.key; });

      groups.enter().append('g')
          .attr('class', function(d, i) { return this.getAttribute('class') || classes(d, i); })
          .attr('fill', function(d, i) { return this.getAttribute('fill') || fill(d, i); });

      groups.exit().transition().duration(durationMs)
        .selectAll('polygon.nv-bar')
        .delay(function(d, i) { return i * delay / data[0].values.length; })
          .attr('points', function(d) {
              return pointsTrapezoid(y(d.y0), y(d.y0 + d.y), 0);
            })
          .remove();

      groups.exit().transition().duration(durationMs)
        .selectAll('g.nv-label-value')
        .delay(function(d, i) { return i * delay / data[0].values.length; })
          .attr('y', 0)
          .attr('transform', 'translate(' + c + ',0)')
          .style('fill-opacity', 1e-6)
          .remove();

      // groups.exit().transition().duration(durationMs)
      //   .selectAll('text.nv-label-group')
      //   .delay(function(d, i) { return i * delay / data[0].values.length; })
      //     .attr('y', 0)
      //     .attr('transform', 'translate(' + availableWidth + ',0)')
      //     .style('fill-opacity', 1e-6)
      //     .remove();

      groups
          .classed('hover', function(d) { return d.hover; })
          .classed('nv-active', function(d) { return d.active === 'active'; })
          .classed('nv-inactive', function(d) { return d.active === 'inactive'; });

      //------------------------------------------------------------
      // Polygons

      var funs = groups.selectAll('polygon.nv-bar')
          .data(function(d, i) {
            return d.values;
          });

      var funsEnter = funs.enter()
            .append('polygon')
              .attr('class', function(d, i) { return 'nv-bar positive'; })
              .attr('points', function(d) {
                return pointsTrapezoid(y(d.y0), y(d.y0 + d.y), 0);
              })
              .style('stroke', '#ffffff')
              .style('stroke-width', 3)
              .style('stroke-opacity', 1);

      funs.transition().duration(durationMs)
          .delay(function(d, i) { return i * delay / data[0].values.length; })
          .attr('points', function(d) {
            var _points;
            if (d.active && d.active === 'active') {
              w = w * 1.05;
              _points = pointsTrapezoid(y(d.y0), y(d.y0 + d.y), 1);
              w = w / 1.05;
            } else {
              _points = pointsTrapezoid(y(d.y0), y(d.y0 + d.y), 1);
            }
            return _points;
          });

      //------------------------------------------------------------

      funs
          .on('mouseover', function(d, i) { //TODO: figure out why j works above, but not here
            d3.select(this).classed('hover', true);
            dispatch.elementMouseover({
              value: getV(d, i),
              point: d,
              series: data[d.series],
              pos: [d3.event.pageX, d3.event.pageY],
              pointIndex: i,
              seriesIndex: d.series,
              e: d3.event
            });
          })
          .on('mouseout', function(d, i) {
            d3.select(this).classed('hover', false);
            dispatch.elementMouseout({
              value: getV(d, i),
              point: d,
              series: data[d.series],
              pointIndex: i,
              seriesIndex: d.series,
              e: d3.event
            });
          })
          .on('mousemove', function(d, i) {
            dispatch.elementMousemove({
              point: d,
              pointIndex: i,
              pos: [d3.event.pageX, d3.event.pageY],
              id: id
            });
          })
          .on('click', function(d, i) {
            dispatch.elementClick({
              value: getV(d, i),
              point: d,
              series: data[d.series],
              pos: [d3.event.pageX, d3.event.pageY],
              pointIndex: i,
              seriesIndex: d.series,
              e: d3.event
            });
            d3.event.stopPropagation();
          })
          .on('dblclick', function(d, i) {
            dispatch.elementDblClick({
              value: getV(d, i),
              point: d,
              series: data[d.series],
              pos: [d3.event.pageX, d3.event.pageY],
              pointIndex: i,
              seriesIndex: d.series,
              e: d3.event
            });
            d3.event.stopPropagation();
          });

      //------------------------------------------------------------
      // Value Labels

      var lblValue = groups.selectAll('.nv-label-value')
            .data(function(d) { return d.values; });

      var lblValueEnter = lblValue.enter()
            .append('g')
              .attr('class', 'nv-label-value')
              .attr('transform', 'translate(' + c + ',0)');

      // KEEP: to be used in case you want rect behind text
      // lblValueEnter.append('rect')
      //     .attr('x', -labelBoxWidth/2)
      //     .attr('y', -20)
      //     .attr('width', labelBoxWidth)
      //     .attr('height', 40)
      //     .attr('rx',3)
      //     .attr('ry',3)
      //     .style('fill', fill({},0))
      //     .attr('stroke', 'none')
      //     .style('fill-opacity', 0.4)
      //   ;

      lblValueEnter.append('text')
        .attr('class', 'nv-label')
        .attr('x', 0)
        .attr('y', -4)
        .attr('text-anchor', 'middle')
        .style('font-size', '11px')
        .style('stroke', 'none')
        .style('pointer-events', 'none')
        .style('fill', function(d, i, j) {
          var backColor = d3.select(this.parentNode).style('fill'),
              textColor = nv.utils.getTextContrast(backColor, i);
          return textColor;
        });
      lblValueEnter.append('text')
        .attr('class', 'nv-value')
        .attr('x', 0)
        .attr('y', 11)
        .attr('text-anchor', 'middle')
        .style('font-size', '15px')
        .style('stroke', 'none')
        .style('pointer-events', 'none')
        .style('fill', function(d, i, j) {
          var backColor = d3.select(this.parentNode).style('fill'),
              textColor = nv.utils.getTextContrast(backColor, i);
          return textColor;
        });
      // KEEP: to be used in case you want rect behind text
      // lblValue.selectAll('text').each(function(d, i){
      //       var width = this.getBBox().width + 20;
      //       if(width > labelBoxWidth) {
      //         labelBoxWidth = width;
      //       }
      //     });
      // lblValue.selectAll('rect').each(function(d, i){
      //       d3.select(this)
      //         .attr('width', labelBoxWidth)
      //         .attr('x', -labelBoxWidth/2);
      //     });

      lblValue.transition().duration(durationMs)
          .delay(function(d, i) {
            return i * delay / data[0].values.length;
          })
          .attr('transform', function(d) {
            var o = (y(d.y0 + d.y / 2));
            return 'translate(' + c + ',' + o + ')';
          });
      lblValue.select('text.nv-label')
          .text(function(d) {
            var s = data[d.series],
                l = s.key + (s.count ? ' (' + s.count + ')' : '');
            return (Math.round(d.height) <= funnelMinHeight) ? '' : l;
          });
      lblValue.select('text.nv-value')
          .text(function(d) {
            return (Math.round(d.height) <= funnelMinHeight) ? '' : fmtValueLabel(d);
          });

      //------------------------------------------------------------
      // Group Labels

      // var lblGroup = groups.selectAll('text.nv-label-group')
      //     .data(function(d) {
      //       d.values.map(function(v) {
      //         v.count = d.count;
      //       });
      //       return d.values;
      //     });

      // var lblGroupEnter = lblGroup.enter()
      //     .append('text')
      //       .attr('class', 'nv-label-group')
      //       .attr('x', 0)
      //       .attr('y', 0)
      //       .attr('dx', -10)
      //       .attr('dy', 5)
      //       .attr('text-anchor', 'middle')
      //       .attr('transform', 'translate(' + availableWidth + ',0)')
      //       .text(function(d) { return d.count; })
      //       .style('stroke', 'none')
      //       .style('fill', 'black')
      //       .style('fill-opacity', 1e-6)
      //       .style('font-size', '15px')
      //       .style('font-weight', 'bold');

      // lblGroup.transition().duration(durationMs)
      //     .delay(function(d, i) { return i * delay / data[0].values.length; })
      //     .attr('transform', function(d) { return 'translate(' + availableWidth + ',' + (y(d.y0 + d.y / 2)) + ')'; })
      //     .style('fill-opacity', 1);


      //store old scales for use in transitions on update
      y0 = y.copy();

    });

    return chart;
  }


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  chart.dispatch = dispatch;

  chart.color = function(_) {
    if (!arguments.length) return color;
    color = _;
    return chart;
  };
  chart.fill = function(_) {
    if (!arguments.length) return fill;
    fill = _;
    return chart;
  };
  chart.classes = function(_) {
    if (!arguments.length) return classes;
    classes = _;
    return chart;
  };
  chart.gradient = function(_) {
    if (!arguments.length) return gradient;
    gradient = _;
    return chart;
  };

  chart.x = function(_) {
    if (!arguments.length) return getX;
    getX = _;
    return chart;
  };

  chart.y = function(_) {
    if (!arguments.length) return getY;
    getY = _;
    return chart;
  };

  chart.margin = function(_) {
    if (!arguments.length) return margin;
    margin = _;
    return chart;
  };

  chart.width = function(_) {
    if (!arguments.length) return width;
    width = _;
    return chart;
  };

  chart.height = function(_) {
    if (!arguments.length) return height;
    height = _;
    return chart;
  };

  chart.xScale = function(_) {
    if (!arguments.length) return x;
    x = _;
    return chart;
  };

  chart.yScale = function(_) {
    if (!arguments.length) return y;
    y = _;
    return chart;
  };

  chart.yDomain = function(_) {
    if (!arguments.length) return yDomain;
    yDomain = _;
    return chart;
  };

  chart.forceY = function(_) {
    if (!arguments.length) return forceY;
    forceY = _;
    return chart;
  };

  chart.id = function(_) {
    if (!arguments.length) return id;
    id = _;
    return chart;
  };

  chart.delay = function(_) {
    if (!arguments.length) return delay;
    delay = _;
    return chart;
  };

  chart.clipEdge = function(_) {
    if (!arguments.length) return clipEdge;
    clipEdge = _;
    return chart;
  };

  chart.fmtValueLabel = function(_) {
    if (!arguments.length) return fmtValueLabel;
    fmtValueLabel = d3.functor(_);
    return chart;
  };

  chart.offset = function(_) {
    if (!arguments.length) return funnelOffset;
    funnelOffset = _;
    return chart;
  };
  //============================================================

  return chart;
}
