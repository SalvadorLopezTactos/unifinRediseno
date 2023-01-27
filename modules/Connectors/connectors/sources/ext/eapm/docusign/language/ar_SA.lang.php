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
    'LBL_LICENSING_INFO' => 'خطوات استخدام موصل DocuSign:
        <br> - أنشئ مفتاح تكامل
        <br> - قم بتمكين DocuSign Connect لـلمغلفات
        (مثال خطاف الويب المستخدم بواسطة DocuSign للاشتراك في نقطة دخول Sugar)
        <br> - قم بإعداد تطبيق جديد في DocuSign وتأكد من إدراج عنوان إعادة التوجيه وأنشئ مفتاحًا سريًا.
        يجب أن يكون عنوان إعادة التوجيه https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
        <br> في حالة وجود قيود IP على مثيل Sugar فضع عناوين IP لـ DocuSign في القائمة البيضاء',
    'environment' => 'البيئة',
    'integration_key' => 'مفتاح التكامل',
    'client_secret' => 'سر العميل',
];
