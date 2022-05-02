<?php
/*
 * author: Tactos
 * Date: 26/04/2022
 * LH para envío de Encuestas a QuestionPro
 */
$hook_array['before_save'][] = Array(
    1,
    'Envía Encueta a QuestionPro',
    'custom/modules/QPRO_Encuestas/encuestas.php',
    'encuestas',
    'encuestas'
);