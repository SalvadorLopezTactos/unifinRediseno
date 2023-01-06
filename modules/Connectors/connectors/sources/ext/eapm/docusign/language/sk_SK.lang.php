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
    'LBL_LICENSING_INFO' => 'Kroky na použitie konektora DocuSign:
        <br> - Vygenerujte kľúč integrácie
        <br> - Povoľte funkciu DocuSign Connect pre obálky
        (t. j. webhook, ktorý DocuSign používa na prihlásenie k vstupnému bodu Sugar)
        <br> - Nastavte novú aplikáciu v DocuSign a nezabudnite vložiť URI presmerovania a vygenerovať tajný kľúč.
       URI presmerovania musí byť https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
        <br> V prípade obmedzení IP v inštancii Sugar vytvorte zoznam povolených IP adries DocuSign',
    'environment' => 'Prostredie',
    'integration_key' => 'Kľúč integrácie',
    'client_secret' => 'Utajenie klienta',
];
