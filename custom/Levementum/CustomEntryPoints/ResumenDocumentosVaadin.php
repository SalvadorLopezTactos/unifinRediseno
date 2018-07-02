<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/18/2015
 * Time: 10:42 AM
 */

?>

<!DOCTYPE html>

<html lang="en" class="blue">

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


<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<body class="tasks">

<?php

/*

 * Configuración para nivel debug:

 * Muestra los errores a nivel PHP

 *

 */

// ini_set('error_reporting', E_ALL);

// ini_set('display_errors', TRUE);

// ini_set('log_errors', TRUE);



/* Vars para URL del servidor de dashlets */
global $sugar_config;
$DASHLET_URL = $sugar_config['dashlet_url'];


?>

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

    <div style="width: 100%; border: 0px solid red; height: 100%;" id="activiti" class="v-app">

        <!-- Optional placeholder for the loading indicator -->

        <div class=" v-app-loading"></div>

        <!-- Alternative fallback text -->

        <noscript>Se requiere habilitar javascript en el browser para visualizar el dashlet.</noscript>

    </div>

</section>

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

    window.onload = function() {

        if (!window.vaadin) alert("Failed to load the Vaadin bootstrap");



        vaadin.initApplication("activiti", {

            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti/",

            "serviceUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti/",

            "widgetset": "com.unifin.MyAppWidgetset",

            "theme": "mytheme",

            "versionInfo": {"vaadinVersion": null},

            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

            "heartbeatInterval": 3000,

            "debug": true,

        });



        vaadin.initApplication("activiti-taskdetail", {

            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti-taskdetail/",

            "serviceUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti-taskdetail/",

            "widgetset": "com.unifin.MyAppWidgetset",

            "theme": "mytheme",

            "versionInfo": {"vaadinVersion": null},

            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

            "heartbeatInterval": 3000,

            "debug": true,

        });





        <?php

            global $current_user;

            echo "

                cargaUser = function() {

                    com.unifin.dashlets.ActivitiDashletUI('{$current_user->user_name}');

                }

            ";

        ?>



        mensajeDeVaadin = function(data) {

            $(document).ready(function(){

                $('#mensaje').html('<span style="color:#1c96ff;font-size:bold">' + data + '</span>');

            });

        };

        jump = function(name_section) {

            console.log("jump: "+ name_section);

            switch(name_section) {

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

</body>

</html>

