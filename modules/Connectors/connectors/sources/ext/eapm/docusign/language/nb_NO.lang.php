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
    'LBL_LICENSING_INFO' => 'Trinn for bruk av DocuSign connector:
        <br> - Generer en integrasjonsnøkkel
        <br> - Aktiver DocuSign Connect for omslag
        (f.eks. webhook benyttet av DocuSign for abonnement på Sugar tilgangspunkt)
        <br> - Still inn en ny anvendelse i DocuSign og sørg for å sette inn omdirigerings-URL og generere en hemmelig nøkkel.
        Omdirigerings-URL skal være https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
        <br> Ved IP-restriksjoner på Sugar-instanser må IP-adressene til DocuSign hvitelistes',
    'environment' => 'Miljø',
    'integration_key' => 'Integrasjonsnøkkel',
    'client_secret' => 'Klienthemmelighet',
];
