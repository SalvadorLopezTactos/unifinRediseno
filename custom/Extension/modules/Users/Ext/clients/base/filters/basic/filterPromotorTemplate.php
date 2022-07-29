<?php
/**
 * Created by PhpStorm.
 * User: CarlosZaragoza
 * Date: 10/28/2015
 * Time: 4:52 PM
 */
$viewdefs['Users']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterPromotorTemplate',
    'name' => 'LBL_FILTER_PROMOTOR_TEMPLATE',
    'filter_definition' => array(
        array(
            'tipodeproducto_c' => array(
                '$equals' => '',
            ),
        )
    ),
    'editable' => true,
    'is_template' => true,
);