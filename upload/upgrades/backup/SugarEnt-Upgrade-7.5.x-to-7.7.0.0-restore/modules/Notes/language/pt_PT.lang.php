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
  'ERR_REMOVING_ATTACHMENT' => 'Falha ao remover anexo...',
  'LBL_ACCOUNT_ID' => 'ID da Entidade',
  'LBL_ACTIVITIES_REPORTS' => 'Relatório de Actividades',
  'LBL_CASE_ID' => 'ID da Ocorrência',
  'LBL_CLOSE' => 'Fechar',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'ID do Contacto',
  'LBL_CONTACT_NAME' => 'Contacto',
  'LBL_CREATED_BY' => 'Criado por',
  'LBL_DATE_ENTERED' => 'Data da Criação',
  'LBL_DATE_MODIFIED' => 'Data da Modificação',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Notas ou Anexos',
  'LBL_DELETED' => 'Eliminado',
  'LBL_DESCRIPTION' => 'Descrição',
  'LBL_EDITLAYOUT' => 'Editar Layout',
  'LBL_EMAIL_ADDRESS' => 'E-mail',
  'LBL_EMAIL_ATTACHMENT' => 'Anexo do E-mail',
  'LBL_EMBED_FLAG' => 'Embutido no E-mail?',
  'LBL_EXPORT_PARENT_ID' => 'ID do objecto relacionado',
  'LBL_EXPORT_PARENT_TYPE' => 'Relacionado com o módulo',
  'LBL_FILENAME' => 'Anexo',
  'LBL_FILE_MIME_TYPE' => 'Mime Type',
  'LBL_FILE_URL' => 'URL do Ficheiro',
  'LBL_FIRST_NAME' => 'Primeiro Nome',
  'LBL_HELP_CREATE' => 'Para criar uma {{module_name}}:
1. Fornecer valores para os campos como desejado.
 - Campos marcados como "Obrigatórios" deverão ser preenchidos antes de gravar.
 - Carregar "Mostrar mais" para mostrar campos adicionais se necessário.

2. Carregar em "Gravar" para finalizar o novo registo e retornar à página anterior.
 - Escolher "Gravar e ver" para abrir a nova {{module_name}} na visualização do registo.
 - Escolher "Gravar e criar novo" para criar imediatamente outra nova {{module_name}}.',
  'LBL_HELP_RECORD' => 'O módulo de {{plural_module_name}} consiste em {{plural_module_name}} individuais que contêm texto ou um anexo pertinente ao registo relacionado.

-Edite os campos deste registo carregando em um campo individualmente ou no botão Editar.
- Visualize ou modifique ligações para outros registos nos sub-paineis alterando o painel esquerdo do fundo para "Visualização de Dados".
- Crie e visualize comentários de utilizador e grande alterações do histórico no {{activitystream_singular_module}}  alterando o painel esquerdo do fundo para "Fluxo de Actividade".
- Siga ou torne favorito este registo utilizando os ícones à direita do nome do registo.
- Acções adicionais estão disponíveis no menu de selecção Acções à direita do botão Editar.',
  'LBL_HELP_RECORDS' => 'O módulo de {{plural_module_name}} consiste em {{plural_module_name}} individuais que contêm texto ou um anexo pertinente ao registo relacionado. Registos de {{module_name}} podem ser relacionados com um registo da maior parte dos módulos via campo relacionado flexível ou relacionado com um único {{contacts_singular_module}}. {{plural_module_name}} podem conter texto genérico sobre um registo ou mesmo um anexo relacionado com o registo. Existem várias maneiras para criar {{plural_module_name}} no Sugar, através do módulo de {{plural_module_name}}, importar {{plural_module_name}}, através do sub-painel Histórico, etc. Assim que a {{module_name}} é criada, poderá visualizar e editar a informação pertencente à {{module_name}} via a visualização de registos de {{plural_module_name}}. Cada registo de {{module_name}} poderá estar relacionado com outros registos do Sugar, como  {{accounts_module}}, {{contacts_module}}, {{opportunities_module}} e muitos outros.',
  'LBL_LAST_NAME' => 'Último Nome:',
  'LBL_LEAD_ID' => 'ID da Lead',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Utilizador',
  'LBL_LIST_CONTACT' => 'Contacto',
  'LBL_LIST_CONTACT_NAME' => 'Contacto',
  'LBL_LIST_DATE_MODIFIED' => 'Última Modificação',
  'LBL_LIST_EDIT_BUTTON' => 'Editar',
  'LBL_LIST_FILENAME' => 'Anexo',
  'LBL_LIST_FORM_TITLE' => 'Lista de Notas ou Anexos',
  'LBL_LIST_RELATED_TO' => 'Referente a',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUBJECT' => 'Assunto',
  'LBL_MEMBER_OF' => 'Membro de',
  'LBL_MODIFIED_BY' => 'Modificado Por',
  'LBL_MODULE_NAME' => 'Notas ou Anexos',
  'LBL_MODULE_NAME_SINGULAR' => 'Nota',
  'LBL_MODULE_TITLE' => 'Notas: Ecrã Principal',
  'LBL_MY_NOTES_DASHLETNAME' => 'As Minhas Notas',
  'LBL_NEW_FORM_BTN' => 'Adicionar uma nota',
  'LBL_NEW_FORM_TITLE' => 'Nova Nota ou Anexo',
  'LBL_NOTE' => 'Notas',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Anexos',
  'LBL_NOTE_INFORMATION' => 'Informação da Nota',
  'LBL_NOTE_STATUS' => 'Nota ou Anexos',
  'LBL_NOTE_SUBJECT' => 'Assunto',
  'LBL_OC_FILE_NOTICE' => 'Por favor aceda ao servidor para ver o ficheiro',
  'LBL_OPPORTUNITY_ID' => 'ID da Oportunidade',
  'LBL_PANEL_DETAILS' => 'Detalhes',
  'LBL_PARENT_ID' => 'ID de Referência',
  'LBL_PARENT_TYPE' => 'Tipo de Referência',
  'LBL_PHONE' => 'Telefone',
  'LBL_PORTAL_FLAG' => 'Exibir no Portal?',
  'LBL_PRODUCT_ID' => 'ID do Produto',
  'LBL_QUOTE_ID' => 'ID da Cotação',
  'LBL_RELATED_TO' => 'Referente a',
  'LBL_REMOVING_ATTACHMENT' => 'A remover anexo...',
  'LBL_REVENUELINEITEMS' => 'Itens de Linha de Receita',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar Notas ou Anexos',
  'LBL_SEND_ANYWAYS' => 'Este e-mail está sem assunto. Enviar / Gravar mesmo assim?',
  'LBL_STATUS' => 'Estado',
  'LBL_SUBJECT' => 'Assunto',
  'LNK_IMPORT_NOTES' => 'Importar Notas ou Anexos',
  'LNK_NEW_NOTE' => 'Nova Nota ou Anexo',
  'LNK_NOTE_LIST' => 'Notas ou Anexos',
);

