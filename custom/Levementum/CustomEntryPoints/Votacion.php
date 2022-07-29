<?php

global $current_user, $db;

$AccountId = '';
$OppId = '';
if(isset($_REQUEST['Oppid'])){
    $Oppid = $_REQUEST['Oppid'];
    $cliente = $_REQUEST['Oppid'];
    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : ROW oportunidad " .$cliente);
}
/* Vars para URL del servidor de dashlets */
global $sugar_config;
$DASHLET_URL = $sugar_config['uni2_url'];
?>

<!DOCTYPE html>
<html lang="en" class="blue">

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
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



<body class="tasks">

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
        src="<?php echo $DASHLET_URL; ?>VAADIN/vaadinBootstrap.js">
</script>



<!-- First dashlet; Embeddes Vaadin dashlet that shows the user Activiti tasks -->

<section class="tasks">
    <div style="width: 100%; border: 0px solid red; height: 100%;" id="votacion" class="v-app">
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
        vaadin.initApplication("votacion", {
            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>integrantesComite/",
            "serviceUrl": "<?php echo $DASHLET_URL; ?>integrantesComite/",
            "widgetset": "com.unifin.MyAppWidgetset",
            "theme": "mytheme",
            "versionInfo": {"vaadinVersion": "7.4.0"},
            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",
            "heartbeatInterval": 3600,
            "standalone": false,
            "debug": false,
        });

        var text = '{ "operacion":<?=$Oppid;?>}';
        console.log(text);
        var parametros = JSON.parse(text);
        console.log(parametros);
        cargaCompleta = function(){
            obtieneIdCliente(parametros);
        }
    };

</script>

</body>

</html>

