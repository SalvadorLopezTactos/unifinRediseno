<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/30/2016
 * Time: 11:53 AM
 */
$hook_array['after_save'][] = Array(
    8,
    'crea Condicion Financiera para incremento/ratificacion',
    'custom/modules/Opportunities/opp_logic_hooks.php',
    'OpportunityLogic',
    'condiciones_financieras_incremento_ratificacion'
);