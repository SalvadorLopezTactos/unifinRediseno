<!DOCTYPE html>
<html>

<?php
/*
@deprecated Carlos Zaragoza
*/
global $sugar_config;
$DASHLET_URL = $sugar_config['dashlet_url'];
?>

<head>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<!-- Loads the Vaadin widget set, etc. -->
<script type="text/javascript" src="<?php echo $DASHLET_URL;?>VAADIN/vaadinBootstrap.js"></script>


<section>
    <!-- First Dashlet: tareas pendientes -->
    <div style="width: 100%; heigth=100%; border: 0px;" id="activiti-processdetail" class="v-app">
        <!-- Optional placeholder for the loading indicator -->
        <div class=" v-app-loading"></div>
        <!-- Alternative fallback text -->
        <noscript>Se requiere habilitar javascript en el browser para
            visualizar el dashlet.</noscript>
    </div>
</section>

<!-- Se agregan las credenciales de Vaddin para las peticiones, permitiendo las cookies de sesión -->
<script>
    XMLHttpRequest.prototype._originalSend = XMLHttpRequest.prototype.send;
    var sendWithCredentials = function(data) {
        this.withCredentials = true;
        this._originalSend(data);
    };
    XMLHttpRequest.prototype.send = sendWithCredentials;
</script>

<script type="text/javascript">
    window.onload = function() {
        if (!window.vaadin)
            alert("Falla al inicializar bootstrap JavaScript: "+
            "<?php echo $DASHLET_URL;?>VAADIN/vaadinBootstrap.js");

        /* Dashlet UI Configuration */
        vaadin.initApplication("activiti-processdetail", {
            "browserDetailsUrl": "<?php echo $DASHLET_URL;?>bpm/activiti-processdetail/",
            "serviceUrl": "<?php echo $DASHLET_URL;?>bpm/activiti-processdetail/",
            "widgetset": "com.unifin.MyAppWidgetset",
            "theme": "mytheme",
            "versionInfo": {"vaadinVersion": null},
            "vaadinDir": "<?php echo $DASHLET_URL;?>VAADIN/",
            "heartbeatInterval": 300,
            "debug": true
        });


        <?php
            global $current_user;
            //$idProcess = this.model.get('id');
                echo "sendProcessId = function() {
                    com.unifin.dashlets.ActivitiProcessUI('alaguna','1045001');
                    }";
            //    echo $idProcess;
            //com.unifin.dashlets.ActivitiProcessUI('$current_user->user_name','1045001');
        ?>
    }



</script>

</body>
</html>

