<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 6/02/20
 * Time: 11:24 AM
 */

    foreach ($viewdefs['Leads']['base']['menu']['header'] as $key => $moduleAction) {
        //remove the link by label key
        if (in_array($moduleAction['label'], array('LNK_IMPORT_VCARD'))) {
            unset($viewdefs['Leads']['base']['menu']['header'][$key]);
        }
    }
