<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/12/2016
 * Time: 2:46 PM
 */

$module_name = 'uni_Brujula';
$viewdefs[$module_name]['base']['view']['brujula_panel_create'] = array(
    'panel_1' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'contactos_numero',
                    'label' => 'LBL_CONTACTOS_NUMERO',
                    'type' => 'int',
                    'view' => 'edit',
                    'css_class' => 'brujula_field',
                    'related_fields' => array(
                        'extemporaneo',
                        'tiempo_total'
                    ),
                ),

                array(
                    'name' => 'contactos_duracion',
                    'label' => 'LBL_CONTACTOS_DURACION',
                    'css_class' => 'brujula_field',
                    'type' => 'int',
                    'view' => 'edit',
                    'tool_tip' => 'Tiempo dedicado a contactos, debe incluir no solo el tiempo que estoy al telefono, sino tambien el tiempo que dedico a la preparacion de la llamada y el tiempo que dedico despues de la llamada.
Ejemplo: Dedico 10 minutos a buscar en internet a que se dedica la empresa, estoy 10 minutos al telefono y dedico 5 minutos a dar de alta el prospecto en CRM y en mandarle un email con la confirmacion de la cita.
Tiempo total de prospeccion 25 minutos.',
                ),
            ),
        ),
    ),


    'panel_2' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'contactos_no_localizados',
                    'label' => 'LBL_CONTACTOS_NO_LOCALIZADOS',
                    'type' => 'int',
                    'view' => 'edit',
                    'css_class' => 'brujula_field',
                ),

                array(
                    'name' => 'contactos_no_interesados',
                    'label' => 'LBL_CONTACTOS_NO_INTERESADOS',
                    'type' => 'int',
                    'view' => 'edit',
                    'css_class' => 'brujula_field',
                ),

                array(
                    'name' => 'contactos_seguimiento_futuro',
                    'label' => 'LBL_CONTACTOS_SEGUIMIENTO_FUTURO',
                    'type' => 'int',
                    'view' => 'edit',
                    'css_class' => 'brujula_field',
                ),

                array(
                    'name' => 'contactos_siguiente_llamada',
                    'label' => 'LBL_CONTACTOS_SIGUIENTE_LLAMADA',
                    'type' => 'int',
                    'view' => 'edit',
                    'css_class' => 'brujula_field',
                ),

                array(
                    'name' => 'contactos_por_visitar',
                    'label' => 'LBL_CONTACTOS_POR_VISITAR',
                    'type' => 'int',
                    'view' => 'edit',
                    'css_class' => 'brujula_field',
                ),

                array(
                    'name' => 'contactos_enviaran_informacion',
                    'label' => 'LBL_CONTACTOS_ENVIARAN_INFORMACION',
                    'type' => 'int',
                    'view' => 'edit',
                    'css_class' => 'brujula_field',
                ),
            ),
        ),
    ),

    'panel_3' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'citas_brujula',
                    'type' => 'citas_brujula',
                    'view' => 'edit',
                ),

            ),
        ),
    ),

    'panel_4' => array(
        array(
            'fields' => array(
                array(
                    array(
                        'name' => 'tiempo_prospeccion',
                        'label' => 'LBL_TIEMPO_PROSPECCION',
                        'css_class' => 'tiempo',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Tiempo en horas que le dedicaste a prospeccion.',
                    ),

                    array(
                        'name' => 'porcentaje_prospeccion',
                        'label' => 'LBL_PORCENTAJE_PROSPECCION',
                        'dismiss_label' => true,
                        'css_class' => 'porcentaje',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Porcentaje de tiempo que le dedicaste a prospeccion.',
                    ),
               ),
                array(
                    array(
                        'name' => 'tiempo_revision_expediente_c',
                        'label' => 'LBL_TIEMPO_REVISION_EXPEDIENTE_C',
                        'css_class' => 'tiempo',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Tiempo que lleva revisar un expediente.
Es importante que este tiempo considere desde antes de armar un expediente para que pueda ser enviado:
* Tiempo que tomo validar los documentos recibidos.
* Tiempo ocupado pidiendo los documentos faltantes.
* Tiempo que toma realizar las comprobaciones al EEFF para ver si candidato de credito',
                    ),

                    array(
                        'name' => 'porcentaje_revision_exp_c',
                        'label' => 'LBL_PORCENTAJE_REVISION_EXP_c',
                        'dismiss_label' => true,
                        'css_class' => 'porcentaje',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Porcentaje de tiempo que le dedicaste a la revision de expedientes.',
                    ),
                ),
                array(
                    array(
                        'name' => 'tiempo_armado_expedientes',
                        'label' => 'LBL_TIEMPO_ARMADO_EXPEDIENTES',
                        'css_class' => 'tiempo',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Tiempo que lleva armar un expediente.
Es el tiempo que te toma enviar un documento.
* Tiempo que toma digitalizar los documentos.
* Tiempo que toma subir los documentos al CRM.
* Tiempo que toma enviar los documentos a revision.

',
                        ),

                    array(
                        'name' => 'porcentaje_armado_expedientes',
                        'label' => 'LBL_PORCENTAJE_ARMADO_EXPEDIENTES',
                        'dismiss_label' => true,
                        'css_class' => 'porcentaje',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Porcentaje de tiempo que le dedicaste a armar expedientes.',
                    ),
                ),

                array(
                    array(
                        'name' => 'tiempo_seguimiento_expedientes',
                        'label' => 'LBL_TIEMPO_SEGUIMIENTO_EXPEDIENTES',
                        'css_class' => 'tiempo',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Tiempo dedicado a un seguimiento en proceso de autorizacion:
* Tiempo que dedico a vender la operacion al analista de credito (tarea del Promotor).
* Tiempo ocupado en dar seguimiento al area de credito (tarea del Coordinador Comercial)',
                    ),

                    array(
                        'name' => 'porcentaje_seguimiento_expedie',
                        'label' => 'LBL_PORCENTAJE_SEGUIMIENTO_EXPEDIE',
                        'dismiss_label' => true,
                        'css_class' => 'porcentaje',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Porcentaje de tiempo dedicado al seguimiento de un expediente.',
                    ),
                ),

                array(
                    array(
                        'name' => 'tiempo_operacion',
                        'label' => 'LBL_TIEMPO_OPERACION',
                        'css_class' => 'tiempo',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Tiempo dedicado a las operaciones hasta que se activan (tarea del Coordinador Comercial)
* Pueden ser llamadas, email, mensajes o reuniones para hacer una operacion.
* Tiempo ocupado en dar de alta una operacion.
* Tiempo para darle seguimiento a las operaciones pendientes.',
                    ),

                    array(
                        'name' => 'porcentaje_operacion',
                        'label' => 'LBL_PORCENTAJE_OPERACION',
                        'dismiss_label' => true,
                        'css_class' => 'porcentaje',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Porcentaje de tiempo dedicado a seguimiento de operaciones.',
                    ),
                ),

                array(

                    array(
                        'name' => 'tiempo_liberacion',
                        'label' => 'LBL_TIEMPO_LIBERACION',
                        'css_class' => 'tiempo',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Tiempo ocupado para liberar (tarea del Coordinador Comercial)
* Tiempo invertido en el seguimiento de la liberacion.
* El tiempo que tomo entregar un bien y finalizar la operacion.',
                    ),

                    array(
                        'name' => 'porcentaje_liberacion',
                        'label' => 'LBL_PORCENTAJE_LIBERACION',
                        'dismiss_label' => true,
                        'css_class' => 'porcentaje',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Porcentaje de tiempo que le dedicaste a una liberacion.',
                    ),
                ),

                array(
                    array(
                        'name' => 'tiempo_servicio_cliente',
                        'label' => 'LBL_TIEMPO_SERVICIO_CLIENTE',
                        'css_class' => 'tiempo',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Tiempo ocupado para atender a los clientes de UNIFIN (tarea del CAC)
* Tiempo invertido en solucionar incidencias y problemas despues de la liberacion.
* Tiempo invertido en dar seguimiento a algun contacto con el CAC.
* Tiempo invertido a dar seguimiento a cartera vencida, esto incluye contacto con el cliente.',
                    ),

                    array(
                        'name' => 'porcentaje_servicio_cliente',
                        'label' => 'LBL_PORCENTAJE_SERVICIO_CLIENTE',
                        'dismiss_label' => true,
                        'css_class' => 'porcentaje',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Porcentaje de tiempo que le dedicaste a dar atencion a tus clientes.',
                    ),
                ),

                array(
                    array(
                        'name' => 'tiempo_otras_actividades',
                        'label' => 'LBL_TIEMPO_OTRAS_ACTIVIDADES',
                        'css_class' => 'tiempo',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Tiempo ocupado para cualquier otra actividad:
* Tiempo ocupado en reuniones con el equipo.
* Tiempo invertido en capacitaciones.
* Tiempo invertido en hacer investigacion de prospectos.
* Tiempo invertido en buscar nuevos prospectos.
* Y cualquier otra actividad.',
                    ),

                    array(
                        'name' => 'porcentaje_otras_actividades',
                        'label' => 'LBL_PORCENTAJE_OTRAS_ACTIVIDADES',
                        'dismiss_label' => true,
                        'css_class' => 'porcentaje',
                        'type' => 'decimal',
                        'view' => 'edit',
                        'tool_tip' => 'Porcentaje de tiempo dedicado a otras actividades.',
                    ),
                ),
            ),
        ),
    ),
);