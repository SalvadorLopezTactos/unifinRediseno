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


$mod_strings = array (
  'ERR_DELETE_RECORD' => 'You must specify a record number in order to delete the bug.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'חשבונות',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'פעילויות',
  'LBL_ASSIGNED_TO_NAME' => 'הוקצה עבור',
  'LBL_BUG' => 'באג:',
  'LBL_BUG_INFORMATION' => 'סקירת באגים',
  'LBL_BUG_NUMBER' => 'באג מספר:',
  'LBL_BUG_SUBJECT' => 'באג בנושא:',
  'LBL_CASES_SUBPANEL_TITLE' => 'אירועים',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'אנשי קשר',
  'LBL_CONTACT_BUG_TITLE' => 'איש קשר-באג:',
  'LBL_CONTACT_NAME' => 'שם איש קשר:',
  'LBL_CONTACT_ROLE' => 'תפקיד:',
  'LBL_CREATED_BY' => 'נוצר על ידי:',
  'LBL_DATE_CREATED' => 'נוצר בתאריך:',
  'LBL_DATE_LAST_MODIFIED' => 'שונה בתאריך:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'מעקב אחר באגים',
  'LBL_DESCRIPTION' => 'תיאור:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'מסמכים',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'הוקצה למשתמש ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'הוקצה למשתמש ששמו',
  'LBL_EXPORT_CREATED_BY' => 'נוצר על ידי ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Fixed in Release Name',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'שונה על ידי ID',
  'LBL_FIXED_IN_RELEASE' => 'תוקן בגרסה:',
  'LBL_FOUND_IN_RELEASE' => 'נמצא בגרסה:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'נמצא בשחשור ששמו',
  'LBL_HELP_CREATE' => 'The {{plural_module_name}} module is used to track and manage product related problems, commonly referred to as {{plural_module_name}} or defects, either found internally or reported by customers.

To create a {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.
 - Choose "Save and view" to open the new {{module_name}} in record view.
 - Choose "Save and create new" to immediately create another new {{module_name}}.',
  'LBL_HELP_RECORD' => 'The {{plural_module_name}} module is used to track and manage product related problems, commonly referred to as {{plural_module_name}} or defects, either found internally or reported by customers.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',
  'LBL_HELP_RECORDS' => 'מודול {{plural_module_name}} משמש למעקב וניהול בעיות שקשורות למוצר, על פי רוב נקרא בשם  {{plural_module_name}} או פגמים, ונמצאו על ידי גורם בארגונך או על ידי לקוח.  {{plural_module_name}} יכול לשמש למעקב אחר פתרון הבעיות. מודול {{plural_module_name}} מספק למשתמשים דרך מהירה לצפות בפרטים של ה{{module_name}} והתהליך לפתרון. כאשר {{module_name}} נוצר, ניתן לצפות ולערוך מידע חודר אל {{module_name}} באמצעות תצוגת רשומות {{module_name}}. ניתן לקשר כל רשומת {{module_name}} לרשומות אחרות כגון {{calls_module}}, {{contacts_module}}, {{cases_module}}, ורבים אחרים.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'הסטוריה',
  'LBL_INVITEE' => 'אנשי קשר',
  'LBL_LIST_ACCOUNT_NAME' => 'שם חשבון',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'משתמשים שהוקצו',
  'LBL_LIST_CONTACT_NAME' => 'שם איש קשר',
  'LBL_LIST_EMAIL_ADDRESS' => 'כתובת דואר אלקטרוני',
  'LBL_LIST_FIXED_IN_RELEASE' => 'תוקן בגרסה',
  'LBL_LIST_FORM_TITLE' => 'רשימת באגים',
  'LBL_LIST_LAST_MODIFIED' => 'שונה לאחרונה',
  'LBL_LIST_MY_BUGS' => 'הבאגים שמוקצים אלי',
  'LBL_LIST_NUMBER' => 'מס.',
  'LBL_LIST_PHONE' => 'טלפון',
  'LBL_LIST_PRIORITY' => 'עדיפות',
  'LBL_LIST_RELEASE' => 'גרסה',
  'LBL_LIST_RESOLUTION' => 'החלטה',
  'LBL_LIST_STATUS' => 'סטאטוס',
  'LBL_LIST_SUBJECT' => 'נושא',
  'LBL_LIST_TYPE' => 'סוג',
  'LBL_MODIFIED_BY' => 'שונה לאחרונה על ידי:',
  'LBL_MODULE_ID' => 'באגים',
  'LBL_MODULE_NAME' => 'באגים',
  'LBL_MODULE_NAME_SINGULAR' => 'באג',
  'LBL_MODULE_TITLE' => 'מעקב אחר באגים: דף ראשי',
  'LBL_NEW_FORM_TITLE' => 'באג חדש',
  'LBL_NOTES_SUBPANEL_TITLE' => 'פתקים',
  'LBL_NUMBER' => 'מספר:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'אם מצאת באג שברצונך לדווח, באפשרותך להקליק כאן לדיווח',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'ניתן לסנן את רשימת הבאגים על ידי מונח לחיפוש',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'לדוגמא, אתה יכול להשתמש בזה למציאת באג שדווח בעבר',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'מודול באגים משמש לצפיה בבאגים ודיווח עליהם. השתמש בחצים למטה לסיור קצר.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'דף זה מציג באגים פעילים',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'הקלקה כאן תחזיר אותך לתצוגה זו בכל עת',
  'LBL_PORTAL_VIEWABLE' => 'נצפה בפורטל',
  'LBL_PRIORITY' => 'עדיפות:',
  'LBL_PRODUCT_CATEGORY' => 'קטגוריה:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'פרויקטים',
  'LBL_RELEASE' => 'גרסה:',
  'LBL_RESOLUTION' => 'החלטה:',
  'LBL_SEARCH_FORM_TITLE' => 'חיפוש באג',
  'LBL_SHOW_IN_PORTAL' => 'הצג בפורטל',
  'LBL_SHOW_MORE' => 'הצג באגים נוספים',
  'LBL_SOURCE' => 'מקור:',
  'LBL_STATUS' => 'סטאטוס:',
  'LBL_SUBJECT' => 'נושא:',
  'LBL_SYSTEM_ID' => 'זהוי מערכת',
  'LBL_TYPE' => 'סוג:',
  'LBL_WORK_LOG' => 'יומן עבודה:',
  'LNK_BUG_LIST' => 'צפייה בבאגים',
  'LNK_BUG_REPORTS' => 'צפה בדוח על באגים',
  'LNK_CREATE' => 'דווח על באג',
  'LNK_CREATE_WHEN_EMPTY' => 'דווח על באג כעת',
  'LNK_IMPORT_BUGS' => 'ייבוא באגים',
  'LNK_NEW_BUG' => 'דוח על באג',
  'NTC_DELETE_CONFIRMATION' => 'האם אתה בטוח שברצונך להסיר איש הקשר מבאג זה?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'האם אתה בטוח שברצונך להסיר באג זה מהחשבון?',
  'NTC_REMOVE_INVITEE' => 'האם אתה בטוח שברצונך להסיר איש הקשר מבאג זה?',
);

