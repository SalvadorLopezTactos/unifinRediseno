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
  'LABEL_PANEL_ASSIGNMENT' => 'Asignación',
  'LBL_ACCOUNT_ID' => 'ID de Cuenta',
  'LBL_ACCOUNT_NAME' => 'Cuenta:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_ASSIGNED_TO_ID' => 'Usuario Asignado:',
  'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
  'LBL_CAMPAIGN' => 'Campaña:',
  'LBL_CAMPAIGN_LINK' => 'Enlace a Campaña',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Campañas',
  'LBL_CLOSED_RLIS' => '# de Cerradas de Ganancia de Artículo',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Oportunidades Ganadas',
  'LBL_COMMITTED' => 'Comprometido',
  'LBL_COMMIT_STAGE' => 'Fase de Compromiso',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Correos Electrónicos de contactos relacionados',
  'LBL_CONTRACTS' => 'Contratos',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Contratos',
  'LBL_CREATED_ID' => 'Creada por ID',
  'LBL_CREATED_USER' => 'Usuario Creado',
  'LBL_CURRENCIES' => 'Monedas',
  'LBL_CURRENCY' => 'Moneda:',
  'LBL_CURRENCY_ID' => 'ID de Moneda',
  'LBL_CURRENCY_NAME' => 'Nombre de Moneda',
  'LBL_CURRENCY_RATE' => 'Tipo de Cambio',
  'LBL_CURRENCY_SYMBOL' => 'Símbolo de Moneda',
  'LBL_DATE_CLOSED' => 'Fecha Esperada de Cierre:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Fecha Esperada de Cierre Timestamp',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Oportunidades',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_DUPLICATE' => 'Posible oportunidad duplicada',
  'LBL_EDITLAYOUT' => 'Editar diseño',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID de Usuario Asignado',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Usuario Asignado',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Id de campaña',
  'LBL_EXPORT_CREATED_BY' => 'Creado por ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificador por ID',
  'LBL_EXPORT_NAME' => 'Nombre',
  'LBL_FILENAME' => 'Archivo Adjunto',
  'LBL_FORECAST' => 'Incluido en Presupuesto',
  'LBL_HELP_CREATE' => 'El módulo {{plural_module_name}}permite realizar un seguimiento de ventas individuales y los elementos de línea pertenecientes a esas ventas de principio a fin. Cada registro {{module_name}} representa una cabecera de un grupo de {{revenuelineitems_module}} así como en relación con otros registros importantes como {{quotes_module}}, {{contacts_module}}, etc.

Para crear un {{module_name}}:
1.Proporcione valores para los campos como se desee. 
  - Los campos marcados "Obligatorio" debe ser completado antes de guardar. 
  - Haga clic en "Mostrar más" para exponer campos adicionales si es necesario. 
2. Haga clic en "Guardar" para finalizar el nuevo disco y volver a la página anterior. 
  - Seleccione la opción "Guardar y ver" para abrir el nuevo {{module_name}} de vista de registro.
 -Seleccione la opción "Guardar y crear nuevo" para crear inmediatamente otra nueva {{module_name}}. 
3. Después de guardar, usar el{{revenuelineitems_module}}subpanel para agregar elementos de línea a la {{module_name}}.',
  'LBL_HELP_RECORD' => 'El módulo {{plural_module_name}} permite realizar un seguimiento de ventas individuales y los elementos de línea pertenecientes a esas ventas de principio a fin. Cada registro {{module_name}} representa una cabecera de un grupo de {{revenuelineitems_module}}así como en relación con otros registros importantes como {{quotes_module}}, {{contacts_module}}, etc.

-Edite los campos de este registro, haga clic en un campo individual o en el botón Modificar. 
- Ver o modificar enlaces a otros registros en los subpaneles, incluyendo {{revenuelineitems_module}},moviendo el panel inferior izquierdo para "Data View". 
- Hacer y ver los comentarios de los usuarios y el cambio en el registro de la historia {{activitystream_singular_module}} moviendo el panel inferior izquierdo para "Últimas acciones". 
- Siga o favorito este registro utilizando los iconos a la derecha del nombre del registro. 
- Las acciones adicionales se encuentran disponibles en el menú Acciones desplegables a la derecha del botón Editar.',
  'LBL_HELP_RECORDS' => 'El módulo {{plural_module_name}} permite realizar un seguimiento de ventas individuales y los elementos de línea pertenecientes a esas ventas de principio a fin. Cada registro {{module_name}} representa una cabecera de un grupo de {{revenuelineitems_module}} así como en relación con otros registros importantes como {{quotes_module}}, {{contacts_module}}, etc. Cada {{revenuelineitems_singular_module}} es la posible venta de un producto en particular e incluye los datos de venta correspondientes. Cada {{revenuelineitems_singular_module}}típicamente progresar a través de varias fases de ventas hasta que se marque bien "Cerrada Ganada" o "Cerrada Perdida". El registro {{module_name}} refleja la cantidad y la fecha de cierre prevista para su {{revenuelineitems_module}}. {{plural_module_name}} y {{revenuelineitems_module}} se puede aprovechar aún más mediante el uso del módulo de Sugar {{forecasts_singular_module}} para entender y predecir las tendencias de ventas, así como el trabajo de enfoque para lograr cuotas de ventas.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
  'LBL_INVITEE' => 'Contactos',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciales',
  'LBL_LEAD_SOURCE' => 'Toma de Contacto:',
  'LBL_LIST_ACCOUNT_NAME' => 'Cuenta',
  'LBL_LIST_AMOUNT' => 'Probablemente',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Cantidad',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_DATE_CLOSED' => 'Fecha Esperada de Cierre',
  'LBL_LIST_FORM_TITLE' => 'Lista de Oportunidades',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Nombre',
  'LBL_LIST_SALES_STAGE' => 'Etapa de Ventas',
  'LBL_MKTO_ID' => 'Marketo ID de Prospecto',
  'LBL_MKTO_SYNC' => 'Sincronizar a  Marketo®',
  'LBL_MODIFIED_ID' => 'Modificada por ID',
  'LBL_MODIFIED_NAME' => 'Modificada por Usuario',
  'LBL_MODIFIED_USER' => 'Usuario Modificado',
  'LBL_MODULE_NAME' => 'Oportunidades',
  'LBL_MODULE_NAME_SINGULAR' => 'Oportunidad',
  'LBL_MODULE_TITLE' => 'Oportunidades: Inicio',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Mis Oportunidades Cerradas',
  'LBL_NAME' => 'Nombre Oportunidad',
  'LBL_NEW_FORM_TITLE' => 'Nueva Oportunidad',
  'LBL_NEXT_STEP' => 'Próximo Paso:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_OPPORTUNITY' => 'Oportunidad:',
  'LBL_OPPORTUNITY_NAME' => 'Nombre Oportunidad:',
  'LBL_OPPORTUNITY_ROLE' => 'Rol en Oportunidad',
  'LBL_OPPORTUNITY_TYPE' => 'Tipo de Oportunidad',
  'LBL_PIPELINE_TOTAL_IS' => 'Embudo de Ventas Total es',
  'LBL_PRIMARY_QUOTE_ID' => 'Presupuesto Principal',
  'LBL_PROBABILITY' => 'Probabilidad (%):',
  'LBL_PRODUCTS' => 'Productos',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Artículos Cotizados',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Cotizaciones',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Cotizaciones',
  'LBL_RAW_AMOUNT' => 'Importe Bruto',
  'LBL_RLI' => 'Ganancia de Artículo',
  'LBL_RLI_SUBPANEL_TITLE' => 'Ganancia de Artículo',
  'LBL_SALES_STAGE' => 'Etapa de Ventas:',
  'LBL_SALES_STATUS' => 'Estado',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Oportunidades',
  'LBL_TEAM_ID' => 'ID de Equipo',
  'LBL_TIMEPERIODS' => 'Periodos de Tiempo',
  'LBL_TIMEPERIOD_ID' => 'Periodo de tiempo',
  'LBL_TOP_OPPORTUNITIES' => 'Mis Principales Oportunidades',
  'LBL_TOTAL_OPPORTUNITIES' => 'Oportunidades Totales',
  'LBL_TOTAL_RLIS' => '# del Total de Ganancia de Artículo',
  'LBL_TYPE' => 'Tipo:',
  'LBL_VIEW_FORM_TITLE' => 'Vista de Oportunidades',
  'LBL_WORKSHEET' => 'Hoja de Trabajo',
  'LNK_CREATE' => 'Crear Negocio',
  'LNK_IMPORT_OPPORTUNITIES' => 'Importar Oportunidades',
  'LNK_NEW_OPPORTUNITY' => 'Nueva Oportunidad',
  'LNK_OPPORTUNITY_LIST' => 'Ver Oportunidades',
  'LNK_OPPORTUNITY_REPORTS' => 'Ver Informes de Oportunidades',
  'MSG_DUPLICATE' => 'El registro para la oportunidad que va a crear podría ser un duplicado de otro registro de oportunidad existente. Los registros de oportunidad con nombres similares se listan a continuación.<br>Haga clic en Guardar para continuar con la creación de esta oportunidad, o en Cancelar para volver al módulo sin crear la oportunidad.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'No puede eliminar Oportunidades que contienen cerradas de Ganancia de Artículo',
  'NTC_REMOVE_OPP_CONFIRMATION' => '¿Está seguro de que desea eliminar este contacto de la oportunidad?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => '¿Está seguro de que desea eliminar esta oportunidad del proyecto?',
  'TPL_RLI_CREATE' => 'Una oportunidad debe estar asociada con la Ganancia de Artículo. <a href="javascript:void(0);" id="createRLI">Crear Ganancia de Artículo</a>.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Crear una ganancia de articulo',
  'UPDATE' => 'Oportunidad - Actualizar Moneda',
  'UPDATE_BUGFOUND_COUNT' => 'Problemas detectados:',
  'UPDATE_BUG_COUNT' => 'Problemas detectados cuya resolución se ha intentado:',
  'UPDATE_COUNT' => 'Registros actualizados:',
  'UPDATE_CREATE_CURRENCY' => 'Creación de nueva moneda:',
  'UPDATE_DOLLARAMOUNTS' => 'Actualizar Cantidades en Dólares EEUU',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Actualiza las cantidades en Dólares EEUU para las oportunidades basadas en el conjunto actual de cambios de moneda. Este valor se usa para calcular gráficas y vistas de listas de cantidades monetarias.',
  'UPDATE_DONE' => 'Hecho',
  'UPDATE_FAIL' => 'No ha podido actualizarse -',
  'UPDATE_FIX' => 'Corregir Cantidades',
  'UPDATE_FIX_TXT' => 'Intenta corregir cualquier cantidad no válida creando un número decimal válido a partir de la cantidad actual. Antes realiza una copia de seguridad de todas las cantidades modificadas en el campo de base de datos amount_backup. Si tras la correción detecta problemas, no vuelva a realizar esta operación sin restaurar los valores previos desde la copia de seguridad ya que si no sobrescribirá la copia de seguridad con nuevos datos no válidos.',
  'UPDATE_INCLUDE_CLOSE' => 'Registros cerrados incluidos',
  'UPDATE_MERGE' => 'Unificar Monedas',
  'UPDATE_MERGE_TXT' => 'Unifica múltiples monedas en una única moneda. Si detecta que hay múltiples registros de tipo moneda para la misma moneda, puede unificarlas. Esto también unificará las monedas para el resto de módulos.',
  'UPDATE_NULL_VALUE' => 'La cantidad es NULL, estableciéndola a 0 -',
  'UPDATE_RESTORE' => 'Restaurar Cantidades',
  'UPDATE_RESTORE_COUNT' => 'Registros con cantidades restauradas:',
  'UPDATE_RESTORE_TXT' => 'Restaura los valores de las cantidades desde la copia de seguridad creada durante la corrección.',
  'UPDATE_VERIFY' => 'Verificar Cantidades',
  'UPDATE_VERIFY_CURAMOUNT' => 'Cantidad actual:',
  'UPDATE_VERIFY_FAIL' => 'Fallo de verificación de registro:',
  'UPDATE_VERIFY_FIX' => 'La corrección daría',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nueva cantidad:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nueva moneda:',
  'UPDATE_VERIFY_TXT' => 'Verifica que los valores de las cantidades en las oportunidades son números decimales válidos con sólo caracteres numéricos (0-9) y decimales(.)',
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Uno o más de los registros seleccionados contiene cerradas de Ganancia de Artículo y no se puede eliminar.',
);

