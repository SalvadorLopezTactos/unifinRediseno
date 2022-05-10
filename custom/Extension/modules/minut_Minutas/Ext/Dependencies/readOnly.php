<?php
/*
 * Created by: Salvador Lopez
 * date 22/10/2018
 * */

$dependencies['minut_Minutas']['readOnlyReunionChk'] = array
(
            'hooks' => array("all"),
            'trigger' => 'true',
            'triggerFields' => array('tct_motivo_c','tct_cliente_no_interesado_chk'),
            'onload' => true,
            'actions' => array(
                array(
                    'name' => 'ReadOnly',
                    'params' => array(
                        'target' => 'tct_programa_nueva_reunion_chk',
                        'value' => 'and(equal($tct_motivo_c,"10"),equal($tct_cliente_no_interesado_chk,true))',
                    ),
                ),
            ),
            'notActions' => array(),
);