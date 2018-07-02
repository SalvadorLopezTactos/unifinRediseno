<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

function loadParentView($type)
{
    SugarAutoLoader::requireWithCustom('include/MVC/View/views/view.'.$type.'.php');
}


function getPrintLink()
{
//    if (isset($_REQUEST['action']) && $_REQUEST['action'] == "ajaxui")
//    {
//        return "javascript:SUGAR.ajaxUI.print();";
//    }
    return "javascript:void window.open('index.php?{$GLOBALS['request_string']}',"
         . "'printwin','menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1')";
}

/**
 * @deprecated since 7.0
 * @return the $url given
 */
function ajaxLink($url)
{
    return $url;
    /*
    global $sugar_config;
    $match = array();
    $javascriptMatch = array();

    preg_match('/module=([^&]*)/i', $url, $match);
    preg_match('/^javascript/i', $url, $javascriptMatch);

    if(!empty($sugar_config['disableAjaxUI'])){
        return $url;
    }
    else if(isset($match[1]) && in_array($match[1], ajaxBannedModules())){
        return $url;
    }
    //Don't modify javascript calls.
    else if (isset($javascriptMatch[0])) {
    	return $url;
    }
    else
    {
        return "?action=ajaxui#ajaxUILoc=" . urlencode($url);
    }
    */
}

?>
