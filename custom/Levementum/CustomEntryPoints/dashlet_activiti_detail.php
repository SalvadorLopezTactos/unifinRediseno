<?php
/**
 * User: fponce
 * Date: 6/18/2015
 * Time: 10:42 AM
 */
?>

<!DOCTYPE html>

<html lang="en" class="blue">
<head>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>


<!-- Se agregan las credenciales de Vaddin para las peticiones, permitiendo las cookies de sesión -->
<script>
    XMLHttpRequest.prototype._originalSend = XMLHttpRequest.prototype.send;
    var sendWithCredentials = function(data) {
        this.withCredentials = true;
        this._originalSend(data);
    };
    XMLHttpRequest.prototype.send = sendWithCredentials;
</script>



<style type="text/css">

    section {
        display: none;
    }

    body.tasks section.tasks,
    body.detail section.detail {
        display: block;
    }


</style>


<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<body class="tasks">

<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);

/* Vars para URL del servidor de dashlets */
global $sugar_config;
$DASHLET_URL = $sugar_config['dashlet_url'];
?>





<!-- Carga Widgets de Vaadin así como el archivo bootstrats.js -->
<script type="text/javascript"src="<?php echo $DASHLET_URL; ?>VAADIN/vaadinBootstrap.js"></script>




<!-- First dashlet; Embeddes Vaadin dashlet that shows the user Activiti tasks -->

<section class="tasks">

    <div style="width: 100%; border: 0px solid red; height: 100%;" id="activiti">

        <!-- Optional placeholder for the loading indicator -->

        <div class=" v-app-loading"></div>

        <!-- Alternative fallback text -->

        <noscript>Se requiere habilitar javascript en el browser para visualizar el dashlet.</noscript>

    </div>

</section>
<a href="" onclick="javascript:jump("activiti");">Regresar</a>

<!-- Second dashlet; Embeddes Vaadin Application for Activiti Task Detail -->

<section class="detail">

    <div style="width: 100%; height: 100%; border: 0px solid green;" id="activiti-taskdetail">

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

            "heartbeatInterval": 300,

            "debug": true,

        });



        vaadin.initApplication("activiti-taskdetail", {

            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti-taskdetail/",

            "serviceUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti-taskdetail/",

            "widgetset": "com.unifin.MyAppWidgetset",

            "theme": "mytheme",

            "versionInfo": {"vaadinVersion": null},

            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

            "heartbeatInterval": 300,

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

        $( "button" ).click(function() {
          $( "p" ).toggle();
        });


    };

</script>

</body>

</html>

















