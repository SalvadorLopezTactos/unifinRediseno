nv.models.axis = function() {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var axis = d3.svg.axisStatic();

  var margin = {top: 0, right: 0, bottom: 0, left: 0},
      thickness = 0,
      scale = d3.scale.linear(),
      axisLabelText = null,
      showMaxMin = true, //TODO: showMaxMin should be disabled on all ordinal scaled axes
      highlightZero = true,
      rotateTicks = 0,//one of (rotateTicks, staggerTicks, wrapTicks)
      staggerTicks = false,
      wrapTicks = false,
      reduceXTicks = false, // if false a tick will show for every data point
      rotateYLabel = true,
      isOrdinal = false,
      textAnchor = null,
      ticks = null,
      axisLabelDistance = 8; //The larger this number is, the closer the axis label is to the axis.

  axis
    .scale(scale)
    .orient('bottom')
    .tickFormat(function(d) { return d; });

  //============================================================


  //============================================================
  // Private Variables
  //------------------------------------------------------------

  var scale0;

  //============================================================

  function chart(selection) {
    selection.each(function(data) {
      var container = d3.select(this);

      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = container.selectAll('g.nv-wrap.nv-axis').data([data]),
          gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-axis').append('g'),
          g = wrap.select('g');

      //------------------------------------------------------------

      var orientation = axis.orient() === 'left' || axis.orient() === 'right' ? 'vertical' : 'horizontal';

      var tickPaddingOriginal = axis.tickPadding(),
          fmt = axis.tickFormat(),
          w = (scale.range().length === 2) ? scale.range()[1] : (scale.range()[scale.range().length - 1] + (scale.range()[1] - scale.range()[0])),
          label = {y: 0, dy: 0, x: w / 2, a: 'middle', t: ''},
          maxmin = {};

      if (ticks !== null) {
        axis.ticks(ticks);
      } else if (axis.orient() === 'top' || axis.orient() === 'bottom') {
        axis.ticks(Math.ceil(Math.abs(scale.range()[1] - scale.range()[0]) / 100));
      }

      if (rotateTicks % 360 && axis.orient() === 'bottom') {
        axis.tickPadding(0);
      }

      g.call(axis);

      axis.tickPadding(tickPaddingOriginal);

      scale0 = scale0 || axis.scale();

      if (fmt === null) {
        fmt = scale0.tickFormat();
      }

      //------------------------------------------------------------
      //Calculate the longest tick width and height

      var maxTickWidth = 0,
          maxTickHeight = 0;
      var tickText = g.selectAll('g.tick').select('text');
      tickText.each(function(d, i) {
        var bbox = this.getBoundingClientRect(),
            size = {w: parseInt(bbox.width, 10), h: parseInt(bbox.height / 1.15, 10)};
        if (size.w > maxTickWidth) {
          maxTickWidth = size.w;
        }
        if (size.h > maxTickHeight) {
          maxTickHeight = size.h;
        }
      });

      thickness = tickPaddingOriginal + (!!axisLabelText ? axisLabelDistance : 0);

      //------------------------------------------------------------
      // Orientation parameters

      switch (axis.orient()) {
      case 'top':

        if (axisLabelText) {
          label.y = -thickness;
          label.dy = '-.71em';
        }

        if (showMaxMin) {
          maxmin = {
            data: scale.domain(),
            translate: function(d, i) { return 'translate(' + scale(d) + ',0)'; },
            dy: '0em',
            x: 0,
            y: -axis.tickPadding(),
            transform: '',
            anchor: rotateTicks ? (rotateTicks % 360 > 0 ? 'start' : 'end') : 'middle'
          };
        }

        break;

      case 'bottom':

        if (rotateTicks % 360) {

          //Convert to radians before calculating sin. Add 30 to margin for healthy padding.
          var sin = Math.abs(Math.sin(rotateTicks * Math.PI / 180));
          thickness += sin ? sin * maxTickWidth : maxTickWidth;
          thickness += sin ? sin * maxTickHeight : 0;
          //Rotate all tickText
          tickText
            .attr('transform', function(d, i, j) { return 'translate(0,' + tickPaddingOriginal + ') rotate(' + rotateTicks + ')'; })
            .style('text-anchor', rotateTicks % 360 > 0 ? 'start' : 'end');

        } else if (wrapTicks) {

          var maxRows = 1;

          g .selectAll('.tick').select('text')
              .each(function(d) {

                var textContent = this.textContent,
                    textNode = d3.select(this),
                    textArray = textContent.split(' '),
                    i = 0,
                    l = textArray.length,
                    dy = 0.71,
                    rows = 1,
                    maxWidth = axis.scale().rangeBand();

                if (this.getBoundingClientRect().width > maxWidth) {
                  this.textContent = '';

                  do {
                    var textString,
                      textSpan = textNode.append('tspan')
                        .text(textArray[i] + ' ')
                        .attr('dy', dy + 'em')
                        .attr('x', 0 + 'px');

                    if (i === 0) {
                      dy = 1;
                    }

                    i += 1;

                    while (i < l) {
                      textString = textSpan.text();
                      textSpan.text(textString + ' ' + textArray[i]);
                      if (this.getBoundingClientRect().width <= maxWidth) {
                        i += 1;
                      } else {
                        textSpan.text(textString);
                        rows += 1;
                        break;
                      }
                    }
                  } while (i < l);
                }

                maxRows = Math.max(maxRows, rows);
              });

          thickness += maxRows * maxTickHeight;

        } else if (staggerTicks) {

          tickText
            .attr('transform', function(d, i) { return 'translate(0,' + (i % 2 === 0 ? '0' : '12') + ')'; });

          thickness += 2 * maxTickHeight;

        } else {

          thickness += maxTickHeight;

        }

        if (axisLabelText) {
          label.y = thickness;
          label.dy = '.71em';
        }

        if (reduceXTicks) {
          g .selectAll('.tick')
              .each(function(d, i) {
                d3.select(this).selectAll('text,line')
                  .style('opacity', i % Math.ceil(data[0].values.length / (w / 100)) !== 0 ? 0 : 1);
              });
        }

        if (showMaxMin) {
          maxmin = {
            data: [scale.domain()[0], scale.domain()[scale.domain().length - 1]],
            translate: function(d, i) {
              return 'translate(' + (scale(d) + (isOrdinal ? scale.rangeBand() / 2 : (d > 0 ? -8 : +4))) + ',0)';
            },
            dy: '.71em',
            x: 0,
            y: axis.tickPadding(),
            rotate: function(d) { return 'rotate(' + rotateTicks + ' 0,0)'; },
            anchor: rotateTicks ? (rotateTicks % 360 > 0 ? 'start' : 'end') : 'middle'
          };
        }

        break;

      case 'right':

        thickness += maxTickWidth;

        if (axisLabelText) {
          label = {
            y: rotateYLabel ? -thickness : -10,
            dy: 0,
            x: rotateYLabel ? scale.range()[0] / 2 : axis.tickPadding(),
            a: rotateYLabel ? 'middle' : 'begin',
            t: rotateYLabel ? 'rotate(90)' : ''
          };
        }

        if (showMaxMin) {
          maxmin = {
            data: scale.domain(),
            translate: function(d, i) { return 'translate(0,' + scale(d) + ')'; },
            dy: '.32em',
            x: axis.tickPadding(),
            y: 0,
            rotate: '',
            anchor: textAnchor ? textAnchor : 'start'
          };
        }
        break;

      case 'left':

        thickness += maxTickWidth;

        if (axisLabelText) {
          label = {
            y: rotateYLabel ? -thickness : -10, //TODO: consider calculating this based on largest tick width... OR at least expose this on chart
            dy: 0,
            x: rotateYLabel ? -scale.range()[0] / 2 : -axis.tickPadding(),
            a: rotateYLabel ? 'middle' : 'end',
            t: rotateYLabel ? 'rotate(-90)' : ''
          };
        }

        if (showMaxMin) {
          maxmin = {
            data: scale.domain(),
            translate: function(d, i) { return 'translate(0,' + scale(d) + ')'; },
            dy: '.32em',
            x: -axis.tickPadding(),
            y: 0,
            rotate: '',
            anchor: textAnchor ? textAnchor : 'end'
          };
        }

        break;
      }

      //------------------------------------------------------------
      // Axis label

      var axisLabel = g.selectAll('text.nv-axislabel').data([axisLabelText]);

      if (textAnchor) {
        g.selectAll('g.tick') // the g's wrapping each tick
          .each(function(d, i) {
            d3.select(this).select('text')
              .style('text-anchor', textAnchor);
          });
      }

      axisLabel.exit().remove();
      axisLabel.enter().append('text').attr('class', 'nv-axislabel');

      if (axisLabelText) {
        axisLabel
          .text(function(d) { return d; })
          .attr('y', label.y)
          .attr('dy', label.dy)
          .attr('x', label.x)
          .attr('transform', label.t)
          .style('text-anchor', label.a);

        axisLabel.each(function(d, i) {
          thickness += orientation === 'horizontal' ?
            parseInt(this.getBoundingClientRect().height / 1.15, 10) :
            parseInt(this.getBoundingClientRect().width / 1.15, 10);
        });
      }

      //------------------------------------------------------------
      // Min Max values

      if (showMaxMin) {
        var axisMaxMin = wrap.selectAll('g.nv-axisMaxMin').data(maxmin.data);
        axisMaxMin.enter().append('g').attr('class', 'nv-axisMaxMin').append('text')
          .style('opacity', 0);
        axisMaxMin.exit().remove();
        axisMaxMin
            .attr('transform', maxmin.translate)
          .select('text')
            .text(function(d, i) {
              var v = fmt(d);
              return ('' + v).match('NaN') ? '' : v;
            })
            .attr('dy', maxmin.dy)
            .attr('x', maxmin.x)
            .attr('y', maxmin.y)
            .attr('transform', maxmin.rotate)
            .style('text-anchor', maxmin.anchor);
        axisMaxMin
            .attr('transform', maxmin.translate)
          .select('text')
            .style('opacity', 1);
      }

      if (showMaxMin && (axis.orient() === 'left' || axis.orient() === 'right')) {
        //check if max and min overlap other values, if so, hide the values that overlap
        g .selectAll('g.tick') // the g's wrapping each tick
            .each(function(d, i) {
              d3.select(this).select('text').style('opacity', 1);
              if (scale(d) > scale.range()[0] - 10 || scale(d) < scale.range()[1] + 10) { // 10 is assuming text height is 16... if d is 0, leave it!
                if (d < 1e-10 && d > -1e-10) {// accounts for minor floating point errors... though could be problematic if the scale is EXTREMELY SMALL
                  d3.select(this).select('text').style('opacity', 0);
                  d3.select(this).select('line').style('opacity', 0);
                }
                d3.select(this).select('text').style('opacity', 0); // Don't remove the ZERO line!!
              }
            });

        //if Max and Min = 0 only show min, Issue #281
        if (scale.domain()[0] === scale.domain()[1] && scale.domain()[0] === 0) {
          wrap.selectAll('g.nv-axisMaxMin')
            .style('opacity', function(d, i) { return !i ? 1 : 0; });
        }
      }

      if (showMaxMin && (axis.orient() === 'top' || axis.orient() === 'bottom')) {
        var maxMinRange = [];
        wrap.selectAll('g.nv-axisMaxMin')
              .each(function(d, i) {
                try {
                  if (i) { // i== 1, max position
                    maxMinRange.push(scale(d) - this.getBoundingClientRect().width - 4);  //assuming the max and min labels are as wide as the next tick (with an extra 4 pixels just in case)
                  }
                  else { // i==0, min position
                    maxMinRange.push(scale(d) + this.getBoundingClientRect().width + 4);
                  }
                } catch (err) {
                  if (i) { // i== 1, max position
                    maxMinRange.push(scale(d) - 4);  //assuming the max and min labels are as wide as the next tick (with an extra 4 pixels just in case)
                  }
                  else { // i==0, min position
                    maxMinRange.push(scale(d) + 4);
                  }
                }
              });

        //check if max and min overlap other values, if so, hide the values that overlap
        g.selectAll('g.tick') // the g's wrapping each tick
            .each(function(d, i) {
              d3.select(this).select('text').style('opacity', 1);
              if (scale(d) < maxMinRange[0] || scale(d) > maxMinRange[1]) {
                if (d < 1e-10 && d > -1e-10) {// accounts for minor floating point errors... though could be problematic if the scale is EXTREMELY SMALL
                  d3.select(this).select('text').style('opacity', 0);
                  d3.select(this).select('line').style('opacity', 0);
                }
                d3.select(this).select('text').style('opacity', 0); // Don't remove the ZERO line!!
              }
            });
      }


      //highlight zero line ... Maybe should not be an option and should just be in CSS?
      if (highlightZero) {
        g .selectAll('line.tick')
            .filter(function(d) {
              return !parseFloat(Math.round(d * 100000) / 1000000);
            }) //this is because sometimes the 0 tick is a very small fraction, TODO: think of cleaner technique
              .classed('zero', true);
      }

      //store old scales for use in transitions on update
      scale0 = scale.copy();

    });

    return chart;
  }


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  // expose chart's sub-components
  chart.axis = axis;

  d3.rebind(chart, axis, 'orient', 'tickValues', 'tickSubdivide', 'tickSize', 'tickPadding', 'tickFormat');
  d3.rebind(chart, scale, 'domain', 'range', 'rangeBand', 'rangeBands'); //these are also accessible by chart.scale(), but added common ones directly for ease of use

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
      return thickness;
    }
    thickness = _;
    return chart;
  };

  chart.height = function(_) {
    if (!arguments.length) {
      return thickness;
    }
    thickness = _;
    return chart;
  };

  chart.ticks = function(_) {
    if (!arguments.length) {
      return ticks;
    }
    ticks = _;
    return chart;
  };

  chart.axisLabel = function(_) {
    if (!arguments.length) {
      return axisLabelText;
    }
    axisLabelText = _;
    return chart;
  };

  chart.showMaxMin = function(_) {
    if (!arguments.length) {
      return showMaxMin;
    }
    showMaxMin = _;
    return chart;
  };

  chart.highlightZero = function(_) {
    if (!arguments.length) {
      return highlightZero;
    }
    highlightZero = _;
    return chart;
  };

  chart.scale = function(_) {
    if (!arguments.length) {
      return scale;
    }
    scale = _;
    axis.scale(scale);
    isOrdinal = typeof scale.rangeBands === 'function';
    d3.rebind(chart, scale, 'domain', 'range', 'rangeBand', 'rangeBands');
    return chart;
  };

  chart.wrapTicks = function(_) {
    if (!arguments.length) {
      return wrapTicks;
    }
    wrapTicks = _;
    rotateTicks = 0;
    staggerTicks = false;
    return chart;
  };

  chart.rotateTicks = function(_) {
    if (!arguments.length) {
      return rotateTicks;
    }
    rotateTicks = _;
    wrapTicks = false;
    staggerTicks = false;
    return chart;
  };

  chart.staggerTicks = function(_) {
    if (!arguments.length) {
      return staggerTicks;
    }
    staggerTicks = _;
    wrapTicks = false;
    rotateTicks = 0;
    return chart;
  };

  chart.reduceXTicks = function(_) {
    if (!arguments.length) {
      return reduceXTicks;
    }
    reduceXTicks = _;
    return chart;
  };

  chart.rotateYLabel = function(_) {
    if (!arguments.length) {
      return rotateYLabel;
    }
    rotateYLabel = _;
    return chart;
  };

  chart.axisLabelDistance = function(_) {
    if (!arguments.length) {
      return axisLabelDistance;
    }
    axisLabelDistance = _;
    return chart;
  };

  chart.maxTickWidth = function(_) {
    if (!arguments.length) {
      return maxTickWidth;
    }
    maxTickWidth = _;
    return chart;
  };

  chart.textAnchor = function(_) {
    if (!arguments.length) {
      return textAnchor;
    }
    textAnchor = _;
    return chart;
  };

  //============================================================


  return chart;
};
