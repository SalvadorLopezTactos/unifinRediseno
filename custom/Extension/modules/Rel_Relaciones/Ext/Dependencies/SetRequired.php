<?php
    $dependencies['Rel_Relaciones']['particpacion'] = array(
            'hooks' => array("all"),
            'trigger' => 'true',
            'triggerFields' => array('relaciones_activas_c'),
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'SetVisibility', //Action type
                            'params' => array(
                                    'target' => 'participacion',
                                    'label' => 'lbl_participacion',
                                    'value' => 'isInList($relaciones_activas_c,createList("Aval","Accionista"))', //Formula
                            ),
                    ),
            ),
    );

$dependencies['Rel_Relaciones']['rel_relaciones_accounts_name_readonly'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'rel_relaciones_accounts_name',
                'value' => 'true',
            ),
        ),
    ),
);
   

    //////////***************************   END: READ ONLY   ******************************////////////////////////////



