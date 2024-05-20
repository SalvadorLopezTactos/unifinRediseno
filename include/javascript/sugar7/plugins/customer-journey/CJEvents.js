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

(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('CJEvents', ['view', 'field'], {

            /**
             * Toggles the panel when the workflowInfo div gets clicked
             */
            workflowInfoClicked: function() {
                if (this.isCJRenderedAsTab()) {
                    return;
                }

                if (this.actionBtnClicked) {
                    this.actionBtnClicked = false;
                    return;
                }

                let moreLess = this.hidePanel ? this.MORE_LESS_STATUS.MORE : this.MORE_LESS_STATUS.LESS;

                this.addRemoveClasses(moreLess);
            },

            /**
             * Add and remove CSS classes when journey is toggled more / less
             *
             * @param {boolean} moreLess
             */
            addRemoveClasses: function(moreLess) {
                let element = this.$el.find(`[data-id='${this.model.get('id')}']`);
                let workflowInfo = element.find('.dri-workflow-info');
                let workflowCard = element.find('.dri-workflow-card');

                if (moreLess === this.MORE_LESS_STATUS.MORE) {
                    workflowInfo.removeClass('dri-workflow-wrapper-closed');
                    workflowCard.removeClass('dri-workflow-wrapper-closed');
                    this.$el.addClass('open-border');
                } else {
                    workflowInfo.addClass('dri-workflow-wrapper-closed');
                    workflowCard.addClass('dri-workflow-wrapper-closed');
                    this.$el.removeClass('open-border');
                }

                this.toggleMoreLess(moreLess);
            },

            /**
             * Set action button clicked flag true to stop worflowInfoClicked action
             */
            actionButtonsClicked: function() {
                this.actionBtnClicked = true;
            },

            /**
             * Set action button clicked flag true to stop worflowInfoClicked action
             */
            actionButtonsClicked: function() {
                this.actionBtnClicked = true;
            },

            /**
             * Highlights the activity that another activity is blocked by
             *
             * @param {event} ev
             */
            blockedActivityClicked: function(ev) {
                var $el = $(ev.currentTarget);
                if ($el.hasClass('cj_blocked')) {
                    var id = $el.data('id');
                    var model = this.activities[id];

                    _.each(
                        model.get('blocked_by'),
                        function(blockedById) {
                            if (id !== blockedById && this.activities[blockedById]) {
                                var blockedBy = this.activities[blockedById];
                                var $blockedBy = this.$(`.dri-subworkflow-activity[data-id='${ blockedById }']`);
                                $blockedBy.effect('highlight', {color: '#e61718'});

                                if (!_.isEmpty(blockedBy.get(this.parentActivityId))) {
                                    this.showActivityChildren(blockedBy.get(this.parentActivityId));
                                }
                            }
                        },
                        this
                    );
                }
            },

            /**
             * Highlights the stage that another activity is blocked by
             *
             * @param {event} ev
             */
            blockedByStageActivityClicked: function(ev) {
                var $el = $(ev.currentTarget);
                if ($el.hasClass('cj_blocked_by_stage')) {
                    var id = $el.data('id');
                    var model = this.activities[id];

                    _.each(
                        model.get('blocked_by_stages'),
                        function(blockedByStageId) {
                            if (model.dri_subworkflow_template_id !== blockedByStageId &&
                                this.stages[blockedByStageId]) {
                                var blockedByStage = this.stages[blockedByStageId];
                                var $blockedByStage = this.$(`.dri-subworkflow[data-id='${ blockedByStageId }']`);
                                $blockedByStage.effect('highlight', {color: '#e61718'});
                            }
                        },
                        this
                    );
                }
            },

            /**
             * Sets the current journey as the Active
             * The active journeys are the one that are displayed in the chart dashlet
             */
            activeCycleClicked: function() {
                var parentModel = this.context.parent && this.context.parent.get('parentModel');
                parentModel && parentModel.trigger('customer_journey:active-cycle:click', this.model.id);
            },

            /**
             * Event handler when clicking on the preview eye icon on an activity
             *
             * @param {event} ev
             */
            previewActivityClicked: function(ev) {
                var id = $(ev.currentTarget).data('id');
                var activity = this.activities[id];
                this.previewModel(activity);
            },

            /**
             * remove the components from the given layout.
             *
             * @param {Object} layout
             * @param {Object} disposedComponents
             */
            disposeComponents: function(layout = null, disposedComponents = []) {
                if (_.isEmpty(layout) || _.isEmpty(disposedComponents)) {
                    return;
                }
                _.each(disposedComponents, function(compName, key) {
                    var comp = layout.getComponent(compName);
                    if (comp) {
                        comp.dispose();
                    }
                });
            },

            /**
             * Deletes a model.
             *
             * @param {Object} model
             */
            deleteModelClick: function(model) {
                let labelName = model.get('name');
                labelName += model.module === 'DRI_SubWorkflows' ? ' stage' : ' activity';
                app.alert.show('delete_activity', {
                    level: 'confirmation',
                    messages: app.lang.get('NTC_DELETE_CONFIRMATION', model.module),
                    onConfirm: _.bind(function() {
                        this.disablingJourneyAndStartLoading();
                        model.destroy({
                            success: _.bind(function() {
                                this.reloadData();
                                app.alert.show('success', {
                                    level: 'success',
                                    autoClose: true,
                                    messages: app.lang.get(
                                        'LBL_DELETE_SUCCESS_MESSAGE',
                                        'DRI_Workflows',
                                        {labelName: labelName}
                                    )
                                });
                            }, this),
                            error: _.bind(function(result) {
                                this.reloadData();
                                app.alert.show('error', {
                                    level: 'error',
                                    messages: result.message,
                                    autoClose: true
                                });
                            }, this),
                        });
                    }, this)
                });
            },

            /**
             * Opens up the drawer in edit mode to edit a given stage
             *
             * @param {Object} stage
             */
            editStageClick: function(stage) {
                var context = this.getStageContextById(stage.get('id'));

                stage.fetch({
                    success: _.bind(function() {
                        context.set('create', true);
                        context.get('model').link = null;

                        app.drawer.open({
                            module: stage.module,
                            layout: 'create',
                            context: context
                        }, _.bind(function(context, model) {
                            // Only reload if the model was saved, if not - revert all attributes from last sync
                            if (model) {
                                this.reloadData();
                            } else {
                                stage.revertAttributes();
                            }
                        }, this));
                    }, this),
                });
            },

            /**
             * Opens up the drawer in edit mode to edit a given activity
             *
             * @param {Object} activity
             */
            editActivityClick: function(activity) {
                var stageContext = this.getStageContextById(activity.get(this.activityStageId));

                activity.fetch({
                    success: _.bind(function() {
                        var context = stageContext.getChildContext({
                            module: activity.module,
                            model: activity,
                            forceNew: true,
                            create: true
                        });

                        app.drawer.open({
                            module: activity.module,
                            layout: 'create',
                            context: context
                        }, _.bind(function(context, model) {
                            //Only reload if the model was saved, if not - revert all attributes from last sync
                            if (model) {
                                this.reloadData();
                            } else {
                                activity.revertAttributes();
                            }
                        }, this));
                    }, this),
                });
            },

            /**
              * Handles starting a given activity
              *
              * @param {Object} activity
              */
            startActivityClick: function(activity) {
                app.alert.show('processing_start_activity_click', {
                    level: 'process',
                    title: app.lang.get('LBL_PROCESSING_REQUEST'),
                });
                this.handleForms(
                    activity,
                    'in_progress',
                    _.bind(function() {
                        this.startActivity(activity);
                        app.alert.dismiss('processing_start_activity_click');
                    }, this)
                );
            },

            /**
             * Starts a given activity
             *
             * @param {Object} activity
             */
            startActivity: function(activity) {
                var url = '';
                if (activity.module == 'Tasks') {
                    this.disablingJourneyAndStartLoading();
                    url = this.buildUrlActivityStatusUpdateApi(activity, 'In Progress');
                    this.callActivityStatusUpdateApi(url, activity);
                }
            },

            /**
            * Show processing alert
            */
            showProcessingAlert: function() {
                app.alert.show('process_complete_activity', {
                    level: 'process',
                    title: app.lang.get('LBL_CJ_PROCESSING_REQUEST'),
                    autoClose: false,
                });
            },

            /**
            * Get count of childActivities
            *
            * @param {Object} activity
            */
            getChildActivityCount: function(activity) {
                return _.isUndefined(activity.get('children')) ? 0 : activity.get('children').length;
            },

            /**
            * On confirm of complete activty click
            *
            * @param {string} activityID
            */
            completeActivityClickConfirm: function(activityID) {
                let activity = this.activities[activityID];

                this.showProcessingAlert();

                if (!_.isUndefined(activity)) {
                    const count = this.validateChildren(activity);
                    const taskCompletedList =  'cj_tasks_completed_status_list';
                    const callCompletedList = 'cj_calls_completed_status_list';
                    const callCompletedStatus = app.lang.getAppListStrings(callCompletedList)['Not Held'];
                    const taskCompletedStatus = app.lang.getAppListStrings(taskCompletedList)['Not Applicable'];

                    if (count < 1) {
                        _.each(activity.get('children'),  (childActivity) => {
                            if (!_.include([taskCompletedStatus, callCompletedStatus],
                                this.activities[childActivity.id].get('status'))) {
                                this.handleFormsForActivities(this.activities[childActivity.id], activity);
                            }
                        }, this);
                    } else {
                        this.blockByWarnings(this.activities[activity.id], count);
                    }
                }
            },

            /**
            * Handles completing a given activity
            *
            * @param {Object} activity
            */
            completeActivityClick: function(activity) {
                if (this.isParent(activity)) {
                    app.alert.show('success', {
                        level: 'confirmation',
                        messages: app.lang.get(
                            'LBL_CJ_COMPLETE_ALL_TASKS_CONFIRMATION',
                            this.model.module
                        ),
                        onConfirm: _.bind(this.completeActivityClickConfirm, this, activity.id)
                    });
                } else {
                    this.showProcessingAlert();
                    this.handleFormsForActivities(activity);
                }
            },

            /**
            * Validating activity children
            *
            * @param {Object} activity
            * @param {Object} object
            */
            validateChildren: function(activity) {
                let count = 0;

                _.each(activity.get('children'), (childActivity) => {
                    if (!_.isEmpty(childActivity.blocked_by) ||
                        !_.isEmpty(childActivity.blocked_by_stages)) {
                        count++;
                    }
                });

                return count;
            },

            /**
            * get count of children having Not Applicable status
            *
            * @param {Object} activity
            */
            getNotApplicableChildrenCount: function(activity) {
                let count = 0;
                const taskCompletedList =  'cj_tasks_completed_status_list';
                const callCompletedList = 'cj_calls_completed_status_list';
                const callCompletedStatus = app.lang.getAppListStrings(callCompletedList)['Not Held'];
                const taskCompletedStatus = app.lang.getAppListStrings(taskCompletedList)['Not Applicable'];

                _.each(activity.get('children'), function(childActivity) {
                    if (_.include([taskCompletedStatus, callCompletedStatus], childActivity.status)) {
                        count++;
                    }
                });

                return count;
            },

            /**
            * Show alerts for bloacked_by activities
            *
            * @param {Object} activity
            * @param {Int} count
            */
            blockByWarnings: function(activity, count) {
                app.alert.dismiss('process_complete_activity');

                if (count === 1) {
                    app.alert.show('bloack_by_children', {
                        level: 'warning',
                        messages: app.lang.get('LBL_CJ_BLOCK_BY',
                            this.model.module,
                            {Name: this.getBlockedByActivityName(activity)}
                        )
                    });
                } else {
                    app.alert.show('bloack_by_multiple_children', {
                        level: 'warning',
                        messages: app.lang.get('LBL_CJ_MULTIPLE_BLOCK_BY'),
                    });
                }
            },

            /**
            * Provide blocked_by activity name
            *
            * @param {Object} activity
            */
            getBlockedByActivityName: function(activity) {
                let childActivityName = '';

                _.each(activity.get('children'), (childActivity) => {
                    if (!_.isEmpty(childActivity.blocked_by) ||
                        !_.isEmpty(childActivity.blocked_by_stages)) {
                        childActivityName = childActivity.name;
                    }
                });

                return childActivityName;
            },

            /**
            * Handles forms for a given activity
            *
            * @param {Object} activity
            * @param {Object} parent
            */
            handleFormsForActivities: function(activity, parent) {
                this.handleForms(
                    activity,
                    'completed',
                    _.bind(this.completeActivity, this, activity, parent)
                );
            },

            /**
            * Completes a given activity
            *
            * @param {Object} activity
            * @param {Object} parent
            */
            completeActivity: function(activity, parent) {
                if (this.completingActivity) {
                    if (this.completingActivity !== activity && _.indexOf(this.completeQueue, activity) === -1) {
                        this.completeQueue.push(activity);
                    }
                    return;
                }

                this.completingActivity = activity;
                let preStatus = activity.get('status');
                let updatedStatus = '';

                switch (activity.module) {
                    case 'Tasks':
                        updatedStatus = 'Completed';
                        break;
                    case 'Meetings':
                    case 'Calls':
                        updatedStatus = 'Held';
                        break;
                    default:
                        return;
                }

                let fields = {
                    status: activity.fields.status,
                };

                let url = this.buildUrlActivityStatusUpdateApi(activity, updatedStatus, parent);
                activity.doValidate(
                    fields,
                    _.bind(function(isValid) {
                        if (isValid) {
                            app.api.call('create', url, null, {
                                success: _.bind(function(response) {
                                    if (!_.isEmpty(response)) {
                                        app.alert.dismiss('process_complete_activity');
                                        this.alertForRequiredFieldDependency(response);

                                        if (this.childActivityCount > 0) {
                                            this.reloadData();
                                        }
                                    } else {
                                        this.disablingJourneyAndStartLoading();
                                        this.completeActivitySuccess(activity);
                                    }
                                }, this),
                                error: _.bind(this.completeActivityError, this),
                            });
                        } else {
                            this.completingActivity = false;
                            activity.set('status', preStatus);
                            app.alert.dismiss('process_complete_activity');
                            app.alert.show('error', {
                                level: 'error',
                                messages: 'Validation failed',
                                autoClose: true,
                            });
                        }
                    }, this)
                );
            },

            /**
             * Successfull Update Activity Status
             *
             * @param {Object} activity
             */
            completeActivitySuccess: function(activity) {
                this.completingActivity = false;
                let stage = this.stages[activity.get('dri_subworkflow_id')];
                let stageRSATriggerFlag = false;
                --this.childActivityCount;
                if (stage.model.get('state') === 'not_started') {
                    stageRSATriggerFlag = true;
                }
                if (this.completeQueue.length) {
                    this.completeActivityClick(this.completeQueue.shift());
                } else {
                    this.reloadData();
                }
                this.handleFormsForStage(activity, activity.get('dri_subworkflow_id'), stageRSATriggerFlag);

                if (this.childActivityCount === 0) {
                    app.alert.dismiss('process_complete_activity');
                    app.alert.show('success_complete_activity', {
                        level: 'success',
                        messages: app.lang.get('LBL_CJ_SUCCESS'),
                        autoClose: true,
                    });
                }
                if (this.childActivityCount === -1) {
                    app.alert.dismiss('process_complete_activity');
                }
            },

            /**
             * Error while updating Activity Status
             *
             * @param {Object} result
             */
            completeActivityError: function(result) {
                this.completingActivity = false;
                this.reloadData();
                app.alert.dismiss('process_complete_activity');
                app.alert.show('error', {
                    level: 'error',
                    messages: result.message,
                    autoClose: true,
                });
            },

            /**
             * Event handler when clicking on the Assign Me on an activity
             *
             * @param {Object} activity
             */
            assignMeActivityClick: function(activity) {
                this.disablingJourneyAndStartLoading();
                activity.set('assigned_user_id', app.user.id);
                activity.save(null, {
                    success: _.bind(this.reloadData, this),
                    error: _.bind(function(result) {
                        this.reloadData();
                        app.alert.show('error', {
                            level: 'error',
                            messages: result.message,
                            autoClose: true
                        });
                    }, this),
                });
            },

            /**
             * Gets called when the Not Applicable button gets clicked
             * Updates the activity and reloads the data in the view
             *
             * @param {Object} activity
             */
            notApplicableActivityClick: function(activity) {
                this.handleForms(
                    activity,
                    'not_applicable',
                    _.bind(this.notApplicableActivity, this, activity)
                );
            },

            /**
             * Handles Not Applicable status for the activity
             * Updates the activity and reloads the data in the view
             *
             * @param {Object} activity
             */
            notApplicableActivity: function(activity) {
                var updatedStatus = '';
                var url = '';

                if (!_.isEmpty(activity.get('cj_parent_activity_id'))) {
                    // If it is a sub activity
                    switch (activity.module) {
                        case 'Tasks':
                            updatedStatus = 'Not Applicable';
                            break;
                        case 'Calls':
                            updatedStatus = 'Not Held';
                            break;
                        case 'Meetings':
                            updatedStatus = 'Not Held';
                            break;
                    }

                    this.disablingJourneyAndStartLoading();

                    url = this.buildUrlActivityStatusUpdateApi(activity, updatedStatus);
                    this.callActivityStatusUpdateApi(url, activity);
                } else {
                    // If it is a parent activity
                    this.childrenActivitiesNotApplicable(activity);
                }
            },

            /**
             * Gets called when the Not Applicable button on Parent Activity is clicked
             * Updates the Sub Activity and reloads the data in the view
             *
             * @param {Object} activity
             */
            childrenActivitiesNotApplicable: function(activity) {
                let url = app.api.buildURL(
                    'DRI_Workflows',
                    'not-applicable',
                    null,
                    {
                        activity_id: activity.id,
                        activity_module: activity.module,
                        activities: this.getActivitiesInfo(activity.get('children'), activity),
                        fieldsToValidate: this.getFieldsToValidate()
                    }
                );

                this.disablingJourneyAndStartLoading();
                app.api.call('create', url, null, {
                    success: _.bind(function(response) {
                        if (!_.isEmpty(response)) {
                            this.alertForRequiredFieldDependency(response);
                            this.reloadData();
                            return;
                        }

                        this.reloadData();
                        var stage = this.stages[activity.get('dri_subworkflow_id')];
                        var stageRSATriggerFlag = false;
                        if (stage.model.get('state') === 'not_started') {
                            stageRSATriggerFlag = true;
                        }
                        this.handleFormsForStage(activity, activity.get('dri_subworkflow_id'), stageRSATriggerFlag);
                    }, this),
                    error: _.bind(function(result) {
                        this.reloadData();
                        app.alert.show('error', {
                            level: 'error',
                            messages: result.message,
                            autoClose: true
                        });
                    }, this)
                });
            },

            /**
             * Opens the preview view in the intelligence pane
             *
             * @param {Object} activity
             */
            previewModel: function(activity) {
                app.events.trigger('preview:render', activity,
                    app.data.createBeanCollection(activity.module, [activity]), true);
            },

            /**
             * Adds a task
             *
             * @param {Object} stage
             */
            addTask: function(stage) {
                this.addActivity(stage, 'Tasks');
            },

            /**
             * Adds a meeting
             *
             * @param {Object} stage
             */
            addMeeting: function(stage) {
                this.addActivity(stage, 'Meetings');
            },

            /**
             * Adds a call
             *
             * @param {Object} stage
             */
            addCall: function(stage) {
                this.addActivity(stage, 'Calls');
            },

            /**
             * Adds a subtask
             *
             * @param {Object} activity
             */
            addSubTask: function(activity) {
                this.addSubActivity(activity, 'Tasks');
            },

            /**
             * Adds a submeeting
             *
             * @param {Object} activity
             */
            addSubMeeting: function(activity) {
                this.addSubActivity(activity, 'Meetings');
            },

            /**
             * Adds a subcall
             *
             * @param {Object} activity
             */
            addSubCall: function(activity) {
                this.addSubActivity(activity, 'Calls');
            },

            /**
             * Gets the fields for the duplicate button
             *
             * @param {Array} fieldsInfo
             * @return {Array}
             */
            _getFieldsForDuplicateButton: function(fieldsInfo) {
                var fields = [];
                _.each(fieldsInfo, function(field) {
                    if (field.type !== 'link') {
                        fields = fields.concat(field.name);
                    }
                }, this);

                return _.uniq(fields);
            },

            /**
             * Handles when clicking on the duplicate button for an activity
             *
             * @param {Object} activity
             * @param {Object} buttonDef
             */
            duplicateButton: function(activity, buttonDef = {}) {
                let currentActivityModule = activity.get('module') || activity.get('_module') || activity.module ||
                    activity._module;
                if (!_.isEmpty(activity.get('id')) && !_.isEmpty(currentActivityModule)) {
                    app.alert.show('loading_duplicate', {
                        level: 'process',
                    });

                    let reFetchActivity = app.data.createBean(currentActivityModule, {id: activity.get('id')});
                    let fieldsForReFecth = this._getFieldsForDuplicateButton(reFetchActivity.fields);
                    reFetchActivity.setOption('fields', fieldsForReFecth);

                    reFetchActivity.fetch({
                        success: _.bind(this.reFetchActivitySuccess, this, activity, buttonDef, reFetchActivity),
                    });
                }
            },

            /**
             * ReFetching Activity is Successful when clicking on the duplicate button for an activity
             *
             * @param {Object} activity
             * @param {Object} buttonDef
             * @param {Object} reFetchActivity
             */
            reFetchActivitySuccess: function(activity, buttonDef, reFetchActivity) {
                let currentModel = activity;
                let prefill = app.data.createBean(activity.module);
                prefill.copy(reFetchActivity);
                currentModel.trigger('duplicate:before', prefill);
                prefill.unset('id');
                prefill.unset('is_escalated');

                let order = '';
                if (!_.isEmpty(buttonDef) && buttonDef.def.childCopy) {
                    order = `${ reFetchActivity.get(this.activitySortOrder) } .`;
                    let stage = this.stages[reFetchActivity.get(this.activityStageId)];
                    let activity = stage.activities[reFetchActivity.id];
                    let children = stage && activity ? activity.children : {};

                    let last = _.last(_.values(children));

                    if (last) {
                        order = `${ reFetchActivity.get(this.activitySortOrder) }.`;
                        order += (parseInt(last.model.get(this.activitySortOrder).split('.')[1]) + 1);
                    } else {
                        order = `${ reFetchActivity.get(this.activitySortOrder) }.1`;
                    }
                } else {
                    let stageID = reFetchActivity.get(this.activityStageId);
                    let lastActivity = this.stages[stageID] && _.last(_.toArray(this.stages[stageID].activities));
                    if (lastActivity) {
                        order = parseInt(lastActivity.data[this.activitySortOrder]) + 1;
                    }
                }

                prefill.set(this.activitySortOrder, order);

                app.alert.dismiss('loading_duplicate');
                app.drawer.open({
                    layout: 'create',
                    context: {
                        create: true,
                        forceNew: true,
                        model: prefill,
                        copiedFromModelId: reFetchActivity.get('id'),
                        module: reFetchActivity.get('_module') || reFetchActivity.get('module')
                    }
                }, _.bind(function(context, newModel) {
                    if (newModel && newModel.id) {
                        this.reloadData();
                    }
                },this)
                );
                prefill.trigger('duplicate:field', this);
            },

            /**
             * Event handler when clicking on the hide children icon on an activity
             *
             * @param {event} ev
             */
            hideActivityChildrenClicked: function(ev) {
                var id = $(ev.currentTarget).data('id');
                this.hideActivityChildren(id);
            },

            /**
             * Handles hiding the child activities
             *
             * @param {string} id
             */
            hideActivityChildren: function(id) {
                this.$(`.dri-activity-children[data-id='${ id }']`).addClass('hide');
                this.$(`.dri-subworkflow-activity[data-id='${ id }'] .dri-activity-show-children`).removeClass('hide');
                this.$(`.dri-subworkflow-activity[data-id='${ id }'] .dri-activity-hide-children`).addClass('hide');
                this.setActivityDisplayChildren(id, this.MORE_LESS_STATUS.LESS);
            },

            /**
             * Event handler when clicking on the show children icon on an activity
             *
             * @param {event} ev
             */
            showActivityChildrenClicked: function(ev) {
                var id = $(ev.currentTarget).data('id');
                this.showActivityChildren(id);
            },

            /**
             * Handles showing the child activities
             *
             * @param {string} id
             */
            showActivityChildren: function(id) {
                this.$(`.dri-activity-children[data-id='${ id }']`).removeClass('hide');
                this.$(`.dri-subworkflow-activity[data-id='${id}'] .dri-activity-show-children`).addClass('hide');
                this.$(`.dri-subworkflow-activity[data-id='${ id }'] .dri-activity-hide-children`).removeClass('hide');
                this.setActivityDisplayChildren(id, this.MORE_LESS_STATUS.MORE);
            },

            /**
             * Retrieves a stage context by id
             *
             * @param {string} stageId
             * @return {Object}
             */
            getStageContextById: function(stageId) {
                var stages = this.model.getRelatedCollection(this.stageLink);
                var stage = stages.get(stageId);
                return this.getStageContext(stage);
            },

            /**
             * Get the cache key for the activity display children
             *
             * @param {string} id
             * @return {string}
             */
            getActivityDisplayChildrenCacheKey: function(id) {
                return app.user.lastState.key('activity_display_children[' + id + ']', this);
            },

            /**
             * Set the cache key for the activity display children
             *
             * @param {string} id
             * @param {string} value
             */
            setActivityDisplayChildren: function(id, value) {
                var key = this.getActivityDisplayChildrenCacheKey(id);
                app.user.lastState.set(key, value);
            },

            /**
             * Retrieves a stage context by stage model
             *
             * @param {Object} stage
             * @return {Object}
             */
            getStageContext: function(stage) {
                var stageContext;

                stageContext = this.context.getChildContext({
                    module: this.stageModule,
                    model: stage,
                    forceNew: true
                });

                return stageContext;
            },

            /**
             * Shows alert for the empty required field
             *
             * @param {Object} data
             */
            alertForRequiredFieldDependency: function(data) {
                app.alert.show('error', {
                    level: 'error',
                    messages: app.lang.get('LBL_REQUIRED_FIELD_EMPTY_IN_ACTIVITY', this.model.module, {
                        fieldName: data.field,
                        recordUrl: app.router.buildRoute(data.module, data.id),
                        recordName: data.name
                    }),
                    autoClose: true,
                    autoCloseDelay: 10000,
                });

                this.completingActivity = false;
            },

            /**
             * It will return all the view level and field level dependencies
             *
             * @param {type} model
             * @return {Object}
             */
            _getSugarLogicDependenciesForModel: function(model) {
                var module = model.module;
                if (_.isEmpty(this.moduleDependencies[module])) {
                    var moduleMetadata = app.metadata.getModule(module) || {};
                    var dependencies = moduleMetadata.dependencies || [];

                    if (moduleMetadata.views && moduleMetadata.views.record) {
                        var recordMetadata = moduleMetadata.views.record.meta;
                        if (!_.isUndefined(recordMetadata.dependencies)) {
                            dependencies = dependencies.concat(recordMetadata.dependencies);
                        }
                    }

                    // Cache the results so we don't have to do this expensive lookup any more
                    this.moduleDependencies[module] = dependencies;
                }

                return this.moduleDependencies[module];
            },

            /**
             * @param {string} id
             * @return {string}
             */
            getActivityDisplayChildren: function(id) {
                var key = this.getActivityDisplayChildrenCacheKey(id);
                return app.user.lastState.get(key);
            },

            /**
             * Event handler when clicking on the Configure Template button
             */
            configureTemplateClick: function() {
                this.reRoute('DRI_Workflow_Templates', this.model.get('dri_workflow_template_id'));
            },

            /**
             * Event handler when clicking on the View Journey button
             */
            viewJourneyClick: function() {
                this.reRoute('DRI_Workflows', this.model.get('id'));
            },

            /**
             * Provide an array containing activities id and module information
             *
             * @param {Object|Array} activities
             * @param {Object} currentActivity
             * @return {Array}
             */
            getActivitiesInfo: function(activities, currentActivity) {
                let activitiesInfo = [];

                if (!_.isEmpty(currentActivity)) {
                    activitiesInfo.push({
                        id: currentActivity.id,
                        module: currentActivity.module
                    });
                }

                for (let key in activities) {
                    let activity = activities[key];

                    activitiesInfo.push({
                        id: activity.id,
                        module: activity.module || activity._module
                    });
                }

                return activitiesInfo;
            },

            /**
             * Event handler when clicking on the Cancel Journey button
             */
            cancelJourneyClick: function() {
                app.alert.show('cancel_model', {
                    level: 'confirmation',
                    messages: app.lang.get('LBL_CJ_CANCEL_CONFIRMATION', this.model.module),
                    onConfirm: _.bind(function() {
                        let url = app.api.buildURL(this.model.module, 'cancel', null, {
                            record: this.model.get('id'),
                            activities: this.getActivitiesInfo(this.activities),
                            fieldsToValidate: this.getFieldsToValidate()
                        });

                        this.disablingJourneyAndStartLoading();
                        app.api.call('create', url, null, {
                            success: _.bind(function(response) {
                                this.reloadData();

                                if (!_.isEmpty(response)) {
                                    this.alertForRequiredFieldDependency(response);
                                } else {
                                    app.alert.show('success', {
                                        level: 'success',
                                        autoClose: true,
                                        messages: app.lang.get(
                                            'LBL_CANCEL_SUCCESS_MESSAGE',
                                            'DRI_Workflows',
                                            {labelName: this.model.get('name')}
                                        )
                                    });
                                }
                            }, this),
                            error: _.bind(function(result) {
                                this.reloadData();

                                app.alert.show('error', {
                                    level: 'error',
                                    messages: result.message,
                                    autoClose: true
                                });
                            }, this)
                        });
                    }, this)
                });
            },

            /**
             * Event handler when clicking on the Archive Journey button
             */
            archiveJourneyClick: function() {
                app.alert.show('archive_model', {
                    level: 'confirmation',
                    messages: app.lang.get('LBL_CJ_ARCHIVE_CONFIRMATION', this.model.module),
                    onConfirm: _.bind(function() {
                        var url = app.api.buildURL(this.model.module, 'archive', {
                            id: this.model.get('id')
                        });

                        this.disablingJourneyAndStartLoading();
                        var parentContext = this.context.parent;
                        app.api.call('create', url, null, {
                            success: _.bind(function() {
                                this.updateArchiveUnarchiveLastState('archived', this.model.get('id'));
                                this.activateCycleAndReloadWorkflow(parentContext, true);
                                this.reloadData();
                            }, this),
                            error: _.bind(function(result) {
                                this.enablingJourneyAndDoneLoading();
                                this.activateCycleAndReloadWorkflow(parentContext);
                                app.alert.show('error', {
                                    level: 'error',
                                    messages: result.message,
                                    autoClose: true
                                });
                            }, this)
                        });
                    }, this)
                });
            },

            /**
             * Event handler when clicking on the Unarchive Journey button
             */
            unarchiveJourneyClick: function() {
                app.alert.show('archive_model', {
                    level: 'confirmation',
                    messages: app.lang.get('LBL_CJ_UNARCHIVE_CONFIRMATION', this.model.module),
                    onConfirm: _.bind(function() {
                        var url = app.api.buildURL(this.model.module, 'unarchive', {
                            id: this.model.get('id')
                        });

                        this.disablingJourneyAndStartLoading();
                        var parentContext = this.context.parent;
                        app.api.call('create', url, null, {
                            success: _.bind(function() {
                                this.updateArchiveUnarchiveLastState('active', this.model.get('id'));
                                this.activateCycleAndReloadWorkflow(parentContext);
                                this.reloadData();
                            }, this),
                            error: _.bind(function(result) {
                                this.enablingJourneyAndDoneLoading();
                                this.activateCycleAndReloadWorkflow(parentContext);
                                app.alert.show('error', {
                                    level: 'error',
                                    messages: result.message,
                                    autoClose: true
                                });
                            }, this)
                        });
                    }, this)
                });
            },

            /**
             * Event handler when clicking on the Delete Journey button
             *
             * @param {Object} model
             */
            deleteCycleClicked: function(model) {
                const journeyId = this.model.get('id');
                const labelName = model.get('name') + ' smart guide';

                app.alert.show('delete_model', {
                    level: 'confirmation',
                    messages: app.lang.get('NTC_DELETE_CONFIRMATION', model.module),
                    onConfirm: _.bind(function() {
                        // We must retrieve the context here since the view
                        // Will be disposed when the request is finished.
                        var parentContext = this.context.parent;
                        this.model.destroy({
                            success: _.bind(function() {
                                this.removeJourneyIdFromLastState(parentContext.parent, journeyId);
                                this.activateCycleAndReloadWorkflow(parentContext, true);
                                app.alert.show('success', {
                                    level: 'success',
                                    autoClose: true,
                                    messages: app.lang.get(
                                        'LBL_DELETE_SUCCESS_MESSAGE',
                                        'DRI_Workflows',
                                        {labelName: labelName}
                                    )
                                });
                            }, this),
                            error: _.bind(function(result) {
                                this.activateCycleAndReloadWorkflow(parentContext);
                                app.alert.show('error', {
                                    level: 'error',
                                    messages: result.message,
                                    autoClose: true
                                });
                            }, this)
                        });
                    }, this)
                });
            },
        });
    });
})(SUGAR.App);
