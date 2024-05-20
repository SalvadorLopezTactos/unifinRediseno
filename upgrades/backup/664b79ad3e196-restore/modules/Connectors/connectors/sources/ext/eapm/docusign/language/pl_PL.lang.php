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
    'LBL_LICENSING_INFO' => 'Aby korzystać z łącznika DocuSign, wykonaj następujące czynności:
        <br> - Wygeneruj klucz integracji.
        <br> - Włącz usługę DocuSign Connect for Envelopes
        (tj. utwórz element webhook używany przez DocuSign do subskrybowania punktu wejścia Sugar).
        <br> - Skonfiguruj nową aplikację w DocuSign oraz wstaw adres URI przekierowania i wygeneruj klucz tajny.
        Adres URI przekierowania musi mieć następujący format: https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect.
        <br> W przypadku ograniczeń adresów IP w wystąpieniu Sugar dodaj adresy IP łącznika DocuSign do białej listy.',
    'environment' => 'Środowisko',
    'integration_key' => 'Klucz integracji',
    'client_secret' => 'Klucz tajny klienta',
];
