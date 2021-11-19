<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/12/2016
 * Time: 12:13 PM
 */
$module_name = 'uni_Brujula';
$viewdefs[$module_name]['base']['view']['brujula_panel_record'] = array(

    'panels_1' => array(
        0 =>
            array(
                'fields' => array(
                    0 =>
                        array(
                            'name' => 'contactos_numero',
                            'label' => 'LBL_CONTACTOS_NUMERO',
                            'type' => 'int',
                            'view' => 'view',
                        ),
                    1 =>
                        array(
                            'name' => 'contactos_duracion',
                            'label' => 'LBL_CONTACTOS_DURACION',
                            'type' => 'int',
                            'view' => 'view',
                        ),

                    2 =>
                        array(
                            'label' => 'RESULTADOS',
                            'css_class' => 'resultados',
                        ),

                    3 =>
                        array(
                            'label' => 'Total (#)',
                            'css_class' => 'total',
                        ),

                    4 =>
                        array(
                            'name' => 'contactos_no_localizados',
                            'label' => 'LBL_CONTACTOS_NO_LOCALIZADOS',
                            'type' => 'int',
                            'view' => 'view',
                        ),

                    5 =>
                        array(
                            'name' => 'contactos_no_interesados',
                            'label' => 'LBL_CONTACTOS_NO_INTERESADOS',
                            'type' => 'int',
                            'view' => 'view',
                        ),

                    6 =>
                        array(
                            'name' => 'contactos_seguimiento_futuro',
                            'label' => 'LBL_CONTACTOS_SEGUIMIENTO_FUTURO',
                            'type' => 'int',
                            'view' => 'view',
                        ),

                    7 =>
                        array(
                            'name' => 'contactos_siguiente_llamada',
                            'label' => 'LBL_CONTACTOS_SIGUIENTE_LLAMADA',
                            'type' => 'int',
                            'view' => 'view',
                        ),

                    8 =>
                        array(
                            'name' => 'contactos_por_visitar',
                            'label' => 'LBL_CONTACTOS_POR_VISITAR',
                            'type' => 'int',
                            'view' => 'view',
                        ),

                    9 =>
                        array(
                            'name' => 'contactos_enviaran_informacion',
                            'label' => 'LBL_CONTACTOS_ENVIARAN_INFORMACION',
                            'type' => 'int',
                            'view' => 'view',
                        ),

                    10 =>
                        array(
                            'name' => 'citas_brujula',
                            'type' => 'citas_brujula',
                            'dismiss_label' => true,
                            'css_class' => 'citas_field',
                            'view' => 'view',
                        ),
                ),
            ),
    ),

    'panels' => array(
        0 =>
            array(
                'fields' => array(
                    0 =>
                    array(
                        'name' => 'contactos_numero',
                        'label' => 'LBL_CONTACTOS_NUMERO',
                        'type' => 'int',
                        'view' => 'view',
                    ),
                    1 =>
                    array(
                        'name' => 'contactos_duracion',
                        'label' => 'LBL_CONTACTOS_DURACION',
                        'type' => 'int',
                        'view' => 'view',
                    ),

                    2 =>
                        array(
                            'label' => 'RESULTADOS',
                            'css_class' => 'resultados',
                        ),

                    3 =>
                        array(
                            'label' => 'Total (#)',
                            'css_class' => 'total',
                        ),

                    4 =>
                    array(
                        'name' => 'contactos_no_localizados',
                        'label' => 'LBL_CONTACTOS_NO_LOCALIZADOS',
                        'type' => 'int',
                        'view' => 'view',
                    ),

                    5 =>
                    array(
                        'name' => 'contactos_no_interesados',
                        'label' => 'LBL_CONTACTOS_NO_INTERESADOS',
                        'type' => 'int',
                        'view' => 'view',
                    ),

                    6 =>
                    array(
                        'name' => 'contactos_seguimiento_futuro',
                        'label' => 'LBL_CONTACTOS_SEGUIMIENTO_FUTURO',
                        'type' => 'int',
                        'view' => 'view',
                    ),

                    7 =>
                    array(
                        'name' => 'contactos_siguiente_llamada',
                        'label' => 'LBL_CONTACTOS_SIGUIENTE_LLAMADA',
                        'type' => 'int',
                        'view' => 'view',
                    ),

                    8 =>
                    array(
                        'name' => 'contactos_por_visitar',
                        'label' => 'LBL_CONTACTOS_POR_VISITAR',
                        'type' => 'int',
                        'view' => 'view',
                    ),

                    9 =>
                    array(
                        'name' => 'contactos_enviaran_informacion',
                        'label' => 'LBL_CONTACTOS_ENVIARAN_INFORMACION',
                        'type' => 'int',
                        'view' => 'view',
                    ),

                    10 =>
                    array(
                        'name' => 'citas_brujula',
                        'type' => 'citas_brujula',
                        'dismiss_label' => true,
                        'css_class' => 'citas_field',
                        'view' => 'view',
                    ),
                ),
            ),

        1 =>
            array(
                'fields' => array(

                    0 =>
                    array(
                    'name'=>'tiempo_prospeccion',
                    'label'=>'LBL_TIEMPO_PROSPECCION',
                    'type'=>'fieldset',
                    'fields'=> array (
                            0 => array(
                                'name' => 'tiempo_prospeccion',
                                'label' => 'LBL_TIEMPO_PROSPECCION',
                                'css_class' => 'tiempo',
                                'type' => 'decimal',
                                'view' => 'view',
                            ),
                            1=> array(
                                'name' => 'porcentaje_prospeccion',
                                'label' => 'LBL_PORCENTAJE_PROSPECCION',
                                'dismiss_label' => true,
                                'css_class' => 'porcentaje',
                                'type' => 'decimal',
                                'view' => 'view',
                            ),
                        ),
                    ),
                    1 =>
                        array(
                            'name'=>'tiempo_revision_expediente_c',
                            'label'=>'LBL_TIEMPO_REVISION_EXPEDIENTE_C',
                            'type'=>'fieldset',
                            'fields'=> array (
                                0 => array(
                                    'name' => 'tiempo_revision_expediente_c',
                                    'label' => 'LBL_TIEMPO_REVISION_EXPEDIENTE_C',
                                    'css_class' => 'tiempo',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                                1=> array(
                                    'name' => 'porcentaje_revision_exp_c',
                                    'label' => 'LBL_PORCENTAJE_REVISION_EXP_c',
                                    'dismiss_label' => true,
                                    'css_class' => 'porcentaje',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                            ),
                        ),

                    2 =>
                        array(
                            'name'=>'tiempo_armado_expedientes',
                            'label'=>'LBL_TIEMPO_ARMADO_EXPEDIENTES',
                            'type'=>'fieldset',
                            'fields'=> array (
                                0 => array(
                                    'name' => 'tiempo_armado_expedientes',
                                    'label' => 'LBL_TIEMPO_ARMADO_EXPEDIENTES',
                                    'css_class' => 'tiempo',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                                1=> array(
                                    'name' => 'porcentaje_armado_expedientes',
                                    'label' => 'LBL_PORCENTAJE_ARMADO_EXPEDIENTES',
                                    'dismiss_label' => true,
                                    'css_class' => 'porcentaje',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                            ),
                        ),

                    3 =>
                        array(
                            'name'=>'tiempo_seguimiento_expedientes',
                            'label'=>'LBL_TIEMPO_SEGUIMIENTO_EXPEDIENTES',
                            'type'=>'fieldset',
                            'fields'=> array (
                                0 => array(
                                    'name' => 'tiempo_seguimiento_expedientes',
                                    'label' => 'LBL_TIEMPO_SEGUIMIENTO_EXPEDIENTES',
                                    'css_class' => 'tiempo',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                                1=> array(
                                    'name' => 'porcentaje_seguimiento_expedie',
                                    'label' => 'LBL_PORCENTAJE_SEGUIMIENTO_EXPEDIE',
                                    'dismiss_label' => true,
                                    'css_class' => 'porcentaje',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                            ),
                        ),

                    4 =>
                        array(
                            'name'=>'tiempo_operacion',
                            'label'=>'LBL_TIEMPO_OPERACION',
                            'type'=>'fieldset',
                            'fields'=> array (
                                0 => array(
                                    'name' => 'tiempo_operacion',
                                    'label' => 'LBL_TIEMPO_OPERACION',
                                    'css_class' => 'tiempo',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                                1=> array(
                                    'name' => 'porcentaje_operacion',
                                    'label' => 'LBL_PORCENTAJE_OPERACION',
                                    'dismiss_label' => true,
                                    'css_class' => 'porcentaje',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                            ),
                        ),

                    5 =>
                        array(
                            'name'=>'tiempo_liberacion',
                            'label'=>'LBL_TIEMPO_LIBERACION',
                            'type'=>'fieldset',
                            'fields'=> array (
                                0 => array(
                                    'name' => 'tiempo_liberacion',
                                    'label' => 'LBL_TIEMPO_LIBERACION',
                                    'css_class' => 'tiempo',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                                1=> array(
                                    'name' => 'porcentaje_liberacion',
                                    'label' => 'LBL_PORCENTAJE_LIBERACION',
                                    'dismiss_label' => true,
                                    'css_class' => 'porcentaje',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                            ),
                        ),

                    6 =>
                        array(
                            'name'=>'tiempo_servicio_cliente',
                            'label'=>'LBL_TIEMPO_SERVICIO_CLIENTE',
                            'type'=>'fieldset',
                            'fields'=> array (
                                0 => array(
                                    'name' => 'tiempo_servicio_cliente',
                                    'label' => 'LBL_TIEMPO_SERVICIO_CLIENTE',
                                    'css_class' => 'tiempo',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                                1=> array(
                                    'name' => 'porcentaje_servicio_cliente',
                                    'label' => 'LBL_PORCENTAJE_SERVICIO_CLIENTE',
                                    'dismiss_label' => true,
                                    'css_class' => 'porcentaje',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                            ),
                        ),


                    7 =>
                        array(
                            'name'=>'tiempo_otras_actividades',
                            'label'=>'LBL_TIEMPO_OTRAS_ACTIVIDADES',
                            'type'=>'fieldset',
                            'fields'=> array (
                                0 => array(
                                    'name' => 'tiempo_otras_actividades',
                                    'label' => 'LBL_TIEMPO_OTRAS_ACTIVIDADES',
                                    'css_class' => 'tiempo',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                                1=> array(
                                    'name' => 'porcentaje_otras_actividades',
                                    'label' => 'LBL_PORCENTAJE_OTRAS_ACTIVIDADES',
                                    'dismiss_label' => true,
                                    'css_class' => 'porcentaje',
                                    'type' => 'decimal',
                                    'view' => 'view',
                                ),
                            ),
                        ),
                ),
            ),
    ),
);

