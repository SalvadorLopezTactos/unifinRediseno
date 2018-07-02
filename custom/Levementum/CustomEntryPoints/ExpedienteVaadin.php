<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/18/2015
 * Time: 6:41 PM
 */

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('log_errors', TRUE);

global $current_user, $db;

$AccountId = '';
$OppId = '';
if(isset($_REQUEST['Accountid'])){
    $AccountId = $_REQUEST['Accountid'];
    $query = "Select accounts_cstm.idcliente_c,accounts.name, accounts_cstm.id_c  , accounts.id as idPersona, accounts_cstm.tipodepersona_c
	from accounts_cstm inner join accounts on accounts.id = accounts_cstm.id_c where accounts_cstm.id_c='$AccountId'";
    $queryResult = $db->query($query);
    $row = $db->fetchByAssoc($queryResult);
    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : ROW cliente " . print_r($row, true));

}

if(isset($_REQUEST['Oppid'])){
    $OppId = $_REQUEST['Oppid'];
}

$IdRegistro = '';

if($AccountId != null && $AccountId != ''){
    $IdRegistro = $AccountId;
}
elseif($OppId != null && $OppId != ''){
    $IdRegistro = $OppId;
}
?>

<!DOCTYPE html>

<html lang="en" class="blue">
<header>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</header>
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

<?php

/* Vars para URL del servidor de dashlets */
global $sugar_config;
$DASHLET_URL = $sugar_config['uni2_url'];

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

<script type='text/javascript'>
    function newWindow(){
        top.location.href = "<?php echo $sugar_config['site_url'];?>/#Accounts/<?php echo $row['id_c']; ?>";
        parent.window.close();
    };
</script>


<!-- First dashlet; Embeddes Vaadin dashlet that shows the user Activiti tasks

 -->
<p class="navbar-text">
<h5>
<span class="label label-default">Persona</span> <a title="<?php echo $row['idcliente_c'].' - '.$row['name']; ?>" href="javascript: newWindow();"><?php echo $row['idcliente_c'].' - '.$row['name']; ?></a> </h5>
    </p>
<section class="tasks">

    <div style="width: 100%; border: 0px solid red; height: 100%;" id="expedientePersona" class="v-app">

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



        vaadin.initApplication("expedientePersona", {

            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>expedientePersona/",

            "serviceUrl": "<?php echo $DASHLET_URL; ?>expedientePersona/",

            "widgetset": "com.unifin.MyAppWidgetset",

            "theme": "mytheme",

            "versionInfo": {"vaadinVersion": "7.4.0"},

            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

            "heartbeatInterval": 3000,

            "standalone": false,

            "debug": true,

        });


       <?php
             global $current_user;

			 $idPersona = $row['idPersona'];
             $cliente = $row['idcliente_c'];
			 $nombreUsuario = 'jsradmin';
			 $tipoPersona = $row['tipodepersona_c'];
			 $nombrePersona = $row['name'];
			 
             $operacion = null;
             $tipo = 0;
			 
			 
			if (trim($row['tipodepersona_c']) == "Persona Fisica"){
                $tipoPersona = "PF";
            }
            if (trim($row['tipodepersona_c']) == "Persona Moral"){
                $tipoPersona = "PM";
            }
            if (trim($row['tipodepersona_c']) == "Persona Fisica con Actividad Empresarial"){
                $tipoPersona = "PFAE";
            }

			 
			 
         ?>
        //var text = '{ "cliente":"<?=$cliente?>" , "operacion":"<?=$operacion?>", "tipo":"<?=$tipo?>" }';
        var text = '{ "idPersona":"<?=$idPersona?>" , "nombreUsuario":"<?=$nombreUsuario?>",  "tipoPersona":"<?=$tipoPersona?>", "nombrePersona":"<?=$nombrePersona?>" }';
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

