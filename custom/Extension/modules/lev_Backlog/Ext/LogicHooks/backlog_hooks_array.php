<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/8/2016
 * Time: 10:42 AM
 */

$hook_array['before_save'][] = Array(
    1,
    'format the name',
    'custom/modules/lev_Backlog/backlog_hooks.php',
    'backlog_hooks',
    'setFormatName'
);

$hook_array['before_save'][] = Array(
    2,
    'add username and date to description field',
    'custom/modules/lev_Backlog/backlog_hooks.php',
    'backlog_hooks',
    'setComentarios'    
);

$hook_array['before_save'][] = Array(
    3,
    'add username and date to description field',
    'custom/modules/lev_Backlog/backlog_hooks.php',
    'backlog_hooks',
    'setMontosMultiEtapa'
);

$hook_array['before_save'][] = Array(
    5,
    'update fields old',
    'custom/modules/lev_Backlog/update_fields_hooks.php',
    'update_fields_hooks',
    'actualizaCamposBacklog'
);