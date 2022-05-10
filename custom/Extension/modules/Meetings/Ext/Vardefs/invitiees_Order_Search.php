<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 27/01/20
 * Time: 05:07 PM
 */

$dictionary["Meeting"]["fields"]["invitees"] =
array(
    'name' => 'invitees',
    'source' => 'non-db',
    'type' => 'collection',
    'vname' => 'LBL_INVITEES',
    'links' => array(
        'users',
        'leads',
        'contacts',
    ),
    'order_by' => 'name:asc',
    'studio' => false,
    'hideacl' => true,
);