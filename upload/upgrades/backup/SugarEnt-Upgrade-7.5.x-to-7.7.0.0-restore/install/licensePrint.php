<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
/*********************************************************************************

 * Description:  printable license page.
 ********************************************************************************/

clean_incoming_data();

require_once("install/language/{$_GET['language']}.lang.php");
require_once("install/install_utils.php");

$license_file = getLicenseContents("LICENSE");
$langHeader = get_language_header();
$out =<<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">   
   <title>{$mod_strings['LBL_LICENSE_TITLE_2']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css">   
</head>

<body>
  <table cellspacing="0" cellpadding="0" border="0" align="center" class="shell" width="90%">
    <tr>
      <td colspan='3' align="right">
        <input type="button" name="print_license" value=" {$mod_strings['LBL_PRINT']} " onClick='window.print();' />
        <input type="button" name="close_windows" value=" {$mod_strings['LBL_CLOSE']} " onClick='window.close();' />
      </td>
    </tr>
    <tr>
      <td width="2%">&nbsp;</td>
      <td>
        <pre>
            {$license_file}
        </pre>
      </td>
      <td width="2%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan='3' align="right">
        <input type="button" name="print_license" value=" {$mod_strings['LBL_PRINT']} " onClick='window.print();' />
        <input type="button" name="close_windows" value=" {$mod_strings['LBL_CLOSE']} " onClick='window.close();' />
      </td>
    </tr>
  </table>
</body>
</html>
EOQ;
echo $out;
?>