<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/23/2017
 * Time: 1:57 PM
 */
$viewdefs['Accounts']['base']['filter']['equipo_unifin'] = array(
    'create' => true,
    'filters' => array(
        array(
            'id' => 'equipo_unifin',
            'name' => 'Equipo Unifin',
            'filter_definition' => array(
                array(
                    'unifin_team' => array(
                        '$equals' => array(),
                    ),
                )
            ),

            'editable' => true
        )
    )
);
