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
Получете API ключ от Citrix Online GoToMeeting, като регистрирате ново приложение.<br>
&nbsp;<br>
Стъпки за регистриране на Вашата инсталация:<br>
&nbsp;<br>
<ol>
<li>Влезте във Вашия профил на разработчик в Citrix Online: <a href=&#39;https://developer.citrixonline.com/&#39; target=&#39;_blank&#39;>https://developer.citrixonline.com/</a></li>
<li>Щракнете върху Кандидатстване за развоен ключ</li>
<li>В API на продукта изберете GoToMeeting и въведете URL адреса на Вашата инсталация в полето за URL адрес на приложение</li>
<li>Под Вашите приложения ще видите колона, озаглавена API ключ</li>
<li>Копирайте я по-долу.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'API ключ',
);
