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
  'ERR_DELETE_RECORD' => 'Um número de registro deve ser especificado para eliminar a Conta.',
  'ERR_REMOVING_ATTACHMENT' => 'Falha ao remover anexo...',
  'LBL_ACCOUNT_ID' => 'ID da Conta',
  'LBL_ACTIVITIES_REPORTS' => 'Relatório de Atividades',
  'LBL_CASE_ID' => 'ID da Ocorrência',
  'LBL_CLOSE' => 'Fechar',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'ID do Contato',
  'LBL_CONTACT_NAME' => 'Contato',
  'LBL_CREATED_BY' => 'Criado por',
  'LBL_DATE_ENTERED' => 'Data de Criação',
  'LBL_DATE_MODIFIED' => 'Data de Modificação',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Notas ou Anexos',
  'LBL_DELETED' => 'Deletado',
  'LBL_DESCRIPTION' => 'Descrição',
  'LBL_EDITLAYOUT' => 'Editar Layout',
  'LBL_EMAIL_ADDRESS' => 'E-mail',
  'LBL_EMAIL_ATTACHMENT' => 'Anexo do E-mail',
  'LBL_EMBED_FLAG' => 'Embutido no E-mail?',
  'LBL_EXPORT_PARENT_ID' => 'Relacionado ao ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Relacionado ao Módulo',
  'LBL_FILENAME' => 'Anexo',
  'LBL_FILE_MIME_TYPE' => 'Mime Type',
  'LBL_FILE_URL' => 'URL do Arquivo',
  'LBL_FIRST_NAME' => 'Primeiro Nome',
  'LBL_HELP_CREATE' => 'Para Criar o {{module_name}}: 1. Forneça valores para os campos conforme desejado. - Os campos marcados "necessária" deve ser preenchido antes de salvar. - Clique em "Mostrar mais" para expor campos adicionais, se necessário. 2 Clique em "Salvar" para finalizar o novo registro e retornar à página anterior. - Escolha a opção "Salvar e visualizar" para abrir o novo {{module_name}} tendo em vista o registro. - Escolha a opção "Salvar e criar novo" para criar imediatamente um outro novo {{module_name}}.',
  'LBL_HELP_RECORD' => 'O {{plural_module_name}} Consiste de um modulo individual  {{plural_module_name}} que contêm texto ou um anexo pertinente ao registro relacionado. {{module_name}} registros podem estar relacionados a um registro na maioria dos módulos via o flex campo relacionam e também pode estar relacionada a um único {{contacts_singular_module}}. {{plural_module_name}} pode conter texto genérico sobre um registro ou mesmo um anexo relacionado com o registro. Existem várias maneiras que você pode criar {{plural_module_name}} no Sugar assim como via {{plural_module_name}} modulo, importando{{plural_module_name}}, Uma Vez que {{module_name}} registro é criado, você pode visualizar e editar as informações relativas à {{module_name}} via {{plural_module_name}} ver o registro. Cada {{module_name}} registro pode então relacionar com outros registros de açúcar, tais como {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, e muitos outros.',
  'LBL_HELP_RECORDS' => 'O {{plural_module_name}} Consiste de um modulo individual  {{plural_module_name}} que contêm texto ou um anexo pertinente ao registro relacionado. {{module_name}} registros podem estar relacionados a um registro na maioria dos módulos via o flex campo relacionam e também pode estar relacionada a um único {{contacts_singular_module}}. {{plural_module_name}} pode conter texto genérico sobre um registro ou mesmo um anexo relacionado com o registro. Existem várias maneiras que você pode criar {{plural_module_name}} no Sugar assim como via {{plural_module_name}} modulo, importando{{plural_module_name}}, Uma Vez que {{module_name}} registro é criado, você pode visualizar e editar as informações relativas à {{module_name}} via {{plural_module_name}} ver o registro. Cada {{module_name}} registro pode então relacionar com outros registros de açúcar, tais como {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, e muitos outros.',
  'LBL_LAST_NAME' => 'Sobrenome',
  'LBL_LEAD_ID' => 'ID do Potencial',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuário',
  'LBL_LIST_CONTACT' => 'Contato',
  'LBL_LIST_CONTACT_NAME' => 'Contato',
  'LBL_LIST_DATE_MODIFIED' => 'Última Modificação',
  'LBL_LIST_EDIT_BUTTON' => 'Editar',
  'LBL_LIST_FILENAME' => 'Anexo',
  'LBL_LIST_FORM_TITLE' => 'Lista de Notas ou Anexos',
  'LBL_LIST_RELATED_TO' => 'Referente a',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Assunto',
  'LBL_MEMBER_OF' => 'Membro de',
  'LBL_MODIFIED_BY' => 'Modificado Por',
  'LBL_MODULE_NAME' => 'Notas ou Anexos',
  'LBL_MODULE_NAME_SINGULAR' => 'anotaçã0',
  'LBL_MODULE_TITLE' => 'Notas: Tela Principal',
  'LBL_MY_NOTES_DASHLETNAME' => 'As Minhas Notas',
  'LBL_NEW_FORM_BTN' => 'adicionar anotação',
  'LBL_NEW_FORM_TITLE' => 'Nova Nota ou Anexo',
  'LBL_NOTE' => 'Notas',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Anexos',
  'LBL_NOTE_INFORMATION' => 'Informação da Nota',
  'LBL_NOTE_STATUS' => 'Nota ou Anexos',
  'LBL_NOTE_SUBJECT' => 'Assunto',
  'LBL_OC_FILE_NOTICE' => 'Por favor acesse ao servidor para ver o arquivo',
  'LBL_OPPORTUNITY_ID' => 'ID da Oportunidade',
  'LBL_PANEL_DETAILS' => 'Detalhes',
  'LBL_PARENT_ID' => 'ID de Referência',
  'LBL_PARENT_TYPE' => 'Tipo de Referência',
  'LBL_PHONE' => 'Telefone',
  'LBL_PORTAL_FLAG' => 'Exibir no Portal?',
  'LBL_PRODUCT_ID' => 'ID do Produto',
  'LBL_QUOTE_ID' => 'ID da Cotação',
  'LBL_RELATED_TO' => 'Referente a',
  'LBL_REMOVING_ATTACHMENT' => 'Removendo anexo...',
  'LBL_REVENUELINEITEMS' => 'Receita Itens de Linha',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar Notas ou Anexos',
  'LBL_SEND_ANYWAYS' => 'Este e-mail está sem assunto. Enviar / Gravar mesmo assim?',
  'LBL_STATUS' => 'Estado',
  'LBL_SUBJECT' => 'Assunto',
  'LNK_IMPORT_NOTES' => 'Importar Notas ou Anexos',
  'LNK_NEW_NOTE' => 'Nova Nota ou Anexo',
  'LNK_NOTE_LIST' => 'Notas ou Anexos',
);

