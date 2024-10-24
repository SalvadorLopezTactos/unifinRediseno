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
    'LBL_KBCONTENTS_LIST_DASHBOARD' => 'Tableau de bord de la liste de bases de connaissances',
    'LBL_KBCONTENTS_RECORD_DASHBOARD' => 'Tableau de bord d&#39;enregistrements de bases de connaissances',
    'LBL_KBCONTENTS_FOCUS_DRAWER_DASHBOARD' => 'Tiroir de rangement Knowledge Base',
    'TPL_ACTIVITY_TIMELINE_DASHLET' => 'Chronologie de la base de connaissances',

    'LBL_MODULE_NAME' => 'Base de connaissances',
    'LBL_MODULE_NAME_SINGULAR' => 'Base de Connaissances - Article',
    'LBL_MODULE_TITLE' => 'Base de Connaissances - Article',
    'LNK_NEW_ARTICLE' => 'Créer un article',
    'LNK_LIST_ARTICLES' => 'Afficher les articles',
    'LNK_KNOWLEDGE_BASE_ADMIN_MENU' => 'Paramètres',
    'LBL_EDIT_LANGUAGES' => 'Modifier les langues',
    'LBL_ADMIN_LABEL_LANGUAGES' => 'Langues disponibles',
    'LBL_CONFIG_LANGUAGES_TITLE' => 'Langues disponibles',
    'LBL_CONFIG_LANGUAGES_TEXT' => 'Configurez les langues qui seront utilisées dans le module de Base des connaissances.',
    'LBL_CONFIG_LANGUAGES_LABEL_KEY' => 'Code langue',
    'LBL_CONFIG_LANGUAGES_LABEL_NAME' => 'Libellé langue',
    'ERR_CONFIG_LANGUAGES_DUPLICATE' => 'Il n&#39;est pas permis d&#39;ajouter la langue avec la clé qui fait double emploi avec celle existante.',
    'ERR_CONFIG_LANGUAGES_EMPTY_KEY' => 'The Language Code field is empty, please enter values before saving.',
    'ERR_CONFIG_LANGUAGES_EMPTY_VALUE' => 'The Language Label field is empty, please enter values before saving.',
    'LBL_SET_ITEM_PRIMARY' => 'Définir valeur comme valeur principale',
    'LBL_ITEM_REMOVE' => 'Supprimer l&#39;élément',
    'LBL_ITEM_ADD' => 'Ajouter l&#39;élément',
    'LBL_MODULE_ID' => 'KBContents',
    'LBL_DOCUMENT_REVISION_ID' => 'ID de révision',
    'LBL_DOCUMENT_REVISION' => 'Révision',
    'LBL_NUMBER' => 'Identifiant',
    'LBL_TEXT_BODY' => 'Corps',
    'LBL_LANG' => 'Langue',
    'LBL_PUBLISH_DATE' => 'Date de mise à disposition',
    'LBL_EXP_DATE' => 'Date expiration',
    'LBL_DOC_ID' => 'Ref Document',
    'LBL_APPROVED' => 'Approuvé',
    'LBL_REVISION' => 'Révision',
    'LBL_ACTIVE_REV' => 'Révision active',
    'LBL_IS_EXTERNAL' => 'Article externe',
    'LBL_KBDOCUMENT_ID' => 'ID document Base de connaissances',
    'LBL_KBDOCUMENTS' => 'Documents de la base de connaissance',
    'LBL_KBDOCUMENT' => 'Document base de connaissances',
    'LBL_KBARTICLE' => 'Article',
    'LBL_KBARTICLES' => 'Articles',
    'LBL_KBARTICLE_ID' => 'Id article',
    'LBL_USEFUL' => 'Utile',
    'LBL_NOT_USEFUL' => 'Pas utile',
    'LBL_RATING' => 'Évaluation',
    'LBL_VIEWED_COUNT' => 'Nombre de vues',
    'LBL_CATEGORIES' => 'Catégories de la Base de connaissances',
    'LBL_CATEGORY_NAME' => 'Catégorie',
    'LBL_USEFULNESS' => 'Utilité',
    'LBL_CATEGORY_ID' => 'Id catégorie',
    'LBL_KBSAPPROVERS' => 'Approbateurs',
    'LBL_KBSAPPROVER_ID' => 'Approuvé par',
    'LBL_KBSAPPROVER' => 'Approuvé par',
    'LBL_KBSCASES' => 'Tickets',
    'LBL_KBSCASE_ID' => 'Ticket lié',
    'LBL_KBSCASE' => 'Ticket lié',
    'LBL_MORE_MOST_USEFUL_ARTICLES' => 'Davantage d&#39;articles publiés de la base de connaissances très utiles...',
    'LBL_KBSLOCALIZATIONS' => 'Traductions',
    'LBL_LOCALIZATIONS_SUBPANEL_TITLE' => 'Traductions',
    'LBL_KBSREVISIONS' => 'Révisions',
    'LBL_REVISIONS_SUBPANEL_TITLE' => 'Révisions',
    'LBL_LISTVIEW_FILTER_ALL' => 'Tous les articles',
    'LBL_LISTVIEW_FILTER_MY' => 'Mes articles',
    'LBL_CREATE_LOCALIZATION_BUTTON_LABEL' => 'Créer traduction',
    'LBL_CREATE_REVISION_BUTTON_LABEL' => 'Créer révision',
    'LBL_CANNOT_CREATE_LOCALIZATION' =>
        'Impossible de créer une nouvelle traduction, car il existe une version de traduction pour toutes les langues disponibles.',
    'LBL_SPECIFY_PUBLISH_DATE' => 'Schedule this article to be published by specifying the Publish Date. Do you wish to continue without updating a Publish Date?',
    'LBL_MODIFY_EXP_DATE_LOW' => 'La date d&#39;expiration est antérieure à celle de publication. Souhaitez-vous continuer sans la modifier ?',
    'LBL_PANEL_INMORELESS' => 'Utilité',
    'LBL_MORE_OTHER_LANGUAGES' => 'Davantage de langues...',
    'EXCEPTION_VOTE_USEFULNESS_NOT_AUTHORIZED' => 'Vous n&#39;êtes pas autorisé à voter {moduleName} utile/non utile. Si vous devez accéder, contactez votre administrateur.',
    'LNK_NEW_KBCONTENT_TEMPLATE' => 'Creer modèle',
    'LNK_LIST_KBCONTENT_TEMPLATES' => 'Afficher modèles',
    'LNK_LIST_KBCATEGORIES' => 'Afficher les catégories',
    'LBL_TEMPLATES' => 'Modèles',
    'LBL_TEMPLATE' => 'Modèle',
    'LBL_TEMPATE_LOAD_MESSAGE' => 'Le modèle va écraser tout les contenus.' .
        ' Êtes-vous certain de vouloir utiliser ce modèle ?',
    'LNK_IMPORT_KBCONTENTS' => 'Importer des articles',
    'LBL_DELETE_CONFIRMATION_LANGUAGE' => 'Tous les documents dans cette langue seront supprimés ! Êtes-vous sûr de vouloir supprimer cette langue ?',
    'LBL_CREATE_CATEGORY_PLACEHOLDER' => 'Appuyez sur Entrée pour créer ou Esc pour annuler',
    'LBL_KB_NOTIFICATION' => 'Le document a été publié.',
    'LBL_KB_PUBLISHED_REQUEST' => 'vous a assigné un document pour approbation et publication.',
    'LBL_KB_STATUS_BACK_TO_DRAFT' => 'Le statut du document a été modifié à nouveau en "brouillon".',
    'LBL_OPERATOR_CONTAINING_THESE_WORDS' => 'contenant ces mots',
    'LBL_OPERATOR_EXCLUDING_THESE_WORDS' => 'à l&#39;exclusion de ces mots',
    'ERROR_EXP_DATE_LOW' => 'La date d’expiration ne peut pas être antérieure à la date de la publication.',
    'ERROR_ACTIVE_DATE_APPROVE_REQUIRED' => 'Le statut Approuvé nécessite une date de publication.',
    'ERROR_ACTIVE_DATE_LOW' => 'The Publish Date must occur on a later date than today&#39;s date.',
    'ERROR_ACTIVE_DATE_EMPTY' => 'La date de publication est vide.',
    'LBL_RECORD_SAVED_SUCCESS' => 'Vous avez créé l&#39;enregistrement <a href="#{{buildRoute model=this}}">{{name}}</a> pour le module {{moduleSingularLower}}.', // use when a model is available
    'ERROR_IS_BEFORE' => 'Erreur. La date de ce champ ne peut être ultérieure à la date du champ {{this}}.',
    'TPL_SHOW_MORE_MODULE' => 'Plus d&#39;articles {{module}}...',
    'LBL_LIST_FORM_TITLE' => 'Liste de la base de connaissances',
    'LBL_SEARCH_FORM_TITLE' => 'Recherche dans la base de connaissances',
];
