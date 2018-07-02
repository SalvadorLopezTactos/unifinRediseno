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
  'LBL_ACTIVE' => 'Aktivní',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivity',
  'LBL_API_CONSKEY' => 'Spotřebitelský klíč',
  'LBL_API_CONSSECRET' => 'OAuth kód (Consumer Secret)',
  'LBL_API_DATA' => 'API Data',
  'LBL_API_OAUTHTOKEN' => 'OAuth Token',
  'LBL_API_TYPE' => 'Typ přihlášení',
  'LBL_APPLICATION' => 'Aplikace',
  'LBL_APPLICATION_FOUND_NOTICE' => 'Účet pro tuto aplikaci již existuje. Obnovuji stávající účet.',
  'LBL_ASSIGNED_TO_ID' => 'Přiřazené Id uživatele',
  'LBL_ASSIGNED_TO_NAME' => 'Uživatel Sugar',
  'LBL_AUTH_ERROR' => 'Ověření externího účtu se nezdařilo.',
  'LBL_AUTH_UNSUPPORTED' => 'Tato ověřovací metoda není aplikací podporována',
  'LBL_BASIC_SAVE_NOTICE' => 'Klepněte na tlačítko Uložit pro vytvoření účtu. Sugr uvěří vaše přihlašovací údaje.',
  'LBL_CONNECTED' => 'Připojeno',
  'LBL_CONNECT_BUTTON_TITLE' => 'Připojit',
  'LBL_CREATED' => 'Vytvořeno',
  'LBL_CREATED_ID' => 'Vytvořeno uživatelem ID',
  'LBL_CREATED_USER' => 'Vytvořeno uživatelem',
  'LBL_DATE_ENTERED' => 'Datum vytvoření',
  'LBL_DATE_MODIFIED' => 'Datum změny',
  'LBL_DELETED' => 'Smazáno',
  'LBL_DESCRIPTION' => 'Popis',
  'LBL_DISCONNECTED' => 'Nepřipojeno',
  'LBL_DISPLAY_PROPERTIES' => 'Vlastnosti zobrazení',
  'LBL_ERR_FACEBOOK' => 'Facebook vrátil chybu a feed nelze zobrazit.',
  'LBL_ERR_FAILED_QUICKCHECK' => 'Nejste právě přípojen k účtu {0}. Klikněte OK na přihlášení a aktivaci externího účtu.',
  'LBL_ERR_NO_AUTHINFO' => 'Toto není ověřovací infornmace pro tento účet.',
  'LBL_ERR_NO_RESPONSE' => 'Naskytnul se problém při ukládání externího účtu.',
  'LBL_ERR_NO_TOKEN' => 'Nejsou k dispozici žádné tokeny pro tento účet.',
  'LBL_ERR_OAUTH_FACEBOOK_1' => 'Relace Facebooku vypršela. Pro pokračování se prosím',
  'LBL_ERR_OAUTH_FACEBOOK_2' => 'přihlašte k Facebooku znovu',
  'LBL_ERR_POPUPS_DISABLED' => 'Prosím aktivujte vyskakovací (popup) okna nebo přidejte vyjímku pro URL "{0}" na seznam pro připojení.',
  'LBL_ERR_TWITTER' => 'Facebook vrátil chybu a feed nelze zobrazit.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Zobrazit historii',
  'LBL_HOMEPAGE_TITLE' => 'Moje externí účty',
  'LBL_ID' => 'ID',
  'LBL_LIST_FORM_TITLE' => 'Seznam externích účtů',
  'LBL_LIST_NAME' => 'Název',
  'LBL_MEET_NOW_BUTTON' => 'Setkaní ihned',
  'LBL_MODIFIED' => 'Upravil',
  'LBL_MODIFIED_ID' => 'Změněno uživatelem ID',
  'LBL_MODIFIED_NAME' => 'Upraveno uživatelem',
  'LBL_MODIFIED_USER' => 'Změněno uživatelem',
  'LBL_MODULE_NAME' => 'Externí účet',
  'LBL_MODULE_NAME_SINGULAR' => 'Externí účet',
  'LBL_MODULE_TITLE' => 'Externí účty',
  'LBL_NAME' => 'App Jméno uživatele',
  'LBL_NEW_FORM_TITLE' => 'Nový externí účet',
  'LBL_NOTE' => 'Prosím všimňete si',
  'LBL_OAUTH_NAME' => '%s',
  'LBL_OAUTH_SAVE_NOTICE' => 'Klikněte Uložit pro vytvoření externího účtu. Budete přesměrováni na stránku pro autorizaci Sugar aplikace a pak zpět do Sugar.',
  'LBL_OMIT_URL' => '(Vynechat http:// or https://)',
  'LBL_PASSWORD' => 'App heslo',
  'LBL_REAUTHENTICATE_KEY' => 'a',
  'LBL_REAUTHENTICATE_LABEL' => 'Znovu autentifikovat',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhledat externí zdroj',
  'LBL_SUCCESS' => 'Dokončeno',
  'LBL_SUGAR_EAPM_SUBPANEL_TITLE' => 'Externí účty',
  'LBL_SUGAR_USER_NAME' => 'Uživatel Sugar',
  'LBL_TEAM' => 'Týmy',
  'LBL_TEAMS' => 'Týmy',
  'LBL_TEAM_ID' => 'Id Týmu',
  'LBL_TITLE_LOTUS_LIVE_DOCUMENTS' => 'Dokumenty LotusLive™',
  'LBL_TITLE_LOTUS_LIVE_MEETINGS' => 'Nadcházející LotusLive™ setkání.',
  'LBL_URL' => 'URL',
  'LBL_USER_NAME' => 'App uživatelské jméno',
  'LBL_VALIDATED' => 'Přístup ověřen',
  'LBL_VIEW_LOTUS_LIVE_DOCUMENTS' => 'Zobrazit dokumenty LotusLive™',
  'LBL_VIEW_LOTUS_LIVE_MEETINGS' => 'Ukázat nadcházející LotusLive™ setkání.',
  'LNK_IMPORT_SUGAR_EAPM' => 'Import externích účtů',
  'LNK_LIST' => 'Zobrazit externí účty',
  'LNK_NEW_RECORD' => 'Vytvořit externí účet',
);

