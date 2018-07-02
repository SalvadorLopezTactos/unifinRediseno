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
  'ERR_NO_OPPS' => 'Please create some Opportunities to see Opportunity graphs.',
  'LBL_ALL_OPPORTUNITIES' => 'סכום כולל של כל ההזדמנויות הוא',
  'LBL_CAMPAIGN_ROI_TITLE_DESC' => 'Shows campaign response by return on investment.',
  'LBL_CHART_ACTION' => 'פעולה',
  'LBL_CHART_DCE_ACTIONS_MONTH' => 'פעולות DCE לפי סוגים (חודש נוכחי)',
  'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'מקור ליד לפי תוצאות',
  'LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS' => 'מודולים שעשיתי בהם שימוש בדוחות הישירים שלי (בשלושים הימים האחרונים)',
  'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'המודולים שהשתמשתי בהם (Last 30 Days)',
  'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'הצינור שלי לפי שלב מכירה',
  'LBL_CHART_OPPORTUNITIES_THIS_QUARTER' => 'הזדמנויות ברבעון זה',
  'LBL_CHART_OUTCOME_BY_MONTH' => 'תוצאות לפי חודש',
  'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'צינור לפי מקור ליד',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'צינורות לפי שלב מכירה',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL' => 'הצינור שלי לפי משפך שלב מכירה',
  'LBL_CHART_TYPE' => 'סוג תרשים:',
  'LBL_CLOSE_DATE_END' => 'Expected Close Date - To:',
  'LBL_CLOSE_DATE_START' => 'Expected Close Date - From:',
  'LBL_CREATED_ON' => 'הורץ לאחרונה',
  'LBL_DATE_END' => 'תאריך סיום:',
  'LBL_DATE_RANGE' => 'טווח הנתונים הוא',
  'LBL_DATE_RANGE_TO' => 'אל',
  'LBL_DATE_START' => 'תאריך התחלה:',
  'LBL_EDIT' => 'ערוך',
  'LBL_LEAD_SOURCES' => 'מקור הליד:',
  'LBL_LEAD_SOURCE_BY_OUTCOME' => 'All Opportunities By Lead Source By Outcome',
  'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Shows cumulative opportunity amounts by selected lead source by outcome for selected users.  Outcome is based on whether the sales stage is Closed Won, Closed Lost, or any other value.',
  'LBL_LEAD_SOURCE_FORM_DESC' => 'Shows cumulative opportunity amounts by selected lead source for selected users.',
  'LBL_LEAD_SOURCE_FORM_TITLE' => 'All Opportunities By Lead Source',
  'LBL_LEAD_SOURCE_OTHER' => 'אחר',
  'LBL_MODULE_NAME' => 'לוח מחונים',
  'LBL_MODULE_NAME_SINGULAR' => 'לוח מחוונים',
  'LBL_MODULE_TITLE' => 'לוח מחונים: דף רשאי',
  'LBL_MONTH_BY_OUTCOME_DESC' => 'Shows cumulative opportunity amounts by month by outcome for selected users where the expected closed date is within the specified date range.  Outcome is based on whether the sales stage is Closed Won, Closed Lost, or any other value.',
  'LBL_MY_MODULES_USED_SIZE' => 'ספירת כניסות',
  'LBL_NUMBER_OF_OPPS' => 'מספר הזדמנויות',
  'LBL_OPPS_IN_LEAD_SOURCE' => 'הזדמנות כשמקור הליד הוא',
  'LBL_OPPS_IN_STAGE' => 'כששלב המכירות הוא',
  'LBL_OPPS_OUTCOME' => 'כשהתוצאה היא',
  'LBL_OPPS_WORTH' => 'שווי ההזדמנויות',
  'LBL_OPP_SIZE' => 'גודל ההזדמנויות ב',
  'LBL_OPP_THOUSANDS' => 'K',
  'LBL_PIPELINE_FORM_TITLE_DESC' => 'Shows cumulative amounts by selected sales stages for your opportunities where the expected closed date is within the specified date range.',
  'LBL_REFRESH' => 'רענן',
  'LBL_ROLLOVER_DETAILS' => 'Rollover a bar for details.',
  'LBL_ROLLOVER_WEDGE_DETAILS' => 'Rollover a wedge for details.',
  'LBL_SALES_STAGES' => 'שלב במכירות:',
  'LBL_SALES_STAGE_FORM_DESC' => 'Shows cumulative opportunity amounts by selected sales stages for selected users where the expected closed date is within the specified date range.',
  'LBL_SALES_STAGE_FORM_TITLE' => 'Pipeline By Sales Stage',
  'LBL_TITLE' => 'כותרת:',
  'LBL_TOTAL_PIPELINE' => 'Pipeline total is',
  'LBL_USERS' => 'משתמשים:',
  'LBL_YEAR' => 'שנה:',
  'LBL_YEAR_BY_OUTCOME' => 'Pipeline By Month By Outcome',
  'LNK_NEW_ACCOUNT' => 'צור חשבון',
  'LNK_NEW_CALL' => 'יומן שיחה',
  'LNK_NEW_CASE' => 'צור אירוע',
  'LNK_NEW_CONTACT' => 'צור איש קשר',
  'LNK_NEW_ISSUE' => 'דווח על באג',
  'LNK_NEW_LEAD' => 'צור ליד',
  'LNK_NEW_MEETING' => 'תזמן פגישה',
  'LNK_NEW_NOTE' => 'Cצור פתק או צרופה',
  'LNK_NEW_OPPORTUNITY' => 'צור הזדמנות',
  'LNK_NEW_QUOTE' => 'ור הצעת מחיר',
  'LNK_NEW_TASK' => 'צור משימה',
  'NTC_NO_LEGENDS' => 'כלום',
);

