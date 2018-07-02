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
  'ERROR_EMPTY_RECORD_ID' => 'Chyba: ID Záznamu nebol špecifikovaný alebo je prázdny.',
  'ERROR_EMPTY_SOURCE_ID' => 'Chyba: ID Zdroja nebol špecifikovaný alebo je prázdny.',
  'ERROR_EMPTY_WRAPPER' => 'Chyba: Nemožno načítal obálku inštancie pre zdroj [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Chyba:  Nebolí nájdené žiadne rozširuhúce informácie pre tento záznam.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Chyba: Žiadne zmapované konektory pre tento modul.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Chyba: Žiadne zmapované polia modulu, pre zobrazenie vo výsledkoch. Prosím, kontaktujte správcu systému/Administrátora.',
  'ERROR_NO_FIELDS_MAPPED' => 'Chyba: Musíte namapovať apoň jedno pole Konektora do poľa modulu, pre vstup do každého modulu.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Žiadne moduly neboli povolené pre tento konektor. Vyberte modul pre tento konektor na stránke Povolenie konektorov.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Chyba: Žiadne konektory, povolené pre vyhľadávanie definovaných polí.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Chyba: Žiadne polia definované pre vyhľadávanie pre tento modul a konektor. Prosím, kontaktujte správcu systému/Administrátora.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Chyba: Súbor sourcedefs.php nebol nájdený.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Chyba: Žiadne zdroje špecifikované k obnove údajov.',
  'ERROR_RECORD_NOT_SELECTED' => 'Chyba: Prosím, pre pokračovaním vyberte záznam zo zoznamu.',
  'LBL_ADDRCITY' => 'Mesto:',
  'LBL_ADDRCOUNTRY' => 'Krajina:',
  'LBL_ADDRCOUNTRY_ID' => 'Krajina ID',
  'LBL_ADDRSTATEPROV' => 'Kraj:',
  'LBL_ADD_MODULE' => 'Pridať',
  'LBL_ADMINISTRATION' => 'Správa konektorov',
  'LBL_ADMINISTRATION_MAIN' => 'Nastavenie konektorov',
  'LBL_AVAILABLE' => 'Dostupné',
  'LBL_BACK' => '< Späť',
  'LBL_CLOSE' => 'Zavrieť',
  'LBL_COMPANY_ID' => 'ID Spoločnosti',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Niektoré požadované údaje neboli vyplnené. Pokračovať v uložení zmien?',
  'LBL_CONNECTOR' => 'Konektor',
  'LBL_CONNECTOR_FIELDS' => 'Polia konektora',
  'LBL_DATA' => 'Údaje',
  'LBL_DEFAULT' => 'Prednastavený',
  'LBL_DELETE_MAPPING_ENTRY' => 'Ste si istý, že chcete vymazať tento vstup?',
  'LBL_DISABLED' => 'Zakázané',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Žiadne zhody pre vaše vyhľadávacie kritériá neboli nájdené.',
  'LBL_ENABLED' => 'Povolené',
  'LBL_EXTERNAL' => 'Povoliť užívateľom vytvárať záznamy externých účtov k tomuto konektoru. Za účelom uplatňovania konektora, vlastnosti by mali byť určené na stránke nastavení Nastavenie vlastností konektora',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Za účelom uplatňovania tohto konektora, vlastnosti by mali byť nastavené v Nastavenie konektora, na stránke nastavení',
  'LBL_FINSALES' => 'Ročný predaj',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Trhová kapitalizácia',
  'LBL_MERGE' => 'Zlúčiť',
  'LBL_MODIFY_DISPLAY_DESC' => 'Vybrať, ktoré moduly budú povolené pre každý konektor.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Nastavenia konektora: Povoliť konektory',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Povoliť konektory',
  'LBL_MODIFY_MAPPING_DESC' => 'Mapa polí konektora do polí modulu, za účelom vymedzenia dát, ktoré majú byť zobrazené a zlužované do záznamov modulu.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Nastavenie konektora: Mapa polí konektora',
  'LBL_MODIFY_MAPPING_TITLE' => 'Mapa polí konektora',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Configurovať vlastnosti pre každý konektor, vrátane URL adries a API kľúčov.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Nastavenie konektora: Nastavenie vlastností konektora',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Nastavenie vlastností konektora',
  'LBL_MODIFY_SEARCH' => 'Vyhľadávanie',
  'LBL_MODIFY_SEARCH_DESC' => 'Výber polí konektora k vyhľadávaniu pre každý modul.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Nastavenie konektora: Správa prehľadávania konektorov',
  'LBL_MODIFY_SEARCH_TITLE' => 'Správa prehľadávania konektorov',
  'LBL_MODULE_FIELDS' => 'Polia modulu',
  'LBL_MODULE_NAME' => 'Konektory',
  'LBL_MODULE_NAME_SINGULAR' => 'Konektor',
  'LBL_NO_PROPERTIES' => 'Tu nie sú konfigurovateľné vlastnosti pre tento konektor.',
  'LBL_PARENT_DUNS' => 'Nadriadený DUNS',
  'LBL_PREVIOUS' => '< Späť',
  'LBL_QUOTE' => 'Ponuka',
  'LBL_RECNAME' => 'Názov spoločnosti',
  'LBL_RESET_BUTTON_TITLE' => 'Reset',
  'LBL_RESET_TO_DEFAULT' => 'Reset do prednastavenia',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Ste si istý, že chcete resetovať do prednastavenej konfigurácii?',
  'LBL_RESULT_LIST' => 'Prehľad údajov',
  'LBL_RUN_WIZARD' => 'Spustiť sprievodcu',
  'LBL_SAVE' => 'Uložiť',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Vyhľadávanie...',
  'LBL_SHOW_IN_LISTVIEW' => 'Zobraziť v zlúčenom zozname',
  'LBL_SMART_COPY' => 'Smart Copy',
  'LBL_STEP1' => 'Údaje vyhľadať a zobraziť',
  'LBL_STEP2' => 'Zlúčiť záznam s',
  'LBL_SUMMARY' => 'Sumár',
  'LBL_TEST_SOURCE' => 'Test konektora',
  'LBL_TEST_SOURCE_FAILED' => 'Test zlyhal',
  'LBL_TEST_SOURCE_RUNNING' => 'Vykonávanie testu...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test bol úspešný',
  'LBL_TITLE' => 'Zlúčenie údajov',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Konečné nadriadené DUNS',
  'dnb_countries_iso' => 
  array (
    'AD' => '',
    'AE' => '',
    'AF' => '',
    'AG' => '',
    'AI' => '',
    'AL' => '',
    'AM' => '',
    'AN' => '',
    'AO' => '',
    'AQ' => '',
    'AR' => '',
    'AS' => '',
    'AT' => '',
    'AU' => '',
    'AW' => '',
    'AZ' => '',
    'BA' => '',
    'BB' => '',
    'BD' => '',
    'BE' => '',
    'BF' => '',
    'BG' => '',
    'BH' => '',
    'BI' => '',
    'BJ' => '',
    'BM' => '',
    'BN' => '',
    'BO' => '',
    'BR' => '',
    'BS' => '',
    'BT' => '',
    'BV' => '',
    'BW' => '',
    'BY' => '',
    'BZ' => '',
    'CA' => '',
    'CC' => '',
    'CD' => '',
    'CF' => '',
    'CG' => '',
    'CH' => '',
    'CI' => '',
    'CK' => '',
    'CL' => '',
    'CM' => '',
    'CN' => '',
    'CO' => '',
    'CR' => '',
    'CU' => '',
    'CV' => '',
    'CX' => '',
    'CY' => '',
    'CZ' => '',
    'DE' => '',
    'DJ' => '',
    'DK' => '',
    'DM' => '',
    'DO' => '',
    'DZ' => '',
    'EC' => '',
    'EE' => '',
    'EG' => '',
    'EH' => '',
    'ER' => '',
    'ES' => '',
    'ET' => '',
    'FI' => '',
    'FJ' => '',
    'FK' => '',
    'FM' => '',
    'FO' => '',
    'FR' => '',
    'FX' => '',
    'GA' => '',
    'GB' => '',
    'GD' => '',
    'GE' => '',
    'GF' => '',
    'GH' => '',
    'GI' => '',
    'GL' => '',
    'GM' => '',
    'GN' => '',
    'GP' => '',
    'GQ' => '',
    'GR' => '',
    'GS' => '',
    'GT' => '',
    'GU' => '',
    'GW' => '',
    'GY' => '',
    'HK' => '',
    'HM' => '',
    'HN' => '',
    'HR' => '',
    'HT' => '',
    'HU' => '',
    'ID' => '',
    'IE' => '',
    'IL' => '',
    'IN' => '',
    'IO' => '',
    'IQ' => '',
    'IR' => '',
    'IS' => '',
    'IT' => '',
    'JM' => '',
    'JO' => '',
    'JP' => '',
    'KE' => '',
    'KG' => '',
    'KH' => '',
    'KI' => '',
    'KM' => '',
    'KN' => '',
    'KP' => '',
    'KR' => '',
    'KW' => '',
    'KY' => '',
    'KZ' => '',
    'LA' => '',
    'LB' => '',
    'LC' => '',
    'LI' => '',
    'LK' => '',
    'LR' => '',
    'LS' => '',
    'LT' => '',
    'LU' => '',
    'LV' => '',
    'LY' => '',
    'MA' => '',
    'MC' => '',
    'MD' => '',
    'ME' => '',
    'MG' => '',
    'MH' => '',
    'MK' => '',
    'ML' => '',
    'MM' => '',
    'MN' => '',
    'MO' => '',
    'MP' => '',
    'MQ' => '',
    'MR' => '',
    'MS' => '',
    'MT' => '',
    'MU' => '',
    'MV' => '',
    'MW' => '',
    'MX' => '',
    'MY' => '',
    'MZ' => '',
    'NA' => '',
    'NC' => '',
    'NE' => '',
    'NF' => '',
    'NG' => '',
    'NI' => '',
    'NL' => '',
    'NO' => '',
    'NP' => '',
    'NR' => '',
    'NU' => '',
    'NZ' => '',
    'OM' => '',
    'PA' => '',
    'PE' => '',
    'PF' => '',
    'PG' => '',
    'PH' => '',
    'PK' => '',
    'PL' => '',
    'PM' => '',
    'PN' => '',
    'PR' => '',
    'PS' => '',
    'PT' => '',
    'PW' => '',
    'PY' => '',
    'QA' => '',
    'RE' => '',
    'RO' => '',
    'RS' => '',
    'RU' => '',
    'RW' => '',
    'SA' => '',
    'SB' => '',
    'SC' => '',
    'SD' => '',
    'SE' => '',
    'SG' => '',
    'SH' => '',
    'SI' => '',
    'SJ' => '',
    'SK' => '',
    'SL' => '',
    'SM' => '',
    'SN' => '',
    'SO' => '',
    'SR' => '',
    'ST' => '',
    'SV' => '',
    'SY' => '',
    'SZ' => '',
    'TC' => '',
    'TD' => '',
    'TF' => '',
    'TG' => '',
    'TH' => '',
    'TJ' => '',
    'TK' => '',
    'TM' => '',
    'TN' => '',
    'TO' => '',
    'TP' => '',
    'TR' => '',
    'TT' => '',
    'TV' => '',
    'TW' => '',
    'TZ' => '',
    'UA' => '',
    'UG' => '',
    'UM' => '',
    'US' => '',
    'UY' => '',
    'UZ' => '',
    'VA' => '',
    'VC' => '',
    'VE' => '',
    'VG' => '',
    'VI' => '',
    'VN' => '',
    'VU' => '',
    'WF' => '',
    'WS' => '',
    'YE' => '',
    'YT' => '',
    'ZA' => '',
    'ZM' => '',
    'ZW' => '',
  ),
  'dnb_states_iso' => 
  array (
    'AD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AQ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'AZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BB' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BJ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'BZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'CZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'Country' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DJ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'DZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'EC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'EE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'EG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ER' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ES' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ET' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FJ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'FX' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
      85 => 
      array (
        'code' => '',
        'name' => '',
      ),
      86 => 
      array (
        'code' => '',
        'name' => '',
      ),
      87 => 
      array (
        'code' => '',
        'name' => '',
      ),
      88 => 
      array (
        'code' => '',
        'name' => '',
      ),
      89 => 
      array (
        'code' => '',
        'name' => '',
      ),
      90 => 
      array (
        'code' => '',
        'name' => '',
      ),
      91 => 
      array (
        'code' => '',
        'name' => '',
      ),
      92 => 
      array (
        'code' => '',
        'name' => '',
      ),
      93 => 
      array (
        'code' => '',
        'name' => '',
      ),
      94 => 
      array (
        'code' => '',
        'name' => '',
      ),
      95 => 
      array (
        'code' => '',
        'name' => '',
      ),
      96 => 
      array (
        'code' => '',
        'name' => '',
      ),
      97 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GB' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
      85 => 
      array (
        'code' => '',
        'name' => '',
      ),
      86 => 
      array (
        'code' => '',
        'name' => '',
      ),
      87 => 
      array (
        'code' => '',
        'name' => '',
      ),
      88 => 
      array (
        'code' => '',
        'name' => '',
      ),
      89 => 
      array (
        'code' => '',
        'name' => '',
      ),
      90 => 
      array (
        'code' => '',
        'name' => '',
      ),
      91 => 
      array (
        'code' => '',
        'name' => '',
      ),
      92 => 
      array (
        'code' => '',
        'name' => '',
      ),
      93 => 
      array (
        'code' => '',
        'name' => '',
      ),
      94 => 
      array (
        'code' => '',
        'name' => '',
      ),
      95 => 
      array (
        'code' => '',
        'name' => '',
      ),
      96 => 
      array (
        'code' => '',
        'name' => '',
      ),
      97 => 
      array (
        'code' => '',
        'name' => '',
      ),
      98 => 
      array (
        'code' => '',
        'name' => '',
      ),
      99 => 
      array (
        'code' => '',
        'name' => '',
      ),
      100 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GQ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'GY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'HU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ID' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IQ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'IT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
      85 => 
      array (
        'code' => '',
        'name' => '',
      ),
      86 => 
      array (
        'code' => '',
        'name' => '',
      ),
      87 => 
      array (
        'code' => '',
        'name' => '',
      ),
      88 => 
      array (
        'code' => '',
        'name' => '',
      ),
      89 => 
      array (
        'code' => '',
        'name' => '',
      ),
      90 => 
      array (
        'code' => '',
        'name' => '',
      ),
      91 => 
      array (
        'code' => '',
        'name' => '',
      ),
      92 => 
      array (
        'code' => '',
        'name' => '',
      ),
      93 => 
      array (
        'code' => '',
        'name' => '',
      ),
      94 => 
      array (
        'code' => '',
        'name' => '',
      ),
      95 => 
      array (
        'code' => '',
        'name' => '',
      ),
      96 => 
      array (
        'code' => '',
        'name' => '',
      ),
      97 => 
      array (
        'code' => '',
        'name' => '',
      ),
      98 => 
      array (
        'code' => '',
        'name' => '',
      ),
      99 => 
      array (
        'code' => '',
        'name' => '',
      ),
      100 => 
      array (
        'code' => '',
        'name' => '',
      ),
      101 => 
      array (
        'code' => '',
        'name' => '',
      ),
      102 => 
      array (
        'code' => '',
        'name' => '',
      ),
      103 => 
      array (
        'code' => '',
        'name' => '',
      ),
      104 => 
      array (
        'code' => '',
        'name' => '',
      ),
      105 => 
      array (
        'code' => '',
        'name' => '',
      ),
      106 => 
      array (
        'code' => '',
        'name' => '',
      ),
      107 => 
      array (
        'code' => '',
        'name' => '',
      ),
      108 => 
      array (
        'code' => '',
        'name' => '',
      ),
      109 => 
      array (
        'code' => '',
        'name' => '',
      ),
      110 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'JM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'JO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'JP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'KZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LB' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'LY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ML' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MQ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MX' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'MZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'NZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'OM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'PY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'QA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'RO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'RU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
      82 => 
      array (
        'code' => '',
        'name' => '',
      ),
      83 => 
      array (
        'code' => '',
        'name' => '',
      ),
      84 => 
      array (
        'code' => '',
        'name' => '',
      ),
      85 => 
      array (
        'code' => '',
        'name' => '',
      ),
      86 => 
      array (
        'code' => '',
        'name' => '',
      ),
      87 => 
      array (
        'code' => '',
        'name' => '',
      ),
      88 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'RW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SB' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SL' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ST' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'SZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TD' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TH' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TJ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TK' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TO' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TP' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
      66 => 
      array (
        'code' => '',
        'name' => '',
      ),
      67 => 
      array (
        'code' => '',
        'name' => '',
      ),
      68 => 
      array (
        'code' => '',
        'name' => '',
      ),
      69 => 
      array (
        'code' => '',
        'name' => '',
      ),
      70 => 
      array (
        'code' => '',
        'name' => '',
      ),
      71 => 
      array (
        'code' => '',
        'name' => '',
      ),
      72 => 
      array (
        'code' => '',
        'name' => '',
      ),
      73 => 
      array (
        'code' => '',
        'name' => '',
      ),
      74 => 
      array (
        'code' => '',
        'name' => '',
      ),
      75 => 
      array (
        'code' => '',
        'name' => '',
      ),
      76 => 
      array (
        'code' => '',
        'name' => '',
      ),
      77 => 
      array (
        'code' => '',
        'name' => '',
      ),
      78 => 
      array (
        'code' => '',
        'name' => '',
      ),
      79 => 
      array (
        'code' => '',
        'name' => '',
      ),
      80 => 
      array (
        'code' => '',
        'name' => '',
      ),
      81 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TV' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'TZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UG' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'US' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
      33 => 
      array (
        'code' => '',
        'name' => '',
      ),
      34 => 
      array (
        'code' => '',
        'name' => '',
      ),
      35 => 
      array (
        'code' => '',
        'name' => '',
      ),
      36 => 
      array (
        'code' => '',
        'name' => '',
      ),
      37 => 
      array (
        'code' => '',
        'name' => '',
      ),
      38 => 
      array (
        'code' => '',
        'name' => '',
      ),
      39 => 
      array (
        'code' => '',
        'name' => '',
      ),
      40 => 
      array (
        'code' => '',
        'name' => '',
      ),
      41 => 
      array (
        'code' => '',
        'name' => '',
      ),
      42 => 
      array (
        'code' => '',
        'name' => '',
      ),
      43 => 
      array (
        'code' => '',
        'name' => '',
      ),
      44 => 
      array (
        'code' => '',
        'name' => '',
      ),
      45 => 
      array (
        'code' => '',
        'name' => '',
      ),
      46 => 
      array (
        'code' => '',
        'name' => '',
      ),
      47 => 
      array (
        'code' => '',
        'name' => '',
      ),
      48 => 
      array (
        'code' => '',
        'name' => '',
      ),
      49 => 
      array (
        'code' => '',
        'name' => '',
      ),
      50 => 
      array (
        'code' => '',
        'name' => '',
      ),
      51 => 
      array (
        'code' => '',
        'name' => '',
      ),
      52 => 
      array (
        'code' => '',
        'name' => '',
      ),
      53 => 
      array (
        'code' => '',
        'name' => '',
      ),
      54 => 
      array (
        'code' => '',
        'name' => '',
      ),
      55 => 
      array (
        'code' => '',
        'name' => '',
      ),
      56 => 
      array (
        'code' => '',
        'name' => '',
      ),
      57 => 
      array (
        'code' => '',
        'name' => '',
      ),
      58 => 
      array (
        'code' => '',
        'name' => '',
      ),
      59 => 
      array (
        'code' => '',
        'name' => '',
      ),
      60 => 
      array (
        'code' => '',
        'name' => '',
      ),
      61 => 
      array (
        'code' => '',
        'name' => '',
      ),
      62 => 
      array (
        'code' => '',
        'name' => '',
      ),
      63 => 
      array (
        'code' => '',
        'name' => '',
      ),
      64 => 
      array (
        'code' => '',
        'name' => '',
      ),
      65 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UY' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'UZ' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VC' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VI' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VN' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
      20 => 
      array (
        'code' => '',
        'name' => '',
      ),
      21 => 
      array (
        'code' => '',
        'name' => '',
      ),
      22 => 
      array (
        'code' => '',
        'name' => '',
      ),
      23 => 
      array (
        'code' => '',
        'name' => '',
      ),
      24 => 
      array (
        'code' => '',
        'name' => '',
      ),
      25 => 
      array (
        'code' => '',
        'name' => '',
      ),
      26 => 
      array (
        'code' => '',
        'name' => '',
      ),
      27 => 
      array (
        'code' => '',
        'name' => '',
      ),
      28 => 
      array (
        'code' => '',
        'name' => '',
      ),
      29 => 
      array (
        'code' => '',
        'name' => '',
      ),
      30 => 
      array (
        'code' => '',
        'name' => '',
      ),
      31 => 
      array (
        'code' => '',
        'name' => '',
      ),
      32 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'VU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'WF' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'WS' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'YE' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
      18 => 
      array (
        'code' => '',
        'name' => '',
      ),
      19 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'YT' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
      12 => 
      array (
        'code' => '',
        'name' => '',
      ),
      13 => 
      array (
        'code' => '',
        'name' => '',
      ),
      14 => 
      array (
        'code' => '',
        'name' => '',
      ),
      15 => 
      array (
        'code' => '',
        'name' => '',
      ),
      16 => 
      array (
        'code' => '',
        'name' => '',
      ),
      17 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'YU' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ZA' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ZM' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ZR' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
      11 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    'ZW' => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
      9 => 
      array (
        'code' => '',
        'name' => '',
      ),
      10 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
    86 => 
    array (
      1 => 
      array (
        'code' => '',
        'name' => '',
      ),
      2 => 
      array (
        'code' => '',
        'name' => '',
      ),
      3 => 
      array (
        'code' => '',
        'name' => '',
      ),
      4 => 
      array (
        'code' => '',
        'name' => '',
      ),
      5 => 
      array (
        'code' => '',
        'name' => '',
      ),
      6 => 
      array (
        'code' => '',
        'name' => '',
      ),
      7 => 
      array (
        'code' => '',
        'name' => '',
      ),
      8 => 
      array (
        'code' => '',
        'name' => '',
      ),
    ),
  ),
);

