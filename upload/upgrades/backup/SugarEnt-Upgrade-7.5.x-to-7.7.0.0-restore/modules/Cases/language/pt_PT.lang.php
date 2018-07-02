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
  'ERR_DELETE_RECORD' => 'Um número de registo deve ser especificado para eliminar a entidade.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Entidades',
  'LBL_ACCOUNT_ID' => 'ID da Entidade',
  'LBL_ACCOUNT_NAME' => 'Nome da Entidade:',
  'LBL_ACCOUNT_NAME_MOD' => 'Nome da Entidade (Mod)',
  'LBL_ACCOUNT_NAME_OWNER' => 'Nome da Entidade (Owner)',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_ASSIGNED_TO_NAME' => 'Atribuído a',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Atribuído a (Name Mod)',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Atribuído a (Name Owner)',
  'LBL_ATTACH_NOTE' => 'Anexar Nota',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Bugs',
  'LBL_CASE' => 'Ocorrência:',
  'LBL_CASE_FROM_TWITTER_TITLE' => 'Tweet',
  'LBL_CASE_INFORMATION' => 'Informação da Ocorrência',
  'LBL_CASE_NUMBER' => 'Número da Ocorrência:',
  'LBL_CASE_SUBJECT' => 'Assunto da Ocorrência:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CONTACT_CASE_TITLE' => 'Contacto-Ocorrência:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Histórico de Contactos',
  'LBL_CONTACT_NAME' => 'Nome do Contacto:',
  'LBL_CONTACT_ROLE' => 'Função:',
  'LBL_CREATED_BY_NAME_MOD' => 'Criado por (Name Mod)',
  'LBL_CREATED_BY_NAME_OWNER' => 'Criado por (Name Owner)',
  'LBL_CREATED_USER' => 'Utilizador Criado',
  'LBL_CREATE_KB_DOCUMENT' => 'Criar Artigo',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Ocorrências',
  'LBL_DESCRIPTION' => 'Descrição:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Atribuído a',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Atribuído a',
  'LBL_EXPORT_CREATED_BY' => 'Criado Por',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Criado por',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificado por',
  'LBL_EXPORT_TEAM_COUNT' => 'Total de Equipas',
  'LBL_FILENANE_ATTACHMENT' => 'Anexar Ficheiro',
  'LBL_HELP_CREATE' => 'O módulo de {{plural_module_name}} é usado para seguir e gerir problemas relacionados com produtos ou serviços reportados pela sua organização ou clientes.



Para criar um {{module_name}}:
1. Fornecer valores para os campos como desejado.
- Campos marcados como "Obrigatórios" deverão ser preenchidos antes de gravar.
- Carregar "Mostrar mais" para mostrar campos adicionais se necessário.

2. Carregar em "Gravar" para finalizar o novo registo e retornar à página anterior.
- Escolher "Gravar e ver" para abrir o novo {{module_name}} na visualização do registo.
- Escolher "Gravar e criar novo" para criar imediatamente outro novo {{module_name}}.',
  'LBL_HELP_RECORD' => 'O módulo de {{plural_module_name}} é usado para seguir e gerir problemas relacionados com produtos ou serviços reportados pela sua organização ou clientes.

- Edite os campos deste registo carregando em um campo individualmente ou no botão Editar.
- Visualize ou modifique ligações para outros registos nos sub-paineis alterando o painel esquerdo do fundo para "Visaulização de Dados".
- Crie e visualize comentários de utilizador e grande alterações do histórico no {{activitystream_singular_module}}  alterando o painel esquerdo do fundo para "Fluxo de Actividade".
- Siga ou torne favorito este registo utilizando os ícones à direita do nome do registo.
- Acções adicionais estão disponíveis no menu de selecção Acções à direita do botão Editar.',
  'LBL_HELP_RECORDS' => 'O módulo de {{plural_module_name}} é usado para seguir e gerir problemas relacionados com produtos ou serviços reportados pela sua organização ou clientes. {{plural_module_name}} são tipicamente relacionados com um registo de uma {{accounts_singular_module}} e múltiplos {{plural_module_name}} poderão estar associados a um único {{accounts_singular_module}}. 
Existem várias maneiras parar criar {{plural_module_name}} no Sugar, como por exemplo via o módulo de {{plural_module_name}}, importando {{plural_module_name}} ou convertendo-as a partir de um e-mail. Uma vez que o {{module_name}} é criado, poderá ver e editar a informação pertencente ao {{module_name}} via a visualização do registo do {{module_name}}. Cada registo de {{module_name}} poderá estar relacionado com outro registo no Sugar, como por exemplo: {{calls_module}}, {{contacts_module}}, {{bugs_module}}, e muitos outros.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Histórico',
  'LBL_INVITEE' => 'Contactos',
  'LBL_KBDOCUMENTS_SUBPANEL_TITLE' => 'Base de Conhecimento',
  'LBL_LIST_ACCOUNT_NAME' => 'Nome da Entidade',
  'LBL_LIST_ASSIGNED' => 'Atribuído a',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Utilizador',
  'LBL_LIST_CLOSE' => 'Fechar',
  'LBL_LIST_DATE_CREATED' => 'Data de Criação',
  'LBL_LIST_FORM_TITLE' => 'Lista de Ocorrências',
  'LBL_LIST_LAST_MODIFIED' => 'Última Alteração',
  'LBL_LIST_MY_CASES' => 'As Minhas Ocorrências Abertas',
  'LBL_LIST_NUMBER' => 'Núm.',
  'LBL_LIST_PRIORITY' => 'Prioridade',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUBJECT' => 'Assunto',
  'LBL_MEMBER_OF' => 'Entidade',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Modificado por (Name Mod)',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Modificado por (Name Owner)',
  'LBL_MODIFIED_USER' => 'Utilizador Modificado',
  'LBL_MODIFIED_USER_NAME' => 'Modificado por',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Modificado por (Mod)',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Modificado por (Owner)',
  'LBL_MODULE_NAME' => 'Ocorrências',
  'LBL_MODULE_NAME_SINGULAR' => 'Ocorrência',
  'LBL_MODULE_TITLE' => 'Ocorrências: Ecrã Principal',
  'LBL_NEW_FORM_TITLE' => 'Nova Ocorrência',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_NUMBER' => 'Número:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Se tem um novo Caso de suporte que gostaria de enviar, poderá carregar aqui para enviar o novo Caso.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Poderá filtrar a lista de Casos fornecendo um termo de pesquisa.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Por exemplo, poderá usar isto para encontrar um pedido que tenha sido enviado anteriormente.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'O módulo de Casos é para gerir os pedidos de suporte que afectam a sua Conta. Use as setas abaixo para seguir numa pequena tour.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Esta página mostra a lista de Casos existentes associados com a sua Conta.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Carregar aqui irá retorna-lo a esta visualização em qualquer altura.',
  'LBL_PORTAL_VIEWABLE' => 'Visível no Portal',
  'LBL_PRIORITY' => 'Prioridade:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projectos',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projectos',
  'LBL_RESOLUTION' => 'Resolução:',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar Ocorrências',
  'LBL_SHOW_IN_PORTAL' => 'Mostrar no Portal',
  'LBL_SHOW_MORE' => 'Mostrar Mais Ocorrências',
  'LBL_SOURCE' => 'Origem:',
  'LBL_STATUS' => 'Situação:',
  'LBL_SUBJECT' => 'Assunto:',
  'LBL_SYSTEM_ID' => 'ID do Sistema',
  'LBL_TEAM_COUNT_MOD' => 'Total de Equipas (Mod)',
  'LBL_TEAM_COUNT_OWNER' => 'Total de Equipas (Owner)',
  'LBL_TEAM_NAME_MOD' => 'Nome da Equipa (Mod)',
  'LBL_TEAM_NAME_OWNER' => 'Nome da Equipa (Owner)',
  'LBL_TYPE' => 'Tipo',
  'LBL_WORK_LOG' => 'Registo de Trabalho',
  'LNK_CASE_LIST' => 'Ocorrências',
  'LNK_CASE_REPORTS' => 'Relatórios de Ocorrências',
  'LNK_CREATE' => 'Criar Ocorrência',
  'LNK_CREATE_WHEN_EMPTY' => 'Criar um caso agora.',
  'LNK_IMPORT_CASES' => 'Importar Ocorrências',
  'LNK_NEW_CASE' => 'Nova Ocorrência',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => 'Tem certeza que quer remover esta ocorrência a partir deste bug?',
  'NTC_REMOVE_INVITEE' => 'Tem certeza que quer remover este contacto da ocorrência?',
);

