<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/10/18
 * Time: 11:53 AM
 */

$dictionary['minut_Minutas']['duplicate_check']['FilterDuplicateCheck']['filter_template'] =
array(
    array(
        '$and' => array(
            array('id' => array('$equals' => '$id')),
            array('name' => array('$equals' => '$name')),
        )
    ),
);
