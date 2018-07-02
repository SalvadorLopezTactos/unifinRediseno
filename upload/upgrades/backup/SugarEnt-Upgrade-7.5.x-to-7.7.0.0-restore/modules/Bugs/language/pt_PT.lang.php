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
  'ERR_DELETE_RECORD' => 'Um número de registo necessita ser especificado para eliminar um Bug.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Entidades',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_ASSIGNED_TO_NAME' => 'Atribuído a',
  'LBL_BUG' => 'Bug:',
  'LBL_BUG_INFORMATION' => 'Informação do Bug',
  'LBL_BUG_NUMBER' => 'Número do Bug:',
  'LBL_BUG_SUBJECT' => 'Assunto do Bug:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Ocorrências',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CONTACT_BUG_TITLE' => 'Contacto-Bug:',
  'LBL_CONTACT_NAME' => 'Nome do Contacto:',
  'LBL_CONTACT_ROLE' => 'Função:',
  'LBL_CREATED_BY' => 'Criado por:',
  'LBL_DATE_CREATED' => 'Data de criação:',
  'LBL_DATE_LAST_MODIFIED' => 'Data de modificação:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Bug Tracker',
  'LBL_DESCRIPTION' => 'Descrição:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID de Utilizador Atribuído',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Nome de Utilizador Atribuído',
  'LBL_EXPORT_CREATED_BY' => 'ID do Utilizador que Criou',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Corrigido na Release com o Nome',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'ID do Utilizador que Modificou',
  'LBL_FIXED_IN_RELEASE' => 'Corrigido na versão:',
  'LBL_FOUND_IN_RELEASE' => 'Encontrado na versão:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Encontrado na Release com o Nome',
  'LBL_HELP_CREATE' => 'O módulo de {{plural_module_name}} é usado para seguir e gerir problemas relacionado com o produto, geralmente descritos como {{plural_module_name}} ou defeitos, encontrados internamente ou reportados por clientes.

Para criar um {{module_name}}:
1. Fornecer valores para os campos como desejado.
- Campos marcados como "Obrigatórios" deverão ser preenchidos antes de gravar.
- Carregar "Mostrar mais" para mostrar campos adicionais se necessário.
2. Carregar em "Gravar" para finalizar o novo registo e retornar à página anterior.
- Escolher "Gravar e ver" para abrir o novo {{module_name}} na visualização do registo.
- Escolher "Gravar e criar novo" para criar imediatamente outro novo {{module_name}}.',
  'LBL_HELP_RECORD' => 'O módulo de {{plural_module_name}} é usado para seguir e gerir problemas relacionados com o produto, geralmente referidos como {{plural_module_name}} ou defeitos, encontrados internamente ou reportados por clientes.

Edite os campos deste registo carregando em um campo individualmente ou no botão Editar.
- Visualize ou modifique ligações para outros registos nos sub-paineis alterando o painel esquerdo do fundo para "Visaulização de Dados".
- Crie e visualize comentários de utilizador e grande alterações do histórico no {{activitystream_singular_module}}  alterando o painel esquerdo do fundo para "Fluxo de Actividade".
- Siga ou torne favorito este registo utilizando os ícones à direita do nome do registo.
- Acções adicionais estão disponíveis no menu de selecção Acções à direita do botão Editar.',
  'LBL_HELP_RECORDS' => 'O módulo de {{plural_module_name}} é usado para seguir e gerir problemas relacionados com o produto, geralmente referidos como {{plural_module_name}} ou defeitos, encontrados internamente ou reportados por clientes. O tratamento de {{plural_module_name}} pode ser melhorado seguindo os que foram encontrados e corrigidos na ultima versão. O módulo de {{plural_module_name}} dá aos utilizadores uma maneira rápida de rever todos os detalhes do {{module_name}} e do processo usado para o corrigir. Uma vez que um {{module_name}} é criado ou submetido, poderá visualizar e editar a informação pertencente ao {{module_name}} via a visualização de registos de {{plural_module_name}}. Cada registo de {{module_name}} poderá estar relacionado com outros registos do Sugar, como {{calls_module}}, {{contacts_module}}, {{cases_module}} e muitos outros.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Histórico',
  'LBL_INVITEE' => 'Contactos',
  'LBL_LIST_ACCOUNT_NAME' => 'Nome da Entidade',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Utilizador',
  'LBL_LIST_CONTACT_NAME' => 'Nome do Contacto',
  'LBL_LIST_EMAIL_ADDRESS' => 'Endereço de e-mail',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Corrigido na versão',
  'LBL_LIST_FORM_TITLE' => 'Listar Bugs',
  'LBL_LIST_LAST_MODIFIED' => 'Última modificação',
  'LBL_LIST_MY_BUGS' => 'Os Meus Bugs',
  'LBL_LIST_NUMBER' => 'Núm.',
  'LBL_LIST_PHONE' => 'Telefone',
  'LBL_LIST_PRIORITY' => 'Prioridade',
  'LBL_LIST_RELEASE' => 'Versão',
  'LBL_LIST_RESOLUTION' => 'Resolução',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUBJECT' => 'Assunto',
  'LBL_LIST_TYPE' => 'Tipo',
  'LBL_MODIFIED_BY' => 'Modificado por:',
  'LBL_MODULE_ID' => 'Bugs',
  'LBL_MODULE_NAME' => 'Bug Tracker',
  'LBL_MODULE_NAME_SINGULAR' => 'Bug',
  'LBL_MODULE_TITLE' => 'Bug Tracker: Ecrã Principal',
  'LBL_NEW_FORM_TITLE' => 'Criar Bug',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_NUMBER' => 'Número:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Se encontrou um novo Bug que gostaria de reportar, poderá carregar aqui para reportar um novo Bug.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Poderá filtrar a lista de Bugs fornecendo um termo de pesquisa.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Por exemplo, poderá usar isto para encontrar um bug que tenha sido reportado previamente.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'O módulo de Bugs serve para visualizar e reportar bugs. Use as setas abaixo para seguir numa pequena tour.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Esta página mostra a lista de Bugs existente e publicados.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Carregar aqui irá retorna-lo a esta visualização em qualquer altura.',
  'LBL_PORTAL_VIEWABLE' => 'Visível no Portal',
  'LBL_PRIORITY' => 'Prioridade:',
  'LBL_PRODUCT_CATEGORY' => 'Categoria:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projectos',
  'LBL_RELEASE' => 'Versão:',
  'LBL_RESOLUTION' => 'Resolução:',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar Bugs',
  'LBL_SHOW_IN_PORTAL' => 'Mostrar no Portal',
  'LBL_SHOW_MORE' => 'Mostrar Mais',
  'LBL_SOURCE' => 'Origem:',
  'LBL_STATUS' => 'Estado:',
  'LBL_SUBJECT' => 'Assunto:',
  'LBL_SYSTEM_ID' => 'ID do Sistema',
  'LBL_TYPE' => 'Tipo:',
  'LBL_WORK_LOG' => 'Log de trabalho:',
  'LNK_BUG_LIST' => 'Bugs',
  'LNK_BUG_REPORTS' => 'Relatórios de Bug',
  'LNK_CREATE' => 'Reportar Bug',
  'LNK_CREATE_WHEN_EMPTY' => 'Reportar um Bug agora.',
  'LNK_IMPORT_BUGS' => 'Importar Bugs',
  'LNK_NEW_BUG' => 'Reportar Bug',
  'NTC_DELETE_CONFIRMATION' => 'Tem a certeza de que pretende eliminar este Contacto deste Bug?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Tem a certeza de que pretende eliminar este Bug desta entidade?',
  'NTC_REMOVE_INVITEE' => 'Tem a certeza de que pretende eliminar este contacto deste Bug?',
);

