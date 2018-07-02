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
  'ERR_DELETE_RECORD' => 'יש לציין מספר רשומה על מנת למחוק את ההזדמנות.',
  'LABEL_PANEL_ASSIGNMENT' => 'מטלה',
  'LBL_ACCOUNT_ID' => 'חשבון זהות',
  'LBL_ACCOUNT_NAME' => 'שם חשבון:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'פעיליות',
  'LBL_ASSIGNED_TO_ID' => 'משתמש שהוקצה:',
  'LBL_ASSIGNED_TO_NAME' => 'הוקצה עבור:',
  'LBL_CAMPAIGN' => 'קמפיין:',
  'LBL_CAMPAIGN_LINK' => 'קישור לקמפיין',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'קמפיינים',
  'LBL_CLOSED_RLIS' => 'מספר שורות פרטי הכנסה סגורות',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'הזדמנויות שנסגרו בהרכשה',
  'LBL_COMMITTED' => 'מחוייב',
  'LBL_COMMIT_STAGE' => 'שלב חיוב',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'אנשי קשר',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'קשור לדואר אלקטרוני של איש קשר',
  'LBL_CONTRACTS' => 'אנשי קשר',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'חוזים',
  'LBL_CREATED_ID' => 'נוצר על ידי זהות',
  'LBL_CREATED_USER' => 'משתמש שנוצר',
  'LBL_CURRENCIES' => 'מטבעות',
  'LBL_CURRENCY' => 'מטבע:',
  'LBL_CURRENCY_ID' => 'מטבע זהות',
  'LBL_CURRENCY_NAME' => 'שם מטבע',
  'LBL_CURRENCY_RATE' => 'שער מטבע',
  'LBL_CURRENCY_SYMBOL' => 'סימול מטבע',
  'LBL_DATE_CLOSED' => 'תאריך סגירה צפוי:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'תאריך סיום מצופה',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'הזדמנויות',
  'LBL_DESCRIPTION' => 'תיאור:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'מסמכים',
  'LBL_DUPLICATE' => 'ככל הנראה הזדמנות כפולה',
  'LBL_EDITLAYOUT' => 'ערוך תצורה',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'הוקצה למשתמש ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'הוקצה למשתמש ששמו',
  'LBL_EXPORT_CAMPAIGN_ID' => 'קמפיין ID',
  'LBL_EXPORT_CREATED_BY' => 'נוצר על ידי ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'שונה על ידי ID',
  'LBL_EXPORT_NAME' => 'שם',
  'LBL_FILENAME' => 'קובץ מצורף',
  'LBL_FORECAST' => 'כלול בתחזית',
  'LBL_HELP_CREATE' => 'The {{plural_module_name}} module allows you to track individual sales and the line items belonging to those sales from start to finish. Each {{module_name}} record represents a header for a group of {{revenuelineitems_module}} as well as relating to other important records such as {{quotes_module}}, {{contacts_module}}, etc.

To create an {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.
 - Choose "Save and view" to open the new {{module_name}} in record view.
 - Choose "Save and create new" to immediately create another new {{module_name}}.
3. After saving, use the {{revenuelineitems_module}} subpanel to add line items to the {{module_name}}.',
  'LBL_HELP_RECORD' => 'The {{plural_module_name}} module allows you to track individual sales and the line items belonging to those sales from start to finish. Each {{module_name}} record represents a header for a group of {{revenuelineitems_module}} as well as relating to other important records such as {{quotes_module}}, {{contacts_module}}, etc.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels, including {{revenuelineitems_module}}, by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',
  'LBL_HELP_RECORDS' => 'מודול {{plural_module_name}} לעקוב אחר מכירות ושורות פריטים השייכות למכירות מההתחלה לסיומן. כל רשומת {{module_name}} מייצגת כותרת לקבוצה של {{revenuelineitems_module}} וקשרים לרשומות חשובות נוספות כגון {{quotes_module}}, {{contacts_module}}, וכולי. כל {{revenuelineitems_singular_module}} הוא פוטנציאל מכירה של מוצר מסויים וכולל מידע רלוונטי למכירה. כל {{revenuelineitems_singular_module}} יופיע בדרך כלל במספר שלבים במכירה עד שהוא יסומן כ "נסגר בהצלחה" או "נסגר בכשלון". רשומת {{module_name}} משקפת את הסכום ומועד סגירה מצופה של {{revenuelineitems_module}}. {{plural_module_name}}.  {{revenuelineitems_module}} יכול להיות ממונף עוד על ידי שימוש במודול {{forecasts_singular_module}} על מנת להבין ולצפות מגמות מכירה ולמקד משאבים להשגת יעדי מכירה.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'הסטוריה',
  'LBL_INVITEE' => 'אנשי קשר',
  'LBL_LEADS_SUBPANEL_TITLE' => 'לידים',
  'LBL_LEAD_SOURCE' => 'מקור הליד:',
  'LBL_LIST_ACCOUNT_NAME' => 'שם חשבון',
  'LBL_LIST_AMOUNT' => 'סכום ההזדמנות',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'סכום',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'משתמש שהוקצה',
  'LBL_LIST_DATE_CLOSED' => 'נסגר',
  'LBL_LIST_FORM_TITLE' => 'רשימת הזדמנויות',
  'LBL_LIST_OPPORTUNITY_NAME' => 'שם',
  'LBL_LIST_SALES_STAGE' => 'שלב במכירות',
  'LBL_MKTO_ID' => 'Marketo® ליד ID',
  'LBL_MKTO_SYNC' => 'סנכרן עם Marketo®',
  'LBL_MODIFIED_ID' => 'שונה על ידי זהות',
  'LBL_MODIFIED_NAME' => 'שונה על ידי שם משתמש',
  'LBL_MODIFIED_USER' => 'משתמש ששונה',
  'LBL_MODULE_NAME' => 'הזדמנויות',
  'LBL_MODULE_NAME_SINGULAR' => 'הזדמנות',
  'LBL_MODULE_TITLE' => 'הזדמנויות: דף הבית',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'ההזדמנויות הסגורות שלי',
  'LBL_NAME' => 'שם ההזדמנות',
  'LBL_NEW_FORM_TITLE' => 'צור הזדמנות',
  'LBL_NEXT_STEP' => 'השלב הבא:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'פתקים',
  'LBL_OPPORTUNITY' => 'הזדמנות:',
  'LBL_OPPORTUNITY_NAME' => 'שם ההזדמנות:',
  'LBL_OPPORTUNITY_ROLE' => 'תפקיד הזדמנות',
  'LBL_OPPORTUNITY_TYPE' => 'סוג הזדמנות',
  'LBL_PIPELINE_TOTAL_IS' => 'סך הכל לצינור מכירות',
  'LBL_PRIMARY_QUOTE_ID' => 'תהצעת מחיר ראשי',
  'LBL_PROBABILITY' => 'הסתברות (%):',
  'LBL_PRODUCTS' => 'שורות פריטים מצוטטים',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'פרטי שורה מצוטטים',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'פרויקטים',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'פרוייקטים',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'הצעות מחיר',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'הצעות מחיר',
  'LBL_RAW_AMOUNT' => 'סכום גלמי',
  'LBL_RLI' => 'שורות פרטי רווח',
  'LBL_RLI_SUBPANEL_TITLE' => 'שורות פרטי הכנסה',
  'LBL_SALES_STAGE' => 'שלב במכירות:',
  'LBL_SALES_STATUS' => 'סטטוס',
  'LBL_SEARCH_FORM_TITLE' => 'חיפוש הזדמנויות',
  'LBL_TEAM_ID' => 'צוות זהות',
  'LBL_TIMEPERIODS' => 'תקופות זמן',
  'LBL_TIMEPERIOD_ID' => 'תקופת זמן ID',
  'LBL_TOP_OPPORTUNITIES' => 'ההזדמנויות הבשלות שלי',
  'LBL_TOTAL_OPPORTUNITIES' => 'סך-בכל הזדמנויות',
  'LBL_TOTAL_RLIS' => 'סך הכל פרטי שורות הכנסה',
  'LBL_TYPE' => 'סוג:',
  'LBL_VIEW_FORM_TITLE' => 'צפייה בהזדמנות',
  'LBL_WORKSHEET' => 'גיליון עבודה',
  'LNK_CREATE' => 'צור עסקה',
  'LNK_IMPORT_OPPORTUNITIES' => 'ייבוא הזדמנויות',
  'LNK_NEW_OPPORTUNITY' => 'צור הזדמנות',
  'LNK_OPPORTUNITY_LIST' => 'צפה בהזדמנויות',
  'LNK_OPPORTUNITY_REPORTS' => 'צפייה בדוחות על הזדמנויות',
  'MSG_DUPLICATE' => 'The opportunity record you are about to create might be a duplicate of a opportunity record that already exists. Opportunity records containing similar names are listed below.<br>Click Save to continue creating this new opportunity, or click Cancel to return to the module without creating the opportunity.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'לא ניתן למחוק הזדמנויות המכילות פרטי שורות רווח',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'האם אתה בטוח שברצונך להסיר איש קשר זה מההזדמנות?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'האם אתה בטוח שברצונך להסיר הזדמנות זו מהפרוייקט?',
  'TPL_RLI_CREATE' => 'הזדמנות חייבת לכלול פריט שורת הכנסה מקושר',
  'TPL_RLI_CREATE_LINK_TEXT' => 'צור פריט שורת הכנסה',
  'UPDATE' => 'Opportunity - עדכון מטבע',
  'UPDATE_BUGFOUND_COUNT' => 'באגים נמצאו:',
  'UPDATE_BUG_COUNT' => 'נמצא באג ונסיתי לפתור אותו:',
  'UPDATE_COUNT' => 'רשומות שעודכנו:',
  'UPDATE_CREATE_CURRENCY' => 'יוצר מטבע חדש:',
  'UPDATE_DOLLARAMOUNTS' => 'עדכן שער חליפין לדולר',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Update the U.S. Dollar amounts for opportunities based on the current set currency rates. This value is used to calculate Graphs and List View Currency Amounts.',
  'UPDATE_DONE' => 'בוצע',
  'UPDATE_FAIL' => 'לא הצלחתי לעדכן -',
  'UPDATE_FIX' => 'שער חליפין קבוע',
  'UPDATE_FIX_TXT' => 'Attempts to fix any invalid amounts by creating a valid decimal from the current amount. Any modified amount is backed up in the amount_backup database field. If you run this and notice bugs, do not rerun it without restoring from the backup as it may overwrite the backup with new invalid data.',
  'UPDATE_INCLUDE_CLOSE' => 'לכלול רשומות שנסגרו',
  'UPDATE_MERGE' => 'מזג מטבעות',
  'UPDATE_MERGE_TXT' => 'Merge multiple currencies into a single currency. If there are multiple currency records for the same currency, you merge them together. This will also merge the currencies for all other modules.',
  'UPDATE_NULL_VALUE' => 'הכמות היא NULL ותוגדר כ-0',
  'UPDATE_RESTORE' => 'שחזר שער חליפין',
  'UPDATE_RESTORE_COUNT' => 'רשומות שערי חליפין ששוחזרו:',
  'UPDATE_RESTORE_TXT' => 'שחזר שערי חליפין מגבוי שבוצע תוך כדי תיקון.',
  'UPDATE_VERIFY' => 'וודא שער חליפין',
  'UPDATE_VERIFY_CURAMOUNT' => 'שער חליפין:',
  'UPDATE_VERIFY_FAIL' => 'רשומה נכלשה בעדכון:',
  'UPDATE_VERIFY_FIX' => 'הרצת תיקון תאפשר',
  'UPDATE_VERIFY_NEWAMOUNT' => 'שער חליפין חדש:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'מטבע חדש:',
  'UPDATE_VERIFY_TXT' => 'Verifies that the amount values in opportunities are valid decimal numbers with only numeric characters(0-9) and decimals(.)',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'רשומה אחת או יותר שנבחרו מכילות פרטי שורות רווח סגורות ואינן ניתנות למחיקה',
);

