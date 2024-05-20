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
    'LBL_LICENSING_INFO' => 'Выполните следующие шаги для подключения DocuSign:
         <br> – Сгенерируйте ключ интеграции
         <br> – Включите подключение DocuSign для конвертов
         (т. е. веб-перехватчик, используемый DocuSign для подписки на точку входа Sugar)
         <br> – Настройте новое приложение в DocuSign, обязательно вставьте URI перенаправления и сгенерируйте секретный ключ клиента.
         URI перенаправления: https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
         <br> В случае ограничений IP-адресов для экземпляра Sugar внесите IP-адреса DocuSign в белый список',
    'environment' => 'Окружение',
    'integration_key' => 'Ключ интеграции',
    'client_secret' => 'Секретный ключ клиента',
];
