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