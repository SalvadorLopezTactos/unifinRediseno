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

/* @var array $params here */
require __DIR__ . '/parameters.php';

$config['db']['db.options'] = [
    'driver' => $params['db_driver'],
    'host' => $params['db_host'],
    'port' => $params['db_port'],
    'dbname' => $params['db_name'],
    'user' => $params['db_user'],
    'password' => $params['db_password'],
    'charset' => $params['db_charset'],
];

$config['logdir'] = $params['logdir'];

$config['passwordHash'] = isset($params['passwordHash']) ? $params['passwordHash'] : [];

$config['monolog'] = isset($params['monolog']) ? $params['monolog'] : [];

$config['sts'] = isset($params['sts']) ? $params['sts'] : [];

$config['idm'] = isset($params['idm']) ? $params['idm'] : [];

$config['cookie.options'] = $params['cookie.options'] ?? [];

$config['session.storage.options'] = isset($params['session.storage.options']) ? $params['session.storage.options'] : [];

$config['logout.options'] = $params['logout.options'] ?? [];

$config['twig'] = $params['twig'] ?? [];

$config['discovery'] = $params['discovery'] ?? [];

$config['recaptcha'] = [
    'sitekey' => $params['recaptcha']['sitekey'] ?? '',
    'secretkey' => $params['recaptcha']['secretkey'] ?? '',
];

$config['honeypot'] = [
    'name' => $params['honeypot']['name'],
];

$config['grpc']['disabled'] = $params['grpc']['disabled'] ?? false;

$config['locales'] = $params['locales'] ?? [];

$config['translation'] = [
    'default' => 'en-US',
    'fallback' => ['en-US'],
    'resources' => [
        'en-US' => '/src/App/Resources/translation/en-US.xlf',
        'en-UK' => '/src/App/Resources/translation/en-UK.xlf',
        'ar-SA' => '/src/App/Resources/translation/ar-SA.xlf',
        'bg-BG' => '/src/App/Resources/translation/bg-BG.xlf',
        'ca-ES' => '/src/App/Resources/translation/ca-ES.xlf',
        'cs-CZ' => '/src/App/Resources/translation/cs-CZ.xlf',
        'da-DK' => '/src/App/Resources/translation/da-DK.xlf',
        'de-DE' => '/src/App/Resources/translation/de-DE.xlf',
        'el-EL' => '/src/App/Resources/translation/el-EL.xlf',
        'es-ES' => '/src/App/Resources/translation/es-ES.xlf',
        'es-LA' => '/src/App/Resources/translation/es-LA.xlf',
        'et-EE' => '/src/App/Resources/translation/et-EE.xlf',
        'fi-FI' => '/src/App/Resources/translation/fi-FI.xlf',
        'fr-FR' => '/src/App/Resources/translation/fr-FR.xlf',
        'he-IL' => '/src/App/Resources/translation/he-IL.xlf',
        'hr-HR' => '/src/App/Resources/translation/hr-HR.xlf',
        'hu-HU' => '/src/App/Resources/translation/hu-HU.xlf',
        'it-iT' => '/src/App/Resources/translation/it-iT.xlf',
        'ja-JP' => '/src/App/Resources/translation/ja-JP.xlf',
        'ko-KR' => '/src/App/Resources/translation/ko-KR.xlf',
        'lt-LT' => '/src/App/Resources/translation/lt-LT.xlf',
        'lv-LV' => '/src/App/Resources/translation/lv-LV.xlf',
        'nl-NL' => '/src/App/Resources/translation/nl-NL.xlf',
        'nb-NO' => '/src/App/Resources/translation/nb-NO.xlf',
        'pl-PL' => '/src/App/Resources/translation/pl-PL.xlf',
        'pt-PT' => '/src/App/Resources/translation/pt-PT.xlf',
        'pt-BR' => '/src/App/Resources/translation/pt-BR.xlf',
        'ro-RO' => '/src/App/Resources/translation/ro-RO.xlf',
        'ru-RU' => '/src/App/Resources/translation/ru-RU.xlf',
        'sk-SK' => '/src/App/Resources/translation/sk-SK.xlf',
        'sq-AL' => '/src/App/Resources/translation/sq-AL.xlf',
        'sr-RS' => '/src/App/Resources/translation/sr-RS.xlf',
        'sv-SE' => '/src/App/Resources/translation/sv-SE.xlf',
        'th-TH' => '/src/App/Resources/translation/th-TH.xlf',
        'tr-TR' => '/src/App/Resources/translation/tr-TR.xlf',
        'uk-UA' => '/src/App/Resources/translation/uk-UA.xlf',
        'zh-TW' => '/src/App/Resources/translation/zh-TW.xlf',
        'zh-CN' => '/src/App/Resources/translation/zh-CN.xlf',
    ],
];

$config['marketingExtras'] = $params['marketingExtras'] ?? [];

$config['regions'] = $params['regions'] ?? [];
