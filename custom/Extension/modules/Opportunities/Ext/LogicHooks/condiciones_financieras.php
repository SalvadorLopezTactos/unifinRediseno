<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/12/2016
 * Time: 11:27 PM
 */
$hook_array['after_save'][] = Array(
    7,
    'crea Condicion Financiera',
    'custom/modules/Opportunities/opp_logic_hooks.php',
    'OpportunityLogic',
    'condiciones_financieras'
);