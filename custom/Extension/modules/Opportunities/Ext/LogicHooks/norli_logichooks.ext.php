<?php 
// Disabling setSalesStatus LogicHooks
// 
// Tue Oct  7 17:18:40 2014
// by ttuemer@sugarcrm.com
if(isset($hook_array['before_save'])){
	foreach ($hook_array['before_save'] as $key => $hook) {
		if(in_array("setSalesStatus", $hook))
			unset($hook_array['before_save'][$key]);
	}
}
?>