/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Views.Base.MapsManualGeocodingView
 * @alias SUGAR.App.view.views.BaseMapsManualGeocodingView
 * @extends  View.Views.Base.ConfigHeaderButtonsView
*/
({
    extendsFrom: 'ConfigHeaderButtonsView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this._initProperties();

        this._fetchRecordLocationData(_.bind(this._storeLocationDataAndCreateMap, this));
    },

    /**
     * Property initialization, nothing to do for this view
     *
     */
    _initProperties: function() {
        this._rendered = false;
        this._queryOptions = {};
        this._matchedAddresses = [];
        this._geocodeRecord = null;
        this._mapController = null;
    },

    /**
     * Store the record location locally then create the map
     *
     * @param {Data.BeanCollection[]} collection
     */
    _storeLocationDataAndCreateMap: function(collection) {
        const hasGeocodeRecord = collection.length > 0;

        if (hasGeocodeRecord) {
            this._geocodeRecord = collection.models[0];
        } else {
            this._geocodeRecord = app.data.createBean('Geocode');
            this._populateGeocodeFromRecord();
        }

        this._createMap();
    },

    /**
     * Set location data when the record is not geocoded
     */
    _populateGeocodeFromRecord: function() {
        const moduleData = app.config.maps.modulesData[this.module];

        if (!moduleData) {
            return;
        }

        const mappings = moduleData.mappings;
        let address = {};

        _.each(mappings, function createAddress(fieldName, fieldKey) {
            address[fieldKey] = this.model.get(fieldName);
        }, this);

        const location = {
            'parent_id': this.model.get('id'),
            'parent_type': this.module,
            'parent_name': this.model.get('name'),
            'parent_user_name': this.model.get('assigned_user_name'),
        };

        this._geocodeRecord.set(location);
    },

    /**
     * Update UI coords widget element
     */
    _updateWidget: function() {
        this.$('[data-fieldname="longitude"]').val(this._geocodeRecord.get('longitude') || '');
        this.$('[data-fieldname="latitude"]').val(this._geocodeRecord.get('latitude') || '');

        this._select2['search-by-address'].clear();

        if (this._geocodeRecord.get('address')) {
            this._select2['search-by-address'].data({'id': 1, 'text': this._geocodeRecord.get('address')});
        }
    },

    /**
     * Create the map controller
     */
    _createMap: function() {
        if (!this._geocodeRecord || !this._rendered) {
            return;
        }

        this._disposeMap();

        this._updateWidget();

        var fieldContainer = this.$('div[data-container="main-map-container"]');
        fieldContainer.empty();

        this._mapController = app.view.createField({
            def: {
                type: 'bing-map',
                name: 'BingMap'
            },
            view: this,
            viewName: 'main-map-container',
        });

        this._mapController.render();
        this._mapController.createMap();

        this.listenTo(this._mapController, 'map:load:complete', this.onMapReady, this);
        this.listenTo(this._mapController, 'map:map:click', this.onMapClick, this);

        this.$('[data-widget=manual-geocode-loading]').hide();
        fieldContainer.append(this._mapController.$el);
    },

    /**
     * Create map location and the pushpins
     */
    _createLocation: function() {
        this._mapController.clearMap();
        this._mapController.createLocation(this._geocodeRecord.toJSON());
        this._mapController.createPushPins();
        this._mapController.drawPushPins();
    },

    /**
     * Called when Map is loaded
     */
    onMapReady: function() {
        this._createLocation();
        this._mapController.centerMap();
    },

    /**
     * Called when Map is clicked
     *
     * @param {Event} e
     */
    onMapClick: function(e) {
        this._mapController.getAddressFromPoint(
            e.location,
            _.bind(this.updateGeocode, this, e.location),
            _.bind(this.updateGeocodeFailed, this)
        );
    },

    /**
     * Update data related to geocode
     *
     * @param {Object} exactLocation
     * @param {Object} data
     */
    updateGeocode: function(exactLocation, data) {
        this._geocodeRecord.set('latitude', exactLocation.latitude);
        this._geocodeRecord.set('longitude', exactLocation.longitude);
        this._geocodeRecord.set('postalcode', data.address.postalCode);
        this._geocodeRecord.set('address', data.address.formattedAddress);
        this._geocodeRecord.set('country', data.address.countryRegion);

        this._createLocation();
        this._updateWidget();

        const savedButtonFieldController = this.getField('save_button');

        if (savedButtonFieldController) {
            savedButtonFieldController.setDisabled(false);
        }
    },

    /**
     * Callback for invalid location
     *
     * @param {Object} location
     */
    updateGeocodeFailed: function(location) {
        app.alert.show('invalid-location', {
            level: 'warning',
            messages: 'EXCEPTION_REQUEST_FAILURE',
            autoClose: true,
            autoCloseDelay: 3000
        });
    },

    /**
     * Get current record location
     *
     * @param {Function} successCallback
     */
    _fetchRecordLocationData: function(successCallback) {
        const geocodeCollection = app.data.createBeanCollection('Geocode');

        geocodeCollection.filterDef = {
            '$and': [{
                'parent_type': this.model.module,
            }, {
                'parent_id': this.model.get('id'),
            }]
        };

        geocodeCollection.fetch({
            success: successCallback
        });
    },

    /**
     * Create generic Select2 options object
     *
     * @return {Object}
     */
    _getSelect2Options: function(additionalOptions) {
        var select2Options = {};

        select2Options.placeholder = app.lang.get('LBL_MAP_SEARCH_BY_ADDRESS');
        select2Options.dropdownAutoWidth = true;

        select2Options = _.extend({}, additionalOptions);

        return select2Options;
    },

    /**
     * Create generic Select2 component or return a cached select2 element
     *
     * @param {string} fieldname
     * @param {Function} callback
     */
    select2: function(fieldname, callback) {
        const delay = 500;

        if (this._select2 && this._select2[fieldname]) {
            return this._select2[fieldname];
        };

        this._disposeSelect2();

        let additionalOptions = {};

        additionalOptions.query = _.debounce(_.bind(this._queryAddresses, this), delay);

        var el = this.$('[data-action=' + fieldname + ']')
            .select2(this._getSelect2Options(additionalOptions))
            .data('select2');

        this._select2 = this._select2 || {};
        this._select2[fieldname] = el;

        el.onSelect = (function select(fn) {
            return function returnCallback(data, options) {
                if (callback) {
                    callback(data);
                }

                return fn.apply(this, arguments);
            };
        })(el.onSelect);

        return el;
    },

    /**
     * Select2 selection list builder
     *
     * @param {Object} options
     *
     */
    _queryAddresses: function(options) {
        this._queryOptions = options;

        const queryTerm = options.term;

        this._mapController.searchByAddress(
            queryTerm,
            _.bind(this._queryAddressesSuccess, this),
            _.bind(this._queryAddressesError, this)
        );
    },

    /**
     * Populate select2 list and store matched addresses
     *
     * @param {Object} geocodeResult
     */
    _queryAddressesSuccess: function(geocodeResult) {
        if (this._queryOptions) {
            let results = _.map(geocodeResult.results, function getAddress(result, key) {
                return {
                    id: key,
                    text: result.address.formattedAddress
                };
            });

            this._queryOptions.callback({
                results,
                more: false,
            });

            this._queryOptions = null;
            this._matchedAddresses = geocodeResult.results;
        }
    },

    /**
     * Clear addresses for invalid input
     *
     * @param {Object} geocodeRequest
     */
    _queryAddressesError: function(geocodeRequest) {
        if (this._queryOptions) {
            this._queryOptions.callback({
                results: [],
                more: false,
            });

            this._queryOptions = null;
            this._matchedAddresses = [];
        }
    },

    /**
     * The new selected location on the map
     *
     * @param {Object} data
     */
    _onAddressSelected: function(data) {
        const {id} = data;

        const address = this._matchedAddresses[id];
        const {latitude, longitude} = address.location;

        this._geocodeRecord.set('latitude', latitude);
        this._geocodeRecord.set('longitude', longitude);
        this._geocodeRecord.set('postalcode', address.address.postalCode);
        this._geocodeRecord.set('address', address.address.formattedAddress);

        const {width, height} = address.bestView;

        this._createLocation();
        this._mapController.centerMap({width, height});
        this._updateWidget();

        const savedButtonFieldController = this.getField('save_button');

        if (savedButtonFieldController) {
            savedButtonFieldController.setDisabled(false);
        }
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super('_render');

        this._rendered = true;
        this._select2 = null;

        const savedButtonFieldController = this.getField('save_button');

        if (savedButtonFieldController) {
            savedButtonFieldController.setDisabled(true);
        }

        this.select2('search-by-address', _.bind(this._onAddressSelected, this));

        this._createMap();
    },

    /**
     * @inheritdoc
     */
    _saveConfig: function() {
        if (this._geocodeRecord.get('geocoded')) {
            app.alert.show('alert-already-geocoded', {
                level: 'confirmation',
                messages: app.lang.get('LBL_MAP_ALREADY_GEOCODED'),
                autoClose: false,
                onConfirm: _.bind(function overwriteGeocoding() {
                    this._saveAndCloseDrawer();
                }, this),
            });
        } else {
            this._saveAndCloseDrawer();
        }
    },

    /**
     * Save the new geocoding and close the current drawer
     */
    _saveAndCloseDrawer: function() {
        this._geocodeRecord.set({
            'status': 'COMPLETED',
            'geocoded': true,
        });

        this._geocodeRecord.save({}, {showAlerts: true});
        this.cancelConfig();
    },

    /**
     * Dispose map element
     */
    _disposeMap: function() {
        if (this._mapController) {
            this._mapController.dispose();
            this._mapController = null;
        }
    },

    /**
     * Dispose select2 elements
     */
    _disposeSelect2: function() {
        this.$('[data-action=search-by-address]').select2('destroy');
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this._disposeSelect2();
        this._disposeMap();
        this._super('_dispose');
    },
});
