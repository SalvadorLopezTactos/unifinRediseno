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
    'LBL_KBCONTENTS_LIST_DASHBOARD' => 'Dashboard da Lista da Base de Conhecimento',
    'LBL_KBCONTENTS_RECORD_DASHBOARD' => 'Dashboard do Registo da Base de Conhecimento',
    'LBL_KBCONTENTS_FOCUS_DRAWER_DASHBOARD' => 'Gaveta de foco na base de conhecimento',
    'TPL_ACTIVITY_TIMELINE_DASHLET' => 'Timeline da Base de Conhecimento',

    'LBL_MODULE_NAME' => 'Base de Conhecimento',
    'LBL_MODULE_NAME_SINGULAR' => 'Artigo da Base de Conhecimento',
    'LBL_MODULE_TITLE' => 'Artigo da Base de Conhecimento',
    'LNK_NEW_ARTICLE' => 'Criar Artigo',
    'LNK_LIST_ARTICLES' => 'Ver Artigos',
    'LNK_KNOWLEDGE_BASE_ADMIN_MENU' => 'Definições',
    'LBL_EDIT_LANGUAGES' => 'Editar idiomas',
    'LBL_ADMIN_LABEL_LANGUAGES' => 'Idiomas disponíveis',
    'LBL_CONFIG_LANGUAGES_TITLE' => 'Idiomas disponíveis',
    'LBL_CONFIG_LANGUAGES_TEXT' => 'Conﬁgure idiomas que vão ser usados no módulo Base de Conhecimento.',
    'LBL_CONFIG_LANGUAGES_LABEL_KEY' => 'Código de idioma',
    'LBL_CONFIG_LANGUAGES_LABEL_NAME' => 'Rótulo de idioma',
    'ERR_CONFIG_LANGUAGES_DUPLICATE' => 'Não é permitido adicionar idioma com a chave que duplica a existente.',
    'ERR_CONFIG_LANGUAGES_EMPTY_KEY' => 'The Language Code field is empty, please enter values before saving.',
    'ERR_CONFIG_LANGUAGES_EMPTY_VALUE' => 'The Language Label field is empty, please enter values before saving.',
    'LBL_SET_ITEM_PRIMARY' => 'Definir Valor como Principal',
    'LBL_ITEM_REMOVE' => 'Remover iItem',
    'LBL_ITEM_ADD' => 'Adicionar item',
    'LBL_MODULE_ID' => 'KBContents',
    'LBL_DOCUMENT_REVISION_ID' => 'ID de revisão',
    'LBL_DOCUMENT_REVISION' => 'Revisão',
    'LBL_NUMBER' => 'Número',
    'LBL_TEXT_BODY' => 'Corpo',
    'LBL_LANG' => 'Idioma',
    'LBL_PUBLISH_DATE' => 'Data de Publicação',
    'LBL_EXP_DATE' => 'Data de Expiração',
    'LBL_DOC_ID' => 'ID do Documento',
    'LBL_APPROVED' => 'Aprovado',
    'LBL_REVISION' => 'Revisão',
    'LBL_ACTIVE_REV' => 'Revisão ativa',
    'LBL_IS_EXTERNAL' => 'Artigo externo',
    'LBL_KBDOCUMENT_ID' => 'ID de Documento de KB',
    'LBL_KBDOCUMENTS' => 'Documentos de KB',
    'LBL_KBDOCUMENT' => 'Documentos de KB',
    'LBL_KBARTICLE' => 'Artigo',
    'LBL_KBARTICLES' => 'Artigos',
    'LBL_KBARTICLE_ID' => 'Id do artigo',
    'LBL_USEFUL' => 'Útil',
    'LBL_NOT_USEFUL' => 'Não foi útil',
    'LBL_RATING' => 'Classificação',
    'LBL_VIEWED_COUNT' => 'Ver Contagem',
    'LBL_CATEGORIES' => 'Categorias da Base de Conhecimento',
    'LBL_CATEGORY_NAME' => 'Categoria',
    'LBL_USEFULNESS' => 'Utilidade',
    'LBL_CATEGORY_ID' => 'Id da categoria',
    'LBL_KBSAPPROVERS' => 'Aprovadores',
    'LBL_KBSAPPROVER_ID' => 'Aprovado por',
    'LBL_KBSAPPROVER' => 'Aprovado por',
    'LBL_KBSCASES' => 'Ocorrências',
    'LBL_KBSCASE_ID' => 'Ocorrência Relacionada',
    'LBL_KBSCASE' => 'Ocorrência Relacionada',
    'LBL_MORE_MOST_USEFUL_ARTICLES' => 'Os artigos publicados mais úteis da base de conhecimento...',
    'LBL_KBSLOCALIZATIONS' => 'Localizações',
    'LBL_LOCALIZATIONS_SUBPANEL_TITLE' => 'Localizações',
    'LBL_KBSREVISIONS' => 'Revisões',
    'LBL_REVISIONS_SUBPANEL_TITLE' => 'Revisões',
    'LBL_LISTVIEW_FILTER_ALL' => 'Todos os artigos',
    'LBL_LISTVIEW_FILTER_MY' => 'Os meus artigos',
    'LBL_CREATE_LOCALIZATION_BUTTON_LABEL' => 'Criar localização',
    'LBL_CREATE_REVISION_BUTTON_LABEL' => 'Criar revisão',
    'LBL_CANNOT_CREATE_LOCALIZATION' =>
        'Não é possível criar uma nova localização, uma vez que existe uma versão de localização para todos os idiomas disponíveis.',
    'LBL_SPECIFY_PUBLISH_DATE' => 'Schedule this article to be published by specifying the Publish Date. Do you wish to continue without updating a Publish Date?',
    'LBL_MODIFY_EXP_DATE_LOW' => 'A Data de Expiração ocorre numa data anterior à Data de Publicação. Pretende continuar sem modificar a Data de Expiração?',
    'LBL_PANEL_INMORELESS' => 'Utilidade',
    'LBL_MORE_OTHER_LANGUAGES' => 'Mais Idiomas...',
    'EXCEPTION_VOTE_USEFULNESS_NOT_AUTHORIZED' => 'Não tem autorização para classificar {moduleName} como útil/não útil. Contacte o seu administrador caso precise de acesso.',
    'LNK_NEW_KBCONTENT_TEMPLATE' => 'Criar modelo',
    'LNK_LIST_KBCONTENT_TEMPLATES' => 'Ver modelos',
    'LNK_LIST_KBCATEGORIES' => 'Ver Categorias',
    'LBL_TEMPLATES' => 'Modelos',
    'LBL_TEMPLATE' => 'Modelo',
    'LBL_TEMPATE_LOAD_MESSAGE' => 'O modelo vai substituir todos os conteúdos.' .
        ' Tem a certeza de que pretende utilizar este modelo?',
    'LNK_IMPORT_KBCONTENTS' => 'Importar artigos',
    'LBL_DELETE_CONFIRMATION_LANGUAGE' => 'Todos os documentos neste idioma serão eliminados! Tem a certeza de que pretende eliminar este idioma?',
    'LBL_CREATE_CATEGORY_PLACEHOLDER' => 'Prima Enter para criar ou Esc para cancelar',
    'LBL_KB_NOTIFICATION' => 'O documento foi publicado.',
    'LBL_KB_PUBLISHED_REQUEST' => 'atribuiu-lhe um Documento para aprovação e publicação.',
    'LBL_KB_STATUS_BACK_TO_DRAFT' => 'O estado do documento foi alterado para o estado anterior de rascunho.',
    'LBL_OPERATOR_CONTAINING_THESE_WORDS' => 'contém estas palavras',
    'LBL_OPERATOR_EXCLUDING_THESE_WORDS' => 'excluindo estas palavras',
    'ERROR_EXP_DATE_LOW' => 'A data de validade não pode ser anterior à data de publicação.',
    'ERROR_ACTIVE_DATE_APPROVE_REQUIRED' => 'O estado Aprovado necessita de data de publicação.',
    'ERROR_ACTIVE_DATE_LOW' => 'The Publish Date must occur on a later date than today&#39;s date.',
    'ERROR_ACTIVE_DATE_EMPTY' => 'A Data de Publicação está vazia.',
    'LBL_RECORD_SAVED_SUCCESS' => 'Criou com êxito o {{moduleSingularLower}} <a href="#{{buildRoute model=this}}">{{name}}</a>.', // use when a model is available
    'ERROR_IS_BEFORE' => 'Erro. A data deste campo deve ser posterior à data do campo {{this}}.',
    'TPL_SHOW_MORE_MODULE' => 'Mais {{module}} artigos...',
    'LBL_LIST_FORM_TITLE' => 'Lista da Base de Conhecimento',
    'LBL_SEARCH_FORM_TITLE' => 'Pesquisa da Base de Conhecimento',
];
