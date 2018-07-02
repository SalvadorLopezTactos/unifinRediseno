<?php

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

$mod_strings = array(
    'LBL_MODULE_NAME' => 'Obchodné príležitosti',
    'LBL_MODULE_NAME_SINGULAR' => 'Obchodná príležitosť',
    'LBL_MODULE_TITLE' => 'Obchodné príležitosti: Domov',
    'LBL_SEARCH_FORM_TITLE' => 'Vyhľadávanie obchodnej príležitosti',
    'LBL_VIEW_FORM_TITLE' => 'Obchodná príležitosť, zobrazenie',
    'LBL_LIST_FORM_TITLE' => 'Zoznam obchodných príležitostí',
    'LBL_OPPORTUNITY_NAME' => 'Názov Obchodnej príležitosti:',
    'LBL_OPPORTUNITY' => 'Obchodná príležitosť:',
    'LBL_NAME' => 'Názov obchodnej príležitosti:',
    'LBL_INVITEE' => 'Kontakty',
    'LBL_CURRENCIES' => 'Meny',
    'LBL_LIST_OPPORTUNITY_NAME' => 'Názov',
    'LBL_LIST_ACCOUNT_NAME' => 'Názov účtu',
    'LBL_LIST_DATE_CLOSED' => 'Zavrieť',
    'LBL_LIST_AMOUNT' => 'Likely',
    'LBL_LIST_AMOUNT_USDOLLAR' => 'Čiastka',
    'LBL_ACCOUNT_ID' => 'ID účtu',
    'LBL_CURRENCY_RATE' => 'Menový kurz',
    'LBL_CURRENCY_ID' => 'ID meny',
    'LBL_CURRENCY_NAME' => 'Názov meny',
    'LBL_CURRENCY_SYMBOL' => 'Symbol meny',
//DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_sales_stage' => 'LBL_LIST_SALES_STAGE',
    'db_name' => 'LBL_NAME',
    'db_amount' => 'LBL_LIST_AMOUNT',
    'db_date_closed' => 'LBL_LIST_DATE_CLOSED',
//END DON'T CONVERT
    'UPDATE' => 'Obchodná príležitosť - aktualizácia meny',
    'UPDATE_DOLLARAMOUNTS' => 'Aktualizácia čiastok v U.S.D.',
    'UPDATE_VERIFY' => 'Overiť čiastky',
    'UPDATE_VERIFY_TXT' => 'Overí, že suma hodnoty v možnostiach je platná iba s číslami  (0-9) a desatinné miestami (.)',
    'UPDATE_FIX' => 'stanoviť čiastky',
    'UPDATE_FIX_TXT' => 'Pokúša sa opraviť neplatné počty vytváraním platných desatinných čísiel z aktuálneho množstva. Hocijaké upravené množstvo je zálohované v amount_backup databázovom poli. Ak toto skúsite a nájdete bug, neskúšajte to znovu bez obnovy zálohy, lebo to môže prepísať zálohu s neplatnými dátami.',
    'UPDATE_DOLLARAMOUNTS_TXT' => 'Aktualizujte množstvo U.S. Doláru pre obchod na základe aktuálneho menového kurzu. Táto hodnota sa používa na vypočítanie Grafov a Zoznamu Hodnôt Mien.',
    'UPDATE_CREATE_CURRENCY' => 'Vytvorenie novej meny:',
    'UPDATE_VERIFY_FAIL' => 'Záznam sa nepodarilo overeť',
    'UPDATE_VERIFY_CURAMOUNT' => 'Aktuálna Čiastka:',
    'UPDATE_VERIFY_FIX' => 'Spustením Opravy dostanete',
    'UPDATE_INCLUDE_CLOSE' => 'Zahrnúť uzatvorené nahrávky',
    'UPDATE_VERIFY_NEWAMOUNT' => 'Nové množstvo:',
    'UPDATE_VERIFY_NEWCURRENCY' => 'Nová mena:',
    'UPDATE_DONE' => 'Dokončené',
    'UPDATE_BUG_COUNT' => 'Nájdené chyby a pokus o vyriešenie:',
    'UPDATE_BUGFOUND_COUNT' => 'Nájdené chyby:',
    'UPDATE_COUNT' => 'Aktualizované nahrávky',
    'UPDATE_RESTORE_COUNT' => 'Obnovené množstvá nahrávok',
    'UPDATE_RESTORE' => 'Obnoviť množstvo',
    'UPDATE_RESTORE_TXT' => 'Obnovi množstvo hodnôt zo zálohy vytvorenej počas opravy.',
    'UPDATE_FAIL' => 'Nemožno aktualizovať -',
    'UPDATE_NULL_VALUE' => 'Množstvo je NULA nastavila to na 0 -',
    'UPDATE_MERGE' => 'Zlúčiť meny',
    'UPDATE_MERGE_TXT' => 'Zlúčte viacej mien do jednej meny. Ak je viac záznamov mien pre rovnakú menu, zlúčte ich do jednej. Toto tiež zlúči meny všetkých modulov.',
    'LBL_ACCOUNT_NAME' => 'Názov účtu',
    'LBL_CURRENCY' => 'Mena:',
    'LBL_DATE_CLOSED' => 'Očakávany dátum uzávierky:',
    'LBL_DATE_CLOSED_TIMESTAMP' => 'Časová pečiatka predpokladaného dátumu uzávierky',
    'LBL_TYPE' => 'Typ:',
    'LBL_CAMPAIGN' => 'Kampaň:',
    'LBL_NEXT_STEP' => 'Ďalší krok',
    'LBL_LEAD_SOURCE' => 'Viesť zdroj',
    'LBL_SALES_STAGE' => 'Citát Stage:',
    'LBL_SALES_STATUS' => 'Stav',
    'LBL_PROBABILITY' => 'Pravdepodobnosť (%):',
    'LBL_DESCRIPTION' => 'Popis',
    'LBL_DUPLICATE' => 'Možná duplicita obchodnej príležitosti',
    'MSG_DUPLICATE' => 'Vytvárate duplicitné ponuku. Môžete si buď vybrať citát z nižšie uvedeného zoznamu, alebo môžete kliknúť na Uložiť duplikovanú ponuku.',
    'LBL_NEW_FORM_TITLE' => 'Vytvoriť obchodnú príležitosť',
    'LNK_NEW_OPPORTUNITY' => 'Vytvoriť obchodnú príležitosť',
    'LNK_CREATE' => 'Vytvoriť obchod',
    'LNK_OPPORTUNITY_LIST' => 'Zobraziť príležitosti',
    'ERR_DELETE_RECORD' => 'K odstráneniu obchodnej príležitosti musíte zadať číslo záznamu.',
    'LBL_TOP_OPPORTUNITIES' => 'Moje Top Otvorené príležitosti',
    'NTC_REMOVE_OPP_CONFIRMATION' => 'Ste si istí, že chcete odstrániť tento kontakt z predaja?',
    'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Ste si istí, že chcete odstrániť túto príležitosť z projektu?',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Obchodné príležitosti',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivity',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'História',
    'LBL_RAW_AMOUNT' => 'Hrubá čiastka',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Príležitosti',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenty',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
    'LBL_ASSIGNED_TO_NAME' => 'Pridelený k:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Pridelený uživateľ',
    'LBL_LIST_SALES_STAGE' => 'Etapa predaja',
    'LBL_MY_CLOSED_OPPORTUNITIES' => 'Moje Uzatvorené príležitosti',
    'LBL_TOTAL_OPPORTUNITIES' => 'Príležitosti spolu',
    'LBL_CLOSED_WON_OPPORTUNITIES' => 'Uzatvorené víťazné príležitosti',
    'LBL_ASSIGNED_TO_ID' => 'Pridelený užívateľ:',
    'LBL_CREATED_ID' => 'Vytvorený podľa ID',
    'LBL_MODIFIED_ID' => 'Zmenený podľa ID',
    'LBL_MODIFIED_NAME' => 'Zmenený podľa užívateľského mena',
    'LBL_CREATED_USER' => 'Vytvorené užívateľom',
    'LBL_MODIFIED_USER' => 'Zmenený užívateľ',
    'LBL_CAMPAIGN_OPPORTUNITY' => 'Kampane',
    'LBL_PROJECT_SUBPANEL_TITLE' => 'Projekty',
    'LABEL_PANEL_ASSIGNMENT' => 'Úloha',
    'LNK_IMPORT_OPPORTUNITIES' => 'importovať príležitosti',
    'LBL_EDITLAYOUT' => 'Upraviť rozloženie' /*for 508 compliance fix*/,
    //For export labels
    'LBL_EXPORT_CAMPAIGN_ID' => 'ID kampane',
    'LBL_OPPORTUNITY_TYPE' => 'Typ príležitostí',
    'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Pridelené meno užívateľa',
    'LBL_EXPORT_ASSIGNED_USER_ID' => 'Pridelené užívateľské ID',
    'LBL_EXPORT_MODIFIED_USER_ID' => 'Upravené podľa ID',
    'LBL_EXPORT_CREATED_BY' => 'Vytvorené podľa ID',
    'LBL_EXPORT_NAME' => 'Názov',
    // SNIP
    'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'E-maily súvisiacich kontaktov',
    'LBL_FILENAME' => 'Príloha',
    'LBL_PRIMARY_QUOTE_ID' => 'Primárna kvóta',
    'LBL_CONTRACTS' => 'Kontrakty',
    'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Kontrakty',
    'LBL_PRODUCTS' => 'Produkty',
    'LBL_RLI' => 'Položky krivky výnosu',
    'LNK_OPPORTUNITY_REPORTS' => 'Zobraziť Reporty príležitostí',
    'LBL_QUOTES_SUBPANEL_TITLE' => 'Ponuky',
    'LBL_TEAM_ID' => 'ID tímu',
    'LBL_TIMEPERIODS' => 'Časové obdobia',
    'LBL_TIMEPERIOD_ID' => 'ID časového obdobia',
    'LBL_COMMITTED' => 'Pridelené',
    'LBL_FORECAST' => 'Zahrnúť do prognózy',
    'LBL_COMMIT_STAGE' => 'Fáza odovzdania',
    'LBL_COMMIT_STAGE_FORECAST' => 'Prognóza',
    'LBL_WORKSHEET' => 'Tabuľka',

    'TPL_RLI_CREATE' => 'Príležitosť musí mať priradenú položku krivky výnosu. Vytvoriť položku krivky výnosu.',
    'TPL_RLI_CREATE_LINK_TEXT' => 'Create a Revenue Line Item.',
    'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Quoted Line Items',
    'LBL_RLI_SUBPANEL_TITLE' => 'Položky krivky výnosu',

    'LBL_TOTAL_RLIS' => '# z celkových položiek krivky výnosu',
    'LBL_CLOSED_RLIS' => '# z uzavretých položiek krivky výnosu',
    'NOTICE_NO_DELETE_CLOSED_RLIS' => 'Nemôžete mazať príležitosti, ktoré obsahujú uzavreté položky krivky výnosu.',
    'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Jeden alebo viac vybraných záznamov obsahuje uzavreté položky krivky výnosu a nemôže byť odstránený.',
    'LBL_INCLUDED_RLIS' => '# of Included Revenue Line Items',

    'LBL_QUOTE_SUBPANEL_TITLE' => '[Quotes]',

    // Config
    'LBL_OPPS_CONFIG_VIEW_BY_LABEL' => 'Opportunity Hierarchy',
    'LBL_OPPS_CONFIG_VIEW_BY_DATE_ROLLUP' => 'Set the Expected Close Date field on the resulting Opportunity records to be the earliest or latest close dates of the existing Revenue Line Items',

    //Dashlet
    'LBL_PIPELINE_TOTAL_IS' => 'Celková Pipeline je',

    'LBL_OPPORTUNITY_ROLE'=>'Rola obchodnej príležirosti',
    'LBL_NOTES_SUBPANEL_TITLE' => 'Poznámky',

    // Help Text
    'LBL_OPPS_CONFIG_ALERT' => 'By clicking Confirm, you will be erasing ALL Forecasts data and changing your Opportunities View. If this is not what you intended, click cancel to return to previous settings.',
    'LBL_OPPS_CONFIG_SALES_STAGE_1a' => 'If all Revenue Line Items are closed and at least one was won,',
    'LBL_OPPS_CONFIG_SALES_STAGE_1b' => 'the Opportunity Sales Stage is set to "Closed Won".',
    'LBL_OPPS_CONFIG_SALES_STAGE_2a' => 'If all Revenue Line Items are in the "Closed Lost" Sales Stage,',
    'LBL_OPPS_CONFIG_SALES_STAGE_2b' => 'the Opportunity Sales Stage is set to "Closed Lost".',
    'LBL_OPPS_CONFIG_SALES_STAGE_3a' => 'If any Revenue Line Items are still open,',
    'LBL_OPPS_CONFIG_SALES_STAGE_3b' => 'the Opportunity will be marked with the least-advanced Sales Stage.',

// BEGIN ENT/ULT

    // Opps Config - View By Opportunities
    'LBL_HELP_CONFIG_OPPS' => 'After you initiate this change, the Revenue Line Item summarization notes will be built in the background. When the notes are complete and available, a notification will be sent to the email address on your user profile. If your instance is set up for {{forecasts_module}}, Sugar will also send you a notification when your {{module_name}} records are synced to the {{forecasts_module}} module and available for new {{forecasts_module}}. Please note that your instance must be configured to send email via Admin > Email Settings in order for the notifications to be sent.',

    // Opps Config - View By Opportunities And RLIs
    'LBL_HELP_CONFIG_RLIS' => 'After you initiate this change, Revenue Line Item records will be created for each existing {{module_name}} in the background. When the Revenue Line Items are complete and available, a notification will be sent to the email address on your user profile. Please note that your instance must be configured to send email via Admin > Email Settings in order for the notification to be sent.',
    // List View Help Text
    'LBL_HELP_RECORDS' => 'The {{plural_module_name}} module allows you to track individual sales and the line items belonging to those sales from start to finish. Each {{module_name}} record represents a header for a group of {{revenuelineitems_module}} as well as relating to other important records such as {{quotes_module}}, {{contacts_module}}, etc. Each {{revenuelineitems_singular_module}} is the prospective sale of a particular product and includes relevant sale data. Each {{revenuelineitems_singular_module}} will typically progress through several Sales Stages until it is marked either "Closed Won" or "Closed Lost". The {{module_name}} record reflects the amount and expected close date of its {{revenuelineitems_module}}. {{plural_module_name}} and {{revenuelineitems_module}} can be leveraged even further by using Sugar&#39;s {{forecasts_singular_module}}ing module to understand and predict sales trends as well as focus work to achieve sales quotas.',

    // Record View Help Text
    'LBL_HELP_RECORD' => 'The {{plural_module_name}} module allows you to track individual sales and the line items belonging to those sales from start to finish. Each {{module_name}} record represents a header for a group of {{revenuelineitems_module}} as well as relating to other important records such as {{quotes_module}}, {{contacts_module}}, etc.

- Edit this record&#39;s fields by clicking an individual field or the Edit button.
- View or modify links to other records in the subpanels, including {{revenuelineitems_module}}, by toggling the bottom left pane to "Data View".
- Make and view user comments and record change history in the {{activitystream_singular_module}} by toggling the bottom left pane to "Activity Stream".
- Follow or favorite this record using the icons to the right of the record name.
- Additional actions are available in the dropdown Actions menu to the right of the Edit button.',

    // Create View Help Text
    'LBL_HELP_CREATE' => 'The {{plural_module_name}} module allows you to track individual sales and the line items belonging to those sales from start to finish. Each {{module_name}} record represents a header for a group of {{revenuelineitems_module}} as well as relating to other important records such as {{quotes_module}}, {{contacts_module}}, etc.

To create an {{module_name}}:
1. Provide values for the fields as desired.
 - Fields marked "Required" must be completed prior to saving.
 - Click "Show More" to expose additional fields if necessary.
2. Click "Save" to finalize the new record and return to the previous page.
3. After saving, use the {{revenuelineitems_module}} subpanel to add line items to the {{module_name}}.',

// END ENT/ULT

    //Marketo
    'LBL_MKTO_SYNC' => 'Sync to Marketo&reg;',
    'LBL_MKTO_ID' => 'Marketo Lead ID',

    'LBL_DASHLET_TOP10_SALES_OPPORTUNITIES_NAME' => 'Top 10 Sales Opportunities',
    'LBL_TOP10_OPPORTUNITIES_CHART_DESC' => 'Displays top ten Opportunities in a bubble chart.',
    'LBL_TOP10_OPPORTUNITIES_MY_OPP' => 'My Opportunities',
    'LBL_TOP10_OPPORTUNITIES_MY_TEAMS_OPP' => "My Team's Opportunities",
);
