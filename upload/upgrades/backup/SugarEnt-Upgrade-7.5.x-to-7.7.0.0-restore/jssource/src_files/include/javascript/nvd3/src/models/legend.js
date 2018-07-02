nv.models.legend = function () {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 10, right: 10, bottom: 10, left: 10},
      width = 0,
      height = 0,
      align = 'right',
      position = 'start',
      radius = 5,
      gutter = 10,
      equalColumns = true,
      showAll = false,
      rowsCount = 2, //number of rows to display if showAll = false
      enabled = false,
      strings = {close: 'Hide legend', type: 'Show legend'},
      id = Math.floor(Math.random() * 10000), //Create semi-unique ID in case user doesn't select one
      getKey = function (d) {
        return d.key.length > 0 || (!isNaN(parseFloat(d.key)) && isFinite(d.key)) ? d.key : 'undefined';
      },
      color = nv.utils.defaultColor(),
      classes = function (d, i) {
        return '';
      },
      dispatch = d3.dispatch('legendClick', 'legendMouseover', 'legendMouseout', 'toggleMenu', 'closeMenu');

  // Private Variables
  //------------------------------------------------------------

  var legendOpen = 0;

  //============================================================

  function legend(selection) {

    selection.each(function (data) {

      var container = d3.select(this),
          containerWidth = width,
          containerHeight = height,
          keyWidths = [],
          legendHeight = 0,
          dropdownHeight = 0,
          type = '';

      if (!data || !data.length || !data.filter(function (d) { return !d.values || d.values.length; }).length) {
        return legend;
      }

      enabled = true;

      type = !data[0].type || data[0].type === 'bar' ? 'bar' : 'line';

      //------------------------------------------------------------
      // Setup containers and skeleton of legend

      var wrap = container.selectAll('g.nv-chart-legend').data([data]);
      var wrapEnter = wrap.enter().append('g').attr('class', 'nv-chart-legend');

      var defs = wrapEnter.append('defs');
      defs
        .append('clipPath').attr('id', 'nv-edge-clip-' + id)
        .append('rect');
      var clip = wrap.select('#nv-edge-clip-' + id + ' rect');

      wrapEnter
        .append('rect').attr('class', 'nv-legend-background');
      var back = container.select('.nv-legend-background');

      wrapEnter
        .append('text').attr('class', 'nv-legend-link');
      var link = container.select('.nv-legend-link');

      wrapEnter
        .append('g').attr('class', 'nv-legend-mask')
        .append('g').attr('class', 'nv-legend');
      var mask = container.select('.nv-legend-mask');
      var g = container.select('g.nv-legend');

      var series = g.selectAll('.nv-series').data(function (d) { return d; });
      var seriesEnter = series.enter().append('g').attr('class', 'nv-series');
      series.exit().remove();

      var zoom = d3.behavior.zoom();

      function zoomLegend(d) {
        var trans = d3.transform(g.attr('transform')).translate,
          transY = trans[1] + d3.event.sourceEvent.wheelDelta / 4,
          diffY = dropdownHeight - legendHeight,
          upMax = Math.max(transY, diffY); //should not go beyond diff
        if (upMax) {
          g .attr('transform', 'translate(0,' + Math.min(upMax, 0) + ')');
        }
      }

      clip
        .attr('x', 0.5 - margin.left)
        .attr('y', 0.5)
        .attr('width', 0)
        .attr('height', 0);

      back
        .attr('x', 0.5)
        .attr('y', 0.5)
        .attr('rx', 2)
        .attr('ry', 2)
        .attr('width', 0)
        .attr('height', 0)
        .style('opacity', 0)
        .style('pointer-events', 'all');

      if (!showAll) {
        back
          .attr('filter', nv.utils.dropShadow('legend_back_' + id, defs, {blur: 2}));
      }

      link
        .text(legendOpen === 1 ? legend.strings().close : legend.strings().open)
        .attr('text-anchor', align === 'left' ? 'start' : 'end')
        .attr('dy', '.32em')
        .attr('dx', 0)
        .style('opacity', 0)
        .on('click', function (d, i) {
          dispatch.toggleMenu(d, i);
        });

      seriesEnter
        .on('mouseover', function (d, i) {
          dispatch.legendMouseover(d, i);  //TODO: Make consistent with other event objects
        })
        .on('mouseout', function (d, i) {
          dispatch.legendMouseout(d, i);
        })
        .on('click', function (d, i) {
          dispatch.legendClick(d, i);
          d3.event.stopPropagation();
        });

      if (type === 'bar') {

        seriesEnter.append('circle')
          .attr('r', radius)
          .attr('class', function (d, i) {
            return this.getAttribute('class') || classes(d, i);
          })
          .attr('fill', function (d, i) {
            return this.getAttribute('fill') || color(d, i);
          })
          .attr('stroke', function (d, i) {
            return this.getAttribute('fill') || color(d, i);
          })
          .style('stroke-width', 2);

        seriesEnter.append('text')
          .text(getKey)
          .attr('dy', '.36em');

      } else {

        seriesEnter.append('circle')
          .attr('r', function (d, i) {
            return d.type === 'dash' ? 0 : radius;
          })
          .attr('class', function (d, i) {
            return this.getAttribute('class') || classes(d, i);
          })
          .attr('fill', function (d, i) {
            return this.getAttribute('fill') || color(d, i);
          })
          .attr('stroke', function (d, i) {
            return this.getAttribute('fill') || color(d, i);
          })
          .style('stroke-width', 0);

        seriesEnter.append('line')
          .attr('class', function (d, i) {
            return this.getAttribute('class') || classes(d, i);
          })
          .attr('stroke', function (d, i) {
            return this.getAttribute('stroke') || color(d, i);
          })
          .attr('stroke-width', 3)
          .attr('x0', 0)
          .attr('y0', 0)
          .attr('y1', 0)
          .style('stroke-width', '4px');

        seriesEnter.append('circle')
          .attr('r', function (d, i) {
            return d.type === 'dash' ? 0 : radius;
          })
          .attr('class', function (d, i) {
            return this.getAttribute('class') || classes(d, i);
          })
          .attr('fill', function (d, i) {
            return this.getAttribute('fill') || color(d, i);
          })
          .attr('stroke', function (d, i) {
            return this.getAttribute('fill') || color(d, i);
          })
          .style('stroke-width', 0);

        seriesEnter.append('text')
          .text(getKey)
          .attr('dy', '.32em')
          .attr('dx', 0)
          .attr('text-anchor', position);

      }

      series.classed('disabled', function (d) {
        return d.disabled;
      });

      //------------------------------------------------------------

      //TODO: add ability to add key to legend
      //var label = g.append('text').text('Probability:').attr('class','nv-series-label').attr('transform','translate(0,0)');

      // store legend label widths
      legend.calculateWidth = function () {

        var shift = gutter + (position === 'start' ? 2 * radius + 3 : 0);
        keyWidths = [];

        g .style('display', 'inline');

        series.select('text').each(function (d, i) {
          var textWidth = d3.select(this).node().getBBox().width;
          keyWidths.push(Math.max(Math.floor(textWidth) + shift, 50));
        });

        legend.width(d3.sum(keyWidths) - gutter);

        return legend.width();
      };

      legend.getLineHeight = function () {
        g .style('display', 'inline');
        var lineHeightBB = Math.floor(series.select('text').node().getBBox().height);
        return lineHeightBB;
      };

      legend.arrange = function (w) {

        containerWidth = w;

        if (keyWidths.length === 0) {
          this.calculateWidth();
        }

        var keys = keyWidths.length,
            rows = 1,
            cols = keys,
            columnWidths = [],
            keyPositions = [],
            leftOffSet = 0,
            topOffset = 0,
            maxRowWidth = 0,
            lineSpacing = position === 'start' ? 10 : 6,
            textHeight = this.getLineHeight(),
            lineHeight = lineSpacing + radius * 2 + (position === 'start' ? 0 : textHeight),
            xpos = 0,
            ypos = 0,
            i;

        if (equalColumns) {

          //keep decreasing the number of keys per row until
          //legend width is less than the available width
          while (cols > 0) {
            columnWidths = [];
            for (i = 0; i < keys; i += 1) {
              if (keyWidths[i] > (columnWidths[i % cols] || 0)) {
                columnWidths[i % cols] = keyWidths[i];
              }
            }
            if (d3.sum(columnWidths) < containerWidth) {
              break;
            }
            cols -= 1;
          }

          rows = Math.ceil(keys / cols);
          maxRowWidth = d3.sum(columnWidths) - gutter;

          for (i = 0; i < keys; i += 1) {
            if (position === 'start') {
              xpos += i % cols === 0 ? 0 - xpos : columnWidths[i % cols - 1];
            } else {
              xpos += (i % cols === 0 ? 0 - xpos : columnWidths[i % cols - 1] / 2) + columnWidths[i % cols] / 2;
            }
            ypos = Math.floor(i / cols) * lineHeight;
            keyPositions[i] = {x: xpos, y: ypos};
          }

        } else {

          for (i = 0; i < keys; i += 1) {
            if (xpos + keyWidths[i] - gutter > containerWidth) {
              xpos = 0;
              rows += 1;
            }
            if (xpos + keyWidths[i] - gutter > maxRowWidth) {
              maxRowWidth = xpos + keyWidths[i] - gutter;
            }
            keyPositions[i] = {x: xpos, y: (rows - 1) * (lineSpacing + radius * 2)};
            xpos += keyWidths[i];
          }

        }

        if (showAll || rows < rowsCount + 1) {

          legendOpen = 0;

          topOffset = 0.5 + margin.top + radius;

          legend
            .width(margin.left + maxRowWidth + margin.right)
            .height(margin.top + rows * lineHeight - lineSpacing + margin.bottom);

          leftOffSet = 0.5 + (align === 'right' ?
            containerWidth - legend.width() + margin.right :
            align === 'center' ?
              (containerWidth - legend.width()) / 2 :
              0 - margin.left);

          zoom
            .on('zoom', null);

          clip
            .attr('y', 0 - topOffset)
            .attr('width', legend.width())
            .attr('height', legend.height());

          back
            .attr('x', leftOffSet)
            .attr('width', legend.width())
            .attr('height', legend.height())
            .style('opacity', 0)
            .style('display', 'inline');

          mask
            .attr('clip-path', 'none')
            .attr('transform', 'translate(' + (leftOffSet + margin.left + (position === 'start' ? radius : 0 - gutter / 2)) + ',' + topOffset + ')');

          g
            .style('opacity', 1)
            .style('display', 'inline');

          series
            .attr('transform', function (d, i) {
              var pos = keyPositions[i];
              return 'translate(' + pos.x + ',' + pos.y + ')';
            });

          series
            .selectAll('text')
              .attr('text-anchor', position)
              .attr('transform', function (d, i) {
                return position === 'start' ? 'translate(8,0)' : 'translate(0,' +  textHeight + ')';
              });
          series
            .selectAll('circle')
              .attr('transform', function (d, i) {
                return 'translate(' + (position === 'start' || type === 'bar' ? 0 : (i ? 15 : -15)) + ',0)';
              });
          series
            .selectAll('line')
              .attr('x1', function (d, i) {
                return d.type === 'dash' ? 40 : 30;
              })
              .attr('transform', function (d, i) {
                return d.type === 'dash' ? 'translate(-20,0)' : 'translate(-15,0)';
              })
              .style('stroke-dasharray', function (d, i) {
                return d.type === 'dash' ? '8, 8' : '0,0';
              });

        } else {

          legend
            .width(margin.left + d3.max(keyWidths) - gutter + (position === 'start' ? 0 : 2 * radius + 3) + margin.right)
            .height(margin.top + radius * 2 + margin.bottom);

          leftOffSet = 0.5 + (align === 'left' ? 0 : containerWidth - legend.width());
          topOffset = 0.5 + legend.height() + margin.top + radius;
          legendHeight = margin.top + radius * 2 * keys + (keys - 1) * 10 + margin.bottom;//TODO: why is this 10 hardcoded?
          dropdownHeight = Math.min(containerHeight - legend.height(), legendHeight);

          zoom
            .on('zoom', zoomLegend);

          clip
            .attr('y', 0 - margin.top - radius)
            .attr('width', legend.width())
            .attr('height', dropdownHeight);

          back
            .attr('x', leftOffSet)
            .attr('y', 0.5 + legend.height())
            .attr('width', legend.width())
            .attr('height', dropdownHeight)
            .style('opacity', legendOpen * 0.9)
            .style('display', legendOpen ? 'inline' : 'none')
            .call(zoom);

          link
            .attr('transform', 'translate(' + (align === 'left' ? 0 : containerWidth) + ',' + (margin.top + radius) + ')')
            .style('opacity', 1);

          mask
            .attr('clip-path', 'url(#nv-edge-clip-' + id + ')')
            .attr('transform', 'translate(' + (leftOffSet + margin.left + radius) + ',' + topOffset + ')');

          g
            .style('opacity', legendOpen)
            .style('display', legendOpen ? 'inline' : 'none')
            .call(zoom);

          series
            .attr('transform', function (d, i) {
              return 'translate(0,' + (i * (10 + radius * 2)) + ')';//TODO: why is this 10 hardcoded?
            });
          series
            .selectAll('circle')
              .attr('transform', '');
          series
            .selectAll('line')
              .attr('x1', 16)
              .attr('transform', 'translate(-8,0)')
              .style('stroke-dasharray', 'inherit');
          series
            .selectAll('text')
              .attr('text-anchor', 'start')
              .attr('transform', 'translate(' + (type === 'bar' ? 8 : 10) + ',0)'); //TODO: why are these hardcoded?

        }

      };

      //============================================================
      // Event Handling/Dispatching (in chart's scope)
      //------------------------------------------------------------

      function displayMenu() {
        back
          .style('opacity', legendOpen * 0.9)
          .style('display', legendOpen ? 'inline' : 'none');
        g
          .style('opacity', legendOpen)
          .style('display', legendOpen ? 'inline' : 'none');
        link
          .text(legendOpen === 1 ? legend.strings().close : legend.strings().open);
      }

      dispatch.on('toggleMenu', function (d) {
        d3.event.stopPropagation();
        legendOpen = 1 - legendOpen;
        displayMenu();
      });

      dispatch.on('closeMenu', function (d) {
        if (legendOpen === 1) {
          legendOpen = 0;
          displayMenu();
        }
      });

    });

    return legend;
  }


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  legend.dispatch = dispatch;

  legend.margin = function (_) {
    if (!arguments.length) { return margin; }
    margin.top    = typeof _.top    !== 'undefined' ? _.top    : margin.top;
    margin.right  = typeof _.right  !== 'undefined' ? _.right  : margin.right;
    margin.bottom = typeof _.bottom !== 'undefined' ? _.bottom : margin.bottom;
    margin.left   = typeof _.left   !== 'undefined' ? _.left   : margin.left;
    return legend;
  };

  legend.width = function (_) {
    if (!arguments.length) {
      return width;
    }
    width = Math.round(_);
    return legend;
  };

  legend.height = function (_) {
    if (!arguments.length) {
      return height;
    }
    height = Math.round(_);
    return legend;
  };

  legend.id = function (_) {
    if (!arguments.length) {
      return id;
    }
    id = _;
    return legend;
  };

  legend.key = function (_) {
    if (!arguments.length) {
      return getKey;
    }
    getKey = _;
    return legend;
  };

  legend.color = function (_) {
    if (!arguments.length) {
      return color;
    }
    color = nv.utils.getColor(_);
    return legend;
  };

  legend.classes = function (_) {
    if (!arguments.length) {
      return classes;
    }
    classes = _;
    return legend;
  };

  legend.align = function (_) {
    if (!arguments.length) {
      return align;
    }
    align = _;
    return legend;
  };

  legend.position = function (_) {
    if (!arguments.length) {
      return position;
    }
    position = _;
    return legend;
  };

  legend.showAll = function(_) {
    if (!arguments.length) { return showAll; }
    showAll = _;
    return legend;
  };

  legend.rowsCount = function (_) {
    if (!arguments.length) {
      return rowsCount;
    }
    rowsCount = _;
    return legend;
  };

  legend.lineSpacing = function (_) {
    if (!arguments.length) {
      return lineSpacing;
    }
    lineSpacing = _;
    return legend;
  };

  legend.strings = function (_) {
    if (!arguments.length) {
      return strings;
    }
    strings = _;
    return legend;
  };

  legend.equalColumns = function (_) {
    if (!arguments.length) {
      return equalColumns;
    }
    equalColumns = _;
    return legend;
  };

  legend.enabled = function (_) {
    if (!arguments.length) {
      return enabled;
    }
    enabled = _;
    return legend;
  };

  //============================================================


  return legend;
};
