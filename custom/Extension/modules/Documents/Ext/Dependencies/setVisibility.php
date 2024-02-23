<?php

$dependencies['Documents']['hide_data_quantico'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id', 'data_document_quantico_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'data_document_quantico_c',
                'value' => 'equal(0,1)',//Este campo siempre se oculta ya que solo se quiere en el registro para que se encuentre disponible en this.model
            ),
        ),
    ),
);

$dependencies['Documents']['hide_name_document'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('filename', 'data_document_quantico_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'filename',
                'value' => 'equal($data_document_quantico_c,"")', //El campo que descarga el documento se oculta y se reemplaza por el campo custom que descarga el documento de Quantico
            ),
        ),
    ),
);
