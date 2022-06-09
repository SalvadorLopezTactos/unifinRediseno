var softphonePackageLocked = false;
SUGAR.App.events.on('app:init', function () {
    console.log("softphone sugar connector init");
});
SUGAR.App.events.on('app:logout', function () {
    console.log("logout, removing connector");
    $("#IWSConnectorToolbar").remove();
});
SUGAR.App.events.on('app:sync:complete', function () {
    console.log("Softphone CTI Connector initialization .....");
    var userAcl = SUGAR.App.user.getAcls()["Soft_WDEScript"];
    if (!userAcl || (userAcl["access"] && userAcl["access"] == "no") || (userAcl["view"] && userAcl["view"] == "no")) {
        console.log("User doesn't have the right permission to view CTI Connector");
        return;
    }
    if (!softphonePackageLocked) {
        SUGAR.App.api.records("read", "Soft_WDEScript", {}, { "fields": "name,scriptcontent", max_num: 3 }, {
            success: function (result) {
                console.log("success called...");
                if (result.records.length == 0) {
                    console.log("Unable to find Soft_WDEScript records.");
                    return;
                }
                loadStaticResources(function () {
                    for (var i = 0; i < result.records.length; i++) {
                        var scriptContent = result.records[i].scriptcontent;
                        //	console.log(scriptContent);
                        var script = document.createElement("script");
                        script.innerHTML = scriptContent;
                        document.head.appendChild(script);
                    }
                });
            },
            error: function (err) { console.log("error called...", err); }
        }, {});
    }
    else {
        loadStaticResources(function () {
            console.log("script loaded");
        });
    }
});
function loadStaticResources(callback) {
    $("body").children().first()
        .after("<div id='IWSConnectorToolbar' name='IWSConnectorToolbar'></div>");
    $('body').append('<style>#IWSConnectorToolbar{@import url(https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css);}</style>');
    $('#IWSConnectorToolbar').append('<style scoped>@import url(https://fonts.googleapis.com/icon?family=Material+Icons);</style>');
    var jsResources = [
        "custom/include/javascript/sugar7/softphone/softphone-connector-core.min.js",
        "custom/include/javascript/sugar7/softphone/iwsprescript.js",
        "custom/include/javascript/sugar7/softphone/SDK.js",
        "custom/include/javascript/sugar7/softphone/pureClientSdkBundle.js"
    ];
    if (softphonePackageLocked) {
        jsResources.push("custom/include/javascript/sugar7/softphone/util.js");
        jsResources.push("custom/include/javascript/sugar7/softphone/iwscript.js");
        jsResources.push("custom/include/javascript/sugar7/softphone/iwsconfig.js");
    }
    sequentialFileLoader.loadScript(jsResources, function () {
        callback();
    });
}
var sequentialFileLoader = (function () {
    var fileLength = 0;
    var scriptListToImport = [];
    function loadScriptAndExecuteCallback(i, callback) {
        if (i == fileLength) {
            callback();
            return;
        }
        var myScript = document.createElement('script');
        myScript.setAttribute('src', scriptListToImport[i]);
        document.body.appendChild(myScript);
        i++;
        myScript.onload = function () { loadScriptAndExecuteCallback(i, callback); };
    }
    function loadScript(scriptList, callback) {
        scriptListToImport = scriptList;
        fileLength = scriptList.length;
        loadScriptAndExecuteCallback(0, callback);
    }
    return {
        loadScript: loadScript
    };
})();
