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
  'ERR_DELETE_RECORD' => 'You must specify a record number to delete the account.',
  'ERR_REMOVING_ATTACHMENT' => 'הסרת הצרופה נכשלה...',
  'LBL_ACCOUNT_ID' => 'זהות חשבון:',
  'LBL_ACTIVITIES_REPORTS' => 'דוח פעילויות',
  'LBL_CASE_ID' => 'זהות אירוע:',
  'LBL_CLOSE' => 'סגור:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'זהות איש קשר:',
  'LBL_CONTACT_NAME' => 'איש קשר:',
  'LBL_CREATED_BY' => 'נוצר על ידי',
  'LBL_DATE_ENTERED' => 'נוצר בתאריך',
  'LBL_DATE_MODIFIED' => 'שונה בתאריך',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'פתקים',
  'LBL_DELETED' => 'נמחק',
  'LBL_DESCRIPTION' => 'פתק',
  'LBL_EDITLAYOUT' => 'ערוך תצורה',
  'LBL_EMAIL_ADDRESS' => 'כתובת דואר אלקטרוני:',
  'LBL_EMAIL_ATTACHMENT' => 'צרופה לדואר אלקטרוני',
  'LBL_EMBED_FLAG' => 'לשבץ בהודעת דואר?',
  'LBL_EXPORT_PARENT_ID' => 'זהות הורה:',
  'LBL_EXPORT_PARENT_TYPE' => 'קשור למודול',
  'LBL_FILENAME' => 'צרופה:',
  'LBL_FILE_MIME_TYPE' => 'Mime Type',
  'LBL_FILE_URL' => 'לינק לקובץ',
  'LBL_FIRST_NAME' => 'שם פרטי:',
  'LBL_HELP_CREATE' => 'To create a {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.
 - Choose "Save and view" to open the new {{module_name}} in record view.
 - Choose "Save and create new" to immediately create another new {{module_name}}.',
  'LBL_HELP_RECORD' => 'The {{plural_module_name}} module consists of individual {{plural_module_name}} that contain text or an attachment pertinent to the related record.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',
  'LBL_HELP_RECORDS' => 'מודול {{plural_module_name}} מכיל {{plural_module_name}} אשר כוללים טקסט או קבצים מצורפים רלוונטיים לרשומה המקושרת. ניתן לקשר רשומות {{module_name}} לרשומה אחרת ברוב המודולים באמצעות שדה היחס הגמיש. כן ניתן לקשרו ל {{contacts_singular_module}} יחיד. {{plural_module_name}} יכול להכיל טקסט גנרי של רשומה או אפילו קובץ מצורף המקושר לרשומה. יש דרכים שונות בהן ניתן ליצור {{plural_module_name}} בשוגר למשל על ידי מודול {{plural_module_name}}, ייבוא {{plural_module_name}}, באמצעות תת פאנל היסטוריה, וכולי. כאשר נוצרת רשומת {{module_name}}, ניתן לצפות ולערוך מידע חודר ל {{module_name}} באמצעות תצוגת רשומות {{plural_module_name}}. כל רשומת {{module_name}} יכולה להיות מקושרת לרשומות שוגר אחרות כגון {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, ורבים אחרים.',
  'LBL_LAST_NAME' => 'שם משפחה:',
  'LBL_LEAD_ID' => 'זהות ליד:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'משתמש שהוקצה',
  'LBL_LIST_CONTACT' => 'איש קשר',
  'LBL_LIST_CONTACT_NAME' => 'איש קשר',
  'LBL_LIST_DATE_MODIFIED' => 'שונה לאחרונה',
  'LBL_LIST_EDIT_BUTTON' => 'ערוך',
  'LBL_LIST_FILENAME' => 'צרופה',
  'LBL_LIST_FORM_TITLE' => 'רשימת פתקים',
  'LBL_LIST_RELATED_TO' => 'קשורים אל',
  'LBL_LIST_STATUS' => 'סטאטוס',
  'LBL_LIST_SUBJECT' => 'נושא',
  'LBL_MEMBER_OF' => 'חבר ב:',
  'LBL_MODIFIED_BY' => 'שונה על ידי',
  'LBL_MODULE_NAME' => 'פתקים',
  'LBL_MODULE_NAME_SINGULAR' => 'פתק',
  'LBL_MODULE_TITLE' => 'פתקים: דף הבית',
  'LBL_MY_NOTES_DASHLETNAME' => 'הפתקים שלי',
  'LBL_NEW_FORM_BTN' => 'הוסף פתק',
  'LBL_NEW_FORM_TITLE' => 'צור פתק או צרופה',
  'LBL_NOTE' => 'פתק:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'צרופות',
  'LBL_NOTE_INFORMATION' => 'סקירת פתקים',
  'LBL_NOTE_STATUS' => 'פתק',
  'LBL_NOTE_SUBJECT' => 'נושא הפתק:',
  'LBL_OC_FILE_NOTICE' => 'ךצפייה בקבצים אנא כנס למערכת',
  'LBL_OPPORTUNITY_ID' => 'זהות ההזדמנות:',
  'LBL_PANEL_DETAILS' => 'פרטים',
  'LBL_PARENT_ID' => 'זהות הורה:',
  'LBL_PARENT_TYPE' => 'סוג הורה',
  'LBL_PHONE' => 'טלפון:',
  'LBL_PORTAL_FLAG' => 'להתיג בפורטל?',
  'LBL_PRODUCT_ID' => 'זהות מוצר:',
  'LBL_QUOTE_ID' => 'זהות הצעת מחיר:',
  'LBL_RELATED_TO' => 'קשור אל:',
  'LBL_REMOVING_ATTACHMENT' => 'מסיר צרופה...',
  'LBL_REVENUELINEITEMS' => 'שורות פרטי הכנסה',
  'LBL_SEARCH_FORM_TITLE' => 'חיפוש פתק',
  'LBL_SEND_ANYWAYS' => 'להודעה זו אין נושא.  לשלוח/לשמור בכל זאת?',
  'LBL_STATUS' => 'סטאטוס',
  'LBL_SUBJECT' => 'נושא:',
  'LNK_IMPORT_NOTES' => 'ייבוא פתקים',
  'LNK_NEW_NOTE' => 'צור פתק או צרופה',
  'LNK_NOTE_LIST' => 'פתקים',
);

