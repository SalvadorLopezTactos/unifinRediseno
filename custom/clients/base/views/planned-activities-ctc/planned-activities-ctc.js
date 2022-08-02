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
 * @inheritdoc
 *
 * Planned Activities dashlet takes advantage of the tabbed dashlet abstraction
 * by using its metadata driven capabilities to configure its tabs in order to
 * display planned activities of specific modules.
 *
 * Besides the metadata properties inherited from Tabbed dashlet, Planned Activities
 * dashlet also supports other properties:
 *
 * - {Array} invitation_actions field def for the invitation actions buttonset
 *           triggers showing invitation actions buttons and corresponding collection
 *
 * - {Array} overdue_badge field def to support overdue calculation, and showing
 *   an overdue badge when appropriate.
 *
 * @class View.Views.Base.PlannedActivitiesView
 * @alias SUGAR.App.view.views.BasePlannedActivitiesView
 * @extends View.Views.Base.HistoryView
 */
({
    extendsFrom: 'HistoryView',

    /**
     * Besides defining new DOM events that will be later bound to methods
     * through {@link #delegateEvents, the events method also makes sure parent
     * classes events are explicitly inherited.
     *
     * @property {Function}
     */
    events: function() {
        
        var prototype = Object.getPrototypeOf(this);
        var parentEvents = _.result(prototype, 'events');
        
        return _.extend({}, parentEvents, {
            'click [data-action=date-switcher]': 'dateSwitcher',
            'click  .mcall': 'makecall',
        });
        
    },

    /**
     * @inheritdoc
     *
     * @property {Object} _defaultSettings
     * @property {String} _defaultSettings.date Date against which retrieved
     *   records will be filtered, supported values are 'today' and 'future',
     *   defaults to 'today'.
     * @property {Number} _defaultSettings.limit Maximum number of records to
     *   load per request, defaults to '10'.
     * @property {String} _defaultSettings.visibility Records visibility
     *   regarding current user, supported values are 'user' and 'group',
     *   defaults to 'user'.
     */
    _defaultSettings: {
        date: 'today',
        limit: 10,
        visibility: 'user'
    },

    /**
     * @inheritdoc
     */
    llamada:false,
    dataext:[],

    initialize: function(options) {
        this.plugins = _.union(this.plugins, [
            'LinkedModel'
        ]);
        self = this;
        this._super('initialize', [options]);
    },

    /**
     * @inheritdoc
     *
     * Store current date state in settings.
     */
    initDashlet: function() {
        this._super('initDashlet');
        if (!this.meta.last_state) {
            this.meta.last_state = {
                id: this.dashModel.get('id') + ':' + this.name,
                defaults: {}
            };
        }
        if (this.meta.config) {
            this.layout.before('dashletconfig:save', function() {
                this._saveSetting('date', this.settings.get('date'));
            }, this);
        } else {
            this.settings.on('change:date', function(model, value) {
                this._saveSetting('date', value);
            }, this);
        }

        this.settings.set('date', this.getDate());
        this.tbodyTag = 'ul[data-action="pagination-body"]';
    },

    /**
     * @inheritdoc
     *
     * Once new records are received, prevent rendering new rows until we fetch
     * the invitation collection by calling {@link #updateInvitation}.
     */
    _initEvents: function() {
        this._super('_initEvents');
        this.on('planned-activities:close-record:fire', this.heldActivity, this);
        this.on('linked-model:create', this.loadData, this);

        this.before('render:rows', function(data) {
            this.updateInvitation(this.collection, data);
            return false;
        }, this);

        return this;
    },

    /**
     * Update the invitation collection.
     *
     * @param {BeanCollection} collection Active tab's collection.
     * @param {Array} data Added recordset's data.
     */
    updateInvitation: function(collection, data) {
        var tab = this.tabs[this.settings.get('activeTab')];
        if (!data.length || !tab.invitations) {
            return;
        }
        this._fetchInvitationActions(tab, _.pluck(data, 'id'));
    },

    /**
     * Completes the selected activity.
     *
     * Shows a confirmation alert and sets the activity as `Held` on confirm.
     * Also updates the collection and re-renders the dashlet to remove it from
     * the view.
     *
     * @param {Data.Bean} model Call/Meeting model to be marked as `Held`.
     */
    heldActivity: function(model) {
        var self = this;
        var name = Handlebars.Utils.escapeExpression(app.utils.getRecordName(model)).trim();
        var context = app.lang.getModuleName(model.module).toLowerCase() + ' ' + name;
        app.alert.show('close_activity_confirmation:' + model.get('id'), {
            level: 'confirmation',
            messages: app.utils.formatString(app.lang.get('LBL_PLANNED_ACTIVITIES_DASHLET_CONFIRM_CLOSE'), [context]),
            onConfirm: function() {
                model.save({status: 'Held'}, {
                    showAlerts: true,
                    success: self._getRemoveModelCompleteCallback()
                });
            }
        });
    },

    /**
     * Create new record.
     *
     * @param {Event} event Click event.
     * @param {Object} params
     * @param {string} params.module Module name.
     * @param {string} params.link Relationship link.
     */
    createRecord: function(event, params) {
        // FIXME: At the moment there are modules marked as bwc enabled though
        // they have sidecar support already, so they're treated as exceptions
        // and drawers are used instead.
        var self = this,
            bwcExceptions = ['Emails'],
            meta = app.metadata.getModule(params.module) || {};

        if (meta.isBwcEnabled && !_.contains(bwcExceptions, params.module)) {
            this._createBwcRecord(params.module, params.link);
            return;
        }

        if (this.module !== 'Home') {
            this.createRelatedRecord(params.module, params.link);
        } else {
            app.drawer.open({
                layout: 'create',
                context: {
                    create: true,
                    module: params.module
                }
            }, function(context, model) {
                if (!model) {
                    return;
                }
                self.context.resetLoadFlag();
                self.context.set('skipFetch', false);
                if (_.isFunction(self.loadData)) {
                    self.loadData();
                } else {
                    self.context.loadData();
                }
            });
        }
    },

    /**
     * Create new record.
     *
     * If we're on Homepage an orphan record is created, otherwise, the link
     * parameter is used and the new record is associated with the record
     * currently being viewed.
     *
     * @param {string} module Module name.
     * @param {string} link Relationship link.
     * @protected
     */
    _createBwcRecord: function(module, link) {
        if (this.module !== 'Home') {
            app.bwc.createRelatedRecord(module, this.model, link);
            return;
        }

        var params = {
            return_module: this.module,
            return_id: this.model.id
        };

        var route = app.bwc.buildRoute(module, null, 'EditView', params);

        app.router.navigate(route, {trigger: true});
    },

    /**
     * @inheritdoc
     * @protected
     */
    _initTabs: function() {
        this._super('_initTabs');

        _.each(this.tabs, function(tab) {
            if (!tab.invitation_actions) {
                return;
            }
            tab.invitations = this._createInvitationsCollection(tab);
        }, this);

        return this;
    },

    /**
     * Create invites collection to set the accept status on the given link.
     *
     * @param {Object} tab Tab properties.
     * @return {Data.BeanCollection} A new instance of bean collection.
     * @protected
     */
    _createInvitationsCollection: function(tab) {
        return app.data.createBeanCollection(tab.module, null, {
            link: {
                name: tab.module.toLowerCase(),
                bean: app.data.createBean('Users', {
                    id: app.user.get('id')
                })
            }
        });
    },

    /**
     * @inheritdoc
     */
    _getRecordsTemplate: function(module) {
        this._recordsTpl = this._recordsTpl || {};

        if (!this._recordsTpl[module]) {
            this._recordsTpl[module] = app.template.getView(this.name + '.records', module) ||
                app.template.getView(this.name + '.records', this.module) ||
                app.template.getView(this.name + '.records') ||
                app.template.getView('history.records', this.module) ||
                app.template.getView('history.records') ||
                app.template.getView('tabbed-dashlet.records', this.module) ||
                app.template.getView('tabbed-dashlet.records');
        }

        return this._recordsTpl[module];
    },

    /**
     * @inheritdoc
     */
    _getFilters: function(index) {

        var today = app.date().formatServer(true);
        var tab = this.tabs[index];
        var filter = {};
        var filters = [];
        var defaultFilters = {
                today: {$lte: today},
                future: {$gt: today}
            };

        filter[tab.filter_applied_to] = defaultFilters[this.getDate()];

        filters.push(filter);

        return filters;
    },

    /**
     * @inheritdoc
     */
    tabSwitcher: function(event) {
        var tab = this.tabs[this.settings.get('activeTab')];
        if (tab.invitations) {
            tab.invitations.dataFetched = false;
        }

        this._super('tabSwitcher', [event]);
    },

    /**
     * @inheritdoc
     *
     * Additional logic on switch visibility event.
     */
    visibilitySwitcher: function() {
        var activeVisibility;
        if (!this.isManager) {
            return;
        }
        activeVisibility = this.getVisibility();
        this.$el.find('[data-action=visibility-switcher]')
            .attr('aria-pressed', function() {
                return $(this).val() === activeVisibility;
            });
    },

    /**
     * Event handler for date switcher.
     *
     * @param {Event} event Click event.
     */
    dateSwitcher: function(event) {
        var date = this.$(event.currentTarget).val();
        if (date === this.getDate()) {
            return;
        }

        this.settings.set('date', date);
        this.loadData();
    },

    /**
     * Saves a setting to local storage.
     *
     * @param {string} setting The setting name.
     * @param {string} value The value to save.
     * @private
     */
    _saveSetting: function(setting, value) {
        var key = app.user.lastState.key(setting, this);
        app.user.lastState.set(key, value);
    },

    /**
     * Get current date state.
     * Returns default value if can't find in last state or settings.
     *
     * @return {string} Date state.
     */
    getDate: function() {
        var date = app.user.lastState.get(
            app.user.lastState.key('date', this),
            this
        );
        return date || this.settings.get('date') || this._defaultSettings.date;
    },

    /**
     * @inheritdoc
     *
     * On load of new data, make sure we reload invitations related data, if
     * it is defined for the current tab.
     */
    loadDataForTabs: function(tabs, options) {
        _.each(tabs, function(tab) {
            if (tab.invitations) {
                tab.invitations.dataFetched = false;
            }
        }, this);

        this._super('loadDataForTabs', [tabs, options]);
    },

    /**
     * Fetch the invitation actions collection for
     * showing the invitation actions buttons
     * @param {Object} tab Tab properties.
     * @param {Array|*} addedIds New added record ids.
     * @private
     */
    _fetchInvitationActions: function(tab, addedIds) {
        this.invitationActions = tab.invitation_actions;
        tab.invitations.filterDef = {
            'id': {'$in': addedIds || this.collection.pluck('id')}
        };
        //self.llamada= false;
        tab.invitations.fetch({
            relate: true,
            success: _.bind(function(collection) {
                if (this.disposed) {
                    return;
                }
                aux=[];
                _.each(collection.models, function(invitation) {
                    var model = this.collection.get(invitation.get('id'));
                    model.set('invitation', invitation);
                    if(invitation.link.name== 'calls'){
                        self.llamada= true;
                        model['attributes']['llamada'] = true;
                        model.set('llamada', true);
                        aux.push(model);
                    }
                }, this);

                if(self.llamada==true){
                    collection.models = aux;
                }
                /*mm = [];
                if(self.llamada==true){
                    _.each(collection.models, function (value, key) {
                        mm = collection.models[key];
                        //mm['id'] = datam['attributes']['id'];
                        //mm['reus'] = true;
                        mm['attributes']['llamada'] = true;
                        //model.set('reus', true);
                        aux.push(mm);
                    });
                    collection.models = aux;
                }*/
                if (!_.isEmpty(addedIds)) {
                    _.each(addedIds, function(id) {
                        var model = this.collection.get(id);
                        this._renderRow(model);
                        this._renderAvatars();
                    }, this);
                    return;
                }
                this.render();
                this._renderAvatars();
            }, this),
            complete: function() {
                tab.invitations.dataFetched = true;
            }
        });
    },

    /**
     * @inheritdoc
     *
     * New model related properties are injected into each model:
     *
     * - {Boolean} overdue True if record is prior to now.
     * - {Bean} invitation The invitation bean that relates the data with the
     *   Users' invitation statuses. This is the model supplied to the
     *   `invitation-actions` field.
     */
    _renderHtml: function() {
        if (this.meta.config) {
            this._super('_renderHtml');
            return;
        }

        var tab = this.tabs[this.settings.get('activeTab')];

        if (tab.overdue_badge) {
            this.overdueBadge = tab.overdue_badge;
        }

        if (!this.collection.length || !tab.invitations ||
            tab.invitations.dataFetched) {
            this._super('_renderHtml');
            return;
        }

        this._fetchInvitationActions(tab);
    },

    makecall: function (evt) {
        if (!evt) return;

        var idcall = evt.currentTarget.id;
        var $input = this.$(evt.currentTarget);
        var tel_usr = app.user.attributes.ext_c;
        var puesto_usuario = App.user.attributes.puestousuario_c;
        var idUsuarioLogeado = App.user.attributes.id;
        var arrayPuestosComerciales = [];
        var reus = false;
        var tel_client = "";
        
        var consulta = app.api.buildURL('GetTelefonoVal/' + idcall, null, null);
        app.api.call('read', consulta, {}, {
            success: _.bind(function (data) {
                console.log(data);
                if(data['status'] == '300'){
                    app.alert.show('error_tel_client', {
                        level: 'error',
                        autoClose: true,
                        messages: '<b>No tiene Lead o Cuenta relacionada</b>.'
                    });
                }else{
                    //TELEFONOS QUE SOLO SON REUS
                    if(data['tel'] == '0'){
                        reus = true;
                    }else{
                        tel_client = data['tel'];
                        name_client = data['nombre']; 
                    }

                    if (!reus) {
                    //Valida Teléfono y Extensión
                        if (tel_usr != '' && tel_usr != null) {
                            if (tel_client != '' && tel_client != null) {
                            context = this;
                            app.alert.show('do-call', {
                                level: 'confirmation',
                                messages: '¿Realmente quieres realizar la llamada? <br><br><b>NOTA: La marcaci\u00F3n se realizar\u00E1 tal cual el n\u00FAmero est\u00E1 registrado</b>',
                                autoClose: false,
                                onConfirm: function () {
                                //context.createcall(context.resultCallback);
                                context.createcall(tel_client,idcall,name_client);
                                },
                            });
                            } else {
                            app.alert.show('error_tel_client', {
                                level: 'error',
                                autoClose: true,
                                messages: 'El cliente al que quieres llamar no tiene <b>N\u00FAmero telefónico</b>.'
                            });
                            }
                        } else {
                            app.alert.show('error_tel_usr', {
                            level: 'error',
                            autoClose: true,
                            messages: 'El usuario con el que estas logueado no tiene <b>Extensi\u00F3n</b>.'
                            });
                        }
                    } else {
                        app.alert.show('message-reus-comercial', {
                            level: 'error',
                            messages: 'No se puede generar llamada a teléfono registrado en REUS',
                            autoClose: false
                        });
                    }
                }
            }, this)
        });
    },

    createcallGen: function (tel_client) {
      
      var posiciones = App.user.attributes.posicion_operativa_c;
      var posicion = '';
      var name_client = this.model.get('name');

        iwscommand.clickToDialPEF({
            number: tel_client,
            type: "call",
            autoPlace: true,
            attributes: {}
        });
    },

    createcall: function (tel_client,idcall,nameClient) {
        //Recupera variables para petición
        self = this;
        var posiciones = App.user.attributes.posicion_operativa_c;
        var gen = App.user.attributes.llamada_genesys_c;
        var posicion = '';
        var name_client = nameClient;
        if(posiciones.includes(3)) posicion = 'Ventas';
        if(posiciones.includes(4)) posicion = 'Staff';
        var Params = {
            'id_cliente': this.model.get('id'),
            'nombre_cliente': name_client,
            'numero_cliente': tel_client,
            'modulo': 'Accounts',
            'posicion': posicion,
            'puesto_usuario': App.user.attributes.puestousuario_c,
            'ext_usuario': App.user.attributes.ext_c,
            'id_llamada': idcall
        };
        if(gen){
            self.createcallGen(tel_client);
        }else{
            //Ejecuta petición para generar llamada
            app.api.call('create', app.api.buildURL('createcall'), { data: Params }, {
              success: _.bind(function (data) {
                id_call = data;
                console.log('Llamada creada, id: ' + id_call);
                app.alert.show('message-to', {
                  level: 'info',
                  messages: 'Usted está llamando a ' + name_client,
                  autoClose: true
                });
                //callback(id_call, self);
              }, this),
            });
        }
    },
})
