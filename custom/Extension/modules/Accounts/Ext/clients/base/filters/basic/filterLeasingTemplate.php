<?php
/**
 * Created by PhpStorm.
 * User: CarlosZaragoza
 * Date: 10/28/2015
 * Time: 4:52 PM
 */
$viewdefs['Accounts']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterLeasingTemplate',
    'name' => 'LBL_FILTER_LEASING_TEMPLATE',
    'filter_definition' => array(
        array(
            'tipodeproducto_c' => array(
                '$equals' => array(),
            ),
        )
    ),
    'editable' => true,
    'is_template' => true,
);