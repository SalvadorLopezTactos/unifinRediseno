<?php
/*
 * author: Tactos
 * Date: 19/04/2022
 * LH que conecta Sugar con QuestionPro para Encuestas
 */
$hook_array['before_save'][] = Array(
    1,
    'Conecta con QuestionPro',
    'custom/modules/QPRO_Gestion_Encuestas/gestion_encuestas.php',
    'gestion_encuestas',
    'gestion_encuestas'
);