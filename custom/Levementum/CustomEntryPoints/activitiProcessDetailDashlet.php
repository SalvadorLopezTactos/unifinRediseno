<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 02/03/18
 * Time: 12:55
 */
/* Vars para URL del servidor de dashlets */
require_once("../../../config.php");

$DASHLET_URL = $sugar_config['dashlet_url'];

$user=$_GET['user'];
$process=$_GET['process'];
?>

<!DOCTYPE html>
<html lang="en" class="blue">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Se agregan las credenciales de Vaddin para las peticiones, permitiendo las cookies de sesión -->
<head>

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

    <style>

        #parent {
            width: 100%;
            height: 32px;
            white-space:nowrap;
            font-size:0;
        }
        .childs {
            height: 32px;
            background-color: #FAFAFA;
            display:inline-block;
            *display:inline;/* For IE7 */
            *zoom:1;/* For IE7 */
            white-space:normal;
            font-size:13px;
            vertical-align:top;
        }

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
    </style>
</head>


<section class="tasks">
    <!--<div style="width: 100%; heigth:100%; border: 0px;" id="activiti-processdetail" class="v-app" onload="carga()">-->
    <div style="width: 100%; heigth:100%; border: 0px;" id="activiti-processdetail" class="v-app">
        <!-- Optional placeholder for the loading indicator -->
        <div class=" v-app-loading"></div>
        <!-- Alternative fallback text -->
        <noscript>Se requiere habilitar javascript en el browser para
            visualizar el dashlet.</noscript>
    </div>
</section>

<div id="parent">
    <div id="infoDateStarted" style="width: 70%;" class="childs"></div>
    <button id="btn_update" onclick="updateProcess()" style="width: 30%; border-color: #f4f4f4; border: 1px" class="fa fa-refresh childs"></button>
</div>


<script type="text/javascript">
    <!-- Start the Vaadin application from $DASHLET_URL -->

    window.onload = function () {

        if (!window.vaadin) alert("Failed to load the Vaadin bootstrap");


        vaadin.initApplication("activiti-processdetail", {

            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti-processdetail/",

            "serviceUrl": "<?php echo $DASHLET_URL; ?>bpm/activiti-processdetail/",

            "widgetset": "com.unifin.MyAppWidgetset",

            "theme": "mytheme",

            "versionInfo": {"vaadinVersion": null},

            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

            "heartbeatInterval": 3000,

            "debug": false,

            "standalone": false
        });

    };

    sendProcessId = function() {
        console.log("<<<<sendProcess>>>>    " + <?php echo $user +' '+ $process?> );
        com.unifin.dashlets.ActivitiProcessUI('<?php echo $user ?>' , '<?php echo $process ?>');
        var date_time = new Date();
        var b = document.getElementById("infoDateStarted");
        b.innerHTML = "Ultima actualización :" + formatDate(date_time);
    }

    updateProcess = function()
    {
        var date_time = new Date();
        var b = document.getElementById("infoDateStarted");
        b.innerHTML = " Ultima actualización :" + formatDate(date_time);
        sendProcessId();
    }

    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        seconds = seconds < 10 ? '0'+seconds : seconds;
        var strTime = hours + ':' + minutes + ':'+ seconds +' ' + ampm;
        return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
    }

</script>

</html>