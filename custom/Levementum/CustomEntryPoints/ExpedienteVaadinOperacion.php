<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/18/2015
 * Time: 6:41 PM
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);

global $current_user, $db;

$AccountId = '';
$OppId = '';
if(isset($_REQUEST['Oppid'])){
    $Oppid = $_REQUEST['Oppid'];
    $query = "select acs.idcliente_c, oc.idsolicitud_c, op.name, a1.name as name_client, oc.id_c, acs.id_c as id_c_client,a1.id as idPersona,
	u.user_name,acs.tipodepersona_c,oc.monto_c,
case
when oc.tipo_producto_c = 1 then 'LEASING'
when oc.tipo_producto_c = 2 then 'CREDITO SIMPLE'
when oc.tipo_producto_c = 3 then 'CREDITO AUTOMOTRIZ'
when oc.tipo_producto_c = 4 then 'FACTORAJE'
when oc.tipo_producto_c = 5 then 'LINEA CREDITO SIMPLE'
else 'SIN PRODUCTO' end as producto,
case when (u.first_name is null or u.first_name = '') or (u.last_name is null or u.last_name = '') then 'Sin promotor' else concat(u.first_name, ' ', u.last_name) end as promotor,
case when oc.estatus_c = 'P' then 'INTEGRACIÓN DE EXPEDIENTE'
when oc.estatus_c = 'E' then 'ANÁLISIS DE CRÉDITO'
when oc.estatus_c = 'RM' then 'ANÁLISIS DE CRÉDITO'
when oc.estatus_c = 'D' then 'COMITÉ'
when oc.estatus_c = 'N' then 'AUTORIZADA'
when oc.estatus_c = 'R' then 'RECHAZADA CRÉDITO'
when oc.estatus_c = 'K' then 'CANCELADA'
when oc.estatus_c = 'CM' then 'RECHAZADA COMITÉ'
when oc.estatus_c = 'CZ' then 'COTIZACIÓN'
when oc.estatus_c = 'SL' then 'SOLICITUD DE COMPRA'
when oc.estatus_c = 'OC' then 'ORDEN DE COMPRA'
when oc.estatus_c = 'CT' then 'CONTRATACIÓN'
when oc.estatus_c = 'LB' then 'LIBERACION'
when oc.estatus_c = 'CA' then 'CONTRATO ACTIVO'
when oc.estatus_c = 'AL' then 'CONTRATO ACTIVO LIBERADO'
when oc.estatus_c = 'T' then 'CONTRATO TERMINADO'
when oc.estatus_c = 'OP' then 'OPERACION DE PROSPECTO'
when oc.estatus_c = 'BC' then 'BURO DE CREDITO'
when oc.estatus_c = 'EF' then 'ESTADOS FINANCIERO'
when oc.estatus_c = 'SC' then 'SCORING'
when oc.estatus_c = 'RF' then 'REFERENCIAS'
when oc.estatus_c = 'CC' then 'CUALITATIVO Y CUANTITATIVO'
when oc.estatus_c = 'CN' then 'CONDICIONADA'
when oc.estatus_c = 'DP' then 'DEVUELTA POR CRÉDITO'
when oc.estatus_c = '' or oc.estatus_c is null then 'VERIFICAR ESTATUS'
else 'ESTATUS INVALIDO'
end as estatus,
case when (oc.analista_credito_c is null or oc.analista_credito_c = '') then 'Sin analista' else oc.analista_credito_c end as analista
from accounts_cstm acs inner join accounts_opportunities ao on acs.id_c = ao.account_id
inner join opportunities_cstm oc on oc.id_c = ao.opportunity_id
inner join opportunities op on op.id = oc.id_c
inner join accounts a1 on a1.id = acs.id_c
inner join users u on u.id = op.assigned_user_id
where ao.opportunity_id='$Oppid'";
    //$query = "Select idcliente_c from accounts_cstm where id_c='$AccountId'";
    $queryResult = $db->query($query);
    $row = $db->fetchByAssoc($queryResult);
    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : ROW oportunidad " . print_r($row, true));
    $cliente = $row['idcliente_c'];
    $operacion = $row['idsolicitud_c'];
    $tipo = 1;
	
	
	$idCliente = $row['idcliente_c'];
	$idPersona = $row['idPersona'];
	$nombreUsuario = $row['user_name'];
	$tipoPersona = $row['tipodepersona_c'];
				if (trim($row['tipodepersona_c']) == "Persona Fisica"){
                $tipoPersona = "PF";
            }
            if (trim($row['tipodepersona_c']) == "Persona Moral"){
                $tipoPersona = "PM";
            }
            if (trim($row['tipodepersona_c']) == "Persona Fisica con Actividad Empresarial"){
                $tipoPersona = "PFAE";
            }
	$monto = $row['monto_c'];
	
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
        top.location.href = "<?php echo $sugar_config['site_url'];?>/#Accounts/<?php echo $row['id_c_client']; ?>";
        //parent.window.close();
    };
    function newWindowOperacion(){
        top.location.href = "<?php echo $sugar_config['site_url'];?>/#Opportunities/<?php echo $row['id_c']; ?>";
        //parent.window.close();
    };
</script>

<!-- First dashlet; Embeddes Vaadin dashlet that shows the user Activiti tasks -->
<div class="navbar-text">
<h5>
    <span class="label label-default">Persona</span> <a title="<?php echo $row['idcliente_c'].' - '.$row['name_client']; ?>" href="javascript: newWindow();"><?php echo $row['idcliente_c'].' - '.$row['name_client']; ?></a>  </h5>
<h5>
    <span class="label label-default">Operaci&oacute;n</span>
    <a title="<?php echo $row['name']; ?>" href="javascript: newWindowOperacion();"><?php echo $row['name']; ?></a>
</h5>
</div>
<div class="navbar-text">
<h5>
	<span class="label label-default">Producto</span>
	<span style="color:#337ab7;"><?php echo $row['producto']; ?></span>
</h5>
<h5>
	<span class="label label-default">Promotor</span>
	<span style="color:#337ab7;"><?php echo $row['promotor']; ?></span>	
</h5>
</div>
<div class="navbar-text">
<h5>
	<span class="label label-default">Estatus operaci&oacute;n</span>
	<span style="color:#337ab7;"><?php echo $row['estatus']; ?></span>
</h5>
<h5>
    <span class="label label-default">Analista cr&eacute;dito</span>
    <span style="color:#337ab7;"><?php echo $row['analista']; ?></span>
</h5>
</div>

<section class="tasks">

    <div style="width: 100%; border: 0px solid red; height: 100%;" id="expediente" class="v-app">

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



        vaadin.initApplication("expediente", {

            "browserDetailsUrl": "<?php echo $DASHLET_URL; ?>expediente/",

            "serviceUrl": "<?php echo $DASHLET_URL; ?>expediente/",

            "widgetset": "com.unifin.MyAppWidgetset",

            "theme": "mytheme",

            "versionInfo": {"vaadinVersion": "7.4.0"},

            "vaadinDir": "<?php echo $DASHLET_URL; ?>VAADIN/",

            "heartbeatInterval": 3000,

            "standalone": false,

            "debug": true,

        });

        //var text = '{ "cliente":"<?=$cliente;?>" , "operacion":"<?=$operacion;?>", "tipo":"<?=$tipo;?>" }';
		var text = '{ "idCliente":"<?=$idCliente;?>" , "idPersona":"<?=$idPersona;?>", "operacion":"<?=$operacion;?>", "nombreUsuario":"<?=$nombreUsuario;?>", "tipoPersona":"<?=$tipoPersona;?>", "monto":"<?=$monto;?>" }';
		
	    console.log(text);
        var parametros = JSON.parse(text);
        console.log(parametros);
        cargaCompleta = function(){
            obtieneIdCliente(parametros);
        }
        //console.log("CZO: "+<?=$cliente;?>);



    };

</script>

</body>

</html>

