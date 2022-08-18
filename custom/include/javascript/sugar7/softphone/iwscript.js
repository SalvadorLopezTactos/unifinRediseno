function networkError(message) {
    log.error(message);
}
function onConnectedSession(message) {
    console.log("onConnectedSession", message);
}
function onDisconnectedSession(message) {
    console.log("onDisconnectedSession", message);
}
function onActivatePureEmbeddableSessionFullPEF(message) {
    console.log("onActivatePureEmbeddableSessionFullPEF", message);
    enableClickToCall();
    listenCallLogsMessages();
    iwscore.handleEvent({ EVENT: "ActivateSession" });
}
function onDeactivateSession(message) {
    console.log("onDeactivateSession", message);
}
//==================================================================
//VOICE Events
//==================================================================
function onEventRingingInbound(message) {
    console.log("onEventRingingInbound, message : ", message);
}
function onEventEstablishedInbound(message) {
    console.log("onEventEstablishedInbound, message : ", message);
    searchContactCreateCall(message, message.ANI.replace("tel:", ""));
    // InboundPopUpANI(message);
}
function onEventEstablishedOutbound(message) {
    console.log("onEventEstablishedInbound, message : ", message);
    InboundPopUpDNIS(message);
}
function onEventDialingOutbound(message) {
}
//==================================================================
//CHAT Events
//==================================================================
function onChatEventRingingInbound(message) {
    console.log("onChatEventRingingInbound", message);
}
function onChatEventEstablishedInbound(message) {
    console.log("onChatEventEstablishedInbound, message : ", message);
    var email = message.EmailAddress || message.attachdata['EmailAddress'] || message.attachdata['context.email'];
    CreateOrPopupEntityEmail(message, "Tasks", email);
}
function onChatEventReleasedInbound(message) {
    console.log("onChatEventReleasedInbound", message);
}
function onChatEventMarkDoneInbound(message) {
    console.log("onChatEventMarkDoneInbound", message);
}
//==================================================================
// SMS Events 
//==================================================================
function onSmsEventEstablishedInbound(message) {
    console.log("onSmsEventEstablishedInbound, message : ", message);
    InboundPopUpANI(message);
}
//==================================================================
// EMAIL Events
//==================================================================
function onEmailEventEstablishedInbound(message) {
    console.log("onEmailEventEstablished, message : ", message);
    CreateOrPopupEntityEmail(message, "Tasks", message.EmailAddress);
}
//==================================================================
//Generic Events 
//==================================================================
function onSwitchInteraction(message) {
    //printAllAttachData(message);
    // InboundPopUpActivity(message, "Tasks");
    log.debugFormat("[onSwitchInteraction] parameters [{0}]", JSON.stringify(message));
    location.href = location.href.split('#')[0] + "#Tasks/" + message.attachdata.activity_id;
}
function onSwitchInteractionInbound(message) {
    onSwitchInteraction(message);
}
function onSwitchInteractionPEF(message) {
    console.log("onSwitchInteractionPEF : ", message);
    log.debugFormat("[onSwitchInteractionPEF] parameters [{0}]", JSON.stringify(message));
    var interaction = iwscore.mapInteractions[message.InteractionID];
    if (interaction && interaction.attachdata) {
        if (interaction.attachdata.contact_id) {
            screenPop("Contacts", message.attachdata.contact_id);
        }
        else if (interaction.attachdata.activity_id) {
            screenPop(message.MediaType == "voice" ? "Calls" : "Tasks", message.attachdata.activity_id);
        }
    }
}
function test() {
    SUGAR.App.api.records("read", "Contacts", {}, {
        "filter[0][$or][0][phone_mobile][$equals]": "+393452607787",
        "filter[0][$or][1][phone_work][$equals]": "+393452607787",
        "fields": "id",
        max_num: 2
    }, { success: function (res) { console.log("**** result from query : ", res); }, error: function (res) { console.log("**** result from query : ", res); } });
}
