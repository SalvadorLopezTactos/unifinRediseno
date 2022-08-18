var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var ChainParameters = /** @class */ (function () {
    function ChainParameters() {
        this.attachData = {};
        this.other = {};
        this.popupEntity = null;
    }
    return ChainParameters;
}());
var Workflow = /** @class */ (function () {
    function Workflow(message) {
        this.message = message;
        this.interaction = new Interaction(message);
        this.parameters = new ChainParameters();
    }
    Workflow.prototype.RunWorkflow = function (actions) {
        var deferred = null;
        log.info("Workflows action length: " + actions.length);
        for (var i = 0; i < actions.length; i++) {
            if (deferred == null) {
                deferred = actions[i].Execute();
            }
            else {
                deferred = deferred.pipe(actions[i].Execute.bind(actions[i]));
            }
        }
    };
    return Workflow;
}());
var Interaction = /** @class */ (function () {
    function Interaction(message) {
        this.Id = message.ConnectionID;
        this.mediaName = message.MediaType;
        this.customerId = message.CustomerID;
    }
    return Interaction;
}());
var SugarEntityBuilder = /** @class */ (function () {
    function SugarEntityBuilder(_context) {
        this._context = _context;
    }
    SugarEntityBuilder.prototype.BuildEntity = function () {
        return null;
    };
    return SugarEntityBuilder;
}());
var SugarEntity = /** @class */ (function () {
    function SugarEntity() {
    }
    return SugarEntity;
}());
var PopupEntity = /** @class */ (function (_super) {
    __extends(PopupEntity, _super);
    function PopupEntity(id, name) {
        var _this = _super.call(this) || this;
        _this.id = id;
        _this.name = name;
        return _this;
    }
    return PopupEntity;
}(SugarEntity));
var SugarCallEntity = /** @class */ (function (_super) {
    __extends(SugarCallEntity, _super);
    function SugarCallEntity() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    return SugarCallEntity;
}(SugarEntity));
var SugarTaskEntity = /** @class */ (function (_super) {
    __extends(SugarTaskEntity, _super);
    function SugarTaskEntity() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    return SugarTaskEntity;
}(SugarEntity));
var SugarAPICallBack = /** @class */ (function () {
    function SugarAPICallBack(entityName, _context, _deferred) {
        this.entityName = entityName;
        this._context = _context;
        this._deferred = _deferred;
    }
    SugarAPICallBack.prototype.success = function (data) {
        this.SuccessCallBack(data);
        this._deferred.resolve(null);
    };
    SugarAPICallBack.prototype.error = function (error) {
        this.ErrorCallBack(error);
        this._deferred.reject(null);
    };
    SugarAPICallBack.prototype.SuccessCallBack = function (data) {
        log.info("SugarAPICallBack success " + data);
    };
    SugarAPICallBack.prototype.ErrorCallBack = function (error) {
        log.error("CallBack Error: " + error);
    };
    return SugarAPICallBack;
}());
var SugarAction = /** @class */ (function () {
    function SugarAction(_context) {
        this._context = _context;
        this._deferred = $.Deferred();
    }
    SugarAction.prototype.Execute = function () {
        var result = this.Run();
        this._deferred.resolve(null);
        return this._deferred;
    };
    SugarAction.prototype.Run = function () {
    };
    return SugarAction;
}());
var SugarCallAPI = /** @class */ (function (_super) {
    __extends(SugarCallAPI, _super);
    function SugarCallAPI(entityName, _context) {
        var _this = _super.call(this, _context) || this;
        _this.entityName = entityName;
        return _this;
    }
    SugarCallAPI.prototype.Execute = function () {
        var _callbacks = this.GetCallBack();
        if (_callbacks != null) {
            this.RunAPI(_callbacks);
        }
        else {
            log.warn("Callback undefined");
        }
        return this._deferred;
    };
    SugarCallAPI.prototype.RunAPI = function (_callbacks) {
    };
    SugarCallAPI.prototype.GetCallBack = function () {
        return null;
    };
    return SugarCallAPI;
}(SugarAction));
var AssociateSugarCallAPI = /** @class */ (function (_super) {
    __extends(AssociateSugarCallAPI, _super);
    function AssociateSugarCallAPI(entityName, _context, relationName) {
        var _this = _super.call(this, entityName, _context) || this;
        _this.relationName = relationName;
        return _this;
    }
    AssociateSugarCallAPI.prototype.RunAPI = function (_callbacks) {
        if (this._context.parameters.attachData.activity_id &&
            this._context.parameters.searchEntities != null && this._context.parameters.searchEntities.length == 1) {
            log.infoFormat("AssociateSugarCallAPI entityName: [{0}]", this.entityName);
            log.infoFormat("AssociateSugarCallAPI entityId: [{0}]", this._context.parameters.attachData.activity_id);
            log.infoFormat("AssociateSugarCallAPI relatedId: [{0}]", this._context.parameters.searchEntities[0].id);
            SUGAR.App.api.relationships("create", this.entityName, { "id": this._context.parameters.attachData.activity_id, "link": this.relationName, "relatedId": this._context.parameters.searchEntities[0].id }, null, _callbacks);
        }
        else {
            log.warn("AssociateSugarCallAPI requires missing arguments");
            this._deferred.resolve(null);
        }
    };
    AssociateSugarCallAPI.prototype.GetCallBack = function () {
        return new SugarAPICallBack(this.entityName, this._context, this._deferred);
    };
    return AssociateSugarCallAPI;
}(SugarCallAPI));
var CreateSugarCallAPI = /** @class */ (function (_super) {
    __extends(CreateSugarCallAPI, _super);
    function CreateSugarCallAPI(entityName, _context, entityBuilder, forcePopup) {
        var _this = _super.call(this, entityName, _context) || this;
        _this.entityBuilder = entityBuilder;
        _this.forcePopup = forcePopup;
        return _this;
    }
    CreateSugarCallAPI.prototype.RunAPI = function (_callbacks) {
        var entity = this.entityBuilder.BuildEntity();
        SUGAR.App.api.records("create", this.entityName, entity, null, _callbacks, null);
    };
    CreateSugarCallAPI.prototype.GetCallBack = function () {
        return new CreateEntityCallBack(this.entityName, this._context, this._deferred, this.forcePopup);
    };
    return CreateSugarCallAPI;
}(SugarCallAPI));
var UpdateSugarCallAPI = /** @class */ (function (_super) {
    __extends(UpdateSugarCallAPI, _super);
    function UpdateSugarCallAPI(entityName, _context, entityBuilder) {
        var _this = _super.call(this, entityName, _context) || this;
        _this.entityBuilder = entityBuilder;
        return _this;
    }
    UpdateSugarCallAPI.prototype.RunAPI = function (_callbacks) {
        var entity = this.entityBuilder.BuildEntity();
        SUGAR.App.api.records("update", this.entityName, entity, null, _callbacks, null);
    };
    UpdateSugarCallAPI.prototype.GetCallBack = function () {
        return new SugarAPICallBack(this.entityName, this._context, this._deferred);
    };
    return UpdateSugarCallAPI;
}(SugarCallAPI));
var SearchSugarCallAPI = /** @class */ (function (_super) {
    __extends(SearchSugarCallAPI, _super);
    function SearchSugarCallAPI(entityName, _context, filter, attachDataNameField, setPopup) {
        var _this = _super.call(this, entityName, _context) || this;
        _this.filter = filter;
        _this.attachDataNameField = attachDataNameField;
        _this.setPopup = setPopup;
        return _this;
    }
    SearchSugarCallAPI.prototype.RunAPI = function (_callbacks) {
        SUGAR.App.api.records("read", this.entityName, {}, this.filter, _callbacks);
    };
    SearchSugarCallAPI.prototype.GetCallBack = function () {
        return new SearchOnlyOneEntityCallBack(this.entityName, this._context, this._deferred, this.attachDataNameField, this.setPopup);
    };
    return SearchSugarCallAPI;
}(SugarCallAPI));
var Popup = /** @class */ (function (_super) {
    __extends(Popup, _super);
    function Popup(_context) {
        return _super.call(this, _context) || this;
    }
    Popup.prototype.Run = function () {
        log.info("Call Popup ...");
        if (this._context.parameters.popupEntity) {
            SUGAR.App.router.navigate("#" + this._context.parameters.popupEntity.name + "/" + this._context.parameters.popupEntity.id, { trigger: true });
        }
        else {
            log.warn("Popup entity not found in workflow paramters!");
        }
    };
    return Popup;
}(SugarAction));
var AttachData = /** @class */ (function (_super) {
    __extends(AttachData, _super);
    function AttachData(_context) {
        return _super.call(this, _context) || this;
    }
    AttachData.prototype.Run = function () {
        log.debug("AttachData start...");
        if (!this._context.parameters.attachData) {
            log.warn("impossible to set attachdata, the value is null ");
            return;
        }
        log.debug("switching integration type : " + iwscore.getConnectorConfig().integrationType);
        var myCollection = iwscore.createUserData();
        if (this._context.parameters.attachData) {
            for (var field in this._context.parameters.attachData) {
                log.debugFormat("[AttachData] field:{0} - value:{1}", field, this._context.parameters.attachData[field]);
                myCollection.put(field, this._context.parameters.attachData[field]);
            }
            if (myCollection.isEmpty()) {
                log.debug("No parameter to attach, returning..");
                return;
            }
        }
        switch (iwscore.getConnectorConfig().integrationType) {
            case "pure-integration":
            case "pure-embeddable":
                iwscommand.SetAttachdataById(this._context.interaction.Id, myCollection);
                for (var p in this._context.parameters.attachData) {
                    this._context.message.attachdata[p] = this._context.parameters.attachData[p];
                }
                console.log("adding json object in memory : ", this._context.message);
                iwscore.addJSONObjectInMemory(this._context.message);
                break;
            default:
                iwscommand.SetAttachdataById(this._context.interaction.Id, myCollection);
                break;
        }
    };
    return AttachData;
}(SugarAction));
var SugarTaskBuilder = /** @class */ (function (_super) {
    __extends(SugarTaskBuilder, _super);
    function SugarTaskBuilder(_context) {
        return _super.call(this, _context) || this;
    }
    SugarTaskBuilder.prototype.BuildEntity = function () {
        log.info("Call SugarTaskBuilder...");
        console.log("this.context : ", this._context);
        var taskData = new SugarCallEntity();
        taskData.name = this._context.interaction.mediaName + " - " + this._context.message.CallType + " - " + this._context.interaction.Id;
        taskData.date_start = new Date().toISOString();
        taskData.iws_interactionid_c = this._context.interaction.Id;
        taskData.iws_medianame_c = this._context.interaction.mediaName;
        taskData.assigned_user_id = SUGAR.App.user.get('id');
        return taskData;
    };
    return SugarTaskBuilder;
}(SugarEntityBuilder));
var SugarCallsBuilder = /** @class */ (function (_super) {
    __extends(SugarCallsBuilder, _super);
    function SugarCallsBuilder(_context) {
        return _super.call(this, _context) || this;
    }
    SugarCallsBuilder.prototype.BuildEntity = function () {
        log.info("Call SugarCallsBuilder...");
        var callData = new SugarCallEntity();
        callData.name = this._context.interaction.mediaName + " - " + this._context.message.CallType + " - " + this._context.interaction.Id;
        callData.date_start = new Date().toISOString();
        callData.duration_minutes = 0;
        switch (this._context.message.CallType) {
            case "Inbound":
            case "Outbound":
                callData.direction = this._context.message.CallType;
                break;
            default:
                callData.direction = "";
                break;
        }
        callData.iws_interactionid_c = this._context.interaction.Id;
        callData.iws_medianame_c = this._context.interaction.mediaName;
        callData.assigned_user_id = SUGAR.App.user.get('id');
        if (this._context.parameters.searchEntities != null && this._context.parameters.searchEntities.length == 1) {
            callData.parent_type = this._context.parameters.searchEntities[0].name;
            callData.parent_id = this._context.parameters.searchEntities[0].id;
        }
        else if (this._context.parameters.attachData.contact_id) {
            callData.parent_type = "Contacts";
            callData.parent_id = this._context.parameters.attachData.contact_id;
        }
        return callData;
    };
    return SugarCallsBuilder;
}(SugarEntityBuilder));
var UpdateSugarCallsBuilder = /** @class */ (function (_super) {
    __extends(UpdateSugarCallsBuilder, _super);
    function UpdateSugarCallsBuilder(_context) {
        return _super.call(this, _context) || this;
    }
    UpdateSugarCallsBuilder.prototype.BuildEntity = function () {
        log.info("Call UpdateSugarCallsBuilder...");
        var callData = new SugarCallEntity();
        if (!this._context.parameters.attachData.activity_id)
            throw new Error("[UpdateSugarCallsBuilder] activity_id is undefined into attachdata values");
        callData.id = this._context.parameters.attachData.activity_id;
        return callData;
    };
    return UpdateSugarCallsBuilder;
}(SugarEntityBuilder));
var CreateEntityCallBack = /** @class */ (function (_super) {
    __extends(CreateEntityCallBack, _super);
    function CreateEntityCallBack(entityName, _context, _deferred, forcePopup) {
        var _this = _super.call(this, entityName, _context, _deferred) || this;
        _this.forcePopup = forcePopup;
        return _this;
    }
    CreateEntityCallBack.prototype.SuccessCallBack = function (data) {
        log.info("Entity created with success");
        this._context.parameters.attachData.activity_id = data.id;
        if (this._context.parameters.popupEntity == null || this.forcePopup)
            this._context.parameters.popupEntity = new PopupEntity(data.id, this.entityName);
    };
    return CreateEntityCallBack;
}(SugarAPICallBack));
var SearchOnlyOneEntityCallBack = /** @class */ (function (_super) {
    __extends(SearchOnlyOneEntityCallBack, _super);
    function SearchOnlyOneEntityCallBack(entityName, _context, _deferred, attachDataFieldName, setPopup) {
        var _this = _super.call(this, entityName, _context, _deferred) || this;
        _this.entityName = entityName;
        _this.attachDataFieldName = attachDataFieldName;
        _this.setPopup = setPopup;
        return _this;
    }
    SearchOnlyOneEntityCallBack.prototype.SuccessCallBack = function (data) {
        log.info("SearchOnlyOneEntityCallBack success:" + JSON.stringify(data));
        log.info(this.entityName + " found:" + data.records.length);
        if (data.records.length == 1) {
            var entityId = data.records[0].id;
            this._context.parameters.searchEntities = new Array();
            var popupEntity = new PopupEntity(entityId, this.entityName);
            this._context.parameters.searchEntities.push(popupEntity);
            if (this.attachDataFieldName != null)
                this._context.parameters.attachData[this.attachDataFieldName] = entityId;
            if (this.setPopup)
                this._context.parameters.popupEntity = popupEntity;
        }
    };
    return SearchOnlyOneEntityCallBack;
}(SugarAPICallBack));
