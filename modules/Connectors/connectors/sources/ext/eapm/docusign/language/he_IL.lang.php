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
    'LBL_LICENSING_INFO' => 'השלבים לשימוש במחבר של DocuSign:
        <br> - יצירת מפתח שילוב
        <br> - הפעלת DocuSign Connect for Envelopes
        (כלומר, רכיב ה-Webhook המשמש את DocuSign להרשמה לנקודת כניסה של Sugar)
        <br> - הגדרת יישום חדש ב-DocuSign, הוספת ה-URI להפניה מחדש ויצירת מפתח סודי
        כתובת ה-URI להפניה מחדש חייבת להיות https://SUGAR_URL/oauth-handler/DocuSignOauth2Redirect
        <br> במקרה של הגבלות IP של המופע של Sugar, הוסף את כתובות ה-IP של DocuSign לרשימת הכתובות המותרות',
    'environment' => 'סביבה',
    'integration_key' => 'מפתח שילוב',
    'client_secret' => 'סוד הלקוח',
];
