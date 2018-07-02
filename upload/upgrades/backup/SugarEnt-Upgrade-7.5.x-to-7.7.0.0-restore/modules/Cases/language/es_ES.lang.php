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
  'ERR_DELETE_RECORD' => 'Debe especificar un número de registro a eliminar.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Cuentas',
  'LBL_ACCOUNT_ID' => 'ID Cuenta',
  'LBL_ACCOUNT_NAME' => 'Cuenta:',
  'LBL_ACCOUNT_NAME_MOD' => 'Nombre del Mod de la cuenta',
  'LBL_ACCOUNT_NAME_OWNER' => 'Propietario de la cuenta',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Mod del usuario asignado',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Propietario del usuario asignado',
  'LBL_ATTACH_NOTE' => 'Adjuntar Nota',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Incidencias',
  'LBL_CASE' => 'Caso:',
  'LBL_CASE_FROM_TWITTER_TITLE' => 'Tweet',
  'LBL_CASE_INFORMATION' => 'Visión General',
  'LBL_CASE_NUMBER' => 'Número:',
  'LBL_CASE_SUBJECT' => 'Asunto:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CONTACT_CASE_TITLE' => 'Contacto-Caso:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Relación de contactos en Emails',
  'LBL_CONTACT_NAME' => 'Contacto:',
  'LBL_CONTACT_ROLE' => 'Rol:',
  'LBL_CREATED_BY_NAME_MOD' => 'Creado por nombre Mod',
  'LBL_CREATED_BY_NAME_OWNER' => 'Creado por nombre propietario',
  'LBL_CREATED_USER' => 'Usuario Creado',
  'LBL_CREATE_KB_DOCUMENT' => 'Crear Artículo',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Casos',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID Usuario asignado',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Asignado al usuario',
  'LBL_EXPORT_CREATED_BY' => 'Creado por ID',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Creado por el usuario',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificador por ID',
  'LBL_EXPORT_TEAM_COUNT' => 'Número de equipos',
  'LBL_FILENANE_ATTACHMENT' => 'Archivar Adjunto',
  'LBL_HELP_CREATE' => 'El módulo {{plural_module_name}} se utiliza para realizar un seguimiento y gestionar productos y servicios relacionados con los problemas reportados por los clientes a su empresa.

Para crear un {{module_name}}:
1. Proporcione valores para los campos que desee.
* Los campos marcados "Obligatorio" se deben completar antes de guardar.
* Haga clic en "Mostrar más" para ver los campos adicionales si es necesario.
2. Haga clic en "Guardar" para finalizar el nuevo registro y volver a la vista en lista de {{plural_module_name}} .
* Seleccione la opción "Guardar y ver" para abrir el nuevo {{module_name}} como vista de registro.
* Seleccione la opción "Guardar y crear nuevo" para un nuevo {{module_name}} inmediatamente.',
  'LBL_HELP_RECORD' => 'El módulo {{plural_module_name}} se utiliza para hacer seguimiento y gestionar productos y servicios relacionados con problemas reportados a la empresa por los clientes.   

- Edita el registro haciendo clic en el campo individual o el botón Editar.
- Ver o modificar enlaces a otros registros en los subpanales yendo a la pestaña "Ver Datos".
- Comentar o ver otros comentarios de usuarios y ver el historial del registro en {{activitystream_singular_module}} yendo a "Actividades Recientes".
- Seguir o guardar como favorito el registro utilizando los iconos a la izquierda del nombre del registro. 
- Acciones adicionales están disponibles en el botón desplegable Acciones.',
  'LBL_HELP_RECORDS' => 'El módulo {{plural_module_name}} se utiliza para realizar seguimiento y gestionar productos y servicios relacionados con los problemas reportados a su empresa por los clientes. {{plural_module_name}} generalmente están relacionados con el registro {{account_module}} ,y múltiples {{plural_module_name}} pueden ser relacionaos a una única {{account_module}}. Hay varios modos en el que puedes crear {{plural_module_name}} en Sugar como a través del módulo {{plural_module_name}}, importando {{plural_module_name}}, o convertirlo desde el email. Una vez el {{module_name}} se ha creado, podrá ver y editar la información relacionada con el {{module_name}} a través de la vista del registro {{module_name}}. Cada registro {{module_name}} entonces podrá estar relacionados a otros registros de Sugar como por ejemplo {{calls_module}}, {{contacts_module}}, {{bugs_module}}, y otros muchos.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
  'LBL_INVITEE' => 'Contactos',
  'LBL_KBDOCUMENTS_SUBPANEL_TITLE' => 'Base de Conocimiento:',
  'LBL_LIST_ACCOUNT_NAME' => 'Cuenta',
  'LBL_LIST_ASSIGNED' => 'Asignado a',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_CLOSE' => 'Cerrar',
  'LBL_LIST_DATE_CREATED' => 'Fecha de Creación',
  'LBL_LIST_FORM_TITLE' => 'Lista de Casos',
  'LBL_LIST_LAST_MODIFIED' => 'Modificado',
  'LBL_LIST_MY_CASES' => 'Mis Casos Abiertos',
  'LBL_LIST_NUMBER' => 'Núm.',
  'LBL_LIST_PRIORITY' => 'Prioridad',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUBJECT' => 'Asunto',
  'LBL_MEMBER_OF' => 'Cuenta',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Modificado por nombre Mod',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Modificado por nombre propietario',
  'LBL_MODIFIED_USER' => 'Usuario Modificado',
  'LBL_MODIFIED_USER_NAME' => 'Nombre del usuario modificado',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Mod del usuario modificado',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Propietario del usuario modificado',
  'LBL_MODULE_NAME' => 'Casos',
  'LBL_MODULE_NAME_SINGULAR' => 'Caso',
  'LBL_MODULE_TITLE' => 'Casos: Inicio',
  'LBL_NEW_FORM_TITLE' => 'Nuevo Caso',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_NUMBER' => 'Número:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Si tienes un nuevo Caso de soporte que te gustaría enviar, puedes hacer clic aquí para enviarlo.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Tú puedes filtrar el listado de Casos indicando un término de búsqueda.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Por ejemplo, tú puedes usarlo para encontrar un tema previamente enviado.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'El módulo de Casos es para la gestión de soporte que afecta a las Cuentas. Utiliza las flechas más abajo para una visita rápida.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Esta página muestra el listado de Casos existentes asociados a tu Cuenta.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Haz clic aquí para volver a esta vista en cualquier momento.',
  'LBL_PORTAL_VIEWABLE' => 'Visible en portal',
  'LBL_PRIORITY' => 'Prioridad:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_RESOLUTION' => 'Resolución:',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Casos',
  'LBL_SHOW_IN_PORTAL' => 'Mostrar en Portal',
  'LBL_SHOW_MORE' => 'Mostrar más Casos',
  'LBL_SOURCE' => 'Fuente:',
  'LBL_STATUS' => 'Estado:',
  'LBL_SUBJECT' => 'Asunto:',
  'LBL_SYSTEM_ID' => 'ID Sistema',
  'LBL_TEAM_COUNT_MOD' => 'Mod de número de equipos',
  'LBL_TEAM_COUNT_OWNER' => 'Propietario del número de equipos',
  'LBL_TEAM_NAME_MOD' => 'Nombre del Mod del equipo',
  'LBL_TEAM_NAME_OWNER' => 'Nombre del propietario del equipo',
  'LBL_TYPE' => 'Tipo',
  'LBL_WORK_LOG' => 'Registro de Trabajo',
  'LNK_CASE_LIST' => 'Ver Casos',
  'LNK_CASE_REPORTS' => 'Ver Informes de Casos',
  'LNK_CREATE' => 'Nuevo Caso',
  'LNK_CREATE_WHEN_EMPTY' => 'Crear un Caso ahora',
  'LNK_IMPORT_CASES' => 'Importar Casos',
  'LNK_NEW_CASE' => 'Nuevo Caso',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => '¿Está seguro de que desea quitar este caso de la incidencia?',
  'NTC_REMOVE_INVITEE' => '¿Está seguro de que desea quitar a este contacto de la cuenta?',
);

