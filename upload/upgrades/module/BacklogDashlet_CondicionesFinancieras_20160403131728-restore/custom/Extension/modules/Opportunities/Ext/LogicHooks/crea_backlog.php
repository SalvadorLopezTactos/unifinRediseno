<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/1/2016
 * Time: 10:13 AM
 */

$hook_array['after_save'][] = Array(
    6,
    'crea Backlog',
    'custom/modules/Opportunities/opp_logic_hooks.php',
    'OpportunityLogic',
    'creaBacklog'
);