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
    'LBL_LICENSING_INFO' => '„DocuSign“ jungties naudojimo veiksmai:
         <br> – Sugeneruokite integravimo raktą
         <br> – Įgalinkite "DocuSign Connect" vokams
         (t. y. „Webhook“, kurį „DocuSign“ naudoja „Sugar“ įėjimo taškui užsiprenumeruoti)
         <br> – „DocuSign“ nustatykite naują programą ir būtinai įdėkite peradresavimo uri ir sugeneruokite slaptą raktą.
         Peradresavimo URL turi būti https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
         <br> Jei „Sugar“ egzemplioriui taikomi IP apribojimai, įtraukite „DocuSign“ IP adresus į baltąjį sąrašą',
    'environment' => 'Aplinka',
    'integration_key' => 'Integravimo raktas',
    'client_secret' => 'Kliento paslaptis',
];
