var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var __spreadArray = (this && this.__spreadArray) || function (to, from, pack) {
    if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
            if (!ar) ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
        }
    }
    return to.concat(ar || Array.prototype.slice.call(from));
};
function CreateOrPopupEntityPure(message, entity) {
    console.log("CreateOrPopupEntityPure phoneNumber", message.attachdata['context.phoneNumber']);
    var searchFilter = {
        "filter[0][$or][0][phone_mobile][$equals]": message.attachdata['context.phoneNumber'],
        "filter[0][$or][1][phone_work][$equals]": message.attachdata['context.phoneNumber'],
        "fields": "id",
        max_num: 2
    };
    CreateOrPopupEntity(message, entity, searchFilter);
}
function CreateOrPopupEntityWde(message, entity) {
    var searchFilter = {
        "filter[0][$or][0][email][$equals]": message.attachdata['EmailAddress'],
        "fields": "id",
        max_num: 2
    };
    CreateOrPopupEntity(message, entity, searchFilter);
}
function CreateOrPopupEntityEmail(message, entity, email) {
    var searchFilter = {
        "filter[0][$or][0][email][$equals]": email,
        "fields": "id",
        max_num: 2
    };
    CreateOrPopupEntity(message, entity, searchFilter);
}
function CreateOrPopupEntity(message, entity, searchFilter) {
    log.info("calling CreateEntity");
    if (message.attachdata && message.attachdata['activity_id']) {
        InboundPopUpActivity(message, entity);
        return;
    }
    var field = message.Service == "PureCloud" ? "phone_mobile" : "email";
    var value = message.Service == "PureCloud" ? message.attachdata['context.phoneNumber'] : message.attachdata['EmailAddress'];
    var mediaInboundWorkflow = new Workflow(message);
    var entityBuilder;
    switch (entity) {
        case "Calls":
            entityBuilder = new SugarCallsBuilder(mediaInboundWorkflow);
            break;
        case "Tasks":
            entityBuilder = new SugarTaskBuilder(mediaInboundWorkflow);
            break;
        default:
            console.log("Error in CreateOrPopupEntity, entity " + entity + " not recognized");
            break;
    }
    var search = new SearchSugarCallAPI("Contacts", mediaInboundWorkflow, searchFilter, "contact_id", true);
    var create = new CreateSugarCallAPI(entity, mediaInboundWorkflow, entityBuilder, false);
    var associate = new AssociateSugarCallAPI(entity, mediaInboundWorkflow, "contacts");
    var attach = new AttachData(mediaInboundWorkflow);
    var popup = new Popup(mediaInboundWorkflow);
    mediaInboundWorkflow.RunWorkflow([search, create, associate, attach, popup]);
}
function MediaInboundPureCloud(message) {
    log.info("calling MediaInboundPureCloud");
    var mediaInboundWorkflow = new Workflow(message);
    var searchFilter = {
        "filter[0][$or][0][phone_mobile][$equals]": message.attachdata['context.phoneNumber'],
        "fields": "id",
        max_num: 2
    };
    console.log("searchFilter=", searchFilter);
    var search = new SearchSugarCallAPI("Contacts", mediaInboundWorkflow, searchFilter, "contact_id", true);
    var create = new CreateSugarCallAPI("Tasks", mediaInboundWorkflow, new SugarTaskBuilder(mediaInboundWorkflow), false);
    var associate = new AssociateSugarCallAPI("Tasks", mediaInboundWorkflow, "contacts");
    var attach = new AttachData(mediaInboundWorkflow);
    var popup = new Popup(mediaInboundWorkflow);
    mediaInboundWorkflow.RunWorkflow([search, create, associate, attach, popup]);
}
function InboundPopUpANI(message) {
    log.info("calling InboundPopUpANI updated");
    message.ANI = message.ANI.replace("tel:", "");
    console.log("ANI = " + message.ANI);
    var voiceInboundWorkflow = new Workflow(message);
    var searchFilter = {
        "filter": [
            {
                "$or": [
                    {
                        "phone_mobile": message.ANI
                    },
                    {
                        "phone_work": message.ANI
                    }
                ]
            }
        ]
    };
    var search = new SearchSugarCallAPI("Contacts", voiceInboundWorkflow, searchFilter, "contact_id", true);
    var create = new CreateSugarCallAPI("Calls", voiceInboundWorkflow, new SugarCallsBuilder(voiceInboundWorkflow), false);
    var attach = new AttachData(voiceInboundWorkflow);
    var popup = new Popup(voiceInboundWorkflow);
    voiceInboundWorkflow.RunWorkflow([search, create, attach, popup]);
    iwscore.addJSONObjectInMemory(message);
}
function searchContactCreateCall(message, contactId) {
    var searchFilter = {
        "filter": [
            {
                "$or": [
                    {
                        "phone_mobile": contactId
                    },
                    {
                        "phone_work": contactId
                    }
                ]
            }
        ]
    };
    SUGAR.App.api.records("read", "Contacts", {}, searchFilter, {
        success: function (res) {
            console.log("**** result success from query : ", res);
            var id;
            if (res && res.records && res.records.length == 1) {
                id = res.records[0].id;
                console.log("contactId : ", id);
            }
            else if (res && res.records && res.records.length > 1) {
                res.records.forEach(function (c) {
                    iwscommand.addAssociationPEF("contact", c.id, c.full_name, false, message.InteractionID);
                });
                iwscommand.executePEFGenericAction(["PureCloud", "User"], "setView", {
                    type: "main",
                    view: { name: "callLog" }
                });
            }
            createCallAndScreenpop(message, id);
        },
        error: function (res) { console.log("**** result error from query : ", res); }
    });
}
function createCallAndScreenpop(message, contactId) {
    var call = {};
    call.duration_minutes = 0;
    if (contactId) {
        call.parent_type = "Contacts";
        call.parent_id = contactId;
    }
    call.name = "".concat(message.MediaType, " - ").concat(message.CallType, " - ").concat(message.InteractionID);
    call.date_start = new Date().toISOString();
    call.iws_interactionid_c = message.InteractionID;
    call.iws_medianame_c = message.MediaType;
    call.assigned_user_id = SUGAR.App.user.get('id');
    SUGAR.App.api.records("create", "Calls", call, null, {
        success: function (res) {
            console.log("**** result success from create : ", res);
            if (res && res.id) {
                var entity = contactId ? "Contacts" : "Calls";
                var id = contactId || res.id;
                var params = { sugar_id: res.id };
                if (contactId) {
                    params.contact_id = contactId;
                }
                iwscommand.SetAttachdataById(message.InteractionID, params);
                message.attachdata = Object.assign(message.attachdata, params);
                iwscore.addJSONObjectInMemory(message);
                screenPop(entity, id);
            }
        },
        error: function (res) { console.log("**** result error from query : ", res); }
    }, null);
}
function screenPop(entityName, id) {
    SUGAR.App.router.navigate("#".concat(entityName, "/").concat(id), { trigger: true });
}
function listenCallLogsMessages() {
    var _this = this;
    window.addEventListener("message", function (event) { return __awaiter(_this, void 0, void 0, function () {
        return __generator(this, function (_a) {
            if (event.data.type == "softphone_connector" && event.data.msg && event.data.msg.type == 'openCallLog') {
                console.log("[softphone] openCallLog event: " + JSON.stringify(event.data.msg));
                this.performCallLogAssociation(event.data.msg.callLog);
            }
            return [2 /*return*/];
        });
    }); });
}
function performCallLogAssociation(callLog) {
    {
        console.log("[softphone] [PerformCallLogAssociation] calling ...");
        if (callLog.attributes && callLog.selectedContact && callLog.selectedContact.id) {
            if (callLog.attributes.sugar_id) {
                updateObject("Calls", callLog.selectedContact.id, {
                    id: callLog.attributes.sugar_id,
                    parent_type: "Contacts",
                    parent_id: callLog.selectedContact.id
                });
            }
        }
    }
}
function updateObject(entity, idToScreenPop, obj) {
    SUGAR.App.api.records("update", entity, obj, null, {
        success: function (res) {
            console.log("**** result success from update : ", res);
            screenPop("Contacts", idToScreenPop);
        },
        error: function (res) { console.log("**** result error from query : ", res); }
    }, null);
}
function callApiSync(api) {
    var params = [];
    for (var _i = 1; _i < arguments.length; _i++) {
        params[_i - 1] = arguments[_i];
    }
    return $.Deferred(function (dfrd) {
        if (params) {
            api.apply(void 0, __spreadArray(__spreadArray([], params, false), [dfrd.resolve], false));
        }
        else {
            api(dfrd.resolve);
        }
    }).promise();
}
function InboundPopUpDNIS(message) {
    log.info("calling InboundPopUpDNIS updated");
    message.DNIS = message.DNIS.replace("tel:", "");
    console.log("DNIS = " + message.DNIS);
    var voiceInboundWorkflow = new Workflow(message);
    var searchFilter = {
        "filter": [
            {
                "$or": [
                    {
                        "phone_mobile": message.DNIS
                    },
                    {
                        "phone_work": message.DNIS
                    }
                ]
            }
        ]
    };
    var search = new SearchSugarCallAPI("Contacts", voiceInboundWorkflow, searchFilter, "contact_id", true);
    var create = new CreateSugarCallAPI("Calls", voiceInboundWorkflow, new SugarCallsBuilder(voiceInboundWorkflow), false);
    var attach = new AttachData(voiceInboundWorkflow);
    var popup = new Popup(voiceInboundWorkflow);
    voiceInboundWorkflow.RunWorkflow([search, create, attach, popup]);
    iwscore.addJSONObjectInMemory(message);
}
function InboundContactPopUpContactId(message) {
    log.info("calling InboundContactPopUpContactId");
    var voiceInboundWorkflow = new Workflow(message);
    voiceInboundWorkflow.parameters.popupEntity = new PopupEntity(this.message.attachdata.contact_id, "Contacts");
    var create = new CreateSugarCallAPI("Calls", voiceInboundWorkflow, new SugarCallsBuilder(voiceInboundWorkflow), false);
    var attach = new AttachData(voiceInboundWorkflow);
    var popup = new Popup(voiceInboundWorkflow);
    voiceInboundWorkflow.RunWorkflow([create, attach, popup]);
}
function InboundPopUpActivity(message, entity) {
    log.info("calling InboundPopUpActivity");
    var voiceInboundWorkflow = new Workflow(message);
    voiceInboundWorkflow.parameters.popupEntity = new PopupEntity(message.attachdata['activity_id'], entity);
    var popup = new Popup(voiceInboundWorkflow);
    voiceInboundWorkflow.RunWorkflow([popup]);
}
function enableClickToCall() {
    window.addEventListener("click", function (event) {
        console.log("click");
        if (event.target.href && event.target.href.indexOf("callto:") >= 0) {
            event.preventDefault();
            onClickToCall(event.target.innerText);
        }
    });
}
/**
*
*/
function onClickToCall(phoneNumber) {
    console.log("onClickToCall ", phoneNumber);
    if (phoneNumber) {
        if (iwscore.getConnectorConfig().integrationType == "pure-embeddable") {
            var call = {
                number: phoneNumber,
                type: "call",
                queueId: "",
                autoPlace: true
            };
            iwscommand.clickToDialPEF(call);
        }
        else {
            iwscommand.MakeCall(phoneNumber, undefined);
        }
    }
}
/**
* Validation example
*/
function isValidPhoneNumber(text) {
    var res = false;
    var myNumber = text;
    if (myNumber) {
        //remove all characters...
        //myNumber = myNumber.replace(/[^0-9]/g, '');
        //remove all spaces...
        myNumber = myNumber.replace(/\s\s+/g, ' ');
        //standard Phone number validation "+(320)299-4038"
        var patt = new RegExp("^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}");
        res = patt.test(myNumber);
    }
    log.debugFormat("isValidPhoneNumber [{0}] = [{1}]", myNumber, res);
    return res ? myNumber : undefined;
}
