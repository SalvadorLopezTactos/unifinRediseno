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
 
// $Id: tabs.php 42346 2008-12-04 16:09:08Z jmertic $



class SugarWidgetTabs extends SugarWidget
{
 var $tabs;
 var $current_key;

 function SugarWidgetTabs(&$tabs,$current_key,$jscallback)
 {
   $this->tabs = $tabs;
   $this->current_key = $current_key;
   $this->jscallback = $jscallback;
 }

 function display()
 {
	ob_start();
?>
<script>
var keys = [ <?php 
$tabs_count = count($this->tabs);
for($i=0; $i < $tabs_count;$i++) 
{
 $tab = $this->tabs[$i];
 echo "\"".$tab['key']."\""; 
 if ($tabs_count > ($i + 1))
 {
   echo ",";
 }
}
?>]; 
tabPreviousKey = '';

function selectTabCSS(key)
{


  for( var i=0; i<keys.length;i++)
  {
   var liclass = '';
   var linkclass = '';

 if ( key == keys[i])
 {
   var liclass = 'active';
   var linkclass = 'current';
 }
  	document.getElementById('tab_li_'+keys[i]).className = liclass;

  	document.getElementById('tab_link_'+keys[i]).className = linkclass;
  }
    <?php echo $this->jscallback;?>(key, tabPreviousKey);
    tabPreviousKey = key;
}
</script>

<ul id="searchTabs" class="tablist">
<?php 
	foreach ($this->tabs as $tab)
	{
		$TITLE = $tab['title'];
		$LI_ID = "";
		$A_ID = "";

	  if ( ! empty($tab['hidden']) && $tab['hidden'] == true)
		{
			  $LI_ID = "style=\"display: none\"";
			  $A_ID = "style=\"display: none\"";

		} else if ( $this->current_key == $tab['key'])
		{
			  $LI_ID = "class=\"active\"";
			  $A_ID = "class=\"current\"";
		}

		$LINK = "<li $LI_ID id=\"tab_li_".$tab['link']."\"><a $A_ID id=\"tab_link_".$tab['link']."\" href=\"javascript:selectTabCSS('{$tab['link']}');\">$TITLE</a></li>";

?>
<?php echo $LINK; ?>	
<?php
	}
?>
</ul>
<?php 
	$ob_contents = ob_get_contents();
        ob_end_clean();
        return $ob_contents;
	}
}
?>
