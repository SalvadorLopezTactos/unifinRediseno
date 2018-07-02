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
  'ERR_DELETE_EMPTY' => 'O registro já foi excluído ou não existe.',
  'ERR_DELETE_RECORD' => 'Um número de registro deve ser especificado para eliminar este registro.',
  'LBL_ALERT_TEMPLATES' => 'Modelos de Alertas',
  'LBL_APOSTROPHE_S' => '&#39;s',
  'LBL_COMPARE_ANY_TIME_PART2' => 'não altera desde',
  'LBL_COMPARE_ANY_TIME_PART3' => 'tempo determinado',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Campo não sofre alterações por um período especificado de tempo',
  'LBL_COMPARE_CHANGE_PART' => 'alterações',
  'LBL_COMPARE_CHANGE_TITLE' => 'Quando um campo no módulo de destino altera',
  'LBL_COMPARE_COUNT_TITLE' => 'Iniciar após um determinado número de vezes',
  'LBL_COMPARE_SPECIFIC_PART' => 'altera para ou de um valor específico',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Quando um campo no módulo de destino altera para ou de um valor específico',
  'LBL_COUNT_TRIGGER1' => 'Total',
  'LBL_COUNT_TRIGGER1_2' => 'em comparação com este valor',
  'LBL_COUNT_TRIGGER2' => 'filtrar por relacionado',
  'LBL_COUNT_TRIGGER2_2' => 'apenas',
  'LBL_COUNT_TRIGGER3' => 'filtrar especificamente por',
  'LBL_COUNT_TRIGGER4' => 'filtrar por um segundo',
  'LBL_EVAL' => 'Avaliação da Trigger:',
  'LBL_FIELD' => 'campo',
  'LBL_FILTER_FIELD_PART1' => 'Filtrar por',
  'LBL_FILTER_FIELD_TITLE' => 'Quando um campo no módulo de destino contém um valor específico',
  'LBL_FILTER_FORM_TITLE' => 'Definir condições de Workflow',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtrar objetos baseado no seguinte:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Especificar relacionado',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Quando o módulo de destino altera e um campo em um módulo relacionado contém um valor específico',
  'LBL_FUTURE_TRIGGER' => 'Especificar novo',
  'LBL_LIST_EVAL' => 'Aval:',
  'LBL_LIST_FIELD' => 'Campo:',
  'LBL_LIST_FORM_TITLE' => 'Lista de Triggers',
  'LBL_LIST_FRAME_PRI' => 'Trigger:',
  'LBL_LIST_FRAME_SEC' => 'Filtro:',
  'LBL_LIST_NAME' => 'Descrição:',
  'LBL_LIST_STATEMEMT' => 'Iniciar um evento baseado no seguinte:',
  'LBL_LIST_TYPE' => 'Tipo:',
  'LBL_LIST_VALUE' => 'Valor:',
  'LBL_MODULE' => 'módulo',
  'LBL_MODULE_NAME' => 'Condições',
  'LBL_MODULE_NAME_SINGULAR' => 'Condição',
  'LBL_MODULE_SECTION_TITLE' => 'Quando estas condições são verificadas',
  'LBL_MODULE_TITLE' => 'Triggers de Workflow: Tela Principal',
  'LBL_MUST_SELECT_VALUE' => 'Você deve selecionar um valor para este campo',
  'LBL_NAME' => 'Nome da Trigger:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Criar Filtro',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Criar Filtro',
  'LBL_NEW_FORM_TITLE' => 'Criar Triggers',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Criar Trigger',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Criar Trigger',
  'LBL_PAST_TRIGGER' => 'Especificar antigo',
  'LBL_RECORD' => 'módulos',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisa de Triggers de Workflow',
  'LBL_SELECT_1ST_FILTER' => 'Você deve selecionar um campo do primeiro filtro válido',
  'LBL_SELECT_2ND_FILTER' => 'Você deve selecionar um campo do segundo filtro válido',
  'LBL_SELECT_AMOUNT' => 'Deve selecionar o montante',
  'LBL_SELECT_OPTION' => 'Por favor selecione uma opção.',
  'LBL_SELECT_TARGET_FIELD' => 'Por favor selecione um campo de destino.',
  'LBL_SELECT_TARGET_MOD' => 'Por favor selecione um módulo relacionado com o destino.',
  'LBL_SHOW' => 'Mostrar',
  'LBL_SHOW_PAST' => 'Modificar o valor antigo:',
  'LBL_SPECIFIC_FIELD' => '&#39;s campo específico',
  'LBL_SPECIFIC_FIELD_LNK' => 'campo específico',
  'LBL_TRIGGER' => 'Quando',
  'LBL_TRIGGER_FILTER_TITLE' => 'Filtrar Triggers:',
  'LBL_TRIGGER_FORM_TITLE' => 'Definir condições para a execução do Workflow',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Quando o módulo de destino altera',
  'LBL_TYPE' => 'Tipo:',
  'LBL_VALUE' => 'valor',
  'LBL_WHEN_VALUE1' => 'Quando o valor do campo é',
  'LBL_WHEN_VALUE2' => 'Quando o valor de',
  'LNK_NEW_TRIGGER' => 'Criar Trigger',
  'LNK_NEW_WORKFLOW' => 'Criar Workflow',
  'LNK_TRIGGER' => 'Triggers de Workflow',
  'LNK_WORKFLOW' => 'Objetos de Workflow',
  'NTC_REMOVE_TRIGGER' => 'Você tem certeza que quer eliminar esta trigger?',
  'NTC_REMOVE_TRIGGER_PRIMARY' => 'A remoção de uma trigger primária irá remover todos as triggers.',
);

