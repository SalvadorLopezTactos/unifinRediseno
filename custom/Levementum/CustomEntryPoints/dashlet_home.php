<!--

 * Copyright (c) 2015, Unifin Financiera

 * All rights reserved.

 *

 * Redistribution and use in source and binary forms, with or without

 * modification, are not permitted.

 *

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"

 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE

 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE

 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE

 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR

 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF

 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS

 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN

 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)

 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE

 * POSSIBILITY OF SUCH DAMAGE.

 *

 * Developed 2015 by LegoSoft www.legosoft.com.mx

 * dashlet1.php 1.0

 * author Carlos Zaragoza <czaragoza@legosoft.com.mx>

 * date 28-Mayo-2015

-->
<?php
/* Vars para URL del servidor de dashlets */
global $sugar_config;
$DASHLET_URL = $sugar_config['dashlet_url'];
?>
<!DOCTYPE html>
<html lang="en" class="blue">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Se agregan las credenciales de Vaddin para las peticiones, permitiendo las cookies de sesión -->
<head>
    <!-- Carga Widgets de Vaadin así como el archivo bootstrats.js -->

    <script type="text/javascript" src="<?php echo $DASHLET_URL; ?>VAADIN/vaadinBootstrap.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
        XMLHttpRequest.prototype._originalSend = XMLHttpRequest.prototype.send;
        var sendWithCredentials = function (data) {
            this.withCredentials = true;
            this._originalSend(data);
        };
        XMLHttpRequest.prototype.send = sendWithCredentials;
    </script>

    <style type="text/css">

        #carga {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: absolute;
            /*display: block;*/
            opacity: 0.8;
            background-color: #fdfdfd;
            z-index: 99;
            text-align: center;
        }

        #carga-image {
            position: relative;
            vertical-align: middle;
            /*top: 200px;*/
            /*left: 240px;*/
            top: 150px;
            margin: auto;
            z-index: 100;
        }

        #color-texto {
            font-family: "Helvetica Neue Light", "Lucida Grande", "Calibri", "Arial", sans-serif;
            font-size: 1.1em;
            color: #020243;
        }

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

        .v-margin-left {
            padding-left: 1px;
        !important;
        }

        .v-margin-bottom {
            padding-bottom: 10px;
        !important;
        }

        .v-margin-right {
            padding-right: 10px;
        !important;
        }

        .v-margin-top {
            padding-top: 1px;
        !important;
        }

    </style>
</head>



<body class="tasks">
<div id="carga">
    <div id="carga-image">
        <img  src="custom/Levementum/images/icon_processing.gif"
              alt="Cargando, por favor espera un momento..."/>

        <p id="color-texto">Cargando, por favor espera un momento...</p>
    </div>

</div>

<!-- First dashlet; Embeddes Vaadin dashlet that shows the user Activiti tasks -->

<section class="tasks">

    <div style="width: 100%; border: 0px solid red; height: 100%;" id="activiti" class="v-app">

        <!-- Optional placeholder for the loading indicator -->

        <div class=" v-app-loading"></div>

        <!-- Alternative fallback text -->

        <noscript>Se requiere habilitar javascript en el browser para visualizar el dashlet.</noscript>

    </div>

</section>
<a href="" onclick="jump(" activiti");">Regresar</a>

<!-- Second dashlet; Embeddes Vaadin Application for Activiti Task Detail -->

<section class="detail">

    <div style="width: 100%; height: 100%; border: 0px solid green;" id="activiti-taskdetail" class="v-app">

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

    <?php

               global $current_user;

               echo "

                   cargaUser = function() {

                       com.unifin.dashlets.ActivitiDashletUI('{$current_user->user_name}');
                       console.log('llamada a ActivitiDashletUI');
                        $( document ).ready(function() {

       // Your code here.
    $('#carga').show();
   });
                   }

               ";
               echo "

                   cargaUserDetail = function() {

                       com.unifin.dashlets.ActivitiTaskDetailDashletUI('{$current_user->user_name}');
                       console.log('llamada a ActivitiTaskDetailDashletUI');
                       $( document ).ready(function() {

       // Your code here.
    $('#carga').hide();
   });

                   }
               ";

           ?>


    window.onload = function () {

        if (!window.vaadin) alert("Failed to load the Vaadin bootstrap");


        vaadin.initApplication("activiti", {

            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti/",

            "serviceUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti/",

            "widgetset": "com.unifin.MyAppWidgetset",

            "theme": "mytheme",

            "versionInfo": {"vaadinVersion": null},

            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

            "heartbeatInterval": 3000,

            "debug": false,

        });


        vaadin.initApplication("activiti-taskdetail", {

            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti-taskdetail/",

            "serviceUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti-taskdetail/",

            "widgetset": "com.unifin.MyAppWidgetset",

            "theme": "mytheme",

            "versionInfo": {"vaadinVersion": null},

            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

            "heartbeatInterval": 3000,

            "debug": false,

        });

        jump = function (name_section) {
            console.log("jump: " + name_section);
            switch (name_section) {
                case 'activiti':
                    document.body.className = 'tasks';
                    break;
                case 'activiti-taskdetail':
                    document.body.className = 'detail';
                    break;
                default:
                    document.body.className = 'tasks';
            }

        };

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

