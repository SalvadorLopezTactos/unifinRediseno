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
    'LBL_LICENSING_INFO' => 'Стъпки към използване на конектор на DocuSign:
        <br> - Генерирайте ключ за интегриране
        <br> - Активирайте DocuSign Connect за контейнери за документи
        (напр. уебхукът, използван от DocuSign за абониране за крайна точка на Sugar)
        <br> - Настройте ново приложения в DocuSign и не пропускайте да вмъкнете идентификатор uri uза пренасочване и генерирайте таен ключ.
        Идентификаторът uri за пренасочване трябва да е https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
        <br> В случай на ограничения за IP адреси на екземпляр Sugar включете IP адресите на DocuSign в списъка на разрешените адреси',
    'environment' => 'Среда',
    'integration_key' => 'Ключ за интегриране',
    'client_secret' => 'Тайна на клиент',
];
