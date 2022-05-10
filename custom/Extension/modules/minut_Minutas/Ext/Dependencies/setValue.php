<?php
/*
 * Created by: Salvador Lopez
 * date 22/10/2018
 * */

//Se establece valor en Casilla de Nueva Reunión cuando Motivo es igual a Seguimiento Futuro
$dependencies['minut_Minutas']['setValueMimutas'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'onload' => true,
    'triggerFields' => array('tct_motivo_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'tct_programa_nueva_reunion_chk',
                'value' => 'ifElse(equal($tct_motivo_c,"10"),true,false)'
            )
        )
    )
);

//Se establece valor No esta interesado para resultado de la cita
$dependencies['minut_Minutas']['set_resultado_c'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'onload' => true,
    'triggerFields' => array('tct_cliente_no_interesado_chk'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'resultado_c',
                'value' => 'ifElse(equal($tct_cliente_no_interesado_chk,true),"2",ifElse(and(equal($tct_cliente_no_interesado_chk,false),equal($resultado_c,"2")),"",$resultado_c))'
            )
        )
    )
);

//Se establece valor true para Cloente no interesado
$dependencies['minut_Minutas']['set_tct_cliente_no_interesado_chk'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'onload' => true,
    'triggerFields' => array('resultado_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'tct_cliente_no_interesado_chk',
                'value' => 'ifElse(equal($resultado_c,"2"),true,false)'
            )
        )
    )
);
