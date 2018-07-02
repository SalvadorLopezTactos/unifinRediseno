<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

/*********************************************************************************
* Description:
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
* Reserved. Contributor(s): contact@synolia.com - www.synolia.com
* *******************************************************************************/


$connector_strings = array (
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Отримайте ключ користувача і секретний ключ від Twitter, зареєструвавши свій екземпляр Sugar як новий застосунок.<br/><br>Кроки для реєстрації екземпляру:<br/><br/><ol><li>Зайдіть на сайт для розробників Twitter: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Увійдіть в систему за допомогою облікового запису Twitter, під яким ви хочете зареєструвати застосунок.</li><li>У формі реєстрації введіть ім’я застосунку. Це ім’я будуть бачити користувачі, використовуючи свій обліковий запис в Twitter для аутентифікації в Sugar.</li><li>Введіть опис.</li><li>Введіть URL-адресу веб-сайту застосунку.</li><li>Введіть Callback URL (URL-адресу зворотного виклику) (може бути якою завгодно, оскільки Sugar не використовує її під час аутентифікації. Приклад: введіть свою URL-адресу веб-сайту Sugar).</li><li>Прийміть умови використання Twitter API.</li><li>Клацніть "Create your Twitter application" (Створити застосунок в Twitter).</li><li>На сторінці застосунку знайдіть API Key (Ключ користувача) та  API Secret (Секретний ключ) на вкладці "API Keys" (Ключі API). Введіть їх нижче.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Ім’я користувача в Twitter',
    'LBL_ID' => 'Ім’я користувача в Twitter',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'Ключ API',
    'oauth_consumer_secret' => 'Секретний ключ API',
);

?>
