<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/9/2015
 * Time: 10:42 AM
 */
$dictionary['Account']['duplicate_check'] = array(
    'enabled' => true,
    'FilterDuplicateCheck' => array(
        'filter_template' => array(
            array(
                '$or' => array(
                    array('clean_name' => array('$equals' => '$clean_name')),
                    array(
                        '$and' => array(
                            array('rfc_c' => array('$equals' => '$rfc_c')),
                            array('rfc_c' => array('$not_equals' => 'XXX010101XXX')),
                            array('rfc_c' => array('$not_equals' => 'XXXX010101XXX')),
                        ),
                    )
                )
            )
        ),
        'ranking_fields' => array(
            array('in_field_name' => 'rfc_c', 'dupe_field_name' => 'rfc_c'),
            array('in_field_name' => 'clean_name', 'dupe_field_name' => 'clean_name'),
        )
    )
);
