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
  'ERR_DELETE_RECORD' => 'Um número de registo deverá ser especificado para eliminar este contacto.',
  'ERR_INVALID_HOUR' => 'Por favor indique uma hora entre as 00:00 e as 24:00',
  'LBL_ACTIVITIES_REPORTS' => 'Relatório de Actividades',
  'LBL_ASSIGNED_TO_NAME' => 'Atribuído a:',
  'LBL_ASSIGNED_USER' => 'Atribuído a',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Contacto:',
  'LBL_CONTACT_FIRST_NAME' => 'Primeiro Nome do Contacto',
  'LBL_CONTACT_ID' => 'ID Contacto:',
  'LBL_CONTACT_LAST_NAME' => 'Último Nome do Contacto',
  'LBL_CONTACT_NAME' => 'Nome do Contacto:',
  'LBL_CONTACT_PHONE' => 'Telefone de Contacto:',
  'LBL_DATE_DUE' => 'Data Limite',
  'LBL_DATE_DUE_FLAG' => 'Sem Data Limite',
  'LBL_DATE_START_FLAG' => 'Sem Data de Início',
  'LBL_DEFAULT_PRIORITY' => 'Médio',
  'LBL_DESCRIPTION' => 'Descrição',
  'LBL_DESCRIPTION_INFORMATION' => 'Informação da Descrição',
  'LBL_DUE_DATE' => 'Data Limite:',
  'LBL_DUE_DATE_AND_TIME' => 'Data e Hora Limites:',
  'LBL_DUE_TIME' => 'Hora Limite:',
  'LBL_EDITLAYOUT' => 'Editar Layout',
  'LBL_EMAIL' => 'E-mail:',
  'LBL_EMAIL_ADDRESS' => 'Endereço de E-mail',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID de Utilizador Atribuído',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Nome de Utilizador Atribuído',
  'LBL_EXPORT_CREATED_BY' => 'ID do Utilizador que Criou',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'ID do Utilizador que Modificou',
  'LBL_EXPORT_PARENT_ID' => 'ID de Relacionado Com',
  'LBL_EXPORT_PARENT_TYPE' => 'Relacionado com o módulo',
  'LBL_HELP_CREATE' => 'O módulo de {{plural_module_name}} consiste em acções flexíveis, itens a fazer ou outros tipos de actividades que necessitem que sejam completadas. 

Para criar um {{module_name}}:
1. Fornecer valores para os campos como desejado.
 - Campos marcados como "Obrigatórios" deverão ser preenchidos antes de gravar.
 - Carregar "Mostrar mais" para mostrar campos adicionais se necessário.

2. Carregar em "Gravar" para finalizar o novo registo e retornar à página anterior.
 - Escolher "Gravar e ver" para abrir o novo {{module_name}} na visualização do registo.
 - Escolher "Gravar e criar novo" para criar imediatamente outro novo {{module_name}}.',
  'LBL_HELP_RECORD' => 'O módulo de {{plural_module_name}} consiste em acções flexíveis, itens a fazer ou outros tipos de actividades que necessitem que sejam completadas. 

- Edite os campos deste registo carregando em um campo individualmente ou no botão Editar.
- Visualize ou modifique ligações para outros registos nos sub-painéis alterando o painel esquerdo do fundo para "Visaulização de Dados".
- Crie e visualize comentários de utilizador e grande alterações do histórico no {{activitystream_singular_module}}  alterando o painel esquerdo do fundo para "Fluxo de Actividade".
- Siga ou torne favorito este registo utilizando os ícones à direita do nome do registo.
- Acções adicionais estão disponíveis no menu de selecção Acções à direita do botão Editar.',
  'LBL_HELP_RECORDS' => 'O módulo de {{plural_module_name}} consiste em acções flexíveis, itens a fazer ou outros tipos de actividades que necessitem que sejam completadas. Registos de {{module_name}} podem estar relacionados com um registo na maior parte dos módulos via o campo relacionado flexível e também poderá estar relacionado com um único  {{contacts_singular_module}}. Existem várias maneiras de criar {{plural_module_name}} no Sugar, via o módulo de {{plural_module_name}}, duplicação, importação de {{plural_module_name}}, etc. Uma vez que o registo {{module_name}} é criado, poderá visualizar e editar a informação pertencente à {{module_name}} via visualização do registo de {{plural_module_name}}. Dependendo dos detalhes da {{module_name}}, poderá também visualizar e editar a informação da {{module_name}} via o módulo Calendário. Cada registo de {{module_name}} poderá estar relacionado com outros registo no Sugar como por exemplo: {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, e muitos outros.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notas',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Utilizador',
  'LBL_LIST_CLOSE' => 'Fechar',
  'LBL_LIST_COMPLETE' => 'Completar:',
  'LBL_LIST_CONTACT' => 'Contacto',
  'LBL_LIST_DATE_MODIFIED' => 'Data de Modificação',
  'LBL_LIST_DUE_DATE' => 'Data Limite',
  'LBL_LIST_DUE_TIME' => 'Hora Limite',
  'LBL_LIST_FORM_TITLE' => 'Lista de Tarefas',
  'LBL_LIST_MY_TASKS' => 'As Minhas Tarefas em Aberto',
  'LBL_LIST_PRIORITY' => 'Prioridade',
  'LBL_LIST_RELATED_TO' => 'Referente a',
  'LBL_LIST_START_DATE' => 'Data Início:',
  'LBL_LIST_START_TIME' => 'Hora Inicial:',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUBJECT' => 'Assunto',
  'LBL_MODULE_NAME' => 'Tarefas',
  'LBL_MODULE_NAME_SINGULAR' => 'Tarefa',
  'LBL_MODULE_TITLE' => 'Tarefas: Ecrã Principal',
  'LBL_NAME' => 'Nome:',
  'LBL_NEW_FORM_DUE_DATE' => 'Data Limite:',
  'LBL_NEW_FORM_DUE_TIME' => 'Hora Limite:',
  'LBL_NEW_FORM_SUBJECT' => 'Assunto:',
  'LBL_NEW_FORM_TITLE' => 'Nova Tarefa',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Nenhum',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_PARENT_ID' => 'ID Origem:',
  'LBL_PARENT_NAME' => 'Tipo de Origem:',
  'LBL_PHONE' => 'Telefone:',
  'LBL_PRIORITY' => 'Prioridade:',
  'LBL_REVENUELINEITEMS' => 'Itens de Linha de Receita',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar Tarefas',
  'LBL_START_DATE' => 'Data Início:',
  'LBL_START_DATE_AND_TIME' => 'Data e Hora de Iní­cio:',
  'LBL_START_TIME' => 'Hora Inicial:',
  'LBL_STATUS' => 'Estado:',
  'LBL_SUBJECT' => 'Assunto:',
  'LBL_TASK' => 'Tarefas:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Tarefa fechada com sucesso.',
  'LBL_TASK_INFORMATION' => 'Informação da Tarefa',
  'LNK_IMPORT_TASKS' => 'Importar Tarefas',
  'LNK_NEW_TASK' => 'Nova Tarefa',
  'LNK_TASK_LIST' => 'Tarefas',
);

