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
  'ERR_DELETE_RECORD' => 'Debe especificar un número de registro para eliminar la incidencia.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Cuentas',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
  'LBL_BUG' => 'Incidencia:',
  'LBL_BUG_INFORMATION' => 'Visión General',
  'LBL_BUG_NUMBER' => 'Número de Incidencia:',
  'LBL_BUG_SUBJECT' => 'Asunto de la Incidencia:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Casos',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CONTACT_BUG_TITLE' => 'Contacto-Incidencia:',
  'LBL_CONTACT_NAME' => 'Contacto:',
  'LBL_CONTACT_ROLE' => 'Rol:',
  'LBL_CREATED_BY' => 'Creado por:',
  'LBL_DATE_CREATED' => 'Fecha de creación:',
  'LBL_DATE_LAST_MODIFIED' => 'Última modificación:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Seguimiento de Incidencias',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID Usuario asignado',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Usuario asignado',
  'LBL_EXPORT_CREATED_BY' => 'Creado por ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Fijado en la versión',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificador por ID',
  'LBL_FIXED_IN_RELEASE' => 'Corregido en Lanzamiento:',
  'LBL_FOUND_IN_RELEASE' => 'Encontrado en Lanzamiento:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Encontrado en la versión',
  'LBL_HELP_CREATE' => 'El módulo {{plural_module_name}} se utiliza para rastrear y administrar los problemas relacionados con productos, comúnmente conocido como {{plural_module_name}} o defectos, ya sean reportados internamente o por el cliente.

Para crear un {{module_name}}:
1. Proporcione valores para los campos que desee.
- Los campos marcados como "Obligatorio" se deben completar antes de guardar.
- Haga clic en "Mostrar más" para ver los campos adicionales si es necesario.
2. Haga clic en "Guardar" para finalizar el nuevo registro y volver a la página previa.
- Seleccione la opción "Guardar y ver" para abrir el nuevo {{module_name}} como vista de registro
- Seleccione la opción "Guardar y crear nuevo" para crear un nuevo {{module_name}} inmediatamente.',
  'LBL_HELP_RECORD' => 'El módulo {{plural_module_name}} se utiliza para hacer seguimiento y gestionar problemas relacionados con productos y servicios, comúnmente referidos como {{plural_module_name}} or defectuosos, ya sean reportados internamente o por los clientes.

- Edita el registro haciendo clic en el campo individual o el botón Editar. 
- Ver o modificar enlaces a otros registros en los subpanales yendo a la pestaña "Ver Datos".
- Comentar o ver otros comentarios de usuarios y ver el historial del registro en {{activitystream_singular_module}} yendo a "Actividades Recientes".
- Seguir o guardar como favorito el registro utilizando los iconos a la izquierda del nombre del registro. 
- Acciones adicionales están disponibles en el botón desplegable Acciones.',
  'LBL_HELP_RECORDS' => 'El módulo {{plural_module_name}} se compone de todos los productos que ya han sido vendidos o están en proceso de venta a los clientes. El listado de los productos vendidos por la empresa se encuentra en Admin > Catálogo de Producto y los administradores tienen la capacidad de añadir productos según sea necesario. Cuando se crean {{plural_module_name}}, tiene la opción de seleccionar productos del catálogo o crear nuevos productos a través del módulo {{plural_module_name}} . Hay varias formas de crear {{plural_module_name}} en Sugar como a través del módulo {{plural_module_name}}, módulo {{quotes_module}}, duplicando, importando {{plural_module_name}}, etc. Una vez el registro {{module_name}} se ha creado, usted podrá ver y editar la información relacionada con el {{module_name}} a través de la vista del registro {{plural_module_name}} .',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
  'LBL_INVITEE' => 'Contactos',
  'LBL_LIST_ACCOUNT_NAME' => 'Cuenta',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_CONTACT_NAME' => 'Contacto',
  'LBL_LIST_EMAIL_ADDRESS' => 'Email',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Corregido en Lanzamiento',
  'LBL_LIST_FORM_TITLE' => 'Lista de Incidencias',
  'LBL_LIST_LAST_MODIFIED' => 'Modificado',
  'LBL_LIST_MY_BUGS' => 'Mis Incidencias Asignadas',
  'LBL_LIST_NUMBER' => 'Núm.',
  'LBL_LIST_PHONE' => 'Teléfono',
  'LBL_LIST_PRIORITY' => 'Prioridad',
  'LBL_LIST_RELEASE' => 'Publicación',
  'LBL_LIST_RESOLUTION' => 'Resolución',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUBJECT' => 'Asunto',
  'LBL_LIST_TYPE' => 'Tipo',
  'LBL_MODIFIED_BY' => 'Modificado por:',
  'LBL_MODULE_ID' => 'Incidencias',
  'LBL_MODULE_NAME' => 'Incidencias',
  'LBL_MODULE_NAME_SINGULAR' => 'Incidencia:',
  'LBL_MODULE_TITLE' => 'Seguimiento de Incidencias: Inicio',
  'LBL_NEW_FORM_TITLE' => 'Nueva Incidencia',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_NUMBER' => 'Número:',
  'LBL_PORTAL_TOUR_RECORDS_CREATE' => 'Si tiene una nueva Incidencia que le gustaría notificar, puede hacer clic aquí para enviarlo.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER' => 'Puede filtrar por la lista de incidencias introduciendo un término de búsqueda.',
  'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE' => 'Por ejemplo, puede usarlo para encontrar una incidencia que ha sido notificada anteriormente.',
  'LBL_PORTAL_TOUR_RECORDS_INTRO' => 'El módulo de Incidencias es para la gestión y notificación de incidencias. Utiliza las flechas más abajo para una visita rápida.',
  'LBL_PORTAL_TOUR_RECORDS_PAGE' => 'Esta página muestra la lista de Incidencias publicadas.',
  'LBL_PORTAL_TOUR_RECORDS_RETURN' => 'Haga clic aquí para volver a esta vista en cualquier momento.',
  'LBL_PORTAL_VIEWABLE' => 'Visible en portal',
  'LBL_PRIORITY' => 'Prioridad:',
  'LBL_PRODUCT_CATEGORY' => 'Categoría:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_RELEASE' => 'Publicación:',
  'LBL_RESOLUTION' => 'Resolución:',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Incidencias',
  'LBL_SHOW_IN_PORTAL' => 'Mostrar en el Portal',
  'LBL_SHOW_MORE' => 'Mostrar más Incidencias',
  'LBL_SOURCE' => 'Fuente:',
  'LBL_STATUS' => 'Estado:',
  'LBL_SUBJECT' => 'Asunto:',
  'LBL_SYSTEM_ID' => 'ID Sistema',
  'LBL_TYPE' => 'Tipo:',
  'LBL_WORK_LOG' => 'Registro de Actividad:',
  'LNK_BUG_LIST' => 'Ver Incidencias',
  'LNK_BUG_REPORTS' => 'Ver Informes de Incidencias',
  'LNK_CREATE' => 'Informe de Incidencia',
  'LNK_CREATE_WHEN_EMPTY' => 'Informar de un Error ahora.',
  'LNK_IMPORT_BUGS' => 'Importаr Incidencias',
  'LNK_NEW_BUG' => 'Informe de Incidencia',
  'NTC_DELETE_CONFIRMATION' => '¿Está seguro de que desea quitar este contacto de esta incidencia?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => '¿Está seguro de que desea mover esta incidencia fuera de esta cuenta?',
  'NTC_REMOVE_INVITEE' => '¿Está seguro de que desea quitar este contacto de la incidencia?',
);

