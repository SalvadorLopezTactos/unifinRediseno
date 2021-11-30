<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('log_errors', TRUE);

global $current_user, $db;
$AccountId = $_REQUEST['Accountid'];
$clientId = $_REQUEST['clientId'] = '' ? '0' : $_REQUEST['clientId'];
$token = '';
if (isset($_SESSION['oauth2']['refresh_token'])) {
    $token = $_SESSION['oauth2']['refresh_token'];
}
global $sugar_config;
$DASHLET_URL = $sugar_config['dashlet_url'];
$UNI2_URL = $sugar_config['uni2_url'];

$logg = $UNI2_URL . "cotizador?idClient=$clientId&userName=$current_user->user_name&id=$current_user->id&token=$token&tipoProducto=LEASING";
$GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : LOG cotizador: " . $logg);
$email = $current_user->fetched_row['email1'];
$tipodeproducto_c = $current_user->fetched_row['tipodeproducto_c'];

$frame = <<<HTML
<div class="cotizador">
<iframe src="<?=$UNI2_URL?>cotizador?idClient=$clientId&userName=$current_user->user_name&id=$current_user->id&token=$token&tipoProducto=LEASING"  height="100%" width="100%" frameborder="0" marginheight="20" marginwidth="35" scrolling="auto"></iframe>
</div>
HTML;

//echo $frame;

if ($AccountId != null && $AccountId != '') {
    $IdRegistro = $AccountId;
} elseif ($OppId != null && $OppId != '') {
    $IdRegistro = $OppId;
}
?>

<!DOCTYPE html>

<html lang="en" class="blue">

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<body class="tasks">

    <?php

    /* Vars para URL del servidor de dashlets */
    global $sugar_config;
    $DASHLET_URL = $sugar_config['uni2_url'];

    ?>

    <!-- Se agregan las credenciales de Vaddin para las peticiones, permitiendo las cookies de sesi?n -->

    <script>
        XMLHttpRequest.prototype._originalSend = XMLHttpRequest.prototype.send;

        var sendWithCredentials = function (data) {

            this.withCredentials = true;

            this._originalSend(data);

        };
        XMLHttpRequest.prototype.send = sendWithCredentials;
    </script>


    <!-- Carga Widgets de Vaadin as? como el archivo bootstrats.js -->

    <script type="text/javascript" src="<?php echo $DASHLET_URL; ?>VAADIN/vaadinBootstrap.js"></script>


    <!-- First dashlet; Embeddes Vaadin dashlet that shows the user Activiti tasks -->

    <section class="tasks">

        <div style="width: 100%; border: 0px solid red; height: 100%;" id="cotizador" class="v-app">

            <!-- Optional placeholder for the loading indicator -->

            <div class=" v-app-loading"></div>

            <!-- Alternative fallback text -->

            <noscript>Se requiere habilitar javascript en el browser para visualizar el dashlet.</noscript>

        </div>

    </section>


    <script type="text/javascript">
        function factoraje(tipo){
            var empleado = '<?=$AccountId;?>';
            if(tipo != 1 && tipo != 9 && tipo != 8){
                if(empleado!=""){
                    console.log("Cerrar");
                    alert("Esta opci\u00F3n no est\u00E1 habilitada para Factoraje");
                    parent.window.close();
                }else{
                    console.log("Atras");
                    alert("Esta opci\u00F3n no est\u00E1 habilitada para Factoraje");
                    window.history.back();
                }
            }

        }

        <!-- Start the Vaadin application from $DASHLET_URL -->

        window.onload = function () {
            if (!window.vaadin) alert("Failed to load the Vaadin bootstrap");

            vaadin.initApplication("cotizador", {

                "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>cotizador/",

                "serviceUrl": "<?php echo $DASHLET_URL; ?>cotizador/",

                "widgetset": "com.unifin.MyAppWidgetset",

                "theme": "uni2Theme",

                "versionInfo": {"vaadinVersion": "7.4.0"},

                "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

                "heartbeatInterval": 3600,

                "standalone": false,

                "debug": true,

            });

            var token = localStorage.getItem('dev:SugarCRM:AuthAccessToken');
            console.log(token);
            var text = '{ "idClient":"<?=$clientId;?>" , "userName":"<?=$current_user->user_name;?>", "id":"<?=$current_user->id;?>", "token":"' + token + '", "full_name":"<?=$current_user->full_name?>", "email":"<?=$email?>", "tipoProducto":"LEASING", "guid_persona" : "<?=$AccountId;?>"}';
            console.log(text);
            var parametros = JSON.parse(text);
            console.log(parametros);
            cargaCompleta = function () {
                obtieneParametros(parametros);
            }
            factoraje(<?php echo $current_user->fetched_row['tipodeproducto_c']; ?>);
        };


    </script>

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

    @font-face {
        font-family: "DaxBold";
        font-weight: normal;
        font-style: normal;
        src: url(custom/Levementum/CustomEntryPoints/fonts/dax/DaxBold.eot);
        src: url(custom/Levementum/CustomEntryPoints/fonts/dax/DaxBold.eot?#iefix) format("embedded-opentype"), url(custom/Levementum/CustomEntryPoints/fonts/dax/DaxBold.woff) format("woff"), url(custom/Levementum/CustomEntryPoints/fonts/dax/DaxBold.ttf) format("truetype"), url(custom/Levementum/CustomEntryPoints/fonts/dax/DaxBold.svg#DaxBold) format("svg");
    }

    @font-face {
        font-family: "dax-medium";
        font-weight: normal;
        font-style: normal;
        src: url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-medium.eot);
        src: url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-medium.eot?#iefix) format("embedded-opentype"), url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-medium.woff) format("woff"), url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-medium.ttf) format("truetype"), url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-medium.svg#dax-medium) format("svg");
    }

    @font-face {
        font-family: "dax-regular";
        font-weight: normal;
        font-style: normal;
        src: url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-regular-1361513784.eot);
        src: url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-regular-1361513784.eot?#iefix) format("embedded-opentype"), url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-regular-1361513784.woff) format("woff"), url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-regular-1361513784.ttf) format("truetype"), url(custom/Levementum/CustomEntryPoints/fonts/dax/dax-regular-1361513784.svg#dax-regular) format("svg");
    }


    @font-face {
        font-family: FlatIconBusiness;
        font-weight: normal;
        font-style: normal;
        src: url(custom/Levementum/CustomEntryPoints/fonts/business/Flaticon.eot);
        src: url(custom/Levementum/CustomEntryPoints/fonts/business/Flaticon.eot?#iefix) format("embedded-opentype"), url(custom/Levementum/CustomEntryPoints/fonts/business/Flaticon.woff) format("woff"), url(custom/Levementum/CustomEntryPoints/fonts/business/Flaticon.ttf) format("truetype"), url(custom/Levementum/CustomEntryPoints/fonts/business/Flaticon.svg#FlatIconBusiness) format("svg");
    }

    @font-face {
        font-family: ThemeIcons;
        font-weight: normal;
        font-style: normal;
        src: url(custom/Levementum/CustomEntryPoints/fonts/themeicons-webfont.eot);
        src: url(custom/Levementum/CustomEntryPoints/fonts/themeicons-webfont.eot?#iefix) format("embedded-opentype"), url(custom/Levementum/CustomEntryPoints/fonts/themeicons-webfont.woff) format("woff"), url(custom/Levementum/CustomEntryPoints/fonts/themeicons-webfont.ttf) format("truetype"), url(custom/Levementum/CustomEntryPoints/fonts/themeicons-webfont.svg#ThemeIcons) format("svg");
    }
</style>

</body>

</html>
