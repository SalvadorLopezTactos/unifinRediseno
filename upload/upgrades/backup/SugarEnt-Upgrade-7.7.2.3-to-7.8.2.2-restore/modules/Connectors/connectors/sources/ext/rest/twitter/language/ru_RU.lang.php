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
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Получите ключ пользователя и секретный ключ от Twitter, зарегистрировав свой экземпляр Sugar как новое приложение.<br/><br>Шаги для регистрации экземпляра:<br/><br/><ol><li>Зайдите на сайт для разработчиков Twitter:  <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Войдите в систему с помощью учетной записи Twitter, под которой вы хотите зарегистрировать приложение.</li><li>В форме регистрации введите имя приложения. Это имя, которое будут видеть пользователи при использовании учетной записи Twitter для аутентификации в Sugar.</li><li>Введите описание.</li><li>Введите URL-адрес веб-сайта приложения.</li><li>Введите Callback URL (URL-адрес обратного вызова) (может быть каким угодно, так как Sugar не использует его при аутентификации. Пример: введите свой URL-адрес веб-сайта Sugar).</li><li>Примите условия использования Twitter API.</li><li>Щелкните "Create your Twitter application" (Создать приложение в Twitter).</li><li>На странице приложения найдите API Key (ключ пользователя) и API Secret (секретный ключ) во вкладке "API Keys" (Ключи API). Введите их ниже.</li></ol></td></tr></table>',
    'LBL_NAME' => 'Имя пользователя в Twitter',
    'LBL_ID' => 'Имя пользователя в Twitter',
	'company_url' => 'URL',
    'oauth_consumer_key' => 'Ключ пользователя',
    'oauth_consumer_secret' => 'Секретный ключ',
);

?>
