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

  'LBL_MODULE_NAME' => 'Üzleti Szabályok feldolgozása',
  'LBL_MODULE_TITLE' => 'Üzleti Szabályok feldolgozása',
  'LBL_MODULE_NAME_SINGULAR' => 'Üzleti Szabályok feldolgozása',

  'LBL_RST_UID' => 'Üzleti Szabályazonosító',
  'LBL_RST_TYPE' => 'Üzleti Szabálytípus',
  'LBL_RST_DEFINITION' => 'Üzleti Szabálymeghatározás',
  'LBL_RST_EDITABLE' => 'Üzleti Szabály Szerkeszthető',
  'LBL_RST_SOURCE' => 'Üzleti Szabályforrás',
  'LBL_RST_SOURCE_DEFINITION' => 'Üzleti Szabályforrás Definíció',
  'LBL_RST_MODULE' => 'Cél Modul',
  'LBL_RST_FILENAME' => 'Üzleti Szabály Fájlnév',
  'LBL_RST_CREATE_DATE' => 'Üzleti Szabály Létrehozási Dátum',
  'LBL_RST_UPDATE_DATE' => 'Üzleti Szabály Aktualizálási Dátum',

    'LNK_LIST' => 'Folyamati Üzleti Szabályok Megtekintése',
    'LNK_NEW_PMSE_BUSINESS_RULES' => 'Folyamati Üzelti Szabályok létrehozása',
    'LNK_IMPORT_PMSE_BUSINESS_RULES' => 'Folyamati Üzelti Szabályok importálása',

    'LBL_PMSE_TITLE_BUSINESS_RULES_BUILDER' => 'Üzleti Szabály Létrehozó',

    'LBL_PMSE_LABEL_DESIGN' => 'Tervezés',
    'LBL_PMSE_LABEL_EXPORT' => 'Export',
    'LBL_PMSE_LABEL_DELETE' => 'Törlés',

    'LBL_PMSE_SAVE_EXIT_BUTTON_LABEL' => 'Mentés és Kilépés',
    'LBL_PMSE_SAVE_DESIGN_BUTTON_LABEL' => 'Mentés és Tervezés',
    'LBL_PMSE_IMPORT_BUTTON_LABEL' => 'Importálás',

    'LBL_PMSE_MY_BUSINESS_RULES' => 'Folyamati Üzleti Szabályaim',
    'LBL_PMSE_ALL_BUSINESS_RULES' => 'Az összes Folyamati Üzleti Szabály',

    'LBL_PMSE_BUSINESS_RULES_SINGLE_HIT' => 'Folyamati Üzleti Szabályok Egyedi Kezelés',

    'LBL_PMSE_BUSINESS_RULES_IMPORT_TEXT' => 'Hozzon létre automatikusan egy új Folyamati Üzleti Szabály adatot azzal, hogy importál egy *.pbr fájlt a rendszeréből.',
    'LBL_PMSE_BUSINESS_RULES_IMPORT_SUCCESS' => 'A Folyamati E-mail Sablon sikeresen importálásra került a rendszerbe.',
    'LBL_PMSE_BUSINESS_RULES_EMPTY_WARNING' => 'Kérjük, válasszon egy érvényes *.pbr fájlt.',

    'LBL_PMSE_MESSAGE_LABEL_UNSUPPORTED_DATA_TYPE' => 'Nem támogatott adattípus',
    'LBL_PMSE_MESSAGE_LABEL_DEFINE_COLUMN_TYPE' => 'Kérjük definiálja először az oszlop típusát.',
    'LBL_PMSE_MESSAGE_LABEL_EMPTY_RETURN_VALUE' => 'A "Visszatérés" összegzés üres',
    'LBL_PMSE_MESSAGE_LABEL_MISSING_EXPRESSION_OR_OPERATOR' => 'hiányzó művelet vagy operátor',
    'LBL_PMSE_MESSAGE_LABEL_DELETE_ROW' => 'Biztosan törölni kívánja ezt a szabálycsomagot?',
    'LBL_PMSE_MESSAGE_LABEL_MIN_ROWS' => 'A döntési táblázatnak legalább egy sorral kell rendelkeznie',
    'LBL_PMSE_MESSAGE_LABEL_MIN_CONDITIONS_COLS' => 'A döntési táblázatnak legalább egy feltétel-oszloppal kell rendelkeznie',
    'LBL_PMSE_MESSAGE_LABEL_MIN_CONCLUSIONS_COLS' => 'A döntési táblázatnak legalább egy következtetési-oszloppal kell rendelkeznie',
    'LBL_PMSE_MESSAGE_LABEL_CHANGE_COLUMN_TYPE' => 'Az ehhez a változóhoz kapcsolt értékek törlődnek. Biztosan folytatja?',
    'LBL_PMSE_MESSAGE_LABEL_REMOVE_VARIABLE' => 'Valóban törölni szeretné ezt a változót?',

    'LBL_PMSE_LABEL_CONDITIONS' => 'Feltételek',
    'LBL_PMSE_LABEL_RETURN' => 'Vissza',
    'LBL_PMSE_LABEL_CONCLUSIONS' => 'Összegzések',

    'LBL_PMSE_TOOLTIP_ADD_CONDITION' => 'Feltétel hozzáadása',
    'LBL_PMSE_TOOLTIP_ADD_CONCLUSION' => 'Következtetés hozzáadása',
    'LBL_PMSE_TOOLTIP_ADD_ROW' => 'Sor hozzáadása',
    'LBL_PMSE_TOOLTIP_REMOVE_COLUMN' => 'Oszlop törlése',

    'LBL_PMSE_DROP_DOWN_CHECKED' => 'Igen',
    'LBL_PMSE_DROP_DOWN_UNCHECKED' => 'Nem',
    'LBL_PMSE_IMPORT_BUSINESS_RULES_FAILURE' => 'A Folyamati Üzleti Szabályokat nem sikerült a fájlból generálni',

    'LBL_PMSE_MESSAGE_REQUIRED_FIELDS_BUSINESSRULES' => 'Az Üzleti Szabály érvénytelen, mivel érvénytelen mezőket, illetve olyan mezőket tartalmaz, melyek nem találhatóak meg az ön SugarCRM példányában. Kérjük javítsa ki a hibákat, és mentse meg az Üzleti Szabályt.',
    'LBL_PMSE_PROCESS_BUSINESS_RULES_EDIT' => 'Ez az Üzleti szabály jelenleg egy Folyamat-meghatározásban használatos. Ennek ellenére szerkeszti az Üzleti szabályt?',
    'LBL_PMSE_PROCESS_BUSINESS_RULES_DELETE' => "Nem törölheti ezt az Üzleti szabályt, mivel jelenleg egy Folyamat-meghatározásban használatos.",
);
