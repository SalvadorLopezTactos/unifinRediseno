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
  'ERR_REMOVING_ATTACHMENT' => 'Error al quitar archivo adjunto...',
  'LBL_ACCOUNT_ID' => 'ID de Cuenta:',
  'LBL_ACTIVITIES_REPORTS' => 'Informe de Actividad',
  'LBL_CASE_ID' => 'ID de Caso:',
  'LBL_CLOSE' => 'Cerrar:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'ID de Contacto:',
  'LBL_CONTACT_NAME' => 'Contacto:',
  'LBL_CREATED_BY' => 'Creado Por',
  'LBL_DATE_ENTERED' => 'Fecha de creación',
  'LBL_DATE_MODIFIED' => 'Fecha Modificación',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Notas',
  'LBL_DELETED' => 'Eliminada',
  'LBL_DESCRIPTION' => 'Nota',
  'LBL_EDITLAYOUT' => 'Editar Diseño',
  'LBL_EMAIL_ADDRESS' => 'Dirección de Correo Electrónico:',
  'LBL_EMAIL_ATTACHMENT' => 'Archivo Adjunto de Correo Electrónico:',
  'LBL_EMBED_FLAG' => '¿Incluir en Correo Electrónico?',
  'LBL_EXPORT_PARENT_ID' => 'Relacionado con el ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Relacionado con el Módulo',
  'LBL_FILENAME' => 'Archivo Adjunto:',
  'LBL_FILE_MIME_TYPE' => 'Tipo MIME',
  'LBL_FILE_URL' => 'URL de Archivo',
  'LBL_FIRST_NAME' => 'Nombre',
  'LBL_HELP_CREATE' => 'Para crear un {{module_name}}:
1. Proporcione valores para los campos como se desee. 
  - Los campos marcados "Obligatorio" debe ser completado antes de guardar. 
  - Haga clic en "Mostrar más" para exponer campos adicionales si es necesario. 
2. Haga clic en "Guardar" para finalizar el nuevo disco y volver a la página anterior. 
  - Seleccione la opción "Guardar y ver" para abrir el nuevo {{module_name}} en vista de registro. 
  - Seleccione la opción "Guardar y crear nuevo" para crear inmediatamente otra nueva {{module_name}}.',
  'LBL_HELP_RECORD' => 'El módulo {{plural_module_name}} consiste individuo {{plural_module_name}} que contienen texto o un archivo adjunto pertinente al registro relacionado.

-Edite los campos de este registro, haga clic en un campo individual o en el botón Modificar. 
- Ver o modificar enlaces a otros registros en los subpaneles moviendo el panel inferior izquierdo para "Vista de datos". 
- Hacer y ver los comentarios de los usuarios y el cambio en el registro de la historia{{activitystream_singular_module}} moviendo el panel inferior izquierdo para "Últimas acciones". 
- Siga o favorito este registro utilizando los iconos a la derecha del nombre del registro. 
- Las acciones adicionales se encuentran disponibles en el menú Acciones desplegables a la derecha del botón Editar.',
  'LBL_HELP_RECORDS' => 'El módulo {{plural_module_name}} consiste de  {{plural_module_name}} individuales que contienen texto o un archivo adjunto pertinente al registro relacionado. {{module_name}} registros pueden estar relacionados con un registro en la mayoría de los módulos a través de los flex se refieren campo y también pueden estar relacionados con un solo {{contacts_singular_module}}. {{plural_module_name}}puede contener texto genérico sobre un registro o incluso un archivo adjunto en relación con el registro. Hay varias formas de crear {{plural_module_name}} en Sugartales como a través del módulo {{plural_module_name}} importando {{plural_module_name}}, vía historila de subpaneles, etc. na vez el registro {{module_name}} es creado, usted puede ver y editar la información relativa a la {{module_name}} vía la vista de registro {{plural_module_name}}. Cada registro {{module_name}} puede relacionarse con otros registros de Sugar tales como {{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, y muchos otros.',
  'LBL_LAST_NAME' => 'Apellidos',
  'LBL_LEAD_ID' => 'ID de Cliente Potencial:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_CONTACT' => 'Contacto',
  'LBL_LIST_CONTACT_NAME' => 'Contacto',
  'LBL_LIST_DATE_MODIFIED' => 'Última Modificación',
  'LBL_LIST_EDIT_BUTTON' => 'Editar',
  'LBL_LIST_FILENAME' => 'Archivo Adjunto',
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
  'LBL_NEW_FORM_TITLE' => 'Nota Nueva o Añadir Archivo Adjunto',
  'LBL_NOTE' => 'Nota:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas y Archivos Adjuntos',
  'LBL_NOTE_INFORMATION' => 'Visión General',
  'LBL_NOTE_STATUS' => 'Nota',
  'LBL_NOTE_SUBJECT' => 'Asunto:',
  'LBL_OC_FILE_NOTICE' => 'Por favor, inicie la sesión en el servidor para ver el archivo',
  'LBL_OPPORTUNITY_ID' => 'ID de Oportunidad:',
  'LBL_PANEL_DETAILS' => 'Detalles',
  'LBL_PARENT_ID' => 'ID de Registro Padre:',
  'LBL_PARENT_TYPE' => 'Tipo de Registro Padre',
  'LBL_PHONE' => 'Teléfono:',
  'LBL_PORTAL_FLAG' => '¿Mostrar en el Portal?',
  'LBL_PRODUCT_ID' => 'ID de Producto:',
  'LBL_QUOTE_ID' => 'ID de Cotización:',
  'LBL_RELATED_TO' => 'Relacionado con:',
  'LBL_REMOVING_ATTACHMENT' => 'Quitando archivo adjunto...',
  'LBL_REVENUELINEITEMS' => 'Ganancia de Artículo',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Notas',
  'LBL_SEND_ANYWAYS' => 'Este correo no tiene asunto. ¿Enviar/guardar de todas formas?',
  'LBL_STATUS' => 'Estado',
  'LBL_SUBJECT' => 'Asunto:',
  'LNK_IMPORT_NOTES' => 'Importar Notas',
  'LNK_NEW_NOTE' => 'Nueva Nota o Archivo Adjunto',
  'LNK_NOTE_LIST' => 'Ver Notas',
);

