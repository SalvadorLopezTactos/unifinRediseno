<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/12/2016
 * Time: 2:39 PM
 */

$module_name = 'uni_Brujula';
$viewdefs[$module_name]['base']['layout']['create-actions'] = array(
    'components' =>
        array(
            array(
                'layout' =>
                    array(
                        'components' =>
                            array(
                                array(
                                    'layout' =>
                                        array(
                                            'components' =>
                                                array(
                                                    array(
                                                        'view' => 'create-actions',
                                                    ),
                                                    array(
                                                        'layout' => 'brujula_panel_create',
                                                    ),
                                                ),
                                            'type' => 'simple',
                                            'name' => 'main-pane',
                                            'span' => 8,
                                        ),
                                ),
                                array(
                                    'layout' =>
                                        array(
                                            'components' =>
                                                array(),
                                            'type' => 'simple',
                                            'name' => 'side-pane',
                                            'span' => 4,
                                        ),
                                ),
                                array(
                                    'layout' =>
                                        array(
                                            'components' =>
                                                array(),
                                            'type' => 'simple',
                                            'name' => 'dashboard-pane',
                                            'span' => 4,
                                        ),
                                ),
                                array(
                                    'layout' =>
                                        array(
                                            'components' =>
                                                array(
                                                    array(
                                                        'layout' => 'preview',
                                                    ),
                                                ),
                                            'type' => 'simple',
                                            'name' => 'preview-pane',
                                            'span' => 8,
                                        ),
                                ),
                            ),
                        'type' => 'default',
                        'name' => 'sidebar',
                        'span' => 12,
                        'last_state' => array(
                            'id' => 'create-default',
                        ),
                    ),
            ),
        ),
    'type' => 'create-actions',
    'name' => 'base',
    'span' => 12,
);
