<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$connector_strings = array(
    'LBL_LICENSING_INFO' =>
'<table border="0" cellspacing="1"> <tr><td valign="top" width="35%" class="dataLabel"> få API-nyckel från Citrix Online GoToMeeting genom att registrera en ny ansökan. <br><br>åtgärder för att registrera din instans: <br><br><ol><li>Logga in på ditt Citrix-konto för onlineutvecklare: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;> &nbsp;https://developer.citrixonline.com/</a></li> <li>Klicka på Verkställ för utvecklarnyckel</li> <li>I produkt API Välj GoToMeeting, och ange Webbadressens instans i programmets URL</li> <li>du kommer att se en kolumn som heter API-nyckel under din ansökan</li> <li>Kopiera den nedan.</li></ol></td></tr></table>',
    'oauth_consumer_key' => 'API-nyckel',
);
