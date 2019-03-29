<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 27/03/19
 * Time: 09:33 AM
 */


$hook_array['after_save'][] = Array(
    14,
    'Guarda datos en el modulo tct3_noviable',
    'custom/modules/Accounts/lh_noviables.php',
    'LeadNV_hook',
    'saveleadnv'
);