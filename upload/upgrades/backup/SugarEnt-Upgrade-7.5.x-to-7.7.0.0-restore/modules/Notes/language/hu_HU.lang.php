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
  'ERR_DELETE_RECORD' => 'Adjon meg egy azonosítót a kliens törléséhez!',
  'ERR_REMOVING_ATTACHMENT' => 'Nem sikerült eltávolítani a mellékletet!',
  'LBL_ACCOUNT_ID' => 'Kliens azonosító:',
  'LBL_ACTIVITIES_REPORTS' => 'Tevékenységek jelentése',
  'LBL_CASE_ID' => 'Eset azonosító:',
  'LBL_CLOSE' => 'Zárás:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'Kapcsolati azonosító:',
  'LBL_CONTACT_NAME' => 'Kapcsolat:',
  'LBL_CREATED_BY' => 'Létrehozta',
  'LBL_DATE_ENTERED' => 'Létrehozás dátuma',
  'LBL_DATE_MODIFIED' => 'Módosítás dátuma',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Feljegyzések',
  'LBL_DELETED' => 'Törölve',
  'LBL_DESCRIPTION' => 'Feljegyzés',
  'LBL_EDITLAYOUT' => 'Elrendezés szerkesztése',
  'LBL_EMAIL_ADDRESS' => 'Email:',
  'LBL_EMAIL_ATTACHMENT' => 'Email melléklet',
  'LBL_EMBED_FLAG' => 'Beágyazza emailbe?',
  'LBL_EXPORT_PARENT_ID' => 'Azonosító szerint',
  'LBL_EXPORT_PARENT_TYPE' => 'Modul szerint',
  'LBL_FILENAME' => 'Melléklet:',
  'LBL_FILE_MIME_TYPE' => 'Mime típus',
  'LBL_FILE_URL' => 'Fájl URL',
  'LBL_FIRST_NAME' => 'Keresztnév',
  'LBL_HELP_CREATE' => '{{module_name}} létrehozásához: 1. töltse ki a mezőket! A kötelező mezők kitöltése nélkül mentés nem lehetséges. Ha Önnek hiányzó mezőt talál, kattintson a "Több mutatása" opcióra a ráadás mezők felfedéséhez! 2. Kattintson a "Mentés" gombra a rekord mentéséhez és a korábbi nézetre való visszatéréshez! Amennyiben a "Mentés és megjelenítés" opciót választja, a {{module_name}} rekordnézetben fog megjelenni. A "Mentés és új létrehozása" paranccsal közvetlen új {{module_name}} létrehozatali oldalára továbbítódik.',
  'LBL_HELP_RECORD' => 'A {{plural_module_name}} modul a rekordokhoz kapcsolódó szövegeket és feljegyzéseket tartalmazza. - Szerkessze ennek a rekordnak a mezőit külön-külön, vagy kattintson a Szerkesztés gombra! Tekintse meg, vagy szerkessze a linkeket a bal alsó "Adatnézet" kapcsoló használatával! Olvassa el, vagy írjon felhasználói hozzászólásokat a "Tevékenységfolyam" opcióval! A rekord neve mellett található ikonok segítségével jelölje be kedvencének a tartalmat, vagy kövesse annak utóéletét! Egyéb tevékenységek a Szerkesztés gombtól jobbra szereplő műveleti gomb legördülő menüjében találhatók.',
  'LBL_HELP_RECORDS' => 'A {{plural_module_name}} modul a rekordokhoz kapcsolódó szövegeket és feljegyzéseket tartalmazza. Egy {{module_name}} rekord tartozhat kapcsolati, vagy egyéb bejegyzésekhez. Új tétel létrehozása történhet hozzáadással, kettőzéssel, importálással, illetve egyéb módokon is. Az új bejegyzések adatait rekord nézetben van lehetősége szerkeszteni. Egy {{module_name}} tétel kapcsolódhat számtalan más Sugar rekordhoz is, így a Kliens, Kapcsolati, vagy Lehetőségek modul elemeihez is.',
  'LBL_LAST_NAME' => 'Vezetéknév',
  'LBL_LEAD_ID' => 'Ajánlás azonosítója:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Hozzárendelt felhasználó',
  'LBL_LIST_CONTACT' => 'Kapcsolat',
  'LBL_LIST_CONTACT_NAME' => 'Kapcsolat',
  'LBL_LIST_DATE_MODIFIED' => 'Utolsó módosítás',
  'LBL_LIST_EDIT_BUTTON' => 'Szerkeszt',
  'LBL_LIST_FILENAME' => 'Melléklet',
  'LBL_LIST_FORM_TITLE' => 'Feljegyzések listája',
  'LBL_LIST_RELATED_TO' => 'Kapcsolódó kliens',
  'LBL_LIST_STATUS' => 'Állapot',
  'LBL_LIST_SUBJECT' => 'Tárgy',
  'LBL_MEMBER_OF' => 'Tagja:',
  'LBL_MODIFIED_BY' => 'Módosította',
  'LBL_MODULE_NAME' => 'Feljegyzések',
  'LBL_MODULE_NAME_SINGULAR' => 'Feljegyzés',
  'LBL_MODULE_TITLE' => 'Feljegyzések: Főoldal',
  'LBL_MY_NOTES_DASHLETNAME' => 'Feljegyzéseim',
  'LBL_NEW_FORM_BTN' => 'Feljegyzés hozzáadása',
  'LBL_NEW_FORM_TITLE' => 'Feljegyzések létrehozása vagy mellékletek hozzáadása',
  'LBL_NOTE' => 'Feljegyzés:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Mellékletek',
  'LBL_NOTE_INFORMATION' => 'Feljegyzések áttekintése',
  'LBL_NOTE_STATUS' => 'Feljegyzés',
  'LBL_NOTE_SUBJECT' => 'Feljegyzés tárgya:',
  'LBL_OC_FILE_NOTICE' => 'Kérjük, jelentkezzen be a szerverre a fájl megnézéséhez',
  'LBL_OPPORTUNITY_ID' => 'Lehetőség azonosítója:',
  'LBL_PANEL_DETAILS' => 'Részletek',
  'LBL_PARENT_ID' => 'Szülő azonosítója:',
  'LBL_PARENT_TYPE' => 'Szülő típus',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PORTAL_FLAG' => 'Megjelenjen a portálon?',
  'LBL_PRODUCT_ID' => 'Termék azonosító:',
  'LBL_QUOTE_ID' => 'Árajánlat azonosító:',
  'LBL_RELATED_TO' => 'Kapcsolódó kliens:',
  'LBL_REMOVING_ATTACHMENT' => 'Melléklet eltávolítása...',
  'LBL_REVENUELINEITEMS' => 'Bevételi sor tételek',
  'LBL_SEARCH_FORM_TITLE' => 'Feljegyzés keresése',
  'LBL_SEND_ANYWAYS' => 'Ennek az email-nek nincs tárgya. Biztos benne, hogy elküldi/elmenti?',
  'LBL_STATUS' => 'Állapot',
  'LBL_SUBJECT' => 'Tárgy:',
  'LNK_IMPORT_NOTES' => 'Feljegyzések importálása',
  'LNK_NEW_NOTE' => 'Feljegyzés vagy melléklet hozzáadása',
  'LNK_NOTE_LIST' => 'Feljegyzések megtekintése',
);

