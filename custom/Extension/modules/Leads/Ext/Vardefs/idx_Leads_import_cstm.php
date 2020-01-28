<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 28/01/20
 * Time: 09:07 AM
 */

$dictionary['Leads']['indices'][] = array(
    'name' => 'idx_importLeads_cstm',
    'type' => 'index',
    'fields' => array(
        0 => 'nombre_c',
        1 => 'apellido_paterno_c',
        2 => 'apellido_materno_c',
    ),
    'source' => 'non-db',
);