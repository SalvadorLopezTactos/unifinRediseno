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
  'ERR_DELETE_RECORD' => 'למחיקת המוצר ציין מספר רשומה.',
  'LBL_ACCOUNT_ID' => 'חשבון ID',
  'LBL_ACCOUNT_NAME' => 'שם חשבון:',
  'LBL_ASSET_NUMBER' => 'נכס מספר:',
  'LBL_ASSIGNED_TO_NAME' => 'הוקצה עבור:',
  'LBL_ASSIGNED_USER_ID' => 'שהוקצה למשתמש ID',
  'LBL_ASSOCIATED_QUOTE' => 'נושא הצעת מחיר',
  'LBL_BOOK_VALUE' => 'ערך הזמנה:',
  'LBL_BOOK_VALUE_DATE' => 'תאריך ערך הזמנה:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'ערך הזמנה (US Dollar):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'הצעת מחיר מחושבת שורת פריט סכום',
  'LBL_CAMPAIGN_PRODUCT' => 'שורת פריט הצעת מחיר לקמפיין',
  'LBL_CATEGORY' => 'קטגוריה:',
  'LBL_CATEGORY_NAME' => 'שם קטגוריה:',
  'LBL_COMMIT_STAGE' => 'שלב חיוב',
  'LBL_COMMIT_STAGE_FORECAST' => 'תחזית',
  'LBL_CONTACT' => 'איש קשר',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'אנשי קשר',
  'LBL_CONTACT_ID' => 'איש קשר ID',
  'LBL_CONTACT_NAME' => 'שם איש קשר:',
  'LBL_CONTRACTS' => 'חוזים',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'חוזים',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'שגיאה',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'התרחשה שגיאה בהמרת פריט שורת הכנסה זו להצעת מחיר',
  'LBL_COST_PRICE' => 'עלות:',
  'LBL_COST_USDOLLAR' => 'עלות (US Dollar)',
  'LBL_CREATED_USER' => 'נוצר על ידי משתמש',
  'LBL_CURRENCY' => 'מטבע:',
  'LBL_CURRENCY_ID' => 'מטבע ID',
  'LBL_CURRENCY_RATE' => 'שער מטבע',
  'LBL_CURRENCY_SYMBOL_NAME' => 'שם סימון מטבע',
  'LBL_DATE_CLOSED' => 'תאריך סגירה צפוי:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'חותם זמן תאריך סיום מצופה',
  'LBL_DATE_PURCHASED' => 'נרכש:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'תמיכה מסתיימת:',
  'LBL_DATE_SUPPORT_STARTS' => 'תמיכה מתחילה:',
  'LBL_DEAL_TOT' => 'הנחה:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'מוצרים',
  'LBL_DESCRIPTION' => 'תיאור:',
  'LBL_DISCOUNT_AMOUNT' => 'סכום ההנחה',
  'LBL_DISCOUNT_AS_PERCENT' => 'הנחה ב %',
  'LBL_DISCOUNT_PRICE' => 'מחיר יחידה:',
  'LBL_DISCOUNT_PRICE_DATE' => 'מחיר לאחר הנחה:',
  'LBL_DISCOUNT_RATE' => 'שיעור הנחה',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'שיעור הנחה (US Dollar)',
  'LBL_DISCOUNT_TOTAL' => 'סך-הכל הנחה',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'הנחה (US Dollar)',
  'LBL_DISCOUNT_USDOLLAR' => 'מחיר יחידה (US Dollar)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'מסמכים',
  'LBL_EDITLAYOUT' => 'Edit Layout',
  'LBL_EXPERT_ID' => 'מומחה מוצר',
  'LBL_EXPORT_CURRENCY_ID' => 'Currency ID',
  'LBL_EXT_PRICE' => 'מחיר שלוחה',
  'LBL_FORECAST' => 'כלול בתחזית',
  'LBL_HELP_CREATE' => 'The {{plural_module_name}} module consists of all products that have already been sold or are in the process of being sold to clients.

To create a {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.
 - Choose "Save and view" to open the new {{module_name}} in record view.
 - Choose "Save and create new" to immediately create another new {{module_name}}.',
  'LBL_HELP_RECORD' => 'The {{plural_module_name}} module consists of all products that have already been sold or are in the process of being sold to clients.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',
  'LBL_HELP_RECORDS' => 'The {{plural_module_name}} module consists of all products that have already been sold or are in the process of being sold to clients. The list of products sold by your organization is housed in Admin > Product Catalog and administrators have the ability to add products as necessary. When creating {{plural_module_name}}, you have the option to either select products from the catalog or create new products via the {{plural_module_name}} module. There are various ways you can create {{plural_module_name}} in Sugar such as via the {{plural_module_name}} module, {{quotes_module}} module, duplication, importing {{plural_module_name}}, etc. Once the {{module_name}} record is created, you can view and edit information pertaining to the {{module_name}} via the {{plural_module_name}} record view.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'לידים',
  'LBL_LEAD_SOURCE' => 'מקור הליד',
  'LBL_LIST_ACCOUNT_NAME' => 'שם חשבון',
  'LBL_LIST_CONTACT_NAME' => 'שם איש קשר',
  'LBL_LIST_COST_PRICE' => 'עלות',
  'LBL_LIST_DATE_PURCHASED' => 'נרכש',
  'LBL_LIST_DISCOUNT_PRICE' => 'מחיר',
  'LBL_LIST_FORM_TITLE' => 'רשימת מוצרים',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'מספר יצרן',
  'LBL_LIST_LIST_PRICE' => 'מחירון',
  'LBL_LIST_MANUFACTURER' => 'יצרן',
  'LBL_LIST_NAME' => 'הצעת מחיר לשורת פריט',
  'LBL_LIST_PRICE' => 'מחיר מחירון:',
  'LBL_LIST_QUANTITY' => 'כמות',
  'LBL_LIST_QUOTE_NAME' => 'שם הצעת מחיר',
  'LBL_LIST_STATUS' => 'סטאטוס',
  'LBL_LIST_SUPPORT_EXPIRES' => 'פג תוקף',
  'LBL_LIST_USDOLLAR' => 'מחיר מחירון (US Dollar)',
  'LBL_MANUFACTURER' => 'יצרנים:',
  'LBL_MANUFACTURERS' => 'יצרנים',
  'LBL_MANUFACTURER_NAME' => 'שם יצרן:',
  'LBL_MEMBER_OF' => 'חבר ב:',
  'LBL_MFT_PART_NUM' => 'מספר חלק אצל יצרן:',
  'LBL_MODIFIED_USER' => 'שונה על ידי',
  'LBL_MODULE_NAME' => 'הצעות מחיר לשורות פריטים',
  'LBL_MODULE_NAME_SINGULAR' => 'הצעת מחיר לשורת פריט',
  'LBL_MODULE_TITLE' => 'הצעות מחיר לשורות פריטים: דף הבית',
  'LBL_NAME' => 'שם',
  'LBL_NEW_FORM_TITLE' => 'צור מוצר',
  'LBL_NEXT_STEP' => 'השלב הבא',
  'LBL_NOTES_SUBPANEL_TITLE' => 'פתקים',
  'LBL_OPPORTUNITY' => 'הזדמנות',
  'LBL_OPPORTUNITY_ID' => 'ID ההזדמנות',
  'LBL_PRICING_FACTOR' => 'פקטור תימחור',
  'LBL_PRICING_FORMULA' => 'נוסחת תימחור:',
  'LBL_PROBABILITY' => 'הסתברות (%):',
  'LBL_PRODUCT' => 'הצעות מחיר לשורת פריט',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'הצעות מחיר לשורות פריטים',
  'LBL_PRODUCT_CATEGORIES' => 'קטגוריות מוצרים',
  'LBL_PRODUCT_TEMPLATE' => 'תבנית מוצר',
  'LBL_PRODUCT_TEMPLATE_ID' => 'תבנית מוצר ID:',
  'LBL_PRODUCT_TYPES' => 'סוגי מוצרים',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'פרויקטים',
  'LBL_QUANTITY' => 'כמות:',
  'LBL_QUOTE' => 'הצעת מחיר',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'הצעות מחיר',
  'LBL_QUOTE_ID' => 'הצעת מחיר ID',
  'LBL_QUOTE_NAME' => 'שם הצעת מחיר:',
  'LBL_RELATED_PRODUCTS' => 'הצעות מחיר קשורה לשורת פריט',
  'LBL_RELATED_PRODUCTS_TITLE' => 'הצעות מחיר לשורות פריט',
  'LBL_REVENUELINEITEM' => 'שורת פריט הכנסה',
  'LBL_REVENUELINEITEMS' => 'שורות פרטי הכנסה',
  'LBL_REVENUELINEITEM_ID' => 'שורת פריט הכנסה ID',
  'LBL_REVENUELINEITEM_NAME' => 'שם שורת פריט הכנסה',
  'LBL_SALES_STAGE' => 'שלב במכירות',
  'LBL_SALES_STATUS' => 'סטטוס שורת הכנסה',
  'LBL_SEARCH_FORM_TITLE' => 'חפש מוצר',
  'LBL_SELECT_DISCOUNT' => 'הנחה ב %',
  'LBL_SERIAL_NUMBER' => 'מספר סידורי:',
  'LBL_STATUS' => 'סטאטוס:',
  'LBL_SUPPORT_CONTACT' => 'איש קשר לתמיכה:',
  'LBL_SUPPORT_DESCRIPTION' => 'תיאור התמיכה:',
  'LBL_SUPPORT_NAME' => 'תמיכה,כותרת:',
  'LBL_SUPPORT_TERM' => 'צוות תמיכה:',
  'LBL_TAX_CLASS' => 'סוגי מיסים:',
  'LBL_TYPE' => 'סוג:',
  'LBL_URL' => 'מוצר URL:',
  'LBL_VENDOR_PART_NUM' => 'מספר חלק אצל ספק:',
  'LBL_WEBSITE' => 'אתר אינטרנט',
  'LBL_WEIGHT' => 'משקל:',
  'LNK_IMPORT_PRODUCTS' => 'ייבוא מוצרים',
  'LNK_NEW_PRODUCT' => 'צור מוצר',
  'LNK_PRODUCT_LIST' => 'צפה במוצרים',
  'NTC_DELETE_CONFIRMATION' => 'אתה בטוח שברצונך למחוק רשומה זו?',
  'NTC_REMOVE_CONFIRMATION' => 'אתה בטוח שברצונך למחוק יחסי גומלין עם מוצר זה?',
);

