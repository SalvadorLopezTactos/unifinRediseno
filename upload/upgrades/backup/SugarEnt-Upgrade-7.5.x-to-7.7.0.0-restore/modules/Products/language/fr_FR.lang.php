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
  'ERR_DELETE_RECORD' => 'Un numéro d&#39;enregistrement doit être spécifié pour toute suppression.',
  'LBL_ACCOUNT_ID' => 'Compte (ID)',
  'LBL_ACCOUNT_NAME' => 'Nom du Compte:',
  'LBL_ASSET_NUMBER' => 'Autre N°:',
  'LBL_ASSIGNED_TO_NAME' => 'Assigné à:',
  'LBL_ASSIGNED_USER_ID' => 'Assigné à (ID) ;',
  'LBL_ASSOCIATED_QUOTE' => 'Nom du devis :',
  'LBL_BOOK_VALUE' => 'Prix réservé:',
  'LBL_BOOK_VALUE_DATE' => 'Date de réservation:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Prix réservé (devise par défaut):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Montant calculé des lignes de devis',
  'LBL_CAMPAIGN_PRODUCT' => 'Campagne de la ligne de devis',
  'LBL_CATEGORY' => 'Catégorie',
  'LBL_CATEGORY_NAME' => 'Nom de la Catégorie:',
  'LBL_COMMIT_STAGE' => 'Etape de soumission',
  'LBL_COMMIT_STAGE_FORECAST' => 'Prévision',
  'LBL_CONTACT' => 'Contact',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contacts',
  'LBL_CONTACT_ID' => 'Ident. Contact',
  'LBL_CONTACT_NAME' => 'Nom du Contact:',
  'LBL_CONTRACTS' => 'Contracts',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Contrats',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Erreur :',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Une erreur est survenue lors de la conversion de cette ligne de devis en un devis',
  'LBL_COST_PRICE' => 'Prix de Revient:',
  'LBL_COST_USDOLLAR' => 'Prix de revient (devise par défaut)',
  'LBL_CREATED_USER' => 'Créé par',
  'LBL_CURRENCY' => 'Devise:',
  'LBL_CURRENCY_ID' => 'Devise (ID)',
  'LBL_CURRENCY_RATE' => 'Taux de change',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Symbole de la devise',
  'LBL_DATE_CLOSED' => 'Date de clôture',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Timestamp date clôture attendue',
  'LBL_DATE_PURCHASED' => 'Acheté:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'Expiration du Support:',
  'LBL_DATE_SUPPORT_STARTS' => 'Démarrage Support:',
  'LBL_DEAL_TOT' => 'Remise:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Lignes de devis',
  'LBL_DESCRIPTION' => 'Description:',
  'LBL_DISCOUNT_AMOUNT' => 'Montant Remise',
  'LBL_DISCOUNT_AS_PERCENT' => 'Remise en %',
  'LBL_DISCOUNT_PRICE' => 'Prix Unitaire:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Date promotion:',
  'LBL_DISCOUNT_RATE' => 'Taux de remise',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Taux de remise (devise par défaut)',
  'LBL_DISCOUNT_TOTAL' => 'Total Remise',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Remise (devise par défaut)',
  'LBL_DISCOUNT_USDOLLAR' => 'Prix unitaire (devise par défaut)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documents',
  'LBL_EDITLAYOUT' => 'Editer la mise en page',
  'LBL_EXPERT_ID' => 'Expert produit',
  'LBL_EXPORT_CURRENCY_ID' => 'Devise (ID)',
  'LBL_EXT_PRICE' => 'Prix Total',
  'LBL_FORECAST' => 'Inclus dans Prévision',
  'LBL_HELP_CREATE' => 'Le module {{module_name}} permet de gérer votre base installé c&#39;est à dire l&#39;ensemble des produits que vous avez vendu à vos clients.

Pour créer un enregistrement du module {{module_name}}, les étapes suivantes sont nécessaires :
1. Remplir les champs désirés.
 - Les champs identifiés comme "Obligatoire" doivent être remplis avant de sauvegarder.
 - Cliquer sur "Voir plus" pour afficher plus de champs de qualification.
2. Cliquer sur "Sauvegarder" pour finaliser l&#39;enregistrement et retourner sur la page précédente.
 - Cliquer sur "Sauvegarder et Afficher" Pour ouvrer la nouvelle {{module_name}}.
 - Cliquer sur "Sauvegarder et Créer" pour créer immédiatement un autre enregistrement du module {{module_name}}.',
  'LBL_HELP_RECORD' => 'Le module {{module_name}} permet de gérer votre base installé c&#39;est à dire l&#39;ensemble des produits que vous avez vendu à vos clients.

- Editer chaque champs en cliquant directement sur le champ concerné ou en cliquant sur le bouton Editer.
- Voir ou modifier les liaisons avec les autres enregistrements via les sous-pannels.
- Voir et participer aux commentaire et au flux d&#39;activité via le module {{activitystream_singular_module}} en cliquant sur le bouton "Flux d’activité".
- Suivre ou mettre en favoris l&#39;enregistrement en utilisant les icônes prévues à cet effet à droite du nom de l&#39;enregistrement.
- Des actions complémentaires sont disponibles dans la listes déroulantes des actions à droite du bouton Editer.',
  'LBL_HELP_RECORDS' => 'Le module {{module_name}} permet de gérer votre base installé c&#39;est à dire l&#39;ensemble des produits que vous avez vendu à vos clients.  La liste des produits vendables par votre société est disponible via Admin > Catalogue Produits et les administrateurs de votre applications peuvent gérer ce catalogue pour ajuster les informations produits lorsque cela est nécessaire. Lors de la création d&#39;un enregistrement dans le module {{plural_module_name}}, vous avez la possibilité de sélectionner un produit de référence disponible dans le Catalogue Produits ou bien de créer un nouveau produits directement depuis le module {{plural_module_name}}. Il y a plusieurs manière de créer des enregistrements au sein du module {{plural_module_name}} dans Sugar comme via le module {{plural_module_name}}, le module {{quotes_module}}, en dupliquant un produit existant, via l&#39;import dans le module {{plural_module_name}}, etc. Une fois l&#39;enregistrement créé dans le module {{module_name}}, vous pouvez afficher et modifier les informations directement via le module {{module_name}} en allant sur la vue Enregistrement du module {{plural_module_name}}.',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Origine principale',
  'LBL_LIST_ACCOUNT_NAME' => 'Nom Compte',
  'LBL_LIST_CONTACT_NAME' => 'Nom Contact',
  'LBL_LIST_COST_PRICE' => 'Prix de Revient',
  'LBL_LIST_DATE_PURCHASED' => 'Acheté le',
  'LBL_LIST_DISCOUNT_PRICE' => 'Prix remisé',
  'LBL_LIST_FORM_TITLE' => 'Lignes de devis',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'N° série Fabricant',
  'LBL_LIST_LIST_PRICE' => 'Listing',
  'LBL_LIST_MANUFACTURER' => 'Fabricant',
  'LBL_LIST_NAME' => 'Ligne de devis',
  'LBL_LIST_PRICE' => 'Prix Public:',
  'LBL_LIST_QUANTITY' => 'Quantité',
  'LBL_LIST_QUOTE_NAME' => 'Nom Devis',
  'LBL_LIST_STATUS' => 'Statut',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Expire le',
  'LBL_LIST_USDOLLAR' => 'Prix Public (devise par défaut)',
  'LBL_MANUFACTURER' => 'Fabricant:',
  'LBL_MANUFACTURERS' => 'Fabricants',
  'LBL_MANUFACTURER_NAME' => 'Nom fabricant',
  'LBL_MEMBER_OF' => 'Membre de:',
  'LBL_MFT_PART_NUM' => 'N° série Fabricant:',
  'LBL_MODIFIED_USER' => 'Modifié par',
  'LBL_MODULE_NAME' => 'Lignes de devis',
  'LBL_MODULE_NAME_SINGULAR' => 'Ligne de devis',
  'LBL_MODULE_TITLE' => 'Lignes de devis',
  'LBL_NAME' => 'Nom',
  'LBL_NEW_FORM_TITLE' => 'Créer Ligne de devis',
  'LBL_NEXT_STEP' => 'Prochaine étape:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notes',
  'LBL_OPPORTUNITY' => 'Affaire',
  'LBL_OPPORTUNITY_ID' => 'Affaire (ID)',
  'LBL_PRICING_FACTOR' => 'Coef pour le prix',
  'LBL_PRICING_FORMULA' => 'Formule de Pricing:',
  'LBL_PROBABILITY' => 'Probabilité (%)',
  'LBL_PRODUCT' => 'Ligne de devis :',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Ligne de devis',
  'LBL_PRODUCT_CATEGORIES' => 'Categories de Produit',
  'LBL_PRODUCT_TEMPLATE' => 'Modèle de produit :',
  'LBL_PRODUCT_TEMPLATE_ID' => 'ID Modèle Produit:',
  'LBL_PRODUCT_TYPES' => 'Types de Produit',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projets',
  'LBL_QUANTITY' => 'Quantité:',
  'LBL_QUOTE' => 'Devis',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Devis',
  'LBL_QUOTE_ID' => 'ID Devis',
  'LBL_QUOTE_NAME' => 'Nom Devis:',
  'LBL_RELATED_PRODUCTS' => 'Ligne de devis liée',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Lignes de devis',
  'LBL_REVENUELINEITEM' => 'Ligne de revenu',
  'LBL_REVENUELINEITEMS' => 'Lignes de revenu',
  'LBL_REVENUELINEITEM_ID' => 'Ligne de revenu (ID) :',
  'LBL_REVENUELINEITEM_NAME' => 'Nom de la ligne de revenu :',
  'LBL_SALES_STAGE' => 'Phase de vente',
  'LBL_SALES_STATUS' => 'Statu des lignes de revenu',
  'LBL_SEARCH_FORM_TITLE' => 'Rechercher une ligne de devis',
  'LBL_SELECT_DISCOUNT' => 'Remise en %',
  'LBL_SERIAL_NUMBER' => 'N° de série:',
  'LBL_STATUS' => 'Statut:',
  'LBL_SUPPORT_CONTACT' => 'Interlocuteur Support:',
  'LBL_SUPPORT_DESCRIPTION' => 'Desc Support:',
  'LBL_SUPPORT_NAME' => 'Titre du Support:',
  'LBL_SUPPORT_TERM' => 'Durée du Support:',
  'LBL_TAX_CLASS' => 'Classe de Taxe:',
  'LBL_TYPE' => 'Type:',
  'LBL_URL' => 'URL Produit:',
  'LBL_VENDOR_PART_NUM' => 'N° série Revendeur:',
  'LBL_WEBSITE' => 'Site Web',
  'LBL_WEIGHT' => 'Poids:',
  'LNK_IMPORT_PRODUCTS' => 'Import Lignes de devis',
  'LNK_NEW_PRODUCT' => 'Créer Ligne de devis',
  'LNK_PRODUCT_LIST' => 'Lignes de devis',
  'NTC_DELETE_CONFIRMATION' => 'Etes vous sûr de vouloir supprimer cet enregistrement ?',
  'NTC_REMOVE_CONFIRMATION' => 'Etes vous sûr de vouloir supprimer ce Produit ?',
);

