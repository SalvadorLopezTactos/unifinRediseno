<?php
global $current_user, $db;
$AccountId = '';
$user = '';
if(isset($_REQUEST['Accountid'])){
    $AccountId = $_REQUEST['Accountid'];
    $user = $current_user->user_name;
}

global $sugar_config;
$UNI2_URL = $sugar_config['uni2_url'];
?>

<!DOCTYPE html>
<html lang="en" class="blue">
<head>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
    <style type="text/css">
        section {
            display: none;
        }
        body.tasks section.tasks,
        body.detail section.detail {
            display: block;
        }
        .v-tooltip {
            background-color: #323232;
            background-color: rgba(50, 50, 50, 0.9);
            -webkit-box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            color: white;
            padding: 5px 9px;
            border-radius: 3px;
            max-width: 35em;
            overflow: hidden !important;
            font-size: 14px;
        }

        .v-tooltip div[style*="width"] {
            width: auto !important;
        }

        .v-tooltip .v-tooltip-text {
            max-height: 10em;
            overflow: auto;
            margin-top: 10px;
        }

        .v-tooltip .v-errormessage[aria-hidden="true"] + .v-tooltip-text {
            margin-top: 0;
        }

        .v-tooltip h1, .mytheme .v-tooltip h2, .mytheme .v-tooltip h3, .mytheme .v-tooltip h4 {
            color: inherit;
        }
    </style>

</head>
<body class="tasks">

<header>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"/>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
</header>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
<!-- Se agregan las credenciales de Vaddin para las peticiones, permitiendo las cookies de sesión -->
<script>
    XMLHttpRequest.prototype._originalSend = XMLHttpRequest.prototype.send;
    var sendWithCredentials = function(data) {
        this.withCredentials = true;
        this._originalSend(data);
    };
    XMLHttpRequest.prototype.send = sendWithCredentials;
</script>

<!-- Carga Widgets de Vaadin así como el archivo bootstrats.js -->

<script type="text/javascript"
        src="<?php echo $UNI2_URL; ?>VAADIN/vaadinBootstrap.js">
</script>



<!-- First dashlet; Embeddes Vaadin dashlet that shows the user Activiti tasks -->
<section class="tasks">
    <div style="width: 100%; border: 0px solid red; height: 100%;" id="negociador" class="v-app mytheme">
        <!-- Optional placeholder for the loading indicator -->
        <div class=" v-app-loading"></div>
        <!-- Alternative fallback text -->
        <noscript>Se requiere habilitar javascript en el browser para visualizar el dashlet.</noscript>
    </div>
</section>

<section>
    <div id="mensaje"></div>
</section>



<script type="text/javascript">
    <!-- Start the Vaadin application from $DASHLET_URL -->
    window.onload = function() {
        if (!window.vaadin) alert("Failed to load the Vaadin bootstrap");
        vaadin.initApplication("negociador", {
            "browserDetailsUrl": "<?php echo $UNI2_URL; ?>negociador/",
            "serviceUrl": "<?php echo $UNI2_URL; ?>negociador/",
            "widgetset": "com.unifin.MyAppWidgetset",
            "theme": "mytheme",
            "versionInfo": {"vaadinVersion": "7.6.0"},
            "vaadinDir": "<?php echo $UNI2_URL; ?>VAADIN/",
            "heartbeatInterval": 3000,
            "standalone": false,
            "debug": false,
        });
        var text = '{ "guidPersona": "<?=$AccountId?>", "nombreUsuario": "<?=$user?>" }';
        console.log(text);
        var parametros = JSON.parse(text);
        console.log(parametros);
        cargaCompleta = function() {
            iniciaNegociador(parametros);
        }
    };

</script>
<iframe src='javascript:""' id="com.unifin.MyAppWidgetset" tabindex="-1" style="position: absolute; width: 0px; height: 0px; border: none; left: -1000px; top: -1000px;"></iframe>

<style>
    @font-face {
        font-family: Flaticon2;
        font-weight: normal;
        font-style: normal;
        src: url('custom/Levementum/CustomEntryPoints/fonts/miscellaneous-elements/Flaticon.eot');
        src: url('custom/Levementum/CustomEntryPoints/fonts/miscellaneous-elements/Flaticon.eot?#iefix') format('embedded-opentype'), url('custom/Levementum/CustomEntryPoints/fonts/miscellaneous-elements/Flaticon.woff') format('woff'), url('custom/Levementum/CustomEntryPoints/fonts/miscellaneous-elements/Flaticon.ttf') format('truetype'), url('custom/Levementum/CustomEntryPoints/fonts/miscellaneous-elements/Flaticon.svg#Flaticon2') format('svg');
    }
    @font-face {
        font-family: Flaticon;
        font-weight: normal;
        font-style: normal;
        src: url(custom/Levementum/CustomEntryPoints/fonts/interface-icon-assets/Flaticon.eot);
        src: url(custom/Levementum/CustomEntryPoints/fonts/interface-icon-assets/Flaticon.eot?#iefix) format("embedded-opentype"), url(custom/Levementum/CustomEntryPoints/fonts/interface-icon-assets/Flaticon.woff) format("woff"), url(custom/Levementum/CustomEntryPoints/fonts/interface-icon-assets/Flaticon.ttf) format("truetype"), url(custom/Levementum/CustomEntryPoints/fonts/interface-icon-assets/Flaticon.svg#Flaticon) format("svg");
    }
    @font-face {
        font-family: Flaticon3;
        font-weight: normal;
        font-style: normal;
        src: url(custom/Levementum/CustomEntryPoints/fonts/ultimate/Flaticon.eot);
        src: url(custom/Levementum/CustomEntryPoints/fonts/ultimate/Flaticon.eot?#iefix) format("embedded-opentype"), url(custom/Levementum/CustomEntryPoints/fonts/ultimate/Flaticon.woff) format("woff"), url(custom/Levementum/CustomEntryPoints/fonts/ultimate/Flaticon.ttf) format("truetype"), url(custom/Levementum/CustomEntryPoints/fonts/ultimate/Flaticon.svg#Flaticon3) format("svg");
    }
</style>


</body>
</html>