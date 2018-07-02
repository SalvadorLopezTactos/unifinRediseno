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
  'ERR_DELETE_RECORD' => 'Debe especificar un número de registro para eliminar la cuenta.',
  'ERR_REMOVING_ATTACHMENT' => 'Error al quitar adjunto...',
  'LBL_ACCOUNT_ID' => 'ID Cuenta:',
  'LBL_ACTIVITIES_REPORTS' => 'Informe de Actividad',
  'LBL_CASE_ID' => 'ID Caso:',
  'LBL_CLOSE' => 'Cerrar:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'ID Contacto:',
  'LBL_CONTACT_NAME' => 'Contacto:',
  'LBL_CREATED_BY' => 'Creado Por',
  'LBL_DATE_ENTERED' => 'Fecha de creación',
  'LBL_DATE_MODIFIED' => 'Fecha Modificación',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Notas',
  'LBL_DELETED' => 'Eliminada',
  'LBL_DESCRIPTION' => 'Nota',
  'LBL_EDITLAYOUT' => 'Editar Diseño',
  'LBL_EMAIL_ADDRESS' => 'Dirección de Correo:',
  'LBL_EMAIL_ATTACHMENT' => 'Adjunto de Correo:',
  'LBL_EMBED_FLAG' => '¿Incluir en Correo?',
  'LBL_EXPORT_PARENT_ID' => 'Relacionado con el ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Relacionado con el Módulo',
  'LBL_FILENAME' => 'Adjunto:',
  'LBL_FILE_MIME_TYPE' => 'Tipo MIME',
  'LBL_FILE_URL' => 'URL de Archivo',
  'LBL_FIRST_NAME' => 'Nombre',
  'LBL_HELP_CREATE' => 'Para crear un {{module_name}}:
1. Proporcione valores para los campos que desee.
 - Los campos marcados como "Obligatorio" se deben completar antes de guardar.
 - Haga clic en "Mostrar Más" para ver los campos adicionales si es necesario.
2. Haga clic en "Guardar" para finalizar el nuevo registro y volver a la página previa. 
 - Seleccione la opción "Guardar y ver" para abrir el nuevo {{module_name}} como vista de registro.
 - Seleccione la opción "Guardar y crear nuevo" para crear un nuevo {{module_name}} inmediatamente.',
  'LBL_HELP_RECORD' => 'El módulo {{plural_module_name}} consisten en {{plural_module_name}} individuales que contienen texto o un adjunto que pertenece al registro relacionado. 

- Edita el registro haciendo clic en el campo individual o el botón Editar. 
- Ver o modificar enlaces a otros registros en los subpanales yendo a la pestaña "Ver Datos".
- Comentar o ver otros comentarios de usuarios y ver el historial del registro en {{activitystream_singular_module}} yendo a "Actividades Recientes".
- Seguir o guardar como favorito el registro utilizando los iconos a la izquierda del nombre del registro. 
- Acciones adicionales están disponibles en el botón desplegable Acciones.',
  'LBL_HELP_RECORDS' => 'El módulo {{plural_module_name}}  consta de {{plural_module_name}} individuales que contienen texto o adjuntos pertenecientes al registro relacionado. Los registros {{module_name}} pueden estar relacionados con un registro en la mayoría de los módulos a través de campos flexibles relacionados y también pueden ser relacionados con un/a {{contact_module}}. {{plural_module_name}} pueden contener texto genérico sobre un registro o incluso un archivo adjunto en relación con el registro. Hay varias formas de crear {{plural_module_name}} en Sugar como por ejemplo a través del módulo {{plural_module_name}}, importando {{plural_module_name}}, vía los subpaneles del Histórico, etc. Una vez el registro {{module_name}} se ha creado, usted podrá ver y editar la información relacionada con el módulo {{module_name}} via {{plural_module_name}} vista de registro. Cada registro de {{module_name}} puede entonces relacionarse con otros registros de Sugar, tales como {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, y otros muchos.',
  'LBL_LAST_NAME' => 'Apellidos',
  'LBL_LEAD_ID' => 'ID Cliente Potencial:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_CONTACT' => 'Contacto',
  'LBL_LIST_CONTACT_NAME' => 'Contacto',
  'LBL_LIST_DATE_MODIFIED' => 'Modificado',
  'LBL_LIST_EDIT_BUTTON' => 'Editar',
  'LBL_LIST_FILENAME' => 'Adjunto',
  'LBL_LIST_FORM_TITLE' => 'Lista de Notas',
  'LBL_LIST_RELATED_TO' => 'Relacionado con',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUBJECT' => 'Asunto',
  'LBL_MEMBER_OF' => 'Miembro de:',
  'LBL_MODIFIED_BY' => 'Modificado Por',
  'LBL_MODULE_NAME' => 'Notas',
  'LBL_MODULE_NAME_SINGULAR' => 'Nota',
  'LBL_MODULE_TITLE' => 'Notas: Inicio',
  'LBL_MY_NOTES_DASHLETNAME' => 'Mis Notas',
  'LBL_NEW_FORM_BTN' => 'Nueva Nota',
  'LBL_NEW_FORM_TITLE' => 'Nueva Nota o Adjunto',
  'LBL_NOTE' => 'Nota:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Adjuntos',
  'LBL_NOTE_INFORMATION' => 'Visión General',
  'LBL_NOTE_STATUS' => 'Nota',
  'LBL_NOTE_SUBJECT' => 'Asunto:',
  'LBL_OC_FILE_NOTICE' => 'Por favor, inicie la sesión en el servidor para ver el archivo',
  'LBL_OPPORTUNITY_ID' => 'ID Oportunidad:',
  'LBL_PANEL_DETAILS' => 'Detalles',
  'LBL_PARENT_ID' => 'ID Padre:',
  'LBL_PARENT_TYPE' => 'Tipo de Padre',
  'LBL_PHONE' => 'Teléfono:',
  'LBL_PORTAL_FLAG' => '¿Mostrar en el Portal?',
  'LBL_PRODUCT_ID' => 'ID Producto:',
  'LBL_QUOTE_ID' => 'ID Presupuesto:',
  'LBL_RELATED_TO' => 'Relacionado con:',
  'LBL_REMOVING_ATTACHMENT' => 'Quitando adjunto...',
  'LBL_REVENUELINEITEMS' => 'Líneas de Ingreso',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Notas',
  'LBL_SEND_ANYWAYS' => 'Este correo no tiene asunto. ¿Enviar/guardar de todas formas?',
  'LBL_STATUS' => 'Estado',
  'LBL_SUBJECT' => 'Asunto:',
  'LNK_IMPORT_NOTES' => 'Importar Notas',
  'LNK_NEW_NOTE' => 'Nueva Nota o Adjunto',
  'LNK_NOTE_LIST' => 'Ver Notas',
);

