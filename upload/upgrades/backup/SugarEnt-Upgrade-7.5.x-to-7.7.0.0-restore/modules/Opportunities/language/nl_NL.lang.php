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
  'ERR_DELETE_RECORD' => 'U dient een recordnummer op te geven om deze opportunity te verwijderen.',
  'LABEL_PANEL_ASSIGNMENT' => 'Toewijzing',
  'LBL_ACCOUNT_ID' => 'Organisatie ID',
  'LBL_ACCOUNT_NAME' => 'Organisatienaam:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activiteiten',
  'LBL_ASSIGNED_TO_ID' => 'Toegewezen aan ID',
  'LBL_ASSIGNED_TO_NAME' => 'Toegewezen aan:',
  'LBL_CAMPAIGN' => 'Campagne:',
  'LBL_CAMPAIGN_LINK' => 'Campagne link',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Campagnes',
  'LBL_CLOSED_RLIS' => '# aantal gesloten opportunityregels',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Gewonnen Opportunities',
  'LBL_COMMITTED' => 'Committed',
  'LBL_COMMIT_STAGE' => 'Commit stadium',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Personen',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'E-mails van gerelateerde personen',
  'LBL_CONTRACTS' => 'Contracten',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Contracten',
  'LBL_CREATED_ID' => 'Aangemaakt door ID',
  'LBL_CREATED_USER' => 'Aangemaakt door Gebruiker',
  'LBL_CURRENCIES' => 'Valutas',
  'LBL_CURRENCY' => 'Valuta:',
  'LBL_CURRENCY_ID' => 'Valuta ID',
  'LBL_CURRENCY_NAME' => 'Valutanaam',
  'LBL_CURRENCY_RATE' => 'Valutakoers',
  'LBL_CURRENCY_SYMBOL' => 'Valuta symbool',
  'LBL_DATE_CLOSED' => 'Verwachte afsluitdatum:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Verwachte sluitingsdatum',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Opportunities',
  'LBL_DESCRIPTION' => 'Beschrijving:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documenten',
  'LBL_DUPLICATE' => 'Mogelijk dubbele Opportunity',
  'LBL_EDITLAYOUT' => 'Wijzig Lay-out',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Toegewezen aan ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Toegewezen aan',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Campagne ID',
  'LBL_EXPORT_CREATED_BY' => 'Gemaakt door ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Gewijzigd door ID',
  'LBL_EXPORT_NAME' => 'Naam',
  'LBL_FILENAME' => 'Bijlage',
  'LBL_FORECAST' => 'Meenemen in de forecast',
  'LBL_HELP_CREATE' => 'De {{plural_module_name}} module stelt u in staat om afzonderlijke verkopen en de regelitems behorende bij deze verkopen te volgen van begin tot het einde van het verkooptraject. Elk {{module_name}} record is een overkoepeling voor een groep {{revenuelineitems_module}} en andere belangrijke gegevens, zoals bijvoorbeeld {{quotes_module}}, {{contacts_module}}, etc.

Om een {{module_name}} aan te maken:
1. Voer de gewenste gegevens in.
 - Velden die "verplicht" zijn, moeten ingevuld zijn voordat het record opgeslagen kan worden.
 - Klik op "Toon meer" om extra velden te tonen.
2. Klik op "Opslaan" om het record op te slaan en terug te keren naar de voorgaande pagina.
 - Kies "Sla op en bekijk" om de nieuwe {{module_name}} in record view te bekijken.
 - Kies "Sla op en maak nieuwe aan" om direct een nieuwe {{module_name}} aan te maken.
3. Gebruik na het opslaan het {{revenuelineitems_module}} subpaneel om regels toe te voegen aan de {{module_name}}.',
  'LBL_HELP_RECORD' => 'De {{plural_module_name}} module stelt u in staat om afzonderlijke verkopen en de regelitems behorende bij deze verkopen te volgen van begin tot het einde van het verkooptraject. Elk {{module_name}} record is een overkoepeling voor een groep {{revenuelineitems_module}} en andere belangrijke gegevens, zoals bijvoorbeeld {{quotes_module}}, {{contacts_module}}, etc.

- Pas de gegevens aan door op een individueel veld of op de Wijzigen knop te klikken.
- Bekijk of pas koppelingen met andere records aan in de subpanels door de "Data View" in te schakelen in het paneel linksonder..
- Maak en bekijk opmerkingen van gebruikers en de wijzigingshistorie door "Activity Stream" in te schakelen in het paneel linksonder.
- Volg of maak het record favoriet door gebruik te maken van de icoontjes rechts naast de naam van het record.
- Extra acties zijn beschikbaar via het dropdown actie menu rechts naast de Wijzigen knop.',
  'LBL_HELP_RECORDS' => 'De {{plural_module_name}} module stelt u in staat om afzonderlijke verkopen en de regelitems behorende bij deze verkopen te volgen van begin tot het einde van het verkooptraject. Elk {{module_name}} record is een overkoepeling voor een groep {{revenuelineitems_module}} en andere belangrijke gegevens, zoals bijvoorbeeld {{quotes_module}}, {{contacts_module}}, etc. Elk {{revenuelineitems_singular_module}} is de potentiële verkoop van een bepaald product en behelst relevante verkoop informatie. Elke {{revenuelineitems_singular_module}} doorloopt normaal gesproken enkele verkoopstadia totdat deze "Gesloten - Gewonnen" óf "Gesloten - Verloren" wordt. Het {{module_name}} record vertegenwoordigd de waarde en de verwachte sluitingsdatum van de bijbehorende {{revenuelineitems_module}}. Het gebruik van {{plural_module_name}} en {{revenuelineitems_module}} kan nog verder verbeterd worden door gebruik te maken van Sugar&#39;s {{forecasts_singular_module}}ing module om daarmee beter grip te krijgen op verkooptrends en vraagvoorspelling als ook om de focus te krijgen op het behalen van verkoopqouta&#39;s.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historie',
  'LBL_INVITEE' => 'Personen',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Bron voor lead:',
  'LBL_LIST_ACCOUNT_NAME' => 'Organisatienaam',
  'LBL_LIST_AMOUNT' => 'Meest waarschijnlijk',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Totaal Bedrag',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Toegewezen aan',
  'LBL_LIST_DATE_CLOSED' => 'Verwachte sluitingsdatum',
  'LBL_LIST_FORM_TITLE' => 'Opportunities',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Opportunity',
  'LBL_LIST_SALES_STAGE' => 'Verkoopstadium',
  'LBL_MKTO_ID' => 'Marketo Lead ID',
  'LBL_MKTO_SYNC' => 'Sync to Marketo&reg;',
  'LBL_MODIFIED_ID' => 'Gewijzigd door ID',
  'LBL_MODIFIED_NAME' => 'Gewijzigd door Gebruikersnaam',
  'LBL_MODIFIED_USER' => 'Gewijzigd door Gebruiker',
  'LBL_MODULE_NAME' => 'Opportunities',
  'LBL_MODULE_NAME_SINGULAR' => 'Opportunity',
  'LBL_MODULE_TITLE' => 'Opportunities: Start',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Mijn gewonnen Opportunities',
  'LBL_NAME' => 'Opportunitynaam',
  'LBL_NEW_FORM_TITLE' => 'Nieuwe Opportunity',
  'LBL_NEXT_STEP' => 'Volgende stap:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notities',
  'LBL_OPPORTUNITY' => 'Opportunity:',
  'LBL_OPPORTUNITY_NAME' => 'Opportunitynaam:',
  'LBL_OPPORTUNITY_ROLE' => 'Opportunity Rol',
  'LBL_OPPORTUNITY_TYPE' => 'Opportunity Type',
  'LBL_PIPELINE_TOTAL_IS' => 'Totaal in de pijplijn is',
  'LBL_PRIMARY_QUOTE_ID' => 'Primaire Offerte',
  'LBL_PROBABILITY' => 'Waarschijnlijkheid (%):',
  'LBL_PRODUCTS' => 'Producten',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Geoffreerde producten',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projecten',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projecten',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Offertes',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Offertes',
  'LBL_RAW_AMOUNT' => 'Ruw Bedrag',
  'LBL_RLI' => 'Opportunityregel',
  'LBL_RLI_SUBPANEL_TITLE' => 'Opportunityregels',
  'LBL_SALES_STAGE' => 'Verkoopstadium:',
  'LBL_SALES_STATUS' => 'Status',
  'LBL_SEARCH_FORM_TITLE' => 'Opportunity zoeken',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TIMEPERIODS' => 'Periodes',
  'LBL_TIMEPERIOD_ID' => 'TimePeriod ID',
  'LBL_TOP_OPPORTUNITIES' => 'Mijn openstaande top Opportunities',
  'LBL_TOTAL_OPPORTUNITIES' => 'Totaal Opportunities',
  'LBL_TOTAL_RLIS' => '# aantal opportunityregels',
  'LBL_TYPE' => 'Type:',
  'LBL_VIEW_FORM_TITLE' => 'Opportunity overzicht',
  'LBL_WORKSHEET' => 'Werkblad',
  'LNK_CREATE' => 'Maak nieuwe Deal',
  'LNK_IMPORT_OPPORTUNITIES' => 'Importeer Opportunities',
  'LNK_NEW_OPPORTUNITY' => 'Nieuwe Opportunity',
  'LNK_OPPORTUNITY_LIST' => 'Bekijk Opportunities',
  'LNK_OPPORTUNITY_REPORTS' => 'Opportunity Rapporten',
  'MSG_DUPLICATE' => 'Het opportunity record dat u nu wilt aanmaken zou een duplicaat kunnen zijn van een reeds bestaande opportunity. Opportunities die dezelfde namen hebben worden hieronder getoond.<br>Klik op Opslaan om door te gaan met het aanmaken van deze nieuwe opportunity, of klik op annuleren om terug te gaan naar de module zonder de opportunity aan te maken.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'U kunt geen Opportunities verwijderen die afgesloten opportunityregels bevatten',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Weet u zeker dat u deze persoon wilt verwijderen bij deze Opportunity?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Weet je zeker dat je deze Opportunity uit het project wilt verwijderen?',
  'TPL_RLI_CREATE' => 'Een opportunity moet een bijbehorende opportunityregel hebben.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Maak een Opportunityregel aan.',
  'UPDATE' => 'Opportunity - Valuta update',
  'UPDATE_BUGFOUND_COUNT' => 'Gevonden fouten:',
  'UPDATE_BUG_COUNT' => 'Fouten gevonden en geprobeerd op te lossen:',
  'UPDATE_COUNT' => 'Bijgewerkte records:',
  'UPDATE_CREATE_CURRENCY' => 'Nieuwe valuta aanmaken:',
  'UPDATE_DOLLARAMOUNTS' => 'Update U.S. Dollar bedragen',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Update de U.S. Dollar bedragen voor Opportunities gebaseerd op de huidige set van wisselkoersen. Deze waarde wordt gebruikt voor de berekening van grafieken en de weergave in de List View.',
  'UPDATE_DONE' => 'Gereed',
  'UPDATE_FAIL' => 'Kon niet bijwerken -',
  'UPDATE_FIX' => 'Herstel bedragen',
  'UPDATE_FIX_TXT' => 'Probeert ongeldige waarden te herstellen door hiervan een decimale waarde te maken. De originele waarden worden gebackup-ed in het database veld "amount_backup". Wanneer u deze functie gebruikt en u stuit op fouten, start de actie dan pas opnieuw nadat u de backup terug hebt gezet. Anders zal de backup overschreven kunnen worden met nieuwe ongeldige data.',
  'UPDATE_INCLUDE_CLOSE' => 'Inclusief gesloten records',
  'UPDATE_MERGE' => 'Valuta samenvoegen',
  'UPDATE_MERGE_TXT' => 'Voeg meerdere valuta samen tot een enkele valuta. Als er meerdere valuta records zijn voor dezelfde valuta, kunt u deze samenvoegen. Dit zal ook de valuta voor andere modules samenvoegen.',
  'UPDATE_NULL_VALUE' => 'Bedrag is NULL, bezig met instellen op 0 -',
  'UPDATE_RESTORE' => 'Bedragen terugzetten',
  'UPDATE_RESTORE_COUNT' => 'Records waarvan bedragen zijn teruggezet:',
  'UPDATE_RESTORE_TXT' => 'Zet bedragen terug uit de backup die is gemaakt gedurende het herstel.',
  'UPDATE_VERIFY' => 'Controleer bedragen',
  'UPDATE_VERIFY_CURAMOUNT' => 'Huidig bedrag:',
  'UPDATE_VERIFY_FAIL' => 'Controle van record mislukt:',
  'UPDATE_VERIFY_FIX' => 'Na herstel wordt dit',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nieuw bedrag:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nieuwe Valuta:',
  'UPDATE_VERIFY_TXT' => 'Controleert of de bedragen in Opportunities geldige numerieke waarden bevatten met slechts numerieke karakters (0-9) en decimalen (.).',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Één of meer van de geselecteerde gegevens bevat gesloten opportunityregels en kan daarom niet worden verwijderd.',
);

