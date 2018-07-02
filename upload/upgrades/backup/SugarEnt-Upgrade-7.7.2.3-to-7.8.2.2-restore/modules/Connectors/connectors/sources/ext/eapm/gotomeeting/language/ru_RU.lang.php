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
Получите ключ API от Citrix Online GoToMeeting, зарегистрировав новое приложение.<br>
&nbsp;<br>
Шаги для регистрации экземпляра:<br>
&nbsp;<br>
<ol>
<li>Войдите в свою учетную запись разработчика Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Нажмите кнопку Apply for Developer Key (Применить для ключа разработчика)</li>
<li>В разделе Product API (API продукта) выберите GoToMeeting и введите URL-адрес своего экземпляра в поле Application URL (URL-адрес приложения)</li>
<li>В разделе Your Applications (Ваши приложения) появится столбец с названием API Key (Ключ API)</li>
<li>Скопируйте ключ в поле ниже.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'Ключ пользователя',
);
