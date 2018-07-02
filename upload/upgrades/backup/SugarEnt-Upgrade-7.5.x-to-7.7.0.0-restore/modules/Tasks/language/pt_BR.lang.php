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
  'DATE_FORMAT' => '(aaaa-mm-dd)',
  'ERR_DELETE_RECORD' => 'Um número de registro deverá ser especificado para eliminar este contato.',
  'ERR_INVALID_HOUR' => 'Por favor indique uma hora entre as 00:00 e as 24:00',
  'LBL_ACTIVITIES_REPORTS' => 'Relatório de Atividades',
  'LBL_ASSIGNED_TO_NAME' => 'Atribuído a:',
  'LBL_ASSIGNED_USER' => 'Atribuído a:',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Contato:',
  'LBL_CONTACT_FIRST_NAME' => 'Primeiro Nome do Contato',
  'LBL_CONTACT_ID' => 'ID Contato:',
  'LBL_CONTACT_LAST_NAME' => 'Último Nome do Contato',
  'LBL_CONTACT_NAME' => 'Nome do Contato:',
  'LBL_CONTACT_PHONE' => 'Telefone de Contato:',
  'LBL_DATE_DUE' => 'Data Limite',
  'LBL_DATE_DUE_FLAG' => 'Sem Data Limite',
  'LBL_DATE_START_FLAG' => 'Sem Data de Início',
  'LBL_DEFAULT_PRIORITY' => 'Médio',
  'LBL_DESCRIPTION' => 'Descrição',
  'LBL_DESCRIPTION_INFORMATION' => 'Descrição',
  'LBL_DUE_DATE' => 'Data Limite:',
  'LBL_DUE_DATE_AND_TIME' => 'Data e Hora Limites:',
  'LBL_DUE_TIME' => 'Hora Limite:',
  'LBL_EDITLAYOUT' => 'Editar Layout',
  'LBL_EMAIL' => 'E-mail:',
  'LBL_EMAIL_ADDRESS' => 'Endereço de E-mail',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID usuário Atribuído',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'nome de usuário atribuído',
  'LBL_EXPORT_CREATED_BY' => 'Criado pelo ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificado Por ID',
  'LBL_EXPORT_PARENT_ID' => 'Relacionado ao ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Relacionado ao Módulo',
  'LBL_HELP_CREATE' => 'O {{}} plural_module_name módulo é composto por itens de linha individuais de negócio que estão incluídos em um {{}} opportunities_singular_module registro e rastreados através do ciclo de vida de vendas. O {{}} opportunities_singular_module registro atua como um cabeçalho para um ou mais {{}} MODULE_NAME registros. Para criar uma {{}} module_name: 1. Fornecer valores para os campos conforme desejado. - Os campos marcados "necessária" deve ser preenchido antes de salvar. - Clique em "Ver Mais" para expor campos adicionais, se necessário. 2. Clique em "Salvar" para finalizar o novo álbum e voltar para a página anterior. - Escolha "Salvar e visualizar" para abrir a nova {{}} module_name no modo de registro. - Escolha "Salvar e criar novo" para criar imediatamente um outro novo {{}} module_name.',
  'LBL_HELP_RECORD' => 'O {{}} plural_module_name módulo é composto por itens de linha individuais de negócio que estão incluídos em um {{}} opportunities_singular_module registro e rastreados através do ciclo de vida de vendas. O {{}} opportunities_singular_module registro atua como um cabeçalho para um ou mais {{}} MODULE_NAME registros. - Editar campos deste registo, clicando em um campo individual ou no botão Editar. - Exibir ou modificar as ligações a outros registros nos subpainéis alternando no painel esquerdo inferior para "Ver dados". - Fazer e ver comentários de usuários e histórico de alterações de registro no {{}} activitystream_singular_module alternando no painel esquerdo inferior para "Atividade Stream". - Siga ou favorito este registro usando os ícones à direita do nome do registro. - Estão disponíveis ações adicionais no menu Ações suspensas à direita do botão Editar.',
  'LBL_HELP_RECORDS' => 'O {{}} plural_module_name módulo é composto por itens de linha individuais de negócio que estão incluídos em um {{}} opportunities_singular_module registro e rastreados através do ciclo de vida de vendas. O {{}} opportunities_singular_module registro atua como um cabeçalho para um ou mais {{}} MODULE_NAME registros. Isto permite uma maior granularidade quando se trabalha {{opportunities_module}} e {{forecasts_singular_module}} ing uma vez que cada item de linha dentro de uma {{opportunities_singular_module}} pode ter sua fase de vendas própria e probabilidade, além de ser incluídos ou excluídos de um usuário {{forecasts_singular_module}} {{ing worksheet_module}} individualmente. Cada {{}} module_name pode estar relacionado a um produto de sua empresa Catálogo de Produtos. Isso fará com que os valores do produto para preencher automaticamente os campos correspondentes no {{}} module_name.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notas ou Anexos',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuário',
  'LBL_LIST_CLOSE' => 'Fechar',
  'LBL_LIST_COMPLETE' => 'Completar:',
  'LBL_LIST_CONTACT' => 'Contato',
  'LBL_LIST_DATE_MODIFIED' => 'Data de Modificação',
  'LBL_LIST_DUE_DATE' => 'Data Limite',
  'LBL_LIST_DUE_TIME' => 'Hora Limite',
  'LBL_LIST_FORM_TITLE' => 'Lista de Tarefas',
  'LBL_LIST_MY_TASKS' => 'As Minhas Tarefas em Aberto',
  'LBL_LIST_PRIORITY' => 'Prioridade',
  'LBL_LIST_RELATED_TO' => 'Referente a',
  'LBL_LIST_START_DATE' => 'Data Início:',
  'LBL_LIST_START_TIME' => 'Hora Inicial:',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Assunto',
  'LBL_MODULE_NAME' => 'Tarefas',
  'LBL_MODULE_NAME_SINGULAR' => 'Tarefa',
  'LBL_MODULE_TITLE' => 'Tarefas: Tela Principal',
  'LBL_NAME' => 'Nome:',
  'LBL_NEW_FORM_DUE_DATE' => 'Data Limite:',
  'LBL_NEW_FORM_DUE_TIME' => 'Hora Limite:',
  'LBL_NEW_FORM_SUBJECT' => 'Assunto:',
  'LBL_NEW_FORM_TITLE' => 'Nova Tarefa',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Nenhum',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Anotaçãoes:',
  'LBL_PARENT_ID' => 'ID Origem:',
  'LBL_PARENT_NAME' => 'Tipo de Origem:',
  'LBL_PHONE' => 'Telefone:',
  'LBL_PRIORITY' => 'Prioridade:',
  'LBL_REVENUELINEITEMS' => 'Itens da linha de Receita',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar Tarefas',
  'LBL_START_DATE' => 'Data Início:',
  'LBL_START_DATE_AND_TIME' => 'Data e Hora de Iní­cio:',
  'LBL_START_TIME' => 'Hora Inicial:',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Assunto:',
  'LBL_TASK' => 'Tarefas:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Tarefa fechada com sucesso',
  'LBL_TASK_INFORMATION' => 'Informação da Tarefa',
  'LNK_IMPORT_TASKS' => 'Importar Tarefas',
  'LNK_NEW_TASK' => 'Nova Tarefa',
  'LNK_TASK_LIST' => 'Tarefas',
);

