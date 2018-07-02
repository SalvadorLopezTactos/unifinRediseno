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

(function (app) {
    app.events.on("app:init", function () {
        app.plugins.register('EmailClientLaunch', ['view', 'field'], {

            events: {
                'click a[data-action="email"]': 'launchEmailClient'
            },

            /**
             * If Sugar Email Client used, launch email compose drawer
             *
             * @param event
             */
            launchEmailClient: function(event) {
                var $link = $(event.currentTarget);

                if (this.useSugarEmailClient()) {
                    this.launchSugarEmailClient(this._retrieveEmailOptions($link));
                }
            },

            /**
             * Open the email compose drawer, prepopulated with given options
             *
             * @param {Object} [options]
             */
            launchSugarEmailClient: function(options) {
                //clean the recipient fields before handing off to email compose
                _.each(['to_addresses', 'cc_addresses', 'bcc_addresses'], function(recipientType) {
                    if (options[recipientType]) {
                        options[recipientType] = this._retrieveValidRecipients(options[recipientType]);
                    }
                }, this);

                app.drawer.open({
                    layout : 'compose',
                    context: {
                        create: 'true',
                        module: 'Emails',
                        prepopulate: options
                    }
                }, _.bind(function(model) {
                    if (model) {
                        //allow for component to perform action after close
                        this.trigger('emailclient:close');
                    }
                }, this));
            },

            /**
             * Return recipient list for email compose drawer
             * Strips out any recipients that don't have an email address
             * Picks out primary or first valid address if only bean is specified
             *
             * @param recipients
             * @returns {Array}
             * @private
             */
            _retrieveValidRecipients: function(recipients) {
                var validRecipients = [],
                    email;

                recipients = _.isArray(recipients) ? recipients : [recipients];
                _.each(recipients, function(recipient) {
                    if (recipient.bean && _.isUndefined(recipient.email)) {
                        //attempt to pull primary (if valid) or first valid email on bean
                        email = this._retrieveEmailAddressFromModel(recipient.bean);

                        //only push the recipient if the bean has a valid email to send to
                        if (email) {
                            validRecipients.push(_.extend({email: email}, recipient));
                        }
                    } else {
                        validRecipients.push(recipient);
                    }
                }, this);

                return validRecipients;
            },

            /**
             * Has the user opted to use the Sugar Email Client
             *
             * @returns {boolean}
             */
            useSugarEmailClient: function() {
                var emailClientPreference = app.user.getPreference('email_client_preference');

                return (emailClientPreference && emailClientPreference.type === 'sugar' && app.acl.hasAccess('edit', 'Emails'));
            },

            /**
             * Extends existing email options, adding the specified ones
             * Also clones the related model passed so we don't modify the original
             *
             * @param options
             */
            addEmailOptions: function(options) {
                this.emailOptions = this.emailOptions || {};
                options = options || {};

                if (options.related) {
                    options.related = this._cloneRelatedModel(options.related);
                }

                this.emailOptions = _.extend({}, this.emailOptions, options);
            },

            /**
             * Returns a copy of the related model for adding to email options
             *
             * @param model
             */
            _cloneRelatedModel: function(model) {
                var relatedModel;

                if (model && model.module) {
                    relatedModel = app.data.createBean(model.module);
                    relatedModel.set(app.utils.deepCopy(model.attributes));
                }

                return relatedModel;
            },

            /**
             * Get appropriate href value based on the email client
             *
             * @param options
             * @returns {String}
             * @private
             */
            _getEmailHref: function(options) {
                if (this.useSugarEmailClient()) {
                    return 'javascript:void(0)';
                } else {
                    return this._buildMailToURL(options);
                }
            },

            /**
             * Build a mailto: url using the given options
             *
             * @param {Object} [options] Optional email field values to pass to the email client
             *   Accepted attributes: to_addresses (array), cc_addresses (array), bcc_addresses (array), subject, html_body
             */
            _buildMailToURL: function(options) {
                var mailToUrl = 'mailto:',
                    formattedOptions = {},
                    queryParams = [];

                if (options.to_addresses) {
                    mailToUrl += this._formatRecipientsToString(options.to_addresses);
                }

                formattedOptions.cc = this._formatRecipientsToString(options.cc_addresses);
                formattedOptions.bcc = this._formatRecipientsToString(options.bcc_addresses);
                formattedOptions.subject = options.subject;
                formattedOptions.body = options.text_body;

                _.each(['cc', 'bcc', 'subject', 'body'], function(option) {
                    var param;
                    if (!_.isEmpty(formattedOptions[option])) {
                        param = option + '=' + encodeURIComponent(formattedOptions[option]);
                        queryParams.push(param);
                    }
                });

                if (!_.isEmpty(queryParams)) {
                    mailToUrl = mailToUrl + '?' + queryParams.join('&');
                }

                return mailToUrl;
            },

            /**
             * Turns a single recipient or list of recipients
             * into a comma separated list of recipient email addresses
             * Useful for producing string for mailto: recipients
             *
             * @param {string|Array} recipients
             * @returns {string}
             * @private
             */
            _formatRecipientsToString: function(recipients) {
                var emailDelim = ',',
                    emails = [],
                    email;

                if (_.isArray(recipients)) {
                    _.each(recipients, function(recipient) {
                        //recipient could just be a string
                        if (_.isString(recipient)) {
                            emails.push(recipient);

                        //recipient could be an object with email attribute
                        } else if (recipient.email) {
                            emails.push(recipient.email);

                        //recipient could be an object with bean that may contain an email address
                        } else if (recipient.bean) {
                            //attempt to pull primary (if valid) or first valid email on bean
                            email = this._retrieveEmailAddressFromModel(recipient.bean);
                            if (email) {
                                emails.push(email);
                            }
                        }
                    }, this);
                } else {
                    emails.push(recipients);
                }

                return emails.join(emailDelim);
            },

            /**
             * Pick an email address off the model
             * Will attempt to grab the primary first
             * Will grab first valid email address in the list if primary is opt-out or invalid
             *
             * @param model
             * @returns {string}
             * @private
             */
            _retrieveEmailAddressFromModel: function(model) {
                var emails = model.get('email');
                if (_.isUndefined(emails)) {
                    // need to include fallback, since in a 6.7 where a module is modified using Studio, we have 'email1' in custom files
                    return model.get('email1');
                }
                var email,
                    isValidEmail = function(email) {
                        return (!_.isUndefined(email) &&
                            !_.isEmpty(email.email_address) &&
                            email.opt_out !== true &&
                            email.invalid_email !== true);
                    },
                    isValidPrimaryEmail = function(email) {
                        return isValidEmail(email) && email.primary_address;
                    };

                email = _.find(emails, isValidPrimaryEmail) || _.find(emails, isValidEmail) || {};
                return email.email_address;
            },

            /**
             * Build email options object
             * Use options on controller as a base and lay link specific options on top
             *
             * @param $link jQuery selected link element
             * @returns {Object}
             * @private
             */
            _retrieveEmailOptions: function($link) {
                var optionsFromLink = $link.data() || {},
                    optionsFromController = this.emailOptions || {};

                // allow the component implementing this plugin to override optionsFromLink
                // allows us to pass more complex data like models, which are not easily
                // passed via data- attributes.
                if (_.isFunction(this._retrieveEmailOptionsFromLink)) {
                    optionsFromLink = this._retrieveEmailOptionsFromLink($link);
                }

                return _.extend({}, optionsFromController, optionsFromLink);
            },

            /**
             * @inheritdoc
             * On render, modify the href appropriately for the correct email client
             */
            onAttach: function () {
                this.on('render', function() {
                    var self = this,
                        $emailLinks = this.$('a[data-action="email"]');

                    $emailLinks.each(function() {
                        var options = self._retrieveEmailOptions($(this)),
                            href = self._getEmailHref(options);
                        $(this).attr('href', href);
                    });
                }, this);
            }
        });
    });
})(SUGAR.App);
