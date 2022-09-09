<?php

$dependencies['Documents']['setoptions_type'] = array(
   'hooks' => array("edit","save"),
   'trigger' => 'true',
   'triggerFields' => array('parent_type'),
   'onload' => true,
   'actions' => array(
      array(
        'name' => 'SetOptions',
        'params' => array(
           'target' => 'tipo_documento_c',
           //Se muestran distintas opciones en el campo tipo cuando se está intentando crear el Documento a partir de un registro de Caso
           'keys' => 'ifElse(and(not(equal($s_seguros_documents_1_name,"")),equal($opportunities_documents_1_name,"")),getDropdownKeySet("tipo_documento_seguros_list"),ifElse(and(not(equal($opportunities_documents_1_name,"")),equal($s_seguros_documents_1_name,"")),getDropdownKeySet("tipo_documento_solicitudes_list"),getDropdownKeySet("tipo_documento_casos_list")))',
           'labels' => 'ifElse(and(not(equal($s_seguros_documents_1_name,"")),equal($opportunities_documents_1_name,"")),getDropdownValueSet("tipo_documento_seguros_list"),ifElse(and(not(equal($opportunities_documents_1_name,"")),equal($s_seguros_documents_1_name,"")),getDropdownValueSet("tipo_documento_solicitudes_list"),getDropdownValueSet("tipo_documento_casos_list")))'
        ),
      ),
    ),
);