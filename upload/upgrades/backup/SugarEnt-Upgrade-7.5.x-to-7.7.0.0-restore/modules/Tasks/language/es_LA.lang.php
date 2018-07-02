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
  'DATE_FORMAT' => '(yyyy-mm-dd)',
  'ERR_DELETE_RECORD' => 'Debe especificar un número de registro para eliminar el contacto.',
  'ERR_INVALID_HOUR' => 'Por favor, introduzca una hora entre 0 y 24',
  'LBL_ACTIVITIES_REPORTS' => 'Informe de Actividad',
  'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
  'LBL_ASSIGNED_USER' => 'Asignado a',
  'LBL_COLON' => ':',
  'LBL_CONTACT' => 'Contacto:',
  'LBL_CONTACT_FIRST_NAME' => 'Nombre del Contacto',
  'LBL_CONTACT_ID' => 'ID de Contacto:',
  'LBL_CONTACT_LAST_NAME' => 'Apellido del Contacto',
  'LBL_CONTACT_NAME' => 'Contacto',
  'LBL_CONTACT_PHONE' => 'Teléfono de Contacto:',
  'LBL_DATE_DUE' => 'Fecha de vencimiento',
  'LBL_DATE_DUE_FLAG' => 'Sin fecha de vencimiento',
  'LBL_DATE_START_FLAG' => 'Sin fecha de inicio',
  'LBL_DEFAULT_PRIORITY' => 'Media',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DESCRIPTION_INFORMATION' => 'Información adicional',
  'LBL_DUE_DATE' => 'Fecha de vencimiento:',
  'LBL_DUE_DATE_AND_TIME' => 'Fecha y hora de vencimiento:',
  'LBL_DUE_TIME' => 'Hora de vencimiento:',
  'LBL_EDITLAYOUT' => 'Editar diseño',
  'LBL_EMAIL' => 'Correo Electrónico:',
  'LBL_EMAIL_ADDRESS' => 'Dirección de Correo:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID de Usuario Asignado',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Usuario Asignado',
  'LBL_EXPORT_CREATED_BY' => 'Creado por ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificado por ID',
  'LBL_EXPORT_PARENT_ID' => 'Relacionado con el ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Relacionado con el módulo',
  'LBL_HELP_CREATE' => 'El módulo {{plural_module_name}} consta de acciones flexibles, los elementos de tareas, o otro tipo de actividad que requiere la terminación.

Para crear un {{module_name}}:
1. Proporcione valores para los campos como se desee. 
  - Los campos marcados "Obligatorio" debe ser completado antes de guardar. 
  - Haga clic en "Mostrar más" para exponer campos adicionales si es necesario. 
2. Haga clic en "Guardar" para finalizar el nuevo disco y volver a la página anterior. 
  - Seleccione la opción "Guardar y ver" para abrir el nuevo {{module_name}}en vista de registro. 
  - Seleccione la opción "Guardar y crear nuevo" para crear inmediatamente otra nueva {{module_name}}.',
  'LBL_HELP_RECORD' => 'El módulo {{plural_module_name}}consta de acciones flexibles, los elementos de tareas, o otro tipo de actividad que requiere la terminación.
- Edite los campos de este registro, haga clic en un campo individual o en el botón Modificar. 
- Ver o modificar enlaces a otros registros en los subpaneles moviendo el panel inferior izquierdo para "Vista de datos". 
- Hacer y ver los comentarios de los usuarios y el cambio en el registro de la historia {{activitystream_singular_module}} moviendo el panel inferior izquierdo para "Últimas acciones". 
- Siga o favorito este registro utilizando los iconos a la derecha del nombre del registro. 
- Las acciones adicionales se encuentran disponibles en el menú Acciones desplegables a la derecha del botón Editar.',
  'LBL_HELP_RECORDS' => 'El módulo {{plural_module_name}} consta de acciones flexibles, los elementos de tareas, o otro tipo de actividad que requiere la terminación. Registros {{module_name}} puede estar relacionado con un registro en la mayoría de los módulos a través de la flexión se relacionan campo y también se puede relacionar con un solo {{contacts_singular_module}}. Hay varias formas de crear {{plural_module_name}} en Sugar tales como a través del módulo {{plural_module_name}}, duplicando, importando {{plural_module_name}}, etc. Una vez que el registro {{module_name}} se crea, puede ver y editar la información relativa a la {{module_name}} vía la vista del registro {{plural_module_name}}. Dependiendo de los detalles sobre la {{module_name}}, también puede ser capaz de ver y editar la información {{module_name}} vía el Calendario del módulo. Cada registro{{module_name}} puede ser relacionado con otros registros de Sugar así como{{accounts_module}}, {{contacts_module}}, {{opportunities_module}}, y muchos otros.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notas',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_CLOSE' => 'Cerrar',
  'LBL_LIST_COMPLETE' => 'Completo:',
  'LBL_LIST_CONTACT' => 'Contacto',
  'LBL_LIST_DATE_MODIFIED' => 'Fecha de Modificación',
  'LBL_LIST_DUE_DATE' => 'Fecha de Vencimiento',
  'LBL_LIST_DUE_TIME' => 'Hora de Vencimiento',
  'LBL_LIST_FORM_TITLE' => 'Lista de Tareas',
  'LBL_LIST_MY_TASKS' => 'Mis Tareas Abiertas',
  'LBL_LIST_PRIORITY' => 'Prioridad',
  'LBL_LIST_RELATED_TO' => 'Relacionado con',
  'LBL_LIST_START_DATE' => 'Fecha de inicio',
  'LBL_LIST_START_TIME' => 'Hora de inicio',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUBJECT' => 'Asunto',
  'LBL_MODULE_NAME' => 'Tareas',
  'LBL_MODULE_NAME_SINGULAR' => 'Tarea',
  'LBL_MODULE_TITLE' => 'Tareas: Inicio',
  'LBL_NAME' => 'Nombre:',
  'LBL_NEW_FORM_DUE_DATE' => 'Fecha de Vencimiento:',
  'LBL_NEW_FORM_DUE_TIME' => 'Hora de Vencimiento:',
  'LBL_NEW_FORM_SUBJECT' => 'Asunto:',
  'LBL_NEW_FORM_TITLE' => 'Nueva Tarea',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_NONE' => 'Ninguno',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_PARENT_ID' => 'ID del registro Padre:',
  'LBL_PARENT_NAME' => 'Tipo de Registro Padre:',
  'LBL_PHONE' => 'Teléfono:',
  'LBL_PRIORITY' => 'Prioridad:',
  'LBL_REVENUELINEITEMS' => 'Ganancia de Artículos',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Tareas',
  'LBL_START_DATE' => 'Fecha de inicio:',
  'LBL_START_DATE_AND_TIME' => 'Fecha y hora de inicio:',
  'LBL_START_TIME' => 'Hora de inicio:',
  'LBL_STATUS' => 'Estado:',
  'LBL_SUBJECT' => 'Asunto:',
  'LBL_TASK' => 'Tareas:',
  'LBL_TASK_CLOSE_SUCCESS' => 'Tarea cerrada exitosamente',
  'LBL_TASK_INFORMATION' => 'Visión General',
  'LNK_IMPORT_TASKS' => 'Importar Tareas',
  'LNK_NEW_TASK' => 'Nueva Tarea',
  'LNK_TASK_LIST' => 'Ver Tareas',
);

