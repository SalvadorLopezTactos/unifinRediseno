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
    'LBL_LICENSING_INFO' => 'Passos para usar o conector DocuSign:
         <br> - Gerar uma chave de integração
         <br> - Activar o DocuSign Connect para envelopes
         (ou seja, o webhook usado pelo DocuSign para subscrever um ponto de entrada do Sugar)
         <br> - Configurar uma nova aplicação no DocuSign e certificar-se de inserir o URI de redirecionamento e gerar uma chave secreta.
         O URI de redirecionamento deve ser https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
         <br> Em caso de restrições de IP na instância do Sugar, coloque os endereços IP do DocuSign na lista de permissões',
    'environment' => 'Ambiente',
    'integration_key' => 'Chave de integração',
    'client_secret' => 'Segredo de cliente',
];
