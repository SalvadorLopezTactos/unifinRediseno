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
 * @class View.Views.Base.DnbNewAndMediaView
 * @alias SUGAR.App.view.views.BaseDnbNewsAndMediaView
 * @extends View.Views.Base.DnbView
 */
({
    extendsFrom: 'DnbView',

    events: {
        'click .showMoreData' : 'showMoreData',
        'click .showLessData' : 'showLessData',
        'change #fb' : 'selectSocialMedia',
        'change #youtube' : 'selectSocialMedia',
        'change #twitter' : 'selectSocialMedia'
    },

    //JSON paths for news
    newsConst: {
        'newsPath' : 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.News.NewsDetails',
        'socialPath' : 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.Telecommunication.SocialMediaDetail',
        'socialMediaNamePath' : 'SocialMediaPlatformName.$',
        'fburl' : 'https://www.facebook.com/',
        'twitterurl' : 'https://twitter.com/',
        'youtubeurl' : 'http://www.youtube.com/'
    },

    //social media meta data map
    //code represent the DNB Code value
    //url is the base url for the social media
    //label is the label for the social media
    //list is the list of user keys for the social media
    socialMediaMeta: {
        'youtube' : {
            'code' : 25866,
            'url' : 'http://www.youtube.com/',
            'label' : 'LBL_DNB_NEWS_YOUTUBE',
            'list' : null
        },
        'twitter' : {
            'code' : 25867,
            'url' : 'https://twitter.com/',
            'label' : 'LBL_DNB_NEWS_TWITTER',
            'list' : null
        },
        'wiki' : {
            'code' : 25868,
            'url' : 'http://www.youtube.com/',
            'label' : 'LBL_DNB_NEWS_WIKI',
            'list' : null
        },
        'fb' : {
            'code' : 25869,
            'url' : 'https://www.facebook.com/',
            'label' : 'LBL_DNB_NEWS_FACEBOOK',
            'list' : null
        }
    },

    //social media data dictionary
    socialMediaDD: {
        'mediaName': {
            'json_path': 'SocialMediaPlatformName.$'
        },
        'contentKey': {
            'json_path': 'UserContentKey'
        },
        'displayName': {
            'json_path': 'UserDisplayName'
        }
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        if (this.layout.collapse) {
            this.layout.collapse(true);
        }
        this.layout.on('dashlet:collapse', this.loadNews, this);
        app.events.on('dnbcompinfo:duns_selected', this.collapseDashlet, this);
        //listen on expand all button click on the dashboard
        this.layout.layout.context.on('dashboard:collapse:fire', this.loadNews, this);
    },

    loadData: function(options) {
       if (this.model.get('duns_num')) {
            this.duns_num = this.model.get('duns_num');
       }

    },

    _render: function() {
        app.view.View.prototype._renderHtml.call(this);
        //applying the select 2 plugins to all the social media data
        _.each(this.socialMediaMeta, function(value, key) {
            if (value.list && value.list.length > 0) {
                var listSelector = '#' + key;
                this.$(listSelector).select2({
                    placeholder: app.lang.get(value.label),
                    data: value.list,
                    containerCss: {'width': '100%'}
                });
            }
        }, this);
    },

    /**
     * Refresh dashlet once Refresh link clicked from gear button
     * To show updated new and media information from DNB service
     */
    refreshClicked: function() {
        this.loadNews(false);
    },

    /**
     * Handles the dashlet expand | collapse events
     * @param  {Boolean} isCollapsed
     */
    loadNews: function(isCollapsed) {
        if (!isCollapsed) {
            //check if account is linked with a D-U-N-S
            this.loadDNBData('duns_num', 'dnb_temp_duns_num', this.getNewsandMediaInfo, null, 'dnb.dnb-no-duns', 'dnb.dnb-no-duns-field');
        }
    },

    /**
     * Handles the change event when a social media drop down is selected
     * based on the link selected, user is redirected to the social media page
     * @param {Object} event
     */
    selectSocialMedia: function(event) {
        var selectedMedia = event.target.id;
        if (selectedMedia) {
            var baseUrl = this.socialMediaMeta[selectedMedia].url;
            var selector = '#' + selectedMedia;
            var contentKey = this.$(selector).val();
            window.open(baseUrl + contentKey);
            //clearing the selection value
            //so that a user can be redirected when clicking mulitple times
            this.$(selector).val('');
        }
    },

    /**
     * Invokes D&B News and Social Media API
     * @param {String} duns_num
     */
    getNewsandMediaInfo: function(duns_num) {
        var self = this;
        self.template = app.template.get(self.name);
        if (!self.disposed) {
            self.render();
        }
        self.$('div#dnb-news-detail-loading').show();
        self.$('div#dnb-news-detail').hide();
        if (duns_num && duns_num !== '') {
            var dnbNewInfoURL = app.api.buildURL('connector/dnb/news/' + duns_num, '', {},{});
            var resultData = {'product': null, 'errmsg': null};
            app.api.call('READ', dnbNewInfoURL, {}, {
                success: function(data) {
                    var responseCode = self.getJsonNode(data, self.appendSVCPaths.responseCode),
                        responseMsg = self.getJsonNode(data, self.appendSVCPaths.responseMsg);
                    if (responseCode && responseCode === self.responseCodes.success) {
                        var newsData = self.getJsonNode(data, self.newsConst.newsPath),
                            socialData = self.getJsonNode(data, self.newsConst.socialPath);
                        if (newsData || socialData) {
                            resultData.news = {}, resultData.social = {};
                            if (newsData) {
                                resultData.news.product = newsData;
                            }
                            if (socialData) {
                                resultData.social.product = socialData;
                            }
                        } else {
                            resultData.errmsg = app.lang.get('LBL_DNB_NO_DATA');
                        }
                    } else {
                        resultData.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                    }
                    self.renderNewsAndSocial(resultData);
                },
                error: _.bind(self.checkAndProcessError, self)
            });
        }
    },

    /**
     * Renders D&B News and Social Media API
     * @param {Object} dnbApiResponse
     */
    renderNewsAndSocial: function(dnbApiResponse) {
        if (this.disposed) {
            return;
        }
        var dnbNews = {};
        if (dnbApiResponse.news || dnbApiResponse.social) {
            dnbNews.news = {},dnbNews.social = {};
            if (dnbApiResponse.news.product) {
                dnbNews.news.product = dnbApiResponse.news.product;
            } else {
                dnbNews.news.errmsg = app.lang.get('LBL_DNB_NO_DATA');
            }
            if (dnbApiResponse.social.product) {
                dnbNews.social.product = this.formatSocial(dnbApiResponse.social.product, this.socialMediaDD);
            } else {
                dnbNews.social.errmsg = app.lang.get('LBL_DNB_NO_DATA');
            }
        }
        if (dnbApiResponse.errmsg) {
            dnbNews.errmsg = dnbApiResponse.errmsg;
        }
        this.dnbNews = dnbNews;
        this.render();
        this.$('div#dnb-news-detail-loading').hide();
        this.$('div#dnb-news-detail').show();
        this.$('.showLessData').hide();
    },

    /**
     * Format Social Media Response
     * @param {Object} dnbApiResponse
     * @param {Object} socialDD
     * @return {Object} formattedSocialData
     */
    formatSocial: function(dnbApiResponse, socialDD) {
        //grouping social media by DNB Code values
        //socialMedia variable will be a map
        //whose keys will be DNB Code values
        //whose values will be social media information in an array
        var socialMedia = _.groupBy(dnbApiResponse, function(socialObj) {
            return socialObj.SocialMediaPlatformName['@DNBCodeValue'];
        });
        var formattedSocialData = [];
        //iterate through each social media meta data map
        _.each(this.socialMediaMeta, function(socialMetaValue, socialMetaKey) {
            if (socialMedia[socialMetaValue.code]) {
                formattedSocialData.push({'label': socialMetaValue.label, 'mediaId': socialMetaKey});
                socialMetaValue.list = [];
                //iterate through every social media array
                //extract the necessary information
                _.each(socialMedia[socialMetaValue.code], function(socialMediaDetails) {
                    var contentKey = this.getJsonNode(socialMediaDetails, this.socialMediaDD.contentKey.json_path),
                        displayName = this.getJsonNode(socialMediaDetails, this.socialMediaDD.displayName.json_path);
                    var dropDownData = null;
                        dropDownData = {
                            id: contentKey,
                            text: displayName || contentKey
                        };
                    socialMetaValue.list.push(dropDownData);
                }, this);
            }
        }, this);
        return formattedSocialData;
    }
});
