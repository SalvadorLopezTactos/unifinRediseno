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
  'ERR_DELETE_RECORD' => 'Un enregistrement doit être sélectionné pour toute suppression.',
  'LABEL_PANEL_ASSIGNMENT' => 'Assignation',
  'LBL_ACCOUNT_ID' => 'Compte (ID)',
  'LBL_ACCOUNT_NAME' => 'Compte:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activités à Réaliser',
  'LBL_ASSIGNED_TO_ID' => 'Assigné à (ID)',
  'LBL_ASSIGNED_TO_NAME' => 'Assigné à',
  'LBL_CAMPAIGN' => 'Campagne:',
  'LBL_CAMPAIGN_LINK' => 'Campagne',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Campagnes',
  'LBL_CLOSED_RLIS' => '# de lignes de revenu gagnées',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Affaires cloturées et gagnées',
  'LBL_COMMITTED' => 'Soumis',
  'LBL_COMMIT_STAGE' => 'Etape de soumission',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contacts',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Historique des emails des contacts liés',
  'LBL_CONTRACTS' => 'Contrats',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Contrats',
  'LBL_CREATED_ID' => 'Créé par (ID)',
  'LBL_CREATED_USER' => 'Créé par',
  'LBL_CURRENCIES' => 'Devises',
  'LBL_CURRENCY' => 'Devise:',
  'LBL_CURRENCY_ID' => 'Devise (ID)',
  'LBL_CURRENCY_NAME' => 'Devise',
  'LBL_CURRENCY_RATE' => 'Taux de change',
  'LBL_CURRENCY_SYMBOL' => 'Symbole de la devise',
  'LBL_DATE_CLOSED' => 'Date de Clôture:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Timestamp date clôture attendue',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Affaires',
  'LBL_DESCRIPTION' => 'Description:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documents',
  'LBL_DUPLICATE' => 'Possibilité de duplication des Affaires',
  'LBL_EDITLAYOUT' => 'Editer la mise en page',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Assigné à (ID)',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Assigné à',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Campagne (ID)',
  'LBL_EXPORT_CREATED_BY' => 'Créé par (ID)',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modifié par (ID)',
  'LBL_EXPORT_NAME' => 'Nom',
  'LBL_FILENAME' => 'Pièce jointe',
  'LBL_FORECAST' => 'Incluse dans Prévision',
  'LBL_HELP_CREATE' => 'Les enregistrements du module {{plural_module_name}} permettent de suivre les vente de façon individuelle et les différents postes liés à ces ventes, du début à la fin. Chaque enregistrement du module {{module_name}} représente une en-tête d&#39;un groupe de {{revenuelineitems_module}} et peut être relié à d&#39;autres enregistrements comme les {{quotes_module}}, {{contacts_module}}, etc

Pour créer un enregistrement du module {{module_name}}, les étapes suivantes sont nécessaires :
1. Remplir les champs désirés.
 - Les champs identifiés comme "Obligatoire" doivent être renseignés avant de sauvegarder.
 - Cliquer sur "Voir plus" pour afficher plus de champs de qualification.
2. Cliquer sur "Sauvegarder" pour finaliser la sauvegarde et retourner sur la page précédente.
 - Cliquer sur "Sauvegarder et Afficher" Pour ouvrir la nouvelle {{module_name}}.
 - Cliquer sur "Sauvegarder et Créer" pour créer immédiatement un autre enregistrement du module {{module_name}}.',
  'LBL_HELP_RECORD' => 'Les enregistrements du module {{plural_module_name}} permettent de suivre les vente de façon individuelle et les différents postes liés à ces ventes, du début à la fin. Chaque enregistrement du module {{module_name}} représente une en-tête d&#39;un groupe de {{revenuelineitems_module}} et peut être relié à d&#39;autres enregistrements comme les  {{quotes_module}}, {{contacts_module}}, etc

- Editer chaque champ en cliquant directement sur le champ concerné ou en cliquant sur le bouton Editer.
- Voir ou modifier les liaisons avec les autres enregistrements via les sous-panels.
- Voir et participer aux commentaires et au flux d&#39;activité via le module {{activitystream_singular_module}} en cliquant sur le bouton "Flux d’activité".
- Suivre ou mettre en favori l&#39;enregistrement en utilisant les icônes prévues à cet effet à droite du nom de l&#39;enregistrement.
- Des actions complémentaires sont disponibles dans la liste déroulante des actions, à droite du bouton Editer.',
  'LBL_HELP_RECORDS' => 'Les enregistrements du module {{plural_module_name}} permettent de suivre les vente de façon individuelle et les différents postes liés à ces ventes, du début à la fin. Chaque enregistrement du module {{module_name}} représente une en-tête d&#39;un groupe de {{revenuelineitems_module}} et peut être relié à d&#39;autres enregistrements comme les  {{quotes_module}}, {{contacts_module}}, etc. Chaque {{revenuelineitems_singular_module}} est une perspective de vente pour un produit particulier et qui inclut les données de vente associées. Le processus de vente lié à chaque {{revenuelineitems_singular_module}} va progresser au travers de sa phase de vente jusqu&#39;à ce que celle-ci soit "Gagnée" ou "Perdue". Les enregistrements du module {{module_name}} reflètent le montant et la date de clôture attendus pour ces {{revenuelineitems_module}}. Les {{plural_module_name}} et les {{revenuelineitems_module}} peuvent être mis à profit en utilisant le module {{forecasts_singular_module}} de Sugar afin d&#39;avoir une estimation des revenus futurs et de voir si ils sont en adéquation avec les objectifs.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historique et Activités terminées',
  'LBL_INVITEE' => 'Contacts',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Origine Principale:',
  'LBL_LIST_ACCOUNT_NAME' => 'Compte',
  'LBL_LIST_AMOUNT' => 'Réaliste',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Montant',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Assigné à',
  'LBL_LIST_DATE_CLOSED' => 'Clôture',
  'LBL_LIST_FORM_TITLE' => 'Liste des Affaires',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Affaires',
  'LBL_LIST_SALES_STAGE' => 'Phase de vente',
  'LBL_MKTO_ID' => 'ID du Lead dans Marketo',
  'LBL_MKTO_SYNC' => 'Synchronisé avec Marketo®',
  'LBL_MODIFIED_ID' => 'Modifié par (ID)',
  'LBL_MODIFIED_NAME' => 'Modifié par',
  'LBL_MODIFIED_USER' => 'Modifié par',
  'LBL_MODULE_NAME' => 'Affaires',
  'LBL_MODULE_NAME_SINGULAR' => 'Affaire',
  'LBL_MODULE_TITLE' => 'Affaires',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Mes Affaires clôturées',
  'LBL_NAME' => 'Nom Affaire',
  'LBL_NEW_FORM_TITLE' => 'Créer une Affaire',
  'LBL_NEXT_STEP' => 'Prochaine étape:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notes',
  'LBL_OPPORTUNITY' => 'Affaire:',
  'LBL_OPPORTUNITY_NAME' => 'Nom Affaire:',
  'LBL_OPPORTUNITY_ROLE' => 'Rôle pour cette Affaire',
  'LBL_OPPORTUNITY_TYPE' => 'Type',
  'LBL_PIPELINE_TOTAL_IS' => 'Montant du portefeuille',
  'LBL_PRIMARY_QUOTE_ID' => 'Devis principal',
  'LBL_PROBABILITY' => 'Probabilité (%):',
  'LBL_PRODUCTS' => 'Produits',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Lignes de devis',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projets',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projets',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Devis',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Devis',
  'LBL_RAW_AMOUNT' => 'Montant Brut',
  'LBL_RLI' => 'Lignes de revenu',
  'LBL_RLI_SUBPANEL_TITLE' => 'Lignes de revenu',
  'LBL_SALES_STAGE' => 'Phase de vente:',
  'LBL_SALES_STATUS' => 'Statut',
  'LBL_SEARCH_FORM_TITLE' => 'Rechercher une Affaire',
  'LBL_TEAM_ID' => 'Equipe (ID)',
  'LBL_TIMEPERIODS' => 'Périodes',
  'LBL_TIMEPERIOD_ID' => 'Période (ID)',
  'LBL_TOP_OPPORTUNITIES' => 'Top des Affaires',
  'LBL_TOTAL_OPPORTUNITIES' => 'Total des Affaires',
  'LBL_TOTAL_RLIS' => '# du total des lignes de revenu',
  'LBL_TYPE' => 'Type:',
  'LBL_VIEW_FORM_TITLE' => 'Vue Affaire',
  'LBL_WORKSHEET' => 'Feuille de travail',
  'LNK_CREATE' => 'Créer Affaire',
  'LNK_IMPORT_OPPORTUNITIES' => 'Import Affaires',
  'LNK_NEW_OPPORTUNITY' => 'Créer une Affaire',
  'LNK_OPPORTUNITY_LIST' => 'Affaires',
  'LNK_OPPORTUNITY_REPORTS' => 'Rapports sur les Affaires',
  'MSG_DUPLICATE' => 'Possibilité de doublon avec une Affaire existante. La liste ci-dessous reprend les Affaires similaires. Vous pouvez soit en sélectionner une dans la liste ci-dessous, soit cliquer sur "Sauvegarder" pour poursuivre la création, soit cliquer sur "Annuler".',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'Vous ne pouvez pas supprimer une Affaire qui contient des lignes de revenu terminées',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Etes-vous sûr de vouloir supprimer ce contact pour cette Affaire ?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => 'Etes-vous sûr de vouloir supprimer cette Affaire de ce Projet ?',
  'TPL_RLI_CREATE' => 'Une affaire doit avoir au minimum une ligne de revenu.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Créer une Ligne de revenu',
  'UPDATE' => 'Affaire - Devise mise à jour',
  'UPDATE_BUGFOUND_COUNT' => 'Bugs trouvés:',
  'UPDATE_BUG_COUNT' => 'Bugs trouvés, tentative de correction:',
  'UPDATE_COUNT' => 'Enregistrement mis à jour:',
  'UPDATE_CREATE_CURRENCY' => 'Créer une devise:',
  'UPDATE_DOLLARAMOUNTS' => 'Mise à jour des montants en devise par défaut',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Mise à jour des montants des Affaires basés sur le cours actuel des devises. Cette valeur est utilisée pour réaliser les montants en devises des graphiques et vues liste.',
  'UPDATE_DONE' => 'Terminé',
  'UPDATE_FAIL' => 'Impossible de mettre à jour -',
  'UPDATE_FIX' => 'Réparer les montants',
  'UPDATE_FIX_TXT' => 'Tentative de correction des montants invalides. Les anciens montants seront sauvegardés en base dans le champ amount_backup. Si vous constatez des dysfonctionnement ne l’exécuter pas une seconde fois car vous perdriez votre backup du champ.',
  'UPDATE_INCLUDE_CLOSE' => 'Inclure enregistrements clos',
  'UPDATE_MERGE' => 'Fusionner les devises',
  'UPDATE_MERGE_TXT' => 'Fusionner les devises. Si vous notez qu&#39;il y a plusieurs devises enregistrées pour la même devise, vous pouvez choisir de les fusionner. Cela va également fusionner les devises pour tous les autres modules.',
  'UPDATE_NULL_VALUE' => 'Le montant est NULL et remplacé par 0 -',
  'UPDATE_RESTORE' => 'Restaurer les montants',
  'UPDATE_RESTORE_COUNT' => 'Montants enregistrés restaurés:',
  'UPDATE_RESTORE_TXT' => 'Restaurer les montants depuis le backup créé lors de la réparation.',
  'UPDATE_VERIFY' => 'Vérifier les montants',
  'UPDATE_VERIFY_CURAMOUNT' => 'Montant actuel:',
  'UPDATE_VERIFY_FAIL' => 'Echec de Verification de cet enregistrement:',
  'UPDATE_VERIFY_FIX' => 'Lancer la réparation',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nouveau Montant:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nouvelle devise:',
  'UPDATE_VERIFY_TXT' => 'Vérifie que les montants des Affaires contiennent des valeurs numériques correctes (valeurs numériques (0-9) et séparateur (,.)',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Un ou plusieurs enregistrements sélectionnés contient des lignes de revenu terminées et ne peuvent donc pas être supprimés.',
);

