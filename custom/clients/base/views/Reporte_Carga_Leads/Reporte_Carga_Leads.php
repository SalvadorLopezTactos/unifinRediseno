<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 27/12/19
 * Time: 02:30 PM
 */



$viewdefs['base']['view']['Reporte_Carga_Leads'] = array(
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'nombre_de_carga',
                    'label' => 'Nombre de la Carga',
                    'type' => 'enum',
                    'required'=>true,
                    'view' => 'edit',
                ),
            ),
        ),
    ),
    'panelsTo' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'asignar_a_promotor',
                    'label' => 'Reasignar a: ',
                    'type' => 'relate',
                    'view' => 'edit',
                ),
            ),
        ),
    )
);