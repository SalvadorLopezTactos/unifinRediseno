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
  'ERR_DELETE_EMPTY' => 'El registro ha sido borrado o no existe.',
  'ERR_DELETE_RECORD' => 'Un número de registro debe ser especificado para borrar el registro.',
  'LBL_ALERT_TEMPLATES' => 'Plantillas de Alerta',
  'LBL_APOSTROPHE_S' => '&#39;s',
  'LBL_COMPARE_ANY_TIME_PART2' => 'no cambia durante',
  'LBL_COMPARE_ANY_TIME_PART3' => 'período especificado de tiempo',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'El campo no cambia durante un período determinado de tiempo',
  'LBL_COMPARE_CHANGE_PART' => 'cambios',
  'LBL_COMPARE_CHANGE_TITLE' => 'Cuando un campo en el módulo objetivo cambia',
  'LBL_COMPARE_COUNT_TITLE' => 'Disparar al alcanzar una cuenta específica',
  'LBL_COMPARE_SPECIFIC_PART' => 'cambia a o de un valor especificado',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Cuando un campo en el módulo objetivo cambia a o de un valor especificado',
  'LBL_COUNT_TRIGGER1' => 'Total',
  'LBL_COUNT_TRIGGER1_2' => 'se compara a esta cantidad',
  'LBL_COUNT_TRIGGER2' => 'filtrar por relación',
  'LBL_COUNT_TRIGGER2_2' => 'sólo',
  'LBL_COUNT_TRIGGER3' => 'filtrar específicamente por',
  'LBL_COUNT_TRIGGER4' => 'filtrar por un segundo',
  'LBL_EVAL' => 'Evaluación del Disparador:',
  'LBL_FIELD' => 'campo',
  'LBL_FILTER_FIELD_PART1' => 'Filtrar por',
  'LBL_FILTER_FIELD_TITLE' => 'Cuando un campo en el módulo objetivo contiene un valor especificado',
  'LBL_FILTER_FORM_TITLE' => 'Definir una Condición del Flujo de Actividad',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtar objetos basándose en lo siguiente:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Especificar relación',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Cuando el módulo objetivo cambia y un campo en el módulo relacionado contiene un valor específico',
  'LBL_FUTURE_TRIGGER' => 'Especificar nuevo',
  'LBL_LIST_EVAL' => 'Eval:',
  'LBL_LIST_FIELD' => 'Campo:',
  'LBL_LIST_FORM_TITLE' => 'Lista de Disparadores',
  'LBL_LIST_FRAME_PRI' => 'Disparador:',
  'LBL_LIST_FRAME_SEC' => 'Filtro:',
  'LBL_LIST_NAME' => 'Descripción:',
  'LBL_LIST_STATEMEMT' => 'Disparar un evento basándose en lo siguiente:',
  'LBL_LIST_TYPE' => 'Tipo:',
  'LBL_LIST_VALUE' => 'Valor:',
  'LBL_MODULE' => 'módulo',
  'LBL_MODULE_NAME' => 'Condiciones',
  'LBL_MODULE_NAME_SINGULAR' => 'Condición',
  'LBL_MODULE_SECTION_TITLE' => 'Cuando se cumplan estas condiciones',
  'LBL_MODULE_TITLE' => 'Disparadores de Flujo de Actividad: Inicio',
  'LBL_MUST_SELECT_VALUE' => 'Debe seleccionar un valor para este campo',
  'LBL_NAME' => 'Nombre del Disparador:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Crear Filtro',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Crear Filtro',
  'LBL_NEW_FORM_TITLE' => 'Nuevo Disparadores',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Crear Disparador',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Crear Disparador',
  'LBL_PAST_TRIGGER' => 'Especificar viejo',
  'LBL_RECORD' => 'del módulo',
  'LBL_SEARCH_FORM_TITLE' => 'Lista de Disparadores de Flujo de Actividad',
  'LBL_SELECT_1ST_FILTER' => 'Debe seleccionar un campo válido como 1er. filtro',
  'LBL_SELECT_2ND_FILTER' => 'Debe seleccionar un campo válido como 2do. filtro',
  'LBL_SELECT_AMOUNT' => 'Debe seleccionar la cantidad',
  'LBL_SELECT_OPTION' => 'Por favor, seleccione una opción.',
  'LBL_SELECT_TARGET_FIELD' => 'Por favor, seleccione un campo de destino.',
  'LBL_SELECT_TARGET_MOD' => 'Por favor, seleccione un módulo relacionado de destino.',
  'LBL_SHOW' => 'Mostrar',
  'LBL_SHOW_PAST' => 'Modificar Valor Anterior:',
  'LBL_SPECIFIC_FIELD' => 'campo específico',
  'LBL_SPECIFIC_FIELD_LNK' => 'campo específico',
  'LBL_TRIGGER' => 'Cuando',
  'LBL_TRIGGER_FILTER_TITLE' => 'Filtros de Disparador',
  'LBL_TRIGGER_FORM_TITLE' => 'Definir una condición para la Ejecución el Flujo de Actividad',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Cuando el módulo objetivo cambia',
  'LBL_TYPE' => 'Tipo:',
  'LBL_VALUE' => 'valor',
  'LBL_WHEN_VALUE1' => 'Cuando el valor del campo es',
  'LBL_WHEN_VALUE2' => 'Cuando el valor de',
  'LNK_NEW_TRIGGER' => 'Crear Disparador',
  'LNK_NEW_WORKFLOW' => 'Crear Flujo de Actividad',
  'LNK_TRIGGER' => 'Disparadores de Flujo de Actividad',
  'LNK_WORKFLOW' => 'Objetos de Flujo de Actividad',
  'NTC_REMOVE_TRIGGER' => '¿Está seguro de que desea quitar este disparador?',
  'NTC_REMOVE_TRIGGER_PRIMARY' => 'Al remover un disparador primario borrará todos los demás.',
);

