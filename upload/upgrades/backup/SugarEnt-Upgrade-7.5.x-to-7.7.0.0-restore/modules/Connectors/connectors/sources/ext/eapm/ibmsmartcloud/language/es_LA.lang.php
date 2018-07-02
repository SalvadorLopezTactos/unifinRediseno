<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
	

$connector_strings = array (
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Obtenga una clave secreta de consumo de IBM SmartCloud&copy; registrando su instancia de Sugar como un aplicación nueva <br><br />&nbsp;<br><br />Pasos para registrar la instancia:<br><br />&nbsp;<br><br /><ol><br /><li>Acceda a su cuenta de IBM SmartCloud (tiene que ser administrador)</li><br /><li>Vaya a "Administration" -> "Manage Organization"</li><br /><li>Vaya al enlace "Integrated Third-Party Apps" en la barra lateral y habilite SugarCRM para todos los usuarios.</li><br /><li>Vaya a "Internal Apps" en la barra lateral y luego a "Register App"</li><br /><li>Nombre esta aplicación (digamos "SugarCRM Production") y asegurase do _NO_ seleccionar  OAuth 2.x en el cuadro de selección de la ventana emergente.</li><br /><li>Una vez creada la aplicación, haga clic en el triángulo pequeño a la derecha del nombre de la aplicación y seleccione "Show Credentials" en el menú desplegable.</li><br /><li>Copie las siguientes credenciales.</li><br /></ol><br /></td></tr></table>',
  'oauth_consumer_key' => 'Claves del consumidor OAuth',
  'oauth_consumer_secret' => 'Secreto del consumidor OAuth',
);

