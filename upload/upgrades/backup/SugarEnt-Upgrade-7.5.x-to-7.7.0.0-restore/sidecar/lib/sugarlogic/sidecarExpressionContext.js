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


(function() {

SUGAR.forms = SUGAR.forms || {};
SUGAR.forms.animation = SUGAR.forms.animation || {};

/**
 * An expression context is used to retrieve variables when evaluating expressions.
 * the default class only returns the empty string.
 */
var SE = SUGAR.expressions,
    SEC = SE.SidecarExpressionContext = function(view){
        this.view = view;
        this.model = view.model || view.context.get("model");
    };

SUGAR.util.extend(SEC, SE.ExpressionContext, {
    getValue : function(varname)
    {
        var value = this.model.get(varname),
            def =   this.model.fields[varname],
            result;

        //Relate fields are only string on the client side, so return the variable name back.
        if(def.type == "link")
            value = varname;

        if (typeof(value) == "string")
        {
            value = value.replace(/\n/g, "");
            if ((/^(\s*)$/).exec(value) != null || value === "")
            {
                result = SEC.parser.toConstant('""');
            }
            // test if value is a number or boolean
            else if ( SE.isNumeric(value) ) {
                result = SEC.parser.toConstant(SE.unFormatNumber(value));
            }
            // assume string
            else {
                result =  SEC.parser.toConstant('"' + value + '"');
            }
        } else if (typeof(value) == "object" && value != null && value.getTime) {
            //This is probably a date object that we must convert to an expression
            var d = new SE.DateExpression("");
            d.evaluate = function(){return this.value};
            d.value = value;
            result =  d;
        } else if (typeof(value) == "number") {
            //Cast to a string before send to toConstant.
            result =  SEC.parser.toConstant("" + value);
        } else if (_.isBoolean(value)) {
            result =  value ? new SUGAR.expressions.TrueExpression() : new SUGAR.expressions.FalseExpression();
        } else {
            result = SEC.parser.toConstant('""');
        }

        return result;

    },
    setValue : function(varname, value)
    {
        if (typeof(this.model.fields[varname]) != 'object') {
            return;
        }
        var targetDef = this.model.fields[varname];

        this.lockedFields = this.lockedFields || [];

        if (typeof(value) == "object" 
            && value.length > 0
            && targetDef.type != "multienum" ) {
            value = value.join(", ");
        }

        //Boolean handling
        if (targetDef.type == "bool" && _.isString(value)) {
            value = SUGAR.expressions.Expression.isTruthy(value);
        }

        if (!this.lockedFields[varname])
        {
            this.lockedFields[varname] = true;
            var el = this.getElement(varname);
            if (el) {
                SUGAR.forms.FlashField($(el).parents('[data-fieldname="' + varname + '"]'), null, varname);
            }
            var ret = this.model.set(varname, value);
            this.lockedFields = [];
            return  ret;
        }
    },
    addListener : function(varname, callback, scope)
    {
        //For lists, we need to listen to the collection to check for modifcations to any of the models.
        if (this.view.collection) {
            this.view.collection.off("change:" + varname, callback, scope);
            this.view.collection.on("change:" + varname, callback, scope);
        } else {
            this.model.off("change:" + varname, callback, scope);
            this.model.on("change:" + varname, callback, scope);
        }
    },
    getElement : function(varname) {
        var field = this.getField(varname);
        if (field && field.el)
            return field.el;
    },
    getField : function(varname) {
        return this.view.getField(varname, this.model);
    },
    addClass : function(varname, css_class, includeLabel){
        var def = this.view.getFieldMeta(varname),
            props = includeLabel ? ["css_class", "cell_css"] : ["css_class"],
            el = this.getElement(varname),
            parent = $(el).closest('div.record-cell');

        _.each(props, function(prop) {
            if (!def[prop]) {
                def[prop] = css_class;
            } else if (def[prop].indexOf(css_class) == -1){
                def[prop] += " " + css_class;
            }
        });
        this.view.setFieldMeta(varname, def);

        $(el).addClass(css_class);
        if (includeLabel && parent) {
            parent.addClass(css_class);
        }

    },
    removeClass : function(varname, css_class, includeLabel) {
        var def = this.view.getFieldMeta(varname),
            field = this.view.getField(varname),
            props = includeLabel ? ["css_class", "cell_css"] : ["css_class"],
            el = this.getElement(varname),
            parent = $(el).closest('div.record-cell');

        //Remove it from both the field objects def and the view metadata
        _.each([field.def, def], function(d) {
            _.each(props, function(prop) {
                if (d[prop] && d[prop].indexOf(css_class) != -1) {
                    d[prop] = $.trim((" " + d[prop] + " ").replace(new RegExp(' ' + css_class + ' '), ""));
                }
            });
        });
        this.view.setFieldMeta(varname, def);

        $(el).removeClass(css_class);
        if (includeLabel && parent) {
            parent.removeClass(css_class);
            parent.find("." + css_class).removeClass(css_class);

        }
    },
    getLink : function(variable) {
        var model = this.model;
        if (model && model.fields && model.fields[variable])
            return model.fields[variable];
    },

    showError : function(variable, error)
    {
    	//TODO
    },
    clearError : function(variable)
    {
    	//TODO
    },
    setStyle : function(variable, styles)
    {
    	//TODO
    },
    setRelatedFields : function(fields, silent){
        silent = !!silent;
        var model = this.model;
        for (var link in fields)
        {
            var currValue = model.get(link),
                forceChangeEvent = !!currValue, //Force the change event if the model already had an object for the link
                value = currValue || {};
            _.each(fields[link], function(values, type) {
                if (_.isObject(values)) {
                    value[type] = _.extend(value[type] || {}, values);
                } else {
                    value[type] = values;
                }
            });
            var toSet = {};
            toSet[link] = value;
            model.set(toSet, {silent:silent});
            if (!silent && forceChangeEvent) {
                model.trigger("change:" + link, model);
            }
        }
    },
    getRelatedFieldValues : function(fields, module, record, silent)
    {
        var self = this,
            api = App.api;
        if (fields.length > 0) {
            module = module || this.view.context.get("module");
            record = record || this.model.get("id");
            for (var i = 0; i < fields.length; i++) {
                var link = fields[i].link,
                    toSet = {};
                //Related fields require a current related id
                if (fields[i].type == "related") {
                    var linkDef = this.model.fields[link];
                    if (linkDef && linkDef.id_name && linkDef.module) {
                        var relId = this.model.get(linkDef.id_name);
                        if (relId) {
                            fields[i].relId = relId
                            fields[i].relModule = linkDef.module;
                        }
                    }
                }
                if (fields[i].relate) {
                    //Mark the links as populating soon to prevent repeat requests for the same data.
                    toSet[link] = {};
                    toSet[link][fields[i].type] = {};
                    toSet[link][fields[i].type][fields[i].relate] = "";
                    self.setRelatedFields(toSet, true);
                }
            }
            var data = {id: record, action: "related"},
                params = {module: module, fields: JSON.stringify(fields)};

            api.call("read", api.buildURL("ExpressionEngine", "related", data, params), data, params, {
                success: function(resp) {
                    self.setRelatedFields(resp, silent);
                    return resp;
                }});
        }
        return null;
    },
    getRelatedField : function(link, ftype, field){
        var linkValues = this.model.get(link) || {};

        if (ftype == "related" && !this.inCollection) {// except subpanels. see explanation below RE:updating a full collection of models
            return this._handleRelateExpression(link, field);
        }

        //Check if we already have this value
        if (typeof(linkValues[ftype]) != "undefined") {
            if (!field) {
                return linkValues[ftype];
            } else if (typeof(linkValues[ftype][field]) != "undefined") {
                return linkValues[ftype][field];
            }
        }
        //We fell through so its time to try and load through ajax

        //When updating a full collection of models, do not get related values as this will
        //send one request per item in the list (could be as many as 100)
        if (this.inCollection) {
            linkValues[ftype] = linkValues[ftype] || {};
            linkValues[ftype][field] = linkValues[ftype][field] || "";
            // Setting with the silent flag to prevent change events from firing
            // downstream and forcing recalculations based on those changes
            this.model.set(link, linkValues, {silent: true});
            return "";
        }

        //Do not attempt to load related values of a new record
        if (!this.model.get("id")) {
            return "";
        }

        var params = {link: link, type: ftype};
        if (field) {
            params.relate = field;
        }

        this.getRelatedFieldValues([params]);

        if (typeof(linkValues[ftype]) == "undefined")
            return "";

        return linkValues[ftype];

    },
    _handleRelateExpression : function(link, field){
        //Ensure the current model is selected in the collection.
        this.view.context.set("model", this.model);
        var relContext = this.view.context.getChildContext({link:link});
        //Prepares instances of related model and collection.
        relContext.prepare();
        var col = relContext.get("collection"),
            fields = relContext.get('fields') || [],
            self = this,
            //First check if there is a relate field availible before loading a rel context.
            rField = _.find(this.model.fields, function(def){
                return (def.type && def.type == "relate" && def.id_name && def.link && def.link == link)
            }),
            relModel = relContext.get("model");

        //Now check if a relate field for this link changed since we last loaded this value
        //Check if the context is a collection and use the first model instead if that is the case
        if (relContext.isDataFetched() && !relContext.get("modelId")) {
            relModel = col.length > 0 ? col.models[0] : null;
        }

        //Now check if a relate field for this link changed since we last loaded this value
        if (rField &&
            (!this.model.get(rField.id_name) ||
                (relModel && relModel.get("id") != this.model.get(rField.id_name))
            )) {
            //Nuke the context info now since its no longer valid
            relContext.set({model:null});
            relContext.resetLoadFlag();
            //We are using a relate field but its empty for now, so abort.
            if (!this.model.get(rField.id_name))
                return "";
        }

        // initiate loading data in case if it's not initiated yet or loaded model doesn't contain the needed field
        if (field && (!relContext.isDataFetched() || (relModel && _.isUndefined(relModel.get(field))))) {
            if (!_.contains(fields, field)) {
                fields.push(field);
            }
            this._loadRelatedData(link, fields, relContext, rField);
        }
        else if (relModel) {
            return relModel.get(field);
        } else {
            // This link is currently being loaded (with the field we need). Collection's don't fire a sync/fetch event,
            // so we need to use doWhen to known when the load is complete.
            // We will fire the link change event once the load is complete to re-fire the dependency with the correct data.
            // Keep a reference to what the model was when we started the doWhen in case it changes when the sync completes.
            var model = this.model;
            SUGAR.App.utils.doWhen(function(){return col.page > 0}, function(){
                model.trigger("change:" + link, model);
            });
        }
        return "";
    },
    //Helper function to trigger the actual load call of related data
    _loadRelatedData : function(link, fields, relContext, rField) {
        var self = this;
        if (rField && this.model.get(rField.id_name)){
            //If we are using a relate field rather than a full link
            var modelId = this.model.get(rField.id_name),
                model =  relContext.get("model")
                     || SUGAR.App.data.createRelatedBean(this.model, this.model.get(rField.id_name), link);
            relContext.set({
                modelId:modelId,
                model : model
            });
        } else {
            //If we don't have a record id, we can't make a server call for anything so abort at this point
            if (_.isEmpty(this.model.get("id")))
                return "" ;
        }

        relContext.prepare();
        //Call set in case fields was not already on the context
        relContext.set({
            'fields' : _.union(relContext.get("fields") || [], fields),
            //Force skipFetch false if this context had the data we wanted, we wouldn't be here.
            skipFetch : false
        });
        if (relContext.isDataFetched()){
            relContext.resetLoadFlag();
        }

        //don't use the link api if we are forcing an id pulled from a field on the current model.
        if (rField) relContext.attributes.link = null;
        var model = this.model;
        //need up update the related context's bean to the current list bean before we can load it.
        //relContext.set("parentModel", model);
        //relContext.attributes.collection.link.bean = model;
        relContext.loadData({success:function(){
            // We will fire the link change event once the load is complete to re-fire the dependency with the correct data.
            model.trigger("change:" + link, model);
        }});
        if (rField) relContext.attributes.link = link;

    },
    //PreSetup but don't load any related contexts we might need
    _setupLinks : function(relatedFields){
        _.each(relatedFields, function(field) {
            if (field.link && field.relate && field.type == "related") {
                var relContext = this.view.context.getChildContext({link:field.link});
                if (relContext) {
                    relContext.set("fields", _.union(relContext.get("fields") || [], [field.relate]));
                }
            }
        }, this);
    },
    //Preload (but don't trigger changes) related field data
    _requestRollups :  function(relatedFields){
        if(this.model.get("id")){
            this.getRelatedFieldValues(relatedFields, null, null, true);
        }
    },
    fireOnLoad : function(dep) {
        //Disable fire on load for now as we no longer have edit vs detail views and
        //this is just costing us performance.
        //this.view.model.once("change", SUGAR.forms.Trigger.fire, dep.trigger);
    },
    getAppListStrings : function(list) {
        return SUGAR.App.lang.getAppListStrings(list);
    },
    parseDate: function(date, type) {
        return SUGAR.App.date.parse(date);
    },
    /**
     * Used to set a field read-only / disabled
     * @param {String} target Name of field to modify
     * @param {Boolean} disabled True to mark a field read-only. False to mark it editable.
     */
    setFieldDisabled: function(target, disabled) {
        disabled = (_.isUndefined(disabled)) ? true : disabled;
        var field = this.getField(target);
        if (field) {
            field.setDisabled(disabled);

            // set the metadata flag for the field
            this.view.setFieldMeta(target, {'readonly': disabled});
            // if we are on a view that has noEditFields on it, we need to add or remove it depending
            // the state of the readonly flag
            if (_.isArray(this.view.noEditFields)) {
                if(disabled) {
                    this.view.noEditFields.push(target);
                } else {
                    this.view.noEditFields = _.without(this.view.noEditFields, target);
                }
            }
            //We then need to show or hide the inline edit pencil if it exists
            if (disabled) {
                this.view.$("span.record-edit-link-wrapper[data-name=" + target + "]").hide();
            } else {
                this.view.$("span.record-edit-link-wrapper[data-name=" + target + "]").show();
            }

            // if disabled is false
            // and the currentState of the field is not edit
            // and the currentState of the view is edit but not inlineEditMode
            // then we switch to field into edit mode and add the field to the editableFields list
            if (_.isEqual(disabled, false)
                && !_.isEqual(field.currentState, 'edit')
                && _.isEqual(this.view.currentState, 'edit')
                && !_.isEqual(this.view.inlineEditMode, true)
            ) {
                field.setMode('edit');
                this.view.editableFields.push(field);
            }
            if (_.isFunction(this.view.setEditableFields)) {
                this.view.setEditableFields();
            }
        }
    },
    /**
     * Used to mark a field required or not in the current view.
     * @param {String} target Name of field to modify.
     * @param {Boolean} required True to mark a field required. False to mark it nullable.
     */
    setFieldRequired: function(target, required) {
        //Force required to be boolean true or false
        required = SUGAR.expressions.Expression.isTruthy(required);
        var field = this.view.getField(target, this.model);
        if (field) {
            field.def.required = required;
            field.render();
        }
    },
    setModel : function(model) {
        this.model = model;
    },
    /**
     * Used to Add Currency Values
     *
     * @param {String} start        What we are starting with
     * @param {String} add          What we want to add to the value
     * @return {String}
     */
    currencyAdd: function(start, add) {
        return SUGAR.App.math.add(start, add, 6, true);
    },
    /**
     * Used to Subtract Currency Values
     *
     * @param {String} start        What we are starting with
     * @param {String} subtract          What we want to subtract from the value
     * @return {String}
     */
    currencySubtract: function(start, subtract) {
        return SUGAR.App.math.sub(start, subtract, 6, true);
    },
    /**
     * Used to Multiply Currency Values
     *
     * @param {String} start        What we are starting with
     * @param {String} multiply     What we want to multipy by
     * @return {String}
     */
    currencyMultiply: function(start, multiply) {
        return SUGAR.App.math.mul(start, multiply, 6, true);
    },
    /**
     * Used to Divide Currency Values
     *
     * @param {String} start        What we are starting with
     * @param {String} divide       What we want to divide the currency value by
     * @return {String}
     */
    currencyDivide: function(start, divide) {
        return SUGAR.App.math.div(start, divide, 6, true);
    }
});

/**
 * @STATIC
 * The Default expression parser.
 */
SEC.parser = new SUGAR.expressions.ExpressionParser();

/**
 * @STATIC
 * Parses expressions given a variable map.<br>
 */
SEC.evalVariableExpression = function(expression, view)
{
	return SEC.parser.evaluate(expression, new SEC(view));
}

/**
 * A dependency is an object representation of a variable being dependent
 * on other variables. For example A being the sum of B and C where A is
 * 'dependent' on B and C.
 */
SUGAR.forms.Dependency = function(trigger, actions, falseActions, testOnLoad, context)
{
    this.actions = actions;
	this.falseActions = falseActions;
	this.context = context;
    this.testOnLoad = testOnLoad;
    trigger.setContext(this.context);
    trigger.setDependency(this);
	this.trigger = trigger;
	if (testOnLoad) {
	    context.fireOnLoad(this);
	}

}

    /**
     *  Creates a Dependency from the given metadata.
     *
     * @static
     * @param meta {object} metadata that defines this dependency
     * @param context {ExpressionContext} to attach to this dependency
     * @return Dependency object created from metadata
     */
SUGAR.forms.Dependency.fromMeta = function(meta, context){
    var condition = meta.trigger || "true",
        triggerFields = meta.triggerFields || SE.ExpressionParser.prototype.getFieldsFromExpression(condition),
        actions = meta.actions || [],
        falseActions = meta.notActions || [],
        onLoad = meta.onload || false,
        //Aways trigger a dependecy onload during a create since no data exists server side yet.
        isNew = context.model && _.isEmpty(context.model.get("id")),
        actionObjects = [],
        falseActionObjects = [];

    //Without any trigger fields (or a condition with variables), we can't create a trigger
    if (_.isEmpty(triggerFields) && !onLoad && !isNew)
        return null;
    //No actions means no reason to create a dependency
    if (_.isEmpty(actions) && _.isEmpty(falseActions))
        return null;

    _.each(actions, function(actionDef)
    {
        if (!actionDef.action || !SUGAR.forms[actionDef.action + "Action"])
            return;
        actionObjects.push(new SUGAR.forms[actionDef.action + "Action"](actionDef.params));
    });
    _.each(falseActions, function(actionDef)
    {
        if (!actionDef.action || !SUGAR.forms[actionDef.action + "Action"])
            return;
        falseActionObjects.push(new SUGAR.forms[actionDef.action + "Action"](actionDef.params));
    });

    return new SUGAR.forms.Dependency(
        new SUGAR.forms.Trigger(triggerFields, condition, context),
        actionObjects, falseActionObjects, onLoad, context
    );
}


    /**
     * If the type of all the triggerFiels are link, then it should return false
     * @returns {boolean}
     */
    SUGAR.forms.Dependency.prototype.fireLinkOnlyDependency = function()
    {
        if (!this.testOnLoad) {
            return false;
        }
        /**
         * cycle all the triggerFields
         *   - When all the triggerFields are type of link, we can still trigger this
         *   - if one is not type of link, then don't trigger this
         */
        var fire = true;
        if (this.context.model.fields) {
            _.each(this.trigger.variables, function(field) {
                fire = (fire && this.context.model.fields[field] && this.context.model.fields[field].type == "link");
            }, this);
        }

        return fire;
    }


/**
 * Triggers this dependency to be re-evaluated again.
 */
SUGAR.forms.Dependency.prototype.fire = function(undo)
{
    if(this.context.view.disposed || !this.context.view.context) {
        return;
    }
	try {
        var model = this.context.model;
        this.lastTriggeredActions = this.lastTriggeredActions || [];

		//Do not trigger dependencies on models that haven't changed and aren't set to fire on load.
        if (model.inSync && !this.testOnLoad) {
            return;
        }

        var actions = this.actions;
		if (undo && this.falseActions != null)
			actions = this.falseActions;

        //Clean up any render listeners for out of date actions when a dependency is triggered multiple times
        _.each(this.lastTriggeredActions, function(action) {
            this.context.view.off(null, null, action);
        }, this);

        if (actions instanceof SUGAR.forms.AbstractAction)
            actions = [actions];

        for (var i in actions) {
            var action = actions[i];
            if (typeof action.exec == "function") {
                action.setContext(this.context);
                action.exec();
                if (this.testOnLoad && action.afterRender) {
                    this.context.view.on('render', action.exec, action);
                }
            }
        }

        this.lastTriggeredActions = actions;

	} catch (e) {
		if (!SUGAR.isIE && console && console.log){
			console.log('ERROR: ' + e);
		}
		return;
	}
};

SUGAR.forms.Dependency.prototype.getRelatedFields = function() {
    var parser = SEC.parser,
        fields = parser.getRelatedFieldsFromFormula(this.trigger.condition);
    //parse will search a list of actions for formulas with relate fields
    var parse = function (actions) {
        if (actions instanceof SUGAR.forms.AbstractAction) {
            actions = [actions];
        }
        for (var i in actions) {
            var action = actions[i];
            //Iterate over all the properties of the action to see if they are formulas with relate fields
            if (typeof action.exec == "function") {
                for (var p in action) {
                    if (typeof action[p] == "string")
                        fields = $.merge(fields, parser.getRelatedFieldsFromFormula(action[p]));
                }
            }
        }
    }
    parse(this.actions);
    parse(this.falseActions);
    return fields;
}


    SUGAR.forms.AbstractAction = function (target) {
        this.target = target;
    };

    SUGAR.forms.AbstractAction.prototype.exec = function () {

    }

    SUGAR.forms.AbstractAction.prototype.setContext = function (context) {
        this.context = context;
    }

    SUGAR.forms.AbstractAction.prototype.evalExpression = function (exp, context) {
        context = context || this.context;
        return SEC.parser.evaluate(exp, context).evaluate();
    }

    /**
     * This object resembles a trigger where a change in any of the specified
     * variables triggers the dependencies to be re-evaluated again.
     */
    SUGAR.forms.Trigger = function (variables, condition, context) {
        this.variables = variables;
        this.condition = condition;
        this.context = context;
        this.dependency = { };
        this._attachListeners();
    }

    /**
     * Attaches a 'change' listener to all the fields that cause
     * the condition to be re-evaluated again.
     */
    SUGAR.forms.Trigger.prototype._attachListeners = function () {
        if (!(this.variables instanceof Array)) {
            this.variables = [this.variables];
        }

        for (var i = 0; i < this.variables.length; i++) {
            this.context.addListener(this.variables[i], SUGAR.forms.Trigger.fire, this, true);
        }
    }

    /**
     * Attaches a 'change' listener to all the fields that cause
     * the condition to be re-evaluated again.
     */
    SUGAR.forms.Trigger.prototype.setDependency = function (dep) {
        this.dependency = dep;
    }

    SUGAR.forms.Trigger.prototype.setContext = function (context) {
        this.context = context;
    }

    /**
     * @STATIC
     * This is the function that is called when a 'change' event
     * is triggered. If the condition is true, then it triggers
     * all the dependencies.
     */
    SUGAR.forms.Trigger.fire = function (model) {
        // eval the condition
        var eval, val;
        if (model) {
            this.context.setModel(model);
        }
        try {
            eval = SEC.parser.evaluate(this.condition, this.context);
        } catch (e) {
            if (!SUGAR.isIE && console && console.log) {
                console.log('ERROR:' + e + "; in Condition: " + this.condition);
            }
        }

        // evaluate the result
        if (typeof(eval) != 'undefined')
            val = eval.evaluate();

        // if the condition is met
        if (val == SUGAR.expressions.Expression.TRUE) {
            // single dependency
            if (this.dependency instanceof SUGAR.forms.Dependency) {
                this.dependency.fire(false);
                return;
            }
        } else if (val == SUGAR.expressions.Expression.FALSE) {
            // single dependency
            if (this.dependency instanceof SUGAR.forms.Dependency) {
                this.dependency.fire(true);
                return;
            }
        }
    }

    SUGAR.forms.flashInProgress = {};
    /**
     * @STATIC
     * Animates a field when by changing it's background color to
     * a shade of light red and back.
     */
    SUGAR.forms.FlashField = function (field, to_color, key) {
        if (typeof(field) == 'undefined' || (!key && !field.id))
            return;
        key = key || field.id;
        if (SUGAR.forms.flashInProgress[key])
            return;

        SUGAR.forms.flashInProgress[key] = true;

        to_color = to_color || '#FF8F8F';
        // store the original background color but default to white
        var original = field.style && field.style.backgroundColor ? field.style.backgroundColor : '#FFFFFF' ;

        $(field).css("backgroundColor", original);

        $(field).animate({
            backgroundColor : to_color
        }, 200, function(){
            $(field).animate({
                backgroundColor : original
            }, 200, function(){
                delete SUGAR.forms.flashInProgress[key];
            });
        });
    };

    //Register SugarLogic as a plugin to sidecar.
    if (SUGAR.App && SUGAR.App.plugins) {
        SUGAR.App.plugins.register('SugarLogic', 'view', {
            onAttach: function() {
                this.on("init", function(){
                    this.deps = [];
                    var slContext = new SUGAR.expressions.SidecarExpressionContext(this),
                        meta = _.extend({}, this.meta, this.options.meta),
                        relatedFields = [],
                        updateCollection = function(collection, trigger) {
                            trigger.context.inCollection = true;
                            collection.each(function(model) {
                                SUGAR.forms.Trigger.fire.apply(trigger, [model]);
                            });
                            trigger.context.inCollection = null;
                        };

                    _.each(meta.dependencies, function(dep) {
                        var newDep = SUGAR.forms.Dependency.fromMeta(dep, slContext);
                        if (newDep) {
                            relatedFields = _.union(relatedFields, newDep.getRelatedFields());
                            if (this.context.isCreate() || newDep.fireLinkOnlyDependency()) {
                                SUGAR.forms.Trigger.fire.apply(newDep.trigger);
                                this.trigger('sugarlogic:initialize');
                            }
                            //We need to fire onLoad dependencies when a row toggles
                            if (newDep.testOnLoad) {
                                this.context.on("list:editrow:fire", SUGAR.forms.Trigger.fire, newDep.trigger);
                                if (this.collection) {
                                    //For views with collections, we need to trigger onLoad dependencies during sync
                                    //For dependent fields and other actions which work outside of edit.
                                    this.collection.on("sync", function(synced){
                                        if (synced instanceof Backbone.Collection) {
                                            //Use defer to prevent script timeouts on large lists
                                            _.defer(updateCollection, synced, newDep.trigger);
                                        } else {
                                            SUGAR.forms.Trigger.fire.apply(newDep.trigger, [synced]);
                                        }
                                    }, this);
                                }
                            }
                        }
                        this.deps.push(newDep);
                    }, this);
                    slContext._setupLinks(relatedFields);
                    slContext._requestRollups(relatedFields);
                });
           },
            /**
             * Override of the base getFieldNames to ensure that feilds used in dependencies are retrieved
             */
            getFieldNames: function() {
                var getFields = SE.ExpressionParser.prototype.getFieldsFromExpression,
                    fields = Object.getPrototypeOf(this).getFieldNames.apply(this, arguments),
                    meta = _.extend({}, this.meta, this.options.meta);
                _.each(meta.dependencies, function(dep) {
                    if (dep.trigger) {
                        fields = _.union(fields, getFields(dep.trigger));
                    }
                    _.each(dep.actions, function(action) {
                        if (action.params) {
                            _.each(action.params, function(param) {
                                if (_.isString(param)) {
                                    fields = _.union(fields, getFields(param));
                                }
                            });
                        }
                    });
                });
                return fields;
            }
       });
    } else if (console.error) {
        console.error("unable to find the plugin manager");
    }
})();
