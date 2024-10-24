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

$mod_strings = [
    // Dashboard Names
    'LBL_OPPORTUNITIES_LIST_DASHBOARD' => 'แดชบอร์ดรายการโอกาส',
    'LBL_OPPORTUNITIES_RECORD_DASHBOARD' => 'แดชบอร์ดบันทึกโอกาส',
    'LBL_OPPORTUNITIES_MULTI_LINE_DASHBOARD' => 'แดชบอร์ดเน้นโอกาสในการขาย - คอนโซล',
    'LBL_OPPORTUNITIES_FOCUS_DRAWER_DASHBOARD' => 'โอกาสทางการขายระบบลิ้นชัก',
    'LBL_RENEWAL_OPPORTUNITY' => 'การต่ออายุโอกาสทางการขาย',

    'LBL_MODULE_NAME' => 'โอกาสทางการขาย',
    'LBL_MODULE_NAME_SINGULAR' => 'โอกาสทางการขาย',
    'LBL_MODULE_TITLE' => 'โอกาสทางการขาย: หน้าแรก',
    'LBL_SEARCH_FORM_TITLE' => 'การค้นหาโอกาสทางการขาย',
    'LBL_VIEW_FORM_TITLE' => 'มุมมองโอกาสทางการขาย',
    'LBL_LIST_FORM_TITLE' => 'รายการโอกาสทางการขาย',
    'LBL_OPPORTUNITY_NAME' => 'ชื่อโอกาสทางการขาย:',
    'LBL_OPPORTUNITY' => 'โอกาสทางการขาย:',
    'LBL_NAME' => 'ชื่อโอกาสทางการขาย',
    'LBL_TIME' => 'เวลา',
    'LBL_INVITEE' => 'ที่อยู่ติดต่อ',
    'LBL_CURRENCIES' => 'สกุลเงิน',
    'LBL_LIST_OPPORTUNITY_NAME' => 'ชื่อ',
    'LBL_LIST_ACCOUNT_NAME' => 'ชื่อบัญชี',
    'LBL_LIST_DATE_CLOSED' => 'วันที่ปิดที่คาดไว้',
    'LBL_LIST_AMOUNT' => 'เป็นไปได้',
    'LBL_LIST_AMOUNT_USDOLLAR' => 'จำนวนเงินที่แปลง',
    'LBL_ACCOUNT_ID' => 'ID บัญชี',
    'LBL_CURRENCY_RATE' => 'อัตราสกุลเงิน',
    'LBL_CURRENCY_ID' => 'ID สกุลเงิน',
    'LBL_CURRENCY_NAME' => 'ชื่อสกุลเงิน',
    'LBL_CURRENCY_SYMBOL' => 'สัญลักษณ์สกุลเงิน',
//DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_sales_stage' => 'LBL_LIST_SALES_STAGE',
    'db_name' => 'LBL_NAME',
    'db_amount' => 'LBL_LIST_AMOUNT',
    'db_date_closed' => 'LBL_LIST_DATE_CLOSED',
//END DON'T CONVERT
    'UPDATE' => 'โอกาสทางการขาย - การอัปเดตสกุลเงิน',
    'UPDATE_DOLLARAMOUNTS' => 'อัปเดตจำนวนเงินดอลลาร์สหรัฐ',
    'UPDATE_VERIFY' => 'ยืนยันจำนวนเงิน',
    'UPDATE_VERIFY_TXT' => 'ยืนยันว่าค่าจำนวนเงินของโอกาสทางการขายเป็นตัวเลขฐานสิบที่ถูกต้อง โดยมีอักขระตัวเลข (0-9) และจุดทศนิยม (.) เท่านั้น',
    'UPDATE_FIX' => 'แก้ไขจำนวนเงิน',
    'UPDATE_FIX_TXT' => 'พยายามแก้ไขจำนวนเงินที่ไม่ถูกต้องด้วยการสร้างค่าฐานสิบที่ถูกต้องจากจำนวนเงินปัจจุบัน จำนวนเงินที่แก้ไขจะมีการสำรองไว้ในฟิลด์ฐานข้อมูล amount_backup ถ้าคุณเรียกใช้คำสั่งนี้และพบบัก โปรดอย่าเรียกใช้ซ้ำโดยไม่เรียกคืนจากการสำรองข้อมูล มิฉะนั้นอาจมีการเขียนทับข้อมูลสำรองด้วยข้อมูลใหม่ที่ไม่ถูกต้อง',
    'UPDATE_DOLLARAMOUNTS_TXT' => 'อัปเดตจำนวนเงินเป็นดอลลาร์สหรัฐสำหรับโอกาสทางการขายโดยอ้างอิงอัตราแลกเปลี่ยนของสกุลเงินชุดปัจจุบัน ค่านี้ใช้คำนวณจำนวนเงินของสกุลเงินในกราฟและมุมมองรายการ',
    'UPDATE_CREATE_CURRENCY' => 'กำลังสร้างสกุลเงินใหม่:',
    'UPDATE_VERIFY_FAIL' => 'ระเบียนไม่ผ่านการยืนยัน:',
    'UPDATE_VERIFY_CURAMOUNT' => 'จำนวนเงินปัจจุบัน:',
    'UPDATE_VERIFY_FIX' => 'การเรียกใช้การแก้ไขจะทำให้',
    'UPDATE_INCLUDE_CLOSE' => 'รวมระเบียนที่ปิด',
    'UPDATE_VERIFY_NEWAMOUNT' => 'จำนวนใหม่:',
    'UPDATE_VERIFY_NEWCURRENCY' => 'สกุลเงินใหม่:',
    'UPDATE_DONE' => 'เสร็จสิ้น',
    'UPDATE_BUG_COUNT' => 'บักที่พบและพยายามแก้ไข:',
    'UPDATE_BUGFOUND_COUNT' => 'บักที่พบ:',
    'UPDATE_COUNT' => 'ระเบียนที่อัปเดต:',
    'UPDATE_RESTORE_COUNT' => 'จำนวนเงินของระเบียนที่เรียกคืน:',
    'UPDATE_RESTORE' => 'เรียกคืนจำนวนเงิน',
    'UPDATE_RESTORE_TXT' => 'เรียกคืนค่าของจำนวนเงินจากการสำรองข้อมูลที่สร้างขึ้นระหว่างการแก้ไข',
    'UPDATE_FAIL' => 'ไม่สามารถอัปเดต - ',
    'UPDATE_NULL_VALUE' => 'จำนวนเงินเป็นค่าว่างเปล่า กำลังตั้งค่าเป็น 0 -',
    'UPDATE_MERGE' => 'ผสานสกุลเงิน',
    'UPDATE_MERGE_TXT' => 'ผสานหลายสกุลเงินเป็นสกุลเงินเดียว ถ้ามีระเบียนสกุลเงินหลายระเบียนสำหรับสกุลเงินเดียวกัน คุณสามารถผสานรวมไว้ด้วยกัน ซึ่งจะทำให้ระบบผสานสกุลเงินสำหรับโมดูลอื่นๆ ทั้งหมดด้วย',
    'LBL_ACCOUNT_NAME' => 'ชื่อบัญชี:',
    'LBL_CURRENCY' => 'สกุลเงิน:',
    'LBL_DATE_CLOSED' => 'วันที่ปิดที่คาดไว้:',
    'LBL_DATE_CLOSED_TIMESTAMP' => 'เวลาระบบของวันที่ปิดที่คาดไว้',
    'LBL_TYPE' => 'ประเภท:',
    'LBL_CAMPAIGN' => 'แคมเปญ:',
    'LBL_NEXT_STEP' => 'ขั้นตอนถัดไป:',
    'LBL_SERVICE_START_DATE' => 'วันเริ่มต้นการบริการ',
    'LBL_LEAD_SOURCE' => 'ที่มาของผู้สนใจ',
    'LBL_SALES_STAGE' => 'ขั้นตอนการขาย',
    'LBL_SALES_STATUS' => 'สถานะ',
    'LBL_PROBABILITY' => 'ความน่าจะเป็น (%)',
    'LBL_DESCRIPTION' => 'คำอธิบาย',
    'LBL_DUPLICATE' => 'โอกาสทางการขายอาจซ้ำกัน',
    'MSG_DUPLICATE' => 'ระเบียนโอกาสทางการขายที่คุณต้องการสร้างอาจซ้ำกับระเบียนโอกาสทางการขายที่มีอยู่แล้ว ด้านล่างนี้เป็นรายชื่อของระเบียนโอกาสทางการขายที่มีชื่อคล้ายกัน<br>คุณสามารถคลิกบันทึกเพื่อสร้างโอกาสทางการขายใหม่นี้ต่อไป หรือคลิกยกเลิกเพื่อกลับสู่โมดูลโดยไม่สร้างโอกาสทางการขาย',
    'LBL_NEW_FORM_TITLE' => 'สร้างโอกาสทางการขาย',
    'LNK_NEW_OPPORTUNITY' => 'สร้างโอกาสทางการขาย',
    'LNK_CREATE' => 'สร้างข้อตกลง',
    'LNK_OPPORTUNITY_LIST' => 'ดูโอกาสทางการขาย',
    'ERR_DELETE_RECORD' => 'ต้องระบุเลขที่ระเบียนเพื่อลบโอกาสทางการขาย',
    'LBL_TOP_OPPORTUNITIES' => 'โอกาสทางการขายที่เปิดอันดับสูงสุดของฉัน',
    'NTC_REMOVE_OPP_CONFIRMATION' => 'คุณแน่ใจหรือไม่ว่าต้องการย้ายที่อยู่ติดต่อนี้ออกจากโอกาสทางการขาย',
    'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'คุณแน่ใจหรือไม่ว่าต้องการย้ายโอกาสทางการขายนี้ออกจากโครงการ',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'โอกาสทางการขาย',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'กิจกรรม',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'ประวัติ',
    'LBL_RAW_AMOUNT' => 'จำนวนเงินขั้นต้น',
    'LBL_LEADS_SUBPANEL_TITLE' => 'ผู้สนใจ',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'ที่อยู่ติดต่อ',
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'เอกสาร',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'โครงการ',
    'LBL_ASSIGNED_TO_NAME' => 'ระบุให้:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'ผู้ใช้ที่ระบุ',
    'LBL_LIST_SALES_STAGE' => 'ขั้นตอนการขาย',
    'LBL_MY_CLOSED_OPPORTUNITIES' => 'โอกาสทางการขายที่ปิดของฉัน',
    'LBL_TOTAL_OPPORTUNITIES' => 'โอกาสทางการขายรวม',
    'LBL_CLOSED_WON_OPPORTUNITIES' => 'โอกาสทางการขายที่ปิดโดยได้รับการขาย',
    'LBL_ASSIGNED_TO_ID' => 'ผู้ใช้ที่ระบุ:',
    'LBL_CREATED_ID' => 'สร้างโดย ID',
    'LBL_MODIFIED_ID' => 'แก้ไขโดย ID',
    'LBL_MODIFIED_NAME' => 'แก้ไขโดยชื่อผู้ใช้',
    'LBL_CREATED_USER' => 'ผู้ใช้ที่สร้าง',
    'LBL_MODIFIED_USER' => 'ผู้ใช้ที่แก้ไข',
    'LBL_CAMPAIGN_OPPORTUNITY' => 'โอกาสทางการขายของแคมเปญ',
    'LBL_PROJECT_SUBPANEL_TITLE' => 'โครงการ',
    'LABEL_PANEL_ASSIGNMENT' => 'การมอบหมาย',
    'LNK_IMPORT_OPPORTUNITIES' => 'นำเข้าโอกาสทางการขาย',
    'LBL_EDITLAYOUT' => 'แก้ไขเลย์เอาต์' /*for 508 compliance fix*/,
    //For export labels
    'LBL_EXPORT_CAMPAIGN_ID' => 'ID แคมเปญ',
    'LBL_OPPORTUNITY_TYPE' => 'ประเภทโอกาสทางการขาย',
    'LBL_EXPORT_ASSIGNED_USER_NAME' => 'ชื่อผู้ใช้ที่ระบุ',
    'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID ผู้ใช้ที่ระบุ',
    'LBL_EXPORT_MODIFIED_USER_ID' => 'แก้ไขโดย ID',
    'LBL_EXPORT_CREATED_BY' => 'สร้างโดย ID',
    'LBL_EXPORT_NAME' => 'ชื่อ',
    // SNIP
    'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'อีเมลของผู้ติดต่อที่เกี่ยวข้อง',
    'LBL_FILENAME' => 'ไฟล์แนบ',
    'LBL_PRIMARY_QUOTE_ID' => 'การเสนอราคาหลัก',
    'LBL_CONTRACTS' => 'สัญญา',
    'LBL_CONTRACTS_SUBPANEL_TITLE' => 'สัญญา',
    'LBL_PRODUCTS' => 'รายการบรรทัดการเสนอราคา',
    'LBL_RLI' => 'รายการบรรทัดรายได้',
    'LNK_OPPORTUNITY_REPORTS' => 'ดูรายงานโอกาสทางการขาย',
    'LBL_QUOTES_SUBPANEL_TITLE' => 'การเสนอราคา',
    'LBL_TEAM_ID' => 'ID ทีม',
    'LBL_TIMEPERIODS' => 'ช่วงเวลา',
    'LBL_TIMEPERIOD_ID' => 'ID ช่วงเวลา',
    'LBL_COMMITTED' => 'คอมมิตแล้ว',
    'LBL_FORECAST' => 'รวมในประมาณการ',
    'LBL_COMMIT_STAGE' => 'ขั้นตอนที่คอมมิต',
    'LBL_COMMIT_STAGE_FORECAST' => 'ขั้นตอนการประมาณการ',
    'LBL_WORKSHEET' => 'เวิร์กชีท',
    'LBL_PURCHASED_LINE_ITEMS' => 'สินค้าในไลน์ที่ซื้อมา',

    // KPI Metrics
    'LBL_ORGANIZE' => 'จัดระเบียบ',
    'LBL_CREATE_NEW' => 'สร้างใหม่',
    'LBL_MANAGE' => 'จัดการ',
    'LBL_SEE_DETAILS' => 'ดูรายละเอียด',
    'LBL_HIDE_NEW' => 'ซ่อน',

    'LBL_FORECASTED_LIKELY' => 'แนวโน้มการพยากรณ์',
    'LBL_LOST' => 'การขายไม่สำเร็จ',
    'LBL_RENEWAL' => 'การต่ออายุ',
    'LBL_RENEWAL_OPPORTUNITIES' => 'การต่ออายุโอกาสทางการขาย',
    'LBL_RENEWAL_PARENT' => 'โอกาสทางการขายหลัก',
    'LBL_PARENT_RENEWAL_OPPORTUNITY_ID' => 'ID หลักของการต่ออายุ',
    'LBL_MONTH_YEAR_RENEWAL' => '{{month}}, {{year}}',

    'LBL_WIDGET_SALES_STAGE' => 'ขั้นตอนการขาย',
    'LBL_WIDGET_DATE_CLOSED' => 'วันที่ปิดที่คาดไว้',
    'LBL_WIDGET_AMOUNT' => 'จำนวน',

    'TPL_RLI_CREATE' => 'โอกาสทางการขายต้องมีรายการบรรทัดรายได้ที่เกี่ยวข้อง',
    'TPL_RLI_CREATE_LINK_TEXT' => 'สร้างรายการบรรทัดรายได้',
    'LBL_PRODUCTS_SUBPANEL_TITLE' => 'รายการบรรทัดการเสนอราคา',
    'LBL_RLI_SUBPANEL_TITLE' => 'รายการบรรทัดรายได้',

    'LBL_TOTAL_RLIS' => 'จำนวนรายการบรรทัดรายได้ทั้งหมด',
    'LBL_CLOSED_RLIS' => 'จำนวนรายการบรรทัดรายได้ที่ปิด',
    'LBL_CLOSED_WON_RLIS' => '# จำนวนรายการบรรทัดรายได้ที่ปิดการขายสำเร็จ',
    'LBL_SERVICE_OPEN_FLEX_DURATION_RLIS' => '# ของช่วงรายได้สินค้าในไลน์ Open Service Flex',
    'NOTICE_NO_DELETE_CLOSED_RLIS' => 'คุณไม่สามารถลบโอกาสทางการขายที่มีรายการบรรทัดรายได้ที่ปิด',
    'WARNING_NO_DELETE_CLOSED_SELECTED' => 'ระเบียนที่เลือกไว้บางรายการมีรายการบรรทัดรายได้ที่ปิด และไม่สามารถลบได้',
    'LBL_INCLUDED_RLIS' => 'จำนวนรายการบรรทัดรายได้ที่รวม',
    'LBL_UPDATE_OPPORTUNITIES_RLIS' => 'เปิดการอัปเดต',
    'LBL_CASCADE_RLI_EDIT' => 'อัปเดตสร้างรายการบรรทัดรายได้',
    'LBL_CASCADE_RLI_CREATE' => 'ตั้งรายการบรรทัดรายได้',
    'LBL_SERVICE_START_DATE_INVALID' => 'วันที่เริ่มบริการไม่สามารถกำหนดให้อยู่เลยวันที่สิ้นสุดการบริการของรายการบรรทัดรายได้เสริม ที่เปิดอยู่ทุกรายการได้',

    'LBL_QUOTE_SUBPANEL_TITLE' => 'การเสนอราคา',
    'LBL_FILTER_OPPORTUNITY_TEMPLATE' => 'โอกาสทางการขายแยกตามบัญชีไดนามิก',
    'LBL_TOP_10_OPP' => 'โอกาสทางการขาย 10 อันดับที่เปิดอยู่',
    'LBL_DASHLET_MY_ACTIVE_OPP' => 'ส่วนข้อมูล: โอกาสทางการขายที่ทำงานอยู่ของฉัน',
    'LBL_MY_ACTIVE_OPP' => 'โอกาสทางการขายที่ทำงานอยู่ของฉัน',


    // Config
    'LBL_OPPS_CONFIG_VIEW_BY_LABEL' => 'ลำดับชั้นของโอกาสทางการขาย',
    'LBL_OPPS_CONFIG_VIEW_BY_DATE_ROLLUP' => 'ตั้งค่าฟิลด์วันที่ปิดที่คาดไว้ในระเบียนโอกาสทางการขายที่ได้มาให้เป็นวันที่ปิดเร็วที่สุดหรือช้าที่สุดของรายการบรรทัดรายได้ที่มีอยู่',

    //Dashlet
    'LBL_PIPELINE_TOTAL_IS' => 'ผลรวมของกระบวนการขายคือ ',

    'LBL_OPPORTUNITY_ROLE' => 'บทบาทของโอกาสทางการขาย',
    'LBL_NOTES_SUBPANEL_TITLE' => 'บันทึก',
    'LBL_TAB_OPPORTUNITY' => 'ตรวจทาน {{module}}',

    // Help Text
    'LBL_OPPS_CONFIG_ALERT' => 'เมื่อคลิกยืนยัน คุณจะลบข้อมูลประมาณการทั้งหมดและเปลี่ยนมุมมองโอกาสทางการขาย ถ้าคุณไม่ได้ต้องการดำเนินการนี้ ให้คลิกยกเลิกเพื่อกลับสู่การตั้งค่าก่อนหน้า',
    'LBL_OPPS_CONFIG_ALERT_TO_OPPS' =>
        'เมื่อคลิกยืนยัน คุณจะลบข้อมูลประมาณการทั้งหมดและเปลี่ยนมุมมองโอกาสทางการขาย '
        . 'และการกำหนดกระบวนการทั้งหมดที่มีโมดูลเป้าหมายเป็นรายการบรรทัดรายได้จะถูกปิดใช้งาน '
        . 'ถ้าคุณไม่ได้ต้องการดำเนินการนี้ ให้คลิกยกเลิกเพื่อกลับสู่การตั้งค่าก่อนหน้า',
    'LBL_OPPS_CONFIG_SALES_STAGE_1a' => 'ถ้ามีการปิดรายการบรรทัดรายได้ทั้งหมด และมีอย่างน้อยหนึ่งรายการที่ได้รับการขาย',
    'LBL_OPPS_CONFIG_SALES_STAGE_1b' => 'ขั้นตอนการขายของโอกาสทางการขายถูกตั้งค่าเป็น "ปิดโดยได้รับการขาย"',
    'LBL_OPPS_CONFIG_SALES_STAGE_2a' => 'ถ้ารายการบรรทัดรายได้ทั้งหมดอยู่ในขั้นตอนการขาย "ปิดโดยไม่ได้รับการขาย"',
    'LBL_OPPS_CONFIG_SALES_STAGE_2b' => 'ขั้นตอนการขายของโอกาสทางการขายถูกตั้งค่าเป็น "ปิดโดยไม่ได้รับการขาย"',
    'LBL_OPPS_CONFIG_SALES_STAGE_3a' => 'ถ้ายังมีรายการบรรทัดรายได้ที่เปิดอยู่',
    'LBL_OPPS_CONFIG_SALES_STAGE_3b' => 'โอกาสทางการขายจะถูกทำเครื่องหมายเป็นขั้นตอนการขายที่เป็นขั้นต้นที่สุด',

// BEGIN ENT/ULT

    // Opps Config - View By Opportunities
    'LBL_HELP_CONFIG_OPPS' => 'หลังจากที่เริ่มต้นการเปลี่ยนแปลงนี้ หมายเหตุการสรุปรายการบรรทัดรายได้จะถูกสร้างขึ้นในพื้นหลัง เมื่อบันทึกเสร็จสมบูรณ์และใช้ได้ จะมีการส่งการแจ้งเตือนไปยังที่อยู่อีเมลในโปรไฟล์ผู้ใช้ของคุณ ถ้าอินสแตนซ์ของคุณมีการตั้งค่าสำหรับ {{forecasts_module}} ไว้ Sugar จะส่งการแจ้งเตือนถึงคุณเมื่อระเบียน {{module_name}} ของคุณซิงค์กับโมดูล {{forecasts_module}} และสามารถใช้ได้สำหรับ {{forecasts_module}} ใหม่ โปรดทราบว่าอินสแตนซ์ของคุณจะต้องมีการกำหนดค่าให้ส่งอีเมลผ่านทาง การดูแลระบบ > การตั้งค่าอีเมล เพื่อให้ระบบสามารถส่งอีเมลได้',

    // Opps Config - View By Opportunities And RLIs
    'LBL_HELP_CONFIG_RLIS' => 'หลังจากที่คุณเริ่มต้นการเปลี่ยนแปลงนี้ ระเบียนรายการบรรทัดรายได้จะได้รับการสร้างขึ้นสำหรับ {{module_name}} ที่มีอยู่แล้วแต่ละรายการในพื้นหลัง เมื่อรายการบรรทัดรายได้เสร็จสมบูรณ์และใช้ได้ จะมีการส่งการแจ้งเตือนไปยังที่อยู่อีเมลในโปรไฟล์ผู้ใช้ของคุณ โปรดทราบว่าอินสแตนซ์ของคุณจะต้องมีการกำหนดค่าให้ส่งอีเมลผ่านทาง การดูแลระบบ > การตั้งค่าอีเมล เพื่อให้ระบบสามารถส่งอีเมลได้',
    // List View Help Text
    'LBL_HELP_RECORDS' => 'โมดูล {{plural_module_name}} ช่วยให้คุณสามารถติดตามการขายจากเริ่มต้นจนจบ แต่ละระเบียน {{module_name}} จะแสดงเป้าหมายการขาย และรวมข้อมูลการขายต่าง ๆ เข้าไว้ด้วยกันพร้อมด้วยระเบียนสำคัญต่าง ๆ ที่เกี่ยวข้อง เช่น {{quotes_module}}, {{contacts_module}} เป็นต้น ทั้งนี้ {{module_name}} มักจะดำเนินการผ่านขั้นตอนการขายหลายขั้นตอนจนกระทั่งมันจะถูกทำเครื่องหมาย "ปิดโดยได้รับการขาย" หรือ "ปิดโดยไม่ได้รับการขาย" กำกับไว้ {{plural_module_name}} ยังสามารถนำมาใช้ประโยชน์ได้แม้ในอนาคตโดยการใช้โมดูล {{forecasts_singular_module}}ของ Sugar เพื่อทำความเข้าใจ และพยากรณ์เทรนด์การขาย พร้อมมุ่งเน้นการทำงานเพื่อให้บรรลุโควตาการขาย',

    // Record View Help Text
    'LBL_HELP_RECORD' => 'โมดูล {{plural_module_name}} ช่วยให้คุณสามารถติดตามการขายแต่ละรายการ และสินค้าในไลน์ที่เป็นของการขายเหล่านั้นตั้งแต่ต้นจนจบ ระเบียน {{module_name}} แต่ละอันจะแสดงการขายที่คาดคะเนไว้ และข้อมูลการขายที่เกี่ยวข้องกัน รวมถึงระเบียนสำคัญอื่น ๆ ที่เกี่ยวข้อง เช่น {{quotes_module}} และ{{contacts_module}} เป็นต้น

- แก้ไขฟิลด์ของระเบียนนี้โดยคลิกลงบนแต่ละฟิลด์ หรือที่ปุ่มแก้ไข 
- ดูหรือแก้ไขลิงก์ไปยังระเบียนอื่นในแผงข้อมูลย่อยโดยสลับหน้าต่างด้านล่างซ้ายเป็น "การดูข้อมูล" 
- สร้างและดูความคิดเห็นของผู้ใช้ และประวัติการเปลี่ยนแปลงต่าง ๆ ใน {{activitystream_singular_module}} โดยสลับหน้าต่างด้านล่างซ้ายเป็น "กระแสกิจกรรม" 
- ติดตามหรือถูกใจบันทึกนี้โดยใช้ไอคอนที่อยู่ทางขวาของชื่อบันทึก 
- การดำเนินการเพิ่มเติมต่าง ๆ สามารถทำได้ในเมนู กระทำการ ซึ่งอยู่ในเมนูดรอปดาวน์ด้านขวาของปุ่มแก้ไข',

    // Create View Help Text
    'LBL_HELP_CREATE' => 'โมดูล {{plural_module_name}} ช่วยให้คุณติดตามการขายแต่ละรายการ และสินค้าในไลน์ที่เป็นของการขายเหล่านั้นตั้งแต่ต้นจนจบ แต่ละระเบียน{{module_name}} อธิบายการขายที่คาดคะเนไว้ และรวมถึงข้อมูลการขายที่เกี่ยวข้องกัน รวมถึงระเบียนสำคัญอื่น ๆ ที่เกี่ยวข้อง เช่น {{quotes_module}}, {{contacts_module}} เป็นต้น

วิธีการสร้าง {{module_name}}:
1. เตรียมค่าสำหรับใส่ในช่องตามที่ต้องการ
 - ต้องใส่ข้อมูลลงในช่องที่ทำเครื่องหมาย "จำเป็นต้องระบุ" ให้แล้วเสร็จก่อนบันทึก
 - คลิก "แสดงเพิ่ม" เพื่อเปิดเผยช่องต่าง ๆ เพิ่มเติมถ้าจำเป็น
2. คลิก "บันทึก" เพื่อทำให้บันทึกใหม่เสร็จสมบูรณ์ และกลับสู่หน้าก่อน',

// END ENT/ULT

    //Marketo
    'LBL_MKTO_SYNC' => 'ซิงค์กับ Marketo&reg;',
    'LBL_MKTO_ID' => 'ID ผู้สนใจของ Marketo',

    'LBL_DASHLET_TOP10_SALES_OPPORTUNITIES_NAME' => 'โอกาสทางการขาย 10 อันดับสูงสุด',
    'LBL_TOP10_OPPORTUNITIES_CHART_DESC' => 'แสดงโอกาสทางการขายสิบอันดับสูงสุดในแผนภูมิฟอง',
    'LBL_TOP10_OPPORTUNITIES_MY_OPP' => 'โอกาสทางการขายของฉัน',
    'LBL_TOP10_OPPORTUNITIES_MY_TEAMS_OPP' => "โอกาสทางการขายของทีม",

    'LBL_PIPELINE_ERR_CLOSED_SALES_STAGE' => 'ไม่สามารถเปลี่ยน {{fieldName}} เนื่องจาก {{moduleSingular}} ไม่มีสินค้าที่เปิดขายในไลน์',
    'TPL_ACTIVITY_TIMELINE_DASHLET' => 'ไทม์ไลน์โอกาสทางการขาย',

    'LBL_CASCADE_SERVICE_WARNING' => ' ไม่สามารถตั้งค่าข้ามรายการบรรทัดรายได้ใด ๆ ได้เพราะรายการเหล่านี้ไม่ใช่บริการ คุณต้องการดำเนินการสร้างต่อไปหรือไม่',
    'LBL_CASCADE_DURATION_WARNING' => ' ไม่สามารถตั้งค่าข้ามรายการบรรทัดรายได้ใด ๆ ได้เพราะระยะเวลาของรายการเหล่านี้ถูกล็อกเอาไว้ คุณต้องการดำเนินการสร้างต่อไปหรือไม่',

    // AI Predict
    'LBL_AI_OPPORTUNITY_CLOSE_PREDICTION_NAME' => 'การพยากรณ์โอกาสปิดการขาย',
    'LBL_AI_OPPORTUNITY_CLOSE_PREDICTION_DESC' => 'ดูรายละเอียดการพยากรณ์การพยากรณ์แบบเฉพาะเจาะจง',
    'LBL_AI_WINRATE' => 'อัตราการขายสำเร็จ',
    'LBL_AI_WONOPP' => 'โอกาสในการขายที่สำเร็จ',
    'LBL_AI_CLOSINGTIME' => 'เวลาปิดการขาย',
    'LBL_AI_CLOSEDOPP' => 'โอกาสในการขายที่ปิดแล้ว',
    'LBL_AI_LEADTIMESPAN' => 'เวลาระหว่างการสร้างโอกาสในการขายและการปิดการขายที่สำเร็จ',
];
