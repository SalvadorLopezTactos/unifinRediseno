(function(app) {
    /**
     * @author bdekoning@levementum.com
     * @date 10/29/14
     * @brief Loads all country records into metadata
     */
    app.events.on("app:sync", function () {
        // workaround for not being able to access sidecar's _metadata outside of closure
        // loading countries metadata manually
        var _countries = {};

        var _registerCountryFunctions = function() {
            app.metadata = _.extend(app.metadata, {
                /**
                 * Gets a country
                 *
                 * @param {String} id
                 * @return {Object} country object
                 */
                getCountry: function (id) {
                    return this.getCountries()[id];
                },

                /**
                 * Gets countries.
                 * @return {Object} Country dictionary.
                 */
                getCountries: function () {
                    return _countries.countries || {};
                },

                getState: function(id) {
                    return this.getStates()[id];
                },

                getStates: function() {
                    return _countries.states || {};
                },

                getMunicipality: function(id) {
                    return this.getMunicipalities()[id];
                },

                getMunicipalities: function() {
                    return _countries.municipalities || {};
                },

                getCity: function(id) {
                    return this.getCities()[id];
                },

                getCities: function() {
                    return _countries.cities || {};
                },

                getPostalCode: function(postalcode) {
                    return this.getPostalCodes()[postalcode];
                },

                getPostalCodes: function() {
                    return _countries.postalcodes || {};
                },

                getColonia: function(id) {
                    return this.getColonias()[id];
                },

                getColonias: function() {
                    return _countries.colonias || {};
                },


                /**
                 * List of all countries mapped by id and information based on the
                 * template given.
                 *
                 * Example for the `template` param:
                 * <pre><code>
                 *   getCountriesSelector(Handlebars.compile('{{symbol}} ({{iso}})'));
                 * </code></pre>
                 *
                 * @param {Function}  template how to format the value returned.
                 * @return {Object} countries with id and value (template based).
                 */
                getCountriesSelector: function (template) {
                    var countries = {};

                    _.each(this.getCountries(), function(country, id) {
                        countries[id] = template(country);
                    });
                    return countries;
                },
            });
        };

        // manually read metadata from the system
        var types = ["countries", "states", "municipalities", "cities", "postalcodes", "colonias"];
        var params = {module_filter: "", platform: app.config.platform, type_filter: types.join(",")};
        var url = app.api.buildURL("metadata", "read", null, params);

        app.api.call('read', url, null, {
            success: function(metadata) {
                _countries.countries = metadata.countries;
                _countries.states = metadata.states;
                _countries.municipalities = metadata.municipalities;
                _countries.cities = metadata.cities;
                _countries.postalcodes = metadata.postalcodes;
                _countries.colonias = metadata.colonias;
                _registerCountryFunctions();
            },
            error: function(error) {
                console.log(error);
            }
        });
    });


    /**
     * @author bdekoning@levementum.com
     * @date 11/3/14
     * @brief Adds new plugin for address validation functions
     */
    /**
     * @author bdekoning@levementum.com
     * @date 10/10/14
     * @brief Performs address validation on a fieldset by comparing the postal code
     *        with any matches in the lev_ZipCodes module
     *
     * @param {String} address_fieldset
     */
    /*
    app.events.on("app:init", function() {
        app.plugins.register('AddressValidation', ["view"], {

            validateAddress: function(address_fieldset) {
                if(this.updatingAddress || (this.currentState !== 'edit' && this.currentState !== 'create')) {
                    return;
                }
                this.updatingAddress = true;

                // field names for the address set
                var city_field_name = address_fieldset + '_city',
                    state_field_name = address_fieldset + '_state',
                    zip_field_name = address_fieldset + '_postalcode',
                    country_field_name = address_fieldset + '_country';

                // store the actual field components for highlighting errors, etc
                var city_field = this.getField(city_field_name),
                    state_field = this.getField(state_field_name),
                    zip_field = this.getField(zip_field_name),
                    fieldset = this.getField(address_fieldset);

                // remove any existing error messages
                fieldset.$('span.zip_mismatch').remove();

                // quick and dirty lookup for "Copy Address 1 to Address 2" checkbox state
                var copy_checked = fieldset.$el.find('input[type=checkbox]').prop("checked");

                // don't do anything if we're missing any address fields
                if(copy_checked || !zip_field || !city_field || !state_field || !fieldset) {
                    this.updatingAddress = false;
                    return;
                }

                var zip = this.model.get(zip_field_name),
                    country = this.model.get(country_field_name);

                if(_.isUndefined(zip)) {
                    this.updatingAddress = false;
                    return;
                }

                // strip anything after the first 5 chars on a US zip code
                if(country !== 'USA') {
                    zip = zip.substr(0, 5);
                }

                // fetch from lev_ZipCodes module to compare city + state with the current values
                var searchCollection = app.data.createBeanCollection('lev_ZipCodes');
                searchCollection.fetch({
                    limit: 1,
                    update: true,
                    remove: true,
                    fields: ['name', 'city', 'state'],
                    params: {
                        filter: [
                            {name: zip},
                            {country: country}
                        ]
                    },
                    success: _.bind(function(data) {
                        city_field.$el.removeClass('error');
                        state_field.$el.removeClass('error');

                        var postalData = data.pop();
                        if(!postalData) {
                            this.updatingAddress = false;
                            return;
                        }
                        var current_city = this.model.get(city_field_name),
                            current_state = this.model.get(state_field_name),
                            different = false;

                        // populate the result city/state if they're both blank
                        if(_.isEmpty(current_city)
                            && _.isEmpty(current_state)) {
                            this.model.set(city_field_name, postalData.get('city'));
                            this.model.set(state_field_name, postalData.get('state'));
                        } else {
                            // highlight mismatched fields, show message
                            if(current_city != postalData.get('city')) {
                                city_field.$el.addClass('error');
                                different = true;
                            }

                            if(current_state != postalData.get('state')) {
                                state_field.$el.addClass('error');
                                different = true;
                            }
                        }
                        if(different) {
                            fieldset.$el.append('<span class="zip_mismatch" style="color:red;"><br>The address provided does not match the zip code.</span>');
                        }
                        this.updatingAddress = false;
                    }, this)
                });
            }
        });
    });
    //*/
})(SUGAR.App);