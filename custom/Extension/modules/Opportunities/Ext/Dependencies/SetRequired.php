<?php	    

	    $dependencies['Opportunities']['plazo_c_required'] = array(
	            'hooks' => array("all"),
	            'trigger' => 'true',
				'triggerFields' => array('tipo_producto_c'),
	            'onload' => true,
	            'actions' => array(
	                    array(
	                            'name' => 'SetRequired', 
	                            'params' => array(
	                                    'target' => 'plazo_c',
	                                    'value' => 'equal($tipo_producto_c,"4")',
	                            ),
	                    ),
	            ),
	    );
/*
	    $dependencies['Opportunities']['forecast_c_required'] = array(
	            'hooks' => array("all"),
	            'trigger' => 'true',
	            'onload' => true,
	            'actions' => array(
	                    array(
	                            'name' => 'SetRequired', 
	                            'params' => array(
	                                    'target' => 'forecast_c',
	                                    'value' => 'true', 
	                            ),
	                    ),
	            ),
	    );
*/
$dependencies['Opportunities']['mes_c_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_producto_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'mes_c',
                'value' => 'and(equal($tipo_producto_c,"1"),equal($tipo_operacion_c,"1"))',
            ),
        ),
    ),
);
$dependencies['Opportunities']['anio_c_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('tipo_producto_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'anio_c',
                'value' => 'and(equal($tipo_producto_c,"1"),equal($tipo_operacion_c,"1"))',
            ),
        ),
    ),
);
$dependencies['Opportunities']['f_tipo_factoraje_c_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'f_tipo_factoraje_c',
                'value' => 'and(equal($tipo_producto_c,"4"),equal($tct_oportunidad_perdida_chk_c,"true"))',
            ),
        ),
    ),
);
$dependencies['Opportunities']['f_aforo_c_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'f_aforo_c',
                'value' => 'and(equal($tipo_producto_c,"4"),equal($tct_oportunidad_perdida_chk_c,"true"))',
            ),
        ),
    ),
);

$dependencies['Opportunities']['assigned_user_name_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'assigned_user_name',
                'value' => 'true',
            ),
        ),
    ),
);
	    /*$dependencies['Opportunities']['forecast_time_c_required'] = array(
	            'hooks' => array("all"),
	            'trigger' => 'true',
	            'onload' => true,
	            'actions' => array(
	                    array(
	                            'name' => 'SetRequired',
	                            'params' => array(
	                                    'target' => 'forecast_time_c',
	                                    'value' => 'true', 
	                            ),
	                    ),
	            ),
	    );*/

    //////////***************************   BEGIN: READ ONLY   ******************************////////////////////////////

    $dependencies['Opportunities']['idsolicitud_c_readonly'] = array(
            'hooks' => array("all"),
            'trigger' => 'true',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'idsolicitud_c',
                                    'value' => 'true',
                            ),
                    ),                    
            ),
    );

	$dependencies['Opportunities']['id_process_c_readonly'] = array(
            'hooks' => array("all"),
            'trigger' => 'true',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'id_process_c',
                                    'value' => 'true',
                            ),
                    ),                    
            ),
    );

    $dependencies['Opportunities']['estatus_c_readonly'] = array(
        'hooks' => array("all"),
        'trigger' => 'true',
        'onload' => true,
        'actions' => array(
            array(
                'name' => 'ReadOnly',
                'params' => array(
                    'target' => 'estatus_c',
                    'value' => 'true',
                ),
            ),
        ),
    );
    
   	////////******************Solo lectura al editar****************/////////
   
    $dependencies['Opportunities']['amount_readonly'] = array(
            'hooks' => array("edit"),
            'trigger' => 'not(equal($id_process_c, ""))',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'amount',
                                    'value' => 'true',
                            ),
                    ),                    
            ),
    );
   
    $dependencies['Opportunities']['monto_c_readonly'] = array(
            'hooks' => array("edit"),
            'trigger' => 'not(equal($id_process_c, ""))',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'monto_c',
                                    'value' => 'true',
                            ),
                    ),                    
            ),
    );
    
    $dependencies['Opportunities']['plazo_c_readonly'] = array(
            'hooks' => array("edit"),
            'trigger' => 'not(equal($id_process_c, ""))',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'plazo_c',
                                    'value' => 'equal($tipo_producto_c,"4")',
                            ),
                    ),                    
            ),
    );
   
   $dependencies['Opportunities']['tipo_producto_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($idsolicitud_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tipo_producto_c',
                'value' => 'true',
            ),
        ),
    ),
);
    /*
	// CVV - 28/03/2016 - Se reemplazan los campos de activo por modulo de condiciones financieras
	$dependencies['Opportunities']['activo_c_readonly'] = array(
            'hooks' => array("edit"),
            'trigger' => 'not(equal($id_process_c, ""))',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'activo_c',
                                    'value' => 'true',
                            ),
                    ),                    
            ),
    );
    
    	$dependencies['Opportunities']['sub_activo_c_readonly'] = array(
            'hooks' => array("edit"),
            'trigger' => 'not(equal($id_process_c, ""))',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'sub_activo_c',
                                    'value' => 'true',
                            ),
                    ),                    
            ),
    );
    
    	$dependencies['Opportunities']['sub_activo_2_c_readonly'] = array(
            'hooks' => array("edit"),
            'trigger' => 'not(equal($id_process_c, ""))',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'sub_activo_2_c',
                                    'value' => 'true',
                            ),
                    ),                    
            ),
    );
    
    	$dependencies['Opportunities']['sub_activo_3_c_readonly'] = array(
            'hooks' => array("edit"),
            'trigger' => 'not(equal($id_process_c, ""))',
            'onload' => true,
            'actions' => array(
                    array(
                            'name' => 'ReadOnly',
                            'params' => array(
                                    'target' => 'sub_activo_3_c',
                                    'value' => 'true',
                            ),
                    ),                    
            ),
    );
	*/
$dependencies['Opportunities']['f_tipo_factoraje_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'and(not(equal($id_process_c, "")),not(equal($id_process_c, "-1")))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'f_tipo_factoraje_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['f_aforo_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'and(not(equal($id_process_c, "")),not(equal($id_process_c, "-1")))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'f_aforo_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['f_documento_descontar_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'and(not(equal($id_process_c, "")),not(equal($id_process_c, "-1")))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'f_documento_descontar_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['f_comentarios_generales_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'and(not(equal($id_process_c, "")),not(equal($id_process_c, "-1")))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'f_comentarios_generales_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['assigned_user_name_readonly'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'assigned_user_name',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['usuario_bo_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'usuario_bo_c',
                'value' => 'true',
            ),
        ),
    ),
);
	/*
	// CVV - 28/03/2016 - Se reemplazan los campos de condiciones financieras por modulo de condiciones financieras
$dependencies['Opportunities']['porcentaje_enganche_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'porcentaje_enganche_c',
                'value' => 'true',
            ),
        ),
    ),
);*/
$dependencies['Opportunities']['porcentaje_ca_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'porcentaje_ca_c',
                'value' => 'true',
            ),
        ),
    ),
);
/* 
$dependencies['Opportunities']['porcentaje_caf_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'porcentaje_caf_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['vrc_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'vrc_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['vri_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'vri_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ca_tasa_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ca_tasa_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['ratificacion_incremento_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO")',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ratificacion_incremento_c',
                'value' => 'true',
            ),
        ),
    ),
);
*/
$dependencies['Opportunities']['monto_ratificacion_increment_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'monto_ratificacion_increment_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['plazo_ratificado_incremento_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'plazo_ratificado_incremento_c',
                'value' => 'equal($tipo_producto_c,"4")',
            ),
        ),
    ),
);
/*
$dependencies['Opportunities']['es_multiactivo_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($idsolicitud_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'es_multiactivo_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['multiactivo_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($idsolicitud_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'multiactivo_c',
                'value' => 'true',
            ),
        ),
    ),
);*/
$dependencies['Opportunities']['tipo_producto_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($idsolicitud_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tipo_producto_c',
                'value' => 'true',
            ),
        ),
    ),
);
/*
$dependencies['Opportunities']['deposito_garantia_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'deposito_garantia_c',
                'value' => 'true',
            ),
        ),
    ),
);
*/
$dependencies['Opportunities']['ca_importe_enganche_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ca_importe_enganche_c',
                'value' => 'true',
            ),
        ),
    ),
);
/*
$dependencies['Opportunities']['porcentaje_renta_inicial_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'porcentaje_renta_inicial_c',
                'value' => 'true',
            ),
        ),
    ),
);
*/

/////*****///////

/*
$dependencies['Opportunities']['ri_ca_tasa_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO")',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_ca_tasa_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_deposito_garantia_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO")',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_deposito_garantia_c',
                'value' => 'true',
            ),
        ),
    ),
);*/
$dependencies['Opportunities']['ri_porcentaje_ca_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_porcentaje_ca_c',
                'value' => 'true',
            ),
        ),
    ),
);
/*
$dependencies['Opportunities']['ri_porcentaje_renta_inicial_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO")',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_porcentaje_renta_inicial_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_vrc_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO")',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_vrc_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_vri_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO")',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_vri_c',
                'value' => 'true',
            ),
        ),
    ),
);
*/
///FACTORAJE, CONDICINES/////
$dependencies['Opportunities']['instrumento_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'instrumento_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['puntos_sobre_tasa_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'puntos_sobre_tasa_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['puntos_tasa_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'puntos_tasa_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['tipo_tasa_ordinario_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tipo_tasa_ordinario_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['tipo_tasa_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tipo_tasa_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['instrumento_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'instrumento_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['factor_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'factor_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['cartera_descontar_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'cartera_descontar_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['tasa_fija_ordinario_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tasa_fija_ordinario_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['tasa_fija_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'not(equal($id_process_c, ""))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tasa_fija_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);


//READONLY RI////
$dependencies['Opportunities']['ri_instrumento_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_instrumento_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_puntos_sobre_tasa_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_puntos_sobre_tasa_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_puntos_tasa_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_puntos_tasa_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_tipo_tasa_ordinario_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_tipo_tasa_ordinario_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_tipo_tasa_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_tipo_tasa_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_instrumento_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_instrumento_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_factor_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_factor_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);
$dependencies['Opportunities']['ri_cartera_descontar_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_cartera_descontar_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['ri_tasa_fija_ordinario_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ri_tasa_fija_ordinario_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['ri_tasa_fija_moratorio_c_readonly'] = array(
    'hooks' => array("edit"),
    'trigger' => 'or(equal($tipo_de_operacion_c, "RATIFICACION_INCREMENTO"),equal($ratificacion_incremento_c,1))',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tasa_fija_moratorio_c',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['Opportunities']['condiciones_financieras_readonly'] = array(
   'hooks' => array("edit"),
   'trigger' => 'true',
   'triggerFields' => array('ratificacion_incremento_c','id_process_c','condiciones_financieras'),
   'onload' => true,
   'actions' => array(
       array(
           'name' => 'ReadOnly',
           'params' => array(
               'target' => 'condiciones_financieras',
               'value' => 'not(equal($id_process_c,""))',
           ),
       ),
   ),
);

//////////***************************   END: READ ONLY   ******************************////////////////////////////