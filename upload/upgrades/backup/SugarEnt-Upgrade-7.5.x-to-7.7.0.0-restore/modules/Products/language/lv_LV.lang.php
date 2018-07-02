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
  'ERR_DELETE_RECORD' => 'Jānorāda ieraksta numurs, lai dzēstu produktu.',
  'LBL_ACCOUNT_ID' => 'Konta ID',
  'LBL_ACCOUNT_NAME' => 'Konta nosaukums:',
  'LBL_ASSET_NUMBER' => 'Aktīva numurs:',
  'LBL_ASSIGNED_TO_NAME' => 'Piešķirts lietotājam:',
  'LBL_ASSIGNED_USER_ID' => 'Piešķirts lietotājam ar ID',
  'LBL_ASSOCIATED_QUOTE' => 'Piedāvājuma temats:',
  'LBL_BOOK_VALUE' => 'Bilances vērtība:',
  'LBL_BOOK_VALUE_DATE' => 'Bilances vērtības datums:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Grāmatošanas vērtība (pamatvalūtā):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Aprēķinātā ieņēmumu posteņa summa',
  'LBL_CAMPAIGN_PRODUCT' => 'Kampaņas produkts',
  'LBL_CATEGORY' => 'Kategorija:',
  'LBL_CATEGORY_NAME' => 'Kategorijas nosaukums:',
  'LBL_COMMIT_STAGE' => 'Iesniegt posmu',
  'LBL_COMMIT_STAGE_FORECAST' => 'Prognoze',
  'LBL_CONTACT' => 'Kontaktpersona',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktpersonas',
  'LBL_CONTACT_ID' => 'Kontakta ID',
  'LBL_CONTACT_NAME' => 'Kontakta vārds:',
  'LBL_CONTRACTS' => 'Līgumi',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Līgumi',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Kļūda:',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Kļūda konvertējot piedāvāto posteni uz piedāvājumu',
  'LBL_COST_PRICE' => 'Izmaksas:',
  'LBL_COST_USDOLLAR' => 'Izmaksas (pamatvalūtā)',
  'LBL_CREATED_USER' => 'Izveidoja',
  'LBL_CURRENCY' => 'Valūta:',
  'LBL_CURRENCY_ID' => 'Valūtas ID:',
  'LBL_CURRENCY_RATE' => 'Valūtas kurss',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Valūtas simbols:',
  'LBL_DATE_CLOSED' => 'Paredzēts slēgšanas datums',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Paredzētā slēgšanas datuma laikspiedols',
  'LBL_DATE_PURCHASED' => 'Iegādāts:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'Atbalsta termiņa beigas:',
  'LBL_DATE_SUPPORT_STARTS' => 'Atbalsta sākums:',
  'LBL_DEAL_TOT' => 'Atlaide:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Produkti',
  'LBL_DESCRIPTION' => 'Apraksts:',
  'LBL_DISCOUNT_AMOUNT' => 'Atlaides summa',
  'LBL_DISCOUNT_AS_PERCENT' => 'Atlaide %',
  'LBL_DISCOUNT_PRICE' => 'Vienības cena:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Cenas atlaidesi datums:',
  'LBL_DISCOUNT_RATE' => 'Atlaide',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Atlaide (pamatvalūtā)',
  'LBL_DISCOUNT_TOTAL' => 'Atlaide kopā',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Atlaide (pamatvalūtā)',
  'LBL_DISCOUNT_USDOLLAR' => 'Atlaide (pamatvalūtā)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenti',
  'LBL_EDITLAYOUT' => 'Rediģēt izkārtojumu',
  'LBL_EXPERT_ID' => 'Produkta eksperts',
  'LBL_EXPORT_CURRENCY_ID' => 'Valūtas ID',
  'LBL_EXT_PRICE' => 'Kopējā cena',
  'LBL_FORECAST' => 'Iekļatu prognozē',
  'LBL_HELP_CREATE' => '{{plural_module_name}} modulis satur visus produktus, kas ir tikuši pārdoti klientiem vai kuru pārdošanas vēl ir procesā.

Lai izveidotu ierakstu:
1. Ievadiet atbilstošos laukos prasītās vērtības.
 - Lauki saglabātu ierakstu ir jāaizpilda lauki kas atzīmēti kā obligāti.
 - Ja nepieciešams redzēt papildus laukus spiediet uz "Rādīt vairāk".
2. Spiediet "Saglabāt" lai pabeigtu jauna ierakst veidošanu un atgrieztos iepriekšējā lapā.
 - Izvēlieties "Saglabāt un apskatīt" lai atvērtu jauno kļūdu ierakstu skata logā.
 - Izvēlieties "Saglabāt un veidot jaunu" lai uzreiz izveidotu vēl vienu jaunu kļūdas pieteikumu.',
  'LBL_HELP_RECORD' => '{{plural_module_name}} modulis satur visus produktus, kas ir tikuši pārdoti klientiem vai kuru pārdošanas vēl ir procesā.

- Rediģējiet ieraksta laukus klikšķinot uz laukiem vai pogas Rediģēt.
- Apskatiet vai rediģējiet saites uz cietiem ierakstiem apakšpaneļos ieslēdzot datu skatu kreisajā apakšējā panelī.
- Veidojiet un apskaties lietotāju komentārus un ierakstu izmaiņu vēsturi darbību plūsmas panelī ieslēdzot darbību plūsmas skatu kreisajā apakšējā panelī.
- Sekojiet vai izceliet šo ierakstu izmantojot ikonas pa labi no ieraksta nosaukuma.
- Papildus darbības pieejamas izkrītošajā darbību izvēlnē pa labi no Rediģēšanas pogas.',
  'LBL_HELP_RECORDS' => '{{plural_module_name}} modulis satur visus produktus, kas ir tikuši pārdoti klientiem vai kuru pārdošanas vēl ir procesā. Produktu saraksts ko uzņēmums pārdod klientiem atrodas Administratora sadaļā Produktu katalogs un administrators var pievienot jaunus produktus pēc vajadzības. Kad tiek veidots produkts jums ir iespēja izvēlēties produktu no katalogs vai izveidot jaunu produktu. Ir vairāki veidi kā izveidot ierakstu caru {{plural_module_name}} moduli, {{quotes_module}} modulī, dublējot, importējot {{plural_module_name}}, u.c. Kad ieraksts ir izveidots jūs varat redzēt un rediģēt ar moduli saistīto informāciju ieraksta kartiņā.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Interesenti',
  'LBL_LEAD_SOURCE' => 'Interesenta avots',
  'LBL_LIST_ACCOUNT_NAME' => 'Konta nosaukums',
  'LBL_LIST_CONTACT_NAME' => 'Kontakta vārds',
  'LBL_LIST_COST_PRICE' => 'Izmaksas',
  'LBL_LIST_DATE_PURCHASED' => 'Iegādāts',
  'LBL_LIST_DISCOUNT_PRICE' => 'Cena',
  'LBL_LIST_FORM_TITLE' => 'Produktu saraksts',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Raž. Nr.',
  'LBL_LIST_LIST_PRICE' => 'Saraksts',
  'LBL_LIST_MANUFACTURER' => 'Ražotājs',
  'LBL_LIST_NAME' => 'Piedāvājuma rinda',
  'LBL_LIST_PRICE' => 'Kataloga cena:',
  'LBL_LIST_QUANTITY' => 'Daudzums',
  'LBL_LIST_QUOTE_NAME' => 'Vārds pēdiņās',
  'LBL_LIST_STATUS' => 'Statuss',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Termiņš beidzas',
  'LBL_LIST_USDOLLAR' => 'Kataloga cena (pamatvalūtā)',
  'LBL_MANUFACTURER' => 'Izgatavotājs:',
  'LBL_MANUFACTURERS' => 'Ražotāji',
  'LBL_MANUFACTURER_NAME' => 'Ražotāja nosaukums:',
  'LBL_MEMBER_OF' => 'Biedrs:',
  'LBL_MFT_PART_NUM' => 'Izgatavotāja detaļas numurs:',
  'LBL_MODIFIED_USER' => 'Modificēja',
  'LBL_MODULE_NAME' => 'Piedāvājuma rindas',
  'LBL_MODULE_NAME_SINGULAR' => 'Piedāvājuma rinda',
  'LBL_MODULE_TITLE' => 'Piedāvājuma rindas: Sākums',
  'LBL_NAME' => 'Nosaukums',
  'LBL_NEW_FORM_TITLE' => 'Izveidot produktu',
  'LBL_NEXT_STEP' => 'Nākamais solis:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Piezīmes',
  'LBL_OPPORTUNITY' => 'Iespēja',
  'LBL_OPPORTUNITY_ID' => 'Iespējas ID',
  'LBL_PRICING_FACTOR' => 'Cenu veidošanas faktors',
  'LBL_PRICING_FORMULA' => 'Cenu veidošanas formula:',
  'LBL_PROBABILITY' => 'Varbūtība (%)',
  'LBL_PRODUCT' => 'Piedāvājuma rinda:',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Piedāvājuma rindas',
  'LBL_PRODUCT_CATEGORIES' => 'Produktu kategorijas',
  'LBL_PRODUCT_TEMPLATE' => 'Produkta veidne:',
  'LBL_PRODUCT_TEMPLATE_ID' => 'Produkta veidnes ID:',
  'LBL_PRODUCT_TYPES' => 'Produktu veidi',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekti',
  'LBL_QUANTITY' => 'Daudzums:',
  'LBL_QUOTE' => 'Piedāvājums',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Piedāvājumi',
  'LBL_QUOTE_ID' => 'Piedāvājuma ID:',
  'LBL_QUOTE_NAME' => 'Vārds pēdiņās:',
  'LBL_RELATED_PRODUCTS' => 'Saistītās piedāvājuma rindas',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Piedāvājuma rindas',
  'LBL_REVENUELINEITEM' => 'Ieņēmumu postenis',
  'LBL_REVENUELINEITEMS' => 'Ieņēmumu posteņi',
  'LBL_REVENUELINEITEM_ID' => 'Ieņēmumu posteņa ID:',
  'LBL_REVENUELINEITEM_NAME' => 'Ieņēmumu posteņa nosaukums',
  'LBL_SALES_STAGE' => 'Pārdošanas posms',
  'LBL_SALES_STATUS' => 'Ieņēmumu posteņa statuss',
  'LBL_SEARCH_FORM_TITLE' => 'Produkta meklēšana',
  'LBL_SELECT_DISCOUNT' => 'Atlaide %',
  'LBL_SERIAL_NUMBER' => 'Sērijas numurs:',
  'LBL_STATUS' => 'Statuss:',
  'LBL_SUPPORT_CONTACT' => 'Atbalsta kontaktinformācija:',
  'LBL_SUPPORT_DESCRIPTION' => 'Atbalsta apraksts:',
  'LBL_SUPPORT_NAME' => 'Atbalsta nosaukums:',
  'LBL_SUPPORT_TERM' => 'Atbalsta termiņš:',
  'LBL_TAX_CLASS' => 'Nodokļu klase:',
  'LBL_TYPE' => 'Veids:',
  'LBL_URL' => 'Produkta URL:',
  'LBL_VENDOR_PART_NUM' => 'Pārdevēja detaļas numurs:',
  'LBL_WEBSITE' => 'Tīmekļa vietne',
  'LBL_WEIGHT' => 'Svars:',
  'LNK_IMPORT_PRODUCTS' => 'Importēt produktus',
  'LNK_NEW_PRODUCT' => 'Izveidot produktu',
  'LNK_PRODUCT_LIST' => 'Produkti',
  'NTC_DELETE_CONFIRMATION' => 'Vai tiešām vēlaties dzēst šo ierakstu?',
  'NTC_REMOVE_CONFIRMATION' => 'Vai tiešām vēlaties dzēst šo produkta relāciju?',
);

