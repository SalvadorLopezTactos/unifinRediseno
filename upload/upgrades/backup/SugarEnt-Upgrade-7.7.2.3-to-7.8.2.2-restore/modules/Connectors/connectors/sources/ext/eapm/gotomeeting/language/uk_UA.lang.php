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
'<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">
Отримайте ключ API від Citrix Online GoToMeeting, зареєструвавши новий застосунок.<br>
&nbsp;<br>
Кроки для реєстрації застосунку:<br>
&nbsp;<br>
<ol>
<li>Увійдіть в свій обліковий запис розробника Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Натисніть Apply for Developer Key (Застосувати для ключа розробника)</li>
<li>В розділі Product API (API продукту) оберіть GoToMeeting та введіть URL-адресу свого екземпляру в поле Application URL (URL-адреса застосунку)</li>
<li>В розділі Your Applications (Ваші застосунки) з’явиться стовпець з назвою API Key (Ключ API)</li>
<li>Скопіюйте його в поле нижче.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'Ключ API',
);
