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
  'ERR_DELETE_RECORD' => 'Debe especificar un número de registro para eliminar el producto.',
  'LBL_ACCOUNT_ID' => 'ID Cuenta',
  'LBL_ACCOUNT_NAME' => 'Nombre de Cuenta:',
  'LBL_ASSET_NUMBER' => 'Número de Activo:',
  'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
  'LBL_ASSIGNED_USER_ID' => 'ID de Usuario Asignado',
  'LBL_ASSOCIATED_QUOTE' => 'Asunto de la Oferta:',
  'LBL_BOOK_VALUE' => 'Valor Contable:',
  'LBL_BOOK_VALUE_DATE' => 'Fecha del Valor Contable:',
  'LBL_BOOK_VALUE_USDOLLAR' => 'Valor Contable (Dólares EEUU):',
  'LBL_CALCULATED_LINE_ITEM_AMOUNT' => 'Total Calculado de la Línea Presupuestada',
  'LBL_CAMPAIGN_PRODUCT' => 'Partida de Campaña Cotizada',
  'LBL_CATEGORY' => 'Categoría:',
  'LBL_CATEGORY_NAME' => 'Nombre de Categoría:',
  'LBL_COMMIT_STAGE' => 'Fase de Compromiso',
  'LBL_COMMIT_STAGE_FORECAST' => 'Previsión',
  'LBL_CONTACT' => 'Contacto',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CONTACT_ID' => 'ID Contacto',
  'LBL_CONTACT_NAME' => 'Nombre de Contacto:',
  'LBL_CONTRACTS' => 'Contratos',
  'LBL_CONTRACTS_SUBPANEL_TITLE' => 'Contratos',
  'LBL_CONVERT_TO_QUOTE_ERROR' => 'Error:',
  'LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE' => 'Hubo un error convirtiendo esta Línea en un Presupuesto',
  'LBL_COST_PRICE' => 'Coste:',
  'LBL_COST_USDOLLAR' => 'Coste (Dólares EEUU)',
  'LBL_CREATED_USER' => 'Usuario Creado',
  'LBL_CURRENCY' => 'Moneda:',
  'LBL_CURRENCY_ID' => 'ID de Moneda',
  'LBL_CURRENCY_RATE' => 'Tipo de Cambio',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Nombre del Símbolo de Moneda',
  'LBL_DATE_CLOSED' => 'Fecha de Cierre Prevista',
  'LBL_DATE_CLOSED_TIMESTAMP' => 'Fecha Prevista de Cierre Timestamp',
  'LBL_DATE_PURCHASED' => 'Comprado:',
  'LBL_DATE_SUPPORT_EXPIRES' => 'Caducidad del Soporte:',
  'LBL_DATE_SUPPORT_STARTS' => 'Inicio del Soporte:',
  'LBL_DEAL_TOT' => 'Descuento:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Productos',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DISCOUNT_AMOUNT' => 'Cantidad Descontada',
  'LBL_DISCOUNT_AS_PERCENT' => 'Descuento en %',
  'LBL_DISCOUNT_PRICE' => 'Precio Unitario:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Fecha de Precio con Descuento:',
  'LBL_DISCOUNT_RATE' => 'Tarifa de Descuento',
  'LBL_DISCOUNT_RATE_USDOLLAR' => 'Tarifa de Descuento (Dólares EEUU)',
  'LBL_DISCOUNT_TOTAL' => 'Descuento Total',
  'LBL_DISCOUNT_TOTAL_USDOLLAR' => 'Descuento (Dólares EEUU)',
  'LBL_DISCOUNT_USDOLLAR' => 'Precio Unitario (Dólares EEUU)',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_EDITLAYOUT' => 'Editar Diseño',
  'LBL_EXPERT_ID' => 'Especialista de Producto',
  'LBL_EXPORT_CURRENCY_ID' => 'ID Moneda',
  'LBL_EXT_PRICE' => 'Precio Ext.',
  'LBL_FORECAST' => 'Incluido en Previsión',
  'LBL_HELP_CREATE' => 'El módulo {{plural_module_name}} se compone de todos los elementos de las líneas de producto de las cotizaciones de las ventas actuales y pasadas. Los registros de {{module_name}} son automáticamente creados desde el módulo {{quotes_module}} pero también pueden ser creados directamente desde el módulo {{plural_module_name}} sí lo desea. 

Para crear un {{module_name}}:
1. Proporcione valores para los campos que desee.
* Los campos marcados "Obligatorio" se deben completar antes de guardar.
* Haga clic en "Mostrar más" para ver los campos adicionales si es necesario.
2. Haga clic en "Guardar" para finalizar el nuevo registro y volver a la vista en lista de {{plural_module_name}} .
* Seleccione la opción "Guardar y ver" para abrir el nuevo {{module_name}} como vista de registro.
* Seleccione la opción "Guardar y crear nuevo" para un nuevo {{module_name}} inmediatamente.',
  'LBL_HELP_RECORD' => 'El módulo {{plural_module_name}} consiste en todos los productos que han sido vendidos o están en proceso de venta a clientes.

- Edita el registro haciendo clic en el campo individual o el botón Editar. 
- Ver o modificar enlaces a otros registros en los subpanales yendo a la pestaña "Ver Datos".
- Comentar o ver otros comentarios de usuarios y ver el historial del registro en {{activitystream_singular_module}} yendo a "Actividades Recientes".
- Seguir o guardar como favorito el registro utilizando los iconos a la izquierda del nombre del registro. 
- Acciones adicionales están disponibles en el botón desplegable Acciones.',
  'LBL_HELP_RECORDS' => 'El módulo {{plural_module_name}} se compone de todos los productos que ya han sido vendidos o están en proceso de venta a los clientes. El listado de los productos vendidos por la empresa se encuentra en Admin > Catálogo de Producto y los administradores tienen la capacidad de añadir productos según sea necesario. Cuando se crean {{plural_module_name}}, tiene la opción de seleccionar productos del catálogo o crear nuevos productos a través del módulo {{plural_module_name}} . Hay varias formas de crear {{plural_module_name}} en Sugar como a través del módulo {{plural_module_name}}, módulo {{quotes_module}}, duplicando, importando {{plural_module_name}}, etc. Una vez el registro {{module_name}} se ha creado, usted podrá ver y editar la información relacionada con el {{module_name}} a través de la vista del registro {{plural_module_name}} .',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciales',
  'LBL_LEAD_SOURCE' => 'Origen de Lead',
  'LBL_LIST_ACCOUNT_NAME' => 'Nombre de Cuenta',
  'LBL_LIST_CONTACT_NAME' => 'Nombre de Contacto',
  'LBL_LIST_COST_PRICE' => 'Coste',
  'LBL_LIST_DATE_PURCHASED' => 'Comprado',
  'LBL_LIST_DISCOUNT_PRICE' => 'Precio',
  'LBL_LIST_FORM_TITLE' => 'Lista de Productos',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Nº Pieza',
  'LBL_LIST_LIST_PRICE' => 'Precio de Lista',
  'LBL_LIST_MANUFACTURER' => 'Proveedor',
  'LBL_LIST_NAME' => 'Línea de Presupuesto',
  'LBL_LIST_PRICE' => 'Precio de Lista:',
  'LBL_LIST_QUANTITY' => 'Cantidad',
  'LBL_LIST_QUOTE_NAME' => 'Nombre de Presupuesto',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LIST_SUPPORT_EXPIRES' => 'Caduca',
  'LBL_LIST_USDOLLAR' => 'Precio de Lista (Dólares EEUU)',
  'LBL_MANUFACTURER' => 'Fabricante:',
  'LBL_MANUFACTURERS' => 'Fabricantes',
  'LBL_MANUFACTURER_NAME' => 'Nombre del Proveedor:',
  'LBL_MEMBER_OF' => 'Miembro de:',
  'LBL_MFT_PART_NUM' => 'Número de Parte del Fabricante:',
  'LBL_MODIFIED_USER' => 'Usuario Modificado',
  'LBL_MODULE_NAME' => 'Líneas de Presupuestos',
  'LBL_MODULE_NAME_SINGULAR' => 'Línea de Presupuesto',
  'LBL_MODULE_TITLE' => 'Líneas de Presupuesto: Hogar',
  'LBL_NAME' => 'Nombre',
  'LBL_NEW_FORM_TITLE' => 'Crear Producto',
  'LBL_NEXT_STEP' => 'Siguiente paso:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Notas',
  'LBL_OPPORTUNITY' => 'Oportunidad',
  'LBL_OPPORTUNITY_ID' => 'ID de Oportunidad',
  'LBL_PRICING_FACTOR' => 'Factor de Valoración',
  'LBL_PRICING_FORMULA' => 'Fórmula de Valoración:',
  'LBL_PROBABILITY' => 'Probabilidad (%):',
  'LBL_PRODUCT' => 'Línea de Presupuesto',
  'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Línea de Presupuestos',
  'LBL_PRODUCT_CATEGORIES' => 'Categorías de Productos',
  'LBL_PRODUCT_TEMPLATE' => 'Plantilla de Producto:',
  'LBL_PRODUCT_TEMPLATE_ID' => 'ID Plantilla de Producto:',
  'LBL_PRODUCT_TYPES' => 'Tipos de Productos',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_QUANTITY' => 'Cantidad:',
  'LBL_QUOTE' => 'Presupuesto',
  'LBL_QUOTES_SUBPANEL_TITLE' => 'Presupuestos',
  'LBL_QUOTE_ID' => 'ID Presupuesto',
  'LBL_QUOTE_NAME' => 'Nombre de Presupuesto:',
  'LBL_RELATED_PRODUCTS' => 'Líneas de la Oferta',
  'LBL_RELATED_PRODUCTS_TITLE' => 'Línea de Presupuestos',
  'LBL_REVENUELINEITEM' => 'Línea de Ingreso',
  'LBL_REVENUELINEITEMS' => 'Línea de Ingreso',
  'LBL_REVENUELINEITEM_ID' => 'ID de Línea de Ingreso',
  'LBL_REVENUELINEITEM_NAME' => 'Nombre de la Línea de Ingreso:',
  'LBL_SALES_STAGE' => 'Etapa de Venta',
  'LBL_SALES_STATUS' => 'Estado del Ingreso',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Productos',
  'LBL_SELECT_DISCOUNT' => '% de Descuento',
  'LBL_SERIAL_NUMBER' => 'Número de Serie:',
  'LBL_STATUS' => 'Estado:',
  'LBL_SUPPORT_CONTACT' => 'Contacto del Soporte:',
  'LBL_SUPPORT_DESCRIPTION' => 'Desc. del Soporte:',
  'LBL_SUPPORT_NAME' => 'Título del Soporte:',
  'LBL_SUPPORT_TERM' => 'Término del Soporte:',
  'LBL_TAX_CLASS' => 'Tipo de Impuesto:',
  'LBL_TYPE' => 'Tipo:',
  'LBL_URL' => 'URL Producto:',
  'LBL_VENDOR_PART_NUM' => 'Número de Parte del Vendedor:',
  'LBL_WEBSITE' => 'Sitio Web',
  'LBL_WEIGHT' => 'Peso:',
  'LNK_IMPORT_PRODUCTS' => 'Importar Productos',
  'LNK_NEW_PRODUCT' => 'Crear Producto',
  'LNK_PRODUCT_LIST' => 'Ver Productos',
  'NTC_DELETE_CONFIRMATION' => '¿Está seguro de que desea eliminar este registro?',
  'NTC_REMOVE_CONFIRMATION' => '¿Está seguro de que desea quitar la relación del producto?',
);

