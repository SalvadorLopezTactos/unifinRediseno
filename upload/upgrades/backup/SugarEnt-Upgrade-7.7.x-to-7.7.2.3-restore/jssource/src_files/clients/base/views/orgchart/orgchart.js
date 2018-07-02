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
/**
 * View that displays a list of models pulled from the context's collection.
 *
 * @class View.Views.Base.OrgchartView
 * @alias SUGAR.App.view.views.BaseOrgchartView
 * @extends View.View
 */
({
    events: {
        'click .zoom-control': 'zoomChart',
        'click .toggle-control': 'toggleChart'
    },
    plugins: ['Dashlet', 'Tooltip', 'Chart'],

    // user configurable
    nodetemplate: null,
    reporteesEndpoint: '',
    zoomExtents: null,
    nodeSize: null,

    // private
    jsTree: null,
    slider: null,
    sliderZoomIn: null,
    sliderZoomOut: null,
    container: null,

    /**
     * Initialize the View
     *
     * @constructor
     * @param {Object} options
     */
    initialize: function(options) {
        var self = this;
        this._super('initialize', [options]);

        //TODO: change api to accept id as param or attrib as object to produce
        this.reporteesEndpoint = app.api.buildURL('Forecasts', 'orgtree/' + app.user.get('id'), null, {'level': 2});
        this.zoomExtents = {'min': 0.25, 'max': 1.75};
        this.nodeSize = {'width': 124, 'height': 56};

        this.chart = nv.models.tree()
                .duration(300)
                .nodeSize(this.nodeSize)
                .nodeRenderer(self.nodeRenderer)
                .zoomExtents(self.zoomExtents)
                .zoomCallback(function(scale) {
                    self.moveSlider(scale);
                })
                .horizontal(false)
                .getId(function(d) {
                    return d.metadata.id;
                })
                .nodeClick(function() {
                    var route = d3.select(this).select('.nv-org-name').attr('data-url');
                    app.router.navigate(route, {trigger: true});
                })
                .nodeCallback(function(d) {
                    d.selectAll('text').text(function() {
                        var text = d3.select(this).text();
                        return nv.utils.stringEllipsify(text, self.container, 96);
                    });
                    d.selectAll('image')
                        .on('error', function(d) {
                            d3.select(this).attr('xlink:href', 'include/images/user.svg');
                        });
                    d.select('.nv-org-name')
                        .on('mouseover', function(d) {
                            d3.select(this).classed('hover', true);
                        })
                        .on('mouseout', function(d, i) {
                            d3.select(this).classed('hover', false);
                        });
                });
    },

    /**
     * Returns a url to a user record
     * @param {String} id the User record id.
     * @protected
     */
    _buildUserUrl: function(id) {
        return '#' + app.bwc.buildRoute('Employees', id);
    },

    /**
     * Appends the node content to the tree
     * This should be extended by each implementation
     * @param {String} content tree content container.
     * @param {Object} d tree node metadata.
     * @param {Int} w tree node width.
     * @param {Int} h tree node height.
     */
    nodeRenderer: function(content, d, w, h) {
        if (!d.metadata.img || d.metadata.img === '') {
            d.metadata.img = 'include/images/user.svg';
        }
        var node = content.append('g').attr('class', 'nv-org-node');
        node.append('rect').attr('class', 'nv-org-bkgd')
            .attr('x', 0)
            .attr('y', 0)
            .attr('rx', 2)
            .attr('ry', 2)
            .attr('width', w)
            .attr('height', h);
        node.append('image').attr('class', 'nv-org-avatar')
            .attr('xlink:href', d.metadata.img)
            .attr('width', '32px')
            .attr('height', '32px')
            .attr('transform', 'translate(3, 3)');
        node.append('text').attr('class', 'nv-org-name')
            .attr('data-url', d.url)
            .attr('transform', 'translate(38, 11)')
            .text(d.metadata.full_name);
        node.append('text').attr('class', 'nv-org-title')
            .attr('data-url', d.url)
            .attr('transform', 'translate(38, 21)')
            .text(d.metadata.title);
        return node;
    },

    /**
     * Generic method to render chart with check for visibility and data.
     * Called by _renderHtml and loadData.
     */
    renderChart: function() {
        var self = this;
        if (!this.isChartReady()) {
            return;
        }

        if (!this.slider) {
            // chart controls
            this.slider = this.$('.btn-slider .noUiSlider');
            this.sliderZoomIn = this.$('.btn-slider i[data-control="zoom-in"]');
            this.sliderZoomOut = this.$('.btn-slider i[data-control="zoom-out"]');

            //zoom slider
            this.slider.noUiSlider('init', {
                start: 100,
                knobs: 1,
                scale: [this.zoomExtents.min * 100, this.zoomExtents.max * 100],
                connect: false,
                step: 25,
                change: function(moveType) {
                    var values, scale;
                    if (!self.chart_loaded) {
                        return;
                    }

                    if (moveType === 'slide') {
                        values = self.slider.noUiSlider('value');
                        scale = self.chart.zoomLevel(values[0] / 100);
                    } else {
                        scale = self.chart.zoomScale();
                    }
                    self.sliderZoomIn.toggleClass('disabled', (scale === self.zoomExtents.max));
                    self.sliderZoomOut.toggleClass('disabled', (scale === self.zoomExtents.min));
                }
            });
        }
        this.moveSlider();

        if (this.jsTree) {
            this.jsTree.jstree('destroy');
        }

        //jsTree control for selecting root node
        this.jsTree = this.$('div[data-control="org-jstree"]').jstree({
            // generating tree from json data
            'json_data': {
                'data': this.chartCollection
            },
            // plugins used for this tree
            'plugins': ['json_data', 'ui', 'types'],
            'core': {
                'animation': 0
            },
            'ui': {
                // when the tree re-renders, initially select the root node
                'initially_select': ['jstree_node_' + app.user.get('user_name')]
            }
        }).on('loaded.jstree', function(e) {
                // do stuff when tree is loaded
                self.$('div[data-control="org-jstree"]').addClass('jstree-sugar');
                self.$('div[data-control="org-jstree"] > ul').addClass('list');
                self.$('div[data-control="org-jstree"] > ul > li > a').addClass('jstree-clicked');
        }).on('click.jstree', function(e) {
                e.stopPropagation();
                e.preventDefault();
        }).on('select_node.jstree', function(event, data) {
                var jsData = data.inst.get_json();

                self.chart.filter(jQuery.data(data.rslt.obj[0], 'id'));
                self.forceRepaint();
                self.moveSlider();

                self.$('div[data-control="org-jstree-dropdown"] .jstree-label').text(data.inst.get_text());
                data.inst.toggle_node(data.rslt.obj);
        });
        app.accessibility.run(this.jsTree, 'click');

        this.container = d3.select('svg#' + this.cid);

        d3.select('svg#' + this.cid)
            .datum(this.chartCollection[0])
            .transition().duration(500)
            .call(this.chart);

        this.chart.reset();

        this.forceRepaint();

        this.$('.nv-expcoll').on('click', function(e) {
            self.forceRepaint();
            self.moveSlider();
        });

        this.chart_loaded = _.isFunction(this.chart.resize);
        this.displayNoData(!this.chart_loaded);
    },

    /**
     * Forces repaint of images using opacity animation to fix
     * issue with rendering foreignObject in SVG
     */
    forceRepaint: function() {
        this.$('.rep-avatar').on('load', function() {
            $(this).removeClass('loaded').addClass('loaded');
        });

        this.$('img').error(function() {
            $(this).attr('src', 'include/images/user.svg');
        });
    },

    /**
     * Move the slider position
     * Use whenever the tree changes size
     */
    moveSlider: function(scale) {
        var s = scale || 1;
        if (this.slider) {
            this.slider.noUiSlider('move', {to: s * 100});
        }
    },

    /**
     * Override the hasChartData method in Chart plugin because
     * this view does not have a total value.
     */
    hasChartData: function() {
        return !_.isEmpty(this.chartCollection);
    },

    /**
     * Override the chartResize method in Chart plugin because
     * orgchart nvd3 model uses resize instead of update.
     */
    chartResize: function() {
        this.moveSlider();
        this.chart.resize();
    },

    /**
     * Recursively step through the tree and for each node representing a tree node, run the data attribute through
     * the _postProcessTree function.  This function supports n-levels of the tree hierarchy.
     *
     * @param data The data structure returned from the REST API Forecasts/reportees endpoint
     * @return The modified data structure after all the parent and children nodes have been stepped through
     * @private
     */
    _postProcessTree: function(data) {
        var root = [],
            self = this;

        if (_.isArray(data) && data.length == 2) {
            root.push(data[0]);
            root[0].children.push(data[1]);
        } else {
            root.push(data);
        }

        //protect against admin and other valid Employees
        if (_.isEmpty(root[0].metadata.id)) {
            return null;
        }

        _.each(root, function(entry) {
            var adopt = [];

            //Scan for the nodes with the data attribute.  These are the nodes we are interested in
            if (!entry.data) {
                return;
            }

            entry.metadata.url = self._buildUserUrl(entry.metadata.id);

            if (!entry.metadata.picture || entry.metadata.picture === '') {
                entry.metadata.img = 'include/images/user.svg';
            } else {
                entry.metadata.img = app.api.buildFileURL({
                    module: 'Employees',
                    id: entry.metadata.id,
                    field: 'picture'
                });
            }

            if (!entry.children) {
                return;
            }

            //For each children found (if any) then call _postProcessTree again.
            _.each(entry.children, function(childEntry) {
                var newChild;
                if (entry.metadata.id !== childEntry.metadata.id) {
                    newChild = self._postProcessTree(childEntry);
                    if (!_.isEmpty(newChild)) {
                        adopt.push(newChild[0]);
                    }
                }
            }, this);

            entry.children = adopt;

        }, this);

        return root;
    },

    /**
     * Slider control for zooming chart viewport.
     * @param {e} event The event object that is triggered.
     */
    zoomChart: function(e) {
        var button, step, scale;
        if (!this.chart_loaded) {
            return;
        }

        button = $(e.target).data('control');
        step = 0.25 * (button === 'zoom-in' ? 1 : -1);
        scale = this.chart.zoomStep(step);

        this.moveSlider(scale);
    },

    /**
     * Handle all chart manipulation toggles.
     * @param {e} event The event object that is triggered.
     */
    toggleChart: function(e) {
        var button;
        if (!this.chart_loaded) {
            return;
        }

        //if icon clicked get parent button
        button = $(e.currentTarget).hasClass('btn') ? $(e.currentTarget) : $(e.currentTarget).parent('.btn');

        switch (button.data('control')) {
            case 'orientation':
                this.chart.orientation();
                button.find('i').toggleClass('fa-arrow-right fa-arrow-down');
                break;

            case 'show-all-nodes':
                this.chart.showall();
                this.forceRepaint();
                break;

            case 'zoom-to-fit':
                this.chart.resize();
                break;

            default:
        }

        this.moveSlider();
    },

    /**
     * @inheritdoc
     */
    loadData: function(options) {
        var self = this;

        app.api.call('get', this.reporteesEndpoint, null, {
            success: function(data) {
                self.chartCollection = self._postProcessTree(data);
                if (!self.disposed) {
                    self.renderChart();
                }
            },
            complete: options ? options.complete : null
        });
    },

    /**
     * overriding _dispose to make sure custom added event listeners are removed
     * @private
     */
    _dispose: function() {
        if (this.jsTree) {
            this.jsTree.jstree('destroy');
        }
        if (this.slider) {
            this.slider.off('move');
        }
        this._super('_dispose');
    }
})
