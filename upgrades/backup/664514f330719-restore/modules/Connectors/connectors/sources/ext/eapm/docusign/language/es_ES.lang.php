<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$connector_strings = [
    'LBL_LICENSING_INFO' => 'Pasos para utilizar un conector de DocuSign:
        <br> - Generar una clave de integración
        <br> - Habilitar DocuSign Connect para los sobres
        (es decir, el webhook que utiliza DocuSign para suscribirse a un punto de entrada de Sugar)
        <br> - Configurar una nueva aplicación en DocuSign y asegurarse de introducir la uri de redirección y generar una clave secreta.
        La uri de redirección debe ser https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
        <br> En caso de restricciones de IP en la instancia de Sugar, marque como seguras las direcciones IP de DocuSign',
    'environment' => 'Entorno',
    'integration_key' => 'Clave de integración',
    'client_secret' => 'Secreto de cliente',
];
