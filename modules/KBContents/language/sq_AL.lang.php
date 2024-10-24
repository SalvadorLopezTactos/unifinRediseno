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
    'LBL_KBCONTENTS_LIST_DASHBOARD' => 'Paneli i listës së këndit të njohurive',
    'LBL_KBCONTENTS_RECORD_DASHBOARD' => 'Paneli i regjistrimeve të këndit të njohurive',
    'LBL_KBCONTENTS_FOCUS_DRAWER_DASHBOARD' => 'Përqendruesi i fokusit te baza e njohurive',
    'TPL_ACTIVITY_TIMELINE_DASHLET' => 'Vija kohore e bazës së njohurive',

    'LBL_MODULE_NAME' => 'Baza e njohurisë',
    'LBL_MODULE_NAME_SINGULAR' => 'Artikuj të bazës së nojurive',
    'LBL_MODULE_TITLE' => 'Artikuj të bazës së nojurive',
    'LNK_NEW_ARTICLE' => 'krijo artikull',
    'LNK_LIST_ARTICLES' => 'Shfaq artikujt',
    'LNK_KNOWLEDGE_BASE_ADMIN_MENU' => 'Parametra',
    'LBL_EDIT_LANGUAGES' => 'Ndrysho gjuhët',
    'LBL_ADMIN_LABEL_LANGUAGES' => 'Gjuhët e disponueshme',
    'LBL_CONFIG_LANGUAGES_TITLE' => 'Gjuhët e disponueshme',
    'LBL_CONFIG_LANGUAGES_TEXT' => 'Konfiguro gjuhët që do të përdoren në modulin e bazës së njohurive.',
    'LBL_CONFIG_LANGUAGES_LABEL_KEY' => 'Kodi i gjuhës',
    'LBL_CONFIG_LANGUAGES_LABEL_NAME' => 'Etiketa e gjuhës',
    'ERR_CONFIG_LANGUAGES_DUPLICATE' => 'Nuk mundësohet shtimi i gjuhës me kodin që dublon atë ekzistues.',
    'ERR_CONFIG_LANGUAGES_EMPTY_KEY' => 'The Language Code field is empty, please enter values before saving.',
    'ERR_CONFIG_LANGUAGES_EMPTY_VALUE' => 'The Language Label field is empty, please enter values before saving.',
    'LBL_SET_ITEM_PRIMARY' => 'Cakto vlerën si kryesore',
    'LBL_ITEM_REMOVE' => 'Hiq artikullin',
    'LBL_ITEM_ADD' => 'Shto artikull',
    'LBL_MODULE_ID' => 'KBContents',
    'LBL_DOCUMENT_REVISION_ID' => 'ID-ja e rishikimit',
    'LBL_DOCUMENT_REVISION' => 'Revizion',
    'LBL_NUMBER' => 'Numri',
    'LBL_TEXT_BODY' => 'Trupi',
    'LBL_LANG' => 'Gjuha',
    'LBL_PUBLISH_DATE' => 'data e publikimit',
    'LBL_EXP_DATE' => 'data e skadimit',
    'LBL_DOC_ID' => 'ID e dokumentacionit',
    'LBL_APPROVED' => 'I miratuar',
    'LBL_REVISION' => 'Revizion',
    'LBL_ACTIVE_REV' => 'Rishikim aktiv',
    'LBL_IS_EXTERNAL' => 'Artikull i jashtëm',
    'LBL_KBDOCUMENT_ID' => 'ID-ja e dokumentit të bazës së njohurive',
    'LBL_KBDOCUMENTS' => 'Dokumentet e bazës së njohurive',
    'LBL_KBDOCUMENT' => 'Dokumenti i bazës së njohurive',
    'LBL_KBARTICLE' => 'Artikull',
    'LBL_KBARTICLES' => 'Artikujt',
    'LBL_KBARTICLE_ID' => 'ID-ja e artikullit',
    'LBL_USEFUL' => 'I dobishëm',
    'LBL_NOT_USEFUL' => 'Jo i dobishëm',
    'LBL_RATING' => 'Klasifikimi:',
    'LBL_VIEWED_COUNT' => 'View Count',
    'LBL_CATEGORIES' => 'Kategoritë e bazës së njohurisë',
    'LBL_CATEGORY_NAME' => 'Kategoria',
    'LBL_USEFULNESS' => 'Dobia',
    'LBL_CATEGORY_ID' => 'ID-ja e kategorisë',
    'LBL_KBSAPPROVERS' => 'Miratuesit',
    'LBL_KBSAPPROVER_ID' => 'Miratuar nga',
    'LBL_KBSAPPROVER' => 'Miratuar nga',
    'LBL_KBSCASES' => 'Rastet',
    'LBL_KBSCASE_ID' => 'Rast i ngjashëm',
    'LBL_KBSCASE' => 'Rast i ngjashëm',
    'LBL_MORE_MOST_USEFUL_ARTICLES' => 'Më shumë nga artikujt më të dobishëm të publikuar të bazës së njohurive...',
    'LBL_KBSLOCALIZATIONS' => 'Lokalizime',
    'LBL_LOCALIZATIONS_SUBPANEL_TITLE' => 'Lokalizime',
    'LBL_KBSREVISIONS' => 'Revizionet',
    'LBL_REVISIONS_SUBPANEL_TITLE' => 'Revizionet',
    'LBL_LISTVIEW_FILTER_ALL' => 'Të gjithë artikujt',
    'LBL_LISTVIEW_FILTER_MY' => 'Artikujt e mi',
    'LBL_CREATE_LOCALIZATION_BUTTON_LABEL' => 'Krijo lokalizim',
    'LBL_CREATE_REVISION_BUTTON_LABEL' => 'Krijo rishikim',
    'LBL_CANNOT_CREATE_LOCALIZATION' =>
        'Nuk mund të krijohet lokalizim i ri duke qenë se ekziston një version lokalizimi për të gjitha gjuhët e disponueshme.',
    'LBL_SPECIFY_PUBLISH_DATE' => 'Schedule this article to be published by specifying the Publish Date. Do you wish to continue without updating a Publish Date?',
    'LBL_MODIFY_EXP_DATE_LOW' => 'The Expiration Date occur on a date before the Publish Date. Do you wish to continue without modify a Expiration Date?',
    'LBL_PANEL_INMORELESS' => 'Dobia',
    'LBL_MORE_OTHER_LANGUAGES' => 'Më shumë gjuhë të tjera...',
    'EXCEPTION_VOTE_USEFULNESS_NOT_AUTHORIZED' => 'Nuk je i autorizuar të votosh i dobishëm/i padobishëm {moduleName}. Kontakto administratorin nëse duhet të hysh.',
    'LNK_NEW_KBCONTENT_TEMPLATE' => 'Krijo shabllon',
    'LNK_LIST_KBCONTENT_TEMPLATES' => 'Shiko shabllonet',
    'LNK_LIST_KBCATEGORIES' => 'Shiko kategoritë',
    'LBL_TEMPLATES' => 'Shabllonet',
    'LBL_TEMPLATE' => 'Shablloni',
    'LBL_TEMPATE_LOAD_MESSAGE' => 'Shablloni do të mbivendosë të gjitha përmbajtjet.' .
        ' Je i sigurt që dëshiron të përdorësh këtë shabllon?',
    'LNK_IMPORT_KBCONTENTS' => 'Importo artikuj',
    'LBL_DELETE_CONFIRMATION_LANGUAGE' => 'Të gjitha dokumentet me këtë gjuhë do të fshihen! Je i sigurt që dëshiron ta fshish këtë gjuhë?',
    'LBL_CREATE_CATEGORY_PLACEHOLDER' => 'Shtyp "Enter" për të krijuar ose "Esc" për të anuluar',
    'LBL_KB_NOTIFICATION' => 'Dokumenti u publikua.',
    'LBL_KB_PUBLISHED_REQUEST' => 'ka caktuar dokumentin për ty për miratim dhe publikim.',
    'LBL_KB_STATUS_BACK_TO_DRAFT' => 'Statusi i dokumentit u ndryshua në draft.',
    'LBL_OPERATOR_CONTAINING_THESE_WORDS' => 'me këto fjalë',
    'LBL_OPERATOR_EXCLUDING_THESE_WORDS' => 'pa këto fjalë',
    'ERROR_EXP_DATE_LOW' => 'Data e skadimit nuk mund të caktohet përpara datës së publikimit.',
    'ERROR_ACTIVE_DATE_APPROVE_REQUIRED' => 'Statusi i miratuar kërkon datën e publikimit.',
    'ERROR_ACTIVE_DATE_LOW' => 'The Publish Date must occur on a later date than today&#39;s date.',
    'ERROR_ACTIVE_DATE_EMPTY' => 'The Publish Date is empty.',
    'LBL_RECORD_SAVED_SUCCESS' => 'You successfully created the {{moduleSingularLower}} <a href="#{{buildRoute model=this}}">{{name}}</a>.', // use when a model is available
    'ERROR_IS_BEFORE' => 'Gabim. Data e kësaj fushe duhet të caktohet pas datës së fushës {{this}}.',
    'TPL_SHOW_MORE_MODULE' => 'Artikuj të tjerë {{module}}...',
    'LBL_LIST_FORM_TITLE' => 'Lista e bazës së njohurive',
    'LBL_SEARCH_FORM_TITLE' => 'Kërkim në bazën e njohurive',
];
