//var firstInteractionIdSelected = null;
function onPreChannelStatus(message) {
    iwscore.setIwsInitData(message);
}
function onPreConnectedSession(message) {
    if (message.IwsApplicationName) {
        iwscore.setIwsApplicationName(message.IwsApplicationName);
    }
    iwscore.setIwsInitData(message);
    iwscore.showConnectedState();
}
function onPreDisconnectedSession(message) {
    iwscore.showDisconnectedState();
}
function onPostDisconnectedSession(message) {
}
function onPreActivatePureEmbeddableSession(message) {
    var _params = iwscore.getConnectorConfig();
    if (_params.integrationType === "pure-embeddable" && message.token) {
        iwscore.initPureCloud(message.token);
    }
}
function onPreActivatePureEmbeddableSessionFullPEF(message) {
    if (message.token) {
        iwscore.getConnectorConfig().auth.token = message.token;
        localStorage.setItem("pureCloudToken", message.token);
        pClient = new PureClientSdk();
        pClient.client.setEnvironment(iwscore.getConnectorConfig().auth.environment);
        pClient.client.setAccessToken(message.token);
    }
}
function onPreRequestConfigurationPureEmbeddable(message) {
    var _params = iwscore.getConnectorConfig();
    if (_params.integrationType === "pure-embeddable") {
        iwscore.sendPureEmbeddableConfiguration();
    }
}
function onPreActivateSession(message) {
    var _params = iwscore.getConnectorConfig();
    if (_params.integrationType === "pure-embeddable" && message.token) {
        iwscore.initPureCloud(message.token);
        return;
    }
    iwscore.showActivedState();
    //load combo interactions
    if (message.interactions) {
        var i;
        log.debugFormat("[onPreActivateSession] received [{0}] interaction", message.interactions.length);
        //addEmptyOption() removeEmptyOption()
        //if((!isMultyInteractions()) && (isEnablePlaceHolder()))
        //	addEmptyOption();
        if (iwscore.isEnablePlaceHolder())
            iwscore.addEmptyOption();
        for (i = 0; i < message.interactions.length; i++) {
            if ((message.interactions[i].State == 8)
                ||
                    (message.interactions[i].State == 1)
                ||
                    (message.interactions[i].State == 2))
                continue;
            log.debug("[onPreActivateSession] Check if the interaction is a Campaign");
            if (iwscore.isCampaign(message.interactions[i])) {
                log.debug("[onPreActivateSession] The interaction is a Campaign");
                if (iwscore.isEnablePlaceHolder())
                    iwscore.addJSONObjectInMemoryCampaign(message.interactions[i], iwscore.isEnablePlaceHolderInteraction(message.interactions[i]));
                else
                    iwscore.addJSONObjectInMemoryCampaign(message.interactions[i], false);
            }
            else {
                log.debug("[onPreActivateSession] The interaction not is a Campaign");
                //if(isMultyInteractions())
                //	addJSONObjectInMemory(message.interactions[i]);
                //related the attach-data
                if (iwscore.isEnablePlaceHolder())
                    iwscore.addJSONObjectInMemory(message.interactions[i], iwscore.isEnablePlaceHolderInteraction(message.interactions[i]));
                else
                    iwscore.addJSONObjectInMemory(message.interactions[i], false);
            }
            //message.interactions[i].State == 5 means released
        }
        //if((!isMultyInteractions()) && (isEnablePlaceHolder()))
        if (iwscore.isEnablePlaceHolder())
            iwscore.removeEmptyOption();
        if (iwscore.countInteractions() > 0) {
            iwscore.removeDefaultOption();
        }
        return;
    }
    if (message.activeInteractions) {
        message.activeInteractions.forEach(function (i) { return iwscore.addJSONObjectInMemory(i); });
    }
    /*pClient["conversationApi"].getConversations().then(function(data){
            window["InteractionBarUI"] = new interactionbar(data.entities, firstInteractionIdSelected);
        }
    );*/
}
function onPreDeactivateSession(message) {
    iwscore.showConnectedState();
}
/*
function onSynchInteractions(message)
{
    for(var key in mapInteractions)
    {
        log.debugFormat("[onSynchInteractions] Check [{0}] in IWS", key);
        if(!message.interactions[key])
        {
            log.warnFormat("[onSynchInteractions] Remove [{0}]", key);
            removeJSONObjectInMemory(key);
        }
        else
        {
            log.debugFormat("[onSynchInteractions] Valid [{0}]", key);
        }
    }
}
*/
/**
 * get the id from DelegateCommand
 * @param message
 * @returns {String}
 */
function getIdFromDelegateCommand(message) {
    var id = "";
    try {
        var sapp = message.Parameters.CommandParameter;
        var n = sapp.indexOf("/");
        id = sapp.substring(n + 1).slice(0, -1);
    }
    catch (e) {
        log.warn("getIdFromDelegateCommand: " + e.message);
    }
    log.debugFormat("[getIdFromDelegateCommand] id[{0}]", id);
    return id;
}
function onPreDelegateCommand(message) {
    try {
        var id = iwscore.getMessageId(message);
        if (id) {
            log.debugFormat("[onPreDelegateCommand] with ConnectionID [{0}]", id);
        }
        else {
            id = getIdFromDelegateCommand(message);
            if (id) {
                log.debugFormat("[onPreDelegateCommand] with ConnectionID [{0}]", id);
                message.ConnectionID = id;
                message.InteractionID = id;
            }
        }
    }
    catch (e) {
        log.warn("[onPreDelegateCommand]: " + e.message);
    }
}
function onPreEventAgentReady(message) {
}
function onPreEventEstablishedInternal(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEventEstablishedConsult(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEventReleasedInbound(message) {
    //removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPostEventReleasedConsult(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEventReleasedInternal(message) {
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
    //removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEventPartyChangedInbound(message) {
    //release the consult...
    //PreviousConnID
    //add the new Inbound
    iwscore.removeJSONObjectInMemory(message.PreviousConnID);
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEventPartyChangedInternal(message) {
    iwscore.removeJSONObjectInMemory(message.PreviousConnID);
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEventPartyChangedOutbound(message) {
    iwscore.removeJSONObjectInMemory(message.PreviousConnID);
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEventEstablishedOutbound(message) {
    if (iwscore.isCampaign(message)) {
        iwscore.addJSONObjectInMemoryCampaign(message, undefined);
        if (iwscore.isEnablePlaceHolder() && iwscore.isSelectedInteraction(message)) {
            iwscommand.SetInteractionOnWde(message.ConnectionID);
        }
    }
    else
        iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEventReleasedOutbound(message) {
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPreEventMarkDoneInbound(message) {
    /*
    //EventPartyChanged
    log.debugFormat("onPreEventMarkDoneInbound State [{0}] Name[{1}]", message.State, message.Name);
    if(message.Name != "EventReleased")
        return false;
        */
}
function onPostEventMarkDoneInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEventMarkDoneInternal(message) {
}
function onPostEventMarkDoneInternal(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEventMarkDoneConsult(message) {
}
function onPostEventMarkDoneConsult(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEventMarkDoneOutbound(message) {
}
function onPostEventMarkDoneOutbound(message) {
    if (!iwscore.isCampaign(message)) {
        iwscore.removeJSONObjectInMemory(message.ConnectionID);
    }
    else {
        var recordhandle = "" + iwscore.getRecordHandle(message);
        iwscore.removeJSONObjectInMemory(recordhandle);
    }
}
//==============================================
// Chat Section 
//==============================================
function onPreChatEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreChatEventReleasedInbound(message) {
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPostChatEventMarkDoneInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
//==============================================
//Workitem Section 
//==============================================
function onPreWorkitemEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreWorkitemEventOpenedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreWorkitemEventReleasedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
//Added in release 1.5.0.0
function onPostWorkitemEventRevokedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
//==============================================
//Email Section 
//==============================================
function onPreEmailEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEmailEventReleasedInbound(message) {
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPostEmailEventReleasedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEmailEventEstablishedOutbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPostEmailEventReleasedOutbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEmailEventOpenedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEmailEventReplyEstablishedOutbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEmailEventReplyEstablished(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEmailEventReplyReleasedOutbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEmailEventReplyReleased(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPreEmailEventReplyCancelled(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreEmailEventReplyOpened(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreEmailEventReplyOpenedOutbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
//==============================================
// Workbin Section 
//==============================================
function onPreWorkbinPlacedIn(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreWorkbinTakenOut(message) {
}
//==============================================
//SMS Section 
//==============================================
function onPreSMSEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreSMSEventReleasedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPreSMSEventEstablishedOutbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreSMSEventReleasedOutbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
//==============================================
//SMS Section 
//==============================================
function onPreSmsEventEstablished(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreSmsEventReleased(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPreSmsEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreSmsEventReleasedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPreSmsEventEstablishedOutbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreSmsEventReleasedOutbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
//==============================================
//Webmessaging Section 
//==============================================
function onPreWebmessagingEventEstablished(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPostWebmessagingEventReleased(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPreWebmessagingEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPostWebmessagingEventReleasedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
//==================================================================
//Events UserEvent
//==================================================================
function onPreEventUserEvent(message) {
    try {
        var eventname = message.attachdata.GSW_USER_EVENT;
        log.debugFormat("onPreEventUserEvent: the event is {0}", eventname);
        iwscore.callSafetyFunction("onPre" + eventname + "(message);", message);
        if (iwscore.checkFunction("on" + eventname)) {
            iwscore.callSafetyFunction("on" + eventname + "(message);", message);
            //return false;
        }
    }
    catch (e) {
        log.error("onPreEventUserEvent: " + e.message);
    }
    return true;
}
function onPostEventUserEvent(message) {
    try {
        var eventname = message.attachdata.GSW_USER_EVENT;
        log.debugFormat("onPostEventUserEvent: the event is {0}", eventname);
        iwscore.callSafetyFunction("onPost" + eventname + "(message);", message);
    }
    catch (e) {
        log.error("onPostEventUserEvent: " + e.message);
    }
    return true;
}
function onPrePreviewRecord(message) {
    log.debug("======= onPrePreviewRecord ==========");
    iwscore.addJSONObjectInMemoryCampaign(message, undefined); //false);
}
function onPreRecordProcessedAcknowledge(message) {
    log.debug("======= onPreRecordProcessedAcknowledge ==========");
    //var recordhandle = "" + getRecordHandle(message);
    //removeJSONObjectInMemory(recordhandle);	
}
function onPostRecordProcessedAcknowledge(message) {
    log.debug("======= onPostRecordProcessedAcknowledge ==========");
    var recordhandle = "" + iwscore.getRecordHandle(message);
    iwscore.removeJSONObjectInMemory(recordhandle);
}
function onPreRecordRejectAcknowledge(message) {
    log.debug("======= onPreRecordRejectAcknowledge ==========");
    var recordhandle = "" + iwscore.getRecordHandle(message);
    iwscore.removeJSONObjectInMemory(recordhandle);
}
function onPreRecordCancelAcknowledge(message) {
    log.debug("======= onPreRecordCancelAcknowledge ==========");
    var recordhandle = "" + iwscore.getRecordHandle(message);
    iwscore.removeJSONObjectInMemory(recordhandle);
}
function onPreScheduledCall(message) {
    log.debug("======= onPreScheduledCall ==========");
    iwscore.addJSONObjectInMemoryCampaign(message, undefined); //false);
}
function onPreChainedRecordsDataEnd(message) {
    log.debug("======= onPreChainedRecordsDataEnd ==========");
    iwscore.addJSONObjectInMemoryCampaign(message, undefined); //false);
}
//==================================================================
// PushPreview
//==================================================================
function onPreOutboundpreviewEventEstablished(message) {
    log.debug("======= onPreOutboundpreviewEventEstablished ==========");
    iwscore.addJSONObjectInMemoryCampaign(message, undefined); //false);
}
function onPreOutboundpreviewEventEstablishedInternal(message) {
    log.debug("======= onPreOutboundpreviewEventEstablishedInternal ==========");
    iwscore.addJSONObjectInMemoryCampaign(message, undefined); //false);
}
function onPostOutboundpreviewEventReleasedInternal(message) {
    onPostOutboundpreviewEventReleased(message);
}
function onPostOutboundpreviewEventReleased(message) {
    log.debug("======= onPostOutboundpreviewEventReleased ==========");
    var recordhandle = "" + iwscore.getRecordHandle(message);
    iwscore.removeJSONObjectInMemory(recordhandle);
}
//==================================================================
//Events Twitter
//==================================================================
function onPreTwitterEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPreTwitterEventReleasedInbound(message) {
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPostTwitterEventReleasedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreTwitterEventReplyOutbound(message) {
    /*
    onTwitterEventReplyOutbound
    onTwitterEventRetweetOutbound
    onTwitterEventRetweetWithCommentsOutbound
    onTwitterEventDirectMessageOutbound
    */
    try {
        var msgType = message.attachdata._twitterMsgType;
        log.debug("onPreTwitterEventReplyOutbound with " + msgType);
        if ((msgType === "Retweet") || (msgType === "DirectMessage")) {
            log.debug("onPreTwitterEventReplyOutbound with " + msgType);
            var myevent = "TwitterEvent{0}Outbound".format(msgType);
            log.debugFormat("onPreTwitterEventReply: the new event is on{0}", myevent);
            iwscore.callSafetyFunction("onPre" + myevent + "(message);", message);
            if (iwscore.checkFunction("on" + myevent)) {
                iwscore.callSafetyFunction("on" + myevent + "(message);", message);
            }
            return false;
        }
    }
    catch (e) {
        log.error("onPreTwitterEventReply: " + e.message);
    }
    return true;
}
//==================================================================
//Events Facebook
//==================================================================
function onPreFacebookEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPostFacebookEventReleasedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreFacebookEventReleasedInbound(message) {
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
function onPreFacebookEventEstablished(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPostFacebookEventReleased(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
function onPreFacebookEventReleased(message) {
    window.dispatchEvent(new CustomEvent(enumCustomEventType.ConnectorInteractionReleased, { detail: message }));
}
//==================================================================
//Generic Events
//==================================================================
function onPreWdeSwitchInteraction(message) {
    var mymessage = iwscore.getInteraction(message.InteractionID);
    if (mymessage) {
        var curr_message = iwscore.getSelectedInteraction();
        if (curr_message) {
            log.infoFormat("[onPreWdeSwitchInteraction] Selected Interaction [{0}] Switch Interaction[{1}] ======================", curr_message.InteractionID, mymessage.InteractionID);
            if (curr_message.InteractionID != mymessage.InteractionID) {
                iwscore.selectInteractionOptionByMessage(mymessage);
            }
        }
    }
}
function onPreSwitchInteractionPEF(message) {
    onPreWdeSwitchInteraction(message);
}
function onPreWebformEventEstablishedInbound(message) {
    iwscore.addJSONObjectInMemory(message, undefined);
}
function onPostWebformEventReleasedInbound(message) {
    iwscore.removeJSONObjectInMemory(message.ConnectionID);
}
/*function onPreSwitchInteractionPEF(message)
{
    if (window["InteractionBarUI"])
    {
        window["InteractionBarUI"].selectInteractionById(message.InteractionID);
    } else
    {
        firstInteractionIdSelected = message.InteractionID;
    }
}*/
//alert("iwsprescript well formed!");
