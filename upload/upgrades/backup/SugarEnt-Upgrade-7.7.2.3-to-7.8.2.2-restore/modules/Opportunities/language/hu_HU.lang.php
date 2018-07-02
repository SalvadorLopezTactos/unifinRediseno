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
    'LBL_MODULE_NAME' => 'Lehetőségek',
    'LBL_MODULE_NAME_SINGULAR' => 'Lehetőség',
    'LBL_MODULE_TITLE' => 'Lehetőségek: Főoldal',
    'LBL_SEARCH_FORM_TITLE' => 'Lehetőségek keresése',
    'LBL_VIEW_FORM_TITLE' => 'Lehetőségek megtekintése',
    'LBL_LIST_FORM_TITLE' => 'Lehetőségek listája',
    'LBL_OPPORTUNITY_NAME' => 'Lehetőség neve:',
    'LBL_OPPORTUNITY' => 'Lehetőség:',
    'LBL_NAME' => 'Lehetőség neve',
    'LBL_INVITEE' => 'Kapcsolatok',
    'LBL_CURRENCIES' => 'Pénznemek',
    'LBL_LIST_OPPORTUNITY_NAME' => 'Név',
    'LBL_LIST_ACCOUNT_NAME' => 'Kliens neve',
    'LBL_LIST_DATE_CLOSED' => 'Zárás',
    'LBL_LIST_AMOUNT' => 'Valószínű',
    'LBL_LIST_AMOUNT_USDOLLAR' => 'Teljes összeg',
    'LBL_ACCOUNT_ID' => 'Kliens azonosító',
    'LBL_CURRENCY_RATE' => 'Árfolyam',
    'LBL_CURRENCY_ID' => 'Pénznem azonosító',
    'LBL_CURRENCY_NAME' => 'Pénznem neve',
    'LBL_CURRENCY_SYMBOL' => 'Pénznem szimbólum',
//DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_sales_stage' => 'LBL_LIST_SALES_STAGE',
    'db_name' => 'LBL_NAME',
    'db_amount' => 'LBL_LIST_AMOUNT',
    'db_date_closed' => 'LBL_LIST_DATE_CLOSED',
//END DON'T CONVERT
    'UPDATE' => 'Lehetőség - Pénznem frissítése',
    'UPDATE_DOLLARAMOUNTS' => 'USA dollár összegek frissítése',
    'UPDATE_VERIFY' => 'Összegek ellenőrzése',
    'UPDATE_VERIFY_TXT' => 'Ellenőrzi, hogy az összegek érvényes decimális(,) vagy numerikus(0-9) karakterek-e.',
    'UPDATE_FIX' => 'Javított összegek',
    'UPDATE_FIX_TXT' => 'Megkísérli kijavítani az érvénytelen értékeket valós decimális értékekre. Minden módosított összeg biztonsági mentés adatbázisban tárolódik. Ha futás közben hibát észlel, ne futtassa újra helyreállítás nélkül a biztonsági mentést, mert a régit felül fogja írni az érvénytelen új adattal.',
    'UPDATE_DOLLARAMOUNTS_TXT' => 'Frissíti az USA dollár összegeket a beállított napi árfolyamok alapján. Az összegek a grafikonokban és a Pénznem értékek lista nézetében fognak megjelenni.',
    'UPDATE_CREATE_CURRENCY' => 'Új pénznem létrehozása:',
    'UPDATE_VERIFY_FAIL' => 'Az ellenőrzés során hibát jelentő rekord:',
    'UPDATE_VERIFY_CURAMOUNT' => 'Jelenlegi összeg:',
    'UPDATE_VERIFY_FIX' => 'A hibajavítás a következőt végzi el',
    'UPDATE_INCLUDE_CLOSE' => 'Zárt rekordokkal együtt',
    'UPDATE_VERIFY_NEWAMOUNT' => 'Új összeg:',
    'UPDATE_VERIFY_NEWCURRENCY' => 'Új pénznem:',
    'UPDATE_DONE' => 'Kész',
    'UPDATE_BUG_COUNT' => 'Talált hibák, amelyeket a rendszer megpróbált kijavítani:',
    'UPDATE_BUGFOUND_COUNT' => 'Talált hibák:',
    'UPDATE_COUNT' => 'Frissített rekordok:',
    'UPDATE_RESTORE_COUNT' => 'Rekord összegei helyreállítva:',
    'UPDATE_RESTORE' => 'Összegek helyreállítása',
    'UPDATE_RESTORE_TXT' => 'Az összeg értékeinek helyreállítása biztonsági mentésből.',
    'UPDATE_FAIL' => 'Nem sikerült frissíteni -',
    'UPDATE_NULL_VALUE' => 'Összeg NULL beállítása 0-ra',
    'UPDATE_MERGE' => 'Pénznemek egyesítése',
    'UPDATE_MERGE_TXT' => 'Több pénznem egyesítése egy pénznemre. Ha több pénznem tartozik ugyanahhoz a pénznemhez, egyesíthetjük őket. A parancs a többi modul számára is egyesíteni fogja a pénznemeket.',
    'LBL_ACCOUNT_NAME' => 'Kliens neve:',
    'LBL_CURRENCY' => 'Pénznem:',
    'LBL_DATE_CLOSED' => 'Várható lezárása dátuma:',
    'LBL_DATE_CLOSED_TIMESTAMP' => 'Lezárás várható dátuma időbélyegző',
    'LBL_TYPE' => 'Típus:',
    'LBL_CAMPAIGN' => 'Kampány:',
    'LBL_NEXT_STEP' => 'Következő lépés:',
    'LBL_LEAD_SOURCE' => 'Ajánlás forrása:',
    'LBL_SALES_STAGE' => 'Eladási szint:',
    'LBL_SALES_STATUS' => 'Állapot',
    'LBL_PROBABILITY' => 'Valószínűség (%):',
    'LBL_DESCRIPTION' => 'Leírás:',
    'LBL_DUPLICATE' => 'Elképzelhető, hogy kettőzött lehetőség',
    'MSG_DUPLICATE' => 'A lehetőség bejegyzés, amit épp létrehozni kíván, elképzelhető, hogy egy korábbi bejegyzés ismétlése. A hasonló névvel szereplő bejegyzések lentebb láthatók. Kattintson a Mentés gombra, ha folytatni kívánja a lehetőség létrehozását, vagy kattintson a Mégsem gombra, hogy visszatérjen a lehetőség létrehozása nélkül a modulba.',
    'LBL_NEW_FORM_TITLE' => 'Lehetőség létrehozása',
    'LNK_NEW_OPPORTUNITY' => 'Lehetőség létrehozása',
    'LNK_CREATE' => 'Megegyezés létrehozása',
    'LNK_OPPORTUNITY_LIST' => 'Lehetőségek megtekintése',
    'ERR_DELETE_RECORD' => 'Ki kell jelölni egy rekordot a lehetőség törléséhez.',
    'LBL_TOP_OPPORTUNITIES' => 'Legjobb nyitott lehetőségeim',
    'NTC_REMOVE_OPP_CONFIRMATION' => 'Biztosan el akarja távolítani ezt a személyt a lehetőségtől?',
    'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Biztosan el akarja távolítani ezt a lehetőséget a projekttől?',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Lehetőségek',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Tevékenységek',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Előzmények',
    'LBL_RAW_AMOUNT' => 'Nyers összeg',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Ajánlások',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kapcsolatok',
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumentumok',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektek',
    'LBL_ASSIGNED_TO_NAME' => 'Felelős:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Felelős felhasználó',
    'LBL_LIST_SALES_STAGE' => 'Eladási szint:',
    'LBL_MY_CLOSED_OPPORTUNITIES' => 'Lezárt lehetőségeim',
    'LBL_TOTAL_OPPORTUNITIES' => 'Lehetőségek összesen',
    'LBL_CLOSED_WON_OPPORTUNITIES' => 'Lezárt, megnyert lehetőségek',
    'LBL_ASSIGNED_TO_ID' => 'Hozzárendelt felhasználó:',
    'LBL_CREATED_ID' => 'Létrehozva azonosító alapján',
    'LBL_MODIFIED_ID' => 'Módosítva azonosító alapján',
    'LBL_MODIFIED_NAME' => 'Módosítva felhasználó neve szerint',
    'LBL_CREATED_USER' => 'Létrehozott felhasználó',
    'LBL_MODIFIED_USER' => 'Módosított felhasználó',
    'LBL_CAMPAIGN_OPPORTUNITY' => 'Kampányok',
    'LBL_PROJECT_SUBPANEL_TITLE' => 'Projektek',
    'LABEL_PANEL_ASSIGNMENT' => 'Feladat',
    'LNK_IMPORT_OPPORTUNITIES' => 'Lehetőségek importálása',
    'LBL_EDITLAYOUT' => 'Elrendezés szerkesztése' /*for 508 compliance fix*/,
    //For export labels
    'LBL_EXPORT_CAMPAIGN_ID' => 'Kampány azonosítója',
    'LBL_OPPORTUNITY_TYPE' => 'Lehetőség típusa',
    'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Felelős felhasználó neve',
    'LBL_EXPORT_ASSIGNED_USER_ID' => 'Felelős felhasználó azonosítója',
    'LBL_EXPORT_MODIFIED_USER_ID' => 'Módosító azonosítója',
    'LBL_EXPORT_CREATED_BY' => 'Létrehozó azonosítója',
    'LBL_EXPORT_NAME' => 'Név',
    // SNIP
    'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Kontakszemélyek emailjei',
    'LBL_FILENAME' => 'Melléklet',
    'LBL_PRIMARY_QUOTE_ID' => 'Elsődleges ajánlat',
    'LBL_CONTRACTS' => 'Szerződések',
    'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Szerződések',
    'LBL_PRODUCTS' => 'Termékek',
    'LBL_RLI' => 'Bevétel sorok',
    'LNK_OPPORTUNITY_REPORTS' => 'Lehetőségek jelentéseinek megtekintése',
    'LBL_QUOTES_SUBPANEL_TITLE' => 'Árajánlatok',
    'LBL_TEAM_ID' => 'Csoport azonosító',
    'LBL_TIMEPERIODS' => 'Időperiódusok',
    'LBL_TIMEPERIOD_ID' => 'Időperiódus azonosítója',
    'LBL_COMMITTED' => 'Hozzárendelve',
    'LBL_FORECAST' => 'Belefoglal az előjelzésbe',
    'LBL_COMMIT_STAGE' => 'Elköteleződés szintje',
    'LBL_COMMIT_STAGE_FORECAST' => 'Előrejelzés',
    'LBL_WORKSHEET' => 'Munkalap',

    'TPL_RLI_CREATE' => 'Minden lehetőségnek kapcsolódnia kell egy bevételi sorhoz. <a href="javascript:void(0);" id="createRLI">Bevételi sor létrehozása</a>.',
    'TPL_RLI_CREATE_LINK_TEXT' => 'Bevételi sor tétel létrehozása.',
    'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Megajánlott Tételek',
    'LBL_RLI_SUBPANEL_TITLE' => 'Bevétel sorok',

    'LBL_TOTAL_RLIS' => '# összes bevételi sor',
    'LBL_CLOSED_RLIS' => '# lezárt bevételi sor',
    'NOTICE_NO_DELETE_CLOSED_RLIS' => 'Azok a lehetőségek, amelyekhez lezárt bevételi sorok kapcsolódnak, nem törölhetők.',
    'WARNING_NO_DELETE_CLOSED_SELECTED' => 'A kijelölt rekordok közül, egy vagy több bejegyzés lezárt bevételi sort tartalmaz, ezért nem lehet törölni.',
    'LBL_INCLUDED_RLIS' => 'Bevett bevételsor-elemek száma',

    'LBL_QUOTE_SUBPANEL_TITLE' => 'Árajánlatok',

    // Config
    'LBL_OPPS_CONFIG_VIEW_BY_LABEL' => 'Lehetőségek hierarchiája',
    'LBL_OPPS_CONFIG_VIEW_BY_DATE_ROLLUP' => 'Adja meg a Várható Zárási Dátummezőt az ebből következő Lehetőségi adatban, úgy hogy az a legkorábban, legkésőbb legyen a meglévő Bevételi Sortételek zárási dátumaihoz',

    //Dashlet
    'LBL_PIPELINE_TOTAL_IS' => 'A pipeline teljes értéke',

    'LBL_OPPORTUNITY_ROLE'=>'Lehetőség szerepe',
    'LBL_NOTES_SUBPANEL_TITLE' => 'Feljegyzések',

    // Help Text
    'LBL_OPPS_CONFIG_ALERT' => 'A Visszaigazolás gombra kattintva Ön ki fog törölni MINDEN Előrejelző adatot a Lehetőségek Nézetéből. Ha Ön nem ezt akarta, kattintson a Vissza gombra, hogy visszatérhessen az előző oldal beállításaihoz.',
    'LBL_OPPS_CONFIG_SALES_STAGE_1a' => 'Ha minden Bevételi Sortétel be van zárva és legalább egy megnyert tétel van,',
    'LBL_OPPS_CONFIG_SALES_STAGE_1b' => 'a Lehetőségi Eladások Státusza a "Bezárva Megnyerve" értéket veszi fel.',
    'LBL_OPPS_CONFIG_SALES_STAGE_2a' => 'Ha minden Bevételi Sortétel Eladási Státusza a "Bezárva Elveszítve" értéket veszi fel,',
    'LBL_OPPS_CONFIG_SALES_STAGE_2b' => 'akkor a Lehetőségi Eladások Státuszát a "Bezárva Elveszítve" értékre kell állítani.',
    'LBL_OPPS_CONFIG_SALES_STAGE_3a' => 'Ha minden Bevételi Sortétel még nyitva van,',
    'LBL_OPPS_CONFIG_SALES_STAGE_3b' => 'akkor a Lehetőség az Eladások legutolsó előremeneteli Állapotával lesz jelezve.',

// BEGIN ENT/ULT

    // Opps Config - View By Opportunities
    'LBL_HELP_CONFIG_OPPS' => 'Ha Ön kezdeményezi ezt a változtatást, a Bevételi Sortételek összefoglaló megjegyzései a háttérben megjelennek. Ha a megjegyzések készen vannak és rendelkezésre állnak a rendszer értesítést küld az Ön felhasználói profiljának e-mail címére. Ha az Ön példánya a {{forecasts_module}} modulra van beállítva, a Sugar akkor is küld Önnek értesítést, ha az Ön {{module_name}} adatai a {{forecasts_module}} modullal szinkronizálásra kerültek és az új {{forecasts_module}} modul számára elérhetők. Kérjük, vegye figyelembe, hogy a példánya úgy kell legyen konfigurálva, hogy tudjon e-mailt küldeni az Admin > Email Beállításokon keresztül, hogy az értesítés elküldhető legyen.',

    // Opps Config - View By Opportunities And RLIs
    'LBL_HELP_CONFIG_RLIS' => 'Miután Ön kezdeményezi ezt a változtatást, a Bevételi Sortételek adatai minden meglévő {{module_name}} modulra vonatkozóan a háttérben megjelennek. Ha a Bevételi Sortételek adatai készen vannak és rendelkezésre állnak a rendszer értesítést küld az Ön felhasználói profiljának e-mail címére. Kérjük, vegye figyelembe, hogy a példánya úgy kell legyen konfigurálva, hogy tudjon e-mailt küldeni az Admin > Email Beállításokon keresztül, hogy az értesítés elküldhető legyen.',
    // List View Help Text
    'LBL_HELP_RECORDS' => 'A(z) {{plural_module_name}} lehetővé teszik, hogy nyomon kövesse az egyéni eladásokat és az adott eladáshoz tartozó sorokat elölről végig. Minden {{module_name}} egy fejlécet képvisel egy csoporthoz a {{revenuelineitems_module}} közül, valamint kapcsolódik olyan más fontos rekordokhoz, mint például {{quotes_module}}, {{contacts_module}}, stb. Minden {{revenuelineitems_singular_module}} egy adott termék prospektív értékesítése, és tartalmazza a releváns eladási adatokat. Minden {{revenuelineitems_singular_module}} jellemzően külöhböző értékesítési fázisokon megy át, amíg megkapja a "Lezárva, elnyerve" vagy "Lezárva, elveszítve" címkét. A(z) {{module_name}} rekord a(z) {{revenuelineitems_module}} összegét és várható lezárási dátuma. A {{plural_module_name}} és {{revenuelineitems_module}} ennél tovább is emelhetőek a Sugar {{forecasts_singular_module}} moduljának használatával, amelynek segítségével megértheti és képes lesz előre jelezni az értékesítési trendeket, és fókuszálhatja a munkáját annak érdekében, hogy elérje az értékesítési kvótákat.',

    // Record View Help Text
    'LBL_HELP_RECORD' => 'A(z) {{plural_module_name}} modul segítségével nyomon követheti az egyéni értékesítéseket, és az adott értékesítéshez tartozó sorokat elejétől végéig. Minden {{module_name}} rekord egy {{revenuelineitems_module}} csoport fejlécét képviseli, emellett más fontos rekordokhoz (pl. {{quotes_module}}, {{contacts_module}} stb.) is kapcsolódik.

- Szerkessze a rekord mezőit, ehhez kattintson egy egyéni mezőre vagy a Szerkesztés gombra.
- Tekintse meg vagy módosítsa a többi rekordra mutató hivatkozást az alpaneleken (pl. {{revenuelineitems_module}}), ehhez húzza a bal alsó panelt "Adatnézet"-re.
- Vigyen be felhasználói bejegyzéseket és rekordmódosítási előzményeket, illetve tekintse meg ezeket itt: {{activitystream_singular_module}}, ehhez húzza a bal alsó panelt "Tevékenységek" nézetre.
- A rekordnév jobb oldalán található gombokkal kövesse vagy kedvelje ezt a rekordot.
- További műveletek elérhetők a legördülő Tevékenységek menüben a Szerkesztés gomb jobb oldalán.',

    // Create View Help Text
    'LBL_HELP_CREATE' => 'A(z) {{plural_module_name}} modul segítségével nyomon követheti az egyedi eladásokat és az azokhoz tartozó sorokat elejétől-végig. Minden {{module_name}} rekord egy {{revenuelineitems_module}} csoport fejlécét képviseli, és olyan más, fontos rekordokhoz kapcsolódik, mint pl. {{quotes_module}}, {{contacts_module}} stb.

{{module_name}} modul létrehozásához:
1. Vigye be a mezőkbe a kívánt értékeket.
 - A "Kötelező" jelölésű mezőket mentés előtt ki kell tölteni.
 - Ha szükséges, a "Mutasson többet" gombbal további mezőket is megjeleníthet.
2. Az új rekord véglegesítéséhez kattintson a "Mentés" gombra, és lépjen vissza az előző oldalra.
3. Mentés után használja a(z) {{revenuelineitems_module}} alpanelt, hogy sorokat adjon hozzá ehhez: {{module_name}}.',

// END ENT/ULT

    //Marketo
    'LBL_MKTO_SYNC' => 'Sznkronizálás ehhez: Marketo®',
    'LBL_MKTO_ID' => 'Marketo Lead azonosító',

    'LBL_DASHLET_TOP10_SALES_OPPORTUNITIES_NAME' => 'Tíz legjobb Eladási Lehetőség Termékei',
    'LBL_TOP10_OPPORTUNITIES_CHART_DESC' => 'A tíz legjobb Eladási Lehetőség Termékeit jeleníti meg egy diagramon.',
    'LBL_TOP10_OPPORTUNITIES_MY_OPP' => 'Lehetőségeim',
    'LBL_TOP10_OPPORTUNITIES_MY_TEAMS_OPP' => "Csoportom Lehetőségei",
);
