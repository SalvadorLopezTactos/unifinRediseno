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
  'LBL_CLOSED_RLIS' => 'nº de Líneas de Ingreso Cerradas',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Oportunidades Ganadas',
  'LBL_COMMITTED' => 'Objectivo Alcanzado',
  'LBL_COMMIT_STAGE' => 'Fase de Compromiso',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Emails de contactos relacionados',
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
  'LBL_DATE_CLOSED' => 'Fecha de cierre:',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Fecha Prevista de Cierre Timestamp',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Oportunidades',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_DUPLICATE' => 'Posible oportunidad duplicada',
  'LBL_EDITLAYOUT' => 'Editar diseño',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID Usuario asignado',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Usuario asignado',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Id de campaña',
  'LBL_EXPORT_CREATED_BY' => 'Creado por ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificador por ID',
  'LBL_EXPORT_NAME' => 'Nombre',
  'LBL_FILENAME' => 'Adjunto',
  'LBL_FORECAST' => 'Incluido en Previsión',
  'LBL_HELP_CREATE' => 'El módulo {{plural_module_name}} permite realizar un seguimiento de ventas individuales de principio a fin y puede utilizarse en el módulo de {{forecasts_module}} para entender las tendencias de ventas y objetivos de ventas alcanzados. 

Para crear un {{module_name}}:
1. Proporcione valores para los campos que desee.
 * Los campos marcados "Obligatorio" se deben completar antes de guardar.
 * Haga clic en "Mostrar más" para ver los campos adicionales si es necesario.
2. Haga clic en "Guardar" para finalizar el nuevo registro y volver a la vista en lista de {{plural_module_name}} .
 * Seleccione la opción "Guardar y ver" para abrir el nuevo {{module_name}} en vista de registro.
 * Seleccione la opción "Guardar y crear nuevo" para un nuevo {{module_name}} inmediatamente.',
  'LBL_HELP_RECORD' => 'El módulo {{plural_module_name}} permite hacer seguimiento de ventas individuales y lineas de ingreso que pertenecen a las ventas desde el principio hasta el final. Cada registro {{module_name}} representa la cabecera del grupo de {{revenuelineitems_module}} y también relacionándose con otros registros importantes como {{quotes_module}}, {{contacts_module}}, etc. 

- Edita el registro haciendo clic en el campo individual o el botón Editar. 
- Ver o modificar enlaces a otros registros en los subpanales, incluyendo {{revenuelineitems_module}} yendo a la pestaña "Ver Datos".
- Comentar o ver otros comentarios de usuarios y ver el historial del registro en {{activitystream_singular_module}} yendo a "Actividades Recientes".
- Seguir o guardar como favorito el registro utilizando los iconos a la izquierda del nombre del registro. 
- Acciones adicionales están disponibles en el botón desplegable Acciones.',
  'LBL_HELP_RECORDS' => 'El módulo {{plural_module_name}} le permite realizar un seguimiento de ventas individuales y las línea relacionadas a esas ventas de principio a fin. Cada {{revenuelineitem_module}} es la venta potencial de un producto en particular e incluye los datos de venta correspondientes. Cada {{revenuelineitem_module}} generalmente progresará a través de varias fases de venta hasta que se marque bien "Cerrado Ganado" o "Cerrado Perdido". El registro {{module_name}} refleja la cantidad y la fecha de cierre prevista de su {{revenuelineitems_module}}. {{plural_module_name}} y {{revenuelineitems_module}} pueden ser más aprovechados utilizando el módulo  {{forecast_module}} de Sugar, para entender y predecir las tendencias en ventas, así como el poner foco en el trabajo para alcanzar los objetivos comerciales.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
  'LBL_INVITEE' => 'Contactos',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciales',
  'LBL_LEAD_SOURCE' => 'Toma de contacto:',
  'LBL_LIST_ACCOUNT_NAME' => 'Cuenta',
  'LBL_LIST_AMOUNT' => 'Probable',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Cantidad',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_DATE_CLOSED' => 'Fecha Cierre',
  'LBL_LIST_FORM_TITLE' => 'Lista de Oportunidades',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Nombre',
  'LBL_LIST_SALES_STAGE' => 'Etapa de Ventas',
  'LBL_MKTO_ID' => 'ID del Lead de Marketo',
  'LBL_MKTO_SYNC' => 'Sincronización con Marketo&reg;',
  'LBL_MODIFIED_ID' => 'Modificada por ID',
  'LBL_MODIFIED_NAME' => 'Modificada por Usuario',
  'LBL_MODIFIED_USER' => 'Usuario Modificado',
  'LBL_MODULE_NAME' => 'Oportunidades',
  'LBL_MODULE_NAME_SINGULAR' => 'Oportunidad',
  'LBL_MODULE_TITLE' => 'Oportunidades: Inicio',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Mis Oportunidades Cerradas',
  'LBL_NAME' => 'Nombre Oportunidad',
  'LBL_NEW_FORM_TITLE' => 'Nueva Oportunidad',
  'LBL_NEXT_STEP' => 'Próximo paso:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_OPPORTUNITY' => 'Oportunidad:',
  'LBL_OPPORTUNITY_NAME' => 'Nombre Oportunidad:',
  'LBL_OPPORTUNITY_ROLE' => 'Rol en Oportunidad',
  'LBL_OPPORTUNITY_TYPE' => 'Tipo de oportunidad',
  'LBL_PIPELINE_TOTAL_IS' => 'Total de Pipeline es',
  'LBL_PRIMARY_QUOTE_ID' => 'Presupuesto Principal',
  'LBL_PROBABILITY' => 'Probabilidad (%):',
  'LBL_PRODUCTS' => 'Productos',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Línea de la Oferta',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Presupuestos',
  'LBL_QUOTE_SUBPANEL_TITLE' => 'Presupuestos',
  'LBL_RAW_AMOUNT' => 'Importe Bruto',
  'LBL_RLI' => 'Línea de Ingreso',
  'LBL_RLI_SUBPANEL_TITLE' => 'Líneas de Ingreso',
  'LBL_SALES_STAGE' => 'Etapa de ventas:',
  'LBL_SALES_STATUS' => 'Estado',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Oportunidades',
  'LBL_TEAM_ID' => 'ID Equipo',
  'LBL_TIMEPERIODS' => 'Periodos de Tiempo',
  'LBL_TIMEPERIOD_ID' => 'Periodo de tiempo',
  'LBL_TOP_OPPORTUNITIES' => 'Mis Principales Oportunidades',
  'LBL_TOTAL_OPPORTUNITIES' => 'Oportunidades Totales',
  'LBL_TOTAL_RLIS' => 'nº Total de Líneas de Ingreso',
  'LBL_TYPE' => 'Tipo:',
  'LBL_VIEW_FORM_TITLE' => 'Vista de Oportunidades',
  'LBL_WORKSHEET' => 'Hoja de Trabajo',
  'LNK_CREATE' => 'Nueva Venta',
  'LNK_IMPORT_OPPORTUNITIES' => 'Importar Oportunidades',
  'LNK_NEW_OPPORTUNITY' => 'Nueva Oportunidad',
  'LNK_OPPORTUNITY_LIST' => 'Ver Oportunidades',
  'LNK_OPPORTUNITY_REPORTS' => 'Ver Informes de Oportunidades',
  'MSG_DUPLICATE' => 'El registro para la oportunidad que va a crear podría ser un duplicado de otro registro de oportunidad existente. Los registros de oportunidad con nombres similares se listan a continuación.<br>Haga clic en Guardar para continuar con la creación de esta oportunidad, o en Cancelar para volver al módulo sin crear la oportunidad.',
  'NOTICE_NO_DELETE_CLOSED_RLIS' => 'No puede eliminar Oportunidades que contienen Líneas de Ingreso cerradas',
  'NTC_REMOVE_OPP_CONFIRMATION' => '¿Está seguro de que desea eliminar este contacto de la oportunidad?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => '¿Está seguro de que desea eliminar esta oportunidad del proyecto?',
  'TPL_RLI_CREATE' => 'Una oportunidad debe tener una Línea de Ingreso asociada. <a href="javascript:void(0);" id="createRLI">Crear una nueva Línea de Ingreso</a>.',
  'TPL_RLI_CREATE_LINK_TEXT' => 'Crear una línea de ingreso',
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
  'WARNING_NO_DELETE_CLOSED_SELECTED' => 'Uno o más de los registros seleccionados contienen Líneas de Ingreso cerradas y no pueden ser eliminados.',
);

